<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Settings");NoAdmin();NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

if(isset($_POST['Save']))
	 { 	  		
		          
				  $FIELDS=array("project_id" ,								
								"property_type_id",
								"plot_area_rate",
								"built_up_area_rate",
								"super_built_up_area_rate");									  
				 
				  
				
				//===================( DELETE ALL DATA )=================================
				 @mysqli_query($_SESSION['CONN']," TRUNCATE TABLE `tbl_project_property_type_rate` ");			
				
				 $PROJECT_Q="SELECT project_id, project_name FROM tbl_project ORDER BY project_name ";
				 $PROJECT_Q=@mysqli_query($_SESSION['CONN'],$PROJECT_Q);
				 while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
				 {
	 
				    $TYPE_Q="SELECT property_type_id, property_type from tbl_setting_property_type where 
							property_type_id in(select project_property_type_id 	
							FROM tbl_project_details where project_id ='".$PROJECT_ROWS['project_id']."')
							 ORDER BY property_type ";
							 
					$TYPE_Q=@mysqli_query($_SESSION['CONN'],$TYPE_Q);
					
					while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
					   { 
						  $common_id=$PROJECT_ROWS['project_id']."_".$TYPE_ROWS['property_type_id'];
						  
						  $VALUES=array($PROJECT_ROWS['project_id'] ,								
										$TYPE_ROWS['property_type_id'],
										$_POST["plot_area_rate".$common_id],
										$_POST["built_up_area_rate".$common_id],
										$_POST["super_built_up_area_rate".$common_id]);
									
						  $INSERT=$DBOBJ->Insert("tbl_project_property_type_rate",$FIELDS,$VALUES,0);						
					   }
				 }
	
					
					
					$DBOBJ->UserAction("PROPERTY TYPE WISE RATE SET","");
					$Message="PROPERTY TYPE WISE RATE SET SUCCESSFULLY.";
			
      header("location:Setting_Property_Type_Wise_Rate.php?Message=".$Message);
	}	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>
input[type=text] { height:18px; font-size:9px; width:98%; min-width:60px; }
</style>
<center>
<h1><img src="../SpitechImages/Settings.png" width="31" height="32" />Settings  : <span>Property Type Wise Rate</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">
    <center>
    <?php ErrorMessage(); ?>
    <form name="FormPropertyType" id="FormPropertyType" method="post"  >
    <fieldset style="width:700px; height:auto;">
<legend>Property Type Wise Rate :</legend>
<table width="300" border="0" cellspacing="1" cellpadding="0" id="Data-Table" style="border:0px;" align="center">
  <tr>
    <th>#</th>
    <th>project</th>
    <th>property type rate / sq.ft.</th>
    </tr>
 <?php  $PROJECT_Q="SELECT project_id, project_name FROM tbl_project ORDER BY project_name ";
 $PROJECT_Q=@mysqli_query($_SESSION['CONN'],$PROJECT_Q);
 while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) {
 ?>   
  <tr>
    <td width="19" style="text-align:center"><?php echo ++$i?>.</td>
    <td width="216"><?php echo $PROJECT_ROWS['project_name']?></td>
    <td width="445">
    <?php 	$TYPE_Q="SELECT property_type_id, property_type from tbl_setting_property_type where property_type_id in(select project_property_type_id FROM tbl_project_details where project_id ='".$PROJECT_ROWS['project_id']."') ORDER BY property_type ";
    $TYPE_Q=@mysqli_query($_SESSION['CONN'],$TYPE_Q);
	$count=@mysqli_num_rows($TYPE_Q);
	if($count>0) {
    ?>
    <table width="270" border="0" cellspacing="1" cellpadding="0" id="SmallTable">
  <tr>
    <th width="24%" style="color:#0F0">TYPE</th>
    <th width="28%">AREA rate</th>
    <th width="24%">BUILT_UP_rate</th>
    <th width="24%">SUP_BUILT_UP_rate</th>
    </tr>
   <?php   
   while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
   { 
     $common_id=$PROJECT_ROWS['project_id']."_".$TYPE_ROWS['property_type_id'];
	 
	 $plot=$DBOBJ->ConvertToText("tbl_project_property_type_rate","project_id='".$PROJECT_ROWS['project_id']."' AND property_type_id","plot_area_rate",$TYPE_ROWS['property_type_id']);
	 
	 $built=$DBOBJ->ConvertToText("tbl_project_property_type_rate","project_id='".$PROJECT_ROWS['project_id']."' AND property_type_id","built_up_area_rate",$TYPE_ROWS['property_type_id']);	 
	 
	 $super=$DBOBJ->ConvertToText("tbl_project_property_type_rate","project_id='".$PROJECT_ROWS['project_id']."' AND property_type_id","super_built_up_area_rate",$TYPE_ROWS['property_type_id']);
	 
	 
    ?> 
  <tr>
    <th><div align="left"><?php echo $TYPE_ROWS['property_type']?></div></th>
    <td><input type="text" name="plot_area_rate<?php echo $common_id?>" value="<?php echo $plot?>" placeholder="AREA RATE" <?php echo OnlyFloat()?> /></td>
    <td><input type="text" name="built_up_area_rate<?php echo $common_id?>" value="<?php echo $built?>" placeholder="BUILD UP RATE"  <?php echo OnlyFloat()?> /></td>
    <td><input type="text" name="super_built_up_area_rate<?php echo $common_id?>" value="<?php echo $super?>" placeholder="SUP BUILD UP RATE" <?php echo OnlyFloat()?> /></td>
    </tr>
   <?php } ?> 
</table>
<?php } ?>
  
    </td>
  </tr>
<?php } ?>
  <tr>
    <th colspan="3">
      <div align="right">
        <input type="submit" name="Save" id="Save" class="Button" value=" Save " <?php Confirm("Are You Sure ? Save Property Type ?"); ?>/>
        <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.location='Setting_Property_Type.php';" />
      </div></th>
    </tr>
</table>

    </fieldset>
    </form>
    </center>
    </td>
  </tr>
</table>
</center>
<?php 
if(isset($_GET[md5("property_type_delete_id")]) && $_SESSION['user_category']=="admin" && $_SESSION['user_id']=='admin' )
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_setting_property_type","property_type_id",$_GET[md5("property_type_delete_id")]);	
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_setting_property_type where property_type_id='".$_GET[md5("property_type_delete_id")]."'");	
	
	$DBOBJ->UserAction("PROPERTY TYPE DELETED","ID=".$_GET[md5("property_type_delete_id")].", PROPERTY TYPE : ".$DELETE_ROW['property_type']);	
	header("location:Setting_Property_Type.php?Message=Property Type : ".$DELETE_ROW['property_type']." Deleted.");	
}
include("../Menu/Footer.php"); 
?>
