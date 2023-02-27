<?php
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../SpitechMailer/SpitechMailer.php");
include_once("../Menu/HeaderCommon.php");
include_once("../Menu/Define.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();


if(isset($_POST['ResetPassword']))
{
	 $USER_Q="SELECT * FROM tbl_admin_user WHERE 
			user_id='".$_POST['user_id']."' 
			AND user_email_id='".$_POST['user_email_id']."' 
			AND user_mobile='".$_POST['user_mobile']."'
			and user_status='1'  ";
	$USER_Q=@mysqli_query($_SESSION['CONN'],$USER_Q);
	$USER_EXIST=@mysqli_num_rows($USER_Q);
	
	$USER_ROW=@mysqli_fetch_assoc($USER_Q);
	if($USER_EXIST>0)
	{
	    $PASSWORD=RandomPassword();
	 	$FIELDS=array("user_password");											
		$VALUES=array(md5($PASSWORD));	
		$UPDATE=$DBOBJ->Update("tbl_admin_user",$FIELDS,$VALUES,"user_id",$USER_ROW["user_id"],0);
			
	      //===================(Message Body)==========================================================================
			$title="Your password of <b>".site_company_name."</b> account has successfully reset. Your login details as follows :";
	        $Message=UserMail($USER_ROW["user_id"],$PASSWORD,$title);			
			@SendDirectMail($USER_ROW["user_email_id"],$Message,site_company_name." Application : Login Password Reset Details",site_company_name);
		  //============================================================================================================

			
	 header("location:index.php?Message=Your Password Has Successfully Reset and Sent To Your E-Mail Address.");	
	}
	else
	{
		header("location:User_Forget_Password.php?Error=Invalid User ID, E-Mail ID And Mobile No.");
		
	}
	
}
?>
<link rel="stylesheet" href="../css/AppStyle.css">
<style>
.table { background:url(../SpitechImages/AdminLoginBG.png) center repeat-y; height:auto; width:400px; margin-top:60px; padding:3px; border:2px solid #615D5C; margin-top:60px;}
body { background:url(../SpitechImages/AdminLoginBodyBG.png); }
#CommonTable { width:100%;height:180px; border:0px solid #009AD0; margin-top:50px; color:white; text-transform:uppercase; margin:0px;}
#CommonTable tr td { background:none;color:white; text-transform:uppercase; font-weight:bolder; font-size:13px; }
h3 { line-height:80px; font-size:18px; font-variant:bolder;color:#3F6;text-shadow:2px 2px black; }
#user_id { color:#006090; background:white url(../SpitechImages/UserLoginBG.png) right no-repeat; padding-right:30px; padding-left:10px;}
#user_email_id { color:#006090; background:white url(../SpitechImages/Mail.png) right no-repeat; padding-right:30px; padding-left:10px;}
#user_mobile { color:#006090; background:white url(../SpitechImages/Mobile.png) right no-repeat; padding-right:30px; padding-left:10px;}
h3 { line-height:80px; font-size:18px; font-variant:bolder;color:#3F6;text-shadow:2px 2px black; }
</style>
<body style=" margin:0px; padding:0px;">

<center>
<form name="form1" id="form1" method="post">
<div style="height:80px; border-bottom:5px solid #731F19; text-align:center; margin:0px; background:#fff;">
<a onClick="window.location='../../index.php'"><img src="../SpitechLogo/Logo.png" width="200" height="100" style="margin-top:5px; opacity:1;padding:5px; border:2px solid #731F19;background:white; "/></a></div>

<div class="table">
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" id="CommonTable">
  <tr>
    <td height="35" colspan="3" style="height:20px; text-align:center">Fill Following Details<hr></td>
    </tr>
  <tr>
    <td height="22" colspan="3">
 
      <?php ErrorMessage(); ?>
   </td>
    </tr>
  <tr>
    <td width="40" rowspan="4" style="vertical-align:top"><img src="../SpitechImages/Password-Recovery.png" width="60" height="80"></td>
    <td width="49" height="22">USER ID</td>
    <td width="293"><input type="text" name="user_id" id="user_id" placeholder="USER ID" style="width:200px;" required maxlength="50"/></td>
  </tr>
 
 
  <tr>
    <td>EMAIL ID</td>
    <td><input type="email" name="user_email_id" id="user_email_id" placeholder="E-MAIL ID" style="width:200px;" required maxlength="50"/></td>
  </tr>

   <tr>
     <td>MOBILE&nbsp;NO</td>
    <td><input type="text" name="user_mobile" id="user_mobile" placeholder="MOBILE NO" style="width:200px;" required maxlength="10" <?php OnlyNumber(); ?>/></td>
  </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
 
  <tr>
    <td colspan="2"><div align="right"><a href="index.php" style="float:right; margin-top:10px; text-transform:capitalize; color:#FF8040">Go Back To Login </a></div></td>
    <td><input type="submit" name="ResetPassword" id="ResetPassword" value="Reset Password" /></td>
  </tr>
  
</table></div><img src="../SpitechImages/Shadow.png" width="411" height="40"></form>

</center>
</body>