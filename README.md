kohana-swift
============

Swift mailer for kohana

Mail configuration explain
==========================

Activities
==========

Classes
-------
    Send mail
    
How to:
-------

1,controller Send mail(matchmovesite/sites/matchmove.com/classes/controller/***.php)

     $to="*******@163.com";             //Send to a user's email
     $title= __("title");                //Send title
     $message="content";                 //Send content
     mailer::send($to,$title, $message)) //The mailer::send () transmit data

2,maile class

     class mailer {                                           //Email sent class
	public static function send($to, $title, $body)
	{
          try{
               $mail = \Mail::factory(\Mail_Transport_Type::SMTP);
	        $message = new \Mail_Message;
	        $message->setTo($to);
	        $message->setsubject($title);
	        $message->setBody($body);
	        $message->setContentType("text/html");
	        $mail->send($message);	        
	        return true;
          }catch(Exception $e){
        	return false;
        }       
       }    		
      }

3,Mailbox configuration information

    matchmovesite/sites/matchmove.com/config/swiftmail.php

4,Email template
    matchmovesite/modules/swift