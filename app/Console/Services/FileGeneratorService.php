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
     * @param $config
     * @param $extensionKey
     */
    public function createExtensionStructure(array $config)
    {

        $this->createRootDirectory($config);
        $this->getFileSystem()->makeDirectory(ROOT_DIRECTORY . $config['extensionKey'] . '/Classes/Controller');

    }

    /**
     * @param int $config
     * @param string $extensionKey
     */
    public function createRootDirectory(array $config)
    {
        if ($config === 0) {
            $config['extensionKey'] = ucfirst(explode('_', $config['extensionKey'])[0]);
        }

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
    
    public function buildFolderStructure($config)
    {
        $folders = explode('/', $config['path']);

        $this->getFileSystem()->makeDirectory(realpath('../') . '/' . $config['extensionKey'] . '/' . $folders[0]);
        $this->getFileSystem()->makeDirectory(realpath('../') . '/' . $config['extensionKey'] .'/' . $folders[0] . '/' . $folders[1]);
        
    }
}
