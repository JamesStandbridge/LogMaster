<?php 

namespace LogMaster\Service\File;

class FileHelper {

	public static function WRITE_LINE(string $path, string $line) 
	{
        $fp = fopen($path, 'a+');
        fwrite($fp, $line.PHP_EOL);
        fclose($fp);
	}

	public static function INIT_DIR(string $path)
	{
		if (!is_dir($path)) {
		    mkdir($path, 0777, true);
		}		
	}

	public function GET_NEWEST_FILE(string $path) {
		
	    $last_modified_time = 0;
	    $last_modified_file = null;

	    $dirmtime = filemtime ($path);
	    foreach (glob("$path/*") as $file)
	    {
	        if (is_file ($file)) {
	            $filemtime = filemtime ($file);
	            $max = max($filemtime, $dirmtime, $last_modified_time);
	            if($max !== $last_modified_time) {
	            	$last_modified_time = $max;
	            	$last_modified_file = $file;
	            }
	        } 
	    }
    	return $last_modified_file;
	} 
}