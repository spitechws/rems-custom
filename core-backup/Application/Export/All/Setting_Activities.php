<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

	
?>
<center>
<h2>ACTIVITY</h2>
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="width:98%;" align="center">
  <tr id="TH">
    <th width="4%">#</th>
    <th width="86%">ACTIVITY </th>
    </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$activity_QUERY="select * from tbl_activity ";
		
	    
		$PAGINATION_QUERY=$activity_QUERY."  order by activity_id ";
		$activity_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$activity_QUERY=@mysqli_query($_SESSION['CONN'],$activity_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($activity_QUERY);

while($activity_ROWS=@mysqli_fetch_assoc($activity_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"><?php echo $activity_ROWS['activity']; ?></div></td>
    </tr>
  <?php } ?>
</table>
</center>
