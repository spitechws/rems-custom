<?php include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../php/SpitechBulkSMS.php");
include_once("../Menu/HeaderCommon.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
NoAdmin();
$ROW=$DBOBJ->GetRow("tbl_dpr_executive","id",$_GET[md5("executive_id")]);

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css">
<div align="center" class="DontPrint">
<?php include_once("../SpitechMailer/SpitechMailer.php");
 $ROW['email'];
?>
<input type="button" id="printNow" value="Print" class="button Dontprint" onClick="window.print();"/>
<input type="button" id="printNow" value="Send" class="button Dontprint" onClick="window.location='DPR_Executive_New_Next.php?<?php echo md5('executive_id')."=".$_GET[md5('executive_id')]."&".md5('password')."=".$_GET[md5('password')]; ?>&Send=Yes';"/>
<input type="button" id="Cancel" value="Back to list" class="Cancel Dontprint" onclick="window.location='DPR_Executive.php';" />
<?php
if(isset($_GET['Send']) && $_GET['Send']!="No")
{   
 	//===================(Message Body)==========================================================================
		$title="Congratulations ! you are successfully registered to <b>".site_company_name."</b>. Your login details as follows :";
		echo $Message=ExecutiveMail($ROW["id"],$_GET[md5("password")],$title);			
		SendDirectMail($ROW["email"],$Message,site_company_name." Application : Login Details ",site_company_name);
 	

//==============(SENDING MOBILE SMS )==========================================	 
$SMS="DEAR ".$ROW['title']." ".$ROW['name'].", WELCOME TO ".site_company_name." TEAM. YOUR LOGIN ID IS : ".$ROW['email']." AND PASSWORD IS : ".$_GET[md5("password")]; 
SendSMS($ROW['mobile'],$SMS);
}
?>
</div>