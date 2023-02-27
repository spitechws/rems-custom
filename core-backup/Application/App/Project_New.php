<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
include_once("../Menu/HeaderCommon.php");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

if(isset($_GET[md5('edit_id')]))
{
  $EDIT_ROW=$DBOBJ->GetRow("tbl_project","project_id",$_GET[md5('edit_id')]);
  $title="Edit Project";  
}
else
{
	$title="Create New Project";
}

if(isset($_POST['Save']))
{
	  $project_photo=FileUpload($_FILES['project_photo'],"../SpitechUploads/project/project_photo/","1");				
	//=================( Checking Project's Photo )==============================================================
	  if(($project_photo=="" || $project_photo==NULL) && $_GET[md5("edit_id")]>0 )
	  {
		  $project_photo=$EDIT_ROW['project_photo'];
	  }
	  if($_GET[md5("edit_id")]>0 && $project_photo!=$EDIT_ROW['project_photo'])
	  {
		@unlink("../SpitechUploads/project/project_photo/".$EDIT_ROW['project_photo']);
	  }
				
	
  	if(isset($_GET[md5("edit_id")]))
	{ 	
	  $FIELDS=array("project_name" ,
					"project_address" ,
					"project_photo" ,
					"project_mouza" ,
					"project_ph_no" ,
					
					"extra_charge_1",		
					"extra_charge_2",	
					"extra_charge_3",	
					"extra_charge_4",	
					"extra_charge_5",	
					"extra_charge_6",	
					
					"extra_charge_amount_1",
					"extra_charge_amount_2",
					"extra_charge_amount_3",
					"extra_charge_amount_4",
					"extra_charge_amount_5",
					"extra_charge_amount_6",	
								
					"edited_details");	
				   
	  $VALUES=array($_POST["project_name"] ,
					$_POST["project_address"] ,
					$project_photo ,
					$_POST["project_mouza"] ,
					$_POST["project_ph_no"] ,
					
					$_POST["extra_charge_1"],		
					$_POST["extra_charge_2"],	
					$_POST["extra_charge_3"],	
					$_POST["extra_charge_4"],	
					$_POST["extra_charge_5"],	
					$_POST["extra_charge_6"],	
					
					$_POST["extra_charge_amount_1"],
					$_POST["extra_charge_amount_2"],
					$_POST["extra_charge_amount_3"],
					$_POST["extra_charge_amount_4"],
					$_POST["extra_charge_amount_5"],
					$_POST["extra_charge_amount_6"],	
										
					CreatedEditedByUserMessage());
					
		$DBOBJ->Update("tbl_project",$FIELDS,$VALUES,"project_id",$_GET[md5("edit_id")],0);
		$MAX_ID=$_GET[md5("edit_id")];		
		
		//===============(ENTRY IN PROJECT DETAILS TABLE)==================================================
		    @mysqli_query($_SESSION['CONN'],"delete from tbl_project_details where project_id='".$MAX_ID."'");
		    $TYPE_FIELDS=array("project_id","project_property_type_id","project_standard_amount_percent","project_no_of_date_to_tokent_expiry");
			$TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id from tbl_setting_property_type ");
			while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
			{
				if(isset($_POST['project_property_type_id'.$TYPE_ROWS["property_type_id"]]))
				{
					$TYPE_VALUES=array($MAX_ID,$TYPE_ROWS["property_type_id"],$_POST["project_standard_amount_percent".$TYPE_ROWS["property_type_id"]],$_POST["project_no_of_date_to_tokent_expiry".$TYPE_ROWS["property_type_id"]]);	
					$DBOBJ->Insert("tbl_project_details",$TYPE_FIELDS,$TYPE_VALUES,0);
				}
			}
						
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAction("PROJECT EDITED", " ID : ".$MAX_ID.", NAME : ".$_POST['project_name']);
				
		$Message="PROJECT EDITED SUCCESSFULLY.";	
        UnloadMe();
	}
	else
	{
		$FIELDS=array("project_name" ,
					"project_address" ,
					"project_photo" ,
					"project_mouza" ,
					"project_ph_no" ,
					
					"extra_charge_1",		
					"extra_charge_2",	
					"extra_charge_3",	
					"extra_charge_4",	
					"extra_charge_5",	
					"extra_charge_6",	
					
					"extra_charge_amount_1",
					"extra_charge_amount_2",
					"extra_charge_amount_3",
					"extra_charge_amount_4",
					"extra_charge_amount_5",
					"extra_charge_amount_6",	
					
					"created_details" ,					
					"edited_details");	
				   
	    $VALUES=array($_POST["project_name"] ,
					$_POST["project_address"] ,
					$project_photo ,
					$_POST["project_mouza"] ,
					$_POST["project_ph_no"] ,
					
					$_POST["extra_charge_1"],		
					$_POST["extra_charge_2"],	
					$_POST["extra_charge_3"],	
					$_POST["extra_charge_4"],	
					$_POST["extra_charge_5"],	
					$_POST["extra_charge_6"],	
					
					$_POST["extra_charge_amount_1"],
					$_POST["extra_charge_amount_2"],
					$_POST["extra_charge_amount_3"],
					$_POST["extra_charge_amount_4"],
					$_POST["extra_charge_amount_5"],
					$_POST["extra_charge_amount_6"],	
					
					$mess=CreatedEditedByUserMessage(),
					$mess);
					
		$DBOBJ->Insert("tbl_project",$FIELDS,$VALUES,0);	
		$MAX_ID=$DBOBJ->MaxID("tbl_project","project_id");
		//===============(ENTRY IN PROJECT DETAILS TABLE)==================================================
		  
		    $TYPE_FIELDS=array("project_id","project_property_type_id","project_standard_amount_percent","project_no_of_date_to_tokent_expiry");
			$TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id from tbl_setting_property_type ");
			while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
			{
				if(isset($_POST['project_property_type_id'.$TYPE_ROWS["property_type_id"]]))
				{
					$TYPE_VALUES=array($MAX_ID,$TYPE_ROWS["property_type_id"],$_POST["project_standard_amount_percent".$TYPE_ROWS["property_type_id"]],$_POST["project_no_of_date_to_tokent_expiry".$TYPE_ROWS["property_type_id"]]);	
					$DBOBJ->Insert("tbl_project_details",$TYPE_FIELDS,$TYPE_VALUES,0);
				}
			}
		
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAction("NEW PROJECT CREATED", " ID : ".$MAX_ID.", NAME : ".$_POST['project_name']);
		
		$Message="PROJECT CREATED SUCCESSFULLY.";
		
	 }
	 
	 UnloadMe();
}
?><head><title><?php echo $title;?></title></head><link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>
#SmallTable tr th, #Data-Table tr th { height:20px !important; font-size:9px; }
#Data-Table tr td { height:20px !important; font-size:9px; line-height:normal !important}
#SmallTable tr td input, #Data-Table tr td input { height:18px; font-size:10px; line-height:normal; margin:1px; }


</style>
    <center>
    <?php ErrorMessage(); ?>
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
    <center>
    <fieldset style="width:600px; margin:0px; padding:0px;">
   <legend><?php echo $title;?></legend>
    <?php MessageError(); ?>
<table width="600" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">
  
  <form name="AdvisorForm" id="AdvisorForm" method="post" enctype="multipart/form-data" >
    <?php  if(!isset($_GET[md5('edit_id')])) { ?>
    <?php } ?>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td width="11">&nbsp;</td>
      <td width="179">name&nbsp;of&nbsp;project<b class="Required">&nbsp;<b class="Required">*</b></b></td>
      <td>      
          <input type="text" name="project_name" id="project_name" placeholder="NAME OF PROJECT" required="required" value="<?php echo $EDIT_ROW['project_name']; ?>" maxlength="50"/>
        
      </td>
      <td width="73" rowspan="5" style="vertical-align:top;">
        <?php $ACTUAL_PHOTO="../SpitechUploads/project/project_photo/".$EDIT_ROW['project_photo'];
		 $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $EDIT_ROW['project_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Project.png"; }
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imgproject_photo" style="border:1px solid maroon"/></td>
      <td width="11"></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>address  (location)&nbsp;<b class="Required">*</b></td>
      <td ><span style="vertical-align:top;">
        <textarea name="project_address" id="project_address" placeholder="ADDRESS OF PROJECT " style="height:50px; font-size:9px"  maxlength="100"><?php echo $EDIT_ROW['project_address']; ?></textarea>
      </span></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>project&nbsp;Image&nbsp;<b class="Required">*</b></td>
      <td width="227" style="vertical-align:top;">
        <?php         FileImageInput("project_photo",$ACTUAL_PHOTO,250)
		?>
        
        </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">mauza&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
        <input type="text" name="project_mouza" id="project_mouza" placeholder="MAUZA" required="required" value="<?php echo $EDIT_ROW['project_mouza']; ?>" maxlength="50"/>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">ph no&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
        <input type="text" name="project_ph_no" id="project_ph_no" placeholder="PATWARI HALKA NO." required="required" value="<?php echo $EDIT_ROW['project_ph_no']; ?>" maxlength="25"/>
        </td>
      <td></td>
    </tr>
       <tr>
         <td colspan="5"><H4>PROPERTY RELATED DETAILS</H4></td>
       </tr>
   
       <tr>
         <td>&nbsp;</td>
         <td colspan="3">
         
         <table width="100" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
  <tr>
    <th width="7%" scope="col">NO</th>
    <th width="30%" scope="col">PROPERTY&nbsp;TYPE</th>
    <th width="34%" scope="col">NO&nbsp;OF&nbsp;DAYS&nbsp;TO TOKEN&nbsp;EXPIRED</th>
    <th width="29%" scope="col">STANDARD&nbsp;DOWNPAYMENT&nbsp;</th>
  </tr>
  
  
  	<?php 
	 $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type ");
	 while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
	 {
		 if(isset($_GET[md5('edit_id')]))
		 {
		 
		  $PERCENT=$DBOBJ->ConvertToText("tbl_project_details","project_id='".$EDIT_ROW['project_id']."' and project_property_type_id","project_standard_amount_percent",$TYPE_ROWS['property_type_id']);
		 
		  $EXPIRY=$DBOBJ->ConvertToText("tbl_project_details","project_id='".$EDIT_ROW['project_id']."' and project_property_type_id","project_no_of_date_to_tokent_expiry",$TYPE_ROWS['property_type_id']);
		  
		   $TYPE=$DBOBJ->ConvertToText("tbl_project_details","project_id='".$EDIT_ROW['project_id']."' and project_property_type_id","project_property_type_id",$TYPE_ROWS['property_type_id']);
		  
		 }
		 else
		 {
			 $PERCENT=$EXPIRY=0;
		 }
		 if($PERCENT=="" ||$PERCENT==NULL ) {$PERCENT=0; }
		 if($EXPIRY=="" ||$EXPIRY==NULL) { $EXPIRY=0; }
	 ?>  
          
          <tr>
            <td width="7%"><div align="center"><?php echo ++$i?>.</div></td>
            <td width="30%">
            	<label>
                     <div align="left" style="width:150px;">
                     <input type="checkbox" name="project_property_type_id<?php echo $TYPE_ROWS['property_type_id']?>" id="project_property_type_id<?php echo $TYPE_ROWS['property_type_id']?>" value="<?php echo $TYPE_ROWS['property_type_id']?>" <?php CheckedCheckbox($TYPE_ROWS['property_type_id'],$TYPE); ?> />
					 <?php echo $TYPE_ROWS['property_type']?>
                        
                     </div>
             	</label>
              </td>
            <td width="34%" style="padding:2px; text-align:center">
             
              <input type="text" name="project_no_of_date_to_tokent_expiry<?php echo $TYPE_ROWS['property_type_id']?>" id="project_no_of_date_to_tokent_expiry<?php echo $TYPE_ROWS['property_type_id']?>" placeholder="TOKEN EXPIRY DAYS FOR <?php echo $TYPE_ROWS['property_type']?>" required="required" <?php OnlyNumber(); ?> value="<?php echo $EXPIRY;?>" maxlength="3" style="width:130px; text-align:right;" />
              
            </td>
            <td style="padding:2px;"><input type="text" name="project_standard_amount_percent<?php echo $TYPE_ROWS['property_type_id']?>" id="project_standard_amount_percent<?php echo $TYPE_ROWS['property_type_id']?>" placeholder="DOWNPAYMENT % OF <?php echo $TYPE_ROWS['property_type']?>" required="required" <?php OnlyFloat(); ?> value="<?php echo $PERCENT;?>" maxlength="8" style="width:130px; text-align:right;" /><div align="left"></div></td>
            </tr>
          <?php } ?>
  
  
  <tr>
    <tH colspan="4">&nbsp;</tH>
    </tr>
</table>

         
         </td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4"><H4>EXTRA CHARGES</H4></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td colspan="3"><table width="100" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="margin-top:0px;">
           <tr>
             <th width="5%" scope="col">#</th>
             <th width="70%" scope="col">particulars</th>
             <th width="25%" scope="col">charge</th>
           </tr>
           <?php 		   for($i=1;$i<7;$i++) 
		   {
			   
		   ?>
           <tr>
             <td><?php echo $i?>.</td>
             <td><input type="text" name="extra_charge_<?php echo $i?>" id="extra_charge_<?php echo $i?>" value="<?php echo $EDIT_ROW['extra_charge_'.$i]?>" placeholder="PARTICULAR <?php echo $i?>" style="width:100%" /></td>
             <td><input type="text" name="extra_charge_amount_<?php echo $i?>" id="extra_charge_amount_<?php echo $i?>" value="<?php echo $EDIT_ROW['extra_charge_amount_'.$i]?>" placeholder="CHARGE <?php echo $i?>" style="text-align:right;width:100%" <?php OnlyFloat()?> /></td>
           </tr>
           <?php } ?>
         </table></td>
         <td>&nbsp;</td>
       </tr>
   
    <tr>
      <td colspan="5" style="text-align:RIGHT">
        <input type="submit" name="Save" id="Save" value="Save Project Details" <?php Confirm("Are You Sure ? Save Project Details ?"); ?>/>
        <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
        </td>
    </tr>
</form>

</table>
</fieldset>
</center>
<?php SpitechPleaseWait()?>