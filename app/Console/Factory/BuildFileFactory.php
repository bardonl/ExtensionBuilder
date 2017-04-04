<?php
namespace App\Console\Factory;

use App\Console\Utility\DependencyInjections;

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
            
            if (!$this->getDependencyInjections()->getFileSystem()->exists( $config['rootDirectory'])) {

                return 'Extension does not exist';
            } else {

                $this->getDependencyInjections()->getTemplateCopyService()->replaceDummyContent($config);
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
    
}