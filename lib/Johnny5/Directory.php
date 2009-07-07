<?php

class Johnny5_Directory extends Johnny5_Generator
{
    public function collectSubItems()
    {
        // 1. create directory if it doesn't exist
        if(!is_dir($this->source)) {
            throw new Exception("Cannot generate from non-existant source: '$this->source'");
        }
        
        // 2. cycle through all file in directory - create Johnny5_File for each. Let them do their stuff.
        foreach (new DirectoryIterator($this->source) as $file) {
            if (!$file->isDot() && !$file->isDir()) {
                $this->addSub(new Johnny5_File($this->source, $this->target, (string) $file));
            } else 
            if(!$file->isDot() && $file->isDir()) {
                $this->addSub(new Johnny5_Directory($this->source, $this->target, (string) $file));
            }
        }
    }
    
    public function generateItem()
    {
        if(!is_dir($this->source)) {
            throw new Exception("Cannot generate from non-existant source: '$this->source'");
        }
        
        echo PHP_EOL ."Making: $this->target";
        @mkdir($this->target, 0777, true);
    }
}

?>