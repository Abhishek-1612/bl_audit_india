<?php

$message = '';

$message .= '<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-28761981-2\']);
  _gaq.push([\'_setDomainName\', \'.intermesh.net\']);
  _gaq.push([\'_setSiteSpeedSampleRate\', 10]);
  _gaq.push([\'_trackPageview\',\''.$_SERVER['REQUEST_URI'].'\']);
  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();</script>';


$message .= '
<table border="1" style="width:100%">
  <tr align="middle" bgcolor="#E6E6FA">
    <td><b>S.NO</b></td>
    <td><b>Offer ID</b></td>
    <td><b>Approved_Date</b></td>
    <td><b>Age of Lead in hour(s)</b></td>
    <td><b>Mcat Name</b></td>
    <td><b>Count</b></td>
    <td><b>User List</b></td>
  </tr>';
$cntr=1;
if($dbtype=='PG'){
     while($rec=pg_fetch_array($sid)){
	$rec=array_change_key_case($rec, CASE_UPPER); 
        
        $offer_id = isset($rec['ETO_OFR_DISPLAY_ID']) ? $rec['ETO_OFR_DISPLAY_ID'] : '';
        $user_list = $rec['USER_LIST'] ;
        $adate=isset($rec['ETO_OFR_APPROV_DATE']) ? $rec['ETO_OFR_APPROV_DATE'] : '';
        $hdate=isset($rec['HR_DIFF']) ? $rec['HR_DIFF'] : '';
        $mname=isset($rec['ETO_OFR_GLCAT_MCAT_NAME']) ? $rec['ETO_OFR_GLCAT_MCAT_NAME'] : '';
        $Count=   $rec['CNT'];
            
    $message .= '<tr>
    <td>'.$cntr.'</td>
    <td>'.$offer_id.'</td>
    <td>'.$adate.'</td>
    <td>'.$hdate.'</td>
    <td>'.$mname.'</td>
    <td>'.$Count.'</td>
    <td>'.$user_list.'</td>
  </tr>';
    $cntr++;

}
}else{
     while($rec=oci_fetch_array($sid)){
	$offer_id = isset($rec['ETO_OFR_DISPLAY_ID']) ? $rec['ETO_OFR_DISPLAY_ID'] : '';
        $user_list = $rec['USER_LIST'] ;
        $adate=isset($rec['ETO_OFR_APPROV_DATE']) ? $rec['ETO_OFR_APPROV_DATE'] : '';
        $hdate=isset($rec['HR_DIFF']) ? $rec['HR_DIFF'] : '';
        $mname=isset($rec['ETO_OFR_GLCAT_MCAT_NAME']) ? $rec['ETO_OFR_GLCAT_MCAT_NAME'] : '';
        $Count=   $rec['CNT'];
            
    $message .= '<tr>
    <td>'.$cntr.'</td>
    <td>'.$offer_id.'</td>
    <td>'.$adate.'</td>
    <td>'.$hdate.'</td>
    <td>'.$mname.'</td>
    <td>'.$Count.'</td>
    <td>'.$user_list.'</td>
  </tr>';
$cntr++;
}
}
 
$message .= '</table>';
echo $message;  