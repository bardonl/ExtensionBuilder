<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Factory\BuildControllerFactory;

/**
 * Class Controller
 * 
 * @package App\Console\Commands
 */
class Controller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:controller {extensionKey?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to build a controller, if more is needed separate them with a comma and a space "FooController, BarController"';

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
     */
    public function handle()
    {
        $controller = array_map('trim', explode("," , $this->ask("Type the name(s) of the controller(s), if you want to use more than one controller separate them using a coma and a space.")));
        $extensionKey = $this->argument('extensionKey');
        
        if ($extensionKey[0]) {

            $this->info($this->getBuildControllerFactory()->handle($extensionKey, $controller, $newExt = true));

        } else {

            $extensionKey = $this->ask('Which extension needs the new controller(s)?');
            $this->info($this->getBuildControllerFactory()->handle($extensionKey, $controller, $newExt = false));

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
