<?php
namespace App\Console\Utility;

use Illuminate\Console\Command;
use App\Console\Factory\BuildControllerFactory;
use Illuminate\Filesystem\Filesystem;
use App\Console\Utility\FileReplaceUtility;
use App\Console\Services\TemplateCopyService;

class GetIlluminateFunctions
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
    protected $templatecopyservice;
    
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
        if (($this->templatecopyservice instanceof TemplateCopyService) === false ) {
            $this->templatecopyservice = new TemplateCopyService();
        }
        
        return $this->templatecopyservice;
    }
}