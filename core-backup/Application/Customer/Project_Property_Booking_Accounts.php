<?php
include_once("../Menu/HeaderCustomer.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Home");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$BOOKING_ID = $_GET[md5('booking_id')];
$BOOKING_ROW = $DBOBJ->GetRow("tbl_property_booking", "booking_id", $_GET[md5("booking_id")]);

if ($BOOKING_ROW['booking_customer_id'] != $_SESSION['customer_id']) {
    header("location:Default.php?Error=Invalid Selecteion ");
}


$CUSTOMER_ROW = $DBOBJ->GetRow("tbl_customer", "customer_id", $BOOKING_ROW['booking_customer_id']);
$ADVISOR_ROW = $DBOBJ->GetRow("tbl_advisor", "advisor_id", $BOOKING_ROW['booking_advisor_id']);
$PROPERTY_ROW = $DBOBJ->GetRow("tbl_property", "property_id", $BOOKING_ROW['booking_property_id']);
$PROJECT_ROW = $DBOBJ->GetRow("tbl_project", "project_id", $BOOKING_ROW['booking_project_id']);

$ORDER_NO = $BOOKING_ROW['booking_order_no'];
$MRP = $BOOKING_ROW['booking_property_mrp'];
$DISCOUNT = $BOOKING_ROW['booking_property_discount'];
$DISCOUNT_AMOUNT = $BOOKING_ROW['booking_property_discount_amount'];
$DISCOUNTED_MRP = $BOOKING_ROW['booking_property_discounted_mrp'];
$BOOKING_DATE = $BOOKING_ROW['booking_date'];
$BOOKING_EXPIRY_DATE = $TOKEN_EXPIRY_DATE = $BOOKING_ROW['booking_token_exp_date'];
$CUSTOMER_ID = $BOOKING_ROW['booking_customer_id'];
$ADVISOR_ID = $BOOKING_ROW['booking_advisor_id'];

$PROPERTY_ID = $BOOKING_ROW['booking_property_id'];
$PROJECT_ID = $BOOKING_ROW['booking_project_id'];
$PROPERTY_TYPE_ID = $PROPERTY_ROW['property_type_id'];
$PROPERTY_TYPE = $DBOBJ->ConvertToText("tbl_setting_property_type", "property_type_id", "property_type", $PROPERTY_TYPE_ID);

$PROPERTY_STATUS = $PROPERTY_ROW['property_status'];

if ($BOOKING_ROW['booking_cancel_status'] == 'Yes') {
    $BOOKIN_STATUS = "Cancelled";
} else {
    $BOOKIN_STATUS = "Active";
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
    <h1><img src="../SpitechImages/ReceivePayment.png" width="31" height="32" /><img src="../SpitechImages/Customer.png" width="31" height="32" /><span>Accounts</span>

    </h1>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
        <tr>
            <td>
                <?php ErrorMessage(); ?>
                <H2>BOOKING DETAILS</H2>
                <div id="Account" align="center">    
                    <table width="99%" cellspacing="1" border="0" id="SmallTable">
                        <tr >
                            <th width="87" height="26" >ORDER&nbsp;NO </th>
                            <th width="120" >BOOKING&nbsp;DATE </th>           
                            <th width="125" >ACCOUNT&nbsp;STATUS</th>
                            <th width="125" >exp date</th>
                            <th width="109" >BOOKING&nbsp;STATUS</th>
                            <th width="315" >CUSTOMER&nbsp;NAME</th>
                            <th width="81" >code id</th>
                            <th width="258" >BOOKED&nbsp;BY <?php echo advisor_title ?></th>
                            <th width="69" >code id</th>

                        </tr>
                        <tr style="font-weight:bolder; font-size:11px;" >
                            <td height="21" style="color:red"><div align="center"><?php echo $ORDER_NO; ?></div></td>
                            <td><div align="center"><?php echo date('d-M-Y', strtotime($BOOKING_DATE)); ?></div></td>               
                            <td<?php
                            if ($BOOKING_ROW['booking_cancel_status'] == "Yes") {
                                $BG = "RED";
                                $COL = "WHITE";
                                $STATUS = "Cancelled";
                            } else {
                                $BG = "GREEN";
                                $COL = "WHITE";
                                $STATUS = "Active";
                            }
                            ?> style="background:<?php echo $BG ?>;COLOR:<?php echo $COL ?>; text-align:center;"><div align="center"><?php echo $BOOKIN_STATUS; ?></div></td>

                            <td<?php
                            if ($PROPERTY_STATUS == "Booked") {
                                $BG = "white";
                                $COL = "black";
                            } else {
                                $BG = "orange";
                                $COL = "WHITE";
                            }
                            ?> style="background:<?php echo $BG ?>;COLOR:<?php echo $COL ?>; text-align:center;"><?php echo date('d-M-Y', strtotime($BOOKING_EXPIRY_DATE)); ?></td>

                            <td><div align="center"><?php echo $PROPERTY_STATUS; ?></div></td>
                            <td><b style="color:red"><?php echo $CUSTOMER_ROW['customer_title'] . " " . $CUSTOMER_ROW['customer_name']; ?></b></td>
                            <td><div align="center"><?php echo $CUSTOMER_ROW['customer_code']; ?></div></td>
                            <td width="258" style="color:red" ><?php echo $ADVISOR_ROW['advisor_title'] . " " . $ADVISOR_ROW['advisor_name']; ?></td>
                            <td width="69" ><div align="center"><?php echo $ADVISOR_ROW['advisor_code'] ?></div></td>
                        </tr>

                    </table>

                    <table width="99%" cellspacing="1" border="0" align="center" id="SmallTable">
                        <tr >
                            <th width="189" height="26" >PROJECT&nbsp;NAME </th>
                            <th width="36" >&nbsp;TYPE </th>
                            <th width="63" >PROPERTY</th>
                            <th width="69" >PLOT&nbsp;AREA </th>
                            <th width="56" >BUILT&nbsp;UP&nbsp;</th>
                            <th width="83" >SUP&nbsp;BUILT&nbsp;UP&nbsp;</th>
                            <th width="92" >&nbsp;RATE&nbsp;@SQT&nbsp;FT </th>
                            <th width="92" >BUILT&nbsp;@SQT&nbsp;FT </th>
                            <th width="95" >SUPER&nbsp;@SQT&nbsp;FT</th>
                            <th width="27" >MRP</th>
                            <th width="60" >DISCOUNT</th>
                            <th width="63" ><div align="right">DISC.&nbsp;MRP </div></th>
                            <th width="98" >DN&nbsp;PAYMENTS&nbsp;% </th>
                        </tr>        
                        <tr bgcolor="#FFFFFF" style="font-size:11px; font-weight:normal;">
                            <td height="20"><?php echo $PROJECT_ROW['project_name']; ?></td>
                            <td><div align="center"><?php echo $PROPERTY_TYPE; ?></div></td>
                            <td><div align="center"><?php echo $PROPERTY_ROW['property_no']; ?></div></td>
                            <td><div align="center"><?php echo @number_format($BOOKING_ROW['booking_property_plot_area'], 2); ?></div></td>
                            <td><div align="center"><?php echo @number_format($BOOKING_ROW['booking_property_built_up_area'], 2); ?></div></td>
                            <td><div align="center"><?php echo @number_format($BOOKING_ROW['booking_property_super_built_up_area'], 2); ?></div></td>
                            <td><div align="right"><?php echo @number_format($BOOKING_ROW['booking_property_plot_area_rate'], 2); ?></div></td>
                            <td><div align="right"><?php echo @number_format($BOOKING_ROW['booking_property_built_up_area_rate'], 2); ?></div></td>
                            <td><div align="right"><?php echo @number_format($BOOKING_ROW['booking_property_super_built_up_rate'], 2); ?></div></td>
                            <td><div align="right"><?php echo @number_format($MRP, 2); ?></div></td>
                            <td><div align="right"><?php echo @number_format($DISCOUNT_AMOUNT, 2); ?></div></td>
                            <td><div align="right"><?php echo @number_format($DISCOUNTED_MRP, 2); ?></div></td>
                            <td><div align="center"><?php echo @number_format($DBOBJ->ConvertToText("tbl_project_details", "project_property_type_id='" . $PROPERTY_TYPE_ID . "' AND project_id", "project_standard_amount_percent", $PROJECT_ID), 2); ?></div></td>
                        </tr>
                    </table>

                    <table width="99%" cellspacing="1" border="0" id="SmallTable">
                        <tr >
                            <th width="165" >Payment Mode</th>
                            <th width="239" height="20" >Bank Name</th>
                        </tr>       
                        <tr >
                            <td><div align="center"><?php echo $BOOKING_ROW['booking_payment_mode']; ?></div></td>
                            <td height="21" ><div align="center"><?php echo $BOOKING_ROW['booking_payment_mode_bank']; ?></div></td>
                        </tr>        
                    </table>    
                </div>


                <H2>ACCOUNT STATEMENTS </H2>
                <div id="Account">
                    <table width="99%" cellspacing="1"  id="Data-Table" >          
                        <tr>
                            <th width="38" height="26" rowspan="2" >S.No</th>
                            <th width="76" rowspan="2" >Voucher&nbsp;No</th>
                            <th width="84" rowspan="2" >Voucher&nbsp;Date</th>
                            <th width="102" rowspan="2" >Particulars (Payment&nbsp;head)</th>
                            <th colspan="4" >Payment&nbsp;Description</th>
                            <th width="70" rowspan="2" >Debit</th>
                            <th width="77" rowspan="2" >Credit</th>
                            <th width="84" rowspan="2" >Balance</th>
                            <th width="171" rowspan="2" >Remarks</th>
                        </tr>
                        <tr >
                            <th width="84" >Payment&nbsp;Mode</th>
                            <th width="135" >Cheque/DD/Xaction&nbsp;#&nbsp;</th>
                            <th width="90" >Bank&nbsp;Name </th>
                            <th width="79" >Date</th>
                        </tr>
                        <?php
                        $DEBIT_TOTAL = 0;
                        $s1 = @mysqli_query($_SESSION['CONN'], "select * from tbl_property_book where project_id=" . $_GET[project_id] . " and property_id=" . $_GET[property_id] . " and customer_id=" . $_GET[customer_id] . " and order_number='" . $_GET['order_no'] . "'");
                        $r1 = @mysqli_fetch_array($s1);
                        ?> 		 
                        <tr>
                            <td height="20" >
                                <div align="center">1. </div></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><div align="left" style="color:#00aa00; font-weight:bolder;">PROPERY&nbsp;MRP </div></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><div align="right"><?php echo @number_format($MRP, 2); ?></div></td>
                            <td><div align="right"  style="color:#00aa00; font-weight:bolder;"><?php echo @number_format($MRP, 2); ?></div></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="20" ><div align="center">2. </div></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><div align="left" style="color:#ff0000; font-weight:bolder;">DISCOUNTED&nbsp;MRP</div></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><div align="right" style="color:#ff0000; font-size:14px;"><b><?php echo @number_format($BALANCE = $DISCOUNTED_MRP, 2); ?></b></div></td>
                            <td ><?php echo "DISCOUNT : <font style=\"color:#0000aa; font-weight:bolder;\">" . @number_format($DISCOUNT_AMOUNT, 2) . "&nbsp;(" . $DISCOUNT . ")"; ?></td>
                        </tr>		  
                        <?php
                        $k = 3;
                        $PAYMENT_Q = @mysqli_query($_SESSION['CONN'], "select * from tbl_property_booking_payments where approved='1' and payment_booking_id='$BOOKING_ID' ORDER BY payment_id");
                        while ($PAYMENT_ROWS = @mysqli_fetch_array($PAYMENT_Q)) {
                            ?>
                            <tr>
                                <td height="20" ><div align="center"><?php echo $k++; ?>.</div></td>
                                <td><div align="left"><?php echo $PAYMENT_ROWS['payment_voucher_no']; ?></div></td>
                                <td><div align="center"><?php echo date('d-M-Y', strtotime($PAYMENT_ROWS['payment_date'])); ?></div></td>
                                <td><div align="left"><?php echo $PAYMENT_ROWS['payment_heading']; ?></div></td>
                                <td><div align="left"><?php echo $PAYMENT_ROWS['payment_mode']; ?></div></td>
                                <td><div align="left"><?php echo $PAYMENT_ROWS['payment_mode_no']; ?></div></td>
                                <td><div align="left"><?php echo $PAYMENT_ROWS['payment_mode_bank']; ?></div></td>
                                <td>
                                    <div align="center">
                                        <?php
                                        if ($PAYMENT_ROWS['payment_mode_date'] != '0000-00-00') {
                                            echo date('d-M-Y', strtotime($PAYMENT_ROWS['payment_mode_date']));
                                        }
                                        ?>
                                    </div></td>
                                <td><div align="right"><?php
                                        echo @number_format($PAYMENT_ROWS['payment_amount'], 2);
                                        $TOTAL_PAID += $PAYMENT_ROWS['payment_amount'];
                                        ?></div></td>
                                <td><div align="right">
                                        <?php
                                        $BALANCE -= $PAYMENT_ROWS['payment_amount'];
                                        echo @number_format(0, 2);
                                        ?>
                                    </div></td>
                                <td><div align="right"><?php echo @number_format($BALANCE, 2); ?></div></td>
                                <td><div align="left"><?php echo $PAYMENT_ROWS['payment_remarks']; ?></div></td>
                            </tr>
                            <?php
                        }
                        ?>

                        <tr>
                            <th height="20" colspan="11" ><div align="right">TOTAL PAID AMOUNT </div></th>
                            <th ><div align="right" style="color:#00aa00; font-size:16px">
                                    <?php echo @number_format($TOTAL_PAID, 2); ?></div>            </th>
                        </tr>
                        <tr>
                            <th height="20" colspan="11" ><div align="right">OUTSTANDING AMOUNT </div></th>
                            <th ><div align="right" style="color:#aa0000; font-size:16px" ><?php echo @number_format($BALANCE, 2); ?></div></th>
                        </tr>
                    </table></div>

            </td>
        </tr>
    </table>
</center>
<?php include("../Menu/FooterCustomer.php"); ?>
