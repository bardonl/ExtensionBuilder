<?php
namespace App\Console\Factory;

use App\Console\Utility\DependecyInjections;

/**
 * build controller factory
 *
 * @package ExtensionBuilder\Console\Factory
 * @author Rick in 't Veld <intveld@redkiwi.nl>, Redkiwi
 */
class BuildFileFactory
{

    /**
     * @var string
     */
    protected $extensionKey;
    
    /**
     * @var DependecyInjections
     */
    protected $getDependecyInjections;
    
    /**
     * @param array $config
     * @param bool $newExt
     * @return string
     */
    public function handle(array $config, $newExt)
    {

        $config['rootDirectory'] = ROOT_DIRECTORY . "/" . $config['extensionKey'];

        if ($newExt) {

            $this->getDependecyInjections()->getTemplateCopyService()->replaceDummyContent($config);

        } else {
            if (!$this->getDependecyInjections()->getFileSystem()->exists( $config['rootDirectory'])) {

                return "Extension doesn't exist";

            } else {

                $this->getDependecyInjections()->getTemplateCopyService()->replaceDummyContent($config);
                
            }
        }
    }
    
    /**
     * @return DependecyInjections
     */
    public function getDependecyInjections()
    {

        if (($this->getDependecyInjections instanceof DependecyInjections) === false) {
            $this->getDependecyInjections = new DependecyInjections();
        }

        return $this->getDependecyInjections;

    }
    
}