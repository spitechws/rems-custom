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

$PROPERTY_ROW=$DBOBJ->GetRow("tbl_property","property_id",$_GET[md5("booking_property_id")]);
$EXP_DAYS=$DBOBJ->ConvertToText("tbl_project_details","project_property_type_id='".$PROPERTY_ROW['property_type_id']."' and project_id","project_no_of_date_to_tokent_expiry",$_GET[md5("booking_project_id")]);




$PROJECT_ID=$_GET[md5('booking_project_id')];
$PROPERTY_ID=$_GET[md5('booking_property_id')];
$PROPERTY_TYPE=$PROPERTY_ROW['property_type_id'];

if(isset($_POST['Save']) && $PROPERTY_ROW['property_status']=="Available" && $_POST["booking_advisor_id"]>0)
{
	//===================(GENERATE PARENT STRING)===========================
	 	$ADVISOR_LEVEL=$DBOBJ->ConvertToText("tbl_advisor", "advisor_id","advisor_level_id",$_POST['booking_advisor_id']);
		$ADVISOR_PERCENT=$DBOBJ->ConvertToText("tbl_setting_advisor_level_with_property_type", "project_id='$PROJECT_ID' and level_id='$ADVISOR_LEVEL' AND property_type_id","commission_percent",$PROPERTY_TYPE);
		$DIFF_PERCENT=$ADVISOR_PERCENT;
		
		//==============(PARENT'S STRING)============================================
			$STRING=$DBOBJ->GetAdvisorParents($_POST["booking_advisor_id"],$PROPERTY_TYPE,$PROJECT_ID);
			$PARENT_STRING=$STRING['PARENT'];
			$PARENT_LEVEL=$STRING['LEVEL'];
			$PARENT_LEVEL_PERCENT=$STRING['PERCENT'];
			$PARENT_LEVEL_PERCENT_DIFF=$STRING['DIFF'];
		
	//=======================================================================
	
	  $VOUCHER_AMOUNT=$_POST['payment_amount'];
	  $PROPERTY_STATUS="TempBooked";
	  $payment_heading="TOKEN";
	  $payment_head="TKN";
	   if($_POST['booking_type']=="Permanent") 
	   { 
	     $PROPERTY_STATUS="Booked"; 
		 $payment_heading="DOWN PAYMENT";
		 $payment_head="DP";
		 
		 $BOOKING_COMMISSION_STATUS="1";//==========(COMMISSION DISTRIBUTED BECAUSE OF DOWNPAYMENT)=================
	   }
	   else
	   {
		   $BOOKING_COMMISSION_STATUS="0";//==========(COMMISSION NOT DISTRIBUTED KEPT FOR NEXT DOWNPAYMENT/INSTALLMENT)=================
	   }
	//========================( PROPERTY TABLE)==============================================================	
        $FIELDS=array("property_status");
		$VALUES=array($PROPERTY_STATUS);		
		$DBOBJ->Update("tbl_property",$FIELDS,$VALUES,"property_id",$_GET[md5('booking_property_id')],0);
	//========================(BOOKING TABLE)=================================================================
	$fixed_rate=0;
	if(isset($_POST['fixed_rate']))
	{
		$fixed_rate=1;
	}
	  $FIELDS=array("booking_type", 
	  			 "booking_commission_status",
				 "booking_particular", 				
				 "booking_date", 
				 "booking_token_exp_date", 
				 "booking_project_id", 
				 "booking_property_id", 				
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
				 "fixed_rate",
				 "booking_remark",
				 "booking_cancel_status", 
				 "booking_cancel_details", 
				 "booking_payment_mode", 
				 "booking_payment_mode_bank", 
				 "booking_registry_status", 
				 "booking_mutation_status", 
				 "created_details", 
				 "edited_details",
				 "approved",
				 "next_payment_date");	
				   
	  $VALUES=array($_POST["booking_type"], 
	  			 $_POST["booking_commission_status"],
				 $payment_heading, 				
				 $_POST["booking_date"], 				
				 ReceiveDate("booking_token_exp_date","POST"), 			
				 $_GET[md5("booking_project_id")], 
				 $_GET[md5("booking_property_id")], 				
				 $_GET[md5("booking_customer_id")],  
				 "ADVISOR", 
				 $_POST["booking_advisor_id"], 
				 $ADVISOR_LEVEL, 
				 $ADVISOR_PERCENT, 
				 $PARENT_STRING,
				 $PARENT_LEVEL,
				 $PARENT_LEVEL_PERCENT,
				 $PARENT_LEVEL_PERCENT_DIFF,
				 $_POST["booking_property_plot_area"], 
				 $_POST["booking_property_plot_area_rate"], 
				 $_POST["booking_property_built_up_area"], 
				 $_POST["booking_property_built_up_area_rate"], 
				 $_POST["booking_property_super_built_up_area"], 
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
				 $fixed_rate,
				 $_POST["booking_remark"],
				 "", 
				 "", 
				 $_POST["booking_payment_mode"], 
				 $_POST["booking_payment_mode_bank"], 
				 "", 
				 "", 
				  $Mess=CreatedEditedByUserMessage(),
				  $Mess,
				  0,
				    ReceiveDate("next_payment_date","POST"),
				  );
					
		$DBOBJ->Insert("tbl_property_booking",$FIELDS,$VALUES,0);
		$MAX_ID=$DBOBJ->MaxID("tbl_property_booking","booking_id");
		
		$ORDER_NO="ODR".str_pad($MAX_ID,4,"0",STR_PAD_LEFT);
		
		$FIELDS=array("booking_order_no");
		$VALUES=array($ORDER_NO);
		
		$DBOBJ->Update("tbl_property_booking",$FIELDS,$VALUES,"booking_id",$MAX_ID,0);
//========================( PAYMENT TABLE)=================================================================
        $FIELDS=array("payment_booking_id" ,	"payment_order_no",				
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
					"payment_first_payment",
					"approved");	
				   
	    $VALUES=array($MAX_ID,$ORDER_NO,		
					$payment_heading,
					 $_GET[md5("booking_project_id")], 
				     $_GET[md5("booking_property_id")], 				
				     $_GET[md5("booking_customer_id")],  
					"1",
					$_POST["payment_amount"], 
					$_POST["booking_date"], 
					"ADVISOR",
					$_POST["booking_advisor_id"],
					$_POST["payment_mode"],
					$_POST["payment_mode_no"],
					$_POST["payment_mode_bank"],
					$_POST["payment_mode_date"], 
					$_POST["booking_remark"],
				  $Mess=CreatedEditedByUserMessage(),
				  $Mess,
				  "1",
				  0);
					
		$DBOBJ->Insert("tbl_property_booking_payments",$FIELDS,$VALUES,0);
		$MAX_PAYMENT_ID=$DBOBJ->MaxID("tbl_property_booking_payments","payment_id");
		
		//==============( GENERATE VOUCHER NO )===============================
		$VOUCHER_NO=str_pad($MAX_ID,4,"0",STR_PAD_LEFT)."/".$payment_head."/".str_pad($MAX_PAYMENT_ID,4,"0",STR_PAD_LEFT);
		//==============( UPDATE VOUCHER NO IN PAYMENT)===============================
		$FIELDS=array("payment_voucher_no");
		$VALUES=array($VOUCHER_NO);		
		$DBOBJ->Update("tbl_property_booking_payments",$FIELDS,$VALUES,"payment_id",$MAX_PAYMENT_ID,0);
		//==============( UPDATE VOUCHER NO IN BOOKING)===============================
		$FIELDS=array("booking_voucher_no");
		$VALUES=array($VOUCHER_NO);		
	    $DBOBJ->Update("tbl_property_booking",$FIELDS,$VALUES,"booking_id",$MAX_ID,0);

//===============( EXTRA CHARGES )================================
$FIELDS=array("booking_id","charge_particular","charge_amount","charge_paid");
for($i=1;$i<7;$i++) 
{
	if(trim($_POST["extra_charge_".$i])!="")
	{
	  $VALUES=array($MAX_ID,$_POST["extra_charge_".$i],$_POST["extra_charge_amount_".$i],'0');	
	  $DBOBJ->Insert("tbl_property_booking_extra_charge",$FIELDS,$VALUES,0);
	}
}
		
		
		
		
  /* if($_POST['booking_type']=="Permanent")
   {*/
      //========================( TDS CALCULATION )===========================================================
		$TDS_Q=@mysqli_query($_SESSION['CONN'],"SELECT tds FROM tbl_setting_tds");
        $TDS_ROW=@mysqli_fetch_assoc($TDS_Q);
		$TDS=$TDS_ROW['tds'];

     //========================( COMMISSION TABLE)==============================================================
         $FIELDS=array("commission_order_no" ,
						"commission_voucher_no" ,
						"commission_project_id" ,
						"commission_property_id" ,
						"commission_property_type" ,
						"commission_particular" ,
						"commission_date" ,
						"commission_voucher_date",
						"commission_customer_id",
						"commission_advisor_id" ,
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
        //=========================(COMMISSION FOR FIRST Associate)==========================================
       
		
        $COMMISSION_AMOUNT=$VOUCHER_AMOUNT*$ADVISOR_PERCENT/100;		
	   
		$VALUES=array(
						$ORDER_NO,
						$VOUCHER_NO ,
						$PROJECT_ID ,
						$PROPERTY_ID ,
						$PROPERTY_TYPE ,
						$payment_heading ,
						$_POST['booking_date'] ,
						$_POST['booking_date'],
						$_GET[md5("booking_customer_id")],
						$_POST["booking_advisor_id"] ,
						$ADVISOR_LEVEL ,
						$ADVISOR_LEVEL ,
						$DIFF_PERCENT ,
						$DIFF_PERCENT ,
						$VOUCHER_AMOUNT ,
						$COMMISSION_AMOUNT ,
						$TDS,
						$TDS_AMOUNT=$TDS*$COMMISSION_AMOUNT/100,
						$COMMISSION_AMOUNT-$TDS_AMOUNT,
						$_POST['booking_advisor_id'] ,
						"SELF",
						0);		
		$DBOBJ->Insert("tbl_advisor_commission",$FIELDS,$VALUES,0);
		
		//=========================(COMMISSION FOR PARENTS/SPONSOR)==========================================
		$CHIELD=$_POST['booking_advisor_id'];
	    $CURRENT_ADVISOR=$CHIELD;
	    $CHIELD_ADVISOR_PERCENT=$DIFF_PERCENT;
		
		while($CURRENT_ADVISOR>0)
		{
			
		    $CURRENT_ADVISOR=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_sponsor",$CHIELD);			   		
			$CHIELD=$CURRENT_ADVISOR;		
			if($CURRENT_ADVISOR=="" || $CURRENT_ADVISOR=="0" || !$CURRENT_ADVISOR || $CURRENT_ADVISOR==NULL)
			{
				echo "if";
				$CURRENT_ADVISOR=0;
				break;
				
			}
			
			else
			{
				//echo "else";
				//echo "current_advisor=".$CURRENT_ADVISOR;
				 $ADVISOR_LEVEL=$DBOBJ->ConvertToText("tbl_advisor", "advisor_id","advisor_level_id",$CURRENT_ADVISOR);
				//echo "current_level=".$ADVISOR_LEVEL; 
				 $ADVISOR_PERCENT=$DBOBJ->ConvertToText("tbl_setting_advisor_level_with_property_type", "project_id='$PROJECT_ID' and level_id='$ADVISOR_LEVEL' AND property_type_id","commission_percent",$PROPERTY_TYPE);
				//echo "percent=".$ADVISOR_PERCENT; 
				$DIFF_PERCENT=$ADVISOR_PERCENT-$CHIELD_ADVISOR_PERCENT;
			    //Zecho "diffper=".$DIFF_PERCENT; 
				$COMMISSION_AMOUNT=0;
				
				if($DIFF_PERCENT>0)
				{					
					$COMMISSION_AMOUNT=$VOUCHER_AMOUNT*$DIFF_PERCENT/100;	
					$CHIELD_ADVISOR_PERCENT=$ADVISOR_PERCENT;	
				}
				else
				{
					$DIFF_PERCENT=0;$COMMISSION_AMOUNT=0;
					$CHIELD_ADVISOR_PERCENT=$CHIELD_ADVISOR_PERCENT;
				}
				    
	   
		$VALUES=array($ORDER_NO,
						$VOUCHER_NO ,
						$PROJECT_ID ,
						$PROPERTY_ID ,
						$PROPERTY_TYPE ,
						$payment_heading ,
						$_POST['booking_date'] ,
						$_POST['booking_date'],
						$_GET[md5("booking_customer_id")],
						$CURRENT_ADVISOR ,
						$ADVISOR_LEVEL ,
						$ADVISOR_LEVEL ,
						$ADVISOR_PERCENT ,
						$DIFF_PERCENT ,
						$VOUCHER_AMOUNT ,
						$COMMISSION_AMOUNT ,
						$TDS,
						$TDS_AMOUNT=$TDS*$COMMISSION_AMOUNT/100,
						$COMMISSION_AMOUNT-$TDS_AMOUNT,
						$_POST['booking_advisor_id'] ,
						"REF",
						0);		
		$DBOBJ->Insert("tbl_advisor_commission",$FIELDS,$VALUES,0);
	
			}
			
		}
		
	 //========================(BOOKING TABLE)=================================================================
	$FIELD_B=array("booking_commission_status");
	$VALUE_B=array("1");		
	$DBOBJ->Update("tbl_property_booking",$FIELD_B,$VALUE_B,"booking_id",$MAX_ID,0);	
	
  // }
//=================( ENTRY IN USER ACTION TABLE )============================================================		
$DBOBJ->UserAction("PROPERTY BOOKED", "ORDER NO ".$ORDER_NO.", AMOUNT : ".$VOUCHER_AMOUNT);			

//========================( MESSAGE AND ACTION )==============================================================
if(isset($_POST['sms'])) { $msg="&".md5('send_sms')."=".md5('send_sms'); }
header("location:Project_Property_Booking_Next.php?".md5("payment_id")."=".$MAX_PAYMENT_ID.$msg);
}


//=======================(DEFAULT RATE)==========================

	 
	$plot=$DBOBJ->ConvertToText("tbl_project_property_type_rate","project_id='".$PROJECT_ID."' AND property_type_id","plot_area_rate",$PROPERTY_TYPE);
	$plot_r=$plot*$PROPERTY_ROW['property_plot_area'];
	
	$built=$DBOBJ->ConvertToText("tbl_project_property_type_rate","project_id='".$PROJECT_ID."' AND property_type_id","built_up_area_rate",$PROPERTY_TYPE);	 
	$built_r=$built*$PROPERTY_ROW['property_built_up_area'];
	
$super=$DBOBJ->ConvertToText("tbl_project_property_type_rate","project_id='".$PROJECT_ID."' AND property_type_id","super_built_up_area_rate",$PROPERTY_TYPE);
$super_r=$super*$PROPERTY_ROW['property_super_built_up_area'];



if($plot=="") 	{ $plot=0;  }
if($built=="")   { $built=0; }
if($super=="")   { $super=0; }

if($plot_r=="") 	{ $plot_r=0;  }
if($built_r=="")   { $built_r=0; }
if($super_r=="")   { $super_r=0; }


$mrp=$plot_r+$built_r+$super_r;
	 
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>
#SmallTable tr th { height:20px !important; font-size:9px; }
#SmallTable tr td input { height:18px; font-size:10px; line-height:normal; margin:1px; }
</style>
<center>
<h1><img src="../SpitechImages/PropertyBook.png" width="31" height="32" />Project  : <span>Property Booking</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">
    <center>
  
   <fieldset style="width:850px; margin:0px; padding:0px;">
   <legend>Booking Form</legend>
    <?php MessageError(); ?>
<table width="93%" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">
  
 
    <tr>
      <td colspan="7"><H4>&nbsp;</H4></td>
      </tr>
   <form name="PropertyForm" id="PropertyForm" method="get" enctype="multipart/form-data" >    
    <tr>
      <td width="11">&nbsp;</td>
      <td width="141">PROJECT<b class="Required"><b class="Required"></b></b></td>
      <td colspan="2">
        
        <select id="<?php echo md5("booking_project_id"); ?>" name="<?php echo md5("booking_project_id"); ?>" required="" onchange="PropertyForm.submit();">
          <option value="">SELECT PROJECT...</option>
          <?php 
             $PROJECT_Q=@mysqli_query($_SESSION['CONN'],"select project_id, project_name from tbl_project ");
             while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
             {?>
          <option value="<?php echo $PROJECT_ROWS['project_id']?>" <?php SelectedSelect($PROJECT_ROWS['project_id'],$_GET[md5("booking_project_id")]);?>>
            <?php echo $PROJECT_ROWS['project_name']?>
            </option>
          <?php } ?>
          </select>
        
      </td>
      <td width="140" rowspan="5" style="vertical-align:top; text-align:center;line-height:13px;">
        <?php 
		$customer_photo=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_photo",$_GET[md5('booking_customer_id')]);
		$ACTUAL_PHOTO="../SpitechUploads/customer/profile_photo/".$customer_photo;  
		  $exist=file_exists($ACTUAL_PHOTO);
		    if($exist!="1" || $customer_photo=="") { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }
		    if(!$_GET[md5('booking_customer_id')]) { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Customer" width="107" height="107" id="imgBorder"/><br />
        <?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$_GET[md5('booking_customer_id')]);?>
      </td>
      <td colspan="2" rowspan="5" style="vertical-align:top; text-align:center; line-height:13px;">
      <div id="AdvisorPhoto">
       <img src="../SpitechImages/Advisor.png" alt="<?php echo advisor_title?>" width="107" height="107"  id="imgBorder"/>
        <br /><?php echo advisor_title?>
      </div>
      </td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>PROPERTY<b class="Required"></b></td>
      <td colspan="2" ><select id="<?php echo md5("booking_property_id"); ?>" name="<?php echo md5("booking_property_id"); ?>" required="" onchange="PropertyForm.submit();">
        <option value="">SELECT PROPERTY...</option>
        <?php 
		  $PROPERTY_Q="select property_id, property_no  from tbl_property where property_project_id='".$_GET[md5('booking_project_id')]."' and property_status='Available' order by  property_id, property_no  ";
             $PROPERTY_Q=@mysqli_query($_SESSION['CONN'],$PROPERTY_Q);
             while($PROPERTY_ROWS=@mysqli_fetch_assoc($PROPERTY_Q)) 
             {?>
        <option value="<?php echo $PROPERTY_ROWS['property_id']?>" <?php SelectedSelect($PROPERTY_ROWS['property_id'],$_GET[md5('booking_property_id')] ); ?>>
          <?php echo $PROPERTY_ROWS['property_no']?>
          </option>
        <?php } ?>
      </select></td>
      </tr>
      
       <tr>
          <td>&nbsp;</td>
          <td>booking date</td>
          <td colspan="2">
            <?php 
		  if(isset($_GET['booking_date_D']) ) { $BOOKING_DATE=ReceiveDate("booking_date","GET"); }
		  else {$BOOKING_DATE=date('Y-m-d'); }
		  DateInput("booking_date",$BOOKING_DATE,"PropertyForm.submit();"); 
		  
		  ?></td>
          </tr>
    <tr>
      <td>&nbsp;</td>
      <td>CUSTOMER</td>
      <td colspan="2" ><span style="vertical-align:top;">
        <select id="<?php echo md5("booking_customer_id"); ?>" name="<?php echo md5("booking_customer_id"); ?>"  required="" onchange="PropertyForm.submit();">
          <option value="">SELECT A CUSTOMER...</option>
          <?php   $CUSTOMER_Q="SELECT customer_id, customer_code, customer_name FROM tbl_customer ORDER BY customer_name";
			   $CUSTOMER_Q=@mysqli_query($_SESSION['CONN'],$CUSTOMER_Q);
			   while($CUSTOMER_ROWS=@mysqli_fetch_assoc($CUSTOMER_Q)) {?>
          <option value="<?php echo $CUSTOMER_ROWS['customer_id'];?>" <?php SelectedSelect($CUSTOMER_ROWS['customer_id'], $_GET[md5('booking_customer_id')]); ?> >
            <?php echo $CUSTOMER_ROWS['customer_name']." [".$CUSTOMER_ROWS['customer_code']." ]";?>
            </option>
          <?php } ?>
          </select>
      </span></td>
      </tr>
       
      
      </form>
      
      <?php if($_GET[md5("booking_project_id")]>0 && $_GET[md5("booking_property_id")]>0 && $_GET[md5("booking_customer_id")]>0) 
	  {
		  
		  if($PROPERTY_ROW['property_status']=="Available") { ?>
      <form name="PropertyBookingForm" id="PropertyBookingForm" method="post" enctype="multipart/form-data" >  
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;"><?php echo advisor_title?></td>
      <td colspan="2" style="vertical-align:top;">
        
        <select id="booking_advisor_id" name="booking_advisor_id" onchange="GetPage('GetAdvisorPhoto.php?advisor_id='+this.value,'AdvisorPhoto');" required="" >
          <option value="">SELECT <?php echo advisor_title?>...</option>
          <?php 		$ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			    $ADVISOR_Q=@mysqli_query($_SESSION['CONN'],$ADVISOR_Q);
			   while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_Q)) {?>
          <option value="<?php echo $ADVISOR_ROWS['advisor_id'];?>"> <?php echo $ADVISOR_ROWS['advisor_name']." [".$ADVISOR_ROWS['advisor_code']." ]";?> </option>
          <?php } ?>
        </select></td>
     
   
      </tr>
      
       <tr>
         <td colspan="4"><H4>Price Calculation</H4></td>
         <td colspan="3" rowspan="3" style="text-align:center;">
           
           <?php 
		   $PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$_GET[md5('booking_project_id')]);
		   $project_photo=$DBOBJ->ConvertToText("tbl_project","project_id","project_photo",$_GET[md5('booking_project_id')]);
		   $ACTUAL_PHOTO="../SpitechUploads/project/project_photo/".$project_photo;
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $project_photo=="") { $ACTUAL_PHOTO="../SpitechImages/Project.png"; }
		 ?><img src="<?php echo $ACTUAL_PHOTO;?>" alt="Project" width="280" height="60" id="imgBorder"/>  
         <br /><?php echo $PROJECT_NAME;?></td>
         </tr>
   
       <tr>
         <td>&nbsp;</td>
         <td>project</td>
         <td colspan="2" style="color:GREEN; font-size:14PX;"><?php echo $PROJECT_NAME; ?></td>
         </tr>
       <tr>
         <td>&nbsp;</td>
         <td>PROPERTY NO<span style="line-height:13px;text-align:justify;"><b class="Required"></b></span></td>
         <td colspan="2" style="color:RED; font-size:14PX;">
           <span style="color:blue; font-size:14PX;"><?php echo $DBOBJ->ConvertToText("tbl_setting_property_type","property_type_id","property_type",$PROPERTY_ROW['property_type_id']); ?></span> /
           <?php echo $PROPERTY_ROW['property_no']; ?>
         </td>
         </tr>
       <tr>
         <td>&nbsp;</td>
         <td colspan="6" style="color:blue"><hr /></td>
         </tr>
       <tr>
         <td>&nbsp;</td>
         <td style="color:blue">PLOT RATE&nbsp;/&nbsp;<span style="color:red;"><span style="text-transform:capitalize; "><sup>2</sup> Feet</span></span></td>
         <td colspan="2" >
         <input type="text" name="booking_property_plot_area_rate" placeholder="Rate/Square Feet" value="<?php echo $plot?>" id="booking_property_plot_area_rate" style="width:110px; text-align:right;" required='' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_plot_area_rate');CalcRate();" onkeyup="CalcRate();"/>
         
         &nbsp;X&nbsp;<span style="color:red;"><?php echo $PROPERTY_ROW['property_plot_area']?>
         <span style="text-transform:capitalize; color:blue;"><SUP>2</SUP> Feet</span></span>
         <input type="hidden" name="booking_property_plot_area" id="booking_property_plot_area" style="width:110px;" required='required' value="<?php echo $PROPERTY_ROW['property_plot_area']?>"/></td>
         <td><div align="left" style="width:130PX;font-size:14px;">
           =&nbsp;<input type="text" name="booking_property_plot_price" id="booking_property_plot_price"  placeholder="Plot Price" value="<?php echo $plot_r?>" style="width:110px; text-align:right;" required='required' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_plot_price');" readonly="readonly"/>
         </div></td>
         <td colspan="2"><span style="color:BLUE">PLOT&nbsp;PRICE</span></td>
       </tr>
       
        <tr>
         <td>&nbsp;</td>
         <td style="color:green">BUILT up RATE&nbsp;/&nbsp;<span style="color:blue"><span style="color:red;"><span style="text-transform:capitalize; ;"><sup>2</sup> Feet</span></span></span></td>
         <td colspan="2">
         <input type="text" name="booking_property_built_up_area_rate" id="booking_property_built_up_area_rate" placeholder="Rate/Square Feet" value="<?php echo $built?>"  style="width:110px; text-align:right;" required='' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_built_up_area_rate');CalcRate();" onkeyup="CalcRate();"/>  				         &nbsp;X&nbsp;<span style="color:red;"><?php echo $PROPERTY_ROW['property_built_up_area']?>
         <span style="text-transform:capitalize; color:blue;"><SUP>2</SUP> Feet</span></span>
         <input type="hidden" name="booking_property_built_up_area" id="booking_property_built_up_area" value="<?php echo $PROPERTY_ROW['property_built_up_area']?>"  style="width:110px;" required='required'/></td>
         <td><div align="left" style="font-size:14px;">
           =&nbsp;<input type="text" name="booking_property_construction_price_built_up" id="booking_property_construction_price_built_up"  placeholder="Construction Price" value="<?php echo $built_r?>" style="width:110px; text-align:right;" required='required' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_construction_price');" readonly="readonly"/>
         </div></td>
         <td colspan="2"><span style="color:GREEN">CONSTRUCTION&nbsp;PRICE</span></td>
       </tr>
        <tr>
         <td>&nbsp;</td>
         <td style="color:green">SUPER&nbsp;BUILT&nbsp;UP&nbsp;RATE&nbsp;/&nbsp;<span style="color:blue"><span style="color:red;"><span style="text-transform:capitalize; "><sup>2</sup>&nbsp;Feet</span></span></span></td>
         <td colspan="2">
         <input type="text" name="booking_property_super_built_up_rate" id="booking_property_super_built_up_rate"  placeholder="Rate/Square Feet" value="<?php echo $super?>" style="width:110px; text-align:right;" required='' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_super_built_up_rate');CalcRate();" onkeyup="CalcRate();"/>
           &nbsp;X&nbsp;<span style="color:red;"><?php echo $PROPERTY_ROW['property_super_built_up_area']?> 
           <span style="text-transform:capitalize; color:blue;"><SUP>2</SUP> Feet</span></span>
           
           <input type="hidden" name="booking_property_super_built_up_area" id="booking_property_super_built_up_area"  style="width:110px;"  value="<?php echo $PROPERTY_ROW['property_super_built_up_area']?>" required='required'/></td>
         <td><div align="left" style="font-size:14px;">
           =&nbsp;<input type="text" name="booking_property_construction_price_super_built_up" id="booking_property_construction_price_super_built_up"  placeholder="Construction Price" value="<?php echo $super_r?>"  style="width:110px; text-align:right;" required='required' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_construction_price');" readonly="readonly"/>
         </div></td>
         <td colspan="2"><span style="color:GREEN">CONSTRUCTION&nbsp;PRICE</span></td>
       </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="6"><hr /></td>
          </tr>
        <tr>
         <td>&nbsp;</td>
         <td style="color:RED;background:#D5FFFF;font-size:14px;">TOTAL MRP</td>
         <td width="152" style=" background:#D5FFFF;">
           
           <input type="text" name="booking_property_mrp" id="booking_property_mrp"  placeholder="TOTAL MRP" value="<?php echo $mrp?>" style="text-align:right; width:110px;  color:red; font-weight:bolder; font-size:14px;" required='required' <?php OnlyFloat()?> onchange="ZeroInitialize('booking_property_mrp');" readonly="readonly"/>
           
         </td>
         <td width="97" style=" line-height:12px; background:#D5FFFF;">
         <div style="width:90px">
           <label><input type="checkbox" value="Fixed Rate" id="fixed_rate" name="fixed_rate" onclick="FixedRateCheck();" />Fixed&nbsp;Rate</label>
         </div>
         </td>
         <td style="background:#D5FFFF;"><input type="text" name="fixed_mrp" id="fixed_mrp"  placeholder="FIXED MRP" value="<?php echo $mrp?>" style="text-align:right; width:110px;  color:red; font-weight:bolder; font-size:14px;" readonly="readonly" required='required' <?php OnlyFloat()?> onchange="FixedRateCheck()" onkeyup="FixedRateCheck()"/></td>
         <td width="74" style="line-height:12px; background:#D5FFFF;">Agreement&nbsp;Cost</td>
         <td width="104" style=" background:#D5FFFF;">
        
        <input type="text" name="govt_rate" placeholder="Govt. Rate" value="<?php echo $mrp?>" id="govt_rate" style="text-align:right;width:110px;" required='required'/>
         </td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         <td colspan="6" style="color:blue"><hr /></td>
         </tr>
        <tr>
          <td colspan="7"><h4>Discount Calculation (<span class="Required">If Any</span>)</h4></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>discount</td>
          <td colspan="5">
            <input type="text" name="booking_property_discount" placeholder="Discount" value="0" id="booking_property_discount" style="text-align:right; width:120px;" required='required'  onchange="CalcDiscount();" onkeyup="CalcDiscount();" maxlength="18" <?php OnlyPercent(); ?>/>
            <span class="Required">
             if % then Type Like 2%, If Amount then type Like 2000
            </span></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>discount amount</td>
          <td colspan="2"><input type="text" name="booking_property_discount_amount" placeholder="Discount Amount" value="0" id="booking_property_discount_amount" style="text-align:right;width:120px;" required='required' readonly="readonly"/></td>
          <td colspan="3" rowspan="11" style="vertical-align:top;">
     <h2>Extra Charges</h2>
     <table width="100" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="margin-top:0px;">
       <tr>
         <th width="5%" scope="col">#</th>
         <th width="70%" scope="col">particulars</th>
         <th width="25%" scope="col">charge</th>
       </tr>
       <?php 	      $PROJECT_ROW=$DBOBJ->GetRow("tbl_project","project_id",$PROJECT_ID);
		   for($i=1;$i<7;$i++) 
		   {			
		   $TOTAL_EXTRA_CHARGE+=$PROJECT_ROW['extra_charge_amount_'.$i];
		   ?>
       <tr>
         <td><?php echo $i?>
           .</td>
         <td><input type="text" name="extra_charge_<?php echo $i?>" id="extra_charge_<?php echo $i?>" value="<?php echo $PROJECT_ROW['extra_charge_'.$i]?>" placeholder="PARTICULAR <?php echo $i?>" style="width:100%"  onchange="TotalExtra()" onkeyup="TotalExtra()"/></td>
         <td><input type="text" name="extra_charge_amount_<?php echo $i?>" id="extra_charge_amount_<?php echo $i?>" value="<?php echo $PROJECT_ROW['extra_charge_amount_'.$i]?>" placeholder="CHARGE <?php echo $i?>" style="text-align:right;width:100%" <?php OnlyFloat()?> onchange="TotalExtra()" onkeyup="TotalExtra()"/></td>
       </tr>
       <?php } ?>
        <tr>
         <th colspan="2" scope="col"><div align="right">TOTAL EXTRA CHARGE</div></th>
         <th width="25%" scope="col"><div align="right" id="TotalExtraCharges">
           <?php echo @number_format($TOTAL_EXTRA_CHARGE,2)?>
         </div></th>
       </tr>
     </table></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td style="color:#FF0000">discounted mrp</td>
          <td colspan="2"><input type="text" name="booking_property_discounted_mrp" placeholder="Discounted MRP" value="<?php echo $mrp?>" id="booking_property_discounted_mrp" style="text-align:right;width:120px; color:white; background:maroon;" required='required' <?php OnlyFloat()?> readonly="readonly"/></td>
          </tr>
        <tr>
          <td colspan="4"><h4>Payment Details</h4></td>
          </tr>
       
        <tr>
          <td>&nbsp;</td>
          <td>booking type</td>
          <td colspan="2">
            <select id="booking_type" name="booking_type" onchange="GetExpDate();NextPaymentDateShow();">
              <option value="Permanent">Permanent (If Down Payment)</option>
              <option value="Temporary">Temporary (If Token)</option>
              </select>
          </td>
          </tr>
        <tr id="ExpRow" style="display:<?php echo "none;"?>">
          <td>&nbsp;</td>
          <td style="line-height:13px; vertical-align:top;">Token expiry date <br />(<span class="Required">if temporarily booked by token</span>)</td>
          <td colspan="2">
            <input type="hidden" name="booking_date" id="booking_date" value="<?php echo $BOOKING_DATE?>" />
            <?php $EXP_DATE=NextDate($BOOKING_DATE,$EXP_DAYS); DateInput("booking_token_exp_date",$EXP_DATE); ?>
            </div></td>
          </tr>
        
        <tr id="NextPaymentDate">
          <td>&nbsp;</td>
          <td style="line-height:13px; vertical-align:top;">Next paymentDate <br />
          <span class="Required">if Permanent booked by <font color="green">Down Payment</font></span></td>
          <td colspan="2"><?php $NEXT_PAYMENT_DATE=NextMonth($BOOKING_DATE,1); DateInput("next_payment_date",$NEXT_PAYMENT_DATE); ?></td>
          </tr>
        
        <tr>
          <td>&nbsp;</td>
          <td>payment amount</td>
          <td colspan="2"><input type="text" name="payment_amount" placeholder="AMOUNT" value="0" id="payment_amount" style="text-align:right; font-size:14PX; background:green; color:white;" required='required' <?php OnlyFloat(); ?> maxlength="18" /></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>payment  method</td>
          <td colspan="2">
            <select name="payment_mode" id="payment_mode" onchange="HidMe();">
              <option value="CASH">CASH</option>        
              <option value="CHEQUE">CHEQUE</option>
              <option value="DD">DD</option>
              <option value="CHALLAN">CHALLAN</option>
              <option value="FT">FT</option>
              <option value="PAYMENT BY BANK">PAYMENT BY BANK</option>
              </select>
          </td>
          </tr>
        <tr id="hide" style="display:<?php echo "none"?>">
          <td>&nbsp;</td>
          <td style="vertical-align:top;">Payment Details</td>
          <td colspan="2"><table width="98%" border="0" cellspacing="4" cellpadding="0">
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
          </table></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>payment mode</td>
          <td colspan="2"><input type="text" name="booking_payment_mode" id="booking_payment_mode" placeholder="LOAN/OWN" maxlength="25" /></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td style="line-height:13px;">bank name
            (<span class="Required"> if by loan</span>)</td>
          <td colspan="2"><input type="text" name="booking_payment_mode_bank" id="booking_payment_mode_bank" placeholder="LOAN BY BANK" maxlength="50" /></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td style="line-height:13px;">Booking Remarks</td>
          <td colspan="5"><input type="text" name="booking_remark" id="booking_remark" placeholder="BOOKING REMARKS IF ANY " maxlength="50" STYLE="WIDTH:550PX;"/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td style="line-height:13px;">SEND SMS
            (<span class="Required"> Check if  SMS</span>)</td>
          <td colspan="5">
            <label><input type="checkbox" name="sms" id="sms" value="send_sms" />SEND SMS (<span class="Required"> Check if  Want To Send Message To Customer & Associate</span>)</label>
          </td>
          </tr>
   
    <tr>
      <td colspan="7" style="text-align:RIGHT">
        <div align="center">
          <input type="submit" name="Save" id="Save" value="Save Booking Details" <?php Confirm("Are You Sure ? Save Booking Details ?"); ?>/>
          <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.location='Customer.php';" />
          </div>
        </td>
    </tr>
</form>
<?php } } ?>
</table>
</fieldset>
</center></td></tr></table></center>
<?php include("../Menu/Footer.php"); ?>
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
	PLOT_PRICE.value=(parseFloat(PLOT_RATE.value)*parseFloat('<?php echo $PROPERTY_ROW['property_plot_area']?>')).toFixed(2);
	/*==============(CONSTRUCTION PRICE)==============================*/
	CONST_PRICE_BUILT.value=(parseFloat(CONST_RATE_BUILT.value)*parseFloat('<?php echo $PROPERTY_ROW['property_built_up_area']?>')).toFixed(2);
	CONST_PRICE_SUPER_BUILT.value=(parseFloat(CONST_RATE_SUPER_BUILT.value)*parseFloat('<?php echo $PROPERTY_ROW['property_super_built_up_area']?>')).toFixed(2);	
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

function GetExpDate()
{
	var Type=document.getElementById('booking_type').value;
	
	
  if(Type=='Temporary') 
  { 
    document.getElementById('ExpRow').style.display='table-row';  	
  } 
  else 
  {  
    document.getElementById('ExpRow').style.display='none';
 
  }
}

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

function NextPaymentDateShow()
{
	var NextPaymentDate=document.getElementById('NextPaymentDate');
	var booking_type=document.getElementById('booking_type');
	if(booking_type.value=="Permanent")
	{
		NextPaymentDate.style.display='table-row';
	}
	else
	{
		NextPaymentDate.style.display='none';
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
	if($PROPERTY_ROW['property_plot_area']>0 ||  $PROPERTY_ROW['property_plot_area']<0) { $cnt++;}
	if($PROPERTY_ROW['property_built_up_area']>0 ||  $PROPERTY_ROW['property_built_up_area']<0) { $cnt++;}
	if($PROPERTY_ROW['property_super_built_up_area']>0 ||  $PROPERTY_ROW['property_super_built_up_area']<0) { $cnt++;}
	?>
	var cnt=parseInt(<?php echo $cnt?>);
	
		p_r.readOnly="readOnly";
		bua_r.readOnly="readOnly";
		plot_r.readOnly="readOnly";
		fixed_mrp.readOnly="";
		fixed_mrp.focus();
	
	var fix=fixed_mrp.value;
	
	if(cnt>0) 
	{ 
	 fix=(fix/cnt).toFixed(2);
	}
	
	<?php 	
	if($PROPERTY_ROW['property_plot_area']>0 ||  $PROPERTY_ROW['property_plot_area']<0) 
	{?> 
	  p_r.value=(fix/<?php echo $PROPERTY_ROW['property_plot_area']?>).toFixed(2);
	  plot_price.value=fix;
	<?php }
	
	if($PROPERTY_ROW['property_built_up_area']>0 ||  $PROPERTY_ROW['property_built_up_area']<0) 
	{?> 
	   bua_r.value=(fix/<?php echo $PROPERTY_ROW['property_built_up_area']?>).toFixed(2);
	  plot_built_price.value=fix;
	<?php }

	if($PROPERTY_ROW['property_super_built_up_area']>0 ||  $PROPERTY_ROW['property_super_built_up_area']<0)
	{?> 
	  plot_r.value=(fix/<?php echo $PROPERTY_ROW['property_super_built_up_area']?>).toFixed(2);
	  plot_sup_price.value=fix;
	<?php }
	?>
	
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
			
			mrp.value='<?php echo $mrp?>';
			govt_rate.value='<?php echo $mrp?>';
			
	}
	CalcDiscount();
}

function TotalExtra()
{
	var TEC=0;
	 var P=document.getElementById('extra_charge_'+x);
	 var TotalExtraCharges=document.getElementById('TotalExtraCharges');
	for(var x=1;x<7 ; x++)
	{
	  var P=document.getElementById('extra_charge_'+x);
	  var C=document.getElementById('extra_charge_amount_'+x);	
	  var val=parseFloat(C.value);
	 
	  if(isNaN(val)) {  val=0; }
	  
	  if(P.value!="")
	  {
		  TEC+=val;
	  }
	  else
	  {
		  C.value=0;
		  TEC+=val;
	  }
	  
	}
	//alert(TEC);
	TotalExtraCharges.innerHTML= TEC.toFixed(2);
}

</script>