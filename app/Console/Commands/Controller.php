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
    protected $signature = 'build:controller {controller} {extensionKey?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to build a controller, if more is needed separate them with a comma without a space "FooController,BarController"';

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
        $controller = explode(', ',$this->argument('controller'));

        $extensionKey = $this->argument('extensionKey');

        if ($extensionKey[0] != NULL) {

            $this->info($this->getBuildControllerFactory()->handle($extensionKey, $controller, $new_ext = true));

        } else {

            $extensionKey = $this->ask('Which extension needs the new controller(s)?');
            $this->info($this->getBuildControllerFactory()->handle($extensionKey, $controller, $new_ext = false));

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
