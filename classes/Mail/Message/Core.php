<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Mail_Message_Core extends Swift_Message {
	
	public function load_config($config = array())
	{
		$config = arr::merge(Mail::config(), $config);
		
		$this->setFrom($config['from']['email'], $config['from']['name']);
		
		if($config['return_path']['enabled'])
		{
			$this->setReturnPath($config['return_path']['email']);
		}
		
		if($config['read_receipt']['enabled'])
		{
			$this->setReadReceiptTo($config['read_receipt']['email']);
		}
		
		$this->setCharset($config['charset']);
		$this->setPriority((int)$config['priority']);
	}
	
	public function __call($function, $params)
	{
		$function = inflector::camelize($function);
		return call_user_func_array(array($this, $function), $params);
	}
}