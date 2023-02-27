<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
RefreshPage(0.5);
?>
<marquee direction="up" behavior="alternate" scrollamount="2" onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 2, 0);" height="180px" >
<ul style="margin:10px; color:blue; text-transform:capitalize; font-weight:bolder; font-family:Tahoma">
<?php $activity_QUERY="select * from tbl_activity order by activity_id desc";
$activity_QUERY=@mysqli_query($_SESSION['CONN'],$activity_QUERY);	  
while($activity_ROWS=@mysqli_fetch_assoc($activity_QUERY)) 
{
	echo "<li>".$activity_ROWS['activity']."</li>";
} 
?>
</ul>
</marquee>

   