<?php $this->pageTitle=Yii::app()->name . ' - Ddunmis Report'; ?>

<html>
  <head>
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
  <?php  
		$employeesArr = $result['employeesArr'];  
		$empidddl = $result['empidddl'];  
		$err = $result['err'];  
		$stdtddl = $result['stdtddl'];  
		$stmmddl = $result['stmmddl'];  
		$styyddl = $result['styyddl'];  
		$eddtddl = $result['eddtddl'];  
		$edmmddl = $result['edmmddl'];  
		$edyyddl = $result['edyyddl'];  
		$genmis = $result['genmis'];  
		$totalAppArray = $result['totalAppArray'];  
		$totalStaticApprov = $result['totalStaticApprov'];  
		$totalStaticApprov_Array = $result['totalStaticApprov_Array'];  
		$totalDelArray = $result['totalDelArray'];  
  ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" height="30">
      <tbody>
      <tr>
        <td style="font-family: arial; font-size: 14px; " align="center" bgcolor="#f4f4f4">
        	<b>Offer Approval / Rejection MIS</b> - (For Dehradun Team)
        </td>
      </tr> 
    <?php
  if(isset($err) && $err != '')
	{
		echo '<TR>
      	  <TD STYLE="font-family: arial; font-size: 14px; font-weight: bold;" 
     	   ALIGN="CENTER" BGCOLOR="#f4f4f4">'.$err.'</TD>
    	  </TR>';
	}
		
		?>
		</tbody>
    </table>
 <form method="post" action="/index.php?r=admin_eto/AdminEto/ddunmis&mid=3449">
    <table border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
      <tbody>
      <tr>
        <td style="font-family: arial; font-size: 12px; font-weight: bold;" bgcolor="#ccccff" width="100" height="30">
        &nbsp;Select Period
        </td>
        <td style="font-family: arial; font-size: 12px; font-weight: bold;" bgcolor="#eaeaea" width="500">
        <table >
          <tr>
            	<td>
			<select name="startdate" size="1">
			<?php foreach($valday as $dayK => $dayV){
				$sel = ($stdtddl == $dayK)?"selected":"";
					echo "<option value=\"$dayK\" $sel>$dayV</option>";		
				} ?>
			</select>
		</td> 
 
            	<td>
			<select name="startmonth" size="1">
				<?php foreach($valmonthval as $monthK => $monthV){
				$monthsel = ($stmmddl == $monthK)?"selected":"";
					echo "<option value=\"$monthK\" $monthsel>$monthV</option>";		
				} ?>
			</select>
		</td> 

        	 <td>
			<select name="startyear" size="1">
				<?php foreach($valyearval as $yearK => $yearV){
				$yearsel = ($styyddl == $yearK)?"selected":"";
					echo "<option value=\"$yearK\" $yearsel>$yearV</option>";		
				} ?>
			</select>	
		</td> 
            <td>&nbsp;to&nbsp;</td>
            <td>
			<select name="enddate" size="1">
				<?php foreach($valday as $dayeK => $dayeV){
				$dayesel = ($eddtddl == $dayeK)?"selected":"";
					echo "<option value=\"$dayeK\" $dayesel>$dayeV</option>";		
				} ?>
			</select>
		</td> 

            	 <td>
			<select name="endmonth" size="1">
			<?php foreach($valmonthval as $monthEK => $monthEV){
				$monthEsel = ($edmmddl == $monthEK)?"selected":"";
					echo "<option value=\"$monthEK\" $monthEsel>$monthEV</option>";		
				} ?>
			</select>
		</td> 

        	<td>
			 <select name="endyear" size="1">
				<?php foreach($valyearval as $yearEK => $yearEV){
				$yearEsel = ($edyyddl == $yearEK)?"selected":"";
					echo "<option value=\"$yearEK\" $yearEsel>$yearEV</option>";		
				} ?>
			</select> 	
		</td>
          </tr>
        </table></td>


<td  style="font-family: arial; font-size: 12px; font-weight: bold;" bgcolor="#ccccff" height="30" width="70">
	&nbsp;Employee
</td>
<td style="font-family: arial; font-size: 12px; font-weight: bold;" bgcolor="#eaeaea">

 <select name="empidddl" id="empidddl"><option value="">--Select--</option>
<?php 
foreach($employeesArr as $employeesKey => $employeesVal)
{
	if(!empty($empidddl) && $empidddl == $employeesKey)
	{
		echo "<option value=\"$employeesKey\" selected>$employeesVal ( $employeesKey )</option>";
	}
	else
	{
		echo "<option value=\"$employeesKey\">$employeesVal ( $employeesKey )</option>";
	}
}
?>
</select>
</td>
      </tr></tbody>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" height="30">
      <tbody>
      <tr>
        <td style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#f4f4f4">
        	<input name="action" value="callcenterinfo" type="hidden">
			<input type="submit" value="Generate Report" name="genmis">
        </td>
      </tr></tbody>
    </table></form>
    
<?php if(!empty($genmis) && empty($err))
	{ ?>
		<div>
		<table width="100%" border="0" align="center" style="font-size:12px;font-family:arial" cellpadding="2" cellspacing="1">

		<tr style="font-weight:bold">
				<td bgcolor="#ccccff" width="7%">Date</td>
				<td bgcolor="#ccccff" >Stc-Approved-ALL</td>
				<!-- <td bgcolor="#ccccff" >Stc-Approved(S)</td> -->
				<td bgcolor="#ccccff" >Stc-Approved(B)</td>
				<td bgcolor="#ccccff" ALIGN="CENTER"> Approved All </td>
				<!-- <td bgcolor="#ccccff" ALIGN="CENTER"> Approved Sell </td> -->
				<td bgcolor="#ccccff" ALIGN="CENTER"> Approved Buy </td>
				
				<td bgcolor="#ccccff" ALIGN="CENTER"> Deleted All </td>
				<!-- <td bgcolor="#ccccff" ALIGN="CENTER"> Deleted Sell </td> -->
				<td bgcolor="#ccccff" ALIGN="CENTER"> Deleted Buy </td>
			</tr>
<?php

		 $appBuy=0;
		$appSell=0;
		$appAll=0;

		$delAll=0;
		$delSell=0;
		$delBuy=0;
		$dtRange =  count($totalAppArray) - 1;
		$dtRangeArr =  range(0,$dtRange);
		$appstatic=0;
		$appstatic_sell=0;
		$appstatic_buy=0;
		foreach ($dtRangeArr as $k=>$value)
		{
			
			echo "<tr bgcolor='#f6f6f6'>
			<td bgcolor='#EAEAE'>".$totalAppArray[$k]['DAT']."
			</td><td bgcolor='#EAEAE' ALIGN='CENTER'>";
		
			$totalStaticApprov_Array[$k]['APPROVED_STATIC_COUNT'] = $totalStaticApprov_Array[$k]['APPROVED_STATIC_COUNT'] ?
			$totalStaticApprov_Array[$k]['APPROVED_STATIC_COUNT']: 0;
			$appstatic = $appstatic + $totalStaticApprov_Array[$k]['APPROVED_STATIC_COUNT'];
			echo $totalStaticApprov_Array[$k]['APPROVED_STATIC_COUNT'];	
			
			/* echo '<td bgcolor="#EAEAE" ALIGN="CENTER">';
			$totalStaticApprov_Array[$k]['APPROVED_STATIC_SELL'] = $totalStaticApprov_Array[$k]['APPROVED_STATIC_SELL'] ?
			$totalStaticApprov_Array[$k]['APPROVED_STATIC_SELL'] : 0;
			$appstatic_sell = $appstatic_sell + $totalStaticApprov_Array[$k]['APPROVED_STATIC_SELL'];
			echo $totalStaticApprov_Array[$k]['APPROVED_STATIC_SELL']; */
			
			echo '<td bgcolor="#EAEAE" ALIGN="CENTER">';
			$totalStaticApprov_Array[$k]['APPROVED_STATIC_BUY'] = $totalStaticApprov_Array[$k]['APPROVED_STATIC_BUY'] ?
			$totalStaticApprov_Array[$k]['APPROVED_STATIC_BUY'] : 0;
			$appstatic_buy = $appstatic_buy + $totalStaticApprov_Array[$k]['APPROVED_STATIC_BUY'];
			echo $totalStaticApprov_Array[$k]['APPROVED_STATIC_BUY'];

			echo '</td><td bgcolor="#EAEAE" ALIGN="CENTER">';
			$totalAppArray[$k]['APPROVED_ALL_CNT'] = $totalAppArray[$k]['APPROVED_ALL_CNT'] ? $totalAppArray[$k]['APPROVED_ALL_CNT'] : 0;
			$appAll=$appAll + $totalAppArray[$k]['APPROVED_ALL_CNT'];
			echo $totalAppArray[$k]['APPROVED_ALL_CNT'];


			/* echo '</td><td bgcolor="#EAEAE" ALIGN="CENTER">';
			$totalAppArray[$k]['APPROVED_SELL_CNT'] = $totalAppArray[$k]['APPROVED_SELL_CNT'] ? $totalAppArray[$k]['APPROVED_SELL_CNT'] : 0;
			$appSell=$appSell + $totalAppArray[$k]['APPROVED_SELL_CNT'];
			echo $totalAppArray[$k]['APPROVED_SELL_CNT']; */


			echo '</td><td bgcolor="#EAEAE" ALIGN="CENTER">';
			$totalAppArray[$k]['APPROVED_BUY_CNT'] = $totalAppArray[$k]['APPROVED_BUY_CNT'] ? $totalAppArray[$k]['APPROVED_BUY_CNT'] : 0;
			$appBuy=$appBuy + $totalAppArray[$k]['APPROVED_BUY_CNT'];
			echo $totalAppArray[$k]['APPROVED_BUY_CNT'];

			
			echo '</td><td bgcolor="#EAEAE" ALIGN="CENTER">';
			$totalDelArray[$k]['DELETE_ALL_CNT'] = $totalDelArray[$k]['DELETE_ALL_CNT'] ? $totalDelArray[$k]['DELETE_ALL_CNT'] : 0;
			$delAll=$delAll + $totalDelArray[$k]['DELETE_ALL_CNT'];
			echo $totalDelArray[$k]['DELETE_ALL_CNT'];


			/* echo '</td><td bgcolor="#EAEAE" ALIGN="CENTER">';
			$totalDelArray[$k]['DELETE_SELL_CNT'] = $totalDelArray[$k]['DELETE_SELL_CNT'] ? $totalDelArray[$k]['DELETE_SELL_CNT'] : 0;
			$delSell=$delSell + $totalDelArray[$k]['DELETE_SELL_CNT'];
			echo $totalDelArray[$k]['DELETE_SELL_CNT']; */


			echo '</td><td bgcolor="#EAEAE" ALIGN="CENTER">';
			$totalDelArray[$k]['DELETE_BUY_CNT'] = $totalDelArray[$k]['DELETE_BUY_CNT'] ? $totalDelArray[$k]['DELETE_BUY_CNT'] : 0;
			$delBuy=$delBuy + $totalDelArray[$k]['DELETE_BUY_CNT'];
			echo $totalDelArray[$k]['DELETE_BUY_CNT'];



			echo "</td></tr>";
		} ?>

	 	<tr style="font-weight:bold">
				<td bgcolor="#ccccff" >Total</td>
				<td bgcolor="#ccccff" ALIGN="CENTER"> <?php echo $appstatic; ?> </td>
				<!-- <td bgcolor="#ccccff" ALIGN="CENTER"> <?php echo $appstatic_sell?> </td> -->
				<td bgcolor="#ccccff" ALIGN="CENTER"> <?php echo $appstatic_buy?> </td>
				<td bgcolor="#ccccff" ALIGN="CENTER"> <?php echo $appAll?> </td>
				<!-- <td bgcolor="#ccccff" ALIGN="CENTER"> <?php echo $appSell?> </td> -->
				<td bgcolor="#ccccff" ALIGN="CENTER"> <?php echo $appBuy ?></td>

				<td bgcolor="#ccccff" ALIGN="CENTER"> <?php echo $delAll ?></td>
				<!-- <td bgcolor="#ccccff" ALIGN="CENTER"> <?php echo $delSell ?></td> -->
				<td bgcolor="#ccccff" ALIGN="CENTER"> <?php echo $delBuy?> </td> 
			</tr> 
		</table></div>
<?php 	}?>
	</body></html> 