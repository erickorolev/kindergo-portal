<?php

declare(strict_types=1);

namespace Support\VtigerClient;

use Exception;
use IteratorAggregate;

/**
* Vtiger Web Services PHP Client Exception class
*
* Class WSException
* @package Support\VtigerClient
*/
class WSException extends Exception implements IteratorAggregate
{
    protected $message;
    protected $code;

    /**
     * Redefine the exception so message isn't optional
     * @access public
     */
    public function __construct(string $message, int $code = 1050, Exception $previous = null)
    {
        $this->message = $message;
        $this->code = $code;

        // make sure everything is assigned properly
        parent::__construct($this->message, 0, $previous);
    }

    /**
     * Custom string representation of object
     * @access public
     * @return string A custom string representation of exception
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * Retrieve an external iterator
     * @access public
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return \Traversable An instance of an object implementing \Traversable
     */
    public function getIterator()
    {
        $properties = $this->getAllProperties();
        $iterator = new \ArrayIterator($properties);

        return $iterator;
    }

    /**
     * Gets all the properties of the object
     * @access public
     * @return array Array of properties
     * @psalm-suppress RedundantCondition
     */
    private function getAllProperties(): array
    {
        $allProperties = get_object_vars($this);
        $properties = array();
        foreach ($allProperties as $fullName => $value) {
            $fullNameComponents = explode("\0", $fullName);
            $propertyName = array_pop($fullNameComponents);
            if ($propertyName && isset($value)) {
                $properties[ $propertyName ] = $value;
            }
        }

        return $properties;
    }
}
