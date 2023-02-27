<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$ADVISOR_ID=$_GET[md5('advisor_id')];


?>
<center>
<h2>Documents</h2>
<table width="94%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" >
  <tr id="TH">
    <th width="2%" height="16">#</th>
    <th width="61%">DOCUMET NAME/DETAILS</th>
    <th>DATE</th>
    <th>TYPE</th>
    <th>SIZE</th>
    </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$DOCS_QUERY="select * from tb_advisor_docs where advisor_id='".$_GET[md5('advisor_id')]."' ";		
	   
		$PAGINATION_QUERY=$DOCS_QUERY."  order by doc_id ";
		$DOCS_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$DOCS_QUERY=@mysqli_query($_SESSION['CONN'],$DOCS_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($DOCS_QUERY);

while($DOCS_ROWS=@mysqli_fetch_assoc($DOCS_QUERY)) 
{
	$path="../SpitechUploads/advisor/documents/".$DOCS_ROWS['doc'];
	 $size=@filesize($path)/1024; 
	?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td><div align="left"><?php echo $DOCS_ROWS['doc_name'];?></div></td>
    <td width="8%"><div align="center"><?php $AR=explode(",",$DOCS_ROWS['created_details']); echo date('d-m-Y',strtotime($AR[2]))?></div></td>
    <td width="15%" style="text-align:center;">
    <?php 	echo $ext = pathinfo($path, PATHINFO_EXTENSION);
	?>
    </td>
    <td width="6%" style="text-align:center;"><?php echo @number_format($size,2)."KB"; ?></td>
    </tr>
  <?php } ?>
</table>
</center>