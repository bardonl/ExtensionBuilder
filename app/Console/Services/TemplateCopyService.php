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

            $this->checkFilesExists($key, $config);
        }
    }
    
    /**
     * @param string $key
     * @param array $config
     */
    public function checkFilesExists($key, $config)
    {
        // @todo make it work with a path array
        if (!$this->dependencyInjectionManager()->getFileSystem()->exists(realpath('../') . '/' . $config['path'][0] . $key . '.php')) {
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
            TEMPLATE_DIRECTORY . '/Default' . $config['type'] . '.php',
            realpath('../') . '/' . $config['path'][0] . $key . '.php'
        );

        $this->dependencyInjectionManager()->getFileReplaceUtility()->findAndReplace(
            realpath('../') . '/' . $config['path'][0] . $key . '.php',
            [
                'Test' . $config['type'] => $key,
                'ExtensionName' => $config['extensionKey']
            ]
        );
        
    }

}