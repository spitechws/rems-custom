<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$pay_sdate=date('Y-m-01');
$pay_edate=date('Y-m-d');

if(isset($_GET['PaySearch']))
{
	$pay_sdate=$_GET['pay_sdate'];
	$pay_edate=$_GET['pay_edate'];
}

$ADVISOR_ID=$_GET[md5('advisor_id')];
$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_GET[md5('advisor_id')]);
?>
<center>
<h2>PAYMENT RECEIVED DETAILS</h2>
      <table width="94%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" >
        <tr id="TH">
          <th width="2%" rowspan="2">#</th>
          <th width="6%" rowspan="2">PAYMENT DATE</th>
          <th width="26%" rowspan="2">PAYMENT</th>
          <th colspan="5">PAYMENT DETAILS</th>
        </tr>
        <tr id="TH">
          <th>MODE</th>
          <th>DD/CHEQUE/TXN&nbsp;NO</th>
          <th>BANK</th>
          <th>DATE</th>
          <th>REMARKS</th>
        </tr>
        <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$PAYMENT_QUERY="select * from tbl_advisor_payment where approved='1' and payment_advisor_id='".$_GET[md5('advisor_id')]."' ";		
	    $PAYMENT_QUERY.=" and payment_date between '$pay_sdate' and '$pay_edate' "; 
		$PAGINATION_QUERY=$PAYMENT_QUERY."  order by payment_date ";
		$PAYMENT_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PAYMENT_QUERY=@mysqli_query($_SESSION['CONN'],$PAYMENT_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PAYMENT_QUERY);

while($PAYMENT_ROWS=@mysqli_fetch_assoc($PAYMENT_QUERY)) 
{
	

?>
        <tr>
          <td><div align="center"><?php echo $k++;?>.</div></td>
          <td><div align="center" style="width:80PX;"><?php echo date('d-M-Y',strtotime($PAYMENT_ROWS['payment_date'])); ?></div></td>
          <td><div align="right"><?php echo @number_format($PAYMENT_ROWS['payment_amount'],2);$total_payment+=$PAYMENT_ROWS['payment_amount'];?></div></td>
          <td width="11%"><div align="right"><?php echo $PAYMENT_ROWS['payment_mode'];?></div></td>
          <td width="16%"><?php echo $PAYMENT_ROWS['payment_mode_no'];?></td>
          <td width="16%"><?php echo $PAYMENT_ROWS['payment_mode_bank'];?></td>
          <td width="6%" style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_mode_date'];?></td>
          <td width="11%" style="text-align:center;"><?php echo $PAYMENT_ROWS['payment_remark'];?></td>
        </tr>
        <?php } ?>
        <tr>
          <th colspan="2">TOTAL</th>
          <th><div align="right">
            <?php echo @number_format($total_payment,2);?>
          </div></th>
          <th colspan="5">&nbsp;</th>
        </tr>
      </table>
      </center>