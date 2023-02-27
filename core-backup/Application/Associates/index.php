<?php
 include_once("../Menu/HeaderCommon.php");
 $DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
?>
<link rel="stylesheet" href="../css/SpitechStyle.css">
<style>
.table { background:url(../SpitechImages/AdminLoginBG.png) center repeat-y; height:auto; width:400px; margin-top:60px; padding:3px; border:2px solid #615D5C}
body { background:url(../SpitechImages/AdminLoginBodyBG.png); }
#CommonTable { width:320px; height:180px; border:0px solid #009AD0; margin-top:50px; color:white; text-transform:uppercase;}
#CommonTable tr td { background:none;color:white; text-transform:uppercase; font-weight:bolder; font-size:13px; }
h3 { line-height:80px; font-size:18px; font-variant:bolder;color:#3F6;text-shadow:2px 2px black; }
#advisor_code { color:#006090; background:white url(../SpitechImages/UserLoginBG.png) right no-repeat; padding-right:30px; padding-left:10px;}
#advisor_password { color:#006090; background:white url(../SpitechImages/UserLoginPWD.png) right no-repeat;padding-right:30px; padding-left:10px;}

h3 { line-height:80px; font-size:18px; font-variant:bolder;color:#3F6;text-shadow:2px 2px black; }
</style>
<body style=" margin:0px; padding:0px;">

<center>
<div style="height:80px; border-bottom:5px solid #731F19; text-align:center; margin:0px; background:#fff;">
<a onClick="window.location='../../index.php'"><img src="../SpitechLogo/Logo.png" width="200" height="100" style="margin-top:5px; opacity:1;padding:5px; border:2px solid #731F19;background:white; "/></a></div>
<div class="table">
<form name="LoginForm" id="LoginForm" method="post" action="LoginCheck.php">
 <table width="98%" border="0" cellspacing="0" cellpadding="2" id="CommonTable" style="margin-top:0px;">
  <tr>
    <td height="22" colspan="2" style="text-align:center"><?php echo strtoupper(advisor_title)?> Login Here :<hr/></td>
  </tr>
  <tr>
    <td height="22" colspan="2"><?php ErrorMessage();LoginError(); ?></td>
    </tr>
  <tr>
    <td width="81" height="22"><?php echo strtoupper(advisor_title)?> CODE ID </td>
    <td width="56">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="text" name="advisor_code" id="advisor_code" placeholder="CODE ID" style="width:280px;"  required=""/>
    </td>
    </tr>
  <tr>
    <td>password</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="password" name="advisor_password" id="advisor_password" placeholder="PASSWORD" style="width:280px;" required/></td>
    </tr>
  <?php  if($_SESSION['captcha_attempt']>2) {  ?>     
  <tr>
    <td colspan="2">
    <table width="100" border="0" cellspacing="0" cellpadding="2" style="margin-top:3px;">

 <tr>
    <td colspan="4" style="text-align:left;">Enter&nbsp;security code</td>
    </tr>
    
    
  <tr>
    <td width="102" >
    <img id="siimage" style="border:1px solid#000; width:100px; height:30px;" src="../SpitechCaptcha/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left">
    </td>
    
    
    <td width="20">
     <object type="application/x-shockwave-flash" data="../SpitechCaptcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=../SpitechCaptcha/images/audio_icon.png&amp;audio_file=../SpitechCaptcha/securimage_play.php" style="width:20px; height:20px;">
    <param name="movie" value="../SpitechCaptcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=../SpitechCaptcha/images/audio_icon.png&amp;audio_file=../SpitechCaptcha/securimage_play.php" />
    </object>
    </td>
    
    
    <td width="59" style="text-align:left">
    <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onClick="document.getElementById('siimage').src = '../SpitechCaptcha/securimage_show.php?sid=' + Math.random(); this.blur(); return false">
    <img src="../SpitechCaptcha/images/refresh.png" alt="Reload Image" onClick="this.blur()" align="bottom" border="0" style=" width:20px; height:20px;">
    </a>
    </td>
    <td width="59" style="text-align:left"><input type="text" name="user_captcha" id="user_captcha" size="12" maxlength="16" placeholder="CODE" style="width:120px;" required=''/></td>
  </tr>
  
 
</table>
    </td>
  </tr>
<?php } ?>  
  <tr>
    <td colspan="2">
      <div align="right">
        <a href="User_Forget_Password.php" style="float:left; margin-top:10px; text-transform:capitalize; color:#0F0">Forgot Password ?</a>
        <input type="submit" name="Login" id="Login" value="Login" />
      </div>
    </td>
    </tr>
</table>
</form>
</div>
<img src="../SpitechImages/Shadow.png" width="411" height="40">
</center></body>