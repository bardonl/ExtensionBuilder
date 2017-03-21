<?php
namespace App\Console\Factory;

use Illuminate\Filesystem\Filesystem;
use App\Console\Utility\FileReplaceUtility;

/**
 * build controller factory
 *
 * @package ExtensionBuilder\Console\Factory
 * @author Rick in 't Veld <intveld@redkiwi.nl>, Redkiwi
 */
class BuildControllerFactory
{

    /**
     * The file system
     *
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var FileReplaceUtility
     */
    protected $fileReplaceUtility;

    /**
     * @var string
     */
    protected $extensionKey;

    /**
     * @param string $extensionKey
     * @param array $controllers
     */
    public function handle($extensionKey, array $controllers)
    {
        $this->extensionKey = $extensionKey;

        foreach ($controllers as $controller) {
            // make a copy of the controller template and replace the values with the new controller name and namespace
            $this->getFileReplaceUtility()->findAndReplace(
                'Target path',
                [
                    'find' => 'replacement',
                    'find2' => 'replacement2'
                ]
            );
        }
    }

    protected function buildTemplateFolder($controller)
    {
        $this->getFileSystem()->makeDirectory($this->extensionKey . '/Resources/Private/Template/' . $controller);
    }

    protected function buildControllerFolder()
    {
        $this->getFileSystem()->makeDirectory($this->extensionKey . '/Classes/Controller');
    }

    protected function buildController()
    {
        $newPath = $this->extensionKey . '/Classes/Controller';
        $this->getFileSystem()->copy($newPath, 'Controller template');
    }

    /**
     * @return Filesystem
     */
    protected function getFileSystem()
    {
        if (($this->fileSystem instanceof Filesystem) === false) {
            $this->fileSystem = new Filesystem();
        }

        return $this->fileSystem;
    }

    /**
     * @return FileReplaceUtility
     */
    protected function getFileReplaceUtility()
    {
        if (($this->fileReplaceUtility instanceof FileReplaceUtility) === false ) {
            $this->fileReplaceUtility = new FileReplaceUtility();
        }

        return $this->fileReplaceUtility;
    }
}