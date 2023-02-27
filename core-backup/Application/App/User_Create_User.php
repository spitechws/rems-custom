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
NoAdmin();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$EDIT_ROW=$DBOBJ->GetRow("tbl_admin_user","user_id",$_GET[md5("edit_id")]);	
if(isset($_GET[md5('edit_id')]))
{
	$EDIT_ROW=$DBOBJ->GetRow("tbl_admin_user","user_id",$_GET[md5("edit_id")]);	
	$title="Edit User Profile";
}
else
{
	$title="Create New User";
}

if(isset($_POST['Submit']))
{
	if(isset($_GET[md5("edit_id")]))
	{
		$USER_EXIST=@mysqli_num_rows(@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_admin_user where user_id='".$_POST["user_id"]."' and  user_id!='".$_GET[md5("edit_id")]."'")); 
		
		
		if($USER_EXIST>0) 
		{ 
			header("location:User_Create_User.php?".md5("edit_id")."=".$_GET[md5("edit_id")]."&Error=User : ".$_POST["user_id"]." Already Exists.");
		}
		
		else
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
			
			$FIELDS=array("user_id",
							"user_name",							
							"user_category",
							"user_email_id",
							"user_mobile",
							"user_photo",
							"user_status",
							"user_created_by",
							"user_created_by_ip",
							"user_created_by_date",
							"user_created_by_time");											
		    $VALUES=array($_POST["user_id"],
							$_POST["user_name"],							
							$_POST["user_category"],
							$_POST["user_email_id"],
							$_POST["user_mobile"],
							$user_photo,
							$_POST["user_status"],
							$_SESSION['user_id'],
							GetIP(),
							date('Y-m-d'),
							IndianTime());	
							
		    $UPDATE=$DBOBJ->Update("tbl_admin_user",$FIELDS,$VALUES,"user_id",$_GET[md5("edit_id")],0);		
					 			
			$DBOBJ->UserAction("USER PROFILE EDITED","USER ID : ".$_POST["user_id"]." NAME : ".$_POST["user_name"]);			
			//======================(EMAIL BODY)========================
			if($EDIT_ROW['user_status']=='1')
			{
				$title="Your profile of <b>".site_company_name."</b> account edited by <b>".$_SESSION['user_id']."</b>. Details are as follows :";
				$Message=UserMail($_POST["user_id"],$_POST["user_password"],$title);			
				@SendDirectMail($_POST["user_email_id"],$Message,site_company_name." Application : Login Details",site_company_name);
			}
			//==========================================================
			//header("location:User_Manage_User.php?Message=User Edited");
			UnLoadMe();
	    }
	 }
	else
	{
		$USER_EXIST=@mysqli_num_rows(@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_admin_user where user_id='".$_POST["user_id"]."'"));
		
		
		if($USER_EXIST>0) { header("location:User_Manage_User.php?Error=User : ".$_POST["user_id"]." Already Exists.");}
		
		else
		{
			$user_photo=FileUpload($_FILES['user_photo'],"../SpitechUploads/admin/profile_photo/","1");
			$FIELDS=array("user_id",
							"user_name",
							"user_password",
							"user_category",
							"user_email_id",
							"user_mobile",
							"user_photo",
							"user_status",
							"user_created_by",
							"user_created_by_ip",
							"user_created_by_date",
							"user_created_by_time");											
		    $VALUES=array($_POST["user_id"],
							$_POST["user_name"],
							md5($_POST["user_password"]),
							$_POST["user_category"],
							$_POST["user_email_id"],
							$_POST["user_mobile"],
							$user_photo,
							$_POST["user_status"],
							$_SESSION['user_id'],
							GetIP(),
							date('Y-m-d'),
							IndianTime());	
		    $UPDATE=$DBOBJ->Insert("tbl_admin_user",$FIELDS,$VALUES,0);
			
				
			$DBOBJ->UserAction("USER PROFILE EDITED","USER ID : ".$_POST["user_id"]." NAME : ".$_POST["user_name"]);
			//======================(EMAIL BODY)========================
			    $title="Congratulations ! your account created in <b>".site_company_name."</b>, details are as follows :";
				$Message=UserMail($_POST["user_id"],$_POST["user_password"],$title);			
				@SendDirectMail($_POST["user_email_id"],$Message,site_company_name." Application : Login Details",site_company_name);
			//==========================================================
			//header("location:User_Manage_User.php?Message=New User Created");
			UnLoadMe();
		}
	}
	
	
	
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />

    <center>

   <form id="FrmUser" name="FrmUser" method="post" enctype="multipart/form-data">
   <fieldset style="width:600px; margin:0px; padding:0px">
   <legend><?php echo $title?></legend>
    <table width="590" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;" >
  <tr>
    <td colspan="3"><?php ErrorMessage(); ?></td>
    </tr>
  <tr>
    <td width="120">user&nbsp;login&nbsp;id&nbsp;<B class="Required">*</B></td>
    <td width="227">
   
    <input type="text" name="user_id" id="user_id" placeholder="User ID" required="" <?php if(isset($_GET[md5("edit_id")]) || strtoupper($EDIT_ROW['user_id'])=='ADMIN') { echo " readonly='readonly' "; } ?> value="<?php echo $EDIT_ROW['user_id'];?>" maxlength="50" />
    </td>
    <td width="213" rowspan="8" style="vertical-align:top">
    <?php $ACTUAL_PHOTO="../SpitechUploads/admin/profile_photo/".$EDIT_ROW['user_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $EDIT_ROW['user_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Default.png"; }
		  if(!isset($_GET[md5('edit_id')])) {$ACTUAL_PHOTO="../SpitechImages/Default.png"; }
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imguser_photo" style="border:1px solid maroon"/>    </td>
  </tr>
  <tr>
    <td>full name <B class="Required">*</B></td>
    <td><input type="text" name="user_name" id="user_name" placeholder="FULL NAME" required="required"  value="<?php echo $EDIT_ROW['user_name'];?>"maxlength="50"/></td>
    </tr>
  <tr>
    <td>User&nbsp;Category <B class="Required">*</B></td>
    <td>
      <?php if(isset($_GET[md5("edit_id")]) && strtoupper($EDIT_ROW['user_id'])=='ADMIN') { ?>
      <input type="text" id="user_category" name="user_category" required="" readonly="readonly" value="<?php echo $EDIT_ROW['user_category']; ?>" />
      <?php } else { ?>
      <select id="user_category" name="user_category" required="">
        <option value="admin" <?php SelectSelected("admin",$EDIT_ROW['user_category']); ?>>Admin</option>
        <option value="account" <?php SelectSelected("account",$EDIT_ROW['user_category']); ?>>Account</option>
        <option value="DEO" <?php SelectSelected("DEO",$EDIT_ROW['user_category']); ?>>Data Entry Operator</option>
        </select> 
      <?php } ?>     
    </td>
    </tr>
  <?php if(!isset($_GET[md5("edit_id")])) { ?>
  <tr>
    <td>password  <B class="Required">*</B></td>
    <td><input type="text" name="user_password" id="user_password" placeholder="PASSWORD" required="" value="<?php echo RandomPassword(); ?>" style="text-transform:none;" /></td>
    </tr>
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
    <td>PROFILE&nbsp;PHOTO  <B class="Required">*</B></td>
    <td> 

    <?php 	FileImageInput("user_photo",$ACTUAL_PHOTO,100)
    ?>
    </td>
    </tr>
  <tr>
    <td>status  <B class="Required">*</B></td>
    <td>
      <select id="user_status" name="user_status" required="">
        <option value="1">ACTIVE</option>
        <option value="2">INACTIVE</option>
        </select>
    </td>
    </tr>
  <tr>
    <td colspan="3" style="text-align:RIGHT">
      <input type="submit" name="Submit" id="Submit" class="Button" value="Save User Info " <?php Confirm("Are You Sure ? Save User Details ? "); ?>/>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.close();" />
      </td>
  </tr>
</table>
</fieldset>
</form>

</center>


