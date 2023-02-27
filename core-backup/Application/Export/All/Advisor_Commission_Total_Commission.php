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
<h1><?php echo advisor_title?>  : <span> Total Commission</span></h1>
    <table width="100%"  id="ExportTable"  cellspacing="0" border="1">
      <tr id="TH">
        <th width="21" height="30" rowspan="2">#</th>
        <th colspan="2" rowspan="2"><?php echo advisor_title?>&nbsp;NAME </th>
        <th width="100" rowspan="2">ID</th>
        <th width="79" rowspan="2">MOBILE</th>
        <th width="101" rowspan="2">CURRENT&nbsp;LEVEL</th>
        <th colspan="2">COLLECTION </th>
        <th width="114" rowspan="2">COMMISSION</th>
        <th width="124" rowspan="2">TDS</th>
        <th width="147" rowspan="2">NET&nbsp;COMMISSION </th>
      </tr>
      <tr id="TH">
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
		{   $ADVISOR_QUERY="select advisor_id, advisor_name, advisor_code, advisor_level_id, advisor_mobile from tbl_advisor where 1 ";
			if($_GET[md5('advisor_id')]!="All") 		{ $ADVISOR_QUERY.=" and advisor_id ='".$_GET[md5('advisor_id')]."' "; }			
		}
	    
		$PAGINATION_QUERY=$ADVISOR_QUERY." order by advisor_name ";
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
						  and approved='1'";
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
      </tr>       
      <?php } ?>      
        <tr>
        <th height="22" colspan="6"><div align="right">TOTAL </div></th>
        <th style="text-align:right;"><?php echo @number_format($TOTAL_SELF_COLLECTION,2);?></th>
        <th>&nbsp;</th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_COMMISSION,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_TDS,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_NETT_COMMISSION,2);?></th>
      </tr>
    </table>
   </center>
