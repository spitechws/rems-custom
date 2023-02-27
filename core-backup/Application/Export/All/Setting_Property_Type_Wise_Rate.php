<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<center>
<h1>Settings  : <span>Property Type Wise Rate</span></h1>
<table width="300" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="border:0px;" align="center">
  <tr id="TH">
    <th>#</th>
    <th>PROJECT</th>
    <th>PROPERTY TYPE RATE / SQ.FT.</th>
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
    <table width="270" border="1" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr id="TH">
    <th width="24%" style="color:maroon">TYPE</th>
    <th width="28%">AREA RATE</th>
    <th width="24%">BUILT_UP_RATE</th>
    <th width="24%">SUP_BUILT_UP_RATE</th>
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
    <td><?php echo $plot?></td>
    <td><?php echo $built?></td>
    <td><?php echo $super?></td>
    </tr>
   <?php } ?> 
</table>
<?php } ?>
  
    </td>
  </tr>
<?php } ?>
  </table>
 </center>
   