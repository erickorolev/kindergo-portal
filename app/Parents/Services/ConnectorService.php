<?php

declare(strict_types=1);

namespace Parents\Services;

use Support\VtigerClient\WSClient;

abstract class ConnectorService
{
    protected WSClient $client;

    public function __construct()
    {
        $this->client = WSClient::getCleanInstance();
    }
}
