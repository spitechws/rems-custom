<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

Menu("Advisor");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Advisor.png" width="31" height="32" /><?php echo advisor_title?>  : <span>Tree</span></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <iframe style="width:98%; height:800px;border:0px; margin-left:1%; overflow:auto" src="../SpitechTree/AdvisorTree.php"></iframe>
    
    </td>
  </tr>
</table>
</center>
<?php include("../Menu/Footer.php"); ?>
