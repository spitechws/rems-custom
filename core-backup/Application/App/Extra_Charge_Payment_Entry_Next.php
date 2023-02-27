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


$PAYMENT_ROW=$DBOBJ->GetRow('tbl_property_booking_extra_charge_payment','payment_id',$_GET[md5('payment_id')]);	
$CHARGE_ROW=$DBOBJ->GetRow('tbl_property_booking_extra_charge','charge_id',$PAYMENT_ROW['charge_id']);	 
$BOOKING_ROW=$DBOBJ->GetRow("tbl_property_booking","booking_id",$CHARGE_ROW['booking_id']);
$CUSTOMER_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$BOOKING_ROW['booking_customer_id']);

?>

<link rel="shortcut icon" href="../SpitechLogo/icon.png" />
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css">
<style>
b { font-size:12px; }
table * { color:black; }

#myStyle { width:650px; margin-top:-8px; padding:0px; border:0px solid #AD6301; background:#fff;}
@media print 
{ 
  #myStyle { width:100%; margin:0px; padding:0px; border:2px solid red;}
}
</style>
<body style="background:white;">
<div class="DontPrint" align="right" style="width:650px; margin-bottom:10px;">
<input type="button" id="DontPrint" value="Print" class="DontPrint button " onClick="window.print();" />
<input type="button" id="Cancel" value="Ok Close" class="DontPrint Cancel" onClick="window.opener.location.reload(); window.close();" />
</div>
<table border="0" cellspacing="0" cellpadding="3"  id="myStyle">
  <tr>
    <td height="73" colspan="2" style=" vertical-align:top;">
    <img src="../SpitechLogo/Logo.png" width="185" height="69" style="margin:5px; "  class="DontPrint"/></td>
    <td height="73" colspan="4" style="vertical-align:top;padding-left:10px;">
    
    <div style="color:#AD6301; font-family:Times; font-size:18PX;  font-weight:bolder; text-transform:uppercase"  class="DontPrint">
	  <?php echo site_company_name?>
    </div>
      
      <div class="DontPrint"><?php echo address?><br />
        <?php if(phone!="") 		{ echo "Phone : ".phone.", "; 		  	    } ?> 
        <?php if(mobile!="") 	   { echo "Mobile : ".mobile.", "; 			} ?>
        <?php if(email!="") 		{ echo "Email : ".email.", "; 		      } ?> 
        <?php if(site_url_home!=""){ echo "Website : ".site_url_home;   } ?>             
      </div>
        
      <div style="line-height:22PX; font-size:14PX; font-weight:BOLDER; background:#AD6301; letter-spacing:1.5px; color:WHITE; margin-top:7PX; font-family:Tahoma; text-align:center;border-top-left-radius:30px;" class="DontPrint">PAYMENT RECEIPT</div></td>
  </tr>
  <tr>
    <td height="27">&nbsp;</td>
    <td width="20%">
    <b class="DontPrint">S.No : </b>
	
	<b style="color:maroon; font-size:13px; float:right; margin-right:5px"><?php echo $PAYMENT_ROW['voucher_no']?></b>
   
    </td>
    <td colspan="4" style="text-align:right; padding-right:35px">
      <b class="DontPrint">Date </b> 
	  <b style="color:maroon; font-size:13px;"><?php echo date('d-m-Y',strtotime($PAYMENT_ROW['payment_date']))?></b>
    </td>
  </tr>
  <tr>
    <td width="3%" style="height:26px;">&nbsp;</td>
    <td width="20%"><div align="left" class="DontPrint">Received With&nbsp;Thanks&nbsp;From</div></td>
    <td colspan="4" style="text-transform:uppercase;"><b>
      <?php echo $CUSTOMER_ROW['customer_title']." ".$CUSTOMER_ROW['customer_name'] ?>
    </b></td>
  </tr>
  <tr>
    <td width="3%" style="height:26px;">&nbsp;</td>
    <td><div align="left" class="DontPrint">A Sum of Rupees (In Words)</div></td>
    <td colspan="4" style="text-transform:uppercase;"><b>
      <?php if($PAYMENT_ROW['payment_amount']<0) { echo "Minus "; } echo ConvertToWord(abs($PAYMENT_ROW['payment_amount']))." Only.";?>
    </b></td>
  </tr>
  <tr>
    <td width="3%" style="height:26px;">&nbsp;</td>
    <td><div align="left" class="DontPrint">By&nbsp;Cash&nbsp;/D.D.&nbsp;/&nbsp;*Cheque&nbsp;No</div></td>
    <td colspan="2" style="text-transform:uppercase;"><b><?php echo $PAYMENT_ROW['payment_mode'].", ".$PAYMENT_ROW['payment_mode_no'];?></b></td>
    <td width="13%"><div align="left" class="DontPrint">On Dated</div></td>
    <td width="23%" style="text-transform:uppercase;"><b>
      <?php if($PAYMENT_ROW['payment_mode_date']!="0000-00-00") { echo date('d-M-Y',strtotime($PAYMENT_ROW['payment_mode_date'])); } ?>
    </b></td>
  </tr>
  <tr>
    <td width="3%" style="height:26px;">&nbsp;</td>
    <td><div align="left" class="DontPrint">drawn on</div></td>
    <td colspan="2" style="text-transform:uppercase;"><b><?php echo $PAYMENT_ROW['payment_mode_bank'];?></b></td>
    <td style="text-transform:capitalize;" class="DontPrint"><div align="left">Against <b>
      <?php echo $PTYPE=strtolower($DBOBJ->PropertyTypeName($BOOKING_ROW['booking_property_id']));?>
      </b> No
    </div></td>
    <td style="text-transform:uppercase;"><span style="float:left;"><b>
      <?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no", $BOOKING_ROW['booking_property_id']);?>
    </b></span></td>
  </tr>
  <tr>
    <td width="3%" style="height:26px;">&nbsp;</td>
    <td style="text-transform:capitalize;"><div align="left" class="DontPrint">Project</div></td>
    <td colspan="4" style="text-transform:capitalize;"><b><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name", $BOOKING_ROW['booking_project_id']);?>
      </b>, 
      
      Kh. No.  <b><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_khasra_no", $BOOKING_ROW['booking_property_id']);?></b>, 
      PH.No.  <b><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_ph_no", $BOOKING_ROW['booking_project_id']);?></b></td>
  </tr>
  <tr>
    <td width="3%" style="height:26px;">&nbsp;</td>
    <td colspan="5">
    <div class="DontPrint">
      <?php echo "As <b>".$CHARGE_ROW['charge_particular']."</b>";?>.  
    Total payments towards consideration of <?php echo $PTYPE;?> subject to the terms &amp; condition of agreement.
    </div>
    </td>
  </tr>
  <tr>
    <td width="3%" style="height:26px;">&nbsp;</td>
    <td width="20%" style="height:26px;">&nbsp;</td>
    <td width="28%" >&nbsp;</td>
    <td colspan="3" ><span style="text-align:left"></span></td>
  </tr>
  <tr>
    <td></td>
    <td style=" font-size:18px; height:40px;">
    
    <span style="height:35px; width:35px; background:black; color:white; padding:5px;"  class="DontPrint">Rs.</span>
    
    <span style="height:33px; background:white; color:maroon; padding:4px; pading-left:30px;">
    <b>&nbsp;
      <?php echo @number_format($PAYMENT_ROW['payment_amount'],2);?>
    </b> </span></td>
    <td colspan="4" style=" font-size:14px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"  style="height:115px;">
    <u><b>Terms & Conditions</b></u>
      <ol>
       <li>Cheque payment are subject to realisation.</li>
       <li>All rights reserves to <?php echo site_company_name?></li>
       <li>Subject to Bilaspur Juridiction only.</li>
      </ol>
    </td>
  </tr>
</table>

</div>
</body>
<?php if($_GET[md5('send_sms')])
{
 
	$CUSTOMER=$CUSTOMER_ROW['customer_title']." ".$CUSTOMER_ROW['customer_name'];
	$PTYPE=$DBOBJ->PropertyTypeName($BOOKING_ROW['booking_property_id']);
	$PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROW['booking_project_id']);
	$PROPERTY_NO=$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROW['booking_property_id']);	
	
//================(MESSAGE FOR CUSTOMER)===============================	
$MESSAGE1="DEAR ".$CUSTOMER.", THANK YOU FOR YOUR PAYMENT FOR ".$CHARGE_ROW['charge_particular']." OF RS. ".@number_format($PAYMENT_ROW['payment_amount'],2)." AGAINST ".$PTYPE." : ".$PROPERTY_NO." OF ".$PROJECT_NAME.". ".site_company_name;

//==================(SEND MESSAGE)================================================	
	SendSMS($CUSTOMER_ROW['customer_mobile'],$MESSAGE1);
	SendSMS($DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_mobile",$BOOKING_ROW['booking_advisor_id']),$MESSAGE2);
}
?>
<script>
window.print();
</script>