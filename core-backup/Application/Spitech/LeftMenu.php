<?php
session_start();
if($_SESSION['spitech_user_id']=="" || !$_SESSION['spitech_user_id']) { header("location:index.php"); }

include_once("../php/SpitechDB.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();		
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css"/>
<style>
input[type=button] { width:170px; margin:4px 5px 4px 5px;  }
#CommonTable tr td { background:white; }
</style>
<table width="270" border="0" cellspacing="0" id="CommonTable" cellpadding="0" style="margin:0px; padding:0px; width:100%; height:100%; max-width:200PX;border:0px;">
  <tr>
    <th style="height:40px;">SPITECH MASTER</th>
  </tr>
  <tr>
    <td><a href="Heading_Settings.php" target="Container"><input type="button" value="Heading Settings"></a></td>
  </tr>
  <tr>
    <td><a href="SMS_Server_Settings.php" target="Container"><input type="button" value="SMS Server"></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="height:100%; ">&nbsp;</td>
  </tr>
</table>

