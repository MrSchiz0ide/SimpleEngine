<?php
/**--------------------------------------------------------------------------
 *@ Registration Page													    |
 *@ Developed by Sir Schiz0ide, all credits go to me                        |
 *@ This is not to be distributed, without my permission					|
 *@ Version 1.0                                      						|
 *@--------------------------------------------------------------------------
**/
require_once("./Config.php");
if(isset($_POST['register']))
{
	if(!EMPTY($_POST['Username']) && !EMPTY($_POST['password']))
	{
		$username = Engine::Sanitize($_POST['Username']);
		$password = Engine::Sanitize(Engine::Hash($_POST['password']));
		
		if(User::is_registered($username) < 1)
		{
			header('Refresh: 3; url=login.php');
			Engine::Register($username, $password, $_SERVER['REMOTE_ADDR']);
			echo 'Registered succesfully! Redirecting..';
		}
		else
		{
			echo 'This user is already registered...';
		}

	}
	else
	{
		echo 'Please fill in all fields!';
	} 
}
?>
</form>