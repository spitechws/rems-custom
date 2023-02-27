<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
?>
<center>
<h1>Project  : <span>Master List</span></h1>
    <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" >
      <tr id="TH">
        <th width="2%">#</th>
        <th width="16%">PROJECT NAME</th>
        <th width="15%">ADDRESS</th>
        <th width="9%">MAUZA</th>
        <th width="8%">P.H. NO</th>
        <th width="21%">PROPERTY&nbsp;BOOKING&nbsp;STATUS</th>
      </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 10;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$PROJECTS_QUERY="select * from tbl_project where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET['project_name']!="") 		{ $PROJECTS_QUERY.=" and project_name like '%".$_GET['project_name']."%' "; }			
		}
	    
		$PAGINATION_QUERY=$PROJECTS_QUERY."  order by project_name ";
		$PROJECTS_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PROJECTS_QUERY=@mysqli_query($_SESSION['CONN'],$PROJECTS_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PROJECTS_QUERY);

while($PROJECTS_ROWS=@mysqli_fetch_assoc($PROJECTS_QUERY)) {
?>
  <tr>
    <td height="79"><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"  style="width:200PX;"><?php echo $PROJECTS_ROWS['project_name']; ?></div></td>
    <td ><?php echo $PROJECTS_ROWS['project_address']; ?></td>
    <td><div align="center"><?php echo $PROJECTS_ROWS['project_mouza']; ?></div></td>
    <td><div align="center"><?php echo $PROJECTS_ROWS['project_ph_no']; ?></div></td>
    <td style="margin:0PX; padding:0PX;" title="GO TO PROPERTY STATUS : MANAGE PROPERTY">
      
        <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="margin:5PX; width:200PX;;"> 
          <tr id="TH">
            <th width="10%">TYPE</th>
            <th width="29%" style="background:GREEN">AVAILABLE</th>
            <th width="20%" style="background:RED">BOOKED</th>
            <th width="20%" style="background:ORANGE;color:BLACK">TEMP</th>
            <th width="21%" style="background:LIGHTGREEN; color:BLACK">HOLD</th>
            <th width="21%">TOTAL</th>
          </tr> 
          
          <?php 	$TOTAL_AVAILABLE=0;
	$TOTAL_BOOKED=0;
	$TOTAL_TEMP_BOOKED=0;
	$TOTAL_HOLD=0;
	$TOTAL_ROW_COUNT_TOTAL=0;
	
	$TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type where property_type_id in (select project_property_type_id from tbl_project_details where project_id='".$PROJECTS_ROWS['project_id']."')");
	 while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
	 {
		 //==============(AVAILABLE)========================
		 $AVAILABLE=@mysqli_query($_SESSION['CONN'],"SELECT COUNT(property_id) AS TOTAL_AVAILABLE FROM tbl_property where property_status='Available' and property_project_id='".$PROJECTS_ROWS['project_id']."' and property_type_id='".$TYPE_ROWS['property_type_id']."' ");
		 $AVAILABLE=@mysqli_fetch_assoc($AVAILABLE);
		 $AVAILABLE=$AVAILABLE['TOTAL_AVAILABLE'];$TOTAL_AVAILABLE+=$AVAILABLE;
		  //==============(TEMP BOOKED)========================
		 $TEMP_BOOKED=@mysqli_query($_SESSION['CONN'],"SELECT COUNT(property_id) AS TOTAL_TEMP_BOOKED FROM tbl_property where property_status='TempBooked' and property_project_id='".$PROJECTS_ROWS['project_id']."'  and property_type_id='".$TYPE_ROWS['property_type_id']."'");
		 $TEMP_BOOKED=@mysqli_fetch_assoc($TEMP_BOOKED);
		 $TEMP_BOOKED=$TEMP_BOOKED['TOTAL_TEMP_BOOKED'];$TOTAL_TEMP_BOOKED+=$TEMP_BOOKED;
		  //==============(BOOKED)========================
		 $BOOKED=@mysqli_query($_SESSION['CONN'],"SELECT COUNT(property_id) AS TOTAL_BOOKED FROM tbl_property where property_status='Booked' and property_project_id='".$PROJECTS_ROWS['project_id']."'  and property_type_id='".$TYPE_ROWS['property_type_id']."'");
		 $BOOKED=@mysqli_fetch_assoc($BOOKED);
		 $BOOKED=$BOOKED['TOTAL_BOOKED'];$TOTAL_BOOKED+=$BOOKED;
		  //==============(HOLD)========================
		 $HOLD=@mysqli_query($_SESSION['CONN'],"SELECT COUNT(property_id) AS TOTAL_HOLD FROM tbl_property where property_status='Hold' and property_project_id='".$PROJECTS_ROWS['project_id']."'  and property_type_id='".$TYPE_ROWS['property_type_id']."'");
		 $HOLD=@mysqli_fetch_assoc($HOLD);
		 $HOLD=$HOLD['TOTAL_HOLD']; $TOTAL_HOLD+=$HOLD;
		 //=================(every row total)=============================
		 $TOTAL_ROW_COUNT=$AVAILABLE+$BOOKED+$TEMP_BOOKED+$HOLD;
		 $TOTAL_ROW_COUNT_TOTAL+=$TOTAL_ROW_COUNT;
		 ?>
          <tr>
            <td><?php echo $TYPE_ROWS['property_type'];?></td>
            <td style="background:GREEN; color:WHITE;"><div align="center"><?php echo $AVAILABLE?></div></td>
            <td style="background:RED; color:WHITE;"><div align="center"><?php echo $BOOKED?></div></td>
            <td style="background:ORANGE"><div align="center"><?php echo $TEMP_BOOKED?></div></td>
            <td style="background:LIGHTGREEN"><div align="center"><?php echo $HOLD?></div></td>
            <td><div align="center"><?php echo $TOTAL_ROW_COUNT?></div></td>
          </tr>
          <?php } ?>
          <tr>
            <tH>TOTAL</tH>
            <tH style="background:GREEN"><div align="center"><?php echo $TOTAL_AVAILABLE?></div></tH>
            <tH style="background:RED"><div align="center"><?php echo $TOTAL_BOOKED?></div></tH>
            <tH style="background:ORANGE; color:BLACK"><div align="center"><?php echo $TOTAL_TEMP_BOOKED?></div></tH>
            <tH style="background:LIGHTGREEN; color:BLACK;"><div align="center"><?php echo $TOTAL_HOLD?></div></tH>
            <tH><div align="center"><?php echo $TOTAL_ROW_COUNT_TOTAL?></div></tH>
          </tr>
        </table>
    </td>
    </tr>
  <?php } ?>
</table>
</center>
  