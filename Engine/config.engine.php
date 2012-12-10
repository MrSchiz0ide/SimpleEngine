<?php
/**
 *@ --------------------------------------------------
 *@ System to handle dynamic Configurations          |
 *@ Developed by Sir Schiz0ide, all credits go to me |
 *@ Version 1.0                                      |
 *@--------------------------------------------------|
**/
class Config 
{
	public static $config = array();

	public static function Read($key)
	{
		return self::$config[$key];
	}	

	public static function Write($key, $value)
	{
		self::$config[$key] = $value;
	}
}