<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$booking_id=$_GET[md5('booking_id')];
$BOOKING_ROW=$DBOBJ->GetRow("tbl_property_booking","booking_id",$booking_id);
$registry_date="1900-01-01";
$registry_dispached_date="1900-01-01";

if(isset($_GET[md5('booking_id')]))
{
	$registry_date=$BOOKING_ROW["registry_date"];
    $registry_dispached_date=$BOOKING_ROW["registry_dispached_date"];
}

if($registry_date=="0000-00-00") { $registry_date="1900-01-01"; }
if($registry_dispached_date=="0000-00-00") { $registry_dispached_date="1900-01-01"; }

if(isset($_POST['Save']))
{	
    if(isset($_GET[md5('booking_id')]))
	{
	    $registry_doc=FileUpload($_FILES['registry_doc'],"../SpitechUploads/booking/","1");	 	
		
		//=================( Checking Student's Photo )==============================================================
		  if($registry_doc=="" || $registry_doc==NULL)
		  {
			  $registry_doc=$BOOKING_ROW['registry_doc'];
		  }
		 
		  if($registry_doc!="" && $registry_doc!=$BOOKING_ROW['registry_doc'])
		  {
			@unlink("../SpitechUploads/booking/".$BOOKING_ROW['registry_doc']);
		  }
	   
	    $FIELDS=array("booking_registry_status",
		               "registry_doc" ,
						"registry_receiver" ,
						"registry_dispached" ,					
						"registry_dispached_by",
						"registry_remarks",
						"registry_date",
						"registry_dispached_date");	
		
		$VALUES=array(
						$_POST["booking_registry_status"],
						$registry_doc ,
						$_POST["registry_receiver"],
						$_POST["registry_dispached"],					
						$_POST["registry_dispached_by"],
						$_POST["registry_remarks"],
						$_POST["registry_date"],
						$_POST["registry_dispached_date"]);	
		
		$MAX_ID=$DBOBJ->Update("tbl_property_booking",$FIELDS,$VALUES,"booking_id",$booking_id,0);	
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAction("REGISTRY DETAILS FILLED", "ORDER : ".$_POST['booking_order_no']);	
	
		UnloadMe();	
	}
	else
	{
		$Message="Invalid Entry.";
		header("location:Project_Property_Booking_Accounts_Registry.php?".md5("booking_id")."=".$booking_id."&Error=".$Message);	
	}
}

?>

<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />  
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
<form name="DocForm" id="DocForm" method="post" enctype="multipart/form-data" style="margin-top:0PX;">  
<?php ErrorMessage();?>
<table width="98%" border="0" cellspacing="0" cellpadding="0" id="CommonTable" style="margin-top:5PX;">
  <tr>
    <th colspan="2">Registry details</th>
    </tr>
  <tr>
    <td>REGISTRY STATUS</td>
    <td>
    <select id="booking_registry_status" name="booking_registry_status">
      <option value="" <?php SelectedSelect($BOOKING_ROW['booking_registry_status'],"")?> >Not Registered</option>
      <option value="Registered" <?php SelectedSelect($BOOKING_ROW['booking_registry_status'],"Registered")?>>Registered</option>
    </select>
    </td>
    </tr>
  <tr>
    <td>REGISTRY DATE</td>
    <td class="Date"><script>DateInput('registry_date', true, 'yyyy-mm-dd', '<?php echo $registry_date; ?>');</script></td>
  </tr>
  <tr>
    <td width="40%">document</td>
    <td width="60%">
    <input type="file" name="registry_doc" id="registry_doc"  value="" />
    <BR />
    <A href="../SpitechUploads/booking/<?php echo $BOOKING_ROW['registry_doc']?>"><?php echo $BOOKING_ROW['registry_doc']?></A>
    
    </td>
    </tr>
  <tr>
    <td>DETAILS</td>
    <td><input type="text" name="registry_remarks" id="registry_remarks" placeholder="DETAILS" maxlength="200" value='<?php echo $BOOKING_ROW['registry_remarks']?>'/></td>
    </tr>
  <tr>
    <th colspan="2">DISPACHED details</th>
    </tr>
  <tr>
    <td>DISPACHED</td>
    <td>
    <select id="registry_dispached" name="registry_dispached">
      <option value="" <?php SelectedSelect($BOOKING_ROW['registry_dispached'],"")?>>No</option>
      <option value="Yes" <?php SelectedSelect($BOOKING_ROW['registry_dispached'],"Yes")?>>Yes</option>
    </select>
    </td>
    </tr>
  <tr>
    <td>DISPACHED_BY</td>
    <td><input type="text" name="registry_dispached_by" id="registry_dispached_by" placeholder="DISPACHED BY" maxlength="100" value='<?php echo $BOOKING_ROW['registry_dispached_by']?>' /></td>
    </tr>
  <tr>
    <td>DISPACHED_DATE</td>
    <td class="Date"><script>DateInput('registry_dispached_date', true, 'yyyy-mm-dd', '<?php echo $registry_dispached_date; ?>');</script></td>
    </tr>
  <tr>
    <td>RECEIVER</td>
    <td><input type="text" name="registry_receiver" id="registry_receiver" placeholder="RECEIVED BY" maxlength="100" value='<?php echo $BOOKING_ROW['registry_receiver']?>'/></td>
    </tr>
  <tr>
    <td colspan="2" style="text-align:center">
       <input type="submit" name="Save" id="Save" value="Save" <?php Confirm("Are You Sure ? Save Registry Details ?"); ?>/>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.close();"/></td>
    </tr>
</table>
</form>
