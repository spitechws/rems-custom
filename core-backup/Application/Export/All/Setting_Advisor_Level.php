<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<center>
<h1>Settings  : <span><?php echo advisor_title?> Level</span></h1>
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable"  align="center">
      <tr id="TH">
    <th width="3%">#</th>
    <th width="7%">LEVEL</th>
    <th width="7%">TARGET(SELF COLLECTION) TO PROMOT NEXT LEVEL</th>
    <th width="8%">NO OF UNIT SALE</th>
    <th width="9%">NO&nbsp;OF ACTIVE&nbsp;MEMBERS</th>
    <th width="61%">PROPERTY TYPE WISE COMMISSION PLAN</th>
    </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$LEVEL_QUERY="select * from tbl_setting_advisor_level ";
		
	    
		$PAGINATION_QUERY=$LEVEL_QUERY."  order by level_id ";
		$LEVEL_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$LEVEL_QUERY=@mysqli_query($_SESSION['CONN'],$LEVEL_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($LEVEL_QUERY);

while($LEVEL_ROWS=@mysqli_fetch_assoc($LEVEL_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ></div>
      <div align="center"><?php echo $LEVEL_ROWS['level_name']; ?></div></td>
    <td style="text-align:right"><?php echo @number_format($LEVEL_ROWS['level_target'],2)?>&nbsp;</td>
    <td ><div align="center"><?php echo $LEVEL_ROWS['level_unit_sale']; ?></div></td>
    <td ><div align="center"><?php echo $LEVEL_ROWS['level_active_member']; ?></div></td>
    <td align="center">
      <center>
        <?php 	$PROJECT_Q="select project_id, project_name from tbl_project order by project_name";
	$PROJECT_Q=@mysqli_query($_SESSION['CONN'],$PROJECT_Q);
	$p=1;
	?>
        <table width="200" border="1" cellspacing="0" cellpadding="0" id="ExportTable">
          <tr id="TH">
            <th width="4%">#</th>
            <th width="21%">PROJECT</th>
            <th width="75%">PROPERTY TYPE WISE PERCENT</th>
            </tr>
          <?php while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) {?>
          <tr>
            <td style="text-align:center;"><?php echo $p++?>.</td>
            <td><?php echo $PROJECT_ROWS['project_name']?></td>
            <td><table width="100" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="width:100PX;" align="center">
              <tr>
                <?php $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type ");
	 	 while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
		 {?>
                <th><div align="center">
                  <?php echo $TYPE_ROWS['property_type'];?>
                  </div></th>
                <?php } ?>
                </tr>
              <tr>
                <?php $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type ");
	 	 while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
		 {?>
                <td style="background:white;"><div align="center" style="width:100px;">
                  <?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level_with_property_type","project_id='".$PROJECT_ROWS['project_id']."' and level_id='".$LEVEL_ROWS['level_id']."' and property_type_id","commission_percent",$TYPE_ROWS['property_type_id']);?>
                  &nbsp;% </div></td>
                <?php } ?>
                </tr>
              </table></td>
            </tr>
          <?php } ?>
          </table>
        
      </center></td>
    </tr>
  <?php } ?>
</table>
 </center>
   