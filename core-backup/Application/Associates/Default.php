<?php
include_once("../Menu/HeaderAdvisor.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
Menu("Home");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();		

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>
#Content tr td { margin-top:0px; margin-bottom:0px; padding-top:0px; padding-bottom:0px; vertical-align:top; height:auto; }
#Content tr td iframe {margin-top:0px; margin-bottom:0px; padding-top:0px; padding-bottom:0px; height:120px;}
#Content tr td h2 {  }

</style>
<h1><img src="../SpitechImages/Home.png" />Home  : <span>Recent Activities</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content" style="height:200px;">
  <tr>
    <td height="100" align="center" style="width:50%">
    <h2><img src="../SpitechImages/Advisor.png" style="height:25px; width:25px; margin-right:10px;"/>TOP <font color="#CCFF00"><?php echo advisor_title?></font> OF THE MONTH : <font color="#FF66FF">Self Bookings</font></h2>
      <iframe src="Top_Advisor_Bookings.php" frameborder="0" width="100%" height="100px" style="background:#FFD;"></iframe>
    </td>
    <td align="center">
     <h2><img src="../SpitechImages/Advisor.png" style="height:25px; width:25px; margin-right:10px;"/>TOP <font color="#CCFF00"><?php echo advisor_title?></font> OF THE MONTH : <font color="#FF66FF">Self Collection</font></h2>
      <iframe src="Top_Advisor_Collection.php" frameborder="0" width="100%" height="100px" style="background:#FFD;"></iframe>
    </td>
  </tr>
  <tr>
    <td height="100" align="center" style="width:50%">
    <h2><img src="../SpitechImages/Activity.png" style="height:25px; width:25px; margin-right:10px;"/>LATEST ACTIVITY/NEWS</h2>
      <iframe src="Setting_Activities.php" frameborder="0" width="100%" height="100px" style="background:#C4FFFF"></iframe></td>
   
    <td align="center"><h2><img src="../SpitechImages/Award.gif" style="height:25px; width:25px; margin-right:10px; padding-top:0px;"/>AWARDS</h2>
    <iframe src="Setting_Awards.php" frameborder="0" width="100%" height="150px" style="background:#FFD5FF"></iframe></td>
  </tr>
 
  <tr>
    <td align="center" ><h2><img src="../SpitechImages/Complain.png" alt="" style="height:25px; width:25px; margin-right:10px;"/>COMPLAINS OF YOUR TEAM MEMBER</h2>
    <iframe src="Setting_Complain.php" frameborder="0" width="100%" style="background:#FFD5D5; height:200px;"></iframe></td>
     
      <td align="center"><h2><img src="../SpitechImages/Property.png" style="height:25px; width:25px; margin-right:10px;"/>CURRENT PROPERTY RATE</h2>
    <iframe src="Setting_Property_Type_Wise_Rate.php" frameborder="0" width="100%"  style="background:#D5FFD5; height:200px;"></iframe></td>
  </tr>
</table>
<?php include("../Menu/FooterAdvisor.php"); ?>
