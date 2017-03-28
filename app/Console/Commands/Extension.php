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

        $extensionKey = $this->argument('extensionKey');

        if($extensionKey == "info"){
            $this->info("
====================================================================================================================
                                             A Redkiwi product
                                       Made by Bart de Geus (trainee)
                                    With a little bit of magic from Rick
====================================================================================================================
php artisan build:extension 'extensionkey' : This will build an extension with default config
            ");
            die;
        }

        if (!$this->confirm('You named the extension: ' . $extensionKey . ' Is that correct?')) {
            
            $extensionKey = $this->ask('Type new extension key:');

            $this->call('build:extension', ['extensionKey' => $extensionKey]);

        }

        $config = $this->choice(
            
            'Building a configuration template? [0/1]',
            ['Build a configuration template', 'Build an extension']
            
        );
        
        if ($this->confirm("Do you need a controller?")) {
            
            $this->call('build:controller', ['extensionKey' => $extensionKey]);
            
        }
        
        $this->getFileGeneratorService()->createRootDirectory($config, $extensionKey);
        
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
}
