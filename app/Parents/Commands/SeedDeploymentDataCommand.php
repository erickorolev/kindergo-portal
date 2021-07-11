<?php

namespace Parents\Commands;

use Parents\Seeders\SeedDeploymentData;

/**
 * Class SeedDeploymentDataCommand
 * @package Parents\Commands
 */
class SeedDeploymentDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "portal:seed-deploy";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Seed data for initial deployment.";

    /**
     * SeedTestingDataCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Handle the command
     */
    public function handle(): void
    {
        $this->call('db:seed', [
            '--class' => SeedDeploymentData::class
        ]);

        $this->info('Deployment Data Seeded Successfully.');
    }
}
