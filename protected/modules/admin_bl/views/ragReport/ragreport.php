<?php 
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
error_reporting(1);
?>

<head>
<title>RAG Report</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; } 
.cancel 
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1; 
 
border-size:2px;border-style:solid;border-color:#0195d3;
} 
</style>

<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">		
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script>
</head>

<form name="ragReport" id="ragReport" method="post" action="" style="margin-top:0;margin-bottom:0;" onsubmit="">
<input name="frame_height" id="frame_height" value="" type="hidden">
		    <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
			  <TR>
				<td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>RAG Report</b></font>			 </td>	
			  </TR>
			  <tr>

				<td WIDTH="15%">&nbsp;Date:</td>
				<td WIDTH="45%">
					&nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.ragReport.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.ragReport.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
			  
					<?php if(!isset($_REQUEST['trend']) || $_REQUEST['trend']=='datewise') { ?>
			  
					<div id="end_date1" style="margin-left:200px; margin-top:-20px;display:block;">
					<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.ragReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.ragReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div>
					<?php } 
					else
					{
					?>
					<div id="end_date1" style="margin-left:200px; margin-top:-20px;display:none;">
					<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.ragReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.ragReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div> <?php } ?>
				</td>
				
		<td >&nbsp;Data: </td>
		<td>&nbsp;<input type="radio" name="data" id="data"  value="generation"
			<?php
			if((isset($_REQUEST['data']) && $_REQUEST['data'] =='generation') || !isset($_REQUEST['data']))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Generation
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="data" id="data"  value="approval"
			<?php
			if((isset($_REQUEST['data']) && $_REQUEST['data'] =='approval'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Approval
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="data" id="data"  value="deletion"
			<?php
			if((isset($_REQUEST['data']) && $_REQUEST['data'] =='deletion'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Deletion
			
			
			&nbsp;<input type="radio" name="data" id="data" value="Timeliness"
			<?php
			if((isset($_REQUEST['data']) && $_REQUEST['data'] =='Timeliness'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Timeliness
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="data" id="data" value="81-Combination"
			<?php
			if((isset($_REQUEST['data']) && $_REQUEST['data'] =='81-Combination'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;81-Combination
			
			</td>
		
		
	
	</tr>
	
	<tr><td >&nbsp;Pool Wise: </td><td>
                    <input type="radio" name="pool" id="pool" value="All"
				<?php
					if((isset($_REQUEST['pool']) && $_REQUEST['pool'] =='All') || !isset($_REQUEST['pool']))
					{
					 echo ' checked';
					}
					
				?>
			>&nbsp;All&nbsp;&nbsp;&nbsp;
			<input type="radio" name="pool" id="pool" value="DNC"
				<?php
					if((isset($_REQUEST['pool']) && $_REQUEST['pool'] =='DNC'))
					{
					 echo ' checked';
					}
					
				?>
			>&nbsp;DNC&nbsp;&nbsp;&nbsp;
			
			<input type="radio" name="pool" id="pool" value="MUSTCALL"
				<?php
					if((isset($_REQUEST['pool']) && $_REQUEST['pool'] =='MUSTCALL'))
					{
					 echo ' checked';
					}
					
				?>
			>&nbsp;MUST CALL&nbsp;&nbsp;&nbsp;
			
			<input type="radio" name="pool" id="pool" value="INTENT"
				<?php
					if((isset($_REQUEST['pool']) && $_REQUEST['pool'] =='INTENT'))
					{
					 echo ' checked';
					}
					
				?>
			>&nbsp;INTENT
		</td>
		
	<td colspan="2">&nbsp; </td>
	</tr>
	<tr>
       <TD colspan="4" align="center">                      
			<input type="submit" name="submit_dump" id="submit_dump" value="Generate Report"> 
			<input type="hidden" name="action" value="generate">
		</TD>
	</TR>
</TABLE>
                        
  <?php
  
  if(isset($_REQUEST['action']))
  {
  if($interval <=31)
  {   
if(!empty($recData)){    
if((isset($_REQUEST['data']) && $_REQUEST['data'] =='Timeliness'))
			{
			   echo '<br><table border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                                   echo '<tr style="background: #dff8ff;color: white;">';
                                   echo '<td align="left" style="padding:4px;" width="150px"></td>';                
                                   echo '<td colspan="7" align="center" style="padding:4px;"><b>Genenation</b></td>';
                                  
                                   echo '<td colspan="7"  align="center" style="padding:4px;"><b>Deletion+Approval</b></td>';                                
                                   
                                    echo '<td colspan="7"  align="center" style="padding:4px;"><b>Timeliness</b></td>';
                                  
                                   
                                   echo '</tr>';
                                   echo '<tr style="background: #dff8ff;color: white;">';
                                   echo '<td align="left" style="padding:4px;" width="150px">Date</td>';                
                                   echo '<td align="center" style="padding:4px;"><b>Red </b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Amber </b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Green </b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Orange</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Yellow</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Blue</b></td>';
                                    
                                   echo '<td align="center" style="padding:4px;"><b>Total </b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Red</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Amber</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Green</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Orange</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Yellow</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Blue</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Total</b></td>';
                                   
                                   echo '<td align="center" style="padding:4px;"><b>Red </b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Amber </b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Green </b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Orange</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Yellow</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Blue</b></td>'; 
                                   echo '<td align="center" style="padding:4px;"><b>Total </b></td>';
                                   
                                   echo '</tr>';
                                   foreach ($recData as $row)
                                   {
                                       echo '<tr style="color: white;">';
                                            echo '<td align="left" style="padding:4px;">'.$row['p_date'].'</td>';
                                       
                                    echo '<td align="center" style="padding:4px;">'.$row['red_gen'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['amber_gen'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['green_gen'].'</td>';
                                    
                                    echo '<td align="center" style="padding:4px;">'.$row['orange_gen'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['yellow_gen'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['blue_gen'].'</td>';
                                    echo '<td align="center" style="padding:4px;"><b>'.$row['total_gen'].'</b></td>';
                                    
                                    echo '<td align="center" style="padding:4px;">'.$row['red_app'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['amber_app'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['green_app'].'</td>';
                                    
                                      echo '<td align="center" style="padding:4px;">'.$row['orange_app'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['yellow_app'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['blue_app'].'</td>';
                                    
                                    echo '<td align="center" style="padding:4px;"><b>'.$row['total_app'].'</b></td>';
                                    
                                     echo '<td align="center" style="padding:4px;">'.round(($row['red_app'] / $row['red_gen']) *100,2) .'</td>';
                                    echo '<td align="center" style="padding:4px;">'. round(($row['amber_app']/ @$row['amber_gen']) *100,2) .'</td>';
                                    echo '<td align="center" style="padding:4px;">'.round(($row['green_app']/ $row['green_gen']) *100,2) .'</td>';
                                    
                                    echo '<td align="center" style="padding:4px;">'.round(($row['orange_app'] / $row['orange_gen']) *100,2) .'</td>';
                                    echo '<td align="center" style="padding:4px;">'. round(($row['yellow_app']/ $row['yellow_gen']) *100,2) .'</td>';
                                    echo '<td align="center" style="padding:4px;">'.round(($row['blue_app']/ $row['blue_gen']) *100,2) .'</td>';
                                    
                                    echo '<td align="center" style="padding:4px;"><b>'.round(($row['total_app']/ $row['total_gen']) *100,2) .'</b></td>';
                                    
                                    echo '</tr>'; 
                                   }
                                   echo '</table>';
			}else{  
                    echo '<br><table border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                                   echo '<tr style="background: #dff8ff;color: white;">';
                                   echo '<td align="left" style="padding:4px;" width="150px">Date</td>';                
                                   echo '<td align="center" style="padding:4px;"><b>Red</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Amber</b></td>';
                                    echo '<td align="center" style="padding:4px;"><b>Green</b></td>';
                                     echo '<td align="center" style="padding:4px;"><b>Orange</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Yellow</b></td>';
                                    echo '<td align="center" style="padding:4px;"><b>Blue</b></td>';
                                   echo '<td align="center" style="padding:4px;"><b>Total</b></td>';
                                   echo '</tr>';
                                   foreach ($recData as $row)
                                   {
                                       echo '<tr style="color: white;">';
                                       if(isset($_REQUEST['data']) && $_REQUEST['data'] =='generation'){
                                            echo '<td align="left" style="padding:4px;">'.$row['eto_ofr_postdate_orig'].'</td>';
                                   }elseif(isset($_REQUEST['data']) && ($_REQUEST['data'] =='approval' || $_REQUEST['data'] =='81-Combination')){
                                            echo '<td align="left" style="padding:4px;">'.$row['eto_ofr_approv_date_orig'].'</td>';
                                       }elseif(isset($_REQUEST['data']) && $_REQUEST['data'] =='deletion'){
                                            echo '<td align="left" style="padding:4px;">'.$row['date_r'].'</td>';
                                       }
                                    echo '<td align="center" style="padding:4px;">'.$row['red'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['amber'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['green'].'</td>';
                                     echo '<td align="center" style="padding:4px;">'.$row['orange'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['yellow'].'</td>';
                                    echo '<td align="center" style="padding:4px;">'.$row['blue'].'</td>';
                                    echo '<td align="center" style="padding:4px;"><b>'.$row['total'].'</b></td>';
                                    echo '</tr>'; 
                                   }
                                   echo '</table>';

                                   }
}            
                else
                {
                echo '<div style="color:red;text-align:center;">No Data Found</div>'; 
                }                
  }
  else
  {
     echo '<div style="color:red;text-align:center;">Please Select Maximum 31 Days Date Range</div>'; 
  }
  
  }
  
  
  
  
  ?>
