<?php
namespace App\Console\Services;

use Illuminate\Filesystem\Filesystem;

/**
 * Class FileGeneratorService
 * @package ExtensionBuilder\Console\Services
 */
class FileGeneratorService
{
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @param int $type
     * @param string $extensionKey
     */
    public function createRootDirectory($type, $extensionKey)
    {
        if ($type === 0) {
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
