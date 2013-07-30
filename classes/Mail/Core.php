<?php defined('SYSPATH') OR die('No direct access allowed.');

require_once dirname(__file__) . '/vendor/swift_required.php';

abstract class Mail_Core {
	
    const CONFIG = 'swift';
    const CLASS_DRIVER_NS = 'Mail_Transport_Driver_';
    
	protected static $_instance;
	
   /**
	 * Create a transport layer to send a messsage.
	 *
	 * @param	Mail_Transport_Type	The transport type
	 * @param	Array	The config item
	 * @param 	Array	From Crendentials
	 * @return  object
	 */
	public static function factory($type = Mail_Transport_Type::SMTP, $from_config = array())
	{
		
        if (empty($from_config))
        {
            $config = Kohana::$config->load(self::CONFIG)->as_array();
        }
        
        if (is_string($from_config))
        {
            $config = Kohana::$config->load($from_config)->as_array();
        }
        
		if(!empty($from_config) && is_array($from_config))
		{
            if(!empty($from_config['email']))
            {
                $config['message']['from']['email'] = $from_config['email'];
            }
            
            if(!empty($from_config['name']))
            {
                $config['message']['from']['name'] = $from_config['name'];
            }
            
		}

		$config = arr::merge($config['message'], $config[$type]);
        
        $reflection = new ReflectionClass(self::CLASS_DRIVER_NS . ucfirst($type));
        $driver = $reflection->newInstanceArgs();
		
		return new Mail($driver, $config);
	}
	
   /**
	 * Gets the current instance of the mail object, or creates a new object if there isnt an existing instance.
	 * 
	 * @param	Name	The name is used if there isnt an existing instance to create a new object.
	 * @return  object
	 */
	public static function instance($type = Mail_Transport_Type::SMTP)
	{
		if(!isset($this->_instance))
		{
			$this->_instance = Mail::factory($type);
		}
		
		return $this->_instance;
	}

	protected $_driver;
	protected $_errors;
	protected $_config;
	protected $_swift_mail;
	
   /**
	 * Loads Transport layer and the specified driver.
	 *
	 * @return  void
	 */
	protected function __construct($driver, $config)
	{
		$this->_driver = $driver;
		$this->_config = $config;
	}
	
   /**
	 * Initialises the message ready for sending
	 * 
	 * @param	Mail_Message	The message you wish to send.
	 * @param	array			The config you wish to load with.
	 * @return  void
	 */
	protected function _initialise(Mail_Message $message, $config = false)
	{
		$config = $config ? $config : $this->_config;
		
		$message->load_config($this->_config);
		$transport = $this->_driver->factory($this->_config);
		
		$this->_swift_mail = Swift_Mailer::newInstance($transport);
		
		return $message;
	}
	
   /**
	 * Sends a single message as you would from a normail mail application. 
	 * NB: all email addresses are viewable every recipient. use send_batch if you do not want this.
	 *
	 * @param   Mail_Message   The mail message to send
	 * @return  array	   	   Message sending errors 
	 */
	public function send(Mail_Message $message)
	{
		try
        {
            $message = $this->_initialise($message);
            $failed_receipts = array();
            
            $this->_swift_mail->send($message, $failed_receipts);
            
            return $failed_receipts;
		}
        catch(Exception $e)
		{
			var_dump($e->getMessage());
		}
	}
	
   /**
	 * Sends single messages to everyone in the to list 
	 * NB: good in keeping email addresses confidential.
	 *
	 * @param   Mail_Message   The mail message to send
	 * @return  array	   	   Message sending errors 
	 */
	public function send_batch(Mail_Message $message)
	{
		$message = $this->_initialise($message);
		$failed_receipts = array();
		$this->_swift_mail->batchSend($message, $failed_receipts);
		
		return $failed_receipts;	
	}
	
	public function __get($key)
	{
		return $this->_config[$key];
	}
	
	public function __set($key, $value)
	{
		$this->_config[$key] = $value;
	}
	
}