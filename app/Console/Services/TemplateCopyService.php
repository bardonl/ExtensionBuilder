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
                $this->copyRootTemplates($key, $config);
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

        if ($config['type'] === 'Model') {
            
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

            $this->copyExtTable($key, $config);
        }
        
    }
    
    /**
     * @param string $key
     * @param array $config
     */
    public function copyRootTemplates($key, $config)
    {
        $this->dependencyInjectionManager()->getFileSystem()->copy(
            TEMPLATE_DIRECTORY . '/' . $key,
            realpath('../') . '/' . $config['path'] . $key
        );
        
        $name = 'ExtensionName';

        if ($this->dependencyInjectionManager()->getFileSystem()->extension(realpath('../') . '/' . $config['path'] . $key) == 'ts') {
            $name = 'extension_name';
            $extensionKey = array_filter(array_map('strtolower',preg_split('/(?=[A-Z])/',$config['extensionKey'])));
            $config['extensionKey'] = implode('_', $extensionKey);
        }

        $this->dependencyInjectionManager()->getFileReplaceUtility()->findAndReplace(
            realpath('../') . '/' . $config['path'] . $key,
            [
                $name => $config['extensionKey']
            ]
        );

    }

    /**
     * @param string $key
     * @param array $config
     */
    public function copyExtTable($key, $config)
    {
        if ($this->dependencyInjectionManager()->getFileSystem()->exists($config['rootDirectory'] . '/' . 'ext_tables.sql')) {

            $ext_tablesContent = $this->dependencyInjectionManager()->getFileSystem()->get(TEMPLATE_DIRECTORY . '/ext_tables.sql');
            $this->dependencyInjectionManager()->getFileSystem()->append($config['rootDirectory'] . '/' . 'ext_tables.sql', $ext_tablesContent);

        } else {

            $this->dependencyInjectionManager()->getFileSystem()->copy(
                TEMPLATE_DIRECTORY . '/ext_tables.sql',
                $config['rootDirectory'] . '/' . 'ext_tables.sql'
            );
        }

        $this->dependencyInjectionManager()->getFileReplaceUtility()->findAndReplace(
            $config['rootDirectory'] . '/' . 'ext_tables.sql',
            [
                'TABLE_NAME' => 'tx_' . strtolower($config['extensionKey']) . '_domain_model_' . strtolower($key)
            ]
        );
    }

}