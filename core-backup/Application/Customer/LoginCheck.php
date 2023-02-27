<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$POST_USER_ID=$_POST['customer_code'];
$POST_PWD=$_POST['customer_password'];
$POST_MD_PWD=md5($POST_PWD);

$customer_ROW=$DBOBJ->GetRow("tbl_customer","customer_code",$POST_USER_ID);


	if($customer_ROW['customer_code']==$POST_USER_ID)
	{	
	
		if($customer_ROW['customer_status']=="1")
		{
				
				if($customer_ROW['customer_password']==$POST_MD_PWD)
				{
					//============(CHECKING CAPTCHA ATTEMP)==================
					if($_SESSION['captcha_attempt']>2)
					{
												
						if(strtolower($_POST['user_captcha'])==$_SESSION['securimage_code_value']['default'])
						{
							$_SESSION["customer_id"]=$customer_ROW['customer_id'];
							$_SESSION["customer_code"]=$customer_ROW['customer_code'];
							$_SESSION["customer_name"]=$customer_ROW['customer_title']." ".$customer_ROW['customer_name'];	
							$_SESSION['captcha_attempt']=0;	
								
							$DBOBJ->UserCustomerAction("Login","");	
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
						    $_SESSION["customer_id"]=$customer_ROW['customer_id'];
							$_SESSION["customer_code"]=$customer_ROW['customer_code'];
							$_SESSION["customer_name"]=$customer_ROW['customer_title']." ".$customer_ROW['customer_name'];								
							
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
	
	 $user_id=$_POST['customer_code'];
	 
	 $_SESSION['login_attempt']=$_SESSION['login_attempt']+1;
	 $_SESSION['captcha_attempt']=$_SESSION['captcha_attempt']+1;
	  
	
	return $Message;
}
	
?>




