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
$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_GET[md5("advisor_id")]);

//======================( WELCOME LETTER EMAIL MESSAGE)===============================================
echo $Message=$DBOBJ->GetAdvisorWelcomeLetter($_GET[md5("advisor_id")]);


?>

<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css">
<div align="center" class="DontPrint">
<?php 
include_once("../SpitechMailer/SpitechMailer.php");
 $ADVISOR_ROW['advisor_email'];


?>
<input type="button" id="printNow" value="Print" class="button Dontprint" onClick="window.print();"/>
<input type="button" id="printNow" value="Resend" class="button Dontprint" onClick="window.location='Advisor_New_Next.php?<?php echo md5('advisor_id')."=".$_GET[md5('advisor_id')]; ?>&Send=Yes';"/>
<input type="button" id="Cancel" value="Ok Go Back" class="Cancel Dontprint" onclick="window.location='Advisor.php';" />
<?php if(isset($_GET['Send']) && $_GET['Send']!="No")
{
     echo  SendDirectMail($ADVISOR_ROW['advisor_email'],$Message,"Welcome Letter ".site_company_name,site_company_name); 

 //===================(Message Body)==========================================================================
		$title="Congratulations ! you are successfully registered to <b>".site_company_name."</b>. Your login details as follows :";
		$Message=AdvisorMail($ADVISOR_ROW["advisor_id"],$_GET[md5("advisor_password")],$title);			
	echo	SendDirectMail($ADVISOR_ROW["advisor_email"],$Message,site_company_name." Application : Login Details ",site_company_name);
 //=============================================================================================================	

//==============(SENDING MOBILE SMS )==========================================	 
$SMS="DEAR ".$ADVISOR_ROW['advisor_title']." ".$ADVISOR_ROW['advisor_name'].", WELCOME TO ".site_company_name." TEAM. YOUR ID IS : ".$ADVISOR_ROW['advisor_code'].". WE WISH YOU GOOD LUCK FOR YOUR UPCOMMING BUSINESS WITH US."; 
	echo SendSMS($ADVISOR_ROW['advisor_mobile'],$SMS);
}
?>
</div>