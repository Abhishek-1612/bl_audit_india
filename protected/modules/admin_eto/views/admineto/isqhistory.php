<?php //echo '<pre>';print_r($isqData);
if($valid == 1) 
{	
	echo '<STYLE TYPE="text/css">.admintext {font-family:arial; font-size:11px;line-height:15px;}.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}</STYLE><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>'
    . '<tr><td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">'
                . 'ISQ History Detail for Offer ID - <font color="red">'.$param['offer'].'</font> <BR>';

	
	echo '</td></tr></tbody></table><div id="masterdiv" style="clear: both;"><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>';
	$data = 	$isqData;
	
	
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
		$key = $histdate;                
		$formattedData[$key][] = $val;
 	}

	$i = $j = 0;
	
	$dateKeys = array_keys($formattedData);
	$noOfRows = count($dateKeys);
	
	for($x = 0; $x < $noOfRows; $x++)
	{
		$dateTime = $dateKeys[$x];
		$value = $formattedData[$dateTime];		
                $date_isq=isset($value['0']['ETO_ATR_HIST_UPD_TIME_DIS']) ? $value['0']['ETO_ATR_HIST_UPD_TIME_DIS'] : '';
                $date = isset($value['0']['ETO_OFR_HIST_DATE_DISP']) ? $value['0']['ETO_OFR_HIST_DATE_DISP'] : $date_isq;
                $updatedName =  '';
                $empId  = isset($value['0']['ETO_ATR_HIST_UPDBY_ID']) ? $value['0']['ETO_ATR_HIST_UPDBY_ID'] : '-';
                $screen = isset($value['0']['ETO_ATR_HIST_UPDBY_SCREEN']) ? $value['0']['ETO_ATR_HIST_UPDBY_SCREEN'] : '-';  
                $auto_cnt=0;
                if($screen=='LEAP' && $auto_cnt==0){
                    $auto_cnt=1;
                    $etoModel =  new AdminEtoForm();
                    $autoisq=$etoModel->isqautofill($param['offer']);
                    $screen = $screen.' '.$autoisq;
                }
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

	if($noOfRows == 0)
	{
		echo '<tr><td class="admintext1" align="center" colspan="14"><DIV CLASS="tab-head">No Record Found !</DIV> </td></tr>';
	}
	
	echo '</tbody></table>';
}
	