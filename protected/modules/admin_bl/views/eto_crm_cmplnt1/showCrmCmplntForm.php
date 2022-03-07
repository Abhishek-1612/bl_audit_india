<?php
$emp_name = isset($rec['GL_EMP_NAME']) ? $rec['GL_EMP_NAME'] : '';
$update_cnt = isset($rec['CNT_UPDATE']) ? $rec['CNT_UPDATE'] : '';
$close_cnt = isset($rec['CNT']) ? $rec['CNT'] : '';
$date = preg_replace('/\_/','\-',$date);
$offerID = '';
        if(isset($_REQUEST['offerID']))
        {
                $offerID = $_REQUEST['offerID'];
        }
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Wrong Buy Lead Complaint CRM</title>
<style type="text/css">
body {
        margin: 0px;
        font-family:arial;
        font-size:12px;
        }

.dark{background : #eefaff;     }
.wbg{background : #ffffff;      }
.fnt{font-size:12px;width:33%;height:15px;}
.tab-container{ background:#ffffff; width:98%; margin:0px auto; border:1px solid #80c0e5;}
.eb{ padding:0px 0px 0px 0px; margin:0px auto;width:100%; float:left;}
.data_off{display:none}
.data_on{display:block}
.nav{ float:left;width:100%; background:url(gifs/tab-bg.gif) repeat-x;}
.nav ul{ padding:0px; margin:0px;}
.nav ul li{ float:left; font-size:14px;list-style:none; font-weight:bold;}
.nav ul li a{ float:left; font-size:14px; color:#12569d; list-style:none; font-weight:bold;  height:30px; padding:0px 11px; border-left:1px solid #80c0e5; line-height:30px; text-decoration:none;}
.nav ul li a:hover{color:#000000; text-decoration:none;}
.nav ul li a.selected{ float:left;color:#bc0800; list-style:none; font-weight:bold; background:#ffffff; background-image:none; height:30px; padding:0px 11px;  line-height:30px; text-decoration:none;border-left:1px solid #80c0e5}

#dhtmltooltip{
position: absolute;
left: -300px;
width: 150px;
border: 1px solid #000000;
padding: 2px;
background-color: #fffed8;
visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}
/*** Add css 8march 2014 **************/
.acl{ padding-left:20px;line-height:20px;font-weight:bold;color:#333; font-size:13px;}
.acl a{ color:#0066CC; text-decoration:none; line-height:20px;}
.acl a:hover{ color:#ff0000; text-decoration:none;line-height:20px;}
.arr{vertical-align:top; font-size:15px;color:#666; font-weight:normal; }
.ctxt{border-left:solid 1px #ccc; padding-left:10px;line-height:20px;}
.ft13{ font-size:13px!important;color:#000099;}.ft134{ font-size:13px!important; color:#C52429;}
.mb{ margin-bottom:10px;}
.cldt{line-height:20px;}
.cl_num{background:#ffefef; padding:4px;color:#C52429; margin-top:5px; margin-right:6px;line-height:20px;}
.cl_num label{color:#C52429!important; font-weight:bold; margin-right:4px; line-height:18px;border-right:1px solid #ccc; padding-right:6px;}
.cl_num label:hover{color:#ff0000!important; font-weight:bold;}
ul.dt{ float:left; padding:0px; margin:0px;}ul.dt li{ float:left; list-style-type:none; margin:2px 4px 0 0px; font-size:12px; font-weight:bold; width:160px; color:#004365; text-align:left;}
.fb{font-weight:bold;}.mtb{ margin:6px 0;line-height:20px;}.pdl6{ padding-right:12px;}
.gct{color:#444;}
a.lct{ color:#0000ff; text-decoration:none;line-height:20px;}a.lct:hover{ color:#ff0000; text-decoration:underline;}
.acl1{ padding-top:5px;}
.smtxt{line-height:22px;color:#002175; font-size:13px;}
.smtxt1{line-height:20px;color:#002175; font-size:13px; padding-left:3px;}
.pdl4{ padding:0 4px;}.pdt6{padding-top:6px;}
.ttxt{color:#005097; font-weight:bold; font-size:14px;}
.nbtns{ background:#f2f2f2; font-size:13px; color:#000; margin:3px 0 0 0; border:1px solid #b3b3b3; font-weight:bold; line-height:20px; padding:3px 5px; cursor:pointer; border-radius:3px;}
.nbtns:hover{ background:#ffffff; color:#333;}
.crm_tips{line-height:18px;}
</style>
<script language="JavaScript" src="../admin_eto/eto-buy-sale-report.js"></script>
<script language="JavaScript" src="../admin_eto/eto-crm-cmplnt2.js?v=11"></script>
<script language="javascript" src="../admin_eto/ebuy.js"></script>
<script type="text/javascript" src="../admin_eto/jquery.min.js"></script>
<script type="text/javascript" src="../admin_eto/animatedcollapse.js"></script>
<script type="text/javascript">

function newPopup(url) {
    popupWindow = window.open(
        url,\'popUpWindow\',\'height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes\')

}
</script>
</head>
<body>
<div align="center" width="98%">
  <h2 style="font-family:arial; padding:15px 0px 0px 13px;margin:0px;font-size:20px; float:left; text-align:left; line-height:20px; color:#bc0800;">Wrong Buy Lead Complaint CRM <span style="font-size:12px;font-weight:normal; color:#000000;line-height:20px;">
 (<b>Agent Name:</b> '.$emp_name.'  <!-- |&nbsp;&nbsp;<b>Updated:</b>'. $update_cnt.' |&nbsp;&nbsp;<b>Closed:</b> '.$close_cnt.' -->) </span>
        </h2><span style="float:right;margin-right:13px;margin-top:5px"><img src="http://farm8.staticflickr.com/7102/6898466772_651419e510_m.jpg" width="200"></span>
    <br style="clear:both;"/><br />

    </div>
<div class="tab-container" id="left_tabs">
            <div class="nav" id="top_navigation">
                <ul>';
                
                 if(!($tabselect) || $tabselect == '1')
                {   
                     
                     echo '<li><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index" class="selected"  style="padding:0px 12px;" id="tab1" onclick="hideDiv(\'crmreport\');left_tab(1)">My Claimed</a></li>';
                 }
                else
                {     
                      
                      echo '<li><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index" style="padding:0px 16px;" id="tab1" onclick="hideDiv(\'crmreport\');left_tab(1)">My Claimed</a></li>';
               }
		if($tabselect == '9')
		{
                    echo '<li><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index&tabselect=9" class="selected"  style="padding:0px 12px;" id="tab9" onclick="hideDiv(\'crmreport\');left_tab(9)">My Claimed (Partial Closed)</a></li>';

		}
		else
		{
                        echo '<li><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index&tabselect=9" style="padding:0px 16px;" id="tab9" onclick="hideDiv(\'crmreport\');left_tab(9)">My Claimed (Partial Closed)</a></li>';
		}
                if($tabselect == '2')
                {
                    echo '<li><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index&tabselect=2" id="tab2" class="selected" onclick="left_tab(2);hideDiv(\'crmreport\')">All Unclaimed</a></li>';
                }
                else
                {
                        echo '<li><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index&tabselect=2" id="tab2" onclick="left_tab(2);hideDiv(\'crmreport\')">All Unclaimed</a></li>';
                }
                if($tabselect == '3')
                {

                    echo '<li><a href="javascript:left_tab(3)" id="tab3" class="selected" onclick="hideDiv(\'crmreport\');javascript:document.getElementById(\'glusrID\').value=\'\'">Search</a></li>';
                
                }
                else
                {
                       echo '<li><a href="javascript:left_tab(3)" id="tab3" onclick="hideDiv(\'crmreport\');javascript:document.getElementById(\'glusrID\').value=\'\'">Search</a></li>';
                }
                if($tabselect == '4')
                {
                   echo '<li><a href="javascript:left_tab(4)" id="tab4" class="selected" onclick="hideDiv(\'crmreport\')">By Date</a></li>';
                }
                else
                {
                     echo '<li><a href="javascript:left_tab(4)" id="tab4" onclick="hideDiv(\'crmreport\')">By Date</a></li>';
                }
                if($tabselect == '5')
                {
                  echo '<li><a href="javascript:left_tab(5)" id="tab5" class="selected" onclick="hideDiv(\'crmreport\')">Not Updated In Last 3 Days </a></li>';
                }
                else
                {
                        echo '<li><a href="javascript:left_tab(5)" id="tab5" onclick="hideDiv(\'crmreport\')">Not Updated In Last 3 Days </a></li>';
                }
                if($tabselect == '6')
                {
                   echo '<li><a href="javascript:left_tab(6)" id="tab6" class="selected" onclick="hideDiv(\'crmreport\')">MIS</a></li>';
                }
                else
                {
                     echo '<li><a href="javascript:left_tab(6)" id="tab6"  onclick="hideDiv(\'crmreport\')">MIS</a></li>';
                }
                if($tabselect == '7')
                {
                   echo '<li><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index&glusr_submit=Find&tabselect=7" id="tab7" class="selected" onclick="left_tab(7);hideDiv(\'crmreport\');javascript:document.getElementById(\'glusrID\').value=\'\'">QC / Review</a></li>';
                }
                else
                {
                        echo '<li><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index&glusr_submit=Find&tabselect=7" id="tab7"  onclick="left_tab(7);hideDiv(\'crmreport\');javascript:document.getElementById(\'glusrID\').value=\'\'">QC / Review</a></li>';
                }
      echo '</ul>

  </div>';
if(!($tabselect))
{
        echo '<div class="eb data_on" id="data1">';
}
else
{
        echo '<div class="eb data_off" id="data1">';
}
echo '
		<style>
		.dark{
		background : #eefaff;
		}
		.fnt
		{
		font-size:12px;
		width:33%;
		height:15px;
		}
		</style>
                <br><table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
		<tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">';
		if($root)
		{
			echo '<td style="width:2%;padding:4px;">Sl.No</td>
			<td style="width:10%;padding:4px;">Glusr ID</td>
			<td style="width:34%;padding:4px;">Company Name</td>
			<td style="width:12%;padding:4px;">No. Of Complaints</td>
			<td style="width:10%;padding:4px;">Claimed By</td>
			<td style="width:10%;padding:4px;">Complained On (Min)</td>
			<td style="width:10%;padding:4px;">Last Updated On</td>
			<td style="width:10%;padding:4px;">Partial Closure Status</td>
			
			</tr>';
		}
		else
		{
			echo '<td style="width:2%;padding:4px;">Sl.No</td>
			<td style="width:10%;padding:4px;">Glusr ID</td>
			<td style="width:43%;padding:4px;">Company Name</td>
			<td style="width:15%;padding:4px;">No. Of Complaints</td>
			<td style="width:10%;padding:4px;">Complained On (Min)</td>
			<td style="width:10%;padding:4px;">Last Updated On</td>
			<td style="width:10%;padding:4px;">Partial Closure Status</td>
			</tr>';
		}
		
        $cnt = 0;
	while($rec =oci_fetch_assoc($sth1))
	{
// warn qq~1:::Tab: $tabselect || Part Close: $rec->{'ETO_BL_CMPLNT_PARTIAL_CLOSE'}~;
     
		if($tabselect == 9 && $rec['ETO_BL_CMPLNT_PARTIAL_CLOSE'] == -1)
		{
			continue;
		}
// warn qq~2:::Tab: $tabselect || Part Close: $rec->{'ETO_BL_CMPLNT_PARTIAL_CLOSE'}~;
                $cnt++;
		$htmlclass = '';
		if($cnt % 2 == 0 )
		{
	             echo '<tr class="dark fnt">';
		}
		else
		{
		  echo '<tr class="fnt wbg">';
		}
	echo '
		<td style="padding:4px;">'.$cnt.'</td>
		<td style="padding:4px;"><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index&glusrID='.$rec['GLUSR_ID'].'&glusr_submit=Submit&tabselect=1">'.$rec['GLUSR_ID'].'</a></td>
		<td style="padding:4px;">'.$rec['COMPANY'].'</td>
		<td style="padding:4px;">'.$rec['CNT'].'</td>';
		if($root)
		{
		     echo '<td style="padding:4px;">'.$rec['EMP_NAME'].'</td>';
		}
		
		echo '<td style="padding:4px;">'.$rec['ETO_BL_CMPLNT_ON'].'</td>
		<td style="padding:4px;">'.$rec['LAST_UPDATED_ON'].'</td>
		<td style="padding:4px;">';

		if($rec['ETO_BL_CMPLNT_PARTIAL_CLOSE'] == 1)
		{
			echo 'Partially Closed in GL Admin<br>Still opened in WebErp';
		}
		if($rec['ETO_BL_CMPLNT_PARTIAL_CLOSE'] == 2)
		{
			echo 'Partially Closed in GL Admin<br>Closed in WebErp';
		}
		echo '</td>
		</tr>';
	}
	if($cnt == 0)
	{
		echo '<tr class="wbg"><td colspan="7" style="padding:4px;"><div align="center" style="width:98% ; border:grey solid 1px;padding:4px;margin:4px;"><font color="red">No Pending Claimed Complaints Found</font></div></td><tr>';
	}
	echo '</table><br><br><br>';
	
	echo '</div>';
	
	if($tabselect == '2')
	  {
		  echo '<div class="eb data_on" id="data2">';
// 		  PBL_Mark_Cmplnt->showGlusrList($dbh);
                 echo '
		<style>
		.dark{
		background : #eefaff;
		}
		.fnt
		{
		font-size:12px;
		width:33%;
		height:15px;
		}
		</style>
		<br><table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
		<tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">
		<td style="width:2%;padding:4px;">Sl.No</td>
		<td style="width:10%;padding:4px;">Glusr ID</td>
		<td style="width:15%;padding:4px;">History</td>
		<td style="width:40%;padding:4px;">Company Name</td>
		<td style="width:10%;padding:4px;">Complained On</td>
		<td style="width:10%;padding:4px;">No. Of Complaints</td>
		<td style="width:13%;padding:4px;">Claim Complaint</td>
		</tr>';
		
		echo $html;
		echo '</table><br><br><br>';
		  echo '</div>';
	  }
	  
	  if($tabselect == '3')
	  {
		  echo '<div class="eb data_on" id="data3">';
	  }
	  else
	  {
		  echo '<div class="eb data_off" id="data3">';
	  }
echo '<br><table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">
<td colspan=\'3\' style="padding:4px;">&nbsp;Search</td>
</tr>
  <tr>
    <td class="admintext1" style="padding-left: 8px; padding-top: 8px;" bgcolor="#eefaff" valign="top" width="47%">
        <form name="cmplnt_form_glusrid" action="/index.php?r=admin_bl/Eto_crm_cmplnt/Index" method="POST">
        <strong>Gl User ID :</strong>&nbsp;</span>
<input id="glusrID" name="glusrID" size="10" maxlength="10" type="TEXT" value="'.$glusrID.'">
<strong>&nbsp;
        Email : </strong>
<input id="glusr_email" name="glusr_email" type="text" value="'.$glusr_email.'">
<input type="hidden" value="3" name="tabselect" id="tabselect"/>
<input name="glusr_submit" value="Submit" style="margin-top: 10px; margin-bottom: 10px;" type="SUBMIT">
        <br>
<font color="red">'.$errMsg.'</font>
        </form>
        </td>
    <td class="admintext1" align="left" style="padding-left: 8px; padding-top: 8px;" bgcolor="#eefaff" valign="top" width="28%"> <form method="POST" action="/index.php?r=admin_bl/Eto_crm_cmplnt/Index"><strong>WebERP Complaint ID:</strong>
            <input name="cmplntID" id="cmplntID" style="width: 80px; margin-top: 5px;" type="TEXT" value="'.$cmplntID.'">

                <input type="hidden" value="3" name="tabselect" id="tabselect"/>
            <input name="glusr_submit" value="Search" style="margin: 10px 0px;" type="SUBMIT"/>
        
</form></td>
<td class="admintext1" style="padding-left: 8px; padding-top: 8px;" bgcolor="#eefaff" valign="top" width="25%">
<form name="offerSearch" id="offerSearch" action="/index.php?r=admin_bl/Eto_crm_cmplnt/Index" method="POST">
        <strong>Offer ID: </strong>
        <input type="text" id="offerID" name="offerID" value="'.$offerID.'" size="10" maxlength="10"/>
        <input type="hidden" value="3" name="tabselect" id="tabselect"/>
        <input name="glusr_submit" value="Search Offer" style="margin-top: 10px; margin-bottom: 10px;" type="SUBMIT">
</form>
</td>
  </tr>
</table>
</div>';

if($tabselect == '4')
{
        echo '<div class="eb data_on" id="data4">';
}
else
{
        echo '<div class="eb data_off" id="data4">';
}
echo '<br><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">
<td style="padding:4px;">&nbsp;Date Wise [No. Of Complaints - Unique Gluser]</td>
</tr>
 <tr>
            <td class="admintext1" style="padding-left: 8px; padding-top: 8px;" bgcolor="#eefaff" valign="top"><form name="cmplnt_form_date" action="/index.php?r=admin_bl/Eto_crm_cmplnt/Index" method="POST">
        <div id="cmplnt_date">
        <ul class="dt">';
        
         while ($rec = oci_fetch_assoc($sth))
        {
                if($rec['ETO_BL_CMPLNT_ON'] == $date)
                {
                        echo '<li><INPUT TYPE=\'RADIO\' NAME=\'cmplnt_date\' value="'.$rec['ETO_BL_CMPLNT_ON'].'" onclick="showGlusrOnDate(this.value);" checked/>'.$rec['ETO_BL_CMPLNT_ON'].' ['.$rec['CMPLNT_CNT'].' - '.$rec['GLUSR_CNT'].'] </li>';
                }
                else
                {
                        echo '<li><INPUT TYPE=\'RADIO\' NAME=\'cmplnt_date\' value="'.$rec['ETO_BL_CMPLNT_ON'].'" onclick="showGlusrOnDate(this.value);"/>'.$rec['ETO_BL_CMPLNT_ON'].' ['.$rec['CMPLNT_CNT'].' - '.$rec['GLUSR_CNT'].'] </li>';
                }
        }
   echo '</ul></div>
        <div id="cmplnt_glusr_date">&nbsp;&nbsp;';
        echo '</div>
        </form></td>
      </tr>
</table>
</div>';

  echo '<div class="eb data_off" id="data5">';
  echo '
		<style>
		.dark{
		background : #eefaff;
		}
		.fnt
		{
		font-size:12px;
		width:33%;
		height:15px;
		}
		</style>
                <br><table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
		<tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">
		<td style="width:15%;padding:4px;">Glusr ID</td>
		<td style="width:55%;padding:4px;">Company Name</td>
		<td style="width:15%;padding:4px;">Claimed On/Last Update</td>
		<td style="width:`5%;padding:4px;">Claimed/Updated By</td>
		</tr>';
	$cnt = 0;
	
	while($rec = oci_fetch_assoc($sth3))
	{
		$cnt++;
		$htmlclass = '';
		if($cnt % 2 == 0 )
		{
			echo '
		<tr class="dark fnt">';
		}
		else
		{
			echo '
		<tr class="fnt wbg">';
		}
		echo '
		<td style="padding:4px;"><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index&glusrID='.$rec['GLUSR_ID'].'&glusr_submit=Submit&tabselect=5">'.$rec['GLUSR_ID'].'</a></td>
		<td style="padding:4px;">'.$rec['COMPANY'].'</td>
		<td style="padding:4px;">'.$rec['ETO_BL_CMPLNT_UPDATED_ON'].'</td>
		<td style="padding:4px;">'.$rec['GL_EMP_NAME'].'</td>
		</tr>';
	}
	if($cnt == 0)
	{
		echo '<tr class="wbg"><td colspan="4" style="padding:4px;"><div align="center" style="width:98% ; border:grey solid 1px;padding:4px;margin:4px;"><font color="red">Good, No > 3 Days Old Claimed Complained Found Pending</font></div></td><tr>';
	}
	echo '</table><br><br><br>';
	
	echo '</div>';
	
	if($tabselect == '6')
	  {
		  echo '<div class="eb data_on" id="data6">';
	  }
	  else
	  {
		  echo '<div class="eb data_off" id="data6">';
	  }
echo '<br>';
$mistabselect = 1;
$mistabselect = isset($_REQUEST['mistabselect']) ? $_REQUEST['mistabselect'] : 1;
echo <<<MSG
<script type="text/javascript">
	function makeDisable(divID)
	{
    		var x=document.getElementById(divID)
    		x.disabled=true
	}
	function makeEnable(divID)
	{
    		var x=document.getElementById(divID)
    		x.disabled=false
	}

        function mis_tab(id)
        {
                if(id==1 && document.getElementById('crmreport'))
                {
                        document.getElementById('crmreport').style.display='block';
                }
                else if(document.getElementById('crmreport'))
                {
                        document.getElementById('crmreport').style.display='none';
                }
		if(id==2 && document.getElementById('userwisereport'))
		{
			document.getElementById('userwisereport').style.display='block';
		}
		else if(document.getElementById('userwisereport'))
                {
                        document.getElementById('userwisereport').style.display='none';
                }
		if(id==3 && document.getElementById('leadwisereport'))
		{
			document.getElementById('leadwisereport').style.display='block';
		}
		else if(document.getElementById('leadwisereport'))
                {
                        document.getElementById('leadwisereport').style.display='none';
                }

		if(id==4 && document.getElementById('talkwisereport'))
		{
			document.getElementById('talkwisereport').style.display='block';
				
		}
		else if(document.getElementById('talkwisereport'))
                {
                        document.getElementById('talkwisereport').style.display='none';
			
                }
		if(id==4 && document.getElementById('talkcount'))
		{
			document.getElementById('talkcount').style.display='block';
			
		}
		else if(document.getElementById('talkcount'))
                {
                        document.getElementById('talkcount').style.display='none';
			
                }	
			
		if(id==4 && document.getElementById('emp-performance'))
		{
			document.getElementById('emp-performance').style.display='block';
			
		}
		else if(document.getElementById('emp-performance'))
                {
                        document.getElementById('emp-performance').style.display='none';
			
                }
                if(id==4 && document.getElementById('complain_detail'))
		{
			document.getElementById('complain_detail').style.display='block';
			
		}
		else if(document.getElementById('complain_detail'))
                {
                        document.getElementById('complain_detail').style.display='none';
			
                }	
		
        	var tabcontainer=document.getElementById('mispart').getElementsByTagName('div');
                for(var i=0; i < tabcontainer.length; i++)
                {	
                        if (tabcontainer[i].className== 'mis-ths')
                        {
                        tabcontainer[i].className= 'mis-th';
                        }
                        else if (tabcontainer[i].className=='mis-show-container')
                        {
                        tabcontainer[i].className='mis-hide-container';
                        }
                }
                document.getElementById('mis_tab'+id).className='mis-ths';
                document.getElementById('mis_data'+id).className='mis-show-container';
		document.getElementById('mistabselect').value=id;
        }
	function checkGlusr(Form)
	{
		if(Form.glusr_id.value == '')
		{
			alert("Kindly Enter Glusr ID");
			return false;
		}
		return true;
	}
	function checkleadwise(Form)
	{
		if(Form.buyer_id.value == '' && Form.display_id.value == '')
		{
			alert("Kindly Enter Buyer ID");
			return false;
		}
		return true;
	}

        function uncheck_radio(Form)
        {
            var radio_length = document.getElementsByName('radio1').length;
            var radio_length1 = document.getElementsByName('radio2').length;

            if(document.getElementById('emp_performance').checked == true)
            {
               for(var i=0;i<radio_length;i++)
                  { 
                     if(Form.radio1[i].checked == true)
                           {
                              Form.radio1[i].checked = false;
                           }
                  }
               for(var i=0;i<radio_length1;i++)
                  { 
                     if(Form.radio2[i].checked == true)
                           {
                              Form.radio2[i].checked = false;
                           }
                  }
            }
        }
         
        function uncheck_chkbox(Form)
        {
            if(document.getElementById('emp_performance').checked == true)
                  {
                     document.getElementById('emp_performance').checked = false;
                  }
        }	

        </script>

MSG;
	echo ' <style type="text/css">
	.mis_nav{line-height:22px;border-bottom:3px solid #60a5ec; float:left; width:99%; padding-right:10px; padding-left:4px;}
	.mis-th{font-family:arial;color:#12569d;float:left;padding:4px 8px 4px 8px; background:#dbeaff;border-top-left-radius: 3px;border-top-right-radius: 3px; margin-right:4px;font-size:14px;cursor:pointer;}
	.mis-ths{font-family:arial;font-size:14px;font-weight:bold;color:#fff; float:left; padding:4px 8px 4px 8px;cursor:pointer;background:#60a5ec;border-top-left-radius: 3px;border-top-right-radius: 3px; margin-right:4px;}
	.mis-show-container{padding:0px 0px 0px 0px; display:block;}
	.mis-hide-container{display:none;padding:0px 0px 4px 0px;}
	</style>';


	#start of html

	echo '<div id="mispart">
	<div class="mis_nav">';
	
	if($mistabselect == '1')
	{
	    echo '<div class="mis-ths" id="mis_tab1" onClick="mis_tab(1)">Summary</div>';
	}
	else
	{
	    echo '<div class="mis-th" id="mis_tab1" onClick="mis_tab(1)">Summary</div>';	
	}
	if($mistabselect == '2')
	{
	    echo '<div class="mis-ths" id="mis_tab2" onClick="mis_tab(2)">User Wise</div>';
	}
	else
	{
	    echo '<div class="mis-th" id="mis_tab2" onClick="mis_tab(2)">User Wise</div>';	
	}
	if($mistabselect == '3')
	{
	    echo '<div class="mis-ths" id="mis_tab3" onClick="mis_tab(3)">Lead Wise</div>';
	}
	else
	{
	    echo '<div class="mis-th" id="mis_tab3" onClick="mis_tab(3)">Lead Wise</div>';
	}
	if($mistabselect == '4')
	{
	    echo '<div class="mis-ths" id="mis_tab4" onClick="mis_tab(4)">Call Summary</div>';
	}
	else
	{
	    echo '<div class="mis-th" id="mis_tab4" onClick="mis_tab(4)">Call Summary</div>';
	}



	echo '</div>
	<br style="clear:both" />

	<!--Mis Part Start here -->';

	if($mistabselect == '1')
	{
	    echo '<div class="mis-show-container" id="mis_data1">';
	}
	else
	{
	    echo '<div class="mis-hide-container" id="mis_data1">';	
	}
		#activity radio button - with selection
	$activity = '';
	if(isset($_REQUEST['activity']))
	{
		$activity = $_REQUEST['activity'];
	}
	echo '
	<form name="mis_form" id="mis_form" method="post" action="/index.php?r=admin_bl/Eto_crm_cmplnt/Index">
	<table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="0" width="100%">
  	<tr>
    	<td class="admintext1" style="padding-left: 8px; padding-top: 8px;" bgcolor="#eefaff" valign="top" width="31%">
	<b>Activity </b>';
	if(!$activity || $activity == 'all')
	{
		echo '<input type="radio" name="activity" value="all" onclick="makeDisable(\'employee\');makeDisable(\'performance\');" checked /> Both';
	}
	else
	{
		echo '<input type="radio" name="activity" value="all" onclick="makeDisable(\'employee\');makeDisable(\'performance\');" /> Both';
	}
	
	if($activity == 'open')
	{
		echo '&nbsp;&nbsp;<input type="radio" name="activity" value="open" onclick="makeDisable(\'employee\');makeDisable(\'performance\');" checked  style="margin-left:8px;" /> Open Between';
	}
	else
	{
		echo '&nbsp;&nbsp;<input type="radio" name="activity" value="open" onclick="makeDisable(\'employee\');makeDisable(\'performance\');" style="margin-left:8px;" /> Open Between';
	}
	if($activity == 'closed')
	{
		echo '&nbsp;&nbsp;<input type="radio" name="activity" value="closed" checked  style="margin-left:8px;" onclick="makeEnable(\'employee\');makeEnable(\'performance\');"/> Closed Between';
	}
	else
	{
		echo '&nbsp;&nbsp;<input type="radio" name="activity" value="closed"  style="margin-left:8px;" onclick="makeEnable(\'employee\');makeEnable(\'performance\');"/> Closed Between';
	}
	echo '</td>
   	<td class="admintext1" align="left" style="padding-left: 8px; padding-top: 8px;" bgcolor="#eefaff" width="60%" valign="top"><table cellspacing="0" cellpadding="3" border="0">
		<tbody><tr>
        <td><b>Select Period</b></td>';
        list($curr_sec,$curr_min,$curr_hour,$curr_day,$curr_month,$curr_year) = localtime(time());
	$curr_month=$curr_month+1;

	if($curr_month < 10)
	{
		$curr_month='0'.$curr_month;
	}
	$curr_year = $curr_year + 1900;
	if(isset($_REQUEST['s_day']))
	{
		$curr_day = $_REQUEST['s_day'];
		$curr_month = $_REQUEST['s_month'];
		$curr_year = $_REQUEST['s_year'];
	}
	$months = array('01' => "January",
             '02' => "February",
	     '03' => "March",
	     '04' => "April",
	     '05' => "May",
	     '06' => "June",
	     '07' => "July",
	     '08' => "August",
	     '09' => "September",
	     '10' => "October",
	     '11' => "November",
	     '12' => "December");
       echo '<td><select size="1" name="s_day" id="s_day">';	
       foreach(range(1,31) as $day)
	{       
		if($day < 10)
		{ 
		$day = "0$day" ;
		}
		if($day == $curr_day)
		{
			echo '<option value="'.$day.'" selected>'.$day.'</option>';
		}
		else
		{
			echo '<option value="'.$day.'">'.$day.'</option>';
		}
	}
        echo '</select></td>';
	echo '<td><select size="1" name="s_month" id="s_month">';
	foreach(range(1,12) as $month)
	{       
	      if($month < 10)
		{
		$month = "0$month" ;
		}
		if($curr_month == $month)
		{
		echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
		}
		else
		{
		echo '<option value="'.$month.'">'.$months[$month].'</option>';
		}
	}
      echo '</select></td>';
      echo '<td><select size="1" name="s_year" id="s_year">';
      foreach(range(($curr_year-5),($curr_year+5)) as $year)
      {
	      if($curr_year == $year)
	      {
		      echo '<option value="'.$year.'" selected>'.$year.'</option>';
	      }
	      else
	      {
		      echo '<option value="'.$year.'">'.$year.'</option>';
	      }
      }
      
      echo '</select></td>';
      if(isset($_REQUEST['e_day']))
      {
	      $curr_day = $_REQUEST['e_day'];
	      $curr_month = $_REQUEST['e_month'];
	      $curr_year = $_REQUEST['e_year'];
      }
      echo '<td> to </td>';
      echo '<td><select size="1" name="e_day" id="e_day">';
      foreach(range(1,31) as $day)
      {       if($day < 10)
	      {
	      $day = "0$day" ;
	      }
	      if($day == $curr_day)
	      {
		echo '<option value="'.$day.'" selected>'.$day.'</option>';
	      }
	      else
	      {
		echo '<option value="'.$day.'">'.$day.'</option>';
	      }
      }
      echo '</select></td>';
      echo '<td><select size="1" name="e_month" id="e_month">';
      foreach(range(1,12) as $month)
      {       if($month < 10)
	      {
	      $month = "0$month";
	      }
	      if($curr_month == $month)
	      {
		      echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
	      }
	      else
	      {
		      echo '<option value="'.$month.'">'.$months[$month].'</option>';
	      }
      }
      echo '</select></td>';
      echo '<td><select size="1" name="e_year" id="e_year">';
      foreach(range(($curr_year-5),($curr_year+5)) as $year)
      {
	      if($curr_year == $year)
	      {
		      echo '<option value="'.$year.'" selected>'.$year.'</option>';
	      }
	      else
	      {
		      echo '<option value="'.$year.'">'.$year.'</option>';
	      }
      }
    echo '</select></td><td><div id="miscount"></div></td>';
    $employee = '';
    $employee = isset($_REQUEST['employee']) ? $_REQUEST['employee'] : 0;
    echo '</tr>
	</table> </td>
  	</tr>
  	<tr>
  	<td class="admintext1" colspan="2" align="left" style="padding-left: 8px; padding-top: 4px;" bgcolor="#eefaff" valign="top"><b>Employee</b>';
	if($activity == 'closed')
	{
		echo '<select style="margin-left:47px" name="employee" id="employee">';
	}
	else
	{
		echo '<select style="margin-left:47px" name="employee" id="employee" disabled>';
	}
	echo '<option value="0">All</option>';
	while($rec =oci_fetch_assoc($sth4))
	{
		if($employee == $rec['ETO_BL_CMPLNT_UPDATED_BY'])
		{
			echo '<option value="'.$rec['ETO_BL_CMPLNT_UPDATED_BY'].'" selected>'.$rec['GL_EMP_NAME'].'</option>';
		}
		else
		{
			echo '<option value="'.$rec['ETO_BL_CMPLNT_UPDATED_BY'].'">'.$rec['GL_EMP_NAME'].'</option>';
		}
	}
	echo '</select></td>
  	</tr>';
	$open_reason = '';
	$open_reason = isset($_REQUEST['open_reason']) ? $_REQUEST['open_reason'] : 0;
	echo '<td class="admintext1" colspan="2" align="left" style="padding-left: 8px; padding-top:4px;" bgcolor="#eefaff" valign="top"><b>Opening Reason</b><select  style="margin-left:12px" name="open_reason" id="open_reason">
	<option value="0">All</option>';
	while($rec = oci_fetch_assoc($sth5))
	{
		if($open_reason == $rec['ETO_BL_CMPLNT_REASON_ID'])
		{
			echo '<option value="'.$rec['ETO_BL_CMPLNT_REASON_ID'].'" selected>'.$rec['ETO_BL_CMPLNT_REASON_DESC'].'</option>';
		}
		else
		{
		       echo '<option value="'.$rec['ETO_BL_CMPLNT_REASON_ID'].'">'.$rec['ETO_BL_CMPLNT_REASON_DESC'].'</option>';
		}
	}
	echo '</select>';
	$close_reason = '';
	$close_reason = isset($_REQUEST['close_reason']) ? $_REQUEST['close_reason'] : 0;
	echo '</td>
  	</tr><tr>
   	<td class="admintext1" colspan="2" align="left" style="padding-left: 8px; padding-top: 4px;" bgcolor="#eefaff" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr>
    	<td width="45%"><b>Closing Reason &nbsp;&nbsp;&nbsp;</b> <select name="close_reason" id="close_reason">
	<option value="0" selected>All</option>';
	while($rec = oci_fetch_assoc($sth6))
	{
		if($close_reason == $rec['ETO_BL_CMPLNT_CRD_REV_ID'])
		{
			echo '<option value="'.$rec['ETO_BL_CMPLNT_CRD_REV_ID'].'" selected>'.$rec['ETO_BL_CMPLNT_CRD_REV_DESC'].'</option>';
		}
		else
		{
		       echo '<option value="'.$rec['ETO_BL_CMPLNT_CRD_REV_ID'].'">'.$rec['ETO_BL_CMPLNT_CRD_REV_DESC'].'</option>';
		}
	}
	echo '</select>';

	echo '
	</td>
    	<td width="38%">';
    	$report = '';
    	$report = isset($_REQUEST['report']) ? $_REQUEST['report'] : '';
    	if(!$report || $report == 'summary')
	{
		echo '<input type="radio" name="report"  value="summary" checked/> Summary';
	}
	else
	{
		echo '<input type="radio" name="report"  value="summary"/> Summary';
	}
	if($report == 'detailed')
	{
		echo '<input type="radio" name="report"  value="detailed" checked/> Detailed';
	}
	else
	{
		echo '<input type="radio" name="report"  value="detailed"/> Detailed';
	}
	if($activity == 'closed')
	{
		if($report == 'performance')
		{
			echo '<input type="radio" name="report" id="performance" value="performance" checked/> Employee Performance';
		}
		else
		{
			echo '<input type="radio" name="report" id="performance" value="performance"/> Employee Performance';
		}
	}
	else
	{
		echo '<input type="radio" name="report" id="performance" value="performance" disabled/> Employee Performance';
	}
	echo '</td>
    	<td align="left"><input type="hidden" value="6" id="tabselect" name="tabselect">
	<input type="hidden" value="1" id="mistabselect" name="mistabselect">
	<input type="Submit" name="glusr_submit" id="glusr_submit" value="Generate"></td>
  	</tr>
	</table>
	<br><br>
	</td>
  	</tr>
	</table>
	</form>

    	</div>

    	<!-- User wise part start here -->';

	if($mistabselect == '2')
	{
	    echo '<div class="mis-show-container" id="mis_data2">';
	}
	else
	{
	    echo '<div class="mis-hide-container" id="mis_data2">';	
	}

        echo '
	<form name="user_wise_form" id="user_wise_form" method="post" action="/index.php?r=admin_bl/Eto_crm_cmplnt/Index" onsubmit="return checkGlusr(document.user_wise_form);">

        <div style="background:#eefaff; padding:4px 0 4px 0;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
        <tr>
        <td width="24%" style="padding:8px 0 0 8px;"><b>Enter GLUSR ID</b> <input type="text" name="glusr_id" id="glusr_id" style="width:100px;" /></td>
        <td width="76%" style="padding:8px 0 0 8px;"><table border="0" cellpadding="3" cellspacing="0">
		<tbody><tr>
        <td width="12%"><b>Select Period</b></td>';
        list($curr_sec,$curr_min,$curr_hour,$curr_day,$curr_month,$curr_year) = localtime(time());
	$curr_month=$curr_month+1;

	if($curr_month < 10)
	{
		$curr_month='0'.$curr_month;
	}
	$curr_year = $curr_year + 1900;
	
	if(isset($_REQUEST['uw_s_month']))
		{			
			$curr_month = $_REQUEST['uw_s_month'];
			$curr_year = $_REQUEST['uw_s_year'];
		}
      echo '<td><select size="1" name="uw_s_month" id="uw_s_month">';
      foreach(range(1,12) as $month)
      {       
	    if($month < 10)
	      {
	      $month = "0$month" ;
	      }
	      if($curr_month == $month)
	      {
	      echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
	      }
	      else
	      {
	      echo '<option value="'.$month.'">'.$months[$month].'</option>';
	      }
      } 
      echo '</select></td>';

     echo '<td><select size="1" name="uw_s_year" id="uw_s_year">';
     foreach(range(($curr_year-5),($curr_year+5)) as $year)
      {
	      if($curr_year == $year)
	      {
		      echo '<option value="'.$year.'" selected>'.$year.'</option>';
	      }
	      else
	      {
		      echo '<option value="'.$year.'">'.$year.'</option>';
	      }
      }
      echo '</select></td>';
      if(isset($_REQUEST['uw_e_month']))
		{			
			$curr_month = $_REQUEST['uw_e_month'];
			$curr_year = $_REQUEST['uw_e_year'];
		}
     echo '<td> <b>To</b> </td>';
     echo '<td><select size="1" name="uw_e_month" id="uw_e_month">';
     foreach(range(1,12) as $month)
      {       
	    if($month < 10)
	      {
	      $month = "0$month" ;
	      }
	      if($curr_month == $month)
	      {
	      echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
	      }
	      else
	      {
	      echo '<option value="'.$month.'">'.$months[$month].'</option>';
	      }
      }
      echo '</select></td>';

     echo '<td><select size="1" name="uw_e_year" id="uw_e_year">';
     foreach(range(($curr_year-5),($curr_year+5)) as $year)
      {
	      if($curr_year == $year)
	      {
		      echo '<option value="'.$year.'" selected>'.$year.'</option>';
	      }
	      else
	      {
		      echo '<option value="'.$year.'">'.$year.'</option>';
	      }
      }
      echo '</select></td><td><div id="miscount"></div></td>';

     echo '<td width="300" align="left"><input type="hidden" value="6" id="tabselect" name="tabselect">
	<input type="hidden" value="2" id="mistabselect" name="mistabselect">
	<input name="glusr_submit" id="glusr_submit" value="Generate Report" style="font-size:13px; padding:2px 10px; font-weight:bold;  cursor:pointer;" type="Submit"></td><td style="float:right; color:#000000; font-weight:bold;font-size:12px;">[ Running From MESH ]</td></tr>
        </tbody></table></td>
        </tr>
        </table>
        </div>
        <br />
        <br />
        
        </form>
        </div>
        <!-- User wiser end here -->
        <!-- Lead wise part start here -->';
        if($mistabselect == '3')
	{
	    echo '<div class="mis-show-container" id="mis_data3">';
	}
	else
	{
	    echo '<div class="mis-hide-container" id="mis_data3">';	
	}

        echo '<br />
        <div style="text-align:center; font-weight:bold;">
		
	<form name="lead_wise_form" id="lead_wise_form" method="post" action="/index.php?r=admin_bl/Eto_crm_cmplnt/Index" onsubmit="return checkleadwise(document.lead_wise_form);">

        <div style="background:#eefaff; padding:4px 0 4px 0;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
        <tr>
        <td width="24%" style="padding:8px 0 0 8px;"><b>Enter LEAD ID</b> <input type="text" name="display_id" id="display_id" style="width:100px;" /></td>
	<td style="padding:8px 0 0 8px;">OR</td>
	<td width="20%" style="padding:8px 0 0 8px;"><b>Buyer GLID</b> <input type="text" style="width:100px;" id="buyer_id" name="buyer_id"></td>
        <td width="76%" style="padding:8px 0 0 8px;">
	<table border="0" cellpadding="3" cellspacing="0">
	<tbody>	
	<tr>
	<td width="300" align="left"><input type="hidden" value="6" id="tabselect" name="tabselect">
	<input type="hidden" value="3" id="mistabselect" name="mistabselect">
	<input name="glusr_submit" id="glusr_submit" value="Report" style="font-size:13px; padding:2px 10px; font-weight:bold;  cursor:pointer;" type="Submit"></td><td style="float:right; color:#000000; font-weight:bold;font-size:12px;">[ Running From MESH ]</td></tr>
        </tbody></table></td>
        </tr>	
        </table>
        </div>
        <br />
        <br />
        
        </form>
	</div>
        </div>
  <!-- Lead wiser end here -->';

# Talk wise starts here
	
	if($mistabselect == '4')
	{
	    echo '<div class="mis-show-container" id="mis_data4">';
	}
	else
	{
	    echo '<div class="mis-hide-container" id="mis_data4">';	
	}	


	echo '
	<form name="talk_wise_form" id="talk_wise_form" method="post" action="/index.php?r=admin_bl/Eto_crm_cmplnt/Index">
	<table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="0" width="100%">
  	<tr>
   	<td colspan="2" class="admintext1" align="left" style="padding-left: 8px; padding-top: 8px;" bgcolor="#eefaff" width="65%" valign="top"><table cellspacing="0" cellpadding="3" border="0">
	<tbody><tr>
        <td><b>Select Period</b></td>';
        list($curr_sec,$curr_min,$curr_hour,$curr_day,$curr_month,$curr_year) = localtime(time());
      $curr_month=$curr_month+1;

      if($curr_month < 10)
      {
	      $curr_month='0'.$curr_month;
      }
      $curr_year = $curr_year + 1900;

      if(isset($_REQUEST['s_day']))
		{
			$curr_day = $_REQUEST['s_day'];
			$curr_month = $_REQUEST['s_month'];
			$curr_year = $_REQUEST['s_year'];
		}
     
     $months = array('01' => "January",
             '02' => "February",
	     '03' => "March",
	     '04' => "April",
	     '05' => "May",
	     '06' => "June",
	     '07' => "July",
	     '08' => "August",
	     '09' => "September",
	     '10' => "October",
	     '11' => "November",
	     '12' => "December");

     echo '<td><select size="1" name="s_day" id="s_day">';
     foreach(range(1,31) as $day)
      {       
	      if($day < 10)
	      { 
	      $day = "0$day" ;
	      }
	      if($day == $curr_day)
	      {
		      echo '<option value="'.$day.'" selected>'.$day.'</option>';
	      }
	      else
	      {
		      echo '<option value="'.$day.'">'.$day.'</option>';
	      }
      }
      echo '</select></td>';
      echo '<td><select size="1" name="s_month" id="s_month">';
      foreach(range(1,12) as $month)
      {       
	    if($month < 10)
	      {
	      $month = "0$month" ;
	      }
	      if($curr_month == $month)
	      {
	      echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
	      }
	      else
	      {
	      echo '<option value="'.$month.'">'.$months[$month].'</option>';
	      }
      }
      echo '</select></td>';
      echo '<td><select size="1" name="s_year" id="s_year">';
      foreach(range(($curr_year-5),($curr_year+5)) as $year)
      {
	      if($curr_year == $year)
	      {
		      echo '<option value="'.$year.'" selected>'.$year.'</option>';
	      }
	      else
	      {
		      echo '<option value="'.$year.'">'.$year.'</option>';
	      }
      }
      echo '</select></td>';
      if(isset($_REQUEST['e_day']))
		{
			$curr_day = $_REQUEST['e_day'];
			$curr_month = $_REQUEST['e_month'];
			$curr_year = $_REQUEST['e_year'];
		}
      echo '<td> to </td>';
       echo '<td><select size="1" name="e_day" id="e_day">';
       foreach(range(1,31) as $day)
	{       if($day < 10)
		{
		$day = "0$day" ;
		}
		if($day == $curr_day)
		{
		  echo '<option value="'.$day.'" selected>'.$day.'</option>';
		}
		else
		{
		  echo '<option value="'.$day.'">'.$day.'</option>';
		}
	}
	echo '</select></td>';
	echo '<td><select size="1" name="e_month" id="e_month">';
	foreach(range(1,12) as $month)
	{       if($month < 10)
		{
		$month = "0$month";
		}
		if($curr_month == $month)
		{
			echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
		}
		else
		{
			echo '<option value="'.$month.'">'.$months[$month].'</option>';
		}
	}
	echo '</select></td>';
	echo '<td><select size="1" name="e_year" id="e_year">';
	foreach(range(($curr_year-5),($curr_year+5)) as $year)
	{
		if($curr_year == $year)
		{
			echo '<option value="'.$year.'" selected>'.$year.'</option>';
		}
		else
		{
			echo '<option value="'.$year.'">'.$year.'</option>';
		}
	}
        echo '</select></td><td style= "width:320px">';
        $performance = '';
        if(isset($_REQUEST['emp_performance']))
        {
        $performance = $_REQUEST['emp_performance'];
        }
        if($performance == 'emp_performance')
		{
			echo '<input type="checkbox" name="emp_performance" id="emp_ performance" value="emp_performance" checked onclick="uncheck_radio(document.talk_wise_form);"/>Employee Performance';
		}
		else
		{
			echo '<input type="checkbox" name="emp_performance" id="emp_performance" value="emp_performance" onclick="uncheck_radio(document.talk_wise_form);"/>Employee Performance';
		}

	echo '</tr>
        </tbody></table></td>
        </tr>
        <tr>
        <td class="admintext1" align="left" style="padding-left: 8px; padding-top: 8px;" bgcolor="#eefaff" width="65%" valign="top">';
         echo '<input type="radio" name="radio1" id="first_time_usr" value="first_time_usr" onclick="uncheck_chkbox();"'; 
         if( isset($_REQUEST['radio1']) && ($_REQUEST['radio1'] == 'first_time_usr'))
         {
         echo 'checked';
         }
         echo '/>&nbsp;First Time User Data&nbsp;&nbsp;&nbsp;&nbsp;';
         
         echo '<input type="radio" name="radio1" id="repeat_complainers" value="repeat_complainers" onclick="uncheck_chkbox();"';
         if(isset($_REQUEST['radio1']) && ($_REQUEST['radio1'] == 'repeat_complainers'))
         {
         echo 'checked';
         }
         echo '/>&nbsp;Repeat Complainers &nbsp;(';
      
               echo '<input type="radio" name="radio2" id="last_month" value="-1" onclick="uncheck_chkbox();"'; 
               if(isset($_REQUEST['radio2']) && ($_REQUEST['radio2'] == -1))
               {
               echo 'checked';
               }
               echo '/>&nbsp;Last Month';
               
               echo '<input type="radio" name="radio2" id="last_2_months" value="-2" onclick="uncheck_chkbox();"';
               if(isset( $_REQUEST['radio2']) && ($_REQUEST['radio2'] == -2))
               {
               echo 'checked';
               }
               echo '/>&nbsp;Last Two Months';
            
               echo '<input type="radio" name="radio2" id="last_3_months" value="-3" onclick="uncheck_chkbox();"';
               if(isset($_REQUEST['radio2']) && ($_REQUEST['radio2'] == -3))
               {
               echo 'checked';
               }
               echo '/>&nbsp;Last 3 Months)&nbsp;&nbsp;&nbsp;&nbsp;';
         
         echo '<input type="radio" name="radio1" id="first_time_usr" value="details_usr" onclick="uncheck_chkbox();"';
         if( isset($_REQUEST['radio1']) && ($_REQUEST['radio1'] == 'details_usr'))
         {
         echo 'checked'; 
         }
         echo '/>&nbsp;Detailed Data Of Repeat Complainers
        </td>
        <td class="admintext1" align="left" style="padding-left: 8px; padding-top: 8px;" bgcolor="#eefaff" valign="top"><input type="hidden" value="6" id="tabselect" name="tabselect">
	<input type="hidden" value="4" id="mistabselect" name="mistabselect">
	<input name="glusr_submit" id="glusr_submit" value="Show Report" style="font-size:13px; padding:2px 10px; font-weight:bold;  cursor:pointer;" type="Submit">
	</td>
        <td style="float:right; color:#000000; font-weight:bold;font-size:12px;"></td>
        </tr>
        </table>
        <br />
        <br />
        </form>
        </div>
<div id="talkcount" style="display:none;"></div>
   <!--Talk wise end here -->

   <!--Mis Part end here -->
   <br style="clear:both;" />
        </div>';
        echo '</div>';
if($tabselect == '7')
{
        echo '<div class="eb data_on" id="data7">';
}
else
{
        echo '<div class="eb data_off" id="data7">';
}

echo '</div>';
if($tabselect == '9')
{
  
        echo '<div class="eb data_on" id="data9">';
        echo '
		<style>
		.dark{
		background : #eefaff;
		}
		.fnt
		{
		font-size:12px;
		width:33%;
		height:15px;
		}
		</style>
                <br><table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
		<tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">';
		if($root)
		{
			echo '<td style="width:2%;padding:4px;">Sl.No</td>
			<td style="width:10%;padding:4px;">Glusr ID</td>
			<td style="width:34%;padding:4px;">Company Name</td>
			<td style="width:12%;padding:4px;">No. Of Complaints</td>
			<td style="width:10%;padding:4px;">Claimed By</td>
			<td style="width:10%;padding:4px;">Complained On (Min)</td>
			<td style="width:10%;padding:4px;">Last Updated On</td>
			<td style="width:10%;padding:4px;">Partial Closure Status</td>
			
			</tr>';
		}
		else
		{
			echo '<td style="width:2%;padding:4px;">Sl.No</td>
			<td style="width:10%;padding:4px;">Glusr ID</td>
			<td style="width:43%;padding:4px;">Company Name</td>
			<td style="width:15%;padding:4px;">No. Of Complaints</td>
			<td style="width:10%;padding:4px;">Complained On (Min)</td>
			<td style="width:10%;padding:4px;">Last Updated On</td>
			<td style="width:10%;padding:4px;">Partial Closure Status</td>
			</tr>';
		}
	$cnt = 0;
	while($rec = oci_fetch_assoc($sth_partial_closed))
	{
	 
// warn qq~1:::Tab: $tabselect || Part Close: $rec->{'ETO_BL_CMPLNT_PARTIAL_CLOSE'}~;
		if($tabselect == 9 && $rec['ETO_BL_CMPLNT_PARTIAL_CLOSE'] == -1)
		{
			
			continue;
			
		}
// warn qq~2:::Tab: $tabselect || Part Close: $rec->{'ETO_BL_CMPLNT_PARTIAL_CLOSE'}~;
		$cnt++;
		$htmlclass = '';
		if($cnt % 2 == 0 )
		{
			echo '
		<tr class="dark fnt">';
		}
		else
		{
			echo '
		<tr class="fnt wbg">';
		}
		echo '
		<td style="padding:4px;">'.$cnt.'</td>
		<td style="padding:4px;"><a href="/index.php&r=admin_bl/Eto_crm_cmplnt/Index&glusrID='.$rec['GLUSR_ID'].'&glusr_submit=Submit&tabselect=1">'.$rec['GLUSR_ID'].'</a></td>
		<td style="padding:4px;">'.$rec['COMPANY'].'</td>
		<td style="padding:4px;">'.$rec['CNT'].'</td>';
		if($root)
		{
			echo '<td style="padding:4px;">'.$rec['EMP_NAME'].'</td>';
		}
		echo '<td style="padding:4px;">'.$rec['ETO_BL_CMPLNT_ON'].'</td>
		<td style="padding:4px;">'.$rec['LAST_UPDATED_ON'].'</td>
		<td style="padding:4px;">';

		if(isset($rec['ETO_BL_CMPLNT_PARTIAL_CLOSE']) && ($rec['ETO_BL_CMPLNT_PARTIAL_CLOSE']== 1))
		{
			echo 'Partially Closed in GL Admin<br>Still opened in WebErp';
		}
		if(isset($rec['ETO_BL_CMPLNT_PARTIAL_CLOSE']) && ($rec['ETO_BL_CMPLNT_PARTIAL_CLOSE'] == 2))
		{
			echo 'Partially Closed in GL Admin<br>Closed in WebErp';
		}
		echo '</td>
		</tr>';
	}
	if($cnt == 0)
	{
		echo '<tr class="wbg"><td colspan="6" style="padding:4px;"><div align="center" style="width:98% ; border:grey solid 1px;padding:4px;margin:4px;"><font color="red">No Pending Claimed Complaints Found</font></div></td><tr>';
	}
	echo '</table><br><br><br>';
	
// 	PBL_Mark_Cmplnt->myClaimedCmplnt($dbh,$empid,$tabselect);
}
else
{
        echo '<div class="eb data_off" id="data9">';
}
echo '</div>';



  echo '<div style="clear:both;"><!-- --></div>
        </div></div></div>';


?>