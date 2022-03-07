<?php if($valid == 0){
		echo 'Your are not logged';die;
}
else if(!empty($autoBlLeads)){
	$autoBlLeads =  $autoBlLeads['autoBlLeads'];
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Auto BL Approval</title>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <link href="/css/report.css" rel="stylesheet" type="text/css">
	    <script type="text/javascript">
		function showSearch(offer) 
                {
                	var root = document.location.hostname;
                        root = "http://"+root;
                        window.open(root+'/index.php?r=admin_eto/OfferDetail/editflaggedleads&mid=3424&offer='+offer+'&go=Go','_blank');
                }
	    </script>	    	    
	</head>
	<body>
	 <div align="center" style="background-color: rgb(223, 248, 255);padding:8px 0; color:#990000;font-family:Trebuchet Ms;Font-size:22px;margin-bottom:6px"> Pending Leads - Auto BL Approval Pool
	</div> 

	
	<table cellspacing="0" cellpadding="4" width="100%" bordercolor="#bedadd" border="1" style="border-collapse: collapse;">
	    <tr>
		<td width="3%" bgcolor="#dff8ff" style="text-align:center;"><b>S.No</b></td>
		<td width="10%" bgcolor="#dff8ff" style="text-align:center;"><b>Lead ID</b></td>
      		<td width="40%" bgcolor="#dff8ff" style="text-align:center;"><b>Lead Title</b></td>
		<td width="10%" bgcolor="#dff8ff" style="text-align:center;"><b>Posting Date</b></td>
		<td width="10%" bgcolor="#dff8ff" style="text-align:center;"><b>MOD ID</b></td>		
	    </tr>
	<?php $counterGen = 1;
	foreach($autoBlLeads as $k => $rowGen)
	{
	    $ofrID = $rowGen['ETO_OFR_DISPLAY_ID'];?>
	    <tr>
		<td width="3%" bgcolor="#dff8ff" style="text-align:center;"><b><?php echo $counterGen ?></b></td>
		<td width="10%" style="text-align:center;" class="intd"><a href="javascript:void(0);" onclick="showSearch(<?php echo $ofrID ?>);"><?php echo $rowGen['ETO_OFR_DISPLAY_ID']; ?></a></td>
		<td width="40%" style="text-align:left;" class="intd"><?php echo $rowGen['ETO_OFR_TITLE']; ?></td>	
		<td width="10%" style="text-align:center;" class="intd"><?php echo isset($rowGen['DATE_R'])?$rowGen['DATE_R']:''; ?></td>
		<td width="10%" style="text-align:center;" class="intd"><?php echo $rowGen['FK_GL_MODULE_ID']; ?></td>
	    </tr>
	    
	    <?php $counterGen++; 
	}	  ?>
            
	</table>		
	</body>
	</html>
<?php	} ?>