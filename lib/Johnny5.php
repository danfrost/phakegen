<?php

require_once 'Johnny5/Generator.php';
require_once 'Johnny5/File.php';
require_once 'Johnny5/Directory.php';
require_once 'Johnny5/ContentParser.php';
require_once 'Johnny5/InputValue.php';

class Johnny5
{
    
    private $source;
    private $target;
    
    public function __construct($source, $target, $name)
    {
        $this->source = $source;
        $this->target = $target;
        $this->name   = $name;
    }
    
    public function generate()
    {
        
    }
}

?>