<?php

class Johnny5_File
{
    private $source   = null;
    private $target   = null;
    
    function __construct($file, $source, $target)
    {
        $this->source = f($source . $file);
        $this->target = f($target . $file);
        $this->target->touch();
    }
    
    function generate()
    {
        $this->copyToTarget();
        $this->parse();
    }
    
    function copyToTarget()
    {
        $this->target->setcontent($this->source->contents());
    }
    
    function parse()
    {
        $parser = new Johnny5_ContentParser($this->target);
        $this->target->setcontent($parser->get());
    }
}

?>