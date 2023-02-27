<?php 
session_start();
?>
<!-- The following is example HTML that can be used on your form -->
  <table width="100" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="102">
    <img id="siimage" style="border:1px solid#000; width:100px; height:30px;" src="./securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left">
    </td>
    
    
    <td width="20">
     <object type="application/x-shockwave-flash" data="./securimage_play.swf?bgcol=#ffffff&amp;icon_file=./images/audio_icon.png&amp;audio_file=./securimage_play.php" style="width:20px; height:20px;">
    <param name="movie" value="./securimage_play.swf?bgcol=#ffffff&amp;icon_file=./images/audio_icon.png&amp;audio_file=./securimage_play.php" />
    </object>
    </td>
    
    
    <td width="48">
    <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = './securimage_show.php?sid=' + Math.random(); this.blur(); return false">
    <img src="./images/refresh.png" alt="Reload Image" onclick="this.blur()" align="bottom" border="0" style=" width:20px; height:20px;">
    </a>
    </td>
  </tr>
  
  <tr>
    <td>Enter&nbsp;Code</td>
    <td colspan="2"><input type="text" name="spitech_captcha" size="12" maxlength="16" placeholder="Enter Code" /></td>
    </tr>
</table>
<?
print_r($_SESSION);





//echo "<br>1...".$_SESSION['securimage_code_value']['default'];

?>
   