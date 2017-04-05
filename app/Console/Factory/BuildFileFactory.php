<?php
namespace App\Console\Factory;

use App\Console\Traits\DependencyInjectionManagerTrait;
use Mockery\CountValidator\Exception;

/**
 * build controller factory
 *
 * @package ExtensionBuilder\Console\Factory
 */
class BuildFileFactory
{
    
    use DependencyInjectionManagerTrait;

    /**
     * @var string
     */
    protected $extensionKey;
    
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
                
                $this->checkFile($config);
                $this->dependencyInjectionManager()->getTemplateCopyService()->replaceDummyContent($config);
            } catch (Exception $e) {

                // @todo exception (call base command)
                return 'Caught exception: ' . $e->getMessage() . "\n";
            }
        }
    }
    
    /**
     * @param array $config
     * @return bool
     */
    function checkFile($config) {
        if(!$this->dependencyInjectionManager()->getFileSystem()->exists( $config['rootDirectory'])) {
            throw new Exception("Folder doesn't exist");
        }
        return true;
    }
    
}