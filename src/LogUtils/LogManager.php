<?php 


namespace LogMaster\LogUtils;

use LogMaster\LogUtils\LogContext;
use LogMaster\LogUtils\LogStrategy;
use LogMaster\Service\FileHelper;

class LogManager {

	private $contexts;
	private $log_dir_name;

	public function __construct(string $log_dir_name = "logs") 
	{
		$this->contexts = [];
		$this->log_dir_name = $log_dir_name;
	}

	public function scanContexts()
	{
		foreach($this->contexts as $context) {
			$context->scan();
		}
	}

	/**
	 * Add new context into LogManager
	 * @param  string $contextName 
	 * @param  array  $filenameBuilder    
	 * @param  string $dir_path   
	 * @return self
	 */
	public function new(string $contextName, array $params = [], array $filenameBuilder = [], string $dir_path) : self
	{	
		if($this->getContext($contextName) != null) {
			throw new \LogicException(sprintf("This context %s already exist", $contextName));
		}

		$strategy = $this->buildStrategy($params);

		$context = new LogContext($contextName, $filenameBuilder, $dir_path, $strategy);
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

		$context->writeLog($message, $this->log_dir_name);

		return $this;	
	}

	private function getContext(string $contextName) : ?LogContext 
	{
		foreach($this->contexts as $index => $context) {
			if($context->getContextName() === $contextName) {
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

	private function buildStrategy(array $params) : LogStrategy
	{
		$strategy = new LogStrategy();

		foreach($params as $index => $param) {
			switch($param['type']) {
				case "file_life_time": 
					$strategy->setFileLifeTime($param['value']);
					break;
				case "file_write_life_time":
					$strategy->setFileWriteLifeTime($param['value']);
					break;

				case "directory_max_size":
					$strategy->setDirectoryMaxSize($param['value']);
					break;

				default:
					throw new \InvalidArgumentException(sprintf("unknow strategy type %s at index %s", $param["type"], $index));
			}
		}

		return $strategy;
	}
}