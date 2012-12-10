<?php
/**
 *@ -------------------------------------------------------------------------
 *@ Main engine file, includes Login/register handler and more key functions|
 *@ Developed by Sir Schiz0ide, all credits go to me                        |
 *@ This is not to be distributed, without my permission					|
 *@ Version 1.0                                      						|
 *@--------------------------------------------------------------------------
**/
class Engine 
{
	public static function Login($username, $password, $ip)
	{
		/* Login validation Script */
		try {
			global $DB;

			$SQL = $DB->prepare("SELECT * FROM users where username = :username AND password = :password");
			$SQL->bindParam(':username', $username, PDO::PARAM_STR);
			$SQL->bindParam(':password', $password, PDO::PARAM_STR);
			$SQL->execute();
			$SQL->setFetchMode(PDO::FETCH_ASSOC);
			$rows = $SQL->fetchColumn();

			if($rows > 0)
			{
				$hurrdurr = $DB->prepare("UPDATE users SET IP_latest = :ip where username = :user");
				$hurrdurr->bindParam(":ip", $ip, PDO::PARAM_STR);
				$hurrdurr->bindParam(":user", $username, PDO::PARAM_STR);
				return true;
			}else{
				return false;
			}
		}
		catch(PDOException $error)
		{
			return $error->getMessage();
		}
	}	

	public static function Register($username, $password, $ipadress)
	{
		/* User registration system, utilises ifuserregistered thingy */
		try 
		{
		global $DB;
		$SQL = $DB->prepare("INSERT INTO users (`username`, `password`, `IP_registered`) VALUES (:username, :password, :ipadress)");
		$SQL->execute(array(":username" => $username, ":password" => $password, "ipadress" => $ipadress));
		return true;
		}
		catch(PDOException $error) {
			return $error->getMessage();
		}
	}

	public static function Sanitize($value)
	{
		/* Sanitize data client side, we use prepared statements so no sqli possible */
		return htmlspecialchars(stripslashes(strip_tags($value)));
	}

	public static function Hash($password)
	{
		/* Password Hashing system, undecryptable */
		return sha1(Config::Read('Salt1') . $password . Config::Read('Salt2'));
	}
}

Class User 
{	
	public static function Logged_In($username, $id)
	{
		/* Check if a user is logged in or not */
		if(!EMPTY($username) && !EMPTY($id))
		{
			return true;
		}else{
			return false;
		}
	}

	public static function is_registered($username)
	{
		/* This is the check if a user is already registered */
		try {
			global $DB;
			$SQL = $DB->prepare("SELECT * FROM users where username = :username");
			$SQL->bindParam(":username", $username, PDO::PARAM_STR);
			$SQL->execute();
			$result = $SQL->fetchColumn();

			if($result)
			{
				return true;
			}else{
				return false;
			}
		}
		catch(PDOException $error)
		{
			return $error->getMessage();
		}
	}

	/* Same story, only enable on webhost hurr durr
	public static function Is_Banned($ip)
	{
		//Search for ban records on the user
		try
		{
			global $DB;

			$SQL = $DB->prepare("SELECT * FROM users where IP_latest = :ip");
			$SQL->bindParam(":ip", $ip, PDO::PARAM_STR);
			$SQL->execute();
			$Status = $SQL->fetch(PDO::FETCH_ASSOC);

			if($Status['Rank'] == 'banned')
			{
				return true;
			}else{
				return false;
			}
		}
		catch(PDOException $error)
		{
			return $error->getMessage();
		}
	}
	*/

	public static function Is_Banned($username)
	{
		//Search for ban records on the user
		try
		{
			global $DB;

			$SQL = $DB->prepare("SELECT * FROM users where username = :username");
			$SQL->bindParam(":username", $username, PDO::PARAM_STR);
			$SQL->execute();
			$Status = $SQL->fetch(PDO::FETCH_ASSOC);

			if($Status['Rank'] == 'banned')
			{
				return true;
			}else{
				return false;
			}
		}
		catch(PDOException $error)
		{
			return $error->getMessage();
		}
	}

	public static function Fetch_ID($username)
	{
		/* This is for the login part, This is used to set the $_SESSION['ID'] */
		try 
		{
		Global $DB;
		$SQL = $DB->prepare("SELECT * FROM users where username = :username");
		$SQL->bindParam(':username', $username, PDO::PARAM_STR);
		$SQL->execute();
		$result = $SQL->fetch(PDO::FETCH_ASSOC);
		return $result['ID'];
		}
		catch(PDOException $error)
		{
			return $error->getMessage();
		}
	}

	public static function Fetch_Rank ($username)
	{
		/* Same story, i find $_SESSION['Rank'] very usefull. */
		try 
		{
		Global $DB;
		$SQL = $DB->prepare("SELECT * FROM users where username = :username");
		$SQL->bindParam(':username', $username, PDO::PARAM_STR);
		$Data = $SQL->execute();
		$result = $SQL->fetch(PDO::FETCH_ASSOC);
		return $result['Rank'];
		}
		catch (PDOException $error)
		{
			return $error->getMessage();
		}
	}

}
?>