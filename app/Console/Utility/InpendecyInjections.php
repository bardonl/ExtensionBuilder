<?php
namespace App\Console\Utility;

use Illuminate\Filesystem\Filesystem;
use App\Console\Services\TemplateCopyService;

/**
 * Class GetIlluminateFunctions
 * @package App\Console\Utility
 *
 */
class InpendecyInjections
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
     * @var TemplateCopyService
     */
    protected $templateCopyService;
    
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
}