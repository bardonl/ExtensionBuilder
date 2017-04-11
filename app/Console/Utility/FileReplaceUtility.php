<?php
namespace App\Console\Utility;

use App\Console\Traits\DependencyInjectionManagerTrait;

/**
 * file replace utility
 *
 * @package App\Console\Utility
 */
class FileReplaceUtility
{
    use DependencyInjectionManagerTrait;

    /**
     * @param string $file
     * @param array $replacements
     */
    public function findAndReplace($file, array $replacements)
    {
        if ($this->dependencyInjectionManager()->getFileSystem()->exists($file)) {

            $file_contents = $this->dependencyInjectionManager()->getFileSystem()->get($file);

            foreach ($replacements as $find => $replacement) {

                $file_contents = str_replace($find, $replacement, $file_contents);
            }

            $this->dependencyInjectionManager()->getFileSystem()->put(
                $file,
                $file_contents
            );
        }
    }
}