<?php
session_start();
include_once("../Menu/HeaderAdvisor.php");
include_once("../SpitechMailer/SpitechMailer.php");
Menu("User");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$USER_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_SESSION['advisor_id']);
if(isset($_POST['Submit']))
{
	//die(md5($_POST['old_password'])."=".$USER_ROW['advisor_password']);
	if(md5($_POST['old_password'])==$USER_ROW['advisor_password'])
	{
		if($_POST['new_password']==$_POST['new_password_repeat'])
		{		
			$FIELDS=array("advisor_password");				
		    $VALUES=array(md5($_POST["new_password"]));	
		    $UPDATE=$DBOBJ->Update("tbl_advisor",$FIELDS,$VALUES,"advisor_id",$_SESSION['advisor_id'],0);
			
			
			//=============( ENTRY IN ACTION TABLE )=======================================================
		    $DBOBJ->UserAdvisorAction(advisor_title." PASSWORD EDITED", " ID NO: ".$_SESSION['advisor_id'].", NAME : ".$_SESSION['advisor_name']);	
			
			//===============(EMAIL BODY)==================================================
			    $title='Your password of '.site_company_name.' account has changed with following details :';
				$Message=AdvisorMail($_SESSION['advisor_id'],$_POST["new_password"],$title);
				@SendDirectMail($USER_ROW['advisor_email'],$Message,site_company_name." Application : Password Changed",site_company_name);
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
    <center>
    <?php ErrorMessage();?>
    <fieldset style="width:700px;">
      <table width="98%" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">
        <tr>
          <td width="131">name</td>
          <td id="Value" style="color:red; font-size:13px;"><?php echo $USER_ROW['advisor_title']." ".$USER_ROW['advisor_name']?></td>
          <td id="Value" > 
         <!-- <script>ShowModal("EditProfile","700px","User_Edit_Profile.php","Edit Profile");</script>    
          <a id="Edit" style="float:right;"><span id="EditProfile">&nbsp;&nbsp;Edit&nbsp;Profile</span></a>--></td>
        </tr>
        <tr>
          <td>id code</td>
          <td style="color:RED; font-size:12PX;" id="Value" ><?php echo $USER_ROW['advisor_code']; ?></td>
          <td width="167" rowspan="9" style="color:RED; font-size:16PX; vertical-align:top; ">
		  <?php $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$USER_ROW['advisor_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $USER_ROW['advisor_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		
		 ?>
            <img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imgBorder"/></td>
        </tr>
        <tr>
          <td>LEVEL</td>
          <td id="Value" style="color:blue"><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$USER_ROW['advisor_level_id']);?></td>
        </tr>
        <tr>
          <td>father's&nbsp;name</td>
          <td width="356" id="Value" ><?php echo $USER_ROW['advisor_fname'];?></td>
        </tr>
        <tr>
          <td>sex</td>
          <td id="Value" ><?php echo $USER_ROW['advisor_sex'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">BLOOD GROUP</td>
          <td id="Value" ><?php echo $USER_ROW['advisor_bg'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">mobile no</td>
          <td id="Value" ><?php echo $USER_ROW['advisor_mobile'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">phone no</td>
          <td id="Value" ><?php echo $USER_ROW['advisor_sex'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">email id</td>
          <td id="Value" style="text-transform:none;"><?php echo $USER_ROW['advisor_email'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">PAN NO</td>
          <td id="Value" ><?php echo $USER_ROW['advisor_pan_no'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">OCCUPATION</td>
          <td colspan="2" id="Value" ><?php echo $USER_ROW['advisor_occupation'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">qualification</td>
          <td colspan="2" id="Value" ><?php echo $USER_ROW['advisor_qualification'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">address</td>
          <td colspan="2" id="Value" ><?php echo $USER_ROW['advisor_address'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">dob</td>
          <td colspan="2" id="Value" ><?php echo date('d-M-Y',strtotime($USER_ROW['advisor_dob']));?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">jOIning date </td>
          <td colspan="2" id="Value" ><?php echo date('d-M-Y',strtotime($USER_ROW['advisor_hire_date']));?></td>
        </tr>
        <tr>
          <td colspan="3"><h4>NAME PROPOSED BY (SPONSOR)</h4></td>
        </tr>
        <tr>
          <td>SPONSOR NAME <span style="line-height:13px; text-align:justify;"></span></td>
          <td colspan="2" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_title",$USER_ROW['advisor_sponsor'])." ".$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$USER_ROW['advisor_sponsor']); ?></td>
        </tr>
        <tr>
          <td>ID CODE</td>
          <td colspan="2" style="color:RED;" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$USER_ROW['advisor_sponsor']); ?></td>
        </tr>
        <tr>
          <td>LEVEL</td>
          <td colspan="2" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_level_id",$USER_ROW['advisor_sponsor']));?></td>
        </tr>
      </table></fieldset>
    </center>
</td></tr></table>
<?php include("../Menu/FooterAdvisor.php"); ?>
