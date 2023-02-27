<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
NoUser();
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
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<form name="FindForm" id="FindForm" method="get" style="margin-top:0px;">
<?php ErrorMessage(); ?>
        <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
          <tr>
            <td width="47" height="30">FROM</td>
            <td width="42" class="Date"><script>DateInput('pay_sdate', true, 'yyyy-mm-dd','<?php echo $pay_sdate?>')</script></td>
            <td width="34">TO</td>
            <td width="34" class="Date"><script>DateInput('pay_edate', true, 'yyyy-mm-dd','<?php echo $pay_edate?>')</script></td>
            <td width="98"><input type="hidden" name="<?php echo md5("advisor_id")?>2" id="<?php echo md5("advisor_id")?>2" value="<?php echo $_GET[md5("advisor_id")]?>" />
              <input type="submit" name="PaySearch" value=" " id="Search" /></td>
            <td width="46" id="Export" ><?php echo ExportPrintLink()?></td>
          </tr>
        </table>
      </form>
      <table width="94%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
        <tr>
          <th width="2%" rowspan="2">#</th>
          <th width="6%" rowspan="2">PAYMENT DATE</th>
          <th width="26%" rowspan="2">PAYMENT</th>
          <th colspan="5">PAYMENT DETAILS</th>
          <th width="6%" rowspan="2" id="Action">ACTION</th>
        </tr>
        <tr>
          <th>MODE</th>
          <th>DD/CHECK/TXN&nbsp;NO</th>
          <th>BANK</th>
          <th>DATE</th>
          <th>remarks</th>
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
          <td id="Action">
          <div align="center" style="width:80px;">
          
          <a id="Edit" href="<?php echo "Advisor_Payment_Entry.php?".md5('edit_id')."=".$PAYMENT_ROWS['payment_id'];?>" title="Edit Payment Details Of : <?php echo $ADV_ROW['advisor_name']; ?>" target="_parent">&nbsp;</a>
          
          <a id="Delete" href="Advisor_Profile_Payment_List.php?<?php echo md5("payment_delete_id")."=".$PAYMENT_ROWS['payment_id']."&".md5('advisor_id')."=".$_GET[md5('advisor_id')]; ?>" <?php Confirm("Are You Sure ? Delete Payment Details ? ".$PAYMENT_ROWS['advisor_name']." ? "); ?>  title="Delete Payment of : <?php echo $ADV_ROW['advisor_name']; ?>">&nbsp;</a>
          
          </div>
          </td>
        </tr>
        <?php } ?>
        <tr>
          <th colspan="2">TOTAL</th>
          <th><div align="right">
            <?php echo @number_format($total_payment,2);?>
          </div></th>
          <th colspan="5">&nbsp;</th>
          <th id="Action">&nbsp;</th>
        </tr>
      </table>
      <div class="paginate" >
        <?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?>
      </div>
<?php 
if(isset($_GET[md5('payment_delete_id')])) 
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_advisor_payment","payment_id",$_GET[md5("payment_delete_id")]);	
	
	$advisor=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$DELETE_ROW['payment_advisor_id']);
	
	@mysqli_query($_SESSION['CONN'],"delete from tbl_advisor_payment where payment_id='".$_GET[md5('payment_delete_id')]."'"); 
	
	$DBOBJ->UserAction(advisor_title." PAYMENT DELETED","NAME : ".$advisor.", AMOUNT : ".$DELETE_ROW['payment_amount']);	
	
	header("location:Advisor_Profile_Payment_List.php?".md5('advisor_id')."=".$_GET[md5('payment_delete_id')]."&Message=Selected Payment Details Have Been Deleted.");
}
?>      