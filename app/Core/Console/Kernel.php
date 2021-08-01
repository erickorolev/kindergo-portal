<?php

namespace App\Console;

use Domains\Payments\Console\Commands\GetPaymentsFromVtigerCommand;
use Domains\Trips\Console\Commands\GetTripsFromVtigerCommand;
use Domains\Users\Console\Commands\GetUsersFromVtigerCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Parents\Commands\GetPortalVersionCommand;
use Parents\Commands\ListActionsCommand;
use Parents\Commands\ListTasksCommand;
use Parents\Commands\SeedDeploymentDataCommand;
use Parents\Commands\SeedTestingDataCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SeedDeploymentDataCommand::class,
        SeedTestingDataCommand::class,
        ListActionsCommand::class,
        ListTasksCommand::class,
        GetPortalVersionCommand::class,
        GetUsersFromVtigerCommand::class,
        GetTripsFromVtigerCommand::class,
        GetPaymentsFromVtigerCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
