<?php
session_start();
if($_SESSION['spitech_user_id']=="" || !$_SESSION['spitech_user_id']) { header("location:index.php"); }
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../php/SpitechBulkSMS.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

if(isset($_POST['Set']))
{
		@mysqli_query($_SESSION['CONN'],"delete from tbl_spitech_sms_server");
		
	 	$FIELDS=array(  'sms','sms_url' ,
						'mobile_parameter' ,
						'message_parameter' ,
						'mobile_prefix',
						'parameter1' ,
						'value1' ,
						'parameter2' ,
						'value2' ,
						'parameter3' ,
						'value3' ,
						'parameter4' ,
						'value4' ,
						'parameter5' ,
						'value5' ,
						'balance_url' ,
						'bparameter1' ,
						'bvalue1' ,
						'bparameter2' ,
						'bvalue2' ,
						'bparameter3' ,
						'bvalue3' ,
						'bparameter4' ,
						'bvalue4' );											
		$VALUES=array($_POST['sms'], $_POST['sms_url'] ,
						$_POST['mobile_parameter'] ,
						$_POST['message_parameter'] ,
						$_POST['mobile_prefix'], 
						$_POST['parameter1'] ,
						$_POST['value1'] ,
						$_POST['parameter2'] ,
						$_POST['value2'] ,
						$_POST['parameter3'] ,
						$_POST['value3'] ,
						$_POST['parameter4'] ,
						$_POST['value4'] ,
						$_POST['parameter5'] ,
						$_POST['value5'] ,
						$_POST['balance_url'] ,
						$_POST['bparameter1'] ,
						$_POST['bvalue1'] ,
						$_POST['bparameter2'] ,
						$_POST['bvalue2'] ,
						$_POST['bparameter3'] ,
						$_POST['bvalue3'] ,
						$_POST['bparameter4'] ,
						$_POST['bvalue4']);	
		
		$DBOBJ->Insert("tbl_spitech_sms_server",$FIELDS,$VALUES,1); 
		
		header("location:SMS_Server_Settings.php?Message=Data Saved Successfully");	
	
} 
$EDIT_ROW=$DBOBJ->GetRow("tbl_spitech_sms_server","1","1");
?>
<link rel="stylesheet" href="../css/SpitechStyle.css">
<style>
input { margin:2px; width:98%; }
#CommonTable tr td { background:white; }
</style>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="CommonTable" style="margin:0px; width:100%; height:100%; border:0px;">
<tr><th style="height:40px;"><div align="left">SMS Server Settings</div></th></tr>
  <tr>
    <td style="height:100%; vertical-align:top;">
<form name="form2" id="form2" method="post">
<table width="98%" align="center" border="0" cellspacing="1" cellpadding="0" style="width:900px;" id="Data-Table">

  <tr><td height="22" colspan="9"> <?php ErrorMessage(); ?></td></tr>
    
  <tr>
    <th height="10" colspan="4">SMS PARAMETER SETTINGS</th>
    <th width="10" rowspan="11" style="background:gray;">&nbsp;</th>
    <th colspan="4" rowspan="2">SMS BALANCE CHECKING PARAMETER</th>
    </tr>
  <tr>
    <th height="11" colspan="4">
     <label style="color:<?php if($EDIT_ROW['sms']=='1') { echo "green" ; } else { echo "red"; } ?>;">
    <input type="checkbox" name="sms" id="sms" value="1" <?php if($EDIT_ROW['sms']=='1') { echo " checked='checked' " ; } ?> placeholder="SEND SMS" style="width:25px;"/>
     Activate SMS (Enable SMS Sending Process)
    </label>
    </th>
  </tr>
    
  <tr>
    <td width="119" height="22"><div align="left">sms_url</div></td>
    <td colspan="3">
      <input type="input" name="sms_url" id="sms_url" value="<?php echo $EDIT_ROW['sms_url']?>" placeholder="SMS Sending Page"  required maxlength="100"/>
    </td>
    <td width="68" height="22"><div align="left">balance_url</div></td>
    <td colspan="3"><input type="input" name="balance_url" id="balance_url" value="<?php echo $EDIT_ROW['balance_url']?>" placeholder="SMS Balance Page"  maxlength="100"/></td>
    </tr>
  <tr>
    <td height="22"><div align="left">mobile_parameter</div></td>
    <td colspan="3"><input type="input" name="mobile_parameter" id="mobile_parameter" value="<?php echo $EDIT_ROW['mobile_parameter']?>" placeholder="Name Of Mobile Parameter"  required maxlength="100"/></td>
    <th height="22" colspan="4">other</th>
    </tr>
  <tr>
    <td height="22"><div align="left">message_parameter</div></td>
    <td colspan="3"><input type="input" name="message_parameter" id="message_parameter" value="<?php echo $EDIT_ROW['message_parameter']?>" placeholder="Name Of Message Parameter"   maxlength="100"/></td>
    <td height="22"><div align="left">parameter1</div></td>
    <td width="182"><input type="input" name="bparameter1" id="bparameter1" value="<?php echo $EDIT_ROW['bparameter1']?>" placeholder="bparameter 1"   maxlength="100"/></td>
    <td width="10"><div align="left">=</div></td>
    <td width="152"><input type="input" name="bvalue1" id="bvalue1" value="<?php echo $EDIT_ROW['bvalue1']?>" placeholder="Value 1"  maxlength="100"/></td>
    </tr>
  <tr>
    <td height="22"><div align="left">mobile_prefix</div></td>
    <td colspan="3"><input type="input" name="mobile_prefix" id="mobile_prefix" value="<?php echo $EDIT_ROW['mobile_prefix']?>" placeholder="Like +91"   maxlength="100"/></td>
    <td height="22"><div align="left">parameter2</div></td>
    <td><input type="input" name="bparameter2" id="bparameter2" value="<?php echo $EDIT_ROW['bparameter2']?>" placeholder="Parameter 2"   maxlength="100"/></td>
    <td><div align="left">=</div></td>
    <td><input type="input" name="bvalue2" id="bvalue2" value="<?php echo $EDIT_ROW['bvalue2']?>" placeholder="Value 2"  maxlength="100"/></td>
    </tr>
  <tr>
    <th height="22" colspan="4">OTHER</th>
    <td height="22"><div align="left">parameter3</div></td>
    <td><input type="input" name="bparameter3" id="bparameter3" value="<?php echo $EDIT_ROW['bparameter3']?>" placeholder="Parameter 3"   maxlength="100"/></td>
    <td><div align="left">=</div></td>
    <td><input type="input" name="bvalue3" id="bvalue3" value="<?php echo $EDIT_ROW['bvalue3']?>" placeholder="Value 3"  maxlength="100"/></td>
    </tr>
  <tr>
    <td height="22"><div align="left">parameter1</div></td>
    <td width="152"><input type="input" name="parameter1" id="parameter1" value="<?php echo $EDIT_ROW['parameter1']?>" placeholder="Parameter 1"   maxlength="100"/></td>
    <td width="10"><div align="left">=</div></td>
    <td width="176"><input type="input" name="value1" id="value1" value="<?php echo $EDIT_ROW['value1']?>" placeholder="Value 1"  maxlength="100"/></td>
    <td height="22"><div align="left">parameter4</div></td>
    <td><input type="input" name="bparameter4" id="bparameter4" value="<?php echo $EDIT_ROW['bparameter4']?>" placeholder="Parameter 4"   maxlength="100"/></td>
    <td><div align="left">=</div></td>
    <td><input type="input" name="bvalue4" id="bvalue4" value="<?php echo $EDIT_ROW['bvalue4']?>" placeholder="Value 4"  maxlength="100"/></td>
    </tr>
  <tr>
    <td height="22"><div align="left">parameter2</div></td>
    <td><input type="input" name="parameter2" id="parameter2" value="<?php echo $EDIT_ROW['parameter2']?>" placeholder="Parameter 2"   maxlength="100"/></td>
    <td><div align="left">=</div></td>
    <td><input type="input" name="value2" id="value2" value="<?php echo $EDIT_ROW['value2']?>" placeholder="Value 2"  maxlength="100"/></td>
    <th colspan="4" rowspan="3">&nbsp;</th>
    </tr>
  <tr>
    <td height="22"><div align="left">parameter3</div></td>
    <td><input type="input" name="parameter3" id="parameter3" value="<?php echo $EDIT_ROW['parameter3']?>" placeholder="Parameter 3"   maxlength="100"/></td>
    <td><div align="left">=</div></td>
    <td><input type="input" name="value3" id="value3" value="<?php echo $EDIT_ROW['value3']?>" placeholder="Value 3"  maxlength="100"/></td>
    </tr>
  <tr>
    <td height="22"><div align="left">parameter4</div></td>
    <td><input type="input" name="parameter4" id="parameter4" value="<?php echo $EDIT_ROW['parameter4']?>" placeholder="Parameter 4"   maxlength="100"/></td>
    <td><div align="left">=</div></td>
    <td><input type="input" name="value4" id="value4" value="<?php echo $EDIT_ROW['value4']?>" placeholder="Value 4"  maxlength="100"/></td>
    </tr>
  <tr>
    <td height="22"><div align="left">parameter5</div></td>
    <td><input type="input" name="parameter5" id="parameter5" value="<?php echo $EDIT_ROW['parameter5']?>" placeholder="Parameter 5"   maxlength="100"/></td>
    <td><div align="left">=</div></td>
    <td><input type="input" name="value5" id="value5" value="<?php echo $EDIT_ROW['value5']?>" placeholder="Value 5"  maxlength="100"/></td>
    <th style="background:gray;">&nbsp;</th>
    <th colspan="4">&nbsp;</th>
  </tr>
  <tr>
    <tH colspan="9" style="text-align:left; text-transform:none;">
    <?php $Message=GetSMSUrl("9907966987","Hello Spitech This Is Test Message"); 
	 echo "<a href='$Message' target='_blank'>".$Message."</a>"
	?>
    </tH>
  </tr>
  <tr>
    <tH colspan="9">
      <div align="right">
        <input type="submit" name="Set" id="Set" value="Save Details" <?php Confirm("Are you Sure ? \\nSave details ?")?> style="width:100px;"/>
        <input type="submit" name="Cancel" id="Cancel" class="Cancel" value="Cancel" onClick="window.location='index.pph?<?php echo md5("Cancel")?>=<?php echo md5("OK")?>' "  style="width:100px;"/>
        
        <input type="button" class="Button" value="Send test sms &rarr;" onclick="var mobile=prompt('Enter your mobile number :\n','9907966987');
        if(!isNaN(parseInt(mobile))) {window.location='<?php echo $_SERVER['PHP_SELF']?>?send_sms=send_sms&mobile='+mobile; }" style="width:130PX"/>
        <?php 
		if(isset($_GET['send_sms']))
		{
			echo SendSMS($_GET['mobile'],"Hello Spitech This Is Test Message");
		}
		?>
        </div>
      </tH>
  </tr>
  
</table>
</form>
</td></tr>
<tr><td style="height:100%;">
<?php function GetSMSUrl($MobileNo,$Message)
{
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
	//==============(SET PARAMETER FROM DATABASE)============================
		$row=$DBOBJ->GetRow("tbl_spitech_sms_server","1","1");
		
	//	printArray($row);
		//===========(FIXED PARAMETER)==============
		$url = $row['sms_url'];
		
		$MobileNo1=$row['mobile_prefix'].$MobileNo;
		$param[$row['mobile_parameter']] = $MobileNo1;
		$param[$row['message_parameter']] = $Message;
	
	    //===========(DYNAMIC PARAMETER)==============
		for($i=1;$i<6;$i++)
		{
			if($row['parameter'.$i]!="") { $param[$row['parameter'.$i]] = $row['value'.$i];  }			
		}
	
	foreach($param as $key=>$val)
	{
		$request.= $key."=".urlencode($val);
		$request.= "&";
	}
	$request = substr($request, 0, strlen($request)-1); 
	
	
	
	return $url."?".$request;
	
	//=====================================

}


?>
</td></tr>
</table>
