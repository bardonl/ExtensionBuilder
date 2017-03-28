<?php
namespace App\Console\Factory;

use App\Console\Utility\InpendecyInjections;

/**
 * build controller factory
 *
 * @package ExtensionBuilder\Console\Factory
 * @author Rick in 't Veld <intveld@redkiwi.nl>, Redkiwi
 */
class BuildControllerFactory
{

    /**
     * @var string
     */
    protected $extensionKey;
    
    /**
     * @var InpendecyInjections
     */
    protected $getInpendecyInjections;
    
    /**
     * @param string $extensionKey
     * @param array $controllers
     * @param bool $newExt
     * @return string
     */
    public function handle($extensionKey, array $controllers, $newExt)
    {

        $getInpendecyInjections = $this->getInpendecyInjections();

        $extensionDirectory = ROOT_DIRECTORY . "\\" . $extensionKey;
        
        if ($newExt) {
            
            $this->getInpendecyInjections()->getTemplateCopyService()->replaceDummyContent($controllers, $extensionDirectory, $extensionKey);

        } else {

            if (!$getInpendecyInjections->getFileSystem()->exists($extensionDirectory)) {

                return "Extension doesn't exist";

            } else {
    
                $getInpendecyInjections->getTemplateCopyService()->replaceDummyContent($controllers, $extensionDirectory, $extensionKey);
                
            }
        }
    }

    protected function buildControllerFolder()
    {
        $this->getInpendecyInjections->getFileSystem()->makeDirectory($this->extensionKey . '/Classes/Controller');
    }
    
    protected function buildController()
    {
        $newPath = $this->extensionKey . '/Classes/Controller';
        $this->getInpendecyInjections->getFileSystem()->copy($newPath, 'Controller template');
    }
    
    /**
     * @return InpendecyInjections
     */
    public function getInpendecyInjections()
    {

        if (($this->getInpendecyInjections instanceof InpendecyInjections) === false) {
            $this->getInpendecyInjections = new InpendecyInjections();
        }

        return $this->getInpendecyInjections;

    }
    
}