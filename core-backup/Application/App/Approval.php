<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Approval");
NoUser();
NoAdmin();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

function ShowMessage() {
    if (isset($_GET['Message'])) {

        //===============( BOOKING )===================================	
        if (isset($_GET["booking_id"])) {
            echo "<DIV id='Message'>" . $_GET['Message'] . "<a href='Project_Property_Booking_Accounts.php?" . md5('booking_id') . "=" . $_GET["booking_id"] . "'>View Account</a></div>";
        }
        //====================(PAYMENT)=============================== 
        if (isset($_GET["advisor_payment_id"])) {
            echo "<DIV id='Message'>" . $_GET['Message'] . "</div>";
        }
    }
}

//========================(APPROVE BOOKING)=====================================================
if (isset($_GET[md5('booking_id')])) {
    $booking_id = $_GET[md5('booking_id')];
    $BOOKING_ROW = $DBOBJ->GetRow("tbl_property_booking", "booking_id", $booking_id);

    $FIELDS = array("approved");
    $VALUES = array(1);
    $DBOBJ->UpDate("tbl_property_booking", $FIELDS, $VALUES, "booking_id", $booking_id);

    $DBOBJ->UserAction("BOOKING APPROVED", "ORDER NO : " . $BOOKING_ROW['booking_order_no']);
    header("location:Approval.php?booking_id=" . $BOOKING_ROW['booking_id'] . "&Message=Booking Of Order NO : " . $BOOKING_ROW['booking_order_no'] . " Have Been Approved By Admin.");
}

//========================(APPROVE PAYMENT)=====================================================
elseif (isset($_GET[md5('payment_id')])) {
    $payment_id = $_GET[md5('payment_id')];
    
    $PAYMENT_ROW = $DBOBJ->GetRow("tbl_property_booking_payments", "payment_id", $payment_id);
    $BOOKING_ROW = $DBOBJ->GetRow("tbl_property_booking", "booking_id", $PAYMENT_ROW['payment_booking_id']);
    $FIELDS = array("approved");
    $VALUES = array(1);

    //============(PAYMENT APPROVAL)==========================	
    $DBOBJ->UpDate("tbl_property_booking_payments", $FIELDS, $VALUES, "payment_id", $payment_id);
    //die($payment_id);
    //============(COMMISSION APPROVAL)=======================	
    $DBOBJ->UpDate("tbl_advisor_commission", $FIELDS, $VALUES, "commission_voucher_no", $PAYMENT_ROW['payment_voucher_no']);

    //=============(Registry Status)=========================
    $booking_id = $BOOKING_ROW['booking_id'];
    
    $TOTAL_BALANCE = $DBOBJ->TotalBookingBalance($booking_id);
    if ($TOTAL_BALANCE <= 0) {
        //============( SET REGISTRY STATUS TO REGISTERED )=======================	
        $F = array("booking_registry_status");
        $V = array("Registered");
        $DBOBJ->UpDate("tbl_property_booking", $F, $V, "booking_id", $booking_id);
    } else {
        //============( SET REGISTRY STATUS TO REGISTERED )=======================	
        $F = array("booking_registry_status");
        $V = array("");
        $DBOBJ->UpDate("tbl_property_booking", $F, $V, "booking_id", $booking_id);
    }
    
    //=======================================================

    $DBOBJ->UserAction("BOOKING PAYMENT RECEIVE APPROVED", "VOUCHER NO : " . $PAYMENT_ROW['payment_voucher_no'] . ", ORDER NO : " . $PAYMENT_ROW['booking_order_no']);
    header("location:Approval.php?booking_id=" . $BOOKING_ROW['booking_id'] . "&Message=Payment Receive Of Voucher No " . $PAYMENT_ROW['payment_voucher_no'] . ", Order NO : " . $PAYMENT_ROW['payment_order_no'] . " Have Been Approved By Admin.");
}

//========================(APPROVE Associate PAYMENT)=====================================================
elseif (isset($_GET[md5('advisor_payment_id')])) {
    $payment_id = $_GET[md5('advisor_payment_id')];
    $PAYMENT_ROW = $DBOBJ->GetRow("tbl_advisor_payment", "payment_id", $payment_id);
    $ADV_ROW = $DBOBJ->GetRow('tbl_advisor', 'advisor_id', $PAYMENT_ROW['payment_advisor_id']);
    $FIELDS = array("approved");
    $VALUES = array(1);
    //============(PAYMENT APPROVAL)====================================================================	
    $DBOBJ->UpDate("tbl_advisor_payment", $FIELDS, $VALUES, "payment_id", $payment_id);

    $DBOBJ->UserAction("Associate PAYMENT APPROVED", advisor_title . " : " . $ADV_ROW['advisor_name']);

    header("location:Approval.php?advisor_payment_id=ok&Message=Payment Receive " . advisor_title . " : " . $ADV_ROW['payment_voucher_no'] . " Have Been Approved By Admin.");
}

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>h2 { margin-top:0px; }</style>
<center>
    <h1><img src="../SpitechImages/Approval.png" width="31" height="32" />Approval  : <span> All Approval List</span></h1>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
        <tr>
            <td>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="49%">
                            <?php ShowMessage() ?>

                            <?php
                            //debug("demo");
                            $BOOK_Q = "SELECT * FROM tbl_property_booking WHERE approved!='1'";
                            $BOOK_Q = @mysqli_query($_SESSION['CONN'], $BOOK_Q);
                            $BOOKING_COUNT = @mysqli_num_rows($BOOK_Q);
                            if ($BOOKING_COUNT > 0) {
                                ?>       
                                <h2>Booking Approval</h2>
                                <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" style="margin-top:0px;">
                                    <tr>
                                        <th width="2%">#</th>
                                        <th width="7%">order&nbsp;no</th>
                                        <th width="8%">date</th>
                                        <th width="17%">Customer</th>
                                        <th width="5%">Property</th>
                                        <th width="13%">project</th>
                                        <th width="6%">heading</th>
                                        <th width="5%">mrp</th>
                                        <th width="5%">discount</th>
                                        <th width="4%">TOTAL</th>
                                        <th width="21%">entered by user</th>
                                        <th colspan="3" id="Action">Action</th>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    while ($BOOK_ROWS = @mysqli_fetch_assoc($BOOK_Q)) {
                                        ?>  
                                        <tr>
                                            <td style="text-align:center;"><?php echo $i++ ?>.</td>
                                            <td style="text-align:center;"><?php echo $BOOK_ROWS['booking_order_no'] ?></td>
                                            <td style="text-align:center;"><?php echo date('d-m-Y', strtotime($BOOK_ROWS['booking_date'])) ?></td>
                                            <td><?php echo $DBOBJ->ConvertToText("tbl_customer", "customer_id", "customer_name", $BOOK_ROWS['booking_customer_id']); ?></td>
                                            <td><?php echo $DBOBJ->PropertyTypeName($BOOK_ROWS['booking_property_id']) . "&nbsp;" . $DBOBJ->ConvertToText("tbl_property", "property_id", "property_no", $BOOK_ROWS['booking_property_id']); ?></td>
                                            <td><?php echo $DBOBJ->ConvertToText("tbl_project", "project_id", "project_name", $BOOK_ROWS['booking_project_id']) ?></td>
                                            <td style="text-align:center"><?php echo $BOOK_ROWS['booking_particular'] ?></td>
                                            <td style="text-align:right"><?php echo $BOOK_ROWS['booking_property_mrp'] ?></td>
                                            <td style="text-align:right"><?php echo $BOOK_ROWS['booking_property_discount_amount'] ?></td>
                                            <td style="text-align:right"><?php echo $BOOK_ROWS['booking_property_discounted_mrp'] ?></td>
                                            <td style="font-size:9PX; text-transform:NONE; line-height:10PX;"><?php echo $BOOK_ROWS['created_details'] ?></td>
                                            <td width="1%" style="text-align:center;" id="Action">
                                                <A id="Report" href="Project_Property_Booking_Accounts.php?<?php echo md5('booking_id') . "=" . $BOOK_ROWS['booking_id'] ?>">&nbsp;</A>
                                            </td>
                                            <td width="2%" style="text-align:center;"  id="Action">

                                                <a <?php Confirm("Are You Sure ? Approve This Booking Of Order No : " . $BOOK_ROWS['booking_order_no']); ?> href="Approval.php?<?php echo md5('booking_id') . "=" . $BOOK_ROWS['booking_id'] ?>" style="color:green;">Approve</a>

                                            </td>
                                            <td width="4%" style="text-align:center; color:red;"  id="Action">

                                                <a <?php Confirm("Are You Sure ? Reject This Booking Of Order No : " . $BOOK_ROWS['booking_order_no']); ?> href="Approval.php?<?php echo md5('reject_booking_id') . "=" . $BOOK_ROWS['booking_id'] ?>" style="color:red;">Reject
                                                </a>

                                            </td>
                                        </tr>
                                    <?php } ?> 
                                    <tr>
                                        <tH colspan="14">&nbsp;</tH>
                                    </tr>
                                </table>
                            <?php } ?>      
                        </td>
                    </tr>
                    <tr>
                        <td>

                            <?php
                            $PAYMENT_Q = "SELECT * FROM tbl_property_booking_payments WHERE approved!='1'";
                            $PAYMENT_Q = @mysqli_query($_SESSION['CONN'], $PAYMENT_Q);
                            $PAYMENT_COUNT = @mysqli_num_rows($PAYMENT_Q);
                            if ($PAYMENT_COUNT > 0) {
                                ?>       
                                <h2> Payment Receive Approval</h2>
                                <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" style="margin-top:0px;">
                                    <tr>
                                        <th width="2%">#</th>
                                        <th width="6%">VOUCHER&nbsp;NO</th>
                                        <th width="5%">ORDER&nbsp;NO</th>
                                        <th width="6%">DATE</th>
                                        <th width="9%">heading</th>
                                        <th width="24%">CUSTOMER</th>
                                        <th colspan="2">PROPERTY/PROJECT</th>
                                        <th width="6%">AMOUNT</th>
                                        <th width="17%">entered by user</th>
                                        <th colspan="3" id="Action">Action</th>
                                    </tr>

                                    <?php
                                    $i = 1;
                                    while ($PAYMENT_ROWS = @mysqli_fetch_assoc($PAYMENT_Q)) {
                                        ?>  

                                        <tr>
                                            <td style="text-align:center;"><?php echo $i++ ?>.</td>
                                            <td style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_voucher_no'] ?></td>
                                            <td style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_order_no'] ?></td>
                                            <td style="text-align:center;"><?php echo date('d-m-Y', strtotime($PAYMENT_ROWS['payment_date'])) ?></td>
                                            <td style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_heading'] ?></td>
                                            <td><?php echo $DBOBJ->ConvertToText("tbl_customer", "customer_id", "customer_name", $PAYMENT_ROWS['payment_customer_id']); ?></td>
                                            <td width="6%"><?php echo $DBOBJ->PropertyTypeName($PAYMENT_ROWS['payment_property_id']) . "&nbsp;" . $DBOBJ->ConvertToText("tbl_property", "property_id", "property_no", $PAYMENT_ROWS['payment_property_id']); ?></td>
                                            <td width="12%"><?php echo $DBOBJ->ConvertToText("tbl_project", "project_id", "project_name", $PAYMENT_ROWS['payment_project_id']) ?></td>
                                            <td style="text-align:right"><?php echo @number_format($PAYMENT_ROWS['payment_amount'], 2); ?></td>
                                            <td style="font-size:9PX; text-transform:NONE; line-height:10PX;"><?php echo $PAYMENT_ROWS['created_details'] ?></td>

                                            <td width="1%" style="text-align:center;" id="Action">
                                                <A id="Report" href='Project_Property_Booking_Next.php?<?php echo md5('payment_id') . "=" . $PAYMENT_ROWS['payment_id']; ?>'>&nbsp;</A>
                                            </td>
                                            <td width="2%" style="text-align:center;"  id="Action">

                                                <a <?php Confirm("Are You Sure ? Approve This Payment Receive Of Voucher No : " . $PAYMENT_ROWS['payment_voucher_no'] . " Of Order No : " . $PAYMENT_ROWS['payment_order_no']); ?> href="Approval.php?<?php echo md5('payment_id') . "=" . $PAYMENT_ROWS['payment_id'] ?>" style="color:green;">Approve</a>

                                            </td>
                                            <td width="4%" style="text-align:center; color:red;" id="Action">

                                                <a <?php Confirm("Are You Sure ? Reject This Payment Receive Of Voucher No : " . $PAYMENT_ROWS['payment_voucher_no'] . " Of Order No : " . $PAYMENT_ROWS['payment_order_no']); ?> href="Approval.php?<?php echo md5('reject_payment_id') . "=" . $PAYMENT_ROWS['payment_id'] ?>" style="color:red;">Reject
                                                </a>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <th colspan="13">&nbsp;</th>
                                    </tr>
                                </table>
                            <?php } ?>         
                        </td>



                    </tr> 


                    <tr>
                        <td>
                            <?php
                            $ADV_QUERY = "select * from tbl_advisor_payment where approved!='1' order by payment_date";
                            $ADV_QUERY = @mysqli_query($_SESSION['CONN'], $ADV_QUERY);
                            $ADV_COUNT = @mysqli_num_rows($ADV_QUERY);
                            if ($ADV_COUNT) {
                                ?> 
                                <h2> <?php echo advisor_title ?> Payment Approval</h2>
                                <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
                                    <tr>
                                        <th width="2%" rowspan="2">#</th>
                                        <th width="6%" rowspan="2">ID&nbsp;CODE</th>
                                        <th width="16%" rowspan="2">NAME</th>
                                        <th width="7%" rowspan="2">LEVEL</th>
                                        <th width="7%" rowspan="2">PAYMENT DATE</th>
                                        <th width="5%" rowspan="2">PAYMENT</th>
                                        <th colspan="5">PAYMENT DETAILS</th>
                                        <th width="7%" rowspan="2">entered&nbsp;by&nbsp;user</th>
                                        <th colspan="2" rowspan="2"  id="Action">ACTION</th>
                                    </tr>
                                    <tr>
                                        <th>MODE</th>
                                        <th>DD/CHECK/TXN&nbsp;NO</th>
                                        <th>BANK</th>
                                        <th>DATE</th>
                                        <th>payment&nbsp;remarks</th>
                                    </tr>
                                    <?php
                                    $k = 1;
                                    while ($PAYMENT_ROWS = @mysqli_fetch_assoc($ADV_QUERY)) {
                                        $ADV_ROW = $DBOBJ->GetRow('tbl_advisor', 'advisor_id', $PAYMENT_ROWS['payment_advisor_id']);
                                        ?>
                                        <tr>
                                            <td><div align="center"><?php echo $k++; ?>.</div></td>
                                            <td ><div align="center" style="width:70px;"><?php echo $ADV_ROW['advisor_code']; ?></div></td>
                                            <td ><div align="left"  style="width:200PX;"><?php echo $ADV_ROW['advisor_name']; ?></div></td>
                                            <td ><div align="center" style="width:70PX;"> <?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level", "level_id", "level_name", $ADV_ROW['advisor_level_id']); ?> </div></td>
                                            <td><div align="center" style="width:80PX;"><?php echo date('d-M-Y', strtotime($PAYMENT_ROWS['payment_date'])); ?></div></td>
                                            <td><div align="right">
                                                    <?php
                                                    echo @number_format($PAYMENT_ROWS['payment_amount'], 2);
                                                    $total_payment += $PAYMENT_ROWS['payment_amount'];
                                                    ?>
                                                </div></td>
                                            <td width="7%"><div align="right">
                                                    <?php echo $PAYMENT_ROWS['payment_mode']; ?>
                                                </div></td>
                                            <td width="9%"><?php echo $PAYMENT_ROWS['payment_mode_no']; ?></td>
                                            <td width="8%"><?php echo $PAYMENT_ROWS['payment_mode_bank']; ?></td>
                                            <td width="6%" style="text-align:center;"><div style="width:70px;">
                                                    <?php
                                                    if ($PAYMENT_ROWS['payment_mode'] != "CASH") {
                                                        echo $PAYMENT_ROWS['payment_mode_date'];
                                                    }
                                                    ?>
                                                </div>
                                                <div align="center"></div></td>
                                            <td width="12%" style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_remark']; ?></td>
                                            <td style="font-size:9PX; text-transform:NONE; line-height:10PX;"><?php echo $PAYMENT_ROWS['created_details'] ?></td>

                                            <td width="4%" style="text-align:center;" id="Action">

                                                <a <?php Confirm("Are You Sure ? Approve This Payment  Of " . advisor_title . " : " . $ADV_ROW['advisor_name']) ?> href="Approval.php?<?php echo md5('advisor_payment_id') . "=" . $PAYMENT_ROWS['payment_id'] ?>" style="color:green;">Approve</a>

                                            </td>
                                            <td width="4%" style="text-align:center; color:red;"  id="Action">

                                                <a <?php Confirm("Are You Sure ? Reject This Payment of " . advisor_title . " : " . $ADV_ROW['advisor_name']); ?> href="Approval.php?<?php echo md5('reject_advisor_payment_id') . "=" . $PAYMENT_ROWS['payment_id'] ?>" style="color:red;">Reject
                                                </a>

                                            </td>

                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <th colspan="5">&nbsp;</th>
                                        <th><div align="right">
                                                <?php echo @number_format($total_payment, 2); ?>
                                            </div></th>
                                        <th colspan="6">&nbsp;</th>
                                        <th colspan="2" id="Action">&nbsp;</th>
                                    </tr>
                                </table>

                            <?php } ?>

                        </td></tr>     
                </table>


            </td></tr></table></center>

<?php
//========================(APPROVE BOOKING)=====================================================
if (isset($_GET[md5('reject_booking_id')])) {
    $booking_id = $_GET[md5('reject_booking_id')];
    $BOOKING_ROW = $DBOBJ->GetRow("tbl_property_booking", "booking_id", $booking_id);

    @mysqli_query($_SESSION['CONN'], "delete from tbl_property_booking where booking_id='$booking_id' ");
    @mysqli_query($_SESSION['CONN'], "delete from tbl_property_booking_payments where payment_booking_id='$booking_id' ");
    @mysqli_query($_SESSION['CONN'], "delete from tbl_advisor_commission where commission_order_no='" . $BOOKING_ROW['booking_order_no'] . "' ");

    //==============( PROPERTY STATUS TO AVAILABLE )====================================
    $FIELDS = array("property_status");
    $VALUES = array("Available");
    $DBOBJ->UpDate("tbl_property", $FIELDS, $VALUES, "property_id", $BOOKING_ROW['booking_property_id']);
    //==================================================================================
    $DBOBJ->UserAction("BOOKING REJECTED", "ORDER NO : " . $BOOKING_ROW['booking_order_no']);
    header("location:Approval.php?Message=Booking Of Order NO : " . $BOOKING_ROW['booking_order_no'] . " Have Been Rejected By Admin.");
}

//========================(APPROVE PAYMENT)=====================================================
elseif (isset($_GET[md5('reject_payment_id')])) {
    $payment_id = $_GET[md5('reject_payment_id')];
    $PAYMENT_ROW = $DBOBJ->GetRow("tbl_property_booking_payments", "payment_id", $payment_id);

    @mysqli_query($_SESSION['CONN'], "delete from tbl_property_booking_payments where payment_id='$payment_id' ");
    @mysqli_query($_SESSION['CONN'], "delete from tbl_advisor_commission where commission_voucher_no='" . $PAYMENT_ROW['payment_voucher_no'] . "' ");

    $DBOBJ->UserAction("BOOKING PAYMENT RECEIVE REJECTED", "VOUCHER NO : " . $PAYMENT_ROW['payment_voucher_no'] . ", ORDER NO : " . $PAYMENT_ROW['payment_voucher_no']);
    header("location:Approval.php?booking_id=" . $BOOKING_ROW['booking_id'] . "&Message=Payment Receive Of Voucher No " . $PAYMENT_ROW['payment_voucher_no'] . ", Order NO : " . $PAYMENT_ROW['payment_order_no'] . " Have Been Rejected By Admin.");
}

//========================(APPROVE PAYMENT)=====================================================
elseif (isset($_GET[md5('reject_advisor_payment_id')])) {
    $payment_id = $_GET[md5('reject_advisor_payment_id')];
    $PAYMENT_ROW = $DBOBJ->GetRow("tbl_advisor_payment", "payment_id", $payment_id);
    $ADV_ROW = $DBOBJ->GetRow('tbl_advisor', 'advisor_id', $PAYMENT_ROW['payment_advisor_id']);

    @mysqli_query($_SESSION['CONN'], "delete from tbl_advisor_payment where payment_id='" . $payment_id . "' ");
    $DBOBJ->UserAction("Associate PAYMENT REJECTED", advisor_title . " : " . $ADV_ROW['advisor_name']);

    header("location:Approval.php?advisor_payment_id=ok&Message=Payment Receive Of " . advisor_title . " " . $ADV_ROW['advisor_name'] . ", AMOUNT : Rs. " . @number_format($PAYMENT_ROW['payment_amount'], 2) . " Have Been Rejected By Admin.");
}


include("../Menu/Footer.php");
?>
