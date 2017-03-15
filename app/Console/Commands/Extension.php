<?php

namespace extension_builder\Console\Commands;

use extension_builder\Http\Controllers\FileGenerator;
use Illuminate\Console\Command;
use Illuminate\Filesystem;


/**
 * extension
 *
 * @package extension_builder\Console\Commands
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
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function failureMessage(){

        echo "Failed to create your extension!";
        echo "\r\n";
        echo "Please Rerun the command!";

        sleep(2);

        exit();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $extensionKey = strtolower($this->argument('extensionKey'));

        if (!strpos($extensionKey, '_')) {
            echo "Your extension key does not contain an underscore";

            echo "Please run the command like:";
            echo "\r\n";
            echo "php artisan build:extension example_extension";

            sleep(2);
            exit();
        }

        if (!$this->confirm('You named the extension: ' . $extensionKey . ' Is that correct?')) {

            echo "You can rerun the command by using";
            echo "\r\n";
            echo "php artisan build:extension example_extension";

            sleep(2);

            exit();
        }

        $config = $this->choice('Building a configuration template? [0/1]', ['Build a configuration template', 'Build a extension']);

        // @todo switch van maken
        if ($config === 0) {

            echo "Building a configuration template";
            FileGenerator::createRootDirectory($config, $extensionKey);
        } elseif ($config === 1) {

            echo "Building a normal extension";
            FileGenerator::createRootDirectory($config, $extensionKey);
        } else {

            echo "Please select a valid value";
        }

        sleep(2);

    }

}
