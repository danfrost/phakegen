<?php

class Johnny5_File extends Johnny5_Generator
{
    function collectSubItems() {
        
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
    
    function generateItem()
    {
        $this->source = f($this->source);
        $this->target = f($this->target);
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