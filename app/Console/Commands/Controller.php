<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Traits\DependencyInjectionManagerTrait;

/**
 * Class Controller
 * 
 * @package App\Console\Commands
 */
class Controller extends Command
{
    use DependencyInjectionManagerTrait;
    
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
        if ($this->argument('config')) {
    
            $config = $this->argument('config');

        } else {
            
            $config = [];
        }

        $config['keys'] = array_map('trim', explode(',' , $this->ask('Type the name(s) of the controller(s), if you want to use more than one controller separate them using a coma and a space.')));
        $config['type'] = 'Controller';

        if (array_key_exists('extensionKey', $config)) {

            $config['path'] = $this->getPath($config);
            $this->info($this->dependencyInjectionManager()->getBuildFileFactory()->handle($config, true));
        } else {
            
            $config['extensionKey'] = $this->ask('Which extension needs the new controller(s)?');
            $config['path'] = $this->getPath($config);
            $this->info($this->dependencyInjectionManager()->getBuildFileFactory()->handle($config, false));
        }

    }
    
    /**
     * @param array $config
     * @return array $paths
     */
    protected function getPath($config)
    {
        $paths[] = [
            $config['extensionKey'] . '/Classes/Controller/',
            $config['extensionKey'] . '/Resources/Private/Language'
        ];
        
        foreach ($config['keys'] as $key) {
            $paths[] = $config['extensionKey'] . '/Resources/Private/Templates/' . str_replace('Controller', '', $key) . '/';
        }

        foreach ($paths as $path) {
            if (!$this->dependencyInjectionManager()->getFileSystem()->isDirectory(realpath('../') . '/' . $path)) {
                $this->dependencyInjectionManager()->getFileGeneratorService()->buildFolderStructure($path);
            }
        }

        return $paths;
    }
}
