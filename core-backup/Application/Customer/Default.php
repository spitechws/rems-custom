<?php
include_once("../Menu/HeaderCustomer.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Home");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
<center>
<h1><img src="../SpitechImages/Customer.png" width="31" height="32" />Booking : <span>List</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td width="61%" align="center" style="vertical-align:top;">
     <?php ErrorMessage()?>
        <table width="98%" border="0" cellspacing="1" id="Data-Table">
          <tr>
            <th width="2%" rowspan="2">#</th>
            <th colspan="3">property details</th>
            <th colspan="2">date</th>
            <th width="7%" rowspan="2">order&nbsp;no</th>
            <th colspan="3">mrp</th>
            <th colspan="2">payments</th>
            <th colspan="2" rowspan="2">status</th>
            <th width="8%" rowspan="2">action</th>
            </tr>
          <tr>
            <th>property</th>
            <th>type</th>
            <th>project</th>
            <th width="6%">booking</th>
            <th width="6%">expiry</th>
            <th width="6%">mrp</th>
            <th width="7%">discount</th>
            <th width="7%">discounted&nbsp;mrp</th>
            <th width="8%">paid</th>
            <th width="8%">balance</th>
            </tr>
          
<?php   
  $BOOKING_Q="SELECT * FROM tbl_property_booking where approved='1' and booking_customer_id='".$_SESSION['customer_id']."' order by booking_date";
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
            <td width="6%"><div align="center"><?php echo $PROPERTY_NO;?></div></td>
            <td width="6%"><div align="center"><?php echo $PROPERTY_TYPE_NAME;?></div></td>
            <td width="14%"><?php echo $PROJECT_NAME;?></td>
            <td style="text-align:center"><?php echo date('d-M-Y',strtotime($BOOKING_ROWS['booking_date']));?></td>
            <td style="text-align:center"><?php echo date('d-M-Y',strtotime($BOOKING_ROWS['booking_token_exp_date']));?></td>
            <td style="text-align:center"><?php echo $BOOKING_ROWS['booking_order_no'];?></td>
            <td style="text-align:right;"><?php echo @number_format($BOOKING_ROWS['booking_property_mrp'],2);$TOTAL_MRP+=$BOOKING_ROWS['booking_property_mrp'];?></td>
            <td style="text-align:right;"><?php echo @number_format($BOOKING_ROWS['booking_property_discount_amount'],2);$TOTAL_DIS+=$BOOKING_ROWS['booking_property_discount_amount'];?></td>
            <td style="text-align:right;"><?php echo @number_format($BOOKING_ROWS['booking_property_discounted_mrp'],2);$TOTAL_DIS_MRP+=$BOOKING_ROWS['booking_property_discounted_mrp'];?></td>
            <td style="text-align:right;"><?php echo @number_format($RECEIVED,2);$TOTAL_RECEIVED+=$RECEIVED;?></td>
            <td style="text-align:right;"><?php echo @number_format($BAL,2);$TOTAL_BALANCE+=$BAL;?></td>
            <td width="5%" style="background:<?php echo $BG?>; color:white;"><?php echo $status?></td>
            <td width="4%" style="background:<?php echo $BG1?>; color:<?php echo $col?>;"><?php echo $BOOKING_ROWS['booking_type'];?></td>
            <td style="text-align:center">
            <a href="Project_Property_Booking_Accounts.php?<?php echo md5('booking_id')."=".$BOOKING_ROWS['booking_id']?>" title="View Accounts">View&nbsp;Account</a>
            </td>
            </tr>
          <?php } ?>
          <tr>
            <th colspan="7"><div align="right">total</div></th>
            <th style="text-align:right"><?php echo @number_format($TOTAL_MRP,2);?></th>
            <th style="text-align:right"><?php echo @number_format($TOTAL_DIS,2);?></th>
            <th style="text-align:right"><?php echo @number_format($TOTAL_DIS_MRP,2);?></th>
            <th style="text-align:right"><?php echo @number_format($TOTAL_RECEIVED,2);?></th>
            <th style="text-align:right"><?php echo @number_format($TOTAL_BALANCE,2);?></th>
            <th colspan="3" style="text-align:right">&nbsp;</th>
            </tr>
  </table>

      
    </td>
  </tr>
</table></center>
<?php include("../Menu/FooterCustomer.php"); ?>