<?php
namespace App\Console\Factory;

use App\Console\Utility\DependencyInjectionManager;
use Mockery\CountValidator\Exception;

/**
 * build controller factory
 *
 * @package ExtensionBuilder\Console\Factory
 */
class BuildFileFactory
{

    /**
     * @var string
     */
    protected $extensionKey;
    
    /**
     * @var DependencyInjectionManager
     */
    protected $dependencyInjectionsManager;
    
    /**
     * @param array $config
     * @param bool $newExt
     * @return string
     */
    public function handle(array $config, $newExt)
    {

        $config['rootDirectory'] = ROOT_DIRECTORY . '/' . $config['extensionKey'];

        if ($newExt) {

            $this->dependencyInjectionManager()->getTemplateCopyService()->replaceDummyContent($config);
        } else {
            
            try{
                
                $this->checkFile($config);
                $this->dependencyInjectionManager()->getTemplateCopyService()->replaceDummyContent($config);
            } catch (Exception $e) {

                // @todo exception (call base command)
                return 'Caught exception: ' . $e->getMessage() . "\n";
            }
        }
    }
    
    /**
     * @return DependencyInjectionManager
     */
    public function dependencyInjectionManager()
    {

        if (($this->dependencyInjectionsManager instanceof DependencyInjectionManager) === false) {
            
            $this->dependencyInjectionsManager = new DependencyInjectionManager();
        }

        return $this->dependencyInjectionsManager;
        
    }
    
    /**
     * @param array $config
     * @return bool
     */
    function checkFile($config) {
        if(!$this->getDependencyInjections()->getFileSystem()->exists( $config['rootDirectory'])) {
            throw new Exception("File doesn't exist");
        }
        return true;
    }
    
}