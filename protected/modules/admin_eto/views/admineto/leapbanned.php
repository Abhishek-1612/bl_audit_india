<?php if($valid == 0){ 
	echo 'Your are not logged';die;
	}
  
else if(!empty($flaggedLeads)){
	$flaggedLeads =  $flaggedLeads['flaggedLeads'];
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Mcat Not Relevant</title>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <link href="/css/report.css" rel="stylesheet" type="text/css">
	    <script type="text/javascript">
		function showSearch(offer) 
                {        
                  var root = document.location.hostname;
                  root = "http://"+root
                  window.open(root+'/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='+offer+'&go=Go&mid=3424','_blank');
                }
	    </script>	   
	    <!--google analytics async code start-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28761981-2']);
  _gaq.push(['_setDomainName', '.intermesh.net']);
  _gaq.push(['_setSiteSpeedSampleRate', 10]);
  _gaq.push(['_trackPageview','<?php echo $_SERVER['REQUEST_URI'];?>']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!--google analytics async code end-->

	</head>
	<body>
	 <div align="center" style="background-color: rgb(223, 248, 255);padding:8px 0; color:#990000;font-family:Trebuchet Ms;Font-size:22px;margin-bottom:6px"> Flagged Leads - Mcat Not Relevant
	</div> 
         MCAT NA Sheet Of Current Month:
		<a href="/index.php?r=admin_eto/AdminEto/downloadmcatna&data=current" TARGET="_blank">Download Processed Data</a><br/>
         MCAT NA Sheet Of Previous Month:
         <a href="/index.php?r=admin_eto/AdminEto/downloadmcatna&data=previous" TARGET="_blank">Download Processed Data</a><br/>	
	<table cellspacing="0" cellpadding="4" width="100%" bordercolor="#bedadd" border="1" style="border-collapse: collapse;">
	    <tr>
		<td width="3%" bgcolor="#dff8ff" style="text-align:center;"><b>S.No</b></td>
		<td width="10%" bgcolor="#dff8ff" style="text-align:center;"><b>Lead ID</b></td>
      <td width="40%" bgcolor="#dff8ff" style="text-align:center;"><b>Lead Title</b></td>
		<td width="10%" bgcolor="#dff8ff" style="text-align:center;"><b>Flagged By</b></td>
		<td width="10%" bgcolor="#dff8ff" style="text-align:center;"><b>Vendor Name</b></td>
		<td width="10%" bgcolor="#dff8ff" style="text-align:center;"><b>Flagging Date</b></td>
		<td width="10%" bgcolor="#dff8ff" style="text-align:center;"><b>Posting Date</b></td>
		<td width="10%" bgcolor="#dff8ff" style="text-align:center;"><b>MOD ID</b></td>
		<td width="7%" bgcolor="#dff8ff" style="text-align:center;"><b>Country ISO</b></td>		
	    </tr>
	<?php $counterGen = 1;
	foreach($flaggedLeads as $k => $rowGen)
	{
	    $ofrID = $rowGen['ETO_OFR_DISPLAY_ID'];?>
	    <tr>
		<td width="3%" bgcolor="#dff8ff" style="text-align:center;"><b><?php echo $counterGen ?></b></td>
		<td width="10%" style="text-align:center;" class="intd"><a href="javascript:void(0);" onclick="showSearch(<?php echo $ofrID ?>);"><?php echo $rowGen['ETO_OFR_DISPLAY_ID']; ?></a></td>
		<td width="40%" style="text-align:left;" class="intd"><?php echo $rowGen['ETO_OFR_TITLE']; ?></td>
		<td width="10%" style="text-align:center;" class="intd"><?php echo $rowGen['FLAGGED_BY_NAME']; ?></td>
		<td width="10%" style="text-align:center;" class="intd"><?php echo $rowGen['ETO_LEAP_VENDOR_NAME']; ?></td>
		<td width="10%" style="text-align:center;" class="intd"><?php echo $rowGen['FLAGGED_DATE']; ?></td>		
		<td width="10%" style="text-align:center;" class="intd"><?php echo isset($rowGen['ETO_OFR_POSTDATE_ORIG'])?$rowGen['ETO_OFR_POSTDATE_ORIG']:''; ?></td>
		<td width="10%" style="text-align:center;" class="intd"><?php echo $rowGen['FK_GL_MODULE_ID']; ?></td>
		<td width="7%" style="text-align:center;" class="intd"><?php echo $rowGen['FK_GL_COUNTRY_ISO']; ?></td>		
	    </tr>
	    
	    <?php $counterGen++; 
	}	  ?>
            
	</table>		
	</body>
	</html>
<?php	} ?>