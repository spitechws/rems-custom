<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../php/SpitechBulkSMS.php");
include_once("../Menu/HeaderCommon.php");


$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
NoUser();
$customer_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$_GET[md5("customer_id")]);

//======================( WELCOME LETTER EMAIL MESSAGE)===============================================
//echo $Message=$DBOBJ->GetCustomerWelcomeLetter($_GET[md5("customer_id")]);
//==============( USER ACCOUNT EMAIL DETAILS )==========================================
	 
	 $NewMessage="Dear Customer, ".$customer_ROW['customer_title']." ".$customer_ROW['customer_name']." <br>
	 
	 <b>Your Login Details of ".site_company_name." Account : </b><br><hr>";
	 $NewMessage.="User ID&nbsp; : ".$customer_ROW['customer_code']."<br>";
	 $NewMessage.="Password : ".$_GET[md5("customer_password")]."<br><hr>";

?>

<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css">
<div align="center">
<?php 
include_once("../SpitechMailer/SpitechMailer.php");
$customer_ROW['customer_email'];

?>

<input type="button" id="printNow" value="If SMTP Error Then Click And Retry" class="button Dontprint" onClick="window.location='customer_New_Next.php?<?php echo md5('customer_id')."=".$_GET[md5('customer_id')]; ?>';"/>

<input type="button" id="Cancel" value="GO TO BOOKING" class="Cancel Dontprint" onclick="window.location='Project_Property_Booking.php?<?php echo md5("booking_customer_id")."=".$_GET[md5("customer_id")];?>" />
</div>

<?php //SendDirectMail($customer_ROW['customer_email'],$Message,"Welcome Letter ".site_company_name,site_company_name); 

SendDirectMail($customer_ROW['customer_email'],$NewMessage,"Login Details Of ".site_company_name." Account",site_company_name);

header("location:Project_Property_Booking.php?".md5("booking_customer_id")."=".$_GET[md5("customer_id")]);
?>
