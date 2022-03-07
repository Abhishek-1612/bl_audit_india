
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
		$start = $result['start'];		
		$end = $result['end'];
		$totalRecords = $result['totalRecords'];
		$nextStart = $end+1; 
                $tableflag=$_REQUEST['tableflag'];
                $rid=$_REQUEST['rid'];
		if($totalRecords <= 1000){
			$nextEnd = $totalRecords;		
		} 
		else{
			$nextEnd = $end+500;		
		}
		$prevStart = $start-500; $prevEnd = $start-1;
		$colwidth=8;
		$date = date('d-m-Y');
		
                $cp=1;
                if(isset($_REQUEST['start']) && $_REQUEST['start'] > 500){
                    $cp = ($_REQUEST['start']-1)/500;
                    $cp = $cp+1;
                }              
               
		?>
		<table style="background-color: #FFFFFF;width: 1300px;">
		<tr>
                	<td align="right" height="30" style="font-family:arial;font-size:14px;font-weight:bold;" colspan="10">               	
			 
			 <a href="/index.php?r=admin_eto/BLDashboard/exportisqfeedback&action=exportisqfeedback&start_date=<?php echo $start_date; ?>&vendor=<?php echo $vendor; ?>&source=<?php echo $source; ?>
			 &employeeID=<?php echo $employeeID; ?>&tlid=<?php echo $tlid; ?>&in_flag=<?php echo $in_flag; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>&tableflag=<?php echo $tableflag; ?>&rid=<?php echo $rid; ?>&mid=3443" target="_blank">Export To Excel</a>
			<?php 
			$serverName = $_SERVER['SERVER_NAME'];
			
			if($totalRecords > 500){
						echo '<td align="center" width= "50%">'; 
						if($start > 1){
							echo '<a class="pagina" href="http://'.$serverName.'/index.php?r=admin_eto/BLDashboard/isqfeedbackdetail&action=isqfeedbackdetail&total_records='.$totalRecords.'&start_date='.$start_date.'&end_date='.$end_date.'&vendor='.$vendor.'&tlid=0&start=1&end=500&tableflag='.$tableflag.'&rid='.$rid.'&mid=3443">  First </a>';
                                                       echo '<a class="pagina" href="http://'.$serverName.'/index.php?r=admin_eto/BLDashboard/isqfeedbackdetail&action=isqfeedbackdetail&total_records='.$totalRecords.'&start_date='.$start_date.'&end_date='.$end_date.'&vendor='.$vendor.'&tlid=0&start='.$prevStart.'&end='.$prevEnd.'&tableflag='.$tableflag.'&rid='.$rid.'&mid=3443">  Previous </a>';		
                                                }
                                                 echo '<span style="font-weight:bold;border: 1px solid #b6b6b6;color: #474747;padding: 6px 9px">'.$cp.'</span>';
						if($end < $totalRecords){
							echo '<a class="pagina" href="http://'.$serverName.'/index.php?r=admin_eto/BLDashboard/isqfeedbackdetail&action=isqfeedbackdetail&total_records='.$totalRecords.'&start_date='.$start_date.'&end_date='.$end_date.'&vendor='.$vendor.'&tlid=0&start='.$nextStart.'&end='.$nextEnd.'&tableflag='.$tableflag.'&rid='.$rid.'&mid=3443> Next </a>';		
						}
						if($end < $totalRecords){
						
						$remainder = ($totalRecords % 500);
						$lastStart = ($totalRecords - $remainder) + 1;
                                                
                                                $total_pg=ceil($totalRecords/500);
							echo '<a class="pagina" href="http://'.$serverName.'/index.php?r=admin_eto/BLDashboard/isqfeedbackdetail&action=isqfeedbackdetail&total_records='.$totalRecords.'&start_date='.$start_date.'&end_date='.$end_date.'&vendor='.$vendor.'&tlid=0&start='.$lastStart.'&end='.$totalRecords.'&tableflag='.$tableflag.'&rid='.$rid.'&mid=3443">Last [Total-'.$total_pg.'] </a>';		
						}
						echo '</td>';
					}
			?>
		</tr>
		</table>  
		<?php echo $feedbackhtml; ?>
		</table>