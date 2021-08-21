<?php

declare(strict_types=1);

namespace Parents\Services;

use Illuminate\Support\Collection;
use Support\VtigerClient\WSClient;

abstract class ConnectorService
{
    protected WSClient $client;

    public function __construct()
    {
        $this->client = WSClient::getCleanInstance();
    }

    public function receiveById(string $module, int $crmid): Collection
    {
        if (!$this->client->entities) {
            return collect([]);
        }
        $result = $this->client->entities->findOneByID($module, (string) $crmid);
        return collect($result);
    }
}
