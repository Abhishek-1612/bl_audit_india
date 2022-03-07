<?php 
$this->pageTitle=Yii::app()->name . ' -ASTBUY Report';

$url  = "http://dev-gladmin.intermesh.net/admin_eto/eto-insta-astbuy.php";
	$html = '';
	$html  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	$html .= '<html xmlns="http://www.w3.org/1999/xhtml">';
	$html .= '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
	$html .= '<!--google analytics async code start-->
  <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-28761981-2\']);
  _gaq.push([\'_setDomainName\', \'.intermesh.net\']);
  _gaq.push([\'_setSiteSpeedSampleRate\', 10]);
  _gaq.push([\'_trackPageview\',\''.$_SERVER['REQUEST_URI'].'\']);
  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!--google analytics async code end--></head><body>';
	$html .= '<div style="width:100%; border-bottom:3px solid #2e3192;">';
	$html .= '<div style="padding-top:10px; border-top:3px solid #2e3192">';
	$html .= '<img src="http://trade.indiamart.com/gifs/indiamart-logo-m.png" alt="indiamart" align="right" style="width:100;height:30;">';
	$html .= '<span style="padding-left:5px; font:bold 20px Arial; color:#990000; text-align:left; line-height:30px;">';
	$html .= 'ASTBUY Reports</span>';
	$html .= '<div style="padding-top:5px; padding-bottom:5px; clear:both; border-bottom:3px solid #2e3192"></div><br></div>';
	$html .= '<div id="content-area" style="padding-left:5px; padding-bottom:5px; font:15px Sans Serif;">';
	$html .= 'Click on the type of Report you want to view.<ul style="line-height:20px;">';
	$html .= '<li><a href="admin_eto/eto-insta-astbuy.php" target="Reports" style="text-decoration: none; color:#00297A;">Instant ASTBUY Report</a></li>';
	$html .= '<li><a href="admin_eto/eto-unsold-leads-generate-report2.php" target="Reports" style="text-decoration: none; color:#00297A;">Overall ASTBUY Report</a></li>';
	$html .= '<li onclick="if(document.getElementById(\'Processed_Status\').style.display == \'none\') document.getElementById(\'Processed_Status\').style.display = \'block\'; else document.getElementById(\'Processed_Status\').style.display=\'none\'"><span  style="color:#00297A;">Today\'s ASTBUY CRON Progress Status</span></li>';
	$html .= '<div id="Processed_Status" style="font:15px sans-serif;display:none">';
	if ($total || $processed || $notProcessed || $sms_processed || $sms_notProcessed)
	{
		$html .= '<span style="display:block; color:#003399;">Total Records to Process:<b> '.$total.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; Processed :<b> '.$processed.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; Not Processed :<b> '.$notProcessed.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; SMS Processed :<b> '.$sms_processed.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; SMS Not Processed :<b> '.$sms_notProcessed.'</b></span>';
	}
	$html .= '</div></ul></div>';
	$html .= '<div id="Report_View" style="height:100%; border-top:3px solid #2e3192">';

	
	$html .= '<ul style="line-height:20px;">'; 
	$html .= '<li style="font:15px sans-serif;" onclick="if(document.getElementById(\'feedback_processed_Status\').style.display == \'none\') document.getElementById(\'feedback_processed_Status\').style.display = \'block\'; else document.getElementById(\'feedback_processed_Status\').style.display=\'none\'"><span  style="color:#00297A;">Today\'s Feedback Progress Status</span></li>';
	$html .= '<div id="feedback_processed_Status" style="font:15px sans-serif;display:none">';
	if ($paid_total || $paid_processed || $paid_notProcessed || $pns_total || $pns_processed || $pns_notProcessed || $buylead_total || $buylead_processed || $buylead_notProcessed)
	{
		$html .= '<span style="display:block; color:#003399;">Total Paid Records to Process:<b> '.$paid_total.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; Processed :<b> '.$paid_processed.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; Not Processed :<b> '.$paid_notProcessed.'</b></span>';
		
		$html .= '<span style="display:block; color:#003399;">Total Buylead Records to Process:<b> '.$buylead_total.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; Processed :<b> '.$buylead_processed.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; Not Processed :<b> '.$buylead_notProcessed.'</b></span>';
			
		$html .= '<span style="display:block; color:#003399;">Total PNS Records to Process:<b> '.$pns_total.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; Processed :<b> '.$pns_processed.'</b></span>';
		$html .= '<span style="display:block; color:#1947A3;"><b>&#45;</b> &nbsp; Not Processed :<b> '.$pns_notProcessed.'</b></span>';
	}
	$html .= '</div></ul>';

	
	$html .= '</div></div></body></html>';
	echo $html;

?>