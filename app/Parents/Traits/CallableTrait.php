<?php

declare(strict_types=1);

namespace Parents\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Parents\DataTransferObjects\ObjectData;
use Parents\Foundation\Facades\Portal;
use Parents\Requests\Request;
use phpDocumentor\Reflection\Types\ClassString;

trait CallableTrait
{
    /**
     * This function will be called from anywhere (controllers, Actions,..) by the Realty facade.
     * The $class input will usually be an Action or Task.
     *
     * @param string $classStart
     * @param array $runMethodArguments
     * @param array $extraMethodsToCall
     *
     * @return  mixed
     * @psalm-suppress MixedMethodCall
     */
    public function call(string $classStart, array $runMethodArguments = [], array $extraMethodsToCall = []): mixed
    {
        /** @var object $class */
        $class = $this->resolveClass($classStart);

        $this->setUIIfExist($class);

        $this->callExtraMethods($class, $extraMethodsToCall);

        // detects Requests arguments "usually sent by controllers", and cvoert them to Transporters.
        $runMethodArguments = $this->convertRequestsToTransporters($class, $runMethodArguments);

        return $class->run(...$runMethodArguments);
    }

    /**
     * This function calls another class but wraps it in a DB-Transaction.
     * This might be useful for CREATE / UPDATE / DELETE
     * operations in order to prevent the database from corrupt data. Internally, the regular call() method is used!
     *
     * @param string $class
     * @param array $runMethodArguments
     * @param array $extraMethodsToCall
     *
     * @return mixed
     */
    public function transactionalCall(
        string $class,
        array $runMethodArguments = [],
        array $extraMethodsToCall = []
    ): mixed {
        return DB::transaction(function () use ($class, $runMethodArguments, $extraMethodsToCall): mixed {
            return $this->call($class, $runMethodArguments, $extraMethodsToCall);
        });
    }

    /**
     * Get instance from a class string
     *
     * @param string $class
     *
     * @return  mixed
     * @psalm-suppress MixedAssignment
     */
    private function resolveClass(string $class): mixed
    {
        // in case passing portal style names such as containerName@classType
        if ($this->needsParsing($class)) {
            $parsedClass = $this->parseClassName($class);
            /** @var string $parsedClassName */
            $parsedClassName = $parsedClass[0];
            /** @var string $containerName */
            $containerName = $this->capitalizeFirstLetter($parsedClassName);
            /** @var string $className */
            $className = $parsedClass[1];

            Portal::verifyContainerExist($containerName);
            /** @var string $classFullName */
            /** @var string $class */
            $class = $classFullName = Portal::buildClassFullName($containerName, $className);
            Portal::verifyClassExist($classFullName);
        } else {
            if (Config::get('portal.logging.log-wrong-apiato-caller-style', true)) {
                Log::debug('It is recommended to use the portal caller style (containerName@className) for ' . $class);
            }
        }

        return App::make($class);
    }

    /**
     * Split containerName@someClass into container name and class name
     *
     * @param string $class
     * @param string $delimiter
     *
     * @return  array
     */
    private function parseClassName(string $class, string $delimiter = '@'): array
    {
        return explode($delimiter, $class);
    }

    /**
     * If it's our Style caller like this: containerName@someClass
     *
     * @param string $class
     * @param string $separator
     *
     * @return  bool
     */
    private function needsParsing(string $class, $separator = '@'): bool
    {
        return (bool) preg_match('/' . $separator . '/', $class);
    }

    /**
     * @param $string
     *
     * @return  string
     */
    private function capitalizeFirstLetter(string $string): string
    {
        return ucfirst($string);
    }

    /**
     *
     * $this->ui is coming, should be attached on the parent controller, from where the actions was called.
     * It can be WebController and ApiController. Each of them has ui, to inform the action
     * if it needs to handle the request differently.
     *
     * @param ClassString|object $class
     * @psalm-suppress UndefinedThisPropertyFetch
     */
    private function setUIIfExist(string | object $class): bool
    {
        if (method_exists($class, 'setUI') && property_exists($this, 'ui')) {
            $class->setUI($this->ui);
            return true;
        }

        return false;
    }

    /**
     * @param object $class
     * @param array $extraMethodsToCall
     */
    private function callExtraMethods(object $class, array $extraMethodsToCall): void
    {
        // allows calling other methods in the class before calling the main `run` function.
        /** @var string|array $methodInfo */
        foreach ($extraMethodsToCall as $methodInfo) {
            // if is array means it method has arguments
            if (is_array($methodInfo)) {
                $this->callWithArguments($class, $methodInfo);
            } else {
                // if is string means it's just the method name without arguments
                $this->callWithoutArguments($class, $methodInfo);
            }
        }
    }

    /**
     * @param ClassString|object $class
     * @param array $methodInfo
     */
    private function callWithArguments(mixed $class, array $methodInfo): void
    {
        /** @var string $method */
        $method = key($methodInfo);
        /** @var array $arguments */
        $arguments = $methodInfo[$method];
        if (method_exists($class, $method)) {
            $class->$method(...$arguments);
        }
    }

    /**
     * @param ClassString|object $class
     * @param string $methodInfo
     */
    private function callWithoutArguments(string | object $class, string $methodInfo): void
    {
        if (method_exists($class, $methodInfo)) {
            $class->$methodInfo();
        }
    }

    /**
     * For backward compatibility purposes only. Could be a temporal function.
     * In case a user passed a Request object to an Action that accepts a Transporter, this function
     * converts that Request to Transporter object.
     *
     * @param ClassString|object $class
     * @param array $runMethodArguments
     *
     * @return  array
     * @psalm-suppress InvalidStringClass
     */
    private function convertRequestsToTransporters(string | object $class, array $runMethodArguments = []): array
    {
        $requestPositions = [];

        // we first check, if one of the params is a REQUEST type
        /**
         * @var int $argumentPosition
         * @var object $argumentValue
         */
        foreach ($runMethodArguments as $argumentPosition => $argumentValue) {
            if ($argumentValue instanceof Request) {
                $requestPositions[] = $argumentPosition;
            }
        }

        // now check, if we have found any REQUEST params
        if (empty($requestPositions)) {
            // We have not found any REQUEST params, so we don't need to transform anything.
            // Just return the runArguments and we are ready...
            return $runMethodArguments;
        }

        // ok.. now we need to get the method signature from the run() method to be called on the $class
        // and check, if on the positions we found REQUESTs are DTOs defined!
        // this is a bit more tricky than the stuff above - but we will manage this

        // get a reflector for the run() method
        $reflector = new \ReflectionMethod($class, 'run');
        $calleeParameters = $reflector->getParameters();

        // now specifically check only the positions we have found a REQUEST in the call() method
        /** @var int $requestPosition */
        foreach ($requestPositions as $requestPosition) {
            $parameter = $calleeParameters[$requestPosition];
            $parameterClass = $parameter->getClass();

            // check if the parameter has a class and this class actually does exist!
            if (!(($parameterClass != null) && (class_exists($parameterClass->name)))) {
                // no, some tests failed - we cannot convert - skip this entry
                continue;
            }

            // and now, we finally need to check, if the class of this param is a subclass of TRANSPORTER
            // Note that we cannot use instanceof here, but rather need to rely on is_subclass_of instead
            $parameterClassName = $parameterClass->name;
            if (! is_subclass_of($parameterClassName, ObjectData::class)) {
                // the class is NOT a subclass of TRANSPORTER
                continue;
            }

            // so everything is ok
            // now we need to "switch" the REQUEST with the TRANSPORTER
            /** @var Request $request */
            $request = $runMethodArguments[$requestPosition];
            $transporterClass = $request->getDto();
            // instantiate transporter and hydrate it with request
            /** @var ObjectData $transporter */
            $transporter = new $transporterClass($request->all());

            // and now "replace" the request with this transporter
            $runMethodArguments[$requestPosition] = $transporter;
        }

        return $runMethodArguments;
    }
}
