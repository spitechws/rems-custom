<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
RefreshPage(0.9);
$s_date=date('Y-m-01');
$e_date=date('Y-m-t');
?>

<ol style="margin:10px; color:#FF0000; text-transform:uppercase;  font-weight:bolder; font-family:Tahoma; font-size:9px;">
<?php $BOOKING_QUERY="select count(booking_advisor_id) as booking, booking_advisor_id from tbl_property_booking where booking_date between '$s_date' and '$e_date' and approved='1' group by booking_advisor_id order by booking desc, booking_advisor_id limit 0, 9";
$BOOKING_QUERY=@mysqli_query($_SESSION['CONN'],$BOOKING_QUERY);	  
while($BOOKING_ROWS=@mysqli_fetch_assoc($BOOKING_QUERY)) 
{
	$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$BOOKING_ROWS['booking_advisor_id']);
	echo "<li>".$ADVISOR_ROW['advisor_name']." 
			(<font color='maroon'>".$ADVISOR_ROW['advisor_code']."</font> , 
			 <font color='green'>".$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROW['advisor_level_id'])."</font>) 
			[<font color='blue'>".$BOOKING_ROWS['booking']."</font>]</li>";
} 
?>
</ol>


   