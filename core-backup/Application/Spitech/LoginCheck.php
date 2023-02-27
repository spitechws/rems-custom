<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$POST_USER_ID=$_POST['user_id'];
$POST_PWD=$_POST['user_password'];
$POST_MD_PWD=md5($POST_PWD);



$USER_ROW=$DBOBJ->GetRow("tbl_spitech_user","user_id",$POST_USER_ID);

	if($USER_ROW['user_id']==$POST_USER_ID)
	{	
		
				if($USER_ROW['user_password']==$POST_MD_PWD)
				{
					//============(CHECKING CAPTCHA ATTEMP)==================
					if($_SESSION['spitech_captcha_attempt']>2)
					{
												
						if(strtolower($_POST['user_captcha'])==$_SESSION['securimage_code_value']['default'])
						{
							$_SESSION["spitech_user_id"]=$USER_ROW['user_id'];
							$_SESSION["spitech_user_name"]=$USER_ROW['user_name'];
							
							$DBOBJ->UserAction("Login","");	
							
							$_SESSION['spitech_captcha_attempt']=0;	
										
							header("location:Default.php");
						}
						else
						{
							$Message=CheckUserAttempt();
							header("location:index.php?".md5("Mode")."=".md5("Incorrect Security Code").$Message);
						}
						
					}
					else
					{
						    $_SESSION["spitech_user_id"]=$USER_ROW['user_id'];
							$_SESSION["spitech_user_name"]=$USER_ROW['user_name'];
							
							$DBOBJ->UserAction("Login","");					
							header("location:Default.php");
					}
					
					
				}
				else
				{
					$Message=CheckUserAttempt();
					header("location:index.php?".md5("Mode")."=".md5("Incorrect Password").$Message);
				}				
		
	}
	else
	{		            
	    CheckUserAttempt();
		header("location:index.php?".md5("Mode")."=".md5("Invalid User ID"));
	}


function CheckUserAttempt()
{
	$DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();
	
	 $user_id=$_POST['user_id'];
	 
	 $_SESSION['spitech_login_attempt']=$_SESSION['spitech_login_attempt']+1;
	 $_SESSION['spitech_captcha_attempt']=$_SESSION['spitech_captcha_attempt']+1;
	  
	  //========( LOGIN ATTEMPT SET O )================================================
	
	return $Message;
}
	
	
?>




