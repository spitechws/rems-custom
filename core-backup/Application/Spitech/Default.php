<?php
include_once("../Menu/HeaderSpitech.php");
include_once("../php/SpitechDB.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();		
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>
#Content { border:0px solid black; background:white; height:85%; margin:0px; padding:0px; overflow:hidden; width:100%; }
</style>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content" style="margin:0px; padding:0px; min-height:500px; background:white; border:2px solid black; width:100%;">
  <tr>
    <td style="width:200px; min-width:200px; height:100%; min-height:400px !important; margin:0px; padding:0px; border-right:3px solid black;">
    
       <iframe style="height:100%; width:100%; margin:0px; padding:0px; background:#CCC;" frameborder="0" width="100%" height="100%"  src="LeftMenu.php">
       </iframe>
    </td>
     <td style="width:100%; min-width:1000px;margin:0px; padding:0px; height:100%;">
      <iframe style="height:100%; width:100%; margin:0px; padding:0px; background:#CCC;" frameborder="0" width="100%" height="100%" name='Container'  src="Heading_Settings.php">
       </iframe>
    </td>
  </tr>
</table>
<?php include_once("../Menu/FooterSpitech.php");?>
