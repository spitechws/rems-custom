<?php
 include_once("../Menu/HeaderAdmin.php");
 Menu("User");
	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();	
	NoAdmin();
//	RefreshPage();
	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" /> 

<h1><img src="../SpitechImages/Users.png" />User : <span>Manage User</span></h1>

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td >
    <?php ErrorMessage(); ?>
    
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
      <tr>
        <th width="41" rowspan="2">#</th>
        <th width="53" rowspan="2">PHOTO</th>
        <th width="163" rowspan="2">user name</th>
        <th width="187" rowspan="2">user&nbsp;full&nbsp;name</th>
        <th width="111" rowspan="2">user&nbsp;category</th>
        <th width="149" rowspan="2">email&nbsp;address</th>
        <th width="70" rowspan="2">mobile&nbsp;no</th>
        <th width="52" rowspan="2">status</th>
        <th colspan="2"> LAST UPDATES DETAILS</th>
        <th width="76" rowspan="2">ACTION</th>
      </tr>
      <tr>
        <th width="171">Administrative</th>
        <th width="139">last login details</th>
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
        <td>
          <?php  
		  $ACTUAL_PHOTO="../SpitechUploads/admin/profile_photo/".$USER_ROWS['user_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!=1 || $USER_ROWS['user_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Default.png"; }
		  ?>
          <img src="<?php echo $ACTUAL_PHOTO; ?>" width="47" height="38" class="Rounded" alt="IMG"  />
          </td>
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
        
        <td style="width:50px;">
    
        <div align="center" style="width:80px;">  
     
         <a id="Edit" title="Edit Details Of User : <?php echo $USER_ROWS['user_name']; ?>"  <?php Modal("User_Create_User.php?".md5("edit_id")."=".$USER_ROWS['user_id'],"700px","400px","300px","200px")?> >
         &nbsp;&nbsp;&nbsp;&nbsp;
        </a>
		<?php if(strtoupper($USER_ROWS['user_id'])!="ADMIN") { ?>
      
        <a id="Delete" href="User_Manage_User.php?<?php echo md5("user_delete_id")."=".$USER_ROWS['user_id']; ?>" <?php Confirm("Are You Sure ? Delete User & Their Related Details ? "); ?>  title="Delete Details Of User : <?php echo $USER_ROWS['user_name']; ?>">&nbsp;</a>
        <?php } ?>
        </div>
        
        </td>
        </tr>
      <?php } ?>
    </table></td>
  </tr>
</table>
</center>
<?php 
if(isset($_GET[md5("user_delete_id")]) && strtoupper($_GET[md5("user_delete_id")])!="ADMIN")
{
	$PHOTO=$DBOBJ->ConvertToText("tbl_admin_user","user_id","user_photo ",$_GET[md5("user_delete_id")]);
	unlink("../Uploads/admin/profile_photo/".$PHOTO);
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_admin_user where user_id='".$_GET[md5("user_delete_id")]."' ");
	header("location:User_Manage_User.php?Message=User Details Deleted Successfully.");	
}
include("../Menu/Footer.php"); 

?>   