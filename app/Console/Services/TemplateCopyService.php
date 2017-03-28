<?php
namespace App\Console\Services;

use App\Console\Utility\InpendecyInjections;

class TemplateCopyService
{
    /**
     * @var InpendecyInjections
     */
    protected $getInpendecyInjections;
    
    /**
     * @param $controllers
     * @param $extensionDirectory
     * @param $extensionKey
     */
    public function replaceDummyContent($controllers, $extensionDirectory, $extensionKey)
    {
        $inpendecyInjections = $this->getInpendecyInjections();
        
        foreach ($controllers as $controller) {

            if (!$inpendecyInjections->getFileSystem()->exists($extensionDirectory . "/Classes/Controller")) {

                $this->buildControllerDir($extensionKey);

                $this->checkFilesExists($controller, $extensionDirectory, $extensionKey);

            } else {

                $this->checkFilesExists($controller, $extensionDirectory, $extensionKey);
                
            }
        }
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
    
    /**
     * @param array $controller
     * @param string $extensionDirectory
     * @param string $extensionKey
     * @return string
     */
    public function checkFilesExists($controller, $extensionDirectory, $extensionKey)
    {

        if (!$this->getInpendecyInjections()->getFileSystem()->exists($extensionDirectory . "/Classes/Controller/" . $controller . ".php")) {

            $this->copyTemplates($controller, $extensionDirectory, $extensionKey);

        } else {

            return "Controller(s) already exists";

        }
    }
    
    /**
     * @param $controller
     * @param $extensionDirectory
     * @param $extensionKey
     */
    public function copyTemplates($controller, $extensionDirectory, $extensionKey)
    {
        $this->getInpendecyInjections()->getFileSystem()->copy(
            TEMPLATE_DIRECTORY . "/DefaultController.php", 
            $extensionDirectory . "/Classes/Controller/" . $controller . ".php"
        );

        $this->getInpendecyInjections()->getFileReplaceUtility()->findAndReplace(
            $extensionDirectory . "/Classes/Controller/" . $controller . ".php",
            [
                'TestController' => $controller,
                'ExtensionName' => $extensionKey
            ]
        );
    }
    
    /**
     * @param $extensionKey
     */
    protected function buildControllerDir($extensionKey)
    {

        $this->getInpendecyInjections()->getFileSystem()->makeDirectory($extensionKey . "/Classes/Controller");

    }
}