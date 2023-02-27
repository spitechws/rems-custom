<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<center>
<h1>Settings  : <span> Manage Database : </span><font>Auto Backup</font></h1>
    <table width="734" border="1" cellpadding="0" cellspacing="0" id="ExportTable">
      <tr id="TH">
        <th width="39">NO</th>
        <th colspan="2">DATE CREATED</th>
        <th width="651">FILE NAME</th>
        <th width="218">SIZE</th>
      </tr>
      <?php  
			$dir='../SpitechBackup/AutoBackup/';
			$files1 = scandir($dir,SCANDIR_SORT_DESCENDING);
			$k=1;
			for($i=0;$i<count($files1);$i++) 
			{ 
			  $FILE=$files1[$i];
			  $FILE_LINK=$dir.$FILE;
			  
			  if($FILE!='.' && $FILE!='..' && $FILE!='index.php') 
			  {    	 
		    ?>
      <tr>
        <td height="29"><div align="center"><?php echo $k++ ;?>.</div></td>
        <td width="119" style="text-align:center;"><?php echo date('d-m-Y',filemtime($FILE_LINK)); ?></td>
        <td width="94" style="text-align:center"><?php @date_default_timezone_set('Asia/Calcutta'); echo date("h:i:s A", @filemtime($FILE_LINK)); ?></td>
        <td style="color:#0079F2; font-weight:bolder; text-transform:none;"><?php echo $files1[$i];?></td>
        <td><?php $size=@filesize($FILE_LINK)/1048576; echo @number_format($size,3)."MB"; ?></td>
      </tr>
      <?php } } ?>
    </table>
   </center>
    