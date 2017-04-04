<?php
namespace App\Console\Factory;

use App\Console\Utility\DependencyInjections;
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
     * @var DependencyInjections
     */
    protected $getDependencyInjections;
    
    /**
     * @param array $config
     * @param bool $newExt
     * @return string
     */
    public function handle(array $config, $newExt)
    {

        $config['rootDirectory'] = ROOT_DIRECTORY . '/' . $config['extensionKey'];

        if ($newExt) {

            $this->getDependencyInjections()->getTemplateCopyService()->replaceDummyContent($config);
        } else {
            
            try{
                $this->checkFile($config);
                $this->getDependencyInjections()->getTemplateCopyService()->replaceDummyContent($config);
            } catch (Exception $e) {

                // @todo exception (call base command)

                return 'Caught exception: ' . $e->getMessage() . "\n";
            }
        }
    }
    
    /**
     * @return DependencyInjections
     */
    public function getDependencyInjections()
    {

        if (($this->getDependencyInjections instanceof DependencyInjections) === false) {
            
            $this->getDependencyInjections = new DependencyInjections();
        }

        return $this->getDependencyInjections;
        
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