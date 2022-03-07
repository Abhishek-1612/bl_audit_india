<?php
if($valid == 0)  { ?>
		Your are not logged in<BR> Click here to <A HREF=\"index.php?r=site/login" target=\"_top\">login</A><BR>
<?php } else {
	$curr_sec = date("s");
		$curr_min= date("i");
		$curr_hour= date("H");
		$curr_day= date("d");
		$curr_month= date("m");
		$curr_year= date("Y");
		//$curr_month = $curr_month+1;
		$curr_year = $curr_year+1900;		
		$bdate_day=$genericInfo['bdate_day'];
		$bdate_month=$genericInfo['bdate_month'];
		$bdate_year=$genericInfo['bdate_year'];
		$adate_day=$genericInfo['adate_day'];
		$bdate_month=$genericInfo['bdate_month'];
		$bdate_year=$genericInfo['bdate_year'];
		$totalRecords=$genericInfo['totalRecords'];
		$mesg=$genericInfo['mesg'];
		$flagError=$genericInfo['flagError'];
		$rec=$genericInfo['rec'];
		$nav_link=$genericInfo['nav_link'];
		 ?>
		<script LANGUAGE="JavaScript" SRC="../protected/js/eto-buy-sale-report.js"></script>
	<SCRIPT LANGUAGE="JavaScript">
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
	</SCRIPT>
	<FORM name="searchForm" METHOD="post" ACTION="/index.php?r=admin_eto/AdminEto/genericmcatreport&mid=3424" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();">
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">Generic Mcat Report</TD>
	</TR>
	</TABLE>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="100" HEIGHT="30">&nbsp;Select Period</TD>
		<TD STYLE="font-family:arial;font-size:12px;font-weight:bold;" 
		BGCOLOR="#EAEAEA">
		<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
		<TR>
			<TD><SELECT NAME="bdate_day" SIZE="1">
            		<OPTION VALUE="0">Day</OPTION>
            		<?php 
            		$d1 = array_merge(array(01,02,03,04,05,06,07,08,09),range(10,31));
            		$dateArr = array_combine($d1,array_merge(array(1,2,3,4,5,6,7,8,9),range(10,31)));
                        foreach ($dateArr as $k => $row) 
                        {	
                        		echo "<OPTION VALUE=\"$k\"";
                        		if ($bdate_day == $k)  {
                              	echo "selected";
                              } else if($k == $curr_day && !$bdate_day) {
                              	echo "selected";
                              }
                              echo ">$row</OPTION>"; 
                        } ?>

			</select></td>
            		<td><select name="bdate_month" SIZE="1">
            		<option value="0">Month</option>
                        <?php
                        foreach ($months as $kMonth => $rMonth) 
                        {
                        	echo "<OPTION VALUE=\"$kMonth\"";
                        if ($bdate_month && $bdate_month == $kMonth) {
                       		echo " SELECTED ";
                        }
                        else if($kMonth == $curr_month && !$bdate_month)
                        {
                           echo " SELECTED ";
                        }
                        echo ">".$rMonth."</OPTION>";
                        } ?>

				</select></td>
            		<td><select name="bdate_year" SIZE="1">
            		<option value="0">Year</option>
                     <?php 
                     	$sysyear = date("Y");
                        $bdate_year =	empty($bdate_year)?$sysyear:$bdate_year;
                        $adate_year =	empty($adate_year)?$sysyear:$adate_year;
                        
                        $valYear = array_combine(range($sysyear -5,$sysyear +5),range($sysyear -5,$sysyear +5));
                        foreach($valYear as $kYear =>$rYear)
                        {
                        	echo "<OPTION VALUE=\"$kYear\"";
                        	if ($bdate_year && $bdate_year == $kYear) 
									{
                        		echo " SELECTED ";
                        	}
                        	echo ">$rYear</OPTION>";
                        } ?>
				</select></td>
			<td>&nbsp;to&nbsp;</td>
			<td><select name="adate_day" SIZE="1">
            		<option value="0">Day</option>
                       <?php 
                        foreach ($dateArr as $k1 => $row1) 
                        {
                                
                                        echo "<OPTION VALUE=\"$k1\"";
                                        if ($adate_day == $k1) 
                                        {
                                             echo " SELECTED ";
                                        }
                                        else if($k1 == $curr_day && !$adate_day)
                                        {
                                             echo " SELECTED ";
                                        }
                                        echo ">$row1</OPTION>"; 
                        } ?>

			</select></td>
            		<td><select name="adate_month" SIZE="1">
            		<option value="0">Month</OPTION>

                    <?php    
                    foreach ($months as $kMonth1 => $rMont1) 
                        {
                        	echo "<OPTION VALUE=\"$kMonth1\"";
                        	if ($adate_month && $adate_month == $kMonth1) 
									{
                        		echo " SELECTED ";
                        	}
                        	else if($kMonth1 == $curr_month && !$adate_month)
                        	{
                                	echo " SELECTED ";
                        	}
                        	echo ">$rMont1</OPTION>";
                        }
?>
			</select></td>
            		<td><select name="adate_year" size="1">
            		<OPTION VALUE="0">Year</OPTION>

                        <?php foreach($valYear as $kYear1 =>$rYear1)
                        {
                        	echo "<OPTION VALUE=\"$kYear1\"";
                        	if ($adate_year && $adate_year == $kYear1) 
									{
                        		echo " SELECTED ";
                        	}
        	        			echo ">$rYear1</OPTION>";
                	} ?>
			</select></td>
		</tr>
		</table></td>				
	</tr>        	
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" height="30">
	<tr>
		<td bgcolor="#f4f4f4" align="center" style="font-family:arial;font-size:14px;font-weight:bold;">
		<input type="hidden" name="action" value="genericmcatinfo">
		<input type="submit" name="Submit1" value="Generate Report">
		</td>
	</tr>
	</table></form>
<?php }if($isGenericMcatInfo == 1){ ?>
	<table width="100%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="#ccccff" style="font-family:arial;font-size:13px;border-right: 1px solid #fff;" align="center"  >&nbsp;<B>Offer ID</b></td>

			<td bgcolor="#ccccff" style="font-family:arial;font-size:13px;border-right: 1px solid #fff;" align="left"  ><b>&nbsp;Lead Title</b></td>

			<td bgcolor="#ccccff" style="font-family:arial;font-size:13px;border-right: 1px solid #fff;" align="center" ><b>&nbsp;Approv Date Orig</b></td>

			<td bgcolor="#ccccff" style="font-family:arial;font-size:13px;border-right: 1px solid #fff;" align="left" ><b>&nbsp;Approved By</b></td>

			<td bgcolor="#ccccff" style="font-family:arial;font-size:13px;border-right: 1px solid #fff;" align="left" ><b>&nbsp;Mcat 1</b></td>

			<td bgcolor="#ccccff" style="font-family:arial;font-size:13px;border-right: 1px solid #fff;" align="left"  ><b>&nbsp;Mcat 2</b></td>
		</tr>

		<?php foreach($rec as $recK => $recR)
		{  ?>
			
			<tr>
				<td style="font-family:arial;font-size:13px;" align="center" >
				<a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&action=edit&search=y&offer=<?php echo $recR['ETO_OFR_DISPLAY_ID']; ?>&go=Go&mid=3424" target="_blank"><?php echo $recR['ETO_OFR_DISPLAY_ID']; ?></a></TD>
				<?php if(isset($recR['ETO_OFR_TITLE'])){ ?>
					<td style="font-family:arial;font-size:13px;" align="left" >&nbsp;<?php echo $recR['ETO_OFR_TITLE']; ?></TD>
				<?php }
				
						if($recR['APPROV_DATE_ORIG']){ ?>
							<td style="font-family:arial;font-size:13px;" align="center" ><?php echo $recR['APPROV_DATE_ORIG']; ?></TD>
						<?php }
						echo '<td style="font-family:arial;font-size:13px;" align="left" >&nbsp;';
						if($recR['APPROVED_BY']){
							echo $recR['APPROVED_BY'];	}
							echo "[ ";					
							if($recR['APPROVED_BY_NAME']){
								echo $recR['APPROVED_BY_NAME'];
							}
							echo "]</TD>";
						
						echo '<td style="font-family:arial;font-size:13px;" align="left" >&nbsp';
						if($recR['MCAT_ID1']) { ?>
							<?php echo $recR['MCAT_ID1'] ;}echo "[ ";
							if($recR['MCAT_NAME1']){
								echo $recR['MCAT_NAME1'];
							}
							echo "]</TD>";
						 
						echo '<td style="font-family:arial;font-size:13px;" align="left" >&nbsp;';
						if($recR['MCAT_ID2']){
								echo $recR['MCAT_ID2'];}
								echo "[ ";
								if($recR['MCAT_NAME2']){
									echo $recR['MCAT_NAME2'];							
								}
								echo "]";
						 echo "</TD>";?>			
			</tr>
		<?php } ?>
		</table>
		<div style="width:100%;">
		<div style="float:right; font-size:12px;padding-top:5px;"><?php echo $nav_link; ?></div></div>
<?php } ?>