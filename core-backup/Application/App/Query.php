<?php
//include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
//Menu("Advisor");
//NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();


	 
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/AdvisorNew.png" width="31" height="32" />Associate  : <span>New Entry/Edit</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">
  <?php    //  $q="ALTER TABLE `tbl_property_booking` ADD `next_payment_date` DATE NOT NULL AFTER `approved` ;";
	// $q=@mysqli_query($_SESSION['CONN'],$q);
	// if($q) { echo "done"; }
	// else echo "error";
	 
	 $q="select * from tbl_property_booking ";
	 mysqli_query($_SESSION['CONN'],$q);
	 while($rows=mysqli_fetch_assoc())
	 {
	   echo ++$i."...".$rows["booking_order_no"]."__surya<br>"	; 
	 }
  ?>

</td></tr></table></center>
<?php include("../Menu/Footer.php"); ?>