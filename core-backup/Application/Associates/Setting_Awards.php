<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
RefreshPage(0.6);
?>

<ul style="margin:10px 25px; text-transform:capitalize;  font-size:14px; font-weight:bolder; color:#804000; font-family:Times">
<?php $AWARDS_QUERY="select * from tbl_award order by award_id desc";
$AWARDS_QUERY=@mysqli_query($_SESSION['CONN'],$AWARDS_QUERY);	  
while($AWARDS_ROWS=@mysqli_fetch_assoc($AWARDS_QUERY)) 
{
	echo "<li style='list-style:url(../SpitechImages/Award.png);'>".$AWARDS_ROWS['award']."</li>";
} 
?>
</ul>


   