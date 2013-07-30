<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * SMTP Transport Driver
 * Used to send messages via the simple mail transfer protocol.
 *
 * @package    Swiftmail
 * @author     Oliver Morgan
 */

abstract class Mail_Transport_Driver_Smtp_Core extends Mail_Transport implements Mail_Transport_Driver {	

	public static function factory($config)
	{
		$transport = Swift_SmtpTransport::newInstance();
		$transport->setHost($config['host']);
		$transport->setPort($config['port']);
		
		if($config['encryption']['enabled'])
		{
			//TODO: Validate with stream_get_transports()
			
			$transport->setEncryption($config['encryption']['type']);
		}
		
		if($config['login']['enabled'])
		{
			$transport->setUsername($config['login']['username']);
			$transport->setPassword($config['login']['password']);
		}
		
		return $transport;
	}
	
}