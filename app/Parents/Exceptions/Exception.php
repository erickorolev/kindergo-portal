<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Parents\Exceptions\codes\ErrorCodeManager;
use Exception as BaseException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\MessageBag;
use Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Exception
 * @package Parents\Exceptions
 * @psalm-suppress PropertyNotSetInConstructor
 */
class Exception extends \Symfony\Component\HttpKernel\Exception\HttpException
{
    /**
     * MessageBag errors.
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Default status code.
     *
     * @var int
     */
    public const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    protected string $environment;

    /**
     * @var array
     */
    private array $customData = array();

    /**
     * Exception constructor.
     *
     * @param ?string            $message
     * @param ?array            $errors
     * @param ?int            $statusCode
     * @param ?int             $code
     * @param \Exception|null $previous
     * @param array           $headers
     */
    public function __construct(
        ?string $message = null,
        ?array $errors = null,
        ?int $statusCode = null,
        ?int $code = 0,
        BaseException $previous = null,
        array $headers = []
    ) {

        // detect and set the running environment
        /** @var string $env */
        $env = Config::get('app.env');
        $this->environment = $env;

        $message = $this->prepareMessage($message);
        $this->prepareError($errors);
        $statusCode = $this->prepareStatusCode($statusCode);

        $this->logTheError($statusCode, $message, $code);

        parent::__construct($statusCode, $message, $previous, $headers, $code);

        $this->addCustomData();

        $this->code = $this->evaluateErrorCode();
    }

    /**
     * Help developers debug the error without showing these details to the end user.
     * Usage: `throw (new MyCustomException())->debug($e)`.
     *
     * @param $error
     * @param $force
     *
     * @return self
     */
    public function debug(string | BaseException $error, bool $force = false): self
    {
        if ($error instanceof BaseException) {
            $error = $error->getMessage();
        }

        if ($this->environment != 'testing' || $force === true) {
            \Illuminate\Support\Facades\Log::error('[DEBUG] ' . $error);
        }

        return $this;
    }

    /**
     * Get the errors message bag.
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors(): MessageBag
    {
        return $this->errors;
    }

    /**
     * Determine if message bag has any errors.
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !$this->errors->isEmpty();
    }

    /**
     * @param int $statusCode
     * @param ?string $message
     * @param ?int $code
     */
    private function logTheError(int $statusCode, ?string $message, ?int $code): void
    {
        // if not testing environment, log the error message
        if ($this->environment != 'testing') {
            if ($message === null) {
                $message = '';
            }
            if ($code === null) {
                $code = '';
            }
            \Illuminate\Support\Facades\Log::error('[ERROR] ' .
                'Status Code: ' . $statusCode . ' | ' .
                'Message: ' . $message . ' | ' .
                'Errors: ' . $this->errors . ' | ' .
                'Code: ' . $code);
        }
    }

    /**
     * @param ?array $errors
     *
     * @return  \Illuminate\Support\MessageBag|null
     */
    private function prepareError(?array $errors = null): ?MessageBag
    {
        return is_null($errors) ? new MessageBag() : $this->prepareArrayError($errors);
    }

    /**
     * @param ?array $errors
     *
     * @return  MessageBag|null
     */
    private function prepareArrayError(?array $errors = []): ?MessageBag
    {
        return is_array($errors) ? new MessageBag($errors) : null;
    }

    /**
     * @param ?string $message
     *
     * @return  ?string
     */
    private function prepareMessage(?string $message = null): ?string
    {
        return is_null($message) && property_exists($this, 'message') ? $this->message : $message;
    }

    /**
     * @param $statusCode
     *
     * @return  int
     */
    private function prepareStatusCode(int $statusCode = null): int
    {
        return is_null($statusCode) ? $this->findStatusCode() : $statusCode;
    }

    /**
     * @psalm-suppress UndefinedThisPropertyFetch
     * @psalm-suppress MixedReturnStatement
     * @psalm-suppress MixedInferredReturnType
     */
    private function findStatusCode(): int
    {
        return property_exists($this, 'httpStatusCode') ? $this->httpStatusCode : self::DEFAULT_STATUS_CODE;
    }

    /**
     * @return ?array
     */
    public function getCustomData(): ?array
    {
        return $this->customData;
    }

    /**
     * @return void
     */
    protected function addCustomData(): void
    {
        $this->customData = array();
    }

    /**
     * Append customData to the exception and return the Exception!
     *
     * @param array $customData
     *
     * @return $this
     */
    public function overrideCustomData(array $customData): self
    {
        $this->customData = $customData;
        return $this;
    }

    /**
     * Default value
     *
     * @return int
     */
    public function useErrorCode(): int
    {
        return $this->code;
    }

    /**
     * Overrides the code with the application error code (if set)
     *
     * @return int
     */
    private function evaluateErrorCode(): int
    {
        return $this->useErrorCode();
    }
}
