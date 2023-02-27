<?php
session_start();
if($_SESSION['spitech_user_id']=="" || !$_SESSION['spitech_user_id']) { header("location:index.php"); }
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$EDIT_ROW=$DBOBJ->GetRow("tbl_site_settings","1","1");

if(isset($_POST['Set']))
{
		@mysqli_query($_SESSION['CONN'],"delete from tbl_site_settings");
		
	 	$FIELDS=array( 'site_name' ,
						'site_heading' ,						
						'site_url_home' ,
						'site_application_url' ,
						'site_company_name' ,
						'site_iso' ,
						'site_copyright' ,
						'advisor_title' ,
						'id_prefix' ,
						'email' ,
						'phone' ,
						'mobile' ,
						'address');											
		$VALUES=array($_POST['site_name'] ,
						$_POST['site_heading'] ,
						$_POST['site_url_home'] ,
						$_POST['site_application_url'] ,
						$_POST['site_company_name'] ,
						$_POST['site_iso'] ,
						$_POST['site_copyright'] ,
						$_POST['advisor_title'] ,
						$_POST['id_prefix'] ,
						$_POST['email'] ,
						$_POST['phone'] ,
						$_POST['mobile'] ,
						$_POST['address']);	
		
		$DBOBJ->Insert("tbl_site_settings",$FIELDS,$VALUES,1); 
		
		if($EDIT_ROW['id_prefix']!=$_POST['id_prefix'])
		{
			//=============( UPDATE CODE TO ALL DVISOR & CUSTOMER )=============================
				echo $ADV_Q="select advisor_id from tbl_advisor";
				$ADV_Q=@mysqli_query($_SESSION['CONN'],$ADV_Q);
				while($ADV=@mysqli_fetch_assoc($ADV_Q)) 
				{						
					$UPDATE_FIELDS=array("advisor_code");
					$UPDATE_VALUES=array($_POST['id_prefix'].str_pad($ADV['advisor_id'],3,"0",STR_PAD_LEFT));
					$DBOBJ->Update("tbl_advisor",$UPDATE_FIELDS,$UPDATE_VALUES,"advisor_id",$ADV['advisor_id'],0);
				}
			//=============( UPDATE CODE TO ALL DVISOR & CUSTOMER )=============================
				$CUST_Q="select customer_id from tbl_customer";
				$CUST_Q=@mysqli_query($_SESSION['CONN'],$CUST_Q);
				while($CUST=@mysqli_fetch_assoc($CUST_Q)) 
				{						
					$UPDATE_FIELDS=array("customer_code");
					$UPDATE_VALUES=array($_POST['id_prefix']."C".str_pad($CUST['customer_id'],3,"0",STR_PAD_LEFT));
					$DBOBJ->Update("tbl_customer",$UPDATE_FIELDS,$UPDATE_VALUES,"customer_id",$CUST['customer_id'],0);
				}	
		}
		
		header("location:Heading_Settings.php?Message=Data Saved Successfully");	
	
} 

?>
<link rel="stylesheet" href="../css/SpitechStyle.css">
<style>
#CommonTable tr td { background:white; }
</style>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="CommonTable" style="margin:0px; width:100%; height:100%; border:0px;">
<tr><th style="height:40px;"><div align="left">Heading Settings</div></th></tr>
  <tr>
    <td style="height:100%; vertical-align:top;">
<form name="form2" id="form2" method="post">
<table width="98%" align="left" border="0" cellspacing="1" cellpadding="2" style="width:700px;" id="Data-Table">
  <tr>
    <th height="35" colspan="2" style="height:20px;">Set Details</th>
    </tr>
  
  <tr><td height="22" colspan="2"> <?php ErrorMessage(); ?></td></tr>
    
  <tr><th height="22">FIELDS</th>
    <th height="22">VALUES</th>
  </tr>
    
  <tr>
    <td width="129" height="22"><div align="left">site name</div></td>
    <td width="560">
    	<input type="input" name="site_name" id="site_name" value="<?php echo $EDIT_ROW['site_name']?>" placeholder="Site Name" style="width:100%;" required maxlength="100"/>
    </td>
  </tr>
  <tr>
    <td height="22"><div align="left">site heading</div></td>
    <td><input type="input" name="site_heading" id="site_heading" value="<?php echo $EDIT_ROW['site_heading']?>" placeholder="Site Heading" style="width:100%;" required maxlength="100"/></td>
  </tr>
  <tr>
    <td height="22"><div align="left">site url home</div></td>
    <td><input type="input" name="site_url_home" id="site_url_home" value="<?php echo $EDIT_ROW['site_url_home']?>" placeholder="Site Url Home" style="width:100%;"  maxlength="100"/></td>
  </tr>
  <tr>
    <td height="22"><div align="left">site&nbsp;application&nbsp;url</div></td>
    <td><input type="input" name="site_application_url" id="site_application_url" value="<?php echo $EDIT_ROW['site_application_url']?>" placeholder="Site Application Url" style="width:100%;"  maxlength="100"/></td>
  </tr>
  <tr>
    <td height="22"><div align="left">site&nbsp;company&nbsp;name</div></td>
    <td><input type="input" name="site_company_name" id="site_company_name" value="<?php echo $EDIT_ROW['site_company_name']?>" placeholder="Site Company Name" style="width:100%;" required maxlength="100"/></td>
  </tr>
  <tr>
    <td height="22"><div align="left">advisor title</div></td>
    <td><input type="input" name="advisor_title" id="advisor_title" value="<?php echo $EDIT_ROW['advisor_title']?>" placeholder="Advisor Title" style="width:100%;" required maxlength="100"/></td>
  </tr>
  <tr>
    <td height="22"><div align="left">id prefix</div></td>
    <td><input type="input" name="id_prefix" id="id_prefix" value="<?php echo $EDIT_ROW['id_prefix']?>" placeholder="ID Prefix" style="width:100%;" required maxlength="100"/></td>
  </tr>
  <tr>
    <td height="22"><div align="left">email</div></td>
    <td><input type="input" name="email" id="email" value="<?php echo $EDIT_ROW['email']?>" placeholder="Email" style="width:100%;" maxlength="100"/></td>
  </tr>
  <tr>
    <td height="22"><div align="left">phone</div></td>
    <td><input type="input" name="phone" id="phone" value="<?php echo $EDIT_ROW['phone']?>" placeholder="Phone" style="width:100%;" maxlength="100"/></td>
  </tr>
  <tr>
    <td height="22"><div align="left">mobile</div></td>
    <td><input type="input" name="mobile" id="mobile" value="<?php echo $EDIT_ROW['mobile']?>" placeholder="mobile" style="width:100%;" required maxlength="100"/></td>
  </tr>
  <tr>
    <td height="22"><div align="left">address</div></td>
    <td><input type="input" name="address" id="address" value="<?php echo $EDIT_ROW['address']?>" placeholder="address" style="width:100%;" required maxlength="200"/></td>
  </tr>
 
  <tr>
    <tH colspan="2">
      <div align="right">
        <input type="submit" name="Set" id="Set" value="Set Details" <?php Confirm("Are you Sure ? \\nSave details ?")?> />
        <input type="submit" name="Cancel" id="Cancel" class="Cancel" value="Cancel" onClick="window.location='index.pph?<?php echo md5("Cancel")?>=<?php echo md5("OK")?>' " />
        </div>
      </tH>
  </tr>
  
</table>
</form>
</td></tr>
<tr><td style="height:100%;">&nbsp;</td></tr>
</table>
