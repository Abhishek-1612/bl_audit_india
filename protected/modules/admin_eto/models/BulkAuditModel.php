<?php
class BulkAuditModel extends CFormModel
{
    public function auditSample($empId, $start_date, $end_date, $maxrecords, $vendor_approval, $agentid, $bucket, $action, $vendorArr,$source)
    {    
        $poolname = isset($_REQUEST['pool']) ? $_REQUEST['pool'] : '';
        $poolval  = isset($_REQUEST['poolVal']) ? $_REQUEST['poolVal'] : '';
        $sample_type  = isset($_REQUEST['sample_type']) ? $_REQUEST['sample_type'] : 0;
        $ofrlist  = isset($_REQUEST['ofrlist']) ? $_REQUEST['ofrlist'] : '';
        $rtype=isset($_REQUEST['rtype']) ? $_REQUEST['rtype'] : '';

        $model                   = new GlobalmodelForm(); 

        $poolval  = str_replace(",", "','", $poolval);
        $poolcond = $flag = '';
        if ($poolval == '') {
            $poolcond = '';
        }
        if (preg_match("/DNC-FORIEGN/i", $poolval)) {
            $poolcond .= " AND (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND  UPPER(FK_GL_COUNTRY_ISO) <> 'IN')";
        }
        if (preg_match("/DNC-INDIA/i", $poolval)) {
            $flag .= "13,15,2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99";
        }
        if (preg_match("/MUSTCALL/i", $poolval)) {
            $flag .= ",11,12,26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59";
        }
        if (preg_match("/INTENT/i", $poolval)) {
            $flag .= ",17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79";
        }
        $obj                 = new Globalconnection();
        $agentid             = isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
        $deletedsample       = isset($_REQUEST['deletedsample']) ? $_REQUEST['deletedsample'] : 'NO';
        $deletedreason       = isset($_REQUEST['deletedreasonselect']) ? $_REQUEST['deletedreasonselect'] : 'ALL';
        $deletedcall_noncall = isset($_REQUEST['deletedcall_noncall']) ? $_REQUEST['deletedcall_noncall'] : 'ALL';
        $delsource           = isset($_REQUEST['delsource']) ? $_REQUEST['delsource'] : 'direct';
        $leadtype            = isset($_REQUEST['leadtype']) ? $_REQUEST['leadtype'] : '';
        $buyer_type          = isset($_REQUEST['buyer_type']) ? $_REQUEST['buyer_type'] : '';
        $offerid             = isset($_REQUEST['offer_id']) ? $_REQUEST['offer_id'] : '';
        $process_level=isset($_REQUEST['process_level']) ? $_REQUEST['process_level'] : '';
        if($source<>''){
            $delsource=$source;
        }
        $offerid             = trim($offerid);
        $deletedreasonArr    = array(
            1 => 'Duplicate Requirement',
            3 => 'Invalid Description',
            10 => 'Wrong Contact Details',
            14 => 'Is a Supplier',
            15 => 'No Requirement',
            63 => 'No Requirement - Price Only',
            17 => 'Test Requirement Posted',
            21 => 'Job Enquiry',
            24 => 'Not Ready to Confirm',
            33 => 'Not Talked Lead',
            16 => 'Do Not Call',
            31 => 'Banned and Adult Product',
            35 => 'One Time Pending Deletion',
            45 => 'Deleted because one similar lead recently approved',
            11 => 'Offer Rejected',
            53 => 'Lead from IM employee',
            52 => '3 leads deleted on call',
            41 => 'Drugs Keywords',
            51 => 'Drugs Keywords',
            49 => 'Duplicate Generation - Time',
            61 => 'User Registered With Blacklisted Country',
            36 => 'Blacklisted User',
            37 => 'Disabled User',
            38 => 'Invalid Email Domains'
        );
        $cond='';
        $random_order_cond=$cond_sample_type = '';
        $bind                = array();

        if($sample_type!=''){
            if($sample_type == 1){
                $cond_sample_type =  " and ETO_OFR_DELETEDBYID >0 ";  
            }
            else if($sample_type == 2){
                $cond_sample_type =  " and ETO_OFR_DELETEDBYID <0 ";  
            }
            else{
                $cond_sample_type =  " "; 
            }
        }
        $sample_per_associate='';
        if($maxrecords=='1 Sample Per Associate'){
            $maxrecords=15000;
            $random_order_cond= " ORDER BY ETO_LEAP_EMP_ID ";
            $cond_sample_type=" AND ETO_OFR_DELETEDBYID > 0";
            $sample_per_associate='1';
        }elseif($maxrecords=='2 Sample Per Associate'){
            $random_order_cond= " ORDER BY ETO_LEAP_EMP_ID ";
            $cond_sample_type=" AND ETO_OFR_DELETEDBYID > 0";
            $sample_per_associate='2';
            $maxrecords=20;
        }else{
            $random_order_cond= " ORDER BY random()  ";
            $limitcond=" limit ".$maxrecords;
        }
        
        
        if ($vendor_approval > 0) {
            $cond .= " AND FK_ETO_LEAP_VENDOR_ID = '$vendor_approval' ";
        }
        if ($agentid <> 'ALL') {
            $cond .= " AND ETO_LEAP_EMP_ID = :agentid ";
            $bind[':agentid'] = $agentid;
        }
    if($process_level=='5,6,7'){
       $cond .=" AND eto_leap_emp_process_level in(5,6,7) ";
    }elseif($process_level=='5,6'){
       $cond .=" AND eto_leap_emp_process_level in(5,6) ";       
    }elseif($process_level=='6,7'){
       $cond .=" AND eto_leap_emp_process_level in(6,7) "; 
    }elseif($process_level=='5,7'){
       $cond .=" AND eto_leap_emp_process_level in(5,7) ";       
    }elseif($process_level=='6'){
       $cond .=" AND eto_leap_emp_process_level = 6 ";
    }elseif($process_level=='7'){
       $cond .=" AND eto_leap_emp_process_level =7 ";
    }elseif($process_level=='5'){
       $cond .=" AND eto_leap_emp_process_level =5 ";
    }

        if ($leadtype == 'NR') {
            $cond .= " AND (ETO_ENQ_TYP  IN (2,4) OR ETO_ENQ_TYP IS NULL)  ";
        } elseif ($leadtype == 'R') {
            $cond .= " AND ETO_ENQ_TYP IN (1,3,5) ";
        } elseif ($leadtype == 'AOV') {
            $cond .= " AND USER_IDENTIFIER_FLAG = 24 ";
        }
        if ($buyer_type == 'Frequent') {
            $cond .= " AND ETO_OFR_DISPLAY_TYPE=11 ";
        }
        $sampleArr = array();
        $dbh = $obj->connect_db_yii('postgress_web68v');  
        if ($flag != '') {
            $flag = ltrim($flag, ",");
            $poolcond .= " AND COALESCE(USER_IDENTIFIER_FLAG,0) IN ($flag)";
        }
        $limitcond='';$cond2 = '';           $page_html='';$sn=0;

        if ($delsource == 'direct') {
             if($start_date<>'' ){
                    $cond .= " and date_trunc('day'::text, eto_ofr_deletiondate) = '$start_date'  ";
                }
       
            if (!empty($offerid) && preg_match('/^\d+$/',$offerid)) {
                $cond2 .= " AND ETO_OFR_DISPLAY_ID= :offerid";
                $random_order_cond= "";
                $bind[':offerid'] = $offerid;
            }
            if ($deletedreason <> 'ALL') {
                $cond2 .= " AND FK_ETO_OFR_DEL_REASON_CODE =:deletedreason ";
                $bind[':deletedreason'] = $deletedreason;
            }
            if ($deletedcall_noncall == 1) {
                $cond2 .= " AND ETO_OFR_CALL_RECORDING_URL IS NOT NULL AND ETO_OFR_DELETEDBYID > 0 ";
            }
            if ($deletedcall_noncall == 2) {
                $cond2 .= " AND ETO_OFR_CALL_RECORDING_URL IS  NULL  AND ETO_OFR_DELETEDBYID > 0 ";
            }
            if ($deletedcall_noncall == 3) {
                $cond2 .= " AND ETO_OFR_IS_FLAGGED IS NOT  NULL  AND ETO_OFR_DELETEDBYID > 0 ";
            }
            if ($deletedcall_noncall == 4) {
                $cond2 .= " AND ETO_OFR_DELETEDBYID < 0 ";
            }
            if ($deletedcall_noncall == 5) {
                $cond2 .= " AND ETO_OFR_DELETEDBYID > 0 ";
            }
            // for 1 / 2 sample per associate
            if($ofrlist == '' && $sample_per_associate==2){
                $ofrlist=$this->print_pagination($delsource,$dbh,$bind,$model,$cond ,$cond2 ,$poolcond,$cond_sample_type);
                if($ofrlist <> ''){
                $cond2 .= " AND ETO_OFR_DISPLAY_ID IN($ofrlist) ";
                }
            }elseif($ofrlist <>'' && $sample_per_associate==2){
                $cond2 .= " AND ETO_OFR_DISPLAY_ID IN($ofrlist) ";
            }
            // end 1/2 sample per associate
             $sql="select * from (SELECT ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL,FK_GLUSR_USR_ID,ETO_OFR_DISPLAY_ID,ETO_OFR_TITLE, 
	TO_CHAR(eto_ofr_deletiondate,'DD-Mon-YYYY') ETO_OFR_APPROV_DATE, FK_GL_MODULE_ID, ETO_LEAP_VENDOR_NAME,ETO_LEAP_EMP_NAME,
	ETO_LEAP_EMP_ID,FK_ETO_OFR_DEL_REASON_CODE, (CASE WHEN ETO_ENQ_TYP IN (1,3,5) THEN 'Retail' ELSE 'Non Retail' END) || ' / ' || 
	(CASE WHEN ETO_OFR_DISPLAY_TYPE=11 THEN 'Frequent' ELSE 'Non Frequent' END) || (CASE WHEN USER_IDENTIFIER_FLAG =24 THEN ' / High AOV' END) 
	LEAD_TYPE 
	FROM ETO_OFR_TEMP_DEL, ETO_LEAP_MIS_INTERIM
	WHERE ETO_OFR_DELETEDBYID = ETO_LEAP_EMP_ID 
	$cond_sample_type                  
                $cond
                $cond2
                $poolcond   
	union all 
	SELECT ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL,FK_GLUSR_USR_ID,
	ETO_OFR_DISPLAY_ID,ETO_OFR_TITLE,TO_CHAR(eto_ofr_deletiondate,'DD-Mon-YYYY') ETO_OFR_APPROV_DATE, FK_GL_MODULE_ID, ETO_LEAP_VENDOR_NAME,
	ETO_LEAP_EMP_NAME,ETO_LEAP_EMP_ID,FK_ETO_OFR_DEL_REASON_CODE, 
	(CASE WHEN ETO_ENQ_TYP IN (1,3,5) THEN 'Retail' ELSE 'Non Retail' END) || ' / ' || (CASE WHEN ETO_OFR_DISPLAY_TYPE=11 THEN 'Frequent' ELSE 
	'Non Frequent' END) || (CASE WHEN USER_IDENTIFIER_FLAG =24 THEN ' / High AOV' END) LEAD_TYPE 
	FROM ETO_OFR_TEMP_DEL_ARCH, ETO_LEAP_MIS_INTERIM 
	WHERE ETO_OFR_DELETEDBYID = ETO_LEAP_EMP_ID 
	$cond_sample_type                  
                $cond
                $cond2
                $poolcond )A $random_order_cond $limitcond";
          
        }else {
                if($start_date<>'' ){
                    $cond .= " and date(eto_ofr_deletiondate) = TO_DATE('$start_date','DD-MON-YYYY') ";
                }
             if (!empty($offerid) && preg_match('/^\d+$/',$offerid)) {
                $cond2 .= " AND DIR_QUERY_FREE_REFID= :offerid";
                $random_order_cond= "";
                $bind[':offerid'] = $offerid;
            }
            if ($deletedreason <> 'ALL') {
                $cond2 .= " AND COALESCE(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON) =:deletedreason ";
                $bind[':deletedreason'] = $deletedreason;
            }
            if ($deletedcall_noncall == 1) {
                $cond2 .= " AND FENQ_CALL_RECORDING_URL IS NOT NULL  AND ETO_OFR_FENQ_EMP_ID > 0 ";
            }
            if ($deletedcall_noncall == 2) {
                $cond2 .= " AND FENQ_CALL_RECORDING_URL IS  NULL  AND ETO_OFR_FENQ_EMP_ID > 0 ";
            }
            if ($deletedcall_noncall == 3) {
                $cond2 .= " AND ETO_OFR_IS_FLAGGED IS NOT  NULL  AND ETO_OFR_FENQ_EMP_ID > 0 ";
            }
            if ($deletedcall_noncall == 4) {
                $cond2 .= " AND ETO_OFR_FENQ_EMP_ID < 0 ";
            }
            if ($deletedcall_noncall == 5) {
                $cond2 .= " AND ETO_OFR_FENQ_EMP_ID > 0 ";
            }
            $poolcond = str_replace("FK_GL_COUNTRY_ISO", "S_COUNTRY_UPPER", $poolcond);
            
            $cond=str_replace("eto_ofr_deletiondate", "ETO_OFR_FENQ_DATE", $cond);
            // for 1 / 2 sample per associate
            if($ofrlist == '' && $sample_per_associate==2){
                $ofrlist=$this->print_pagination($delsource,$dbh,$bind,$model,$cond ,$cond2 ,$poolcond,$cond_sample_type);
                if($ofrlist <> ''){
                $cond2 .= " AND DIR_QUERY_FREE_REFID IN($ofrlist) ";
                }
            }elseif($ofrlist <>'' && $sample_per_associate==2){
                $cond2 .= " AND DIR_QUERY_FREE_REFID IN($ofrlist) ";
            }
            // end 1/2 sample per associate
                          
            $sql           = "SELECT * FROM (
          SELECT 
                     FENQ_CALL_RECORDING_URL CALL_RECORDING_URL,FK_GLUSR_USR_ID,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL ETO_OFR_TITLE,TO_CHAR(ETO_OFR_FENQ_DATE,'DD-Mon-YYYY') ETO_OFR_APPROV_DATE,
                     QUERY_MODID FK_GL_MODULE_ID,ETO_LEAP_VENDOR_NAME,ETO_LEAP_EMP_NAME,ETO_LEAP_EMP_ID,COALESCE(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON) FK_ETO_OFR_DEL_REASON_CODE,
                     NULL  || ' / ' || (CASE WHEN ETO_OFR_DISPLAY_TYPE=11 THEN 'Frequent' ELSE 'Non Frequent' END) || (CASE WHEN USER_IDENTIFIER_FLAG =24 THEN ' / High AOV' END) LEAD_TYPE
                FROM 
                    ETO_OFR_FROM_FENQ, ETO_LEAP_MIS_INTERIM      
                WHERE 
                    ETO_OFR_FENQ_EMP_ID = ETO_LEAP_EMP_ID                    
                    AND  FK_ETO_OFR_ID  IS NULL
                $cond
                $cond2
                $poolcond  
                 union all 
                 SELECT 
                     FENQ_CALL_RECORDING_URL CALL_RECORDING_URL,FK_GLUSR_USR_ID,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL ETO_OFR_TITLE,TO_CHAR(ETO_OFR_FENQ_DATE,'DD-Mon-YYYY') ETO_OFR_APPROV_DATE,
                     QUERY_MODID FK_GL_MODULE_ID,ETO_LEAP_VENDOR_NAME,ETO_LEAP_EMP_NAME,ETO_LEAP_EMP_ID,COALESCE(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON) FK_ETO_OFR_DEL_REASON_CODE,
                     NULL  || ' / ' || (CASE WHEN ETO_OFR_DISPLAY_TYPE=11 THEN 'Frequent' ELSE 'Non Frequent' END) || (CASE WHEN USER_IDENTIFIER_FLAG =24 THEN ' / High AOV' END) LEAD_TYPE
                FROM 
                    ETO_OFR_FROM_FENQ_ARCH, ETO_LEAP_MIS_INTERIM      
                WHERE 
                    ETO_OFR_FENQ_EMP_ID = ETO_LEAP_EMP_ID                    
                    AND  FK_ETO_OFR_ID  IS NULL
                $cond
                $cond2
                $poolcond
                ) A 
                $random_order_cond  $limitcond ";            
        } 
        $sth                     = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);
            $prev_empid='';$counter=0;
          while ($rec1 = $sth->read()) {         
            $rec=array_change_key_case($rec1, CASE_UPPER);
            if($counter < 20 && $counter<$maxrecords){  
                        if(($sample_per_associate == '1') && ($prev_empid==$rec['ETO_LEAP_EMP_ID'])) {
                        }else{
                        $counter++;
                        if (isset($rec['FK_ETO_OFR_DEL_REASON_CODE'])) {
                            $deletedReason = isset($deletedreasonArr[$rec['FK_ETO_OFR_DEL_REASON_CODE']]) ? $deletedreasonArr[$rec['FK_ETO_OFR_DEL_REASON_CODE']] : '';
                        } else {
                            $deletedReason = '';
                        }
                        $rec['deletedreason'] = $deletedReason;
                        array_push($sampleArr, $rec);
                        }
                        $prev_empid=$rec['ETO_LEAP_EMP_ID'];
            }else{
                break;
            } 
        } 
        $sampleArr = array(

            array(
                  'CALL_RECORDING_URL' => 'http://112.133.194.234:8082/monitor/20220321/IN-2010-08069043046-20220321-183028-1647867628.313600.WAV',
                  'FK_GLUSR_USR_ID' => '66590605',
                  'ETO_OFR_DISPLAY_ID' => '66590605',
                  'ETO_OFR_TITLE' => 'Kisan Card',
                  'ETO_OFR_APPROV_DATE' => '21-Mar-2022',
                  'FK_GL_MODULE_ID' => 'FLPNS',
                  'ETO_LEAP_VENDOR_NAME' => 'VKALPINTENT',
                  'ETO_LEAP_EMP_NAME' => 'Rashmi Chouhan',
                  'DELETEDREASON' => 'test',
                   'ETO_LEAP_EMP_ID' => '87918',
                     'LEAD_TYPE' => ''
      
              ),
         array(
                       'CALL_RECORDING_URL' => '',
                  'FK_GLUSR_USR_ID' => '116413113',
                  'ETO_OFR_DISPLAY_ID' => '73215676959',
                  'ETO_OFR_TITLE' => 'TENNIS',
                  'ETO_OFR_APPROV_DATE' => '21-Mar-2022',
                  'FK_GL_MODULE_ID' => 'ANDROID',
                  'ETO_LEAP_VENDOR_NAME' => 'COMPETENTDNC',
                  'ETO_LEAP_EMP_NAME' => 'Sukhwinder Kumar',
                  'DELETEDREASON' => 'test',
                   'ETO_LEAP_EMP_ID' => '80558',
                     'LEAD_TYPE' => ''
              ),
          );
        return $sampleArr; 
    }
    public function printsample($dataArr)
    {
        $checkradio1 = "checked";
        $checkradio2 = "";
        $check1 = $check2 =  $check3 =$check4= '';

        $tot_records = count($dataArr);
        if ($tot_records > 0) {

            echo '<br><table style="border-collapse: collapse;" border="0" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">';
            $all_ofr_id = '';
            for ($i = 0; $i < count($dataArr); $i++) {
                $title   = isset($dataArr[$i]['ETO_OFR_TITLE']) ? $dataArr[$i]['ETO_OFR_TITLE'] : '';
                $offerID = isset($dataArr[$i]['ETO_OFR_DISPLAY_ID']) ? $dataArr[$i]['ETO_OFR_DISPLAY_ID'] : '';
                $all_ofr_id .= $offerID . ",";
                $ETO_OFR_APPROV_DATE = isset($dataArr[$i]['ETO_OFR_APPROV_DATE']) ? $dataArr[$i]['ETO_OFR_APPROV_DATE'] : '';
                if (isset($dataArr[$i]['CALL_RECORDING_URL'])) {
                    $prim1              = $dataArr[$i]['CALL_RECORDING_URL'];
                    $CALL_RECORDING_URL = '<a href="' . $prim1 . '" TARGET="_blank"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A>';
                } else {
                    $CALL_RECORDING_URL = '<b style="color:#0000ff">&#187;&nbsp;Recording Not Available </b>';
                }
                $glid = $dataArr[$i]["FK_GLUSR_USR_ID"];
                echo '<tr>
                                     <td style="background: #0195d3; color: white;padding:4px;"><b>SNo:</b>&nbsp;'.($i + 1).'&nbsp;&nbsp;<b>ID:</b>&nbsp; <a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=' . $dataArr[$i]['ETO_OFR_DISPLAY_ID'] . '&go=Go&mid=3424" style="text-decoration:none;color: white;" target="_blank">' . $dataArr[$i]['ETO_OFR_DISPLAY_ID'] . '</a></td>
                                     <td style="background: #0195d3; color: white;padding:4px;"><b>Lead title:</b>&nbsp;' . $title . '</td>
                                     <td style="background: #0195d3; color: white;padding:4px;"><b>History:</b>&nbsp; <a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=ofrHist&offer=' . $dataArr[$i]['ETO_OFR_DISPLAY_ID'] . '&mid=3424" style="text-decoration:none;color: white;" target="_blank">' . $dataArr[$i]['ETO_OFR_DISPLAY_ID'] . '</a></td>
                                     </tr>
                                     <tr><td style="padding:4px;"><b>Associate:</b>&nbsp; ' . $dataArr[$i]['ETO_LEAP_EMP_NAME'] . '(' . $dataArr[$i]['ETO_LEAP_EMP_ID'] . ')</td>
                                     <td style="padding:4px;"><b>Call Recording:</b>&nbsp; ' . $CALL_RECORDING_URL . '</td><td style="padding:4px;"><a href="index.php?r=admin_eto/OfferDetail/multiplecallrecord&offer=' . $offerID . '&mid=3424" target="_blank">&#187;&nbsp;View All Recordings</A></td>
                                     </tr><tr>
                                     <td style="padding:4px;"><b>Deletion On:</b>&nbsp; ' . $ETO_OFR_APPROV_DATE . '</td>
                                     <td style="padding:4px;"><input onclick = "validate_radio(this.name)" type="radio" name="delopt_' . $offerID . '" value="227"  '.$checkradio1.'  id="delopt_' . $offerID . '">
                                         <font color="green">&nbsp;No Error Found</font>
                                     </td>  
                                      <td width="40%" rowspan=2>
                                      <table border=0 cellpadding="0" cellspacing="0"  width="100%"><tr>
                                      <td><input onclick = "validate_opt(this.name)"  type="checkbox" '.$check1.' width="100px" value="228" name="chk_' . $offerID . '" id="chk_228_' . $offerID . '">
                                    <font color="red">Wrong Deletion Disposition Selection</font></td>
                                    <td><input onclick = "validate_opt(this.name)"  type="checkbox" '.$check3.' width="100px" value="230" name="chk_' . $offerID . '" id="chk_230_' . $offerID . '">
                                        <font color="red">Phone Etiquette Error</font>
                                        </td></tr>

                                        
                                        <tr>
                                        <td><input onclick = "validate_opt(this.name)"  type="checkbox" '.$check1.' width="100px" value="228" name="chk_' . $offerID . '" id="chk_228_' . $offerID . '">
                                        <font color="red">Can be Approved</font></td>
                                        <td><input onclick = "validate_opt(this.name)"  type="checkbox" '.$check3.' width="100px" value="230" name="chk_' . $offerID . '" id="chk_230_' . $offerID . '">
                                        <font color="red">Can be Flagged</font>
                                        </td></tr>



                                        <tr><td><input onclick = "validate_opt(this.name)"  type="checkbox" '.$check2.' width="100px" value="229" name="chk_' . $offerID . '" id="chk_229_' . $offerID . '">
                                        
                                       
                                        <font color="red">Others/Tech Issue</font></td></tr>
                                        </table></td></tr>
                                     <tr>
                                     <td style="padding:4px;"><b>Deletion Reason: </b>&nbsp;' . @$dataArr[$i]['deletedreason'] . '</td>
                                     <td><input type="radio" '.$checkradio2.' onclick = "validate_radio(this.name)" name="delopt_' . $offerID . '" id="delopt_' . $offerID . '" value="2" ><font color="red">&nbsp;Error Found</font></td>
                                     </tr><tr>
                                     <td style="padding:4px;"><b>User Stats: </b>&nbsp;<input type="button" name="showuserstat_' . $offerID . '" id="showuserstat_' . $offerID . '" value="Show" onclick="showuserstats(' . $offerID . ',' . $glid . ')"><div style="font-size:12px;padding:8px 15px 8px 8px; line-height:23px;letter-spacing:-0.02em;font-weight:bold" id="userstat_' . $offerID . '"></div>
                                     </td>
                                     <td style="padding:4px;" colspan=2><textarea id="remarks_' . $offerID . '" name="remarks" style="width: 98%; height: 40px; margin-bottom:8px; ">Comment(if any):</textarea></td>
                                     </tr>';
            }
            $all_ofr_id = trim($all_ofr_id, ",");
            echo '<TR >
                            <TD valign="top"  align="center" colspan=3><input id = "save_all" type="button" name="save_all" value="Save All" class="btn btn-success" ONCLICK="return check_validate();">
                            <input id = "all_ofr_id" type="hidden" name="all_ofr_id" value="' . $all_ofr_id . '"> </table>';

            
        } else {
            echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
        }
    }
    public function save_audit_details()
    {
        $serv_model               = new ServiceGlobalModelForm();
        $BL_AUDIT_RESPONSE_EMP_ID = Yii::app()->session['empid'];
        $errormessage             = '';
        // Save main details
        $request                  = Yii::app()->request;
        $opt_ids                  = $request->getParam('opt_ids');
        $opt_ids_array            = json_decode($opt_ids, true);
        foreach ($opt_ids_array as $row) {
            $opt_val  = $row['opt_val'];
           
            
            $offerid  = $row['ofr_id'];
            $ques_val = $row['ques_val'];
          
            
            $REMARKS  = $row['rem_val'];

            $opt_val=implode(",",$opt_val);         
            $ques_val=implode(",",$ques_val); 
            $content  = array(
                'token' => 'imobile1@15061981',
                "QUESTION_ID" => $ques_val,
                "QUES_OPT_ID" => $opt_val,
                'modid' => 'GLADMIN',
                'REMARKS' => $REMARKS,
                'OFR_DISPLAY_ID' => $offerid,
                'EMP_ID' => $BL_AUDIT_RESPONSE_EMP_ID,
                'action' => 'Insert'
            );
         
            if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') {
                $url = 'http://stg-leads.imutils.com/wservce/glreport/blaudit/';
            } else {
                $url = 'http://leads.imutils.com/wservce/glreport/blaudit/';
            }
            $dataHash = $serv_model->mapiService('BLAUDIT', $url, $content, 'No');
           // print_r($dataHash); exit;
            if ($dataHash['Response']['Code'] == 200) {
                $errormessage .= 'Offer id:' . $offerid . ' Audit Id:' . $dataHash['Response']['MainPrimeId'] . "<br>";
            } else {
                $errormessage .= 'Offer id:' . $offerid . " Error: Some Error occured" . "<br>";
            }
        }
        return $errormessage;
    }
    
    
    
    
    public function auditDump_mis($postgre, $start_date, $end_date, $action, $vendor_approve, $vendor_audit, $auditId, $AssociateId ,$deleted_by)
    {
        
        $emp_id = Yii::app()->session['empid'];
        $strt1        = strtotime($start_date);
        $end1         = strtotime($end_date);
        $today        = strtotime(date("d-M-Y"));
        $rtype =isset($_REQUEST["rtype"]) ? $_REQUEST["rtype"] : '';
        $offerid      = isset($_REQUEST['offer_id']) ? $_REQUEST['offer_id'] : '';
        $offerid      = trim($offerid);
        $auditId      = trim($auditId);   
        $score        = isset($_REQUEST['score']) ? $_REQUEST['score'] : '';     
        $string       = '';
        $leader       = isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
        $sample_type  = isset($_REQUEST['sample_type']) ? $_REQUEST['sample_type'] : 0;
       
        $deletedreason       = isset($_REQUEST['deletedreasonselect']) ? $_REQUEST['deletedreasonselect'] : 'ALL';
        $qa           = isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
        $agent        = isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
        $vendor1      = isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : array();
        $score        = isset($_REQUEST['score']) ? $_REQUEST['score'] : '';
        $archive_data = isset($_REQUEST['Archive_data']) ? $_REQUEST['Archive_data'] : ''; 
        $process_level=isset($_REQUEST['process_level']) ? $_REQUEST['process_level'] : '';
        $AssociateId=isset($_REQUEST['agent_id']) ? $_REQUEST['agent_id'] : ''; 
        $obj          = new Globalconnection();  
        
        $cond_sample_type = '';

        if($sample_type!=''){
            if($sample_type == 1){
                $cond_sample_type =  " and ETO_OFR_DELETEDBYID >0 ";  
            }
            else if($sample_type == 2){
                $cond_sample_type =  " and ETO_OFR_DELETEDBYID <0 ";  
            }
            else{
                $cond_sample_type =  " "; 
            }
        }
        if (isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')) {
            $dbh = $obj->connect_db_yii('postgress_web77v');
        } else {
            $dbh = $obj->connect_db_yii('postgress_web68v');
        }
        if (!empty($archive_data)) {
            $BL_AUDIT_RESPONSE        = 'BL_AUDIT_RESPONSE_ARCH';
            $BL_AUDIT_RESPONSE_DETAIL = 'BL_AUDIT_RESPONSE_DETAIL_ARCH';
        } else {
            $BL_AUDIT_RESPONSE        = 'BL_AUDIT_RESPONSE';
            $BL_AUDIT_RESPONSE_DETAIL = 'BL_AUDIT_RESPONSE_DETAIL';
        }
        if (!empty($vendor1) && !in_array("ALL", $vendor1)) {
            $string = implode(',', $vendor1);
            $string = str_replace("EMP", 0, $string);
            $string = str_replace("AGENT", 1, $string);
            $string = str_replace("TL", 2, $string);
            $string = str_replace("QA", 3, $string);
            $string = str_replace("MGR", 4, $string);
        } else {
            $string = '';
        }        
            if ((($strt1 == $today && $end1 == $today) || ($auditId <> '' || $offerid <> '')) && empty($archive_data)) {
                $db_flag = 0;
            }
            $qtype = " QUESTION_TYPE = 9 ";
        
        $recVendorAll = CommonVariable::get_active_vendor_list();        
        $dataArr = array();
        $bind    = array();
        $con1    = $con2 = "";

        if ($string != '') {
            if (strlen($string) == 1) {
                $con1 .= " AND ELM2.ETO_LEAP_EMP_LEVEL= $string ";
            } else {
                $con1 .= " AND ELM2.ETO_LEAP_EMP_LEVEL in ($string) ";
            }
        }
        if ($AssociateId > 0) {
            $con1 .= " AND ELM1.ETO_LEAP_EMP_ID = :ETO_LEAP_EMP_ID ";
            $bind[':ETO_LEAP_EMP_ID'] = $AssociateId;
        }    
        if ($deleted_by <> 'ALL') {
            foreach ($recVendorAll as $key => $value) {
                if ($deleted_by == $value) {
                    $con1 .= " AND ELM1.FK_ETO_LEAP_VENDOR_ID = :deleted_by ";
                    $bind[':deleted_by'] = $key;
                }
            }
        }
    $seljob_type=isset($_REQUEST['seljob_type']) ? $_REQUEST['seljob_type'] : '';  
    if($seljob_type==11){
        $con1 .=" AND ELM1.FK_ETO_LEAP_VENDOR_ID in(4,11,40,51,54,55,56,57) ";
    }
    if($seljob_type==12){
        $con1 .=" AND ELM1.FK_ETO_LEAP_VENDOR_ID in(5,34) ";
    }

    if($process_level=='5,6,7'){
       $con1 .= " AND ELM1.eto_leap_emp_process_level in(5,6,7) ";
    }elseif($process_level=='5,6'){
       $con1 .= " AND ELM1.eto_leap_emp_process_level in(5,6) ";       
    }elseif($process_level=='6,7'){
       $con1 .= " AND ELM1.eto_leap_emp_process_level in(6,7) "; 
    }elseif($process_level=='5,7'){
       $con1 .= " AND ELM1.eto_leap_emp_process_level in(5,7) ";       
    }elseif($process_level=='6'){
       $con1 .= " AND ELM1.eto_leap_emp_process_level = 6 ";
    }elseif($process_level=='7'){
       $con1 .= " AND ELM1.eto_leap_emp_process_level =7 ";
    }elseif($process_level=='5'){
       $con1 .= " AND ELM1.eto_leap_emp_process_level =5 ";
    }

        if ($vendor_audit <> 'ALL') {
            foreach ($recVendorAll as $key => $value) {
                if ($vendor_audit == $value) {
                    $con1 .= " AND ELM2.FK_ETO_LEAP_VENDOR_ID = :vendor_audit ";
                    $bind[':vendor_audit'] = $key;
                }
            }
        }

        
        if ($leader <> 'ALL' && $db_flag == 1) {
            $con1 .= " AND ELM2.ETO_LEAP_TL_ID =:leader ";
            $bind[':leader'] = $leader;
        }
        
        if ($qa <> 'ALL') {
            $con1 .= " AND ELM2.ETO_LEAP_QA_ID = :qa ";
            $bind[':qa'] = $qa;
        }
        
        if($rtype == 'freelancemgr'){
            $objAuditModel =new AuditModel_v1;
            $agentlist=$objAuditModel->getemplist();//print_r($agentlist);
            $freelanceagentlist= $agentlist[0]['emplist'];//die;
            if($agentlist<>''){
            $con1 .=" AND ELM2.ETO_LEAP_EMP_ID in($freelanceagentlist) ";
            }
        }else{
             if ($agent <> 'ALL') {
                if(trim($agent)<>''){
                $con1 .= " AND ELM2.ETO_LEAP_EMP_ID = :agent ";
                $bind[':agent'] = $agent;
                }
            }
        }   
        if ($deletedreason <> 'ALL') {
            $con2 .= " AND FK_ETO_OFR_DEL_REASON_CODE =:deletedreason ";
            $bind[':deletedreason'] = $deletedreason;
        }
        
        if (!empty($offerid)) {
            $con1 .= " AND FK_ETO_OFR_DISPLAY_ID= :offerid";
            $bind[':offerid'] = $offerid;
        }
        if (!empty($auditId)) {
            $con1 .= " AND BL_AUDIT_RESPONSE_ID= :auditId";
            $bind[':auditId'] = $auditId;
        }
        
        $con_date = '';
        if (($strt1 == $today && $end1 == $today) && ($auditId == '' && $offerid == '')) {
            $con_date .= "  AND date(BL_AUDIT_RESPONSE_DATE) >= date(now()) ";
        } elseif ($auditId <> '' || $offerid <> '') {
            $con_date .= " AND date(BL_AUDIT_RESPONSE_DATE) >= date(now())-90 ";
        } else {
            $con_date .= " AND DATE(BL_AUDIT_RESPONSE_DATE) >= to_date(:STARTDATE,'DD-MON-YYYY') AND DATE(BL_AUDIT_RESPONSE_DATE) <= to_date(:ENDDATE,'DD-MON-YYYY')";
            $bind[':STARTDATE'] = $start_date;
            $bind[':ENDDATE']   = $end_date;
        }
        $con_score=$con_score_opt = "";
        if($score=='pass'){
            $con_score=" and d.bl_audit_ques_opt_desc='Pass'";
            $con_score_opt = " and OPT is not null";            
        }
        else if($score=='fail'){
            $con_score=" and d.bl_audit_ques_opt_desc <>'Pass'";
            $con_score_opt = " and OPT is not null";
        }
        
       
      
        $p_res_id   = '';
        $cnt        = 0;
        $vendorName = $quesDetailsSql = '';
        if ($action == 'submit_dump' || $action == "exportEXL") {
            $etoModel = new AdminEtoForm();
            $emp_id   = Yii::app()->session['empid'];
            if ($emp_id > 0) {
                $recVendor  = $etoModel->getLeapEmpLVL($emp_id);
                $vendorName = isset($recVendor['ETO_LEAP_VENDOR_NAME']) ? $recVendor['ETO_LEAP_VENDOR_NAME'] : '';
            }
        }
            $quesDetailsSql = " SELECT ELM1.ETO_LEAP_VENDOR_NAME, 
       ELM2.ETO_LEAP_EMP_NAME 
       || '-' 
       || ELM2.ETO_LEAP_VENDOR_NAME AUDITOR_NAME, 
       RES_DATE, 
       BL_AUDIT_RESPONSE_ID, 
       FK_ETO_OFR_DISPLAY_ID, 
       ELM1.ETO_LEAP_EMP_NAME       ASSOC_NAME, 
       ELM1.ETO_LEAP_EMP_ID, 
       OPT, 
       REMARKS, 
       QUESTION_TYPE, 
       BL_AUDIT_REBUTTAL_RES_ID,FK_ETO_OFR_DEL_REASON_CODE  
FROM   (WITH AUDIT_TBL 
              AS (SELECT BL_AUDIT_RESPONSE_ID, 
                         FK_ETO_OFR_DISPLAY_ID, 
                         BL_AUDIT_RESPONSE_EMP_ID, 
                         TO_CHAR(BL_AUDIT_RESPONSE_DATE, 
                         'DD-MON-YYYY HH:MI:SS AM') 
                         RES_DATE, 
                         REMARKS, 
                         (SELECT QUESTION_TYPE 
                                 || '#' 
                                 || QUESTION_ID 
                                 || '#' 
                                 || IS_FORMATING 
                                 || '#' 
                                 || IS_NOISE 
                                 || '#' 
                                 || QUESTION_WEIGHTAGE 
                          FROM   BL_AUDIT_QUESTION C 
                          WHERE  QUESTION_ID = B.FK_QUESTION_ID 
                                 AND  $qtype ) 
                            QUESTION_TYPE, 
                         (SELECT BL_AUDIT_QUES_OPT_DESC 
                          FROM   BL_AUDIT_QUES_OPT D 
                          WHERE  D.BL_AUDIT_QUES_OPT_ID = 
                                 B.FK_BL_AUDIT_QUES_OPT_ID $con_score
                                 ) OPT 
                         , 
                         (SELECT FK_BL_AUDIT_RESPONSE_ID 
                          FROM   BL_AUDIT_REBUTTAL 
                          WHERE  FK_BL_AUDIT_RESPONSE_ID = 
                                 A.BL_AUDIT_RESPONSE_ID) 
                            BL_AUDIT_REBUTTAL_RES_ID 
                  FROM   $BL_AUDIT_RESPONSE A, 
                         $BL_AUDIT_RESPONSE_DETAIL B 
                  WHERE  A.BL_AUDIT_RESPONSE_ID = B.FK_BL_AUDIT_RESPONSE_ID 
                            $con_date 
                         ) 
        SELECT 
                ETO_OFR_DISPLAY_ID, 
                ETO_OFR_DELETEDBYID ETO_OFR_APPROV_BY_ORIG, 
                BL_AUDIT_RESPONSE_ID, 
                FK_ETO_OFR_DISPLAY_ID, 
                BL_AUDIT_RESPONSE_EMP_ID, 
                RES_DATE, 
                REMARKS, 
                QUESTION_TYPE, 
                OPT, 
                BL_AUDIT_REBUTTAL_RES_ID,ETO_OFR_HIST_COMMENTS||'('|| FK_ETO_OFR_DEL_REASON_CODE ||')' FK_ETO_OFR_DEL_REASON_CODE 
                
                                                                            FROM 
                ETO_OFR_TEMP_DEL, 
                AUDIT_TBL 
        WHERE 
                ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID 
                $con2    $cond_sample_type
        UNION ALL 
        SELECT 
                ETO_OFR_DISPLAY_ID, 
                ETO_OFR_DELETEDBYID ETO_OFR_APPROV_BY_ORIG, 
                BL_AUDIT_RESPONSE_ID, 
                FK_ETO_OFR_DISPLAY_ID, 
                BL_AUDIT_RESPONSE_EMP_ID, 
                RES_DATE, 
                REMARKS, 
                QUESTION_TYPE, 
                OPT, 
                BL_AUDIT_REBUTTAL_RES_ID,ETO_OFR_HIST_COMMENTS||'('|| FK_ETO_OFR_DEL_REASON_CODE ||')' FK_ETO_OFR_DEL_REASON_CODE  
                                                                            FROM 
                ETO_OFR_TEMP_DEL_ARCH, 
                AUDIT_TBL 
        WHERE 
                ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID 
                $con2    $cond_sample_type
        UNION ALL 
        SELECT 
                DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID, 
                ETO_OFR_FENQ_EMP_ID  ETO_OFR_APPROV_BY_ORIG, 
                BL_AUDIT_RESPONSE_ID, 
                FK_ETO_OFR_DISPLAY_ID, 
                BL_AUDIT_RESPONSE_EMP_ID, 
                RES_DATE, 
                REMARKS, 
                QUESTION_TYPE, 
                OPT, 
                BL_AUDIT_REBUTTAL_RES_ID, (SELECT IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID=3 and IIL_MASTER_DATA_VALUE=
                                Coalesce(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON)::text) ||'('|| Coalesce(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON) ||')' FK_ETO_OFR_DEL_REASON_CODE 
                                                                            FROM 
                ETO_OFR_FROM_FENQ, 
                AUDIT_TBL 
        WHERE 
                DIR_QUERY_FREE_REFID = FK_ETO_OFR_DISPLAY_ID 
                AND FK_ETO_OFR_ID IS NULL 
         UNION ALL 
         SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID, 
                ETO_OFR_FENQ_EMP_ID  ETO_OFR_APPROV_BY_ORIG, 
                BL_AUDIT_RESPONSE_ID, 
                FK_ETO_OFR_DISPLAY_ID, 
                BL_AUDIT_RESPONSE_EMP_ID, 
                RES_DATE, 
                REMARKS, 
                QUESTION_TYPE, 
                OPT, 
                BL_AUDIT_REBUTTAL_RES_ID,(SELECT IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID=3 and IIL_MASTER_DATA_VALUE=
                                Coalesce(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON)::text) ||'('|| Coalesce(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON) ||')' FK_ETO_OFR_DEL_REASON_CODE  
         FROM   ETO_OFR_FROM_FENQ_ARCH, 
                AUDIT_TBL 
         WHERE  DIR_QUERY_FREE_REFID = FK_ETO_OFR_DISPLAY_ID 
                AND FK_ETO_OFR_ID IS NULL
                ) OFR, 
        ETO_LEAP_MIS_INTERIM  ELM1, 
        ETO_LEAP_MIS_INTERIM  ELM2 
WHERE  OFR.ETO_OFR_APPROV_BY_ORIG = ELM1.ETO_LEAP_EMP_ID 
       AND ELM2.ETO_LEAP_EMP_ID = BL_AUDIT_RESPONSE_EMP_ID 
       AND QUESTION_TYPE IS NOT NULL $con1 $con_score_opt
ORDER  BY BL_AUDIT_RESPONSE_ID, 
          QUESTION_TYPE  ";
            
        $model = new GlobalmodelForm();
        $sth   = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $quesDetailsSql, $bind);
        
        if($sth){
        while ($rec1 = $sth->read()) {
            
            $rec                                 = array_change_key_case($rec1, CASE_UPPER);
            $rec_set                             = array(); //echo"printing<pre>";print_r($rec);
            $rec_set['ETO_LEAP_VENDOR_NAME']     = $rec['ETO_LEAP_VENDOR_NAME'];
            $rec_set['AUDITOR_NAME']             = $rec['AUDITOR_NAME'];
            $rec_set['RES_DATE']                 = $rec['RES_DATE'];
            $rec_set['BL_AUDIT_RESPONSE_ID']     = $rec['BL_AUDIT_RESPONSE_ID'];
            $rec_set['FK_ETO_OFR_DISPLAY_ID']    = $rec['FK_ETO_OFR_DISPLAY_ID'];
            $rec_set['ASSOC_NAME']               = $rec['ASSOC_NAME'];
            $rec_set['ETO_LEAP_EMP_ID']          = $rec['ETO_LEAP_EMP_ID'];
            $rec_set['FK_ETO_OFR_DEL_REASON_CODE'] = isset($rec['FK_ETO_OFR_DEL_REASON_CODE']) ? $rec['FK_ETO_OFR_DEL_REASON_CODE'] : '';
            $rec_set['REMARKS']                  = $rec['REMARKS'];
            $rec_set['BL_AUDIT_RESPONSE_ID']     = $rec['BL_AUDIT_RESPONSE_ID'];
            $rec_set['BL_AUDIT_REBUTTAL_RES_ID'] = isset($rec['BL_AUDIT_REBUTTAL_RES_ID']) ? $rec['BL_AUDIT_REBUTTAL_RES_ID'] : '';
          
            $rec_set['OPT'] = $rec['OPT'];
            array_push($dataArr, $rec_set);
        }
        }
        $cnt = 0;
        $d1  = $d2 = $arr_q = $head = $d_final = array();
            $head[0]  = "Partner Name";
            $head[1]  = "Auditor Name";
            $head[2]  = "Audit Date/Time";
            $head[3]  = "Audit ID";
            $head[4]  = "Offer ID";
            $head[5]  = "Deleted By";
            $head[6]  = "Deleted By (ID)";
            $head[7]  = "Deletion Reason";

            $head[8]  = "Audit Status";
            $head[9]  = "Wrong Deletion Disposition Selection";
            $head[10]  = "Wrong Deletion";
            $head[11] = "Phone Etiquette Error";
            $head[12] = "Others";
            $head[13] = "Comments (if any)";
            $head[14] = "Score Including";
            $head[15] = "Raise Rebuttal";       
            array_push($d1, $head);
            foreach ($dataArr as $sampleValue) {
                if ($p_res_id != $sampleValue['BL_AUDIT_RESPONSE_ID']) {
                    $k = 0;
                    $cnt++;
                   
                    $d1[$cnt][$k++] = $sampleValue['ETO_LEAP_VENDOR_NAME'];
                    $d1[$cnt][$k++] = $sampleValue['AUDITOR_NAME'];
                    $d1[$cnt][$k++] = $sampleValue['RES_DATE'];
                    $d1[$cnt][$k++] = $sampleValue['BL_AUDIT_RESPONSE_ID'];
                    $d1[$cnt][$k++] = $sampleValue['FK_ETO_OFR_DISPLAY_ID'];
                    $d1[$cnt][$k++] = $sampleValue['ASSOC_NAME'];
                    $d1[$cnt][$k++] = $sampleValue['ETO_LEAP_EMP_ID'];
                    $d1[$cnt][$k++] = $sampleValue['FK_ETO_OFR_DEL_REASON_CODE'];
                    $d1[$cnt][9]=$d1[$cnt][10]=$d1[$cnt][11]=$d1[$cnt][12]="-";

                    if($sampleValue['OPT'] =="Pass"){
                        $d1[$cnt][8] = "Pass"; //Audit Status
                        $d1[$cnt][14] = 1;   //Score
                    }
                    else{
                        $d1[$cnt][8] = "Fail"; //Audit Status
                        $d1[$cnt][14] = 0;  //score
                    }

                    if (($action == 'submit_dump' || $action == "exportEXL") && ($vendorName == 'DDN' && preg_match("/DDN/i", $sampleValue['AUDITOR_NAME']) == 0)) {
                        $d1[$cnt][13] = '-';
                    } else {
                        $d1[$cnt][13] = $sampleValue['REMARKS'];
                    }
                    
                    if (!empty($sampleValue['BL_AUDIT_REBUTTAL_RES_ID']))
                        $REBUTTAL_RAISE = 'Yes';
                    else
                        $REBUTTAL_RAISE = 'No';
                    $d1[$cnt][15] = $REBUTTAL_RAISE;
                }
                if($sampleValue['OPT'] == "Wrong Deletion Disposition Selection"){
                    $d1[$cnt][9]=$sampleValue['OPT'];
                }elseif($sampleValue['OPT'] == "Wrong Deletion"){
                    $d1[$cnt][10]=$sampleValue['OPT'];
                }elseif($sampleValue['OPT'] == "Phone Etiquette Error"){
                    $d1[$cnt][11]=$sampleValue['OPT'];                       
                }elseif($sampleValue['OPT'] == "Others"){
                    $d1[$cnt][12]=$sampleValue['OPT'];                       
                }
                $p_res_id = $sampleValue['BL_AUDIT_RESPONSE_ID'];
            }
            
            $cnt     = 0;
            $d_final = array();
            for ($i = 0; $i < count($d1); $i++) { 
                    array_push($d_final, $d1[$i]);     
                    }
        if($action=="exportEXL"){
            $filename_out = "/home3/indiamart/public_html/excel_download/bulk_bigbuyer_output/";
            $filename_out .= 'del_audit_mis'.'.xls';
            $filename = fopen($filename_out, "w");
            $i=0;
            foreach($d_final as $temp)
            {
                    $tempfile=$temp[0]."##".$temp[1]."##".$temp[2]."##".$temp[3]."##".$temp[4]."##".$temp[5]."##".$temp[6]."##".$temp[7]."##".$temp[8]."##".$temp[9]."##".$temp[10]."##".$temp[11]."##".$temp[12]."##".$temp[13];
                    $tempfile2=preg_replace('/,/', "", $tempfile);
                    $d1_file=preg_replace('/##/', ",", $tempfile2);
                    $d2_file=preg_replace('/[^A-Za-z0-9\-,+\(\):]/', ' ', $d1_file);
                    $d3_file=preg_replace('/,\s/', "", $d2_file);
                    fwrite($filename,"$d3_file\t\n");                
                $i++;
            }

            fclose($filename);
            $this->export($filename_out);
           }else{
               return $d_final;
           }    
    }
    
   public function export($filename_out)
{
        $data = file_get_contents($filename_out);
          header("Content-Type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=\"$filename_out\"");
        echo $data;		
        exit();
}
 
        
    public function auditdetailbyID($auditId)
    {
        $archive_data=$con='';
        $rec=array();
        $auditId      = trim($auditId);   
        $obj          = new Globalconnection();  
        $con = $qtype = '';    
        if (isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')) {
            $dbh = $obj->connect_db_yii('postgress_web68v');
        } else {
            $dbh = $obj->connect_db_yii('postgress_web68v');
        }
        if (!empty($archive_data)) {
            $BL_AUDIT_RESPONSE        = 'BL_AUDIT_RESPONSE_ARCH';
            $BL_AUDIT_RESPONSE_DETAIL = 'BL_AUDIT_RESPONSE_DETAIL_ARCH';
        } else {
            $BL_AUDIT_RESPONSE        = 'BL_AUDIT_RESPONSE';
            $BL_AUDIT_RESPONSE_DETAIL = 'BL_AUDIT_RESPONSE_DETAIL';
        }
            $qtype = " QUESTION_TYPE =9 ";
        if ($auditId>0) {
            $con = " AND BL_AUDIT_RESPONSE_ID= :auditId";
            $bind[':auditId'] = $auditId;        
      
            $quesDetailsSql = " WITH AUDIT_TBL AS
            (
            SELECT BL_AUDIT_RESPONSE_ID,
            FK_ETO_OFR_DISPLAY_ID,
            BL_AUDIT_RESPONSE_EMP_ID,
            TO_CHAR(BL_AUDIT_RESPONSE_DATE,'DD-Mon-yyyy HH:MI:SS AM') RES_DATE,
            REMARKS,
            (
            SELECT QUESTION_TYPE||'#'||QUESTION_ID||'#'||IS_FORMATING||'#'|| IS_NOISE||'#'||
            QUESTION_WEIGHTAGE
            FROM BL_AUDIT_QUESTION c
            WHERE QUESTION_ID = b.FK_QUESTION_ID AND $qtype
            )
            QUESTION_TYPE,
            (SELECT   BL_AUDIT_QUES_OPT_DESC
            FROM BL_AUDIT_QUES_OPT d
            WHERE d.BL_AUDIT_QUES_OPT_ID = b.FK_BL_AUDIT_QUES_OPT_ID
            ) OPT ,
            (
            SELECT FK_BL_AUDIT_RESPONSE_ID
            FROM BL_AUDIT_REBUTTAL
            WHERE FK_BL_AUDIT_RESPONSE_ID=a.BL_AUDIT_RESPONSE_ID
            )
            BL_AUDIT_REBUTTAL_RES_ID
            FROM $BL_AUDIT_RESPONSE  a,
            $BL_AUDIT_RESPONSE_DETAIL b
            WHERE a.BL_AUDIT_RESPONSE_ID=b.FK_BL_AUDIT_RESPONSE_ID
            $con 
            )
            SELECT
            ELM1.ETO_LEAP_VENDOR_NAME,
            ELM2.ETO_LEAP_EMP_NAME || '-'|| ELM2.ETO_LEAP_VENDOR_NAME AUDITOR_NAME,
            RES_DATE,
            BL_AUDIT_RESPONSE_ID,
            FK_ETO_OFR_DISPLAY_ID,
            ELM1.ETO_LEAP_EMP_NAME ASSOC_NAME,
            ELM1.ETO_LEAP_EMP_ID,
            OPT,
            REMARKS,
            QUESTION_TYPE,
            BL_AUDIT_REBUTTAL_RES_ID,DELSOURCE 
            FROM
            AUDIT_TBL,
            (
            SELECT 'direct' DELSOURCE, ETO_OFR_DISPLAY_ID,ETO_OFR_DELETEDBYID ETO_OFR_APPROV_BY_ORIG FROM ETO_OFR_TEMP_DEL,AUDIT_TBL
            WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID
            UNION ALL
            SELECT  'direct' DELSOURCE , ETO_OFR_DISPLAY_ID,ETO_OFR_DELETEDBYID ETO_OFR_APPROV_BY_ORIG FROM ETO_OFR_TEMP_DEL_ARCH,AUDIT_TBL
            WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID
            UNION ALL
            SELECT 'fenq' DELSOURCE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,ETO_OFR_FENQ_EMP_ID ETO_OFR_APPROV_BY_ORIG FROM ETO_OFR_FROM_FENQ , AUDIT_TBL
            WHERE   FK_ETO_OFR_ID IS NULL and DIR_QUERY_FREE_REFID = FK_ETO_OFR_DISPLAY_ID
            UNION ALL
            SELECT 'fenq' DELSOURCE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,ETO_OFR_FENQ_EMP_ID ETO_OFR_APPROV_BY_ORIG FROM ETO_OFR_FROM_FENQ_ARCH , AUDIT_TBL
            WHERE   FK_ETO_OFR_ID IS NULL and DIR_QUERY_FREE_REFID = FK_ETO_OFR_DISPLAY_ID
            )
            OFR,
            ETO_LEAP_MIS_INTERIM  ELM1,
            ETO_LEAP_MIS_INTERIM  ELM2
            WHERE OFR.ETO_OFR_DISPLAY_ID =AUDIT_TBL.FK_ETO_OFR_DISPLAY_ID
            AND OFR.ETO_OFR_APPROV_BY_ORIG=ELM1.ETO_LEAP_EMP_ID
            AND ELM2.ETO_LEAP_EMP_ID=BL_AUDIT_RESPONSE_EMP_ID AND QUESTION_TYPE IS NOT NULL
            ORDER BY BL_AUDIT_RESPONSE_ID, QUESTION_TYPE";
        $model = new GlobalmodelForm();
        $sth   = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $quesDetailsSql, $bind); 
      $dataArr = array();
        while ($rec1 = $sth->read()) { 
            $rec = array_change_key_case($rec1, CASE_UPPER);
            array_push($dataArr, $rec); 
        }
        }
       return $dataArr;  
    }
    
    
    



  public function save_audit_details_Edit($auditid )
  {
    
      $serv_model               = new ServiceGlobalModelForm();
      $BL_AUDIT_RESPONSE_EMP_ID = Yii::app()->session['empid'];
      $BL_AUDIT_RESPONSE_EMP_NAME = Yii::app()->session['empname'];
      $errormessage             = '';
    
      $request                  = Yii::app()->request;
      $opt_ids                  = $request->getParam('opt_ids');
      $opt_ids_array            = json_decode($opt_ids, true);
     
      foreach ($opt_ids_array as $row) {
          $opt_val  = $row['opt_val'];
         
          
          $offerid  = $row['ofr_id'];
          $ques_val = $row['ques_val'];
        
          
          $REMARKS="Updated by $BL_AUDIT_RESPONSE_EMP_NAME ($BL_AUDIT_RESPONSE_EMP_ID) on ". date('d-M-Y H:i:s A') ." \n".$row['rem_val'];;

          $opt_val=implode(",",$opt_val);         
          $ques_val=implode(",",$ques_val); 
          $content  = array(
              'token' => 'imobile1@15061981',
              "QUESTION_ID" => $ques_val,
              "QUES_OPT_ID" => $opt_val,
              'modid' => 'GLADMIN',
              'REMARKS' => $REMARKS,
              'OFR_DISPLAY_ID' => $offerid,
              'EMP_ID' => $BL_AUDIT_RESPONSE_EMP_ID,
              'BL_AUDIT_RESPONSE_ID'=> $auditid,
              'action' => 'Update'
          );
          
          if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') {
              $url = 'http://stg-leads.imutils.com/wservce/glreport/blaudit/';
          } else {
              $url = 'http://leads.imutils.com/wservce/glreport/blaudit/';
          }
          $dataHash = $serv_model->mapiService('BLAUDIT', $url, $content, 'No');
         
          if ($dataHash['Response']['Code'] == 200) {
              $errormessage .= 'Offer id:' . $offerid . ' Audit Id:' . $dataHash['Response']['MainPrimeId'] . "<br>";
          } else {
              $errormessage .= 'Offer id:' . $offerid . " Error: Some Error occured" . "<br>";
          }
      }
      echo"$errormessage";
      return $errormessage;
  }
  
  public function print_pagination($bltype,$dbh,$bind,$model,$cond ,$cond2 ,$poolcond,$cond_sample_type){
      
      if($bltype=='direct'){
       $sql_page="SELECT count(ETO_OFR_DISPLAY_ID) cnt,substring (string_agg(ETO_OFR_DISPLAY_ID::text, ','),0,24) OFR_LIST,ETO_LEAP_EMP_ID , COUNT(1) OVER()TOTALCNT 
                FROM (SELECT ETO_LEAP_EMP_ID, ETO_OFR_DISPLAY_ID FROM ETO_OFR_TEMP_DEL, ETO_LEAP_MIS_INTERIM  WHERE ETO_OFR_DELETEDBYID = ETO_LEAP_EMP_ID $cond_sample_type                  
                $cond $cond2 $poolcond union all SELECT ETO_LEAP_EMP_ID, ETO_OFR_DISPLAY_ID FROM ETO_OFR_TEMP_DEL_ARCH, ETO_LEAP_MIS_INTERIM  "
               . "WHERE ETO_OFR_DELETEDBYID = ETO_LEAP_EMP_ID $cond_sample_type $cond $cond2 $poolcond ) A group by ETO_LEAP_EMP_ID "
               . "having count(ETO_OFR_DISPLAY_ID) >=1 order by count(ETO_OFR_DISPLAY_ID) desc";
           
      }else{
          $sql_page="SELECT count(ETO_OFR_DISPLAY_ID) cnt,substring (string_agg(ETO_OFR_DISPLAY_ID::text, ','),0,24) OFR_LIST,ETO_LEAP_EMP_ID, COUNT(1) OVER()TOTALCNT 
                FROM (
                    SELECT ETO_LEAP_EMP_ID,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID                
                     FROM ETO_OFR_FROM_FENQ, ETO_LEAP_MIS_INTERIM   WHERE 
                    ETO_OFR_FENQ_EMP_ID = ETO_LEAP_EMP_ID AND  FK_ETO_OFR_ID  IS NULL
                $cond $cond2 $poolcond  
                 union all SELECT ETO_LEAP_EMP_ID,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID 
                FROM ETO_OFR_FROM_FENQ_ARCH, ETO_LEAP_MIS_INTERIM   WHERE ETO_OFR_FENQ_EMP_ID = ETO_LEAP_EMP_ID AND  FK_ETO_OFR_ID  IS NULL $cond $cond2 $poolcond
                 ) A group by ETO_LEAP_EMP_ID having count(ETO_OFR_DISPLAY_ID) >=1 order by count(ETO_OFR_DISPLAY_ID) desc";             
      }
       $sth_page= $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_page, $bind);
            $page_html=$firstpg_ofrlist=$ofrids='';$pg=$currentpg=1;$sn=0;
            while ($rec1 = $sth_page->read()) {
                $sn++;
                $ofrids .=$rec1['ofr_list'].',';
                $totalcnt =$rec1['totalcnt'];
                if($sn % 10 == 0 || $totalcnt == $sn){
                    $ofrids=rtrim($ofrids,',');
                    if($pg==1){
                        $firstpg_ofrlist=$ofrids;
                      $page_html .='<input type="hidden" value="'.$ofrids.'" id="hdn'.$pg.'"> <a class="pagina" onclick="pagination('.$pg.')" href="#" style="text-decoration:none;">Page'.$pg.'</a>&nbsp;&nbsp;'; 
                   }else{
                      $page_html .='<input type="hidden" value="'.$ofrids.'" id="hdn'.$pg.'"> <a class="pagina" onclick="pagination('.$pg.')" href="#" style="text-decoration:none;">Page'.$pg.'</a>&nbsp;&nbsp;'; 
                   }
                    $ofrids='';$pg++;                  
                }
            }
            echo '<div id="pagination">'.$page_html.'</div>';
            return $firstpg_ofrlist;
  }
}