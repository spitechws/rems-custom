<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

function ShowMessage()
{
	if(isset($_GET['Message']))
	{
	
	//===============( BOOKING )===================================	
	  if(isset($_GET["booking_id"]))
	  { 
	  	echo "<DIV id='Message'>".$_GET['Message']."<a href='Project_Property_Booking_Accounts.php?".md5('booking_id')."=".$_GET["booking_id"]."'>View Account</a></div>";  
	  }
	 //====================(PAYMENT)=============================== 
	  if(isset($_GET["advisor_payment_id"]))
	  { 
	  	echo "<DIV id='Message'>".$_GET['Message']."</div>";  
	  }
	  
	}
}

//========================(APPROVE BOOKING)=====================================================
if(isset($_GET[md5('booking_id')]))
{
	$booking_id=$_GET[md5('booking_id')];
	$BOOKING_ROW=$DBOBJ->GetRow("tbl_property_booking","booking_id",$booking_id);
	
	$FIELDS=array("approved");
	$VALUES=array(1);
	$DBOBJ->UpDate("tbl_property_booking",$FIELDS,$VALUES,"booking_id",$booking_id);	
	
	$DBOBJ->UserAction("BOOKING APPROVED","ORDER NO : ".$BOOKING_ROW['booking_order_no']);
	header("location:Approval.php?booking_id=".$BOOKING_ROW['booking_id']."&Message=Booking Of Order NO : ".$BOOKING_ROW['booking_order_no']." Have Been Approved By Admin."); 
}

//========================(APPROVE PAYMENT)=====================================================
elseif(isset($_GET[md5('payment_id')]))
{
	$payment_id=$_GET[md5('payment_id')];
	$PAYMENT_ROW=$DBOBJ->GetRow("tbl_property_booking_payments","payment_id",$payment_id);
	$BOOKING_ROW=$DBOBJ->GetRow("tbl_property_booking","booking_id",$PAYMENT_ROW['payment_booking_id']);
	$FIELDS=array("approved");
	$VALUES=array(1);    
  
	//============(PAYMENT APPROVAL)==========================	
	    $DBOBJ->UpDate("tbl_property_booking_payments",$FIELDS,$VALUES,"payment_id",$payment_id);
	//============(COMMISSION APPROVAL)=======================	
		$DBOBJ->UpDate("tbl_advisor_commission",$FIELDS,$VALUES,"commission_voucher_no",$PAYMENT_ROW['payment_voucher_no']);	
	
	//=============(Registry Status)=========================
	  $booking_id=$BOOKING_ROW['booking_id'];
	  $TOTAL_BALANCE=$DBOBJ->TotalBookingBalance($booking_id);
	  if($TOTAL_BALANCE<=0)
	  {
		   //============( SET REGISTRY STATUS TO REGISTERED )=======================	
			$F=array("booking_registry_status");
			$V=array("Registered");
			$DBOBJ->UpDate("tbl_property_booking",$F,$V,"booking_id",$booking_id,0);	
	  }
	  else
	  {
		  //============( SET REGISTRY STATUS TO REGISTERED )=======================	
			$F=array("booking_registry_status");
			$V=array("");
			$DBOBJ->UpDate("tbl_property_booking",$F,$V,"booking_id",$booking_id,0);	
	  }
	//=======================================================
	
	$DBOBJ->UserAction("BOOKING PAYMENT RECEIVE APPROVED","VOUCHER NO : ".$PAYMENT_ROW['payment_voucher_no'].", ORDER NO : ".$PAYMENT_ROW['booking_order_no']);
	header("location:Approval.php?booking_id=".$BOOKING_ROW['booking_id']."&Message=Payment Receive Of Voucher No ".$PAYMENT_ROW['payment_voucher_no'].", Order NO : ".$PAYMENT_ROW['payment_order_no']." Have Been Approved By Admin.");
}

//========================(APPROVE Associate PAYMENT)=====================================================
elseif(isset($_GET[md5('advisor_payment_id')]))
{
	$payment_id=$_GET[md5('advisor_payment_id')];
	$PAYMENT_ROW=$DBOBJ->GetRow("tbl_advisor_payment","payment_id",$payment_id);
	$ADV_ROW=$DBOBJ->GetRow('tbl_advisor','advisor_id',$PAYMENT_ROW['payment_advisor_id']);
	$FIELDS=array("approved");
	$VALUES=array(1);
	//============(PAYMENT APPROVAL)====================================================================	
	    $DBOBJ->UpDate("tbl_advisor_payment",$FIELDS,$VALUES,"payment_id",$payment_id);
	
	
	$DBOBJ->UserAction("Associate PAYMENT APPROVED",advisor_title." : ".$ADV_ROW['advisor_name']);
	
	header("location:Approval.php?advisor_payment_id=ok&Message=Payment Receive ".advisor_title." : ".$ADV_ROW['payment_voucher_no']." Have Been Approved By Admin.");
}


?>
<center>
<h1>Approval  : <span> All Approval List</span></h1>
   
  <h2>Booking Approval</h2>
          <table width="100%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="margin-top:0px;">
            <tr id="TH">
              <th width="2%">#</th>
              <th width="7%">ORDER&nbsp;NO</th>
              <th width="8%">DATE</th>
              <th width="17%">CUSTOMER</th>
              <th width="5%">PROPERTY</th>
              <th width="13%">PROJECT</th>
              <th width="6%">HEADING</th>
              <th width="5%">MRP</th>
              <th width="5%">DISCOUNT</th>
              <th width="4%">TOTAL</th>
              <th width="21%">ENTERED BY USER</th>
            </tr>
<?php 
$i=1;
while($BOOK_ROWS=@mysqli_fetch_assoc($BOOK_Q)) {
?>  
            <tr>
              <td style="text-align:center;"><?php echo $i++?>.</td>
              <td style="text-align:center;"><?php echo $BOOK_ROWS['booking_order_no']?></td>
              <td style="text-align:center;"><?php echo date('d-m-Y',strtotime($BOOK_ROWS['booking_date']))?></td>
              <td><?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$BOOK_ROWS['booking_customer_id']); ?></td>
              <td><?php echo $DBOBJ->PropertyTypeName($BOOK_ROWS['booking_property_id'])."&nbsp;".$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOK_ROWS['booking_property_id']);?></td>
              <td><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOK_ROWS['booking_project_id'])?></td>
              <td style="text-align:center"><?php echo $BOOK_ROWS['booking_particular']?></td>
              <td style="text-align:right"><?php echo $BOOK_ROWS['booking_property_mrp']?></td>
              <td style="text-align:right"><?php echo $BOOK_ROWS['booking_property_discount_amount']?></td>
              <td style="text-align:right"><?php echo $BOOK_ROWS['booking_property_discounted_mrp']?></td>
              <td style="font-size:9PX; text-transform:NONE; line-height:10PX;"><?php echo $BOOK_ROWS['created_details']?></td>
            </tr>
            <?php } ?> 
            <tr>
              <tH colspan="11">&nbsp;</tH>
            </tr>
  </table>
    
          <h2> Payment Receive Approval</h2>
          <table width="100%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="margin-top:0px;">
            <tr id="TH">
              <th width="2%">#</th>
              <th width="6%">VOUCHER&nbsp;NO</th>
              <th width="5%">ORDER&nbsp;NO</th>
              <th width="6%">DATE</th>
              <th width="9%">HEADING</th>
              <th width="24%">CUSTOMER</th>
              <th colspan="2">PROPERTY/PROJECT</th>
              <th width="6%">AMOUNT</th>
              <th width="17%">ENTERED BY USER</th>
            </tr>
              
               <?php  

$i=1;
while($PAYMENT_ROWS=@mysqli_fetch_assoc($PAYMENT_Q)) {
?>  

            <tr>
              <td style="text-align:center;"><?php echo $i++?>.</td>
              <td style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_voucher_no']?></td>
              <td style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_order_no']?></td>
              <td style="text-align:center;"><?php echo date('d-m-Y',strtotime($PAYMENT_ROWS['payment_date']))?></td>
              <td style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_heading']?></td>
              <td><?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$PAYMENT_ROWS['payment_customer_id']); ?></td>
              <td width="6%"><?php echo $DBOBJ->PropertyTypeName($PAYMENT_ROWS['payment_property_id'])."&nbsp;".$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$PAYMENT_ROWS['payment_property_id']);?></td>
              <td width="12%"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$PAYMENT_ROWS['payment_project_id'])?></td>
              <td style="text-align:right"><?php echo @number_format($PAYMENT_ROWS['payment_amount'],2);?></td>
              <td style="font-size:9PX; text-transform:NONE; line-height:10PX;"><?php echo $PAYMENT_ROWS['created_details']?></td>
            </tr>
              <?php } ?>
            <tr>
              <th colspan="10">&nbsp;</th>
            </tr>
  </table>
 
 <h2> <?php echo advisor_title?> Payment Approval</h2>
  <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" >
    <tr id="TH">
      <th width="2%" rowspan="2">#</th>
      <th width="6%" rowspan="2">ID&nbsp;CODE</th>
      <th width="16%" rowspan="2">NAME</th>
      <th width="7%" rowspan="2">LEVEL</th>
      <th width="7%" rowspan="2">PAYMENT DATE</th>
      <th width="5%" rowspan="2">PAYMENT</th>
      <th colspan="5">PAYMENT DETAILS</th>
      <th width="7%" rowspan="2">ENTERED&nbsp;BY&nbsp;USER</th>
    </tr>
    <tr id="TH">
      <th>MODE</th>
      <th>DD/CHEQUE/TXN&nbsp;NO</th>
      <th>BANK</th>
      <th>DATE</th>
      <th>PAYMENT&nbsp;REMARKS</th>
    </tr>
<?php
$k=1;
while($PAYMENT_ROWS=@mysqli_fetch_assoc($ADV_QUERY)) 
{
	$ADV_ROW=$DBOBJ->GetRow('tbl_advisor','advisor_id',$PAYMENT_ROWS['payment_advisor_id']);?>
    <tr>
      <td><div align="center"><?php echo $k++;?>.</div></td>
      <td ><div align="center" style="width:70px;"><?php echo $ADV_ROW['advisor_code']; ?></div></td>
      <td ><div align="left"  style="width:200PX;"><?php echo $ADV_ROW['advisor_name']; ?></div></td>
      <td ><div align="center" style="width:70PX;"> <?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADV_ROW['advisor_level_id']); ?> </div></td>
      <td><div align="center" style="width:80PX;"><?php echo date('d-M-Y',strtotime($PAYMENT_ROWS['payment_date'])); ?></div></td>
      <td><div align="right">
        <?php echo @number_format($PAYMENT_ROWS['payment_amount'],2);$total_payment+=$PAYMENT_ROWS['payment_amount'];?>
      </div></td>
      <td width="7%"><div align="right">
        <?php echo $PAYMENT_ROWS['payment_mode'];?>
      </div></td>
      <td width="9%"><?php echo $PAYMENT_ROWS['payment_mode_no'];?></td>
      <td width="8%"><?php echo $PAYMENT_ROWS['payment_mode_bank'];?></td>
      <td width="6%" style="text-align:center;"><div style="width:70px;">
        <?php if($PAYMENT_ROWS['payment_mode']!="CASH") { echo $PAYMENT_ROWS['payment_mode_date']; }?>
      </div>
        <div align="center"></div></td>
      <td width="12%" style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_remark'];?></td>
      <td style="font-size:9PX; text-transform:NONE; line-height:10PX;"><?php echo $PAYMENT_ROWS['created_details']?></td>
     
    </tr>
    <?php } ?>
    <tr>
      <th colspan="5">&nbsp;</th>
      <th><div align="right">
        <?php echo @number_format($total_payment,2);?>
      </div></th>
      <th colspan="6">&nbsp;</th>
    </tr>
</table></center>
