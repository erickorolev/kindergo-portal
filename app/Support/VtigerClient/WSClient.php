<?php

namespace Support\VtigerClient;

/**
 * Vtiger Web Services PHP Client
 *
 * Class WSClient
 * @package Support\VtigerClient
 */
final class WSClient
{
    private Session|null $session = null;

    public Modules|null $modules = null;
    public Entities|null $entities = null;

    public const USE_ACCESSKEY = 1;
    public const USE_PASSWORD = 2;

    /**
     * Class constructor
     * @param  string  $vtigerUrl  The URL of the remote WebServices server
     * @param  string  $username  User name
     * @param  string  $secret  Access key token (shown on user's profile page) or password, depends on $loginMode
     * @param  integer [$loginMode = self::USE_ACCESSKEY|USE_PASSWORD]  Login mode, defaults to username + accessKey
     * @param string [$wsBaseURL = 'webservice.php']  WebServices base URL appended to vTiger root URL
     * @param int Optional request timeout in seconds
     */
    public function __construct(
        string $vtigerUrl,
        string $username,
        string $secret,
        int $loginMode = self::USE_ACCESSKEY,
        string $wsBaseURL = 'webservice.php',
        int $requestTimeout = 0
    ) {
        $this->modules = new Modules($this);
        $this->entities = new Entities($this);
        $this->session = new Session($vtigerUrl, $wsBaseURL, $requestTimeout);

        $loginOK = false;

        switch ($loginMode) {
            case self::USE_ACCESSKEY:
                $loginOK = $this->session->login($username, $secret);
                break;

            case self::USE_PASSWORD:
                $loginOK = $this->session->loginPassword($username, $secret);
                break;

            default:
                throw new WSException(sprintf('Unknown login mode: %s', $loginMode));
        }

        if (!$loginOK) {
            throw new WSException(sprintf(
                'Failed to log into vTiger CRM (User: %s, URL: %s)',
                $username,
                $vtigerUrl
            ));
        }
    }

    /**
     * Invokes custom operation (defined in vtiger_ws_operation table)
     * @access public
     * @param  string  $operation  Name of the webservice to invoke
     * @param  array   [$params = null] Parameter values to operation
     * @param  string  [$method = 'POST'] HTTP request method (GET, POST etc)
     * @return ?array Result object
     */
    public function invokeOperation(
        string $operation,
        array $params = null,
        string $method = 'POST'
    ): ?array {
        if (is_array($params) && !empty($params) && !is_assoc_array($params)) {
            throw new WSException(
                "You have to specified a list of operation parameters, but apparently
                it's not an associative array ('prop' => value)!"
            );
        }

        $params[ 'operation' ] = $operation;
        return $this->session?->sendHttpRequest($params, $method);
    }

    /**
     * VTiger provides a simple query language for fetching data.
     * This language is quite similar to select queries in SQL.
     * There are limitations, the queries work on a single Module,
     * embedded queries are not supported, and does not support joins.
     * But this is still a powerful way of getting data from Vtiger.
     * Query always limits its output to 100 records,
     * Client application can use limit operator to get different records.
     * @access public
     * @param  string $query SQL-like expression
     * @return ?array  Query results
     */
    public function runQuery(string $query): ?array
    {
        // Make sure the query ends with ;
        $query = (strripos($query, ';') != strlen($query) - 1)
            ? trim($query .= ';')
            : trim($query);

        return $this->invokeOperation('query', [ 'query' => $query ], 'GET');
    }

    /**
     * Gets an array containing the basic information about current API user
     * @access public
     * @return ?array Basic information about current API user
     */
    public function getCurrentUser(): ?array
    {
        return $this->session?->getUserInfo();
    }

    /**
     * Gets an array containing the basic information about the connected vTiger instance
     * @access public
     * @return array Basic information about the connected vTiger instance
     */
    public function getVtigerInfo(): array
    {
        return [
            'vtiger' => $this->session?->getVtigerVersion(),
            'api' => $this->session?->getVtigerApiVersion(),
        ];
    }

    public static function getCleanInstance(): self
    {
        /** @var string $url */
        $url = config('services.vtiger.url');
        /** @var string $login */
        $login = config('services.vtiger.login');
        /** @var string $key */
        $key = config('services.vtiger.key');
        return new self($url, $login, $key, self::USE_ACCESSKEY);
    }
}

if (!function_exists('is_assoc_array')) {

    /**
     * Checks if an array is associative or not
     * @param  string  Array to test
     * @return boolean Returns true in a given array is associative and false if it's not
     */
    function is_assoc_array(array|string $array): bool
    {
        if (empty($array) || !is_array($array)) {
            return false;
        }

        foreach (array_keys($array) as $key) {
            if (!is_int($key)) {
                return true;
            }
        }
        return false;
    }
}
