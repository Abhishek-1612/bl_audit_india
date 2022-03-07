<?php


$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
        $todate=isset($_REQUEST['todate']) ? $_REQUEST['todate'] : '';
	$fromdate=isset($_REQUEST['fromdate']) ? $_REQUEST['fromdate'] : '';
	$status=isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
	$subquery='';
	$a='';	#for 'all' radio button
	$d='';	#for 'done' radio button
	$p='checked';	#for 'pending' radio button
	$result='';
	$limit=50;
	$start;
	$end;
	$sql1;
	$rec1;
	$sth1;
	$total_count=isset($_REQUEST['total']) ? $_REQUEST['total'] : '';
	$all_cnt=array(0,0,0);
	$pending_count;
	
	if($fetch_cnt){
		$start=($fetch_cnt*$limit)+1;
		$end=$start+$limit-1;
	}
	else{
		$start=1;
		$end=$limit;
	}

	if($status){
		if($status == 'done')
		{
		$d='checked';
		$p=''; 
		
		}
		elseif($status == 'all')
		{
		$a='checked';
		$p='';
		}
	}
	
	if($fromdate && $todate){

		$fromdate=preg_replace('/\//','-',$fromdate);

		$todate=preg_replace('/\//','-',$todate);
		
	}
	echo <<<msg
<html><head>

</head></html>
msg;

if($fetch_cnt == 0){
	$result.=  '
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html><head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">';
		if($status != 'done'){
			$result.='<meta http-equiv="refresh" content="300">';
		}
		$result.='<title>Eto-bl-pur-pending</title> 
		<style>
		.intd {
		    padding: 4px 0;
		    text-align: center;
		    word-wrap: break-word;
		}
		</style>
		<script type="text/javascript" LANGUAGE="JavaScript" src="'.$utilsHost.'/js/calendar-v1.js"></script>
		<link rel="stylesheet" type="text/css" href="'.$utilsHost.'/css/calendar-v1.css">
		<link href="/css/report.css" rel="stylesheet" type="text/css"> 
		 </head> 

	<body> 
 		<div id="showform1" style="width:100%; margin:0px auto;">
                        <form name="user_details" action="index.php?r=admin_bl/Eto_bl_pur_limit_pend/Index" method="post" style="margin-top:0;margin-bottom:0;">
                                <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%"  height="60px">
                                        <tbody>
                       <tr><td align="center" bgcolor="#dff8ff"><font color=" #000000" size=3px><b>Purchase Limit Pending Report</b></font></td></tr>
                        <tr>
                           <td width="32%" style="text-align:center;height:50px;"><span style="float:left;font-size:16px;">Total Pending: '.$pending_count.'</span> &nbsp;
   <!--<select name="time_diff">
  <option value="others">Others</option>
  <option value="five">Within 5 min</option>
  <option value="ten">Within 10 min</option>
  <option value="fifften">Within 15 min</option>
</select>&nbsp;--!> From Date &nbsp;&nbsp;<input type="text" value="'.$fromdate.'" name="fromdate" id="fromdate" autocomplete="off" onclick="displayDatePicker(\'fromdate\')" size="10"> &nbsp; &nbsp;To Date &nbsp;&nbsp;<input type="text" value="'.$todate.'" name="todate" id="todate" autocomplete="off" size="10" onclick="displayDatePicker(\'todate\')" > &nbsp; &nbsp; <input type="radio" name="status" value="pending" '.$p.' >Pending &nbsp; &nbsp; <input type="radio" name="status" value="done" '.$d.' >Done &nbsp; &nbsp; <input type="radio" name="status" value="all" '.$a.' >All &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="submit" align="middle" value="Go"></td>
						</tr>
                                        </tbody>
                                </table>
                        </form>
                </div>
	<table width="1300px" cellspacing="0" cellpadding="4" bordercolor="#bedadd" border="1" style="border-collapse: collapse;" id="datatable">
	<tr>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>GLID</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Purchase Count</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Lead ID</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Platform</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Purchase Date</b></td>
<!--	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Modified Date</b></td>-->
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Status</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Pending Attempts</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>EMAIL</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>MOBILE</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>EMP ID</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Reason</b></td>
	</tr>
	';
}


 	$rec;
	$count=$start;
	while($rec = oci_fetch_array($sth,OCI_BOTH))
	{
		$rec['ETO_BL_PUR_IP_CITY'] = isset($rec['ETO_BL_PUR_IP_CITY']) ? $rec['ETO_BL_PUR_IP_CITY'] : '';
		$rec['ETO_BL_PUR_CLIENT_IP'] = isset($rec['ETO_BL_PUR_CLIENT_IP']) ? $rec['ETO_BL_PUR_CLIENT_IP'] : '';
		$rec['ETO_BL_PUR_IP_COUNTRY'] = isset($rec['ETO_BL_PUR_IP_COUNTRY']) ? $rec['ETO_BL_PUR_IP_COUNTRY'] : '';
		$rec['ETO_BL_PUR_UPDATED'] = isset($rec['ETO_BL_PUR_UPDATED']) ? $rec['ETO_BL_PUR_UPDATED'] : '';
		$rec['ETO_BL_PUR_STATUS'] = (isset($rec['ETO_BL_PUR_STATUS']) && $rec['ETO_BL_PUR_STATUS'] == 1) ? 'Done' : '<font color="#ff0000">WIP</font>';



$result.= '<tr> 
		<td class="intd" width="100px" style="text-align:center;">
		<a href="index.php?r=admin_bl/Eto_bl_pur_limit/Index&action=detail&gluserid='.$rec['FK_GLUSR_USR_ID'].'" target=\'blank\'>'.$rec['FK_GLUSR_USR_ID'].'</a></td>
		<td class="intd" width="100px" style="text-align:center;">'.$rec['ETO_BL_PUR_COUNT'].' </td>
		<td class="intd" width="100px" style="text-align:center;">'.$rec['ETO_BL_PUR_OFR_ID'];
		if($rec['ETO_BL_PUR_LEAD_TYPE'] == 'T')
		{ 
		$result.=' <br><font color="RED"><sub>Tender</sub></font>';
		} 
		$result.= '</td>
		<td class="intd" width="100px" style="text-align:center;">'.$rec['ETO_BL_PUR_MOD_ID'].' </td>
		<td class="intd" width="100px" style="text-align:center;">'.$rec['ETO_BL_PUR_DATE_DISP'].' </td>
<!--		<td class="intd" width="100px" style="text-align:center;">'.$rec['ETO_BL_PUR_UPDATED'].' </td>-->
		<td class="intd" width="100px" style="text-align:center;">'.$rec['ETO_BL_PUR_STATUS'].'</td>
		<td class="intd" width="100px" style="text-align:center;">'.$rec['TOTAL_ENTRY_CNT'].'</td>
		<td class="intd" width="100px" style="text-align:center;">';
		if(isset($rec['GLUSR_USR_EMAIL'])){
		$result .= $rec['GLUSR_USR_EMAIL'];
		}
		$result .= '</td>
		<td class="intd" width="100px" style="text-align:center;">'.$rec['GLUSR_USR_PH_MOBILE'].'</td>
		<td class="intd" width="100px" style="text-align:center;">';
		$result.= isset($rec['ETO_BL_PUR_LIMIT_LAST_UPD_BY']) ? $rec['ETO_BL_PUR_LIMIT_LAST_UPD_BY'] : "--";
		$result.= '</td>
		<td class="intd" width="100px" style="text-align:center;">';
		$result.= isset($rec['ETO_BL_PUR_LIMIT_REASON']) ? $rec['ETO_BL_PUR_LIMIT_REASON'] : "--";
		$result.= '</td></tr>';		
		
	


		$count++;
	 }
	
	$pfcnt = $fetch_cnt;
	$fetch_cnt++;
	if(isset($_REQUEST['flag']) && ($total_count>= ($fetch_cnt*$limit)) && ($_REQUEST['flag'] >=2))
	{
		$serv=$_SERVER['SERVER_NAME'];
	$result.= <<<msg
	<tr><td colspan="11" style="background-color:#FFFFFF;text-align:center;height:60px"><input name="moreresult$pfcnt" type="button" id="moreresult$pfcnt" value="Show more records" style="height:30px;width:150px;"></td></tr> <script src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
		<script>
		\$(document).ready(function(){
		 \$('#moreresult$pfcnt').click(function(){
\$('#datatable tr:last').remove();
\$("#datatable").append('<tr id="myTableRow" style="text-align: center;width: 460px;margin-bottom: 20px;margin-left: 12%;background-color: #FFFFFF;padding: 7px;"><td colspan="11" style="height:50px;"><img src="<?php echo$utilsHost?>/gifs/indicator2.gif"><span style="padding: 0px 72px;font-weight: 700;">Fetching more to show...</span><img src="<?php echo$utilsHost?>/gifs/indicator2.gif"></td></tr>');
		    \$.ajax({url:"/index.php?r=admin_bl/Eto_bl_pur_limit_pend/Index&flag=$fetch_cnt&status=$status&fromdate=$fromdate&todate=$todate&total=$total_count",success:function(result){
			\$('#myTableRow').remove();	
			\$("#datatable").append(result);
		    }});
		  });
		});
		</script>
msg;
	}

	if($pfcnt == 0)
	{       
	        $serv=$_SERVER['SERVER_NAME'];
		$result.= <<<msg
	        <script src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
		<script>
			var fetch_cnt=1;
			var loading= false;
			\$(window).scroll(function() {
			\$(document).ready(function(){
			if (fetch_cnt<3 && !loading && (\$(window).scrollTop() >  \$(document).height() - \$(window).height() - 10)) {
			if($total_count>= (fetch_cnt*$limit)){	loading= true;
\$("#datatable").append('<tr id="myTableRow" style="text-align: center;width: 460px;margin-bottom: 20px;margin-left: 12%;background-color: #FFFFFF;padding: 7px;"><td colspan="11" style="height:50px;"><img src="<?php echo$utilsHost?>/gifs/indicator2.gif"><span style="padding: 0px 72px;font-weight: 700;">Fetching more to show...</span><img src="<?php echo$utilsHost?>/gifs/indicator2.gif"></td></tr>');
				\$.ajax({url:"/index.php?r=admin_bl/Eto_bl_pur_limit_pend/Index&flag="+fetch_cnt+"&status=$status&fromdate=$fromdate&todate=$todate&total=$total_count",success:function(result){
						\$('#myTableRow').remove();	
						\$("#datatable").append(result);
        		            }});
				fetch_cnt++;    
				setTimeout(function(){loading = false;},3000);  
			}
			} });});
		</script>
msg;
        	$result.= '</table></body></hmtl>';
	}

echo  $result;

?>
