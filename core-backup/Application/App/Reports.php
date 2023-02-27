<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
Menu("Reports");NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();		
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>
#CommonTable tr td img, #CommonTable tr th img { margin-bottom:-5px; width:20px; height:20px; padding-bottom:5px; margin-top:-5px; margin-right:3px; }
#CommonTable tr td { height:35px; }
</style>
<h1><img src="../SpitechImages/Settings.png" />Settings  : <span>Basic Settings</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center" style="text-align:center">
    <center>
    <img src="../SpitechImages/Reports.png" width="68" height="70" />
    <table width="300" border="0" cellspacing="0" cellpadding="0" id="CommonTable" align="center" style="width:900px;">
  <tr>
    <th colspan="4"><div align="left"><img src="../SpitechImages/Collection.png" />Collection</div></th>
    </tr>
  <tr>
    <td width="50">&nbsp;</td>
    <td width="371"><a href="Report_Collection_Commission_Paid.php"><img src="../SpitechImages/Property.png" />project wise Total Collection-Commission-tds</a></td>
    <td width="23">:</td>
    <td width="454" id="Hint" style="text-transform:none"><img src="../SpitechImages/Hint.png" />Collection, Commission Gain, Commission Paid Report </td>
    </tr>
    
  <tr>
    <td width="50">&nbsp;</td>
    <td width="371"><a href="Report_Expense_Collection.php"><img src="../SpitechImages/Expense.png" />Expense & Collection</a></td>
    <td width="23">:</td>
    <td width="454" id="Hint" style="text-transform:none"><img src="../SpitechImages/Hint.png" />Expense & Collection</td>
    </tr>
    
    
    <tr>
    <th colspan="4"><div align="left"><img src="../SpitechImages/Advisor.png" /><?php echo advisor_title?></div></th>
    </tr>
  <tr>
    <td width="50">&nbsp;</td>
    <td width="371"><a href="Report_Advisor_For_Promotion.php"><img src="../SpitechImages/Level.gif" /><?php echo advisor_title?> Ability To Promot Report</a></td>
    <td width="23">:</td>
    <td width="454" id="Hint" style="text-transform:none"><img src="../SpitechImages/Hint.png" /><?php echo advisor_title?> Promotion Report followed by target setting </td>
    </tr>
   <tr>
    <td width="50">&nbsp;</td>
    <td width="371"><a href="Report_Advisor_Promoted.php"><img src="../SpitechImages/Level.gif" /><?php echo advisor_title?> Promoted report</a></td>
    <td width="23">:</td>
    <td width="454" id="Hint" style="text-transform:none"><img src="../SpitechImages/Hint.png" /><?php echo advisor_title?> Promoted Report (When Any <?php echo advisor_title?> <b>promoted</b>)</td>
    </tr>
    </table>
</center>
    
    </td>
  </tr>
</table>
<?php 
include("../Menu/Footer.php"); 
?>
