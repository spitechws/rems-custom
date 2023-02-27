<?php 
include_once('../php/Excel.php'); ExportExcel(); 
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
<center>
<h1><?php echo advisor_title?>  : <span> Ability To Be Promoted</span></h1>
    <table width="100%"  id="ExportTable"  cellspacing="0" border="1">
      <tr id="TH">
        <th width="35" height="30">#</th>
        <th width="323"><?php echo advisor_title?>&nbsp;NAME </th>
        <th width="93">ID</th>
        <th width="155">CURRENT&nbsp;LEVEL</th>
        <th width="118">TARGET <br />
          <font style="color:red; font-size:9px; text-transform:none">For  Promotion</font></th>
        <th width="119">SELF COLLECTION<br /><font style="color:red; font-size:9px; text-transform:none">For Promotion</font></th>
        <th width="88">PROMOTION ABILITY</th>
        <th width="119">REMAINING AMOUNT TO BE PREOMOTED</th>
      </tr>
      <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		
		if(isset($_GET['Search']))
		{   $ADVISOR_QUERY="select advisor_id, advisor_name, advisor_code, advisor_level_id from tbl_advisor where 1 ";
			if($_GET[md5('advisor_id')]!="All") 		{ $ADVISOR_QUERY.=" and advisor_id ='".$_GET[md5('advisor_id')]."' "; }			
		}
	    
		$PAGINATION_QUERY=$ADVISOR_QUERY."  order by advisor_name ";
		$ADVISOR_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ADVISOR_QUERY=@mysqli_query($_SESSION['CONN'],$ADVISOR_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ADVISOR_QUERY);
$Hide=0;
while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_QUERY)) 
{
	$ADVISOR_ID=$ADVISOR_ROWS['advisor_id'];
	$TARGET=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_target",$ADVISOR_ROWS['advisor_level_id']);
	
	//==================( COLLECTION CALCULATION )====================================================
   $SELF_COLLECTION=$DBOBJ->GetAdvisorSelfCollection($ADVISOR_ID,$s_date, $e_date);	  
   
    $DIFF=$SELF_COLLECTION-$TARGET;

	$ABILITY="<FONT COLOR='red' size='+1'>X</font>";
	
	if($DIFF>=0)
	{
		$ABILITY="<FONT COLOR='GREEN' size='+1'>Able</FONT>";
		$TR_ID="PROMOTE";
		$REMAINING="";
		
		
	}
	else
	{
		$TR_ID="Hide".$Hide++;
		$REMAINING=@number_format(abs($DIFF),2);
		$ACTION="";
		$PROMOTION_LEVEL="";
		$PROMOTION_LEVEL_NAME="";
		
	}
	
		  
	$COL="BLACK";
	if($COMMISSION>0) { $COL="MAROON"; }
	elseif($COMMISSION<0) { $COL="RED"; }	
		  
?>
      <tr id='<?php echo $TR_ID?>'>
        <td height="22"><div align="center"><?php echo $k++?>.</div></td>
        <td><?php echo $ADVISOR_ROWS['advisor_name']; ?></td>
        <td><div align="center"><?php echo $ADVISOR_ROWS['advisor_code']; ?></div></td>
        <td style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROWS['advisor_level_id']); ?></td>
       <td style="text-align:right;"><?php echo @number_format($TARGET,2);?></td>
        <td style="text-align:right;color:<?php if($SELF_COLLECTION>0) { echo "maroon"; }?>;"><?php echo @number_format($SELF_COLLECTION,2);?></td>
        <td style="text-align:center;"><?php echo $ABILITY?></td>
        <td style="text-align:right;"><?php echo $REMAINING?></td>
      </tr>       
      <?php } ?>
    </table>
   </center>
