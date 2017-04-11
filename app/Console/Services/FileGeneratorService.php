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

        $config['keys'] = [
            'ext_emconf.php',
            'ext_localconf.php',
            'ext_tables.php'
        ];

        $config['path'] = $config['extensionKey'] . '/';

        $this->dependencyInjectionManager()->getFileSystem()->makeDirectory(realpath('../') . '/' . $config['path'] , 755, true);

        foreach ($config['keys'] as $key) {
            if (! $this->dependencyInjectionManager()->getFileSystem()->isFile(realpath('../') . '/' . $config['path'] . '/' . $key)) {
                $this->dependencyInjectionManager()->getTemplateCopyService()->copyRootTemplates($key, $config);
            }
        }
    }

}
