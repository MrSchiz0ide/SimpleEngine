<?php
/**
 *@ --------------------------------------------------
 *@ Unique User referal system                       |
 *@ Developed by Sir Schiz0ide, all credits go to me |
 *@ Version 1.0                                      |
 *@--------------------------------------------------|
**/

class Refer 
{
	public static function Check_Refer($username)
	{
		try 
		{
			/* Simple check, required for the update function */
			global $DB;
			$SQL = $DB->prepare("SELECT * FROM users where username = :username");
			$SQL->bindParam(":username", $username, PDO::PARAM_STR);
			$SQL->execute();
			$result = $SQL->fetch();

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

	public static function Add_Refer_Points($username, $ip)
	{
		try
		{
			global $DB;
			if(self::Check_Refer($username) == false)
			{
				return false;
			}
			else
			{
				//phase 1
				$ammount = Config::Read('Refer_Points');
				$SQL = $DB->prepare("UPDATE users SET ref_points = ref_points + :ammount where username = :username");
				$SQL->bindParam(":ammount", $ammount, PDO::PARAM_INT);
				$SQL->bindParam(":username", $username, PDO::PARAM_STR);
				$SQL->execute();


				//phase 2
				$hurr = $DB->prepare("INSERT INTO refer_logs (`refer_username`, `IP`) VALUES (:refer_username, :ipadress)");
				$hurr->execute(array(":refer_username" => $username, ":ipadress" => $ip));

				//final check to see if succesfull.
				if($SQL->fetch() > 0)
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

	public static function Check_If_Referd($ip)
	{
		try
		{
			global $DB;
			$checkSQL = $DB->prepare("SELECT * FROM Refer_Logs where IP = :ipadress");
			$checkSQL->bindParam(":ipadress", $ip, PDO::PARAM_STR);
			$checkSQL->execute();
			$result = $checkSQL->fetch();

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
}
?>