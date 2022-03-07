<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <title>Complaint Details</title>
	    <style>
		.admintext {font-family:arial; font-size:13px;line-height:20px;padding-left:5px;}
		.admintext1 {font-family:arial; font-size:12px;line-height:20px;padding-left:2px;padding-right:3px;}
		.sptxt {color:red;}
	    </style>
	</head>
	<body>
	<?php 
	$glusrid = $complaintResult['glusrid'];	
	$offerID = $complaintResult['offerID'];	
	$recArr = $complaintResult['rec'];	
	if(!empty($glusrid)) { ?>
		<div align="center" style="background-color:#eaeaea;height:40px;padding-top:15px;font-family: arial; font-size: 14px; font-weight: bold;margin-bottom:10px;" >Complaint Against the User ID - <font color="red"><?php echo $glusrid; ?></font> <br></div>

		
		    <table align="center" border="1" cellpadding="0" cellspacing="0" width="100%">
		    <tr>
			<td class="admintext1" align="center" width="6%" bgcolor="#ccccff"><b>User ID</b></td>
			<td class="admintext1" align="center" width="7%" bgcolor="#ccccff"><b>Complaint ID</b></td>
			<td class="admintext1" align="center" width="6%" bgcolor="#ccccff"><b>Offer ID</b></td>
			<td class="admintext1" align="center" width="8%" bgcolor="#ccccff"><b>Complaint Open</b></td>
			<td class="admintext1" align="center" width="20%" bgcolor="#ccccff"><b>Description</b></td>
			<td class="admintext1" align="center" width="21%" bgcolor="#ccccff"><b>Complaint Open Reason</b></td>
			<td class="admintext1" align="center" width="20%" bgcolor="#ccccff"><b>Complaint Close Reason</b></td>
			<td class="admintext1" align="center" width="12%" bgcolor="#ccccff"><b>Complaint Against Lead</b></td>
		    </tr>
		    <?php foreach($recArr as $k => $rec) {
		    	$userID = isset($rec['FK_GLUSR_USR_ID'])?$rec['FK_GLUSR_USR_ID']:'';
		    	$cmplntID = isset($rec['FK_COMPLAINT_ID'])?$rec['FK_COMPLAINT_ID']: '';
		   	$offerID = isset($rec['FK_ETO_OFR_DISPLAY_ID'])?$rec['FK_ETO_OFR_DISPLAY_ID']:'';
		    	$cmplntON = isset($rec['ETO_BL_CMPLNT_ON'])?$rec['ETO_BL_CMPLNT_ON']:'';
		   	$supCmplntReason = isset($rec['ETO_BL_CMPLNT_DESC'])?$rec['ETO_BL_CMPLNT_DESC']: '';
		    	$cmplntReason = isset($rec['OPEN_REASON'])?$rec['OPEN_REASON']:'';
		    	$cmplntCloseReason = isset($rec['CLOSING_REASON'])?$rec['CLOSING_REASON']: '0';
		    	$totLeadCmplnt = isset($rec['TOTAL_LEAD_CMPLNT'])?$rec['TOTAL_LEAD_CMPLNT'] :'';
		    	?>
		    <tr>
			<td class="admintext1" align="center"><?php echo $userID; ?></td>			
			<td class="admintext1" align="center"><?php echo$cmplntID; ?></td>
			<td class="admintext1" align="center"><?php echo$offerID; ?></td>
			<td class="admintext1" align="center"><?php echo$cmplntON; ?></td>
			<td class="admintext1" align="left"><?php echo$supCmplntReason; ?></td>
			<td class="admintext1" align="left"><?php echo$cmplntReason; ?></td>
			<td class="admintext1" align="left"><?php echo$cmplntCloseReason; ?></td>
			<td class="admintext1" align="center"><?php echo$totLeadCmplnt; ?></td>
		    </tr>
		    			
		<?php } ?>
		</table>
<?php } else if(!empty($offerID)) { ?>
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tr>
			<td style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Complaint Against the Offer ID - <font color="red"><?php echo $offerID; ?></font> <BR>
			</td>
		    </tr>
		    <tr><td style="height:10px"></td></tr>
		    <?php foreach($recArr as $k => $rec)
				{
		   	$userID = isset($rec['GLUSR_USR_ID'])?$rec['GLUSR_USR_ID']:'';
		   	$userName = isset($rec['GLUSR_NAME'])?$rec['GLUSR_NAME']:'';
		    	$cmplntON = isset($rec['ETO_BL_CMPLNT_ON'])?$rec['ETO_BL_CMPLNT_ON']:'';
		   	$cmplntReason = isset($rec['ETO_BL_CMPLNT_REASON_DESC'])?$rec['ETO_BL_CMPLNT_REASON_DESC'] :'';		

		    ?>		
		    <tr>
			<td class="admintext" align="left">
			    <span class="sptxt"><?php echo $userName[$userID]; ?></span><b> issued complaint on </b><span class="sptxt"><?php echo $cmplntON; ?></span>
			    <b> against the offer</b> <span class="sptxt"> <?php echo $offerID; ?></span>
			     <b>for the reason</b> <span class="sptxt"><?php echo $cmplntReason; ?></span>			
			</td>			
		    </tr>
	    	    <tr><td style="height:5px;"></td></tr>
		    
		<?php } ?>
		</table> 
<?php } ?>
</body></html>