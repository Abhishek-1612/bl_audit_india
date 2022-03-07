<html>
  <head>
    <title>Lead Quality Report</title>
    <script type="text/javascript" src="eto-buy-sale-report.js"></script>
    <script type="text/javaScript">
         <!--
        
	function checkBuyForm()
	{
		if(document.searchForm.bdate_day.value == 0 || document.searchForm.bdate_month.value == 0 || document.searchForm.bdate_year.value == 0)
		{
			alert("Fill Start Date");
			return false;
		}
	
		if(document.searchForm.adate_day.value == 0 || document.searchForm.adate_month.value == 0 || document.searchForm.adate_year.value == 0)
		{
			alert("Fill End Date");
			return false;
		}
	
		if(document.searchForm.bdate_month.value == 2 || document.searchForm.bdate_month.value == 4
		|| document.searchForm.bdate_month.value == 6|| document.searchForm.bdate_month.value == 9|| document.searchForm.bdate_month.value == 11)
		{
			if(document.searchForm.bdate_day.value == 31)
			{
			alert("This date does not exists");
			return false;
			}
		}
		if(document.searchForm.adate_month.value == 2 || document.searchForm.adate_month.value == 4
		|| document.searchForm.adate_month.value == 6|| document.searchForm.adate_month.value == 9|| document.searchForm.adate_month.value == 11)
		{
			if(document.searchForm.adate_day.value == 31)
			{
			alert("This date does not exists");
			return false;
			}
		}
	}

	
	//-->
	</script>
  </head>
  <body>
  <?php  
		$recModArr = $etoLeapQcResult['recModArr'];  
		$bdate_day_sel = $etoLeapQcResult['bdate_day_sel'];  
		$bdate_month_sel = $etoLeapQcResult['bdate_month_sel'];  
		$bdate_year_sel = $etoLeapQcResult['bdate_year_sel'];  
		$adate_day_sel = $etoLeapQcResult['adate_day_sel'];  
		$adate_month_sel = $etoLeapQcResult['adate_month_sel'];  
		$adate_year_sel = $etoLeapQcResult['adate_year_sel'];  
		$modval = $etoLeapQcResult['modid'];  
		$source = $etoLeapQcResult['source'];   
		$flagError = $etoLeapQcResult['flagError'];   
		$errArr = $etoLeapQcResult['errArr'];   
		$total_fenq_rejected = $etoLeapQcResult['total_fenq_rejected'];   
		$total_fenq_approved = $etoLeapQcResult['total_fenq_approved'];   
		$total_fenq_generated = $etoLeapQcResult['total_fenq_generated'];   
		$total_general_rejected = $etoLeapQcResult['total_general_rejected'];   
		$total_general_approved = $etoLeapQcResult['total_general_approved'];   
		$total_general_generated = $etoLeapQcResult['total_general_generated'];   
		$for_sold = $etoLeapQcResult['for_sold'];   
		$in_sold = $etoLeapQcResult['in_sold'];   
		$tot_lead_sold = $etoLeapQcResult['tot_lead_sold'];   
		$unq_for_sold = $etoLeapQcResult['unq_for_sold'];   
		$unq_in_sold = $etoLeapQcResult['unq_in_sold'];   
		$totalunq_sold = $etoLeapQcResult['totalunq_sold'];   
		$L_60 = $etoLeapQcResult['L_60'];   
		$rec1 = $etoLeapQcResult['rec1'];   
		$L_45 = $etoLeapQcResult['L_45'];   
		$L_30 = $etoLeapQcResult['L_30'];   
		$L_15 = $etoLeapQcResult['L_15'];   
		$MORE_THEN_8HR = $etoLeapQcResult['MORE_THEN_8HR'];   
		$MORE_THEN_8_HR = $etoLeapQcResult['MORE_THEN_8_HR'];   
		$LT_3 = $etoLeapQcResult['LT_3'];   
		$rec = $etoLeapQcResult['rec'];   
		$LT_5 = $etoLeapQcResult['LT_5'];   
		$LT_2 = $etoLeapQcResult['LT_2'];   
		$LT_4 = $etoLeapQcResult['LT_4'];   
		$LT_1 = $etoLeapQcResult['LT_1'];   
		$pageref = $etoLeapQcResult['pageref'];   
		$add = $etoLeapQcResult['add'];   
		$web = $etoLeapQcResult['web'];   
		$enrich_only = $etoLeapQcResult['enrich_only'];   
		$enrich = $etoLeapQcResult['enrich'];   
		$notverf = $etoLeapQcResult['notverf'];   
		$verf = $etoLeapQcResult['verf'];   
		$desc = $etoLeapQcResult['desc'];   
		$GL_PRIVATE = $etoLeapQcResult['GL_PRIVATE'];   
		$GL_PUBLIC = $etoLeapQcResult['GL_PUBLIC'];   
		$comp = $etoLeapQcResult['comp'];   
		$quant = $etoLeapQcResult['quant'];   
		$mcat = $etoLeapQcResult['mcat'];    
		$city = $etoLeapQcResult['city'];    
  ?>
  <form name="searchForm" method="post" action="/index.php?r=admin_eto/AdminEto/etoleapquality" style="margin-top:0;margin-bottom:0;" onsubmit="return checkBuyForm();">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" height="30">
	<tr>
		<td bgcolor="#f4f4f4" align="center" style="font-family:arial;font-size:14px;font-weight:bold;">Lead Quality Report</td>
	</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td bgcolor="#ccccff" style="font-family:arial;font-size:12px;font-weight:bold;" width="12%" height="30">&nbsp;Select Period</td>
		<td style="font-family:arial;font-size:12px;font-weight:bold;" 
		bgcolor="#eaeaea" width="40%">
		<table border="0" cellpadding="3" cellspacing="0">
		<tr>

		<td><select name="bdate_day" size="1">
            <option value="">Day</option>
            <?php foreach($valday as $dayK => $dayV){
				$sel = ($bdate_day_sel == $dayK)?"selected":"";
					echo "<option value=\"$dayK\" $sel>$dayV</option>";		
				} ?>
			</select>
		</td>
		<td><select name="bdate_month" size="1">
            <option value="">Month</option>
				<?php foreach($valmonthval as $monthK => $monthV){
				$monthsel = ($bdate_month_sel == $monthK)?"selected":"";
					echo "<option value=\"$monthK\" $monthsel>$monthV</option>";		
				} ?>
			</select>
		</td>
      <td><select name="bdate_year" SIZE="1">
            <option value="0">Year</option>
				<?php foreach($valyearval as $yearK => $yearV){
					$yearsel = ($bdate_year_sel == $yearK)?"selected":"";
					echo "<option value=\"$yearK\" $yearsel>$yearV</option>";		
				} ?>
			</select>
		</td>
		<td>&nbsp;to&nbsp;</td>

		<td><select name="adate_day" size="1">
            <option value="0">Day</option>
				<?php foreach($valday as $dayeK => $dayeV){
					$dayesel = ($adate_day_sel == $dayeK)?"selected":"";
					echo "<option value=\"$dayeK\" $dayesel>$dayeV</option>";		
				} ?>
			</select>
		</td>
      <td><select name="adate_month" size="1">
            <option value="0">Month</option>
            <?php foreach($valmonthval as $monthEK => $monthEV){
					$monthEsel = ($adate_month_sel == $monthEK)?"selected":"";
					echo "<option value=\"$monthEK\" $monthEsel>$monthEV</option>";		
				} ?>
			</select>
		</td>
		<td><select name="adate_year" size="1">
        	<option value="0">Year</option>
        	<?php foreach($valyearval as $yearEK => $yearEV){
				$yearEsel = ($adate_year_sel == $yearEK)?"selected":"";
					echo "<option value=\"$yearEK\" $yearEsel>$yearEV</option>";		
			} ?>
			</select>
		</td>
	</tr>
</table>
</td>
	<td width="12%" bgcolor="#ccccff" style="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;MODID</td>
		<td bgcolor="#eaeaea" width="12%">
		<table border="0" cellpadding="1" cellspacing="0">
		<tr>
			<td>
				<select name="modid" size="1" style="width:100px;">
				<option value="all" <?php echo ($modval == 'all')?"selected":''; ?>>All</option>
				
				<option value="bpf" <?php echo ($modval == 'bpf')?"selected":''; ?>>BPF</option>
				<?php foreach($recModArr as $kRecMod => $RecMod) 
				{
					$selModVal = ($modval == $RecMod['GL_MODULE_ID'])?"selected":'';
					echo "<option value='".$RecMod['GL_MODULE_ID']."' $selModVal >".$RecMod['GL_MODULE_ID']."</option>";
				} ?>
			</td>
		</tr>
		</table>
		</td>
		<td width="12%" bgcolor="#ccccff" style="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;COUNTRY</td>
		<td bgcolor="#eaeaea" width="12%">
		<table border="0" cellpadding="1" cellspacing="0">
		<tr>
			<td>
			<select name="source" id ="source" size="1" style="width:150px;" >
			<?php foreach($cntryArr as $cntRow) 
				{
					$selCntry = ($source == $cntRow)?"selected":'';
					echo "<option value=\"$cntRow\" $selCntry >$cntRow</option>";
			} ?>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	</table>
	<br><br>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" height="30">
	<tr colspan="3">
		<td bgcolor="#f4f4f4">
		</td> 
		<td BGCOLOR="#F4F4F4"></td>
		<td bgcolor="#f4f4f4" align="center" style="font-family:arial;font-size:14px;font-weight:bold;">
			<input type="hidden" name="action" value="get_lead_quality_rpt">
			<input type="submit" name="Submit1" value="Generate Report">
		</td>
	</tr>
	</table>
	</form>
	<?php if ($flagError == 1)
	{
		$mesg = '';
		$mesg = '<table border="0" width="100%"><tr>
		<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left">
		<FONT COLOR="#FF0000" size="2"><B>Following Error(s) Occured:<BR><BR>';
		$errorCounter=0;
		foreach ($errArr as $e=>$err)
		{
			$errorCounter++;
			$mesg .= " Error ".$errorCounter.": ".$e."<BR>";
		}
		$mesg .= "<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT></TD>
			</TR></TABLE>";
	} else { ?>
			<div>
		<table width="50%" border="0" cellpadding="0" cellspacing="0" align="CENTER" bgcolor="#ffffff">
		<tr>
		<td height="30" colspan="2" align="CENTER" bgcolor="#ccccff" style="font-family:arial;font-weight:bold;font-size:11px;border-top:1px solid #ffffff">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="20%" height="30" style="padding-left:8px;color:#0303bd; font-size:13px;"><b>Quality Parameter</b></td>
			<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b>Data</b></td>
			<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b>Percentage</b></td>
		</tr>
		</table></td> 
		</tr>

	
	
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:10px">TOTAL LEADS APPROVED</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['TOTAL_APPROV']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
	</tr>
	</table>
	</td>	</tr>
 
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">CITY</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['CITY_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $city; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">MCAT MAPPING</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['MCAT_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $mcat; ?>%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">QUANTITY</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['QTY_TOTAL'];?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $quant; ?>%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">COMPANY</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['COMPANY_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $comp; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:50px">LIMITED COMPANY</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['GL_PUBLIC_LTD_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $GL_PUBLIC; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:50px">PVT. LIMITED COMPANY</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['GL_PRIVATE_LTD_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $GL_PRIVATE; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">> 200 CHAR IN DESC</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['DESC_GT_200_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $desc; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">VERIFIED ONLY</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['VERIFIED_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $verf; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">NOT VERIFIED</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['NOT_VERIFIED_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $notverf; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">VERIFIED & UPDATED</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['ENRICH_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $enrich; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">UPDATED ONLY</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['ENRICHED_ONLY_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $enrich_only; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">WEBSITE</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['WEBSITE_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $web; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">ADDRESS</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['ADDRESS_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $add; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">SOURCE</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec['PAGE_REFERRER_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $pageref; ?>%</td>
	</tr>
	</table></td>
	</tr>



	<tr>
	<td height="30" colspan="2" align="CENTER" bgcolor="#ccccff" style="font-family:arial;font-weight:bold;font-size:11px;border-top:1px solid #ffffff">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="20%" height="30" style="padding-left:8px;color:#0303bd; font-size:13px;"><b>Buy Lead Latency (in Hours)</b></td>
		<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b></b></td>
		<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b></b></td>
	</tr>	
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">0 - 1 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec1['T1_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $LT_1; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px"> 1 - 3 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec1['T4_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $LT_4; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px"> 1 - 8 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec1['T2_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $LT_2; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px"> 3 - 24 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec1['T5_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $LT_5; ?>%</td>
	</tr>
	</table></td>
	</tr>


	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">8 - 24 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec1['T3_TOTAL']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $LT_3; ?>%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">MORE THAN 24 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $MORE_THEN_8_HR; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $MORE_THEN_8HR; ?>%</td>
	</tr>
	</table></td>
	</tr>


	<tr>
	<td height="30" colspan="2" align="CENTER" bgcolor="#ccccff" style="font-family:arial;font-weight:bold;font-size:11px;border-top:1px solid #ffffff">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="20%" height="30" style="padding-left:8px;color:#0303bd; font-size:13px;"><b>Buy Lead Latency (in Minutes)</b></td>
		<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b></b></td>
		<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b></b></td>
	</tr>	
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">0 - 15 MIN</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec1['M15']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $L_15; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">15 - 30 MIN</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec1['M30']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $L_30; ?>%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">30 - 45 MIN</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec1['M45']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $L_45; ?>%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">45 - 60 MIN</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $rec1['M60']; ?></td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"><?php echo $L_60 ; ?>%</td>
	</tr>
	</table></td>
		<TR >
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>LEAD PURCHASE ACTIVITY</B></TD>			
				</TR>
				<TR>			
				<TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px;" ><b>Total Leads Sold - Unique</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ><?php echo $totalunq_sold; ?> 			 
				</TD></TR>
				<TR>			
				<TD width="15%" STYLE="font-family:arial;font-size:13px;padding:9px 0px 9px 29px;" >Indian Sold - Unique</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ><?php echo $unq_in_sold; ?></TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px 0px 9px 29px" >Foreign Sold - Unique</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo $unq_for_sold; ?></TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Leads Sold - Transactions</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo $tot_lead_sold; ?></TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px 0px 9px 29px" >Indian Lead - Transactions</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo $in_sold; ?></TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px 0px 9px 29px" >Foreign Lead - Transactions</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo $for_sold; ?></TD></TR></table></td></tr>


		<TR>
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>Total Leads Rejected</B></TD>			
				</TR>
				<TR>			
				<TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px;" >Total General leads generated</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo $total_general_generated	?>		 
				</TD></TR>
				<TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Total General leads approved</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo $total_general_approved ?>			 
				</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" >Total General leads Rejected</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo $total_general_rejected ?>			 
				</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Fenq leads Generated</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo  $total_fenq_generated		?>	 
				</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Fenq leads approved</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo $total_fenq_approved ?>			 
				</TD></TR>		 
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px" >Total Fenq Leads Rejected</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" ><?php echo $total_fenq_rejected?></TD>
				</TR><table></td></tr>				
		

	</table>
</div>
<br><br><br>
	<?php } ?>
  </body>
</html>