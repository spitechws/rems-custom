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
if($_POST['action']=='BACKUP_DATABASE')
{
// call the backup_db function.
 $link_new=BackupDB($db_host,$db_user,$db_pass,$db_name);

  header("location:BackupDownload.php?path=$link_new");
  
}
//-------------( OPTIMIZE DATABASE )----------------------------------------
elseif($_REQUEST['action']=="OPTIMIZE_DATABASE")
		{
		   $count=count($_POST['table_name']);
		   $table_array=$_POST['table_name'];		
					  
		   for($i=0;$i<$count;$i++)
		   {
		     $table_name=$table_array[$i];
		  	 $sql_1="OPTIMIZE TABLE $table_name "; 
			 @mysqli_query($_SESSION['CONN'],$sql_1) or die(@mysqli_error($_SESSION['CONN']));   
			}
			
			//-----------------------------( ENTRY IN USER ACTION TABLE )-----------------------------------------
         $DBOBJ->UserAction("DATABASE OPTIMIZED",""); 
 
			header("location:../App/SpitechManageDataBase.php?Message=Tables+Optimized+Successfully.");
		}
//-------------( REPAIR DATABASE )----------------------------------------		
elseif($_REQUEST['action']=="REPAIR_DATABASE")
		{
				
		    $count=count($_POST['table_name']);
			$table_array=$_POST['table_name'];
			
					  
		   for($i=0;$i<$count;$i++)
		   {
		     $table_name=$table_array[$i];
		  	 $sql_1="repair  table $table_name "; 
			 @mysqli_query($_SESSION['CONN'],$sql_1) or die(@mysqli_error($_SESSION['CONN']));   
			}
			
				//-----------------------------( ENTRY IN USER ACTION TABLE )-----------------------------------------
            $DBOBJ->UserAction("DATABASE REPAIRED",""); 
			header("location:../App/SpitechManageDataBase.php?Message=Tables+Repaired+Successfully.");
		}		


function BackupDB($db_host,$db_user,$db_pass,$db_name,$tables = '*',$drop = true)
{
     set_time_limit(1800); 
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
		$location='SPITECH_DB_'.date('d_m_Y__H_i_s_').'.sql';
        $handle = fopen($location,'w+');
        fwrite($handle,$return);
		
		
        fclose($handle);
    }
	return($location);
	
			
} // end of the function

?>