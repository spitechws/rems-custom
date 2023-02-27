<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$CUSTOMER_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$_GET[md5('customer_id')]);
?>
<center>
<h1>Customer  : <span>Profile</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td width="39%" align="center">
    <center>
   

   <h2 style="margin:0px; width:502px;">Customer Profile</h2>

     
    <table border="1" cellspacing="0" cellpadding="5" id="ExportTable" style="border:0px; margin-top:0px;">  
   <tr>
     <td colspan="2"><H4>CUSTOMER DETAILS</H4></td>
   </tr>
    <tr>
      <td>NAME</td>
      <td style="color:RED; font-size:13PX;" id="Value"><?php echo $CUSTOMER_ROW['customer_title']." ".$CUSTOMER_ROW['customer_name']?></td>
      </tr>

    <tr>
      <td width="180"> ID CODE </td>
      <td width="291"><span style="color:blue; font-size:13PX;" id="Value"><?php echo $CUSTOMER_ROW['customer_code']?></span></td>
      </tr>
    <tr>
      <td style="line-height:12px;">FATHER'S/HUSBAND'S NAME </td>
      <td  id="Value"><?php echo $CUSTOMER_ROW['customer_fname'];?></td>
      </tr>
    <tr>
      <td>SEX </td>
      <td  id="Value"><?php echo $CUSTOMER_ROW['customer_sex'];?></td>
      </tr>
    <tr>
      <td>MARITAL STATUS</td>
      <td  id="Value"><?php echo $CUSTOMER_ROW['customer_marital_status'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">BLOOD GROUP</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_bg'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">MOBILE O</td>
      <td id="Value" style="color:blue;"><?php echo $CUSTOMER_ROW['customer_mobile'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">WHATS APP NO</td>
      <td id="Value" style="color:blue;"><?php echo $CUSTOMER_ROW['customer_whatsapp_no'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">PHONE NO</td>
      <td id="Value" style="color:blue;"><?php echo $CUSTOMER_ROW['customer_phone'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">EMAIL ID</td>
      <td id="Value" style="text-transform:none;"><?php echo $CUSTOMER_ROW['customer_email'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">PAN NO</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_pan'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">OCCUPATION</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_occupation'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">DESIGNATION</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_designation'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">ANUAL INCOME</td>
      <td id="Value" style="color:blue;"><?php echo @number_format($CUSTOMER_ROW['customer_anual_income'],2);?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">CITY</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_city'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">ADDRESS</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_address'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">DATE OF BIRTH </td>
      <td id="Value"><?php ShowDate($CUSTOMER_ROW['customer_dob']);?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">ANNIVERSARY DATE</td>
      <td id="Value">
	  <?php ShowDate($CUSTOMER_ROW['customer_anniversary_date']);?></td>
    </tr>
    <tr>
      <td style="line-height:13px;">REG. DATE</td>
      <td id="Value"><?php ShowDate($CUSTOMER_ROW['customer_reg_date']); ?></td>
      </tr>
       <tr>
      <td colspan="2"><H4>NOMINEE DETAILS</H4></td>
      </tr>
   
       <tr>
         <td>NOMINEE NAME<span style="line-height:13px;"> </span></td>
         <td id="Value" style="color:blue;"><?php echo $CUSTOMER_ROW['customer_nominee_name'];?></td>
         </tr>
       <tr>
         <td style="text-align:justify; line-height:13px;">RELATION WITH CUSTOMER</td>
         <td id="Value" style="color:red;"><?php echo $CUSTOMER_ROW['customer_relation_with_nominee'];?></td>
         </tr>
       <tr>
         <td style="line-height:13px;">DAT OF BIRTH</td>
         <td id="Value"><?php echo date('d-M-Y',strtotime($CUSTOMER_ROW['customer_nominee_dob']));?></td>
         </tr>
       <tr>
      <td style="line-height:13px;">MOBILE NO</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_nominee_mobile'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">PHONE NO</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_nominee_phone'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px;">ADDRESS&nbsp;OF&nbsp;NOMINEE</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_nominee_address'];?></td>
      </tr>

</table>


</center></td>
    <td width="61%" align="center" style="vertical-align:top;">
    <h2 style="margin-top:0PX;">BOOKING DETAILS</h2>
    <div style="width:780px; overflow:auto; border:1px solid gray; height:250px; margin:10px;margin-top:0PX;">
    <table width="98%" border="1" cellspacing="0" id="ExportTable">
  <tr id="TH">
    <th width="2%" rowspan="2">#</th>
    <th colspan="3">PROPERTY DETAILS</th>
    <th colspan="2">DATE</th>
    <th width="21%" rowspan="2">ORDER&nbsp;NO</th>
    <th colspan="3">MRP</th>
    <th colspan="2">PAYMENTS</th>
    <th width="6%" colspan="2" rowspan="2">STATUS</th>
    </tr>
  <tr id="TH">
    <th>PROPERTY</th>
    <th>TYPE</th>
    <th>PROJECT</th>
    <th width="8%">BOOKING</th>
    <th width="6%">EXPIRY</th>
    <th width="4%">MRP</th>
    <th width="3%">DIS</th>
    <th width="7%">DIS.MRP</th>
    <th width="8%">RECEIVED</th>
    <th width="8%">BALANCE</th>
    </tr>
  
  <?php   
  $BOOKING_Q="SELECT * FROM tbl_property_booking where approved='1' and booking_customer_id='".$_GET[md5('customer_id')]."' order by booking_date";
  $BOOKING_Q=@mysqli_query($_SESSION['CONN'],$BOOKING_Q);
  while($BOOKING_ROWS=@mysqli_fetch_assoc($BOOKING_Q)) 
  { 
   $PROPERTY_NO=$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROWS['booking_property_id']);
   $PROPERTY_TYPE_NAME=$DBOBJ->PropertyTypeName($BOOKING_ROWS['booking_property_id']);
   $PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROWS['booking_project_id']);
   $RECEIVED=$DBOBJ->TotalBookingCollection($BOOKING_ROWS['booking_id']);
   $BAL=$DBOBJ->TotalBookingBalance($BOOKING_ROWS['booking_id']);
   $status=$BOOKING_ROWS['booking_cancel_status'];
   if($status=="Yes") { $status="CENCELLED"; $BG="RED"; } else { $status="ACTIVE"; $BG="GREEN"; }
   if($BOOKING_ROWS['booking_type']=="Permanent") { $BG1="RED"; $col="white"; } else { $BG1="orange"; $col="black"; }
  ?>  
  <tr>
    <td style="text-align:center;"><?php echo ++$j;?></td>
    <td width="9%"><div align="center"><?php echo $PROPERTY_NO;?></div></td>
    <td width="5%"><div align="center"><?php echo $PROPERTY_TYPE_NAME;?></div></td>
    <td width="13%"><div align="center" style="width:150px;"><?php echo $PROJECT_NAME;?></div></td>
    <td style="text-align:center"><?php echo date('d-M-Y',strtotime($BOOKING_ROWS['booking_date']));?></td>
    <td style="text-align:center"><?php echo date('d-M-Y',strtotime($BOOKING_ROWS['booking_token_exp_date']));?></td>
    <td style="text-align:center"><?php echo $BOOKING_ROWS['booking_order_no'];?></td>
    <td style="text-align:right;"><?php echo @number_format($BOOKING_ROWS['booking_property_mrp'],2);$TOTAL_MRP+=$BOOKING_ROWS['booking_property_mrp'];?></td>
    <td style="text-align:right;"><?php echo @number_format($BOOKING_ROWS['booking_property_discount_amount'],2);$TOTAL_DIS+=$BOOKING_ROWS['booking_property_discount_amount'];?></td>
    <td style="text-align:right;"><?php echo @number_format($BOOKING_ROWS['booking_property_discounted_mrp'],2);$TOTAL_DIS_MRP+=$BOOKING_ROWS['booking_property_discounted_mrp'];?></td>
    <td style="text-align:right;"><?php echo @number_format($RECEIVED,2);$TOTAL_RECEIVED+=$RECEIVED;?></td>
    <td style="text-align:right;"><?php echo @number_format($BAL,2);$TOTAL_BALANCE+=$BAL;?></td>
    <td style="background:<?php echo $BG?>; color:white;"><?php echo $status?></td>
    <td style="background:<?php echo $BG1?>; color:<?php echo $col?>;"><?php echo $BOOKING_ROWS['booking_type'];?></td>
    </tr>
  <?php } ?>
  <tr>
    <th colspan="7">&nbsp;</th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_MRP,2);?></th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_DIS,2);?></th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_DIS_MRP,2);?></th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_RECEIVED,2);?></th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_BALANCE,2);?></th>
    <th colspan="2" style="text-align:right">&nbsp;</th>
    </tr>
</table>
</div>
    
    </td>
  </tr>
</table></center>
