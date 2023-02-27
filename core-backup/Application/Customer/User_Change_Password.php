<?php
session_start();
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../Menu/HeaderCommon.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<head><title>User Change Password</title></head>
 <center>
 
   <form id="FrmChangePassword" name="ChangePassword" method="post" action="User.php">
    <table width="590" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">
  <tr>
    <td colspan="3"></td>
    </tr>
  <tr>
    <td width="154">OLD&nbsp;PASSWORD</td>
    <td width="126"><input type="password" name="old_password" id="old_password" placeholder="OLD PASSWORD" required=""/></td>
    <td width="126"></td>
  </tr>
  <tr>
    <td>NEW&nbsp;PASSWORD</td>
    <td><input type="password" name="new_password" id="new_password" placeholder="NEW PASSWORD" required=""/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>REPEAT&nbsp;NEW&nbsp;PASSWORD</td>
    <td><input type="password" name="new_password_repeat" id="new_password_repeat" placeholder="REPEAT NEW PASSWORD" required=""/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:RIGHT">
    <input type="submit" name="Submit" id="Submit" class="Button" value="Save Password" <?php Confirm("Are You Sure ? Save New Password"); ?>/>
    <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.location='User.php';" />
    </td>
    </tr>
</table>
</form>

</center>


