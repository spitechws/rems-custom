<?php  include_once("../Menu/HeaderAdmin.php");
 Menu("DPR");
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
	 #Data-Table #white td { background:#fff; }
	 #Data-Table #red td { background:#CEFFE7; }	
	 #Data-Table #yellow td { background:yellow; }	
</style>

<h1><img src="../SpitechImages/DPR.png" />DPR : <span>Master List</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td >
    <?php ErrorMessage(); ?>
    <form name="FindForm" id="FindForm" method="get" >
   
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" class="SearchTable" style="margin-top:5px;">
        <tr>
          
          <td width="5%">EXECUTIVE</td>
          <td width="61%">
          <select name="executive_id" id="executive_id" style="width:100%">
                    <option value="All">All Executives...</option>
                    <?php $ESECUTIVE_Q="SELECT * from tbl_dpr_executive ORDER BY name, designation, status";
			   $ESECUTIVE_Q=@mysqli_query($_SESSION['CONN'],$ESECUTIVE_Q);
			   while($ESECUTIVE_ROWS=@mysqli_fetch_assoc($ESECUTIVE_Q)) {?>
                    <option value="<?php echo $ESECUTIVE_ROWS['id'];?>" <?php SelectedSelect($ESECUTIVE_ROWS['id'], $_GET['executive_id']); ?>><?php echo $ESECUTIVE_ROWS['name']." [".$ESECUTIVE_ROWS['designation']." ]";?></option>
                    <?php } ?>
           </select>
          </td>
          <td width="5%">FROM</td>
          <td width="2%" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd','<?php echo $s_date; ?>');</script></td>
          <td width="6%">TO</td>
          <td width="6%" class="Date"><script>DateInput('e_date', true, 'yyyy-mm-dd','<?php echo $e_date; ?>');</script></td>
          <td width="8%"><input type="submit" name="Search" value=" " id="Search" /></td>
          <td width="7%"><input type="button" name="All" value="Show All" class="Button" onclick="window.location='DPR.php';" /></td>
        </tr>
      </table>
    </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
        <tr>
          <th width="20">#</th>
          <th width="72">DATE</th>
          <th>EXECUTIVE</th>
          <th>DESIGNATION</th>
          <th>TOTAL NO. OF FOLLOW-UP TAKEN</th>
          <th>TOTAL NO. OF NEW PERSONS,<br />TO WHOM GIVEN INFORMATION</th>
          <th>TOTAL NO. OF CALLS DONE<br />( FOLLOW-UP + GIVEN INFORMATION )</th>
          <th>TOTAL NO. OF NEW PERSONS,<br />WHO ARE INTERESTED</th>
          <th width="131">TOTAL NO. OF NEW PERSONS,<br />WHO GIVEN APPOINTMENT</th>
          <th colspan="2">SUBMISSION DETAILS</th>
          <th width="58">ACTION</th>
        </tr>
        <?php 
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 25;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
			
			
		$DPR_QUERY="select * from tbl_dpr where 1 "; 	
		
		if(isset($_GET['Search']))
		{
		   if($_GET['executive_id']!="All")
		   {
			  $DPR_QUERY.=" executive_id='".$_GET['executive_id']."' ";
		   }
		}	
		
	    $DPR_QUERY.=" and date between '".$s_date."' and '".$e_date."' ";	
		$PAGINATION_QUERY=$DPR_QUERY."  order by id desc";
		$DPR_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$DPR_QUERY=@mysqli_query($_SESSION['CONN'],$DPR_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($DPR_QUERY);

while($DPR_ROWS=@mysqli_fetch_assoc($DPR_QUERY)) 
{			
?>
        <tr>
          <td><div align="center"><?php echo $k++;?>.</div></td>
          <td><div align="center" style="width:70px;"><b><?php echo date('d-M-Y',strtotime($DPR_ROWS['date'])); ?></b></div></td>
          <td width="195" style="text-align:justify"><?php echo $DBOBJ->ConvertToText("tbl_dpr_executive","id","name",$DPR_ROWS['executive_id'])?></td>
          <td width="166" style="text-align:center"><?php echo $DPR_ROWS['designation'] ?></td>
          <td width="108" style="text-align:center">
		  <?php 
		  echo $DPR_ROWS['follow_up']; $follow_up+=$DPR_ROWS['follow_up'];
		  if($DPR_ROWS['follow_up_remark']!="") { echo "<br/><font color='#0080C0'>".$DPR_ROWS['follow_up_remark']."</font>";}
		  ?>          
          </td>
          <td width="151" style="text-align:center">
		  <?php 
		  echo $DPR_ROWS['info_given'];  $info_given+=$DPR_ROWS['info_given'];
		  if($DPR_ROWS['info_given_remark']!="") { echo "<br/><font color='#0080C0'>".$DPR_ROWS['info_given_remark']."</font>";}
		  ?> 
		  </td>
          <td width="129" style="text-align:center">
		  <?php 
		  echo $DPR_ROWS['total'];  $total+=$DPR_ROWS['total']; 
		  if($DPR_ROWS['total_remark']!="") { echo "<br/><font color='#0080C0'>".$DPR_ROWS['total_remark']."</font>";}
		  ?></td>
          <td width="135" style="text-align:center">
		  <?php 
		  echo $DPR_ROWS['interested'];   $interested+=$DPR_ROWS['interested']; 
		  if($DPR_ROWS['interested_remark']!="") { echo "<br/><font color='#0080C0'>".$DPR_ROWS['interested_remark']."</font>";}
		  ?>
		  </td>
          <td width="131" style="text-align:center">
		  <?php 
		  echo $DPR_ROWS['appointment'];   $appointment+=$DPR_ROWS['appointment']; 
		  if($DPR_ROWS['appointment_remark']!="") { echo "<br/><font color='#0080C0'>".$DPR_ROWS['appointment_remark']."</font>";}
		  ?>
		  </td>
          <td width="56" style="text-align:center"><?php echo date('d-M-Y h:i:s A',strtotime($DPR_ROWS['entry_date_time'])); ?></td>
          <td width="47" style="text-align:center"><?php echo $DPR_ROWS['ip'];?></td>
          <td>
            <div align="center" style="width:50px;">        
            <A id="Report" <?php Modal("DPR_View.php?".md5("dvr_id")."=".$DPR_ROWS['id'],"950px", "500px", "500px", "100px"); ?> title="View  DPR Details">&nbsp;&nbsp;</A>   
            
            <a id="Delete" href="DPR.php?<?php echo  md5("dpr_delete_id")."=".$DPR_ROWS['id']; ?>" <?php Confirm("Are you sure ? Delete this report ? "); ?>  >&nbsp;</a>         
            </div>
          </td>
        </tr>
      
        <?php } ?>
        
        <tr>
          <th colspan="2">TOTAL</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th><?php echo $follow_up?></th>
          <th><?php echo $info_given?></th>
          <th><?php echo $total?></th>
          <th><?php echo $interested?></th>
          <th><?php echo $appointment?></th>
          <th colspan="2">&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
      </table>       
      <div align="right" class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url('DPR.php'));  ?></div>           
      </td>
  </tr>
</table>
<?php 

if(isset($_GET[md5("dpr_delete_id")]))
{
	NoAdmin();	
	@mysqli_query($_SESSION['CONN'],"delete from tbl_dpr_details where dpr_id='".$_GET[md5("dpr_delete_id")]."' ");
	@mysqli_query($_SESSION['CONN'],"delete from tbl_dpr where id='".$_GET[md5("dpr_delete_id")]."' ");	
	
	$DBOBJ->UserAction("DPR DELETED","ID=".$_GET[md5("dpr_delete_id")]);	
	header("location:DPR.php?Error=Report delete.");
}

include("../Menu/Footer.php"); ?>