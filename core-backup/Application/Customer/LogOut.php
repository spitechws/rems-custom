<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
if($_SESSION['customer_id']!="" && $_SESSION['customer_name']!="" && $_SESSION['customer_code']!="" && $_SESSION['customer_id']!=NULL && $_SESSION['customer_name']!=NULL && $_SESSION['customer_code']!=NULL)
{
	$DBOBJ->UserCustomerAction("Log Out","");	
}

$_SESSION['customer_id']=NULL;
$_SESSION['customer_name']=NULL;
$_SESSION['customer_code']=NULL;

session_destroy();
header("location:index.php");

?>




