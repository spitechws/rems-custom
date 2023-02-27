<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$POST_USER_ID=$_POST['advisor_code'];
$POST_PWD=$_POST['advisor_password'];
$POST_MD_PWD=md5($POST_PWD);

$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_code",$POST_USER_ID);


	if($ADVISOR_ROW['advisor_code']==$POST_USER_ID)
	{	
	
		if($ADVISOR_ROW['advisor_status']=="1")
		{
				
				if($ADVISOR_ROW['advisor_password']==$POST_MD_PWD)
				{
					//============(CHECKING CAPTCHA ATTEMP)==================
					if($_SESSION['captcha_attempt']>2)
					{
												
						if(strtolower($_POST['user_captcha'])==$_SESSION['securimage_code_value']['default'])
						{
							$_SESSION["advisor_id"]=$ADVISOR_ROW['advisor_id'];
							$_SESSION["advisor_code"]=$ADVISOR_ROW['advisor_code'];
							$_SESSION["advisor_name"]=$ADVISOR_ROW['advisor_title']." ".$ADVISOR_ROW['advisor_name'];	
							$_SESSION['captcha_attempt']=0;	
							//===================(CREATING TEAM STRING)==================================================================	
								$ADVISOR_TEAM=$_SESSION['advisor_id']; $DBOBJ->GetAdvisorTeam($_SESSION['advisor_id']);				
								$_SESSION["advisor_team"]=$ADVISOR_TEAM;
								$ADVISOR_TEAM="";
							//===================(END OF CREATING TEAM STRING)==================================================================	
							$DBOBJ->UserAdvisorAction("Login","");	
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
						    $_SESSION["advisor_id"]=$ADVISOR_ROW['advisor_id'];
							$_SESSION["advisor_code"]=$ADVISOR_ROW['advisor_code'];
							$_SESSION["advisor_name"]=$ADVISOR_ROW['advisor_title']." ".$ADVISOR_ROW['advisor_name'];	
							
							//===================(CREATING TEAM STRING)==================================================================	
								$ADVISOR_TEAM=$_SESSION['advisor_id']; $DBOBJ->GetAdvisorTeam($_SESSION['advisor_id']);				
								$_SESSION["advisor_team"]=$ADVISOR_TEAM;
								$ADVISOR_TEAM="";
							//===================(END OF CREATING TEAM STRING)==================================================================	
							$DBOBJ->UserAdvisorAction("Login","");	
							header("location:Default.php");
					}
				}
				else
				{
					CheckUserAttempt();
					header("location:index.php?".md5("Mode")."=".md5("Incorrect Password"));
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
	
	 $user_id=$_POST['advisor_code'];
	 
	 $_SESSION['login_attempt']=$_SESSION['login_attempt']+1;
	 $_SESSION['captcha_attempt']=$_SESSION['captcha_attempt']+1;
	  
	
	return $Message;
}
	
?>




