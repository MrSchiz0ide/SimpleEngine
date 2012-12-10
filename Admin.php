<?php
/**--------------------------------------------------------------------------
 *@ Administration Panel													|
 *@ Developed by Sir Schiz0ide, all credits go to me                        |
 *@ This is not to be distributed, without my permission					|
 *@ Version 1.0                                      						|
 *@--------------------------------------------------------------------------
**/
require_once("./Config.php");
session_start();

if(!isset($_SESSION['username']) && !isset($_SESSION['ID']))
{
	header('location: ./login.php');
}

if($_SESSION['Rank'] !== 'admin')
{
	header('location: ./index.php');
}

//do something here
?>