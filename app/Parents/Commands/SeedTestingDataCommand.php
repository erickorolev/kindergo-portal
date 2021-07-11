<?php

namespace Parents\Commands;

use Parents\Seeders\SeedTestingData;

/**
 * Class SeedTestingDataCommand
 * @package Parents\Commands
 */
class SeedTestingDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "portal:seed-test";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Seed testing data.";

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
            '--class' => SeedTestingData::class
        ]);

        $this->info('Testing Data Seeded Successfully.');
    }
}
