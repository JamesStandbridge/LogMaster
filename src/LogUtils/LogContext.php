<?php 


namespace LogMaster\LogUtils;

use LogMaster\LogUtils\LogStrategy;

class LogContext {

	private $contextName;
	private $filename;
	private $strategy;

	private $dir_path;

	public function __construct(string $contextName, string $filename, string $dir_path) 
	{
		$this->contextName = $contextName;
		$this->filename = $filename;
		$this->dir_path = $dir_path;
		$this->strategy = new LogStrategy();
	}

	public function getDir() : string
	{
		return $this->dir_path;
	}

	public function getFilename() : string
	{
		return $this->filename;
	}

	public function getContextName() : string 
	{
		return $this->contextName;
	}
}