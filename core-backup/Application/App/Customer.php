<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Customer");
NoUser();
RefreshPage(5);
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Customer.png" width="31" height="32" />Customer  : <span>Master List</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>" ><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>
     <?php ErrorMessage(); ?>
     <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
      <tr>
        <td width="3%">Name</td>
        <td width="9%"><input type="text" id="customer_name" name="customer_name" style="width:100px;"  placeholder="NAME" maxlength="50"/></td>
        <td width="1%">id</td>
        <td width="7%"><input type="text" id="customer_code" name="customer_code" style="width:80px;"  placeholder="ID CODE" maxlength="25" /></td>
        <td width="4%">MOBILE</td>
        <td width="9%"><input type="text" id="customer_mobile" name="customer_mobile" style="width:100px;"  placeholder="MOBILE" maxlength="10"/></td>
        <td width="3%">phone</td>
        <td width="9%"><input type="text" id="customer_phone" name="customer_phone" style="width:100px;"  placeholder="PHONE" maxlength="10"/></td>
        <td width="3%">EMAIL</td>
        <td width="9%"><input type="text" id="customer_email" name="customer_email" style="width:100px;"  placeholder="E-MAIL" maxlength="50"/></td>
        <td width="1%">BG</td>
        <td width="9%"><input type="text" id="customer_bg" name="customer_bg" style="width:110px;"  placeholder="BLOOD GROOUP" maxlength="50"/></td>
        <td width="8%">
          <input type="submit" name="Search" value=" " id="Search" /></td>
        <td width="25%">
        <input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='customer.php'" style="width:80px;"/></td>
      
      </tr>
     
      </table>

  </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
      <tr>
    <th width="2%" rowspan="2">#</th>
    <th width="6%" rowspan="2">ID&nbsp;CODE</th>
    <th width="5%" rowspan="2">PHOTO</th>
    <th width="16%" rowspan="2">NAME</th>
    <th width="7%" rowspan="2">reg&nbsp;date</th>
    <th colspan="2">CONTACT DETAILS</th>
    <th width="37%" rowspan="2">BOOKING&nbsp;DETAILS (SHORT DETAILS)</th>
    <th width="7%" rowspan="2" id="Action">ACTION</th>
  </tr>
      <tr>
        <th width="3%">MOBILE</th>
        <th width="17%">address</th>
      </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$CUSTOMER_QUERY="select customer_id, customer_title, customer_name, customer_code, customer_mobile, customer_address, customer_city, customer_reg_date, customer_photo from tbl_customer where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET['customer_name']!="") 		{ $CUSTOMER_QUERY.=" and customer_name like '%".$_GET['customer_name']."%' "; }
			if($_GET['customer_code']!="") 		{ $CUSTOMER_QUERY.=" and customer_code ='".$_GET['customer_code']."' "; }
			if($_GET['customer_mobile']!="") 	{ $CUSTOMER_QUERY.=" and customer_mobile ='".$_GET['customer_mobile']."' "; }
			if($_GET['customer_email']!="") 	{ $CUSTOMER_QUERY.=" and customer_email ='".$_GET['customer_email']."' "; }
			if($_GET['customer_phone']!="") 	{ $CUSTOMER_QUERY.=" and customer_phone ='".$_GET['customer_phone']."' "; }		
			if($_GET['customer_bg']!="") 		{ $CUSTOMER_QUERY.=" and customer_bg ='".$_GET['customer_bg']."' "; }		
				
		}
	    
		$PAGINATION_QUERY=$CUSTOMER_QUERY."  order by customer_name ";
		$CUSTOMER_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$CUSTOMER_QUERY=@mysqli_query($_SESSION['CONN'],$CUSTOMER_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($CUSTOMER_QUERY);

while($CUSTOMER_ROWS=@mysqli_fetch_assoc($CUSTOMER_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="center" style="width:70px;"><?php echo $CUSTOMER_ROWS['customer_code']; ?></div></td>
     <td style="margin:1PX; padding:1PX; text-align:center;" title="View Profile Of Customer : <?php echo $CUSTOMER_ROWS['customer_name']; ?>">
     <a href="<?php echo "Customer_Profile.php?".md5('customer_id')."=".$CUSTOMER_ROWS['customer_id'];?>" >
     <?php $ACTUAL_PHOTO="../SpitechUploads/customer/profile_photo/".$CUSTOMER_ROWS['customer_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $CUSTOMER_ROWS['customer_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Customer.png"; }
		
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="47" height="53" style="padding:0PX;"/>
         </a>
         
    </td>
    <td ><div align="left"  style="width:200PX;"><?php echo $CUSTOMER_ROWS['customer_name']; ?></div></td>
    <td >
      <div align="center" style="width:80PX;"><?php echo ShowDate($CUSTOMER_ROWS['customer_reg_date']); ?>
        </div>
    </td>
    <td><div align="center"><?php echo $CUSTOMER_ROWS['customer_mobile']; ?></div></td>
    <td><div align="left"><?php echo $CUSTOMER_ROWS['customer_city'].", ".$CUSTOMER_ROWS['customer_address']; ?></div></td>
    <td>
      <?php    $BOOKING_Q="select booking_id, 
			booking_order_no,
			booking_project_id,
			booking_property_id, 
			booking_date,
			booking_property_discounted_mrp
	 from tbl_property_booking where booking_customer_id='".$CUSTOMER_ROWS['customer_id']."' and 
	 booking_cancel_status=''
	 and approved='1' ";
   $BOOKING_Q=@mysqli_query($_SESSION['CONN'],$BOOKING_Q);
   $COUNT=@mysqli_num_rows($BOOKING_Q);
   if($COUNT>0) {
  ?> 
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="SmallTable">
 
  <tr>
    <th width="6%">#</th>
    <th width="21%">BOOKING&nbsp;NO</th>
    <th width="21%">PROPERTY</th>
    <th width="32%">PROJECT</th>
    <th width="20%">MRP</th>
    <th width="21%">PAID</th>
    <th width="21%">BALANCE</th>
  </tr>
  <?php 
  $i=1;
  while($BOOKING_ROWS=@mysqli_fetch_assoc($BOOKING_Q)) {  ?>
  <tr>
    <td><?php echo $i++;?>.</td>
    <td><div align="center" title="View Account"><a href="Project_Property_Booking_Accounts.php?<?php echo md5('booking_id')."=".$BOOKING_ROWS['booking_id'];?>"><?php echo $BOOKING_ROWS['booking_order_no'];?></a></div></td>
    <td>
	  <div align="center">
	    <?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROWS['booking_property_id'])."/"; 
    
	$PROPERTY_TYPE=$DBOBJ->ConvertToText("tbl_property","property_id","property_type_id",$BOOKING_ROWS['booking_property_id']); 
	echo $DBOBJ->ConvertToText("tbl_setting_property_type","property_type_id","property_type",$PROPERTY_TYPE); 
	?>
	    </div></td>
    <td><div align="left" style="width:120PX;"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROWS['booking_project_id']); ?></div></td>
    <td><div align="right">
	<?php echo @number_format($BOOKING_ROWS['booking_property_discounted_mrp'],2); 
	$TOTAL_MRP+=$BOOKING_ROWS['booking_property_discounted_mrp'];
	?></div></td>
    <td><div align="right">
	<?php echo @number_format($COLLECTION=$DBOBJ->TotalBookingCollection($BOOKING_ROWS['booking_id']),2);
	$TOTAL_COLLECTION+=$COLLECTION;
	?></div></td>
    <td><div align="right"><?php echo @number_format($BALANCE=$DBOBJ->TotalBookingBalance($BOOKING_ROWS['booking_id']),2);
	$TOTAL_BALANCE+=$BALANCE;?></div></td>
  </tr>
  <?php } ?>
  <tr>
    <th colspan="4">TOTAL</th>
    <th><div align="right"><?php echo @number_format($TOTAL_MRP,2); $GRAND_TOTAL_MRP+=$TOTAL_MRP; $TOTAL_MRP=0;?></div></th>
    <th><div align="right"><?php echo @number_format($TOTAL_COLLECTION,2); $GRAND_TOTAL_COLLECTION+=$TOTAL_COLLECTION; $TOTAL_COLLECTION=0;?></div></th>
    <th><div align="right"><?php echo @number_format($TOTAL_BALANCE,2); $GRAND_TOTAL_BALANCE+=$TOTAL_BALANCE; $TOTAL_BALANCE=0;?></div></th>
  </tr>
</table>
<?php } ?>
    </td>
    <td id="Action"><div align="center" style="width:80px;"> 
        <a id="Profile" href="<?php echo "Customer_Profile.php?".md5('customer_id')."=".$CUSTOMER_ROWS['customer_id'];?>" title="View Profile Of Associate : <?php echo $CUSTOMER_ROWS['customer_name']; ?>"></a> 
        
      <a id="Edit" href="<?php echo "Customer_New.php?".md5('edit_id')."=".$CUSTOMER_ROWS['customer_id'];?>" title="Edit Profile Of customer : <?php echo $CUSTOMER_ROWS['customer_name']; ?>">&nbsp;</a> 
      
    
      <a id="Delete" href="Customer.php?<?php echo md5("customer_delete_id")."=".$CUSTOMER_ROWS['customer_id']; ?>" <?php Confirm("Are You Sure ? Delete Customer ? ".$CUSTOMER_ROWS['customer_name']." ? "); ?>  title="Delete Profile of Customer : <?php echo $CUSTOMER_ROWS['customer_name']; ?>">&nbsp;</a></div>
     
    </td>
  </tr>

  <?php  } ?>
    <tr>
    <th colspan="7"><div align="right">TOTAL CALCULATIONS</div></th>
    <th>
    <table cellspacing="1" id="SmallTable" style="width:300px;" align="right">
     <tr>
       <th>mrp</th>
       <th>paid</th>
       <th>balance</th>
     </tr>
     <tr>
    <td><div align="right"><?php echo @number_format($GRAND_TOTAL_MRP,2); ?></div></td>
    <td><div align="right"><?php echo @number_format($GRAND_TOTAL_COLLECTION,2); ?></div></td>
    <td><div align="right"><?php echo @number_format($GRAND_TOTAL_BALANCE,2); ?></div></td>
  </tr>
</table>
    </th>
    <th id="Action">&nbsp;</th>
    </tr>
</table>
 <div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
    </td>
  </tr>
</table>
</center>
<?php 
if(isset($_GET[md5("customer_delete_id")]))
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$_GET[md5("customer_delete_id")]);	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_customer where customer_id='".$_GET[md5("customer_delete_id")]."'");	
   
   //====================( UPDATING PROPERTY STATUS )==========================================================
		$FIELDS=array("property_status");
		$FIELDS=array("Available");
		$Q="UPDATE tbl_property SET property_status='Available' WHERE 
			property_id IN(SELECT booking_property_id FROM tbl_property_booking 
				WHERE booking_customer_id='".$_GET[md5("customer_delete_id")]."'
				AND booking_cancel_status!='Yes')";
		@mysqli_query($_SESSION['CONN'],$Q);			
    //====================( END UPDATING PROPERTY STATUS )=====================================================
	
   	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking where booking_customer_id='".$_GET[md5("customer_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_cancelled where booking_customer_id='".$_GET[md5("customer_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_deleted where booking_customer_id='".$_GET[md5("customer_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_payments where payment_customer_id='".$_GET[md5("customer_delete_id")]."'");
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor_commission where commission_customer_id='".$_GET[md5("customer_delete_id")]."'");
     
	 //==================( EXTRA CHARGE )=============================
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_extra_charge where
	              booking_id in(select booking_id from tbl_property_booking where booking_customer_id='".$_GET[md5("customer_delete_id")]."'");		
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_extra_charge_payment where
	              booking_id in(select booking_id from tbl_property_booking where booking_customer_id='".$_GET[md5("customer_delete_id")]."'");
				  
    @unlink('../SpitechUploads/customer/profile_photo/'.$DELETE_ROW['customer_photo']);
	
	$DBOBJ->UserAction("CUSTOMER DELETED","ID=".$_GET[md5("customer_delete_id")].", NAME : ".$DELETE_ROW['customer_name']);	
	header("location:Customer.php?Message=customer : ".$DELETE_ROW['customer_name']." Deleted.");	
}
include("../Menu/Footer.php"); 
?>
