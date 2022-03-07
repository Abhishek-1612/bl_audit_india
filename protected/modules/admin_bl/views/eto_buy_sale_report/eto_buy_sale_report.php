<?php
$this->pageTitle=Yii::app()->name . ' - Sales Report (Lead)';

 $fields = array('adate_day','adate_month','adate_year','bdate_day','bdate_month','bdate_year','modid','client');
	 $param=array();
	foreach ($fields as $x) 
	{
     		if (isset($_REQUEST[$x])) 
		{
        		$param[$x]=$_REQUEST[$x];
     		} 
		else 
		{
        		$param[$x]='';
     		}
  	}

 	list ($curr_sec,$curr_min,$curr_hour,$curr_day,$curr_month,$curr_year) = localtime(time());
	$curr_month = $curr_month+1;
	if($curr_month < 10)
	{
		$curr_month='0'.$curr_month;
	}
     $curr_year=$curr_year+1900;

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

	

	echo '
	<html>
	<head>	
	</head>
	<body>
	
	
	<script LANGUAGE="JavaScript" SRC="../protected/js/eto-buy-sale-report.js"></SCRIPT>';

	if($mesg)
	{
		echo  $mesg;
	}

	echo '
	<FORM name="searchForm" METHOD="post" ACTION="index.php?r=admin_bl/Eto_buy_sale_report/Index&mid=3441" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();">
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">PBL Sales Report (Enquiry Wise)</TD>
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
            <OPTION VALUE="0">Day</OPTION>';

		foreach (range(1,31) as $x) 
		{
			if($x < 10)
			{
				echo '<OPTION VALUE="0'.$x.'"';
				if ($param['bdate_day'] == '0'.$x) 
				{
					echo 'SELECTED';
				}
				elseif($x == $curr_day && !$param['bdate_day'])
				{
					echo ' SELECTED';
				}
				echo '>0'.$x.'</OPTION">';
			}
			else
			{
				echo '<OPTION VALUE="'.$x.'"';
				if ($param['bdate_day'] == $x) 
				{
					echo 'SELECTED';
				}
				elseif($x == $curr_day && !$param['bdate_day'])
				{
					echo  'SELECTED ';
				}
				echo '>'.$x.'</OPTION">';
			}  
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="bdate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';
		$months2=array_keys($months);
		foreach ($months2 as $x) {
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['bdate_month'] && $param['bdate_month'] == $x) {
                       echo 'SELECTED';
                   }
		elseif($x == $curr_month && !$param['bdate_month'])
		{
			echo 'SELECTED';
		}
                   echo '>'.$months[$x].'</OPTION">
                   ';
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="bdate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';

		foreach (range(($curr_year-5),($curr_year+5)) as $x) {
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['bdate_year'] && $param['bdate_year'] == $x) {
                       echo 'SELECTED ';
                   }
		elseif($x == $curr_year && !$param['bdate_year'])
		{
			echo 'SELECTED';
		}
                   echo '>'.$x.'</OPTION">
                   ';
                }
		echo '</SELECT></TD>


		<TD>&nbsp;to&nbsp;</TD>

		<TD><SELECT NAME="adate_day" SIZE="1">
            <OPTION VALUE="0">Day</OPTION>';

		foreach (range(1,31) as $x) 
		{
			if($x < 10)
			{
				echo '<OPTION VALUE="0'.$x.'"';
				if ($param['adate_day'] == '0'.$x) 
				{
					echo 'SELECTED';
				}
				elseif($x == $curr_day && !$param['adate_day'])
				{
					echo 'SELECTED';
				}
				echo '>0'.$x.'</OPTION">';
			}
			else
			{
				echo '<OPTION VALUE="'.$x.'"';
				if ($param['adate_day'] == $x) 
				{
					echo ' SELECTED ';
				}
				elseif($x == $curr_day && !$param['adate_day'])
				{
					echo ' SELECTED ';
				}
				echo '>'.$x.'</OPTION">';
			}  
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="adate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';
		 $months2=array_keys($months);
		 foreach($months2 as $x)
		 {
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['adate_month'] && $param['adate_month'] == $x) {
                      echo 'SELECTED';
                   }
		elseif($x == $curr_month && !$param['adate_month'])
		{
			echo 'SELECTED ';
		}
                   echo '>'.$months[$x].'</OPTION">
                   ';
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="adate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';

		foreach (range(($curr_year-5),($curr_year+5)) as $x) {
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['adate_year'] && $param['adate_year'] == $x) {
                       echo 'SELECTED';
                   }
		elseif($x == $curr_year && !$param['adate_year'])
		{
		echo ' SELECTED ';
		}
                   echo '>'.$x.'</OPTION">
                   ';
                }
		echo '</SELECT></TD>
		</TR>
		</TABLE></TD>
		<TD WIDTH="100" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Sales Source</TD>
		<TD BGCOLOR="#EAEAEA">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
		<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="0" CHECKED></TD>
		<TD STYLE="font-family:arial;font-size:12px;">All&nbsp;&nbsp;</TD>
		<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="ETO"';

		if ($param['modid'] && $param['modid'] == 'ETO')
		{
			echo 'CHECKED';
		}

		echo '></TD>
		<TD STYLE="font-family:arial;font-size:12px;">IndiaMART&nbsp;&nbsp;</TD>
		<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="HELLOTD"';

		if ($param['modid'] && $param['modid'] == 'HELLOTD')
		{
			echo 'CHECKED';
		}

		echo '></TD>
		<TD STYLE="font-family:arial;font-size:12px;">HelloTrade</TD>
		</TR>
		</TABLE></TD>
	</TR>


	<TR>
        
	<TD BGCOLOR="#EAEAEA"></TD><TD BGCOLOR="#EAEAEA"></TD>
	<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Purchase Type</TD>
        <TD BGCOLOR="#EAEAEA">
        <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
          <TR>
            <TD>

	    <SELECT NAME="client" SIZE="1" style="width:200px;">
	    <OPTION VALUE="0">All</OPTION><OPTION VALUE="1"';
		if($param['client']==1)
		{
			echo ' selected';
		}

		echo '>View Paid Purchased</OPTION>
		<OPTION VALUE="2"';
		if($param['client']==2)
		{
			echo  'selected';
		}

		echo '>View Free Purchased</OPTION>
		<OPTION VALUE="3"';
		if($param['client']==3)
		{
		   echo ' selected';
		}

		echo '>View Preferred Purchased</OPTION>
		</SELECT>
	  </TD>
          </TR>
        </TABLE>
	</TD>
      </TR>

	</TABLE>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
		<input type="hidden" name="action" value="sellstatus">
		<INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report">
		</TD>
	</TR>
	</TABLE></FORM>';
	 if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'sellstatus')
	      {
	
	
	 $bdate_day = isset($_REQUEST['bdate_day']) ? $_REQUEST['bdate_day'] : '';
		 $bdate_month = isset($_REQUEST['bdate_month']) ? $_REQUEST['bdate_month'] : '';
		 $bdate_year = isset($_REQUEST['bdate_year']) ? $_REQUEST['bdate_year'] : '';
		 $adate_day = isset($_REQUEST['adate_day']) ? $_REQUEST['adate_day'] : '';
		 $adate_month = isset($_REQUEST['adate_month']) ? $_REQUEST['adate_month'] : '';
		 $adate_year = isset($_REQUEST['adate_year']) ? $_REQUEST['adate_year'] : '';

		 $modid = isset($_REQUEST['modid']) ? $_REQUEST['modid'] : '';
		 $offertype = isset($_REQUEST['offertype']) ? $_REQUEST['offertype'] : 1;
		 $country_quality = isset($_REQUEST['country_quality']) ? $_REQUEST['country_quality'] : '';

		 $client = isset($_REQUEST['client']) ? $_REQUEST['client'] : 0;
		 $space = '';
       echo '<script LANGUAGE="JavaScript" SRC="../protected/js/eto-buy-sale-report.js"></SCRIPT>';

		#################### New Design ############################

		echo '<div><br></div>
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding:3px;color:006FB6;">
		Showing PBL Sales Report (Enquiry Wise) From:'.$space.' '. $bdate_day.' '.$months[$bdate_month].' '.$bdate_year.' '.$space.'To:'.$space.' '. $adate_day.' '.$months[$adate_month].' '.$adate_year.'
		<DIV STYLE="font-size:11px;color:#000000;font-weight:normal;">
		(<FONT COLOR="#FF0000">*</FONT>) Indicates Preferred Enquiry | <IMG SRC="../images/paid-usr.gif" ALT="Paid Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Paid Clients (Havinig atleast one Paid Credit Transaction) | <IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Free Clients | <IMG SRC="../images/paid-usr1.gif" ALT="Preferred Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Preferred Clients
		</DIV>
		</DIV>';
		
		
		echo '
		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
		<TR>
			<TD BGCOLOR="#E5E5E5" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" 
			WIDTH="40%">&nbsp;Buy Lead Details</TD>
			<TD BGCOLOR="#FFFFFF" WIDTH="60%">
			<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1" HEIGHT="30">
			<TR>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" WIDTH="12%">&nbsp;<B>GL User</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" WIDTH="30%"><B>&nbsp;Company</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" WIDTH="22%"><B>&nbsp;City / Country</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" WIDTH="12%"><B>&nbsp;Purchased On</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" WIDTH="12%"><B>&nbsp;Credit Used</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" WIDTH="8%"><B>&nbsp;Avg Amt</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" WIDTH="4%"><B>&nbsp;Src</B></TD>
			</TR>
			</TABLE></TD>
		</TR>
		</TABLE>
		<input type="hidden" name="offer_details" id="offer_details" value="0">';

		 $seq=0;
		 $i = 0;
		 $totalCredit=0;
		 $totalAvgPrice=0;
		 $avgPrice=0;
		 $totalOfferPur =0;

		 $summaryOfferCountPaid=0;
		 $summaryOfferCountFree=0;
		 $summaryOfferCountPref=0;

		 $summaryCreditCount=0;
		 $summaryCreditCountPaid=0;
		 $summaryCreditCountFree=0;
		 $summaryCreditCountPref=0;

		 $summaryAvgPriceCount=0;
		 $summaryAvgPriceCountPaid=0;
		 $summaryAvgPriceCountFree=0;
		 $summaryAvgPriceCountPref=0;

		 $distinctOffers=0;
		 $distinctGlusers=0;
		 $hash_glusers = array();

		
		echo '<TABLE WIDTH="100%" BORDER="1" CELLPADDING="0" CELLSPACING="0" STYLE="border-collapse:collapse;" BORDERCOLOR="#EAEAEA">';
                if($dbtype=='PG'){
                while ( $rec =  pg_fetch_array($sth)) 
		{
                    $rec=array_change_key_case($rec, CASE_UPPER); 
		
                         if(isset($rec['GLUSR_STATUS']))
                         {
			 $status =$rec['GLUSR_STATUS'];
			 }
			 else
			 {
			 $status=0;
			 }
			$i++;
			if($rec['SEQ'] != $seq && $i != 1)
			{
				echo '</TABLE>
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR="#E1EAE0">
				<TR>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%" BGCOLOR="#DFDFFF">&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="30%" BGCOLOR="#DFDFFF">&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:12px;color:#0000AA;" WIDTH="22%" ALIGN="RIGHT" BGCOLOR="#DFDFFF"><B>Lead Summary</B>&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="12%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalOfferPur.' Purchase</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="12%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalCredit.' Credits</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="8%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalAvgPrice.'</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="4%" BGCOLOR="#DFDFFF">&nbsp;</TD>
				</TR>
				</TABLE>
				</TD>
				</TR>';
				$totalCredit=0;
				$totalAvgPrice=0;
				$totalOfferPur=0;
			}
			
			$totalOfferPur++;
			$totalCredit=$totalCredit+$rec['ETO_CREDITS_USED'];
			$summaryCreditCount=$summaryCreditCount+$rec['ETO_CREDITS_USED'];

			$avgPrice=$rec['ETO_CREDITS_USED']*$rec['AVG_PER_CREDIT_COST'];
			$avgPrice = sprintf("%.2f",$avgPrice);
			$totalAvgPrice=sprintf("%.2f",$totalAvgPrice+$avgPrice);
			$summaryAvgPriceCount=sprintf("%.2f",$summaryAvgPriceCount+$avgPrice);

			 $bgcolor2='#f7f7f7';
			if($totalOfferPur % 2 == 0)
			{
				$bgcolor2='#eeeeee';
			}

			if($rec['SEQ'] != $seq)
			{
				$distinctOffers++;
				#change by gunjan
				 $mainDesc = $rec['ETO_OFR_DESC'];
				 $mainDesc = preg_replace('/(<\s*a\b.*?\/\s*a\s*>)|(<\s*\/?\s*a\b.*?\s*>)/i', '',$mainDesc);
                                 $mainDesc = preg_replace('/(<\s*img\b.*?\s*>)/i', '',$mainDesc);
                                 $mainDesc = preg_replace('/(http|www)(.*?)(\s+?|$)/i', '',$mainDesc);
                                 $mainDesc = preg_replace('/\b([\w\-\_\.]*?)(\@[\w\-\_\.]*?)(\s+?|$)/i', '',$mainDesc);
    
				//$mainDesc = $this->removeUnwantedInfo($mainDesc);
				$mainDesc = preg_replace('/\n/','<BR>',$mainDesc);
				//$mainDesc =~ s/\n/<BR>\n/g;
				$mainDesc = preg_replace('/\t/','&nbsp;&nbsp;&nbsp;&nbsp;',$mainDesc);
				//$mainDesc =~ s/\t/&nbsp;&nbsp;&nbsp;&nbsp;/g;
				#end
	
				 $title=$mainDesc;
				 $title1='';
				if (strlen($title)>96)
				{
					$title = substr($title,0,96);
					$title .= "...";
					$title1 = substr($mainDesc,96,strlen($mainDesc));
				}
				 $img='';
				 $bgcolor='';
				 $bgcolor1='#f9f9f9';

				if(isset($rec['ETO_OFR_PREFERED_FK_GLUSR_ID']))
				{
					$img .='<font color="red">*</font>';
					$bgcolor='ffffca';
					$bgcolor1=$bgcolor;
				}

				echo '<TR>
				<TD bgcolor="'.$bgcolor1.'" WIDTH="40%" VALIGN="TOP">
				<DIV STYLE="font-family:arial;font-size:12px;padding:5px;">Offer Posting Date: '.$rec['OFFER_DATE'].'<BR>
				<B>'.$img.' '.$rec['ETO_OFR_TITLE'].'<FONT COLOR="#0000FF"> ['.$rec['GLUSR_COUNTRY'].'] </FONT></B><BR>'.$space.' 
				'.$title.' '.$space.'<BR>
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" STYLE="border-collapse:collapse;" BORDERCOLOR="#EAEAEA">
				<TR>
				<TD WIDTH="100%" VALIGN="TOP" onclick="javascript:showDetail('.$i.');"; style="cursor:pointer;">
				<FONT COLOR="#0000FF" size="2"><u>more details</u></font>
				</td></tr></table>';
				
				echo '
				<div id="div'.$i.'" style="display:none;">
				'.$title1.'';

				if(isset($rec['ETO_OFR_QTY']))
				{
					echo '<BR>Preferred Quantity: '.$rec['ETO_OFR_QTY'].'';
				}
			
				if(isset($rec['ETO_OFR_SUPPLY_TERM']))
				{
					echo '<BR>Delivery Terms:'. $rec['ETO_OFR_SUPPLY_TERM'].'';
				}
			
				if(isset($rec['ETO_OFR_PAY_TERM']))
				{
					echo '<BR>Payment Terms: '.$rec['ETO_OFR_PAY_TERM'].'';
				}
		
				if(isset($rec['ETO_OFR_PAGE_REFERRER']))
				{
				     echo '<BR>Enquiry Source: <a href="'.$rec['ETO_OFR_PAGE_REFERRER'].'" target="_new">'.$rec['ETO_OFR_PAGE_REFERRER'].'</a>';
				}

				if(isset($rec['ETO_OFR_S_IP']))
				{
					echo '<BR>
					This enquiry has been generated through IP:- '.$rec['ETO_OFR_S_IP'].'';
					if($rec['ETO_OFR_S_IP_COUNTRY'] != 'NA')
					{
						echo ' ('.$rec['ETO_OFR_S_IP_COUNTRY'].')';
					}
				}

				echo '<BR><BR>
				<B>Buyer\'s Information-</B><BR>
				<DIV>Name: '.$rec['GLUSR_NAME'].'';
	
				if(isset($rec['GLUSR_DESIGNATION']))
				{
					echo ' ('.$rec['GLUSR_DESIGNATION'].')';
				}
				echo '</div>';
	
				if(isset($rec['GLUSR_COMPANY']))
				{
					echo '<div>Company:'. $rec['GLUSR_COMPANY'].'</div>';
				}
	
				if(isset($rec['GLUSR_ADDRESS']))
				{
					echo '<DIV>Address:'. $rec['GLUSR_ADDRESS'].'</DIV>';
				}
	
				if(isset($rec['GLUSR_CITY']))
				{
					echo '<DIV>City: '.$rec['GLUSR_CITY'].'</DIV>';
				}
		
				if(isset($rec['GLUSR_STATE']))
				{
					echo '<DIV>State:'. $rec['GLUSR_STATE'].'</DIV> ';
				}
	
				echo '<DIV>Country:'. $rec['GLUSR_COUNTRY'].'</DIV>';
				if(isset($rec['GLUSR_ZIP']))
				{
					echo '<DIV>Postal Code: '.$rec['GLUSR_ZIP'].'</DIV>';
				}
				
				echo '<div>Telephone: '.$rec['GLUSR_PHONE'].'</div>';
				
				if(isset($rec['GLUSR_USR_FAX_NUMBER']))
				{	
					echo '<div>Fax: '.$rec['GLUSR_FAX'].'</div>';
				}
			
				if(isset($rec['GLUSR_MOBILE']))
				{
					 $mobile = '+('.$rec['GLUSR_USR_PH_COUNTRY'].')-'.$rec['GLUSR_MOBILE'].'';
					if(isset($rec['GLUSR_USR_PH_MOBILE_ALT']))
					{
						$mobile .= '/'.$rec['GLUSR_USR_PH_MOBILE_ALT'].'';
					}
					echo '
					<div>Mobile / Cell Phone: '.$mobile.'</div>';
				}

				echo '
				<div>Email: '.$rec['GLUSR_USR_EMAIL'].'</div>';
	
				 $length_url = isset($rec['ETO_OFR_GLUSR_DISP_URL']) ? $rec['ETO_OFR_GLUSR_DISP_URL'] : '';
				if($length_url)
				{	
					echo '
					<DIV>Website: <A HREF="'.$rec['ETO_OFR_GLUSR_DISP_URL'].'" target="_new">$length_url</A></DIV>';
				}

				echo '</div>
				</DIV></TD>
				<TD WIDTH="60%" VALIGN="TOP">
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR="#E1EAE0" STYLE="border-collapse:collapse;">';
			}

			if(isset($hash_glusers[$rec['FK_GLUSR_USR_ID']]) != $rec['FK_GLUSR_USR_ID'])
			{
				$hash_glusers[$rec['FK_GLUSR_USR_ID']]=$rec['FK_GLUSR_USR_ID'];
				$distinctGlusers++;
			}

			echo '
			<TR bgcolor="'.$bgcolor2.'">
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%">';

				if($status == 1)
				{
					echo '<IMG SRC="../images/paid-usr.gif" ALT="Paid Credit Used" WIDTH="8" HEIGHT="8" HSPACE="4">';
					if(isset($rec['PREFERRED_STATUS']) && $rec['PREFERRED_STATUS'] != 0)
					{
						echo '&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="4">';
					}

					if(isset($rec['ETO_OFR_PREFERED_FK_GLUSR_ID']))
					{
						$summaryOfferCountPref++;
						$summaryCreditCountPref = $summaryCreditCountPref+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountPref=sprintf("%.2f",$summaryAvgPriceCountPref+$avgPrice);
					}
					else
					{
						$summaryOfferCountPaid++;
						$summaryCreditCountPaid = $summaryCreditCountPaid+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountPaid=sprintf("%.2f",$summaryAvgPriceCountPaid+$avgPrice);
					}
				}
				else
				{
					echo '<IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="4">';

					if(isset($rec['PREFERRED_STATUS']) && $rec['PREFERRED_STATUS'] !=0)
					{
						echo '&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="4">';
					}

					if(isset($rec['ETO_OFR_PREFERED_FK_GLUSR_ID']))
					{
						$summaryOfferCountPref++;
						$summaryCreditCountPref = $summaryCreditCountPref+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountPref=sprintf("%.2f",$summaryAvgPriceCountPref+$avgPrice);
					}
					else
					{
						$summaryOfferCountFree++;
						$summaryCreditCountFree = $summaryCreditCountFree+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountFree=sprintf("%.2f",$summaryAvgPriceCountFree+$avgPrice);
					}
				}
				
			$global_model=new GlobalmodelForm();
                        $dbh_mesh = $global_model->connect_db();
                        $loginUserDet=$global_model->getUserDetails(__FILE__, __LINE__,$dbh_mesh,$rec['FK_GLUSR_USR_ID'],0);
	               // $loginUserDet = GLUsrPublic->getUserDetails(__FILE__,__LINE__,$dbh,$rec['FK_GLUSR_USR_ID'},0);
				 $country = isset($loginUserDet['country']) ? $loginUserDet['country'] : '';
				 $city = isset( $loginUserDet['city']) ? $loginUserDet['city'] : '';
				 $company = isset($loginUserDet['company_name']) ? $loginUserDet['company_name'] : '';

				echo '<A HREF="javascript:popup(\'/index.php?r=admin_bl/Transaction_report/Index/action/transDetails&mid=3441&nofrm=1&glusrid='.$rec['FK_GLUSR_USR_ID'].'\');">'.$rec['FK_GLUSR_USR_ID'].'</A></TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="30%">'.$company.'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="22%">';

				if($city)
				{
					echo ''.$city.' / ';
				}
				echo ''.$country.'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%">'.$rec['PUR_DATE'].'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%">'.$rec['ETO_CREDITS_USED'].' Credits</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="8%">'.$avgPrice.'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="4%"><FONT COLOR="red"><B>'.$rec['ETO_LEAD_FK_GL_MODULE_ID'].'</B></FONT></TD>
			</TR>';
			$seq = $rec['SEQ'];
		}

                }else{
                    while ( $rec =  oci_fetch_assoc($sth)) 
		{

		
                         if(isset($rec['GLUSR_STATUS']))
                         {
			 $status =$rec['GLUSR_STATUS'];
			 }
			 else
			 {
			 $status=0;
			 }
			$i++;
			if($rec['SEQ'] != $seq && $i != 1)
			{
				echo '</TABLE>
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR="#E1EAE0">
				<TR>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%" BGCOLOR="#DFDFFF">&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="30%" BGCOLOR="#DFDFFF">&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:12px;color:#0000AA;" WIDTH="22%" ALIGN="RIGHT" BGCOLOR="#DFDFFF"><B>Lead Summary</B>&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="12%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalOfferPur.' Purchase</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="12%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalCredit.' Credits</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="8%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalAvgPrice.'</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="4%" BGCOLOR="#DFDFFF">&nbsp;</TD>
				</TR>
				</TABLE>
				</TD>
				</TR>';
				$totalCredit=0;
				$totalAvgPrice=0;
				$totalOfferPur=0;
			}
			
			$totalOfferPur++;
			$totalCredit=$totalCredit+$rec['ETO_CREDITS_USED'];
			$summaryCreditCount=$summaryCreditCount+$rec['ETO_CREDITS_USED'];

			$avgPrice=$rec['ETO_CREDITS_USED']*$rec['AVG_PER_CREDIT_COST'];
			$avgPrice = sprintf("%.2f",$avgPrice);
			$totalAvgPrice=sprintf("%.2f",$totalAvgPrice+$avgPrice);
			$summaryAvgPriceCount=sprintf("%.2f",$summaryAvgPriceCount+$avgPrice);

			 $bgcolor2='#f7f7f7';
			if($totalOfferPur % 2 == 0)
			{
				$bgcolor2='#eeeeee';
			}

			if($rec['SEQ'] != $seq)
			{
				$distinctOffers++;
				#change by gunjan
				 $mainDesc = $rec['ETO_OFR_DESC'];
				 $mainDesc = preg_replace('/(<\s*a\b.*?\/\s*a\s*>)|(<\s*\/?\s*a\b.*?\s*>)/i', '',$mainDesc);
                                 $mainDesc = preg_replace('/(<\s*img\b.*?\s*>)/i', '',$mainDesc);
                                 $mainDesc = preg_replace('/(http|www)(.*?)(\s+?|$)/i', '',$mainDesc);
                                 $mainDesc = preg_replace('/\b([\w\-\_\.]*?)(\@[\w\-\_\.]*?)(\s+?|$)/i', '',$mainDesc);
    
				//$mainDesc = $this->removeUnwantedInfo($mainDesc);
				$mainDesc = preg_replace('/\n/','<BR>',$mainDesc);
				//$mainDesc =~ s/\n/<BR>\n/g;
				$mainDesc = preg_replace('/\t/','&nbsp;&nbsp;&nbsp;&nbsp;',$mainDesc);
				//$mainDesc =~ s/\t/&nbsp;&nbsp;&nbsp;&nbsp;/g;
				#end
	
				 $title=$mainDesc;
				 $title1='';
				if (strlen($title)>96)
				{
					$title = substr($title,0,96);
					$title .= "...";
					$title1 = substr($mainDesc,96,strlen($mainDesc));
				}
				 $img='';
				 $bgcolor='';
				 $bgcolor1='#f9f9f9';

				if(isset($rec['ETO_OFR_PREFERED_FK_GLUSR_ID']))
				{
					$img .='<font color="red">*</font>';
					$bgcolor='ffffca';
					$bgcolor1=$bgcolor;
				}

				echo '<TR>
				<TD bgcolor="'.$bgcolor1.'" WIDTH="40%" VALIGN="TOP">
				<DIV STYLE="font-family:arial;font-size:12px;padding:5px;">Offer Posting Date: '.$rec['OFFER_DATE'].'<BR>
				<B>'.$img.' '.$rec['ETO_OFR_TITLE'].'<FONT COLOR="#0000FF"> ['.$rec['GLUSR_COUNTRY'].'] </FONT></B><BR>'.$space.' 
				'.$title.' '.$space.'<BR>
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" STYLE="border-collapse:collapse;" BORDERCOLOR="#EAEAEA">
				<TR>
				<TD WIDTH="100%" VALIGN="TOP" onclick="javascript:showDetail('.$i.');"; style="cursor:pointer;">
				<FONT COLOR="#0000FF" size="2"><u>more details</u></font>
				</td></tr></table>';
				
				echo '
				<div id="div'.$i.'" style="display:none;">
				'.$title1.'';

				if(isset($rec['ETO_OFR_QTY']))
				{
					echo '<BR>Preferred Quantity: '.$rec['ETO_OFR_QTY'].'';
				}
			
				if(isset($rec['ETO_OFR_SUPPLY_TERM']))
				{
					echo '<BR>Delivery Terms:'. $rec['ETO_OFR_SUPPLY_TERM'].'';
				}
			
				if(isset($rec['ETO_OFR_PAY_TERM']))
				{
					echo '<BR>Payment Terms: '.$rec['ETO_OFR_PAY_TERM'].'';
				}
		
				if(isset($rec['ETO_OFR_PAGE_REFERRER']))
				{
				     echo '<BR>Enquiry Source: <a href="'.$rec['ETO_OFR_PAGE_REFERRER'].'" target="_new">'.$rec['ETO_OFR_PAGE_REFERRER'].'</a>';
				}

				if(isset($rec['ETO_OFR_S_IP']))
				{
					echo '<BR>
					This enquiry has been generated through IP:- '.$rec['ETO_OFR_S_IP'].'';
					if($rec['ETO_OFR_S_IP_COUNTRY'] != 'NA')
					{
						echo ' ('.$rec['ETO_OFR_S_IP_COUNTRY'].')';
					}
				}

				echo '<BR><BR>
				<B>Buyer\'s Information-</B><BR>
				<DIV>Name: '.$rec['GLUSR_NAME'].'';
	
				if(isset($rec['GLUSR_DESIGNATION']))
				{
					echo ' ('.$rec['GLUSR_DESIGNATION'].')';
				}
				echo '</div>';
	
				if(isset($rec['GLUSR_COMPANY']))
				{
					echo '<div>Company:'. $rec['GLUSR_COMPANY'].'</div>';
				}
	
				if(isset($rec['GLUSR_ADDRESS']))
				{
					echo '<DIV>Address:'. $rec['GLUSR_ADDRESS'].'</DIV>';
				}
	
				if(isset($rec['GLUSR_CITY']))
				{
					echo '<DIV>City: '.$rec['GLUSR_CITY'].'</DIV>';
				}
		
				if(isset($rec['GLUSR_STATE']))
				{
					echo '<DIV>State:'. $rec['GLUSR_STATE'].'</DIV> ';
				}
	
				echo '<DIV>Country:'. $rec['GLUSR_COUNTRY'].'</DIV>';
				if(isset($rec['GLUSR_ZIP']))
				{
					echo '<DIV>Postal Code: '.$rec['GLUSR_ZIP'].'</DIV>';
				}
				
				echo '<div>Telephone: '.$rec['GLUSR_PHONE'].'</div>';
				
				if(isset($rec['GLUSR_USR_FAX_NUMBER']))
				{	
					echo '<div>Fax: '.$rec['GLUSR_FAX'].'</div>';
				}
			
				if(isset($rec['GLUSR_MOBILE']))
				{
					 $mobile = '+('.$rec['GLUSR_USR_PH_COUNTRY'].')-'.$rec['GLUSR_MOBILE'].'';
					if(isset($rec['GLUSR_USR_PH_MOBILE_ALT']))
					{
						$mobile .= '/'.$rec['GLUSR_USR_PH_MOBILE_ALT'].'';
					}
					echo '
					<div>Mobile / Cell Phone: '.$mobile.'</div>';
				}

				echo '
				<div>Email: '.$rec['GLUSR_USR_EMAIL'].'</div>';
	
				 $length_url = isset($rec['ETO_OFR_GLUSR_DISP_URL']) ? $rec['ETO_OFR_GLUSR_DISP_URL'] : '';
				if($length_url)
				{	
					echo '
					<DIV>Website: <A HREF="'.$rec['ETO_OFR_GLUSR_DISP_URL'].'" target="_new">$length_url</A></DIV>';
				}

				echo '</div>
				</DIV></TD>
				<TD WIDTH="60%" VALIGN="TOP">
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR="#E1EAE0" STYLE="border-collapse:collapse;">';
			}

			if(isset($hash_glusers[$rec['FK_GLUSR_USR_ID']]) != $rec['FK_GLUSR_USR_ID'])
			{
				$hash_glusers[$rec['FK_GLUSR_USR_ID']]=$rec['FK_GLUSR_USR_ID'];
				$distinctGlusers++;
			}

			echo '
			<TR bgcolor="'.$bgcolor2.'">
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%">';

				if($status == 1)
				{
					echo '<IMG SRC="../images/paid-usr.gif" ALT="Paid Credit Used" WIDTH="8" HEIGHT="8" HSPACE="4">';
					if(isset($rec['PREFERRED_STATUS']) && $rec['PREFERRED_STATUS'] != 0)
					{
						echo '&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="4">';
					}

					if(isset($rec['ETO_OFR_PREFERED_FK_GLUSR_ID']))
					{
						$summaryOfferCountPref++;
						$summaryCreditCountPref = $summaryCreditCountPref+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountPref=sprintf("%.2f",$summaryAvgPriceCountPref+$avgPrice);
					}
					else
					{
						$summaryOfferCountPaid++;
						$summaryCreditCountPaid = $summaryCreditCountPaid+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountPaid=sprintf("%.2f",$summaryAvgPriceCountPaid+$avgPrice);
					}
				}
				else
				{
					echo '<IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="4">';

					if(isset($rec['PREFERRED_STATUS']) && $rec['PREFERRED_STATUS'] !=0)
					{
						echo '&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="4">';
					}

					if(isset($rec['ETO_OFR_PREFERED_FK_GLUSR_ID']))
					{
						$summaryOfferCountPref++;
						$summaryCreditCountPref = $summaryCreditCountPref+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountPref=sprintf("%.2f",$summaryAvgPriceCountPref+$avgPrice);
					}
					else
					{
						$summaryOfferCountFree++;
						$summaryCreditCountFree = $summaryCreditCountFree+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountFree=sprintf("%.2f",$summaryAvgPriceCountFree+$avgPrice);
					}
				}
				
			$global_model=new GlobalmodelForm();
                        $dbh_mesh = $global_model->connect_db();
                        $loginUserDet=$global_model->getUserDetails(__FILE__, __LINE__,$dbh_mesh,$rec['FK_GLUSR_USR_ID'],0);
	               // $loginUserDet = GLUsrPublic->getUserDetails(__FILE__,__LINE__,$dbh,$rec['FK_GLUSR_USR_ID'},0);
				 $country = isset($loginUserDet['country']) ? $loginUserDet['country'] : '';
				 $city = isset( $loginUserDet['city']) ? $loginUserDet['city'] : '';
				 $company = isset($loginUserDet['company_name']) ? $loginUserDet['company_name'] : '';

				echo '<A HREF="javascript:popup(\'/index.php?r=admin_bl/Transaction_report/Index/action/transDetails&mid=3441&nofrm=1&glusrid='.$rec['FK_GLUSR_USR_ID'].'\');">'.$rec['FK_GLUSR_USR_ID'].'</A></TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="30%">'.$company.'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="22%">';

				if($city)
				{
					echo ''.$city.' / ';
				}
				echo ''.$country.'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%">'.$rec['PUR_DATE'].'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%">'.$rec['ETO_CREDITS_USED'].' Credits</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="8%">'.$avgPrice.'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="4%"><FONT COLOR="red"><B>'.$rec['ETO_LEAD_FK_GL_MODULE_ID'].'</B></FONT></TD>
			</TR>';
			$seq = $rec['SEQ'];
		}

                }
                    
		
		if($i > 0)
		{
			echo '</TABLE>
			<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR="#E1EAE0">
			<TR>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%" BGCOLOR="#DFDFFF">&nbsp;</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="30%" BGCOLOR="#DFDFFF">&nbsp;</TD>
			<TD STYLE="font-family:arial;font-size:12px;color:#0000AA;" WIDTH="22%" ALIGN="RIGHT" BGCOLOR="#DFDFFF"><B>Lead Summary</B>&nbsp;</TD>
			<TD STYLE="font-family:arial;font-size:12px;" WIDTH="12%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalOfferPur.' Purchase</B></TD>
			<TD STYLE="font-family:arial;font-size:12px;" WIDTH="12%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalCredit.' Credits</B></TD>
			<TD STYLE="font-family:arial;font-size:12px;" WIDTH="8%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalAvgPrice.'</B></TD>
			<TD STYLE="font-family:arial;font-size:12px;" WIDTH="4%" BGCOLOR="#DFDFFF">&nbsp;</TD>
			</TR>
			</TABLE>
			</TD></TR>';
		}

		echo '</TABLE>

		<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" align="right" width="100%">
		<tr>
		<td width="40%">
		<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" align="left" width="100%">
		<TR BGCOLOR="#FFFFFF">
		<TD STYLE="font-family:arial;font-size:12px;" colspan="2" align="left" width="100%" height="30">
		<FONT size="3"><B>Unique-</B></font></TD>
		</TR>
		<TR BGCOLOR="#E1EAE0">
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="50%"><B>Offers</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="50%"><B>GLUsers</B></TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="50%">'.$distinctOffers.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="50%">'.$distinctGlusers.'</TD>
		</TR>
		</table>
		</td>
		<td width="60%">
		<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" align="right" width="100%">
		<TR BGCOLOR="#FFFFFF">
		<TD STYLE="font-family:arial;font-size:12px;" colspan="5" align="left" width="100%" height="30">
		<FONT size="3"><B>Summary-</B></font></TD>
		</TR>
		<TR BGCOLOR="#E1EAE0">
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%" height="30"><B>Detail</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Paid</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Free</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Pref</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total</B></TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%" height="30">Offer Purchase Count</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryOfferCountPaid.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryOfferCountFree.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryOfferCountPref.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$i.'</TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%" height="30">Credit Used</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryCreditCountPaid.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryCreditCountFree.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryCreditCountPref.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryCreditCount.'</TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%" height="30">Avg Amount</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryAvgPriceCountPaid.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryAvgPriceCountFree.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryAvgPriceCountPref.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$summaryAvgPriceCount.'</TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%"><div><BR></div></TD>
		</TR>
		</TABLE>
		</td>
		</tr>
		</table>
		</body>
		</html>';
		
	}
