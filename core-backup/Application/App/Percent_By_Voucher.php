<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$PAYMENT_ROW=$DBOBJ->GetRow("tbl_property_booking_payments","payment_id",$_GET[md5("payment_id")]);

$voucher_no=$PAYMENT_ROW['payment_voucher_no'];
$BOOKING_ID=$PAYMENT_ROW['payment_booking_id'];
$BOOKING_ROW=$DBOBJ->GetRow("tbl_property_booking","booking_id",$BOOKING_ID);
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
#CommonTable tr td #SmallTable tr th, #CommonTable tr td #Data-Table tr th { height:20px; }
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
    <th colspan="6">VOUCHER DETAILS</th>
    </tr>
  <tr>
    <td>AMOUNT</td>
    <td id="Required"><?php echo @number_format($PAYMENT_ROW['payment_amount'],2)?></td>
    <td>VOUCHER DATE</td>
    <td  id="Required"><?php echo date('d-M-Y',strtotime($PAYMENT_ROW['payment_date']));?></td>
    <td>&nbsp;</td>
    <td id="Value">&nbsp;</td>
  </tr> 
    
  <tr>
    <th colspan="6">COMMISSION DISTRIBUTED REPORT</th></tr>
  <tr>
    <td colspan="6">
    <table width="100%"  id="Data-Table"  cellspacing="1" style="width:100%; margin:5PX 0PX 5PX 0PX; ">
      <tr>
        <th width="25" height="30" rowspan="2">#</th>
        <th colspan="3"><?php echo advisor_title?>
          DETAILS</th>
        <th width="94" rowspan="2">LEVEL</th>
        <th width="94" rowspan="2">PERCENT</th>
        <th width="94" rowspan="2">DIFF</th>
        <th width="94" rowspan="2">COMMISSION</th>
        <th width="74" rowspan="2">TDS</th>
        <th width="97" rowspan="2">NET </th>
        </tr>
      <tr>
        <th>NAME</th>
        <th>CODE</th>
        <th>comm.date</th>
        </tr>
 <?php
	
		$COMMISSION_QUERY="select * FROM tbl_advisor_commission where approved='1' and commission_voucher_no='$voucher_no' order by commission_id ";
		$COMMISSION_QUERY=@mysqli_query($_SESSION['CONN'],$COMMISSION_QUERY);		
$Hide=0;
while($COMMISSION_ROWS=@mysqli_fetch_assoc($COMMISSION_QUERY)) 
{
		  
	$COLLECTION=$COMMISSION_ROWS['commission_voucher_amount'];	$TOTAL_COLLECTION+=$COLLECTION;
	$COMMISSION=$COMMISSION_ROWS['commission_amount'];	$TOTAL_COMMISSION+=$COMMISSION;
	$TDS=$COMMISSION_ROWS['commission_tds_amount']; 			   $TOTAL_TDS+=$TDS;
	$NETT_COMMISSION=$COMMISSION_ROWS['commission_nett_amount']; $TOTAL_NETT_COMMISSION+=$NETT_COMMISSION;
	
	$ADVISOR_C=$DBOBJ->ConvertToText('tbl_advisor','advisor_id','advisor_code',$COMMISSION_ROWS['commission_advisor_id']);
	$ADVISOR_N=$DBOBJ->ConvertToText('tbl_advisor','advisor_id','advisor_name',$COMMISSION_ROWS['commission_advisor_id']);
	
	
	$COL="BLACK";
	if($COMMISSION>0) { $COL="MAROON"; }
	elseif($COMMISSION<0) { $COL="RED"; }	
	$LVL=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$COMMISSION_ROWS['commission_advisor_level_id']);
	$PERCENT=$COMMISSION_ROWS['commission_advisor_level_percent'];
	$DIFF=$COMMISSION_ROWS['commission_advisor_level_diff_percent'];
?>
      <tr <?php if($COMMISSION=="0" ||$COMMISSION==""  ||$COMMISSION==NULL) { echo "id=Hide".$Hide++; } ?>>
        <td height="22"><div align="center"><?php echo ++$k?>.</div></td>
        <td width="311" style=" height:18px"><div align="center" style="width:200px;text-align:left;"><?php echo $ADVISOR_N?></div></td>
        <td width="45"><div align="center" style="width:70px;"><?php echo $ADVISOR_C?></div></td>
        <td width="45"><?php echo date('d-M-Y',strtotime($COMMISSION_ROWS['commission_date']));?></td>
        <td><div align="center" style="width:120px;"><?php echo $LVL?></div></td>
        <td><?php echo $PERCENT?>%</td>
        <td><?php echo $DIFF?>%</td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($COMMISSION,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($TDS,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($NETT_COMMISSION,2);?></td>
        </tr>
      <?php } ?>
      <tr>
        <th height="22" colspan="4"><div align="right">TOTAL </div></th>
        <th style="text-align:right">&nbsp;</th>
        <th style="text-align:right">&nbsp;</th>
        <th style="text-align:right">&nbsp;</th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_COMMISSION,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_TDS,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_NETT_COMMISSION,2);?></th>
        </tr>
    </table></td>
  </tr>
   <tr>
    <th colspan="6"><A onclick="<?php echo ShowHide('Plan','table-row') ?>" style="color:#008800">
    <img src="../SpitechImages/Percent.png" style="width:20px; height:18px" />
    COMMISSION PERCENTAGE DISTRIBUTION ON RULE</A>
    </th>
  </tr>
 
  <tr id="Plan" style="display:<?php echo 'none'?>;">
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
