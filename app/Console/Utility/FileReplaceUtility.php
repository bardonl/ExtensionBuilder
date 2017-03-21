<?php
namespace App\Console\Utility;

use Illuminate\Filesystem\Filesystem;

/**
 * file replace utility
 *
 * @package App\Console\Utility
 * @author Rick in 't Veld <intveld@redkiwi.nl>, Redkiwi
 */
class FileReplaceUtility
{
    /**
     * @var FileSystem
     */
    protected $fileSystem;

    /**
     * @param string $file
     * @param array $replacements
     */
    public function findAndReplace($file, array $replacements)
    {
        if ($this->getFileSystem()->exists($file)) {

            $file_contents = $this->getFileSystem()->get($file);

            foreach ($replacements as $find => $replacement) {

                $file_contents = str_replace($find, $replacement, $file_contents);
            }

            $this->getFileSystem()->put(
                $file,
                $file_contents
            );
        }
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