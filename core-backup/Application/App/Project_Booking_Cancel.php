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

$BOOKING_ROW=$DBOBJ->GetRow("tbl_property_booking","booking_id",$_GET[md5("booking_id")]);	
$BOOKING_ID=$_GET[md5("booking_id")];
$PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROW['booking_project_id']);
$PROPERTY_NO=$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROW['booking_property_id']);
$PROPERTY_TYPE=$DBOBJ->PropertyTypeName($BOOKING_ROW['booking_property_id']);

$CUSTOMER=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$BOOKING_ROW['booking_customer_id']).", CODE : ".$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_code",$BOOKING_ROW['booking_customer_id']);

$ADVISOR=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$BOOKING_ROW['booking_advisor_id']).", CODE : ".$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$BOOKING_ROW['booking_advisor_id']);

if(isset($_POST['Submit']) && $BOOKING_ROW['booking_cancel_status']!="Yes")
{
 
 $cancel_date=ReceiveDate('cancel_date',"POST");
	  //========================( PROPERTY TABLE)==============================================================	
        $FIELDS=array("property_status");
		$VALUES=array("Available");		
		$DBOBJ->Update("tbl_property",$FIELDS,$VALUES,"property_id",$BOOKING_ROW['booking_property_id'],0);  	
	//========================( BOOKING TABLE)==============================================================	
        $FIELDS=array("booking_cancel_status","booking_cancel_details");
		$VALUES=array("Yes",$_SESSION['user_name'].",".$_SESSION['user_category'].",".date('Y-m-d').",".IndianTime().",".GetIP());		
		$DBOBJ->Update("tbl_property_booking",$FIELDS,$VALUES,"booking_id",$BOOKING_ROW['booking_id'],0);  	
	//========================( PAYMENT TABLE)=================================================================
        $FIELDS=array("payment_booking_id" ,	
					"payment_order_no",				
					"payment_heading" ,
					"payment_project_id" ,
					"payment_property_id" ,
					"payment_customer_id" ,
					"payment_installment_no" ,
					"payment_amount" ,
					"payment_date" ,
					"payment_booking_executive_type" ,
					"payment_advisor_id" ,
					"payment_mode" ,
					"payment_mode_no" ,
					"payment_mode_bank" ,
					"payment_mode_date" ,
					"payment_remarks",
					"created_details" ,
					"edited_details");	
				   
	    $VALUES=array($BOOKING_ROW['booking_id'],
					 $BOOKING_ROW['booking_order_no'],		
					"CANCEL",
					 $BOOKING_ROW["booking_project_id"], 
				     $BOOKING_ROW["booking_property_id"], 				
				     $BOOKING_ROW["booking_customer_id"],  
					$DBOBJ->ConvertToText('tbl_property_booking_payments','payment_booking_id','MAX(payment_installment_no)',$BOOKING_ID)+1,
					-$_POST["refund_amount"], 
					ReceiveDate("cancel_date","POST"), 
					"Associate",
					$BOOKING_ROW["booking_advisor_id"],
					"CANCEL",
					$_POST["payment_mode_no"],
					$_POST["payment_mode_bank"],
					ReceiveDate("cancel_date","POST"), 
					"CANCELLED REFUND",
				  $Mess=CreatedEditedByUserMessage(),
				  $Mess);
					
		$DBOBJ->Insert("tbl_property_booking_payments",$FIELDS,$VALUES,0);
		$MAX_PAYMENT_ID=$DBOBJ->MaxID("tbl_property_booking_payments","payment_id");
		
		//==============( GENERATE VOUCHER NO )===============================
		$VOUCHER_NO=str_pad($BOOKING_ID,4,"0",STR_PAD_LEFT)."/CAN/".str_pad($MAX_PAYMENT_ID,4,"0",STR_PAD_LEFT);
		//==============( UPDATE VOUCHER NO IN PAYMENT)===============================
		$FIELDS=array("payment_voucher_no");
		$VALUES=array($VOUCHER_NO);		
		$DBOBJ->Update("tbl_property_booking_payments",$FIELDS,$VALUES,"payment_id",$MAX_PAYMENT_ID,0);	
//=========================( REVERSE COMMISSION )=======================================
if(isset($_POST['reverse_commission']))
{
 $COMMISSION_Q="SELECT commission_advisor_id, 
				SUM(commission_amount) AS COMMISSION, 
				SUM(commission_tds_amount) AS TDS, 
				SUM(commission_nett_amount) AS NETT 
				FROM tbl_advisor_commission com
				WHERE 
				commission_order_no='".$BOOKING_ROW['booking_order_no']."' 				
				group by commission_advisor_id";
$COMMISSION_Q=@mysqli_query($_SESSION['CONN'],$COMMISSION_Q);		
//========================( TDS CALCULATION )===========================================================
$TDS_Q=@mysqli_query($_SESSION['CONN'],"SELECT tds FROM tbl_setting_tds");
$TDS_ROW=@mysqli_fetch_assoc($TDS_Q);
$TDS=$TDS_ROW['tds'];

while($COMMISSION_ROWS=@mysqli_fetch_assoc($COMMISSION_Q)) 
{
	$COMMISSION=(-1)*($COMMISSION_ROWS['COMMISSION']);
	$TDS_AMOUNT=(-1)*($COMMISSION_ROWS['TDS']);
	$NETT=(-1)*($COMMISSION_ROWS['NETT']);
	
	 $FIELDS=array(
		 				"commission_order_no" ,
						"commission_voucher_no" ,
						"commission_project_id" ,
						"commission_property_id" ,
						"commission_property_type" ,
						"commission_particular" ,
						"commission_date" ,	
						"commission_voucher_date",					
						"commission_advisor_id" ,
						"commission_customer_id",
						"commission_advisor_level_id" ,
						"commission_advisor_level_percent" ,
						"commission_advisor_level_diff_percent" ,
						"commission_voucher_amount" ,
						"commission_amount" ,
						"commission_tds_percent",
						"commission_tds_amount",
						"commission_nett_amount",
						"commission_by_advisor_id" ,
						"commission_by");
	
	if($BOOKING_ROW['booking_advisor_id']==$COMMISSION_ROWS['commission_advisor_id']) { $REF_SELF="SELF"; } else { $REF_SELF="REF"; }
	
	$VALUES=array(
						$BOOKING_ROW['booking_order_no'],
						$VOUCHER_NO ,
						$BOOKING_ROW['booking_project_id'] ,
						$BOOKING_ROW['booking_property_id'] ,
						$DBOBJ->ConvertToText("tbl_property","property_id","property_type_id",$BOOKING_ROW['booking_property_id']),
						"CANCEL",
						$cancel_date ,
						$cancel_date ,
						$COMMISSION_ROWS['commission_advisor_id'] ,
						$BOOKING_ROW['booking_customer_id'],
						"" ,
						"" ,
						"" ,
						-($_POST["refund_amount"]+$_POST["not_refund"]),
						$COMMISSION,
						$TDS,
						$TDS_AMOUNT,
						$NETT,
						$BOOKING_ROW['booking_advisor_id'],
						$REF_SELF);		
		
		$DBOBJ->Insert("tbl_advisor_commission",$FIELDS,$VALUES,0);					
}
}
//==============================( ENTRY IN CANCELLED TABLE )===============================================================  
  $FIELDS=array( "booking_id", 
                "booking_type", 
				"booking_commission_status",
				"booking_particular", 
				"booking_voucher_no", 
				"booking_date",
				"booking_token_exp_date",
				"booking_project_id",
				"booking_property_id",
				"booking_order_no",
				"booking_customer_id",
				"booking_executive_type",
				"booking_advisor_id", 
				"booking_advisor_level",
				"booking_advisor_level_percent",
				"booking_advisor_team",
				"booking_advisor_team_level",
				"booking_advisor_team_level_percent",
				"booking_advisor_team_level_percent_diff",
				"booking_property_plot_area", 
				"booking_property_plot_area_rate", 
				"booking_property_built_up_area",
				"booking_property_built_up_area_rate", 
				"booking_property_super_built_up_area",
				"booking_property_super_built_up_rate",
				"booking_property_plot_price", 
				"booking_property_construction_build_up_price", 
				"booking_property_construction_super_build_up_price", 
				"booking_property_construction_price", 
				"booking_property_mrp",
				"booking_property_discount", 
				"booking_property_discount_amount", 
				"booking_property_discounted_mrp", 	
				"fixed_mrp",
				"govt_rate",
				"fixed_rate	",		
				"booking_remark", 
				"booking_cancel_status", 
				"booking_cancel_details",
				"booking_payment_mode", 
				"booking_payment_mode_bank", 
				"booking_registry_status", 
				"registry_doc", 
				"registry_receiver", 
				"registry_dispached", 
				"registry_dispached_by", 
				"registry_remarks", 
				"registry_date", 
				"registry_dispached_date", 
				"booking_mutation_status", 
				"created_details", 
				"edited_details");
  $VALUES=array($BOOKING_ROW["booking_id"],
                $BOOKING_ROW["booking_type"], 
				$BOOKING_ROW["booking_commission_status"],
				$BOOKING_ROW["booking_particular"], 
				$BOOKING_ROW["booking_voucher_no"], 
				$BOOKING_ROW["booking_date"],
				$BOOKING_ROW["booking_token_exp_date"],
				$BOOKING_ROW["booking_project_id"],
				$BOOKING_ROW["booking_property_id"],
				$BOOKING_ROW["booking_order_no"],
				$BOOKING_ROW["booking_customer_id"],
				$BOOKING_ROW["booking_executive_type"],
				$BOOKING_ROW["booking_advisor_id"], 
				$BOOKING_ROW["booking_advisor_level"],
				$BOOKING_ROW["booking_advisor_level_percent"],
				$BOOKING_ROW["booking_advisor_team"],
				$BOOKING_ROW["booking_advisor_team_level"],
				$BOOKING_ROW["booking_advisor_team_level_percent"],
				$BOOKING_ROW["booking_advisor_team_level_percent_diff"],
				$BOOKING_ROW["booking_property_plot_area"], 
				$BOOKING_ROW["booking_property_plot_area_rate"], 
				$BOOKING_ROW["booking_property_built_up_area"],
				$BOOKING_ROW["booking_property_built_up_area_rate"], 
				$BOOKING_ROW["booking_property_super_built_up_area"],
				$BOOKING_ROW["booking_property_super_built_up_rate"],
				$BOOKING_ROW["booking_property_plot_price"], 
				$BOOKING_ROW["booking_property_construction_build_up_price"], 
				$BOOKING_ROW["booking_property_construction_super_build_up_price"], 
				$BOOKING_ROW["booking_property_construction_price"], 
				$BOOKING_ROW["booking_property_mrp"],
				$BOOKING_ROW["booking_property_discount"], 
				$BOOKING_ROW["booking_property_discount_amount"], 
				$BOOKING_ROW["booking_property_discounted_mrp"], 
				$BOOKING_ROW["fixed_mrp"],
				$BOOKING_ROW["govt_rate"],
				$BOOKING_ROW["fixed_rate"],		
				$BOOKING_ROW["booking_remark"], 
				"Yes", 
				$_SESSION['user_name'].",".$_SESSION['user_category'].",".date('Y-m-d').",".IndianTime().",".GetIP(),				
				$BOOKING_ROW["booking_payment_mode"], 
				$BOOKING_ROW["booking_payment_mode_bank"], 
				$BOOKING_ROW["booking_registry_status"], 			
				$BOOKING_ROW["registry_doc"], 
				$BOOKING_ROW["registry_receiver"], 
				$BOOKING_ROW["registry_dispached"], 
				$BOOKING_ROW["registry_dispached_by"], 
				$BOOKING_ROW["registry_remarks"], 
				$BOOKING_ROW["registry_date"], 
				$BOOKING_ROW["registry_dispached_date"], 
				$BOOKING_ROW["booking_mutation_status"], 
				$Mess=CreatedEditedByUserMessage(),
				$Mess);		
  $DBOBJ->Insert("tbl_property_booking_cancelled",$FIELDS,$VALUES,0); 
//==============================( END ENTRY IN CANCELLED TABLE )===========================================================  

$DBOBJ->UserAction("BOOKING CANCELLED","ORDER NO : ".$BOOKING_ROW['booking_order_no'].", PROJECT : ".$PROJECT_NAME.", PROPERTY : ".$PROPERTY_TYPE."/".$PROPERTY_NO.", CUSTOMER : ".$CUSTOMER.", ".advisor_title." : ".$ADVISOR);
 header("location:Project_Booking_Cancelled.php?Message=Booking Cancelled Successfully");

}

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
<head><title>Project : Booking Cancel Confirmation</title></head>
<?php if(strtoupper($_SESSION['user_category'])=="ADMIN" && $BOOKING_ROW['booking_cancel_status']!="Yes") {?>
    <center>
  
   <form id="FrmBookingDelete" name="FrmBookingDelete" method="post" enctype="multipart/form-data" action="Project_Booking_Cancel.php?<?php echo md5('booking_id')."=".$_GET[md5("booking_id")]?>">
   <table width="970" border="0" cellspacing="0" cellpadding="5" id="SimpleTable" style="border:0px; margin-top:0px;">
  <tr>
    <td colspan="4"><?php ErrorMessage(); ?></td>
    </tr>
  <tr>
    <td>ORDER NO</td>
    <td colspan="2" style="color:red;"><?php echo $BOOKING_ROW['booking_order_no'];?></td>
      <td width="506" rowspan="9" style="vertical-align:top">
    <h2 style="margin-top:0px; width:502px; margin:0px;">Commission Details</h2>
    <div style="width:500px; height:200px; margin:0px; overflow:auto; border:1px solid silver;">      
      <table width="98%" border="0" cellspacing="1" id="SmallTable" style="margin-top:5px;">
        <tr>
          <th width="2%">#</th>
          <th width="44%"><?php echo advisor_title?></th>
          <th width="12%">id</th>
          <th width="18%">commission</th>
          <th width="12%">tds</th>
          <th width="12%">nett </th>
          </tr>
  <?php 
 $COMMISSION_Q="SELECT com.commission_advisor_id, a.advisor_name, a.advisor_code, 
				SUM(com.commission_amount) AS COMMISSION, 
				SUM(com.commission_tds_amount) AS TDS, 
				SUM(com.commission_nett_amount) AS NETT 
				FROM tbl_advisor_commission com, tbl_advisor a 
				WHERE 
				com.commission_order_no='".$BOOKING_ROW['booking_order_no']."' 
				and  com.commission_advisor_id=a.advisor_id
				group by com.commission_advisor_id order by a.advisor_name";
$COMMISSION_Q=@mysqli_query($_SESSION['CONN'],$COMMISSION_Q);		
while($COMMISSION_ROWS=@mysqli_fetch_assoc($COMMISSION_Q)) {?>    
        <tr>
          <td><div align="center"><?php echo ++$j?></div></td>
          <td><div align="left" style="width:180px;"><?php echo $COMMISSION_ROWS['advisor_name']?></div></td>
          <td><div align="center"><?php echo $COMMISSION_ROWS['advisor_code']?></div></td>
          <td><div align="right"><?php echo @number_format($COMMISSION_ROWS['COMMISSION'],2);$TOTAL_COMMISSION+=$COMMISSION_ROWS['COMMISSION'];?></div></td>
          <td><div align="right"><?php echo @number_format($COMMISSION_ROWS['TDS'],2);$TOTAL_TDS+=$COMMISSION_ROWS['TDS'];?></div></td>
          <td><div align="right"><?php echo @number_format($COMMISSION_ROWS['NETT'],2);$TOTAL_NETT+=$COMMISSION_ROWS['NETT'];?></div></td>
          </tr>
        <?php } ?>
        <tr>
          <th colspan="3">TOTAL</th>
          <th><div align="right"><?php echo @number_format($TOTAL_COMMISSION,2);?></div></th>
          <th><div align="right"><?php echo @number_format($TOTAL_TDS,2);?></div></th>
          <th><div align="right"><?php echo @number_format($TOTAL_NETT,2);?></div></th>
          </tr>
          
  </table>
      
    </td>
  </tr>
  <tr>
    <td width="116">PROPERTY </td>
    <td colspan="2" style="color:blue; "><?php echo $PROPERTY_TYPE."/".$PROPERTY_NO.", ".$PROJECT_NAME;?></td>
    </tr>
  <tr>
    <td>CUSTOMER</td>
    <td colspan="2" class="Value" style="color:red"><?php echo $CUSTOMER;?></td>
    </tr>
  <tr>
    <td><?php echo advisor_title?></td>
    <td colspan="2" class="Value" style="color:blue"><?php echo $ADVISOR;?></td>
    </tr>

  <tr>
    <td>BOOKING DATE</td>
    <td class="Value"><div align="right">
      <?php echo date('d-M-Y',strtotime($BOOKING_ROW['booking_date']));?>
    </div></td>
    <td class="Value">&nbsp;</td>
    </tr>
  <tr>
    <td>DISCOUNTED MRP</td>
    <td width="88" class="Value" style="color:blue"><div align="right">
      <?php echo @number_format($BOOKING_ROW['booking_property_discounted_mrp'],2)?>
    </div></td>
    <td width="148" class="Value">&nbsp;</td>
    </tr>
  <tr>
    <td>PAYMENT&nbsp;RECEIVED</td>
    <td class="Value" style="color:green"><div align="right">
      <?php echo @number_format($paid=$DBOBJ->TotalBookingCollection($BOOKING_ROW['booking_id']),2)?><input type="hidden" name="Received" id="Received" value="<?php echo $paid?>" />
    </div></td>
    <td class="Value">&nbsp;</td>
    </tr>
  <tr>
    <td>BALANCE</td>
    <td class="Value" style="color:red"><div align="right">
      <?php echo @number_format($BALANCE=$DBOBJ->TotalBookingBalance($BOOKING_ROW['booking_id']),2)?>
    </div></td>
    <td class="Value">&nbsp;</td>
    </tr>
  <tr>
    <td>REFUND AMOUNT</td>
    <td colspan="2" style="color:red;" class="Date">
    <input type="text" name="refund_amount" id="refund_amount" required="required" <?php onlyFloat(); ?> value="<?php echo $paid;?>" style="width:100px; text-align:right;" onchange="Calc();" onkeyup="Calc();"/></td>
  </tr>
  <tr>
    <td>CUTT&nbsp;OF (<b id="Required">Not&nbsp;Refundable</b>)</td>
    <td colspan="2" style="color:red;" class="Date"><span class="Date" style="color:red;">
      <input type="text" name="not_refund" id="not_refund" <?php onlyFloat(); ?> value="0.00" style="width:100px; text-align:right; border:0px;" readonly="readonly" onchange="Calc();" onkeyup="Calc();"/>
    </span></td>
  </tr>
  <tr>
    <td>CANCEL DATE</td>
    <td colspan="2" tyle="color:red" class="Date"><?php DateInput("cancel_date");?>
        
    </td>
    </tr>
   <tr>
    <td colspan="3"><hr /></td>
    </tr>
  <tr>
    <td style="vertical-align:top">Reverse Commission</td>
    <td colspan="2" style="color:red">
    <label>
    <input type="checkbox" value="Yes" name="reverse_commission" id="reverse_commission" onclick="if(this.checked!='') { alert('Commission Will Be Reversed.');}" />
     Do you want to reverse commission earned by all <?php echo advisor_title?>. 
     <br />A new commission will be generated which will be equal to negative of total earned commission.
    </label>
    </td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:RIGHT; vertical-align:top;"><hr /></td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:RIGHT; vertical-align:top;">
    <input type="submit" name="Submit" id="Submit" class="Button" value="Cancel Booking" <?php Confirm("Are You Sure ?\\n Do Your Realy Want To Cancel This Booking And Its Related Details ?\\n\\n All Payment Received & Commission Generated Details Will Be Reverse. \\n\\nWould You Proceed ?"); ?>/>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.close();" /></td>
    </tr>
  <tr>
    <td colspan="4" >
    <div id="Error" style="text-transform:none;"><font color="#00FF00">Some Of  Payment Received</font> Will Be <font color="#00FF00">Reverse</font> On Cancel At Cancel Date.
   
     <br/> A New Payment of <font color="#00FF00" id="Ref"><?php echo @number_format(-$paid,2);?></font> Will Be Maked.
    </div>
    </td>
    </tr>
</table>
<script>
function Calc()
{
	alert();
	/*var bal=parseFloat(<?php echo $paid?>)-parseFloat(document.getElementById('refund_amount').value);
	
	document.getElementById('not_refund').value=bal.toFixed(2);*/
	
}
</script>

</form>

</center>
<?php } ?>
