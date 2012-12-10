<?php
/**--------------------------------------------------------------------------
 *@ Index Page     															|
 *@ Developed by Sir Schiz0ide, all credits go to me                        |
 *@ This is not to be distributed, without my permission					|
 *@ Version 1.0                                      						|
 *@--------------------------------------------------------------------------
**/
require_once('./Config.php');
session_start();
if(!isset($_SESSION['ID']) && !isset($_SESSION['username']))
{
	header('Location: login.php');
}
if(User::Is_Banned($_SESSION['username']) == true)
{
	echo '<b>You appear to be Banned!</b><br>';
	echo 'Reason: ' . Management::Return_Ban_Reason($_SESSION['username']) . '<br>';
	die();
}

//do something here

?>