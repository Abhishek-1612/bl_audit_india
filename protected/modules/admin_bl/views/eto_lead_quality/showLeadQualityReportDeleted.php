<?php

 $city = '';
 $mcat = '';
 $quant= '';
 $comp= '';
 $GL_PUBLIC= '';
 $GL_PRIVATE= '';
 $desc = '';
 $desc_lth= '';
 $verf= '';
 $notverf= '';
 $enrich= '';
 $enrich_only= '';
 $web= '';
 $add= '';
 $pageref= '';





if(isset($rec['TOTAL_APPROV']) &&  $rec['TOTAL_APPROV'] != 0)
{
 $citys = ($rec_sold['CITY_TOTAL']/$rec['TOTAL_APPROV']) * 100;

$citys = round($citys,2);
 $mcats = ($rec_sold['MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$mcats = round($mcats,2);
 $quants = ($rec_sold['QTY_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $quants = round($quants,2);

 $comps = ($rec_sold['COMPANY_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $comps = round($comps,2);
 $GL_PUBLICs = ($rec_sold['GL_PUBLIC_LTD_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$GL_PUBLICs = round($GL_PUBLICs,2);
 $GL_PRIVATEs = ($rec_sold['GL_PRIVATE_LTD_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$GL_PRIVATEs = round( $GL_PRIVATEs,2);
 $descs = ($rec_sold['DESC_GT_200_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$descs = round( $descs,2);
$descs1 = ($rec_sold['DESC_GT_150_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$descs1 = round( $descs1,2);
$descs2 = ($rec_sold['DESC_GT_100_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$descs2 = round( $descs2,2);

 $verfs = ($rec_sold['VERIFIED_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $verfs = round( $verfs,2);
 $notverfs = ($rec_sold['NOT_VERIFIED_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $notverfs = round( $notverfs,2);
 $enrichs = ($rec_sold['ENRICH_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $enrichs = round( $enrichs,2);
 $enrich_onlys = ($rec_sold['ENRICHED_ONLY_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $enrich_onlys = round( $enrich_onlys,2);
 $webs = ($rec_sold['WEBSITE_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $webs = round( $webs,2);
 $adds = ($rec_sold['ADDRESS_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $adds = round( $adds,2);
 $temails = ($rec_sold['EMAIL_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $temails = round( $temails,2);
 $pagerefs = ($rec_sold['PAGE_REFERRER_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $pagerefs = round( $pagerefs,2);
 
 $tiletotals = ($rec_sold['TITLE_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $tiletotals = round( $tiletotals,2);
 $apxovalues = ($rec_sold['ORDER_VALUE_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $apxovalues = round( $apxovalues,2);
 $trectypes = ($rec_sold['TOTAL_REQ_TYPE']/$rec['TOTAL_APPROV']) * 100;
 $trectypes = round( $trectypes,2);
 $tpostingprps = ($rec_sold['TOTAL_POSTING_PURP']/$rec['TOTAL_APPROV']) * 100;
 $tpostingprps = round( $tpostingprps,2);
 $tsuplocs = ($rec_sold['TOTAL_SUP_LOC']/$rec['TOTAL_APPROV']) * 100;
 $tsuplocs = round( $tsuplocs,2);
 $trecfreqs = ($rec_sold['TOTAL_REQ_FREQUENCY']/$rec['TOTAL_APPROV']) * 100;
 $trecfreqs = round( $trecfreqs,2);
 
 $tpurperiods = ($rec_sold['TOTAL_PUR_PERIOD']/$rec['TOTAL_APPROV']) * 100;
 $tpurperiods = round( $tpurperiods,2);
 
 
 $isqs1 = ($rec_isq['ISQ1_UNIQ_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isqs1 = round( $isqs1,2);
 $isqs2 = ($rec_isq['ISQ2_UNIQ_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isqs2 = round( $isqs2,2);
 $isqs3 = ($rec_isq['ISQ3_UNIQ_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isqs3 = round( $isqs3,2);
 $isqs4 = ($rec_isq['ISQ4_UNIQ_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isqs4 = round( $isqs4,2);
 
 $isqs5 = ($rec_isq['ISQ5_UNIQ_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isqs5 = round( $isqs5,2);
 
 $isq1 = ($rec_isq['ISQ1_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isq1 = round( $isq1,2);
 $isq2 = ($rec_isq['ISQ2_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isq2 = round( $isq2,2);
 $isq3 = ($rec_isq['ISQ3_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isq3 = round( $isq3,2);
 $isq4 = ($rec_isq['ISQ4_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isq4 = round( $isq4,2);
 
 $isq5 = ($rec_isq['ISQ5_CNT']/$rec['TOTAL_APPROV']) * 100;
 $isq5 = round($isq5,2);
 
 ///////////////////////////////////////////
 $city = ($rec['CITY_TOTAL']/$rec['TOTAL_APPROV']) * 100;

$city = round($city,2);
 $mcat = ($rec['MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100;

 $quant = ($rec['QTY_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $quant = round($quant,2);

 $comp = ($rec['COMPANY_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $comp = round($comp,2);
 $GL_PUBLIC = ($rec['GL_PUBLIC_LTD_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$GL_PUBLIC = round($GL_PUBLIC,2);
 $GL_PRIVATE = ($rec['GL_PRIVATE_LTD_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$GL_PRIVATE = round( $GL_PRIVATE,2);
 $desc = ($rec['DESC_GT_200_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$desc = round( $desc,2);
$desc1 = ($rec['DESC_GT_150_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$desc1 = round( $desc1,2);
$desc2 = ($rec['DESC_GT_100_TOTAL']/$rec['TOTAL_APPROV']) * 100;
$desc2 = round( $desc2,2);

 $verf = ($rec['VERIFIED_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $verf = round( $verf,2);
 $notverf = ($rec['NOT_VERIFIED_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $notverf = round( $notverf,2);
 $enrich = ($rec['ENRICH_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $enrich = round( $enrich,2);
 $enrich_only = ($rec['ENRICHED_ONLY_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $enrich_only = round( $enrich_only,2);
 $web = ($rec['WEBSITE_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $web = round( $web,2);
 $add = ($rec['ADDRESS_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $add = round( $add,2);
 $temail = ($rec['EMAIL_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $temail = round( $temail,2);
 $pageref = ($rec['PAGE_REFERRER_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $pageref = round( $pageref,2);
 
 $tiletotal = ($rec['TITLE_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $tiletotal = round( $tiletotal,2);
 $apxovalue = ($rec['ORDER_VALUE_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 $apxovalue = round( $apxovalue,2);
 $trectype = ($rec['TOTAL_REQ_TYPE']/$rec['TOTAL_APPROV']) * 100;
 $trectype = round( $trectype,2);
 $tpostingprp = ($rec['TOTAL_POSTING_PURP']/$rec['TOTAL_APPROV']) * 100;
 $tpostingprp = round( $tpostingprp,2);
 $tsuploc = ($rec['TOTAL_SUP_LOC']/$rec['TOTAL_APPROV']) * 100;
 $tsuploc = round( $tsuploc,2);
 $trecfreq = ($rec['TOTAL_REQ_FREQUENCY']/$rec['TOTAL_APPROV']) * 100;
 $trecfreq = round( $trecfreq,2);
 
 $tpurperiod = ($rec['TOTAL_PUR_PERIOD']/$rec['TOTAL_APPROV']) * 100;
 $tpurperiod = round( $tpurperiod,2);
 }
else
{
 $city = 0;
 $city = round( $city);

 $mcat = 0;
 $mcat = round( $mcat);

 $quant = 0;
 $quant = round( $quant);

 $comp = 0;
 $comp = round( $comp);

 $GL_PUBLIC = 0;
 $GL_PUBLIC = round( $GL_PUBLIC);

 $GL_PRIVATE = 0;
 $GL_PRIVATE = round( $GL_PRIVATE);

 $desc = 0;
 $desc = round( $desc);

 $desc1 = 0;
 $desc1 = round( $desc1);
 
 $desc2 = 0;
 $desc2 = round( $desc2);
 
 $desc_lth = 0;
 $desc_lth = round( $desc_lth);
 
 $verf = 0; 
 $verf = round( $verf);

 $notverf = 0;
 $notverf = round( $notverf);

 $enrich = 0;
 $enrich = round( $enrich);

 $enrich_only = 0;
 $enrich_only = round( $enrich_only);

 $web = 0;
 $web = round( $web);

 $add = 0;
 $add = round( $add);

 $temail = 0;
 $temail = round( $temail);
 
 $pageref = 0;
 $pageref = round( $pageref);
 
 $tiletotal = 0;
 $tiletotal = round( $tiletotal);
 
 $apxovalue = 0;
 $apxovalue = round( $apxovalue);

 $trectype = 0;
 $trectype = round( $trectype);
 $tpostingprp = 0;
 $tpostingprp = round( $tpostingprp);
 $tsuploc = 0;
 $tsuploc = round( $tsuploc);
 $trecfreq = 0;
 $trecfreq = round( $trecfreq);
 
 $tpurperiod = 0;
 $citys = 0;
 $mcats = 0;
 $quants = 0;
 $comps = 0;
 $GL_PUBLICs = 0;
 $GL_PRIVATEs = 0;
 $descs = 0;
 $descs1 = 0;
 $descs2 =0;
 $desc_lths =0;
 $verfs =0;
 $notverfs = 0;
 $enrichs = 0;
 $enrich_onlys =0;
 $webs = 0;
 $adds = 0;
 $temails = 0;
 $pagerefs = 0;
 $tiletotals = 0;
 $apxovalues = 0;
 $trectypes = 0;
 $tpostingprps = 0;
 $tsuplocs =0;
 $trecfreqs = 0;
 $tpurperiods = 0;
 $isqs1 = 0;
 $isqs2 = 0;
 $isqs3 = 0;
 $isqs4 =0;
 $isqs5 = 0;
 $isq1 =0;
 $isq2 = 0;
 $isq3 = 0;
 $isq4 = 0;
 $isq5 = 0;
 
 }




		
#***********************query for fenq generated leads*****************************
		

  echo '
		<div>
		<table  width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
	      <tr style="background-color:#DCD9CF;font-weight:bold">
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:1px">Total Worked</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;border-top:1px solid #cacaca;padding-left:10px">'.($rec['TOTAL_APPROV']+$rec_deleted['TOTAL_APPROV']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-top:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">Total Deleted</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-top:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['TOTAL_APPROV'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-top:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">Total Approved</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-top:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['TOTAL_APPROV'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-top:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-top:1px solid #cacaca;border-right:1px solid #cacaca;padding-left:10px"></td>
	   </tr>
	</table>
		<table width="80%" border="0" cellpadding="0" cellspacing="0" align="CENTER" bgcolor="#ffffff">
		<tr>
		<td height="30" colspan="2" align="CENTER" bgcolor="#ccccff" style="font-family:arial;font-weight:bold;font-size:11px;border-top:1px solid #ffffff">
		<table width="110%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="5%" height="30" style="padding-left:8px;color:#0303bd; font-size:13px;"><b>Quality Parameter</b></td>
			<td width="5%" style="padding-left:0px;color:#0303bd; font-size:13px;"><b>Provided at Generation</b></td>
			<td width="5%" style="padding-left:0px;color:#0303bd; font-size:13px;"><b>Provided but Deleted</b></td>
			<td width="5%" style="padding-left:0px;color:#0303bd; font-size:13px;"><b>Not Provided & Approved</b></td>
			<td width="5%" style="padding-left:0px;color:#0303bd; font-size:13px;"><b>Provided & Approved</b></td>
			
			<td width="5%" style="padding-left:0px;color:#0303bd; font-size:13px;"><b>At Time of Approval</b></td>
			<td width="6%" style="padding-left:0px;color:#0303bd; font-size:13px;"><b>Enrichment % at Approval</b></td>
			<td width="8%" style="padding-left:0px;color:#0303bd; font-size:13px;"><b>sold%</b></td>
		</tr>

		</table></td> 
		</tr>';

	
	echo '
	<tr>
		</tr>
        <tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Title</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['TITLE_TOTAL']+(($rec['TITLE_TOTAL']-$rec_leapenrichment['TITLE_UPDATE_TOTAL'])+$rec_leapenrichment_new['TITLE_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['TITLE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['TITLE_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['TITLE_TOTAL']-$rec_leapenrichment['TITLE_UPDATE_TOTAL'])+$rec_leapenrichment['TITLE_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['TITLE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$tiletotal.'%</td><td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$tiletotals.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">> 200 CHAR IN DESC</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['DESC_GT_200_TOTAL']+(($rec['DESC_GT_200_TOTAL']-$rec_leapenrichment['DESC_GT_200_UPDATE_TOTAL'])+$rec_leapenrichment['DESC_GT_200_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['DESC_GT_200_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['DESC_GT_200_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['DESC_GT_200_TOTAL']-$rec_leapenrichment['DESC_GT_200_UPDATE_TOTAL'])+$rec_leapenrichment['DESC_GT_200_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['DESC_GT_200_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$desc.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$descs.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">> 150 CHAR IN DESC</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['DESC_GT_150_TOTAL']+(($rec['DESC_GT_150_TOTAL']-$rec_leapenrichment['DESC_GT_150_UPDATE_TOTAL'])+$rec_leapenrichment['DESC_GT_150_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['DESC_GT_150_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['DESC_GT_150_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['DESC_GT_150_TOTAL']-$rec_leapenrichment['DESC_GT_150_UPDATE_TOTAL'])+$rec_leapenrichment['DESC_GT_150_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['DESC_GT_150_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$desc1.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$descs1.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">> 100 CHAR IN DESC</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['DESC_GT_100_TOTAL']+(($rec['DESC_GT_100_TOTAL']-$rec_leapenrichment['DESC_GT_100_UPDATE_TOTAL'])+$rec_leapenrichment['DESC_GT_100_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['DESC_GT_100_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['DESC_GT_100_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['DESC_GT_100_TOTAL']-$rec_leapenrichment['DESC_GT_100_UPDATE_TOTAL'])+$rec_leapenrichment['DESC_GT_100_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['DESC_GT_100_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$desc2.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$descs2.'%</td>
	</tr>
	</table></td>
	</tr>
        <tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Application</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['APPLICATION_TOTAL']+(($rec['APPLICATION_TOTAL']-$rec_leapenrichment['APPLICATION_UPDATE_TOTAL'])+$rec_leapenrichment_new['APPLICATION_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['APPLICATION_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['APPLICATION_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['APPLICATION_TOTAL']-$rec_leapenrichment['APPLICATION_UPDATE_TOTAL'])+$rec_leapenrichment['APPLICATION_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['APPLICATION_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['APPLICATION_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['APPLICATION_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">QUANTITY</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['QTY_TOTAL']+(($rec['QTY_TOTAL']-$rec_leapenrichment['QTY_UPDATE_TOTAL'])+$rec_leapenrichment_new['QTY_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['QTY_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['QTY_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['QTY_TOTAL']-$rec_leapenrichment['QTY_UPDATE_TOTAL'])+$rec_leapenrichment['QTY_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['QTY_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$quant.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$quants.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Addtional Information</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['ADDITIONAL_INFO_TOTAL']+(($rec['ADDITIONAL_INFO_TOTAL']-$rec_leapenrichment['ADDITIONAL_INFO_UPDATE_TOTAL'])+$rec_leapenrichment_new['ADDITIONAL_INFO_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['ADDITIONAL_INFO_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['ADDITIONAL_INFO_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['ADDITIONAL_INFO_TOTAL']-$rec_leapenrichment['ADDITIONAL_INFO_UPDATE_TOTAL'])+$rec_leapenrichment['ADDITIONAL_INFO_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['ADDITIONAL_INFO_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['ADDITIONAL_INFO_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['ADDITIONAL_INFO_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">ISQ1</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq_deleted['ISQ1_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq['ISQ1_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isq1.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isqs1.'%</td>
	</tr>
	</table></td>
	</tr><tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">ISQ2</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq_deleted['ISQ2_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq['ISQ2_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isq2.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isqs2.'%</td>
	</tr>
	</table></td>
	</tr><tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">ISQ3</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq_deleted['ISQ3_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq['ISQ3_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isq3.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isqs3.'%</td>
	</tr>
	</table></td>
	</tr><tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">ISQ4</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq_deleted['ISQ4_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq['ISQ4_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isq4.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isqs4.'%</td>
	</tr>
	</table></td>
	</tr><tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">ISQ5</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq_deleted['ISQ5_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_isq['ISQ5_CNT'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isq5.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$isqs5.'</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:5px">Requirement Type</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['TOTAL_REQ_TYPE']+(($rec['TOTAL_REQ_TYPE']-$rec_leapenrichment['REQ_TYPE_UPDATE_TOTAL'])+$rec_leapenrichment_new['REQ_TYPE_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['TOTAL_REQ_TYPE'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['REQ_TYPE_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['TOTAL_REQ_TYPE']-$rec_leapenrichment['REQ_TYPE_UPDATE_TOTAL'])+$rec_leapenrichment['REQ_TYPE_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['TOTAL_REQ_TYPE'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$trectype.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$trectypes.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:5px">Preffered Supplier Location</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['TOTAL_SUP_LOC']+(($rec['TOTAL_SUP_LOC']-$rec_leapenrichment['GEOGRAPHY_ID_UPDATE_TOTAL'])+$rec_leapenrichment_new['GEOGRAPHY_ID_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['TOTAL_SUP_LOC'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['GEOGRAPHY_ID_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['TOTAL_SUP_LOC']-$rec_leapenrichment['GEOGRAPHY_ID_UPDATE_TOTAL'])+$rec_leapenrichment['GEOGRAPHY_ID_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['TOTAL_SUP_LOC'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$tsuploc.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$tsuplocs.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:5px">Why Do You Need This</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['TOTAL_PUR_PERIOD']+(($rec['TOTAL_PUR_PERIOD']-$rec_leapenrichment['PURCHASE_PERIOD_UPDATE_TOTAL'])+$rec_leapenrichment_new['PURCHASE_PERIOD_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['TOTAL_PUR_PERIOD'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['PURCHASE_PERIOD_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['TOTAL_PUR_PERIOD']-$rec_leapenrichment['PURCHASE_PERIOD_UPDATE_TOTAL'])+$rec_leapenrichment['PURCHASE_PERIOD_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['TOTAL_PUR_PERIOD'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$tpurperiod.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$tpurperiods.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Reselling</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['RESELLING_TOTAL']+(($rec['RESELLING_TOTAL']-$rec_leapenrichment['RESELLING_UPDATE_TOTAL'])+$rec_leapenrichment['RESELLING_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['RESELLING_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['RESELLING_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['RESELLING_TOTAL']-$rec_leapenrichment['RESELLING_UPDATE_TOTAL'])+$rec_leapenrichment['RESELLING_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['RESELLING_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['RESELLING_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['RESELLING_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">End Use</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['ENDUSE_TOTAL']+(($rec['ENDUSE_TOTAL']-$rec_leapenrichment['ENDUSE_UPDATE_TOTAL'])+$rec_leapenrichment['ENDUSE_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['ENDUSE_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['ENDUSE_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['ENDUSE_TOTAL']-$rec_leapenrichment['ENDUSE_UPDATE_TOTAL'])+$rec_leapenrichment['ENDUSE_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['ENDUSE_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['ENDUSE_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['ENDUSE_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:5px">Requirement Frequency</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['TOTAL_REQ_FREQUENCY']+(($rec['TOTAL_REQ_FREQUENCY']-$rec_leapenrichment['REQ_FREQ_UPDATE_TOTAL'])+$rec_leapenrichment_new['REQ_FREQ_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['TOTAL_REQ_FREQUENCY'].'</td>
		 <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['REQ_FREQ_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['TOTAL_REQ_FREQUENCY']-$rec_leapenrichment['REQ_FREQ_UPDATE_TOTAL'])+$rec_leapenrichment['REQ_FREQ_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['TOTAL_REQ_FREQUENCY'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$trecfreq.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$trecfreqs.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:5px">Approx. Order Value</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['ORDER_VALUE_TOTAL']+(($rec['ORDER_VALUE_TOTAL']-$rec_leapenrichment['ORDER_VALUE_UPDATE_TOTAL'])+$rec_leapenrichment_new['ORDER_VALUE_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['ORDER_VALUE_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['ORDER_VALUE_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['ORDER_VALUE_TOTAL']-$rec_leapenrichment['ORDER_VALUE_UPDATE_TOTAL'])+$rec_leapenrichment['ORDER_VALUE_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['ORDER_VALUE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$apxovalue.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$apxovalues.'%</td>
	</tr>
	</table></td>
	</tr>
	

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">MCAT MAPPING</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['MCAT_TOTAL']+(($rec['MCAT_TOTAL']-$rec_leapenrichment['MCAT_UPDATE_TOTAL'])+$rec_leapenrichment_new['MCAT_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['MCAT_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['MCAT_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['MCAT_TOTAL']-$rec_leapenrichment['MCAT_UPDATE_TOTAL'])+$rec_leapenrichment['MCAT_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['MCAT_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$mcat.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$mcats.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Name</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['NAME_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['NAME_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['NAME_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['NAME_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Email Primary</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['EMAIL_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['EMAIL_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$temail.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$temails.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Email Alternate</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['ALT_EMAIL_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['ALT_EMAIL_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['ALT_EMAIL_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['ALT_EMAIL_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Mobile Primary</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['PRIMARY_MOBILE_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['PRIMARY_MOBILE_TOTAL'].'</td>
		
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['PRIMARY_MOBILE_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['PRIMARY_MOBILE_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Mobile Alternate</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['ALT_MOBILE_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['ALT_MOBILE_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['ALT_MOBILE_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['ALT_MOBILE_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Company</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['COMPANY_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['COMPANY_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$comp.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$comps.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Company Ownership Type</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['COMPANY_OWNERSHIP_TYPE_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['COMPANY_OWNERSHIP_TYPE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['COMPANY_OWNERSHIP_TYPE_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:5px">PVT. LIMITED COMPANY</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['GL_PRIVATE_LTD_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['GL_PRIVATE_LTD_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$GL_PRIVATE.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$GL_PRIVATEs.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:5px">LIMITED COMPANY</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['GL_PUBLIC_LTD_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['GL_PUBLIC_LTD_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$GL_PUBLIC.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$GL_PUBLICs.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">ADDRESS</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['ADDRESS_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['ADDRESS_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$add.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$adds.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">WEBSITE</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['WEBSITE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['WEBSITE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$web.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$webs.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">SOURCE</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['PAGE_REFERRER_TOTAL']+(($rec['PAGE_REFERRER_TOTAL']-$rec_leapenrichment['PAGE_REFERRER_UPDATE_TOTAL'])+$rec_leapenrichment['PAGE_REFERRER_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['PAGE_REFERRER_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['PAGE_REFERRER_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['PAGE_REFERRER_TOTAL']-$rec_leapenrichment['PAGE_REFERRER_UPDATE_TOTAL'])+$rec_leapenrichment['PAGE_REFERRER_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['PAGE_REFERRER_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$pageref.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$pagerefs.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">VERIFIED ONLY</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['VERIFIED_TOTAL']+(($rec['VERIFIED_TOTAL']-$rec_leapenrichment['VERIFIED_UPDATE_TOTAL'])+$rec_leapenrichment['VERIFIED_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['VERIFIED_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['VERIFIED_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['VERIFIED_TOTAL']-$rec_leapenrichment['VERIFIED_UPDATE_TOTAL'])+$rec_leapenrichment['VERIFIED_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['VERIFIED_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$verf.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$verfs.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">NOT VERIFIED</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['NOT_VERIFIED_TOTAL']+(($rec['NOT_VERIFIED_TOTAL']-$rec_leapenrichment['NOT_VERIFIED_UPDATE_TOTAL'])+$rec_leapenrichment['NOT_VERIFIED_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['NOT_VERIFIED_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['NOT_VERIFIED_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['NOT_VERIFIED_TOTAL']-$rec_leapenrichment['NOT_VERIFIED_UPDATE_TOTAL'])+$rec_leapenrichment['NOT_VERIFIED_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['NOT_VERIFIED_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$notverf.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$notverfs.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">VERIFIED & UPDATED</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['ENRICH_TOTAL']+(($rec['ENRICH_TOTAL']-$rec_leapenrichment['ENRICH_UPDATE_TOTAL'])+$rec_leapenrichment['ENRICH_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['ENRICH_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['ENRICH_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['ENRICH_TOTAL']-$rec_leapenrichment['ENRICH_UPDATE_TOTAL'])+$rec_leapenrichment['ENRICH_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['ENRICH_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$enrich.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$enrichs.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">UPDATED ONLY</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['ENRICHED_ONLY_TOTAL']+(($rec['ENRICHED_ONLY_TOTAL']-$rec_leapenrichment['ENRICHED_ONLY_UPDATE_TOTAL'])+$rec_leapenrichment['ENRICHED_ONLY_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['ENRICHED_ONLY_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['ENRICHED_ONLY_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['ENRICHED_ONLY_TOTAL']-$rec_leapenrichment['ENRICHED_ONLY_UPDATE_TOTAL'])+$rec_leapenrichment['ENRICHED_ONLY_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['ENRICHED_ONLY_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$enrich_only.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$enrich_onlys.'%</td>
	</tr>
	</table></td>
	</tr>
        <tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Leads Approved with 1 MCAT</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['ONE_MCAT_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['ONE_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['ONE_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Leads Approved with 2 MCAT</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['TWO_MCAT_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['TWO_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['TWO_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Leads Approved with 3 MCAT</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['THREE_MCAT_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['THREE_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['THREE_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Leads Approved with 4 MCAT</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['FOUR_MCAT_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['FOUR_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['FOUR_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Leads Approved with 5 MCAT</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['FIVE_MCAT_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['FIVE_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['FIVE_MCAT_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">Supplier Selection</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['SUPPLIER_SELECTION_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['SUPPLIER_SELECTION_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['SUPPLIER_SELECTION_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['SUPPLIER_SELECTION_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
         <tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">     Auto</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['AUTO_SUPPLIER_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['AUTO_SUPPLIER_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['AUTO_SUPPLIER_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['AUTO_SUPPLIER_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">    Manual</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['MANUAL_SUPPLIER_TOTAL'].'</td>
                <td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['MANUAL_SUPPLIER_TOTAL'].'</td>
		';
		if($rec['TOTAL_APPROV']!=0)
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec['MANUAL_SUPPLIER_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.round(($rec_sold['MANUAL_SUPPLIER_TOTAL']/$rec['TOTAL_APPROV']) * 100,2).'%</td>';
		else
		echo '<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">0%</td>';
	echo '
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:4px">CITY</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">-</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['CITY_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px"></td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['CITY_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$city.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$citys.'%</td>
	</tr>
	</table></td>
	</tr>
	<!-- 17/02/2016-->
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:5px">Preffered Posting Purpose</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.($rec_deleted['TOTAL_POSTING_PURP']+(($rec['TOTAL_POSTING_PURP']-$rec_leapenrichment['PURPOSE_UPDATE_TOTAL'])+$rec_leapenrichment_new['PURPOSE_INSERT_TOTAL'])).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_deleted['TOTAL_POSTING_PURP'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec_leapenrichment['PURPOSE_CHANGE_TOTAL'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.(($rec['TOTAL_POSTING_PURP']-$rec_leapenrichment['PURPOSE_UPDATE_TOTAL'])+$rec_leapenrichment['PURPOSE_INSERT_TOTAL']).'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec['TOTAL_POSTING_PURP'].'</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$tpostingprp.'%</td>
		<td width="10%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$tpostingprps.'%</td>
	</tr>
	</table></td>
	</tr>

	</table>
</div>
<br><br><br>';
?>