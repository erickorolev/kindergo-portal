<?php

namespace Parents\Commands;

use Parents\Foundation\Portal;

/**
 * Class GetPortalVersionCommand
 * @package Parents\Commands
 */
class GetPortalVersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "portal";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Display the current Portal version.";

    /**
     * GetPortalVersionCommand constructor.
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
        $this->info(Portal::VERSION);
    }
}
