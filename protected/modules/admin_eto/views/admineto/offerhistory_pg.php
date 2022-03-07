<?php
if($valid == 1) 
{	
	echo '<STYLE TYPE="text/css">.admintext {font-family:arial; font-size:11px;line-height:15px;}.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}</STYLE><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">History Detail for Offer ID - <font color="red">'.$param['offer'].'(Postgre)</font> <BR>';

	if(isset($params['start_date']) && !empty($params['start_date']))
	{
		echo '<font color="blue">"'.$status_disp[$status_type[$params['status_type']]].'"</font> Screen between '.$params['start_date'].' & '.$params['end_date'];
	}
	echo '</td></tr></tbody></table><div id="masterdiv" style="clear: both;"><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>';
	$result = 	$returnResult['result'];
	$field_disp = 	$returnResult['field_disp'];
	$isq = $isqData;
	$data = array_merge($result,$isq);
	$formattedData = array();

function phparraysort($Array, $SortBy=array(), $Sort = SORT_REGULAR) {
    if (is_array($Array) && count($Array) > 0 && !empty($SortBy)) {
            $Map = array();
            foreach ($Array as $Key => $Val) {
                $Sort_key = '';
foreach ($SortBy as $Key_key) {
$Sort_key .= $Val[$Key_key];
}                
                $Map[$Key] = $Sort_key;
            }
            asort($Map, $Sort);
            $Sorted = array();
            foreach ($Map as $Key => $Val) {
                $Sorted[] = $Array[$Key];
            }
            return array_reverse($Sorted);
    }
    return $Array;
}
        $data1 = phparraysort($data, array('ETO_OFR_HIST_DATE_SORT','ETO_OFR_HIST_ID'));
 
	
	foreach($data1 as $val){
		$histdate = $val['ETO_OFR_HIST_DATE_SORT'];
                if(isset($val['ATYPE'])){
                    $type = $val['ATYPE'];
                }else{
                    $type = $val['TYPE'];
                }
		$histstatus=isset($val['ETO_OFR_HIST_TYP'])?$val['ETO_OFR_HIST_TYP']:'';
                if($histstatus=='D'){
                    $key = $histdate.'_'.$type.$histstatus;
                }else{
                    $key = $histdate.'_'.$type;
                }
		$formattedData[$key][] = $val;
 	}

	$i = $j = 0;
	$currency='';
	

	$dateKeys = array_keys($formattedData);
	$noOfRows = count($dateKeys);
	
	for($x = 0; $x < $noOfRows; $x++)
	{
		$dateTime = $dateKeys[$x];
		$value = $formattedData[$dateTime];
		
		if(preg_match('/ISQ/', $dateTime))
		{	$date_isq=isset($value['0']['ETO_ATR_HIST_UPD_TIME_DIS']) ? $value['0']['ETO_ATR_HIST_UPD_TIME_DIS'] : '';
			$date = isset($value['0']['ETO_OFR_HIST_DATE_DISP']) ? $value['0']['ETO_OFR_HIST_DATE_DISP'] : $date_isq;
			$updatedName = '';
			$empId  = isset($value['0']['ETO_ATR_HIST_UPDBY_ID']) ? $value['0']['ETO_ATR_HIST_UPDBY_ID'] : '-';
			$screen = isset($value['0']['ETO_ATR_HIST_UPDBY_SCREEN']) ? $value['0']['ETO_ATR_HIST_UPDBY_SCREEN'] : '-';
			$flag = 'ISQ';
			$emp = '';
			if($empId > 0){
				$emp =  " Emp ID - $empId ";
			}
			$html = '';
			echo '<tr><td><br></td></tr><tr><td class="admintext1" align="left"> <b style="color:red;">ISQ Modified</b> On '.$date.' by '.$emp.' using '.$screen.'</td></tr><tr><td class="admintext" width="100%" align="left"><table width="100%" cellspacing="1" cellpadding="1" border="0" align="center"><tbody><tr><td class="admintext" width="40%" bgcolor="#ccccff" align="left"><b>Field Name</b></td><td class="admintext" width="30%" bgcolor="#ccccff" align="left"><b>Old Value</b></td><td class="admintext" width="30%" bgcolor="#ccccff" align="left"><b>New Value</b></td></tr>';
			foreach($value as $up)
			{
				$bgColor = '#eaeaea';
				if($up['ETO_ATR_COLUMN_VALUE'] =='MCAT')
				{
					$bgColor = '#FFEFD5';
				}
				
				$html .= '<tr><td class="admintext1" width="40%" bgcolor="'.$bgColor.'" align="left">'.$up['ETO_ATR_COLUMN_VALUE'].'</td><td class="admintext1" width="30%" bgcolor="#eaeaea" align="left">'.$up['ETO_ATR_HIST_OLD_VALUE'].'</td><td class="admintext1" width="30%" bgcolor="#eaeaea" align="left">'.$up['ETO_ATR_HIST_NEW_VALUE'].'</td></tr>';
			}
			 
			 
			$html .= '</tbody></table></td></tr>';			
			echo $html;
		}	
		elseif(preg_match('/OFFER/', $dateTime))
		{
			$actionDisp = $status_disp[$value['0']['ETO_OFR_HIST_TYP']];			 			 
			if(isset($value['0']['ETO_OFR_HIST_APPROV_FLAG']) && $value['0']['ETO_OFR_HIST_APPROV_FLAG'] == 1)
			{ 		
				$actionDisp = 'Approved';
			}
	
			$ofrHistBy = '';
			$ofrHistDate = isset($value['0']['ETO_OFR_HIST_DATE_DISP'])?$value['0']['ETO_OFR_HIST_DATE_DISP']:'-';
		
			echo '<tr><td><BR></td></tr><tr> <td class="admintext1" align="left"> <B style="color:red;">'.$actionDisp.'</B> On '.$ofrHistDate.' by ';

			
			if(!empty($value['0']['ETO_OFR_HIST_EMP_ID'])){
				echo ' Emp ID - '.$value['0']['ETO_OFR_HIST_EMP_ID'];
			}
			if(empty($value['0']['ETO_OFR_HIST_EMP_ID'])){
			if(!empty($value['0']['ETO_OFR_HIST_USR_ID'])){
				echo ' User ID - '.$value['0']['ETO_OFR_HIST_USR_ID'];
			}
		}
		
		
			if(!empty($value['0']['ETO_OFR_HIST_USING'])){
				echo ' using '.$value['0']['ETO_OFR_HIST_USING'];
			}

			if(!empty($value['0']['ETO_OFR_HIST_COMMENTS'])){
				echo ' ["'.$value['0']['ETO_OFR_HIST_COMMENTS'].'"]';			
			}	
			echo '</td></tr>';
			$j=1;
			
			foreach($value as $rec)
			{
				if($rec['ETO_OFR_HIST_TYP'] == 'P' || $rec['ETO_OFR_HIST_TYP'] == 'U' || $rec['ETO_OFR_HIST_TYP'] == 'N')
				{
					echo '<tr><td class="admintext" align="left" width="100%"><table align="center" border="0" cellpadding="1" cellspacing="1" width="100%">';
						
					$ofrOldVal = isset($rec['ETO_OFR_HIST_OLD_VAL'])?$rec['ETO_OFR_HIST_OLD_VAL']:'';
                                        
					if($rec['ETO_OFR_HIST_FIELD']=='ETO_OFR_CURRENCY_ID')
						$currency  =isset($rec['ETO_OFR_HIST_NEW_VAL'])?$rec['ETO_OFR_HIST_NEW_VAL']:'';
		 
                                       $ofrNewVal = isset($rec['ETO_OFR_HIST_NEW_VAL'])?$rec['ETO_OFR_HIST_NEW_VAL']:'';
                                        
					if($rec['ETO_OFR_HIST_FIELD']=='ETO_OFR_APPROX_ORDER_VALUE'){
                                            if($ofrNewVal <>'' && $currency <> '' && strpos($ofrNewVal,$currency) === false){
                                                $ofrNewVal = isset($rec['ETO_OFR_HIST_NEW_VAL'])?$rec['ETO_OFR_HIST_NEW_VAL'].' '.$currency:'';	
                                            }						
                                        }
					$fieldName = isset($field_disp[$rec['ETO_OFR_HIST_FIELD']])?$field_disp[$rec['ETO_OFR_HIST_FIELD']]:'';
		
					if($j == 1)
					{
						echo '<tr>';
						if($rec['ETO_OFR_HIST_TYP'] == 'N')
						{//for new posted skip old value column
							if(!empty($ofrNewVal)){
								echo '<td class="admintext" align="left" width="40%" bgcolor="#ccccff"><b>Field Name</b></td><td class="admintext" align="left" width="60%" bgcolor="#ccccff"><b>New Value</b></td>	';
							}		
						} 
						else
						{
							echo '<td class="admintext" align="left" width="40%" bgcolor="#ccccff"><b>Field Name</b></td><td class="admintext" align="left" width="30%" bgcolor="#ccccff"><b>Old Value</b></td><td class="admintext" align="left" width="30%" bgcolor="#ccccff"><b>New Value</b></td>';				
						}
						echo '</tr>';
					}
	
					if($rec['ETO_OFR_HIST_TYP'] == 'N')
					{//for new posted skip old value column
						echo '<tr><td class="admintext1" align="left" bgcolor="#eaeaea" width="40%">'.$fieldName.'</td><td class="admintext1" align="left" bgcolor="#eaeaea" width="60%">'.$ofrNewVal.'</td></tr>';		
					} 
					else
					{
						echo '<tr><td class="admintext1" align="left" bgcolor="#eaeaea" width="40%">'.$fieldName.'</td><td class="admintext1" align="left" bgcolor="#eaeaea" width="30%">'.$ofrOldVal.'</td><td class="admintext1" align="left" bgcolor="#eaeaea" width="30%">'.$ofrNewVal.'</td></tr>';		
					}
			
					echo '</table></td></tr>';
					$j++;
				}
			}	
		}
	}

	if($noOfRows == 0)
	{
		echo '<tr><td class="admintext1" align="center" colspan="14"><DIV CLASS="tab-head">No Record Found !</DIV> </td></tr>';
	}
	
	echo '</tbody></table>';
}
	