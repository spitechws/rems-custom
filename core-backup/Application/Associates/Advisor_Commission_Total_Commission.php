<?php
include_once("../Menu/HeaderAdvisor.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Advisor");
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
<h1><img src="../SpitechImages/TotalCommission.png" width="31" height="32" /><?php echo advisor_title?>  : <span> Total Commission</span>
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
				$ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor where advisor_id in(".$_SESSION['advisor_team'].") ORDER BY advisor_name";
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
            <input type="button" id="ShowHideBtn" value="Hide Not Getting Commission" name="ShowHideBtn" onclick="HideCom();"/>
            </td>
          </tr>       
      </table></form>
    
    <?php  if(isset($_GET['Search'])) { ?>
<table width="98%" border="0" cellspacing="1" id="SearchTable" style="margin-top:0px;">
  <tr>
    <td width="18%" id="Field">Commission&nbsp;Statement&nbsp;Of&nbsp;: </td>
    <td width="25%" id="Value"><?php 
	if($_GET[md5('advisor_id')]!="All") 
	{ 
		 $ADVISOR_ROW=$DBOBJ->GetRow('tbl_advisor','advisor_id',$_GET[md5('advisor_id')]) ;
		 echo $ADVISOR_ROW['advisor_name']." [ <font style='color:maroon'>".$ADVISOR_ROW['advisor_code']."</font> ]";
	} 
	else 
	{ 
	    echo "ALL ".advisor_title;
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
        <th width="21" height="30" rowspan="2">#</th>
        <th colspan="2" rowspan="2"><?php echo advisor_title?>&nbsp;name </th>
        <th width="100" rowspan="2">ID</th>
        <th width="79" rowspan="2">mobile</th>
        <th width="101" rowspan="2">CURRENT&nbsp;LEVEL</th>
        <th colspan="2">COLLECTION </th>
        <th width="114" rowspan="2">COMMISSION</th>
        <th width="124" rowspan="2">TDS</th>
        <th width="147" rowspan="2">NET&nbsp;COMMISSION </th>
        <th width="80" rowspan="2" class="Action">ACTION</th>
      </tr>
      <tr>
        <th width="112">SELF</th>
        <th width="121">TEAM</th>
      </tr>
      <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		
		if(isset($_GET['Search']))
		{   $ADVISOR_QUERY="select advisor_id, advisor_name, advisor_code, advisor_level_id, advisor_mobile from tbl_advisor  where advisor_id in(".$_SESSION['advisor_team'].") ";
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
	$COMMISSION_Q="SELECT SUM(commission_amount) AS COMMISSION, 
						  SUM(commission_tds_amount) AS TDS, 
						  SUM(commission_nett_amount) AS NETT_COMMISSION
						  FROM tbl_advisor_commission WHERE 
						  commission_advisor_id='$ADVISOR_ID' AND
						  commission_date BETWEEN '$s_date' AND '$e_date' 
						  and approved='1' ";
	$COMMISSION_Q=@mysqli_query($_SESSION['CONN'],$COMMISSION_Q);	
	$COMMISSION_ROW=@mysqli_fetch_assoc($COMMISSION_Q);	
	
	//==================( COMMISSION CALCULATION )====================================================
		$COMMISSION=$COMMISSION_ROW['COMMISSION'];		      $TOTAL_COMMISSION+=$COMMISSION;
		$TDS=$COMMISSION_ROW['TDS'];	                        $TOTAL_TDS+=$TDS;
		$NETT_COMMISSION=$COMMISSION_ROW['NETT_COMMISSION'];	$TOTAL_NETT_COMMISSION+=$NETT_COMMISSION;
	//==================( COLLECTION CALCULATION )====================================================
		  $ADVISOR_TEAM=$ADVISOR_ID; $DBOBJ->GetAdvisorTeam($ADVISOR_ID);
		  
		  $TOTAL_COLLECTION=$DBOBJ->GetAdvisorTotalCollection($ADVISOR_TEAM,$s_date, $e_date);
		  $SELF_COLLECTION=$DBOBJ->GetAdvisorSelfCollection($ADVISOR_ID,$s_date, $e_date);
	      
		  $TEAM_COLLECTION=$TOTAL_COLLECTION-$SELF_COLLECTION;
		  $TOTAL_SELF_COLLECTION+= $SELF_COLLECTION;
		  
		  
		  
	$COL="BLACK";
	if($COMMISSION>0) { $COL="MAROON"; }
	elseif($COMMISSION<0) { $COL="RED"; }	
		  
?>
      <tr <?php if($COMMISSION=="0" ||$COMMISSION==""  ||$COMMISSION==NULL) { echo "id=Hide".$Hide++; } ?>>
        <td height="22"><div align="center"><?php echo $k++?>.</div></td>
        <td colspan="2"><div align="left"  style="width:200PX;"><?php echo $ADVISOR_ROWS['advisor_name']; ?></div></td>
        <td><div align="center"><?php echo $ADVISOR_ROWS['advisor_code']; ?></div></td>
        <td><div align="center"><?php echo $ADVISOR_ROWS['advisor_mobile']; ?></div></td>
        <td><div align="center" style="width:100PX;"> <?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROWS['advisor_level_id']); ?></div></td>
        <td style="text-align:right;color:<?php if($SELF_COLLECTION>0) { echo "maroon"; }?>;"><?php echo @number_format($SELF_COLLECTION,2);?></td>
        <td style="text-align:right;"><?php echo @number_format($TEAM_COLLECTION,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>"><?php echo @number_format($COMMISSION,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>"><?php echo @number_format($TDS,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>"><?php echo @number_format($NETT_COMMISSION,2);?></td>
        <td style="text-align:center;" class="Action"><a id="Report" href="Advisor_Commission_All_Commission.php?<?php echo md5('advisor_id')."=".$ADVISOR_ID."&s_date=".$s_date."&e_date=".$e_date."&Search=+";?>">&nbsp;&nbsp;Details</a></td>
      </tr>       
      <?php } ?>      
        <tr>
        <th height="22" colspan="6"><div align="right">TOTAL </div></th>
        <th style="text-align:right;"><?php echo @number_format($TOTAL_SELF_COLLECTION,2);?></th>
        <th>&nbsp;</th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_COMMISSION,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_TDS,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_NETT_COMMISSION,2);?></th>
        <th class="Action"><div align="right"></div></th>
      </tr>
    </table>
    <div class="paginate DontPrint" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>
    </td>
  </tr>
</table>
</center>

<script>
function HideCom()
{
	if(document.getElementById('ShowHideBtn').value=="Hide Not Getting Commission")
	{   document.getElementById('ShowHideBtn').value="Show Not Getting Commission";
		for(var i=0;i<=<?php echo $Hide?>;i++)
		{
			document.getElementById('Hide'+i).style.display='none';
		}
		
	}
	else
	{   document.getElementById('ShowHideBtn').value="Hide Not Getting Commission";
		for(var i=0;i<=<?php echo $Hide?>;i++)
		{
			document.getElementById('Hide'+i).style.display='table-row';
		}
		
	}
}
</script>

<?php include("../Menu/FooterAdvisor.php"); ?>
