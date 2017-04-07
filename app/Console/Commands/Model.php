<?php
namespace App\Console\Commands;

use App\Console\Traits\DependencyInjectionManagerTrait;
use Illuminate\Console\Command;

/**
 * Class Model
 * 
 * @package App\Console\Commands
 */
class Model extends Command
{
    use DependencyInjectionManagerTrait;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:model {config?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The model is where the getters and setters are placed so the values can be used in the template.';

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
    
        if ($this->argument('config')) {
        
            $config = $this->argument('config');
        
        } else {
        
            $config = [];
        }

        $config['keys'] = array_map('trim', explode(',' , $this->ask('Type the name(s) of the model(s), if you want to use more than one model separate them using a coma and a space.')));
        $config['type'] = 'Model';

        if (array_key_exists('extensionKey', $config)) {

            $config['path'] = $this->getPath($config);
            $this->info($this->dependencyInjectionManager()->getBuildFileFactory()->handle($config, true));
        } else {

            $config['extensionKey'] = $this->ask('Which extension needs the new model(s)?');
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
            $config['extensionKey'] . '/Classes/Domain/Model/',
            $config['extensionKey'] . '/Configuration/TCA/'
        ];
    
        foreach ($paths as $path) {
            if (!$this->dependencyInjectionManager()->getFileSystem()->isDirectory(realpath('../') . '/' . $path)) {
                $this->dependencyInjectionManager()->getFileGeneratorService()->buildFolderStructure($path);
            }
        }
        
        return $paths;
    }
}
