<?php 


namespace LogMaster\LogUtils;

use LogMaster\LogUtils\LogStrategy;
use LogMaster\Service\File\FileHelper;


class LogContext {

	private $contextName;
	private $filenameBuilder;
	private $strategy;

	private $dir_path;

	public function __construct(string $contextName, array $filenameBuilder = [], string $dir_path, LogStrategy $strategy) 
	{
		$this->contextName = $contextName;
		$this->filenameBuilder = $filenameBuilder;
		$this->dir_path = $dir_path;
		$this->strategy = $strategy;
	}

	public function scan() {}

	public function getDir() : string
	{
		return $this->dir_path;
	}

	public function getFilename() : string
	{
		$name = "";
		foreach($this->filenameBuilder as $field) {
			switch($field["type"]) {
				case "text":
					$name .= $field["value"];
					break;
				case "date":
					$name .= (new \DateTime())->format('Y-m-d');
					break;
				case "time":
					$name .= (new \DateTime())->format('H:i:s');
					break;	
				case "dateTime":
					$name .= (new \DateTime())->format('Y-m-d H:i:s');
					break;		
				default:
					throw new \LogicException(sprintf("invalid namebuilder field %s inside context %s"), $field['type'], $this->getContextName());	
			}
		}
		return $name;
	}

	public function getContextName() : string 
	{
		return $this->contextName;
	}

	public function writeLog(string $message, string $log_dir_name)
	{
		$dir = $log_dir_name."/".$this->getDir();
		FileHelper::INIT_DIR($dir);
		
		$filepath = $this->getFilepath($dir);
		if($filepath == null) {
			$filepath = $dir."/".$this->getFilename().".txt";
		}

		FileHelper::WRITE_LINE(
			$filepath,
			(new \DateTime())->format('Y-m-d H:i:s').' '.$_SERVER['PHP_SELF'].' '.$message
		);
	}

	private function getFilepath(string $dir_path) {
		$latestFile = $this->getLastLogFile($dir_path);
		if($latestFile != null) {
			$timestamp = filemtime($dir_path);

			$interval = date_diff((new \DateTime())->setTimestamp($timestamp), new \DateTime());
			if($interval->d > $this->strategy->getFileWriteLifeTime()) { 
				return null;
			}
			else {
				return $latestFile;	
			}

		} else {
			return null;
		}
	}

	private function getLastLogFile(string $dir_path)
	{
		return FileHelper::GET_NEWEST_FILE($dir_path);
	}
}