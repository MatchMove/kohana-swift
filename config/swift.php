<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
    'default' => array(
        
        /*
         * Swiftmailer Message Settings
         * These settings are used as global defauls, they can be overridden on runtime.
         * go with Amazon SES
         */
        'message' => array (
            
            'from' => array (
                'email' => 'someone@email.com',     // The email address you are sending as.
                'name'  => 'John Doe Co.'           // The name displayed on the recipient email. (Optional)
            ),
            
            // The email to return a bounced address (if sending failed).
            'return_path' => array( 
                'enabled' => true,
                'email'   => 'failed@email.com'
            ),
            
            //Whether to enable a receipt to be sent to an address if the email is read.
            'read_receipt' => array(
                'enabled' => false,  
                'email'   =>  'read@email.com' // The email to send the receipt to.
            ),
            
            'charset' => Kohana::$charset, // Anything, 'UTF-8', 'iso-8859-2' etc.
            'line_length' => 78, // The number of lines within a message, NB: Max is 1000.
            'priority' => Mail_Priority::NORMAL // Take your pick: Highest, High, Normal, Low, Lowest.
        ),
        
        /*
         * SMTP Mail Transfer Settings
         * See: http://en.wikipedia.org/wiki/Simple_Mail_Transfer_Protocol
         * This is the most common mail transport layer.
         */
        Mail_Transport_Type::SMTP => array (
            
            'host'     => 'smtp1.smtp.email.com',   // The host of the SMTP server
            'port'     => 25,                       // The SMTP server port, typically 25 or 587 for ssl etc.
            
            'encryption' => array (
                'enabled' => true,                  // Whether to send the message with encryption
                'type' 	  => 'tls'                  // TLS or SSL
            ),
            
            'login' => array (
                'enabled'   => true,            // Whether your sever requires a login (it should do)
                'username'  => 'username',      // The username to login with
                'password'  => 'p@ssw0rd'       // The password to login with
            )
        ),
        
        /*
         * PHP Mail Transfer Settings
         * See: http://www.php.net/mail
         * Isnt particularly stable or helpful in the majority of cases.
         */
        Mail_Transport_Type::MAIL => array(
            'parameters' => '-f%s'
        ),
        
        /*
         * Sendmail Transfer Settins
         * See: http://www.sendmail.org/ or http://swiftmailer.org/docs/sendmail-transport
         * Linux only, involves communicating with a locally installed MTA
         */
        Mail_Transport_Type::SENDMAIL => array (
            'directory' => '',  // eg. '/usr/sbin/exim'
            'command'   => 'bs' // 'bs' or 't'
        )

    )
);