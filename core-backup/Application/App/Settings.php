<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
Menu("Settings");NoAdmin();NoUser();
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
    <img src="../SpitechImages/Settings.png" width="156" height="89" />
    <table width="300" border="0" cellspacing="0" cellpadding="0" id="CommonTable" align="center" style="width:900px;">
  <tr>
    <th colspan="5"><div align="left"><img src="../SpitechImages/Project.png" />Project</div></th>
    </tr>
  <tr>
    <td width="86">&nbsp;</td>
    <td width="21" >&nbsp;</td>
    <td width="233"><a href="Setting_Property_Type.php"><img src="../SpitechImages/Property.png" />Property&nbsp;Type</a></td>
    <td>:</td>
    <td width="535" id="Hint" style="text-transform:none"><img src="../SpitechImages/Hint.png" />To Manage Property Type Like : <b>Plot, House, Flat</b> and <b>Banglow</b> etc. </td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td><a href="Setting_Property_Type_Wise_Rate.php"><img src="../SpitechImages/Property.png" />Property&nbsp;Type wise rate</a></td>
    <td>:</td>
    <td style="text-transform:none" id="Hint"><img src="../SpitechImages/Hint.png" />Project Wise Property Type Wise Rate : <b>To Show On <?php echo advisor_title?> Login</b></td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td><a href="Setting_TDS.php"><img src="../SpitechImages/Percent.png" />TDS Percent</a></td>
    <td>:</td>
    <td style="text-transform:none" id="Hint"><img src="../SpitechImages/Hint.png" />To Manage TDS : for <b><?php echo advisor_title?> </b>etc. </td>
  </tr>
 
  <tr>
    <th colspan="5"><div align="left"><img src="../SpitechImages/Advisor.png" /><?php echo advisor_title?></div></th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="Setting_Advisor_Level.php"><img src="../SpitechImages/Level.gif" /><?php echo advisor_title?> Level</a></td>
    <td width="23">:</td>
     <td style="text-transform:none" id="Hint"><img src="../SpitechImages/Hint.png" />To Manage <b><?php echo advisor_title?> Level</b> &amp; <b>Commission Plan</b>. </td>
  </tr>
  
   
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="Setting_Other_Activities.php"><img src="../SpitechImages/Activity.png" /> ACTIVITY, AWARDS, COMPLAINS</a></td>
    <td width="23">:</td>
     <td style="text-transform:none" id="Hint"><img src="../SpitechImages/Hint.png" />To Show On <b><?php echo advisor_title?> </b>Login. </td>
  </tr>
   <tr>
     <th colspan="5"><div align="left"><img src="../SpitechImages/BackUp.png" alt="" />back up &amp; MANAGE DATABASE</div></th>
   </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="SpitechManageDataBase.php"><img src="../SpitechImages/DataBase.png" />MANAGE DATABASE</a></td>
    <td>:</td>
     <td colspan="3" style="text-transform:none" id="Hint"><img src="../SpitechImages/Hint.png" />To Manage Database : Like <b>Backup</b>, <b>Optimize</b> And <b>Repair</b>, etc. </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="SpitechManageDataBaseAutoBackUpList.php"><img src="../SpitechImages/BackUp.png" alt="" />Auto BACKUP LIST</a></td>
    <td>:</td>
    <td style="text-transform:none" id="Hint"><img src="../SpitechImages/Hint.png" />Manage List Of <b>Auto Backup</b>.</td>
    </tr>
    </table>
</center>
    
    </td>
  </tr>
</table>
<?php 
if($_GET[md5("room_delete_id")]>0)
{
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_room where room_id='".$_GET[md5("room_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_room_seet where seet_room_id='".$_GET[md5("room_delete_id")]."'");	
	header("location:Course_List.php");	
}

if($_GET[md5("seet_delete_id")]>0)
{
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_room_seet where seet_id='".$_GET[md5("seet_delete_id")]."'");	
	header("location:Room_List.php");	
}
include("../Menu/Footer.php"); 
?>
