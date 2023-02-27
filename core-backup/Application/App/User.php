<?php
session_start();
 include_once("../Menu/HeaderAdmin.php");
 include_once("../Menu/Define.php");
 include_once("../SpitechMailer/SpitechMailer.php");
 include_once("../php/MailFunction.php");
 
Menu("User");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
NoUser();



$USER_ROW=$DBOBJ->GetRow("tbl_admin_user","user_id",$_SESSION['user_id']);

if(isset($_POST['Submit']))
{
	
	if(md5($_POST['old_password'])==$USER_ROW['user_password'])
	{
		if($_POST['new_password']==$_POST['new_password_repeat'])
		{
		
			$FIELDS=array("user_password");				
		    $VALUES=array(md5($_POST["new_password"]));	
		    $UPDATE=$DBOBJ->Update("tbl_admin_user",$FIELDS,$VALUES,"user_id",$_SESSION['user_id'],0);		
						
			$DBOBJ->UserAction("USER PASSWORD CHANGED","");		  		 	
			
			//===============(EMAIL BODY)==================================================
			   $title='Your password of '.site_company_name.' account has changed with following details :';
				$Message=UserMail($_SESSION["user_id"],$_POST["new_password"],$title);
				@SendDirectMail($USER_ROW['user_email_id'],$Message,site_company_name." Application : Password Changed",site_company_name);
			//============================================================================
			session_destroy();
			echo "<script>alert('Your Password Have Been Successfully Update. Please Login Again With New Changes.');window.location='index.php';</script>";
			
		}		
		else
		{
			header("location:User.php?Error=New Password And Repeat Password Does Not Match");
		}		
	}
	else
	{
		header("location:User.php?Error=Old Password Does Not Match");
	}
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" /> 

<h1><img src="../SpitechImages/Payment1.png" />User : <span>Profile</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td >
	
    <center><?php ErrorMessage(); ?>
    <fieldset style="width:600px; height:250px;">
    <table width="500" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;" onMouseOver="Res();">
  
      <tr>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="3" id='Value2'  style="color:maroon; font-size:14px; text-decoration:none;" >&nbsp;</td>
        <td width="100" style="text-align:center">&nbsp;</td>
        <td width="101" style=" vertical-align:top">
          
        </td>
      </tr>
      <tr>
    <td width="12"></td>
    <td width="85">User ID</td>
    <td colspan="3" id='Value'  style="color:maroon; font-size:14px; text-decoration:none;" ><?php echo $USER_ROW['user_id']; ?> 
    </td>
    <td width="100" rowspan="5" style="text-align:center"><?php  
		  $ACTUAL_PHOTO="../SpitechUploads/admin/profile_photo/".$USER_ROW['user_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!=1 || $USER_ROW['user_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Default.png";}	
		  
		  ?>
      <img src="<?php echo $ACTUAL_PHOTO; ?>" width="117" height="132" id="image" style="border:5px solid gray;" /></td>
    <td width="101" rowspan="2" style=" vertical-align:top">
       <!-- <script>ShowModal("EditUserProfile","700px","User_Edit_Profile.php","Edit Profile");</script>  
    	<a id="Edit" style="float:right; margin-top:0px;"><span id="EditUserProfile">&nbsp;&nbsp;Edit&nbsp;Profile</span></a>-->
    </td>
      </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Full Name</td>
    <td colspan="3"  id='Value' style="text-transform:none;"><?php echo $USER_ROW['user_name']; ?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Category</td>
    <td colspan="3" id='Value' style="text-transform:none;" ><?php echo $USER_ROW['user_category']; ?></td>
    <td width="101" style=" vertical-align:top">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>E-MAIL ID</td>
    <td colspan="3" id='Value' style="text-transform:none;"><?php echo $USER_ROW['user_email_id']; ?></td>
    <td width="101" style=" vertical-align:top">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Mobile</td>
    <td width="164" id='Value' ><?php echo $USER_ROW['user_mobile']; ?></td>
    <td width="76">&nbsp;</td>
    <td width="102" id='Value' >&nbsp;</td>
    <td width="101" style=" vertical-align:top">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="7"><h4>Last Access Details</h4></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Date</td>
    <td colspan="2" id='Value'><span style="color:maroon;"><?php echo date('d-M-Y',strtotime($USER_ROW['user_last_access_date'])); ?></span></td>
    <td>Time</td>
    <td colspan="2" id='Value' ><?php echo $USER_ROW['user_last_access_time']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>IP</td>
    <td colspan="5" id='Value' ><?php  echo $USER_ROW['user_last_access_ip']; ?></td>
  </tr>



    </table></fieldset>
</center>
</td></tr></table>
<?php include("../Menu/Footer.php"); ?>
