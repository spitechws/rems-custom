<?php
session_start();
include_once("../Menu/HeaderCustomer.php");
include_once("../SpitechMailer/SpitechMailer.php");

Menu("User");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$USER_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$_SESSION['customer_id']);
if(isset($_POST['Submit']))
{	
	if(md5($_POST['old_password'])==$USER_ROW['customer_password'])
	{
		if($_POST['new_password']==$_POST['new_password_repeat'])
		{		
			$FIELDS=array("customer_password");				
		    $VALUES=array(md5($_POST["new_password"]));	
		    $UPDATE=$DBOBJ->Update("tbl_customer",$FIELDS,$VALUES,"customer_id",$_SESSION['customer_id'],0);
			
			$title='Your password of '.site_company_name.' account has changed with following details :';
			$Message=CustomerMail($_SESSION['customer_id'],$_POST["new_password"],$title);
			//=============( ENTRY IN ACTION TABLE )=======================================================
		    $DBOBJ->UserAdvisorAction("CUSTOMER PASSWORD EDITED", "ID NO: ".$_SESSION['customer_code'].", NAME : ".$_SESSION['customer_name']);		  		 	
			@SendDirectMail($USER_ROW['customer_email'],$Message,site_company_name." Application : Password Changed",site_company_name);
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
<h1><img src="../SpitechImages/Customer.png" />Profile : </h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td >	
    <center>
    <?php ErrorMessage();?>
    <fieldset style="width:700px;">
      <table width="98%" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:25px; margin-bottom:25px;">
        <tr>
          <td width="131">name</td>
          <td id="Value" style="color:red; font-size:13px;"><?php echo $USER_ROW['customer_title']." ".$USER_ROW['customer_name']?></td>
          <td id="Value" > </td>
        </tr>
        <tr>
          <td>id code</td>
          <td style="color:blue; font-size:12PX;" id="Value" ><?php echo $USER_ROW['customer_code']; ?></td>
          <td width="167" rowspan="7" style="color:RED; font-size:16PX; vertical-align:top; "><?php $ACTUAL_PHOTO="../SpitechUploads/customer/profile_photo/".$USER_ROW['customer_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $USER_ROW['customer_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }
		
		 ?>
            <img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imgBorder"/></td>
        </tr>
        <tr>
          <td>father's&nbsp;name</td>
          <td width="356" id="Value" ><?php echo $USER_ROW['customer_fname'];?></td>
        </tr>
        <tr>
          <td>sex</td>
          <td id="Value" ><?php echo $USER_ROW['customer_sex'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">BLOOD GROUP</td>
          <td id="Value" ><?php echo $USER_ROW['customer_bg'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">mobile no</td>
          <td id="Value" ><?php echo $USER_ROW['customer_mobile'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">phone no</td>
          <td id="Value" ><?php echo $USER_ROW['customer_sex'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">email id</td>
          <td id="Value" style="text-transform:none; color:blue"><?php echo $USER_ROW['customer_email'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">OCCUPATION</td>
          <td colspan="2" id="Value" ><?php echo $USER_ROW['customer_occupation'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">address</td>
          <td colspan="2" id="Value" ><?php echo $USER_ROW['customer_address'];?></td>
        </tr>
        <tr>
          <td style="line-height:13px; text-align:justify;">dob</td>
          <td colspan="2" id="Value" ><?php echo date('d-M-Y',strtotime($USER_ROW['customer_dob']));?></td>
        </tr>
        <tr>
          <td colspan="3"><h4>NOMINEE DETAILS</h4></td>
        </tr>
        <tr>
          <td>NAME<span style="line-height:13px; text-align:justify;"></span></td>
          <td colspan="2" id="Value" ><?php echo $USER_ROW['customer_nominee_name']; ?></td>
        </tr>
        <tr>
          <td>RELATION</td>
          <td colspan="2" style="color:RED;" id="Value" ><?php echo $USER_ROW['customer_relation_with_nominee'];?></td>
        </tr>
        <tr>
          <td>MOBILE</td>
          <td colspan="2" id="Value" ><?php echo $USER_ROW['customer_nominee_mobile'];?></td>
        </tr>
         <tr>
          <td>PHONE</td>
          <td colspan="2" id="Value" ><?php echo $USER_ROW['customer_nominee_phone'];?></td>
        </tr>
         <tr>
          <td>ADDRESS</td>
          <td colspan="2" id="Value" ><?php echo $USER_ROW['customer_nominee_address'];?></td>
        </tr>
         <tr>
           <td>DOB</td>
           <td colspan="2" id="Value" ><?php echo date('d-M-Y',strtotime($USER_ROW['customer_nominee_dob']));?></td>
         </tr>
      </table>
    </fieldset>
    </center>
</td></tr></table>
<?php include("../Menu/FooterAdvisor.php"); ?>
