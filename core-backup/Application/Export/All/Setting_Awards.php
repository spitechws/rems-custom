<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();


?>
<center>
<H2>AWARDS</H2>
   
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="width:98%;" align="center">
  <tr id="TH">
    <th width="4%">#</th>
    <th width="86%">AWARD </th>
    </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$award_QUERY="select * from tbl_award ";
		
	    
		$PAGINATION_QUERY=$award_QUERY."  order by award_id ";
		$award_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$award_QUERY=@mysqli_query($_SESSION['CONN'],$award_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($award_QUERY);

while($award_ROWS=@mysqli_fetch_assoc($award_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"><?php echo $award_ROWS['award']; ?></div></td>
    </tr>
  <?php } ?>
</table>
</center>
