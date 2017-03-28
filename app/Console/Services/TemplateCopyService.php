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

            if ($illuminatefunctions->getFileSystem()->exists($extensionDirectory . "/Classes/Controller")) {

                if (!$illuminatefunctions->getFileSystem()->exists($extensionDirectory . "/Classes/Controller/" . $controller . ".php")){
    
                    $illuminatefunctions->getFileSystem()->copy(TEMPLATE_DIRECTORY . "/DefaultController.php", $extensionDirectory . "/Classes/Controller/" . $controller . ".php");
    
                    $illuminatefunctions->getFileReplaceUtility()->findAndReplace(
                        $extensionDirectory . "/Classes/Controller/" . $controller . ".php",
                        [
                            'TestController' => $controller,
                            'ExtensionName' => $extensionKey
                        ]
                    );
                } else {

                    return "Controller already exists";

                }
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
}