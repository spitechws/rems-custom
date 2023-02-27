<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
?>
<center>
<h1>Project  : <span> Property Master List (<font>Manage Property</font>) </span></h1>
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable">
      <tr id="TH">
    <th width="2%" rowspan="2">#</th>
    <th width="6%" rowspan="2">PROPERTY NO</th>
    <th width="6%" rowspan="2">TYPE</th>
    <th width="12%" rowspan="2">PROJECT</th>
    <th colspan="3">AREA DETAILS (IN SQUARE FEET)</th>
    <th colspan="2">BOOKING DETAILS IF BOOKED</th>
    <th width="4%" rowspan="2">KHASRA</th>
    <th width="5%" rowspan="2">REMARKS</th>
    <th width="11%" rowspan="2">STATUS</th>
    </tr>
      <tr id="TH">
        <th width="5%">PLOT&nbsp;AREA</th>
        <th width="5%">BUILT&nbsp;UP AREA</th>
        <th width="6%">SUPER&nbsp;BUILT&nbsp;UP AREA</th>
        <th width="11%">CUSTOMER'S NAME<br /> (IF BOOKED)</th>
        <th width="13%"><?php echo advisor_title?>'S&nbsp;NAME<br /> (IF BOOKED)</th>
        </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$PROPERTY_QUERY="select * from tbl_property where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET[md5('property_project_id')]!="All") { $PROPERTY_QUERY.=" and property_project_id='".$_GET[md5('property_project_id')]."' "; }
			if($_GET[md5('property_type_id')]!="All") 	{ $PROPERTY_QUERY.=" and property_type_id ='".$_GET[md5('property_type_id')]."' "; }
			if($_GET[md5('property_id')]!="All") 		 { $PROPERTY_QUERY.=" and property_id ='".$_GET[md5('property_id')]."' "; }
			if($_GET[md5('property_status')]!="All") 	 { $PROPERTY_QUERY.=" and property_status ='".$_GET[md5('property_status')]."' "; }			
		}
	    
		$PAGINATION_QUERY=$PROPERTY_QUERY."  order by property_project_id, property_no+0, property_id ";
		$PROPERTY_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PROPERTY_QUERY=@mysqli_query($_SESSION['CONN'],$PROPERTY_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PROPERTY_QUERY);

while($PROPERTY_ROWS=@mysqli_fetch_assoc($PROPERTY_QUERY)) 
{
	$BOOKING_ROW=$DBOBJ->GetRow('tbl_property_booking',"booking_cancel_status!='Yes' and approved='1' and booking_property_id",$PROPERTY_ROWS['property_id']);
	$CUSTOMER_NAME=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$BOOKING_ROW['booking_customer_id']);
	$ADVISOR_NAME=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$BOOKING_ROW['booking_advisor_id']);
	
	$STATUS=$PROPERTY_ROWS['property_status'];
	$BG_COLOR='NONE';
	$COLOR='BLACK';
	if($STATUS=="Available") 
	{ 
		$BG_COLOR='GREEN';$COLOR='AQUA';
		
	} 
	elseif($STATUS=='TempBooked') 
	{
		$BG_COLOR='ORANGE'; 	
		
	} 
	elseif($STATUS=="Booked") 
	{ 
		$BG_COLOR='RED';$COLOR='YELLOW';
	}
	
	
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_no']; ?></div></td>
    <td style="text-align:center;"><?php echo $DBOBJ->ConvertToText("tbl_setting_property_type","property_type_id","property_type",$PROPERTY_ROWS['property_type_id'])?></td>
    <td> 
    <div align="left"  style="width:150PX;">
	<?php 
	echo $PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$PROPERTY_ROWS['property_project_id']); 
	?>
    </div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_plot_area']; ?></div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_built_up_area']; ?></div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_super_built_up_area']; ?></div></td>
    <td><?php echo $CUSTOMER_NAME;?></td>
    <td><?php echo $ADVISOR_NAME;?></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_khasra_no']; ?></div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_remarks']; ?></div></td>
    <td style="background:<?php echo $BG_COLOR?>; color:<?php echo $COLOR?>;"><div align="center"><?php echo $PROPERTY_ROWS['property_status']; ?></div></td>
    </tr>
  <?php } ?>
</table>
</center>
    