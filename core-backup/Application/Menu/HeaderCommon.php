<?php 
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
include_once("../Menu/Define.php");
include_once("../php/MailFunction.php");
include_once("../php/ExportFunction.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$SITE_ROW=$DBOBJ->GetRow("tbl_site_settings","1","1");
$TITLE=$SITE_ROW['site_heading'];
$ADVISOR_TITLE=$SITE_ROW['advisor_title '];

if($TITLE=="") { $TITLE="Spitech Real Estate Web Application"; }
if($ADVISOR_TITLE=="") { $ADVISOR_TITLE="Advisor"; }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $TITLE?></title>
<link rel="shortcut icon" href="../SpitechLogo/icon.png" />
<link rel="icon" href="../SpitechLogo/icon.png" />
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />    
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
<script>
function Closed()
{
	var opener=window.opener;
	
	if(opener!=null)
	{
		window.onunload = function () 
		{		
			window.opener.location.reload();
		};				
	}	
}
Closed()
</script>
</head>

