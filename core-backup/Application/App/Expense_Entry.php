<?php
session_start();
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
NoUser();

	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();
	
	$EDIT_ROW=$DBOBJ->GetRow("tbl_expense","expense_id",$_GET[md5("edit_id")]);	
	
	if(isset($_POST['Submit']))
	{			  
		
		$FIELDS=array("expense_category_id" ,
						"expense_sub_category_id" ,
						"expense_party" ,
						"expense_credit_debit" ,
						"expense_amount" ,
						"expense_date" ,
						"payment_mode" ,
						"payment_no" ,
						"payment_bank" ,
						"payment_mode_date" ,
						"expense_note");				
		
		$VALUES=array(  $_POST["category_id"] ,
						$_POST["sub_category_id"] ,
						$_POST["expense_party"] ,
						$_POST["expense_credit_debit"] ,
						$_POST["expense_amount"] ,
						$_POST["expense_date"] ,
						$_POST["payment_mode"] ,
						$_POST["payment_no"] ,
						$_POST["payment_bank"] ,
						$_POST["payment_mode_date"],
						$_POST["expense_note"]);
		
		if($_GET[md5("edit_id")]>0)
		{
		    $UPDATE=$DBOBJ->Update("tbl_expense",$FIELDS,$VALUES,"expense_id",$_GET[md5("edit_id")],1);
			$MaxID=$_GET[md5("edit_id")];
			
		  //=============( ENTRY IN ACTION TABLE )=======================================================
		  $DBOBJ->UserAction("EXPENSE EDITED", "OLD AMOUNT ".$EDIT_ROW['expense_amount'].", NEW : ".$_POST['expense_amount']);
			
		}
		else
		{
			$INSERT=$DBOBJ->Insert("tbl_expense",$FIELDS,$VALUES,0);
			$MaxID=$DBOBJ->MaxID("tbl_expense","expense_id" );
			 //=============( ENTRY IN ACTION TABLE )=======================================================
		      $DBOBJ->UserAction("EXPENSE ADDED", "AMOUNT : ".$_POST['expense_amount']);
		}
		
		UnloadMe();
	}
	
	 
	 if($_GET[md5("edit_id")]>0) 
	 {
		$title="Edit";
		$expense_date=$EDIT_ROW['expense_date'];
		$payment_mode_date=$EDIT_ROW['payment_mode_date'];		
		$CATEGORY_ID=$EDIT_ROW['expense_category_id'];
	 } 
	 else 
	 { 
	 	$title=""; 
		$expense_date=date('Y-m-d');
		$payment_mode_date=date('Y-m-d');			
		$CATEGORY_ID="";
	 } 
	
?><head><title><?php echo $title; ?> Payment Receive Entry</title></head>

<link href="../css/AppStyle.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="../calender/calendarDateInput.js"></script>
  <center>
<form name="PaymentForm" id="PaymentForm" method="post" enctype="multipart/form-data" style="margin:0px; padding:0px;" >

    <center>
    <fieldset style="width:400px;"><legend>Expense Entry Form : </legend>
    <table width="350" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;" align="center">
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
 
  <tr>
    <td>CATEGORY</td>
    <td colspan="2">
    <select id="category_id" name="category_id" required='' onchange="GetPage('GetExpenseSubCategory.php?category_id='+this.value+'&sub_category_id=<?php echo $EDIT_ROW['expense_sub_category_id']?>','sub');">
    <option value="">SELECT EXPENSE CATEGORY...</option>
      <?php $Q=@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_expense_category order by category_name");
		   while($CAT_ROWS=@mysqli_fetch_assoc($Q)) { ?>
      <option value="<?php echo $CAT_ROWS['category_id']; ?>" <?php SelectedSelect($CAT_ROWS['category_id'],$EDIT_ROW['expense_category_id']); ?>>
        <?php echo $CAT_ROWS['category_name'];?>
        </option>
      <?php } ?>
    </select>
    </td>
    </tr>
    
    <tr>
    <td>SUB&nbsp;CATEGORY</td>
    <td colspan="2">
    <div id="sub">
    <select id="sub_category_id" name="sub_category_id" required=''>
      <?php $Q=@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_expense_sub_category where category_id='".$CATEGORY_ID."' order by sub_category_name");
		   while($CAT_ROWS=@mysqli_fetch_assoc($Q)) { ?>
      <option value="<?php echo $CAT_ROWS['sub_category_id']; ?>" <?php SelectedSelect($CAT_ROWS['sub_category_id'],$EDIT_ROW['expense_sub_category_id']); ?>>
        <?php echo $CAT_ROWS['sub_category_name'];?>
        </option>
      <?php } ?>
    </select>
    </div>
    </td>
    </tr>
 
  <tr>
    <td>against&nbsp;party</td>
    <td colspan="2">
    <input type="text" name="expense_party" id="expense_party" placeholder="NAME OF PARTY" required="required" value="<?php echo $EDIT_ROW['expense_party']; ?>"  />
    </td>
  </tr>
  <tr>
    <td style="vertical-align:top;">date</td>
    <td colspan="2" class="Date"><script>DateInput('expense_date', true, 'yyyy-mm-dd', '<?php echo $expense_date; ?>');</script></td>
  </tr>
   <tr>
    <td style="vertical-align:top;">amount</td>
    <td colspan="2">
    <input type="text" name="expense_amount" id="expense_amount" placeholder="AMOUNT" required="required" value="<?php echo $EDIT_ROW['expense_amount'];?>"  <?php OnlyFloat(); ?> />
    </td>
  </tr>
   <tr>
     <td>TYPE</td>
     <td colspan="2">
      <select name="expense_credit_debit" id="expense_credit_debit" required=''>
      	<option value="Debit">Debit</option>   
      </select>
     </td>
   </tr>
   <tr>
    <td>mode</td>
    <td colspan="2">
    <select name="payment_mode" id="payment_mode" onchange="HidMe();">
      <option value="CASH" <?php SelectedSelect("CASH",$EDIT_ROW['payment_mode']); ?>>CASH</option>           
      <option value="CHEQUE" <?php SelectedSelect("CHEQUE",$EDIT_ROW['payment_mode']); ?>>CHEQUE</option>     
      <option value="DD" <?php SelectedSelect("DD",$EDIT_ROW['payment_mode']); ?>>DD</option>
      <option value="FT" <?php SelectedSelect("FT",$EDIT_ROW['payment_mode']); ?>>FT</option>
      <option value="CHALLAN" <?php SelectedSelect("CHALLAN",$EDIT_ROW['payment_mode']); ?>>CHALLAN</option>
   </select>
  </td>
    </tr>
  <tr id="hide" style=" display:<?php if($EDIT_ROW['payment_mode']=="CASH" || $EDIT_ROW['payment_mode']=="") { echo "none"; } else {echo "table-row"; }  ?>;">
    <td><div align="right">payment&nbsp;details</div></td>
    <td colspan="2">
    <table width="98%" border="0" cellspacing="4" cellpadding="0">
      <tr>
        <td width="26%"><div align="left">NO</div></td>
        <td width="74%"><input type="text" name="payment_no" id="payment_no" placeholder="CHALLAN/DD/CHEQUE/TXN NO" value="<?php echo $EDIT_ROW['payment_no']; ?>" /></td>
      </tr>
      <tr>
        <td><div align="left">Bank</div></td>
        <td><input type="text" name="payment_bank" id="payment_bank" placeholder="FROM BANK"  value="<?php echo $EDIT_ROW['payment_bank']; ?>" /></td>
      </tr>
      <tr>
        <td><div align="left">Date</div></td>
        <td class="Date"><script>DateInput('payment_mode_date', true, 'yyyy-mm-dd', '<?php echo $payment_mode_date; ?>');</script></td>
      </tr>
    </table></td>
  </tr>
  
 
  <tr>
    <td style="vertical-align:top;">remarks</td>
    <td colspan="2">
    
    <textarea name="expense_note" id="expense_note" placeholder="Remarks"><?php echo $EDIT_ROW['expense_note']; ?></textarea>
  
  </td>
    </tr>
  <tr>
    <td colspan="3" style="text-align:RIGHT">
      <input type="submit" name="Submit" id="Submit" value="Save Expense Details" <?php Confirm("Are You Sure ? Save Payment Details ?"); ?>/>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
      </td>
  </tr>

</table></fieldset></center></form></center>
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
</script>
