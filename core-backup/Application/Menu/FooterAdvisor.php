<?php 
    $DBOBJ->UserAdvisorLastAccessTimeEntry();
	SpitechPleaseWait();
?>
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
<script>
function renderTime() 
	{
	setTimeout('renderTime()',1000);
	GetPage('../App/GetIndianTime.php','Timer');
	}
	renderTime() 
</script>