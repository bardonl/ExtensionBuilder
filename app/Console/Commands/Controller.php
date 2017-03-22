<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Factory\BuildControllerFactory;

/**
 * Class Controller
 * @package App\Console\Commands
 */
class Controller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:controller {controller} {extensionKey=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to build one or more controllers';

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

        $controller = explode(',',$this->argument('controller'));
        $extensionKey = $this->argument('extensionKey');

        if ($extensionKey != NULL) {

            $this->getBuildControllerFactory()->handle($extensionKey, $controller);

        } else {

            $extensionKey = $this->ask('Which extension needs the new controller(s)');
            $this->getBuildControllerFactory()->handle($extensionKey, $controller);
            
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
