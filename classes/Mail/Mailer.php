<?php defined('SYSPATH') or die('No direct script access.');

//Email sent class
class Mail_Mailer {

    //insite email send out  $from = array('sesmail');  go with Amazon SES
    //crontab job email send out $from =array() go with mail server
	public static function send($to, $title, $body, $from =array(),$cc = array())
	{
        try{
        
			$to = is_string($to) ? explode(",",$to) : $to;
			
			$mail = \Mail::factory(\Mail_Transport_Type::SMTP,$from);
			$message = new \Mail_Message;
			$message->setTo($to);
			$message->setCc($cc);
			$message->setsubject($title);
			$message->setBody($body);
			$message->setContentType("text/html");
			$failed_receipts = $mail->send($message);
			return count($failed_receipts) > 0 ? false : true;
	    }catch(Exception $e){
        	return false;
        }
       
    }
}
