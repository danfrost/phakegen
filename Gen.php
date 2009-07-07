<?php
require_once 'lib/Johnny5.php';
class Phake_Script_Gen extends Phake_Script
{
    /**
     * Show help ** This is going to implement "johnny5"
     */
    function index($template, $target, $pretend=false)
    {
        if(!trim($template)) {
            phake('help gen');
        } else {
            Phake_Vars::load();
            
            $templateDir = dirname(__FILE__). '/templates/';

            $source = $templateDir."/$template/";
            $target = substr($target, 0, 1)=='/' ? $target : $GLOBALS['_ENV']['PWD'].'/'.$target;
            
            echo "\nSource : $source\nTarget : $target\nName : $name\n";
            
            if($pretend) {
                Johnny5_Generator::$pretend = true;
            }
            
            $j5dir = new Johnny5_Directory($source, $target);//, $name);
            $j5dir->generate();
            
            Phake_Vars::save();
        }
    }
    
    /**
     * Show all install templates
     */
    function show()
    {
        echo PHP_EOL . 'Known templates' . PHP_EOL;
        $templateDir = dirname(__FILE__). '/templates/';
        foreach (new DirectoryIterator($templateDir) as $file) {
            if (!$file->isDot() && $file->isDir()) {
                echo PHP_EOL . "  - $file";
            }
        }
        echo PHP_EOL;
    }
    
    /**
     * Show all the files in a give template
     */
    function inspect($template)
    {
        if(!$template) {
            phake('gen show');
            return;
        }
        
        echo PHP_EOL . 'Files in template "'.$template.'"';
        
        $templateDir = dirname(__FILE__). '/templates/';

        $source = $templateDir."/$template/";
        $target = '.'; // Doesn't matter as we're in pretend mode
        
        Johnny5_Generator::$pretend = true;
        
        $j5dir = new Johnny5_Directory($source, $target);//, $name);
        $j5dir->generate();
        
    }
}

?>