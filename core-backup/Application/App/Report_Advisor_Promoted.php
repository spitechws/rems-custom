<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Reports");
NoUser();

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$s_date=date('Y-m-d');
$e_date=date('Y-m-d');

if(isset($_GET['Search']))
{
	$s_date=$_GET['s_date'];
	$e_date=$_GET['e_date'];
}

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />

<center>
<h1><img src="../SpitechImages/Reports.png" width="31" height="32" /><?php echo advisor_title?>  : <span> Promoted Report</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>" class="DontPrint" ><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    
    <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>; margin-top:-20px;" >
      <table width="98%" id="CommonTable"  cellspacing="0" class="DontPrint">       
          <tr >
            <td height="30"><?php echo advisor_title?></td>
            <td>          
              <select id="<?php echo md5('advisor_id');?>" name="<?php echo md5('advisor_id');?>" style="width:80px;">
                <option value="All">All <?php echo advisor_title?>...</option>
                <?php 
				$PROMOTION_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			    $PROMOTION_Q=@mysqli_query($_SESSION['CONN'],$PROMOTION_Q);
			   while($PROMOTION_ROWS=@mysqli_fetch_assoc($PROMOTION_Q)) {?>
                <option value="<?php echo $PROMOTION_ROWS['advisor_id'];?>" <?php SelectedSelect($PROMOTION_ROWS['advisor_id'],$_GET[md5('advisor_id')]);?>>
				<?php echo $PROMOTION_ROWS['advisor_name']." [".$PROMOTION_ROWS['advisor_code']." ]";?></option>
                <?php } ?>
              </select>          
            </td>
            <td height="30">from</td>
            <td><select id="<?php echo md5('prev_level_id')?>" name="<?php echo md5('prev_level_id')?>" style="width:80px;" >
             <option value="All">All Levels...</option>
              <?php 
			   $LEVEL_Q="SELECT level_id, level_name FROM tbl_setting_advisor_level ORDER BY level_id";
			   $LEVEL_Q=@mysqli_query($_SESSION['CONN'],$LEVEL_Q);
			   while($LEVEL_ROWS=@mysqli_fetch_assoc($LEVEL_Q)) {?>
              <option value="<?php echo $LEVEL_ROWS['level_id'];?>" <?php SelectedSelect($LEVEL_ROWS['level_id'], $_GET[md5('prev_level_id')]); ?>>
                <?php echo $LEVEL_ROWS['level_name'];?>
                </option>
              <?php } ?>
            </select></td>
            <td>to</td>
            <td><select id="<?php echo md5('promoted_level_id')?>" name="<?php echo md5('promoted_level_id')?>" style="width:80px;" >
             <option value="All">All Levels...</option>
              <?php 
			   $LEVEL_Q="SELECT level_id, level_name FROM tbl_setting_advisor_level ORDER BY level_id";
			   $LEVEL_Q=@mysqli_query($_SESSION['CONN'],$LEVEL_Q);
			   while($LEVEL_ROWS=@mysqli_fetch_assoc($LEVEL_Q)) {?>
              <option value="<?php echo $LEVEL_ROWS['level_id'];?>" <?php SelectedSelect($LEVEL_ROWS['level_id'], $_GET[md5('promoted_level_id')]); ?>>
                <?php echo $LEVEL_ROWS['level_name'];?>
                </option>
              <?php } ?>
            </select></td>
            <td>FROM</td>
            <td width="68" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd','<?php echo $s_date?>')</script></td>
            <td width="64">TO</td>
            <td width="35" class="Date"><script>DateInput('e_date', true, 'yyyy-mm-dd','<?php echo $e_date?>')</script></td>
            <td colspan="2"><input type="submit" name="Search" id="Search" value="  "  /></td>
            <td width="735" style="text-transform:capitalize"><input type="button" value="All" onclick="window.location='Report_Advisor_Promoted.php';"/></td>
          </tr>       
      </table></form>
    <table width="100%"  id="Data-Table"  cellspacing="1">
      <tr>
        <th width="39" height="30">#</th>
        <th width="209"><?php echo advisor_title?>&nbsp;name </th>
        <th width="77">ID</th>
        <th width="121">current level</th>
        <th width="106">from&nbsp;LEVEL</th>
        <th width="110">to level<font style="color:red; font-size:9px; text-transform:none"></font></th>
        <th colspan="2">date<font style="color:red; font-size:9px; text-transform:none"></font></th>
        <th width="376">user</th>
        </tr>
      <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		 $PROMOTION_QUERY="select * from tbl_advisor_promotion where 1 ";
		if(isset($_GET['Search']))
		{  
			if($_GET[md5('advisor_id')]!="All") 		{ $PROMOTION_QUERY.=" and advisor_id ='".$_GET[md5('advisor_id')]."' "; }	
			if($_GET[md5('prev_level_id')]!="All") 	 { $PROMOTION_QUERY.=" and prev_level_id ='".$_GET[md5('prev_level_id')]."' "; }	
			if($_GET[md5('promoted_level_id')]!="All") { $PROMOTION_QUERY.=" and promoted_level_id ='".$_GET[md5('promoted_level_id')]."' "; }	
			
		}
	    
		$PROMOTION_QUERY.=" and promotion_date between '$s_date' and '$e_date' ";
		$PAGINATION_QUERY=$PROMOTION_QUERY."  order by promotion_date ";
	    $PROMOTION_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PROMOTION_QUERY=@mysqli_query($_SESSION['CONN'],$PROMOTION_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PROMOTION_QUERY);

while($PROMOTION_ROWS=@mysqli_fetch_assoc($PROMOTION_QUERY)) 
{
	$advisor_id=$PROMOTION_ROWS['advisor_id'];
    $ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$advisor_id);
    $level_id=$ADVISOR_ROW['advisor_level_id'];
    $level=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$level_id);
	
	$FROM=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$PROMOTION_ROWS['prev_level_id']);
	$TO=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$PROMOTION_ROWS['promoted_level_id']);
	
?>
      <tr>
        <td height="22"><div align="center"><?php echo $k++?>.</div></td>
        <td><?php echo $ADVISOR_ROW['advisor_name']; ?></td>
        <td><div align="center"><?php echo $ADVISOR_ROW['advisor_code']; ?></div></td>
        <td style="text-align:center"><?php echo $level?></td>
        <td style="text-align:center"><?php echo $FROM;?></td>
       <td style="text-align:center;"><?php echo $TO;?></td>
        <td width="90" style="text-align:center"><?php echo date('d-m-Y',strtotime($PROMOTION_ROWS['promotion_date']))?></td>
        <td width="95" style="text-align:center"><?php echo date('h:i:sA',strtotime($PROMOTION_ROWS['promotion_time']))?></td>
        <td style="text-align:justify; line-height:10px; font-size:9px;"><?php echo $PROMOTION_ROWS['created_details']?></td>
        </tr>       
      <?php } ?>
  </table>
    <div class="paginate DontPrint" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>
    </td>
  </tr>
</table>
</center>

<script>
function HideCom()
{
	if(document.getElementById('ShowHideBtn').value=="Hide Not Able")
	{   document.getElementById('ShowHideBtn').value="Show All";
		for(var i=0;i<=<?php echo $Hide?>;i++)
		{
			document.getElementById('Hide'+i).style.display='none';
		}
		
	}
	else
	{   document.getElementById('ShowHideBtn').value="Hide Not Able";
		for(var i=0;i<=<?php echo $Hide?>;i++)
		{
			document.getElementById('Hide'+i).style.display='table-row';
		}
		
	}
}
</script>

<?php include("../Menu/Footer.php"); ?>
