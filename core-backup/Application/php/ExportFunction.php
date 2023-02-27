<?php
function ExportPrintLink($find=true)
 {
	$path="../Export/".basename($_SERVER['PHP_SELF']);
	
	 $exist=file_exists($path);
	 
	 if($exist) 
	 { 
	  $path.="?".$_SERVER['QUERY_STRING'];
	  ?><a class="Export" <?php Modal($path)?> title="Export In Excel">&nbsp;</a>
	 <?php }?>
           <a class="Print" onclick="window.print();" title="Print Document"></a>
<?php } ?>



