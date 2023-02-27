<?php
session_start();
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
NoUser();
NoAdminCategory();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$BOOKING_ROW=$DBOBJ->GetRow("tbl_property_booking","booking_id",$_GET[md5("booking_id")]);	
$TOTAL_PAID=$DBOBJ->TotalBookingCollection($_GET[md5("booking_id")]);
$PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROW['booking_project_id']);
$PROPERTY_NO=$DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROW['booking_property_id']);
$PROPERTY_TYPE=$DBOBJ->PropertyTypeName($BOOKING_ROW['booking_property_id']);

$CUSTOMER=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$BOOKING_ROW['booking_customer_id']).", CODE : ".$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_code",$BOOKING_ROW['booking_customer_id']);

$ADVISOR=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$BOOKING_ROW['booking_advisor_id']).", CODE : ".$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$BOOKING_ROW['booking_advisor_id']);

if(isset($_POST['Submit']))
{
  if($BOOKING_ROW['booking_cancel_status']!="Yes")
  {
	  //========================( PROPERTY TABLE)==============================================================	
        $FIELDS=array("property_status");
		$VALUES=array("Available");		
		$DBOBJ->Update("tbl_property",$FIELDS,$VALUES,"property_id",$BOOKING_ROW['booking_property_id'],0);  }
 
  //========================( DELETE COMMISSION )==============================================================	
  	@mysqli_query($_SESSION['CONN'],"delete from tbl_advisor_commission where commission_order_no='".$BOOKING_ROW['booking_order_no']."' ");	
	
	//========================( DELETE EXTRA CHARGES )==============================================================	
  	@mysqli_query($_SESSION['CONN'],"delete from tbl_property_booking_extra_charge where booking_id='".$_GET[md5("booking_id")]."' ");	
	@mysqli_query($_SESSION['CONN'],"delete from tbl_property_booking_extra_charge_payment where booking_id='".$_GET[md5("booking_id")]."' ");	
	//========================( BOOKING DOCS )==============================================================
	@mysqli_query($_SESSION['CONN'],"delete from tbl_property_booking_payments_doc where payment_id in(select payment_id from tbl_property_booking_payments where payment_booking_id='".$_GET[md5("booking_id")]."') ");    
   //========================( DELETE BOOKING )==============================================================	
  	@mysqli_query($_SESSION['CONN'],"delete from tbl_property_booking where booking_id='".$_GET[md5("booking_id")]."' ");	
  //========================( DELETE PAYMENT )==============================================================	
  	@mysqli_query($_SESSION['CONN'],"delete from tbl_property_booking_payments where payment_booking_id='".$_GET[md5("booking_id")]."' ");	
	
  
$DBOBJ->UserAction("BOOKING DELETED","ORDER NO : ".$BOOKING_ROW['booking_order_no'].", PROJECT : ".$PROJECT_NAME.", PROPERTY : ".$PROPERTY_TYPE."/".$PROPERTY_NO.", CUSTOMER : ".$CUSTOMER.", Associate : ".$ADVISOR);
 
   
//==============================( ENTRY IN BOOKING DELETED TABLE )===============================================================  
  $FIELDS=array("booking_type", 
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
				"booking_total_payment_received",
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
				"edited_details",
				"deleted_details");
  $VALUES=array($BOOKING_ROW["booking_type"], 
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
				
				$TOTAL_PAID,
				$BOOKING_ROW["booking_remark"], 
				$BOOKING_ROW["booking_cancel_status"], 
				$BOOKING_ROW["booking_cancel_details"],
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
				$BOOKING_ROW["created_details"],
				$BOOKING_ROW["edited_details"],
				$Mess=CreatedEditedByUserMessage());		
  $DBOBJ->Insert("tbl_property_booking_deleted",$FIELDS,$VALUES,0);  
//==============================( END ENTRY IN BOOKING DELETED TABLE )===========================================================  
  header("location:Project_Booking_Deleted.php?Message=Booking Deleted Successfully");
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<head><title>Project : Booking Delete Confirmation</title></head>
    <center>
  <!-- <fieldset style="width:880px; height:310px;">
   <legend>Delete Booking Details</legend>-->
   <form id="FrmBookingDelete" name="FrmBookingDelete" method="post" enctype="multipart/form-data" action="Project_Booking_Delete.php?<?php echo md5('booking_id')."=".$_GET[md5("booking_id")]?>">
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
    <td width="127">PROPERTY </td>
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
  <?php if(!isset($_SESSION['user_id'])) { ?>
  <?php } ?>
  <tr>
    <td>BOOKING DATE</td>
    <td class="Value"><div align="right">
      <?php echo date('d-M-Y',strtotime($BOOKING_ROW['booking_date']));?>
    </div></td>
    <td class="Value">&nbsp;</td>
    </tr>
  <tr>
    <td>DISCOUNTED MRP</td>
    <td width="58" class="Value" style="color:blue"><div align="right">
      <?php echo @number_format($BOOKING_ROW['booking_property_discounted_mrp'],2)?>
    </div></td>
    <td width="239" class="Value">&nbsp;</td>
    </tr>
  <tr>
    <td>PAYMENT&nbsp;RECEIVED</td>
    <td class="Value" style="color:green"><div align="right">
      <?php echo @number_format($DBOBJ->TotalBookingCollection($BOOKING_ROW['booking_id']),2)?>
    </div></td>
    <td class="Value">&nbsp;</td>
  </tr>
  <tr>
    <td>BALANCE</td>
    <td class="Value" style="color:red"><div align="right">
      <?php echo @number_format($DBOBJ->TotalBookingBalance($BOOKING_ROW['booking_id']),2)?>
    </div></td>
    <td class="Value">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" style="text-align:RIGHT; vertical-align:bottom;">
      <input type="submit" name="Submit" id="Submit" class="Button" value="Delete Booking" <?php Confirm("Are You Sure ?\\n Do Your Realy Want To Delete This Booking And Its Related Details ?\\n\\n All Payment Received & Commission Generated Details Will Be Deleted. \\n\\nWould You Proceed ?"); ?>/>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.close();" />
    </td>
    </tr>
     <tr>
    <td colspan="4" >
    <div id="Error" style="text-transform:none;"><font color="#00FF00">All Payment Received, Extra Charges, </font> and <font color="#00FF00">All Commission Generated</font> Will Be <font color="#00FF00">Deleted</font>.
   
    
    </div>
    </td>
    </tr>
</table>
</form>
<!--</fieldset>-->
</center>


