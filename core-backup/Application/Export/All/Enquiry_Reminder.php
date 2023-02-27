<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

	$s_date=date('2000-01-01');	
	$e_date=NextDate(date('Y-m-d'),+0);	
	if(isset($_GET['Search']))
	{
		$s_date=$_GET['s_date']; 	
	    $e_date=$_GET['e_date'];	
	}
	
?>
<center>
<h1>Enquiry : <span>Reminder</span></h1>

    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable">
      <tr id="TH">
        <th width="17">#</th>
        <th width="65">DATE</th>
        <th width="68">REMIND&nbsp;ON</th>
        <th>CUSTOMER</th>
        <th>MOBILE</th>
        <th>PROJECT</th>
        <th>PROPERTY</th>
        <th width="400">REMARKS</th>
        <th width="49">STATUS</th>
      </tr>
      <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ENQ_QUERY="select * from tbl_enquiry where 1 ";
	    
		if(!isset($_GET['Search'])) { $ENQ_QUERY.=" and status='Enable' "; }
		
		if(isset($_GET['Search']))		{			
			
			if($_GET['status']!="All") 		   { $ENQ_QUERY.=" and status ='".$_GET['status']."'"; 	            }				
		}
		
	    $ENQ_QUERY.=" and remind_date between '".$s_date."' and '".$e_date."' ";	
        $PAGINATION_QUERY=$ENQ_QUERY."  order by remind_date desc, enquiry_id desc ";
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
      </tr>
      <?php } ?>
    </table>    
    </center>