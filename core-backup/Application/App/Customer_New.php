<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Customer");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();


$ID_Q="SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_customer' ";
$ID_Q=@mysqli_query($_SESSION['CONN'],$ID_Q);
$ID_ROW=@mysqli_fetch_array($ID_Q);
$ID_NO=$ID_ROW[0];

$ID_NO=id_prefix."C".str_pad($ID_NO,3,"0",STR_PAD_LEFT);

$title="Register New Customer"; 
$customer_dob=date('1900-01-01');
$customer_anniversary_date=date('1900-01-01');
$customer_reg_date=date('Y-m-d');	
$customer_nominee_dob=date('1900-01-01');

if(isset($_GET[md5('edit_id')]))
{
  $EDIT_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$_GET[md5('edit_id')]);
  $ID_NO=$EDIT_ROW['customer_code'];
  $title="Edit Customer Profile";
  $customer_dob=$EDIT_ROW['customer_dob'];
  $customer_anniversary_date=$EDIT_ROW['customer_anniversary_date'];
  $customer_reg_date=$EDIT_ROW['customer_reg_date'];
  $customer_nominee_dob=$EDIT_ROW['customer_nominee_dob'];
}

if(isset($_POST['Save']))
{
	           $customer_photo=FileUpload($_FILES['customer_photo'],"../SpitechUploads/customer/profile_photo/","1");				 
				
				//=================( Checking Student's Photo )==============================================================
				  if(($customer_photo=="" || $customer_photo==NULL) && $_GET[md5("edit_id")]>0 )
				  {
					  $customer_photo=$EDIT_ROW['customer_photo'];
				  }
				  if($_GET[md5("edit_id")]>0 && $customer_photo!=$EDIT_ROW['customer_photo'])
				  {
				    @unlink("../SpitechUploads/customer/profile_photo/".$EDIT_ROW['customer_photo']);
				  }				
	
  	if(isset($_GET[md5("edit_id")]))
	{ 	
	  $FIELDS=array("customer_title" ,	  				
					"customer_name" ,
					"customer_fname" ,
					"customer_phone" ,
					"customer_mobile" ,
					"customer_email" ,
					"customer_whatsapp_no",
					"customer_marital_status",		
					"customer_sex" ,
					"customer_bg" ,
					"customer_dob" ,
					"customer_anniversary_date",
					"customer_reg_date" ,
					"customer_pan" ,
					"customer_address" ,
					"customer_city" ,
					"customer_photo" ,
					"customer_occupation" ,
					"customer_designation" ,
					"customer_anual_income" ,
					"customer_nominee_name" ,
					"customer_nominee_dob" ,
					"customer_relation_with_nominee" ,
					"customer_nominee_mobile" ,
					"customer_nominee_phone" ,
					"customer_nominee_address" ,	
					"customer_status",				
					"edited_details");	
				   
	  $VALUES=array($_POST["customer_title"] ,	  				
					$_POST["customer_name"] ,
					$_POST["customer_fname"] ,
					$_POST["customer_phone"] ,
					$_POST["customer_mobile"] ,
					$_POST["customer_email"] ,
					$_POST["customer_whatsapp_no"],
					$_POST["customer_marital_status"],		
					$_POST["customer_sex"] ,
					$_POST["customer_bg"] ,
					$_POST["customer_dob"] ,
					$_POST["customer_anniversary_date"],
					$_POST["customer_reg_date"] ,
					$_POST["customer_pan"] ,
					$_POST["customer_address"] ,
					$_POST["customer_city"] ,
					$customer_photo ,
					$_POST["customer_occupation"] ,
					$_POST["customer_designation"] ,
					$_POST["customer_anual_income"] ,
					$_POST["customer_nominee_name"] ,
					$_POST["customer_nominee_dob"] ,
					$_POST["customer_relation_with_nominee"] ,
					$_POST["customer_nominee_mobile"] ,
					$_POST["customer_nominee_phone"] ,
					$_POST["customer_nominee_address"] ,
					$_POST["customer_status"],						
					CreatedEditedByUserMessage());
					
		$DBOBJ->Update("tbl_customer",$FIELDS,$VALUES,"customer_id",$_GET[md5("edit_id")],0);
		$MAX_ID=$_GET[md5("edit_id")];			
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAction("CUSTOMER PROFILE EDITED", " ID : ".$MAX_ID.", NAME : ".$_POST['customer_name']);
				
		 $Message="CUSTOMER PROFILE EDITED SUCCESSFULLY.";	
         header("location:Customer.php?Message".$Message);
	}
	else
	{
		$FIELDS=array(  "customer_title" ,"customer_password",
						"customer_name" ,
						"customer_fname" ,
						"customer_phone" ,
						"customer_mobile" ,
						"customer_email" ,
						"customer_whatsapp_no",
					    "customer_marital_status",		
						"customer_sex" ,
						"customer_bg" ,
						"customer_dob" ,
						"customer_anniversary_date",
						"customer_reg_date" ,
						"customer_pan" ,
						"customer_address" ,
						"customer_city" ,
						"customer_photo" ,
						"customer_occupation" ,
						"customer_designation" ,
						"customer_anual_income" ,
						"customer_nominee_name" ,
						"customer_nominee_dob" ,
						"customer_relation_with_nominee" ,
						"customer_nominee_mobile" ,
						"customer_nominee_phone" ,
						"customer_nominee_address" ,
						"created_details" ,
						"edited_details" ,						
						"last_access_details",
						'customer_status');	
		$VALUES=array(  $_POST["customer_title"], md5($_POST["customer_password"]),
						$_POST["customer_name"] ,
						$_POST["customer_fname"] ,
						$_POST["customer_phone"] ,
						$_POST["customer_mobile"] ,
						$_POST["customer_email"] ,
						$_POST["customer_whatsapp_no"],
					    $_POST["customer_marital_status"],					
						$_POST["customer_sex"] ,
						$_POST["customer_bg"] ,
						$_POST["customer_dob"] ,
						$_POST["customer_anniversary_date"],
						$_POST["customer_reg_date"] ,
						$_POST["customer_pan"] ,
						$_POST["customer_address"] ,
						$_POST["customer_city"] ,
						$customer_photo,
						$_POST["customer_occupation"] ,
						$_POST["customer_designation"] ,
						$_POST["customer_anual_income"] ,
						$_POST["customer_nominee_name"] ,
						$_POST["customer_nominee_dob"] ,
						$_POST["customer_relation_with_nominee"] ,
						$_POST["customer_nominee_mobile"] ,
						$_POST["customer_nominee_phone"] ,
						$_POST["customer_nominee_address"] ,
						$Mess=CreatedEditedByUserMessage(),
						$Mess,
						"",
						$_POST['customer_status']);	
		$DBOBJ->Insert("tbl_customer",$FIELDS,$VALUES,0);	
		$MAX_ID=$DBOBJ->MaxID("tbl_customer","customer_id");
		
		//=============( UPDATE CODE TO NEW Associate WITH NEW ID INSERTED )=============================
		$UPDATE_FIELDS=array("customer_code");
		$UPDATE_VALUES=array(id_prefix."C".str_pad($MAX_ID,3,"0",STR_PAD_LEFT));
		$DBOBJ->Update("tbl_customer",$UPDATE_FIELDS,$UPDATE_VALUES,"customer_id",$MAX_ID,0);
		
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAction("NEW CUSTOMER REGISTERED", " ID : ".$MAX_ID.", NAME : ".$_POST['customer_name']);
		
		$Message="CUSTOMER REGISTERED SUCCESSFULLY.";
		//header("location:Project_Property_Booking.php?".md5("booking_customer_id")."=".$MAX_ID);		
		
		//$Message=customer_title." REGISTERED SUCCESSFULLY.";
		header("location:Customer_New_Next.php?".md5("customer_id")."=".$MAX_ID."&".md5("customer_password")."=".$_POST['customer_password']);
		
		
	 }
}

	 
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/CustomerNew.png" width="31" height="32" />Customer  : <span>New Entry/Edit</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">
    <center>
    <?php ErrorMessage(); ?>
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
    <center>
    <fieldset style="width:700px; margin:0px; padding:0px;">
   <legend><?php echo $title;?></legend>
    <?php MessageError(); ?>
<table width="98%" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">
  
  <form name="CustomerForm" id="CustomerForm" method="post" enctype="multipart/form-data" >  
    <tr>
      <td colspan="3"><H4>CUSTOMER DETAILS</H4></td>
      <td width="145" style="vertical-align:top;">
     
      
     
     </td>
      <td width="101">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>id code &nbsp;<b class="Required">*</b></td>
      <td style="color:RED; font-size:16PX;"><?php echo $ID_NO;?></td>
      <td width="145">&nbsp;</td>
      <td width="101">&nbsp;</td>
      </tr>
       
   
    <?php  if(!isset($_GET[md5('edit_id')])) { ?>
    <tr>
      <td>&nbsp;</td>
      <td>PASSWORD &nbsp;<b class="Required">*</b></td>
      <td colspan="2">
      <input type="text" name="customer_password" id="customer_password" placeholder="PASSWORD" required="required" value="<?php echo RandomPassword(); ?>" maxlength="50"/>
      </td>
      <td width="101">&nbsp;</td>
      
    </tr>
    <?php } ?>
    <tr>
      <td width="15">&nbsp;</td>
      <td width="180">name <b class="Required">&nbsp;<b class="Required">*</b></b></td>
      <td>
        <div align="left" style="width:280PX;">
          <select id="customer_title" name="customer_title" style="width:60PX;">
            <option value="MR." <?php SelectedSelect("MR.", $EDIT_ROW['customer_title']); ?>>MR.</option>
            <option value="MRS." <?php SelectedSelect("MRS.", $EDIT_ROW['customer_title']); ?>>MRS.</option>
            <option value="MISS" <?php SelectedSelect("MISS", $EDIT_ROW['customer_title']); ?>>MISS</option>
            <option value="ER." <?php SelectedSelect("ER.", $EDIT_ROW['customer_title']); ?>>ER.</option>
            <option value="DR." <?php SelectedSelect("DR.", $EDIT_ROW['customer_title']); ?>>DR.</option>
            </select>
          <input type="text" name="customer_name" id="customer_name" placeholder="FULL NAME" required="required" value="<?php echo $EDIT_ROW['customer_name']; ?>" maxlength="50"/>
          </div>
      </td>
      <td width="145" rowspan="8" style="vertical-align:top">
      <?php $ACTUAL_PHOTO="../SpitechUploads/customer/profile_photo/".$EDIT_ROW['customer_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $EDIT_ROW['customer_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }
		  if(!isset($_GET[md5('edit_id')])) { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }
		 ?>
      <img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imgcustomer_photo" style="border:1px solid maroon"/>
      </td>
      <td width="101">&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:12px;">father's/HUSBAND'S name&nbsp;&nbsp;<b class="Required">*</b></td>
      <td ><input type="text" name="customer_fname" id="customer_fname" placeholder="FATHER'S NAME"  value="<?php echo $EDIT_ROW['customer_fname']; ?>" maxlength="50" required='required'/></td>
      <td width="101">&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>sex <b class="Required">&nbsp;<b class="Required">*</b></b></td>
      <td >      
        <select id="customer_sex" name="customer_sex">
          <option value="MALE" <?php SelectedSelect("MALE", $EDIT_ROW['customer_sex']); ?>>MALE</option>
          <option value="FEMALE" <?php SelectedSelect("FEMALE", $EDIT_ROW['customer_sex']); ?>>FEMALE</option>         
          </select>
      </td>
      <td width="101">&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>MARITAL STATUS &nbsp;<b class="Required">*</b></td>
      <td ><select id="customer_marital_status" name="customer_marital_status" required='required'>
        <option value="Unmarried" <?php SelectedSelect("Unmarried", $EDIT_ROW['customer_marital_status']); ?>>Unmarried</option>
        <option value="Married" <?php SelectedSelect("Married", $EDIT_ROW['customer_marital_status']); ?>>Married</option>
        <option value="Separated" <?php SelectedSelect("Separated", $EDIT_ROW['customer_marital_status']); ?>>Separated</option>
        <option value="Divorced" <?php SelectedSelect("Divorced", $EDIT_ROW['customer_marital_status']); ?>>Divorced</option>
        <option value="Separated" <?php SelectedSelect("Widowed", $EDIT_ROW['customer_marital_status']); ?>>Widowed</option>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">photo <b class="Required">&nbsp;<b class="Required">*</b></b></td>
      <td width="291" style="vertical-align:top;">
        <?php         FileImageInput("customer_photo",$ACTUAL_PHOTO,100)
		?>
        
      </td>
      <td width="101">&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">BLOOD GROUP</td>
      <td style="vertical-align:top;">
        <input type="text" name="customer_bg" id="customer_bg" placeholder="BLOOD GROUP" value="<?php echo $EDIT_ROW['customer_bg']; ?>" maxlength="25"/>
      </td>
      <td width="101">&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">mobile no&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
        <input type="text" name="customer_mobile" id="customer_mobile" placeholder="MOBILE NO" required="required" value="<?php echo $EDIT_ROW['customer_mobile']; ?>" maxlength="10" <?php OnlyNumber(); ?>/>
      </td>
      <td></td>
      </tr>
     <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">Whats app no</td>
      <td style="vertical-align:top;">
        <input type="text" name="customer_whatsapp_no" id="customer_whatsapp_no" placeholder="WHATS APP NO" value="<?php echo $EDIT_ROW['customer_whatsapp_no']; ?>" maxlength="10" <?php OnlyNumber(); ?>/>
      </td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">phone no</td>
      <td style="vertical-align:top;">
        <input type="text" name="customer_phone" id="customer_phone" placeholder="PHONE NO" value="<?php echo $EDIT_ROW['customer_phone']; ?>" maxlength="12" <?php OnlyNumber(); ?>/></td>
      <td width="145">&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">email id&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
        <input type="email" name="customer_email" id="customer_email" placeholder="EMAIL ID" required="required" value="<?php echo $EDIT_ROW['customer_email']; ?>" maxlength="50" />
      </td>
      <td width="145">&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">PAN NO</td>
      <td style="vertical-align:top;">
        <input type="text" name="customer_pan" id="customer_pan" placeholder="PAN NO"  value="<?php echo $EDIT_ROW['customer_pan']; ?>" maxlength="25" />
        </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">OCCUPATION</td>
      <td style="vertical-align:top;">
      <input type="text" name="customer_occupation" id="customer_occupation" placeholder="OCCUPATION" value="<?php echo $EDIT_ROW['customer_occupation']; ?>" maxlength="50"/>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">Designation</td>
      <td style="vertical-align:top;">
      <input type="text" name="customer_designation" id="customer_designation" placeholder="DESIGNATION" value="<?php echo $EDIT_ROW['customer_designation']; ?>" maxlength="50" />
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">anual income</td>
      <td style="vertical-align:top;">
      <input type="text" name="customer_anual_income" id="customer_anual_income" placeholder="ANNUAL INCOME" maxlength="15" value="<?php echo $EDIT_ROW['customer_anual_income']; ?>" <?php OnlyFloat(); ?>/>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">city&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;"><input type="text" name="customer_city" id="customer_city" placeholder="CITY" required="required" value="<?php echo $EDIT_ROW['customer_city']; ?>" maxlength="50"/></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">address&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
      <textarea name="customer_address" id="customer_address" placeholder="ADDRESS" required=""  maxlength="200"><?php echo $EDIT_ROW['customer_address']; ?></textarea>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">date of BIRTH &nbsp;<b class="Required">*</b></td>
      <td class="Date" style="vertical-align:top;"><script>DateInput('customer_dob', true, 'yyyy-mm-dd', '<?php echo $customer_dob; ?>');</script></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">Anniversary Date&nbsp;<b class="Required">*</b></td>
      <td class="Date" style="vertical-align:top;"><script>DateInput('customer_anniversary_date', true, 'yyyy-mm-dd', '<?php echo $customer_anniversary_date; ?>');</script></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">reg. date &nbsp;<b class="Required">*</b></td>
      <td class="Date" style="vertical-align:top;"><script>DateInput('customer_reg_date', true, 'yyyy-mm-dd', '<?php echo $customer_reg_date; ?>');</script></td>
      <td></td>
      <td></td>
    </tr>
       <tr>
      <td colspan="5"><H4>NOMINEE DETAILS</H4></td>
      </tr>
   
       <tr>
         <td>&nbsp;</td>
         <td>NOMINEE NAME<span style="line-height:13px; text-align:justify;"> &nbsp;<b class="Required">*</b></span></td>
         <td><span style="width:280PX;">
           <input type="text" name="customer_nominee_name" id="customer_nominee_name" placeholder="NOMINEE NAME" required="required" value="<?php echo $EDIT_ROW['customer_nominee_name']; ?>" maxlength="50"/>
         </span></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td style="line-height:13px; text-align:justify;">relation&nbsp;with&nbsp;customer&nbsp;<b class="Required">*</b></td>
         <td style="vertical-align:top;"><input type="text" name="customer_relation_with_nominee" id="customer_relation_with_nominee" placeholder="RELATION WITH CUSTOMER" required="required" value="<?php echo $EDIT_ROW['customer_relation_with_nominee']; ?>" maxlength="50" /></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td style="line-height:13px; text-align:justify;">DATE OF BIRTH&nbsp;<b class="Required">*</b></td>
         <td style="vertical-align:top;" class="Date"><script>DateInput('customer_nominee_dob', true, 'yyyy-mm-dd', '<?php echo $customer_nominee_dob; ?>');</script></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">mobile no&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
      <input type="text" name="customer_nominee_mobile" id="customer_nominee_mobile" placeholder="MOBILE NO" required="required" value="<?php echo $EDIT_ROW['customer_nominee_mobile']; ?>" maxlength="10" <?php OnlyNumber(); ?>/>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
       </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">phone no</td>
      <td style="vertical-align:top;"><input type="text" name="customer_nominee_phone" id="customer_nominee_phone" placeholder="PHONE NO" value="<?php echo $EDIT_ROW['customer_nominee_phone']; ?>" maxlength="12" <?php OnlyNumber(); ?>/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">ADDRESS&nbsp;OF&nbsp;NOMINEE&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
      <textarea name="customer_nominee_address" id="customer_nominee_address" placeholder="ADDRESS OF NIMINEE"  maxlength="50"><?php echo $EDIT_ROW['customer_nominee_address'];?></textarea>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
      <tr>
        <td colspan="5"><H4>Login</H4></td>
        </tr>
      <tr>
      <td>&nbsp;</td>
      <td>status</td>
      <td colspan="2" style="color:RED;">
      <select id="customer_status" name="customer_status" <?php SelectedSelect("1", $EDIT_ROW['customer_status']); ?>>
         <option value="1" <?php SelectedSelect("1", $EDIT_ROW['customer_status']); ?>>ACTIVE</option>
         <option value="0" <?php SelectedSelect("0", $EDIT_ROW['customer_status']); ?>>INACTIVE</option>
      </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" style="text-align:RIGHT">
        <div align="center">
          <input type="submit" name="Save" id="Save" value="Save Details" <?php Confirm("Are You Sure ? Save Details ?"); ?>/>
          <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
        </div>
        </td>
    </tr>
</form>

</table>
</fieldset>
</center>
</center></td></tr></table></center>
<?php 

/*$rows=$DBOBJ->GetAdvisorParents(6,1);
echo "PARENTS=".$rows['PARENT'];
echo "<BR>LEVEL=".$rows['LEVEL'];
echo "<BR>PERCENT=".$rows['PERCENT'];
echo "<BR>DIFF=".$rows['DIFF'];*/

include("../Menu/Footer.php"); ?>