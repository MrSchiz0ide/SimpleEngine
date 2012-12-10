<?php
define("BASE", realpath(__DIR__));

foreach(glob(BASE . '\Engine\*.engine.php') as $include)
{
	require_once($include);
}

Config::Write('dbhost', 'localhost');
Config::Write('dbname', 'test');
Config::Write('dbuser', 'root');
Config::Write('dbpass', '');
Config::Write('Site_Title', 'SkyHigh Boot');
Config::Write('Salt1', 'aWxnB#x@1x&dm!@#4');
Config::Write('Salt2', 'xvS$3x@5#1^nxnQwx');
Config::Write('Refer_Points', 100);

/**
 * @Database connection is establishes here
 *  Using PDO to prevent SQL injections
 *  All other data is sanitized
 */
try 
{ 
	$DB = new PDO('mysql:host=' . Config::Read('dbhost') . ';dbname=' . Config::Read('dbname'), Config::Read('dbuser'), Config::Read('dbpass'));
	$DB->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
}
catch (PDOException $error) 
{	
	echo $error->getMessage(); 
}
?>