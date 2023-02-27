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
        $FIELDS=array("charge_particular" ,
						"charge_amount");	
				   
	    $VALUES=array($_POST["charge_particular"] ,
					  $_POST["charge_amount"]);
					  					
		$MAX_PAYMENT_ID=$DBOBJ->Update("tbl_property_booking_extra_charge",$FIELDS,$VALUES,"charge_id",$charge_id,0);
		
				
$DBOBJ->UserAction("EXTRA CHARGE EDITED", "ORDER NO ".$ORDER_NO.", OLD CHARGE : ".$CHARGE_ROW['charge_particular'].", OLD AMOUNT : ".$CHARGE_ROW["charge_amount"].", NEW CHARGE : ".$_POST["charge_particular"].", AMOUNT : ".$_POST["charge_amount"]);		 

UnloadMe();

	
}

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />

<center>
<?php  if($charge_id>0) {?>
  <fieldset style="width:400PX;"><legend> Extra Charge Edit : </legend>
 <form id='ExtraChargeForm' name="ExtraChargeForm" method="post">
   <table width="400" border="0" cellspacing="1"  style="border:0PX;" id="SimpleTable">
   
        <tr>
          <td>Particular</td>
          <td colspan="3" style="color:red; font-size:12px;">
		  <input type="text" name="charge_particular" id="charge_particular" placeholder="CHARGE PARTICULAR" value="<?php echo $CHARGE_ROW['charge_particular']?>" maxlength="50" required="required" />
           </td>
        </tr>
        <tr>
          <td>Charge</td>
          <td colspan="3" style="color:red; font-size:12px;">
		  <input type="text" name="charge_amount" id="charge_amount" placeholder="AMOUNT" value="<?php echo $CHARGE_ROW['charge_amount']?>" maxlength="10" required="required" <?php echo OnlyFloat()?>  onkeyup="Calc()" onchange="Calc()"/>
		 </td>
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
    <td style="color:red; font-size:13px;"><div align="right" id="Bal"><?php echo @number_format($TOTAL_BALANCE,2);?></div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
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


function Calc()
{
	var ID=document.getElementById('Bal');
	var charge_amount=parseFloat(document.getElementById('charge_amount').value);
	var TOTAL_PAID=parseFloat(<?php echo $TOTAL_PAID?>)
	
	if(isNaN(charge_amount))
	{
		charge_amount=0;
	}
	
	if(isNaN(TOTAL_PAID))
	{
		TOTAL_PAID=0;
	}
	
	var balance=charge_amount-TOTAL_PAID;
	
	if(balance>=0)
	{
	  ID.innerHTML=balance.toFixed(2);
	}
	else
	{
		ID.innerHTML="Advance&nbsp;"+Math.abs(balance).toFixed(2);
	}
	
}
</script>
  

