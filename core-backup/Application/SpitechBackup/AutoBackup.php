<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$db_host = HOST ; // Here enter the databse host name.
$db_user = USER ; // Here enter the username to access your database.
$db_pass = PASSWORD ; // Here enter the password to access your database.
$db_name = DATABASE ; // Here enter the database name, of which you want to take the backup.

//-------------( BACKUP DATABASE )----------------------------------------
$file=date('d-m-Y').'.sql';

if(!file_exists($file)) 
{ 
    //--------------( Delete Old files )------------------------------------------------------
		deleteOldFiles();
	//--------------( Create New Backup File on AutoBackup Folder )------------------------------------------------------   
	    BackUpDB($db_host,$db_user,$db_pass,$db_name);
		
		$DBOBJ->UserAction("AUTO DB BACKUP TAKEN","FILE NAME : ".date('d-m-Y').'.sql');
}



function deleteOldFiles($keep_files=10) {
	$keep_files=$keep_files-1;
	$folder='../SpiTechBackup/AutoBackup/';
	$aFile = scandir($folder, SCANDIR_SORT_DESCENDING);
	$i=1;
	foreach($aFile as $value) {	
		if($value!="." && $value!=".." && $value!="index.php") {			
			if($i>$keep_files) {
				@unlink($folder.$value);
				//echo "<font color=red>".$value."</font> Deleted<br>";
			} else {
				//echo  "<font color=green>".$value."</font> Saved<br>";
			}
			$i++;
		}
	}
}


function BackUpDB($db_host,$db_user,$db_pass,$db_name,$tables = '*',$drop = true)
{
     set_time_limit(0); 
	// link to the database by above given authentication.
    $link = @mysqli_connect($db_host,$db_user,$db_pass);
   
    if(@mysqli_select_db($db_name,$link))
    {
        //get all of the tables
        if($tables == '*')
        {
            // store all the table name in $tables array.
            $tables = array();
            $result = @mysqli_query($_SESSION['CONN'],'SHOW TABLES');

            while($row = @mysqli_fetch_row($result))
            {
                $tables[] = $row[0];
            }

        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        //cycle through
        foreach($tables as $table)
        {
            $result = @mysqli_query($_SESSION['CONN'],'SELECT * FROM '.$table);
            $fields_num = @mysqli_num_fields($result);

             //---------------( TITLE OF TABLE )---------------------------------
            $return.= '-- Table structure for table : '.$table.';';
            $res = @mysqli_fetch_row(@mysqli_query($_SESSION['CONN'],'SHOW CREATE TABLE '.$table));
           
            $return.= "\n\n".$res[1].";\n\n";

            for ($index = 0; $index < $fields_num; $index++)

            {

                while($row = @mysqli_fetch_row($result))
                {
                    $return.= 'INSERT INTO '.$table.' VALUES(';

                    for($j=0; $j<$fields_num; $j++)
                    {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                        if ($j<($fields_num-1)) { $return.= ','; }
                    } // end of innermost for loop

                    $return.= ");\n";
                } // end of while loop

            } // end of for loop.

            $return.="\n\n\n";
        } // end of outer for loop.

        //save the file in the desitred location.
		$location='AutoBackup/'.date('d-m-Y').'.sql';
        $handle = fopen($location,'w+');
        fwrite($handle,$return);
		
		
        fclose($handle);
    }
	return($location);
	
			
} // end of the function

?>