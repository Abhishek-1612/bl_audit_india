<?php

$result = 	$returnResult1['result'];
			$field_disp = 	$returnResult1['field_disp'];
	echo '
	<STYLE TYPE="text/css">
	.admintext {font-family:arial; font-size:11px;line-height:15px;}
	.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}
	.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
	</STYLE>

	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Offer History Detail for Offer ID - <font color="red">'.$param['offer'].'</font> <BR>';

	if(isset($params['start_date']) && !empty($params['start_date']))
	{
		echo '<font color="blue">"'.$status_disp[$status_type[$params['status_type']]].'"</font> Screen between '.$params['start_date'].' & '.$params['end_date'];
	}

	echo '</td>
	</tr>
	</tbody></table>
	
	<div id="masterdiv" style="clear: both;">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>';

	$i = 0;
	$j = 0;
	$orderID =0;
	$hash = array();
	$hash1 = array();
	$histID = 0;
	foreach ($result as $recK => $rec)
	{
		$i++;
		if($histID != $rec['ETO_OFR_HIST_ID'])
		{
			 $actionDisp = $status_disp[$rec['ETO_OFR_HIST_TYP']];			 			 
			if(isset($rec['ETO_OFR_HIST_APPROV_FLAG']) && $rec['ETO_OFR_HIST_APPROV_FLAG'] == 1)
			{ 		
				$actionDisp = 'Approved';
			}
			
			$ofrHistBy = isset($rec['ETO_OFR_HIST_BY'])?$rec['ETO_OFR_HIST_BY']:'-';
			$ofrHistDate = isset($rec['ETO_OFR_HIST_DATE_DISP'])?$rec['ETO_OFR_HIST_DATE_DISP']:'-';
			echo '			<tr><td><BR></td></tr>
			<tr>
			<td class="admintext1" align="left"> <B style="color:red;">'.$actionDisp.'</B> On '.$ofrHistDate.' by '.$ofrHistBy.' (';
			
			 if(!empty($rec['ETO_OFR_HIST_EMP_ID'])){
							 echo ' Emp ID - '.$rec['ETO_OFR_HIST_EMP_ID'];
			 }
			
			if(!empty($rec['ETO_OFR_HIST_USR_ID'])){
					echo ' User ID - '.$rec['ETO_OFR_HIST_USR_ID'];
			}
			echo ')';
			if(!empty($rec['ETO_OFR_HIST_USING'])){
				echo ' using '.$rec['ETO_OFR_HIST_USING'];
			}

			if(!empty($rec['ETO_OFR_HIST_COMMENTS'])){
				echo ' ["'.$rec['ETO_OFR_HIST_COMMENTS'].'"]';			
			}			
			echo '</td>
			</tr>';
			$j=1;
		}

		if($rec['ETO_OFR_HIST_TYP'] == 'U')
		{
			echo '
			<tr>
			<td class="admintext" align="left" width="100%">


			<table align="center" border="0" cellpadding="1" cellspacing="1" width="100%">';

			if($j == 1)
			{
				echo '
				<tr>
				<td class="admintext" align="left" width="40%" bgcolor="#ccccff"><b>Field Name</b></td>
				<td class="admintext" align="left" width="30%" bgcolor="#ccccff"><b>Old Value</b></td>
				<td class="admintext" align="left" width="30%" bgcolor="#ccccff"><b>New Value</b></td>
				</tr>';
			}
		$ofrOldVal = isset($rec['ETO_OFR_HIST_OLD_VAL'])?$rec['ETO_OFR_HIST_OLD_VAL']:'';
		$ofrNewVal = isset($rec['ETO_OFR_HIST_NEW_VAL'])?$rec['ETO_OFR_HIST_NEW_VAL']:'';
			echo '
			<tr>
			<td class="admintext1" align="left" bgcolor="#eaeaea" width="40%">'.
			$field_disp[$rec['ETO_OFR_HIST_FIELD']].'</td>
			<td class="admintext1" align="left" bgcolor="#eaeaea" width="30%">'.$ofrOldVal.'</td>
			<td class="admintext1" align="left" bgcolor="#eaeaea" width="30%">'.$ofrNewVal.'</td>
			</tr>';


			echo '</table>

			</td>
			</tr>';
			$j++;
		}
		$histID = $rec['ETO_OFR_HIST_ID'];
	}

	if($i == 0)
	{
		echo '
		<tr>
		<td class="admintext1" align="center" colspan="14">
		<DIV CLASS="tab-head">No Record Found !</DIV> </td>
		</tr>';
	}
	echo '</tbody></table>';
	?>
	<html>
	<?php $queryID = $returnResult2['queryID'];
		$rec = $returnResult2['rec'];
		$receiverID = $returnResult2['receiverID'];
		$offer = $returnResult2['offer'];
	?>	<head>
	<STYLE TYPE="text/css">
		.admintext {font-family:arial; font-size:11px;font-weight:bold;line-height:15px;}
		.admintext1 {font-family:ms sans serif,verdana; font-size:13px;line-height:17px;}
		.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
	</STYLE>
	</head>
<body>
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	    <tbody>
	    	<tr>
	    		<td colspan="4" style="font-family: arial; font-size: 15px; font-weight: bold;" align="center" bgcolor="#ccdccd" height="30">
	    		FENQ History Detail for Offer ID - 
	    		<font color="red">
	    		<?php echo $offer; ?></font> <BR>
				</td>
	    	</tr>
	    </tbody>
	</table>
<?php

	if(empty($queryID)) 
	{
	     echo '<table align="center" bgcolor="#eaeaea" border="0" cellpadding="3" cellspacing="0" width="100%">
		<tbody>
		<tr>
		    <td class="admintext1" align="center" colspan="14">
			<DIV CLASS="tab-head">No Record Found !</DIV> 
		    </td>
		</tr>
		</tbody>
	     </table>';
	     exit;
	}
	
	$Enq_typ = ((isset($rec['ENQ_TYP']) && $rec['ENQ_TYP'] == 'WEB') ? '<font color="red">WEB Enquiry</font>' : '<font color="red">SMS Enquiry</font>');
	
	?>
	<div id="masterdiv" style="clear: both;">
	<table align="center" bgcolor="#eaeaea" border="0" cellpadding="3" cellspacing="0" width="100%">
	<tbody>
	<?php			            
       echo '<tr><td colspan="2">'.$Enq_typ.'</td></tr>';
        if(isset($rec['DATE_R']) && !empty($rec['DATE_R'])){
        	echo '<tr><td class="admintext1" width="160"><B>Date :</B></td><td class="admintext1" > '.$rec['DATE_R'].' </td></tr>';
        }
        if(isset($rec['ENQ_ID']) && !empty($rec['ENQ_ID'])){
        	 echo '<tr><td class="admintext1"><B>Query ID :</B></td><td class="admintext1">'.$rec['ENQ_ID'].' </td><td></td><td></td></tr>';       
        }	
        if(isset($rec['FK_GLUSR_USR_ID']) && !empty($rec['FK_GLUSR_USR_ID'])){
        	 echo '<tr><td class="admintext1"><B>Original Sender :</B></td><td class="admintext1">'.$rec['FK_GLUSR_USR_ID'].' </td></tr>';       
        }
        if(!empty($receiverID)){
        	 echo '<tr><td class="admintext1"><B>Original Receiver :</B></td><td class="admintext1">'.$receiverID.'</td></tr>';    
        }
        if(isset($rec['QUERY_MODID']) && !empty($rec['QUERY_MODID'])){
        	echo '<tr><td class="admintext1"><B>Query MODID :</B></td><td class="admintext1">'.$rec['QUERY_MODID'].' </td></tr>';     
        }
        if(isset($rec['MESSAGE']) && !empty($rec['MESSAGE'])){
        	echo '<tr><td class="admintext1"><B>Original Message :</B></td><td class="admintext1">'.$rec['MESSAGE'].' </td></tr>';     
        }
        if(isset($rec['DIR_QUERY_REQ_APRX_ORDER_VALUE']) && !empty($rec['DIR_QUERY_REQ_APRX_ORDER_VALUE'])){
        	echo '<tr><td class="admintext1"><B>Approx Order Value:</B></td><td class="admintext1">'.$rec['DIR_QUERY_REQ_APRX_ORDER_VALUE'].'</td></tr>';     
        }
        if(isset($rec['DIR_QUERY_REQ_APP_USAGE']) && !empty($rec['DIR_QUERY_REQ_APP_USAGE'])){
        	echo '<tr><td class="admintext1"><B>Application Usage: </B></td><td class="admintext1">'.$rec['DIR_QUERY_REQ_APP_USAGE'].'</td></tr>';     
        }
        if(isset($rec['DIR_QUERY_REQ_PURCHASE_PERIOD']) && !empty($rec['DIR_QUERY_REQ_PURCHASE_PERIOD'])){
        	echo '<tr><td class="admintext1"><B>Purchase Period: </B></td><td class="admintext1"> '.$rec['DIR_QUERY_REQ_PURCHASE_PERIOD'].' </td></tr>';     
        }
        if(isset($rec['DIR_QUERY_REQ_PURPOSE']) && !empty($rec['DIR_QUERY_REQ_PURPOSE'])){
        	echo '<tr><td class="admintext1"><B>Requirment Purpose: </B></td><td class="admintext1"> '.$rec['DIR_QUERY_REQ_PURPOSE'].' </td></tr>';     
        }
        if(isset($rec['DIR_QUERY_REQ_FREQUENCY']) && !empty($rec['DIR_QUERY_REQ_FREQUENCY'])){
        	echo '<tr><td class="admintext1"><B>Requirment Frequency: </B></td><td class="admintext1"> '.$rec['DIR_QUERY_REQ_FREQUENCY'].' </td></tr>';     
        }
        
        if(isset($rec['DIR_QUERY_REQ_GEOGRAPHY_ID']) && $rec['DIR_QUERY_REQ_GEOGRAPHY_ID'] == 1)
        {
        	echo '<tr><td class="admintext1"><B>Location Preference:</B></td><td class="admintext1">Local Only</td></tr>';
        }
        elseif(isset($rec['DIR_QUERY_REQ_GEOGRAPHY_ID']) && $rec['DIR_QUERY_REQ_GEOGRAPHY_ID'] == 2)
        {
        	echo '<tr><td class="admintext1"><B>Location Preference:</B></td><td class="admintext1">India Only</td></tr>';
        }
        elseif(isset($rec['DIR_QUERY_REQ_GEOGRAPHY_ID']) && $rec['DIR_QUERY_REQ_GEOGRAPHY_ID'] == 3)
        {
        	echo '<tr><td class="admintext1"><B>Location Preference:</B></td><td class="admintext1">Anywhere In The world</td></tr>';
        }
        elseif(isset($rec['DIR_QUERY_REQ_GEOGRAPHY_ID']) && $rec['DIR_QUERY_REQ_GEOGRAPHY_ID'] == 4)
        {
        	echo '<tr><td class="admintext1"><B>Location Preference:</B></td><td class="admintext1">';
			if(isset($rec['CITY_1'])){
				echo $rec['CITY_1'];	
			}
			if(isset($rec['CITY_2'])){
				echo $rec['CITY_2'];	
			}
			if(isset($rec['CITY_3'])){
				echo $rec['CITY_3'];	
			}
			echo '</td></tr>';
        }
        if(isset($rec['DIR_QUERY_REQ_DESTINATION_PORT']) && !empty($rec['DIR_QUERY_REQ_DESTINATION_PORT'])){
        	 echo '<tr><td class="admintext1"><B>Destination Port:</B></td><td class="admintext1">'.$rec['DIR_QUERY_REQ_DESTINATION_PORT'].'</td></tr>';     
        }  
        if(isset($rec['DIR_QUERY_REQ_PAYMENT_MODE']) && !empty($rec['DIR_QUERY_REQ_PAYMENT_MODE'])){
        	 echo '<tr><td class="admintext1"><B>Payment Mode:</B></td><td   class="admintext1">'.$rec['DIR_QUERY_REQ_PAYMENT_MODE'].' </td></tr>';     
        }
        if(isset($rec['DIR_QUERY_REQ_SHIPMENT_MODE']) && !empty($rec['DIR_QUERY_REQ_SHIPMENT_MODE'])){
        	 echo '<tr><td class="admintext1"><B>Shipment Mode:</B></td><td class="admintext1">'.$rec['DIR_QUERY_REQ_SHIPMENT_MODE'].' </td></tr>';     
        }      
        
        echo '<tr><td class="admintext1"><br><B>SENDER DETAIL -</B></td>';
         if(isset($rec['SENDERNAME']) && !empty($rec['SENDERNAME'])){
         	echo '<tr><td class="admintext1"><B>Name :</B></td><td class="admintext1">'.$rec['SENDERNAME'].' </td></tr>';      
         }
         if(isset($rec['SENDEREMAIL']) && !empty($rec['SENDEREMAIL'])){
         	echo '<tr><td class="admintext1"><B>Email :</B></td><td class="admintext1">'.$rec['SENDEREMAIL'].'</td></tr>';      
         }
         if(isset($rec['S_ORGANIZATION']) && !empty($rec['S_ORGANIZATION'])){
         	echo '<tr><td class="admintext1"><B>Organization :</B></td><td class="admintext1">'.$rec['S_ORGANIZATION'].' </td></tr>';      
         }
         if(isset($rec['S_DESIGNATION']) && !empty($rec['S_DESIGNATION'])){
         	echo '<tr><td class="admintext1"><B>Designation :</B></td><td class="admintext1">'.$rec['S_DESIGNATION'].' </td></tr>';      
         }
         if(isset($rec['S_STREETADDRESS']) && !empty($rec['S_STREETADDRESS'])){
         	echo '<tr><td class="admintext1"><B>Streetaddress :</B></td><td class="admintext1">'.$rec['S_STREETADDRESS'].' </td></tr>';      
         }
         if(isset($rec['S_CITY']) && !empty($rec['S_CITY'])){
         	echo '<tr><td class="admintext1"><B>City :</B></td><td class="admintext1">'.$rec['S_CITY'].' </td></tr>';      
         }
         if(isset($rec['S_STATE']) && !empty($rec['S_STATE'])){
         	echo '<tr><td class="admintext1"><B>State :</B></td><td class="admintext1">'.$rec['S_STATE'].' </td></tr>';      
         }
         if(isset($rec['S_ZIP']) && !empty($rec['S_ZIP'])){
         	echo '<tr><td class="admintext1"><B>Zip :</B></td><td class="admintext1">'.$rec['S_ZIP'].' </td></tr>';      
         }
         if(isset($rec['S_COUNTRY']) && !empty($rec['S_COUNTRY'])){
         	echo '<tr><td class="admintext1"><B>Country :</B></td><td class="admintext1">'.$rec['S_COUNTRY'].' </td></tr>';      
         }
         if(isset($rec['S_PHONE']) && !empty($rec['S_PHONE'])){
         	echo '<tr><td class="admintext1"><B>Phone :</B></td><td class="admintext1">'.$rec['S_PHONE'].' </td></tr>';      
         }
         if(isset($rec['S_COUNTRY']) && !empty($rec['S_COUNTRY'])){
         	echo '<tr><td class="admintext1"><B>Country :</B></td><td class="admintext1">'.$rec['S_COUNTRY'].' </td></tr>';      
         }
        
        
         ?>
         </tbody></table>
	</div></body>
	</html>
	if(empty($param['offer']) || $param['offer'] == 0 || !preg_match('/^\d+$/', $param['offer'])){ ?>	
		<div align="center" style="font-family: arial; font-size: 14px; font-weight: bold;">
			<font color="red">Sorry, Please enter Valid Offer ID</font>
		</div>
	<?php exit; 
	}  ?>
	<html>
	<head>
	<style TYPE="text/css">
	.admintext {font-family:arial; font-size:11px;line-height:15px;}
	.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}
	.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
	
        .block1{FONT-SIZE: 12px; border-right:1px #DDF0FF solid;padding-left:10px;padding-right:10px;}
        .block1 a{COLOR: #0000ff}
        .block1 .res{font-weight:bold; }
        .block1 .off{font-weight:bold; COLOR: #000000;}
        .block1 b{COLOR: #FF4800;FONT-SIZE: 14px;}

	</style>
	</head>
	<body>
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Mcat Mapping Detail for Offer ID - <font color="red"><?php echo $param['offer']; ?></font> <BR>

	</td>
	</tr>
	</tbody></table>
	
	<div id="masterdiv" style="clear: both;">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
<?php
	$i = 0;
	$j = 0;
	$orderID =0;	
	$histID = 0;
	$empid=0;
	foreach($returnResult3['recMapResult'] as $recK => $recMap){	
		$i++;
		if($empid != $recMap['GL_EMP_ID'])	{
			$actionDisp = '';
			
			if(isset($recMap1['ETO_OFR_HIST_EMP_ID']) && $recMap1['ETO_OFR_HIST_EMP_ID'] == $recMap['GL_EMP_ID'])	{
				$actionDisp = '<B style="color:red;">Auto Mcat Selection </B>';
			} else if(isset($recMap1['ETO_OFR_HIST_EMP_ID']) && $recMap1['ETO_OFR_HIST_EMP_ID'] != $recMap['GL_EMP_ID']) {
				$actionDisp = '<B style="color:red;">Auto Mcat Selection </B> by '.$recMap1['GL_EMP_NAME'].' (';
				$actionDisp .= ($recMap1['ETO_OFR_HIST_EMP_ID']) ?' Emp ID - '.$recMap1['ETO_OFR_HIST_EMP_ID']:'';
				$actionDisp .= ')';
				$actionDisp .= ($recMap1['ETO_OFR_HIST_DATE'])?' On '.$recMap1['ETO_OFR_HIST_DATE']:'';
				$actionDisp .= ' and <B style="color:red;">Changed </B>';
			}
			else
			{
				$actionDisp = '<B style="color:red;"> Manual Mcat Selection</B>';
			} 

			echo '
			<tr><td><BR></td></tr>
			<tr>
			<td class="admintext1" align="left"> '.$actionDisp.' by '.$recMap['GL_EMP_NAME'].' (';

			echo ($recMap['GL_EMP_ID'])?' Emp ID - '.$recMap['GL_EMP_ID']:'';

			echo ')';
			
			echo ($recMap['ETO_OFR_MAPPING_DATE'])?' On '.$recMap['ETO_OFR_MAPPING_DATE']:'';
			
			echo '</td>
			</tr>';
			$j=1;
		}

                echo '
                <tr>
                <td class="admintext" align="left" width="100%">
                <table align="center" border="0" cellpadding="1" cellspacing="1" width="100%">';

                if($j == 1)
                {
                        echo '
                        <tr>
                        <td class="admintext" align="left" width="20%" bgcolor="#ccccff"><b>Mcat ID</b></td>
                        <td class="admintext" align="left" width="80%" bgcolor="#ccccff"><b>Mcat Name</b></td>                        
                        </tr>';
                }

                echo '
                <tr>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="20%">'.$recMap['GLCAT_MCAT_ID'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="80%">'.$recMap['GLCAT_MCAT_NAME'].'</td>                
                </tr>';
                echo '</table>

                </td>
                </tr>';
                $j++;
        
		$empid = $recMap['GL_EMP_ID'];
	}
	

	if($i == 0)
	{
		echo '
		<tr>
		<td class="admintext1" align="center" colspan="14">
		<DIV CLASS="tab-head">No Record Found !</DIV> </td>
		</tr>';
	}
	echo '</tbody></table>';


	#### Not Selected Mcats Details ####
	echo '	
	<div id="masterdiv1" style="clear: both;">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>';

       

	$i = 0;
	$j = 0;
	$orderID =0;	
	$histID = 0;
	$empid=0;

	foreach ($returnResult3['recNotMapResult'] as $recNotMapK => $recNotMap) {	
		$i++;
		if($empid != $recNotMap['GL_EMP_ID'])
		{
			$actionDisp = 'Auto Mcat Not Selected';						

			echo '
			<tr><td><BR></td></tr>
			<tr>
			<td class="admintext1" align="left"> <B style="color:red;">'.$actionDisp.'</B> by '.$recNotMap['GL_EMP_NAME'].' (';

			echo ($recNotMap['GL_EMP_ID'])?' Emp ID - '.$recNotMap['GL_EMP_ID']:'';

			echo ')';
			
			echo ($recNotMap['ETO_AUTO_MCAT_SELECTION_DATE'])?' On '.$recNotMap['ETO_AUTO_MCAT_SELECTION_DATE']:'';
			
			echo '</td>
			</tr>';
			$j=1;
		}

                echo '
                <tr>
                <td class="admintext" align="left" width="100%">
                <table align="center" border="0" cellpadding="1" cellspacing="1" width="100%">';

                if($j == 1)
                {
                        echo '
                        <tr>
                        <td class="admintext" align="left" width="20%" bgcolor="#ccccff"><b>Mcat ID</b></td>
                        <td class="admintext" align="left" width="80%" bgcolor="#ccccff"><b>Mcat Name</b></td>                        
                        </tr>';
                }

                echo '
                <tr>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="20%">'.$recNotMap['GLCAT_MCAT_ID'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="80%">'.$recNotMap['GLCAT_MCAT_NAME'].'</td>                
                </tr>';
                echo '</table>

                </td>
                </tr>';
                $j++;
        
		$empid = $recNotMap['GL_EMP_ID'];
	}

	echo '</tbody></table>';

	#### Supplier Selection Details ####
        if(!empty($returnResult3['hash']))
        {
		echo '
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top:25px;padding-bottom:20px;">
		<tbody><tr>
		<td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Supplier Selection Details for Offer ID - <font color="red">'.$param["offer"].'</font> <BR></td>
		</tr>
		</tbody></table>';

                echo '
        	<table width="100%" border="0" bgcolor="#f3f3f3" cellspacing="1" cellpadding="0">
        	<tr>
                <td width="6%" bgcolor="#FFFFFF" class="block1" style="padding:4px;border-right: none;"><b>Glusr ID</b></td>
                <td width="27%" bgcolor="#FFFFFF" class="block1" style="padding:4px;border-right: none;"><b>Glusr Company</b></td>
		<td width="9%" bgcolor="#FFFFFF" class="block1" style="padding:4px;border-right: none;" align="center"><b>Glusr Loc Pref</b></td>
		<td width="15%" bgcolor="#FFFFFF" class="block1" style="padding:4px;border-right: none;" align="center"><b>Offer/Product Name</b></td>
		<td width="20%" bgcolor="#FFFFFF" class="block1" style="padding:4px;border-right: none;" align="center"><b>Offer Title</b></td>
		<td width="20%" bgcolor="#FFFFFF" class="block1" style="padding:4px;border-right: none;" align="center"><b>Search Keyword</b></td>
		<td width="3%" bgcolor="#FFFFFF" class="block1" style="padding:4px;border-right: none;"><b>Rank</b></td>
        	</tr>';		
        }

	$i=1;
	$bgcolorRANK='';	
        foreach ($returnResult3['hash'] as $k => $hash) {
        	
			if(preg_match('m/-/',$hash["SUPPLIER_RANK"])) { 
			$bgcolorRANK = 'bgcolor="#FFDADA"'; 
			} else { 
			$bgcolorRANK = ' bgcolor="#FFFFFF"';
			}
			$city = !empty($hash["GLUSR_USR_CITY"])?','.$hash["GLUSR_USR_CITY"]:'';
			 echo '<tr>
			 <td $bgcolorRANK class="block1" style="padding:4px;border-right: none;"> '.$hash["GLUSR_USR_ID"].' </td>
			 <td $bgcolorRANK class="block1" style="padding:4px;border-right: none;">
			 <a href="'.$hash["GLUSR_USR_URL"].'" target="_blank">'.$hash["GLUSR_COMPANY"].'</a> '.$city.'</td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:4px;border-right: none;"> '.$hash["GLUSR_USR_LOC_PREF"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:4px;border-right: none;"> '.$hash["ITEM_OFR_NAME"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:4px;border-right: none;"> '.$hash["ETO_OFR_TITLE"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:4px;border-right: none;"> '.$hash["SEARCH_KEYWORD"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:4px;border-right: none; font-weight:bold;"> '.$hash["SUPPLIER_RANK"].' </td>
			</tr>';
			$i++;
       }	
	echo '</table>';
	echo '</body></html> ';
	