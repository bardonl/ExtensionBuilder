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
        if (!$this->dependencyInjectionManager()->getFileSystem()->exists(realpath('../') . '/' . $config['path'][0] . $key . '.php')) {
            if (array_key_exists('typoScript', $config) && $config['typoScript'] == 1) {
                $this->copyTSTemplates($key, $config);
            } else {
                $this->copyTemplates($key, $config);
            }
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

        if ($config['type'] == 'Model') {
            
            $this->dependencyInjectionManager()->getFileSystem()->copy(
                TEMPLATE_DIRECTORY . '/DefaultTCA.php',
                realpath('../') . '/' . $config['path'][1] . $key . '.php'
            );

            $this->dependencyInjectionManager()->getFileReplaceUtility()->findAndReplace(
                realpath('../') . '/' . $config['path'][1] . $key . '.php',
                [
                    'Test' . $config['type'] => $key,
                    'ExtensionName' => $config['extensionKey']
                ]
            );

            if ($this->dependencyInjectionManager()->getFileSystem()->exists($config['rootDirectory'] . '/' . 'ext_tables.sql')) {

                // @todo copy content of ext_tables.sql for each model in existing file

            } else {

                $this->dependencyInjectionManager()->getFileSystem()->copy(
                    TEMPLATE_DIRECTORY . '/ext_tables.sql',
                    $config['rootDirectory'] . '/' . 'ext_tables.sql'
                );

                // @todo copy existing content within the file for each model

                $this->dependencyInjectionManager()->getFileReplaceUtility()->findAndReplace(
                    $config['rootDirectory'] . '/' . 'ext_tables.sql',
                    [
                        'TABLE_NAME' => 'tx_' . strtolower($config['extensionKey']) . '_domain_model_' . strtolower($key)
                    ]
                );

            }

        }
        
    }
    
    /**
     * @param array $config
     * @param string $defaultFile
     */
    public function copyRootTemplates($config, $defaultFile) {
        $this->dependencyInjectionManager()->getFileSystem()->copy(
            TEMPLATE_DIRECTORY . '/' . $defaultFile,
            realpath('../') . '/' . $config['extensionKey'] . '/' . $defaultFile
        );
        
        $this->dependencyInjectionManager()->getFileReplaceUtility()->findAndReplace(
            realpath('../') . '/' . $config['extensionKey'] . '/' . $defaultFile,
            [
                'ExtensionName' => $config['extensionKey']
            ]
        );
    }
    
    /**
     * @param string $key
     * @param array $config
     */
    public function copyTSTemplates($key, $config){
        $this->dependencyInjectionManager()->getFileSystem()->copy(
            TEMPLATE_DIRECTORY . '/' . $key,
            realpath('../') . '/' . $config['path'] . $key
        );

        $this->dependencyInjectionManager()->getFileReplaceUtility()->findAndReplace(
            realpath('../') . '/' . $config['path'] . $key,
            [
                'ExtensionName' => $config['extensionKey']
            ]
        );
    }

}