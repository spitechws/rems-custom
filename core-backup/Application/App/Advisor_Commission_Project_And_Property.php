<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Advisor");
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
<h1><img src="../SpitechImages/PropertyWiseCommission.png" width="31" height="32" />Project  : <span> Project/Property wise Commission</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>"><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>
     <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>; margin-top:-20px;" >
      <table width="98%" id="CommonTable"  cellspacing="0" class="DontPrint">       
          <tr >
            <td height="30">project</td>
            <td>
            <select id="commission_project_id" name="commission_project_id" onchange="GetPage('GetCommissionProperty.php?project_id='+this.value,'property');" style="width:100px;">
              <option value="All">ALL PROJECT...</option>
              <?php 
             $PROJECT_Q=@mysqli_query($_SESSION['CONN'],"select project_id, project_name from tbl_project ");
             while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
             {?>
              <option value="<?php echo $PROJECT_ROWS['project_id']?>" <?php SelectedSelect($PROJECT_ROWS['project_id'],$_GET['commission_project_id']);?>>
                <?php echo $PROJECT_ROWS['project_name']?>
                </option>
              <?php } ?>
            </select></td>
             <td height="30">property</td>
            <td><div id="property">
              <select id="commission_property_id" name="commission_property_id" style="width:100px;" >
                <option value="All">ALL PROPERTY...</option>
                <?php 
		  $PROPERTY_Q="select property_id, property_no  from tbl_property where property_project_id='".$_GET['booking_project_id']."'  and  property_id in(select commission_property_id from tbl_advisor_commission group by commission_property_id) order by  property_id, property_no  ";
             $PROPERTY_Q=@mysqli_query($_SESSION['CONN'],$PROPERTY_Q);
             while($PROPERTY_ROWS=@mysqli_fetch_assoc($PROPERTY_Q)) 
             {?>
                <option value="<?php echo $PROPERTY_ROWS['property_id']?>" <?php SelectedSelect($PROPERTY_ROWS['property_id'],$_GET['booking_property_id'] ); ?>>
                  <?php echo $PROPERTY_ROWS['property_no']?>
                  </option>
                <?php } ?>
              </select>
            </div></td>
               <td height="30"><?php echo advisor_title?></td>
            <td>          
              <select id="commission_advisor_id" name="commission_advisor_id" style="width:100px;">
                <option value="All">All <?php echo advisor_title?>...</option>
                <?php 
				$ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			    $ADVISOR_Q=@mysqli_query($_SESSION['CONN'],$ADVISOR_Q);
			   while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_Q)) {?>
                <option value="<?php echo $ADVISOR_ROWS['advisor_id'];?>" <?php SelectedSelect($ADVISOR_ROWS['advisor_id'],$_GET['commission_advisor_id']);?>>
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
    <td width="14%" id="Field">Commission&nbsp;Statement&nbsp;Of&nbsp;: </td>
     <td width="6%" id="Field">PROJECT&nbsp;:</td>
      <td width="16%" id="Value">
	  <?php 
	if($_GET['commission_project_id']!="All") 
	{ 
		 $PROJECT_ROW=$DBOBJ->GetRow('tbl_project','project_id',$_GET['commission_project_id']) ;
		 echo $PROJECT_ROW['project_name'];
	} 
	else 
	{ 
	    echo "ALL PROJECTS";
	} 
	?></td>
     <td width="7%" id="Field">PROPERTY&nbsp;:</td>
      <td width="9%" id="Value"><?php 
	if($_GET['commission_property_id']!="All") 
	{ 
		 $PROPERTY_ROW=$DBOBJ->GetRow('tbl_property','property_id',$_GET['commission_property_id']) ;
		 echo $PROPERTY_ROW['property_no'];
	} 
	else 
	{ 
	    echo "ALL PROPERTY";
	} 
	?></td>
     <td width="5%" id="Field"><?php echo advisor_title?>&nbsp;:</td>
    <td width="18%" id="Value"><?php 
	if($_GET['commission_advisor_id']!="All") 
	{ 
		 $ADVISOR_ROW=$DBOBJ->GetRow('tbl_advisor','advisor_id',$_GET['commission_advisor_id']) ;
		 echo $ADVISOR_ROW['advisor_name']." [ <font style='color:maroon'>".$ADVISOR_ROW['advisor_code']."</font> ]";
	} 
	else 
	{ 
	    echo "ALL ".advisor_title;
	} 
	?></td>
    <td width="7%" id="Field">from&nbsp;date&nbsp;:</td>
    <td width="6%" id="Value"><?php echo date('d-M-Y',strtotime($s_date))?></td>
    <td width="3%">to&nbsp;:</td>
    <td width="9%" id="Value"><?php echo date('d-M-Y',strtotime($e_date))?></td>
    
   
  </tr>
</table>

    <?php } ?>
    <table width="100%"  id="Data-Table"  cellspacing="1">
      <tr>
        <th width="18" height="30" rowspan="2">#</th>
        <th width="83" rowspan="2">Voucher&nbsp;No</th>
        <th width="61" rowspan="2">COMMISSION DATE</th>
        <th width="83" rowspan="2">Voucher Date</th>
        <th width="83" rowspan="2">Particulars</th>
        <th width="61" rowspan="2">Voucher Amount</th>
        <th width="96" colspan="2"><?php echo advisor_title?> DETAILS</th>
        <th width="96" rowspan="2">COMMISSION</th>
        <th width="70" rowspan="2">TDS</th>
        <th width="115" rowspan="2">NET COMMISSION </th>
        <th colspan="2">Customer&nbsp;DETAILS</th>
        <th colspan="2">BOOKED&nbsp;BY&nbsp;<?php echo advisor_title?></th>
        <th colspan="3">PROJECT DETAILS</th>
        </tr>
      <tr>
        <th>ID</th>
        <th>NAME</th>
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
		    $COMMISSION_QUERY="select * FROM tbl_advisor_commission where approved='1' and commission_date between '$s_date' and '$e_date' ";		
			if($_GET['commission_project_id']!="All")  		{ $COMMISSION_QUERY.=" and commission_project_id ='".$_GET['commission_project_id']."' "; }
			if($_GET['commission_property_id']!="All") 		{ $COMMISSION_QUERY.=" and commission_property_id ='".$_GET['commission_property_id']."' "; }
			if($_GET['commission_advisor_id']!="All") 		{ $COMMISSION_QUERY.=" and commission_advisor_id ='".$_GET['commission_advisor_id']."' "; }			
		}
	    
		$PAGINATION_QUERY=$COMMISSION_QUERY."  order by commission_id ";
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
	
	$ADVISOR_C=$DBOBJ->ConvertToText('tbl_advisor','advisor_id','advisor_code',$COMMISSION_ROWS['commission_advisor_id']);
	$ADVISOR_N=$DBOBJ->ConvertToText('tbl_advisor','advisor_id','advisor_name',$COMMISSION_ROWS['commission_advisor_id']);
	
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
        <td><div align="center" style="width:70px;"><?php echo date('d-M-Y',strtotime($COMMISSION_ROWS['commission_date']));?></div></td>
        <td><div align="center" style="width:70px;"><?php echo date('d-M-Y',strtotime($COMMISSION_ROWS['commission_voucher_date']));?></div></td>
        <td><div align="left" style="width:100PX;"><?php echo $COMMISSION_ROWS['commission_particular'];?></div></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($COLLECTION,2);?></td>
        <td width="96"><div align="center" style="width:70px;"><?php echo $ADVISOR_C?></div></td>
        <td width="145"><div align="left" style="width:150PX;"><?php echo $ADVISOR_N?></div></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($COMMISSION,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($TDS,2);?></td>
        <td style="text-align:right;color:<?php echo $COL?>;"><?php echo @number_format($NETT_COMMISSION,2);?></td>
        <td><div align="center" style="width:70px;"><?php echo $CUSTOMER_CODE?></div></td>
        <td><div align="left" style="width:150PX;"><?php echo $CUSTOMER_NAME?></div></td>
        <td width="26"><div align="center" style="width:70px;"><?php echo $ADVISOR_CODE?></div></td>
        <td width="145"><div align="left" style="width:150PX;"><?php echo $ADVISOR_NAME?></div></td>
        <td width="178"><div align="left" style="width:120PX;"><?php echo $PROJECT_NAME?></div></td>
        <td width="64" style="text-align:center"><?php echo $PROPERTY_NO?></td>
        <td width="39" style="text-align:center"><?php echo $PROPERTY_TYPE?></td>
        </tr>       
      <?php } ?>      
        <tr>
        <th height="22" colspan="8"><div align="right">TOTAL </div></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_COMMISSION,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_TDS,2);?></th>
        <th style="text-align:right"><?php echo @number_format($TOTAL_NETT_COMMISSION,2);?></th>
        <th colspan="7" style="text-align:right">&nbsp;</th>
        </tr>
    </table>
    <div class="paginate DontPrint" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>
    </center>
    </td>
  </tr>
</table>
</center>
<?php 
if(isset($_GET[md5("property_delete_id")]) && $_GET[md5("property_delete_id")]!="1")
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_property","property_id",$_GET[md5("property_delete_id")]);	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking where booking_property_id='".$_GET[md5("property_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_payments where payment_property_id='".$_GET[md5("property_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor_commission where  commission_property_id='".$_GET[md5("property_delete_id")]."'");
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_cancelled where booking_property_id='".$_GET[md5("property_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_deteted where booking_property_id='".$_GET[md5("property_delete_id")]."'");	
	$DBOBJ->UserAction("Property DELETED","ID=".$_GET[md5("property_delete_id")].", NO : ".$DELETE_ROW['property_no']);	
	header("location:Project_Property_List.php?Message=Property : ".$DELETE_ROW['property_no']." Deleted.");	
}
include("../Menu/Footer.php"); 
?>
