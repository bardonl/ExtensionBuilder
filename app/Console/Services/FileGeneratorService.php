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

    /**
     * @param array $config
     */
    public function createExtensionStructure(array $config)
    {

        $this->createRootDirectory($config);
        $this->getFileSystem()->makeDirectory(ROOT_DIRECTORY . $config['extensionKey'] . '/Classes/Controller');

    }

    /**
     * @param array $config
     */
    public function createRootDirectory(array $config)
    {

        $this->getFileSystem()->makeDirectory(realpath('../') . '/' . $config['extensionKey']);
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
    
    /**
     * @param array $config
     */
    public function buildFolderStructure($config)
    {

        $this->getFileSystem()->makeDirectory(realpath('../') . '/' . $config['extensionKey'] .'/' . $config['path'], 755, true);
        
    }
}
