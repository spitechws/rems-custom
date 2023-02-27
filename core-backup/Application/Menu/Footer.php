<?php $DBOBJ->UserLastAccessTimeEntry();@SpitechPleaseWait(); ?>
<style>
#Footer { margin:0px; padding:0px; height:70px; background:url(../SpitechImages/Footer.png) repeat-x; margin-bottom:-30px;  }
#Footer * { text-align:center; }
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Footer" style="margin-bottom:-30px; ">
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="69%" style="padding-top:5px;">
    
    Copyright &copy; <?php echo site_copyright?> <a href="http://<?php echo site_url_home?>"><?php echo site_company_name?></a>, All Rights Reserved.  <br />
    Website : <a href="http://<?php echo site_url_home?>"><?php echo site_url_home?></a></td>
    <td width="21%" style="font-size:9px; text-align:center; color:#C16100; vertical-align:bottom;">
     <div style="width:250px; margin-bottom:5px;">
         Developed By : <b>Spitech Web Solution & Services</b><br />
         Website : <a href="http://www.spitech.in" target="_blank">www.spitech.in</a> 
     </div></td> 
   
  </tr>
</table>
</body>
</html>
<?php //------------------------( Auto Backup )-------------------------------
$file=date('d-m-Y').'.sql';
$time=explode(':',IndianTime());

$time_am_pm=explode(' ',$time[2]);
$file_name='../SpitechBackup/AutoBackup/'.$file;
if(!file_exists($file_name) && ($time[0]>5 && $time_am_pm[1]=='PM' && $time[0]!=12 ) ) 
{ 

    $server=$_SERVER['SERVER_NAME'];
	$url = APPROOT."SpitechBackup/AutoBackup.php";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_URL, $url); //set the url
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //return as a variable
	curl_setopt($ch, CURLOPT_POST, 1); //set POST method
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request); //set the POST variables
	$response = curl_exec($ch); //run the whole process and return the response
	curl_close($ch); //close the curl handle
	return $response;
}

//----------------------(  )--------------------------------------------
 $count_row=@mysqli_fetch_array(@mysqli_query($_SESSION['CONN'],"select count(action_id) from tbl_admin_user_action"));
 $count=$count_row[0];
 if($count>30000)
 {
   $LIMIT=$count-30000;
   @mysqli_query($_SESSION['CONN'],"DELETE FROM tbl_user_action order by action_id asc LIMIT $LIMIT");
 }	
 
?>
<script>
function renderTime() 
{
setTimeout('renderTime()',1000);
GetPage('../App/GetIndianTime.php','Timer');
}
renderTime() 
</script>