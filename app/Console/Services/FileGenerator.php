<?php

namespace extension_builder\Http\Controllers;

use Illuminate\Http\Request;

class FileGenerator extends Controller
{

    public function __construct()
    {

    }

    public static function createRootDirectory($type, $extensionKey){
        //$type is a value indicating a configuration template or a normal extension
        // 0 = configuration template
        // 1 = normal extension
        if($type == 0){
            //If the extension is a configuration, everything after the underscore (_) will be removed
            //The first letter is changed to uppercase
            $extensionName = ucfirst(explode('_',$extensionKey)[0]);
            //This will call the function to create the root directory of the extension
            self::makeDir($extensionName);
        }
        if($type == 1){
            //This will call the function to create the root directory of the extension
            self::makeDir($extensionKey);
        }
    }

    public function makeDir($extensionName){
        if(!mkdir("../../".$extensionName)){
            return "There was an error!";
        }
    }
}
