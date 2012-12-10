<?php
/**
 *@ --------------------------------------------------
 *@ Unique API management/Loading system             |
 *@ Developed by Sir Schiz0ide, all credits go to me |
 *@ Version 1.0                                      |
 *@--------------------------------------------------|
**/

class Mechanism 
{
	public static $apis = array();

	public static function Load_APIs()
	{
		try 
		{
			global $DB;

			//phase 1, fetch the apis from the DB
			$swag = $DB->prepare("SELECT * FROM apis where status = 'online'");
			$swag->execute();
			while($rows = $swag->fetch(PDO::FETCH_ASSOC))
			{
				array_push(self::$apis, $rows['Url']);
			}
		}
		catch(PDOException $error)
		{
			return $error->getMessage();
		}
	}

	public static function Return_APIs()
	{
		return self::$apis;
	}

	public static function Add_API($url)
	{
		try
		{
			/* Some shitty variables nobody cares about */
			global $DB;
			$status = 'online';

			/* Phase 1, Checking if the api already exists or not. */
			$fetchSQL = $DB->prepare("SELECT * FROM apis where Url = :urley");
			$fetchSQL->bindParam(":urley", $url, PDO::PARAM_STR);
			$fetchSQL->execute();
			$result = $fetchSQL->fetch();

			if($result)
			{
				return false;
			}
			else
			{
				$addSQL = $DB->prepare("INSERT INTO apis (`Url`, `status`) VALUES (:url, :status)");
				$addSQL->bindParam(":url", $url, PDO::PARAM_STR);
				$addSQL->bindParam(":status", $status, PDO::PARAM_STR);
				$addSQL->execute();
				return true;
			}
		}
		catch(PDOException $error)
		{
			return $error->getMessage();
		}

	}

	public static function Check_Status($site)
	{
			$curl = curl_init($site);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_exec($curl);

			$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			if($status == '200')
			{
				return true;
			}
			else
			{
				return false;
			}

	}
}
?>