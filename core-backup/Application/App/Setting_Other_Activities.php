<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Settings");NoAdmin();NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Settings.png" width="31" height="32" />Settings  <span> Activity , Awards, Complains</span>
</h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
 
  <tr>
    <td width="50%" align="center">
   <h2>ACTIVITY</h2>
   <iframe src="Setting_Activities.php" frameborder="0" width="100%" height="300px"></iframe>
   </td>
    <td width="50%" align="center"><h2>COMPLAINS</h2>
   <iframe src="Setting_Complain.php" frameborder="0" width="100%" height="300px"></iframe>
   </td></td>
  </tr>
  <tr>
    <td width="50%" align="center">
   <h2>AWARDS</h2>
   <iframe src="Setting_Awards.php" frameborder="0" width="100%" height="300px"></iframe>
   </td>
    <td width="50%" align="center">&nbsp;</td></td>
  </tr>
</table>
</center>
<?php 
include("../Menu/Footer.php"); 
?>
