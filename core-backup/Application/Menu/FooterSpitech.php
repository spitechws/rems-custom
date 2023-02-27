<?php SpitechPleaseWait();?>

<style>
body { overflow:hidden; }
#Footer   { margin:0px; padding:0px; height:10%; background:#3AA6C4;  border-top:1px solid black; min-height:50px; }
#Footer * { text-align:center; }
#Footer a { color:maroon }
#Footer a:hover { color:red; }
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Footer">
  <tr>
    
    <td style="padding-top:10px; vertical-align:top;">
      
      <div style=" margin-bottom:5px; ">
       
       Copyright &copy; Copyright 2013-2014 <a href="#"><b>Spitech Pvt. Ltd.</b></a> , All Rights Reserved. 
        Developed By : <a href="http://www.spitech.in" target="_blank" title="Go To Spitech Website"><b>Spitech Pvt. Ltd.</b></a>  
       
      </div>    </td> 
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