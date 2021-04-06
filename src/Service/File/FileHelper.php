<?php 

namespace LogMaster\Service\File;

class FileHelper {

	public static function WRITE_LINE(string $path, string $line) 
	{
        $fp = fopen($path, 'a+');
        fwrite($fp, $line.PHP_EOL);
        fclose($fp);
	}
}