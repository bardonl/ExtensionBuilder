<?php
namespace App\Console\Commands;

use App\Console\Traits\DependencyInjectionManagerTrait;
use Illuminate\Console\Command;

/**
 * Class ConfigurationTemplate
 * 
 * @package App\Console\Commands
 */
class ConfigurationTemplate extends Command
{
    use DependencyInjectionManagerTrait;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:configurationtemplate {config?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is called when there is asked for a Configuration Template';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('config')) {

            foreach ($this->argument('config') as $key => $value) {
                $config[$key] = $value;
            }

        } else {

            $config = [];
        }

        var_dump($config);
        die;

        $this->getPath($config);
        
        if ($this->confirm('Do you need TypoScript?')) {
            
            $config['path'] = $config['extensionKey'] . '/Configuration/TypoScript/Base/';
            $config['keys'] = ['Page.ts', 'Config.ts'];
            $config['typoScript'] = 1;
            $this->dependencyInjectionManager()->getTemplateCopyService()->replaceDummyContent($config);
        }
    }
    
    /**
     * @param array $config
     * @return array $paths
     */
    public function getPath($config)
    {
        
        // @todo maybe think of a more efficient way
        $paths[] = [
            $config['extensionKey'] . '/Configuration/BackendLayout/',
            $config['extensionKey'] . '/Configuration/TypoScript/Base/',
            $config['extensionKey'] . '/Resources/Private/Layouts/',
            $config['extensionKey'] . '/Resources/Public/',
            $config['extensionKey'] . '/Resources/Public/JavaScripts/',
            $config['extensionKey'] . '/Resources/Public/Styles/',
            $config['extensionKey'] . '/Resources/Public/Images/'
        ];

        foreach ($paths as $path) {
            if (!$this->dependencyInjectionManager()->getFileSystem()->isDirectory(realpath('../') . '/' . $path)) {
                $this->dependencyInjectionManager()->getFileGeneratorService()->buildFolderStructure($path);
            }
        }
        
        return $paths;
    }
}
