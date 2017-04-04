<?php
namespace App\Console\Services;

use App\Console\Utility\DependencyInjections;

/**
 * Class TemplateCopyService
 * @package App\Console\Services
 */
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

            if (!$this->getDependencyInjections()->getFileSystem()->exists($config['rootDirectory'] . '/' . $config['path'])) {

                $this->getDependencyInjections()->getFileGeneratorService()->buildFolderStructure($config);
                
            }
            $this->checkFilesExists($key, $config);
        }
    }
    
    /**
     * @param string $key
     * @param array $config
     * @return string
     */
    public function checkFilesExists($key, $config)
    {
        if (!$this->getDependencyInjections()->getFileSystem()->exists($config['rootDirectory'] . '/' . $config['path'] . $key . '.php')) {

            $this->copyTemplates($key, $config);
        } else {

            return 'File(s) already exists';
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
            $config['rootDirectory'] . '/' . $config['path'] . '/' . $key . '.php'
        );

        $this->getDependencyInjections()->getFileReplaceUtility()->findAndReplace(
            $config['rootDirectory'] . '/' . $config['path'] . '/' . $key . '.php',
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