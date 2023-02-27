<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$POST_USER_ID=$_POST['user_id'];
$POST_PWD=$_POST['user_password'];
$POST_MD_PWD=md5($POST_PWD);

$USER_ROW=$DBOBJ->GetRow("tbl_admin_user","user_id",$POST_USER_ID);

	if($USER_ROW['user_id']==$POST_USER_ID)
	{	
		if($USER_ROW['user_status']==1)
		{
				if($USER_ROW['user_password']==$POST_MD_PWD)
				{
					//============(CHECKING CAPTCHA ATTEMP)==================
					if($_SESSION['captcha_attempt']>2)
					{
												
						if(strtolower($_POST['user_captcha'])==$_SESSION['securimage_code_value']['default'])
						{
							$_SESSION["user_id"]=$USER_ROW['user_id'];
							$_SESSION["user_name"]=$USER_ROW['user_name'];
							$_SESSION["user_category"]=$USER_ROW['user_category'];
							$DBOBJ->UserAction("Login","");	
							
							$_SESSION['captcha_attempt']=0;	
										
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
						    $_SESSION["user_id"]=$USER_ROW['user_id'];
							$_SESSION["user_name"]=$USER_ROW['user_name'];
							$_SESSION["user_category"]=$USER_ROW['user_category'];
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
			header("location:index.php?".md5("Mode")."=".md5("Expired"));
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
	 
	 $_SESSION['login_attempt']=$_SESSION['login_attempt']+1;
	 $_SESSION['captcha_attempt']=$_SESSION['captcha_attempt']+1;
	  
	  //========( LOGIN ATTEMPT SET O )================================================
			/*if($_SESSION['login_attempt'.$user_id]>5)
			{		
			    $user_category=$DBOBJ->ConvertToText("tbl_admin_user","user_id","user_category",$user_id);				
				
				$DETAILS=$user_id.", ".$user_category.", ".date('Y-m-d, h:i:s a').", ".GetIP();
				$NEXT_DATE=NextDate(date('Y-m-d'),"+1")." ".date('H:i:s');
																		
				$FIELDS=array("user_status","login_attempt_details","login_attempt_enable_on");							
				$VALUES=array(0,$DETAILS,$NEXT_DATE);	
				$DBOBJ->UpDate("tbl_admin_user",$FIELDS,$VALUES,"user_id",$user_id,0);
				
				$Message="&Message=Your Account Have Been Blocked For 24 Hours. Due to Invalid Login.";
			}*/
	return $Message;
}
	
	
?>




