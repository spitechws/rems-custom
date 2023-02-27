<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$s_date=date('Y-m-d');
$e_date=date('Y-m-d');

if(isset($_GET['Search']))
{
	$s_date=$_GET['s_date'];
	$e_date=$_GET['e_date'];
}

?>
<center>
<h1><?php echo advisor_title?>  : <span> Promoted Report</span></h1>
    <table width="100%"  id="ExportTable"  cellspacing="0" border="1">
      <tr id="TH">
        <th width="39" height="30">#</th>
        <th width="209"><?php echo advisor_title?>&nbsp;NAME </th>
        <th width="77">ID</th>
        <th width="121">CURRENT LEVEL</th>
        <th width="106">FROM&nbsp;LEVEL</th>
        <th width="110">TO LEVEL<font style="color:red; font-size:9px; text-transform:none"></font></th>
        <th colspan="2">DATE<font style="color:red; font-size:9px; text-transform:none"></font></th>
        <th width="376">USER</th>
        </tr>
      <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		 $PROMOTION_QUERY="select * from tbl_advisor_promotion where 1 ";
		if(isset($_GET['Search']))
		{  
			if($_GET[md5('advisor_id')]!="All") 		{ $PROMOTION_QUERY.=" and advisor_id ='".$_GET[md5('advisor_id')]."' "; }	
			if($_GET[md5('prev_level_id')]!="All") 	 { $PROMOTION_QUERY.=" and prev_level_id ='".$_GET[md5('prev_level_id')]."' "; }	
			if($_GET[md5('promoted_level_id')]!="All") { $PROMOTION_QUERY.=" and promoted_level_id ='".$_GET[md5('promoted_level_id')]."' "; }	
			
		}
	    
		$PROMOTION_QUERY.=" and promotion_date between '$s_date' and '$e_date' ";
		$PAGINATION_QUERY=$PROMOTION_QUERY."  order by promotion_date ";
	    $PROMOTION_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PROMOTION_QUERY=@mysqli_query($_SESSION['CONN'],$PROMOTION_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PROMOTION_QUERY);

while($PROMOTION_ROWS=@mysqli_fetch_assoc($PROMOTION_QUERY)) 
{
	$advisor_id=$PROMOTION_ROWS['advisor_id'];
    $ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$advisor_id);
    $level_id=$ADVISOR_ROW['advisor_level_id'];
    $level=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$level_id);
	
	$FROM=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$PROMOTION_ROWS['prev_level_id']);
	$TO=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$PROMOTION_ROWS['promoted_level_id']);
	
?>
      <tr>
        <td height="22"><div align="center"><?php echo $k++?>.</div></td>
        <td><?php echo $ADVISOR_ROW['advisor_name']; ?></td>
        <td><div align="center"><?php echo $ADVISOR_ROW['advisor_code']; ?></div></td>
        <td style="text-align:center"><?php echo $level?></td>
        <td style="text-align:center"><?php echo $FROM;?></td>
       <td style="text-align:center;"><?php echo $TO;?></td>
        <td width="90" style="text-align:center"><?php echo date('d-m-Y',strtotime($PROMOTION_ROWS['promotion_date']))?></td>
        <td width="95" style="text-align:center"><?php echo date('h:i:sA',strtotime($PROMOTION_ROWS['promotion_time']))?></td>
        <td style="text-align:justify; line-height:10px; font-size:9px;"><?php echo $PROMOTION_ROWS['created_details']?></td>
        </tr>       
      <?php } ?>
  </table>
 </center>
