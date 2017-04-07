<?php
namespace App\Console\Services;

use App\Console\Traits\DependencyInjectionManagerTrait;

/**
 * Class FileGeneratorService
 * 
 * @package ExtensionBuilder\Console\Services
 */
class FileGeneratorService
{
    use DependencyInjectionManagerTrait;

    /**
     * @param string $path
     */
    public function buildFolderStructure($path)
    {

        $this->dependencyInjectionManager()->getFileSystem()->makeDirectory(realpath('../') . '/' . $path, 755, true);

    }

    /**
     * @param array $config
     */
    public function buildRoot($config)
    {

        $defaultFiles = [
            'ext_emconf.php', 'ext_localconf.php', 'ext_tables.php'
        ];

        $this->dependencyInjectionManager()->getFileSystem()->makeDirectory(realpath('../') . '/' . $config['extensionKey'] , 755, true);

        foreach ($defaultFiles as $defaultFile) {
            if (! $this->dependencyInjectionManager()->getFileSystem()->isFile(realpath('../') . '/' . $config['extensionKey'] . '/' . $defaultFile)) {
                $this->dependencyInjectionManager()->getTemplateCopyService()->copyRootTemplates($config, $defaultFile);
            }
        }
    }

}
