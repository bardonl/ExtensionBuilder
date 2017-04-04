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
    public function buildFolderStructure($config)
    {

        $this->getFileSystem()->makeDirectory(realpath('../') . '/' . $config['path'], 755, true);
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
