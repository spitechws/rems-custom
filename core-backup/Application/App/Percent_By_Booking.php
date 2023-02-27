<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$BOOKING_ID=$_GET[md5('booking_id')];
$BOOKING_ROW=$DBOBJ->GetRow("tbl_property_booking","booking_id",$_GET[md5("booking_id")]);
$CUSTOMER_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$BOOKING_ROW['booking_customer_id']);
$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$BOOKING_ROW['booking_advisor_id']);
$PROPERTY_ROW=$DBOBJ->GetRow("tbl_property","property_id",$BOOKING_ROW['booking_property_id']);
$PROJECT_ROW=$DBOBJ->GetRow("tbl_project","project_id",$BOOKING_ROW['booking_project_id']);


$CUSTOMER_ID=$BOOKING_ROW['booking_customer_id'];
$ADVISOR_ID=$BOOKING_ROW['booking_advisor_id'];

$PROPERTY_ID=$BOOKING_ROW['booking_property_id'];
$PROJECT_ID=$BOOKING_ROW['booking_project_id'];
$PROPERTY_TYPE_ID=$PROPERTY_ROW['property_type_id'];
$PROPERTY_TYPE=$DBOBJ->ConvertToText("tbl_setting_property_type","property_type_id","property_type",$PROPERTY_TYPE_ID);

$PROPERTY_STATUS=$PROPERTY_ROW['property_status'];

if($BOOKING_ROW['booking_cancel_status']=='Yes') { $BOOKIN_STATUS="Cancelled"; } else { $BOOKIN_STATUS="Active"; }
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>
#CommonTable tr td #SmallTable tr th { height:20px; }
</style>
<center>
<table width="100%" border="0" cellspacing="0" id="CommonTable" style="width:750px">
  <tr>
    <th colspan="6">Commission Percentage on booking</th>
    </tr>
  <tr>
    <td width="86">order no</td>
    <td width="119" id="Value"><?php echo $BOOKING_ROW['booking_order_no'];?></td>
    <td width="115">BOOKING DATE</td>
    <td width="116" id="Value"><?php echo date('d-M-Y',strtotime($BOOKING_ROW['booking_date']));?></td>
    <td width="125">PROPERTY STATUS</td>
    <td width="125" id="Value"><?php echo $PROPERTY_STATUS;?></td>
  </tr>
  <tr>
    <td>PROPERTY</td>
    <td id="Value"><?php echo $PROPERTY_TYPE;?> <?php echo $PROPERTY_ROW['property_no'];?></td>
    <td>PROJECT</td>
    <td id="Value"><?php echo $PROJECT_ROW['project_name'];?></td>
    <td>BOOKING STATUE</td>
    <td id="Value"><?php echo $BOOKIN_STATUS?></td>
  </tr>
  <tr>
    <td>CUSTOMER</td>
    <td id="Value"><?php echo $CUSTOMER_ROW['customer_code'];?></td>
    <td colspan="4" id="Value"><?php echo $CUSTOMER_ROW['customer_title']." ".$CUSTOMER_ROW['customer_name'];?></td>
    </tr>
  <tr>
    <td><?php echo advisor_title?></td>
    <td id="Value"><?php echo $ADVISOR_ROW['advisor_code']?></td>
    <td colspan="4" id="Value"><?php echo $ADVISOR_ROW['advisor_title']." ".$ADVISOR_ROW['advisor_name'];?></td>
    </tr>
  <tr>
    <th colspan="6">
    <img src="../SpitechImages/Percent.png" style="width:20px; height:18px" />
    Commission PERCENTAGE DISTRIBUTION ON RULE
    </th>
    </tr>
  <tr>
    <td colspan="6">
      <table width="100%" border="0" cellspacing="1" id="SmallTable">
        <tr>
          <th colspan="2">VOUCHER AMOUNT</th>
          <th style="text-align:left">
          <input style="width:80px" type="text" id="amount" value="10000.00" placeholder="AMOUNT" <?php echo onlyFloat()?> maxlength="10" onkeyup="CalC();" onchange="CalC();" />
          </th>
          <th colspan="4" style="text-align:left">Commission will based on level at the time of booking</th>
          </tr>
        <tr>
          <th width="5%" rowspan="2">#</th>
          <th width="35%"><?php echo advisor_title?></th>
          <th width="9%" rowspan="2">CODE</th>
          <th width="14%">BOOKING-LEVEL</th>
          <th width="37%">PERCENT</th>
          <th width="37%">DIFFERRENCE</th>
          <th width="37%" rowspan="2">COMMISSION</th>
          </tr>
        <tr>
          <th><?php echo $BOOKING_ROW['booking_advisor_id'].",".$BOOKING_ROW['booking_advisor_team'];?></th>
          <th width="14%"><?php echo $BOOKING_ROW['booking_advisor_level'].",".$BOOKING_ROW['booking_advisor_team_level'];?></th>
          <th width="37%"><?php echo $BOOKING_ROW['booking_advisor_level_percent'].",".$BOOKING_ROW['booking_advisor_team_level_percent'];?></th>
          <th width="37%"><?php echo $BOOKING_ROW['booking_advisor_level_percent'].",".$BOOKING_ROW['booking_advisor_team_level_percent_diff'];?></th>
        </tr>
        <tr>
          <td>1.</td>
          <td style="text-align:LEFT"><?php echo $ADVISOR_ROW['advisor_name'];?></td>
          <td><?php echo $ADVISOR_ROW['advisor_code']?></td>
          <td><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$BOOKING_ROW['booking_advisor_level']);?></td>
          <td><?php echo $BOOKING_ROW['booking_advisor_level_percent'];$TP+=$BOOKING_ROW['booking_advisor_level_percent']?>%</td>
          <td><?php echo $BOOKING_ROW['booking_advisor_level_percent'];$TD+=$BOOKING_ROW['booking_advisor_level_percent']?>%</td>
          <td style="text-align:right">
          <B id="ID1" title="<?php echo $BOOKING_ROW['booking_advisor_level_percent']?>">
		   <?php echo @number_format(10000*$BOOKING_ROW['booking_advisor_level_percent']/100,2);$TA+=(10000*$BOOKING_ROW['booking_advisor_level_percent']/100)?>
          </B>
          </td>
          </tr>
<?php $TEAM=explode(",",$BOOKING_ROW['booking_advisor_team']);
$LEVEL=explode(",",$BOOKING_ROW['booking_advisor_team_level']);
$PERCENT=explode(",",$BOOKING_ROW['booking_advisor_team_level_percent']);
$DIFF=explode(",",$BOOKING_ROW['booking_advisor_team_level_percent_diff']);
$K=2;
for($i=0;$i<count($TEAM);$i++) 
{
	$CODE=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$TEAM[$i]);
	$NAME=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$TEAM[$i]);
	$LVL=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$LEVEL[$i]);
?>          
        <tr>
          <td><?php echo $K++?>.</td>
          <td><div align="left" style="width:200px"><?php echo $NAME?></div></td>
          <td><?php echo $CODE?></td>
          <td><?php echo $LVL?></td>
          <td><?php echo $PERCENT[$i];$TP+=$PERCENT[$i]?>%</td>
          <td><?php echo $DIFF[$i];$TD+=$DIFF[$i]?>%</td>
          <td style="text-align:right">
              <B id="ID<?php echo $K-1?>"  title="<?php echo $DIFF[$i]?>">
             	 <?php echo @number_format(10000*$DIFF[$i]/100,2);$TA+=(10000*$DIFF[$i]/100);?>
              </B>
          </td>
          </tr>
<?php } ?> 
 <tr>
          <th colspan="5" style="text-align:right">TOTAL</th>
          <th><?php echo $TD?>%</th>
          <th style="text-align:right; padding:1px"><b id="total"><?php echo @number_format($TA,2)?></b></th>
          </tr>         
      </table>    </td>
    </tr>
</table>

</center>
<script>
function CalC()
{
	var amount=document.getElementById('amount');
	var amt=parseFloat(amount.value);
	var tot=0;
	
	if(isNaN(amt) || amt<0 || amt==0) { amount.value=10000.00;amt=10000.00;}
	
	
	for(var i=1;i<<?php echo $K?>;i++)
	{ 
	  var b=document.getElementById('ID'+i);
	  var per=parseFloat(b.title);
	  if(isNaN(per)) { per=0;}
	  var com=amt*per/100;
	  b.innerHTML=(com).toFixed(2);
	  tot+=com;
	}
	
	document.getElementById('total').innerHTML=(tot).toFixed(2);
}
</script>
