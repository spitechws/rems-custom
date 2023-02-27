<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<center>
<h1>Customer  : <span>Master List</span></h1>
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" >
      <tr id="TH">
    <th width="2%" rowspan="2">#</th>
    <th width="6%" rowspan="2">ID&nbsp;CODE</th>
    <th width="16%" rowspan="2">NAME</th>
    <th width="7%" rowspan="2">REG.&nbsp;DATE</th>
    <th colspan="2">CONTACT DETAILS</th>
    <th width="37%" rowspan="2">BOOKING&nbsp;DETAILS (SHORT DETAILS)</th>
    </tr>
      <tr id="TH">
        <th width="3%">MOBILE</th>
        <th width="17%">ADDRESS</th>
      </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$CUSTOMER_QUERY="select customer_id, customer_title, customer_name, customer_code, customer_mobile, customer_address, customer_city, customer_reg_date, customer_photo from tbl_customer where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET['customer_name']!="") 		{ $CUSTOMER_QUERY.=" and customer_name like '%".$_GET['customer_name']."%' "; }
			if($_GET['customer_code']!="") 		{ $CUSTOMER_QUERY.=" and customer_code ='".$_GET['customer_code']."' "; }
			if($_GET['customer_mobile']!="") 	{ $CUSTOMER_QUERY.=" and customer_mobile ='".$_GET['customer_mobile']."' "; }
			if($_GET['customer_email']!="") 	{ $CUSTOMER_QUERY.=" and customer_email ='".$_GET['customer_email']."' "; }
			if($_GET['customer_phone']!="") 	{ $CUSTOMER_QUERY.=" and customer_phone ='".$_GET['customer_phone']."' "; }		
			if($_GET['customer_bg']!="") 		{ $CUSTOMER_QUERY.=" and customer_bg ='".$_GET['customer_bg']."' "; }		
				
		}
	    
		$PAGINATION_QUERY=$CUSTOMER_QUERY."  order by customer_name ";
		$CUSTOMER_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$CUSTOMER_QUERY=@mysqli_query($_SESSION['CONN'],$CUSTOMER_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($CUSTOMER_QUERY);

while($CUSTOMER_ROWS=@mysqli_fetch_assoc($CUSTOMER_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="center" style="width:70px;"><?php echo $CUSTOMER_ROWS['customer_code']; ?></div></td>
     <td ><div align="left"  style="width:200PX;"><?php echo $CUSTOMER_ROWS['customer_name']; ?></div></td>
    <td >
      <div align="center" style="width:80PX;"><?php echo ShowDate($CUSTOMER_ROWS['customer_reg_date']); ?>
        </div>
    </td>
    <td><div align="center"><?php echo $CUSTOMER_ROWS['customer_mobile']; ?></div></td>
    <td><div align="left"><?php echo $CUSTOMER_ROWS['customer_city'].", ".$CUSTOMER_ROWS['customer_address']; ?></div></td>
    <td>
      <?php    $BOOKING_Q="select booking_id, 
			booking_order_no,
			booking_project_id,
			booking_property_id, 
			booking_date,
			booking_property_discounted_mrp
	 from tbl_property_booking where booking_customer_id='".$CUSTOMER_ROWS['customer_id']."' and 
	 booking_cancel_status=''
	 and approved='1' ";
   $BOOKING_Q=@mysqli_query($_SESSION['CONN'],$BOOKING_Q);
   $COUNT=@mysqli_num_rows($BOOKING_Q);
   if($COUNT>0) {
  ?> 
      <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable">
        
        <tr id="TH">
          <th width="6%">#</th>
          <th width="21%">BOOKING&nbsp;NO</th>
          <th width="21%">PROPERTY</th>
          <th width="32%">PROJECT</th>
          <th width="20%">MRP</th>
          <th width="21%">PAID</th>
          <th width="21%">BALANCE</th>
          </tr>
        <?php 
		$i=1;
		while($BOOKING_ROWS=@mysqli_fetch_assoc($BOOKING_Q)) {  ?>
        <tr>
          <td><?php echo $i++;?>.</td>
          <td><div align="center" title="View Account"><?php echo $BOOKING_ROWS['booking_order_no'];?></div></td>
          <td>
            <div align="center">
              <?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROWS['booking_property_id'])."/"; 
    
	$PROPERTY_TYPE=$DBOBJ->ConvertToText("tbl_property","property_id","property_type_id",$BOOKING_ROWS['booking_property_id']); 
	echo $DBOBJ->ConvertToText("tbl_setting_property_type","property_type_id","property_type",$PROPERTY_TYPE); 
	?>
            </div></td>
          <td><div align="left" style="width:120PX;"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROWS['booking_project_id']); ?></div></td>
          <td><div align="right">
            <?php echo @number_format($BOOKING_ROWS['booking_property_discounted_mrp'],2); 
	$TOTAL_MRP+=$BOOKING_ROWS['booking_property_discounted_mrp'];
	?></div></td>
          <td><div align="right">
            <?php echo @number_format($COLLECTION=$DBOBJ->TotalBookingCollection($BOOKING_ROWS['booking_id']),2);
	$TOTAL_COLLECTION+=$COLLECTION;
	?></div></td>
          <td><div align="right"><?php echo @number_format($BALANCE=$DBOBJ->TotalBookingBalance($BOOKING_ROWS['booking_id']),2);
	$TOTAL_BALANCE+=$BALANCE;?></div></td>
          </tr>
        <?php } ?>
        <tr>
          <th colspan="4">TOTAL</th>
          <th><div align="right"><?php echo @number_format($TOTAL_MRP,2); $GRAND_TOTAL_MRP+=$TOTAL_MRP; $TOTAL_MRP=0;?></div></th>
          <th><div align="right"><?php echo @number_format($TOTAL_COLLECTION,2); $GRAND_TOTAL_COLLECTION+=$TOTAL_COLLECTION; $TOTAL_COLLECTION=0;?></div></th>
          <th><div align="right"><?php echo @number_format($TOTAL_BALANCE,2); $GRAND_TOTAL_BALANCE+=$TOTAL_BALANCE; $TOTAL_BALANCE=0;?></div></th>
          </tr>
  </table>
  <?php } ?>
    </td>
    </tr>

  <?php  } ?>
    <tr>
    <th colspan="6"><div align="right">TOTAL CALCULATIONS</div></th>
    <th>
      <table cellspacing="0" border="1" id="ExportTable" style="width:300px;" align="right">
        <tr id="TH">
          <th>MRP</th>
          <th>PAID</th>
          <th>BALANCE</th>
          </tr>
        <tr>
          <td><div align="right"><?php echo @number_format($GRAND_TOTAL_MRP,2); ?></div></td>
          <td><div align="right"><?php echo @number_format($GRAND_TOTAL_COLLECTION,2); ?></div></td>
          <td><div align="right"><?php echo @number_format($GRAND_TOTAL_BALANCE,2); ?></div></td>
          </tr>
  </table>
    </th>
    </tr>
</table>
</center>
   