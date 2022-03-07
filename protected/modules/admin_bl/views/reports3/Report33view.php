<?php
  echo '<div style="margin:0px auto;text-align:center;"><br><div style="font-weight:bold;">Tenders Report</div><br>

<table width="70%" border="1" cellpadding="5" cellspacing="1" align="CENTER" border-color="#f8f8f8" style="border-collapse:collapse">
<tr>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" height="30" rowspan="2" align="CENTER"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER" colspan="3"><b>All</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER" colspan="3"><b>MY Tenders</b></td>
<td bgcolor="#FFFF99" style="font-family:arial;font-size:11px;" align="CENTER" colspan="3"><b>Tender.IM</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER" colspan="3"><b>Tender Email Alerts</b></td>
<td bgcolor="#FFCCCC" align="CENTER" colspan="8" style="font-family:arial;font-size:11px;"><b>Email Alert Category</b></td>
<td bgcolor="#B5EAAA" align="CENTER" colspan="7" style="font-family:arial;font-size:11px;"><b>Others</b></td>
</tr>

<tr>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>Total Sold</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique Sold</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique User</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Total Sold</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique Sold</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique User</b></td>
<td bgcolor="#FFFF99" style="font-family:arial;font-size:11px;" align="CENTER"><b>Total Sold</b></td>
<td bgcolor="#FFFF99" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique Sold</b></td>
<td bgcolor="#FFFF99" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique User</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>Total Sold</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique Sold</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique User</b></td>


<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>TMRNG</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>TMIDDAY</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>TACTIVE</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>TEVNG</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>TBULK</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>TSUNDAY</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>EMKTG</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>WITHINST</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>ETO</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>BL-Alerts</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>MOB</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>ANDROID</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>IOS</b></td>

</tr>';
$i=0;
 $tdrtoal=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 

 for($i=0;$i<sizeof($result);$i++)
 {
 $result[$i]=array_change_key_case($result[$i], CASE_UPPER);
  echo '<tr>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SDT'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['TOT_SOLD'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['UNI_SOLD'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['UNIGLUSR_SOLD'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_MY'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['UNISOLD_MY'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['UNIGLUSR_MY'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_TDR'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['UNISOLD_TDR'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['UNIGLUSR_TDR'].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_EMKTG'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['UNISOLD_EMKTG'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['UNIGLUSR_EMKTG'].'</td>
		
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_TMRNG_NEW'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_TMIDDAY_NEW'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_TACTIVE_NEW'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_TEVNG_NEW'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_TBULK_NEW'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_TSUNDAY_NEW'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_EMKTG_NEW'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_WITHINST'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_ETO'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_BL'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_MOB'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_ANDROID'].'</td>
		<td style="font-family:arial;font-size:11px;" align="CENTER">'.$result[$i]['SOLD_IOS'].'</td>

		</tr>';  

            $tdrtoal[0]+=$result[$i]['SOLD_MY'];
		$tdrtoal[1]+=$result[$i]['UNISOLD_MY'];
		$tdrtoal[2]+=$result[$i]['UNIGLUSR_MY'];

		$tdrtoal[3]+=$result[$i]['SOLD_TDR'];
		$tdrtoal[4]+=$result[$i]['UNISOLD_TDR'];
		$tdrtoal[5]+=$result[$i]['UNIGLUSR_TDR'];	

		$tdrtoal[6]+=$result[$i]['TOT_SOLD'];
		$tdrtoal[7]+=$result[$i]['UNI_SOLD'];
		$tdrtoal[8]+=$result[$i]['UNIGLUSR_SOLD'];

        $tdrtoal[9]+=$result[$i]['SOLD_EMKTG'];
		$tdrtoal[10]+=$result[$i]['UNISOLD_EMKTG'];
		$tdrtoal[11]+=$result[$i]['UNIGLUSR_EMKTG'];
		
		$tdrtoal[12]+=$result[$i]['SOLD_TMRNG_NEW'];
		$tdrtoal[13]+=$result[$i]['SOLD_TMIDDAY_NEW'];
		$tdrtoal[14]+=$result[$i]['SOLD_TACTIVE_NEW'];
		$tdrtoal[15]+=$result[$i]['SOLD_TEVNG_NEW'];
		$tdrtoal[16]+=$result[$i]['SOLD_TBULK_NEW'];
		$tdrtoal[17]+=$result[$i]['SOLD_TSUNDAY_NEW'];
		$tdrtoal[18]+=$result[$i]['SOLD_EMKTG_NEW'];
		$tdrtoal[19]+=$result[$i]['SOLD_WITHINST'];

		$tdrtoal[20]+=$result[$i]['SOLD_ETO'];
		$tdrtoal[21]+=$result[$i]['SOLD_BL'];
		$tdrtoal[22]+=$result[$i]['SOLD_MOB'];
		$tdrtoal[23]+=$result[$i]['SOLD_ANDROID'];
		$tdrtoal[24]+=$result[$i]['SOLD_IOS'];
}


   echo '<tr STYLE="height:30px;">
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Total</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[6].'</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tot_uniq_cnts['TOT_SOLD_CNT'].'</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tot_uniq_cnts['TOT_USR_CNT'].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[0].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[1].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tot_uniq_cnts['TOT_UNIGLUSR_MY'].'</b></td>
<td bgcolor="#FFFF99" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[3].'</b></td>
<td bgcolor="#FFFF99" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[4].'</b></td>
<td bgcolor="#FFFF99" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tot_uniq_cnts['TOT_UNIGLUSR_TDR'].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[9].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[10].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tot_uniq_cnts['TOT_UNIGLUSR_EMKTG'].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[12].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[13].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[14].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[15].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[16].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[17].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[18].'</b></td>
<td bgcolor="#FFCCCC" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[19].'</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[20].'</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[21].'</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[22].'</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[23].'</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[24].'</b></td>

</tr></div>';
?>