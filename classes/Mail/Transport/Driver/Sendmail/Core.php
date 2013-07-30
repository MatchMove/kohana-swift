<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Sendmail Transport Driver
 * Used to send messages via the sendmail transport layer.
 *
 * @package    Swiftmail
 * @author     Oliver Morgan
 */

abstract class Mail_Transport_Driver_Sendmail_Core extends Mail_Transport implements Mail_Transport_Driver {	
	
	public static function factory($config)
	{
		return Swift_SendmailTransport::newInstance($config->directory . ' -' . $config->command);
	}
}