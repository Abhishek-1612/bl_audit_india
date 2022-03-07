<?php
$cntry_arr=array('All','India','Foreign');

$start_date=isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : ''; 
$start_date = (!empty($start_date) ? $start_date : date("d-M-Y"));

$end_date=isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : '';
$end_date = (!empty($end_date) ? $end_date : date("d-M-Y"));

$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));

?>	
<html>
<head>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">		
<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script>
<script>
    function validateForm(){alert('hh');
                var date1=document.searchForm.start_date.value;
                var mdy = date1.split('-');
                var date1=mdy[0] +' '+mdy[1]+' '+mdy[2];
                var date1 = new Date(date1);

                var date2=document.searchForm.end_date.value;
                var mdy2 = date2.split('-');
                var date2=mdy2[0] +' '+mdy2[1]+' '+mdy2[2];
                var date2 = new Date(date2);
               var timeDiff = Math.abs(date2.getTime() - date1.getTime());
               var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
               if(diffDays>7)
               {
                alert('Kindly Select Dates In Span Of 7 Days Only');
                return false;
               }
               return true;
    }    
</script>


	</head>
	<body>
	<FORM name="searchForm" METHOD="post"  STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return validateForm()">
	<input name="frame_height" id="frame_height" value="" type="hidden">
	<TABLE WIDTH="100%" bordercolor="#CCCCFF" BORDER="1" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
		<TD colspan=8 HEIGHT=30px BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">Lead Quality Report</TD>
	</TR>
	
	<TR>
		<TD HEIGHT="25px" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="12%" HEIGHT="30">&nbsp;Select Period</TD>
		<TD STYLE="font-family:arial;font-size:12px;font-weight:bold;" BGCOLOR="#EAEAEA" width="35%">
		&nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
                    &nbsp;&nbsp;<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div>
                </TD>
                <?php 
		echo '<TD WIDTH="10%" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;MODID</TD>
		<TD BGCOLOR="#EAEAEA" width="10%">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
			<TD>
				<SELECT NAME="modid" SIZE="1" style="width:100px;">
				<OPTION VALUE="';
				if($modval == 'all'){
					echo 'all" SELECTED="SELECTED"';
				}
				else
				{
					echo 'all"';
				}
				echo '>All</OPTION>
				<OPTION VALUE="';
				if($modval == 'bpf')
				{
					echo 'bpf" SELECTED="SELECTED"';
				}
				else
				{
					echo 'bpf"';
				}
			 echo '>BPF</OPTION>
			';
			
	   while ( $rec = oci_fetch_assoc($sth)) 
		{
			echo '<OPTION VALUE="';
			if($modval == $rec['GL_MODULE_ID'])
			{
			    echo ''.$modval.'" SELECTED="SELECTED"';	
			}
			else
			{
				echo ''.$rec['GL_MODULE_ID'].'"';
			}
			echo '> '.$rec['GL_MODULE_ID'].'</OPTION>';
		}
		
	echo '</TD>
		</TR>
		</TABLE>
		</TD>';
# 		if($modval && $modval eq 'FENQ')
# 		{

	echo '<TD WIDTH="120" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Country</TD>
			<TD BGCOLOR="#EAEAEA" width="10%">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
			<TD>
		<SELECT NAME="country" id ="country" SIZE="1" style="width:100px;" >';
		
                  foreach($cntry_arr as $x)
                        {
                                echo '<OPTION VALUE="'.$x.'"';
                                if (isset($_REQUEST['country'])  &&  $_REQUEST['country'] ==  $x) 
                                {
                                        echo ' SELECTED ';
                                }
                                echo '>'.$x.'</OPTION">';
                        }		
			
# 		}
		echo '</TD>
		</TR>
		</TABLE>
		</TD>
		<TD WIDTH="12%" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Report Type</TD>
			<TD BGCOLOR="#EAEAEA" width="12%">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
			<TD>
		<SELECT NAME="report_type" id ="source" SIZE="1" style="width:140px;" >';
		
                                if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']=='report3'){
                                 echo '<OPTION VALUE="report3" SELECTED>Summary Report</OPTION><OPTION VALUE="report2">Main Report</OPTION><OPTION VALUE="report1">Detailed Report</OPTION>';
                                }elseif(isset($_REQUEST['report_type']) && $_REQUEST['report_type']=='report1'){
                                 echo '<OPTION VALUE="report3">Summary Report</OPTION><OPTION VALUE="report2">Main Report</OPTION><OPTION VALUE="report1" SELECTED>Detailed Report</OPTION>';
                               }else{
                                  echo '<OPTION VALUE="report3">Summary Report</OPTION><OPTION VALUE="report2" SELECTED>Main Report</OPTION><OPTION VALUE="report1">Detailed Report</OPTION>';
                               }
               echo '</TD>
		</TR>
		</TABLE>
		</TD>
	</TR>
	
	<TR><td HEIGHT="25px" bgcolor="#CCCCFF" style="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;&nbsp;Source</td><td BGCOLOR="#F4F4F4"><SELECT NAME="sourceid" id ="sourceid" SIZE="1" style="width:150px;" >';
$sourceid=array('DIRECT','INTENT','FENQ');
echo '<OPTION VALUE="all">All</OPTION">';
                        foreach($sourceid as $x)
                        {
                                echo '<OPTION VALUE="'.$x.'"';
                                if (isset($_REQUEST['sourceid'])  && $_REQUEST['sourceid'] == $x) 
                                {
                                       echo ' SELECTED ';
                                }
                                echo '>'.$x.'</OPTION">';
                        }
                        
                        
echo '</select></TD><td bgcolor="#CCCCFF" style="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;&nbsp;Pool</td><td BGCOLOR="#F4F4F4"><SELECT NAME="poolid" id ="poolid" SIZE="1" style="width:150px;" >';
$poolid=array('Must Call','DNC','Service','Foreign','Intent','Procmart');
echo '<OPTION VALUE="all">All</OPTION">';
                        foreach($poolid as $x)
                        {
                                echo '<OPTION VALUE="'.$x.'"';
                                if (isset($_REQUEST['poolid'])  && $_REQUEST['poolid'] == $x) 
                                {
                                       echo ' SELECTED ';
                                }
                                echo '>'.$x.'</OPTION">';
                        }
                                           
echo '</select></TD><TD colspan=4 BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
<input type="hidden" name="action" value="get_lead_quality_rpt">
<INPUT TYPE="SUBMIT" id="Submit1" NAME="Submit1" VALUE="Generate Report">
</TD>
	</TR></TABLE>';
         if($mesg)
	      {
		      echo  $mesg;
	      }
	echo '</FORM>
	</body>
	</html>';

			

                
		




?>