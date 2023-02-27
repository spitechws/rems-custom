<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
include_once("../php/SpitechBulkSMS.php");
Menu("Advisor");
NoUser();

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

if(isset($_GET[md5('edit_id')])) 
{ 	
	$EDIT_ROW=$DBOBJ->GetRow('tbl_advisor_payment','payment_id',$_GET[md5('edit_id')]);
	$ADVISOR_ID=$EDIT_ROW['payment_advisor_id'];	
}

$ADVISOR_ROW=$DBOBJ->GetRow('tbl_advisor','advisor_id',$ADVISOR_ID);
$NETT_COM=$DBOBJ->AdvisorNetCommission($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
$PAID=$DBOBJ->AdvisorTotalPaid($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
$BAL=$NETT_COM-$PAID;

if(isset($_POST['Save']))
{
	
        $FIELDS=array("payment_advisor_id" ,
						"payment_amount" ,
						"payment_date" ,
						"payment_mode" ,
						"payment_mode_no" ,
						"payment_mode_bank" ,
						"payment_mode_date" ,
						"payment_remark" ,
						"created_details" ,
						"edited_details",
						"approved");	
		if(isset($_GET[md5('edit_id')]))
		{	
		    $VALUES=array($ADVISOR_ID ,
							$_POST["payment_amount"] ,
							$_POST["payment_date"] ,
							$_POST["payment_mode"] ,
							$_POST["payment_mode_no"] , 
							$_POST["payment_mode_bank"] ,
							$_POST["payment_mode_date"] ,
							$_POST["payment_remark"] ,
							$EDIT_ROW['created_details'],
							CreatedEditedByUserMessage(),
							"0");					
			$DBOBJ->Update("tbl_advisor_payment",$FIELDS,$VALUES,"payment_id",$_GET[md5('edit_id')],0);

		}
		else
		{
	    	$VALUES=array($_GET[md5("payment_advisor_id")] ,
							$_POST["payment_amount"] ,
							$_POST["payment_date"] ,
							$_POST["payment_mode"] ,
							$_POST["payment_mode_no"] , 
							$_POST["payment_mode_bank"] ,
							$_POST["payment_mode_date"] ,
							$_POST["payment_remark"] ,
							$Mess=CreatedEditedByUserMessage(),
							$Mess,
							"0");					
			$DBOBJ->Insert("tbl_advisor_payment",$FIELDS,$VALUES,0);
			
			    $MESSEGE="DEAR Associate ".$ADVISOR_ROW['advisor_title']." ".$ADVISOR_ROW['advisor_name'].", ".$ADVISOR_ROW['advisor_code'].", THE COMMISSION PAYMENT OF RS. ".@number_format($_POST["payment_amount"],2)." IS READY TO RECEIVE, PLEASE COLLECT FROM OFFICE.  PLEASE IGNORE IF ALREADY RECEIVED. ".site_company_name ;
	
				if($ADVISOR_ROW['advisor_mobile']!='0' ||$ADVISOR_ROW['advisor_mobile']!=' ' || $ADVISOR_ROW['advisor_mobile']!='' )
				{
				   SendSMS($ADVISOR_ROW['advisor_mobile'],strtoupper($MESSEGE));
				}  					
				
		}
		
$DBOBJ->UserAction("PAID TO ADVIOR", "CODE : ".$ADVISOR_ROW['advisor_code'].", NAME : ".$ADVISOR_ROW['advisor_code'].", AMOUNT : ".$_POST["payment_amount"]);		
header("location:Advisor_Payment_Entry.php?payment_advisor_id=".$ADVISOR_ID);	
}

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />

<center>
<h1><img src="../SpitechImages/ReceivePayment.png" width="31" height="32" />Project  : <span>Receive Payment</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("Entry","block"); ?>" ><img src="../SpitechImages/ReceivePayment.png" />Make Payment</A>
</h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">  
    <center> 
   <fieldset style="width:550PX;display:<?php if(isset($_GET[md5('edit_id')]) || isset($_GET[md5('payment_advisor_id')])) { echo "block;"; } else { echo "none;"; };?>" id="Entry"><legend> Receive Payment : </legend>
   <table width="98%" border="0" cellspacing="0"  style="border:0PX;" id="SimpleTable">
   
  <tr>
    <td width="90"><?php echo advisor_title?></td>
    <td colspan="2"><form id='PaymentForm' name="PaymentForm" method="get">
    <select name="<?php echo md5('payment_advisor_id');?>" id="<?php echo md5('payment_advisor_id');?>" onchange="PaymentForm.submit();">
      <?php if(!isset($_GET[md5('edit_id')])) {?><option value="">Select <?php echo advisor_title?>...</option><?php } ?>
      <?php 
			   $ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			   if(isset($_GET[md5('edit_id')])) {$ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor where advisor_id='".$EDIT_ROW['payment_advisor_id']."'"; }
			   $ADVISOR_Q=@mysqli_query($_SESSION['CONN'],$ADVISOR_Q);
			   while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_Q)) {?>
      <option value="<?php echo $ADVISOR_ROWS['advisor_id'];?>" <?php SelectedSelect($ADVISOR_ROWS['advisor_id'],$ADVISOR_ID); ?>>
      <?php echo $ADVISOR_ROWS['advisor_name']." [".$ADVISOR_ROWS['advisor_code']." ]";?> </option>
      <?php } ?>
    </select>
    </form></td>
    <td width="149" rowspan="8" style="line-height:13px; text-align:center;vertical-align:top;font-size:10px;">
      
      <?php $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$ADVISOR_ROW['advisor_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		  if(!isset($_GET[md5('payment_advisor_id')]))  { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		  
		 ?><img src="<?php  echo $ACTUAL_PHOTO; ?>" alt="<?php echo advisor_title?>" width="100" height="120" id="imgBorder"/>
      <br /><?php echo $ADVISOR_ROW['advisor_name'];?>
      
      
      </td>
  </tr>
    <?php if($_GET[md5('payment_advisor_id')]>0  || isset($_GET[md5('edit_id')])) { ?>  
       <form name="EntryForm" id="EntryForm" method="post" >
  <tr>
    <td>NAME</td>
    <td colspan="2" style="color:red;font-size:13px;"><?php echo $ADVISOR_ROW['advisor_name']?></td>
    </tr>
  <tr>
    <td>CODE ID</td>
    <td style="color:blue;font-size:13px;"><?php echo $ADVISOR_ROW['advisor_code']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>TOTAL&nbsp;COMMISSION</td>
    <td width="88" style="color:maroon;font-size:13px;"><div align="right"><?php echo @number_format($NETT_COM,2);?></div></td>
    <td width="200">&nbsp;</td>
  </tr>
  <tr>
    <td>total paid</td>
    <td style="color:green;font-size:13px;"><div align="right"><?php echo @number_format($PAID-$EDIT_ROW['payment_amount'],2);?></div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>balance</td>
    <td style="color:red; font-size:13px;"><div align="right"><?php echo @number_format($BAL+$EDIT_ROW['payment_amount'],2);?></div></td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td>PAYMENT&nbsp;DATE</td>
    <td colspan="2" class="Date"><script>DateInput('payment_date', true, 'yyyy-mm-dd' <?php if(isset($_GET[md5('edit_id')])) { echo ",'".$EDIT_ROW['payment_date']."'"; } ?>);</script></td>
  </tr>
  <tr>
    <td>MODE</td>
    <td colspan="2">
      <select name="payment_mode" id="payment_mode" onchange="HidMe();">
        <option value="CASH" <?php SelectSelected("CASH",$EDIT_ROW['payment_mode']);?>>CASH</option>           
        <option value="CHEQUE" <?php SelectSelected("CHEQUE",$EDIT_ROW['payment_mode']);?>>CHEQUE</option>
        <option value="DD" <?php SelectSelected("DD",$EDIT_ROW['payment_mode']);?>>DD</option>
        <option value="FT" <?php SelectSelected("FT",$EDIT_ROW['payment_mode']);?>>FT</option>
      </select></td>
    </tr>

  <tr id="hide" style="display:<?php if($EDIT_ROW['payment_mode']=="CASH" || !isset($_GET[md5('edit_id')])) { echo "none"; } else { echo "table-row"; } ?>">
    <td>PAYMENT&nbsp;DETAILS</td>
    <td colspan="2">
      
      <table width="98%" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td width="26%"><div align="left">NO</div></td>
          <td width="74%"><div align="left">
            <input type="text" name="payment_mode_no" id="payment_mode_no" placeholder="DD/CHEQUE/TXN NO" maxlength="25" value="<?php echo $EDIT_ROW['payment_mode_no']?>" />
            </div></td>
          </tr>
        <tr>
          <td><div align="left">Bank</div></td>
          <td><div align="left">
            <input type="text" name="payment_mode_bank" id="payment_mode_bank" placeholder="FROM BANK"   value="<?php echo $EDIT_ROW['payment_mode_no']?>" />
            </div></td>
          </tr>
        <tr>
          <td height="32"><div align="left">Date</div></td>
          <td class="Date"><div align="left">
            <script>DateInput('payment_mode_date', true, 'yyyy-mm-dd'<?php if(isset($_GET[md5('edit_id')])) { echo ",'".$EDIT_ROW['payment_mode_date']."'"; } ?>);</script>
            </div></td>
          </tr>
        </table>
      
    </td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>PAYING AMOUNT</td>
    <td colspan="2">
      <input type="text" name="payment_amount" placeholder="AMOUNT"  value="<?php if(isset($_GET[md5('edit_id')])) { echo $EDIT_ROW['payment_amount'];} else { echo "0"; }?>"  id="payment_amount" style="text-align:right; width:105px; font-size:14PX; background:green; color:white;" required='required' <?php OnlyFloat(); ?> maxlength="18" onchange="Calc();" onkeyup="Calc();" /></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>BALANCE</td>
    <td  style="color:red; font-size:13px;"><div align="right"><SPAN id="Bal">
      <?php echo @number_format($BAL,2);?>
    </SPAN></div></td>
    <td  style="color:red; font-size:13px;">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>REMARKS</td>
    <td colspan="3"><input type="text" name="payment_remark" id="payment_remark" placeholder="PAYMENT REMARKS IF ANY " maxlength="100" style="width:450px;" /></td>
  </tr>
        <tr>
          <td colspan="4">
            <div align="center">
              <input type="submit" name="Save" id="Save" value="Save Payment Details" <?php Confirm("Are You Sure ? Save Payment Details ?"); ?>/>
              <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.location='Advisor_Payment_Entry.php';" />
              </div>
            </td>
          <td width="5" style="text-align:RIGHT">&nbsp;</td>
        </tr></form>
    <?php } ?>
   </table>

  </fieldset>
  
  <?php ErrorMessage(); ?>
     <form name="FindForm" id="FindForm" method="get" >
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
      <tr>
        <td width="51"><?php echo advisor_title?></td>
        <td width="202">
          <select name="payment_advisor_id" id="payment_advisor_id" >
            <option value="All">All <?php echo advisor_title?>...</option> 
            <?php 
			   $SPONSOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			   $SPONSOR_Q=@mysqli_query($_SESSION['CONN'],$SPONSOR_Q);
			   while($SPONSOR_ROWS=@mysqli_fetch_assoc($SPONSOR_Q)) {?>
            <option value="<?php echo $SPONSOR_ROWS['advisor_id'];?>" <?php SelectedSelect($SPONSOR_ROWS['advisor_id'], $_GET['payment_advisor_id']); ?>>
              <?php echo $SPONSOR_ROWS['advisor_name']." [".$SPONSOR_ROWS['advisor_code']." ]";?>
              </option>
            <?php } ?>       
          </select></td>
          <td width="47" height="30">FROM</td>
            <td width="42" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd','<?php echo $s_date?>')</script></td>
            <td width="34">TO</td>
            <td width="34" class="Date"><script>DateInput('e_date', true, 'yyyy-mm-dd','<?php echo $e_date?>')</script></td>
        <td width="98">
          <input type="submit" name="Search" value=" " id="Search" /></td>
        <td width="749">
        <input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='Advisor_Payment_Entry.php'" style="width:80px;"/></td>
      
      </tr>
     
      </table>

  </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
      <tr>
    <th width="2%" rowspan="2">#</th>
    <th width="3%" rowspan="2">ID&nbsp;CODE</th>
    <th width="17%" rowspan="2">NAME</th>
    <th width="7%" rowspan="2">LEVEL</th>
    <th width="7%" rowspan="2">PAYMENT DATE</th>
    <th width="7%" rowspan="2">PAYMENT</th>
    <th colspan="5">PAYMENT DETAILS</th>
    <th width="7%" rowspan="2" id="Action">ACTION</th>
  </tr>
      <tr>
        <th>MODE</th>
        <th>DD/CHECK/TXN&nbsp;NO</th>
        <th>BANK</th>
        <th>DATE</th>
        <th>payment&nbsp;remarks</th>
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
    <td id="Action"><div align="center" style="width:80px;"> 
      
      
      <a id="Edit" href="<?php echo "Advisor_Payment_Entry.php?".md5('edit_id')."=".$PAYMENT_ROWS['payment_id'];?>" title="Edit Payment Details Of : <?php echo $ADV_ROW['advisor_name']; ?>">&nbsp;</a> 
      
      
      <a id="Delete" href="Advisor_Payment_Entry.php?<?php echo md5("payment_delete_id")."=".$PAYMENT_ROWS['payment_id']; ?>" <?php Confirm("Are You Sure ? Delete Payment Details ? ".$PAYMENT_ROWS['advisor_name']." ? "); ?>  title="Delete Payment of : <?php echo $ADV_ROW['advisor_name']; ?>">&nbsp;</a>
      
      </div>
      
    </td>
  </tr>
   <?php } ?>
    <tr><th colspan="5">&nbsp;</th>
      <th><div align="right"><?php echo @number_format($total_payment,2);?></div></th>
      <th colspan="5">&nbsp;</th>
      <th id="Action">&nbsp;</th>
      </tr>

</table>
 <div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

  </center></td></tr></table>
   <script>
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

function Calc()
{
	var ID=document.getElementById('Bal');
	
	var balance=parseFloat(<?php echo $BAL+$EDIT_ROW['payment_amount']?>)-parseFloat(document.getElementById('payment_amount').value);
	
	ID.innerHTML=balance.toFixed(2);
}
</script>
<?php 
if(isset($_GET[md5('payment_delete_id')])) 
{
	@mysqli_query($_SESSION['CONN'],"delete from tbl_advisor_payment where payment_id='".$_GET[md5('payment_delete_id')]."'"); 
	header("location:Advisor_Payment_Entry.php?Message=Selected Payment Details Have Been Deleted.");
}
include("../Menu/Footer.php"); 
?>