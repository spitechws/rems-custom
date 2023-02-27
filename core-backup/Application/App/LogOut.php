<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
if($_SESSION['user_id']!="" && $_SESSION['user_name']!="" && $_SESSION['user_id']!=NULL && $_SESSION['user_name']!=NULL)
{
	$DBOBJ->UserAction("Log Out","");	
}
$_SESSION['user_id']=NULL;
$_SESSION['user_name']=NULL;
//$msg=$_SESSION['Message'];
session_destroy();
header("location:index.php");

?>




