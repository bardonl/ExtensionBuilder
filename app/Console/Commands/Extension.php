<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Services\FileGeneratorService;

/**
 * Class Extension
 * 
 * @package App\Console\Commands
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
    protected $description = 'The main command to run the extension builder';

    /**
     * The file generator
     *
     * @var FileGeneratorService
     */
    protected $fileGenerator;

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
            'type' => '',
            'path' => '',
            'extensionType' => '',
            'keys' => [
                ''
            ]
        ];

        $this->confirmExtensionKey($config);

        $this->chooseExtensionType($config);

        $this->confirmController($config);

    }

    /**
     * @return FileGeneratorService
     */
    protected function getFileGeneratorService()
    {
        if (($this->fileGenerator instanceof FileGeneratorService) === false) {

            $this->fileGenerator = new FileGeneratorService();

        }

        return $this->fileGenerator;
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
        if (empty($config['extensionType'])) {

            $config['extensionType'] = $this->choice(

                'Building a configuration template?',
                [0 => 'Build a configuration template', 1 => 'Build an extension']

            );
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
}
