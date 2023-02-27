<?php include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("DPR");
NoAdmin();

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
  <h1><img src="../SpitechImages/Executive.png" width="31" height="32" />DPR : <span> Executive List</span> <A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>" ><img src="../SpitechImages/FindIcon.png" />Search</A> </h1>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
    <tr>
      <td><center>
          <?php ErrorMessage(); ?>
          <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
            <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
              <tr>
                <td width="3%">Name</td>
                <td width="16%"><input type="text" id="name" name="name" placeholder="NAME" maxlength="50" value="<?php echo $_GET['name']?>"/></td>
                 <td width="3%">DESIGNATION</td>
                <td width="16%"><input type="text" id="designation" name="designation" placeholder="DESIGNATION" value="<?php echo $_GET['designation']?>" maxlength="50"/></td>
                <td width="3%">MOBILE</td>
                <td width="16%"><input type="text" id="mobile" name="mobile" placeholder="MOBILE" value="<?php echo $_GET['mobile']?>" maxlength="10"/></td>
                <td width="2%">EMAIL</td>
                <td width="44%"><input type="text" id="email" name="email"  placeholder="E-MAIL" value="<?php echo $_GET['email']?>" maxlength="50"/></td>
                <td width="8%"><input type="submit" name="Search" value=" " id="Search" /></td>
                <td width="8%"><input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='DPR_Executive.php'" style="width:80px;"/></td>
              </tr>
            </table>
          </form>
          <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
            <tr>
              <th width="2%">#</th>
              <th width="3%">PHOTO</th>
              <th width="17%">NAME</th>
              <th width="12%">DESIGNATION</th>
              <th width="5%">MOBILE</th>
              <th width="15%">EMAIL</th>
              <th width="25%">ADDRESS</th>
              <th width="6%">HIRE&nbsp;DATE</th>
              <th width="8%">STATUS</th>
              <th width="7%" class="Action">ACTION</th>
            </tr>
<?php 
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ADVISOR_QUERY="select * from tbl_dpr_executive where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET['name']!="") 		{ $ADVISOR_QUERY.=" and name like '%".$_GET['name']."%' "; }	
			if($_GET['designation']!="") 		{ $ADVISOR_QUERY.=" and designation = '".$_GET['designation']."' "; }			
			if($_GET['mobile']!="") 	{ $ADVISOR_QUERY.=" and mobile ='".$_GET['mobile']."' "; }
			if($_GET['email']!="") 		{ $ADVISOR_QUERY.=" and email ='".$_GET['email']."' "; }				
		}
	    
		$PAGINATION_QUERY=$ADVISOR_QUERY."  order by name ";
		$ADVISOR_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ADVISOR_QUERY=@mysqli_query($_SESSION['CONN'],$ADVISOR_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ADVISOR_QUERY);

while($EXECUTIVE_ROWS=@mysqli_fetch_assoc($ADVISOR_QUERY)) {
?>
            <tr>
              <td><div align="center"><?php echo $k++;?>.</div></td>
              <td style="margin:1PX; padding:1PX; text-align:center;" title="View Profile Of <?php echo advisor_title?> : <?php echo $EXECUTIVE_ROWS['name']; ?>"><a href="<?php echo "DPR_Executive_Profile.php?".md5('advisor_id')."=".$EXECUTIVE_ROWS['id'];?>" >
                <?php $ACTUAL_PHOTO="../SpitechUploads/executive/".$EXECUTIVE_ROWS['photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $EXECUTIVE_ROWS['photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		
		 ?>
                <img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="37" height="32" style="MArgin:0PX; padding:0PX;"/> </a></td>
              <td><?php echo $EXECUTIVE_ROWS['name']; ?></td>
              <td style="text-align:center"><?php echo $EXECUTIVE_ROWS['designation']; ?></td>
              <td><div align="center"><?php echo $EXECUTIVE_ROWS['mobile']."<br/>".$EXECUTIVE_ROWS['whatsapp_no']; ?></div></td>
              <td><div align="left" style="text-transform:none;"><?php echo $EXECUTIVE_ROWS['email']; ?></div></td>
              <td><?php echo $EXECUTIVE_ROWS['address']; ?></div></td>
              <td><div align="center" style="width:80PX;"><?php ShowDate($EXECUTIVE_ROWS['date']); ?></div></td>
              <td>
        <div align="center">
		<?php if($EXECUTIVE_ROWS['status']=="1") { echo "<font color='green'>Active</font>"; } else {  echo "<font color='red'>InActive</font>";  }	?>
        </div>
              </td>
              <td class="Action"><div align="center" style="width:80px;">
              <a id="Edit" href="<?php echo "DPR_Executive_New.php?".md5('edit_id')."=".$EXECUTIVE_ROWS['id'];?>" title="Edit Profile Of : <?php echo $EXECUTIVE_ROWS['name']; ?>">&nbsp;</a>              
                 
              <a id="Delete" href="DPR_Executive.php?<?php echo  md5("executive_delete_id")."=".$EXECUTIVE_ROWS['id']; ?>" <?php Confirm("Are You Sure ? Delete Executive ? ".$EXECUTIVE_ROWS['name']." ? "); ?>  title="Delete Profile of : <?php echo $EXECUTIVE_ROWS['name']; ?>">&nbsp;</a>
              </div>
              
               </td>
            </tr>
            <?php } ?>
          </table>
          <div class="paginate" >
            <?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?>
          </div>
        </center></td>
    </tr>
  </table>
</center>
<?php 
if(isset($_GET[md5("executive_delete_id")]))
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_dpr_executive","id",$_GET[md5("executive_delete_id")]);	
    
	@mysqli_query($_SESSION['CONN'],"delete from tbl_dpr_details where dpr_id in(select id from tbl_dpr where executive_id= '".$_GET[md5("executive_delete_id")]."') ");
	@mysqli_query($_SESSION['CONN'],"delete from tbl_dpr where executive_id='".$_GET[md5("executive_delete_id")]."' ");		
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_dpr_executive where id='".$_GET[md5("executive_delete_id")]."'");	
    @unlink('../SpitechUploads/executive/'.$DELETE_ROW['photo']);	

	$DBOBJ->UserAction("EXECUTIVE DELETED","ID=".$_GET[md5("executive_delete_id")].", NAME : ".$DELETE_ROW['name']);	
	header("location:DPR_Executive.php?Error=Executive : ".$DELETE_ROW['name']." Deleted.");	
}
include("../Menu/Footer.php"); 
?>
