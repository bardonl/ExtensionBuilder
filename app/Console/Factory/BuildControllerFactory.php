<?php
namespace App\Console\Factory;

use Illuminate\Filesystem\Filesystem;
use App\Console\Utility\FileReplaceUtility;
use App\Console\Utility\GetIlluminateFunctions;

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
     * @var GetIlluminateFunctions
     */
    protected $getilluminatefunctions;
    
    public $illuminatefunctions;

    /**
     * @param string $extensionKey
     * @param array $controllers
     * @param bool $new_ext
     * @return string
     */
    public function handle($extensionKey, array $controllers, $new_ext)
    {

        $illuminatefunctions = $this->getIlluminateFunctions();

        $extensionDirectory = ROOT_DIRECTORY . "/" . $extensionKey;
        
        if ($new_ext) {
            

        } else {

            if (!$illuminatefunctions->getFileSystem()->exists($extensionDirectory)) {

                return "Extension doesn't exist";

            } else {
    
                $illuminatefunctions->getTemplateCopyService()->copy($controllers, $extensionDirectory, $extensionKey);
                
            }
        }
    }

    /**
     * @param string $controller
     */
    protected function buildTemplateFolder($controller)
    {
        $this->getilluminatefunctions->getFileSystem()->makeDirectory($this->extensionKey . '/Resources/Private/Template/' . $controller);
    }

    protected function buildControllerFolder()
    {
        $this->getilluminatefunctions->getFileSystem()->makeDirectory($this->extensionKey . '/Classes/Controller');
    }
    
    protected function buildController()
    {
        $newPath = $this->extensionKey . '/Classes/Controller';
        $this->getilluminatefunctions->getFileSystem()->copy($newPath, 'Controller template');
    }
    
    /**
     * @return GetIlluminateFunctions
     */
    public function getIlluminateFunctions()
    {

        if (($this->getilluminatefunctions instanceof GetIlluminateFunctions) === false) {
            $this->getilluminatefunctions = new GetIlluminateFunctions();
        }

        return $this->getilluminatefunctions;

    }
    
}