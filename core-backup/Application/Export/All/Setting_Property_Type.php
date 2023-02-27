<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

	
?>
<center>
<h1>Settings  : <span>Property Type</span></h1>
 
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="width:600px;" align="center">
  <tr id="TH">
    <th width="4%">#</th>
    <th width="86%">PROPERTY TYPE</th>
    </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$PROPERTY_TYPE_QUERY="select * from tbl_setting_property_type ";
		
	    
		$PAGINATION_QUERY=$PROPERTY_TYPE_QUERY."  order by property_type_id ";
		$PROPERTY_TYPE_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PROPERTY_TYPE_QUERY=@mysqli_query($_SESSION['CONN'],$PROPERTY_TYPE_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PROPERTY_TYPE_QUERY);

while($PROPERTY_TYPE_ROWS=@mysqli_fetch_assoc($PROPERTY_TYPE_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"><?php echo $PROPERTY_TYPE_ROWS['property_type']; ?></div></td>
    </tr>
  <?php } ?>
</table>
</center>
   