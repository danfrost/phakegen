<?php

/**
 * Whenever a user inputs a string, it is stored in "Johnny5_InputValue" so it can be 
 * transformed into a variable as required.
 */
class Johnny5_InputValue
{
    private $name;
	private $value;
	
	function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}
	
	function __toString()
	{
		return $this->asVariable();//'___'.$this->name.'___';//
	}
	
	/**
	 * Returns variable value as a variable name. Usage in template is via $this->__toString()
	 */
	function asVariable()
	{
		$len = strlen($this->value);
		$value = '';
		for ($i=0; $i < $len; $i++) { 
			//
			$ch = ($this->value{$i});
			//echo "\n>$ch.";
			if($ch==' ') {
				$capNext = true;
			} else {
				if($capNext) {
					$value .= strtoupper($this->value{$i}); 
				} else {
					$value .= $this->value{$i};
				}
				$capNext = false;
			}
		}
		
		$v = str_replace(array(
			' ', '-', ',', '.'
			), '', $value);
        
		return $v;
	}
}


?>