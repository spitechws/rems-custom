<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
RefreshPage(0.3);
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
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
    <th width="28%">plot rate</th>
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
    <td><div align="center"><?php echo @number_format($plot,2)?></div></td>
    <td><div align="center"><?php echo @number_format($built,2)?></div></td>
    <td><div align="center"><?php echo @number_format($super,2)?></div></td>
    </tr>
   <?php } ?> 
</table>
<?php } ?>
  
    </td>
  </tr>
<?php } ?>
  <tr>
    <th colspan="3">
      <div align="right"></div></th>
    </tr>
</table>

