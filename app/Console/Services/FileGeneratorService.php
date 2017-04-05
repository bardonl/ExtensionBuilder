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
     * @param array $config
     */
    public function buildFolderStructure($config)
    {
        $this->dependencyInjectionManager()->getFileSystem()->makeDirectory(realpath('../') . '/' . $config['path'], 755, true);
    }

}
