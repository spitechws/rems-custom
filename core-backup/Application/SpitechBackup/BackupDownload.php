<?php
if($_GET['path']!='')
{
  set_time_limit(18000); 
 $path=$_GET['path'];
header('Content-Type: application/x-download');
header('Content-disposition: attachment; filename="'.$path.'"');
header('Content-length: '.filesize($path));
header('Content-Transfer-Encoding: binary');

if ($file = fopen($path, 'rb')) 
{
    while(!feof($file) and (connection_status()==0)) 
	{
        print(fread($file, filesize($path)));
        flush();
    }
    fclose($file);
}

//------( DELETE TEMP SQL FILE FROM SERVER PATH )-------
 unlink($path);

}

?>