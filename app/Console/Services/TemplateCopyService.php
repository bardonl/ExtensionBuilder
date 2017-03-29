<?php
namespace App\Console\Services;

use App\Console\Utility\DependecyInjections;

class TemplateCopyService
{
    /**
     * @var DependecyInjections
     */
    protected $getDependecyInjections;
    
    /**
     * @param array $config
     */
    public function replaceDummyContent($config)
    {
        
        foreach ($config['keys'] as $key) {

            if (!$this->getDependecyInjections()->getFileSystem()->exists($config['rootDirectory'] . '/' . $config['path'])) {

                $this->getDependecyInjections()->getFileGeneratorService()->buildFolderStructure($config);

                $this->checkFilesExists($key, $config);
            } else {

                $this->checkFilesExists($key, $config);
            }
        }
    }
    
    /**
     * @param string $key
     * @param array $config
     * @return string
     */
    public function checkFilesExists($key, $config)
    {
        if (!$this->getDependecyInjections()->getFileSystem()->exists($config['rootDirectory'] . '/' . $config['path'] . $key . ".php")) {

            $this->copyTemplates($key, $config);
        } else {

            return "File(s) already exists";
        }
    }
    
    /**
     * @param string $key
     * @param array $config
     */
    public function copyTemplates($key, $config)
    {

        $this->getDependecyInjections()->getFileSystem()->copy(
            TEMPLATE_DIRECTORY . '/Default'. $config['type'] .'.php',
            $config['rootDirectory'] . '/' . $config['path'] . '/' . $key . '.php'
        );

        $this->getDependecyInjections()->getFileReplaceUtility()->findAndReplace(
            $config['rootDirectory'] . '/' . $config['path'] . '/' . $key . '.php',
            [
                'TestController' => $key,
                'ExtensionName' => $config['extensionKey']
            ]
        );
    }

    /**
     * @return DependecyInjections
     */
    public function getDependecyInjections()
    {

        if (($this->getDependecyInjections instanceof DependecyInjections) === false) {
            $this->getDependecyInjections = new DependecyInjections();
        }

        return $this->getDependecyInjections;

    }
}