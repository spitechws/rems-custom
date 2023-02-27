<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$ADVISOR_TEAM1=$_SESSION['advisor_team'];
?>
<link rel="stylesheet" href="treeview.css" />
<link rel="stylesheet" href="screen.css" />
<link rel="stylesheet" href="../css/SpitechStyle.css" />
<script src="jquery.js" type="text/javascript"></script>
<script src="jquerycookie.js" type="text/javascript"></script>
<script src="jquery_treeview.js" type="text/javascript"></script>
<script type="text/javascript" src="demo.js"></script>
<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				collapsed: true,
				animated: "fast",
				control:"#sidetreecontrol",
				prerendered: true,
				persist: "location"
			});
		})		
	</script>
<style>
* {font-family:arial;}
</style>
<table border="0" cellspacing="0" style="padding:0px; margin-top:5px; width:98%" id="CommonTable">
  <tr >
    <td width="9%" >SELECT&nbsp;SPONSOR </td>
    <td width="17%" style="height:40px; vertical-align:middle;">
    
    <form name="form2" action="AdvisorTreePersonal.php" method="get" style="margin-top:10PX;" >
        <select name="advisor_sponsor" id="advisor_sponsor" style="font-size:11px;" onchange="form2.submit()" >
          <option value="1" >SPONSOR ID...</option>
          <?php $q=@mysqli_query($_SESSION['CONN'],"select advisor_id, advisor_code, advisor_name, advisor_level_id from tbl_advisor where advisor_id in ($ADVISOR_TEAM1) order by advisor_id ");
							while($SPONSOR_ROWS=@mysqli_fetch_assoc($q))
							{						
							?>
          <option value="<?php echo $SPONSOR_ROWS['advisor_id'];?>" <?php if($_GET['advisor_sponsor']==$SPONSOR_ROWS['advisor_id']) {?> selected="selected"<?php } ?>>
          <?php echo $SPONSOR_ROWS['advisor_code']?>
          - [
          <?php echo $SPONSOR_ROWS['advisor_name']." / ".$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$SPONSOR_ROWS['advisor_level_id']);?>
          ] </option>
          <?php } ?>
        </select>
      </form></td>
    <td width="22%" style="vertical-align:middle">
    <form name="form1" action="AdvisorTreePersonal.php" method="get" style="margin-top:10PX;" >
        NAME&nbsp;
        <select name="advisor_sponsor" id="advisor_sponsor" style="font-size:11px; " onchange="form1.submit()" >
          <option value="1" >SPONSOR NAME...</option>
          <?php $q=@mysqli_query($_SESSION['CONN'],"select advisor_id, advisor_code, advisor_name, advisor_level_id from tbl_advisor where advisor_id in ($ADVISOR_TEAM1)  order by advisor_name");
							while($SPONSOR_ROWS=@mysqli_fetch_assoc($q))
							{
							
							?>
          <option value="<?php echo $SPONSOR_ROWS['advisor_id'];?>" <?php if($_GET['advisor_sponsor']==$SPONSOR_ROWS['advisor_id']) {?> selected="selected"<?php } ?>>
          <?php echo $SPONSOR_ROWS['advisor_name']?>
          - [
          <?php echo $SPONSOR_ROWS['advisor_code']." / ".$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$SPONSOR_ROWS['advisor_level_id']);?>
          ] </option>
          <?php } ?>
        </select>
      </form></td>
    <td width="52%">SHOWING TEAM OF : <blink><font color="#0033FF">
      <?php if($_GET['advisor_sponsor']) { echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$_GET['advisor_sponsor']);} else  { echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",1); } ?>
      </font></blink></td>
  </tr>
</table>
<?php
	function CreateDirectory($path = -1,$sql)
	{	$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
		if ($path>0) 
		{
			echo '<ul>';
		   $s = @mysqli_query($_SESSION['CONN'],"select  advisor_id, advisor_code, advisor_name, advisor_level_id from tbl_advisor where advisor_sponsor = '$sql' order by advisor_name");
			while ($rows = @mysqli_fetch_array($s))
			{
			$p = $rows['advisor_id'];
			$s1 = @mysqli_query($_SESSION['CONN'],"select  advisor_id, advisor_code, advisor_name, advisor_level_id from tbl_advisor where advisor_sponsor = '$p' order by advisor_name");
						
			
				if (@mysqli_num_rows($s1)>0)
					//printSubDir($file, $path, $queue);
					printSubDir($rows['advisor_id']);
				else if($rows['advisor_id']>0 || $rows['advisor_id']!="")
				{
				$ADV_sql = @mysqli_query($_SESSION['CONN'],"select  advisor_id, advisor_code, advisor_name, advisor_level_id from tbl_advisor where advisor_id='".$rows['advisor_id']."' order by advisor_name");
				$rows = @mysqli_fetch_array($ADV_sql);
				
				
				   if($rows['advisor_name']!=NULL)
					$queue[] = $rows['advisor_name']." / <font color=\"GREEN\"> ".$rows['advisor_code']." </font> / <font color=\"#006697\"> ".$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$rows['advisor_level_id'])."</FONT>";
				}
			}
			
			printQueue($queue);
			echo "</ul>";
		}else
		{
		}
	}
	
	function printQueue($queue)
	{
	
	  if(count($queue)>0)
	  {
		foreach ($queue as $file) 
		{
		   printFile($file);
		} 
	  }
		 
	}
	
	function printFile($file)
	{
	
		echo '<li style="color:#006697; font-weight:bolder;background-color:#FFFFFF; ">'.$file.'</li>';
	}
	
	function printSubDir($dir)
	{
		$DBOBJ = new DataBase();
		$DBOBJ->ConnectDatabase();
	$ADV_sql = @mysqli_query($_SESSION['CONN'],"select  advisor_id, advisor_code, advisor_name, advisor_level_id from tbl_advisor where advisor_id='$dir' order by advisor_name");
	$rows = @mysqli_fetch_array($ADV_sql);
				
				
					$c = $rows['advisor_name']." / <font color=\"GREEN\">".$rows['advisor_code']."</font> / <font color=\"#006697\">".$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$rows['advisor_level_id'])."</FONT>";
					
					
	 
		echo "<li style="."color:#006697;background-color:#FFFFFF;line-height:13px;"."><font style="."font-weight:bolder;font-size:11px; line-height:10px;".">".$c."</font>";
		CreateDirectory(1,$dir);
		echo "</li>";
	}
function fprintSubDir($dir)
{
	$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
	$ADV_sql = @mysqli_query($_SESSION['CONN'],"select * from tbl_advisor where advisor_id='$dir' order by advisor_name");
	$rows = @mysqli_fetch_array($ADV_sql);
				
				
					$c = $rows['advisor_name']." /<font color=\"GREEN\"> ".$rows['advisor_code']." </font>/ ".$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$rows['advisor_level_id']);
					
					
	 if($_GET['tree_type'])
	 {
		?>
<ul id="<?php echo $_GET['tree_type']; ?>" class="treeview-<?php echo $_GET['tree_type']; ?>" >
<li style="color:#006697;background-color:#FFFFFF;"><font style="font-weight:bolder;font-size:11px; line-height:10px;"><?php echo $c; ?></font>
  <?php }	
	else
	{
	echo "<ul id=\"gray\" class=\"treeview-gray\" background-color:#FFFFFF;><li style="."color:#006697;background-color:#FFFFFF;"."><font style="."font-weight:bolder;font-size:11px; line-height:10px;".">".$c."</font>";
	}
		CreateDirectory(1,$dir);
		echo "</li></ul>";
	}
	
	if($_GET['advisor_sponsor'])
	{
	  fprintSubDir($_GET['advisor_sponsor']);
	}
	else
	{
	  fprintSubDir($_SESSION['advisor_id']);
	}
	
	//CreateDirectory(1,'1');
?>
  </div>
  

</style>
</body>
</html>
