<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * PHP Mail Transport Driver
 * Used to send messages via 
 *
 * @package    Swiftmail
 * @author     Oliver Morgan
 */

abstract class Mail_Transport_Driver_Mail_Core extends Mail_Transport implements Mail_Transport_Driver  {
	
	public static function factory($config)
	{
		return Swift_MailTransport::newInstance();
	}
}