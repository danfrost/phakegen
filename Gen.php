<?php
require_once 'lib/Johnny5.php';
class Phake_Script_Gen extends Phake_Script
{
    /**
     * Show help ** This is going to implement "johnny5"
     */
    function index()
    {
        phake('help gen');
    }
    
    function test($pretend=false)
    {   
        Phake_Vars::load();
        
        $source = $GLOBALS['_ENV']['PWD'].'/source/';
        $target = $GLOBALS['_ENV']['PWD'].'/target/';
        $name = 'template';
        
        if($pretend) {
            Johnny5_Generator::$pretend = true;
        }
        
        $j5dir = new Johnny5_Directory($source, $target, $name);
        $j5dir->generate();
        
        Phake_Vars::save();
    }
    
    
}

?>