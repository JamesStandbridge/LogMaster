<?php
namespace App\Models;


class LogsManager
{
   

    function error_log($msg)
    {  date_default_timezone_set('Europe/Paris');
        $fp = fopen(LOG_FILE, 'a+');
        fwrite($fp, (new \DateTime())->format('Y-m-d H:i:s').' '.$_SERVER['PHP_SELF'].' '.$msg.PHP_EOL);
        fclose($fp);
       
        
    }  
    function success_log($msg)
    {
        date_default_timezone_set('Europe/Paris'); 
        $fp = fopen(LOG_FILE, 'a+');
        fwrite($fp,(new \DateTime())->format('Y-m-d H:i:s').' '.$_SERVER['PHP_SELF'].' '.$msg.PHP_EOL);
        fclose($fp);
       
        
    }  
}