<?php
session_start();
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../SpitechMailer/SpitechMailer.php");
include_once("../Menu/Define.php");
include_once("../php/MailFunction.php");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$EDIT_ROW=$DBOBJ->GetRow("tbl_admin_user","user_id",$_SESSION["user_id"]);	

if(isset($_POST['Submit']))
{	
			$user_photo=FileUpload($_FILES['user_photo'],"../SpitechUploads/admin/profile_photo/","1");
			if($user_photo=="" && $user_photo==NULL )
			{
				$user_photo=$EDIT_ROW["user_photo"];
			}
			else
			{
				@unlink("../SpitechUploads/admin/profile_photo/".$EDIT_ROW["user_photo"]);
			}
			
			$FIELDS=array(  "user_name",								
							"user_email_id",
							"user_mobile",
							"user_photo");											
		    $VALUES=array(  $_POST["user_name"],						
							$_POST["user_email_id"],
							$_POST["user_mobile"],
							$user_photo);	
							
		    $UPDATE=$DBOBJ->Update("tbl_admin_user",$FIELDS,$VALUES,"user_id",$_SESSION['user_id'],0);
			
			//=================(Message Body)===================================================================================
			    $title="Your profile of <b>".site_company_name."</b> account has successfully edited. Your profile details as follows :";
				$Message=UserMail($_SESSION['user_id'],"...",$title)	;		
				@SendDirectMail($EDIT_ROW["user_email_id"],$Message,site_company_name." Application : Profile Edited",site_company_name);
			//====================================================================================================================
			$DBOBJ->UserAction("USER PROFILE EDITED","");
			header("location:User.php?Message=Profile Edited Successfully");	   
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<head><title>User : Create/Edit New User</title></head>
    <center>
 
   <form id="FrmUser" name="FrmUser" method="post" enctype="multipart/form-data" action="User_Edit_Profile.php">
    <table width="590" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">

  <tr>
    <td width="120">user login id  <B class="Required">*</B></td>
    <td width="227" style="color:red; text-transform:none;"><?php echo $EDIT_ROW['user_id'];?></td>
    <td width="213" rowspan="6" style="vertical-align:top;">
	
	<?php $ACTUAL_PHOTO="../SpitechUploads/admin/profile_photo/".$EDIT_ROW['user_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $EDIT_ROW['user_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Default.png"; }
		 ?>
      <img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="image"/></td>
  </tr>
  <tr>
    <td>full name <B class="Required">*</B></td>
    <td><input type="text" name="user_name" id="user_name" placeholder="FULL NAME" required="required"  value="<?php echo $EDIT_ROW['user_name'];?>"maxlength="50"/></td>
    </tr>
  <tr>
    <td>User Category <B class="Required">*</B></td>
    <td style="text-transform:none;"><?php echo $EDIT_ROW['user_category']; ?></td>
    </tr>
  <?php if(!isset($_SESSION['user_id'])) { ?>
  <?php } ?>
  <tr>
    <td>email address  <B class="Required">*</B></td>
    <td><input type="email" name="user_email_id" id="user_email_id" placeholder="E-Mail Id" required="required" value="<?php echo $EDIT_ROW['user_email_id'];?>" maxlength="50"/></td>
    </tr>
  <tr>
    <td>mobile no  <B class="Required">*</B></td>
    <td><input type="text" name="user_mobile" id="user_mobile" placeholder="Mobile" required="required" value="<?php echo $EDIT_ROW['user_mobile'];?>" maxlength="10"/></td>
    </tr>
  <tr>
    <td>PROFILE PHOTO  <B class="Required">*</B></td>
    <td> <input type="file" name="user_photo" id="user_photo"  value="" /></td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:RIGHT">
      <input type="submit" name="Submit" id="Submit" class="Button" value="Save Profile " <?php Confirm("Are You Sure ? Save Profile ? "); ?>/>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.location='User.php';" />
      </td>
  </tr>
</table>
</form>

</center>


