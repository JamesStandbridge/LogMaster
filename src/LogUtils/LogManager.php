<?php 


namespace LogMaster\LogUtils;

use LogMaster\LogUtils\LogContext;
use LogMaster\Service\FileHelper;

class LogManager {

	private $contexts;

	public function __construct() 
	{
		$this->contexts = [];
	}

	/**
	 * Add new context into LogManager
	 * @param  string $contextName 
	 * @param  string $filename    
	 * @param  string $dir_path   
	 * @return self
	 */
	public function new(string $contextName, string $filename, string $dir_path) : self
	{
		if($this->getContext($contextName) != null) {
			throw new \LogicException(sprintf("This context %s already exist", $contextName));
		}

		$context = new LogContext($contextName, $filename);
		$context->set_dir($dir_path);
		$this->addContext($context);

		return $this;
	}

	/**
	 * write a new log entry into context file selected
	 * @param  string      $contextName 
	 * @param  string      $message     
	 * @param  int|integer $severity    
	 * @return self          
	 * 
	 * @throws LogicException if unknow context       
	 */
	public function write_log(string $contextName, string $message, int $severity = 1) : self
	{
		$context = $this->getContext($contextName);

		if($context == null) {
			throw new \LogicException(sprintf('unknow context %s', $contextName));
		}

		FileHelper::WRITE_LINE(
			$context->getDir().$context->getFilename(),
			$message
		);

		return $this;	
	}


	private function getContext(string $contextName) : ?LogContext 
	{
		foreach($this->contexts as $index => $context) {
			if($context->getName() === $contextName) {
				return $context;
			}	
		}		

		return null;
	}

	private function addContext(LogContext $context) : self
	{
		$this->contexts[] = $context;
		
		return $this;
	}
}