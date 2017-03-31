<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Info
 * @package App\Console\Commands
 */
class Info extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display information about the extension builder and its commands';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('
        
====================================================================================================================

                                      Redkiwi TYPO3 Extension Builder
                                       Made by Bart de Geus (trainee)
                                With a little bit of magic from Rick in the Field
                                
====================================================================================================================

php artisan build:extension "extensionkey"  :       This will build an extension with default config
php artisan build:controller                :       This will build a conroller for an existing extension
php artisan build:model                     :       This will build a model for an existing extension

            ');
        die();
    }
}
