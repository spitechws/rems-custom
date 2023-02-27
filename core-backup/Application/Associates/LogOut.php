<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
if($_SESSION['advisor_id']!="" && $_SESSION['advisor_name']!="" && $_SESSION['advisor_code']!="" && $_SESSION['advisor_id']!=NULL && $_SESSION['advisor_name']!=NULL && $_SESSION['advisor_code']!=NULL)
{
	$DBOBJ->UserAdvisorAction("Log Out","");	
}
$_SESSION['advisor_id']=NULL;
$_SESSION['advisor_name']=NULL;
$_SESSION['advisor_code']=NULL;

session_destroy();
header("location:index.php");

?>




