<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Model
 * 
 * @package App\Console\Commands
 */
class Model extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:model {model*}';

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

        echo 'This is the build:model command';
        sleep(4);
        
    }
}
