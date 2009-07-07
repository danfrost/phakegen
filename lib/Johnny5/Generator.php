<?php

/**
 * 
 
 Generate is a recursive, nested object for generating files / directories and collecting
 sub-generators.
 
 Any generator can contain generators within itself. These must be found in collectSubItems();
 and added via $this->addSub($item);
 
 Sub-items are collected on instantiation.
 
 On construct, we just set the source and target as raw
 
 */
abstract class Johnny5_Generator
{
    
    static $pretend = false;
    
    private $subObjects = array();
    
    private $hasCollectedSubItems   = false;
    
    protected $source_raw   = null;
    protected $target_raw   = null;
    
    protected $source   = null;
    protected $target   = null;
    
    /**
     */
    function __construct($source, $target, $name=null){
        //echo PHP_EOL . "s/t = $source | $target | $name ";
        if(trim($name)) {
            $this->source   = $source . '/' . $name;
            $this->target   = $target . '/' . $name;
            $this->name     = $name;
        } else {
            $this->source   = $source;
            $this->target   = $target;
        }
        $this->collectSubItems();
    }
    
    /**
     * Find variable parts of the path. This is only run when we start the generating.
     */
    private function parseTargetForVariables($dir)
    {
        // ?? Not sure if capitals is the best way to identify variables. Perhaps a prefix like '@' or '$'
        preg_match_all("_([A-Z0-9]{2,100})_", $dir, $arr);
        
        $reservedVars = array(
            'README', 'INSTALL', 'CHANGELOG'
            );
        
        if($arr[0]) {
            foreach($arr[0] as $var) {
                if(!in_array($var, $reservedVars)) {
                    echo PHP_EOL . 'File '.$dir;
                
                    $got_value = false;
            		while($got_value==false) {
            		    $ret = Phake_Vars::get(strtolower($var));
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
        }
        return $dir;
    }
    
    final function addSub(Johnny5_Generator & $gen)
    {
        $this->subObjects[] = $gen;
    }
    
    final function __toString()
    {
        $type = (str_replace('Johnny5_', '', get_class($this))=='File') ? 'f' : 'd';
        if($type=='d') {
            $sub = count($this->subObjects);
            $sub = " [contains $sub objects]";
            $trail = '/';
        } else {
            $sub = "";
            $trail = '';
        }
        $base = red(basename($this->source));
        return "$base$trail $sub";
    }
    
    final function generate()
    {
        Johnny5_Generator::up();
        
        if(Johnny5_Generator::$pretend) {
            echo PHP_EOL . '    '.(str_repeat('    ', Johnny5_Generator::depth()-1)) . 
                (count($this->subObjects)>0 ? '\\   ' : '|   ') . (string) $this;    
        } else {
            $this->target = $this->parseTargetForVariables($this->target);
            $this->generateItem();
            //echo " - generated";
        }
        
        foreach($this->subObjects as $k=>$_) {
            $this->subObjects[$k]->generate();
        }
        
        Johnny5_Generator::down();
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