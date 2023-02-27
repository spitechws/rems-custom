<?php
session_start();
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../Menu/HeaderCommon.php");
NoUser();
NoAdmin();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$EDIT_ROW=$DBOBJ->GetRow("tbl_property","property_id",$_GET[md5("edit_id")]);	

if(isset($_POST['Submit']) && isset($_GET[md5("edit_id")]))
{
	if($EDIT_ROW['property_status']=="Available"  || $EDIT_ROW['property_status']=="Hold")
	{			
			 $FIELDS=array("property_project_id" ,
						"property_type_id" ,
						"property_no" ,					
						"property_plot_area" ,
						"property_built_up_area" ,
						"property_super_built_up_area" ,
						"property_status",
						"property_khasra_no" ,
						"property_remarks" ,						
						"edited_details");	
																	
		    $VALUES=array($_POST["property_project_id"] ,
								$_POST["property_type_id"] ,
								$_POST["property_no"] ,							
								$_POST["property_plot_area"] ,
								$_POST["property_built_up_area"] ,
								$_POST["property_super_built_up_area"] ,
								$_POST["property_status"],
								$_POST["property_khasra_no"] ,
								$_POST["property_remarks"],									
								CreatedEditedByUserMessage());
		   $DBOBJ->Update("tbl_property",$FIELDS,$VALUES,"property_id",$_GET[md5("edit_id")],0);							
	
	}
	UnloadMe();
}

if(($EDIT_ROW['property_status']=="Available" || $EDIT_ROW['property_status']=="Hold" ) && isset($_GET[md5("edit_id")]))
{
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<head><title>Edit Property</title></head>
    <center>
   <fieldset style="width:400px;"><legend>Edit Property</legend>
   <form id="FrmProperty" name="FrmProperty" method="post" enctype="multipart/form-data">
    <table width="400" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;" >
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr>
    <td>project<b class="Required">&nbsp;<b class="Required">*</b></b></td>
    <td>
    <select id="property_project_id" name="property_project_id" required="">
      <option value="">Select A Project...</option>
      <?php     $PROJECT_Q=@mysqli_query($_SESSION['CONN'],"select project_id, project_name from tbl_project ");
             while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
             {?>
      <option value="<?php echo $PROJECT_ROWS['project_id']?>" <?php SelectedSelect($PROJECT_ROWS['project_id'],$EDIT_ROW['property_project_id']);?>>
        <?php echo $PROJECT_ROWS['project_name']?>
        </option>
      <?php } ?>
    </select></td>
    <td></td>
  </tr>
  <tr>
    <td width="120">type<B class="Required">&nbsp;<b class="Required">*</b></B></td>
    <td width="227"><select id="property_type_id" name="property_type_id" required="">
      <?php 
             $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type");
             while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
             {?>
      <option value="<?php echo $TYPE_ROWS['property_type_id']?>" <?php SelectSelected($TYPE_ROWS['property_type_id'],$EDIT_ROW['property_type_id']); ?>>
        <?php echo $TYPE_ROWS['property_type']?>
        </option>
      <?php } ?>
    </select></td>
    <td width="213"></td>
  </tr>
  <tr>
    <td>property&nbsp;no&nbsp;<b class="Required">*</b></td>
    <td><input type="text" name="property_no" id="property_no" placeholder="NO" value="<?php echo $EDIT_ROW['property_no'];?>" required="required"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>plot&nbsp;area<B class="Required">&nbsp;<b class="Required">*</b></B></td>
    <td><input type="text" name="property_plot_area" id="property_plot_area" placeholder="PLOT AREA" value="<?php echo $EDIT_ROW['property_plot_area'];?>" required="" <?php OnlyFloat();?>/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>built&nbsp;up&nbsp;area&nbsp;<B class="Required">*</B></td>
     <td><input type="text" name="property_built_up_area" id="property_built_up_area" placeholder="BUILT UP AREA" value="<?php echo $EDIT_ROW['property_built_up_area'];?>" required="" <?php OnlyFloat();?>/></td>
    
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>super&nbsp;built&nbsp;up&nbsp;area&nbsp;<B class="Required">*</B></td>
    <td><input type="text" name="property_super_built_up_area" id="property_super_built_up_area" placeholder="SUPER BUILT UP AREA"  required="" <?php OnlyFloat();?> VALUE='<?php echo $EDIT_ROW['property_super_built_up_area'];?>'/></td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td>status&nbsp;<b class="Required">*</b></td>
    <td>
    <select name="property_status" id="property_status" required="">
       <option value="Available" <?php SelectedSelect("Available", $EDIT_ROW["property_status"]); ?>>Available</option>
       <option value="Hold" <?php SelectedSelect("Hold", $EDIT_ROW["property_status"]); ?>>Hold</option>
    </select>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>khasra<B class="Required">*</B></td>
    <td><input type="text" name="property_khasra_no" id="property_khasra_no" placeholder="KHASRA NO" value="<?php echo $EDIT_ROW['property_khasra_no'];?>" required="" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>remarks<B class="Required"></B></td>
    <td><input type="text" name="property_remarks" id="property_remarks" placeholder="REMARKS" value="<?php echo $EDIT_ROW['property_remarks'];?>" /></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" style="text-align:RIGHT">
      <input type="submit" name="Submit" id="Submit" class="Button" value="Save Property details" <?php Confirm("Are You Sure ? Save Property Details ? "); ?>/>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.close();" />
      </td>
  </tr>
</table>
</form>
</fieldset>
</center>

<?php } ?>
