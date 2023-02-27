<?php sleep(1); 
if($_GET['NAME'])
{
echo $_GET['NAME'];
//header("location:index.php");
echo "<script>window.location='index.php';</script>";
}

?>
<style type="text/css" media="screen">
.delete-form{

}
.delete-form label{
display:block;
font-size:14px;
color:#666;
margin:8px 0 6px 0;
}
.delete-form .field-wrapper{
background:#DDD;
padding:6px;
margin:4px 0;
}
.delete-form .field-wrapper input{
width:300px;
padding:4px;
font-size:16px;
color:#666;
border:1px solid #AAA;
}
.delete-form span{
font-size:14px;
color:#D44;
}
</style>
<p>
<strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <em>Duis aute irure dolor in reprehenderit in voluptate velit</em> esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
</p>
<div class="delete-form">
<label for="confirm-text">TYPE "DELETE" TO CONFIRM DELETION</label>
<div class="field-wrapper">
<FORM method="get" name="form1" id="form1" action="ajax-content.php">
<table width="50%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="3%">NAME</td>
    <td width="47%"><input type="text" id="confirm-text" name="NAME" value="<?php echo $_GET['text']; ?>"/></td>
    </tr>
  <tr>
    <td>AGE</td>
    <td><input type="text" value="" id="confirm-text2" name="AGE" /></td>
  </tr>
  <tr>
    <td>FNAME</td>
    <td><input type="text" value="" id="confirm-text3" name="FNAME"  /></td>
  </tr>
  <tr>
    <td>MNAME</td>
    <td><input type="text" value="" id="confirm-text4"  name="MNAME" /></td>
  </tr>
  <tr>
    <td>SCHOOL</td>
    <td><input type="text" value="" id="confirm-text5"  name="SCHOOL" /></td>
  </tr>
</table>
</FORM>
</div>
<span style="display:none;" id="confirm-delete-error">Error: insert DELETE</span>
</div>