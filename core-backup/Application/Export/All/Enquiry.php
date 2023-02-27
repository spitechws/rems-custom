<?php
session_start();
 include_once("../Menu/HeaderAdmin.php");
 Menu("Enquiry");
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

<h1><img src="../SpitechImages/Enquiry.png" />Enquiry : <span>Master List</span></h1>

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
          <td width="36%"><input type="button" name="All" value="Show All" class="Button" onclick="window.location='Enquiry.php';" /></td>
        </tr>
      </table>
    </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
        <tr>
          <th width="17">#</th>
          <th width="65">DATE</th>
          <th width="68">REMIND&nbsp;ON</th>
          <th>CUSTOMER</th>
          <th>MOBILE</th>
          <th>PROJECT</th>
          <th>PROPERTY</th>
          <th width="400">REMARKS</th>
          <th width="42">Status</th>
          <th width="90">ACTION</th>
        </tr>
        <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ENQ_QUERY="select * from tbl_enquiry where 1 ";
	    
		/*if(!isset($_GET['Search'])) { $ENQ_QUERY.=" and status='1' "; }*/
		
		if(isset($_GET['Search']))
		{			
			if($_GET['customer_name']!="") 		{ $ENQ_QUERY.=" and customer_name ='".$_GET['customer_name']."'"; 	}
			if($_GET['status']!="All") 		   { $ENQ_QUERY.=" and status ='".$_GET['status']."'"; 	            }				
		}
		
	    $ENQ_QUERY.=" and enquiry_date between '".$s_date."' and '".$e_date."' ";	
		$PAGINATION_QUERY=$ENQ_QUERY."  order by enquiry_date desc, enquiry_id desc ";
		$ENQ_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ENQ_QUERY=@mysqli_query($_SESSION['CONN'],$ENQ_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ENQ_QUERY);

while($ENQ_ROWS=@mysqli_fetch_assoc($ENQ_QUERY)) 
{
	
			$id='red';
		
			if($ENQ_ROWS['status']=="Enable")
			{
				$id='white';
			}
			else if($ENQ_ROWS['status']=="Booked")
			{
				$id='yellow';
			}
?>
        <tr id="<?php echo $id?>">
          <td><div align="center"><?php echo $k++;?>.</div></td>
          <td><div align="center" style="width:65px;"><?php echo date('d-M-Y',strtotime($ENQ_ROWS['enquiry_date'])); ?></div></td>
          <td><div align="center" style="width:65px;"><?php echo date('d-M-Y',strtotime($ENQ_ROWS['remind_date'])); ?></div></td>
          <td width="256"><?php echo $ENQ_ROWS['customer_name'];?></td>
          <td width="65" style="text-align:center"><?php echo $ENQ_ROWS['mobile_no'];?></td>
          <td width="190" style="text-align:left"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$ENQ_ROWS["project_id"])?></td>
          <td width="83" style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$ENQ_ROWS["property_id"])?></td>
          <td width="400"><?php echo $ENQ_ROWS['remarks'];?></td>
          <td width="42" style="text-align:center"><?php echo $ENQ_ROWS['status'];?></td>
          <td>
            <div align="center" style="width:90px;">        
            <A id="Report" <?php Modal("Enquiry_View.php?".md5("enquiry_id")."=".$ENQ_ROWS['enquiry_id'],"950px", "500px", "500px", "100px"); ?> title="View  Enquiry Details">&nbsp;&nbsp;</A>
           
              <A id="Edit" <?php Modal("Enquiry_New.php?".md5("edit_id")."=".$ENQ_ROWS['enquiry_id'],"1000px", "700px", "350px", "100px"); ?> title="Edit  Enquiry Details">&nbsp;</A>
              
               
            
              
            <A id="Delete" href="Enquiry.php?<?php echo md5("enquiry_delete_id")."=".$ENQ_ROWS['enquiry_id']; ?>" <?php Confirm("Are You Sure ? Delete This Expense Entry ? "); ?>  title="Delete Enquiry ">&nbsp;</A></div>
          </td>
        </tr>
      
        <?php } ?>
      </table>
      
     
      
       <div align="right" class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url('Enquiry.php'));  ?></div>
           
      </td>
  </tr>
</table>
<?php 
if($_GET[md5("enquiry_delete_id")]>0)
{
	NoAdmin();
    $DELETE_ROW=$DBOBJ->GetRow("tbl_enquiry","enquiry_id",$_GET[md5("enquiry_delete_id")]);
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_enquiry where enquiry_id='".$_GET[md5("enquiry_delete_id")]."' ");	
	$DBOBJ->UserAction("ENQUIRY ADDED", " ID : ".$_GET[md5("enquiry_delete_id")].", CUSTOMER : ".$DELETE_ROW['customer_name']);
	header("location:Enquiry.php?Message=Selected Enquiry Have Been Deleted Successfully.");		
}
include("../Menu/Footer.php"); 

?>
