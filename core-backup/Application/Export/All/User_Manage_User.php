<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
//	RefreshPage();
	
?>
<center>
<h1>User : <span>Manage User</span></h1>
    
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable">
      <tr id="TH">
        <th width="41" rowspan="2">#</th>
        <th width="163" rowspan="2">USER NAME</th>
        <th width="187" rowspan="2">USER&nbsp;FULL&nbsp;NAME</th>
        <th width="111" rowspan="2">USER&nbsp;CATEGORY</th>
        <th width="149" rowspan="2">EMAIL&nbsp;ADDRESS</th>
        <th width="70" rowspan="2">MOBILE&nbsp;NO</th>
        <th width="52" rowspan="2">STATUS</th>
        <th colspan="2"> LAST UPDATES DETAILS</th>
      </tr>
      <tr id="TH">
        <th width="171">ADMINISTRATIVE</th>
        <th width="139">LAST LOGIN DETAILS</th>
      </tr>
      <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ST_QUERY="select * from tbl_admin_user where 1 ";
			    
		$PAGINATION_QUERY=$ST_QUERY."  order by user_id ";
		$ST_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ST_QUERY=@mysqli_query($_SESSION['CONN'],$ST_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ST_QUERY);

while($USER_ROWS=@mysqli_fetch_assoc($ST_QUERY)) 
{
	$SEET_STATUS=$DBOBJ->ConvertToText("tbl_room_seet","seet_id","seet_status",$USER_ROWS["student_seat"]);		
?>
      <tr>
        <td><div align="center"><?php echo $k++;?>.</div></td>
        <td><?php echo $USER_ROWS['user_id']; ?></td>
        <td><?php echo $USER_ROWS['user_name']; ?></td>
        <td><div align="center"><?php echo $USER_ROWS['user_category']; ?></div></td>
        <td style="text-transform:none"><?php echo $USER_ROWS['user_email_id']; ?></td>
        <td><?php echo $USER_ROWS['user_mobile']; ?></td>
        <td><div align="center">
		<?php 
		if($USER_ROWS['user_status']=="1") { echo "<font color='green'>Active</font>"; } else {  echo "<font color='red'>InActive</font>";  }
		 
		
		?></div></td>
        <td><?php echo "Created/Edited By : ".$USER_ROWS['user_created_by'].", From IP : ".$USER_ROWS['user_created_by_ip'].", On Date : ".$USER_ROWS['user_created_by_date'].", ".$USER_ROWS['user_created_by_time']; ?></span></td>
       
        <td><?php echo "Date :  ".$USER_ROWS['user_last_access_date'].", ".$USER_ROWS['user_last_access_time'].", IP : ".$USER_ROWS['user_last_access_ip'].", ".$USER_ROWS['user_created_by_time']; ?></td>
        </tr>
      <?php } ?>
  </table>
</center>
