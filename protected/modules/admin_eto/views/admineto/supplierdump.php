
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
		<SCRIPT LANGUAGE="JavaScript">
		   function ajaxFunction()
        	{
                var xmlHttp;
                try
                {	// Firefox, Opera 8.0+, Safari
                        xmlHttp=new XMLHttpRequest();
                }
                catch (e){// Internet Explorer
                        try
                        {
                                xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                        }
                        catch (e)
                        {
                                try
                                {
                                        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                                }
                                catch (e)
                                {
                                        alert("Your browser does not support AJAX!");
                                        return false;
                                }
                        }
                }
                return xmlHttp;
        }
		function exportExcel(start_date,end_date,vendor,source,employeeID,stime,etime,filename,tlid)
		{
		/*var xmlHttp=ajaxFunction();
                if(xmlHttp)
                {
                        xmlHttp.onreadystatechange=function()
                        {
                                if(xmlHttp.readyState==4)
                                {
                                        var temp=xmlHttp.responseText;
					window.location.href=filename;
                                }	
                        }
                        var str='/index.php?r=admin_eto/AdminEto/leapdashboard&action=export&start_date='+start_date+'&end_date='+end_date+'&vendor='+vendor+'&source='+source+'&employeeID='+employeeID+'&start_time='+stime+'&end_time='+etime+'&tlid='+tlid;
                        xmlHttp.open("GET",str,true);
                        xmlHttp.send(null);
                        return false;
                }*/
                
		}
		</SCRIPT>
		<style>
		.pagina:link { text-decoration: none;padding: 6px 9px; } a:visited { text-decoration: none; } a:hover { text-decoration: underline; } a:active {   text-decoration: underline; }</style>
		<?php 
                $feedbackhtml=$result['returndata'];
                $tlid =$result['tlid'];
		$SERVER_NAME = $_SERVER['SERVER_NAME'];
		$htmlArr = $result['returndata'];		
		$start_date = $result['start_date'];		
		$end_date = $result['end_date'];		
		$vendor = $result['vendor'];		
		$source = $result['source'];		
		$employeeID = $result['employeeID'];		
		$start_time = $result['start_time'];		
		$end_time = $result['end_time'];		
		$start = $result['start'];		
		$end = $result['end'];
		$in_flag = $result['in_flag'];
		$totalRecords = $result['totalRecords'];
		$nextStart = $end+1; 
		if($totalRecords <= 10000){
			$nextEnd = $totalRecords;		
		} 
		else{
			$nextEnd = $end+5000;		
		}
		$prevStart = $start-5000; $prevEnd = $start-1;
		$colwidth=8;
		$date = date('d-m-Y');
		$fileName = "/gl_global_upload/approval_dump.xls";
                $cp=1;
                if(isset($_REQUEST['start']) && $_REQUEST['start'] > 5000){
                    $cp = ($_REQUEST['start']-1)/5000;
                    $cp = $cp+1;
                }              
               
		?>
		<table style="background-color: #FFFFFF;width: 1300px;">
		<tr>
                	<td align="right" height="30" style="font-family:arial;font-size:14px;font-weight:bold;" colspan="10">               	
			 
			 <a href="/index.php?r=admin_eto/AdminEto/leapdashboard&action=exportSupplier&start_date=<?php echo $start_date; ?>&
			 end_date=<?php echo $end_date; ?>&vendor=<?php echo $vendor; ?>&source=<?php echo $source; ?>
			 &tlid=<?php echo $tlid; ?>&start_time=<?php echo $start_time; ?>&end_time=<?php echo $end_time; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>&mid=3443" target="_blank">Export To Excel</a>
			<?php 
			$serverName = $_SERVER['SERVER_NAME'];
			
			if($totalRecords > 5000){
						echo '<td align="center" width= "50%">'; 
						if($start > 1){
							echo '<a class="pagina" href="http://'.$serverName.'/index.php?r=admin_eto/AdminEto/leapdashboard&action=feedbackdetail&total_records='.$totalRecords.'&start_date='.$start_date.'&end_date='.$end_date.'&vendor='.$vendor.'&source=A&start_time='.$start_time.'&end_time='.$end_time.'&tlid=0&in_flag='.$in_flag.'&start=1&end=5000&mid=3443">  First </a>';
                                                       echo '<a class="pagina" href="http://'.$serverName.'/index.php?r=admin_eto/AdminEto/leapdashboard&action=feedbackdetail&total_records='.$totalRecords.'&start_date='.$start_date.'&end_date='.$end_date.'&vendor='.$vendor.'&source=A&start_time='.$start_time.'&end_time='.$end_time.'&tlid=0&in_flag='.$in_flag.'&start='.$prevStart.'&end='.$prevEnd.'&mid=3443">  Previous </a>';		
                                                }
                                                 echo '<span style="font-weight:bold;border: 1px solid #b6b6b6;color: #474747;padding: 6px 9px">'.$cp.'</span>';
						if($end < $totalRecords){
							echo '<a class="pagina" href="http://'.$serverName.'/index.php?r=admin_eto/AdminEto/leapdashboard&action=feedbackdetail&total_records='.$totalRecords.'&start_date='.$start_date.'&end_date='.$end_date.'&vendor='.$vendor.'&source=A&start_time='.$start_time.'&end_time='.$end_time.'&tlid=0&in_flag='.$in_flag.'&start='.$nextStart.'&end='.$nextEnd.'"&mid=3443> Next </a>';		
						}
						if($end < $totalRecords){
						
						$remainder = ($totalRecords % 5000);
						$lastStart = ($totalRecords - $remainder) + 1;
                                                
                                                $total_pg=ceil($totalRecords/5000);
							echo '<a class="pagina" href="http://'.$serverName.'/index.php?r=admin_eto/AdminEto/leapdashboard&action=feedbackdetail&total_records='.$totalRecords.'&start_date='.$start_date.'&end_date='.$end_date.'&vendor='.$vendor.'&source=A&start_time='.$start_time.'&end_time='.$end_time.'&tlid=0&in_flag='.$in_flag.'&start='.$lastStart.'&end='.$totalRecords.'&mid=3443">Last [Total-'.$total_pg.'] </a>';		
						}
						echo '</td>';
					}
			?>
		</tr>
		</table>  
		<?php echo $feedbackhtml; ?>
		</table>