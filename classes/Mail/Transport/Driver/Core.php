<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Mail Transport Interface.
 * Used to interface all transport methods.
 *
 * @package    Swiftmail
 * @author     Oliver Morgan
 */

interface Mail_Transport_Driver_Core {
	
	public static function factory($config);
	
}