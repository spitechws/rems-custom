<?php
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../SpitechMailer/SpitechMailer.php");
include_once("../Menu/HeaderCommon.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();


if(isset($_POST['ResetPassword']))
{
	  $USER_Q="SELECT * FROM tbl_customer WHERE 
			customer_code='".$_POST['customer_code']."' 
			AND customer_email='".$_POST['customer_email']."' 
			AND customer_mobile='".$_POST['customer_mobile']."' ";
	$USER_Q=@mysqli_query($_SESSION['CONN'],$USER_Q);
	$USER_EXIST=@mysqli_num_rows($USER_Q);
	
	$USER_ROW=@mysqli_fetch_assoc($USER_Q);
	if($USER_EXIST>0)
	{
	    $PASSWORD=RandomPassword();
	 	$FIELDS=array("customer_password");											
		$VALUES=array(md5($PASSWORD));	
		$UPDATE=$DBOBJ->Update("tbl_customer",$FIELDS,$VALUES,"customer_code",$USER_ROW["customer_code"],0);
			
	 //===================(Message Body)==========================================================================
		$title="Your password of <b>".site_company_name."</b> account has successfully reset. Your login details as follows :";
		$Message=CustomerMail($USER_ROW["customer_id"],$PASSWORD,$title);			
			@SendDirectMail($USER_ROW["customer_email"],$Message,site_company_name." Application : Login Password Reset Details",site_company_name);
	 //=============================================================================================================				
	   
			
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
.table { background:url(../SpitechImages/AdminLoginBG.png) center no-repeat; height:400px; width:420px; margin-top:40px;}
body { background:url(../SpitechImages/AdminLoginBodyBG.png); }
#CommonTable tr td { background:#F1F1F1; }
h3 { line-height:80px; font-size:18px; font-variant:bolder;color:#3F6;text-shadow:2px 2px black; }
</style>
<body style=" margin:0px; padding:0px;">
<center>
<form name="form1" id="form1" method="post">
<center>
<div style="height:80px; border-bottom:5px solid #731F19; text-align:center; margin:0px; background:#666;">
<a onClick="window.location='../../index.php'"><img src="../SpitechLogo/Logo.png" width="200" height="100" style="margin-top:5px; opacity:1;padding:5px; border:2px solid #731F19;background:white; "/></a></div>

<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" style="width:500px; height:200px; border:5px solid #009AD0;" id="CommonTable">
  <tr>
    <th height="35" colspan="3" style="height:20px;">Fill Following Details</th>
    </tr>
  <tr>
    <td height="22" colspan="3">
 
      <?php ErrorMessage(); ?>
   </td>
    </tr>
  <tr>
    <td width="127" rowspan="4"><img src="../SpitechImages/Password-Recovery.png" width="125" height="116"></td>
    <td width="81" height="22">CODE ID</td>
    <td width="282"><input type="text" name="customer_code" id="customer_code" placeholder="USER ID" style="width:250px;" required maxlength="50"/></td>
  </tr>
 
 
  <tr>
    <td>EMAIL ID</td>
    <td><input type="email" name="customer_email" id="customer_email" placeholder="E-MAIL ID" style="width:250px;" required maxlength="50"/></td>
  </tr>

   <tr>
     <td>MOBILE&nbsp;NO</td>
    <td><input type="text" name="customer_mobile" id="customer_mobile" placeholder="MOBILE NO" style="width:250px;" required maxlength="10" <?php OnlyNumber(); ?>/></td>
  </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
 
  <tr>
    <td colspan="2"><div align="right"><a href="index.php" style="float:right; margin-top:10px; text-transform:capitalize; color:#FF8040">Go Back To Login </a></div></td>
    <td><input type="submit" name="ResetPassword" id="ResetPassword" value="Reset Password" /></td>
  </tr>
  
</table></form>
</center>
</body>