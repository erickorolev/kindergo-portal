<?php

namespace Parents\Commands;

use Illuminate\Support\Facades\File;
use Parents\Foundation\Facades\Portal;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class ListTasksCommand
 * @package Parents\Commands
 */
class ListTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "portal:list:tasks {--withfilename}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "List all Tasks in the Application.";

    /**
     * ListActionsCommand constructor.
     *
     * @param ConsoleOutput $console
     * @psalm-suppress UndefinedThisPropertyAssignment
     */
    public function __construct(ConsoleOutput $console)
    {
        parent::__construct();

        $this->console = $console;
    }

    /**
     * Handle the command
     */
    public function handle(): void
    {
        /** @var string $containerName */
        foreach (Portal::getContainersNames() as $containerName) {
            /** @psalm-var ConsoleOutput $this->console */
            $this->console->writeln("<fg=yellow> [$containerName]</fg=yellow>");

            $directory = base_path('app/Containers/' . $containerName . '/Tasks');

            if (File::isDirectory($directory)) {
                $files = File::allFiles($directory);

                foreach ($files as $action) {
                    // get the file name as is
                    $fileName = $originalFileName = $action->getFilename();

                    // remove the Task.php postfix from each file name
                    $fileName = str_replace('Task.php', '', $fileName);

                    // further, remove the `.php', if the file does not end on 'Task.php'
                    $fileName = str_replace('.php', '', $fileName);

                    // uncamelize the word and replace it with spaces
                    /** @var string $fileName */
                    $fileName = Portal::uncamelize($fileName);

                    // check if flag exist
                    $includeFileName = '';
                    if ($this->option('withfilename')) {
                        $includeFileName = "<fg=red>($originalFileName)</fg=red>";
                    }

                    $this->console->writeln("<fg=green>  - $fileName</fg=green>  $includeFileName");
                }
            }
        }
    }
}
