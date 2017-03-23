<?php
namespace App\Console\Factory;

use Illuminate\Filesystem\Filesystem;
use App\Console\Utility\FileReplaceUtility;

/**
 * build controller factory
 *
 * @package ExtensionBuilder\Console\Factory
 * @author Rick in 't Veld <intveld@redkiwi.nl>, Redkiwi
 */
class BuildControllerFactory
{

    /**
     * The file system
     *
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var FileReplaceUtility
     */
    protected $fileReplaceUtility;

    /**
     * @var string
     */
    protected $extensionKey;
    
    /**
     * @param string $extensionKey
     * @param array $controllers
     * @param bool $new_ext
     * @return string
     */
    public function handle($extensionKey, array $controllers, $new_ext)
    {

        $extensionDirectory = ROOT_DIRECTORY . "/" . $extensionKey;
        
        if ($new_ext) {
            
            return "You are in the BuildControllerFactory";
            
        } else {

            if (!$this->getFileSystem()->exists($extensionDirectory)) {

                return "Extension doesn't exist";

            } else {

                foreach ($controllers as $controller) {

                    if ($this->getFileSystem()->exists($extensionDirectory . "/Classes/Controller")) {

                        $this->getFileSystem()->copy(TEMPLATE_DIRECTORY . "/DefaultController.php", $extensionDirectory . "/Classes/Controller/" . $controller . ".php");

                        $this->getFileReplaceUtility()->findAndReplace(
                            $extensionDirectory . "/Classes/Controller/" . $controller . "php",
                            [
                                'TestController' => $controller,
                                'ExtensionName' => $this->extensionKey
                            ]
                        );
                    }
                }
            }
        }
    }

    /**
     * @param string $controller
     */
    protected function buildTemplateFolder($controller)
    {
        $this->getFileSystem()->makeDirectory($this->extensionKey . '/Resources/Private/Template/' . $controller);
    }
    
    protected function buildControllerFolder()
    {
        $this->getFileSystem()->makeDirectory($this->extensionKey . '/Classes/Controller');
    }
    
    protected function buildController()
    {
        $newPath = $this->extensionKey . '/Classes/Controller';
        $this->getFileSystem()->copy($newPath, 'Controller template');
    }

    /**
     * @return Filesystem
     */
    protected function getFileSystem()
    {
        if (($this->fileSystem instanceof Filesystem) === false) {
            $this->fileSystem = new Filesystem();
        }

        return $this->fileSystem;
    }

    /**
     * @return FileReplaceUtility
     */
    protected function getFileReplaceUtility()
    {
        if (($this->fileReplaceUtility instanceof FileReplaceUtility) === false ) {
            $this->fileReplaceUtility = new FileReplaceUtility();
        }

        return $this->fileReplaceUtility;
    }
}