<?php
namespace App\Console\Services;

use App\Console\Utility\DependencyInjections;

class TemplateCopyService
{
    /**
     * @var DependencyInjections
     */
    protected $getDependencyInjections;
    
    /**
     * @param array $config
     */
    public function replaceDummyContent($config)
    {
        
        foreach ($config['keys'] as $key) {

            if (!$this->getDependencyInjections()->getFileSystem()->exists(realpath('../') . '/' . $config['path'])) {
                
                $this->getDependencyInjections()->getFileGeneratorService()->buildFolderStructure($config);
            }

            $this->checkFilesExists($key, $config);
        }
    }
    
    /**
     * @param $key
     * @param $config
     */
    public function checkFilesExists($key, $config)
    {
        if (!$this->getDependencyInjections()->getFileSystem()->exists(realpath('../'). '/' . $config['path'] . '/' . $key . '.php')) {

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

        $this->getDependencyInjections()->getFileSystem()->copy(
            TEMPLATE_DIRECTORY . '/Default'. $config['type'] .'.php',
            realpath('../') . '/' . $config['path'] . '/' . $key . '.php'
        );

        $this->getDependencyInjections()->getFileReplaceUtility()->findAndReplace(
            realpath('../') . '/' . $config['path'] . '/' . $key . '.php',
            [
                'Test' . $config['type'] => $key,
                'ExtensionName' => $config['extensionKey']
            ]
        );
        
    }

    /**
     * @return DependencyInjections
     */
    public function getDependencyInjections()
    {

        if (($this->getDependencyInjections instanceof DependencyInjections) === false) {
            $this->getDependencyInjections = new DependencyInjections();
        }

        return $this->getDependencyInjections;

    }
}