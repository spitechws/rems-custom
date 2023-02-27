<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Settings");
NoUser();
NoAdmin();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
if(isset($_GET[md5('delete_file')])) 
{ 
 @unlink('../SpitechBackup/AutoBackup/'.$_GET[md5('delete_file')]);
 $DBOBJ->UserAction("AUTO BACKUP FILE DELETED","FILE NAME : ".$_GET[md5('delete_file')]);	
 header("Location:SpitechManageDataBaseAutoBackUpList.php?Message=Backup File : ". $_GET[md5('delete_file')]." Have Been Deleted.");
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/BackUp.png" width="31" height="32" />
Settings  : <span> Manage Database : </span><font>Auto Backup</font></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>   
    <?php  ErrorMessage();?>
    <table width="734" border="0" cellpadding="0" cellspacing="1" id="Data-Table">
      <tr>
        <th width="39">NO</th>
        <th colspan="2">Date Created</th>
        <th width="651">file name</th>
        <th width="218">size</th>
        <th colspan="2">Action</th>
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
     
        <td width="104">
        
            <a href="<?php echo $FILE_LINK;  ?>" title="Download Backup File : ".<?php echo $files1[$i];  ?>>
               <img src="../SpitechImages/Download.png" alt="Download" style="display:inline;" />
            </a>
       
        </td>
        <td width="20">
             <a href="SpitechManageDataBaseAutoBackUpList.php?<?php echo md5('delete_file')."=".$FILE; ?>" id="Delete" <?php Confirm("Are You Sure ? Delete This Backup File ?"); ?>>
                 &nbsp;
             </a>
        </td>
      </tr>
      <?php } } ?>
    </table>
    
    </center>
    </td>
  </tr>
</table>
</center>

<?php include("../Menu/Footer.php"); ?>
