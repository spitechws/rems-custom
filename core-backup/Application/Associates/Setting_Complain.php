<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
RefreshPage(0.2);
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$COMPLAIN_QUERY="select * from tbl_complain where advisor_id in(".$_SESSION['advisor_id'].") order by complain_id desc";
$COMPLAIN_QUERY=@mysqli_query($_SESSION['CONN'],$COMPLAIN_QUERY);	
$COUNT=@mysqli_num_rows($COMPLAIN_QUERY);  
if($COUNT) {
?>

<table width="98%" border="0" cellspacing="1" id="SmallTable">
<tr>
<th colspan="2"><?php echo advisor_title?></th>
<th>FROM</th>
<th>COMPLAIN</th>
</tr>

<?php 
while($COMPLAIN_ROWS=@mysqli_fetch_assoc($COMPLAIN_QUERY)) 
{
	$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$COMPLAIN_ROWS['advisor_id']); 
	?>
<tr>
<td width="4%">
<?php $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$ADVISOR_ROW['advisor_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $ADVISOR_ROW['advisor_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="37" height="32" style="MArgin:0PX; padding:0PX;"/> 
</td>
<td width="20%"><?php echo $ADVISOR_ROW['advisor_name']?></td>
<td width="17%" style="color:BLUE;"><?php echo $COMPLAIN_ROWS['complain_from'];?></td>
<td width="59%" style="color:red; text-transform:none; font-family:tahoma;"><?php echo $COMPLAIN_ROWS['complain'];?></td>
</tr>
<?php 	
} 
?>
</table>
<?php } ?>

   