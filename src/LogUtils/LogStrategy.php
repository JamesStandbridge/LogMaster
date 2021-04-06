<?php 


namespace LogMaster\LogUtils;



class LogStrategy {

	private $fileLifeTime;
	private $fileWriteLifeTime;
	private $directionMaxSize;

	public function __construct() {
		$this->fileLifeTime = null;
		$this->fileWriteLifeTime = null;
		$this->directionMaxSize = null;
	}

	public function setFileLifeTime(int $maxDay) : self
	{
		$this->fileLifeTime = $maxDay;

		return $this;
	}

	public function setFileWriteLifeTime(int $maxDay) : self
	{
		$this->fileWriteLifeTime = $maxDay;

		return $this;
	}

	public function setDirectoryMaxSize(int $max) : self
	{
		$this->directionMaxSize = $max;

		return $this;
	}

	public function getFileLifeTime() : int 
	{
		return $this->fileLifeTime;
	}

	public function getFileWriteLifeTime() : int
	{
		return $this->fileWriteLifeTime;
	}

	public function getDirectoryMaxSize() : int 
	{
		return $this->directionMaxSize;
	}
}