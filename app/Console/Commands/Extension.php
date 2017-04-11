<?php
namespace App\Console\Commands;

use App\Console\Traits\DependencyInjectionManagerTrait;
use Illuminate\Console\Command;

/**
 * Class Extension
 * 
 * @package App\Console\Commands
 */
class Extension extends Command
{
    use DependencyInjectionManagerTrait;
    
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
    protected $description = 'The main command to run the extension builder';
    
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
        $config = [
            'extensionKey'=> $this->argument('extensionKey'),
            'rootDirectory' => ROOT_DIRECTORY . '/' . $this->argument('extensionKey'),
        ];

        $this->confirmExtensionKey($config);
        
        $this->dependencyInjectionManager()->getFileGeneratorService()->buildRoot($config);

        $this->chooseExtensionType($config);

        $this->confirmController($config);
        
        $this->confirmModel($config);

    }

    /**
     * Call Command build:extension with new key if extensionKey is not correct
     *
     * @param array $config
     */
    public function confirmExtensionKey($config)
    {
        if (!$this->confirm('You named the extension: ' . $config['extensionKey'] . ' Is that correct?')) {

            $config['extensionKey'] = $this->ask('Type new extension key:');

            $this->call('build:extension', ['extensionKey' => $config['extensionKey']]);
            die;
        }
    }

    /**
     * @param array $config
     */
    public function chooseExtensionType($config)
    {
            if ($this->confirm('Configuration Template?')) {
                $this->call('build:configurationtemplate', ['config' => $config]);
            }
    }

    /**
     * Call the build:controller if controllers are needed
     *
     * @param array $config
     */
    public function confirmController($config)
    {
        if ($this->confirm('Do you need a controller?')) {
            $this->call('build:controller', ['config' => $config]);
        }
    }
    
    /**
     * @param array $config
     */
    public function confirmModel($config)
    {
        if ($this->confirm('Do you need a model?')) {
            
            $this->call('build:model', ['config' => $config]);
            
        }
    }
}
