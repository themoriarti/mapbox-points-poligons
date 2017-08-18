<?php
/**
 * (C) Moriarti Engine
 *
 * @author Moriarti <mor.moriarti@gmail.com>
 */
define('CD',dirname(__FILE__)."/");
    function __autoload($nameClass){
        if(($expression=!class_exists($nameClass)&&file_exists($classFile=CD.$nameClass.'.php'))||preg_match('/^(ControllerBase|ModelBase|ViewBase)$/',$nameClass,$matches)) {
            require_once $classFile;
        }elseif(preg_match('/^(Controller|Model|View)([a-z_-]{1,64})$/i',$nameClass,$matches)) {
            $classFile=realpath(CD.'/../'.strtolower($matches[1]).'s').'/'.$nameClass.'.php';
            if(is_readable($classFile)&&file_exists($classFile)) {
                include_once $classFile;
                if(!class_exists($nameClass)){
                    //eval('class '.$nameClass.' extends Exception {}');
                    //throw new $nameClass('[__autoload] File and class dont same! File#'.$classFile);
                    die('[__autoload] File and class dont same! File#'.$classFile);
                }
            }else{
                //eval('class '.$nameClass.' extends Exception {}');
                //throw new $nameClass('[__autoload] '.$matches[1].' not found or dont read! File#'.$classFile);
                die('[__autoload] '.$matches[1].' not found or dont read! File#'.$classFile);
            }
        }elseif(!$expression) {
            // Autoloading vendor lib.
            $classFile=realpath(CD.'/../vendor/'.$nameClass.'/'.$nameClass.'.php');
            include_once $classFile;
            if(!class_exists($nameClass)){
                die('[__autoload] File and class dont same! File#'.$classFile);
            }
            //die('[__autoload] File doesn\'t exists. File#'.$classFile);
        }
    }
