<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Settings");
NoUser();
NoAdmin();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/DataBase.png" width="31" height="32" />
Settings  : <span> Manage Database</span></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>
    <fieldset style="width:700px;">
    <form name="FormDB" id="FormDB" method="post"  action="../SpitechBackup/Backup.php" >
	  <table width="700" height="274"  align="center" cellpadding="10"  id="CommonTable" style="border:0px;">
          <tr>
            <td height="-4" colspan="2" ><?php ErrorMessage();?></td>
            </tr>
          <tr>
            <td width="49%" rowspan="11" ><select name="table_name[]" multiple="multiple" style="width:450; height:300PX; margin:10PX; "   >
              <optgroup label="Select Tables..."></optgroup>
              <?php 		$TABLE_Q="show tables";
		$rec=mysqli_query($_SESSION['CONN'],$TABLE_Q);
		 while($row=mysqli_fetch_assoc($rec))
		  {
		  ?>
              <option value="<?php echo $row['Tables_in_'.DATABASE]?>">
                <?php echo $row['Tables_in_'.DATABASE]?>
                </option>
              <?php 		  }
		?>
            </select></td>
      
        <td width="51%" ><label>&nbsp;
          <div align="left">
            <input name="action" type="radio" value="BACKUP_DATABASE" checked="checked" />
            BACKUP&nbsp;DATABASE </div>
          </label></td>
       
       
      </tr>
      <tr>
        <td height="91" ><label><div align="left"><input name="action" type="radio" value="OPTIMIZE_DATABASE" /> OPTIMIZE&nbsp;DATABASE</div></label></td>
      </tr>
      <tr>
        <td ><label>
          <div align="left">
            <input name="action" type="radio" value="REPAIR_DATABASE" />
            REPAIRE&nbsp;DATABASE </div>
          </label></td>
      </tr>
      <tr>
        <td style="vertical-align:top" ><div align="center">
          <input type="submit" name="Submit" value="   Go   " class="button" <?php confirm("Are You Sure to do this action ?");  ?>  />
        </div></td>
      </tr>
      <tr>
        <td style="vertical-align:top" >&nbsp;</td>
      </tr>
      <tr>
        <td style="vertical-align:top" >&nbsp;</td>
      </tr>
      <tr>
        <td style="vertical-align:top" >&nbsp;</td>
      </tr>
      <tr>
        <td style="vertical-align:top" >&nbsp;</td>
      </tr>
      <tr>
        <td height="2" style="vertical-align:top" >&nbsp;</td>
      </tr>
      <tr>
        <td height="5" style="vertical-align:top" >&nbsp;</td>
      </tr>
      <tr>
        <td height="13" style="vertical-align:top" >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td height="13" style="vertical-align:top" >&nbsp;</td>
      </tr>
	  </table>
	  </form></fieldset></center>
	  
    </td>
  </tr>
</table>
</center>

<?php include("../Menu/Footer.php"); ?>
