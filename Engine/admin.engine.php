<?php
/**
 *@ --------------------------------------------------
 *@ Unique Administration/Management system          |
 *@ Developed by Sir Schiz0ide                       |
 *@ Version 1.0                                      |
 *@---------------------------------------------------
**/
class Management
{
	public static function Ban_User($username, $reason)
	{
		try 
		{
			/* First check if the user is banned or not */
			global $DB;
			if(User::Is_Banned($username, $reason) == true)
			{
				return false;
			}
			else
			{
				$banSQL = $DB->prepare("UPDATE users SET rank = 'banned', Ban_Reason = :reason WHERE username = :username");
				$banSQL->execute(array(":reason" => $reason,":username" => $username));
				return true;
			}
		}
		catch(PDOException $error)
		{
			return $error->getMessage();
		}

	}

	public static function Set_Rank($username, $rank)
	{
		try 
		{
			global $DB;
			$old_rank = User::Fetch_Rank($username);

			if($rank == $old_rank)
			{
				return 'Error: User already has this rank!';
			} else {
				$updateSQL = $DB->prepare("UPDATE users SET Rank = :rank where username = :username");
				$updateSQL->bindParam(":rank", $rank, PDO::PARAM_STR);
				$updateSQL->bindParam(":username", $username, PDO::PARAM_STR);
				$updateSQL->execute();

				$result = $updateSQL->fetchColumn();

				if($result)
				{
					return true;
				}else{
					return false;
				}
			}
		}
		catch(PDOException $error)
		{
			return $error->getMessage();
		}
	}

	/* Only enable on online webhost, doesnt seem to work on Localhost
	public static function Return_Ban_Reason($ip)
	{
		try
		{
			global $DB;
			$fetchSQL = $DB->prepare("SELECT * FROM users where IP_latest = :ip");
			$fetchSQL->bindParam(":ip", $ip, PDO::PARAM_STR);
			$fetchSQL->execute();

			$result = $fetchSQL->fetch(PDO::FETCH_ASSOC);
			return $result['Reason'];
		}
		catch (PDOException $error)
		{
			return $error->getMessage();
		}
	}*/

	public static function Return_Ban_Reason($username)
	{
		try
		{
			global $DB;
			$fetchSQL = $DB->prepare("SELECT * FROM users where username = :username");
			$fetchSQL->bindParam(":username", $username, PDO::PARAM_STR);
			$fetchSQL->execute();

			$result = $fetchSQL->fetch(PDO::FETCH_ASSOC);
			return $result['Ban_Reason'];
		}
		catch (PDOException $error)
		{
			return $error->getMessage();
		}
	}
}
?>