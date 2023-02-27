<?php
session_start();
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../php/SpitechBulkSMS.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
NoUser();


$PAYMENT_ROW=$DBOBJ->GetRow("tbl_property_booking_payments","payment_id",$_GET[md5("payment_id")]);
$BOOKING_ROW=$DBOBJ->GetRow("tbl_property_booking","booking_id",$PAYMENT_ROW['payment_booking_id']);
$CUSTOMER_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$BOOKING_ROW['booking_customer_id']);

?>

<link rel="shortcut icon" href="../SpitechLogo/icon.png" />
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css">
<style>
b { font-size:12px; }
table * { color:black; }

#myStyle { width:830px; margin-top:-8px; padding:0px; border:2px solid #000; background:#fff;}
@media print 
{ 
  #myStyle { width:100%; margin:0px; padding:0px; }
}
</style>
<body style="background:white;">
<div class="DontPrint" align="right" style="width:830px; margin-bottom:10px;">
<input type="button" id="DontPrint" value="Print" class="DontPrint button " onClick="window.print();" />
<input type="button" id="Cancel" value="Ok Go Back To Account" class="DontPrint Cancel" onClick="window.location='Project_Property_Booking_Accounts.php?<?php echo md5('booking_id')."=".$PAYMENT_ROW['payment_booking_id']; ?>';" />
</div>
<table border="0" cellspacing="0" cellpadding="3"  id="myStyle">
  <tr style="background:url(../SpitechImages/ReceiptTop.png) no-repeat;">
    <td height="73" colspan="2" style="height:125px; vertical-align:top;"><img src="../SpitechLogo/Logo.png" width="185" height="102" style="margin:5px; "/></td>
    <td height="73" colspan="4" style="vertical-align:top;">
    
    <div style="color:#000; font-family:Times; font-size:20PX; PADDING-top:15PX; margin-left:0px; font-weight:bolder; text-transform:uppercase"><?php echo site_company_name?>
    </div>
      <table width="150" border="0" cellspacing="0" style="float:right; margin-top:-35px;font-weight:bolder; font-size:12px;">
        <tr>
          <td style="color:#000;">Voucher&nbsp;No&nbsp;</td>
          <td style="color:#000;">:</td>
          <td style=" background:white; font-size:13px;"><b style="color:maroon;">
            <?php echo $PAYMENT_ROW['payment_voucher_no']?>
          </b></td>
        </tr>
        <tr>
          <td style="color:#000;">Date</td>
          <td style="color:#000;">:</td>
          <td ><b style="color:maroon;">
            <?php echo date('d-M-Y',strtotime($PAYMENT_ROW['payment_date'])) ?>
          </b></td>
        </tr>
      </table>
      <div style="margin-top:28px; margin-left:10px;"><?php echo address?><br />
        <?php if(phone!="") 		{ echo "Phone : ".phone.", "; 		  	    } ?> 
        <?php if(mobile!="") 	   { echo "Mobile : ".mobile.", "; 			} ?>
        <?php if(email!="") 		{ echo "Email : ".email.", "; 		      } ?> 
        <?php if(site_url_home!=""){ echo "Website : ".site_url_home;   } ?>             
      </div>
        
      <div style="line-height:22PX; font-size:14PX; font-weight:BOLDER; background:#000; letter-spacing:1.5px; color:WHITE; margin-top:7PX; font-family:Tahoma; text-align:center;border-top-left-radius:30px;">PAYMENT RECEIPT</div></td>
  </tr>
  <tr>
    <td height="27">&nbsp;</td>
    <td width="23%" style="height:10px;">&nbsp;</td>
    <td colspan="4" style="text-transform:uppercase;">&nbsp;</td>
  </tr>
  <tr>
    <td width="6%" style="height:26px;">&nbsp;</td>
    <td width="23%">Received With&nbsp;Thanks&nbsp;From</td>
    <td colspan="4" style="text-transform:uppercase;"><b>
      <?php echo $CUSTOMER_ROW['customer_title']." ".$CUSTOMER_ROW['customer_name'] ?>
    </b></td>
  </tr>
  <tr>
    <td width="6%" style="height:26px;">&nbsp;</td>
    <td>A Sum of Rs.</td>
    <td colspan="4" style="text-transform:uppercase;"><b>
      <?php if($PAYMENT_ROW['payment_amount']<0) { echo "Minus "; } echo ConvertToWord(abs($PAYMENT_ROW['payment_amount']))." Only.";?>
    </b></td>
  </tr>
  <tr>
    <td width="6%" style="height:26px;">&nbsp;</td>
    <td>By&nbsp;Cash&nbsp;/D.D.&nbsp;/&nbsp;*Cheque&nbsp;No</td>
    <td colspan="2" style="text-transform:uppercase;"><b>
      <?php echo $PAYMENT_ROW['payment_mode'].", ".$PAYMENT_ROW['payment_mode_no'];?>
    </b></td>
    <td width="15%">On Dated</td>
    <td width="12%" style="text-transform:uppercase;"><b>
      <?php if($PAYMENT_ROW['payment_mode_date']!="0000-00-00") { echo date('d-M-Y',strtotime($PAYMENT_ROW['payment_mode_date'])); } ?>
    </b></td>
  </tr>
  <tr>
    <td width="6%" style="height:26px;">&nbsp;</td>
    <td>Drawn on</td>
    <td colspan="4" style="text-transform:uppercase;"><b>
      <?php echo $PAYMENT_ROW['payment_mode_bank'];?>
    </b></td>
  </tr>
  <tr>
    <td width="6%" style="height:26px;">&nbsp;</td>
    <td style="text-transform:capitalize;">Against <b>
      <?php echo $PTYPE=strtolower($DBOBJ->PropertyTypeName($BOOKING_ROW['booking_property_id']));?>
    </b> No</td>
    <td width="19%" style="text-transform:capitalize;"><div align="right"> <span style="float:left;"><b>
      <?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no", $BOOKING_ROW['booking_property_id']);?>
    </b></span> <span style="float:right;">Kh. No. : <b><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_khasra_no", $BOOKING_ROW['booking_property_id']);?>
    </b>,</div></td>
    <td width="25%" style="text-transform:uppercase;"><div align="left"><span style="float:left;"> PH.No. : <b><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_ph_no", $BOOKING_ROW['booking_project_id']);?></b></span>,</div></td>
    <td colspan="2" style="text-transform:uppercase;"><div align="left">Project : <b>
      <?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name", $BOOKING_ROW['booking_project_id']);?>
    </b></div></td>
  </tr>
  <tr>
    <td width="6%" style="height:26px;">&nbsp;</td>
    <td>Payment</td>
    <td >&nbsp;</td>
    <td colspan="3" ><span style="text-align:left">
      <?php echo "As <b>".$PAYMENT_ROW['payment_heading']."</b>";?>
      . </span> Total payments towards </td>
  </tr>
  <tr>
    <td width="6%" style="height:26px;">&nbsp;</td>
    <td width="23%" style="height:26px;">&nbsp;</td>
    <td >&nbsp;</td>
    <td colspan="3" ><span style="text-align:left">consideration of <span style="text-transform:capitalize; font-weight:bolder;">
      <?php echo $PTYPE;?>
    </span> Subject to the terms &amp; condition of agreement.</span></td>
  </tr>
  <tr>
    <td></td>
    <td style=" font-size:18px; height:40px;"><span style="height:35px; width:35px; background:black; color:white; padding:5px;">Rs.</span> <span style="height:33px; width:35px; background:white; color:maroon; padding:4px; border:1px solid black; margin-left:-5px;"> <b>&nbsp;
      <?php echo @number_format($PAYMENT_ROW['payment_amount'],2);?>
    </b> </span></td>
    <td colspan="4" style=" font-size:14px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"  style="background:url(../SpitechImages/ReceiptBottom.png); height:115px;">
    <div style="float:left; margin-top:65PX; font-size:9PX;">*CHEQUE SUBJECT TO REALIZAION, *SUBJECT TO BILASPUR JURISDICTION ONLY</div>
   
    <DIV style="float:right; margin-top:-10PX; font-weight:BOLDER; font-size:14PX; margin-right:30PX;">for <SPAN style="color:#000; text-transform:uppercase;"><?php echo site_company_name?></SPAN></DIV>
    <?php 	  $margin=strlen("for ".site_company_name)*6;
	?>
    <DIV style="float:right; margin-top:60px; font-weight:bolder; margin-right:-<?php echo $margin?>">Authorised Signatory</DIV>
    </td>
  </tr>
</table>
</div>
<?php $PROPERTY_TYPE_ID=$DBOBJ->ConvertToText("tbl_property","property_id","property_type_id",$PAYMENT_ROW['payment_property_id']);
if($_GET[md5('send_sms')])
{
	$ADVISOR=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_title",$BOOKING_ROW['booking_advisor_id'])." ".$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$BOOKING_ROW['booking_advisor_id'])." [".$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$BOOKING_ROW['booking_advisor_id'])."]";
	$CUSTOMER=$CUSTOMER_ROW['customer_title']." ".$CUSTOMER_ROW['customer_name'];
	$PTYPE=$DBOBJ->PropertyTypeName($PAYMENT_ROW['payment_property_id']);
	$PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$PAYMENT_ROW['payment_project_id']);
	$PROPERTY_NO=$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$PAYMENT_ROW['payment_property_id']);
	
//==================( MESSAGE FOR CUSTOMER )========================================	
	$MESSAGE1="DEAR ".$CUSTOMER.", CONGRATULATIONS! YOU HAVE BOOKED ".$PTYPE." OF '".$PROJECT_NAME."' SUCCESSFULLY. THANK YOU FOR YOUR ASSOCIATION WITH US. ".site_company_name;
	
	$MESSAGE2="DEAR ".$CUSTOMER.", THANK YOU FOR YOUR PAYMENT OF RS. ".@number_format($PAYMENT_ROW['payment_amount'],2)." AGAINST ".$PTYPE." : ".$PROPERTY_NO." OF ".$PROJECT_NAME." YOUR TOTAL BALANCE IS RS. ".@number_format($DBOBJ->TotalBookingBalance($PAYMENT_ROW['payment_booking_id']),2)." ".site_company_name;
	
//===============================(MESSAGE FOR AssociateS)========================================================================	
 $MESSAGE3 ="DEAR ".$ADVISOR.", CONGRATULATIONS! ".$PTYPE." : ".$PROPERTY_NO." IN OUR PROJECT ".$PROJECT_NAME." WITH ".$PAYMENT_ROW['payment_heading']." OF Rs ".@number_format($PAYMENT_ROW['payment_amount'],2)." ON CUSTOMER NAME ".$CUSTOMER." HAS BEEN BOOKED SUCCESSFULLY BY YOU. ".site_company_name;

///=================(SEND MESSAGE)===========================================
	SendSMS($CUSTOMER_ROW['customer_mobile'],$MESSAGE1);
	SendSMS($CUSTOMER_ROW['customer_mobile'],$MESSAGE2);
	SendSMS($DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_mobile",$BOOKING_ROW['booking_advisor_id']),$MESSAGE3);
	



//==================( SENDING MESSAGE TO ALL AssociateS THAT PROPERTY BOOKED )==================================	
    $ADVISOR_Q="SELECT advisor_id, advisor_title, advisor_name, advisor_code, advisor_mobile FROM tbl_advisor where advisor_id!='".$BOOKING_ROW['booking_advisor_id']."' ";
	$ADVISOR_Q=@mysqli_query($_SESSION['CONN'],$ADVISOR_Q);
	while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_Q))
	{   	
		$MESSAGE4="DEAR ".advisor_title." ".$ADVISOR_ROWS['advisor_title']." ".$ADVISOR_ROWS['advisor_name']." [".$ADVISOR_ROWS['advisor_code']."], ";
		$MESSAGE4.=$PTYPE." ".$PROPERTY_NO." OF ".$PROJECT_NAME."  HAS BEEN BOOKED WITH ".$PAYMENT_ROW['payment_heading']." BY ".advisor_title." : ".$ADVISOR.". THANK YOU ...".site_company_name;
		
		SendSMS($ADVISOR_ROWS['advisor_mobile'],$MESSAGE4);
		
	}
	
}
  
?>
</body>
<script>
window.print();
</script>