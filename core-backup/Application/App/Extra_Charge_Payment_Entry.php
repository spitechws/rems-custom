<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

NoUser();
//PrintArray($_POST);
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$charge_id=$_GET[md5('charge_id')];
$CHARGE_ROW=$DBOBJ->GetRow('tbl_property_booking_extra_charge','charge_id',$charge_id);

$TOTAL_PAID=$CHARGE_ROW['charge_paid'];
$BALANCE=$TOTAL_BALANCE=$CHARGE_ROW['charge_amount']-$CHARGE_ROW['charge_paid'];


$booking_id=$CHARGE_ROW['booking_id'];
$BOOKING_ROW=$DBOBJ->GetRow('tbl_property_booking','booking_id',$booking_id);

$CUSTOMER_ROW=$DBOBJ->GetRow('tbl_customer','customer_id',$BOOKING_ROW['booking_customer_id']);

$PROPERTY_ID=$BOOKING_ROW['booking_property_id'];
$PROJECT_ID=$BOOKING_ROW['booking_project_id'];
$CUSTOMER_ID=$BOOKING_ROW['booking_customer_id'];
$ADVISOR_ID=$BOOKING_ROW['booking_advisor_id'];

$ORDER_COUNTER=$booking_id;
$ORDER_NO=$BOOKING_ROW['booking_order_no'];
$PROPERTY_TYPE=$PROPERTY_TYPE_ID=$DBOBJ->ConvertToText('tbl_property','property_id','property_type_id',$BOOKING_ROW['booking_property_id']);

if(isset($_POST['Save']))
{
	 
        //========================( PAYMENT TABLE)=================================================================
        $FIELDS=array("booking_id" ,
						"charge_id" ,						
						"payment_amount" ,
						"payment_date" ,
						"payment_mode" ,
						"payment_mode_no" ,
						"payment_mode_bank" ,
						"payment_mode_date" ,
						"payment_notes" ,
						"created_details" ,
						"edited_details");	
				   
	    $VALUES=array($booking_id ,
						$charge_id,						
						$_POST["payment_amount"] ,
						$_POST["payment_date"] ,
						$_POST["payment_mode"] ,
						$_POST["payment_mode_no"] ,
						$_POST["payment_mode_bank"] ,
						$_POST["payment_mode_date"] ,
						$_POST["payment_notes"] ,
						$Mess=CreatedEditedByUserMessage() ,
						$Mess);					
		$MAX_PAYMENT_ID=$DBOBJ->Insert("tbl_property_booking_extra_charge_payment",$FIELDS,$VALUES,0);
		
		
		//==============( GENERATE VOUCHER NO )===============================
		$VOUCHER_NO=str_pad($ORDER_COUNTER,4,"0",STR_PAD_LEFT)."/X/".str_pad($MAX_PAYMENT_ID,4,"0",STR_PAD_LEFT);
		//==============( UPDATE VOUCHER NO IN PAYMENT)===============================
			$FIELDS=array("voucher_no");
			$VALUES=array($VOUCHER_NO);		
			$DBOBJ->Update("tbl_property_booking_extra_charge_payment",$FIELDS,$VALUES,"payment_id",$MAX_PAYMENT_ID,0);
		
		//==============( UPDATE PAID )===============================
			$FIELDS=array("charge_paid");
			$VALUES=array($TOTAL_PAID+($_POST["payment_amount"]));		
			$DBOBJ->Update("tbl_property_booking_extra_charge",$FIELDS,$VALUES,"charge_id",$charge_id,0);
				
$DBOBJ->UserAction("EXTRA PAYMENT RECEIVED", "ORDER NO ".$ORDER_NO.", AMOUNT : ".$_POST["payment_amount"]);		

if(isset($_POST['sms'])) { $msg="&".md5('send_sms')."=".md5('send_sms'); }

header("location:Extra_Charge_Payment_Entry_Next.php?".md5("payment_id")."=".$MAX_PAYMENT_ID.$msg);
//========================( MESSAGE AND ACTION )==============================================================
	
}

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />

<center>
<?php  if($charge_id>0) {?>
  <fieldset style="width:400PX;"><legend> Receive Extra Charge Payment : </legend>
 <form id='ExtraChargeForm' name="ExtraChargeForm" method="post">
   <table width="400" border="0" cellspacing="0"  style="border:0PX;" id="SimpleTable">
   
        <tr>
          <td>Particular</td>
          <td colspan="3" style="color:red; font-size:12px;"><?php echo $CHARGE_ROW['charge_particular']?>          </td>
        </tr>
        <tr>
          <td>Charge</td>
          <td colspan="3" style="color:red; font-size:12px;"><?php echo @number_format($CHARGE_ROW['charge_amount'],2)?></td>
        </tr>
        <tr>
        <td colspan="4"><hr /></td>
        </tr>
      <tr>
    <td width="104">CUSTOMER</td>
    <td colspan="2" style="color:green;"><?php echo $CUSTOMER_ROW['customer_title']." ".$CUSTOMER_ROW['customer_name']?></td>
    <td width="86" rowspan="6" style=" vertical-align:top;">
         <?php $ACTUAL_PHOTO="../SpitechUploads/customer/profile_photo/".$CUSTOMER_ROW['customer_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $CUSTOMER_ROW['customer_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }	  
		 ?>
         <img src="<?php echo $ACTUAL_PHOTO;?>" alt="Customer" width="80" height="100" style="border:1px solid maroon"/>
    </td>
    
    </tr>


  <tr>
    <td>PROPERTY</td>
    <td colspan="2" style="color:BLUE;">
      <?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROW['booking_property_id'])."/".$DBOBJ->PropertyTypeName($BOOKING_ROW['booking_property_id']);;?>
    </td>
    </tr>
  <tr>
    <td>PROJECT</td>
    <td colspan="2" style="color:BLUE;"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROW['booking_project_id']);?></td>
    </tr>
  <tr>
    <td>Order No</td>
    <td width="53" style="color:red;"><div align="right"><?php echo $BOOKING_ROW['booking_order_no'];?></div></td>
    <td width="140">&nbsp;</td>
    </tr>
  <tr>
    <td>Total Paid</td>
    <td style="color:green;font-size:13px;"><div align="right"><?php echo @number_format($TOTAL_PAID,2);?></div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Balance</td>
    <td style="color:red; font-size:13px;"><div align="right"><?php echo @number_format($TOTAL_BALANCE,2);?></div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4"><hr /></td>
  </tr>
  <tr>
    <td>PAYMENT&nbsp;DATE</td>
    <td colspan="3" class="Date"><script>DateInput('payment_date', true, 'yyyy-mm-dd','<?php echo date('Y-m-d')?>');</script></td>
  </tr>
  <tr>
    <td>MODE</td>
    <td colspan="2">
      <select name="payment_mode" id="payment_mode" onchange="HidMe();" style="width:100px">
        <option value="CASH">CASH</option>
        <option value="CHEQUE">CHEQUE</option>
        <option value="CHALLAN">CHALLAN</option>
        <option value="DD">DD</option>
        <option value="FT">FT</option>
        </select></td>
    <td>&nbsp;</td>
  </tr>

  <tr id="hide" style="display:<?php echo "none"?>">
    <td>PAYMENT&nbsp;DETAILS</td>
    <td colspan="3">
      
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="15%"><div align="left">NO</div></td>
          <td width="85%"><div align="left">
            <input type="text" name="payment_mode_no" id="payment_mode_no" placeholder="CHALLAN/DD/CHEQUE/TXN NO" maxlength="25" style="width:100%" />
            </div></td>
          </tr>
        <tr>
          <td><div align="left">Bank</div></td>
          <td><div align="left">
            <input type="text" name="payment_mode_bank" id="payment_mode_bank" placeholder="FROM BANK"  style="width:100%" />
            </div></td>
          </tr>
        <tr>
          <td><div align="left">Date</div></td>
          <td class="Date"><div align="left">
            <script>DateInput('payment_mode_date', true, 'yyyy-mm-dd','<?php echo date('Y-m-d')?>');</script>
            </div></td>
          </tr>
        </table>
      
    </td>
    </tr>
  <tr>
    <td>PAYING AMOUNT</td>
    <td colspan="3">
      <input type="text" name="payment_amount" placeholder="AMOUNT" value="0" id="payment_amount" style="text-align:right; width:105px; background:green; color:white;" required='required' <?php OnlyFloat(); ?> maxlength="18" onchange="Calc();" onkeyup="Calc();" /></td>
    </tr>
  <tr>
    <td>BALANCE</td>
    <td  style="color:red; font-size:13px;"><div align="right"><SPAN id="Bal">
      <?php echo @number_format($TOTAL_BALANCE,2);?>
    </SPAN></div></td>
    <td  style="color:red; font-size:13px;">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>REMARKS</td>
    <td colspan="3"><input type="text" name="payment_notes" id="payment_notes" placeholder="PAYMENT REMARKS IF ANY " maxlength="100" style="width:100%;" /></td>
    </tr>
        <tr>
          <td style="line-height:13px;">SEND SMS</td>
          <td colspan="3">
            <label><input type="checkbox" name="sms" id="sms" value="send_sms" />SEND SMS (<span class="Required"> Check if  Want To Send Message To Customer & Associate</span>)</label>
          </td>
          </tr>
   
    <tr>
      <td colspan="4">
        <div align="center">
          <input type="submit" name="Save" id="Save" value="Save Payment Details" <?php Confirm("Are You Sure ? Save Payment Details ?"); ?>/>
          <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
          </div>
      </td>
      <td width="7" style="text-align:RIGHT">&nbsp;</td>
    </tr>
  
   </table>
</form>
   </fieldset>
   <?php } ?>
    </center>
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
  

