<?php
namespace App\Console\Factory;

use App\Console\Traits\DependencyInjectionManagerTrait;

/**
 * build controller factory
 *
 * @package ExtensionBuilder\Console\Factory
 */
class BuildFileFactory
{
    use DependencyInjectionManagerTrait;
    
    /**
     * @param array $config
     * @param bool $newExt
     * @return string
     */
    public function handle(array $config, $newExt)
    {

        $config['rootDirectory'] = ROOT_DIRECTORY . '/' . $config['extensionKey'];

        if ($newExt) {

            $this->dependencyInjectionManager()->getTemplateCopyService()->replaceDummyContent($config);
        } else {
            
            try{
                
                $this->checkFolder($config);
                $this->dependencyInjectionManager()->getTemplateCopyService()->replaceDummyContent($config);
            } catch (\Exception $e) {

                // @todo exception (call base command)
                return 'Caught exception: ' . $e->getMessage() . "\n";
            }
        }
    }
    
    /**
     * @param $config
     * @return bool
     * @throws \Exception
     */
    function checkFolder($config) {
        if (!$this->dependencyInjectionManager()->getFileSystem()->isDirectory( $config['rootDirectory'])) {
            throw new \Exception("Folder doesn't exist");
        }
        return true;
    }
    
}