<style>
	ul.pagination li.details{
	   color:#006C6C;
	}
	
	ul.pagination li a
	{
		color:#FFFFFF;
		border-radius:3px;	
		-moz-border-radius:3px;
		-webkit-border-radius:3px;
	}
	
	ul.pagination li a
	{
		color:#474747;
		border:solid 1px #62AAC2;
		padding:2px 6px 2px 6px;
		background:#E6E6E6;
		background:-moz-linear-gradient(top,#FFFFFF 1px,#F3F3F3 1px,#E6E6E6);
		background:-webkit-gradient(linear,0 0,0 100%,color-stop(0.02,#FFFFFF),color-stop(0.02,#F3F3F3),color-stop(1,#E6E6E6));text-decoration:none;
	}	
	
	ul.pagination li a:hover,
	ul.pagination li a.current
	{
		background:gray;
		background:url(images/th-blue.png)
	}
	.paginate input[type=button] { color:#474747;
		border:solid 1px #62AAC2;
		padding:0px 6px 2px 6px;
		background:gray;
		background:url(images/th-blue.png);
		 height:25px; margin-top:0px; line-height:12px; font-size:10px; margin-left:0px; 
	}
	.paginate input[type=button]:hover
	{
			background:url(images/deletebg.PNG);  border:1px solid #C98582;
	}
	.paginate input[type=text]
	{
			border:solid 1px #62AAC2;
	}
	.paginate input[type=text]:focus { border:1px solid green;font-weight:BOLDER; color:#060;}
	ul.pagination li a:active, .paginate input[type=button]:active { background:url(images/th-green.png); border:1px solid #62C267}
	
	
	
	ul.pagination{
		margin: auto;
		padding:0px;
		height:100%;
		overflow:hidden;
		font:11px 'Tahoma';
		color:#006A6A;
		list-style-type:none;	 
		
		 
	}   
	
	ul.pagination li.details{
		
		padding:5px 2px 5px 2px;
		color:black;
		vertical-align:middle;
		font-size:12px;
	}
	
	ul.pagination li.dot{padding: 3px 0;}
	
	ul.pagination li{
		float:left;
		margin:0px;
		padding:0px;
		color:black;
		margin-left:5px;
	}
	
	ul.pagination li:first-child{
		margin-left:0px;
	}
	
	ul.pagination li a{
		color:black;
		background:#CAE1EA;
		vertical-align:middle;
		display:block;
		text-decoration:none;
		padding:2px 5px 2px 5px;
	}
	
	ul.pagination li a img{
		border:none;
	}
	 .paginate { margin-top:0px; margin-left:1%; margin-right:1%;   margin-bottom:-15px; text-align:right;}
	 .paginate input[type=text] { width:40px; height:25px; font-size:11px; }
		
</style>
<?php 
 function url($page_name="")
			   {
				   $url=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
				   if(isset($_GET['page']))
				   {
					  $page=$_GET['page'];
					  $array= explode('&page='.$page,$page_name."?".$_SERVER['QUERY_STRING']);
					 
					  $url=$array[0];
				   }
				   else
				   {
					    $url= $page_name."?".$_SERVER['QUERY_STRING'];
				   }
				   return  $url."&";
			   }
			   
    	 function pagination($query, $per_page = 10,$page = 1, $url = '?')
	     {  
		 $LIMIT_URL='';if($_GET['limit']) { $LIMIT_URL= '&limit='.$_GET['limit'].'';}
	   	$row = @mysqli_num_rows(mysqli_query($_SESSION['CONN'],$query));
		$all=$row;
    	$total = $row;
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul  class='pagination'>";
                    $pagination .= "<li class='details'><font color=darkgreen><b>Total $all Record Found.</b></font> Showing Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter$LIMIT_URL'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter$LIMIT_URL'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1$LIMIT_URL'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage$LIMIT_URL'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1$LIMIT_URL'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2$LIMIT_URL'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter$LIMIT_URL'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1$LIMIT_URL'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage$LIMIT_URL'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1$LIMIT_URL'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2$LIMIT_URL'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter$LIMIT_URL'>$counter</a></li>";					
    				}
    			}
    		}
    	
			
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}page=$next$LIMIT_URL'>Next</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage$LIMIT_URL'>Last</a></li>";				
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";              
            }
			
    		$pagination.= "<li><a href='{$url}page=1&limit=$all' style='background:url(images/th-green.png);border:1px solid #62C267;'>Show&nbsp;All</a></li>";
					
    	}
		
		$pagination.= "<li class='paginate' style='list-style:NONE'>				
                <label style='COLOR:MAROON; FONT-WEIGHT:BOLDER;'>Per&nbsp;Page
				<input type='text' name='limit' id='limit' value='$per_page' onchange=\"window.location='{$url}page=1&limit='+limit.value;\"/>
				<input type='button' id='paginateButton' name='paginateButton' style='color:black; text-decoration:none' value='Show' onclick=\"window.location='{$url}page=1&limit='+limit.value;\"  /></label>
                </li>";
				
				$pagination.= "</ul>";?>
      
<div style="background:none; "><?php echo  $pagination;?></div>

<?php    if($per_page>=$all) {  echo "<ul  class='pagination' style='margin-top:-25px; '><li><a href='{$url}page=1' class='current'>Show&nbsp;Pagination</a></li></ul>"; }

 } 
	
?>
