<?php
namespace ExtensionBuilder\Console\Services;

use Illuminate\Filesystem\Filesystem;

/**
 * Class FileGenerator
 * @package ExtensionBuilder\Console\Services
 */
class FileGenerator
{
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    public static function createRootDirectory($type, $extensionKey)
    {
        //$type is a value indicating a configuration template or a normal extension
        // 0 = configuration template
        // 1 = normal extension
        
        switch($type){
            case 0:
                
                $extensionName = ucfirst(explode('_', $extensionKey)[0]);
                self::getFileSystem()->makeDirectory(realpath('../../') . '/' . $extensionName);
                
                break;
            case 1:
                
                self::getFileSystem()->makeDirectory(realpath('../../') . '/' . $extensionKey);
                
                break;
                
        }
    }

    /**
     * @return Filesystem
     */
    public function getFileSystem()
    {
       if (($this->fileSystem instanceof Filesystem) === null) {
           $this->fileSystem = new Filesystem();
       }

        return $this->fileSystem;
    }

}
