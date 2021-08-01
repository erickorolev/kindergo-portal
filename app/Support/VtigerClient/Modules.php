<?php

declare(strict_types=1);

namespace Support\VtigerClient;

/**
* Vtiger Web Services PHP Client Session class
*
* Class Modules
* @package Support\VtigerClient
*/
class Modules
{
    private WSClient $wsClient;

    public function __construct(WSClient $wsClient)
    {
        $this->wsClient = $wsClient;
    }

    /**
     * Lists all the Vtiger entity types available through the API
     * @access public
     * @return array List of entity types
     */
    public function getAll(): array
    {
        $result = $this->wsClient->invokeOperation('listtypes', [ ], 'GET');
        if (!$result) {
            return [];
        }
        /** @var array $modules */
        $modules = $result[ 'types' ];

        $result = array();
        foreach ($modules as $moduleName) {
            $result[ $moduleName ] = [ 'name' => $moduleName ];
        }
        return $result;
    }

    /**
     * Get the type information about a given VTiger entity type.
     * @access public
     * @param  string  $moduleName Name of the module / entity type
     * @return ?array  Result object
     */
    public function getOne(string $moduleName): ?array
    {
        return $this->wsClient->invokeOperation('describe', [ 'elementType' => $moduleName ], 'GET');
    }

    /**
     * Gets the entity ID prepended with module / entity type ID
     * @access private
     * @param  string  $moduleName   Name of the module / entity type
     * @param  string  $entityID     Numeric entity ID
     * @return boolean|string Returns false if it is not possible to retrieve module / entity type ID
     */
    public function getTypedID(string $moduleName, string $entityID): bool|string
    {
        if (stripos($entityID, 'x') !== false) {
            return $entityID;
        }

        if (empty($entityID) || intval($entityID) < 1) {
            throw new WSException('Entity ID must be a valid number');
        }

        $type = $this->getOne($moduleName);
        if (!is_array($type) || !array_key_exists('idPrefix', $type)) {
            $errorMessage = sprintf("The following module is not installed: %s", $moduleName);
            throw new WSException($errorMessage);
        }

        return "{$type[ 'idPrefix' ]}x{$entityID}";
    }
}
