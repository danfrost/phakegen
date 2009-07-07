<?php

abstract class Johnny5_Generator
{
    
    private $subObjects = array();
    
    private $hasCollectedSubItems   = false;
    
    final function addSub(Johnny5_Generator & $gen)
    {
        $this->subObjects[] = $gen;
    }
    
    final function preGenerate()
    {
        if(!$this->hasCollectedSubItems) {
            $this->collectSubItems();
            $this->hasCollectedSubItems = true;
        }
        
        Johnny5_Generator::up();
        echo PHP_EOL . '  Queue '.get_class($this);
        foreach($this->subObjects as $k=>$_) {
            $this->subObjects[$k]->preGenerate();
        }
        Johnny5_Generator::down();
    }
    
    final function generate()
    {
        if(!$this->hasCollectedSubItems) {
            $this->collectSubItems();
            $this->hasCollectedSubItems = true;
        }
        
        echo PHP_EOL . '';
        $this->generateItem();
        foreach($this->subObjects as $k=>$_) {
            $this->subObjects[$k]->generate();
        }
    }
    
    /**
     * Must implement whatever generation tasks that '$this' object requires
     */
    abstract function generateItem();
    
    /**
     * Must implement any collecting sub-item - e.g. files inside a directory
     */
    abstract function collectSubItems();
    
    
    static  $genDepth = 0;
    
    static function up()
    {
        self::$genDepth++;
    }
    
    static function down()
    {
        self::$genDepth--;
    }
    
    static function depth()
    {
        return self::$genDepth;
    }
    
}