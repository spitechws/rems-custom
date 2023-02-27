<?php
session_start();
 include_once("../Menu/HeaderAdvisor.php");
 Menu("DVR");
	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();

	$s_date=date('2000-01-01');	
	$e_date=date('Y-m-d');	
	if(isset($_GET['Search']))
	{
		$s_date=$_GET['s_date']; 	
	    $e_date=$_GET['e_date'];	
	}
	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" /> 
 <style>
	 #Data-Table #white td { background:#fff; }
	 #Data-Table #red td { background:#CEFFE7; }	
	 #Data-Table #yellow td { background:yellow; }	
	</style>

<h1><img src="../SpitechImages/DVR.png" />DVR : <span>Master List</span></h1>

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td >
    <?php ErrorMessage(); ?>
    <form name="FindForm" id="FindForm" method="get" >
   
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" class="SearchTable" style="margin-top:5px;">
        <tr>
          
          <td width="6%">&nbsp;Name&nbsp;like</td>
          <td width="16%">
          <input type="text" name="customer_name" id="customer_name" placeholder="NAME" value="<?php echo $_GET['customer_name']; ?>" maxlength="50"/>
          </td>
         
          <td width="4%">FROM</td>
          <td width="3%" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd','<?php echo $s_date; ?>');</script></td>
          <td width="3%">TO</td>
          <td width="4%" class="Date"><script>DateInput('e_date', true, 'yyyy-mm-dd','<?php echo $e_date; ?>');</script></td>
          <TD width="4%">STATUS</TD>
          <TD width="16%">
          <select name="status" id="status">
          <option value="All">All Status...</option>
          <option value="Enable" <?php SelectedSelect("Enable",$_GET['status']); ?>>Enable</option>
          <option value="Disable" <?php SelectedSelect("Disable",$_GET['status']); ?>>Disable</option>
          <option value="Booked" <?php SelectedSelect("Booked",$_GET['status']); ?>>Booked</option>
        </select></TD>
          <td width="8%"><input type="submit" name="Search" value=" " id="Search" /></td>
          <td width="36%"><input type="button" name="All" value="Show All" class="Button" onclick="window.location='DVR.php';" /></td>
        </tr>
      </table>
    </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
        <tr>
          <th width="21">#</th>
          <th width="67">DATE</th>
          <th width="67">REMIND&nbsp;ON</th>
          <th>CUSTOMER</th>
          <th>MOBILE</th>
          <th>PROJECT</th>
          <th>PROPERTY</th>
          <th width="436">REMARKS</th>
          <th width="42">Status</th>
          <th width="52">ACTION</th>
        </tr>
        <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$DVR_QUERY="select * from tbl_advisor_dvr where advisor_id='".$_SESSION['advisor_id']."' ";
	    
		/*if(!isset($_GET['Search'])) { $DVR_QUERY.=" and status='1' "; }*/
		
		if(isset($_GET['Search']))
		{			
			if($_GET['customer_name']!="") 		{ $DVR_QUERY.=" and customer_name ='".$_GET['customer_name']."'"; 	}
			if($_GET['status']!="All") 		   { $DVR_QUERY.=" and status ='".$_GET['status']."'"; 	            }				
		}
		
	    $DVR_QUERY.=" and dvr_date between '".$s_date."' and '".$e_date."' ";	
		$PAGINATION_QUERY=$DVR_QUERY."  order by dvr_date desc, dvr_id desc ";
		$DVR_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$DVR_QUERY=@mysqli_query($_SESSION['CONN'],$DVR_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($DVR_QUERY);

while($DVR_ROWS=@mysqli_fetch_assoc($DVR_QUERY)) 
{
	
			$id='red';
		
			if($DVR_ROWS['status']=="Enable")
			{
				$id='white';
			}
			else if($DVR_ROWS['status']=="Booked")
			{
				$id='yellow';
			}
?>
        <tr id="<?php echo $id?>">
          <td><div align="center"><?php echo $k++;?>.</div></td>
          <td><div align="center" style="width:65px;"><?php echo date('d-M-Y',strtotime($DVR_ROWS['dvr_date'])); ?></div></td>
          <td><div align="center" style="width:65px;"><?php echo date('d-M-Y',strtotime($DVR_ROWS['remind_date'])); ?></div></td>
          <td width="252"><?php echo $DVR_ROWS['customer_name'];?></td>
          <td width="64" style="text-align:center"><?php echo $DVR_ROWS['mobile_no'];?></td>
          <td width="187" style="text-align:left"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$DVR_ROWS["project_id"])?></td>
          <td width="82" style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$DVR_ROWS["property_id"])?></td>
          <td width="436"><?php echo $DVR_ROWS['remarks'];?></td>
          <td width="42" style="text-align:center"><?php echo $DVR_ROWS['status'];?></td>
          <td>
            <div align="center" style="width:50px;">        
            <A id="Report" <?php Modal("DVR_View.php?".md5("dvr_id")."=".$DVR_ROWS['dvr_id'],"950px", "500px", "500px", "100px"); ?> title="View  DVR Details">&nbsp;&nbsp;</A>
           
              <A id="Edit" <?php Modal("DVR_New.php?".md5("edit_id")."=".$DVR_ROWS['dvr_id'],"1000px", "700px", "350px", "100px"); ?> title="Edit  DVR Details">&nbsp;</A>
              
               
            
              
            <!--<A id="Delete" href="DVR.php?<?php echo md5("dvr_delete_id")."=".$DVR_ROWS['dvr_id']; ?>" <?php Confirm("Are You Sure ? Delete This Expense Entry ? "); ?>  title="Delete DVR ">&nbsp;</A>-->
            
            </div>
          </td>
        </tr>
      
        <?php } ?>
      </table>
      
     
      
       <div align="right" class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url('DVR.php'));  ?></div>
           
      </td>
  </tr>
</table>
<?php 
if($_GET[md5("dvr_delete_id")]>0)
{
	
	CheckAdvisor("tbl_advisor_dvr","dvr_id",$_GET[md5("dvr_delete_id")]);
    $DELETE_ROW=$DBOBJ->GetRow("tbl_advisor_dvr","dvr_id",$_GET[md5("dvr_delete_id")]);
	
	//@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor_dvr where dvr_id='".$_GET[md5("dvr_delete_id")]."' ");	
    //$DBOBJ->UserAdvisorAction("DVR DELETED", " ID : ".$_GET[md5("dvr_delete_id")].", CUSTOMER : ".$DELETE_ROW['customer_name']);
	//header("location:DVR.php?Message=Selected DVR Have Been Deleted Successfully.");		
}
include("../Menu/Footer.php"); 

?>
