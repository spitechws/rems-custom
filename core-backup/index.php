<?php
include_once("Application/php/SpitechDB.php");
include_once("Application/Menu/Define.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo site_heading?></title>
<link rel="shortcut icon" href="Application/SpitechLogo/icon.png" />
<link rel="icon" href="Application/SpitechLogo/icon.png" />
<link href="Application/css/SpitechStyle.css" rel="stylesheet" type="text/css" />    
</head>
<body style="background:url(Application/SpitechLogo/LoginBodyBG.png) top repeat;">
<style>
#Hover { cursor:pointer; width:40px;}
#Hover:hover { width:50px; }
#Data-Table tr td { height:70px; vertical-align:middle; text-align:center; }
body { margin:0px; }
</style>

<div style="height:80px; border-bottom:5px solid #731F19; text-align:center; margin:0px; background:#fff;">
<img src="Application/SpitechLogo/Logo.png" width="200" height="100" style="margin-top:5px; opacity:1;padding:5px; border:2px solid #731F19;background:white; " /></div>
<center>
<table align="center" style="margin-top:100px; width:200px;" id="Data-Table">
<tr>
  <th colspan="2" style="text-transform:none; text-align:left;">
  <img src="Application/SpitechImages/Password-Recovery.png" height="33" style="margin-bottom:-15px; margin-top:-8px;"/>User Login Here:
  </th>
</tr>
<tr>
<td width="100" style="text-align:center" title="<?php echo advisor_title?> Login">
<img src="Application/SpitechImages/Advisor.png" onclick="window.location='Application/Associates';" id="Hover" /><br /><?php echo advisor_title?>
</td>
<td width="100" style="text-align:center" title="User Login"><img src="Application/SpitechImages/AdminLoginIcon.png" onclick="window.location='Application/App';" id="Hover"/><br />User/Admin</td>

</tr>

</table>
<img src="Application/SpitechImages/Shadow.png" width="200" style="margin-top:-14px; width:200px; height:30px;" />
</center>
</body>