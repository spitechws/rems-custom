<?php @session_start();
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../Menu/Define.php");
NoUser();
NoAdmin();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$booking_id=$_GET[md5('booking_id')];

$BOOKING_ROW=$DBOBJ->GetRow('tbl_property_booking','booking_id',$booking_id);
$PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROW['booking_project_id']);
$PROPERTY_NO=$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROW['booking_property_id']);
$PROPERTY_TYPE_NAME=$DBOBJ->PropertyTypeName($BOOKING_ROW['booking_property_id']);

$CUSTOMER_NAME=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$BOOKING_ROW['booking_customer_id']);
$CUSTOMER_CODE=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_code",$BOOKING_ROW['booking_customer_id']);

$ADVISOR_NAME=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$BOOKING_ROW['booking_advisor_id']);
$ADVISOR_CODE=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$BOOKING_ROW['booking_advisor_id']);

$COMMISSION_ROW=$DBOBJ->GetRow('tbl_advisor_commission','commission_voucher_no',$BOOKING_ROW['booking_voucher_no']);

if(isset($_POST['Save']) && $_GET[md5('booking_id')]>0)
{
	//=========================(ENTRY IN BOOKING)===========================================
	
	
		 $FIELDS=array("booking_property_plot_area_rate", 				
				 "booking_property_built_up_area_rate", 				
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
				 "fixed_rate",
				 
				 "booking_remark",				 
				 "booking_payment_mode", 
				 "booking_payment_mode_bank", 				
				 "edited_details");	
				   
	  $VALUES=array(
				 $_POST["booking_property_plot_area_rate"], 				
				 $_POST["booking_property_built_up_area_rate"], 				
				 $_POST["booking_property_super_built_up_rate"], 
				 $_POST["booking_property_plot_price"], 
				 $_POST["booking_property_construction_price_built_up"],
				 $_POST["booking_property_construction_price_super_built_up"],
				 $_POST["booking_property_construction_price_built_up"]+$_POST["booking_property_construction_price_super_built_up"], 
				 $_POST["booking_property_mrp"], 
				 $_POST["booking_property_discount"], 
				 $_POST["booking_property_discount_amount"], 
				 $_POST["booking_property_discounted_mrp"], 
				 
				  $_POST["fixed_mrp"],
				  $_POST["govt_rate"],
				  $_POST["fixed_rate"],
				 
				 $_POST["booking_remark"],				
				 $_POST["booking_payment_mode"], 
				 $_POST["booking_payment_mode_bank"], 				 
				 $Mess=CreatedEditedByUserMessage());
		 $DBOBJ->Update("tbl_property_booking",$FIELDS,$VALUES,"booking_id",$booking_id,0);
		
	
	$DBOBJ->UserAction("BOOKING DETAILS EDITED","BOOKING NO : ".$BOOKING_ROW['booking_id']);
	UnloadMe();
}

	$plot=$BOOKING_ROW['booking_property_plot_area'];
	$plot_r=$plot*$BOOKING_ROW['booking_property_plot_area_rate'];
	
	$built=$BOOKING_ROW['booking_property_built_up_area'];	 
	$built_r=$built*$BOOKING_ROW['booking_property_built_up_area_rate'];
	
$super=$BOOKING_ROW['booking_property_super_built_up_area'];	;
$super_r=$super*$BOOKING_ROW['booking_property_super_built_up_rate'];	;



if($plot=="") 	{ $plot=0;  }
if($built=="")   { $built=0; }
if($super=="")   { $super=0; }

if($plot_r=="") 	{ $plot_r=0;  }
if($built_r=="")   { $built_r=0; }
if($super_r=="")   { $super_r=0; }
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
<head>
<title>Project : Booking Delete Confirmation</title>
</head>

<center>
  <fieldset style="width:850px; height:auto;"><legend>Edit Booking Details : </legend>
    <table width="98%" border="0" cellspacing="0"  style="border:0PX;" id="SimpleTable">
      <form id='PaymentForm' name="PaymentForm" method="post">
        <tr>
          <td colspan="4"><HR /></td>
        </tr>
        <tr>
          <td width="124">PROPERTY</td>
          <td style="color:BLUE; font-size:14px;"><?php echo $PROPERTY_TYPE_NAME."/".$PROPERTY_NO?></td>
          <td width="107" >PROJECT</td>
          <td width="250" style="color:BLUE; font-size:14px;"><?php echo $PROJECT_NAME?></td>
        </tr>
        <tr>
          <td>ORDER NO</td>
          <td colspan="3" style="color:maroon; font-size:14px;"><?php echo $BOOKING_ROW['booking_order_no'];?></td>
        </tr>
        <tr>
          <td>CUSTOMER</td>
          <td colspan="3" id="Value"><?php echo $CUSTOMER_NAME." [<FONT COLOR='RED'>".$CUSTOMER_CODE."</FONT>]";?></td>
        </tr>
        <tr>
          <td><?php echo advisor_title?></td>
          <td colspan="3" id="Value"><?php echo $ADVISOR_NAME." [<FONT COLOR='RED'>".$ADVISOR_CODE."</FONT>]";?></td>
        </tr>
        <tr>
          <td><div align="left" style="width:120px;">BOOKING DATE</div></td>
          <td width="95" id="Value" style="color:maroon"><div align="left">
              <?php echo date('d/M/Y',strtotime($BOOKING_ROW['booking_date'],2));?>
            </div></td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"><hr /></td>
        </tr>
     
        <tr>
          <td colspan="4">
            <table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="16%" style="color:blue">PLOT RATE&nbsp;/&nbsp;<span style="color:red;"><span style="text-transform:capitalize; "><sup>2</sup> Feet</span></span></td>
                <td colspan="2" >
                <input type="text" name="booking_property_plot_area_rate" placeholder="Rate/Square Feet" id="booking_property_plot_area_rate" style="width:80px; text-align:right;" required='' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_plot_area_rate');CalcRate();" onkeyup="CalcRate();" value="<?php echo $BOOKING_ROW['booking_property_plot_area_rate']?>"/>
                
                  &nbsp;X&nbsp;<span style="color:red;">
                  <?php echo $BOOKING_ROW['booking_property_plot_area']?>
                  <span style="text-transform:capitalize; color:blue;"><SUP>2</SUP> Feet</span></span>
                 
                  <input type="hidden" name="booking_property_plot_area" id="booking_property_plot_area" style="width:80px;" required='required' value="<?php echo $BOOKING_ROW['booking_property_plot_area']?>"/>
                  
                  </td>
                <td width="15%"><div align="left" style="width:120px;"><span style="font-size:14px;"> =&nbsp;
                    <input type="text" name="booking_property_plot_price" id="booking_property_plot_price"  placeholder="Plot Price" value="<?php echo $BOOKING_ROW['booking_property_plot_price']?>" style="width:80px; text-align:right;" required='required' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_plot_price');" readonly="readonly"/>
                    </span></div></td>
                <td width="36%" colspan="2"><span style="color:BLUE">PLOT&nbsp;PRICE</span></td>
              </tr>
              <tr>
                <td style="color:green">BUILT up RATE&nbsp;/&nbsp;<span style="color:blue"><span style="color:red;"><span style="text-transform:capitalize; ;"><sup>2</sup> Feet</span></span></span></td>
                <td colspan="2"><input type="text" name="booking_property_built_up_area_rate" id="booking_property_built_up_area_rate" placeholder="Rate/Square Feet"  style="width:80px; text-align:right;" required='' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_built_up_area_rate');CalcRate();" onkeyup="CalcRate();" value="<?php echo $BOOKING_ROW['booking_property_built_up_area_rate']?>"/>
                  &nbsp;X&nbsp;<span style="color:red;">
                  <?php echo $BOOKING_ROW['booking_property_built_up_area']?>
                  <span style="text-transform:capitalize; color:blue;"><SUP>2</SUP> Feet</span></span>
                  <input type="hidden" name="booking_property_built_up_area" id="booking_property_built_up_area" value="<?php echo $BOOKING_ROW['booking_property_built_up_area']?>"  style="width:80px;" required='required'/></td>
                <td><div align="left"><span style="font-size:14px;"> =&nbsp;
                    <input type="text" name="booking_property_construction_price_built_up" id="booking_property_construction_price_built_up"  placeholder="Construction Price" value="<?php echo $BOOKING_ROW['booking_property_construction_build_up_price']?>" style="width:80px; text-align:right;" required='required' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_construction_price_built_up');" readonly="readonly"/>
                    </span></div></td>
                <td colspan="2"><span style="color:GREEN">CONSTRUCTION&nbsp;PRICE</span></td>
              </tr>
              <tr>
                <td style="color:green">SUPER&nbsp;BUILT&nbsp;UP&nbsp;RATE&nbsp;/&nbsp;<span style="color:blue"><span style="color:red;"><span style="text-transform:capitalize; "><sup>2</sup>&nbsp;Feet</span></span></span></td>
                <td colspan="2"><input type="text" name="booking_property_super_built_up_rate" id="booking_property_super_built_up_rate"  placeholder="Rate/Square Feet"  style="width:80px; text-align:right;" required='' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_super_built_up_rate');CalcRate();" onkeyup="CalcRate();" value="<?php echo $BOOKING_ROW['booking_property_super_built_up_rate']?>"/>
                  &nbsp;X&nbsp;<span style="color:red;">
                  <?php echo $BOOKING_ROW['booking_property_super_built_up_area']?>
                  <span style="text-transform:capitalize; color:blue;"><SUP>2</SUP> Feet</span></span>
                  <input type="hidden" name="booking_property_super_built_up_area" id="booking_property_super_built_up_area"  style="width:80px;"  value="<?php echo $BOOKING_ROW['booking_property_super_built_up_area']?>" required='required'/></td>
                <td><div align="left"><span style="font-size:14px;"> =&nbsp;
                    <input type="text" name="booking_property_construction_price_super_built_up" id="booking_property_construction_price_super_built_up"  placeholder="Construction Price" value="<?php echo $BOOKING_ROW['booking_property_construction_super_build_up_price']?>" style="width:80px; text-align:right;" required='required' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_construction_price_super_built_up');" readonly="readonly"/>
                    </span></div></td>
                <td colspan="2"><span style="color:GREEN">CONSTRUCTION&nbsp;PRICE</span></td>
              </tr>
               <tr>
          
          <td colspan="7"><hr /></td>
          </tr>
              <tr style=" background:#D5FFFF;">
                <td style="color:BLUE;"><span style="color:RED; font-size:14px;">TOTAL MRP</span></td>
                <td width="11%"><span style="font-size:14px;">
                  <input type="text" name="booking_property_mrp" id="booking_property_mrp"  placeholder="TOTAL MRP" style="text-align:right; width:80px;  color:red; font-weight:bolder; font-size:14px;" required='required' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_mrp');" readonly="readonly" value='<?php echo $BOOKING_ROW['booking_property_mrp']?>'/>
                  </span></td>
                <td width="22%"><div style="width:90px">
           <label><input type="checkbox" value="1" id="fixed_rate" name="fixed_rate" onclick="FixedRateCheck();" <?php CheckedCheckBox($BOOKING_ROW['fixed_rate'],1)?>/>Fixed&nbsp;Rate</label>
         </div></td>
                <td><input type="text" name="fixed_mrp" id="fixed_mrp"  placeholder="FIXED MRP" value="<?php echo $BOOKING_ROW['fixed_mrp']?>" style="text-align:right; width:110px;  color:red; font-weight:bolder; font-size:14px;" readonly="readonly" required='required' <?php OnlyFloat()?> onchange="FixedRateCheck()" onkeyup="FixedRateCheck()"/></td>
         <td width="74" style="line-height:12px;">Agreement&nbsp;Cost</td>
         <td width="104">
        
        <input type="text" name="govt_rate" placeholder="Govt. Rate"  value="<?php echo $BOOKING_ROW['govt_rate']?>" id="govt_rate" style="text-align:right;width:110px;" required='required'/>
         </td>
              </tr>
              <tr>
                <td colspan="6" style="color:blue"><hr /></td>
              </tr>
              <tr>
                <td colspan="6"><h4>Discount Calculation (<span class="Required">If Any</span>)</h4></td>
              </tr>
              <tr>
                <td>DISCOUNT</td>
                <td colspan="5"><input type="text" name="booking_property_discount" placeholder="Discount" value="<?php echo $BOOKING_ROW['booking_property_discount']?>" id="booking_property_discount" style="text-align:right; width:120px;" required='required'  onchange="CalcDiscount();" onkeyup="CalcDiscount();" maxlength="18" <?php OnlyPercent(); ?>/></td>
              </tr>
              <tr>
                <td>DISCOUNT AMOUNT</td>
                <td colspan="2"><input type="text" name="booking_property_discount_amount" placeholder="Discount Amount" value="<?php echo $BOOKING_ROW['booking_property_discount_amount']?>" id="booking_property_discount_amount" style="text-align:right;width:120px;" required='required' readonly="readonly"/></td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td style="color:#FF0000">DISCOUNTED MRP</td>
                <td colspan="2"><input type="text" name="booking_property_discounted_mrp" placeholder="Discounted MRP" value="<?php echo $BOOKING_ROW['booking_property_discounted_mrp']?>" id="booking_property_discounted_mrp" style="text-align:right;width:120px; color:white; background:maroon;" required='required' <?php OnlyFloat()?> readonly="readonly"/></td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="6" style="color:#FF0000"><hr /></td>
              </tr>
              
      <tr>
         
          <td style="line-height:13px;">BOOKING REMARKS</td>
          <td colspan="5">
          <input type="text" name="booking_remark" id="booking_remark" placeholder="BOOKING REMARKS IF ANY " maxlength="50" style="WIDTH:550PX;" value="<?php echo $BOOKING_ROW['booking_remark']?>"/>
          </td>
        </tr>
        <tr>
        
          <td>PAYMENT MODE</td>
          <td colspan="2"><input type="text" name="booking_payment_mode" id="booking_payment_mode" placeholder="LOAN/OWN" maxlength="25" value="<?php echo $BOOKING_ROW['booking_payment_mode']?>"/></td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
         
          <td style="line-height:13px;">BANK NAME            (<span class="Required"> if by loan</span>)</td>
          <td colspan="2"><input type="text" name="booking_payment_mode_bank" id="booking_payment_mode_bank" placeholder="LOAN BY BANK" maxlength="50" value="<?php echo $BOOKING_ROW['booking_payment_mode_bank']?>"/></td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="4"><div align="center">
              <input type="submit" name="Save" id="Save" value="Save Payment Details" <?php Confirm("Are You Sure ? Save Booking Details ?"); ?>/>
              <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
            </div></td>
          <td width="5" style="text-align:RIGHT">&nbsp;</td>
        </tr>
      </form>
    </table>
  </fieldset>
</center>
<script>
function ZeroInitialize(ID)
{
	val=document.getElementById(ID).value
	if(val=="" || val==null)
	{
		document.getElementById(ID).value="0";
	}
}
function CalcRate()
{
	TOTAL_MRP=document.getElementById('booking_property_mrp');
	
	PLOT_RATE=document.getElementById('booking_property_plot_area_rate');
	CONST_RATE_BUILT=document.getElementById('booking_property_built_up_area_rate');
	CONST_RATE_SUPER_BUILT=document.getElementById('booking_property_super_built_up_rate');
	
	PLOT_PRICE=document.getElementById('booking_property_plot_price');
	CONST_PRICE_BUILT=document.getElementById('booking_property_construction_price_built_up');
	CONST_PRICE_SUPER_BUILT=document.getElementById('booking_property_construction_price_super_built_up');
	
	/*==============(PLOT PRICE)==============================*/
	PLOT_PRICE.value=(parseFloat(PLOT_RATE.value)*parseFloat('<?php echo $BOOKING_ROW['booking_property_plot_area']?>')).toFixed(2);
	
	/*==============(CONSTRUCTION PRICE)==============================*/
	CONST_PRICE_BUILT.value=(parseFloat(CONST_RATE_BUILT.value)*parseFloat('<?php echo $BOOKING_ROW['booking_property_built_up_area']?>')).toFixed(2);
	CONST_PRICE_SUPER_BUILT.value=(parseFloat(CONST_RATE_SUPER_BUILT.value)*parseFloat('<?php echo $BOOKING_ROW['booking_property_super_built_up_area']?>')).toFixed(2);	
	/*==============(TOTAL MRP)==============================*/
	TOTAL_MRP.value=(parseFloat(PLOT_PRICE.value)+parseFloat(CONST_PRICE_BUILT.value)+parseFloat(CONST_PRICE_SUPER_BUILT.value)).toFixed(2);
	CalcDiscount();
}


function CalcDiscount()
{
	var MRP=document.getElementById('booking_property_mrp');
	var DIS=document.getElementById('booking_property_discount');
	var DISCOUNT_AMOUNT=document.getElementById('booking_property_discount_amount');
	var DISCOUNTED_AMOUNT=document.getElementById('booking_property_discounted_mrp');
	if(isNaN(DIS.value))
	{
		var DISC_PERCENT=DIS.value;
		var PERCENT=DISC_PERCENT.split("%");
		PERCENT=PERCENT[0];
		
		DISCOUNT_AMOUNT.value=(parseFloat(MRP.value)*parseFloat(PERCENT)/100).toFixed(2);
		DISCOUNTED_AMOUNT.value=(parseFloat(MRP.value)-parseFloat(DISCOUNT_AMOUNT.value)).toFixed(2);
	}
	else
	{
		DISCOUNT_AMOUNT.value=parseFloat(DIS.value).toFixed(2);
		DISCOUNTED_AMOUNT.value=(parseFloat(MRP.value)-parseFloat(DIS.value)).toFixed(2);
	}
}


function FixedRateCheck()
{
	var FixedRate=document.getElementById('fixed_rate');	
	var fixed_mrp=document.getElementById('fixed_mrp');
	var mrp=document.getElementById('booking_property_mrp');
	var govt_rate=document.getElementById('govt_rate');
	
	if(isNaN(parseFloat(fixed_mrp.value)))
	{
		fixed_mrp.value=0;
	}
	
	var p_r=document.getElementById('booking_property_plot_area_rate');
	var bua_r=document.getElementById('booking_property_built_up_area_rate');
	var plot_r=document.getElementById('booking_property_super_built_up_rate');
	
	var plot_price=document.getElementById('booking_property_plot_price');
	var plot_built_price=document.getElementById('booking_property_construction_price_built_up');
	var plot_sup_price=document.getElementById('booking_property_construction_price_super_built_up');


	if(FixedRate.checked!="")
	{
	 
	<?php 	$cnt=0;
	if($BOOKING_ROW['booking_property_plot_area']>0 ||  $BOOKING_ROW['booking_property_plot_area']<0) { $cnt++;}
	if($BOOKING_ROW['booking_property_built_up_area']>0 ||  $BOOKING_ROW['booking_property_built_up_area']<0) { $cnt++;}
	if($BOOKING_ROW['booking_property_super_built_up_area']>0 ||  $BOOKING_ROW['booking_property_super_built_up_area']<0) { $cnt++;}
	?>
	var cnt=parseInt(<?php echo $cnt?>);
	
		/*p_r.readOnly="readOnly";
		bua_r.readOnly="readOnly";
		plot_r.readOnly="readOnly";*/
		fixed_mrp.readOnly="";
		fixed_mrp.focus();
	
	var fix=fixed_mrp.value;
	
	if(cnt>0) 
	{ 
	 fix=(fix/cnt).toFixed(2);
	}
	
	 
	  p_r.value=0;
	  plot_price.value=0;
	
	
	
	  bua_r.value=0;
	  plot_built_price.value=0;
	

	
	  plot_r.value=0;
	  plot_sup_price.value=0;
	
	
	mrp.value=fixed_mrp.value;	
	govt_rate.value=fixed_mrp.value;	
	}	
	else
	{
		p_r.readOnly="";
		bua_r.readOnly="";
		plot_r.readOnly="";		
		fixed_mrp.readOnly="readOnly";				
		//============( Set Default )===============================
			p_r.value="<?php echo $plot?>"; 		plot_price.value=<?php echo $plot_r?>;
			bua_r.value="<?php echo $built?>";      plot_built_price.value=<?php echo $built_r?>;
			plot_r.value="<?php echo $super?>";     plot_sup_price.value=<?php echo $super_r?>;
			
			mrp.value='<?php echo $BOOKING_ROW['booking_property_mrp']?>';
			govt_rate.value='<?php echo $BOOKING_ROW['govt_rate']?>';
			
	}
	CalcDiscount();
}
</script>