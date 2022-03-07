<?php error_reporting(1);

 ?>
<html>
	<?php $queryID = $returnResult['queryID'];
		$rec = $returnResult['rec'];
		$receiverID = $returnResult['receiverID'];
                $offer = $returnResult['offer'];
		$origMODID = $returnResult['origMODID'];
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
        	echo '<tr><td class="admintext1"><B>Query MODID / Original MODID:</B></td><td class="admintext1">'.$rec['QUERY_MODID'].'/'.$origMODID.' </td></tr>';     
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