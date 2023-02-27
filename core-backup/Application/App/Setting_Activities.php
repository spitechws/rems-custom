<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
NoAdmin();NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

if(isset($_GET[md5('activity_edit_id')]))
{
  $EDIT_ROW=$DBOBJ->GetRow("tbl_activity","activity_id",$_GET[md5('activity_edit_id')]);
}

if(isset($_POST['Save']))
	 { 	  		
		          $FIELDS=array("activity");									  
				  $VALUES=array($_POST["activity"]);				
							
				if(isset($_GET[md5("activity_edit_id")]))
				{ 	
					$Update=$DBOBJ->Update("tbl_activity",$FIELDS,$VALUES,"activity_id",$_GET[md5("activity_edit_id")],0);
					$DBOBJ->UserAction("ACTIVITY EDITED", "OLD : ".$EDIT_ROW['activity'].", NEW : ".$_POST["activity"]);
					$Message="ACTIVITY EDITED SUCCESSFULLY.";
				}
				else
				{
					$INSERT=$DBOBJ->Insert("tbl_activity",$FIELDS,$VALUES,0);	
					
					$DBOBJ->UserAction("ACTIVITY CREATED", "ACTIVITY : ".$_POST['activity']);
					$Message="ACTIVITY CREATED SUCCESSFULLY.";
				}
      header("location:Setting_Activities.php?Message=".$Message);
	}	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" ="text/css" />
<center>
      <form name="FormActivity" id="FormActivity" method="post" style="margin-top:0PX;" ><?php ErrorMessage()?>
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="CommonTable" align="center" style="margin-top:5PX;">
  <tr>
    
    <td style="padding:1px;">
    <textarea name="activity" id="activity" placeholder="ENTER ACTIVITY" required="required" style="width:100%; height:40px; font-size:9px; line-height:10px;"><?php echo $EDIT_ROW['activity'];?>
</textarea></td>
    <td width="45"><input type="submit" name="Save" id="Save" class="Button" value=" Save " <?php Confirm("Are You Sure ? Save Activity ?"); ?> style="width:55px;"/></td>
    <td width="46" id="Export" ><?php //ExportPrintLink()?></td>
  </tr>
</table>

  </form>
    
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="width:98%;" align="center">
  <tr>
    <th width="4%">#</th>
    <th width="88%">Activity </th>
    <th width="8%" class="Action">ACTION</th>
  </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$activity_QUERY="select * from tbl_activity ";
		
	    
		$PAGINATION_QUERY=$activity_QUERY."  order by activity_id ";
		$activity_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$activity_QUERY=@mysqli_query($_SESSION['CONN'],$activity_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($activity_QUERY);

while($activity_ROWS=@mysqli_fetch_assoc($activity_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"><?php echo $activity_ROWS['activity']; ?></div></td>
    <td class="Action"><div align="center" style="width:100px;"> 
      
      <a id="Edit" href="Setting_Activities.php?<?php echo md5('activity_edit_id')."=".$activity_ROWS['activity_id'];?>" title="Edit Activity  : <?php echo $activity_ROWS['activity']; ?>">&nbsp;</a> 
      
      <a id="Delete" href="Setting_Activities.php?<?php echo md5("activity_delete_id")."=".$activity_ROWS['activity_id']; ?>" <?php Confirm("Are You Sure ? Delete Activity  :  ".$activity_ROWS['activity']." ? "); ?>  title="Delete Activity  : <?php echo $activity_ROWS['activity']; ?>">&nbsp;</a></div></td>
  </tr>
  <?php } ?>
</table>
 <div class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
</div>
   
<?php 
if(isset($_GET[md5("activity_delete_id")]))
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_activity","activity_id",$_GET[md5("activity_delete_id")]);	
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_activity where activity_id='".$_GET[md5("activity_delete_id")]."'");	
	
	$DBOBJ->UserAction("Activity  DELETED","ACTIVITY : ".$DELETE_ROW['activity']);	
	header("location:Setting_Activities.php?Message=Activity : ".$DELETE_ROW['activity']." Deleted.");	
}

?>
