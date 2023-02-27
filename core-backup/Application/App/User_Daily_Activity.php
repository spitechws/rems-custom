<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("User");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$ACTION=$_REQUEST['action'];
$CATEGORY=$_REQUEST['CATEGORY'];
$USER=$_REQUEST['user'];

$s_date=date('Y-m-d');
$e_date=date('Y-m-d');
if(isset($_REQUEST['s_date']))
{
	$s_date=$_REQUEST['s_date'];
	$e_date=$_REQUEST['e_date'];
}

$ACTION_Q1="select * from tbl_admin_user_action where 1 ";
if($ACTION!='All')
{
 $ACTION_Q1.=" and  action_name='$ACTION'";
}
if($CATEGORY!='All')
{
 $ACTION_Q1.=" and  action_user_category='$CATEGORY' ";
}
if($USER!='All')
{
 $ACTION_Q1.=" AND action_user_name='$USER' ";
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/UsersActivity.png" width="31" height="32" />User  : <span> Daily Activity  </span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>"><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center> <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
      <table  width="98%" id="CommonTable" cellspacing="0" class="DontPrint" style="margin-top:0px;">
         
          <tr>
            <td width="5%" >ACTION</td>
            <td width="9%" >
            <select name="action" id="action" required="required" style="width:100PX;" >
              <option value="All">ALL ACTIVITY...</option>
              <?php $ACT_Q =@mysqli_query($_SESSION['CONN'],"select action_name from  tbl_admin_user_action group by action_name order by action_name ");
		while($ACT_ROWS=@mysqli_fetch_array($ACT_Q))
		{?>
              <option value="<?php echo $ACT_ROWS['action_name']?>" <?php if($ACT_ROWS['action_name']==$_GET['action']) { ?> selected="selected" <?php } ?>><?php echo $ACT_ROWS['action_name']?></option>
              <?php } ?>
            </select></td>
            <td width="6%" >CATEGORY</td>
            <td width="9%" ><select name="CATEGORY"  id="CATEGORY" required="required"  style="width:100PX;" >
              <option value="All">ALL USER CATEGORY...</option>
             
              <?php $CAT_Q =@mysqli_query($_SESSION['CONN'],"select user_category from  tbl_admin_user group by user_category ORDER BY user_category");
		while($CAT_ROWS=@mysqli_fetch_array($CAT_Q))
		{?>
              <option value="<?php echo $CAT_ROWS['user_category']?>"><?php echo $CAT_ROWS['user_category']?></option>
              <?php } ?>
            </select></td>
            <td width="4%" >USER</td>
            <td width="9%" >
            <select name="user"  id="user" required="required" style="width:100PX;" >
              <option value="All">ALL USER....</option>
              <?php $USER_Q =@mysqli_query($_SESSION['CONN'],"select user_id from  tbl_admin_user ORDER BY user_id");
		while($USER_ROWS=@mysqli_fetch_array($USER_Q))
		{?>
              <option value="<?php echo $USER_ROWS['user_id']?>"><?php echo $USER_ROWS['user_id']?></option>
              <?php } ?>
            </select></td>
            <td width="4%" >FROM</td>
            <td width="2%" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd','<?php echo $s_date?>')</script></td>
            <td width="3%" >TO</td>
            <td width="3%" class="Date" ><script>DateInput('e_date', true, 'yyyy-mm-dd','<?php echo $e_date?>')</script></td>
            <td width="46%" ><input type="submit" name="Search" id="Search" value=" " class="button" /></td>
          </tr>
       
      </table> </form>
      <?php if(isset($_GET['Search'])) { ?>
      <table  width="100%" id="SearchTable" cellspacing="0" class="DontPrint">
        <tr>
          <td width="3%" align="left">ACTION&nbsp;:</td>
          <td width="20%" id="Value"><?php echo $ACTION; ?></td>
          <td width="4%" align="left">USER&nbsp;:</td>
          <td width="18%" id="Value"><?php echo $USER;?></td>
          <td width="6%" align="left"><div align="left">CATEGORY&nbsp;:</div></td>
          <td width="11%" id="Value"><?php echo $CATEGORY;?></td>
          <td width="10%" align="left"><div align="left">STATEMENT&nbsp;DATE&nbsp;:</div></td>
          <td width="28%" colspan="5" id="Value"><strong>From&nbsp;:</strong> <?php echo date('d-m-Y',strtotime($s_date)); ?> <strong>To&nbsp;:</strong> <?php echo date('d-m-Y',strtotime($e_date)); ?></td>
        </tr>       
      </table>
      <?php } ?>
      <table  width="100%" id="Data-Table" cellspacing="1" >
        <tr>
          <th width="39" height="22">S.NO</th>
          <th width="42">DATE</th>
          <th width="208">ACTIVITY DESCRIPTION</th>
          <th width="463">action details</th>
          <th width="183">category</th>
          <th width="139">user id</th>
          <th width="79">time</th>
          <th width="79">ip</th>
        </tr>
 <?php 
$k=1;
$date=$s_date;
while($date<=$e_date)
{
	$ACTION_Q=@mysqli_query($_SESSION['CONN'],$ACTION_Q1." and action_user_date='$date' ");
	$exist=@mysqli_num_rows($ACTION_Q);
	if($exist>0) {
?>
        <tr style="font-size:11px; background:#D7FFD7; font-size:14px;">
          <td height="22"><div align="center" style="font-weight:bolder;"><?php echo $k++?>.</div></td>
          <td colspan="7" title="<?php echo date('d-m-Y',strtotime($date));  ?>"><div align="left" style="font-weight:bolder;"><?php echo date('d-m-Y',strtotime($date));  ?></div></td>
        </tr>
        <?php 		$j=1;
	//echo $ACTION_Q1." and action_user_date='$date' order by action_id ";
	
	while($ACTION_ROWS=@mysqli_fetch_array($ACTION_Q)) {
	?>
        <tr title="ACTION ON DATE : <?php echo date('d-m-Y',strtotime($date));  ?>" >
          <td height="22"><div align="center"></div></td>
          <td><div align="center" ><?php echo $j++; ?></div></td>
          <td title="ACTION &amp; ACTIVITY ON DATE : <?php echo date('d-m-Y',strtotime($date));  ?>" style="font-size:9px; font-family:tahoma; color:#000000; font-weight:bolder;">
		  <?php echo $ACTION_ROWS['action_name']; ?></td>
          <td title="ACTION ON "><?php echo $ACTION_ROWS['action_on'];?></td>
          <td title="USER CATEGORY"><div align="center"><?php echo $ACTION_ROWS['action_user_category']?></div></td>
          <td title="USER NAME"><div align="center"><?php echo $ACTION_ROWS['action_user_name']; ?></div></td>
          <td title="USER ACTION"><div align="center"><?php echo $ACTION_ROWS['action_user_time'];?></div></td>
          <td title="IP ADDRESS"><div align="center"><?php echo $ACTION_ROWS['action_user_ip'];?></div></td>
        </tr>
        <?php } } $date = date('Y-m-d',(strtotime(date("Y-m-d", strtotime($date)) . " +1 day")));  } ?>
      </table>
    </center>
    </td>
  </tr>
</table>
</center>
<?php include("../Menu/Footer.php"); ?>
