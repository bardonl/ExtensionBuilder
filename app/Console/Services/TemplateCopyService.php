<?php
namespace App\Console\Services;

use App\Console\Traits\DependencyInjectionManagerTrait;

class TemplateCopyService
{
    use DependencyInjectionManagerTrait;
    
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
        if (!$this->dependencyInjectionManager()->getFileSystem()->exists(realpath('../'). '/' . $config['path'] . $key . '.php')) {

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
            realpath('../') . '/' . $config['path'] . $key . '.php'
        );

        $this->dependencyInjectionManager()->getFileReplaceUtility()->findAndReplace(
            realpath('../') . '/' . $config['path'] . $key . '.php',
            [
                'Test' . $config['type'] => $key,
                'ExtensionName' => $config['extensionKey']
            ]
        );
        
    }

}