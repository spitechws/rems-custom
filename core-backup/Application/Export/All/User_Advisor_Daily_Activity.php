<?php 
include_once('../php/Excel.php'); ExportExcel(); 
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

$ACTION_Q1="select * from tbl_advisor_action where 1 ";
if($ACTION!='All')
{
 $ACTION_Q1.=" and  action_name='$ACTION'";
}

if($USER!='All')
{
 $ACTION_Q1.=" AND action_user_id='$USER' ";
}
?>
<center>
<h1>User  : <span> <?php echo advisor_title?> Daily Activity  </span></h1>
      <table  width="100%" id="ExportTable" cellspacing="0" border="1" >
        <tr id="TH">
          <th width="42" height="22">S.NO</th>
          <th width="45">DATE</th>
          <th width="196">ACTIVITY&nbsp;DESCRIPTION</th>
          <th width="290">ACTION DETAILS</th>
          <th width="369"><?php echo advisor_title?>  NAME</th>
          <th width="137">USER ID</th>
          <th width="75">TIME</th>
          <th width="78">IP</th>
        </tr>
 <?php 
$k=1;
$date=$s_date;
while($date<=$e_date)
{
	$ACTION_Q=@mysqli_query($_SESSION['CONN'],$ACTION_Q1." and action_user_date='$date' order by action_id ");
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
          <td title="Associate NAME"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_code","advisor_name",$ACTION_ROWS['action_user_id']);?></td>
          <td title="USER ID"><div align="center"><?php echo $ACTION_ROWS['action_user_id']; ?></div></td>
          <td title="USER TIME"><div align="center"><?php echo $ACTION_ROWS['action_user_time'];?></div></td>
          <td title="IP ADDRESS"><div align="center"><?php echo $ACTION_ROWS['action_user_ip'];?></div></td>
        </tr>
        <?php } } $date = date('Y-m-d',(strtotime(date("Y-m-d", strtotime($date)) . " +1 day")));  } ?>
      </table>
    </center>
   