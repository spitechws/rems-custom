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
	$DBOBJ->ValidateAdvisor($_SESSION['advisor_team'] ,$_GET[md5('advisor_id')]);
}

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/AllCommission.png" width="31" height="32" /><?php echo advisor_title?>  : <span> All Commission</span>
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
                
                <?php 
				$ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor where advisor_id in (".$_SESSION['advisor_team'].") ORDER BY advisor_name";
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
            <td width="735" style="text-transform:capitalize">&nbsp;</td>
          </tr>       
      </table></form>
    
    <?php  if(isset($_GET['Search'])) { ?>
<table width="98%" border="0" cellspacing="1" id="SearchTable" style="margin-top:0px;">
  <tr>
    <td width="19%" id="Field">Commission&nbsp;Statement&nbsp;Of&nbsp;: </td>
    <td width="26%" id="Value"><?php 
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
    <td width="8%" id="Field">from&nbsp;date&nbsp;:</td>
    <td width="7%" id="Value"><?php echo date('d-M-Y',strtotime($s_date))?></td>
    <td width="4%">to&nbsp;:</td>
    <td width="36%" id="Value"><?php echo date('d-M-Y',strtotime($e_date))?></td>
    
    
  </tr>
</table>

    <?php } ?>
    <table width="100%"  id="Data-Table"  cellspacing="1">
      <tr>
        <th width="18" height="30" rowspan="2">#</th>
        <th width="83" rowspan="2">Voucher&nbsp;No</th>
        <th width="61" rowspan="2">Voucher Date</th>
        <th width="83" rowspan="2">Particulars</th>
        <th width="61" rowspan="2">Voucher Amount</th>
        <th width="96" rowspan="2">COMMISSION</th>
        <th width="70" rowspan="2">TDS</th>
        <th width="115" rowspan="2">NET COMMISSION </th>
        <th colspan="2">Customer&nbsp;DETAILS</th>
        <th colspan="2">BOOKED&nbsp;BY&nbsp;<?php echo advisor_title?></th>
        <th colspan="3">PROJECT DETAILS</th>
        </tr>
      <tr>
        <th width="14">ID</th>
        <th width="152">NAME</th>
        <th>ID</th>
        <th>NAME</th>
        <th>PROJECT</th>
        <th>PROPERTY</th>
        <th>TYPE</th>
      </tr>
      <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		
		if(isset($_GET['Search']))
		{	
		    $COMMISSION_QUERY="select * FROM tbl_advisor_commission where approved='1' and commission_advisor_id in (".$_SESSION['advisor_team'].") ";		
			if($_GET[md5('advisor_id')]!="All") 		{ $COMMISSION_QUERY.=" and commission_advisor_id ='".$_GET[md5('advisor_id')]."' "; }			
		}
	    
		$PAGINATION_QUERY=$COMMISSION_QUERY." and commission_date between '$s_date' and '$e_date'  order by commission_id ";
		$COMMISSION_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$COMMISSION_QUERY=@mysqli_query($_SESSION['CONN'],$COMMISSION_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($COMMISSION_QUERY);
$Hide=0;
while($COMMISSION_ROWS=@mysqli_fetch_assoc($COMMISSION_QUERY)) 
{
		  
	$COLLECTION=$COMMISSION_ROWS['commission_voucher_amount'];	$TOTAL_COLLECTION+=$COLLECTION;
	$COMMISSION=$COMMISSION_ROWS['commission_amount'];	$TOTAL_COMMISSION+=$COMMISSION;
	$TDS=$COMMISSION_ROWS['commission_tds_amount']; 			   $TOTAL_TDS+=$TDS;
	$NETT_COMMISSION=$COMMISSION_ROWS['commission_nett_amount']; $TOTAL_NETT_COMMISSION+=$NETT_COMMISSION;
	
	$CUSTOMER_CODE=$DBOBJ->ConvertToText('tbl_customer','customer_id','customer_code',$COMMISSION_ROWS['commission_customer_id']);
	$CUSTOMER_NAME=$DBOBJ->ConvertToText('tbl_customer','customer_id','customer_name',$COMMISSION_ROWS['commission_customer_id']);
	
	$ADVISOR_CODE=$DBOBJ->ConvertToText('tbl_advisor','advisor_id','advisor_code',$COMMISSION_ROWS['commission_by_advisor_id']);
	$ADVISOR_NAME=$DBOBJ->ConvertToText('tbl_advisor','advisor_id','advisor_name',$COMMISSION_ROWS['commission_by_advisor_id']);
	
	$PROJECT_NAME=$DBOBJ->ConvertToText('tbl_project','project_id','project_name',$COMMISSION_ROWS['commission_project_id']);
	$PROPERTY_NO=$DBOBJ->ConvertToText('tbl_property','property_id','property_no',$COMMISSION_ROWS['commission_property_id']);
	$PROPERTY_TYPE=$DBOBJ->PropertyTypeName($COMMISSION_ROWS['commission_property_id']);
	
	
	$COL="BLACK";
	if($COMMISSION>0) { $COL="MAROON"; }
	elseif($COMMISSION<0) { $COL="RED"; }	
		  
?>
      <tr <?php if($COMMISSION=="0" ||$COMMISSION==""  ||$COMMISSION==NULL) { echo "id=Hide".$Hide++; } ?>>
        <td height="22"><div align="center"><?php echo $k++?>.</div></td>
        <td><?php echo $COMMISSION_ROWS['commission_voucher_no'];?></td>
        <td><div align="center" style="width:80px;"><?php echo date('d-M-Y',strtotime($COMMISSION_ROWS['commission_date']));?></div></td>
        <td><div align="left" style="width:100PX;"><?php echo $COMMISSION_ROWS['commission_particular'];?></div></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($COLLECTION,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($COMMISSION,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($TDS,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($NETT_COMMISSION,2);?></td>
        <td><div align="center" style="width:70px;"><?php echo $CUSTOMER_CODE?></div></td>
        <td><div align="left" style="width:150PX;"><?php echo $CUSTOMER_NAME?></div></td>
        <td width="26"><div align="center" style="width:80px;"><?php echo $ADVISOR_CODE?></div></td>
        <td width="145"><?php echo $ADVISOR_NAME?></td>
        <td width="178"><?php echo $PROJECT_NAME?></td>
        <td width="64" style="text-align:center"><?php echo $PROPERTY_NO?></td>
        <td width="39" style="text-align:center"><?php echo $PROPERTY_TYPE?></td>
        </tr>       
      <?php } ?>      
        <tr>
        <th height="22" colspan="4"><div align="right">TOTAL </div></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_COLLECTION,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_COMMISSION,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_TDS,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_NETT_COMMISSION,2);?></th>
        <th colspan="7" style="text-align:right">&nbsp;</th>
        </tr>
    </table>
    <div class="paginate DontPrint" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>
    </td>
  </tr>
</table>
</center>
<?php include("../Menu/FooterAdvisor.php"); ?>
