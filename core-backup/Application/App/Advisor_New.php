<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Advisor");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$ID_Q="SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_advisor' ";
$ID_Q=@mysqli_query($_SESSION['CONN'],$ID_Q);
$ID_ROW=@mysqli_fetch_array($ID_Q);
$ID_NO=$ID_ROW[0];
$ID_NO=id_prefix.str_pad($ID_NO,3,"0",STR_PAD_LEFT);

$title="Register New ".advisor_title; 
$advisor_dob=date('1900-01-01');
$advisor_anniversary_date=date('1900-01-01');
$advisor_hire_date=date('Y-m-d');	


if(isset($_GET[md5('edit_id')]))
{
  $EDIT_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_GET[md5('edit_id')]);
  $ID_NO=$EDIT_ROW['advisor_code'];
  $title="Edit ".advisor_title." Profile";
  $advisor_dob=$EDIT_ROW['advisor_dob'];
  $advisor_anniversary_date=$EDIT_ROW['advisor_anniversary_date'];
  $advisor_hire_date=$EDIT_ROW['advisor_hire_date'];
}

if(isset($_POST['Save']))
{
	
	
	              $advisor_photo=FileUpload($_FILES['advisor_photo'],"../SpitechUploads/advisor/profile_photo/","1");				 
				
				//=================( Checking Student's Photo )==============================================================
				  if(($advisor_photo=="" || $advisor_photo==NULL) && $_GET[md5("edit_id")]>0 )
				  {
					  $advisor_photo=$EDIT_ROW['advisor_photo'];
				  }
				  if($_GET[md5("edit_id")]>0 && $advisor_photo!=$EDIT_ROW['advisor_photo'])
				  {
				    @unlink("../SpitechUploads/advisor/profile_photo/".$EDIT_ROW['advisor_photo']);
				  }
				
	
  	if(isset($_GET[md5("edit_id")]))
	{ 	
	  $FIELDS=array("advisor_code" ,					
					"advisor_sponsor" ,
					"advisor_level_id" ,
					"advisor_title" ,
					"advisor_name" ,
					"advisor_fname" ,
					"advisor_sex" ,					
					"advisor_address" ,
					"advisor_mobile" ,
					"advisor_phone" ,
					"advisor_email" ,
					"advisor_whatsapp_no",
					"advisor_marital_status",
					"advisor_bg" ,
					"advisor_dob" ,
					'advisor_anniversary_date',
					"advisor_hire_date" ,
					"advisor_qualification" ,
					"advisor_occupation" ,
					"advisor_pan_no" ,
					"advisor_photo" ,	
					"advisor_status",				
					"edited_details");	
				   
	  $VALUES=array($EDIT_ROW["advisor_code"] ,									
					$_POST["advisor_sponsor"] ,
					$_POST["advisor_level_id"] ,
					$_POST["advisor_title"] ,
					$_POST["advisor_name"] ,
					$_POST["advisor_fname"] ,
					$_POST["advisor_sex"] ,					
					$_POST["advisor_address"] ,
					$_POST["advisor_mobile"] ,
					$_POST["advisor_phone"] ,
					$_POST["advisor_email"] ,
					$_POST["advisor_whatsapp_no"],
					$_POST["advisor_marital_status"],
					$_POST["advisor_bg"] ,
					$_POST["advisor_dob"] ,
					$_POST["advisor_anniversary_date"],
					$_POST["advisor_hire_date"] ,
					$_POST["advisor_qualification"] ,
					$_POST["advisor_occupation"] ,
					$_POST["advisor_pan_no"] ,
					$advisor_photo ,
					$_POST["advisor_status"],
					CreatedEditedByUserMessage());
					
		$DBOBJ->Update("tbl_advisor",$FIELDS,$VALUES,"advisor_id",$_GET[md5("edit_id")],0);
		$MAX_ID=$_GET[md5("edit_id")];			
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAction(advisor_title." PROFILE EDITED", " ID : ".$MAX_ID.", NAME : ".$_POST['advisor_name']);
				
		$Message=advisor_title." PROFILE EDITED SUCCESSFULLY.";	
         header("location:Advisor.php?Message".$Message);
	}
	else
	{
		$FIELDS=array("advisor_code" ,
						"advisor_password" ,
						"advisor_sponsor" ,
						"advisor_level_id" ,
						"advisor_title" ,
						"advisor_name" ,
						"advisor_fname" ,
						"advisor_sex" ,						
						"advisor_address" ,
						"advisor_mobile" ,
						"advisor_phone" ,
						"advisor_email" ,
						"advisor_whatsapp_no",
					    "advisor_marital_status",
						"advisor_bg" ,
						"advisor_dob" ,
						"advisor_anniversary_date",
						"advisor_hire_date" ,
						"advisor_qualification" ,
						"advisor_occupation" ,
						"advisor_pan_no" ,
						"advisor_photo" ,
						"advisor_status",
						"created_details" ,
						"edited_details" ,
						"last_access_details");	
		$VALUES=array("",
						md5($_POST["advisor_password"]),
						$_POST["advisor_sponsor"] ,
						$_POST["advisor_level_id"] ,
						$_POST["advisor_title"] ,
						$_POST["advisor_name"] ,
						$_POST["advisor_fname"] ,
						$_POST["advisor_sex"] ,					
						$_POST["advisor_address"] ,
						$_POST["advisor_mobile"] ,
						$_POST["advisor_phone"] ,
						$_POST["advisor_email"] ,
						$_POST["advisor_whatsapp_no"],
					    $_POST["advisor_marital_status"],
						$_POST["advisor_bg"] ,
						$_POST["advisor_dob"] ,
						$_POST["advisor_anniversary_date"],
						$_POST["advisor_hire_date"] ,
						$_POST["advisor_qualification"] ,
						$_POST["advisor_occupation"] ,
						$_POST["advisor_pan_no"] ,
						$advisor_photo ,
						$_POST["advisor_status"],
						$Mess=CreatedEditedByUserMessage(),
						$Mess,
						"");	
		$MAX_ID=$DBOBJ->Insert("tbl_advisor",$FIELDS,$VALUES,0);	
		
		
		//=============( UPDATE CODE TO NEW Associate WITH NEW ID INSERTED )=============================
		$UPDATE_FIELDS=array("advisor_code");
		$UPDATE_VALUES=array(id_prefix.str_pad($MAX_ID,3,"0",STR_PAD_LEFT));
		$DBOBJ->Update("tbl_advisor",$UPDATE_FIELDS,$UPDATE_VALUES,"advisor_id",$MAX_ID,0);
		
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAction("NEW ".advisor_title." REGISTERED", " ID : ".$MAX_ID.", NAME : ".$_POST['advisor_name']);
		
		$Message=advisor_title." REGISTERED SUCCESSFULLY.";
		header("location:Advisor_New_Next.php?".md5("advisor_id")."=".$MAX_ID."&".md5("advisor_password")."=".$_POST['advisor_password']."&Send=Yes");
	 }
}

	 
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/AdvisorNew.png" width="31" height="32" /><?php echo advisor_title?>  : <span>New Entry/Edit</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">
    <center>
    <?php ErrorMessage(); ?>
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
    <center>
    <fieldset style="width:550px; margin:0px; padding:0px;">
   <legend><?php echo $title;?></legend>
    <?php MessageError(); ?>
<table width="500" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">
  
  <form name="AdvisorForm" id="AdvisorForm" method="post" enctype="multipart/form-data" >  
    <tr>
      <td>&nbsp;</td>
      <td>id code ( user id ) &nbsp;<b class="Required">*</b></td>
      <td colspan="2" style="color:RED; font-size:16PX;"><?php echo $ID_NO; ?></td>
      <td></td>
    </tr>
    <?php  if(!isset($_GET[md5('edit_id')])) { ?>
    <tr>
      <td>&nbsp;</td>
      <td>PASSWORD &nbsp;<b class="Required">*</b></td>
      <td colspan="2">
      <input type="text" name="advisor_password" id="advisor_password" placeholder="PASSWORD" required="required" value="<?php echo RandomPassword(); ?>" maxlength="50"/>
      </td>
      <td></td>
    </tr>
    <?php } ?>
    
    <tr>
      <td width="11">&nbsp;</td>
      <td width="179">name <b class="Required">&nbsp;<b class="Required">*</b></b></td>
      <td colspan="2">
        <div align="left" style="width:300PX;">
          <select id="advisor_title" name="advisor_title" style="width:60PX;">
            <option value="MR." <?php SelectedSelect("MR.", $EDIT_ROW['advisor_title']); ?>>MR.</option>
            <option value="MRS." <?php SelectedSelect("MRS.", $EDIT_ROW['advisor_title']); ?>>MRS.</option>
            <option value="MISS" <?php SelectedSelect("MISS", $EDIT_ROW['advisor_title']); ?>>MISS</option>
            <option value="ER." <?php SelectedSelect("ER.", $EDIT_ROW['advisor_title']); ?>>ER.</option>
            <option value="DR." <?php SelectedSelect("DR.", $EDIT_ROW['advisor_title']); ?>>DR.</option>
          </select>
          <input type="text" name="advisor_name" id="advisor_name" placeholder="FULL NAME" required="required" value="<?php echo $EDIT_ROW['advisor_name']; ?>" maxlength="50"/>
        </div>
      </td>
      <td width="11"></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:12px;">father's/husband's name &nbsp;<b class="Required">*</b></td>
      <td ><input type="text" name="advisor_fname" id="advisor_fname" placeholder="FATHER'S NAME"  value="<?php echo $EDIT_ROW['advisor_fname']; ?>" maxlength="50" required='required'/></td>
      <td width="73" rowspan="9" style="vertical-align:top;">
      <?php $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$EDIT_ROW['advisor_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		  if(!isset($_GET[md5('edit_id')]) || $EDIT_ROW['advisor_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imgadvisor_photo" style="border:1px solid maroon"/>      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>sex &nbsp;<b class="Required">*</b></td>
      <td >      
        <select id="advisor_sex" name="advisor_sex">
          <option value="MALE" <?php SelectedSelect("MALE", $EDIT_ROW['advisor_sex']); ?>>MALE</option>
          <option value="FEMALE" <?php SelectedSelect("FEMALE", $EDIT_ROW['advisor_sex']); ?>>FEMALE</option>         
        </select>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>MARITAL STATUS &nbsp;<b class="Required">*</b></td>
      <td ><select id="advisor_marital_status" name="advisor_marital_status" required='required'>
        <option value="Unmarried" <?php SelectedSelect("Unmarried", $EDIT_ROW['advisor_marital_status']); ?>>Unmarried</option>
        <option value="Married" <?php SelectedSelect("Married", $EDIT_ROW['advisor_marital_status']); ?>>Married</option>
        <option value="Separated" <?php SelectedSelect("Separated", $EDIT_ROW['advisor_marital_status']); ?>>Separated</option>
        <option value="Divorced" <?php SelectedSelect("Divorced", $EDIT_ROW['advisor_marital_status']); ?>>Divorced</option>
        <option value="Separated" <?php SelectedSelect("Widowed", $EDIT_ROW['advisor_marital_status']); ?>>Widowed</option>
      </select></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">photo</td>
      <td width="227" style="vertical-align:top;">
  
        <?php         FileImageInput("advisor_photo",$ACTUAL_PHOTO,100)
		?>
        
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">BLOOD GROUP</td>
      <td style="vertical-align:top;">
        <input type="text" name="advisor_bg" id="advisor_bg" placeholder="BLOOD GROUP" value="<?php echo $EDIT_ROW['advisor_bg']; ?>" maxlength="25"/>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">mobile no&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
        <input type="text" name="advisor_mobile" id="advisor_mobile" placeholder="MOBILE NO" required="required" value="<?php echo $EDIT_ROW['advisor_mobile']; ?>" maxlength="10" <?php OnlyNumber(); ?>/>
      </td>
      <td></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">Whats app no</td>
      <td style="vertical-align:top;">
      <input type="text" name="advisor_whatsapp_no" id="advisor_whatsapp_no" placeholder="WHATS APP NO" value="<?php echo $EDIT_ROW['advisor_whatsapp_no']; ?>" maxlength="10" <?php OnlyNumber(); ?>/>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">phone no</td>
      <td style="vertical-align:top;">
        <input type="text" name="advisor_phone" id="advisor_phone" placeholder="PHONE NO" value="<?php echo $EDIT_ROW['advisor_phone']; ?>" maxlength="12" <?php OnlyNumber(); ?>/></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">email id&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
        <input type="email" name="advisor_email" id="advisor_email" placeholder="EMAIL ID" required="required" value="<?php echo $EDIT_ROW['advisor_email']; ?>" maxlength="50" />
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">PAN NO</td>
      <td colspan="2" style="vertical-align:top;">
        <input type="text" name="advisor_pan_no" id="advisor_pan_no" placeholder="PAN NO" value="<?php echo $EDIT_ROW['advisor_pan_no']; ?>" maxlength="25" />
        </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">OCCUPATION&nbsp;<b class="Required">*</b></td>
      <td colspan="2" style="vertical-align:top;">
      <input type="text" name="advisor_occupation" id="advisor_occupation" placeholder="OCCUPATION" required="required" value="<?php echo $EDIT_ROW['advisor_occupation']; ?>" maxlength="50"/>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">educational&nbsp;qualification&nbsp;<b class="Required">*</b></td>
      <td colspan="2" style="vertical-align:top;">
      <input type="text" name="advisor_qualification" id="advisor_qualification" placeholder="QUALIFICATION" required="required" value="<?php echo $EDIT_ROW['advisor_qualification']; ?>" maxlength="50"/>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">address</td>
      <td colspan="2" style="vertical-align:top;">
      <textarea name="advisor_address" id="advisor_address" placeholder="ADDRESS"  maxlength="200"><?php echo $EDIT_ROW['advisor_address']; ?></textarea>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">date of BIRTH &nbsp;<b class="Required">*</b></td>
      <td colspan="2" class="Date" style="vertical-align:top;"><script>DateInput('advisor_dob', true, 'yyyy-mm-dd', '<?php echo $advisor_dob; ?>');</script></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">Anniversary Date&nbsp;<b class="Required">*</b></td>
      <td colspan="2" class="Date" style="vertical-align:top;"><script>DateInput('advisor_anniversary_date', true, 'yyyy-mm-dd', '<?php echo $advisor_anniversary_date; ?>');</script></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">date of jOIning &nbsp;<b class="Required">*</b></td>
      <td colspan="2" class="Date" style="vertical-align:top;"><script>DateInput('advisor_hire_date', true, 'yyyy-mm-dd', '<?php echo $advisor_hire_date; ?>');</script></td>
      <td></td>
    </tr>
       <tr>
      <td colspan="5"><H4>NAME PROPOSED BY (SPONSOR)</H4></td>
      </tr>
   
       <tr>
         <td>&nbsp;</td>
         <td>LEVEL</td>
         <td colspan="2">
         
         <select id="advisor_level_id" name="advisor_level_id" required="" >         
           <?php 
			   $LEVEL_Q="SELECT level_id, level_name FROM tbl_setting_advisor_level ORDER BY level_id";
			   $LEVEL_Q=@mysqli_query($_SESSION['CONN'],$LEVEL_Q);
			   while($LEVEL_ROWS=@mysqli_fetch_assoc($LEVEL_Q)) {?>
           <option value="<?php echo $LEVEL_ROWS['level_id'];?>" <?php SelectedSelect($LEVEL_ROWS['level_id'], $EDIT_ROW['advisor_level_id']); ?>>
           <?php echo $LEVEL_ROWS['level_name'];?> </option>
           <?php } ?>
         </select></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
      <td>&nbsp;</td>
      <td>NAME <span style="line-height:13px; text-align:justify;">&nbsp;<b class="Required">*</b></span></td>
      <td colspan="2">
	  <?php $exist=$DBOBJ->ExistRow("tbl_advisor"); 
	  
	  if($exist>0) 
	  {
		  if(isset($_GET[md5('edit_id')]) && $_GET[md5('edit_id')]!="1")
		  {
			  $required=" required=''"; 
			 // echo "1";
		  }
		  elseif(!isset($_GET[md5('edit_id')]))
		  {
			   $required=" required='' "; 
			 //  echo "2";
		  }
		 
		  
	  }
	  
	  ?> 
          <select id="advisor_sponsor" name="advisor_sponsor" <?php echo $required ?>>
             <option value="">SELECT AN SPONSOR...</option>
             <?php 
			 if(isset($_GET[md5('edit_id')])) 
			 {
			   	$SPONSOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor where advisor_id!='".$_GET[md5("edit_id")]."' ORDER BY advisor_name";
			 }
			 else
			 {
				$SPONSOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			 }
			   $SPONSOR_Q=@mysqli_query($_SESSION['CONN'],$SPONSOR_Q);
			   while($SPONSOR_ROWS=@mysqli_fetch_assoc($SPONSOR_Q)) {?>
             <option value="<?php echo $SPONSOR_ROWS['advisor_id'];?>" <?php SelectedSelect($SPONSOR_ROWS['advisor_id'], $EDIT_ROW['advisor_sponsor']); ?> onclick=" document.getElementById('res').innerHTML='<?php echo $SPONSOR_ROWS['advisor_code']?>'; ">
			 <?php echo $SPONSOR_ROWS['advisor_name']." [".$SPONSOR_ROWS['advisor_code']." ]";?>
             </option>
             <?php } ?>
          </select>
      </td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>ID CODE <span style="line-height:13px; text-align:justify;">&nbsp;<b class="Required">*</b></span></td>
      <td colspan="2" style="color:RED;">
      <div align="left" id="res">
       <?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$EDIT_ROW['advisor_sponsor']); ?>
      </div>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>status</td>
      <td colspan="2" style="color:RED;">
      <select id="advisor_status" name="advisor_status" <?php SelectedSelect("1", $EDIT_ROW['advisor_status']); ?>>
         <option value="1" <?php SelectedSelect("1", $EDIT_ROW['advisor_status']); ?>>ACTIVE</option>
         <option value="0" <?php SelectedSelect("0", $EDIT_ROW['advisor_status']); ?>>INACTIVE</option>
      </select>
      </td>
      <td>&nbsp;</td>
    </tr>
   
    <tr>
      <td colspan="5" style="text-align:RIGHT">
        <input type="submit" name="Save" id="Save" value="Save <?php echo advisor_title?> Details" <?php Confirm("Are You Sure ? Save ".advisor_title." Details ?"); ?>/>
        <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
        </td>
    </tr>
</form>

</table>
</fieldset>
</center>
</center></td></tr></table></center>
<?php include("../Menu/Footer.php"); ?>