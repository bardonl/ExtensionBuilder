<?php
namespace App\Console\Services;

use App\Console\Utility\DependencyInjectionManager;

class TemplateCopyService
{
    /**
     * @var DependencyInjectionManager
     */
    protected $dependencyInjectionManager;
    
    /**
     * @param array $config
     */
    public function replaceDummyContent($config)
    {
        
        foreach ($config['keys'] as $key) {

            if (!$this->dependencyInjectionManager()->getFileSystem()->exists(realpath('../') . '/' . $config['path'])) {
                
                $this->dependencyInjectionManager()->getFileGeneratorService()->buildFolderStructure($config);
            }

            $this->checkFilesExists($key, $config);
        }
    }
    
    /**
     * @param string $key
     * @param array $config
     */
    public function checkFilesExists($key, $config)
    {
        if (!$this->dependencyInjectionManager()->getFileSystem()->exists(realpath('../'). '/' . $config['path'] . '/' . $key . '.php')) {

            $this->copyTemplates($key, $config);
        } else {

            echo 'File(s) already exists';
        }
    }
    
    /**
     * @param string $key
     * @param array $config
     */
    public function copyTemplates($key, $config)
    {

        $this->dependencyInjectionManager()->getFileSystem()->copy(
            TEMPLATE_DIRECTORY . '/Default'. $config['type'] .'.php',
            realpath('../') . '/' . $config['path'] . '/' . $key . '.php'
        );

        $this->dependencyInjectionManager()->getFileReplaceUtility()->findAndReplace(
            realpath('../') . '/' . $config['path'] . '/' . $key . '.php',
            [
                'Test' . $config['type'] => $key,
                'ExtensionName' => $config['extensionKey']
            ]
        );
        
    }

    /**
     * @return DependencyInjectionManager
     */
    public function dependencyInjectionManager()
    {

        if (($this->dependencyInjectionManager instanceof DependencyInjectionManager) === false) {
            $this->dependencyInjectionsManager = new DependencyInjectionManager();
        }

        return $this->dependencyInjectionManager;

    }
}