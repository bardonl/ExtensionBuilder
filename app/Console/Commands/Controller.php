<?php
namespace App\Console\Commands;

use App\Console\Factory\BuildFileFactory;
use Illuminate\Console\Command;

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
    protected $signature = 'build:controller {config?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to build a controller, if more is needed separate them with a comma and a space "FooController, BarController"';

    /**
     * The controller factory
     *
     * @var BuildFileFactory
     */
    protected $fileFactory;

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
        if(!empty($this->argument('config'))) {

            foreach( $this->argument('config') as $key => $value){
                $config[$key] = $value;
            }

        } else {
            
            $config = [];
        }

        $config['keys'] = array_map('trim', explode(',' , $this->ask('Type the name(s) of the controller(s), if you want to use more than one controller separate them using a coma and a space.')));
        $config['path'] = 'Classes/Controller';
        $config['type'] = 'Controller';

        if (array_key_exists('extensionKey', $config)) {
            
            $this->info($this->getBuildFileFactory()->handle($config, true));
        } else {
    
            $config['extensionKey'] = $this->ask('Which extension needs the new controller(s)?');
            $this->info($this->getBuildFileFactory()->handle($config, false));
        }

    }

    /**
     * @return BuildFileFactory
     */
    protected function getBuildFileFactory()
    {
        if (($this->fileFactory instanceof BuildFileFactory) === false) {

            $this->fileFactory = new BuildFileFactory();
        }

        return $this->fileFactory;
    }
}
