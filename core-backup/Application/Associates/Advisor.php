<?php
include_once("../Menu/HeaderAdvisor.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Advisor");

RefreshPage(1);
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Advisor.png" width="31" height="32" /><?php echo advisor_title?>  : <span> Master List</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>" ><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>
     <?php ErrorMessage(); ?>
     <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
      <tr>
        <td width="5%">Name</td>
        <td width="13%"><input type="text" id="advisor_name" name="advisor_name" style="width:100px;"  placeholder="NAME" maxlength="50"/></td>
        <td width="4%">id</td>
        <td width="4%"><input type="text" id="advisor_code" name="advisor_code" style="width:80px;"  placeholder="ID CODE" maxlength="25" /></td>
        <td width="8%">MOBILE</td>
        <td width="12%"><input type="text" id="advisor_mobile" name="advisor_mobile" style="width:100px;"  placeholder="MOBILE" maxlength="10"/></td>
        <td width="7%">EMAIL</td>
        <td width="6%"><input type="text" id="advisor_email" name="advisor_email" style="width:100px;"  placeholder="E-MAIL" maxlength="50"/></td>
        <td width="6%">bg</td>
        <td width="12%"><input type="text" id="advisor_bg" name="advisor_bg" style="width:100px;"  placeholder="BLOOD GROUP" maxlength="25"/></td>
        <td width="7%">SPONCER</td>
        <td width="3%">
        <select name="advisor_sponsor" id="advisor_sponsor" style="width:120px;">
          <option value="All">All Sponsors...</option> 
            <?php 
			   $SPONSOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor where advisor_id in(".$_SESSION['advisor_team'].") ORDER BY advisor_name";
			   $SPONSOR_Q=@mysqli_query($_SESSION['CONN'],$SPONSOR_Q);
			   while($SPONSOR_ROWS=@mysqli_fetch_assoc($SPONSOR_Q)) {?>
             <option value="<?php echo $SPONSOR_ROWS['advisor_id'];?>" <?php SelectedSelect($SPONSOR_ROWS['advisor_id'], $_GET['advisor_sponsor']); ?>>
			 <?php echo $SPONSOR_ROWS['advisor_name']." [".$SPONSOR_ROWS['advisor_code']." ]";?>
             </option>
             <?php } ?>       
        </select></td>
        <td width="4%">LEVEL</td>
        <td width="7%">
        
          
        <select name="advisor_level_id" id="advisor_level_id" style="width:100px;">
          <option value="All">All Lavel...</option>
          <?php 
			   $LEVEL_Q="SELECT level_id, level_name FROM tbl_setting_advisor_level ORDER BY level_id";
			   $LEVEL_Q=@mysqli_query($_SESSION['CONN'],$LEVEL_Q);
			   while($LEVEL_ROWS=@mysqli_fetch_assoc($LEVEL_Q)) {?>
           <option value="<?php echo $LEVEL_ROWS['level_id'];?>" <?php SelectedSelect($LEVEL_ROWS['level_id'], $_GET['advisor_level_id']); ?>>
           <?php echo $LEVEL_ROWS['level_name'];?> </option>
           <?php } ?>
        </select></td>
        <td width="14%">
        <input type="submit" name="Search" value=" " id="Search" /></td>
        <td width="15%">
        <input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='Advisor.php'" style="width:80px;"/></td>
      
      </tr>
     
      </table>

  </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
      <tr>
    <th width="2%" rowspan="2">#</th>
    <th width="3%" rowspan="2"><div align="center" style="width:80px;">ID&nbsp;CODE</div></th>
    <th width="3%" rowspan="2">photo</th>
    <th width="23%" rowspan="2">NAME</th>
    <th width="7%" rowspan="2">LEVEL</th>
    <th colspan="2">SPONSOR</th>
    <th colspan="3">CONTACT DETAILS</th>
    <th width="7%" rowspan="2">HIRE&nbsp;DATE</th>
    <th width="8%" rowspan="2">DOB</th>
    </tr>
      <tr>
        <th width="16%">NAME</th>
        <th width="7%">ID&nbsp;CODE</th>
        <th width="4%">MOBILE</th>
        <th width="4%">PHONE</th>
        <th width="16%">EMAIL</th>
      </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ADVISOR_QUERY="select * from tbl_advisor where advisor_id in(".$_SESSION['advisor_team'].") ";
		if(isset($_GET['Search']))
		{
			if($_GET['advisor_name']!="") 		{ $ADVISOR_QUERY.=" and advisor_name like '%".$_GET['advisor_name']."%' "; }
			if($_GET['advisor_code']!="") 		{ $ADVISOR_QUERY.=" and advisor_code ='".$_GET['advisor_code']."' "; }
			if($_GET['advisor_mobile']!="") 	{ $ADVISOR_QUERY.=" and advisor_mobile ='".$_GET['advisor_mobile']."' "; }
			if($_GET['advisor_email']!="") 		{ $ADVISOR_QUERY.=" and advisor_email ='".$_GET['advisor_email']."' "; }
			if($_GET['advisor_bg']!="") 		{ $ADVISOR_QUERY.=" and advisor_bg ='".$_GET['advisor_bg']."' "; }
			if($_GET['advisor_sponsor']!="All") 	{ $ADVISOR_QUERY.=" and advisor_sponsor ='".$_GET['advisor_sponsor']."' "; }
			if($_GET['advisor_level_id']!="All")	{ $ADVISOR_QUERY.=" and advisor_level_id ='".$_GET['advisor_level_id']."' "; }
		}
	    
		$PAGINATION_QUERY=$ADVISOR_QUERY."  order by advisor_name ";
		$ADVISOR_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ADVISOR_QUERY=@mysqli_query($_SESSION['CONN'],$ADVISOR_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ADVISOR_QUERY);

while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="center"><?php echo $ADVISOR_ROWS['advisor_code']; ?></div></td>
    
      <td style="margin:1PX; padding:1PX; text-align:center;" title="View Profile Of Associate : <?php echo $ADVISOR_ROWS['advisor_name']; ?>">
     <a href="<?php echo "Advisor_Profile.php?".md5('advisor_id')."=".$ADVISOR_ROWS['advisor_id'];?>" >
     <?php $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$ADVISOR_ROWS['advisor_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $ADVISOR_ROWS['advisor_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="37" height="32" style="MArgin:0PX; padding:0PX;"/> 
         </a>
    </td>
   
    <td ><div align="left"  style="width:200PX;"><?php echo $ADVISOR_ROWS['advisor_name']; ?></div></td>
    <td >
    <div align="center" style="width:80PX;">
	   <?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROWS['advisor_level_id']); ?>
    </div>
    </td>
    <td >
    <div align="LEFT" style="width:200PX;">
	<?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$ADVISOR_ROWS['advisor_sponsor']); ?>
    </div>
    </td>
    <td >
    <div align="center" style="width:80PX;">
	<?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$ADVISOR_ROWS['advisor_sponsor']); ?>
    </div>
    </td>
    <td><div align="center"><?php echo $ADVISOR_ROWS['advisor_mobile']; ?></div></td>
    <td><div align="center"><?php echo $ADVISOR_ROWS['advisor_phone']; ?></div></td>
    <td><div align="left"><?php echo $ADVISOR_ROWS['advisor_email']; ?></div></td>
    <td><div align="center" style="width:80PX;"><?php ShowDate($ADVISOR_ROWS['advisor_hire_date']); ?></div></td>
    <td><div align="center" style="width:80PX;"><?php ShowDate($ADVISOR_ROWS['advisor_dob']); ?></div></td>
    </tr>
  <?php } ?>
</table>
 <div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
    </td>
  </tr>
</table>
</center>
<?php include("../Menu/FooterAdvisor.php"); ?>