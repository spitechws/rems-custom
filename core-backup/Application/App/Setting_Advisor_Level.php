<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Settings");
NoAdmin();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Settings.png" width="31" height="32" />Settings  : <span><?php echo advisor_title?> Level</span>
<span id="AddNew"><a <?php Modal("Setting_Advisor_Level_New.php","650px", "500px", "300px", "100px"); ?>>Create New Level</a></span>
</h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">
    <center>
    <?php ErrorMessage(); ?>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table"  align="center">
      <tr>
    <th width="3%">#</th>
    <th width="7%">LEVEL</th>
    <th width="7%">TARGET(<b id="Required">SELF COLLECTION</b>) to promot next level</th>
    <th width="8%">NO OF UNIT SALE</th>
    <th width="9%">NO&nbsp;OF ACTIVE&nbsp;MEMBERS</th>
    <th width="61%">PROPERTY TYPE WISE COMMISSION PLAN</th>
    <th width="5%" class="Action">ACTION</th>
  </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$LEVEL_QUERY="select * from tbl_setting_advisor_level ";
		
	    
		$PAGINATION_QUERY=$LEVEL_QUERY."  order by level_id ";
		$LEVEL_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$LEVEL_QUERY=@mysqli_query($_SESSION['CONN'],$LEVEL_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($LEVEL_QUERY);

while($LEVEL_ROWS=@mysqli_fetch_assoc($LEVEL_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ></div>
      <div align="center"><?php echo $LEVEL_ROWS['level_name']; ?></div></td>
    <td style="text-align:right"><?php echo @number_format($LEVEL_ROWS['level_target'],2)?>&nbsp;</td>
    <td ><div align="center"><?php echo $LEVEL_ROWS['level_unit_sale']; ?></div></td>
    <td ><div align="center"><?php echo $LEVEL_ROWS['level_active_member']; ?></div></td>
    <td align="center">
      <center>
        <?php 	$PROJECT_Q="select project_id, project_name from tbl_project order by project_name";
	$PROJECT_Q=@mysqli_query($_SESSION['CONN'],$PROJECT_Q);
	$p=1;
	?>
        <table width="200" border="0" cellspacing="1" cellpadding="0" id="SmallTable">
          <tr>
            <th width="4%">#</th>
            <th width="21%">Project</th>
            <th width="75%">PROPERTY TYPE WISE PERCENT</th>
            </tr>
          <?php while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) {?>
          <tr>
            <td style="text-align:center;"><?php echo $p++?>.</td>
            <td><?php echo $PROJECT_ROWS['project_name']?></td>
            <td><table width="100" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="width:100PX;" align="center">
              <tr>
                <?php $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type ");
	 	 while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
		 {?>
                <th><div align="center">
                  <?php echo $TYPE_ROWS['property_type'];?>
                  </div></th>
                <?php } ?>
                </tr>
              <tr>
                <?php $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type ");
	 	 while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
		 {?>
                <td style="background:white;"><div align="center" style="width:100px;">
                  <?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level_with_property_type","project_id='".$PROJECT_ROWS['project_id']."' and level_id='".$LEVEL_ROWS['level_id']."' and property_type_id","commission_percent",$TYPE_ROWS['property_type_id']);?>
                  &nbsp;% </div></td>
                <?php } ?>
                </tr>
              </table></td>
            </tr>
          <?php } ?>
  </table>
        
      </center></td>
    <td class="Action"><div align="center" style="width:60px;"> 
      
      <a id="Edit" <?php Modal("Setting_Advisor_Level_New.php?".md5('edit_id')."=".$LEVEL_ROWS['level_id'],"650px", "500px", "300px", "100px"); ?>>&nbsp;</a> 
      
      <a id="Delete" href="Setting_Advisor_Level.php?<?php echo md5("level_delete_id")."=".$LEVEL_ROWS['level_id']; ?>" <?php Confirm("Are You Sure ? Delete ".advisor_title." Level :  ".$LEVEL_ROWS['level_name']." ? "); ?>  title="Delete Associate Level : <?php echo $LEVEL_ROWS['level_name']; ?>">&nbsp;</a></div></td>
  </tr>
  <?php } ?>
</table>
 <div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
    </td>
  </tr>
</table>
</center>
<?php 
if(isset($_GET[md5("level_delete_id")]) && $_SESSION['user_category']=="admin" && $_SESSION['user_id']=='admin' )
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_setting_advisor_level","level_id",$_GET[md5("level_delete_id")]);	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_setting_advisor_level where level_id='".$_GET[md5("level_delete_id")]."'");
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_setting_advisor_level_with_property_type where level_id='".$_GET[md5("level_delete_id")]."'");	
	$DBOBJ->UserAction(advisor_title." LEVEL DELETED","ID=".$_GET[md5("level_delete_id")].", LEVEL : ".$DELETE_ROW['level_name']);	
	header("location:Setting_Advisor_Level.php?Message=".advisor_title." Level : ".$DELETE_ROW['level_name']." Deleted.");	
}
include("../Menu/Footer.php"); 
?>
