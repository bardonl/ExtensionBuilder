<?php

namespace extension_builder\Http\Controllers;

use Illuminate\Filesystem\Filesystem;

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

        // @todo switch van maken
        if ($type == 0) {
            //If the extension is a configuration, everything after the underscore (_) will be removed
            //The first letter is changed to uppercase
            $extensionName = ucfirst(explode('_', $extensionKey)[0]);
            //This will call the function to create the root directory of the extension
            self::getFileSystem()->makeDirectory(realpath('../../') . '/' . $extensionName);
        }

        if ($type == 1) {
            //This will call the function to create the root directory of the extension
            self::getFileSystem()->makeDirectory(realpath('../../') . '/' . $extensionKey);
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
