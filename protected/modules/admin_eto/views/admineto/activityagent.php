<?php 
        $start_date=isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : strtoupper(date('d-M-Y'));  
       $selvendor_name=isset($_POST['vendor']) ? $_POST['vendor']:'';
       $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
        ?>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
        <script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
        <script language="javascript" src="/js/calendar.js"></script>
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="60%" align="center">
	<form name="searchForm" METHOD="post" STYLE="margin-top:0;margin-bottom:0;">
	<TR>
	<td width="100%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 13px;color: #333399;" 
            colspan="3" align="center"><b>Associate Activity Report</b>
	</td>
	</TR>
	<tr>
            <td width="30%" style="font-weight: bold">Select Date:&nbsp;
                <input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
	</td><td width="30%" style="font-weight: bold">&nbsp;&nbsp;Vendor: &nbsp;	
	<select name="vendor" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
	<?php 
       $vendorArr1=array();
               if(count($vendorArr)==1){                                
                    $vendor_name=$vendorArr[key($vendorArr)];
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('2'=>'COGENT','16'=>'COGENTBRB','15'=>'COGENTDNC','3'=>'COGENTINBOUND','12'=>'COGENTINTENT','23'=>'COGENTPNS','4'=>'COMPETENT');
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('21'=>'KOCHARTECH','28'=>'KOCHARTECHAUTO','6'=>'KOCHARTECHCHN','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH','30'=>'KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('17'=>'RADIATE','24'=>'RADIATEAUTO','1'=>'RADIATEDNC','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL');    
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('27'=>'VKALP','10'=>'VKALPAUTOIND','5'=>'VKALPDNC','11'=>'VKALPINTENT','29'=>'VKALPREVIEW');       
                      }else{
                          $vendorArr1 = $vendorArr;
                      }
                }else{
                       unset($vendorArr['0']);
                       $vendorArr1 = $vendorArr;
                }
        foreach($vendorArr1 as  $key => $value)
        {
            if($selvendor_name == $key)
                {
                   echo '<OPTION VALUE="'.$key.'" SELECTED="SELECTED" >'.$value.'</OPTION>';
                }
                else
                {
                    echo '<OPTION VALUE="'.$key.'" >'.$value.'</OPTION>';
                }

        }echo '</select>'; ?>
	</td>
		<td align="center">
		<input type="submit" name="Submit" VALUE="Show">
		</td>
		</tr>
		</form>
	</table>
	
	<?php echo $response?>
	
