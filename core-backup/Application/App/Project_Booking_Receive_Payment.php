<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Project");
NoUser();
//PrintArray($_POST);
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$BOOKING_ROW=$DBOBJ->GetRow('tbl_property_booking','booking_id',$_GET[md5('booking_id')]);
//===================(COMMISSION DISTRIBUTED OR NOT)=================================================
$BOOKING_COMMISSION_STATUS=$BOOKING_ROW['booking_commission_status'];
//======================================================================

$CUSTOMER_ROW=$DBOBJ->GetRow('tbl_customer','customer_id',$BOOKING_ROW['booking_customer_id']);
$ADVISOR_ROW=$DBOBJ->GetRow('tbl_advisor','advisor_id',$BOOKING_ROW['booking_advisor_id']);

$TOTAL_PAID=$DBOBJ->TotalBookingCollection($_GET[md5('booking_id')]);
$TOTAL_BALANCE=$DBOBJ->TotalBookingBalance($_GET[md5('booking_id')]);
$BALANCE=$BOOKING_ROW['booking_property_discounted_mrp'];

$BOOKING_ID=$_GET[md5('booking_id')];

$PROPERTY_ID=$BOOKING_ROW['booking_property_id'];
$PROJECT_ID=$BOOKING_ROW['booking_project_id'];
$CUSTOMER_ID=$BOOKING_ROW['booking_customer_id'];
$ADVISOR_ID=$BOOKING_ROW['booking_advisor_id'];

$ORDER_COUNTER=$BOOKING_ID;
$ORDER_NO=$BOOKING_ROW['booking_order_no'];
$PROPERTY_TYPE=$PROPERTY_TYPE_ID=$DBOBJ->ConvertToText('tbl_property','property_id','property_type_id',$BOOKING_ROW['booking_property_id']);

if(isset($_POST['Save']) && isset($_GET[md5('booking_id')]))
{
	  $VOUCHER_AMOUNT=$_POST['payment_amount'];
	 
	  $PROPERTY_STATUS="Booked";
	  $payment_heading=$_POST['payment_heading'];
	  $payment_head="DP";
	
	   if($payment_heading=="DOWN PAYMENT") 
	   { 
	     $PROPERTY_STATUS="Booked"; 		
		 $payment_head="DP";
	   }
	   elseif($payment_heading=="INSTALLMENT")
	   {
		   $PROPERTY_STATUS="Booked"; 		
		   $payment_head="INS";
	   }
	   elseif($payment_heading=="FULL PAYMENT")
	   {
		   $PROPERTY_STATUS="Booked"; 		
		   $payment_head="FP";
	   }
	//========================( PROPERTY TABLE)==============================================================	
        $FIELDS=array("property_status");
		$VALUES=array($PROPERTY_STATUS);		
		$DBOBJ->Update("tbl_property",$FIELDS,$VALUES,"property_id",$PROPERTY_ID,0);
	//========================(BOOKING TABLE)=================================================================
	 	$FIELDS=array("booking_type");
		$VALUES=array("Permanent");		
		$DBOBJ->Update("tbl_property_booking",$FIELDS,$VALUES,"booking_id",$BOOKING_ID,0);
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
					"edited_details",
					"approved");	
				   
	    $VALUES=array($BOOKING_ID,
						$ORDER_NO,		
						$payment_heading,
						$PROJECT_ID, 
						$PROPERTY_ID, 				
						$BOOKING_ROW['booking_customer_id'],  
						$DBOBJ->ConvertToText('tbl_property_booking_payments','payment_booking_id','MAX(payment_installment_no)',$BOOKING_ID)+1,
						$_POST["payment_amount"], 
						$_POST["payment_date"], 
						"ADVISOR",
						$ADVISOR_ID,
						$_POST["payment_mode"],
						$_POST["payment_mode_no"],
						$_POST["payment_mode_bank"],
						$_POST["payment_mode_date"], 
						$_POST["booking_remark"],
						$Mess=CreatedEditedByUserMessage(),
						$Mess,
						0);					
		$DBOBJ->Insert("tbl_property_booking_payments",$FIELDS,$VALUES,0);
		$MAX_PAYMENT_ID=$DBOBJ->MaxID("tbl_property_booking_payments","payment_id");
		
		//==============( GENERATE VOUCHER NO )===============================
		$VOUCHER_NO=str_pad($ORDER_COUNTER,4,"0",STR_PAD_LEFT)."/".$payment_head."/".str_pad($MAX_PAYMENT_ID,4,"0",STR_PAD_LEFT);
		//==============( UPDATE VOUCHER NO IN PAYMENT)===============================
		$FIELDS=array("payment_voucher_no");
		$VALUES=array($VOUCHER_NO);		
		$DBOBJ->Update("tbl_property_booking_payments",$FIELDS,$VALUES,"payment_id",$MAX_PAYMENT_ID,0);
		
//========================( COMMISSION TABLE)==================================================================================================
//=============================================================================================================================================
        $FIELDS=array("commission_order_no" ,
						"commission_voucher_no" ,
						"commission_project_id" ,
						"commission_property_id" ,
						"commission_property_type" ,
						"commission_particular" ,
						"commission_date" ,	
						"commission_voucher_date" ,					
						"commission_advisor_id" ,
						"commission_customer_id",
						"commission_advisor_level_id" ,
						"commission_advisor_current_level_id",
						"commission_advisor_level_percent" ,
						"commission_advisor_level_diff_percent" ,
						"commission_voucher_amount" ,
						"commission_amount" ,
						"commission_tds_percent",
						"commission_tds_amount",
						"commission_nett_amount",
						"commission_by_advisor_id" ,
						"commission_by",
						"approved");
						
//==========================(COMMISSION ON TOKEN WAITING FOR OWNPAYMENT)===================================================		
if($BOOKING_ROW['booking_commission_status']!="1")
{
        $TOKEN_ROW=$DBOBJ->GetRow("tbl_property_booking_payments","payment_voucher_no",$BOOKING_ROW['booking_voucher_no']);
		$ADVISOR_LEVEL=$BOOKING_ROW['booking_advisor_level'];
		$ADVISOR_PERCENT=$BOOKING_ROW['booking_advisor_level_percent'];
		$DIFF_PERCENT=$ADVISOR_PERCENT;
        $COMMISSION_AMOUNT=$TOKEN_ROW['payment_amount']*$ADVISOR_PERCENT/100;		
	    
		//========================( TDS CALCULATION )===========================================================
		$TDS_Q=@mysqli_query($_SESSION['CONN'],"SELECT tds FROM tbl_setting_tds");
        $TDS_ROW=@mysqli_fetch_assoc($TDS_Q);
		$TDS=$TDS_ROW['tds'];
		
		$VALUES=array($ORDER_NO,
						$TOKEN_ROW['payment_voucher_no'] ,
						$PROJECT_ID ,
						$PROPERTY_ID ,
						$PROPERTY_TYPE ,
						$TOKEN_ROW['payment_heading'],
						$_POST['payment_date'],	
						$TOKEN_ROW['payment_date'] ,						
						$ADVISOR_ID ,
						$BOOKING_ROW['booking_customer_id'],
						$ADVISOR_LEVEL ,
						$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_level_id",$ADVISOR_ID),
						$DIFF_PERCENT ,
						$DIFF_PERCENT ,						
						$TOKEN_ROW['payment_amount'] ,
						$COMMISSION_AMOUNT ,
						$TDS,
						$TDS_AMOUNT=$TDS*$COMMISSION_AMOUNT/100,
						$COMMISSION_AMOUNT-$TDS_AMOUNT,
						$ADVISOR_ID ,
						"SELF",
						0);		
		$DBOBJ->Insert("tbl_advisor_commission",$FIELDS,$VALUES,0);
		
//=========================(COMMISSION FOR PARENTS/SPONSOR)==========================================	
$SPONSOR_STRING=explode(",",$BOOKING_ROW['booking_advisor_team']);	
$LEVEL_STRING=explode(",",$BOOKING_ROW['booking_advisor_team_level']);
$PERCENT_STRING=explode(",",$BOOKING_ROW['booking_advisor_team_level_percent']);
$DIFF_STRING=explode(",",$BOOKING_ROW['booking_advisor_team_level_percent_diff']);	

$SPONSOR_COUNT=count($SPONSOR_STRING);

for($s=0;$s<$SPONSOR_COUNT;$s++)
{	
		$COMMISSION_AMOUNT=$TOKEN_ROW['payment_amount']*$DIFF_STRING[$s]/100;	   
		$VALUES=array(  $ORDER_NO,
						$TOKEN_ROW['payment_voucher_no'] ,
						$PROJECT_ID ,
						$PROPERTY_ID ,
						$PROPERTY_TYPE ,
						$TOKEN_ROW['payment_heading'] ,
						$_POST['payment_date'] ,	
						$TOKEN_ROW['payment_date'] ,			
						$SPONSOR_STRING[$s] ,
						$BOOKING_ROW['booking_customer_id'],
						$LEVEL_STRING[$s] ,
						$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_level_id",$SPONSOR_STRING[$s]),
						$PERCENT_STRING[$s] ,
						$DIFF_STRING[$s],
						$TOKEN_ROW['payment_amount'] ,
						$COMMISSION_AMOUNT ,
						$TDS,
						$TDS_AMOUNT=$TDS*$COMMISSION_AMOUNT/100,
						$COMMISSION_AMOUNT-$TDS_AMOUNT,
						$ADVISOR_ID ,
						"REF",
						0);		
		$DBOBJ->Insert("tbl_advisor_commission",$FIELDS,$VALUES,0);
   }	
   
   //========================(BOOKING TABLE)=================================================================
	 	$FIELD_B=array("booking_commission_status","next_payment_date");
		$VALUE_B=array("1",$_POST['next_payment_date']);		
		$DBOBJ->Update("tbl_property_booking",$FIELD_B,$VALUE_B,"booking_id",$BOOKING_ID,0);					
}
					
						
//============================(COMMISSION ON CURRENT PAYMENT)===================================================================					
//=========================(COMMISSION FOR FIRST Associate)==========================================
        $ADVISOR_LEVEL=$BOOKING_ROW['booking_advisor_level'];
		$ADVISOR_PERCENT=$BOOKING_ROW['booking_advisor_level_percent'];
		$DIFF_PERCENT=$ADVISOR_PERCENT;
        $COMMISSION_AMOUNT=$VOUCHER_AMOUNT*$ADVISOR_PERCENT/100;		
	    
		//========================( TDS CALCULATION )===========================================================
		$TDS_Q=@mysqli_query($_SESSION['CONN'],"SELECT tds FROM tbl_setting_tds");
        $TDS_ROW=@mysqli_fetch_assoc($TDS_Q);
		$TDS=$TDS_ROW['tds'];
		
		$VALUES=array($ORDER_NO,
						$VOUCHER_NO ,
						$PROJECT_ID ,
						$PROPERTY_ID ,
						$PROPERTY_TYPE ,
						$payment_heading ,
						$_POST['payment_date'] ,	
						$_POST['payment_date'] ,						
						$ADVISOR_ID ,
						$BOOKING_ROW['booking_customer_id'],
						$ADVISOR_LEVEL ,
						$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_level_id",$ADVISOR_ID),
						$DIFF_PERCENT ,
						$DIFF_PERCENT ,						
						$VOUCHER_AMOUNT ,
						$COMMISSION_AMOUNT ,
						$TDS,
						$TDS_AMOUNT=$TDS*$COMMISSION_AMOUNT/100,
						$COMMISSION_AMOUNT-$TDS_AMOUNT,
						$ADVISOR_ID ,
						"SELF",
						0);		
		$DBOBJ->Insert("tbl_advisor_commission",$FIELDS,$VALUES,0);
		
//=========================(COMMISSION FOR PARENTS/SPONSOR)==========================================	
$SPONSOR_STRING=explode(",",$BOOKING_ROW['booking_advisor_team']);	
$LEVEL_STRING=explode(",",$BOOKING_ROW['booking_advisor_team_level']);
$PERCENT_STRING=explode(",",$BOOKING_ROW['booking_advisor_team_level_percent']);
$DIFF_STRING=explode(",",$BOOKING_ROW['booking_advisor_team_level_percent_diff']);	
$SPONSOR_COUNT=count($SPONSOR_STRING);
for($s=0;$s<$SPONSOR_COUNT;$s++)
{	
		$COMMISSION_AMOUNT=$VOUCHER_AMOUNT*$DIFF_STRING[$s]/100;	   
		$VALUES=array(  $ORDER_NO,
						$VOUCHER_NO ,
						$PROJECT_ID ,
						$PROPERTY_ID ,
						$PROPERTY_TYPE ,
						$payment_heading ,
						$_POST['payment_date'] ,
						$_POST['payment_date'] ,
						$SPONSOR_STRING[$s] ,
						$BOOKING_ROW['booking_customer_id'],
						$LEVEL_STRING[$s] ,
						$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_level_id",$SPONSOR_STRING[$s]),
						$PERCENT_STRING[$s] ,
						$DIFF_STRING[$s],
						$VOUCHER_AMOUNT ,
						$COMMISSION_AMOUNT ,
						$TDS,
						$TDS_AMOUNT=$TDS*$COMMISSION_AMOUNT/100,
						$COMMISSION_AMOUNT-$TDS_AMOUNT,
						$ADVISOR_ID ,
						"REF",
						0);		
		$DBOBJ->Insert("tbl_advisor_commission",$FIELDS,$VALUES,0);
}
		
			

		
$DBOBJ->UserAction("PAYMENT RECEIVED", "ORDER NO ".$ORDER_NO.", AMOUNT : ".$VOUCHER_AMOUNT);		
if(isset($_POST['sms'])) { $msg="&".md5('send_sms')."=".md5('send_sms'); }
header("location:Project_Booking_Receive_Payment_Next.php?".md5("payment_voucher_no")."=".$VOUCHER_NO.$msg);
//========================( MESSAGE AND ACTION )==============================================================
	
}

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />

<center>
<h1><img src="../SpitechImages/ReceivePayment.png" width="31" height="32" />Project  : <span>Receive Payment</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">  
    <center> 
   <fieldset style="width:1000PX;"><legend> Receive Payment : </legend>
 
   <table width="98%" border="0" cellspacing="1"  style="border:0PX;" id="SimpleTable">
   <form id='BookingForm' name="BookingForm" method="get">
  <tr>
    <td width="72">CUSTOMER</td>
    <td colspan="2">
         <select id="<?php echo md5("booking_customer_id"); ?>" name="<?php echo md5("booking_customer_id"); ?>"  required="" onchange="BookingForm.submit();" >
          <option value="">SELECT A CUSTOMER...</option>
          <?php   $CUSTOMER_Q="SELECT customer_id, customer_code, customer_name FROM tbl_customer ORDER BY customer_name";
			   $CUSTOMER_Q=@mysqli_query($_SESSION['CONN'],$CUSTOMER_Q);
			   while($CUSTOMER_ROWS=@mysqli_fetch_assoc($CUSTOMER_Q)) {?>
          <option value="<?php echo $CUSTOMER_ROWS['customer_id'];?>" <?php SelectedSelect($CUSTOMER_ROWS['customer_id'], $_GET[md5('booking_customer_id')]); ?> >
            <?php echo $CUSTOMER_ROWS['customer_name']." [".$CUSTOMER_ROWS['customer_code']." ]";?>
            </option>
          <?php } ?>
          </select>
          
          </td>
    <td width="118" rowspan="9" style="text-align:center; line-height:13px; vertical-align:top; font-size:10px;" title="Customer">
      <?php 
	  $customer_photo=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_photo",$_GET[md5('booking_customer_id')]);
	  $ACTUAL_PHOTO="../SpitechUploads/customer/profile_photo/".$customer_photo; 
	
	  if($customer_photo!="" && $customer_photo!="0")
	  {
		  $exist=file_exists($ACTUAL_PHOTO); 
		  if($exist!="1") { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }
	  }
	  else
	  {
		  $ACTUAL_PHOTO="../SpitechImages/Customer.png";
	  } 
		  
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Customer" width="100" height="120" id="imgBorder"/>
      <?php echo $CUSTOMER_ROW['customer_name'];?>
    </td>
    <td width="114" rowspan="9" style="line-height:13px; text-align:center;vertical-align:top;font-size:10px;" title="Advisor">
    
     <?php 
	 
	 $advisor_photo=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_photo",$BOOKING_ROW['booking_advisor_id']);
	 $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$advisor_photo;
	 
	 if($advisor_photo!="" && $advisor_photo!="0")
	 {
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
	 }
	 else
	 {
		  $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; 
	 }
		  
		 ?><img src="<?php  echo $ACTUAL_PHOTO; ?>" alt="<?php echo advisor_title?>" width="100" height="120" id="imgBorder"/>
         <?php echo $ADVISOR_ROW['advisor_name'];?>
    
    
    </td>
    <td width="360" rowspan="21" style="line-height:13px; text-align:center;vertical-align:top; border-LEFT:1PX SOLID GRAY;">
    <h2 style="width:100%; margin:0px;">Previous Payment Details</h2>
    <table width="98%" cellspacing="1"  id="SmallTable" style="width:98%; margin:0px;">
      <tr>
        <th width="38" height="26" >S.No</th>
        <th width="76" >Voucher</th>
        <th width="84" >Date</th>
        <th width="102" >Particulars </th>
        <th width="70" >payment</th>
        </tr>
      <?php 		  $DEBIT_TOTAL=0;
           $s1 = @mysqli_query($_SESSION['CONN'],"select * from tbl_property_book where project_id=".$_GET[project_id]." and property_id=".$_GET[property_id]." and customer_id=".$_GET[customer_id]." and order_number='".$_GET['order_no']."' and approved='1' ");
		   $r1=@mysqli_fetch_array($s1);
		   
		 	
		  $k=1;	
		  $PAYMENT_Q=@mysqli_query($_SESSION['CONN'],"select * from tbl_property_booking_payments where approved='1' and payment_booking_id='$BOOKING_ID' ORDER BY payment_id"); 
		  while($PAYMENT_ROWS=@mysqli_fetch_array($PAYMENT_Q))
		  {	  
		   ?>
      <tr>
        <td height="20" ><div align="center"><?php echo $k++;?>.</div></td>
        <td><div align="left"><?php echo $PAYMENT_ROWS['payment_voucher_no']; ?></div></td>
        <td><div align="center"><?php echo date('d-M-Y',strtotime($PAYMENT_ROWS['payment_date']));?></div></td>
        <td><div align="left" style="width:120px;"><?php echo $PAYMENT_ROWS['payment_heading'];?></div></td>
        <td><div align="right"><?php echo @number_format($PAYMENT_ROWS['payment_amount'],2); $TOTAL_PAID1+=$PAYMENT_ROWS['payment_amount'];?></div></td>
        </tr>
      <?php }?>
      <tr  >
        <th height="20" colspan="4" ><div align="right">TOTAL PAID AMOUNT </div></th>
        <th ><div align="right" style="color:#990000;"> <?php echo @number_format($TOTAL_PAID1,2); ?></div></th>
        </tr>
    </table>
    
    
    
    </td>
  </tr>

   
  <tr>
    <td>PROPERTY</td>
    <td colspan="2">
      <select id="<?php echo md5("booking_id"); ?>" name="<?php echo md5("booking_id"); ?>"  required="" onchange="BookingForm.submit();">
        <option value="">SELECT BOOKING DETAILS...</option>
        <?php   $BOOKING_Q="SELECT * from tbl_property_booking where booking_customer_id='".$_GET[md5('booking_customer_id')]."' and booking_cancel_status!='Yes' and approved='1' " ;
			   $BOOKING_Q=@mysqli_query($_SESSION['CONN'],$BOOKING_Q);
			   while($BOOKING_ROWS=@mysqli_fetch_assoc($BOOKING_Q)) {?>
        <option value="<?php echo $BOOKING_ROWS['booking_id'];?>" <?php SelectedSelect($BOOKING_ROWS['booking_id'], $_GET[md5('booking_id')]); ?> >
          <?php 			
			$TYPE=$DBOBJ->PropertyTypeName($BOOKING_ROWS['booking_property_id']);
			$PROPERTY=$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROWS['booking_property_id']);
			$PROJECT=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROWS['booking_project_id']);
			
			echo $PROPERTY." / ".$TYPE." / ".$PROJECT." / ".$BOOKING_ROWS['booking_order_no'];
			?>
          </option>
        <?php } ?>
        </select>
    </td>
    </tr>
      </form>
  <?php if($_GET[md5('booking_id')]>0) { ?>  
     <form id='PaymentForm' name="PaymentForm" method="post">
  <tr>
    <td colspan="3"><HR /></td>
    </tr>
  <tr>
    <td>PROPERTY</td>
    <td colspan="2" style="color:BLUE; font-size:14px;">
	<?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROW['booking_property_id'])."/".$DBOBJ->PropertyTypeName($BOOKING_ROW['booking_property_id']);;?>
    </td>
    </tr>
  <tr>
    <td>PROJECT</td>
    <td colspan="2" style="color:BLUE; font-size:14px;"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROW['booking_project_id']);?></td>
    </tr>
  <tr>
    <td>Order No</td>
    <td width="124" style="color:red; font-size:14px;"><div align="right"><?php echo $BOOKING_ROW['booking_order_no'];?></div></td>
    <td width="178">&nbsp;</td>
    </tr>
  <tr>
    <td><div align="left" style="width:120px;">booking&nbsp;date</div></td>
    <td id="Value"><div align="right"><?php echo date('d-Y-M',strtotime($BOOKING_ROW['booking_date']));?></div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>mrp</td>
    <td style="color:maroon;font-size:13px;"><div align="right"><?php echo @number_format($BOOKING_ROW['booking_property_discounted_mrp'],2);?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>total paid</td>
    <td style="color:green;font-size:13px;"><div align="right"><?php echo @number_format($TOTAL_PAID,2);?></div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>balance</td>
    <td style="color:red; font-size:13px;"><div align="right"><?php echo @number_format($TOTAL_BALANCE,2);?></div></td>
    <td>&nbsp;</td>
    <td style="text-align:center; line-height:13px; vertical-align:top">&nbsp;</td>
    <td style="line-height:13px; text-align:center;vertical-align:top">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5"><hr /></td>
    </tr>
  <tr>
    <td>PARTICULAR</td>
    <td colspan="2">
      <select id="payment_heading" name="payment_heading">      
         <?php 	  $DP_EXIST="SELECT payment_id from tbl_property_booking_payments where payment_booking_id='".$_GET[md5('booking_id')]."' and payment_heading='DOWN PAYMENT' ";
	  $DP_EXIST=@mysqli_query($_SESSION['CONN'],$DP_EXIST);
	  $DP_EXIST=@mysqli_num_rows($DP_EXIST);
	    if($DP_EXIST<1) { ?>   
        <option value="DOWN PAYMENT">DOWN PAYMENT</option>  
        <?php } ?>      
        
        <option value="INSTALLMENT">INSTALLMENT</option>
        <option value="FULL PAYMENT">FULL PAYMENT</option>
        </select>
    </td>
    <td style="text-align:center; line-height:13px; vertical-align:top">&nbsp;</td>
    <td style="line-height:13px; text-align:center;vertical-align:top">&nbsp;</td>
    </tr>
  <tr>
    <td>PAYMENT&nbsp;DATE</td>
    <td colspan="2" class="Date"><script>DateInput('payment_date', true, 'yyyy-mm-dd','<?php echo date('Y-m-d')?>');</script></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td style="line-height:13px; vertical-align:top;">
          <span class="Required">Next Payment Date</span></td>
    <td colspan="2" class="Date">
	<?php $NEXT_PAYMENT_DATE=NextMonth(date('Y-m-d'),1);  ?>
    <script>DateInput('next_payment_date', true, 'yyyy-mm-dd','<?php echo $NEXT_PAYMENT_DATE?>');</script></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>MODE</td>
    <td colspan="2">
    <select name="payment_mode" id="payment_mode" onchange="HidMe();">
      <option value="CASH">CASH</option>     
          <option value="CHEQUE">CHEQUE</option>
          <option value="CHALLAN">CHALLAN</option>
          <option value="DD">DD</option>
          <option value="FT">FT</option>
          <option value="PAYMENT BY BANK">PAYMENT BY BANK</option>     
  </select>
  </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>

  <tr id="hide" style="display:<?php echo "none"?>">
    <td>PAYMENT&nbsp;DETAILS</td>
    <td colspan="2">
    
    <table width="98%" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="26%"><div align="left">NO</div></td>
              <td width="74%"><div align="left">
                <input type="text" name="payment_mode_no" id="payment_mode_no" placeholder="CHALLAN/DD/CHEQUE/TXN NO" maxlength="25" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Bank</div></td>
              <td><div align="left">
                <input type="text" name="payment_mode_bank" id="payment_mode_bank" placeholder="FROM BANK"  />
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>PAYING AMOUNT</td>
    <td colspan="2">
    <input type="text" name="payment_amount" placeholder="AMOUNT" value="0" id="payment_amount" style="text-align:right; width:105px; font-size:14PX; background:green; color:white;" required='required' <?php OnlyFloat(); ?> maxlength="18" onchange="Calc();" onkeyup="Calc();" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>BALANCE</td>
    <td  style="color:red; font-size:13px;"><div align="right"><SPAN id="Bal">
      <?php echo @number_format($TOTAL_BALANCE,2);?>
    </SPAN></div></td>
    <td  style="color:red; font-size:13px;">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>REMARKS</td>
    <td colspan="4"><input type="text" name="payment_remarks" id="payment_remarks" placeholder="PAYMENT REMARKS IF ANY " maxlength="100" style="width:450px;" /></td>
    </tr>
        <tr>
          <td style="line-height:13px;">SEND SMS</td>
          <td colspan="4">
            <label><input type="checkbox" name="sms" id="sms" value="send_sms" />SEND SMS (<span class="Required"> Check if  Want To Send Message To Customer & Associate</span>)</label>
          </td>
          </tr>
   
    <tr>
      <td colspan="5">
        <div align="center">
          <input type="submit" name="Save" id="Save" value="Save Payment Details" <?php Confirm("Are You Sure ? Save Payment Details ?"); ?>/>
          <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.location='Customer.php';" />
          </div>
      </td>
      <td style="text-align:RIGHT">&nbsp;</td>
    </tr></form>
    <?php } ?>
   </table>

   </fieldset></center>
    </td>
    </tr>
    </table>
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
  
<?php include("../Menu/Footer.php"); ?>
