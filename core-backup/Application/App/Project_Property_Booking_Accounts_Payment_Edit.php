<?php
session_start();
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../Menu/Define.php");
NoUser();
NoAdminCategory();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$PAYMENT_ROW=$DBOBJ->GetRow('tbl_property_booking_payments','payment_id',$_GET[md5('payment_id')]);
$BOOKING_ROW=$DBOBJ->GetRow('tbl_property_booking','booking_id',$PAYMENT_ROW['payment_booking_id']);



$PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$PAYMENT_ROW['payment_project_id']);
$PROPERTY_NO=$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$PAYMENT_ROW['payment_property_id']);
$PROPERTY_TYPE_NAME=$DBOBJ->PropertyTypeName($BOOKING_ROW['booking_property_id']);

$CUSTOMER_NAME=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$PAYMENT_ROW['payment_customer_id']);
$CUSTOMER_CODE=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_code",$PAYMENT_ROW['payment_customer_id']);

$ADVISOR_NAME=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$PAYMENT_ROW['payment_advisor_id']);
$ADVISOR_CODE=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$PAYMENT_ROW['payment_advisor_id']);

$COMMISSION_ROW=$DBOBJ->GetRow('tbl_advisor_commission','commission_voucher_no',$PAYMENT_ROW['payment_voucher_no']);

if(isset($_POST['Save']) && $_GET[md5('payment_id')]>0)
{
	//=========================(ENTRY IN BOOKING)===========================================
	
	if($PAYMENT_ROW['payment_first_payment']=="1")
	{	
		 $FIELDS=array("booking_date","booking_token_exp_date","edited_details");
		 $VALUES=array($_POST["payment_date"],$_POST["booking_token_exp_date"],CreatedEditedByUserMessage());
		 $DBOBJ->Update("tbl_property_booking",$FIELDS,$VALUES,"booking_id",$PAYMENT_ROW['payment_booking_id'],1);
	}
	
	//========================(NEXT PAYMENT DATE EDIT)============================================================
	     $FIELDS=array("next_payment_date","edited_details");
		 $VALUES=array($_POST["next_payment_date"],CreatedEditedByUserMessage());
		 $DBOBJ->Update("tbl_property_booking",$FIELDS,$VALUES,"booking_id",$PAYMENT_ROW['payment_booking_id'],1);
	
//========================( PAYMENT TABLE)=================================================================
        $FIELDS=array(  "payment_amount" ,
						"payment_date" ,
						"payment_mode" ,
						"payment_mode_no" ,
						"payment_mode_bank" ,
						"payment_mode_date" ,
						"payment_remarks",					
						"edited_details",
						"approved");					   
	    $VALUES=array(  $_POST["payment_amount"], 
						$_POST["payment_date"], 
						$_POST["payment_mode"],
						$_POST["payment_mode_no"],
						$_POST["payment_mode_bank"],
						$_POST["payment_mode_date"], 
						$_POST["payment_remark"],
						CreatedEditedByUserMessage(),
						"0");					
		$DBOBJ->Update("tbl_property_booking_payments",$FIELDS,$VALUES,"payment_id",$_GET[md5('payment_id')],0);
//========================( COMMISSION PAYMENT TABLE)========================================================
	$COM_Q="SELECT * FROM tbl_advisor_commission WHERE commission_voucher_no='".$PAYMENT_ROW['payment_voucher_no']."' ";	
	$COM_Q=@mysqli_query($_SESSION['CONN'],$COM_Q);
	while($COM_ROWS=@mysqli_fetch_assoc($COM_Q))
	{
		 $COM_ID=$COM_ROWS['commission_id'];
		 $FIELDS=array( "commission_date" ,
		                "commission_voucher_date" ,
						"commission_amount" ,						
						"commission_tds_amount" ,
						"commission_nett_amount" ,
						"commission_voucher_amount",
						"approved");	
		 $VALUES=array(
		                $_POST["payment_commission_date"],
		                $_POST["payment_date"] ,						
						$COMISSION=$_POST["payment_amount"]*$COM_ROWS['commission_advisor_level_diff_percent']/100 ,
						$TDS_AMOUNT=$COMISSION*$COM_ROWS["commission_tds_percent"]/100 ,
						$COMISSION-$TDS_AMOUNT ,
						$_POST["payment_amount"],
						0);	
		$DBOBJ->Update("tbl_advisor_commission",$FIELDS,$VALUES,"commission_id",$COM_ID,0);										
	}
	$DBOBJ->UserAction("PAYMENT EDITED","VOUCHER NO : ".$PAYMENT_ROW['payment_voucher_no']);
	UnloadMe();
}
?><link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
<head><title>Project : Booking Delete Confirmation</title></head>
    <center>
   <fieldset style="width:600px; height:auto;">
  
   <table width="98%" border="0" cellspacing="0"  style="border:0PX;" id="SimpleTable">
   
 
<form id='PaymentForm' name="PaymentForm" method="post">
  <tr>
    <td colspan="4"><HR /></td>
    </tr>
  <tr>
    <td width="124">PROPERTY</td>
    <td style="color:BLUE; font-size:14px;"><?php echo $PROPERTY_TYPE_NAME."/".$PROPERTY_NO?></td>
    <td width="107" >Project</td>
    <td width="250" style="color:BLUE; font-size:14px;"><?php echo $PROJECT_NAME?></td>
    </tr>
  
  <tr>
    <td>VOUCHER NO</td>
    <td colspan="3" style="color:red; font-size:14px;"><?php echo $PAYMENT_ROW['payment_voucher_no'];?></td>
  </tr>
  <tr>
    <td>Order No</td>
    <td colspan="3" style="color:maroon; font-size:14px;"><?php echo $PAYMENT_ROW['payment_order_no'];?></td>
    </tr>
  <tr>
    <td>Customer</td>
    <td colspan="3" id="Value"><?php echo $CUSTOMER_NAME." [<FONT COLOR='RED'>".$CUSTOMER_CODE."</FONT>]";?></td>
    </tr>
  <tr>
    <td><?php echo advisor_title?></td>
    <td colspan="3" id="Value"><?php echo $ADVISOR_NAME." [<FONT COLOR='RED'>".$ADVISOR_CODE."</FONT>]";?></td>
    </tr>
  <tr>
    <td><div align="left" style="width:120px;">Payment</div></td>
    <td width="95" id="Value"><div align="right"><?php echo date('d-Y-M',strtotime($BOOKING_ROW['booking_date']));?></div></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr /></td>
    </tr>
  <tr>
    <td>PARTICULAR</td>
    <td colspan="3" class="Value"><?php echo $PAYMENT_ROW['payment_heading']?></td>
    </tr>
  <tr>
    <td>PAYMENT&nbsp;DATE</td>
    <td colspan="3" class="Date"><script>DateInput('payment_date', true, 'yyyy-mm-dd','<?php echo $PAYMENT_ROW['payment_date']?>');</script></td>
    </tr>
   <?php  
   if($COMMISSION_ROW['commission_date']!="" && $COMMISSION_ROW['commission_date']!=NULL) {
   ?> 
  <tr>
    <td>COMMISSION DATE</td>
    <td colspan="3" class="Date"><script>DateInput('payment_commission_date', true, 'yyyy-mm-dd','<?php echo $COMMISSION_ROW['commission_date']?>');</script></td>
  </tr>
  <?php } ?>
<?php if($PAYMENT_ROW['payment_first_payment']=="1")
	{	   ?>
  <tr>
    <td>TOKEN&nbsp;EXPIRY&nbsp;DATE</td>
    <td colspan="3" class="Date">
    <script>DateInput('booking_token_exp_date', true, 'yyyy-mm-dd','<?php echo $BOOKING_ROW['booking_token_exp_date']?>');</script></td>
  </tr>

 
  
  <?php } ?> 
  
  <tr style="display:<?php if($BOOKING_ROW['booking_type']!="Permanent") { echo "none"; } ?>">
    <td style="color:red;">NEXT PAYMENT DATE</td>
    <td colspan="3" class="Date"><script>DateInput('next_payment_date', true, 'yyyy-mm-dd','<?php echo $BOOKING_ROW['next_payment_date']?>');</script></td>
  </tr>
  <tr>
    <td>MODE</td>
    <td colspan="3">
      <select name="payment_mode" id="payment_mode" onchange="HidMe();">
        <option value="CASH" <?php SelectedSelect("CASH",$PAYMENT_ROW['payment_mode']); ?>>CASH</option>     
        <option value="CHALLAN" <?php SelectedSelect("CHALLAN",$PAYMENT_ROW['payment_mode']); ?>>CHALLAN</option>
        <option value="DD" <?php SelectedSelect("DD",$PAYMENT_ROW['payment_mode']); ?>>DD</option>
        <option value="CHEQUE" <?php SelectedSelect("CHEQUE",$PAYMENT_ROW['payment_mode']); ?>>CHEQUE</option>
        <option value="FT" <?php SelectedSelect("FT",$PAYMENT_ROW['payment_mode']); ?>>FT</option>
        <option value="PAYMENT BY BANK" <?php SelectedSelect("PAYMENT BY BANK",$PAYMENT_ROW['payment_mode']); ?>>PAYMENT BY BANK</option>
      </select></td>
    </tr>

  <tr id="hide" style="display:<?php if(strtoupper($PAYMENT_ROW['payment_mode'])=="CASH") { echo "none"; } else { echo "table-row"; } ?>;">
    <td>PAYMENT&nbsp;DETAILS</td>
    <td colspan="3">
      
      <table width="98%" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td width="26%"><div align="left">NO</div></td>
          <td width="74%"><div align="left">
            <input type="text" name="payment_mode_no" id="payment_mode_no" placeholder="CHALLAN/DD/CHEQUE/TXN NO" maxlength="25" value="<?php echo $PAYMENT_ROW['payment_mode_no']?>" />
            </div></td>
          </tr>
        <tr>
          <td><div align="left">Bank</div></td>
          <td><div align="left">
            <input type="text" name="payment_mode_bank" id="payment_mode_bank" placeholder="FROM BANK" value="<?php echo $PAYMENT_ROW['payment_mode_bank']?>"  />
            </div></td>
          </tr>
        <tr>
          <td><div align="left">Date</div></td>
          <td class="Date"><div align="left">
            <script>DateInput('payment_mode_date', true, 'yyyy-mm-dd','<?php echo $PAYMENT_ROW['payment_mode_date']?>');</script>
            </div></td>
          </tr>
        </table>
      
    </td>
    </tr>
  <tr>
    <td>PAYING AMOUNT</td>
    <td colspan="3">
      <input type="text" name="payment_amount" placeholder="AMOUNT" id="payment_amount" style="text-align:right; width:105px; font-size:14PX; background:green; color:white;" required='required' <?php OnlyFloat(); ?> maxlength="18" onchange="Calc();" onkeyup="Calc();" value="<?php echo $PAYMENT_ROW['payment_amount'];?>" /></td>
    </tr>
  
  <tr>
    <td>REMARKS</td>
    <td colspan="3"><input type="text" name="payment_remark" id="payment_remark" placeholder="PAYMENT REMARKS IF ANY " maxlength="100" style="width:450px;" value="<?php echo $PAYMENT_ROW['payment_remarks']?>" /></td>
  </tr>
        <tr>
          <td colspan="4">
            <div align="center">
              <input type="submit" name="Save" id="Save" value="Save Payment Details" <?php Confirm("Are You Sure ? Save Payment Details ?"); ?>/>
              <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
            </div>
          </td>
          <td width="5" style="text-align:RIGHT">&nbsp;</td>
      </tr></form>
   
   </table>
   </fieldset></center>
   <script>
function HidMe()
{
	if(document.getElementById('payment_mode').value!="CASH") 
	{ 
	   document.getElementById('hide').style.display='table-row';
	}
	else
	{
		document.getElementById('hide').style.display='none';
	}
}

function Calc()
{
	var ID=document.getElementById('Bal');
	
	var balance=parseFloat(<?php echo $TOTAL_BALANCE?>)-parseFloat(document.getElementById('payment_amount').value);
	
	ID.innerHTML=balance.toFixed(2);
}
</script>