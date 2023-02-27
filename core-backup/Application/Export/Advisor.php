<?php 
include_once('../php/Excel.php'); 
ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<center>
<h1><?php echo advisor_title?>  : <span> Master List</span></h1>
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" >
      <tr id="TH">
    <th width="2%" rowspan="2">#</th>
    <th width="3%" rowspan="2"><div align="center" style="width:80px;">ID&nbsp;CODE</div></th>
    <th width="17%" rowspan="2">NAME</th>
    <th width="7%" rowspan="2">LEVEL</th>
    <th colspan="2">SPONSOR</th>
    <th colspan="3">CONTACT DETAILS</th>
    <th width="7%" rowspan="2">HIRE&nbsp;DATE</th>
    <th width="7%" rowspan="2">DOB</th>
    </tr>
      <tr id="TH">
        <th width="16%">NAME</th>
        <th width="7%">ID&nbsp;CODE</th>
        <th width="4%">MOBILE</th>
        <th width="4%">PHONE</th>
        <th width="16%">EMAIL</th>
      </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ADVISOR_QUERY="select * from tbl_advisor where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET['advisor_name']!="") 		{ $ADVISOR_QUERY.=" and advisor_name like '%".$_GET['advisor_name']."%' "; }
			if($_GET['advisor_code']!="") 		{ $ADVISOR_QUERY.=" and advisor_code ='".$_GET['advisor_code']."' "; }
			if($_GET['advisor_mobile']!="") 	{ $ADVISOR_QUERY.=" and advisor_mobile ='".$_GET['advisor_mobile']."' "; }
			if($_GET['advisor_email']!="") 		{ $ADVISOR_QUERY.=" and advisor_email ='".$_GET['advisor_email']."' "; }
			if($_GET['advisor_bg']!="") 		{ $ADVISOR_QUERY.=" and advisor_bg ='".$_GET['advisor_bg']."' "; }
			if($_GET['advisor_sponsor']!="All") 	{ $ADVISOR_QUERY.=" and advisor_sponsor ='".$_GET['advisor_sponsor']."' "; }
			if($_GET['advisor_level_id']!="All")	{ $ADVISOR_QUERY.=" and advisor_level_id ='".$_GET['advisor_level_id']."' "; }
		}
	    
		$PAGINATION_QUERY=$ADVISOR_QUERY."  order by advisor_name ";
		$ADVISOR_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ADVISOR_QUERY=@mysqli_query($_SESSION['CONN'],$ADVISOR_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ADVISOR_QUERY);

while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="center"><?php echo $ADVISOR_ROWS['advisor_code']; ?></div></td>
    <td ><div align="left"  style="width:200PX;"><?php echo $ADVISOR_ROWS['advisor_name']; ?></div></td>
    <td >
    <div align="center" style="width:80PX;">
	   <?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROWS['advisor_level_id']); ?>
    </div>
    </td>
    <td >
    <div align="LEFT" style="width:200PX;">
	<?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$ADVISOR_ROWS['advisor_sponsor']); ?>
    </div>
    </td>
    <td >
    <div align="center" style="width:80PX;">
	<?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$ADVISOR_ROWS['advisor_sponsor']); ?>
    </div>
    </td>
    <td><div align="center"><?php echo $ADVISOR_ROWS['advisor_mobile']; ?></div></td>
    <td><div align="center"><?php echo $ADVISOR_ROWS['advisor_phone']; ?></div></td>
    <td><div align="left" style="text-transform:none;"><?php echo $ADVISOR_ROWS['advisor_email']; ?></div></td>
    <td><div align="center" style="width:80PX;"><?php ShowDate($ADVISOR_ROWS['advisor_hire_date']); ?></div></td>
    <td><div align="center" style="width:80PX;"><?php ShowDate($ADVISOR_ROWS['advisor_dob']); ?></div></td>
    </tr>
  <?php } ?>
</table>
</center>
  