<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Customer");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$CUSTOMER_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$_GET[md5('customer_id')]);
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
<center>
<h1><img src="../SpitechImages/CustomerNew.png" width="31" height="32" />Customer  : <span>Profile</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td width="39%" align="center">
    <center>
   

   <h2 style="margin:0px; width:502px;">Customer Profile</h2>
    <fieldset style="width:500px; margin:0px; padding:0px;">
     
    <table border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">  
   <tr class="DontPrint">
     <td style="height:35px;" colspan="2">CUSTOMER</td>
     <td colspan="2" id="Value2" style="color:red; font-size:13px;">
     <form id="AdvisorForm" name="AdvisorForm" method="get" style="margin:0px; margin-top:3px;">
       <select name="<?php echo md5("customer_id")?>" id="<?php echo md5("customer_id")?>" onchange="AdvisorForm.submit();">
         <option value="">Select A Customer...</option>
         <?php 
			   $CUSTOMER_Q="SELECT customer_id, customer_code, customer_name FROM tbl_customer ORDER BY customer_name";
			   $CUSTOMER_Q=@mysqli_query($_SESSION['CONN'],$CUSTOMER_Q);
			   while($CUSTOMER_ROWS=@mysqli_fetch_assoc($CUSTOMER_Q)) {?>
         <option value="<?php echo $CUSTOMER_ROWS['customer_id'];?>" <?php SelectedSelect($CUSTOMER_ROWS['customer_id'], $_GET[md5('customer_id')]); ?>>
           <?php echo $CUSTOMER_ROWS['customer_name']." [".$CUSTOMER_ROWS['customer_code']." ]";?>
           </option>
         <?php } ?>
       </select>
     </form></td>
   </tr>
  
     
    <tr>
      <td colspan="4"><H4>CUSTOMER DETAILS</H4></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>name</td>
      <td colspan="2" style="color:RED; font-size:13PX;" id="Value"><?php echo $CUSTOMER_ROW['customer_title']." ".$CUSTOMER_ROW['customer_name']?></td>
      </tr>

    <tr>
      <td width="15">&nbsp;</td>
      <td width="180"> id code </td>
      <td width="291"><span style="color:blue; font-size:13PX;" id="Value"><?php echo $CUSTOMER_ROW['customer_code']?></span></td>
      <td width="145" rowspan="8" style="vertical-align:top;">
	  <?php $ACTUAL_PHOTO="../SpitechUploads/customer/profile_photo/".$CUSTOMER_ROW['customer_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1") { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }
		  if(!isset($_GET[md5('customer_id')]) || $CUSTOMER_ROW['customer_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }
		 ?>
        <img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imgBorder"/></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:12px;">father's/Husband's name </td>
      <td  id="Value"><?php echo $CUSTOMER_ROW['customer_fname'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>sex </td>
      <td  id="Value"><?php echo $CUSTOMER_ROW['customer_sex'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Marital STATUS</td>
      <td  id="Value"><?php echo $CUSTOMER_ROW['customer_marital_status'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">BLOOD GROUP</td>
      <td id="Value"><?php echo $CUSTOMER_ROW['customer_bg'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">mobile no</td>
      <td id="Value" style="color:blue;"><?php echo $CUSTOMER_ROW['customer_mobile'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">WHATS APP NO</td>
      <td id="Value" style="color:blue;"><?php echo $CUSTOMER_ROW['customer_whatsapp_no'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">phone no</td>
      <td id="Value" style="color:blue;"><?php echo $CUSTOMER_ROW['customer_phone'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">email id</td>
      <td colspan="2" id="Value" style="text-transform:none;"><?php echo $CUSTOMER_ROW['customer_email'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">PAN NO</td>
      <td colspan="2" id="Value"><?php echo $CUSTOMER_ROW['customer_pan'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">OCCUPATION</td>
      <td colspan="2" id="Value"><?php echo $CUSTOMER_ROW['customer_occupation'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">Designation</td>
      <td colspan="2" id="Value"><?php echo $CUSTOMER_ROW['customer_designation'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">anual income</td>
      <td colspan="2" id="Value" style="color:blue;"><?php echo @number_format($CUSTOMER_ROW['customer_anual_income'],2);?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">city</td>
      <td colspan="2" id="Value"><?php echo $CUSTOMER_ROW['customer_city'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">address</td>
      <td colspan="2" id="Value"><?php echo $CUSTOMER_ROW['customer_address'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">date of BIRTH </td>
      <td colspan="2" id="Value"><?php ShowDate($CUSTOMER_ROW['customer_dob']);?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">ANNIVERSARY DATE</td>
      <td colspan="2" id="Value">
	  <?php ShowDate($CUSTOMER_ROW['customer_anniversary_date']);?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">reg. date </td>
      <td colspan="2" id="Value"><?php ShowDate($CUSTOMER_ROW['customer_reg_date']); ?></td>
      </tr>
       <tr>
      <td colspan="4"><H4>NOMINEE DETAILS</H4></td>
      </tr>
   
       <tr>
         <td>&nbsp;</td>
         <td>NOMINEE NAME<span style="line-height:13px;"> </span></td>
         <td colspan="2" id="Value" style="color:blue;"><?php echo $CUSTOMER_ROW['customer_nominee_name'];?></td>
         </tr>
       <tr>
         <td>&nbsp;</td>
         <td style="text-align:justify; line-height:13px;">relation&nbsp;with&nbsp;customer</td>
         <td colspan="2" id="Value" style="color:red;"><?php echo $CUSTOMER_ROW['customer_relation_with_nominee'];?></td>
         </tr>
       <tr>
         <td>&nbsp;</td>
         <td style="line-height:13px;">DAT OF BIRTH</td>
         <td colspan="2" id="Value"><?php echo date('d-M-Y',strtotime($CUSTOMER_ROW['customer_nominee_dob']));?></td>
         </tr>
       <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">mobile no</td>
      <td colspan="2" id="Value"><?php echo $CUSTOMER_ROW['customer_nominee_mobile'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">phone no</td>
      <td colspan="2" id="Value"><?php echo $CUSTOMER_ROW['customer_nominee_phone'];?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px;">ADDRESS&nbsp;OF&nbsp;NOMINEE</td>
      <td colspan="2" id="Value"><?php echo $CUSTOMER_ROW['customer_nominee_address'];?></td>
      </tr>

</table>
</fieldset>

</center></td>
    <td width="61%" align="center" style="vertical-align:top;">
    <h2 style="margin-top:0PX;">BOOKING DETAILS</h2>
    <div style="width:780px; overflow:auto; border:1px solid gray; height:250px; margin:10px;margin-top:0PX;">
    <table width="98%" border="0" cellspacing="1" id="Data-Table">
  <tr>
    <th width="2%" rowspan="2">#</th>
    <th colspan="3">property details</th>
    <th colspan="2">date</th>
    <th width="21%" rowspan="2">order&nbsp;no</th>
    <th colspan="3">mrp</th>
    <th colspan="2">payments</th>
    <th width="6%" colspan="2" rowspan="2">status</th>
    <th width="6%" rowspan="2">action</th>
  </tr>
  <tr>
    <th>property</th>
    <th>type</th>
    <th>project</th>
    <th width="8%">booking</th>
    <th width="6%">expiry</th>
    <th width="4%">mrp</th>
    <th width="3%">dis</th>
    <th width="7%">dis.mrp</th>
    <th width="8%">received</th>
    <th width="8%">balance</th>
    </tr>
  
  <?php   
  $BOOKING_Q="SELECT * FROM tbl_property_booking where approved='1' and booking_customer_id='".$_GET[md5('customer_id')]."' order by booking_date";
  $BOOKING_Q=@mysqli_query($_SESSION['CONN'],$BOOKING_Q);
  while($BOOKING_ROWS=@mysqli_fetch_assoc($BOOKING_Q)) 
  { 
   $PROPERTY_NO=$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROWS['booking_property_id']);
   $PROPERTY_TYPE_NAME=$DBOBJ->PropertyTypeName($BOOKING_ROWS['booking_property_id']);
   $PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROWS['booking_project_id']);
   $RECEIVED=$DBOBJ->TotalBookingCollection($BOOKING_ROWS['booking_id']);
   $BAL=$DBOBJ->TotalBookingBalance($BOOKING_ROWS['booking_id']);
   $status=$BOOKING_ROWS['booking_cancel_status'];
   if($status=="Yes") { $status="CENCELLED"; $BG="RED"; } else { $status="ACTIVE"; $BG="GREEN"; }
   if($BOOKING_ROWS['booking_type']=="Permanent") { $BG1="RED"; $col="white"; } else { $BG1="orange"; $col="black"; }
  ?>  
  <tr>
    <td style="text-align:center;"><?php echo ++$j;?></td>
    <td width="9%"><div align="center"><?php echo $PROPERTY_NO;?></div></td>
    <td width="5%"><div align="center"><?php echo $PROPERTY_TYPE_NAME;?></div></td>
    <td width="13%"><div align="center" style="width:150px;"><?php echo $PROJECT_NAME;?></div></td>
    <td style="text-align:center"><?php echo date('d-M-Y',strtotime($BOOKING_ROWS['booking_date']));?></td>
    <td style="text-align:center"><?php echo date('d-M-Y',strtotime($BOOKING_ROWS['booking_token_exp_date']));?></td>
    <td style="text-align:center"><?php echo $BOOKING_ROWS['booking_order_no'];?></td>
    <td style="text-align:right;"><?php echo @number_format($BOOKING_ROWS['booking_property_mrp'],2);$TOTAL_MRP+=$BOOKING_ROWS['booking_property_mrp'];?></td>
    <td style="text-align:right;"><?php echo @number_format($BOOKING_ROWS['booking_property_discount_amount'],2);$TOTAL_DIS+=$BOOKING_ROWS['booking_property_discount_amount'];?></td>
    <td style="text-align:right;"><?php echo @number_format($BOOKING_ROWS['booking_property_discounted_mrp'],2);$TOTAL_DIS_MRP+=$BOOKING_ROWS['booking_property_discounted_mrp'];?></td>
    <td style="text-align:right;"><?php echo @number_format($RECEIVED,2);$TOTAL_RECEIVED+=$RECEIVED;?></td>
    <td style="text-align:right;"><?php echo @number_format($BAL,2);$TOTAL_BALANCE+=$BAL;?></td>
    <td style="background:<?php echo $BG?>; color:white;"><?php echo $status?></td>
    <td style="background:<?php echo $BG1?>; color:<?php echo $col?>;"><?php echo $BOOKING_ROWS['booking_type'];?></td>
    <td><a href="Project_Property_Booking_Accounts.php?<?php echo md5('booking_id')."=".$BOOKING_ROWS['booking_id']?>" title="View Accounts">Account</a></td>
  </tr>
  <?php } ?>
  <tr>
    <th colspan="7">&nbsp;</th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_MRP,2);?></th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_DIS,2);?></th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_DIS_MRP,2);?></th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_RECEIVED,2);?></th>
    <th style="text-align:right"><?php echo @number_format($TOTAL_BALANCE,2);?></th>
    <th colspan="2" style="text-align:right">&nbsp;</th>
    <th style="text-align:right">&nbsp;</th>
    </tr>
</table>
</div>
    
    </td>
  </tr>
</table></center>
<?php include("../Menu/Footer.php"); ?>