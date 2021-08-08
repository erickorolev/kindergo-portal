<?php

declare(strict_types=1);

namespace Support\VtigerClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Parents\Exceptions\codes\ApplicationErrorCodesTable;

/**
* Vtiger Web Services PHP Client Session class
*
* Class Session
* @package Support\VtigerClient
* @internal
*/
class Session
{
    // HTTP Client instance
    protected Client $httpClient;

    // request timeout in seconds
    protected int $requestTimeout;

    // Service URL to which client connects to
    protected string|null $vtigerUrl = null;
    protected string|null $wsBaseURL = null;

    // Vtiger CRM and WebServices API version
    private string $vtigerApiVersion = '0.0';
    private string $vtigerVersion = '0.0';

    // Webservice login validity
    private int|string|null $serviceExpireTime = null;
    private string|null $serviceToken = null;

    // Webservice user credentials
    private string|null $userName = null;
    private int|string|null $accessKey = null;

    // Webservice login credentials
    private string|null $userID = null;
    private string|null $sessionName = null;

    /**
     * Class constructor
     * @param string $vtigerUrl  The URL of the remote WebServices server
     * @param string [$wsBaseURL = 'webservice.php']  WebServices base URL appended to vTiger root URL
     * @param int $requestTimeout Number of seconds after which request times out
     */
    public function __construct(
        string $vtigerUrl,
        string $wsBaseURL = 'webservice.php',
        int $requestTimeout = 0
    ) {
        $this->vtigerUrl = self::fixVtigerBaseUrl($vtigerUrl);
        $this->wsBaseURL = $wsBaseURL;
        $this->requestTimeout = $requestTimeout;

        // Gets target URL for WebServices API requests
        $this->httpClient = new Client([
            'base_uri' => $this->vtigerUrl
        ]);
    }

    /**
     * Login to the server using username and VTiger access key token
     * @access public
     * @param  string $username VTiger user name
     * @param  string $accessKey VTiger access key token (visible on user profile/settings page)
     * @return boolean Returns true if login operation has been successful
     */
    public function login(string $username, string $accessKey): bool
    {
        // Do the challenge before loggin in
        if ($this->passChallenge($username) === false) {
            return false;
        }

        $postdata = [
            'operation' => 'login',
            'username'  => $username,
            'accessKey' => md5($this->serviceToken . $accessKey)
        ];

        $result = $this->sendHttpRequest($postdata);
        if (!is_array($result) || empty($result)) {
            return false;
        }

        // Backuping logged in user credentials
        $this->userName = $username;
        $this->accessKey = $accessKey;

        // Session data
        $this->sessionName = $result[ 'sessionName' ];
        $this->userID = $result[ 'userId' ];

        // Vtiger CRM and WebServices API version
        $this->vtigerApiVersion = $result[ 'version' ];
        $this->vtigerVersion = $result[ 'vtigerVersion' ];

        return true;
    }

    /**
     * Allows you to login using username and password instead of access key (works on some VTige forks)
     * @access public
     * @param  string  $username VTiger user name
     * @param  string  $password VTiger password (used to access CRM using the standard login page)
     * @param  string|null  $accessKey This parameter will be filled with user's VTiger access key
     * @return boolean  Returns true if login operation has been successful
     */
    public function loginPassword(string $username, string $password, ?string &$accessKey = null): bool
    {
        // Do the challenge before loggin in
        if ($this->passChallenge($username) === false) {
            return false;
        }

        $postdata = [
            'operation' => 'login_pwd',
            'username' => $username,
            'password' => $password
        ];

        $result = $this->sendHttpRequest($postdata);
        if (!is_array($result) || empty($result)) {
            return false;
        }

        $this->accessKey = array_key_exists('accesskey', $result)
            ? $result[ 'accesskey' ]
            : $result[ 0 ];

        return $this->login($username, $accessKey ?? '');
    }

    /**
     * Gets a challenge token from the server and stores for future requests
     * @access private
     * @param  string  $username VTiger user name
     * @return boolean Returns false in case of failure
     */
    private function passChallenge(string $username): bool
    {
        $getdata = [
            'operation' => 'getchallenge',
            'username'  => $username
        ];
        $result = $this->sendHttpRequest($getdata, 'GET');

        if (!is_array($result) || !isset($result[ 'token' ])) {
            return false;
        }

        $this->serviceExpireTime = $result[ 'expireTime' ];
        $this->serviceToken = $result[ 'token' ];

        return true;
    }

    /**
     * Gets an array containing the basic information about current API user
     * @access public
     * @return array Basic information about current API user
     */
    public function getUserInfo(): array
    {
        return [
            'id' => $this->userID,
            'userName' => $this->userName,
            'accessKey' => $this->accessKey,
        ];
    }

    /**
     * Gets vTiger version, retrieved on successful login
     * @access public
     * @return string vTiger version, retrieved on successful login
     */
    public function getVtigerVersion(): string
    {
        return $this->vtigerVersion;
    }

    /**
     * Gets vTiger WebServices API version, retrieved on successful login
     * @access public
     * @return string vTiger WebServices API version, retrieved on successful login
     */
    public function getVtigerApiVersion(): string
    {
        return $this->vtigerApiVersion;
    }

    /**
     * Sends HTTP request to VTiger web service API endpoint
     * @access private
     * @param  array $requestData HTTP request data
     * @param  string $method HTTP request method (GET, POST etc)
     * @return ?array Returns request result object (null in case of failure)
     * @psalm-suppress DeprecatedMethod
     */
    public function sendHttpRequest(array $requestData, string $method = 'POST'): ?array
    {
        // Perform re-login if required.
        if ('getchallenge' !== $requestData[ 'operation' ] && time() > $this->serviceExpireTime) {
            $this->login($this->userName ?? '', (string) $this->accessKey);
        }

        /** @var string $configUrl */
        $configUrl = config('services.vtiger.url');

        $requestData[ 'sessionName' ] = $this->sessionName;

        try {
            switch ($method) {
                case 'GET':
                    $response = $this->httpClient->get(
                        $this->wsBaseURL ?? $configUrl,
                        [ 'query' => $requestData, 'timeout' => $this->requestTimeout ]
                    );
                    break;
                case 'POST':
                    $response = $this->httpClient->post(
                        $this->wsBaseURL ?? $configUrl,
                        [ 'form_params' => $requestData, 'timeout' => $this->requestTimeout ]
                    );
                    break;
                default:
                    throw new WSException("Unsupported request type {$method}");
            }
        } catch (RequestException $ex) {
            $urlFailed = $this->httpClient->getConfig('base_uri') . $this->wsBaseURL;
            Log::error('Error in Vtiger Connection by URL ' . $urlFailed . ': ' . $ex->getMessage());
            throw new WSException(
                sprintf('Failed to execute %s call on "%s" URL', $method, $urlFailed),
                ApplicationErrorCodesTable::REQUEST_GENERAL_ERROR['code'],
                $ex
            );
        }

        $jsonRaw = $response->getBody()->getContents();
        $jsonObj = json_decode($jsonRaw, true);

        $result = (is_array($jsonObj) && !self::checkForError($jsonObj))
            ? $jsonObj[ 'result' ]
            : null;
        return $result;
    }

    /**
     *  Cleans and fixes vTiger URL
     * @access private
     * @static
     * @param  string $baseUrl  Base URL of vTiger CRM
     * @return string Returns cleaned and fixed vTiger URL
     */
    private static function fixVtigerBaseUrl(string $baseUrl): string
    {
        if (!preg_match('/^https?:\/\//i', $baseUrl)) {
            $baseUrl = sprintf('http://%s', $baseUrl);
        }
        if (strripos($baseUrl, '/') !== strlen($baseUrl) - 1) {
            $baseUrl .= '/';
        }
        return $baseUrl;
    }

    /**
     * Check if server response contains an error, therefore the requested operation has failed
     * @access private
     * @static
     * @param  array $jsonResult Server response object to check for errors
     * @return boolean  True if response object contains an error
     */
    private static function checkForError(array $jsonResult): bool
    {
        if (isset($jsonResult[ 'success' ]) && true === (bool) $jsonResult[ 'success' ]) {
            return false;
        }

        if (isset($jsonResult[ 'error' ])) {
            $error = $jsonResult[ 'error' ];
            throw new WSException(
                $error[ 'message' ],
                (int) $error[ 'code' ]
            );
        }

        // This should never happen
        throw new WSException('Unknown error');
    }
}
