<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
NoAdmin();NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

if(isset($_GET[md5('edit_id')]))
{
  $EDIT_ROW=$DBOBJ->GetRow("tbl_award","award_id",$_GET[md5('edit_id')]);
}

if(isset($_POST['Save']))
	 { 	  		
		          $FIELDS=array("award");									  
				  $VALUES=array($_POST["award"]);				
							
				if(isset($_GET[md5("edit_id")]))
				{ 	
					$Update=$DBOBJ->Update("tbl_award",$FIELDS,$VALUES,"award_id",$_GET[md5("edit_id")],0);
					$DBOBJ->UserAction("Award EDITED", "OLD : ".$EDIT_ROW['award'].", NEW : ".$_POST["award"]);
					$Message="Award EDITED SUCCESSFULLY.";
				}
				else
				{
					$INSERT=$DBOBJ->Insert("tbl_award",$FIELDS,$VALUES,0);	
					
					$DBOBJ->UserAction("Award CREATED", "Award : ".$_POST['award']);
					$Message="Award CREATED SUCCESSFULLY.";
				}
      header("location:Setting_Awards.php?Message=".$Message);
	}	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" ="text/css" />
<center>
      <form name="FormAward" id="FormAward" method="post" style="margin-top:0PX;" ><?php ErrorMessage()?>
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="CommonTable" align="center" style="margin-top:5PX;">
  <tr>
    
    <td width="1230" style="padding:1PX;"><textarea name="award" id="award" placeholder="ENTER AWARD" REQUIRED="" style="width:100%; height:40px; font-size:9px; line-height:10px;"><?php echo $EDIT_ROW['award'];?></textarea></td>
    
    <td width="45"><input type="submit" name="Save" id="Save" class="Button" value=" Save " <?php Confirm("Are You Sure ? Save Award ?"); ?> style="width:55px;"/></td>
    <td width="46" id="Export" ><?php //ExportPrintLink()?></td>
  </tr>
</table>

  </form>
    
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="width:98%;" align="center">
  <tr>
    <th width="4%">#</th>
    <th width="86%">Award </th>
    <th width="10%" class="Action">ACTION</th>
  </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$award_QUERY="select * from tbl_award ";
		
	    
		$PAGINATION_QUERY=$award_QUERY."  order by award_id ";
		$award_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$award_QUERY=@mysqli_query($_SESSION['CONN'],$award_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($award_QUERY);

while($award_ROWS=@mysqli_fetch_assoc($award_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"><?php echo $award_ROWS['award']; ?></div></td>
    <td class="Action"><div align="center" style="width:100px;"> 
      
      <a id="Edit" href="Setting_Awards.php?<?php echo md5('edit_id')."=".$award_ROWS['award_id'];?>" title="Edit Award  : <?php echo $award_ROWS['award']; ?>">&nbsp;</a> 
      
      <a id="Delete" href="Setting_Awards.php?<?php echo md5("award_delete_id")."=".$award_ROWS['award_id']; ?>" <?php Confirm("Are You Sure ? Delete Award  :  ".$award_ROWS['award']." ? "); ?>  title="Delete Award  : <?php echo $award_ROWS['award']; ?>">&nbsp;</a></div></td>
  </tr>
  <?php } ?>
</table>
 <div class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
</div>
   
<?php 
if(isset($_GET[md5("award_delete_id")]) )
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_award","award_id",$_GET[md5("award_delete_id")]);	
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_award where award_id='".$_GET[md5("award_delete_id")]."'");	
	
	$DBOBJ->UserAction("Award  DELETED","Award : ".$DELETE_ROW['award']);	
	header("location:Setting_Awards.php?Message=Award : ".$DELETE_ROW['award']." Deleted.");	
}

?>
