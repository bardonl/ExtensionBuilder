<?php
namespace ExtensionBuilder\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem;

/**
 * extension
 *
 * @package ExtensionBuilder\Console\Commands
 */
class Controller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:controller {controller*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to build the controller(s)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
    }
}
