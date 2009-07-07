<?php

class Johnny5_ContentParser {
	
	private $___file;
	private $___output;
	
	/**
	 * $file to be parsed
	 */
	function __construct($file) {
		$this->___file = $file;
	}
	
	/**
	 * Returns the parsed content
	 */
	function get() {	
		$this->___output = '';
		
		$this->ob_start();
		// TODO: We should parse this file to make sure it doesn't do very much.
		require $this->___file->getFullPath();
		
		//$this->___output .= ob_get_clean();
		$this->ob_pause();
		
		$this->___output = str_replace('&lt;?php', '<?php', $this->___output);
		$this->___output = str_replace('?&gt;', '?>', $this->___output);
		
		return $this->___output;
	}
	
	/**
	 * \brief	Used for string variables
	 */
	function __get($var) {
		$this->ob_pause();
		//$ret = J5_Input::get($var);
		$got_value = false;
		while($got_value==false) {
		    $ret = Phake_Vars::get($var);//readline($var);
		    if(trim($ret)!='?') {
			    $got_value=true;
			    $value = new Johnny5_InputValue($var, $ret);
		    } else {
		        //echo "\nNo help support written yet...";
		        $bt = debug_backtrace();
				$bt = $bt[0];
				
				$file = $bt['file'];
				$line = $bt['line'];
				
				$php = $this->___file->contents($file);
				$x = explode("\n", $php);
				
				$varloc = '$this->'.$var;
				$extract_line = $x[($line-1)];
				$extract_line = str_replace("\t", '    ', $extract_line);
				$strpos = strpos($extract_line, $varloc);
				$prefix = "  EXTRACT:  ";
				
				echo "\n".$prefix.'Here\'s some help:';
				echo "\n".$prefix.$x[($line-2)];
				echo "\n".$prefix.$extract_line;
				echo "\n".str_repeat(' ', (strlen($prefix))).str_repeat(' ',$strpos).str_repeat('^',strlen($varloc))."\n";
		    }
		}
		
		$this->ob_start();
		return $value;
	}
	
	function ob_start() {
		ob_start();
	}
	
	function ob_pause() {
		$this->___output .= ob_get_clean();
	}
	
	/**
	 * 
	 */
	function __call($func, $opts) {
	    throw new Exception("__call unsupported");
	    
		$this->ob_pause();
		
		$str = "$func (".implode(', ', $opts).")";
		//$ret = J5_Input::get($func, $str);
		$got_value = false;
		while($got_value==false) {
			try {
				$ret = J5_Input::get($func, $str);
				$got_value=true;
			} catch(J5_Input_HelpException $e) {
				//echo "\nHELP: Trying to get value ==== $func";
				$bt = debug_backtrace();
				//print_r($bt);die();
				$bt = $bt[1];
				
				$file = $bt['file'];
				$line = $bt['line'];
				
				$php = file_get_contents($file);
				$x = explode("\n", $php);
				
				$varloc = '$this->'.$func;
				//$strpos = strpos($x[($line-1)], $varloc);
				$extract_line = $x[($line-1)];
				$extract_line = str_replace("\t", '    ', $extract_line);
				$strpos = strpos($extract_line, $varloc);
				$prefix = "  EXTRACT:  ";
				
				echo "\n".$prefix.'Here\'s some help:';
				echo "\n".$prefix.$x[($line-2)];
				echo "\n".$prefix.$extract_line;
				echo "\n".str_repeat(' ', (strlen($prefix))).str_repeat(' ',($strpos+3)).str_repeat('^',strlen($varloc))."\n";
			}
		}
		
		$this->ob_start();
		return $ret;
	}
}

?>