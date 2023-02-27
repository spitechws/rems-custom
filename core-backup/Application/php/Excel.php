<?php
@session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../Menu/Define.php");

@date_default_timezone_set('Asia/Calcutta');
function ExportExcel($FileName="")
{	
	if($FileName=="") 
	{ 
		  $page=@basename($_SERVER['PHP_SELF']);
		  $page=@str_replace(".php","",$page);
		  
		  if(advisor_title!="Advisor" && advisor_title!="")
		  {
			  $title=advisor_title; 
			  $page=@str_replace("Advisor",$title,$page);
		  }
		 
		  $FileName=$page."(".date('d_m_y)_(h_i_s_A').")";
	}
	
	$FileName=@str_replace(" ","_",$FileName);
	
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=$FileName.xls");
	header("Pragma: no-cache");
	header("Expires: 0");	
	
	
	?>
    <style>

#ExportTable {
	font-family:Arial !important;
	font-size:10px;
	margin-top:0px;
}
#ExportTable td {
	font-size:10px !important;
	background:white;
	vertical-align:middle !important;
}
#ExportTable th {
	font-size:10px !important;
	
	background:#E4E4E4;
	font-weight:bolder;
	 text-transform:uppercase !important;
}
#ExportTable tr td td, #ExportTable tr td th {
	font-size:9px !important;
}


#TH 
{
 background:#E4E4E4; text-transform:uppercase !important;;
}



H1 {
	font-size:20px !important;	
	color:#000 !important;

	text-transform:uppercase !important;
	background:#C4FFFF !important;
	line-height:40px;
	padding:10px;
}
H1 span { color:#009900; }
h2 { font-size:14px; }
#ExportHide, #ExportHide * { display:none !important; visibility:hidden !important; height:0px !important; width:0px !important; }

</style>
    <?php }
?>


