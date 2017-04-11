<?php
namespace App\Console\Utility;

use Illuminate\Filesystem\Filesystem;
use App\Console\Services\TemplateCopyService;
use App\Console\Services\FileGeneratorService;
use App\Console\Factory\BuildFileFactory;

/**
 * Class GetIlluminateFunctions
 * 
 * @package App\Console\Utility
 */
class DependencyInjectionManager
{
    
    /**
     * @var Filesystem
     */
    protected $fileSystem;
    
    /**
     * @var FileReplaceUtility
     */
    protected $fileReplaceUtility;
    
    /**
     * @var TemplateCopyService
     */
    protected $templateCopyService;
    
    /**
     * @var FileGeneratorService
     */
    protected $fileGeneratorService;

    /**
     * @var BuildFileFactory
     */
    protected $fileFactory;
    
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
    
    /**
     * @return FileReplaceUtility
     */
    public function getFileReplaceUtility()
    {
        if (($this->fileReplaceUtility instanceof FileReplaceUtility) === false ) {
            $this->fileReplaceUtility = new FileReplaceUtility();
        }
        
        return $this->fileReplaceUtility;
    }
    
    /**
     * @return TemplateCopyService
     */
    public function getTemplateCopyService()
    {
        if (($this->templateCopyService instanceof TemplateCopyService) === false ) {
            $this->templateCopyService = new TemplateCopyService();
        }
        
        return $this->templateCopyService;
    }
    
    /**
     * @return FileGeneratorService
     */
    public function getFileGeneratorService()
    {
        if (($this->fileGeneratorService instanceof FileGeneratorService) === false) {
            
            $this->fileGeneratorService = new FileGeneratorService();
            
        }
        
        return $this->fileGeneratorService;
    }

    /**
     * @return BuildFileFactory
     */
    public function getBuildFileFactory()
    {
        if (($this->fileFactory instanceof BuildFileFactory) === false) {

            $this->fileFactory = new BuildFileFactory();
        }

        return $this->fileFactory;
    }
}