<?php @session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../php/SpitechBulkSMS.php");
include_once("../Menu/HeaderCommon.php");


$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
NoAdmin();
$USER_ROW=$DBOBJ->GetRow("tbl_admin_user","user_id",$_GET[md5("user_id")]);

//======================( WELCOME LETTER EMAIL MESSAGE)===============================================
echo $Message=UserMail($_GET[md5("user_id")],$_GET[md5("user_password")]);
//==============( USER ACCOUNT EMAIL DETAILS )==========================================

?>

<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css">
<div align="center">
<?php include_once("../SpitechMailer/SpitechMailer.php");
$USER_ROW['user_email_id'];

?>

<input type="button" id="printNow" value="Send Again" class="button Dontprint" onClick="window.location='User_New_Next.php';"/>

<input type="button" id="Cancel" value="GO BACK &#x27A1;" class="Cancel Dontprint" onclick="window.location='User_Manage_User.php';" />
</div>

<?php SendDirectMail($USER_ROW['user_email_id'],$Message,"User : Login Details Of ".site_company_name." Account",site_company_name);
//header("location:Project_Property_Booking.php?".md5("booking_user_id")."=".$_GET[md5("user_id")]);
?>
