<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$payment_id=$_GET[md5('payment_id')];

if(isset($_POST['Save']))
{	
	    $doc=FileUpload($_FILES['doc'],"../SpitechUploads/booking/","1");	 	
	   
	    $FIELDS=array("payment_id" ,
						"doc_name" ,
						"doc" ,					
						"created_details",
						"edited_details");	
		
		$VALUES=array($payment_id ,						
						$_POST["doc_name"] ,
						$doc,
						$Mess=CreatedEditedByUserMessage(),
						$Mess);	
		
		$MAX_ID=$DBOBJ->Insert("tbl_property_booking_payments_doc",$FIELDS,$VALUES,0);	
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAction("PAYMENT DOCUMENT UPLOADED", "DOCS : ".$_POST['doc_name']);
		
		$Message="DOCUMENT UPLOADES SUCCESSFULLY.";
		header("location:Project_Property_Booking_Accounts_Doc.php?".md5("payment_id")."=".$payment_id."&Message=".$Message."&");	
}

?>

<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />  
<form name="DocForm" id="DocForm" method="post" enctype="multipart/form-data" style="margin-top:0PX;">  
<?php ErrorMessage();?>
<table width="98%" border="0" cellspacing="0" cellpadding="0" id="CommonTable" style="margin-top:5PX;">
  <tr>
    <td width="5%">DETAILS</td>
    <td width="17%"><input type="text" name="doc_name" id="doc_name" placeholder="DOCUMENTS DETAILS" maxlength="50" required='required'/></td>
    <td width="6%">document</td>
    <td width="18%"><input type="file" name="doc" id="doc"  value="" /></td>
    <td width="54%"><input type="submit" name="Save" id="Save" value="Save" <?php Confirm("Are You Sure ? Save ".advisor_title." Document Details ?"); ?>/></td>
  </tr>
</table>
</form>
<table width="94%" border="0" cellspacing="1" cellpadding="0" id="SmallTable" >
  <tr>
    <th width="2%" height="16">#</th>
    <th width="61%">DOCUMET NAME/DETAILS</th>
    <th>DATE</th>
    <th>TYPE</th>
    <th>SIZE</th>
    <th colspan="2" id="Action">ACTION</th>
  </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$DOCS_QUERY="select * from tbl_property_booking_payments_doc where payment_id='".$_GET[md5('payment_id')]."' ";		
	   
		$PAGINATION_QUERY=$DOCS_QUERY."  order by doc_id ";
		$DOCS_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$DOCS_QUERY=@mysqli_query($_SESSION['CONN'],$DOCS_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($DOCS_QUERY);

while($DOCS_ROWS=@mysqli_fetch_assoc($DOCS_QUERY)) 
{
	$path="../SpitechUploads/booking/".$DOCS_ROWS['doc'];
	 $size=@filesize($path)/1024; 
	?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td><div align="left"><?php echo $DOCS_ROWS['doc_name'];?></div></td>
    <td width="8%"><div align="center"><?php $AR=explode(",",$DOCS_ROWS['created_details']); echo date('d-m-Y',strtotime($AR[2]))?></div></td>
    <td width="15%" style="text-align:center;">
    <?php 	echo $ext = pathinfo($path, PATHINFO_EXTENSION);
	?>
    </td>
    <td width="6%" style="text-align:center;"><?php echo @number_format($size,2)."KB"; ?></td>
    <td width="2%" id="Action">
    <div align="center" style="width:30px;">
    
    <a id="Delete" href="Project_Property_Booking_Accounts_Doc.php?<?php echo  md5("doc_delete_id")."=".$DOCS_ROWS['doc_id']."&".md5('payment_id')."=".$_GET[md5('payment_id')]; ?>" <?php Confirm("Are You Sure ? Delete This Document ? "); ?>  title="Delete Document">&nbsp;</a>
    
    </div></td>
    <td width="6%" id="Action">
    <a href="../SpitechUploads/booking/<?php echo $DOCS_ROWS['doc']?>"><img src="../SpitechImages/Download.png" height="18" /></a>
    </td>
  </tr>
  <?php } ?>
</table>
<div class="paginate DontPrint" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>
<?php if(isset($_GET[md5('doc_delete_id')]))
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_property_booking_payments_doc","doc_id",$_GET[md5("doc_delete_id")]);	
	
	@mysqli_query($_SESSION['CONN'],"delete from tbl_property_booking_payments_doc where doc_id='".$_GET[md5('doc_delete_id')]."' "); 
	
	@unlink('../SpitechUploads/booking/'.$DELETE_ROW['doc']);

	$DBOBJ->UserAction("DOCUMENT DELETED","NAME : ".$DELETE_ROW['doc_name']);	
	header("location:Project_Property_Booking_Accounts_Doc.php?Message=PAYMENT DOCUMENT : ".$DELETE_ROW['doc_name']." Deleted.&".md5('payment_id')."=".$_GET[md5('payment_id')]);	
}
?>