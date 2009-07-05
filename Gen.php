<?php
require_once 'lib/Johnny5.php';
class Phake_Script_Gen extends Phake_Script
{
    /**
     * Show help ** This is going to implement "johnny5"
     */
    function index()
    {
        phake('help gen');
    }
    
    function test()
    {   
        Phake_Vars::load();
        
        //echo Phake_Vars::get('testvar');
        
        //echo Phake_Vars::get('anothervar');
        
        $j5file = new Johnny5_File('testfile', $GLOBALS['_ENV']['PWD'].'/source/', $GLOBALS['_ENV']['PWD'].'/target/');
        $j5file->generate();
        
        Phake_Vars::save();
        /*
        if ($db = new SQLiteDatabase('filename')) {
            $q = @$db->query('SELECT requests FROM tablename WHERE id = 1');
            if ($q === false) {
                $db->queryExec('CREATE TABLE tablename (id int, requests int, PRIMARY KEY (id)); INSERT INTO tablename VALUES (1,1)');
                $hits = 1;
            } else {
                $result = $q->fetchSingle();
                $hits = $result+1;
            }
            $db->queryExec("UPDATE tablename SET requests = '$hits' WHERE id = 1");
        } else {
            die($err);
        }
        echo $db->queryExec("SELECT * from tablename");
        */
    }
    
    
}

?>