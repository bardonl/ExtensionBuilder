<?php
namespace App\Console\Traits;

use App\Console\Utility\DependencyInjectionManager;

trait DependencyInjectionManagerTrait
{
    /**
     * @var DependencyInjectionManager
     */
    protected $dependencyInjectionManager;
    
    /**
     * @return DependencyInjectionManager
     */
    public function dependencyInjectionManager()
    {
        
        if (($this->dependencyInjectionManager instanceof DependencyInjectionManager) === false) {
            $this->dependencyInjectionManager = new DependencyInjectionManager();

        }
        
        return $this->dependencyInjectionManager;
    }
}