<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$s_date=date('Y-m-01');
$e_date=date('Y-m-d');
if(isset($_GET['Search'])) 
{
	$s_date=$_GET['s_date'];
    $e_date=$_GET['e_date'];
}
$ADVISOR_ID=$_GET[md5('payment_advisor_id')];
$ADVISOR_ROW=$DBOBJ->GetRow('tbl_advisor','advisor_id',$ADVISOR_ID);

?>
<center>
<h1>Project  : <span>Receive Payment</span></h1>
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" >
      <tr id="TH">
    <th width="2%" rowspan="2">#</th>
    <th width="3%" rowspan="2">ID&nbsp;CODE</th>
    <th width="17%" rowspan="2">NAME</th>
    <th width="7%" rowspan="2">LEVEL</th>
    <th width="7%" rowspan="2">PAYMENT DATE</th>
    <th width="7%" rowspan="2">PAYMENT</th>
    <th colspan="5">PAYMENT DETAILS</th>
    </tr>
      <tr id="TH">
        <th>MODE</th>
        <th>DD/CHEQUE/TXN&nbsp;NO</th>
        <th>BANK</th>
        <th>DATE</th>
        <th>PAYMENT&nbsp;REMARKS</th>
      </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$PAYMENT_QUERY="select * from tbl_advisor_payment where approved!='0' ";
		if(isset($_GET['Search']))
		{
			if($_GET['payment_advisor_id']!="All") 		{ $PAYMENT_QUERY.=" and payment_advisor_id='".$_GET['payment_advisor_id']."' "; }			
		}
	   $PAYMENT_QUERY.=" and payment_date between '$s_date' and '$e_date' "; 
		$PAGINATION_QUERY=$PAYMENT_QUERY."  order by payment_date ";
		$PAYMENT_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PAYMENT_QUERY=@mysqli_query($_SESSION['CONN'],$PAYMENT_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PAYMENT_QUERY);

while($PAYMENT_ROWS=@mysqli_fetch_assoc($PAYMENT_QUERY)) 
{
	$ADV_ROW=$DBOBJ->GetRow('tbl_advisor','advisor_id',$PAYMENT_ROWS['payment_advisor_id']);

?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="center" style="width:70px;"><?php echo $ADV_ROW['advisor_code']; ?></div></td>
    <td ><div align="left"  style="width:200PX;"><?php echo $ADV_ROW['advisor_name']; ?></div></td>
    <td >
      <div align="center" style="width:80PX;">
        <?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADV_ROW['advisor_level_id']); ?>
        </div>
    </td>
    <td><div align="center" style="width:80PX;"><?php echo date('d-M-Y',strtotime($PAYMENT_ROWS['payment_date'])); ?></div></td>
    <td><div align="right"><?php echo @number_format($PAYMENT_ROWS['payment_amount'],2);$total_payment+=$PAYMENT_ROWS['payment_amount'];?></div></td>
    <td width="7%"><div align="right"><?php echo $PAYMENT_ROWS['payment_mode'];?></div></td>
    <td width="7%"><?php echo $PAYMENT_ROWS['payment_mode_no'];?></td>
    <td width="7%"><?php echo $PAYMENT_ROWS['payment_mode_bank'];?></td>
    <td width="4%" style="text-align:center;"><div style="width:70px;"><?php if($PAYMENT_ROWS['payment_mode']!="CASH") { echo $PAYMENT_ROWS['payment_mode_date']; }?></div>
      <div align="center"></div></td>
    <td width="3%" style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_remark'];?></td>
    </tr>
   <?php } ?>
    <tr><th colspan="5">&nbsp;</th>
      <th><div align="right"><?php echo @number_format($total_payment,2);?></div></th>
      <th colspan="5">&nbsp;</th>
      </tr>

</table>
 </center>