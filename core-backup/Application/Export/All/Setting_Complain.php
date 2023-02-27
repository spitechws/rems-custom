<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
  $EDIT_ROW=$DBOBJ->GetRow("tbl_complain","complain_id",$_GET[md5('edit_id')]);


?>
<center>
<H2>COMPLAINS</H2>
<table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="width:98%;" align="center">
  <tr id="TH">
    <th width="2%">#</th>
    <th width="64%">COMPLAIN </th>
    <th colspan="2"><?php echo advisor_title?></th>
    </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$complain_QUERY="select * from tbl_complain ";
		
	    
		$PAGINATION_QUERY=$complain_QUERY."  order by complain_id ";
		$complain_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$complain_QUERY=@mysqli_query($_SESSION['CONN'],$complain_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($complain_QUERY);

while($COMPLAIN_ROWS=@mysqli_fetch_assoc($complain_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"><?php echo $COMPLAIN_ROWS['complain']; ?></div></td>
    <td width="20%"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$COMPLAIN_ROWS['advisor_id']);?></td>
    <td width="9%"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$COMPLAIN_ROWS['advisor_id']);?></td>
    </tr>
  <?php } ?>
</table>
</center>
