<?php
namespace App\Console\Services;

use Illuminate\Filesystem\Filesystem;

/**
 * Class FileGeneratorService
 * 
 * @package ExtensionBuilder\Console\Services
 */
class FileGeneratorService
{
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    public function createExtensionStructure($config, $extensionKey)
    {

        $this->createRootDirectory($config, $extensionKey);
        mkdir(ROOT_DIRECTORY . $extensionKey . "/Classes/Controller");

    }

    /**
     * @param int $config
     * @param string $extensionKey
     */
    public function createRootDirectory($config, $extensionKey)
    {
        if ($config === 0) {
            $extensionKey = ucfirst(explode('_', $extensionKey)[0]);
        }

        $this->getFileSystem()->makeDirectory(realpath('../') . '/' . $extensionKey);
    }

    /**
     * @return Filesystem
     */
    public function getFileSystem()
    {
        if (($this->fileSystem instanceof Filesystem) === false) {
            $this->fileSystem = new Filesystem();
        }

        return $this->fileSystem;
    }

}
