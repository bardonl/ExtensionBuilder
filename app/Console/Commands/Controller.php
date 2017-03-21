<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Factory\BuildControllerFactory;

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
    protected $description = 'Command description';

    /**
     * The controller factory
     *
     * @var BuildControllerFactory
     */
    protected $controllerFactory;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $controller = $this->argument('controller');

        $extension = $this->ask('Which extension needs the new controller(s)');
        $question =  $this->confirm('Are you sure?' . $extension);

        if ($question) {
            $this->getBuildControllerFactory()->handle($extension, $controller);
        } else {
            echo 'sterf een langzame dood';
        }
    }

    /**
     * @return BuildControllerFactory
     */
    protected function getBuildControllerFactory()
    {
        if (($this->controllerFactory instanceof BuildControllerFactory) === false) {
            $this->controllerFactory = new BuildControllerFactory();
        }

        return $this->controllerFactory;
    }
}
