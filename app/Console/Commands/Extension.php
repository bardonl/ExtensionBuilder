<?php
namespace ExtensionBuilder\Console\Commands;

use ExtensionBuilder\Console\Services\FileGenerator;
use Illuminate\Console\Command;
use Illuminate\Filesystem;

/**
 * extension
 *
 * @package ExtensionBuilder\Console\Commands
 */
class Extension extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:extension {extensionKey}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The user has the option to choose between a configuration template or an extension';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $extensionKey = strtolower($this->argument('extensionKey'));

        if (!$this->confirm('You named the extension: ' . $extensionKey . ' Is that correct?')) {

            $this->info("You can rerun the command by using");
            echo "\r\n";
            $this->info("php artisan build:extension example_extension");

            sleep(2);

            exit();
        }

        $config = $this->choice('Building a configuration template? [0/1]', ['Build a configuration template', 'Build a extension']);
        
        switch($config){
            case 0:
                $this->info("Building a configuration template");
                FileGenerator::createRootDirectory($config, $extensionKey);
                break;
            case 1:
                $this->info("Building a normal extension");
                FileGenerator::createRootDirectory($config, $extensionKey);
                break;
            default:
                $this->warn("Please select a valid value");
        }

        sleep(2);

    }

}
