<?php
  
	$start_date=isset($_REQUEST['start_date'])?$_REQUEST['start_date']:strtoupper(date('d-M-Y'));
	$end_date=isset($_REQUEST['end_date'])?$_REQUEST['end_date']:strtoupper(date('d-M-Y'));
	$reporttype=isset($_REQUEST['reporttype'])?$_REQUEST['reporttype']:'';
	$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';

	
	$rep = array('1' => "Normal", '2' => "Monthly ModID Wise");
	$eto_enq=array('All','Detail','Search','Other');	
	$dir_enq=array('All','Search','Other');	
	$query_typ=array('1' =>"All",'2' =>"Web",'3' =>"Sms");
	$dayStyle ='';
	if (isset($xyz['report']) && $xyz['report'] == 2)
	{
		$dayStyle='STYLE="background-color:#DEF2FE;color:#b5b2ad;"';
	}
	?>

<html>
<body>
<title>FENQ Report</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; } 
.cancel { display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1; border-size:2px;border-style:solid;border-color:#0195d3;} .TD{background-color: aliceblue;}
</style>
<link href="/css/report.css" rel="STYLESHEET" type="text/css">		
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script> 	
<script>
	function validate(){
		var date1=$('#start_date').val();
		var mdy = date1.split('-');
		var date1=mdy[0] +' '+mdy[1]+' '+mdy[2];
		var date1 = new Date(date1);

		var date2=$('#end_date').val();
		var mdy2 = date2.split('-');
		var date2=mdy2[0] +' '+mdy2[1]+' '+mdy2[2];
		var date2 = new Date(date2);
		var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
		if(diffDays>31)
		{
			alert('Please Select maximum 31 days difference Only');
			return false;
		}
	}

	function ShowDDL(val)
	{
		if(val=="ETO")
		{
			document.getElementById(eto_ddl).style.display=block;
			document.getElementById(eto_label).style.display=block;
			document.getElementById(dir_ddl).style.display=none;
			document.getElementById(dir_label).style.display=none;
		}
		else if(val=="DIR")
		{
			document.getElementById(dir_ddl).style.display=block;
			document.getElementById(dir_label).style.display=block;
			document.getElementById(eto_ddl).style.display=none;
			document.getElementById(eto_label).style.display=none;
		}
		else
		{
			document.getElementById(eto_ddl).style.display=none;
			document.getElementById(eto_label).style.display=none;
			document.getElementById(dir_ddl).style.display=none;
			document.getElementById(dir_label).style.display=none;
		}
	}
</script>
</body>
</html>

<?php
	if(isset($mesg))
	{
		print $mesg;
	}
	
	echo '<table width="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0"><tr><td>
	<FORM name="searchForm" METHOD="post" ACTION="index.php?r=admin_bl/Fenq_report/Index&mid=3434" STYLE="margin-top:0;margin-bottom:0;">
    <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
      <TR>
        <TD BGCOLOR="#dff8ff" HEIGHT="30" COLSPAN="4" ALIGN="CENTER" 
        STYLE="font-family:arial;font-size:14px;font-weight:bold;">FENQ Report</TD>
      </TR>
      <TR>
        <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" WIDTH="10%">&nbsp;Start Date</TD>
        <TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="40%">
        <TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
			<TR>';
?>
			  <input name="start_date" type="text" value='<?php echo $start_date;?>' size="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" readonly="readonly">
        	</TR>
		</TABLE>
		</TD>
	<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Choose Mod Id
	<div id="eto_label" name="eto_label" style="display:none; clear:both;"><br>&nbsp;ETO Source	</div>	
	<div id="dir_label" name="dir_label" style="display:none; clear:both;"><br>&nbsp;DIR Source	</div>	
	</TD>
	<?php
	echo '<TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:14px;">';
   echo ''.$select.'
	<div id="eto_ddl" name="eto_ddl" style="display:none;"><SELECT NAME="eto_enquiry">';

   foreach($eto_enq as $value)
		{
		        if(isset($_REQUEST['eto_enquiry']))
		        {
			$cur_eto=$_REQUEST['eto_enquiry'];
			}
			else
			{
			$cur_eto='All';
			}
                   	echo '<OPTION VALUE="'.$value.'"';
                   	if ($cur_eto == $value) 
			{
                       		echo ' SELECTED ';
                   	}
                   	echo '>'.$value.'</OPTION>';
                }
                
                echo '</SELECT></div>';
	echo '<div id="dir_ddl" name="dir_ddl" style="display:none;"><SELECT NAME="dir_enquiry">';
	
	foreach($dir_enq as $val)
	{
		if(isset($_REQUEST['dir_enquiry']))
		{
		$cur_dir=$_REQUEST['dir_enquiry'];
		}
		else
		{
		$cur_dir='All';
		}
		echo '<OPTION VALUE="'.$val.'"';
		if ($cur_dir == $val) 
		{
			echo ' SELECTED ';
		}
		echo '>'.$val.'</OPTION>';
	}
	$modidDrpDwn='';
	echo '</SELECT></div>';
        if(isset($xyz['modidDrpDwn']))
        {
          $modidDrpDwn=$xyz['modidDrpDwn'];
         }
        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'generate')
	{
		if(isset($modidDrpDwn) && $modidDrpDwn == 'ETO')
		{
		  echo '<script language="javascript" TYPE="text/javascript">
			document.getElementById(\'eto_ddl\').style.display=\'block\';
			document.getElementById(\'eto_label\').style.display=\'block\';
			document.getElementById(\'dir_ddl\').style.display=\'none\';
			document.getElementById(\'dir_label\').style.display=\'none\';
		   </script>';
		   
		   }
		
		if($modidDrpDwn && $modidDrpDwn == 'DIR')
		{
		
		  echo '<script language="javascript" TYPE="text/javascript">
			document.getElementById(\'dir_ddl\').style.display=\'block\';
			document.getElementById(\'dir_label\').style.display=\'block\';
			document.getElementById(\'eto_ddl\').style.display=\'none\';
			document.getElementById(\'eto_label\').style.display=\'none\';
		   </script>';
		   
		   }
	
	}
	echo '</TD>
      </TR>
      <TR>
        <TD BGCOLOR="#dff8ff" 
        STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30">&nbsp;End Date</TD>
        <TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:12px;font-weight:bold;">
        <TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
			<TR>';
			?>
			<input name="end_date" type="text" value='<?php echo $end_date;?>' size="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" readonly="readonly">
		<?php
		echo '</TR>
        </TABLE>
		</TD>
	<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;">
	&nbsp;Country</TD>
	<TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:14px;">';
	$cntry=array('' => "All",'1' => "Indian", '2' => "Foreign");
	$cntryrating=array('1' => "A", '2' => "B", '3' => "C", '4' => "D", '5' => "Others(C & D)", '6' => "All");
	$cntry1=array_keys($cntry);
	foreach ($cntry1 as $key)
	{
                  echo '<input type="radio" name="cntry" value="'.$key.'"';
                   if (isset($xyz['cntry']) && $xyz['cntry'] == $key) {
                       echo ' checked';
                   }
		   elseif($key == '' && !isset($xyz['cntry']))
		   {
			echo ' checked';
		   }
                   echo ' onclick="disModule(2);">&nbsp;'.$cntry[$key].'&nbsp;';
         }
       echo	' </TD>
        
      </TR>
	<TR>

	<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" WIDTH="10%">
	&nbsp;Query Type</TD> <TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:14px;">';
	$query_typ1=array_keys($query_typ);
	foreach ($query_typ1 as $key)
{
			  echo '<input type="radio" name="querytype" value="'.$key.'"';
			   if (isset($xyz['querytype']) && $xyz['querytype'] == $key) {
				   echo ' checked';
			   }
	   elseif($key == 1)
	   {
		echo ' checked';
	   }
			   echo ' onclick="disModule(2);">&nbsp;'.$query_typ[$key].'&nbsp;';
	 }
	echo'</TD>
	<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" WIDTH="10%">
	&nbsp;Report Type</TD>
	<TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:14px;">
	<input type="radio" name="reporttype" value="datewise"';if($reporttype=="datewise" || $reporttype==''){echo 'checked';}echo'>&nbsp;Datewise &nbsp;&nbsp;
	<input type="radio" name="reporttype" value="summary" ';if($reporttype=="summary"  ){echo 'checked';} echo'>&nbsp;Summary &nbsp;&nbsp;
	
	
	</td>
	</TR>
	<TR>
        <TD BGCOLOR="#dff8ff" HEIGHT="30" COLSPAN="4" ALIGN="CENTER">
	<input type="hidden" name="action" value="generate">
	<INPUT TYPE="SUBMIT" NAME="Submit" VALUE="Submit" onclick="return validate();"> 
	</TD>
      </TR>
    </TABLE></FORM>
	</td>
	<tr><table>';

?>