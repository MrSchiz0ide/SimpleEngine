<?php
/**--------------------------------------------------------------------------
 *@ Login page       														|
 *@ Developed by Sir Schiz0ide, all credits go to me                        |
 *@ This is not to be distributed, without my permission					|
 *@ Version 1.0                                      						|
 *@--------------------------------------------------------------------------
**/
session_start();
Ob_start();
require_once('./Config.php');
?>

	<?php if(isset($_POST['go']))
	{
		if(!EMPTY($_POST['user']) && !EMPTY($_POST['pass']))
		{
			$username = Engine::Sanitize($_POST['user']);
			$password = Engine::Hash(Engine::Sanitize($_POST['pass']));
			$Check = Engine::Login($username, $password, $_SERVER['REMOTE_ADDR']);

			if($Check < 1)
			{
				echo 'Error: Name/password incorrect';
			}else{
				header('Refresh: 3; url=index.php');
				echo 'Login succesful! redirecting!';
				$_SESSION['ID'] = User::Fetch_ID($username);
				$_SESSION['username'] = $username;
				$_SESSION['Rank'] = User::Fetch_Rank($username);
				Ob_end_clean();
			}
		}else{
			echo 'Error: Please fill in all fields..';
		}
	}