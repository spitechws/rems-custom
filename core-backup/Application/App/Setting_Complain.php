<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
NoAdmin();NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
  $EDIT_ROW=$DBOBJ->GetRow("tbl_complain","complain_id",$_GET[md5('edit_id')]);

if(isset($_POST['Save']))
	 { 	  		
		          $FIELDS=array("complain","advisor_id","complain_from");									  
				  $VALUES=array($_POST["complain"],$_POST["advisor_id"],$_POST["complain_from"]);				
							
				if(isset($_GET[md5("edit_id")]))
				{ 	
					$Update=$DBOBJ->Update("tbl_complain",$FIELDS,$VALUES,"complain_id",$_GET[md5("edit_id")],0);
					$DBOBJ->UserAction("COMPLAIN EDITED", "OLD : ".$EDIT_ROW['complain'].", NEW : ".$_POST["complain"]);
					$Message="COMPLAIN EDITED SUCCESSFULLY.";
				}
				else
				{
					$INSERT=$DBOBJ->Insert("tbl_complain",$FIELDS,$VALUES,0);	
					
					$DBOBJ->UserAction("COMPLAIN CREATED", "COMPLAIN : ".$_POST['complain']);
					$Message="COMPLAIN CREATED SUCCESSFULLY.";
				}
      header("location:Setting_Complain.php?Message=".$Message);
	}	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" ="text/css" />
<center>
<form name="FormAward" id="FormAward" method="post" style="margin-top:0PX;" >
<?php ErrorMessage()?>
  <table width="98%" border="0" cellspacing="0" cellpadding="0" id="CommonTable" align="center" style="margin-top:5PX;">
    <tr>
      <td width="124" style="padding:1PX;">
      <textarea name="complain_from" required="required" maxlength="50" placeholder="COMPLAIN FROM" style="width:120px;  height:40px; font-size:9px; line-height:10px;" ><?php echo $EDIT_ROW['complain_from'];?></textarea>
      </td>
      <td width="881" style="padding:1PX;">
      <textarea name="complain" id="complain" placeholder="ENTER COMPLAIN" required="required" style="width:100%; height:40px; font-size:9px; line-height:10px;"><?php echo $EDIT_ROW['complain'];?></textarea></td>
      <td width="188"><select id="advisor_id" name="advisor_id" <?php echo $required ?> style="width:150PX;">
        <option value="">Select <?php echo advisor_title?>...</option>
        <?php 		
				$SPONSOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			
			   $SPONSOR_Q=@mysqli_query($_SESSION['CONN'],$SPONSOR_Q);
			   while($SPONSOR_ROWS=@mysqli_fetch_assoc($SPONSOR_Q)) {?>
        <option value="<?php echo $SPONSOR_ROWS['advisor_id'];?>" <?php SelectedSelect($SPONSOR_ROWS['advisor_id'], $EDIT_ROW['advisor_id']); ?>>
          <?php echo $SPONSOR_ROWS['advisor_name']." [".$SPONSOR_ROWS['advisor_code']." ]";?>
          </option>
        <?php } ?>
      </select></td>
      <td width="55"><input type="submit" name="Save" id="Save" class="Button" value=" Save " <?php Confirm("Are You Sure ? Save Award ?"); ?> style="width:55px;"/></td>
      <td width="46" id="Export" ><?php //ExportPrintLink()?></td>
    </tr>
  </table>
</form>
<table width="98%" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="width:98%;" align="center">
  <tr>
    <th width="2%">#</th>
    <th width="64%">Complain </th>
    <th colspan="2"><?php echo advisor_title?></th>
    <th width="5%" class="Action">ACTION</th>
  </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$complain_QUERY="select * from tbl_complain ";
		
	    
		$PAGINATION_QUERY=$complain_QUERY."  order by complain_id ";
		$complain_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$complain_QUERY=@mysqli_query($_SESSION['CONN'],$complain_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($complain_QUERY);

while($COMPLAIN_ROWS=@mysqli_fetch_assoc($complain_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"><?php echo $COMPLAIN_ROWS['complain']; ?></div></td>
    <td width="20%"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$COMPLAIN_ROWS['advisor_id']);?></td>
    <td width="9%"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$COMPLAIN_ROWS['advisor_id']);?></td>
    <td class="Action">
    <div align="center" style="width:60px;"> 
      
      <a id="Edit" href="Setting_Complain.php?<?php echo md5('edit_id')."=".$COMPLAIN_ROWS['complain_id'];?>" title="Edit Complain  : <?php echo  $COMPLAIN_ROWS['complain']; ?>">&nbsp;</a> 
      
      <a id="Delete" href="Setting_Complain.php?<?php echo md5("complain_delete_id")."=".$COMPLAIN_ROWS['complain_id']; ?>" <?php Confirm("Are You Sure ? Delete Complain  :  ".$COMPLAIN_ROWS['complain']." ? "); ?>  title="Delete Complain  : <?php echo $COMPLAIN_ROWS['complain']; ?>">&nbsp;</a>
      
     </div>
     
      </td>
  </tr>
  <?php } ?>
</table>
 <div class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
</div>
   
<?php 
if(isset($_GET[md5("complain_delete_id")])  )
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_complain","complain_id",$_GET[md5("complain_delete_id")]);	
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_complain where complain_id='".$_GET[md5("complain_delete_id")]."'");	
	
	$DBOBJ->UserAction("Complain  DELETED","COMPLAIN : ".$DELETE_ROW['complain']);	
	header("location:Setting_Complain.php?Message=Complain : ".$DELETE_ROW['complain']." Deleted.");	
}

?>
