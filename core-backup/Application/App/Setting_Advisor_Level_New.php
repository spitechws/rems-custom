<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../Menu/Define.php");
include_once("../Menu/HeaderCommon.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
NoAdmin();NoUser();
if(isset($_GET[md5('edit_id')]))
{
  $EDIT_ROW=$DBOBJ->GetRow("tbl_setting_advisor_level","level_id",$_GET[md5('edit_id')]);
}

if(isset($_POST['Save']))
{
  	 $FIELDS=array("level_name","level_target","level_unit_sale","level_active_member","level_last_month","created_details","edited_details");									  
	 $VALUES=array($_POST["level_name"],$_POST["level_target"],$_POST["level_unit_sale"],$_POST["level_active_member"],$_POST["level_last_month"],$Mess=CreatedEditedByUserMessage(),$Mess);	
	 				
				if(isset($_GET[md5("edit_id")]))
				{ 	
				    //==================( INSERT IN MAIN LEVEL TABLE )=================================================
					$Update=$DBOBJ->Update("tbl_setting_advisor_level",$FIELDS,$VALUES,"level_id",$_GET[md5("edit_id")],0);
					$MAX_ID=$_GET[md5("edit_id")];					
					
					//==================( INSERT IN PROPERTY TYPE LEVEL TABLE )=================================================
					@mysqli_query($_SESSION['CONN'],"delete from tbl_setting_advisor_level_with_property_type where level_id='".$MAX_ID."'");
					$TYPE_FIELDS=array("level_id","property_type_id","commission_percent","project_id");
					
					//=============( PROJECT )============================================================
					$PROJECT_Q="select project_id, project_name from tbl_project order by project_name";
					$PROJECT_Q=@mysqli_query($_SESSION['CONN'],$PROJECT_Q);						
					while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
					{
						$TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id from tbl_setting_property_type ");
						while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
						{
							$TYPE_VALUES=array($MAX_ID,$TYPE_ROWS["property_type_id"],$_POST["property_type".$TYPE_ROWS["property_type_id"]."_".$PROJECT_ROWS['project_id']],$PROJECT_ROWS['project_id']);	
							$DBOBJ->Insert("tbl_setting_advisor_level_with_property_type",$TYPE_FIELDS,$TYPE_VALUES,0);
						}
					}
					
					$DBOBJ->UserAction(advisor_title." LEVEL EDITED", " ID : ".$_GET[md5("edit_id")].", OLD : ".$EDIT_ROW['level_name']." NEW : ".$_POST["level_name"]);			
					$Message=advisor_title." lEVEL EDITED SUCCESSFULLY.";		
				}
				else
				{
					//==================( INSERT IN MAIN LEVEL TABLE )=================================================
					$MAX_ID=$DBOBJ->Insert("tbl_setting_advisor_level",$FIELDS,$VALUES,0);	
					
					
					//==================( INSERT IN PROPERTY TYPE LEVEL TABLE )=================================================
					$TYPE_FIELDS=array("level_id","property_type_id","commission_percent",'project_id');
					
					//=============( PROJECT )============================================================
					$PROJECT_Q="select project_id, project_name from tbl_project order by project_name";
					$PROJECT_Q=@mysqli_query($_SESSION['CONN'],$PROJECT_Q);						
					while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
					{
						$TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id from tbl_setting_property_type ");
						while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
						{
							$TYPE_VALUES=array($MAX_ID,$TYPE_ROWS["property_type_id"],$_POST["property_type".$TYPE_ROWS["property_type_id"]."_".$PROJECT_ROWS['project_id']],$PROJECT_ROWS['project_id']);	
							$DBOBJ->Insert("tbl_setting_advisor_level_with_property_type",$TYPE_FIELDS,$TYPE_VALUES,0);
						}
					}
					
					$DBOBJ->UserAction(advisor_title." LEVEL CREATED", " ID : ".$MAX_ID.", TYPE : ".$_POST['level_name']);
					$Message=advisor_title." lEVEL CREATED SUCCESSFULLY.";
				}
	 Alert($Message);			
     UnloadMe();
}
?><head><title>Settings : Associate Level Entry</title>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
    <center>
    <fieldset style="width:550px; margin:0px; padding:0px;">
   <legend><?php echo advisor_title?> Level Entry/Edit : </legend>
    <?php MessageError(); ?>
<table width="500" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">
  
  <form name="CourseForm" id="CourseForm" method="post" enctype="multipart/form-data" >
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><h4>Level Details</h4></td>
      </tr>
    <tr>
      <td width="14">&nbsp;</td>
      <td width="156">Level&nbsp;<b class="Required">*</b></td>
      <td width="212"><input type="text" name="level_name" id="level_name" placeholder="LEVEL" required="required" value="<?php echo $EDIT_ROW['level_name']; ?>" maxlength="50"/>
      </td>
      <td width="16"></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>TARGET(<b id="Required">SELF COLLECTION</b>) TO PROMOT NEXT LEVEL&nbsp;<b class="Required">*</b></td>
      <td ><input type="text" name="level_target" id="level_target" placeholder="SELF COLLECTION"  value="<?php echo $EDIT_ROW['level_target']; ?>" maxlength="18" <?php OnlyFloat(); ?> required='required'/></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>no of unit Sale&nbsp;<b class="Required">*</b></td>
      <td ><input type="text" name="level_unit_sale" id="level_unit_sale" placeholder="NO OF UNIT SALE"  value="<?php echo $EDIT_ROW['level_unit_sale']; ?>" maxlength="10" <?php OnlyNumber(); ?> required='required'/></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>No&nbsp;of&nbsp;active&nbsp;Members&nbsp;<b class="Required">*</b></td>
      <td ><input type="text" name="level_active_member" id="level_active_member" placeholder="NO OF ACTIVE MEMBERS"  value="<?php echo $EDIT_ROW['level_active_member']; ?>" maxlength="10" <?php OnlyNumber(); ?> required=''/></td>
      <td></td>
      </tr>
    
    
    
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><H4>Property Type Wise Commission % Details</H4></td>
      </tr>
   
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">
       <?php 	$PROJECT_Q="select project_id, project_name from tbl_project order by project_name";
	$PROJECT_Q=@mysqli_query($_SESSION['CONN'],$PROJECT_Q);
	$p=1;
	?>
         <table width="200" border="0" cellspacing="1" cellpadding="0" id="SmallTable">
  <tr>
    <th width="4%">#</th>
    <th width="16%">Project</th>
    <th width="80%">PROPERTY TYPE WISE PERCENT</th>
  </tr>
  <?php while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) {?>
  <tr>
    <td style="text-align:center;"><?php echo $p++?>.</td>
    <td><?php echo $PROJECT_ROWS['project_name']?></td>
    <td>
        <table width="200" border="0" cellspacing="1" cellpadding="0" id="SmallTable" >
          <tr>
            <th>#</th>
            <th>property type</th>
            <th colspan="2">commission&nbsp;percent</th>
            </tr>
	<?php 
	 $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type ");
	 while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
	 {
		 if(isset($_GET[md5('edit_id')]))
		 {
		 $percent=$DBOBJ->ConvertToText("tbl_setting_advisor_level_with_property_type","project_id='".$PROJECT_ROWS['project_id']."' and level_id='".$EDIT_ROW['level_id']."' and property_type_id","commission_percent",$TYPE_ROWS['property_type_id']);
		 }
		 else
		 {
			 $percent=0;
		 }
	 ?>  
          
          <tr>
            <td width="6%"><div align="center"><?php echo ++$i?>.</div></td>
            <td width="41%"><div align="left" style="width:130px;">&nbsp;<?php echo $TYPE_ROWS['property_type']?>
              <span style="line-height:13px; text-align:justify;">&nbsp;<b class="Required">*</b></span></div></td>
            <td width="31%" style="padding:2px;"><div align="right">
              <input type="text" name="property_type<?php echo $TYPE_ROWS['property_type_id']?>_<?php echo $PROJECT_ROWS['project_id']?>" placeholder="% For <?php echo $TYPE_ROWS['property_type']?>" required="required" <?php OnlyFloat(); ?> value="<?php echo $percent;?>" maxlength="5" style="width:130px; text-align:right;" />
            </div></td>
            <td width="22%" style="padding:2px;"><div align="left">%</div></td>
            </tr>
          <?php } ?>
  </table>
  </td></tr><?php } ?></table>
</td>
      </tr>
   
    <tr>
      <td colspan="4" style="text-align:RIGHT">
        <input type="submit" name="Save" id="Save" value="Save <?php echo advisor_title?> Level" <?php Confirm("Are You Sure ? Save ".advisor_title." Level Settings ?"); ?>/>
        <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
        </td>
    </tr>
</form>

</table>
</fieldset>
</center>

