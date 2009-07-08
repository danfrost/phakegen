&lt;?php

class Phake_Script_<?= $this->scriptname ?> extends Phake_Script
{
    
    /**
     * Show help message
     */
    function index()
    {
        phake('help <?= strtolower($this->scriptname); ?>');
    }
    
    function example()
    {
        echo PHP_EOL . 'This is a simple phake script - <?= $this->scriptname ?>' . PHP_EOL;
    }
}

?&gt;