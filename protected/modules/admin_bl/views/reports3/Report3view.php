<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<link href="/css/report.css" rel="STYLESHEET" type="text/css">		
 <script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script> 
<?php
$start_date=isset($_REQUEST['start_date'])?$_REQUEST['start_date']:strtoupper(date('d-M-Y'));
$end_date=isset($_REQUEST['end_date'])?$_REQUEST['end_date']:strtoupper(date('d-M-Y'));

$this->pageTitle=Yii::app()->name . ' -Consumption Report';
echo '<html><head><SCRIPT LANGUAGE="JavaScript">';
echo "function ShowDemandData(req)
{
		var xmlHttp=ajaxFunction();
		var obj='demand_data'+req;
		var start_date=\"$start_date\";
		var end_date=\"$end_date\";
		var modid=\"$modid\";
		var submodid=\"$submodid\";
		document.getElementById('show_data'+req).style.display = \"none\";
		if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					var temp=xmlHttp.responseText;
					document.getElementById(obj).innerHTML =temp;
				}
				else
				{
					document.getElementById(obj).innerHTML='<img src=\"gifs/indicator.gif\">&nbsp;<B style=\"color:blue;\">In Process...</B>';
				}
			}
			var str='index.php?r=admin_bl/Reports3/blconsumptiondemand/req/'+req+'/start_date/'+start_date+'/end_date/'+end_date+'/modid/'+modid+'/submodid/'+submodid;
			xmlHttp.open(\"GET\",str,true);
			xmlHttp.send(null);
			return false;
		}
}

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
				xmlHttp=new ActiveXObject(\"Msxml2.XMLHTTP\");
			}
			catch (e)
			{
				try
				{
					xmlHttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
				}
				catch (e)
				{
					alert(\"Your browser does not support AJAX!\");
					return false;
				}
			}
		}
		return xmlHttp;
}

</script>";
?>
<script>
function IMAdvantage()
{    
    $("#IMAdvantage").hide();
    $("#IMAdvantage").html('Processing...');
    a={};
    a['start_date']=$('#start_date').val();
    a['end_date']=$('#end_date').val();
    $.ajax({
            type: "POST",
            url:"index.php?r=admin_bl/Reports3/IMAdvantage/",
            data:a,
            success: function(response){
                    $("#spIMAdvantage").html(response);
                    $("#IMAdvantage").show();  
            }
    });  
}
</script>
<html><head>
<FORM name="searchForm" METHOD="post" STYLE="margin-top:0;margin-bottom:0;">
	<TABLE WIDTH="100%" BORDER="1" CELLPADDING="0" CELLSPACING="0" HEIGHT="30" bordercolor="#bedaff" style="border-collapse: collapse;">
	<TR>
		<TD colspan="6" BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-left:270px;">
                    Consumption Report (MODID Wise)
                        </TD>
	</TR>
	<TR>
		<TD colspan="6" BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-left:270px;"><div style="float:right;font-size:14px;"><a href="index.php?r=admin_bl/ConsumptionReport/blconsumptionreport&mid=3431" target="_blank">BL Consumption - Daily - Hourly/Datewise Report</a> &nbsp;</div></TD>
	</TR>	
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="100" HEIGHT="30">&nbsp;Select Period</TD>
		<TD STYLE="font-family:arial;font-size:12px;font-weight:bold;" 
		BGCOLOR="#EAEAEA">
		<input name="start_date" type="text" value='<?php echo $start_date;?>' size="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" readonly="readonly">
		<input name="end_date" type="text" value='<?php echo $end_date;?>' size="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" readonly="readonly">
 </TD>
		<TD WIDTH="100" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;MODID</TD>
		<TD BGCOLOR="#EAEAEA">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
			<TD>			       
<?php		
			echo '<SELECT NAME="modid" SIZE="1" style="width:200px;" onchange="show_search(this)">';
				echo '<OPTION VALUE="';
				if($modid == 'all'){
					echo 'all" SELECTED="SELECTED"';
				}
				else{
					echo 'all"';;
				}
				echo '>All</OPTION>
				<OPTION VALUE="';
				if($modid == 'bpf'){
					echo 'bpf" SELECTED="SELECTED"';
				}else{
					echo 'bpf"';
				}
				echo '>BPF</OPTION>';
				
				 
                         
			  for($i=0;$i<sizeof($rec);$i++)
			  {			  
		           echo '<OPTION VALUE="';
		           if($modid == $rec[$i])
		            {
				echo $modid.'"'.' SELECTED="SELECTED"';

				
			    }
			    else
			    {
				echo $rec[$i].'"';

			    }
		            echo '>'.$rec[$i].'</OPTION>';         
			    }


                 $search = '';
		
		if(isset($_REQUEST['search']))
	        {
			$search = $_REQUEST['search'];
		}
		$display_option = '';
		if($modid == 'DIR' || $modid == 'ETO')
		{
			$display_option = " style='display:block;' ";	
		}
		else
		{
			$display_option = " style='display:none;' ";
		}

                echo '</select>
		<div id="div-search" '.$display_option.'>
		<input type="radio" name="search" id="search1" value="all"';
		
		if(!$search || $search == 'all')
		{
			echo 'checked';
		}
		echo '/> All
		<input type="radio" name="search" id="search2" value="search"';
		if($search == 'search')
		{
			echo  'checked';
		}
		echo '~/> Search
		</div>
		</TD>
		</TR>
		</TABLE>
		</TD>';
	   
	   echo '<TD WIDTH="100" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;FENQ MODID</TD>
			<TD BGCOLOR="#EAEAEA">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
			<TD>
		<SELECT NAME="submodid" id ="submodid" SIZE="1" style="width:150px;" >
						<OPTION VALUE="';
						if($submodid == 'all'){
							echo 'all" SELECTED="SELECTED"';
						}else{
							echo 'all"';
						}
						echo '>All</OPTION>
						<OPTION VALUE="';
						if($submodid == 'bpf'){
							echo 'bpf" SELECTED="SELECTED"';
						}else{
							echo 'bpf"';
						}
						echo '>BPF</OPTION>';
						
						 
			  for($i=0;$i<sizeof($rec);$i++)
			  {			  
		           echo '<OPTION VALUE="';
		           if($submodid == $rec[$i])
		              {
				echo $submodid.'"'.' SELECTED="SELECTED"';

				
			      }
			    else
			      {
				echo $rec[$i].'"';

			      }
		            echo '>'.$rec[$i].'</OPTION>';
		            
		                     
                            }
                            
                            echo '</TD>
		</TR>
		</TABLE>
		</TD>';
		
		echo '</TR>
	</TABLE>';
	echo '<br>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">	
	<TR><TD BGCOLOR="#F4F4F4" width="60%" ALIGN="LEFT" STYLE="font-family:arial;font-size:14px;font-weight:bold;">';
      
	if(isset($bl_tender_rep) && $bl_tender_rep == 'bl_tender_rep')
        {
         echo '<input type="checkbox" style="margin:0 5px 0 20px" name="bl_tender_rep" id="bl_tender_rep" value="bl_tender_rep" checked/><b>BL Tender Report</b>';
        }
        else
        {
        echo '<input type="checkbox" style="margin:0 5px 0 20px" name="bl_tender_rep" id="bl_tender_rep" value="bl_tender_rep"/><b>BL Tender Report</b>';
        }	
       echo '<span id="bl_tracking_hr_rep" style="margin:0 5px 0 20px;display:none"><input type="checkbox" name="bl_track_hr_rep" id="bl_track_hr_rep" onclick="trackingcheck()" value="bl_track_hr_rep"/><b>BL Tracking Report Hourwise</b></span></td><TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
		<input type="hidden" name="action" value="get_cons_rpt">
		<INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report">
		</TD>
	</TR>
	</TABLE></FORM>
	<div id="se_time" STYLE="font-family:arial;font-size:11px;"></div>';
			

?>