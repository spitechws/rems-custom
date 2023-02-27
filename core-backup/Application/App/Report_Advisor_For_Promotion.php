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
<style>
#Data-Table #PROMOTE td { background:#D7FFD7; color:#000000; }
#Data-Table tr td { color:#666;  background:#fff;}
</style>
<center>
<h1><img src="../SpitechImages/Reports.png" width="31" height="32" /><?php echo advisor_title?>  : <span> Ability To Be Promoted</span>
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
              <select id="<?php echo md5('advisor_id');?>" name="<?php echo md5('advisor_id');?>">
                <option value="All">All <?php echo advisor_title?>...</option>
                <?php 
				$ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			    $ADVISOR_Q=@mysqli_query($_SESSION['CONN'],$ADVISOR_Q);
			   while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_Q)) {?>
                <option value="<?php echo $ADVISOR_ROWS['advisor_id'];?>" <?php SelectedSelect($ADVISOR_ROWS['advisor_id'],$_GET[md5('advisor_id')]);?>>
				<?php echo $ADVISOR_ROWS['advisor_name']." [".$ADVISOR_ROWS['advisor_code']." ]";?></option>
                <?php } ?>
              </select>          
            </td>
            <td height="30">FROM</td>
            <td width="68" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd','<?php echo $s_date?>')</script></td>
            <td width="64">TO</td>
            <td width="35" class="Date"><script>DateInput('e_date', true, 'yyyy-mm-dd','<?php echo $e_date?>')</script></td>
            <td colspan="2"><input type="submit" name="Search" id="Search" value="  "  /></td>
            <td width="735" style="text-transform:capitalize">
            <input type="button" id="ShowHideBtn" value="Hide Not Able" name="ShowHideBtn" onclick="HideCom();"/>
            </td>
          </tr>       
      </table></form>
    
    <?php  if(isset($_GET['Search'])) { ?>
<table width="98%" border="0" cellspacing="1" id="SearchTable" style="margin-top:0px;">
  <tr>
    <td width="18%" id="Field">Statement&nbsp;Of&nbsp;: </td>
    <td width="25%" id="Value"><?php 
	if($_GET[md5('advisor_id')]!="All") 
	{ 
		 $ADVISOR_ROW=$DBOBJ->GetRow('tbl_advisor','advisor_id',$_GET[md5('advisor_id')]) ;
		 echo $ADVISOR_ROW['advisor_name']." [ <font style='color:maroon'>".$ADVISOR_ROW['advisor_code']."</font> ]";
	} 
	else 
	{ 
	    echo "ALL AssociateS";
	} 
	?></td>
    <td width="6%" id="Field">from&nbsp;date&nbsp;:</td>
    <td width="2%" id="Value"><?php echo date('d-M-Y',strtotime($s_date))?></td>
    <td width="2%">to&nbsp;:</td>
    <td width="38%" id="Value"><?php echo date('d-M-Y',strtotime($e_date))?></td>
    
    <td width="9%">&nbsp;</td>
  </tr>
</table>

    <?php } ?>
    <table width="100%"  id="Data-Table"  cellspacing="1">
      <tr>
        <th width="35" height="30">#</th>
        <th width="323"><?php echo advisor_title?>&nbsp;name </th>
        <th width="93">ID</th>
        <th width="155">CURRENT&nbsp;LEVEL</th>
        <th width="118">TARGET <br />
          <font style="color:red; font-size:9px; text-transform:none">For  Promotion</font></th>
        <th width="119">SELF COLLECTION<br /><font style="color:red; font-size:9px; text-transform:none">For Promotion</font></th>
        <th width="88">PROMOTION ABILITY</th>
        <th width="119">REMAINING AMOUNT TO BE PREOMOTED</th>
        <th width="84" class="Action">ACTION</th>
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
        <td style="text-align:center;" class="Action">
		<?php if($DIFF>=0)
	       {?>
			   <input type="button" <?php Modal("Report_Advisor_For_Promotion_Next.php?".md5('advisor_id')."=".$ADVISOR_ID,"400px", "300px", "400px", "200px");?> value="Promot" style="margin:0px;"/>
		   <?php } ?>
        </td>
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
