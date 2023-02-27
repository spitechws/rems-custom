<?php
include_once("../Menu/HeaderAdvisor.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Advisor");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$com_sdate=date('Y-m-01');
$com_edate=date('Y-m-d');

$pay_sdate=date('Y-m-01');
$pay_edate=date('Y-m-d');

if(isset($_GET['PaySearch']))
{
	$pay_sdate=$_GET['pay_sdate'];
	$pay_edate=$_GET['pay_edate'];
}

if(isset($_GET['ComSearch']))
{
	$com_sdate=$_GET['com_sdate'];
	$com_edate=$_GET['com_edate'];
}
$ADVISOR_ID=$_GET[md5('advisor_id')];

$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_GET[md5('advisor_id')]);
$NETT_COM=$DBOBJ->AdvisorNetCommission($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
$PAID=$DBOBJ->AdvisorTotalPaid($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
$BAL=$NETT_COM-$PAID;
$DBOBJ->ValidateAdvisor($_SESSION['advisor_team'] ,$ADVISOR_ID);
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
<center>
<h1><img src="../SpitechImages/Advisor.png" width="31" height="32" /><?php echo advisor_title?>  : <span>Profile</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td width="508"  align="center" style="width:400px; vertical-align:top;">
    <center>
    <h2 style="margin:0px; width:502px;"><?php echo advisor_title?> Profile</h2>
    <fieldset style="width:500px; margin:0px; padding:0px;">
      
      <?php MessageError(); ?>
  <table border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">  
   <tr class="DontPrint">
     <td style="height:35px;"><?php echo advisor_title?></td>
     <td colspan="2" id="Value2" style="color:red; font-size:13px;">
     <form id="AdvisorForm" name="AdvisorForm" method="get" style="margin:0px; margin-top:3px;">
       <select name="<?php echo md5("advisor_id")?>" id="<?php echo md5("advisor_id")?>" onchange="AdvisorForm.submit();">
         <option value="">Select <?php echo advisor_title?>...</option>
         <?php 
			   $ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor where advisor_id in(".$_SESSION["advisor_team"].")ORDER BY advisor_name";
			   $ADVISOR_Q=@mysqli_query($_SESSION['CONN'],$ADVISOR_Q);
			   while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_Q)) {?>
         <option value="<?php echo $ADVISOR_ROWS['advisor_id'];?>" <?php SelectedSelect($ADVISOR_ROWS['advisor_id'], $_GET[md5('advisor_id')]); ?>>
           <?php echo $ADVISOR_ROWS['advisor_name']." [".$ADVISOR_ROWS['advisor_code']." ]";?>
           </option>
         <?php } ?>
       </select>
     </form></td>
   </tr>
  
   <tr>
     <td colspan="3"><hr /></td>
     </tr>
   <tr>
     <td><div align="right">total commission</div></td>
     <td width="227" style="color:maroon;font-size:13px;"><div align="right">
       <?php echo @number_format($NETT_COM,2);?>
     </div></td>
     <td id="Value5" style="color:red; font-size:13px;">&nbsp;</td>
   </tr>
   <tr>
     <td><div align="right">tota paid</div></td>
     <td style="color:green;font-size:13px;"><div align="right">
       <?php echo @number_format($PAID,2);?>
     </div></td>
     <td id="Value4" style="color:red; font-size:13px;">&nbsp;</td>
   </tr>
   <tr>
     <td><div align="right">balance</div></td>
     <td style="color:red; font-size:13px;"><div align="right">
       <?php echo @number_format($BAL,2);?>
     </div></td>
     <td id="Value3" style="color:red; font-size:13px;">&nbsp;</td>
   </tr>
    <tr>
     <td colspan="3"><hr /></td>
     </tr>
   <tr>
      <td width="179">name</td>
      <td colspan="2" id="Value" style="color:red; font-size:13px;"><?php echo $ADVISOR_ROW['advisor_title']." ".$ADVISOR_ROW['advisor_name']?></td>
      </tr>
    <tr>
      <td>id code</td>
      <td style="color:RED; font-size:12PX;" id="Value" ><?php echo $ADVISOR_ROW['advisor_code']; ?></td>
      <td width="73" rowspan="9" style="color:RED; font-size:16PX; vertical-align:top; ">
        <?php $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$ADVISOR_ROW['advisor_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || !isset($_GET[md5('advisor_id')]) || $ADVISOR_ROW['advisor_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imgBorder"/>      </td>
      </tr>
    <tr>
         <td>LEVEL</td>
         <td id="Value" style="color:blue"><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROW['advisor_level_id']);?></td>
         </tr>
   
   
    <tr>
      <td style="line-height:12px;">father's/Husband's name </td>
      <td width="227" id="Value" ><?php echo $ADVISOR_ROW['advisor_fname'];?></td>
      </tr>
    <tr>
      <td>sex</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_sex'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">BLOOD GROUP</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_bg'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">mobile no</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_mobile'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">phone no</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_sex'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">email id</td>
      <td id="Value" style="text-transform:none;"><?php echo $ADVISOR_ROW['advisor_email'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">PAN NO</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_pan_no'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">OCCUPATION</td>
      <td colspan="2" id="Value" ><?php echo $ADVISOR_ROW['advisor_occupation'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">qualification</td>
      <td colspan="2" id="Value" ><?php echo $ADVISOR_ROW['advisor_qualification'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">address</td>
      <td colspan="2" id="Value" ><?php echo $ADVISOR_ROW['advisor_address'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">dob</td>
      <td colspan="2" id="Value" ><?php ShowDate($ADVISOR_ROW['advisor_dob']);?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">ANNIVERSARY DATE</td>
      <td colspan="2" id="Value" >&nbsp;<?php ShowDate($ADVISOR_ROW['advisor_anniversary_date']);?></td>
    </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">jOIning date </td>
      <td colspan="2" id="Value" ><?php ShowDate($ADVISOR_ROW['advisor_hire_date']);?></td>
      </tr>
     <tr>
      <td>status</td>
      <td style="background:<?php if($ADVISOR_ROW['advisor_status']) { echo "green"; $status="ACTIVE"; } else { echo "red"; $status="IN-ACTIVE "; }?>; color:white;" id="Value" ><?php echo $status?></td>
      <td>&nbsp;</td>
      </tr> 
       <tr>
      <td colspan="3"><H4>NAME PROPOSED BY (SPONSOR)</H4></td>
      </tr>
   
      
       <tr>
      <td>SPONSOR NAME <span style="line-height:13px; text-align:justify;"></span></td>
      <td colspan="2" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_title",$ADVISOR_ROW['advisor_sponsor'])." ".$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$ADVISOR_ROW['advisor_sponsor']); ?>
      </td>
      </tr>
    <tr>
      <td>ID CODE</td>
      <td colspan="2" style="color:RED;" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$ADVISOR_ROW['advisor_sponsor']); ?></td>
      </tr>
     <tr>
         <td>LEVEL</td>
         <td colspan="2" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_level_id",$ADVISOR_ROW['advisor_sponsor']));?></td>
         </tr>
   
   


</table>
</fieldset>
</center>
</td>
  
    <td width="777">
     <h2 style="margin-LEFT:1%; margin-top:0px;">PAYMENT RECEIVED DETAILS</h2>
    <form name="FindForm" id="FindForm" method="get" style="margin-top:-5px;">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
      <tr>
        <td width="47" height="30">FROM</td>
            <td width="42" class="Date"><script>DateInput('pay_sdate', true, 'yyyy-mm-dd','<?php echo $pay_sdate?>')</script></td>
            <td width="34">TO</td>
            <td width="34" class="Date"><script>DateInput('pay_edate', true, 'yyyy-mm-dd','<?php echo $pay_edate?>')</script></td>
        <td width="98">
          <input type="hidden" name="<?php echo md5("advisor_id")?>" id="<?php echo md5("advisor_id")?>" value="<?php echo $_GET[md5("advisor_id")]?>" />
          <input type="submit" name="PaySearch" value=" " id="Search" /></td>
        <td width="749">&nbsp;</td>
      
      </tr>
     
      </table>

  </form>
    <table width="94%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
      <tr>
    <th width="7%" rowspan="2">#</th>
    <th width="11%" rowspan="2">PAYMENT DATE</th>
    <th width="8%" rowspan="2">PAYMENT</th>
    <th colspan="5">PAYMENT DETAILS</th>
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
    <td width="11%"><div align="LEFT"><?php echo $PAYMENT_ROWS['payment_mode'];?></div></td>
    <td width="15%"><?php echo $PAYMENT_ROWS['payment_mode_no'];?></td>
    <td width="12%"><?php echo $PAYMENT_ROWS['payment_mode_bank'];?></td>
    <td width="11%" style="text-align:center;"><div align="center" style="width:80PX;"><?php if($PAYMENT_ROWS['payment_mode']!="CASH") { echo $PAYMENT_ROWS['payment_mode_date'];}?></div></td>
    <td width="25%" ><?php echo $PAYMENT_ROWS['payment_remark'];?></td>
    </tr>
   <?php } ?>
    <tr>
      <th colspan="2">TOTAL</th>
      <th><div align="right"><?php echo @number_format($total_payment,2);?></div></th>
      <th colspan="5">&nbsp;</th>
      </tr>

</table>
 <div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>
    </td>
  </tr>
  <tr>
    <td colspan="3"  align="center" style="width:400px; vertical-align:top;">
    <h2 style="margin-top:0px;">Commission Statement</h2>
    
     <form name="FindCom" id="FindCom" method="get" style="margin-top:-10px;" >       
       <table width="98%" id="CommonTable"  cellspacing="0" class="DontPrint" style="margin-top:10px;">       
         <tr >
           <td height="30">FROM</td>
           <td width="68" class="Date"><script>DateInput('com_sdate', true, 'yyyy-mm-dd','<?php echo $com_sdate?>')</script></td>
           <td width="64">TO</td>
           <td width="35" class="Date"><script>DateInput('com_edate', true, 'yyyy-mm-dd','<?php echo $com_edate?>')</script></td>
           <td colspan="2">
           <input type="hidden" name="<?php echo md5("advisor_id")?>" id="<?php echo md5("advisor_id")?>" value="<?php echo $_GET[md5("advisor_id")]?>" />
           <input type="submit" name="ComSearch" id="Search" value="  "  /></td>
           <td width="735" style="text-transform:capitalize">&nbsp;</td>
           </tr>       
       </table></form>
      <table width="98%" border="0" cellspacing="1" id="SearchTable" style="margin-top:0px;width:">
        <tr>
          <td width="67%" id="Field">Commission&nbsp;Statement&nbsp;Of&nbsp;:&nbsp;<font color="#009900">
            <?php echo $ADVISOR_ROW['advisor_title']." ".$ADVISOR_ROW['advisor_name']?></font>
            </td>
          <td width="10%" id="Field">from&nbsp;date&nbsp;:</td>
          
          
          <td width="8%" id="Value"><?php echo date('d-M-Y',strtotime($com_sdate))?></td>
          <td width="7%">to&nbsp;:</td>
          <td width="8%" id="Value"><?php echo date('d-M-Y',strtotime($com_edate))?></td> 
          </tr>
</table>
    
        <table width="98%"  id="Data-Table"  cellspacing="1">
          <tr>
            <th width="18" height="30" rowspan="2">#</th>
            <th width="83" rowspan="2">Voucher</th>
            <th width="61" rowspan="2"> Date</th>
            <th width="83" rowspan="2">Particulars</th>
            <th width="61" rowspan="2">Voucher Amount</th>
            <th width="96" rowspan="2">COMM.</th>
            <th width="70" rowspan="2">TDS</th>
            <th width="115" rowspan="2">NET COMM </th>
            <th colspan="2">Customer&nbsp;DETAILS</th>
            <th colspan="2">BOOKED&nbsp;BY&nbsp;<?php echo advisor_title?></th>
            <th colspan="3">PROJECT DETAILS</th>
            </tr>
          <tr>
            <th width="14">ID</th>
            <th width="152">NAME</th>
            <th>ID</th>
            <th>NAME</th>
            <th>PROJECT</th>
            <th>PROPERTY</th>
            <th>TYPE</th>
            </tr>
          <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		
			
		    $COMMISSION_QUERY="select * FROM tbl_advisor_commission where  approved='1' and commission_advisor_id ='".$_GET[md5('advisor_id')]."' and commission_date between '$com_sdate' and '$com_edate' ";		
						
		
	    
		$PAGINATION_QUERY=$COMMISSION_QUERY."  order by commission_id ";
		$COMMISSION_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$COMMISSION_QUERY=@mysqli_query($_SESSION['CONN'],$COMMISSION_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($COMMISSION_QUERY);
$Hide=0;
while($COMMISSION_ROWS=@mysqli_fetch_assoc($COMMISSION_QUERY)) 
{
		  
	$COLLECTION=$COMMISSION_ROWS['commission_voucher_amount'];	$TOTAL_COLLECTION+=$COLLECTION;
	$COMMISSION=$COMMISSION_ROWS['commission_amount'];	$TOTAL_COMMISSION+=$COMMISSION;
	$TDS=$COMMISSION_ROWS['commission_tds_amount']; 			   $TOTAL_TDS+=$TDS;
	$NETT_COMMISSION=$COMMISSION_ROWS['commission_nett_amount']; $TOTAL_NETT_COMMISSION+=$NETT_COMMISSION;
	
	$CUSTOMER_CODE=$DBOBJ->ConvertToText('tbl_customer','customer_id','customer_code',$COMMISSION_ROWS['commission_customer_id']);
	$CUSTOMER_NAME=$DBOBJ->ConvertToText('tbl_customer','customer_id','customer_name',$COMMISSION_ROWS['commission_customer_id']);
	
	$ADVISOR_CODE=$DBOBJ->ConvertToText('tbl_advisor','advisor_id','advisor_code',$COMMISSION_ROWS['commission_by_advisor_id']);
	$ADVISOR_NAME=$DBOBJ->ConvertToText('tbl_advisor','advisor_id','advisor_name',$COMMISSION_ROWS['commission_by_advisor_id']);
	
	$PROJECT_NAME=$DBOBJ->ConvertToText('tbl_project','project_id','project_name',$COMMISSION_ROWS['commission_project_id']);
	$PROPERTY_NO=$DBOBJ->ConvertToText('tbl_property','property_id','property_no',$COMMISSION_ROWS['commission_property_id']);
	$PROPERTY_TYPE=$DBOBJ->PropertyTypeName($COMMISSION_ROWS['commission_property_id']);
	
	
	$COL="BLACK";
	if($COMMISSION>0) { $COL="MAROON"; }
	elseif($COMMISSION<0) { $COL="RED"; }	
		  
?>
          <tr <?php if($COMMISSION=="0" ||$COMMISSION==""  ||$COMMISSION==NULL) { echo "id=Hide".$Hide++; } ?>>
            <td height="22"><div align="center"><?php echo $k++?>.</div></td>
            <td><?php echo $COMMISSION_ROWS['commission_voucher_no'];?></td>
            <td><div align="center" style="width:78PX;"><?php echo date('d-M-Y',strtotime($COMMISSION_ROWS['commission_date']));?></div></td>
            <td><div align="left" style="width:100PX;"><?php echo $COMMISSION_ROWS['commission_particular'];?></div></td>
            <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($COLLECTION,2);?></td>
            <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($COMMISSION,2);?></td>
            <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($TDS,2);?></td>
            <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($NETT_COMMISSION,2);?></td>
            <td><div align="center" style="width:78PX;"><?php echo $CUSTOMER_CODE?></div></td>
            <td><div align="left" style="width:150PX;"><?php echo $CUSTOMER_NAME?></div></td>
            <td width="26"><div align="center" style="width:78PX;"><?php echo $ADVISOR_CODE?></div></td>
            <td width="145"><div align="left" style="width:150PX;"><?php echo $ADVISOR_NAME?></div></td>
            <td width="178"><div align="left" style="width:100px;"><?php echo $PROJECT_NAME?></div></td>
            <td width="64" style="text-align:center"><?php echo $PROPERTY_NO?></td>
            <td width="39" style="text-align:center"><?php echo $PROPERTY_TYPE?></td>
            </tr>       
          <?php } ?>      
          <tr>
            <th height="22" colspan="4"><div align="right">TOTAL </div></th>
            <th style="text-align:right"><?php echo @number_format($TOTAL_COLLECTION,2);?></th>
            <th style="text-align:right"><?php echo @number_format($TOTAL_COMMISSION,2);?></th>
            <th style="text-align:right"><?php echo @number_format($TOTAL_TDS,2);?></th>
            <th style="text-align:right"><?php echo @number_format($TOTAL_NETT_COMMISSION,2);?></th>
            <th colspan="7" style="text-align:right">&nbsp;</th>
            </tr>
          </table>   
      </div>
     <div class="paginate DontPrint" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>
        </tr>
</table>
</center>
<?php 
if(isset($_GET[md5('payment_delete_id')])) 
{
	@mysqli_query($_SESSION['CONN'],"delete from tbl_advisor_payment where payment_id='".$_GET[md5('payment_delete_id')]."'"); 
	header("location:Advisor_Profile.php?".md5('advisor_id')."&Message=Selected Payment Details Have Been Deleted.");
}
include("../Menu/Footer.php"); ?>