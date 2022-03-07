<?php

$end_date=isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : ''; 

if($end_date == '')
{
$today_date=date('d-M-y', strtotime(date("d-M-Y")));

$tempArray=explode('-',$today_date);
$day=$tempArray[0];
if($day<10)
$day="$day";
$month=$tempArray[1];
$year=$tempArray[2];
$year=$year+2000;
$today_date="$day-$month-$year";
$end_date=$today_date;
}
$end_date=strtoupper($end_date);

$start_date=isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : ''; 
if($start_date == '')
{
$today_date=date('d-M-y', strtotime(date("d-M-Y")));

$tempArray=explode('-',$today_date);
$day=$tempArray[0];
if($day<10)
$day="$day";
$month=$tempArray[1];
$year=$tempArray[2];
$year=$year+2000;
$today_date="$day-$month-$year";
$start_date=$today_date;
}
$start_date=strtoupper($start_date);


$this->pageTitle = Yii::app()->name . ' - BL Gen Process';
echo '<html>
     <head><LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
      <script language="javascript" src="/js/calendar.js"></script>';
if(isset($_REQUEST['modid']) && $_REQUEST['modid'] != 'SAAP')
	    {  
 echo ' <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-28761981-2\']);
  _gaq.push([\'_setDomainName\', \'.intermesh.net\']);
  _gaq.push([\'_setSiteSpeedSampleRate\', 10]);
  _gaq.push([\'_trackPageview\',\'' . $_SERVER['REQUEST_URI'] . '\']);
  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();  
</script>


';




}

echo "
<script>
function ShowDemandData(req,rtype)
{
     
		var count=req+6;
		var xmlHttp=ajaxFunction();                
		var obj='';
		var start_date=\"$start_date\";
		var end_date=\"$end_date\";
                    
                        var str='';
                        if(rtype == 'SAAB'){
                            obj='demand_data'+count;
                            document.getElementById('show_data'+count).style.display = \"none\";
                            str='index.php?r=admin_bl/Regular_buyer_alert/Demanddata/account/2/report/SAAB/req/'+req+'/start_date/'+start_date+'/end_date/'+end_date;
                        }else if(rtype == 'REAC2'){
                            document.getElementById('show_data6').style.display = \"none\";
                            obj='demand_data6';
                            str='index.php?r=admin_bl/Regular_buyer_alert/Demanddata/account/2/report/REACT/sendgrid/yes/start_date/'+start_date+'/end_date/'+end_date;
                        }else if(rtype == 'REAC1'){
                            document.getElementById('show_data5').style.display = \"none\";
                            obj='demand_data5';
                            str='index.php?r=admin_bl/Regular_buyer_alert/Demanddata/account/2/report/REACT/sendgrid/no/start_date/'+start_date+'/end_date/'+end_date;
                        }else if(rtype == 'REM2'){
                            document.getElementById('show_data4').style.display = \"none\";
                            obj='demand_data4';
                            str='index.php?r=admin_bl/Regular_buyer_alert/Demanddata/account/2/report/REM/sendgrid/yes/start_date/'+start_date+'/end_date/'+end_date;
                        }else if(rtype == 'REM1'){
                            document.getElementById('show_data3').style.display = \"none\";
                            obj='demand_data3';
                            str='index.php?r=admin_bl/Regular_buyer_alert/Demanddata/account/2/report/REM/req/1/sendgrid/no/start_date/'+start_date+'/end_date/'+end_date;
                        }else if(rtype == 'REM3'){
                            document.getElementById('show_data11').style.display = \"none\";
                            obj='demand_data11';
                            str='index.php?r=admin_bl/Regular_buyer_alert/Demanddata/account/2/report/REM/req/2/sendgrid/no/start_date/'+start_date+'/end_date/'+end_date;
                        }else if(rtype == 'REG2'){
                            document.getElementById('show_data2').style.display = \"none\";
                            obj='demand_data2';
                            str='index.php?r=admin_bl/Regular_buyer_alert/Demanddata/account/2/report/NOR/start_date/'+start_date+'/end_date/'+end_date;
                        }else if(rtype == 'REG1'){
                            document.getElementById('show_data1').style.display = \"none\";
                            obj='demand_data1';
                            str='index.php?r=admin_bl/Regular_buyer_alert/Demanddata/account/1/report/NOR/start_date/'+start_date+'/end_date/'+end_date;
                        }

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


     echo '</head>
     <body><div align="right" STYLE="padding-right:20px;font-family:arial;font-size:12px;"><a href="index.php?r=admin_bl/Bl_intent_testing/Index&mid=3471" target="_blank">Intent Testing Screen</a></div>
	<FORM name="searchForm" METHOD="post" ACTION="/index.php?r=admin_bl/Regular_buyer_alert/Index&mid=3471" STYLE="margin-top:0;margin-bottom:0;" >
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
	<TR>
		
		<TD bgcolor="#dff8ff" ALIGN="CENTER" colspan="2"><font COLOR =" #333399"><b>Generation Report</b></font></TD>
		
	</TR>
	
	<TR>
		<TD WIDTH="150" HEIGHT="30">&nbsp;Select Period</TD>	
		<TD>From:
		<input name="start_date" type="text" VALUE="'.$start_date.'" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.searchForm.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="start_date" TYPE="text" readonly="readonly">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        To:
		<input name="end_date" type="text" VALUE="'.$end_date.'" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.searchForm.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="end_date" TYPE="text" readonly="readonly">
		
		</TD>
		
		</TR>';
		
echo '<TR>
	<TD>&nbsp;Report Type</TD>
        <TD>
        <TABLE width="60%" BORDER="0" CELLPADDING="1" CELLSPACING="0">
          <TR>';

echo '<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="NOR" ';
if (!isset($_REQUEST['action']) || (isset($_REQUEST['modid']) && $_REQUEST['modid'] == 'NOR')) {
    echo 'CHECKED';
}
echo '></TD>
		<TD STYLE="font-family:arial;font-size:12px;">Regular Buyer Alert&nbsp;&nbsp;</TD>
		<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="REM" ';

if (isset($_REQUEST['modid']) && $_REQUEST['modid'] == 'REM') {
    echo 'CHECKED';
}

echo '></TD>
		<TD STYLE="font-family:arial;font-size:12px;">Buyer Remarketing&nbsp;&nbsp;</TD>';
echo '<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="REACT" ';
if (isset($_REQUEST['modid']) && $_REQUEST['modid'] == 'REACT') {
    echo 'CHECKED';
}
echo '></TD>
		<TD STYLE="font-family:arial;font-size:12px;">Reactivation Report&nbsp;&nbsp;</TD>';

echo '<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="SAAP" ';
if (isset($_REQUEST['modid']) && $_REQUEST['modid'] == 'SAAP') {
    echo 'CHECKED';
}
echo '></TD>
		<TD STYLE="font-family:arial;font-size:12px;">SAAB Report&nbsp;&nbsp;</TD>';
		
		
		echo '<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="INTENT" ';
if (isset($_REQUEST['modid']) && $_REQUEST['modid'] == 'INTENT') {
    echo 'CHECKED';
}
echo '></TD>
		<TD STYLE="font-family:arial;font-size:12px;">Intent Report&nbsp;&nbsp;</TD>
		</TR>';
echo '</TABLE></TD></TR>';

echo '<TR>
		<TD colspan="2" align="center">
		<input type="hidden" name="action" value="sellstatus">
		<INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report">
		</TD>
	</TR></table>
	</FORM><br>';


if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'sellstatus') {
    if (isset($_REQUEST['modid']) && $_REQUEST['modid'] == 'NOR') {
        $rec_enq = $rec3;         
         if($dbtype=='PG'){
               $rec_intent_gen=pg_fetch_array($sth_intent_gen);
               $rec_enq_app=pg_fetch_array($sth_enq_app);
               $rec_enq_sent_to_enq=pg_fetch_array($sth_enq_sent_to_enq);
               $rec_enq_gen=pg_fetch_array($sth_enq_gen);
               $rec_intent_app=pg_fetch_array($sth_intent_app);
               $rec_gen=pg_fetch_array($sth8);
               $rec_app=pg_fetch_array($sth7);
               
               $rec_intent_gen=array_change_key_case($rec_intent_gen, CASE_UPPER); 
               $rec_enq_app=array_change_key_case($rec_enq_app, CASE_UPPER);
               $rec_enq_sent_to_enq=array_change_key_case($rec_enq_sent_to_enq, CASE_UPPER);
               $rec_enq_gen=array_change_key_case($rec_enq_gen, CASE_UPPER);
               $rec_gen=array_change_key_case($rec_gen, CASE_UPPER);
               $rec_app=array_change_key_case($rec_app, CASE_UPPER);
               
         }else{
               $rec_intent_gen=oci_fetch_array($sth_intent_gen,OCI_BOTH);
               $rec_enq_app=oci_fetch_array($sth_enq_app,OCI_BOTH);
               $rec_enq_sent_to_enq=oci_fetch_array($sth_enq_sent_to_enq,OCI_BOTH);
               $rec_enq_gen=oci_fetch_array($sth_enq_gen,OCI_BOTH);
               $rec_intent_app=oci_fetch_array($sth_intent_app,OCI_BOTH);
               $rec_gen=oci_fetch_array($sth8,OCI_BOTH);
               $rec_app=oci_fetch_array($sth7,OCI_BOTH);
         }
             
        
        $intent_gen = !empty($rec_intent_gen['UNIQUE_SENT_TO_DIR_QUERY_FREE']) ? $rec_intent_gen['UNIQUE_SENT_TO_DIR_QUERY_FREE'] : 0;
        $enq_app = !empty($rec_enq_app['TOTAL_APPROVED']) ? $rec_enq_app['TOTAL_APPROVED'] : 0;    
        $enq_sent_to_fenq = !empty($rec_enq_sent_to_enq['TOTAL_SENT_TO_FENQ']) ? $rec_enq_sent_to_enq['TOTAL_SENT_TO_FENQ'] : 0;
        $enq_gen = !empty($rec_enq_gen['TOTAL_ENQUIRY']) ? $rec_enq_gen['TOTAL_ENQUIRY'] : 0;
        $intent_app = !empty($rec_intent_app['TOTAL_APPROVED']) ? $rec_intent_app['TOTAL_APPROVED'] : 0;
        $lead_gen = !empty($rec_gen['REG_GEN']) ? $rec_gen['REG_GEN'] : 0;
        $lead_app = !empty($rec_app['REG_APPROVED']) ? $rec_app['REG_APPROVED'] : 0;      



        $sent = 0;
        $delivered = 0;
        $unique_open = 0;
        $unique_click = 0;
        $spam = 0;
        $blocked = 0;
        $unsubscribed = 0;
        $invalid = 0;
        $bounced = 0;
        $tot_gen = $intent_gen + $enq_gen + $lead_gen ;
        $tot_app = $intent_app + $enq_app + $lead_app ;
        
        
        echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
			    <tbody>
                            <tr><td BGCOLOR="#dff8ff" ALIGN="LEFT"><b>Total Generated:</b></td><td BGCOLOR="#dff8ff">' . $tot_gen . '</td></tr>
                            
			    <tr><td><B>&nbsp;&nbsp;Intent Generated</B></td><td>' . $intent_gen . '</td></tr>
			    <tr><td><B>&nbsp;&nbsp;Enquiries Generated</B></td><td>' . $enq_gen . '</td></tr>
                             <tr><td><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enquiries Sent to Fenq</B></td><td>' . $enq_sent_to_fenq . '</td></tr>   
			    <tr><td><B>&nbsp;&nbsp;Lead Generated</B></td><td>' . $lead_gen . '</td></tr>
                                
			    
                                
			    <tr><td BGCOLOR="#dff8ff"><b>Total Approved:</b></td><td BGCOLOR="#dff8ff">' . $tot_app . '</td></tr>
			    <tr><td><B>&nbsp;&nbsp;Intent Approved</B></td><td>' . $intent_app . '</td></tr>
			    <tr><td><B>&nbsp;&nbsp;Enquiries Approved</B></td><td>' . $enq_app . '</td></tr>
			    <tr><td><B>&nbsp;&nbsp;Lead Approved</B></td><td>' . $lead_app . '</td></tr>
                         </table>';

        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

     

       echo '<table STYLE="font-family:arial;font-size:11px;" bordercolor="#bedaff" align="CENTER" border="1" width="70%" cellpadding="5" cellspacing="2">
            <tr><TD BGCOLOR="#dff8ff" align=center><B>Account: emailmrktg@indiamart.com<div id="show_data1">( <a href="javascript:void(0);" onclick="ShowDemandData(0,\'REG1\');" style="text-decoration:none;">Show Detail</a> )</div></B></TD></tr>
                 <tr><TD ><div id="demand_data1"></div></TD></tr></table>';
                 
          echo '<br><table STYLE="font-family:arial;font-size:11px;" bordercolor="#bedaff" align="CENTER" border="1" width="70%" cellpadding="5" cellspacing="2">
            <tr><TD align=center BGCOLOR="#dff8ff"><B>Account: marketing@indiamart.com<div id="show_data2">( <a href="javascript:void(0);" onclick="ShowDemandData(0,\'REG2\');" style="text-decoration:none;">Show Detail</a> )</div></B></TD></tr>
            <tr><TD ><div id="demand_data2"></div></TD></tr>';       
 
    }
    
    
    if (isset($_REQUEST['modid']) && $_REQUEST['modid'] == 'REACT') {
                              
                
                $rec_fenq_enq=$rec4;
                $rec_intent=$rec5;
                $rec_transaction=$rec6;
                $rec_unique_leads_solds=$rec7;
               if($dbtype=='PG'){
                    $rec_app_in=pg_fetch_array($sth_react_in);
                    $rec_app_foriegn=pg_fetch_array($sth_react_foriegn);
                    
                    $rec_app_in=array_change_key_case($rec_app_in, CASE_UPPER); 
                    $rec_app_foriegn=array_change_key_case($rec_app_foriegn, CASE_UPPER); 
               }else{
                   $rec_app_in=oci_fetch_array($sth_react_in,OCI_BOTH);
                   $rec_app_foriegn=oci_fetch_array($sth_react_foriegn,OCI_BOTH);
               } 
              
               $app_direct_enq_in=isset($rec_app_in['REACT_APPROVED']) ? $rec_app_in['REACT_APPROVED']: 0;
               
               $app_direct_enq_fr=isset($rec_app_foriegn['REACT_APPROVED']) ? $rec_app_foriegn['REACT_APPROVED']: 0;
               
               $app_direct_enq=$app_direct_enq_in+$app_direct_enq_fr;
       
        
        $gen_fenq_enq=!empty($rec_fenq_enq['TOTAL_ENQUIRY']) ? $rec_fenq_enq['TOTAL_ENQUIRY'] : 0;
        $gen_fenq_enq_in=!empty($rec_fenq_enq['INDIAN_ENQUIRY']) ? $rec_fenq_enq['INDIAN_ENQUIRY'] : 0;        
        $gen_fenq_enq_fr=!empty($rec_fenq_enq['FOREIGN_ENQUIRY']) ? $rec_fenq_enq['FOREIGN_ENQUIRY'] : 0;
        
        $gen_fenq_enq_sentto =!empty($rec_fenq_enq['TOTAL_SENT_TO_FENQ']) ? $rec_fenq_enq['TOTAL_SENT_TO_FENQ'] : 0;
        $gen_fenq_enq_sentto_in=!empty($rec_fenq_enq['INDIAN_SENT_TO_FENQ']) ? $rec_fenq_enq['INDIAN_SENT_TO_FENQ'] : 0;   
        $gen_fenq_enq_sentto_fr=!empty($rec_fenq_enq['FORIEGN_SENT_TO_FENQ']) ? $rec_fenq_enq['FORIEGN_SENT_TO_FENQ'] : 0;
        
        $app_fenq_enq_sentto =!empty($rec_fenq_enq['TOT_SENT_TO_FENQ_APPR']) ? $rec_fenq_enq['TOT_SENT_TO_FENQ_APPR'] : 0;
        $app_fenq_enq_sentto_in=!empty($rec_fenq_enq['INDIAN_SENT_TO_FENQ_APPR']) ? $rec_fenq_enq['INDIAN_SENT_TO_FENQ_APPR'] : 0;        
        $app_fenq_enq_sentto_fr=!empty($rec_fenq_enq['FORIEGN_SENT_TO_FENQ_APPR']) ? $rec_fenq_enq['FORIEGN_SENT_TO_FENQ_APPR'] : 0;
                
        
        
        $intent_gen = !empty($rec_intent['INTENT_GEN']) ? $rec_intent['INTENT_GEN'] : 0;
        $intent_gen_bl = !empty($rec_intent['INTENT_BL_GEN']) ? $rec_intent['INTENT_BL_GEN'] : 0;
        $intent_gen_unique = !empty($rec_intent['UNQ_INTENT_BL_GEN']) ? $rec_intent['UNQ_INTENT_BL_GEN'] : 0;
        $intent_app = !empty($rec_intent['INTENT_BL_APPR']) ? $rec_intent['INTENT_BL_APPR'] : 0;
        $intent_rej = !empty($rec_intent['INTENT_BL_REJ']) ? $rec_intent['INTENT_BL_REJ'] : 0;
        $intent_wait = !empty($rec_intent['INTENT_BL_WAIT']) ? $rec_intent['INTENT_BL_WAIT'] : 0;
        
        $transaction = !empty($rec_transaction['CNT']) ? $rec_transaction['CNT'] : 0;
        $unique_leads_solds = !empty($rec_unique_leads_solds['CNT']) ? $rec_unique_leads_solds['CNT'] : 0;

        $sent = 0;
        $delivered = 0;
        $unique_open = 0;
        $unique_click = 0;
        $spam = 0;
        $blocked = 0;
        $unsubscribed = 0;
        $invalid = 0;
        $bounced = 0;
        $tot_gen=0;
        $tot_app=0;
        $tot_subscribers=0;
$enq_gen=0;
              



$tot_approved=$app_direct_enq + $app_fenq_enq_sentto + $intent_app;                  




         echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
                              <tr><TD BGCOLOR="#dff8ff" colspan="2"><B>Unique Buyers<div id="show_data5">( <a href="javascript:void(0);" onclick="ShowDemandData(0,\'REAC1\');" style="text-decoration:none;">Show Detail</a> )</div></B></td></tr> 
                              <tr><TD colspan="2"><div id="demand_data5"></div></TD></tr>
                              <tr><TD BGCOLOR="#dff8ff"><B>Approved</B></td><td BGCOLOR="#dff8ff">' . $tot_approved . '</td></tr> 
                              
                             <tr><td><B>&nbsp;&nbsp;BL Approved</B></td><td>' . $app_direct_enq . '</td></tr>   
                             <tr><td><B>&nbsp;&nbsp;&nbsp;&nbsp;Indian</B></td><td>' . $app_direct_enq_in . '</td></tr>   
                             <tr><td><B>&nbsp;&nbsp;&nbsp;&nbsp;Foreign</B></td><td>' . $app_direct_enq_fr . '</td></tr>   
                             <tr><td><B>&nbsp;&nbsp;Enquiries Approved</B></td><td>' . $app_fenq_enq_sentto . '</td></tr>   
                             <tr><td><B>&nbsp;&nbsp;&nbsp;&nbsp;Indian</B></td><td>' . $app_fenq_enq_sentto_in . '</td></tr>   
                             <tr><td><B>&nbsp;&nbsp;&nbsp;&nbsp;Foreign</B></td><td>' . $app_fenq_enq_sentto_fr . '</td></tr>   
                             <tr><td><B>&nbsp;&nbsp;Intent Approved</B></td><td>' . $intent_app . '</td></tr>
                             <tr><TD BGCOLOR="#dff8ff"><B>Approved Lead Conversion</B></td><td BGCOLOR="#dff8ff"></td></tr>
                             <tr><TD><B>Lead Sold</B></td><td>' . $unique_leads_solds . '</td></tr>
                             <tr><TD><B>Total Transaction</B></td><td>' . $transaction . '</td></tr>';

 echo '<tr><TD BGCOLOR="#dff8ff" colspan="2"><B>Email Stats<div id="show_data6">( <a href="javascript:void(0);" onclick="ShowDemandData(0,\'REAC2\');" style="text-decoration:none;">Show Detail</a> )</div></B></TD></tr>
 <tr><TD colspan="2"><div id="demand_data6"></div></TD></tr>
 </table>';

       
    }


    if (isset($_REQUEST['modid']) && $_REQUEST['modid'] == 'REM') {
//print_r($rec1);echo '111';print_r($rec2);echo '222';print_r($rec3);echo '333';print_r($rec4);echo '444';print_r($rec5);echo '555';print_r($rec6);
        
            $Captured_for_Intent =$rec1['TOTAL'];           
            

            $TOTAL_INTENT=$rec2['TOTAL_INTENT'];
            $ENQUIRY_INTENT = $rec2['ENQUIRY_INTENT'];
            $SEARCH_INTENT = $rec2['SEARCH_INTENT'];
            $BROWSE_INTENT = $rec2['BROWSE_INTENT'];
            $CALL_INTENT = $rec2['CALL_INTENT'];
            $BL_INTENT = $rec2['BL_INTENT'];
            $BLFORM_INTENT = $rec2['BLFORM_INTENT'];
            $TOTAL_INTENT_APP = $rec2['APPROVED'];
            $tot_intent_gen=$rec2['GEN'];
         
            $ENQUIRY_INTENT_GEN = $rec2_1['ENQ_GEN'];
            $SEARCH_INTENT_GEN = $rec2_1['SEARCH_GEN'];
            $BROWSE_INTENT_GEN = $rec2_1['BROWSE_GEN'];
            $CALL_INTENT_GEN = $rec2_1['CALL_GEN'];
            $BL_INTENT_GEN = $rec2_1['BL_GEN'];
            $BLFORM_GEN=$rec2_1['BLFORM_GEN'];


            

           
            $ENQUIRY_INTENT_APP = $rec2_1['ENQ_APPROVED'];
            $SEARCH_INTENT_APP = $rec2_1['SEARCH_APPROVED'];
            $BROWSE_INTENT_APP = $rec2_1['BROWSE_APPROVED'];
            $CALL_INTENT_APP = $rec2_1['CALL_APPROVED'];
            $BL_INTENT_APP = $rec2_1['BL_APPROVED'];
             $BLFORM_APPROVED = $rec2_1['BLFORM_APPROVED'];
   
           
            $usr_pos_bl=$rec7['CNT'];
           
            $usr_pos_enq=$rec8['CNT'];
       
            echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
			    <tbody><tr><td bgcolor="#FEFCFF" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;" colspan="3"><b>Data Funnel</b></td></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;Users Posted BL only</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $usr_pos_bl . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;Users posted Enquiry only</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $usr_pos_enq . '</TD></tr>
			    
			    
			    
			    
                           <tr><td bgcolor="#FEFCFF" STYLE="font-family:arial;font-size:11px;"><b>Captured for Intent</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $Captured_for_Intent . '</TD></tr>

                            <tr><td bgcolor="#FEFCFF" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;"><b>Call Remarketing</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" ></TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;Total Intent Captured</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $TOTAL_INTENT . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;ENQUIRY_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $ENQUIRY_INTENT . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;CALL_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $CALL_INTENT . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BL_FORM_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $BLFORM_INTENT . '</TD></tr>
                            
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;SEARCH_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $SEARCH_INTENT . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BROWSE_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $BROWSE_INTENT . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BL_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $BL_INTENT . '</TD></tr>
                              
                             <tr><td bgcolor="#FEFCFF" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;"><b>Intent Generated</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $tot_intent_gen. '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;ENQUIRY_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $ENQUIRY_INTENT_GEN . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;CALL_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $CALL_INTENT_GEN . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BL_FORM_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $BLFORM_GEN . '</TD></tr>

<tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;SEARCH_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $SEARCH_INTENT_GEN . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BROWSE_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' .$BROWSE_INTENT_GEN . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BL_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $BL_INTENT_GEN . '</TD></tr>
                             

                            <tr><td bgcolor="#FEFCFF" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;"><b>Intent Approved</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $TOTAL_INTENT_APP . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;ENQUIRY_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $ENQUIRY_INTENT_APP . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;CALL_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $CALL_INTENT_APP . '</TD></tr>
                             <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BL_FORM_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $BLFORM_APPROVED. '</TD></tr>
                            
<tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;SEARCH_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $SEARCH_INTENT_APP . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BROWSE_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' .$BROWSE_INTENT_APP . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BL_INTENT</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $BL_INTENT_APP . '</TD></tr>
                             
                            <tr><td bgcolor="#FEFCFF" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;"><b>Email Re-marketing Summary<div id="show_data3">( <a href="javascript:void(0);" onclick="ShowDemandData(0,\'REM1\');" style="text-decoration:none;">Show Detail</a> )</div></b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" ></TD></tr>
                             <tr><TD colspan="2"><div id="demand_data3"></div></TD></tr>
                             <tr><td bgcolor="#FEFCFF" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;"><b>Total Transaction<div id="show_data11">( <a href="javascript:void(0);" onclick="ShowDemandData(0,\'REM3\');" style="text-decoration:none;">Show Detail</a> )</div></b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" ></TD></tr>
                             <tr><TD colspan="2"><div id="demand_data11"></div></TD></tr>
			    </tbody>
			    </table><hr style="color:#FEFCFF">
			    ';
        
        

        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        echo '<div>Category:Re1-MCAT<div id="show_data4">( <a href="javascript:void(0);" onclick="ShowDemandData(0,\'REM2\');" style="text-decoration:none;">Show Detail</a> )</div>
        <div id="demand_data4"></div>';
        echo '<br><hr style="color:#333399"><br>';
        echo '<TABLE>
			    <tbody><tr>
			    <td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;" colspan="3"><b>Activity log report :</b></td></tr>
			    </tbody>
			    </table><br><br>';

        echo '<a target="_blank" href="http://dev-m.indiamart.com/mreport/csl_searchlog.php">http://dev-m.indiamart.com/mreport/csl_searchlog.php</a><br><br><hr style="color:#EAEAEA">

</body>
</html>';
    }
    
    
if(isset($_REQUEST['modid']) && $_REQUEST['modid'] == 'INTENT')
	    {
    
	    
	$i=0;
	   
 echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
 <TR>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;</TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Captured</B></TD>	
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Generated</B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approved</B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approved %</B></TD>
	
 </TR>
 <TR>	
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total Intent</B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD></TR>';
 if($dbtype=='PG'){
	 while ($rec = pg_fetch_array($sth_intent))
	    {
               $rec=array_change_key_case($rec, CASE_UPPER); 
               $APP=isset($rec['APPROVED_INTENTS']) ? $rec['APPROVED_INTENTS'] : 0;
            }
    }else{
         oci_fetch_all($sth_intent,$rec);
    }
	   if(!empty($rec)){
	   foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
	   {
	   $APP=isset($rec['APPROVED_INTENTS'][$i]) ? $rec['APPROVED_INTENTS'][$i] : 0;
	   $GEN=isset($rec['GENERATED_INTENTS'][$i]) ? $rec['GENERATED_INTENTS'][$i] : 0;
	   if($GEN)
	   {
	   $APP_PER=($APP/$GEN)*100;
	   $APP_PER=round($APP_PER,2);
	   }
	   else
	   {
	   $APP_PER=0;
	   }
	echo '<TR>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_INTENTS'][$i].'</TD>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERATED_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
	</TR>';
	$i=$i+1;
	 
	 }
	 }
	 
	 echo '<TR>	
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Types</B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD></TR>
<TR>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Enquiry Intent</B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
	
 </TR>';
 
 $i=0;
 
  if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
	   {
	    $APP=isset($rec['APPROVED_ENQUIRY_INTENTS'][$i]) ? $rec['APPROVED_ENQUIRY_INTENTS'][$i] : 0;
	   $GEN=isset($rec['GENERTED_ENQUIRY_INTENTS'][$i]) ? $rec['GENERTED_ENQUIRY_INTENTS'][$i] : 0;
	   if($GEN)
	   {
	   $APP_PER=($APP/$GEN)*100;
	   $APP_PER=round($APP_PER,2);
	   }
	   else
	   {
	   $APP_PER=0;
	   }
	   if(isset($rec['CAPTURED_ENQUIRY_INTENTS'][$i]) && ($rec['CAPTURED_ENQUIRY_INTENTS'][$i] !=0))
	   {
	echo '<TR>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_ENQUIRY_INTENTS'][$i].'</TD>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_ENQUIRY_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_ENQUIRY_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
	</TR>';
	}
	$i=$i+1;
	 
	 }
	 }
 
  echo '
<TR>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Call Intent</B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
	
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
	   {
	    $APP=isset($rec['APPROVED_CALL_INTENTS'][$i]) ? $rec['APPROVED_CALL_INTENTS'][$i] : 0;
	   $GEN=isset($rec['GENERTED_CALL_INTENTS'][$i]) ? $rec['GENERTED_CALL_INTENTS'][$i] : 0;
	   if($GEN)
	   {
	   $APP_PER=($APP/$GEN)*100;
	   $APP_PER=round($APP_PER,2);
	   }
	   else
	   {
	   $APP_PER=0;
	   }
	   if(isset($rec['CAPTURED_CALL_INTENTS'][$i]) && ($rec['CAPTURED_CALL_INTENTS'][$i] !=0))
	   {
	echo '<TR>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_CALL_INTENTS'][$i].'</TD>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_CALL_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_CALL_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
	</TR>';
	}
	$i=$i+1;
	 
	 }
	 
	 }
 

	    

	    echo '
<TR>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>BL Form Intent</B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
	
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
	   {
	   $APP=isset($rec['APPROVED_BLFORM_INTENTS'][$i]) ? $rec['APPROVED_BLFORM_INTENTS'][$i] : 0;
	   $GEN=isset($rec['GENERTED_BLFORM_INTENTS'][$i]) ? $rec['GENERTED_BLFORM_INTENTS'][$i] : 0;
	   if($GEN)
	   {
	   $APP_PER=($APP/$GEN)*100;
	   $APP_PER=round($APP_PER,2);
	   }
	   else
	   {
	   $APP_PER=0;
	   }
	   if(isset($rec['CAPTURED_BLFORM_INTENTS'][$i]) && ($rec['CAPTURED_BLFORM_INTENTS'][$i] !=0))
	   {
	echo '<TR>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_BLFORM_INTENTS'][$i].'</TD>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_BLFORM_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_BLFORM_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
	</TR>';
	}
	$i=$i+1;
	 
	 }
	 }
	 
	     echo '
<TR>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Search Intent</B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
	
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
	   {
	    $APP=isset($rec['APPROVED_SEARCH_INTENTS'][$i]) ? $rec['APPROVED_SEARCH_INTENTS'][$i] : 0;
	   $GEN=isset($rec['GENERTED_SEARCH_INTENTS'][$i]) ? $rec['GENERTED_SEARCH_INTENTS'][$i] : 0;
	   if($GEN)
	   {
	   $APP_PER=($APP/$GEN)*100;
	   $APP_PER=round($APP_PER,2);
	   }
	   else
	   {
	   $APP_PER=0;
	   }
	    if(isset($rec['CAPTURED_SEARCH_INTENTS'][$i]) && ($rec['CAPTURED_SEARCH_INTENTS'][$i] !=0))
	   {
	echo '<TR>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_SEARCH_INTENTS'][$i].'</TD>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_SEARCH_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_SEARCH_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
	</TR>';
	}
	$i=$i+1;
	 
	 }
	 }
    echo '
<TR>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Browse Intent</B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
	
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
	   {
	    $APP=isset($rec['APPROVED_BROWSE_INTENTS'][$i]) ? $rec['APPROVED_BROWSE_INTENTS'][$i] : 0;
	   $GEN=isset($rec['GENERTED_BROWSE_INTENTS'][$i]) ? $rec['GENERTED_BROWSE_INTENTS'][$i] : 0;
	   if($GEN)
	   {
	   $APP_PER=($APP/$GEN)*100;
	   $APP_PER=round($APP_PER,2);
	   }
	   else
	   {
	   $APP_PER=0;
	   }
	   if(isset($rec['CAPTURED_BROWSE_INTENTS'][$i]) && ($rec['CAPTURED_BROWSE_INTENTS'][$i] !=0))
	   {
	echo '<TR>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_BROWSE_INTENTS'][$i].'</TD>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_BROWSE_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_BROWSE_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
	</TR>';
	}
	$i=$i+1;
	 
	 }
	 }
	  echo '
<TR>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>BL Intent</B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
	
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
	   {
	   $APP=isset($rec['APPROVED_BL_INTENTS'][$i]) ? $rec['APPROVED_BL_INTENTS'][$i] : 0;
	   $GEN=isset($rec['GENERTED_BL_INTENTS'][$i]) ? $rec['GENERTED_BL_INTENTS'][$i] : 0;
	   if($GEN)
	   {
	   $APP_PER=($APP/$GEN)*100;
	   $APP_PER=round($APP_PER,2);
	   }
	   else
	   {
	   $APP_PER=0;
	   }
	    if(isset($rec['CAPTURED_BL_INTENTS'][$i]) && ($rec['CAPTURED_BL_INTENTS'][$i] !=0))
	   {
	echo '<TR>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_BL_INTENTS'][$i].'</TD>	
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_BL_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_BL_INTENTS'][$i].'</TD>
		<TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
	</TR>';
	}
	$i=$i+1;
	 
	 }
	 }
        echo '</table>';
	}

  
  
  
  
}


    
?>