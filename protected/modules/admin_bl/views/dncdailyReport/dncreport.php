<?php 
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
?>

<head>
<title>DNC Daily Report</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; } 
.cancel 
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1; 
 
border-size:2px;border-style:solid;border-color:#0195d3;
} 
</style>

<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">		
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script>
<script>
function trend_check(id)
{
 if(id ==1)
 {
  document.getElementById("end_date1").style.display='block';
 }
 else
 {
  document.getElementById("end_date1").style.display='none';
 }
 
}
function del_check(id)
{
 if(id.value =='approval')
 {
  document.getElementById("del_type").style.display='none';
 }
 if(id.value =='generation')
 {
  document.getElementById("del_type").style.display='none';
 }
 if(id.value =='deletion')
 {
  document.getElementById("del_type").style.display='block';
 }
}

function showdemanddata(req,pool){
        a={};

            a['start_date']=$('#start_date').val();
            a['end_date']=$('#end_date').val();
            a['country']=$('input[name="country"]:checked').val();;
            a['req']=req;
            a['pool']=pool;
						
            var obj='demand_data'+req;
         
          document.getElementById('show_data'+req).style.display = "none";
        result='';  

        $.ajax({
            url:"index.php?r=admin_bl/DncReport/dncdemand&mid=3540",
            type: 'post',
            data:a,
            beforeSend: function(){$("#"+obj).html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
            success:function(result){                          
               document.getElementById(obj).innerHTML =result;                    
            }
        });                    
                    
    } 
</script>
</head>

<form name="dncReport" id="dncReport" method="post" action="" style="margin-top:0;margin-bottom:0;" onsubmit="">
<input name="frame_height" id="frame_height" value="" type="hidden">
		    <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
			  <TR>
				<td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>LEAP POOL WISE Report</b></font>			 </td>	
			  </TR>
			  <tr>

				<td WIDTH="15%">&nbsp;Date:</td>
				<td WIDTH="45%">
					&nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.dncReport.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.dncReport.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
			  
					<?php if(!isset($_REQUEST['trend']) || $_REQUEST['trend']=='datewise') { ?>
			  
					<div id="end_date1" style="margin-left:200px; margin-top:-20px;display:block;">
					<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div>
					<?php } 
					else
					{
					?>
					<div id="end_date1" style="margin-left:200px; margin-top:-20px;display:none;">
					<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div> <?php } ?>
				</td>
				
			  	<td WIDTH="15%">&nbsp;Country: </td>
				
				<td WIDTH="25%">
					&nbsp;<input type="radio" name="country" id="country" value="india"
					<?php
					if((isset($_REQUEST['country']) && $_REQUEST['country'] =='india') || !isset($_REQUEST['country']))
					{
					 echo ' checked';
					}
					
					?>
					>&nbsp;India
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="country" id="country" value="foreign"
					<?php
					if((isset($_REQUEST['country']) && $_REQUEST['country'] =='foreign'))
					{
					 echo ' checked';
					}
					
					?>
					>&nbsp;Foreign
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="country" id="country" value="both"
					<?php
					if((isset($_REQUEST['country']) && $_REQUEST['country'] =='both'))
					{
					 echo ' checked';
					}
					
					?>
					>&nbsp;Both
				</td>
	
			  </tr>
                    
        <tr>
		<td >&nbsp;Data: </td>
		<td>&nbsp;<input type="radio" name="data" id="data" onclick="del_check(this);" value="generation"
			<?php
			if((isset($_REQUEST['data']) && $_REQUEST['data'] =='generation') || !isset($_REQUEST['data']))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Generation
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="data" id="data" onclick="del_check(this);" value="approval"
			<?php
			if((isset($_REQUEST['data']) && $_REQUEST['data'] =='approval'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Approval
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="data" id="data" onclick="del_check(this);" value="deletion"
			<?php
			if((isset($_REQUEST['data']) && $_REQUEST['data'] =='deletion'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Deletion
			<div id="del_type" style="margin-top:-20px;margin-left:300px;display:none;">
			
			<b>Deletion Type:</b>&nbsp;<input type="radio" name="deltypye" id="deltypye" value="auto"
			<?php
			if((isset($_REQUEST['deltypye']) && $_REQUEST['deltypye'] =='auto') || !isset($_REQUEST['deltypye']))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Auto
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="deltypye" id="deltypye" value="mannual"
			<?php
			if((isset($_REQUEST['deltypye']) && $_REQUEST['deltypye'] =='mannual'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Manual
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="deltypye" id="deltypye" value="all"
			<?php
			if((isset($_REQUEST['deltypye']) && $_REQUEST['deltypye'] =='all'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;ALL
			<div>
		</td>
		
		<td >&nbsp;Type: </td>
		<td >&nbsp;<input type="radio" name="type" id="type" value="modidwise"
			<?php
			if((isset($_REQUEST['type']) && $_REQUEST['type'] =='modidwise') || !isset($_REQUEST['type']))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;Modid Wise
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="type" id="type" value="flagwise"
			<?php
			if((isset($_REQUEST['type']) && $_REQUEST['type'] =='flagwise'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;User Identifier Flag Wise
		</td>
	
	</tr>
	
	<tr>
		<td >&nbsp;Source: </td>
		<td>&nbsp;<input type="radio" name="source" id="source" value="all"
			<?php
			if((isset($_REQUEST['source']) && $_REQUEST['source'] =='all') || !isset($_REQUEST['type']))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;ALL
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="source" id="source" value="FENQ"
			<?php
			if((isset($_REQUEST['source']) && $_REQUEST['source'] =='FENQ'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;FENQ
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="source" id="source" value="DIRECT"
			<?php
			if((isset($_REQUEST['source']) && $_REQUEST['source'] =='DIRECT'))
			{
			 echo ' checked';
			}
			
			?>
			>&nbsp;DIRECT
		</td>
		
		<td >&nbsp;Mod Id: </td>
		<td></td>
	</tr>
	
	<tr>
		<td >&nbsp;Pool Wise: </td>

		<td>
			<input type="radio" name="pool" id="pool" value="DNC"
				<?php
					if((isset($_REQUEST['pool']) && $_REQUEST['pool'] =='DNC') || !isset($_REQUEST['pool']))
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
		
		<td >&nbsp;Trend: </td>
		<td>&nbsp;<input type="radio" name="trend" id="trend" onclick="trend_check(1);" value="datewise"
		<?php
		if((isset($_REQUEST['trend']) && $_REQUEST['trend'] =='datewise') || !isset($_REQUEST['trend']))
		{
		 echo ' checked';
		}
		
		?>
		 >&nbsp;Date Wise
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trend" id="trend" onclick="trend_check(2);" value="hourly"
		<?php
		if((isset($_REQUEST['trend']) && $_REQUEST['trend'] =='hourly'))
		{
		 echo ' checked';
		}
		
		?>
		>&nbsp;Hourly
		</td>
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
   
if(isset($_REQUEST['trend']) && $_REQUEST['trend'] =='datewise')   
{   
  
if(isset($_REQUEST['type']) && $_REQUEST['type'] =='modidwise')
{
   $DataArr=$ModArr=array();
   $date='';
   $m=-1;
   for($i=0;$i<count($recData);$i++)
    {
       if($date ==$recData[$i]['ETO_OFR_POSTDATE_ORIG']) 
       {
         $DataArr[$m][$recData[$i]['FK_GL_MODULE_ID']]=$recData[$i]['CNT'];
         $DataArr[$m]['DATE']=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
       }
       else{
             $m++;
             $DataArr[$m][$recData[$i]['FK_GL_MODULE_ID']]=$recData[$i]['CNT'];
             $DataArr[$m]['DATE']=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
           }
           
           $date=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
           
           array_push($ModArr,$recData[$i]['FK_GL_MODULE_ID']);
    }
    
    $ModArr=array_unique($ModArr);

if(!empty($DataArr)){    
	
 echo '<br><table border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                echo '<tr style="background: #dff8ff;color: white;">';
                echo '<td align="left" style="padding:4px;" width="150px"><b>Date /Mod Id</b></td>';
                foreach($ModArr as $x)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.$x.'</b></td>';
                  ${"total" . $x} =0;
                }
                echo '<td align="center" style="padding:4px;"><b>Total</b></td>';
                echo '</tr>';
                $SumTotal=0;
                foreach ($DataArr as $y)
                {
                 echo '<tr style="color: white;">';
                 echo '<td align="left" style="padding:4px;"><b>'.$y['DATE'].'</b></td>';
                 $dayTotal=0;
                  foreach($ModArr as $x)
		  { 
		    $count=isset($y[$x]) ? $y[$x] : 0;
		    $dayTotal=$dayTotal+$count;
		    ${"total" . $x}=${"total" . $x}+$count;
		    echo '<td align="center" style="padding:4px;">'.$count.'</td>';
		  }
		  $SumTotal=$SumTotal+$dayTotal;
		  echo '<td align="center" style="padding:4px;"><b>'.$dayTotal.'</b></td>';
                 echo '</tr>';
                 
                }
                
                echo '<tr style="background: #dff8ff;color: white;">';
                echo '<td align="left" style="padding:4px;"><b>Total</b></td>';
                foreach($ModArr as $x)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.${"total" . $x}.'</b></td>';
                }
                echo '<td align="center" style="padding:4px;"><b>'.$SumTotal.'</b></td>';
                echo '</tr>';
                
                
                echo '</table>';
                
                  
                }                
                else
                {
                echo '<div style="color:red;text-align:center;">No Data Found</div>'; 
                }                
  }
  
  if(isset($_REQUEST['type']) && $_REQUEST['type'] =='flagwise')
  {
  
  $DataArr=array();
  $ModArr=array();
  
  
   $date='';
   $m=-1;
   for($i=0;$i<count($recData);$i++)
    {
       if($date ==$recData[$i]['ETO_OFR_POSTDATE_ORIG']) 
       {
         $DataArr[$m][$recData[$i]['USER_IDENTIFIER_FLAG']]=$recData[$i]['CNT'];
         $DataArr[$m]['DATE']=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
       }
       else{
             $m++;
             $DataArr[$m][$recData[$i]['USER_IDENTIFIER_FLAG']]=$recData[$i]['CNT'];
             $DataArr[$m]['DATE']=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
           }
           
           $date=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
           array_push($ModArr,$recData[$i]['USER_IDENTIFIER_FLAG']);
    }
  
   $ModArr=array_unique($ModArr);
   
   if(!empty($DataArr))
   {
	
 echo '<br><table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                echo '<tr style="background: #dff8ff;color: white;">';
                echo '<td align="left" style="padding:4px;" width="200px"><b>Date / User Identifier</b></td>';
                foreach($ModArr as $x)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.$x.'</b></td>'; 
                  ${"total" . $x} =0;
                 
                }
                echo '<td align="center" style="padding:4px;"><b>Total</b></td>'; 
                
                echo '</tr>';
                $SumTotal=0;
                foreach ($DataArr as $y)
                {
                 echo '<tr style="color: white;">';
                 echo '<td align="left" style="padding:4px;"><b>'.$y['DATE'].'</b></td>';
                 $dayTotal=0;
                  foreach($ModArr as $x)
		  { 
		   $count=isset($y[$x]) ? $y[$x] : 0;
		   $dayTotal=$dayTotal+$count;
		   ${"total" . $x}=${"total" . $x}+$count;
		    echo '<td align="center" style="padding:4px;">'.$count.'</td>';
		  }
		  $SumTotal=$SumTotal+$dayTotal;
		  echo '<td align="center" style="padding:4px;"><b>'.$dayTotal.'</b></td>';
                 echo '</tr>';
                }
                
                  echo '<tr style="background: #dff8ff;color: white;">';
                echo '<td align="left" style="padding:4px;"><b>Total</b></td>';
                foreach($ModArr as $x)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.${"total" . $x}.'</b></td>';
                }
                echo '<td align="center" style="padding:4px;"><b>'.$SumTotal.'</b></td>';
                echo '</tr>'; 
                
                
                echo '</table>';
                
                echo '<br><br><table style="width:700px;"  border="1" cellpadding="0" cellspacing="1" align="left">
                 <tr style="background: #88cecd;color: white;">
                 <td align="center" style="padding:4px;" width="100px"><b>User Identifier</b></td>
                 <td align="center" style="padding:4px;" width="600px"><b>Meaning</b></td></tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">2</td>
                 <td align="center" style="padding:4px;">>=100 Char in Description And Either Quantity or Order Value is available</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">3</td>
                 <td align="center" style="padding:4px;">>=100 Char in Description</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">5</td>
                 <td align="center" style="padding:4px;">Personal Big Buyer</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">6</td>
                 <td align="center" style="padding:4px;">Official Big Buyer</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">7</td>
                 <td align="center" style="padding:4px;">At-least 1 Lead approved Last 90 Days And Either Quantity or Order Value is available</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">8</td>
                 <td align="center" style="padding:4px;">Any 1 Field from (How Soon, Why you Need, Frequency) And Either Quantity or Order Value is available</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">9</td>
                 <td align="center" style="padding:4px;"> Modi_id= BLAFFLT And Description>=50 (google adword)</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">10</td>
                 <td align="center" style="padding:4px;">If Lead is Re-Posted from My.IndiaMART.com</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">14</td>
                 <td align="center" style="padding:4px;">GLUser DNC Setting</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">16</td>
                 <td align="center" style="padding:4px;">At least 1 ISQ filled</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">19</td>
                 <td align="center" style="padding:4px;">Subject is available And (>10 Char in description or null) And Order Value And Quantity</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">20</td>
                 <td align="center" style="padding:4px;">Probable DNC without Email</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">21</td>
                 <td align="center" style="padding:4px;">Without Email DNC from Must</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">22</td>
                 <td align="center" style="padding:4px;">Not Talk-3(DNC)</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">23</td>
                 <td align="center" style="padding:4px;">Not Talk-1 + Service Non Supplier(DNC)</td>
                 </tr>
                 </table>';
                
                 
                }
                else
                {
                echo '<div style="color:red;text-align:center;">No Data Found</div>'; 
                }
  
  }  
  }
  
  if(isset($_REQUEST['trend']) && $_REQUEST['trend'] =='hourly')   
  {  
  $ArrHour=array('00'=>'00 - 01','01'=>'01 - 02','02'=>'02 - 03','03'=>'03 - 04','04'=>'04 - 05','05'=>'05 - 06','06'=>'06 - 07','07'=>'07 - 08','08'=>'08 - 09','09'=>'09 - 10','10'=>'10 - 11','11'=>'11 - 12','12'=>'12 - 13','13'=>'13 - 14','14'=>'14 - 15','15'=>'15 - 16','16'=>'16 - 17','17'=>'17 - 18','18'=>'18 - 19','19'=>'19 - 20','20'=>'20 - 21','21'=>'21 - 22','22'=>'22 - 23','23'=>'23 - 24');
  
  if(isset($_REQUEST['type']) && $_REQUEST['type'] =='modidwise')
   {
   $DataArr=$ModArr=array();
   $date='';
   $m=-1;
   for($i=0;$i<count($recData);$i++)
    {
       if($date ==$recData[$i]['ETO_OFR_POSTDATE_ORIG']) 
       {
         $DataArr[$m][$recData[$i]['FK_GL_MODULE_ID']]=$recData[$i]['CNT'];
         $DataArr[$m]['HR']=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
       }
       else{
             $m++;
             $DataArr[$m][$recData[$i]['FK_GL_MODULE_ID']]=$recData[$i]['CNT'];
             $DataArr[$m]['HR']=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
           }
           
           $date=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
           array_push($ModArr,$recData[$i]['FK_GL_MODULE_ID']);
    }
    
    $ModArr=array_unique($ModArr);
  
  if(!empty($DataArr))
  {
	
 echo '<br><table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                echo '<tr style="background: #dff8ff;color: white;">';
                echo '<td align="left" style="padding:4px;"><b>Hours /Mod Id</b></td>';
                foreach($ModArr as $x)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.$x.'</b></td>';
                  ${"total" . $x}=0;
                 
                }echo '<td align="center" style="padding:4px;"><b>Total</b></td>';
                echo '</tr>';
                $SumTotal=0;
                foreach ($DataArr as $y)
                {
                 echo '<tr style="color: white;">';
                 echo '<td align="left" style="padding:4px;"><b>'.$ArrHour[$y['HR']].'</b></td>';
                 $dayTotal=0;
                  foreach($ModArr as $x)
		  { 
		   $count=isset($y[$x]) ? $y[$x] : 0; 
		   $dayTotal=$dayTotal+$count;
		   ${"total" . $x}=${"total" . $x}+$count;
		    echo '<td align="center" style="padding:4px;">'.$count.'</td>';
		  }
		  $SumTotal=$SumTotal+$dayTotal;
		  echo '<td align="center" style="padding:4px;"><b>'.$dayTotal.'</b></td>';
                 echo '</tr>';
                }
                
                  echo '<tr style="background: #dff8ff;color: white;">';
                echo '<td align="left" style="padding:4px;"><b>Total</b></td>';
                foreach($ModArr as $x)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.${"total" . $x}.'</b></td>';
                }
                echo '<td align="center" style="padding:4px;"><b>'.$SumTotal.'</b></td>';
                echo '</tr>'; 
                
                
                echo '</table>';	
                
                
                }
                else
                {
                echo '<div style="color:red;text-align:center;">No Data Found</div>'; 
                }
                
  }
  
  if(isset($_REQUEST['type']) && $_REQUEST['type'] =='flagwise')
  {
  
  $DataArr=array();
  $ModArr=array();
  
   $date='';
   $m=-1;
   for($i=0;$i<count($recData);$i++)
    {
       if($date ==$recData[$i]['ETO_OFR_POSTDATE_ORIG']) 
       {
         $DataArr[$m][$recData[$i]['USER_IDENTIFIER_FLAG']]=$recData[$i]['CNT'];
         $DataArr[$m]['HR']=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
       }
       else{
             $m++;
             $DataArr[$m][$recData[$i]['USER_IDENTIFIER_FLAG']]=$recData[$i]['CNT'];
             $DataArr[$m]['HR']=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
           }
           
           $date=$recData[$i]['ETO_OFR_POSTDATE_ORIG'];
           array_push($ModArr,$recData[$i]['USER_IDENTIFIER_FLAG']);
    }
  
   $ModArr=array_unique($ModArr);
//    $ModArr=sort($ModArr);
   
   if(!empty($DataArr))
   {	
 echo '<br><table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                echo '<tr style="background: #dff8ff;color: white;">';
                echo '<td align="left" style="padding:4px;" width="200px"><b>Hours / User Identifier</b></td>';
                foreach($ModArr as $x)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.$x.'</b></td>';
                  ${"total" . $x}=0;
                 
                }
                 echo '<td align="center" style="padding:4px;"><b>Total</b></td>';
                echo '</tr>';
                $SumTotal=0;
                foreach ($DataArr as $y)
                {
                 echo '<tr style="color: white;">';
                 echo '<td align="left" style="padding:4px;"><b>'.$ArrHour[$y['HR']].'</b></td>';
                 $dayTotal=0;
                  foreach($ModArr as $x)
		  { 
		   $count=isset($y[$x]) ? $y[$x] : 0; 
		   $dayTotal=$dayTotal+$count;
		   ${"total" . $x}=${"total" . $x}+$count;
		    echo '<td align="center" style="padding:4px;">'.$count.'</td>';
		  }
		  $SumTotal=$SumTotal+$dayTotal;
		  echo '<td align="center" style="padding:4px;"><b>'.$dayTotal.'</b></td>';
                 echo '</tr>';
                }
                
                echo '<tr style="background: #dff8ff;color: white;">';
                echo '<td align="left" style="padding:4px;"><b>Total</b></td>';
                foreach($ModArr as $x)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.${"total" . $x}.'</b></td>';
                }
                echo '<td align="center" style="padding:4px;"><b>'.$SumTotal.'</b></td>';
                echo '</tr>'; 
                echo '</table>';
                
                 echo '<br><br><table style="width:700px;"  border="1" cellpadding="0" cellspacing="1" align="left">
                 <tr style="background: #88cecd;color: white;">
                 <td align="center" style="padding:4px;" width="100px"><b>User Identifier</b></td>
                 <td align="center" style="padding:4px;" width="600px"><b>Meaning</b></td></tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">2</td>
                 <td align="center" style="padding:4px;">>=100 Char in Description And Either Quantity or Order Value is available</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">3</td>
                 <td align="center" style="padding:4px;">>=100 Char in Description</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">5</td>
                 <td align="center" style="padding:4px;">Personal Big Buyer</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">6</td>
                 <td align="center" style="padding:4px;">Official Big Buyer</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">7</td>
                 <td align="center" style="padding:4px;">At-least 1 Lead approved Last 90 Days And Either Quantity or Order Value is available</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">8</td>
                 <td align="center" style="padding:4px;">Any 1 Field from (How Soon, Why you Need, Frequency) And Either Quantity or Order Value is available</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">9</td>
                 <td align="center" style="padding:4px;"> Modi_id= BLAFFLT And Description>=50 (google adword)</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">10</td>
                 <td align="center" style="padding:4px;">If Lead is Re-Posted from My.IndiaMART.com</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">14</td>
                 <td align="center" style="padding:4px;">GLUser DNC Setting</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">16</td>
                 <td align="center" style="padding:4px;">At least 1 ISQ filled</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">19</td>
                 <td align="center" style="padding:4px;">Subject is available And (>10 Char in description or null) And Order Value And Quantity</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">20</td>
                 <td align="center" style="padding:4px;">Probable DNC without Email</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">21</td>
                 <td align="center" style="padding:4px;">Without Email DNC from Must</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">22</td>
                 <td align="center" style="padding:4px;">Not Talk-3(DNC)</td>
                 </tr>
                 <tr style="color: white;">
                 <td align="center" style="padding:4px;">23</td>
                 <td align="center" style="padding:4px;">Not Talk-1 + Service Non Supplier(DNC)</td>
                 </tr></table>';
              }
              else
                {
                echo '<div style="color:red;text-align:center;">No Data Found</div>'; 
                }
  
  }
  }
  
    //Addition to DNC   
    
$pool = isset($_REQUEST['pool'])? $_REQUEST['pool'] : '';             

echo '<br><br><table width="100%" align="left" border="1" cellpadding="5" cellspacing="2">
<TR>
        <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="70%" >&nbsp;<B>Special Focus Parameters</B></TD>
        <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B><div id="show_data0"><a href="javascript:void(0);" onclick="showdemanddata(0,\''.$pool.'\');" style="text-decoration:none;">Show data</a></div></B></TD>	
</TR>
<TR>
<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="2">
         <div id="demand_data0">
         </TD>
</TR>

<TR>
        <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Retail Leads (Only for Indian '.$pool.' Leads) + Delayed Approval
</TD>
        <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B><div id="show_data1"><a href="javascript:void(0);" onclick="showdemanddata(1,\''.$pool.'\');" style="text-decoration:none;">Show data</a></div></B></TD>	
</TR>
<TR>
<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="2">
         <div id="demand_data1">
         </TD>
</TR>
<TR>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;Overall Rejection (%)
</TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B><div id="show_data3"><a href="javascript:void(0);" onclick="showdemanddata(3,\''.$pool.'\');" style="text-decoration:none;">Show data</a></div></B></TD>	
</TR>
<TR>
<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="2">
         <div id="demand_data3">
         </TD>
</TR>



<TR>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;Total MCATs selected
</TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B><div id="show_data13"><a href="javascript:void(0);" onclick="showdemanddata(13,\''.$pool.'\');" style="text-decoration:none;">Show data</a></div></B></TD>	
</TR>
<TR>
<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="2">
         <div id="demand_data13">
         </TD>	
</TR>
<TR>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;font-weight:bold;" ALIGN="LEFT"  >Timeliness Detail
</TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B><div id="show_data14"><a href="javascript:void(0);" onclick="showdemanddata(14,\''.$pool.'\');" style="text-decoration:none;">Show data</a></div></B></TD>	
</TR>
<TR>
<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="2">
<div id="demand_data14">
</TD>
</TR>
<TR>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;font-weight:bold;" ALIGN="LEFT"  >Total Enriched Columns Data
</TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B><div id="show_data15"><a href="javascript:void(0);" onclick="showdemanddata(15,\''.$pool.'\');" style="text-decoration:none;">Show data</a></div></B></TD>	
</TR>
<TR>
<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="2">
<div id="demand_data15">
</TD>
</TR>
</table>';
  
  
 } 
  else
  {
     echo '<div style="color:red;text-align:center;">Please Select Maximum 31 Days Date Range</div>'; 
  }
  
  }
  
  
  
  
  ?>
