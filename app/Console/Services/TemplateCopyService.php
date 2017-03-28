<?php
namespace App\Console\Services;

use Illuminate\Filesystem\Filesystem;
use App\Console\Utility\GetIlluminateFunctions;

class TemplateCopyService
{
    /**
     * @var GetIlluminateFunctions
     */
    protected $getilluminatefunctions;

    public $illuminatefunctions;
    
    public function copy($controllers, $extensionDirectory, $extensionKey)
    {
        $illuminatefunctions = $this->getIlluminateFunctions();

        foreach ($controllers as $controller) {

            if (!$illuminatefunctions->getFileSystem()->exists($extensionDirectory . "/Classes/Controller")) {

                $this->buildControllerDir($extensionKey);

                $this->checkFilesExists($controller, $extensionDirectory, $extensionKey);

            } else {

                $this->checkFilesExists($controller, $extensionDirectory, $extensionKey);
                
            }
        }
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

    public function checkFilesExists($controller, $extensionDirectory, $extensionKey)
    {

        if (!$this->getIlluminateFunctions()->getFileSystem()->exists($extensionDirectory . "/Classes/Controller/" . $controller . ".php")) {

            $this->copyTemplates($controller, $extensionDirectory, $extensionKey);

        } else {

            return "Controller(s) already exists";

        }
    }

    public function copyTemplates($controller, $extensionDirectory, $extensionKey){
        $this->getIlluminateFunctions()->getFileSystem()->copy(TEMPLATE_DIRECTORY . "/DefaultController.php", $extensionDirectory . "/Classes/Controller/" . $controller . ".php");

        $this->getIlluminateFunctions()->getFileReplaceUtility()->findAndReplace(
            $extensionDirectory . "/Classes/Controller/" . $controller . ".php",
            [
                'TestController' => $controller,
                'ExtensionName' => $extensionKey
            ]
        );
    }
    
    protected function buildControllerDir($extensionKey){

        $this->getIlluminateFunctions()->getFileSystem()->makeDirectory($extensionKey . "/Classes/Controller");

    }
}