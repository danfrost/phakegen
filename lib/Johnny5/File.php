<?php

class Johnny5_File
{
    private $source   = null;
    private $target   = null;
    
    function __construct($file, $source, $target)
    {
        echo PHP_EOL . "Generating '$source$file' => '$target$file'";
        $this->source = f($source . $file);
        //$this->target = f($target . $file);
        $this->setTarget($target . $file);
        $this->target->touch();
    }
    
    private function setTarget($dir)
    {
        // ?? Not sure if capitals is the best way to identify variables. Perhaps a prefix like '@' or '$'
        preg_match_all("_([A-Z]{2,100})_", $dir, $arr);
        
        if($arr[0]) {
            foreach($arr[0] as $var) {
                echo PHP_EOL . 'File '.$dir;
                
                $got_value = false;
        		while($got_value==false) {
        		    $ret = Phake_Vars::get($var);
        		    if(trim($ret)!='?') {
        			    $got_value=true;
        			    $value = new Johnny5_InputValue($var, $ret);
        		    } else {
        		        echo "Dir.";
        		    }
        		}
        		
        		$dir = str_replace($var, $value, $dir);
            }
        }
        $this->target = f($dir);
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