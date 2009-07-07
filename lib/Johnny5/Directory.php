<?php

class Johnny5_Directory extends Johnny5_Generator
{
    
    private $source;
    private $target;
    
    public function __construct($source, $target)
    {
        $this->source = $source;
        $this->setTarget($target);
    }
    
    private function setTarget($dir)
    {
        // ?? Not sure if capitals is the best way to identify variables. Perhaps a prefix like '@' or '$'
        preg_match_all("_([A-Z]{2,100})_", $dir, $arr);
        
        if($arr[0]) {
            foreach($arr[0] as $var) {
                //echo PHP_EOL . 'Directory '.$dir;
                
                $got_value = false;
        		while($got_value==false) {
        		    $ret = Phake_Vars::get($var);//readline($var);
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
        $this->target = $dir;
    }
    
    public function collectSubItems()
    {
        // 1. create directory if it doesn't exist
        if(!is_dir($this->source)) {
            throw new Exception("Cannot generate from non-existant source: '$this->source'");
        }
        
        // 2. cycle through all file in directory - create Johnny5_File for each. Let them do their stuff.
        foreach (new DirectoryIterator($this->source) as $file) {
            if (!$file->isDot() && !$file->isDir()) {
                //echo "\n!!! Found file: $file";
                //$j5file = 
                $this->addSub(new Johnny5_File((string) $file, $this->source, $this->target));
                //$j5file->generate();
            } else 
            if(!$file->isDot() && $file->isDir()) {
                //$j5dir = 
                $this->addSub(new Johnny5_Directory($this->source . (string) $file . '/', $this->target . (string) $file . '/'));
                //$j5dir->generate();
            }
        }
    }
    
    public function generateItem()
    {
        if(!is_dir($this->source)) {
            throw new Exception("Cannot generate from non-existant source: '$this->source'");
        }
        
        @mkdir($this->target, 0777, true);
        /*
        // 1. create directory if it doesn't exist
        if(!is_dir($this->source)) {
            throw new Exception("Cannot generate from non-existant source: '$this->source'");
        }
        
        @mkdir($this->target, 0777, true);
        
        // 2. cycle through all file in directory - create Johnny5_File for each. Let them do their stuff.
        foreach (new DirectoryIterator($this->source) as $file) {
            if (!$file->isDot() && !$file->isDir()) {
                //echo "\n!!! Found file: $file";
                //$j5file = 
                $this->addSub(new Johnny5_File((string) $file, $this->source, $this->target));
                //$j5file->generate();
            } else 
            if(!$file->isDot() && $file->isDir()) {
                //$j5dir = 
                $this->addSub(new Johnny5_Directory($this->source . (string) $file . '/', $this->target . (string) $file . '/'));
                //$j5dir->generate();
            }
        }*/
    }
}

?>