
<?php
class LeapDashboardModel extends CFormModel{
    
	public function getLeapVendor($request,$emp_id){
                $obj = new Globalconnection();
                $model = new GlobalmodelForm();
                $vendorName='';
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
                   $permision=0;$vendorArr=array();
		if($dbh){
			$sql = "SELECT ETO_LEAP_VENDOR_NAME FROM ETO_LEAP_MIS_INTERIM WHERE ETO_LEAP_EMP_ID = :EMP_ID AND ETO_LEAP_EMP_LEVEL <> 1";
			$bind[':EMP_ID']=$emp_id; 
			$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                        while($rec = $sth->read()) {
                                $returnArr=array_change_key_case($rec, CASE_UPPER);     
                                $vendorName = isset($returnArr['ETO_LEAP_VENDOR_NAME'])?$returnArr['ETO_LEAP_VENDOR_NAME'] :'';
                           }			
						   $recVendorAll=array('BANREVIEW','C2CTRAIN','C2CPRACTICE','COMPETENT','COMPETENTDNC','CONNECT_C2C','DDN','DNCTRAIN','IEINBOUND',	
                            'NOIDA','OAP_PD','VKALPAUTOIND','VKALPDNC','VKALPINTENT','VKALPREVIEW' );	
//$this->allvendernames();
			array_unshift($recVendorAll, "ALL");
			
			if(!empty($vendorName))
			{
				if($vendorName === 'NOIDA' || $vendorName === 'DDN')
				{
					$permision = 4;
					$vendorArr = $recVendorAll;
				}
				else
				{
					$permision = 1;
					$vendorArr = array($vendorName);
				}
			}
			$returnArr = array(
				"permision" => $permision,
				"vendorArr" => $vendorArr
			);	
				
			return $returnArr;		
		} else {
			echo "Connection Problem !!!";
			exit;		
		}
	}
        
        public function getLeapVendor_list($request,$emp_id){
                $obj = new Globalconnection();                
                $model = new GlobalmodelForm(); 
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
					// print_r($dbh);die('work');
                }
                $permision=0;$vendorArr=array();$vendor=array();$id=$name='';
		if($dbh){
			// die('work');
			$sql = "SELECT ETO_LEAP_VENDOR_NAME,FK_ETO_LEAP_VENDOR_ID FROM ETO_LEAP_MIS_INTERIM WHERE ETO_LEAP_EMP_ID = :EMP_ID AND ETO_LEAP_EMP_LEVEL <> 1";
			
			$bind[':EMP_ID']=$emp_id; 
			$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                        while($rec = $sth->read()) {
                                $returnArr=array_change_key_case($rec, CASE_UPPER);     
                                $id= isset($returnArr['FK_ETO_LEAP_VENDOR_ID'])?$returnArr['FK_ETO_LEAP_VENDOR_ID'] :'';
                                $name=isset($returnArr['ETO_LEAP_VENDOR_NAME'])?$returnArr['ETO_LEAP_VENDOR_NAME'] :'';
                                $vendor[$id] = $name;                       
                           }
						   $recVendorAll=array();
		        	
			$recVendorAll=CommonVariable::get_active_vendor_list();   				
	
                        $recVendorAll['0']="ALL";		
			
			if(!empty($vendor))
			{
				if($name=== 'NOIDA' || $name === 'DDN')
				{
					$permision = 4;
					$vendorArr = $recVendorAll;
				}
				else
				{
					$permision = 1;
					$vendorArr = $vendor;
				}
			}
                                 
			$returnArr = array(
				"permision" => $permision,
				"vendorArr" => $vendorArr
			);                      
			return $returnArr;		
		} else {
			echo "Connection Problem !!!";
			exit;		
		}
	}
        
	public function showForm($request,$vendorRe) {
		$vendorArr = $vendorRe['vendorArr'];
		$currentDate = date("d-m-Y");
		$permision = $vendorRe['permision'];
		$vendor1= $request->getParam('vendor1','');
		$start_date= $request->getParam('start_date','');
		$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));
		
		$end_date= $request->getParam('end_date','');
		$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
		$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
		$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
		$hours= range(0,24);
		$vendorLength = $vendor1;
		if($vendorLength == 0)
		{
			$vendor1 = $vendorArr;
		}
		$tljson = $this->getTLList($permision,$vendorArr);
		$flaggedHash = $this->FlaggedPendingData($permision,$vendorArr);
		$reShowFormarr = array(
			'tljson' => $tljson,
			'start_date' => $start_date,		
			'end_date' => $end_date,
			'vendor1' => $vendor1,	
			'hours' => $hours,
			'flaggedHash' => $flaggedHash
		);
		
		return $reShowFormarr;
	}
	
	public function getTLList($permision,$vendorArray) {
		$sql = "
		SELECT ETO_LEAP_VENDOR_NAME,ETO_LEAP_EMP_ID,ETO_LEAP_AGENT_NAME 
		FROM ETO_LEAP_MIS_INTERIM
		WHERE ETO_LEAP_EMP_LEVEL  = 2
		";
		$keyArray = array('ETO_LEAP_VENDOR_NAME','ETO_LEAP_EMP_ID');
		$tlHash = array();
		$obj = new Globalconnection();
                $model = new GlobalmodelForm();
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
                $bind=array();
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql; 
                while($rec1=$sth->read()){
                    $rec=array_change_key_case($rec1, CASE_UPPER);  
                    $vendorName = $rec['ETO_LEAP_VENDOR_NAME'];
                    $tlID =  $rec['ETO_LEAP_EMP_ID'];
                    $tlHash[$vendorName][$tlID] = $rec['ETO_LEAP_AGENT_NAME'];		
		}		
		$json = json_encode($tlHash);
		return $json;

	}
	
	public function FlaggedPendingData($permision,$vendorArray) {
			$obj = new Globalconnection();
                        $dbh=$obj->connect_db_oci('postgress_web68v');
			$vendorArr=$vendorArray;
			$vendorArr = array_diff($vendorArray, array("ALL"));;
			$sql = "SELECT A.*,
                                       (SELECT ETO_LEAP_AGENT_NAME FROM ETO_LEAP_MIS_INTERIM WHERE ETO_LEAP_EMP_ID=TL_ID) ETO_LEAP_TL_NAME, 
    						MAX(RN) OVER(PARTITION BY ETO_LEAP_VENDOR_NAME ORDER BY ETO_LEAP_VENDOR_NAME) VENDOR_MAX_REC,
    						MAX(RN) OVER (ORDER BY 1) NOIDA_MAX_REC
   						FROM
								(
        							SELECT         
            					ETO_LEAP_TL_ID TL_ID, ETO_LEAP_VENDOR_NAME, COUNT(ETO_OFR_DISPLAY_ID) CNT,
            					ROW_NUMBER()OVER(PARTITION BY ETO_LEAP_VENDOR_NAME ORDER BY ETO_LEAP_VENDOR_NAME) RN
    								FROM DIR_QUERY_FREE,ETO_LEAP_MIS_INTERIM WHERE 
    								FK_EMPLOYEEID=ETO_LEAP_EMP_ID
    							--AND ETO_OFR_IS_FLAGGED=4        
                                    GROUP BY ETO_LEAP_TL_ID,ETO_LEAP_VENDOR_NAME 
                                    )A ";
			
			$sth=pg_query($dbh,$sql);
			$flaggedHash = array();
			$i = 1; $noidaMaxRec = '';
			while($rec = pg_fetch_array($sth))	{
                                        $rec=array_change_key_case($rec, CASE_UPPER);
			               $flaggedHash[$rec['ETO_LEAP_VENDOR_NAME']]=$rec['ETO_LEAP_VENDOR_NAME'];
					$tempName = $rec['ETO_LEAP_VENDOR_NAME']."TLNAME".$rec['RN'];
					$tempCnt = $rec['ETO_LEAP_VENDOR_NAME']."TLCNT".$rec['RN'];
					$flaggedHash[$tempName] = !empty($rec['ETO_LEAP_TL_NAME'])?$rec['ETO_LEAP_TL_NAME']:'NA';
					$flaggedHash[$tempCnt] = $rec['CNT'];
					$tempMaxRec = $rec['ETO_LEAP_VENDOR_NAME']."MAXREC";
					$flaggedHash[$tempMaxRec] = $rec['VENDOR_MAX_REC'];
					$flaggedHash["NOIDA_MAX_REC"] = $rec['NOIDA_MAX_REC'];
			}			
			$returnArr = '';
			if($permision == 4)
			{
				//$vendorArr = array('VKALP','KOCHARTECH','COGENT','KOCHARTECHLDH');
			}
			$vendorWiseTotalFlagged = 0;
					if(!empty($permision)) {
						$returnArr .= '<div id="" style="overflow-y:scroll; overflow-x:scroll; height:250px;"><table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">';
				       	foreach($vendorArr as $row)
					   {	
						  if (array_key_exists($row,$flaggedHash))				
						  {	$tempVendor = $row;
							$maxRec =1;
							if($permision == 4) {
								$maxRec = $flaggedHash["NOIDA_MAX_REC"];
							} else {
								$maxRec = $flaggedHash[$tempVendor."MAXREC"];
							}
							
						$returnArr .= '<tr>
						<td rowspan="2"><b>'.$row.'</b></td>';
						 
						$maxRange = range(1,$maxRec);
						foreach($maxRange as $row1)
						{ 
								$tl_name = isset($flaggedHash[$tempVendor."TLNAME".$row1])?$flaggedHash[$tempVendor."TLNAME".$row1]:''; 
								$returnArr .= "<td>$tl_name</td>";
						}
						$returnArr .= "</tr><tr>";
						foreach($maxRange as $row2)
						{
								$tl_cnt = isset($flaggedHash[$tempVendor."TLCNT".$row2])?$flaggedHash[$tempVendor."TLCNT".$row2]:'';
								$returnArr .= "<td>$tl_cnt</td>";
						}
						$returnArr .= "</tr>";
						$vendorWiseTotalFlagged = 0;
					  }
				}
				$returnArr .= "</table></div>";
			} $returnArr .= "";
			return $returnArr;
	}
        
	public function displayTotal($request,$vendorRe,$empId) {
		$flagError=0;
		$errArr= array();
		$hash=array();
		$hashTtl = array();
		$vendorArr = $vendorRe['vendorArr']; 
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$vendor1=$request->getParam('vendor1',0);
		$vendorSelVal = $request->getParam('vendorVal','ALL');
		$start_time=$request->getParam('start_time',0);
		$end_time=$request->getParam('end_time',24);
		$source = $request->getParam('source','A');
		$tlid = $request->getParam('tlselect',0);
		$vendor = ''; 
	
		$s1 = strtotime($start_date);
                $e1 = strtotime($end_date);
		$t1 = strtotime(date("d-M-Y"));
                $obj = new Globalconnection();
		
		if($vendorSelVal != ''){
			$vendorSelVal = explode(',', $vendorSelVal);
			$vendorLength = count($vendorSelVal);
		} else {
			$vendorLength = strlen($vendorSelVal);
		}
		if($vendorLength == 0)
		{
			$vendor1 = $vendorArr;
		}else{
			$vendor1 = 	$vendorSelVal;	
		}
		if($vendor1 == 'ALL' && preg_grep("ALL",$vendor1))
		{
			$vendorLength = 1;
		}
		$isAll =0;
			foreach($vendor1 as $row) {
			
			if($row == 'ALL')
			{
				$isAll =1;
			}
		}
		
		if ($flagError==1)
		{
			$mesg = '';
			$mesg ='<TABLE BORDER="0" WIDTH="100%"><TR>
				<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#a30000" size="2"><B>Following Error(s) Occured:<BR>';
			$errorCounter=0;
			foreach ($errArr as $err)
			{
				$errorCounter++;
				$mesg .=" Error $errorCounter: $err";
			}
			$mesg .= "</FONT></TD>
				</TR></TABLE>";
			$this->showForm($request,$vendorRe);
		}
		else {	
			$getSqlCondHash = $this->getSqlCondHash($request,$vendorArr);
			$keys= array('CR_DATE','ETO_LEAP_VENDOR_NAME','FK_GL_MODULE_ID');
			$hashTotalAssigned = array();
			$hashTotalApproved = array();
			$hashTotalAHT = array();
			$hashTotalTimeliness = array();
			$hashTotalActiveAgents = array();
			$hash = array();
 			$returnCurArr = $this->getTotalAssigned($getSqlCondHash,$request);
 			$sthCurCount = $returnCurArr['cursorCnt'];
 			$sthAppCount = $returnCurArr['appCnt'];
 			$sthTimlinessCount = $returnCurArr['timlinessCnt'];
 			$sthAhtCount = $returnCurArr['ahtCnt'];                       
 			
                        $CurCount=json_decode($sthCurCount,true);
                        $AppCount=json_decode($sthAppCount,true);
                        $TimlinessCount = json_decode($sthTimlinessCount,true);
 			$AhtCount = json_decode($sthAhtCount,true); 
			//print_r($CurCount);
			//echo"ggg";
			//exit;

			if(!empty($CurCount)){
 			foreach($CurCount as $rec){
                                $rec_ttl=array_change_key_case($rec, CASE_UPPER);
				$crDate = date("d-M-Y",strtotime($rec_ttl['CR_DATE']));
				$vendorName = $rec_ttl['ETO_LEAP_VENDOR_NAME'];
				$hash[$crDate][$vendorName]["TTL_DELETED"]=$rec_ttl['TTL_DELETED'];
                                $hash[$crDate][$vendorName]["TTL_NT_FLAGGED"]=$rec_ttl['TTL_NT_FLAGGED'];
                                $hash[$crDate][$vendorName]["TTL_AUTO_FLAGGED"]=$rec_ttl['TTL_AUTO_FLAGGED'];
			}
		}    
		if(!empty($AppCount)){
 			foreach($AppCount as $row){ 		
                                $rec=array_change_key_case($row, CASE_UPPER);
				$crDate = date("d-M-Y",strtotime($rec['ETO_OFR_APPROV_DATE_ORIG']));
                                
				$vendorName = $rec['ETO_LEAP_VENDOR_NAME'];
				$hash[$crDate][$vendorName]["APPROVED_24_MORE"]=$rec['APPROVED_24_MORE'];
				$hash[$crDate][$vendorName]["APPROVED_12_MORE"]=$rec['APPROVED_12_MORE'];
				$hash[$crDate][$vendorName]["TTL_APPROVAL"]=$rec['TTL_APPROVAL'];
				$hash[$crDate][$vendorName]["TTL_CALL_APPROVED"]=$rec['TTL_CALL_APPROVED'];
				$hash[$crDate][$vendorName]["TTL_DO_NOT_CALL"]=$rec['TTL_DO_NOT_CALL'];
                                if(isset($rec['TTL_PPP'])){
                                    $hash[$crDate][$vendorName]["TTL_PPP"] =$rec["TTL_PPP"];
                                }else{
                                    $hash[$crDate][$vendorName]["TTL_PPP"] =0;
                                }
                                if(isset($rec['TTL_INTENT'])){
                                    $hash[$crDate][$vendorName]["TTL_INTENT"]=$rec['TTL_INTENT'];
                                }else{
                                    $hash[$crDate][$vendorName]["TTL_INTENT"]=0;
                                }			
                                
                                if(isset($rec['TTL_DNC_FOREIGN'])){
                                    $hash[$crDate][$vendorName]["TTL_DNC_FOREIGN"]=$rec['TTL_DNC_FOREIGN'];
                                }else{
                                     $hash[$crDate][$vendorName]["TTL_DNC_FOREIGN"]=0;
                                }
                                if(isset($rec['TTL_LEAP'])){
                                    $hash[$crDate][$vendorName]["TTL_LEAP"]=$rec['TTL_LEAP'];
                                }else{
                                     $hash[$crDate][$vendorName]["TTL_LEAP"]=0;
                                }
				
			}
		}
		if(!empty($AhtCount)){
 			foreach($AhtCount as $row)
			{
                                $rec=array_change_key_case($row, CASE_UPPER);
				if($rec['ETO_OFR_APPROV_DATE_ORIG'] == NULL){
					continue;				
				}
				$crDate = date("d-M-Y",strtotime($rec['ETO_OFR_APPROV_DATE_ORIG']));
				$vendorName = $rec['ETO_LEAP_VENDOR_NAME'];
				$tempAHT = !empty($rec['AHT'])? $rec['AHT']:'0.0';                                
				$hash[$crDate][$vendorName]["TEMP_AHT"] =  sprintf( "%.2f",$tempAHT);                               
				$hash[$crDate][$vendorName]["AHT"] = $this->findAHT($hash[$crDate][$vendorName]["TEMP_AHT"] );                               
			}
		}
		if(!empty($TimlinessCount)){
 			foreach($TimlinessCount as $row)
			{	
                                $rec=array_change_key_case($row, CASE_UPPER);
				if(empty($rec['ETO_OFR_POSTDATE_ORIG']) || $rec['ETO_OFR_POSTDATE_ORIG'] == NULL){
					continue;				
				}
				$crDate = date("d-M-Y",strtotime($rec['ETO_OFR_POSTDATE_ORIG']));
				$vendorName = $rec['ETO_LEAP_VENDOR_NAME'];
                                $timliness = $this->findPercnt($rec['TOTAL_WORKED'],$rec['TOTAL_GEN']);
				$hash[$crDate][$vendorName]["TIMLINESS"] =$timliness;			
			}
		}
                      $colwidth = "70px";$returnHash = '';
			$returnHash .= "<BR>";
			$returnHash .= '<div id="div1" style="width:1300px; margin:0px auto;">';
        	$returnHash .= '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1300px">
        							<tr>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="110px" ><b>Date</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Vendor</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Approved</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Deleted</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Call</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>DNC</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Foreign</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Intent</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Leap MODID</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>NT Manual</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>NT Auto</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Approval %</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Timliness</b></td>        							
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>AHT</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>PPP</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Approved 12+</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="110px"><b>Approved 24+</b></td>
        							</tr>';
       			
			$vendorArr1 = $this->allvendernames();;
	 	//$vendorArr1 = array('VKALP','ILEAD','KOCHARTECH','KOCHARTECHCHN','KOCHARTECHLDH','DDN','NOIDA','COGENT','OTHER');
        	foreach ($hash as $crDate => $crRow){
        		if(!isset($hash[$crDate]["ALL"]))
				{
					foreach($vendorArr1 as $row)
					{
						if(!isset($hash[$crDate][$row])){
							unset($hash[$crDate][$row]);					
						}
					}
				}
			}
		
			foreach($hash as $crDatek=>$crDateR)
			{
                            $rowspan=count($hash[$crDatek]) - 1;
                            if($rowspan == 0){
                               $rowspan=1; 
                            }

				foreach($hash[$crDatek] as $crVendork=>$crVendorR)
				{	
                                       
					if(!(in_array($crVendork, $vendor1)))
					{
						continue;
					}
					$totalWorked = $crVendorR['TTL_DELETED'] + $crVendorR['TTL_APPROVAL'];				
					$approvedPer = $hash[$crDatek][$crVendork]['APPROVED_PR'] = $this->findPercnt($crVendorR["TTL_APPROVAL"],$totalWorked);
                                        if($crVendork=='CONNECT_C2C'){
                                            $totalWorked = $crVendorR['TTL_DELETED'] + $crVendorR['TTL_APPROVAL'] + $crVendorR['TTL_NT_FLAGGED'] + $crVendorR['TTL_AUTO_FLAGGED'];
                                            $approvedPer=$hash[$crDatek][$crVendork]['APPROVED_PR'] = $this->findPercnt($crVendorR["TTL_APPROVAL"],$totalWorked);
                                        }else{
											$totalWorked = $crVendorR['TTL_DELETED'] + $crVendorR['TTL_APPROVAL'];
                                            $approvedPer = $hash[$crDatek][$crVendork]['APPROVED_PR'] = $this->findPercnt($crVendorR["TTL_APPROVAL"],$totalWorked);
                                        }
		            $crVendorR['TIMLINESS']=isset($crVendorR['TIMLINESS'])?$crVendorR['TIMLINESS']:'';
					$crVendorR['AHT']=isset($crVendorR['AHT'])?$crVendorR['AHT']:'';
		            $crVendorR['TTL_PPP']=isset($crVendorR['TTL_PPP'])?$crVendorR['TTL_PPP']:'';
		            $crVendorR['APPROVED_12_MORE']=isset($crVendorR['APPROVED_12_MORE'])?$crVendorR['APPROVED_12_MORE']:'';
		            $crVendorR['APPROVED_24_MORE']=isset($crVendorR['APPROVED_24_MORE'])?$crVendorR['APPROVED_24_MORE']:'';
					$vendor = $crVendork; 
                                $returnHash .= '<tr>
				<td class="intd" style="text-align:center;"  width="100px" >'.$crDatek.'</td>
				';

					$returnHash .= "<td class='intd' style='text-align:center;'  width='100px'>$crVendork
					<a href='javascript:void(0)' onclick=\"empWiseDetail('D','divid1','$crDatek','$crDatek','$vendor','$source','$start_time','$end_time','$tlid','','');\"
						style='text-decoration:none;color:#0000ff' ><b>+</b></a></td>	
					
					<td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=empwisead&start_date=$crDatek&end_date=$crDatek&vendor=$vendor&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&tlid=$tlid&total_records=".$crVendorR['TTL_APPROVAL']."'>".$crVendorR['TTL_APPROVAL']."</a>
					</td>
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=empwisedd&total_records=".$crVendorR['TTL_DELETED']."&start_date=$crDatek&end_date=$crDatek&vendor=$vendor&in_flag=2&source=$source&start_time=$start_time&end_time=$end_time&tlid=$tlid'>".$crVendorR['TTL_DELETED']."</a>
					</td>";
                                        $returnHash .= "
										
					<td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['TTL_CALL_APPROVED']."</td>
					<td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['TTL_DO_NOT_CALL']."</td>
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['TTL_DNC_FOREIGN']."</td>
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['TTL_INTENT']."</td>    
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['TTL_LEAP']."</td>                                        
                                        
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/ntdashboard&mid=3443&start_date=$crDatek&end_date=$crDatek&vendor=$vendor&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&tlid=$tlid&total_records=".$crVendorR['TTL_NT_FLAGGED']."'>".$crVendorR['TTL_NT_FLAGGED']."</a>
					 </td>
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/autodashboard&mid=3443&start_date=$crDatek&end_date=$crDatek&vendor=$vendor&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&tlid=$tlid&total_records=".$crVendorR['TTL_AUTO_FLAGGED']."'>".$crVendorR['TTL_AUTO_FLAGGED']."</a>
					 </td>
					<td class='intd' style='text-align:center;'  width='$colwidth'>".$approvedPer."</td>		
					<td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['TIMLINESS']."</td>					
					<td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['AHT']."</td>
					<td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['TTL_PPP']."</td>					
					<td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['APPROVED_12_MORE']."</td>
					<td class='intd' style='text-align:center;'  width='$colwidth'>".$crVendorR['APPROVED_24_MORE']."</td>
					</tr>";
				}
			}
	
	if($vendorLength == 1)
	{
		
		$hashTtl["TTL_APPROVAL"] =0;
		$hashTtl["APPROVED_12_MORE"] =0;
		$hashTtl["APPROVED_24_MORE"] =0;
		$hashTtl["TTL_DELETED"] =0;
		$hashTtl["TTL_CALL_APPROVED"] =0;
		$hashTtl["TTL_DO_NOT_CALL"] =0;
                $hashTtl["TTL_DNC_FOREIGN"] =0;
                $hashTtl["TTL_LEAP"] =0;
		$hashTtl["TTL_NT_FLAGGED"] =0;
                $hashTtl["TTL_AUTO_FLAGGED"] =0;
		$hashTtl["APPROVED_PR"] =0;
		$hashTtl["AHT"] =0;
		$hashTtl["TIMLINESS"] =0;
		
		$hashTtl["TTL_PPP"] = 0;		
                $hashTtl["TTL_INTENT"] =0;
		
		$rowcount = 0;		
		foreach($hash as $crDatekey => $crDate)
		{
			foreach($hash[$crDatekey] as $crVendorKey => $crVendor)
			{
				if(!(in_array($crVendorKey,$vendor1)))
				{
					continue;
				}
			
				$hashTtl["TTL_APPROVAL"] = $hashTtl["TTL_APPROVAL"]+$crVendor["TTL_APPROVAL"];
				$hashTtl["APPROVED_12_MORE"] = $hashTtl["APPROVED_12_MORE"]+$crVendor["APPROVED_12_MORE"];
				$hashTtl["APPROVED_24_MORE"] = $hashTtl["APPROVED_24_MORE"]+$crVendor["APPROVED_24_MORE"];
				$hashTtl["TTL_DELETED"] = $hashTtl["TTL_DELETED"]+$crVendor["TTL_DELETED"];
				$hashTtl["TTL_CALL_APPROVED"] = $hashTtl["TTL_CALL_APPROVED"]+$crVendor["TTL_CALL_APPROVED"];
				$hashTtl["TTL_DO_NOT_CALL"] = $hashTtl["TTL_DO_NOT_CALL"]+$crVendor["TTL_DO_NOT_CALL"];
                                $hashTtl["TTL_DNC_FOREIGN"] = $hashTtl["TTL_DNC_FOREIGN"]+$crVendor["TTL_DNC_FOREIGN"];
                                $hashTtl["TTL_LEAP"] = $hashTtl["TTL_LEAP"]+$crVendor["TTL_LEAP"];
                                $hashTtl["TTL_INTENT"] = $hashTtl["TTL_INTENT"]+$crVendor["TTL_INTENT"];
                                $hashTtl["APPROVED_PR"] = $hashTtl["APPROVED_PR"]+$crVendor["APPROVED_PR"];
                                
				$hashTtl["TTL_NT_FLAGGED"] = $hashTtl["TTL_NT_FLAGGED"]+$crVendor["TTL_NT_FLAGGED"];
				$hashTtl["TTL_AUTO_FLAGGED"] = $hashTtl["TTL_AUTO_FLAGGED"]+$crVendor["TTL_AUTO_FLAGGED"];
			
				$hashTtl["TIMLINESS"] = $hashTtl["TIMLINESS"]+$crVendor["TIMLINESS"];
				$hashTtl["AHT"] = $hashTtl["AHT"]+$crVendor["TEMP_AHT"];
				
				$hashTtl["TTL_PPP"] = $hashTtl["TTL_PPP"]+$crVendor["TTL_PPP"];
				$rowcount++;
			}
		}
		//exit;
		if($rowcount!=0){
			$hashTtl["APPROVED_PR"] = sprintf("%.2f", ($hashTtl["APPROVED_PR"]/$rowcount));
			$hashTtl["TIMLINESS"]  = sprintf( "%.2f", ($hashTtl["TIMLINESS"] /$rowcount));
			$hashTtl["AHT"]  = sprintf( "%.2f", ($hashTtl["AHT"] /$rowcount));
		}
		else{
			$hashTtl["APPROVED_PR"]=0;
			$hashTtl["TIMLINESS"]=0;
			$hashTtl["AHT"]=0;
		}
			$hashTtl["AHT"] = $this->findAHT($hashTtl["AHT"]);
			if($rowcount!=0){
			$hashTtl["TTL_PPP"] = sprintf( "%.2f", ($hashTtl["TTL_PPP"] /$rowcount));	
			}
			$hashTtl["TTL_PPP"]=0;
		
			$returnHash .= "<tr>
					<td  style='text-align:left;' bgcolor='#dff8ff' width='100px' colspan='2'>
					<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total"; 
					$returnHash .= "</td>
					
					<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>
					".$hashTtl['TTL_APPROVAL']."</td>
					<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>
					".$hashTtl['TTL_DELETED'] ."</td>
					<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['TTL_CALL_APPROVED']."</td>
					<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['TTL_DO_NOT_CALL']."</td>
                                        <td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['TTL_DNC_FOREIGN']."</td> 
                                        <td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['TTL_INTENT']."</td> 
                                        <td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['TTL_LEAP']."</td>    
                                       <td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['TTL_NT_FLAGGED']."</td>
                                        <td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['TTL_AUTO_FLAGGED']."</td>";
					
					
					$returnHash .= "<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['APPROVED_PR']."
					<input type='hidden' value='".$hashTtl['APPROVED_PR']."' class='$start_date-$end_date' name='ttlApprovalPR'></td>
					<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['TIMLINESS']."</td>					
					<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['AHT']."</td>
					<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['TTL_PPP']."</td>					
					<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['APPROVED_12_MORE']."</td>
					<td  style='text-align:center;' bgcolor='#dff8ff' width='$colwidth'>".$hashTtl['APPROVED_24_MORE']."</td>
			</tr>"
			;
				}
				$returnHash .= "</table>";
				$returnHash .= '</div><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>';
				return $returnHash;
			}			
 		}
	
	public function getSqlCondHashMis($request,$vendorArr) {
		$sqlCondHashMis =array();
		$modid = $request->getParam('modid', '');
		$source = $request->getParam('source','A');
		$vendor= $request->getParam('vendorname') ;
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$start_time=$request->getParam('start_time',0);
		$end_time=$request->getParam('end_time',24);
		$tlid = $request->getParam('tlselect','');

		$sqlCondHashMis['START_DATE'] = $start_date;
		$sqlCondHashMis['END_DATE'] = $end_date;
		$sqlCondHashMis['START_TIME'] = $start_time;
		$sqlCondHashMis['END_TIME'] = $end_time;

		$sqlCondHashMis['REPORT_PERIOD']= $request->getParam('reportperiod','DAILY');
		$sqlCondHashMis['REPORT_WISE'] =  $request->getParam('reportwise','VENDORWISE');
		$sqlCondHashMis['KPI'] = $request->getParam('kpi','APPROVED');
	
		if($source == 'I')
		{
			$sqlCondHashMis['FENQ_COUNTRY'] = " AND S_COUNTRY_UPPER IN ('IN','INDIA') ";
			$sqlCondHashMis['GEN_COUNTRY']  = " AND FK_GL_COUNTRY_ISO = 'IN' ";
			$sqlCondHashMis['GEN_COUNTRY_ETO_OFR']  = " AND ETO_OFR.FK_GL_COUNTRY_ISO = 'IN' ";
			$sqlCondHashMis['GEN_COUNTRY_ETO_OFR_EXPIRED']  = " AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO = 'IN' ";
			$sqlCondHashMis['MCATNA_COUNTRY']  ="WHERE FK_GL_COUNTRY_ISO = 'IN'";
		}
		elseif($source == 'F')
		{
			$sqlCondHashMis['FENQ_COUNTRY'] = " AND S_COUNTRY_UPPER NOT IN ('IN','INDIA') ";
			$sqlCondHashMis['GEN_COUNTRY']  = " AND FK_GL_COUNTRY_ISO <> 'IN'";
			$sqlCondHashMis['GEN_COUNTRY_ETO_OFR']  = " AND ETO_OFR.FK_GL_COUNTRY_ISO <> 'IN'";
			$sqlCondHashMis['GEN_COUNTRY_ETO_OFR_EXPIRED']  = " AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO <> 'IN'";
			$sqlCondHashMis['MCATNA_COUNTRY'] = "WHERE FK_GL_COUNTRY_ISO <> 'IN'";
		}
		elseif($source == 'A')
		{
			$sqlCondHashMis['FENQ_COUNTRY'] = '';
			$sqlCondHashMis['GEN_COUNTRY']  = '';
			$sqlCondHashMis['GEN_COUNTRY_ETO_OFR']  = '';
			$sqlCondHashMis['GEN_COUNTRY_ETO_OFR_EXPIRED'] = '';
			$sqlCondHashMis['MCATNA_COUNTRY'] = '';
		}
	
		$vendorStr = '';
		$vendorArray = $vendorArr;
		foreach($vendorArray as $row1)
		{
			$vendorStr.= "'$row1',";
		}
		$vendorStr = trim($vendorStr);
		if($vendor == 'ALL' && preg_grep("ALL",$vendorArray))
		{
			$sqlCondHashMis['VENDOR_COND'] = "AND NVL(ETO_LEAP_VENDOR_NAME,'OTHER') IN (".$vendorStr.")";
		}
		else
		{
			$sqlCondHashMis['VENDOR_COND'] = "AND NVL(ETO_LEAP_VENDOR_NAME,'OTHER') = '$vendor'";
		}
		return $sqlCondHashMis;
	}
	
	public function getSqlCondHash($request,$vendorArr){
		$sqlCondHash = array();
		$modid = $request->getParam('modid','');
		$source = $request->getParam('source','A');
		$vendor= $request->getParam('vendor','');
		$vendor1 = $request->getParam('vendor1');
		$vendorSelVal = $request->getParam('vendorVal','ALL');
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$start_time=$request->getParam('start_time',0);
		$end_time=$request->getParam('end_time',24);
		$tlid = $request->getParam('tlselect','');
		
		if($vendorSelVal != ''){
			$vendorSelVal = explode(',', $vendorSelVal);
			$vendorLength = count($vendorSelVal);
		}else{
			$vendorLength = strlen($vendorSelVal);
		}$vArr = array();
		if($vendorLength == 0) {
			$vendor1 = $vendorArr;
		} else{
			$vendor1 = $vendorSelVal;
		}
		if(!empty($tlid)) {
			$sqlCondHash['TL_CONDITION'] =" AND ETO_LEAP_TL_ID = $tlid";
		} else {
			$sqlCondHash['TL_CONDITION'] = '';
		}
		$sqlCondHash['START_DATE'] = date("d-M-Y",strtotime($start_date));
		$sqlCondHash['END_DATE'] = date("d-M-Y",strtotime($end_date));
		$sqlCondHash['START_TIME'] = $start_time;
		$sqlCondHash['END_TIME'] = $end_time;

		if($source == 'I') {
			$sqlCondHash['FENQ_COUNTRY'] = " AND S_COUNTRY_UPPER IN ('IN','INDIA') ";
			$sqlCondHash['GEN_COUNTRY']  = " AND FK_GL_COUNTRY_ISO = 'IN' ";
			$sqlCondHash['GEN_COUNTRY_ETO_OFR']  = " AND ETO_OFR.FK_GL_COUNTRY_ISO = 'IN' ";
			$sqlCondHash['GEN_COUNTRY_ETO_OFR_EXPIRED']  = " AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO = 'IN' ";
			$sqlCondHash['MCATNA_COUNTRY']  ="WHERE FK_GL_COUNTRY_ISO = 'IN'";
		}
		elseif($source == 'F') {
			$sqlCondHash['FENQ_COUNTRY'] = " AND S_COUNTRY_UPPER NOT IN ('IN','INDIA') ";
			$sqlCondHash['GEN_COUNTRY']  = " AND FK_GL_COUNTRY_ISO <> 'IN'";
			$sqlCondHash['GEN_COUNTRY_ETO_OFR']  = " AND ETO_OFR.FK_GL_COUNTRY_ISO <> 'IN'";
			$sqlCondHash['GEN_COUNTRY_ETO_OFR_EXPIRED']  = " AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO <> 'IN'";
			$sqlCondHash['MCATNA_COUNTRY'] = "WHERE FK_GL_COUNTRY_ISO <> 'IN'";
		}
		elseif($source == 'A') {
			$sqlCondHash['FENQ_COUNTRY'] = '';
			$sqlCondHash['GEN_COUNTRY']  = '';
			$sqlCondHash['GEN_COUNTRY_ETO_OFR']  = '';
			$sqlCondHash['GEN_COUNTRY_ETO_OFR_EXPIRED'] = '';
			$sqlCondHash['MCATNA_COUNTRY'] = '';
		}

		if($vendor == 'ALL') {
			$sqlCondHash['VENDOR_NAME'] ='';
		} else if(!empty($vendor)) {
			$sqlCondHash['VENDOR_NAME']=" and NVL(ETO_LEAP_VENDOR_NAME,'OTHER')='$vendor'";
		}
		$vendorStr = $vendorIDSStr='';
		$isAll =0;
		$vendorStr .= "'";
                $vendorIDSStr .="'";
                $recVendorAll=CommonVariable::get_active_vendor_list();  
		foreach($vendor1 as $row) {
			if($row != 'ALL') {
				$vendorStr .= "$row,";
                                if($row<>'ALL'){
                                    foreach($recVendorAll as $key => $value)
                                    {
                                        if($row == $value)
                                        {
                                            $vendorIDSStr .= "$key,";
                                        }
                                    }       
                                }
			}
			if($row == 'ALL')
			{
				$isAll =1;
			}
		}
		
		$vendorStr = trim($vendorStr,',');
		$vendorStr = trim($vendorStr);
		$vendorStr .= "'";
                
                $vendorIDSStr = trim($vendorIDSStr,',');
		$vendorIDSStr = trim($vendorIDSStr);
		$vendorIDSStr .= "'";
                
                        
		if(!empty($isAll)) {
			$sqlCondHash['VENDOR_NAME_ARR']='';
			$sqlCondHash['VENDOR_NAME_ARR_PARAM'] = 'ALL';
                        $sqlCondHash['IN_VENDOR_IDS'] = '';
		} else {
                        $vendorStr_q=str_replace(",", "','", $vendorStr);
                        $sqlCondHash['VENDOR_NAME_ARR']=" and ETO_LEAP_VENDOR_NAME IN (".$vendorStr_q.")";			
			$sqlCondHash['VENDOR_NAME_ARR_PARAM']= $vendorStr;
                        $sqlCondHash['IN_VENDOR_IDS']=$vendorIDSStr;
		}
		if($modid == 'FENQ' || $modid == 'GEN' ) {
			$sqlCondHash['SELECT_MODID']="DECODE(FK_GL_MODULE_ID,'FENQ','FENQ','GEN') FK_GL_MODULE_ID,";
			$sqlCondHash['GROUPBY_MODID']=", DECODE(FK_GL_MODULE_ID,'FENQ','FENQ','GEN')";
		} else {
			$sqlCondHash['SELECT_MODID']="DECODE(FK_GL_MODULE_ID,'FENQ','ALL','ALL') FK_GL_MODULE_ID,";
			$sqlCondHash['GROUPBY_MODID']=", DECODE(FK_GL_MODULE_ID,'FENQ','ALL','ALL')";
		}
		if(!empty($isAll)) {
			$sqlCondHash['SELECT_VENDOR_NAME']= "'ALL' ETO_LEAP_VENDOR_NAME,";
			$sqlCondHash['GROUPBY_VENDOR_NAME']= '';
		}  else {
			$sqlCondHash['SELECT_VENDOR_NAME']="ETO_LEAP_VENDOR_NAME,";
			$sqlCondHash['GROUPBY_VENDOR_NAME']=",ETO_LEAP_VENDOR_NAME";
		}		
		return $sqlCondHash;
	}
	
	
        public function getTotalAssigned($sqlCondHash,$request) {
			$empid=Yii::app()->session['empid'];
            $cursorCnt =array();
	    $appCnt =array();
            $ahtCnt=array();
            $timlinessCnt=array();
            $minLockDateCur=array();
            $maxApproveDateCur=array();
            $empwise=array();
            $empwiseapp=array();
            $objcon = new Globalconnection();
			$dbh=$objcon->connect_db_oci('postgress_web68v');	
		    $source = $request->getParam('source','A');
	    $empFlag = $request->getParam('emp_flag',0);
	    $in_flag = $request->getParam('in_flag',0);
	    $cntryArr = array('I' => 2,'F' => 3,'A' => 0);
	    $cntryFlag = isset($cntryArr[$source])?$cntryArr[$source]:0;
	    $tlid = $request->getParam('tlselect',0);
	    $tlidEmpWise = $request->getParam('tlid',0);
	    
	    $tlid = (!empty($tlidEmpWise) ? $tlidEmpWise : (!empty($tlid) ? $tlid : 0));
	    $startLimit = 1;
	    $endLimit = 5000;
	    if(isset($sqlCondHash['EMP_ID']) && !empty($sqlCondHash['EMP_ID'])){
			$empFlag	= $sqlCondHash['EMP_ID'];    
	    }
	    if(isset($sqlCondHash['START_LIMIT']) && !empty($sqlCondHash['START_LIMIT'])){
			$startLimit	= $sqlCondHash['START_LIMIT'];    
	    }
	    if(isset($sqlCondHash['END_LIMIT']) && !empty($sqlCondHash['END_LIMIT'])){
			$endLimit	= $sqlCondHash['END_LIMIT'];    
	    }
	    if(isset($sqlCondHash['IN_FLAG']) && !empty($sqlCondHash['IN_FLAG'])){
			$in_flag	= $sqlCondHash['IN_FLAG'];    
	    }
            $vendors=$sqlCondHash['VENDOR_NAME_ARR_PARAM'];
            $vendors_id=isset($sqlCondHash['IN_VENDOR_IDS'])?$sqlCondHash['IN_VENDOR_IDS']:'';
            $START_DATE=$sqlCondHash['START_DATE'];
            $END_DATE=$sqlCondHash['END_DATE'];
            $START_TIME=$sqlCondHash['START_TIME'];
            $END_TIME=$sqlCondHash['END_TIME'];
            if($vendors=='ALL'){     
				
					$query = "SELECT * from sp_leap_dashboard_v2('ALL', '$START_DATE','$END_DATE',$START_TIME, $END_TIME,$cntryFlag,$tlid,$empFlag,$in_flag,$startLimit,$endLimit,'')";                 
			}else{
               $vendorStr="'".$vendors."'";
               $vendorStr_q=str_replace("''", "'", $vendorStr);
               if($vendors_id==''){                   
                   if($in_flag <> 0){
                        $recVendorAll=CommonVariable::get_active_vendor_list(); 
                        foreach($recVendorAll as $key => $value)
                         {
                             if($vendors == $value)
                             {
                                 $vendors_id = $key;
                             }
                         }
					
							$query = "SELECT * from sp_leap_dashboard_v2($vendorStr_q, '$START_DATE','$END_DATE',$START_TIME, $END_TIME,$cntryFlag,$tlid,$empFlag,$in_flag,$startLimit,$endLimit,'$vendors_id')";  
						  
					}else{
					
							$query = "SELECT * from sp_leap_dashboard_v2($vendorStr_q, '$START_DATE','$END_DATE',$START_TIME, $END_TIME,$cntryFlag,$tlid,$empFlag,$in_flag,$startLimit,$endLimit,'')";  
						
					}              
               }else{
					$query = "SELECT * from sp_leap_dashboard_v2($vendorStr_q, '$START_DATE','$END_DATE',$START_TIME, $END_TIME,$cntryFlag,$tlid,$empFlag,$in_flag,$startLimit,$endLimit,$vendors_id)";                 
			
            }
		}
$started_time = microtime(true); 
$tr=pg_query($dbh,$query);
$r=pg_fetch_all($tr);
$emp_id = Yii::app()->session['empid'];
$out_cur_cnt=$r[0]['out_cur_cnt'];  
$out_cur_aht_cnt=$r[0]['out_cur_aht_cnt'];
$out_app_cnt=$r[0]['out_app_cnt'];
$out_cur_timliness=$r[0]['out_cur_timliness'];
$out_cur_min_lock_date=$r[0]['out_cur_min_lock_date'];
$out_cur_max_approv_date=$r[0]['out_cur_max_approv_date'];
$out_cur_del=$r[0]['out_cur_del'];
$out_cur_app=$r[0]['out_cur_app'];

$end_time = microtime(true); 	
$difference_in_time = $end_time - $started_time;	
$queryTime = number_format($difference_in_time, 30);
$msg_with_parameters='';
$msg_with_parameters.="SQL query took $queryTime seconds.\n";
$msg_with_parameters.="Query with parameters : $query ";

if($queryTime>5){      
	mail("ramu@indiamart.com", "LeapdashboadModel query taking more than 5000ms", "$msg_with_parameters");  
}
if($queryTime>10){      
	mail("laxmi@indiamart.com", "LeapdashboadModel query taking more than 10,000ms", "$msg_with_parameters");  
        echo '<div align="center"><font color="red">We are unable to process because DB Procedure takes More than 10 Sec. </font></div>';
}
//echo '<pre>';print_r($out_cur_aht_cnt);echo '</pre>';
$returnArr = array(
				'cursorCnt' => $out_cur_cnt,
				"appCnt" => $out_app_cnt,
				"ahtCnt" => $out_cur_aht_cnt,
				"timlinessCnt" => $out_cur_timliness,
				"minLockDateCur" => $out_cur_min_lock_date,
				"maxApproveDateCur" => $out_cur_max_approv_date,
				"empwise" => $out_cur_del,
				"empwiseapp" => $out_cur_app,
			);			
			return $returnArr;			
  }
  
	public function findAHTold($tempAHT) {            
            $arr = explode(".", $tempAHT);
            $sec='00';
            if(isset($arr[1])){
            $sec =  $arr[1]*60;
            if($sec <= 9) {
             $sec="0$sec";
            }
            if($arr[0]==0)
            {
                    $arr[0]="00";
            }
            elseif($arr[0]<=9)
            {
                    $arr[0]="0".$arr[0]."";
            }
            }
            return date('H:i:s', mktime(0,$arr[0],$sec));  
	}
	

function findAHT($seconds){
     // extract hours
    $hours = floor($seconds / (60 * 60));
    if($hours==0)
    {
            $hours="00";
    }
    elseif($hours<=9)
    {
            $hours="0".$hours."";
    }
    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor($divisor_for_minutes / 60);
    if($minutes==0)
    {
            $minutes="00";
    }
    elseif($minutes<=9)
    {
            $minutes="0".$minutes."";
    }
    
    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil($divisor_for_seconds);
    
    if($seconds==0)
    {
            $seconds="00";
    }
    elseif($seconds<=9)
    {
            $seconds="0".$seconds."";
    }

    //create string HH:MM:SS
    $ret = $hours.":".$minutes.":".$seconds;
    return($ret);
}


	public function findPercnt($numerator,$denominator,$precision=2){
		$result = 0;
		$numerator = !empty($numerator)?$numerator:0;
		$denominator = !empty($denominator)?$denominator:0;
		if($denominator > 0) {
			if($precision == 1) {
				$result = sprintf("%.0f", ($numerator/$denominator)*100);
			} else {
				$result = sprintf("%.2f", ($numerator/$denominator)*100);
			}
		}
		if($result == 0) {
			if($precision == 1) {
				$result = "0";
			} else {
				$result = "00.00";
			}
		}
		return $result;
	}
	
	  
	public function array_sort_by_column($arr, $col, $dir = SORT_ASC) {
			$keys = array_keys($arr);
			$sort_col = array();
				foreach ($arr as $key=> $row) 
				{
				if(isset($_REQUEST['sortby']) and $_REQUEST['sortby']=='AHT' )    
				    $sort_col[$key] = strtotime($row[$col]);
				else
				    $sort_col[$key] = $row[$col];
				}
				
                                if(isset($_REQUEST['orderdata']) and $_REQUEST['orderdata']=='SORT_DESC')
				 array_multisort($sort_col, SORT_DESC, SORT_NUMERIC, $arr,$keys);
				else
				 array_multisort($sort_col, SORT_ASC, SORT_NUMERIC, $arr,$keys);
                        
                         $arr = array_combine($keys, $arr);
                         return $arr;
                     }

public function tlWiseDetail($request,$vendorRe) {
		
		$flagError='';
		$errArr=array();
		$empHash=array();
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$start_time = $request->getParam('start_time',0);
		$end_time = $request->getParam('end_time',24);
               
		$strt1 = strtotime($start_date);
		$end1 = strtotime($end_date);
		$today = strtotime(date("d-M-Y"));
               
	if($flagError==1)
	{
			$mesg = '';
		$mesg = '<TABLE BORDER="0" WIDTH="100%"><TR>
			<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#a30000" size="2"><B>Following Error(s) Occured:<BR>';
		$errorCounter=0;
		foreach ($errArr as $err) {
			$errorCounter++;
			$mesg .= " Error ".$errorCounter.": $err";
		}
		$mesg .="</FONT></TD>
			</TR></TABLE>";
	} else 
	{	
			$source = $request->getParam('source','A');
			$empFlag = $request->getParam('emp_flag',0);
                        $cntryArr = array('I' => 2,'F' => 3,'A' => 0);
                        $cntryFlag = isset($cntryArr[$source])?$cntryArr[$source]:0;
			$vendor = $request->getParam('vendor','ALL');
			$tlid = $request->getParam('tlid',0);
                        $vendorArr = $vendorRe['vendorArr']; 
                        
                        
                        $sqlCondHash = $this->getSqlCondHash($request,$vendorArr);
                        $sqlCondHash['IN_FLAG']=6;
                        
			$returnCurArr = $this->getTotalAssigned($sqlCondHash,$request);
			$sthCurCount = $returnCurArr['cursorCnt'];
 			$sthAppCount = $returnCurArr['appCnt'];
 			$sthAhtCount = $returnCurArr['ahtCnt']; 			
 			$CurCount=json_decode($sthCurCount,true);
                        $AppCount=json_decode($sthAppCount,true);
                        $AhtCount = json_decode($sthAhtCount,true);
 			$empHash = array();
			 if(!empty($CurCount)){
 			foreach($CurCount as $rec){ 			
                                $rec=array_change_key_case($rec, CASE_UPPER);
				$empID = $rec['TL_ID'];
				$empHash[$empID]["TTL_DELETED"] =$rec["TTL_DELETED"];
				$empHash[$empID]["TTL_NT_FLAGGED"] =$rec["TTL_NT_FLAGGED"];
                                $empHash[$empID]["TTL_AUTO_FLAGGED"] =$rec["TTL_AUTO_FLAGGED"];
				$empHash[$empID]["ETO_LEAP_TL_NAME"] = $rec["ETO_LEAP_TL_NAME"];
                                $empHash[$empID]["ETO_LEAP_VENDOR_NAME"] = $rec["ETO_LEAP_VENDOR_NAME"];				
			}
		}
 			foreach($AppCount as $rec){ 	
                               $rec=array_change_key_case($rec, CASE_UPPER);
 				$empID = $rec['TL_ID'];
				$empHash[$empID]["TTL_APPROVAL"] =$rec["TTL_APPROVAL"];
                                $empHash[$empID]["TTL_PPP"] =$rec["TTL_PPP"];
				$empHash[$empID]["TTL_CALL_APPROVED"] =$rec["TTL_CALL_APPROVED"];
				$empHash[$empID]["TTL_DO_NOT_CALL"] =$rec["TTL_DO_NOT_CALL"];
                                $empHash[$empID]["TTL_DNC_FOREIGN"] =$rec["TTL_DNC_FOREIGN"];
                                if(isset($rec["TTL_LEAP"])){
                                    $empHash[$empID]["TTL_LEAP"] =$rec["TTL_LEAP"];	
                                }else{
                                    $empHash[$empID]["TTL_LEAP"] =0;	
                                }
				$empHash[$empID]["APPROVED_12_MORE"] =$rec["APPROVED_12_MORE"];
				$empHash[$empID]["APPROVED_24_MORE"] =$rec["APPROVED_24_MORE"];
                        }
                        foreach($AhtCount as $rec){ 	
 			        $rec=array_change_key_case($rec, CASE_UPPER);
				if(isset($rec['ETO_LEAP_TL_ID'])){
                                    $empID = $rec['ETO_LEAP_TL_ID'];
                                }else{
                                    $empID = isset($rec['TL_ID'])?$rec['TL_ID']:'';
                                }
				$tempAHT = !empty($rec['AHT'])? $rec['AHT']:'00:00:00';
				$empHash[$empID]["TEMP_AHT"] = $tempAHT;
				$empHash[$empID]["AHT"] = $this->findAHT($tempAHT);
			}
			
			foreach($empHash as $empID => $empR)
                        {

                                $empHash[$empID]["AHT"] = isset($empHash[$empID]["AHT"])?$empHash[$empID]["AHT"]:'00:00:00';
                                $empHash[$empID]["TEMP_AHT"] = isset($empHash[$empID]["TEMP_AHT"])?$empHash[$empID]["TEMP_AHT"]:0;	
                                $empHash[$empID]["TTL_APPROVAL"]= !empty($empHash[$empID]["TTL_APPROVAL"])?$empHash[$empID]["TTL_APPROVAL"]:0;
                                $empHash[$empID]["TTL_CALL_APPROVED"]= !empty($empHash[$empID]["TTL_CALL_APPROVED"])?$empHash[$empID]["TTL_CALL_APPROVED"]:0;
                                $empHash[$empID]["TTL_DO_NOT_CALL"]= !empty($empHash[$empID]["TTL_DO_NOT_CALL"])?$empHash[$empID]["TTL_DO_NOT_CALL"]:0;
                                $empHash[$empID]["TTL_DNC_FOREIGN"]= !empty($empHash[$empID]["TTL_DNC_FOREIGN"])?$empHash[$empID]["TTL_DNC_FOREIGN"]:0;
                                $empHash[$empID]["TTL_LEAP"]= !empty($empHash[$empID]["TTL_LEAP"])?$empHash[$empID]["TTL_LEAP"]:0;
                                $empHash[$empID]["TTL_DELETED"]= !empty($empHash[$empID]["TTL_DELETED"])?$empHash[$empID]["TTL_DELETED"]:0;
                                $empHash[$empID]["TTL_WORKED"] = $empHash[$empID]["TTL_APPROVAL"]+$empHash[$empID]["TTL_DELETED"];
                                $empHash[$empID]["APPROVAL_PR"] = $this->findPercnt($empHash[$empID]["TTL_APPROVAL"],$empHash[$empID]["TTL_WORKED"]); 
                        }
        
       
	$colwidth ="55px";	$colwidth1 = "60px";	$cssClass = "$start_date";
	if($start_date != $end_date)
	{
		$cssClass = "$start_date - $end_date";
	}
					$cssClass .= "-$vendor";				 
				$html = '';
				$html .= '
				
				<input type="hidden" value="'.$cssClass.'" name="startdt" id="startdt">
				  <div id="div1" style="width:1300px; margin:0px auto;">
				<table border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1300px" >
				<tr id="trid">	
				<td class="intd" bgcolor="#dff8ff" width="85"><b>TL Name</b></td>
				<td class="intd" bgcolor="#dff8ff" width="65"><b>TL ID</b></td>				
				<td class="intd" bgcolor="#dff8ff" width="65"><b>Vendor</b></td>	
				<td class="intd" bgcolor="#dff8ff" width="55"><b>Deleted </b>'."</td>".'
				<td class="intd" bgcolor="#dff8ff" width="60"><b>Approved </b>'."</td>".'
				<td class="intd" bgcolor="#dff8ff" width="65"><b>Call</b></td>
				<td class="intd" bgcolor="#dff8ff" width="65"><b>DNC</b></td>
                                <td class="intd" bgcolor="#dff8ff" width="65"><b>Foreign</b></td>
                                <td class="intd" bgcolor="#dff8ff" width="65"><b>Leap MODID</b></td>
				<td class="intd" bgcolor="#dff8ff" width="70"><b>NT Manual</b></td>
                                <td class="intd" bgcolor="#dff8ff" width="70"><b>NT Auto</b></td>
				<td class="intd" bgcolor="#dff8ff" width="55"><b>Approval %</b></td>				
				<td class="intd" bgcolor="#dff8ff" width="55"><b>AHT </b></td>
                                <td class="intd" bgcolor="#dff8ff" width="55"><b>PPP </b></td>				
				</tr>
				<tbody>';				
				
				foreach($empHash as $empK => $empR) {					
                                        $vendor_cur=isset($empR['ETO_LEAP_VENDOR_NAME'])?$empR['ETO_LEAP_VENDOR_NAME']:'-';
                                        $tl=isset($empR['ETO_LEAP_TL_NAME'])?$empR['ETO_LEAP_TL_NAME']:'';
                                        $ttl_nt=isset($empR['TTL_NT_FLAGGED'])?$empR['TTL_NT_FLAGGED']:'';
                                        $ttl_auto=isset($empR['TTL_AUTO_FLAGGED'])?$empR['TTL_AUTO_FLAGGED']:'';
                                        $aht=isset($empR['AHT'])?$empR['AHT']:''; 
                                        $temp_aht=isset($empR['TEMP_AHT'])?$empR['TEMP_AHT']:''; 
                                        $ppp=isset($empR['TTL_PPP'])?$empR['TTL_PPP']:''; 
					$html .= "
					 <tr>
					<td class='intd'   width='$colwidth1'><a href='javascript:void(0)' onclick=\"empWiseDetail('D','divid1','$start_date','$end_date','$vendor_cur','$source','$start_time','$end_time','$empK','','','1');\"
						style='text-decoration:none;color:#0000ff' >".$tl."</a>
                                        </td>
					<td class='intd'   width='$colwidth1'>$empK</td>
                                        <td class='intd'   width='$colwidth1'>".$vendor_cur."</td>  
                                            

                                        <td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=empwisedd&start_date=$start_date&end_date=$end_date&vendor=$vendor_cur&in_flag=2&source=$source&start_time=$start_time&end_time=$end_time&tlid=$empK&total_records=".$empR['TTL_DELETED']."'>".$empR['TTL_DELETED']."</a>
					</td>
					<td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=empwisead&start_date=$start_date&end_date=$end_date&vendor=$vendor_cur&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&tlid=$empK&total_records=".$empR['TTL_APPROVAL']."'>".$empR['TTL_APPROVAL']."</a>
					<input type='hidden' value='".$empR['TTL_APPROVAL']."' name='ttlapproved'>
					</td>	
					<td class='intd'   width='$colwidth1'>".$empR["TTL_CALL_APPROVED"]."</td>
					<td class='intd'   width='$colwidth1'>".$empR["TTL_DO_NOT_CALL"]."</td>
                                        <td class='intd'   width='$colwidth1'>".$empR["TTL_DNC_FOREIGN"]."</td>
                                        <td class='intd'   width='$colwidth1'>".$empR["TTL_LEAP"]."</td>
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/ntdashboard&start_date=$start_date&end_date=$end_date&vendor=$vendor_cur&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&tlid=$empK&total_records=".$ttl_nt."'>".$ttl_nt."</a>
					</td>
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/autodashboard&start_date=$start_date&end_date=$end_date&vendor=$vendor_cur&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&tlid=$empK&total_records=".$ttl_auto."'>".$ttl_auto."</a>
					</td>
					<td class='intd'   width='$colwidth'>".$empR['APPROVAL_PR']."<input type='hidden' value='".$empR["APPROVAL_PR"]."' class='$cssClass' name='empApprovalPR'></td>
					<td class='intd'   width='$colwidth'>".$aht."
                                        <input type='hidden' value='".$temp_aht."' class='$cssClass' name='empAHT'></td>
                                        <td class='intd'   width='$colwidth'>".$ppp."</td>										
					</tr>";
				}
				$html .= '</tbody></table>
				</div><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>';
				echo $html;
				}
  }
 
public function aonWiseDetail($request,$vendorRe) {
		
		$flagError='';
		$errArr=array();
		$empHash=array();
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		  
		$strt1 = strtotime($start_date);
		$end1 = strtotime($end_date);
		$today = strtotime(date("d-M-Y"));
	if($flagError==1)
	{
			$mesg = '';
		$mesg = '<TABLE BORDER="0" WIDTH="100%"><TR>
			<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#a30000" size="2"><B>Following Error(s) Occured:<BR>';
		$errorCounter=0;
		foreach ($errArr as $err) {
			$errorCounter++;
			$mesg .= " Error ".$errorCounter.": $err";
		}
		$mesg .="</FONT></TD>
			</TR></TABLE>";
	} else 
	{	
			$source = $request->getParam('source','A');
			$empFlag = $request->getParam('emp_flag',0);
                        $cntryArr = array('I' => 2,'F' => 3,'A' => 0);
                        $cntryFlag = isset($cntryArr[$source])?$cntryArr[$source]:0;
			$vendor = $request->getParam('vendor','ALL');
			$tlid = $request->getParam('tlid',0);
                        $vendorArr = $vendorRe['vendorArr']; 
                        
                        
                        $sqlCondHash = $this->getSqlCondHash($request,$vendorArr);
                        $sqlCondHash['IN_FLAG']=7;
			$returnCurArr = $this->getTotalAssigned($sqlCondHash,$request);
			$sthCurCount = $returnCurArr['cursorCnt'];
 			$sthAppCount = $returnCurArr['appCnt'];
 			$sthAhtCount = $returnCurArr['ahtCnt'];
 			$CurCount=json_decode($sthCurCount,true);
                        $AppCount=json_decode($sthAppCount,true);
                        $AhtCount = json_decode($sthAhtCount,true);
 			
 			$empHash = array();
 			 foreach($CurCount as $rec){ 
                                $rec=array_change_key_case($rec, CASE_UPPER);
				$empID = $rec['AON_FLAG'];
				$empHash[$empID]["TTL_DELETED"] =$rec["TTL_DELETED"];
				$empHash[$empID]["TTL_NT_FLAGGED"] =$rec["TTL_NT_FLAGGED"];
                                $empHash[$empID]["TTL_AUTO_FLAGGED"] =$rec["TTL_AUTO_FLAGGED"];
			}
                        foreach($AppCount as $rec){  			
                                $rec=array_change_key_case($rec, CASE_UPPER);
 				$empID = $rec['AON_FLAG'];
				$empHash[$empID]["TTL_APPROVAL"] =$rec["TTL_APPROVAL"];
                                $empHash[$empID]["TTL_PPP"] =$rec["TTL_PPP"];
				$empHash[$empID]["TTL_CALL_APPROVED"] =$rec["TTL_CALL_APPROVED"];
				$empHash[$empID]["TTL_DO_NOT_CALL"] =$rec["TTL_DO_NOT_CALL"];
                                $empHash[$empID]["TTL_DNC_FOREIGN"] =$rec["TTL_DNC_FOREIGN"];
                                if(isset($rec['TL_ID'])){
                                   $empHash[$empID]["TTL_LEAP"] =$rec["TTL_LEAP"];
                                }else{
                                   $empHash[$empID]["TTL_LEAP"] =0;
                                }
			}
                        foreach($AhtCount as $rec){  
                                $rec=array_change_key_case($rec, CASE_UPPER);
                                if(isset($rec['TL_ID'])){
                                    $empID = $rec['TL_ID'];
                                }else{
                                    $empID = $rec['AON_FLAG'];
                                }
				
				$tempAHT = !empty($rec['AHT'])? $rec['AHT']:'00:00:00';
				$empHash[$empID]["TEMP_AHT"] = $tempAHT;
				$empHash[$empID]["AHT"] = $this->findAHT($tempAHT);
			}
			
			foreach($empHash as $empID => $empR)
	{
		
		$empHash[$empID]["AHT"] = !empty($empHash[$empID]["AHT"])?$empHash[$empID]["AHT"]:'00:00:00';
		$empHash[$empID]["TEMP_AHT"] = !empty($empHash[$empID]["AHT"])?$empHash[$empID]["TEMP_AHT"]:0;
		
		$empHash[$empID]["TTL_APPROVAL"]= !empty($empHash[$empID]["TTL_APPROVAL"])?$empHash[$empID]["TTL_APPROVAL"]:0;
		$empHash[$empID]["TTL_CALL_APPROVED"]= !empty($empHash[$empID]["TTL_CALL_APPROVED"])?$empHash[$empID]["TTL_CALL_APPROVED"]:0;
		$empHash[$empID]["TTL_DO_NOT_CALL"]= !empty($empHash[$empID]["TTL_DO_NOT_CALL"])?$empHash[$empID]["TTL_DO_NOT_CALL"]:0;
                $empHash[$empID]["TTL_DNC_FOREIGN"]= !empty($empHash[$empID]["TTL_DNC_FOREIGN"])?$empHash[$empID]["TTL_DNC_FOREIGN"]:0;
                $empHash[$empID]["TTL_LEAP"]= !empty($empHash[$empID]["TTL_LEAP"])?$empHash[$empID]["TTL_LEAP"]:0;
		$empHash[$empID]["TTL_DELETED"]= !empty($empHash[$empID]["TTL_DELETED"])?$empHash[$empID]["TTL_DELETED"]:0;
		$empHash[$empID]["TTL_WORKED"] = $empHash[$empID]["TTL_APPROVAL"]+$empHash[$empID]["TTL_DELETED"];
		$empHash[$empID]["APPROVAL_PR"] = $this->findPercnt($empHash[$empID]["TTL_APPROVAL"],$empHash[$empID]["TTL_WORKED"]);		
	}
        
       
	$colwidth ="55px";	$colwidth1 = "60px";	$colwidth2 = "100px";	$cssClass = "$start_date";
	if($start_date != $end_date)
	{
		$cssClass = "$start_date - $end_date";
	}
					$cssClass .= "-$vendor";
				$html = '';
				$html .= '
				
				<input type="hidden" value="'.$cssClass.'" name="startdt" id="startdt">
				<link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
			        <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
			        <div id="div1" style="width:1300px; margin:0px auto;">
				<table border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1300px" >				
				<tr id="trid">	
				<td class="intd" bgcolor="#dff8ff" width="85"><b>AON</b></td>				
				<td class="intd" bgcolor="#dff8ff" width="55"><b>Deleted </b>'."</td>".'
				<td class="intd" bgcolor="#dff8ff" width="60"><b>Approved </b>'."</td>".'
				<td class="intd" bgcolor="#dff8ff" width="65"><b>Call</b></td>
				<td class="intd" bgcolor="#dff8ff" width="65"><b>DNC</b></td>
                                <td class="intd" bgcolor="#dff8ff" width="65"><b>Foreign</b></td>
                                <td class="intd" bgcolor="#dff8ff" width="65"><b>Leap MODID</b></td>
				<td class="intd" bgcolor="#dff8ff" width="70"><b>NT Manual</b>'."</td>".'
                                <td class="intd" bgcolor="#dff8ff" width="70"><b>NT Auto</b>'."</td>".'
				<td class="intd" bgcolor="#dff8ff" width="55"><b>Approval %</b></td>				
				<td class="intd" bgcolor="#dff8ff" width="55"><b>AHT </b>'."</td>".'
				<td class="intd" bgcolor="#dff8ff" width="100"><b>PPP</b></td>	
				</tr>
				<tbody>';
				
				foreach($empHash as $empK => $empR) {					
                                       if($empK==''){
                                           $empK="NA";
                                       }
					$html .= "
					 <tr>
					<td class='intd'   width='$colwidth1'>".$empK."</a>
                                        </td>

                                        <td class='intd' style='text-align:center;'  width='$colwidth'>".$empR['TTL_DELETED']."</td>
					<td class='intd' style='text-align:center;'  width='$colwidth'>".$empR['TTL_APPROVAL']."</a>
					<input type='hidden' value='".$crVendorR['TTL_APPROVAL']."' name='ttlapproved'>
					</td>	
					<td class='intd'   width='$colwidth1'>".$empR["TTL_CALL_APPROVED"]."</td>
					<td class='intd'   width='$colwidth1'>".$empR["TTL_DO_NOT_CALL"]."</td>
                                        <td class='intd'   width='$colwidth1'>".$empR["TTL_DNC_FOREIGN"]."</td>
                                        <td class='intd'   width='$colwidth1'>".$empR["TTL_LEAP"]."</td>
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>".$empR['TTL_NT_FLAGGED']."</td>
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>".$empR['TTL_AUTO_FLAGGED']."</td>
					<td class='intd'   width='$colwidth'>".$empR['APPROVAL_PR']."</td>
					<td class='intd'   width='$colwidth'>".$empR["AHT"]."</td>
					<td class='intd'   width='$colwidth'>".$empR["TTL_PPP"]."</td>
					
					</tr>";
				}
				$html .= '</tbody></table>
				</div><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>';
				echo $html;
				}
  }
  
public function isqWiseDetail($request,$vendorRe,$empId)
  {
  
               $model = new GlobalmodelForm();
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$start_time = $request->getParam('start_time',0);
		$end_time = $request->getParam('end_time',24);
                $vendor=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : ''; 
                $vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
		$strt1 = strtotime($start_date);
		$end1 = strtotime($end_date);
		$today = strtotime(date("d-M-Y"));
		$source = $request->getParam('source','A');
		$tlid = $request->getParam('tlselect',0);
                $tlidEmpWise = $request->getParam('tlid',0);
	        $tlid = (!empty($tlidEmpWise) ? $tlidEmpWise : (!empty($tlid) ? $tlid : 0));
                $obj = new Globalconnection();
				$dbh = $obj->connect_db_yii('postgress_web68v'); 
		$vendorArr=explode(',',$vendorVal);
		if($vendor <>'ALL')
		{
		$sqlcond1 =" ,eto_leap_mis";
		$column =",ETO_LEAP_VENDOR_NAME";
                        if(sizeof($vendorArr)>1)
                        {		
                                    $sqlcond2 =" where 
                                    ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG";
                                    if($strt1 == $today && $end1 == $today)
                                    {
                                      $sqlcond2 .=" AND date(eto_ofr_approv_date_orig) =date(now())";
                                    }
                                    else
                                    {
                                    $sqlcond2 .=" AND date(eto_ofr_approv_date_orig) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY')"; 
                                    }

                                    $vendorVal="'".str_replace(",", "','", $vendorVal)."'";  
                                    $sqlcond2 .=" AND EXTRACT(HOUR from ETO_OFR_APPROV_DATE_ORIG) >= $start_time 
                                    AND EXTRACT(HOUR from ETO_OFR_APPROV_DATE_ORIG) < $end_time ";
                                    
                                    if($source=='I'){
                                        $sqlcond2 .=" and FK_GL_COUNTRY_ISO = 'IN' ";
                                    }elseif($source=='F'){
                                        $sqlcond2 .=" and FK_GL_COUNTRY_ISO <> 'IN' ";
                                    }
                                    if($vendorVal<>'ALL'){
                                        $sqlcond2 .="  AND ETO_LEAP_VENDOR_NAME IN ($vendorVal)";
                                    }                                   
                        }
                        else
                        {
                         $sqlcond2 =" where 
                                    ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG";
                                    if($strt1 == $today && $end1 == $today)
                                    {
                                      $sqlcond2 .=" AND date(eto_ofr_approv_date_orig) =date(now())";
                                    }
                                    else
                                    {
                                    $sqlcond2 .=" AND date(eto_ofr_approv_date_orig) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY')"; 
                                    }
                                    $sqlcond2 .=" AND EXTRACT(HOUR from ETO_OFR_APPROV_DATE_ORIG) >= $start_time 
                                    AND EXTRACT(HOUR from ETO_OFR_APPROV_DATE_ORIG) < $end_time ";
                                    
                                     if($source=='I'){
                                        $sqlcond2 .=" and FK_GL_COUNTRY_ISO = 'IN' ";
                                    }elseif($source=='F'){
                                        $sqlcond2 .=" and FK_GL_COUNTRY_ISO <> 'IN' ";
                                    }  
                                    
                                    $vendorVal="'".str_replace(",", "','", $vendorVal)."'";  
                                    if($vendorVal<>'ALL'){
                                        $sqlcond2 .="  AND ETO_LEAP_VENDOR_NAME IN ($vendorVal)";
                                    }
                    }
                                   
		}
		else
		{
		$column='';
		$sqlcond1 ="";
		if($strt1 == $today && $end1 == $today)
                            {
                              $sqlcond2 =" where date(eto_ofr_approv_date_orig) =date(now())";
                            }
                            else
                            {
                            $sqlcond2 =" where date_trunc('day'::text, eto_ofr_approv_date_orig) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY')"; 
                            }
                            $sqlcond2 .=" AND EXTRACT(HOUR from ETO_OFR_APPROV_DATE_ORIG) >= $start_time 
                                    AND EXTRACT(HOUR from ETO_OFR_APPROV_DATE_ORIG) < $end_time ";
                            if($source=='I'){
                                $sqlcond2 .=" and FK_GL_COUNTRY_ISO = 'IN' ";
                            }elseif($source=='F'){
                                $sqlcond2 .=" and FK_GL_COUNTRY_ISO <> 'IN' ";
                            }
                             if($vendorVal<>'ALL'){
                                $sqlcond2 .="  AND ETO_LEAP_VENDOR_NAME IN ($vendorVal)";
                            }
			   
		}          
		     $bind[':start_date']=$start_date;
		     $bind[':end_date']=$end_date;
		   $sql2="select APPROV_DATE, count(distinct eto_ofr_display_id) BL_APRROVED, 
                      count(distinct case when coalesce(mcat_isq_avl,0) > 0 then eto_ofr_display_id end) isq_avl,
                      count(distinct case when ISQ_FILLED >0 then eto_ofr_display_id end) isq_filled_1 ,
                      count(distinct case when ISQ_FILLED >1 then eto_ofr_display_id end) isq_filled_2, 
                      count(distinct case when ISQ_FILLED >2 then eto_ofr_display_id end) isq_filled_3,                         
                      count(distinct case when ISQ_FILLED >3 then eto_ofr_display_id end) isq_filled_4, 
                      count(distinct case when ISQ_FILLED >4 then eto_ofr_display_id end) isq_filled_5 $column  
from 
(
    select eto_ofr_display_id,APPROV_DATE $column, 
    (select count(distinct IM_CAT_SPEC_CATEGORY_ID||'#'||IM_CAT_SPEC_CATEGORY_TYPE) 
    from im_cat_specification where IM_CAT_SPEC_STATUS = 1 and IM_CAT_SPEC_CATEGORY_TYPE = 3 and IM_CAT_SPEC_CATEGORY_ID = OFR.FK_GLCAT_MCAT_ID) mcat_isq_avl,
    (select count(fk_eto_ofr_display_id) from eto_attribute where fk_eto_ofr_display_id = eto_ofr_display_id) isq_filled  from                                 
    (
        select FK_GLCAT_MCAT_ID, eto_ofr_display_id, to_char(date(eto_ofr_approv_date_orig),'dd-Mon-yyyy') APPROV_DATE $column  
        from eto_ofr $sqlcond1 $sqlcond2
        UNION ALL 
        select FK_GLCAT_MCAT_ID, eto_ofr_display_id, to_char(date_trunc('day'::text, eto_ofr_approv_date_orig),'dd-Mon-yyyy') APPROV_DATE 
        $column from eto_ofr_expired $sqlcond1 $sqlcond2                                  
    ) OFR
)a group by APPROV_DATE $column order by APPROV_DATE
;";  

		     $sth2 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql2, $bind);
			 $rec2=array();
			 if($sth2){
		     $rec2=$sth2->readAll();
			 }
		     $IsqArray=array();
               if($rec2){      
		     for($i=0;$i<sizeof($rec2);$i++)
		     {
                       $rec2[$i]=array_change_key_case($rec2[$i], CASE_UPPER);
		       $IsqArray[$i]['APPROV_DATE']=$rec2[$i]['APPROV_DATE'];
		       if($vendor <>'ALL'){
		       $IsqArray[$i]['ETO_LEAP_VENDOR_NAME']=$rec2[$i]['ETO_LEAP_VENDOR_NAME'];
		        }
		       $IsqArray[$i]['TOT_BL_APRROVED']=$rec2[$i]['BL_APRROVED'];		       
		       $IsqArray[$i]['ISQ_AVL']=$rec2[$i]['ISQ_AVL'];
		       $IsqArray[$i]['ISQ_FILLED_1']=$rec2[$i]['ISQ_FILLED_1'];
		       $IsqArray[$i]['ISQ_FILLED_2']=$rec2[$i]['ISQ_FILLED_2'];
		       $IsqArray[$i]['ISQ_FILLED_3']=$rec2[$i]['ISQ_FILLED_3'];
		       $IsqArray[$i]['ISQ_FILLED_4']=$rec2[$i]['ISQ_FILLED_4'];
		       $IsqArray[$i]['ISQ_FILLED_5']=$rec2[$i]['ISQ_FILLED_5'];
		     }
			}
		        $returnHash = '';
			$returnHash .= "<BR>";
			$returnHash .= '<div id="div1" style="width:1300px; margin:0px auto;">';
        	$returnHash .= '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1300px">
        							<tr>
        							<td rowspan="2" colspan="2" style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Date</b></td>
        							<td rowspan="2" colspan="2" style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Vendor Name</b></td>
        							<td rowspan="2" colspan="2"  style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>Approval</b></td>
        							<td rowspan="2" colspan="2"  style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>ISQ AVL</b></td>
                                                                <td colspan="2" style="text-align:center;" bgcolor="#dff8ff"" width="11%"><b>>=ISQ1</b></td>
                                                                <td colspan="2" style="text-align:center;" bgcolor="#dff8ff" width="11%"><b>>=ISQ2</b></td>        
        							<td colspan="2" style="text-align:center;" bgcolor="#dff8ff" width="11%"><b>>=ISQ3</b></td>
                                                                <td colspan="2" style="text-align:center;" bgcolor="#dff8ff" width="11%"><b>>=ISQ4</b></td>
        							<td colspan="2" style="text-align:center;" bgcolor="#dff8ff" width="11%"><b>>=ISQ5</b></td>
        							</tr>
        							<tr>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>%</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="6%" ><b>Filled</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="5%" ><b>%</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="6%" ><b>Filled</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="5%" ><b>%</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="6%" ><b>Filled</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="5%" ><b>%</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="6%" ><b>Filled</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="5%" ><b>%</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="6%" ><b>Filled</b></td>
        							</tr>';
        	
        	
						$ISQ_AVL=0;
						$TOT_BL_APRROVED=0;
						$ISQ_FILLED_1_TOT=0;
						$ISQ_FILLED_2_TOT=0;
						$ISQ_FILLED_3_TOT=0;
						$ISQ_FILLED_4_TOT=0;
						$ISQ_FILLED_5_TOT=0;
						foreach($IsqArray as $temp)
						{
						if($temp['ISQ_AVL']>0)
						{
						$ISQ_FILLED_1_per=round(($temp['ISQ_FILLED_1']/$temp['ISQ_AVL'])*100,2);
						$ISQ_FILLED_2_per=round(($temp['ISQ_FILLED_2']/$temp['ISQ_AVL'])*100,2);
						$ISQ_FILLED_3_per=round(($temp['ISQ_FILLED_3']/$temp['ISQ_AVL'])*100,2);
						$ISQ_FILLED_4_per=round(($temp['ISQ_FILLED_4']/$temp['ISQ_AVL'])*100,2);
						$ISQ_FILLED_5_per=round(($temp['ISQ_FILLED_5']/$temp['ISQ_AVL'])*100,2);
						}
						else
						{
						  $ISQ_FILLED_1_per=0;
						  $ISQ_FILLED_2_per=0;
						  $ISQ_FILLED_3_per=0;
						  $ISQ_FILLED_4_per=0;
						  $ISQ_FILLED_5_per=0;
						}
						$ISQ_FILLED_1_per = sprintf('%0.2f', $ISQ_FILLED_1_per);
						$ISQ_FILLED_2_per = sprintf('%0.2f', $ISQ_FILLED_2_per);
						$ISQ_FILLED_3_per = sprintf('%0.2f', $ISQ_FILLED_3_per);
						$ISQ_FILLED_4_per = sprintf('%0.2f', $ISQ_FILLED_4_per);
						$ISQ_FILLED_5_per = sprintf('%0.2f', $ISQ_FILLED_5_per);
						
						$ISQ_FILLED_1=!empty($temp['ISQ_FILLED_1']) ? $temp['ISQ_FILLED_1'] :0;
						$ISQ_FILLED_2=!empty($temp['ISQ_FILLED_2']) ? $temp['ISQ_FILLED_2'] :0;
						$ISQ_FILLED_3=!empty($temp['ISQ_FILLED_3']) ? $temp['ISQ_FILLED_3'] :0;
						$ISQ_FILLED_4=!empty($temp['ISQ_FILLED_4']) ? $temp['ISQ_FILLED_4'] :0;
						$ISQ_FILLED_5=!empty($temp['ISQ_FILLED_5']) ? $temp['ISQ_FILLED_5'] :0;
						$APPROV_DATE=$temp['APPROV_DATE'];
						$returnHash .= '<tr>
        							<td  colspan="2" style="text-align:center;"  width="10%">'.$APPROV_DATE.'</td>';
        							if($vendor <>'ALL')
        							{
        							$ETO_LEAP_VENDOR_NAME=$temp['ETO_LEAP_VENDOR_NAME'];
        							$returnHash .="<td  colspan='2' style='text-align:center;' width='10%'>$ETO_LEAP_VENDOR_NAME        							
        							</td>";
        							}
        							else
        							{
        							 $returnHash .="<td  colspan='2' style='text-align:center;' width='10%'>$vendor</td>";
        							}
        							$returnHash .='<td  colspan="2"  style="text-align:center;"  width="5%">'.$temp['TOT_BL_APRROVED'].'</td>
        							<td  colspan="2"  style="text-align:center;"  width="5%">'.$temp['ISQ_AVL'].'</td>
        							<td  style="text-align:center;"  width="5%">'.$ISQ_FILLED_1_per.'</td>
        							<td  style="text-align:center;"  width="6%" >'.$ISQ_FILLED_1.'</td>
        							<td  style="text-align:center;"  width="5%" >'.$ISQ_FILLED_2_per.'</td>
        							<td  style="text-align:center;"  width="6%" >'.$ISQ_FILLED_2.'</td>
        							<td  style="text-align:center;"  width="5%" >'.$ISQ_FILLED_3_per.'</td>
        							<td  style="text-align:center;"  width="6%" >'.$ISQ_FILLED_3.'</td>
        							<td  style="text-align:center;"  width="5%" >'.$ISQ_FILLED_4_per.'</td>
        							<td  style="text-align:center;"  width="6%" >'.$ISQ_FILLED_4.'</td>
        							<td  style="text-align:center;"  width="5%" >'.$ISQ_FILLED_5_per.'</td>
        							<td  style="text-align:center;"  width="6%" >'.$ISQ_FILLED_5.'</td>
        							</tr>';
        	$ISQ_AVL=$ISQ_AVL+$temp['ISQ_AVL'];
        	$TOT_BL_APRROVED=$TOT_BL_APRROVED+$temp['TOT_BL_APRROVED'];
        	$ISQ_FILLED_1_TOT=$ISQ_FILLED_1_TOT+$ISQ_FILLED_1;
        	$ISQ_FILLED_2_TOT=$ISQ_FILLED_2_TOT+$ISQ_FILLED_2;
        	$ISQ_FILLED_3_TOT=$ISQ_FILLED_3_TOT+$ISQ_FILLED_3;
        	$ISQ_FILLED_4_TOT=$ISQ_FILLED_4_TOT+$ISQ_FILLED_4;
        	$ISQ_FILLED_5_TOT=$ISQ_FILLED_5_TOT+$ISQ_FILLED_5;
        	}
        	
        	$ISQ_FILLED_1_per_TOT=round(($ISQ_FILLED_1_TOT/$ISQ_AVL)*100,2);
        	$ISQ_FILLED_2_per_TOT=round(($ISQ_FILLED_2_TOT/$ISQ_AVL)*100,2);
        	$ISQ_FILLED_3_per_TOT=round(($ISQ_FILLED_3_TOT/$ISQ_AVL)*100,2);
        	$ISQ_FILLED_4_per_TOT=round(($ISQ_FILLED_4_TOT/$ISQ_AVL)*100,2);
        	$ISQ_FILLED_5_per_TOT=round(($ISQ_FILLED_5_TOT/$ISQ_AVL)*100,2);
        	
        	$ISQ_FILLED_1_per_TOT = sprintf('%0.2f', $ISQ_FILLED_1_per_TOT);
        	$ISQ_FILLED_2_per_TOT = sprintf('%0.2f', $ISQ_FILLED_2_per_TOT);
        	$ISQ_FILLED_3_per_TOT = sprintf('%0.2f', $ISQ_FILLED_3_per_TOT);
        	$ISQ_FILLED_4_per_TOT = sprintf('%0.2f', $ISQ_FILLED_4_per_TOT);
        	$ISQ_FILLED_5_per_TOT = sprintf('%0.2f', $ISQ_FILLED_5_per_TOT);
        	
        	$returnHash .= '<tr>
        							<td  colspan="4" style="text-align:center;" bgcolor="#dff8ff"  width="10%"><b>Total</b></td>
        							<td  colspan="2"  style="text-align:center;" bgcolor="#dff8ff"  width="5%">'.$TOT_BL_APRROVED.'</td>
        							<td  colspan="2"  style="text-align:center;" bgcolor="#dff8ff"  width="5%">'.$ISQ_AVL.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff"  width="5%">'.$ISQ_FILLED_1_per_TOT.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff"  width="6%" >'.$ISQ_FILLED_1_TOT.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff"  width="5%" >'.$ISQ_FILLED_2_per_TOT.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff"  width="6%" >'.$ISQ_FILLED_2_TOT.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff"  width="5%" >'.$ISQ_FILLED_3_per_TOT.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="6%" >'.$ISQ_FILLED_3_TOT.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="5%" >'.$ISQ_FILLED_4_per_TOT.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="6%" >'.$ISQ_FILLED_4_TOT.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="5%" >'.$ISQ_FILLED_5_per_TOT.'</td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="6%" >'.$ISQ_FILLED_5_TOT.'</td>
        							</tr>';
        							
        							$returnHash .= '</table></div><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>';
        					
        return $returnHash;							
  
  }
  
  public function topPerformerDetail($request)
  {
        
        $start_date = $request->getParam('start_date','');
	$strt1 = strtotime($start_date);
	$today = strtotime(date("d-M-Y"));
        $model = new GlobalmodelForm();
        $obj = new Globalconnection();
       if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
         if($strt1 ==$today)
         {
         $cond =" WHERE date(ETO_OFR_APPROV_DATE_ORIG)=date(now())";
         $column=" to_char(now(),'dd-Mon-YYYY') TIME1";
         $grp ="";
         }
         else
         {
          $cond=" WHERE date(ETO_OFR_APPROV_DATE_ORIG)=to_date(:start_date,'DD-MON-YYYY')";
          $column=" to_char(ETO_OFR_APPROV_DATE_ORIG,'dd-Mon-YYYY') TIME1";
          $grp ="to_char(ETO_OFR_APPROV_DATE_ORIG,'dd-Mon-YYYY'),";
         }
                    
        $sql="SELECT COUNT(ETO_OFR_DISPLAY_ID) CNT,
              $column,
	      ETO_LEAP_EMP_NAME,
	      ETO_LEAP_EMP_ID,
	      ETO_LEAP_VENDOR_NAME
	      FROM
	      (SELECT ETO_OFR_DISPLAY_ID,ETO_OFR_APPROV_DATE_ORIG,
		ETO_OFR_APPROV_BY_ORIG
	      FROM ETO_OFR
	      $cond
	      UNION ALL
	      SELECT ETO_OFR_DISPLAY_ID,ETO_OFR_APPROV_DATE_ORIG,
		ETO_OFR_APPROV_BY_ORIG
	      FROM ETO_OFR_EXPIRED
	      $cond
	      )OFR,
	      eto_Leap_mis B
	      WHERE OFR.ETO_OFR_APPROV_BY_ORIG=B.ETO_LEAP_EMP_ID
	      GROUP BY $grp ETO_LEAP_EMP_NAME,
	      ETO_LEAP_EMP_ID,
	      ETO_LEAP_VENDOR_NAME
	      ORDER BY CNT DESC";    
	     
	  $bind=array();
	  if($strt1 != $today)
	  $bind[':start_date']=$start_date;
	//  echo $sql;
	 $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,$bind);
         $Must_Call_array=array('COGENT','VKALP','KOCHARTECH','KOCHARTECHLDH','COGENTINBOUND');
         $Intent_array=array('COGENTINTENT');
         $DNC_array=array('KOCHARTECHDNC');
         $Must_Call_data=$Intent_data=$DNC_data=array();
         $counter=0;
         while($rec1=$sth->read())
         {
            $rec=array_change_key_case($rec1, CASE_UPPER);
           if(in_array($rec['ETO_LEAP_VENDOR_NAME'],$Must_Call_array))
           {
		  if(count($Must_Call_data) <3)
		  {
			array_push($Must_Call_data,$rec);
			$counter++;
		  }
           
           }
           if(in_array($rec['ETO_LEAP_VENDOR_NAME'],$Intent_array))
           {
		  if(count($Intent_data) <3)
		    {
		      array_push($Intent_data,$rec);
		    }
           
           }
           if(in_array($rec['ETO_LEAP_VENDOR_NAME'],$DNC_array))
           {
	      if(count($DNC_data) <3)
	      {
		array_push($DNC_data,$rec);
	      }
           }
           
         }
         if($counter>0){
        echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">
        							<tr>
        							<td colspan="7" style="text-align:center;" bgcolor="#dff8ff" width="100%"><b>Productivity Leaders of the Day Till: '.@$Must_Call_data[0]['TIME'].'</b></td>
        							</tr>
        							<tr>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="15%"></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="30%" colspan="2"><b>Must Call</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="30%" colspan="2"><b>Intent/Priority</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="25%" colspan="2"><b>DNC</b></td>
        							</tr>
        							<tr>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="15%"></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="22%"><b>Name</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="8%"><b>Approval</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="22%"><b>Name</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="8%"><b>Approval</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="18%"><b>Name</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="7%"><b>Approval</b></td>
        							</tr>
        							<tr>
        							<td  style="text-align:center;"  width="15%"><b>Topper</b></td>
        							<td  style="text-align:center;"  width="22%">'.@$Must_Call_data[0]['ETO_LEAP_EMP_NAME'].' ('.@$Must_Call_data[0]['ETO_LEAP_EMP_ID'].')</td>
        							<td  style="text-align:center;"  width="8%">'.@$Must_Call_data[0]['CNT'].'</td>
        							<td  style="text-align:center;"  width="22%">'.@$Intent_data[0]['ETO_LEAP_EMP_NAME'].' ('.@$Intent_data[0]['ETO_LEAP_EMP_ID'].')</td>
        							<td  style="text-align:center;"  width="8%">'.@$Intent_data[0]['CNT'].'</td>
        							<td  style="text-align:center;"  width="18%">'.@$DNC_data[0]['ETO_LEAP_EMP_NAME'].' ('.@$DNC_data[0]['ETO_LEAP_EMP_ID'].')</td>
        							<td  style="text-align:center;"  width="7%">'.@$DNC_data[0]['CNT'].'</td>
        							</tr>
        							<tr>
        							<td  style="text-align:center;"  width="15%"><b>1st Runner Up</b></td>
        							<td  style="text-align:center;"  width="22%">'.@$Must_Call_data[1]['ETO_LEAP_EMP_NAME'].' ('.@$Must_Call_data[1]['ETO_LEAP_EMP_ID'].')</td>
        							<td  style="text-align:center;"  width="8%">'.@$Must_Call_data[1]['CNT'].'</td>
        							<td  style="text-align:center;"  width="22%">'.@$Intent_data[1]['ETO_LEAP_EMP_NAME'].' ('.@$Intent_data[1]['ETO_LEAP_EMP_ID'].')</td>
        							<td  style="text-align:center;"  width="8%">'.@$Intent_data[1]['CNT'].'</td>
        							<td  style="text-align:center;"  width="18%">'.@$DNC_data[1]['ETO_LEAP_EMP_NAME'].' ('.@$DNC_data[1]['ETO_LEAP_EMP_ID'].')</td>
        							<td  style="text-align:center;"  width="7%">'.@$DNC_data[1]['CNT'].'</td>
        							</tr>
        							<tr>
        							<td  style="text-align:center;"  width="15%"><b>2nd Runner Up</b></td>
        							<td  style="text-align:center;"  width="22%">'.@$Must_Call_data[2]['ETO_LEAP_EMP_NAME'].' ('.@$Must_Call_data[2]['ETO_LEAP_EMP_ID'].')</td>
        							<td  style="text-align:center;"  width="8%">'.@$Must_Call_data[2]['CNT'].'</td>
        							<td  style="text-align:center;"  width="22%">'.@$Intent_data[2]['ETO_LEAP_EMP_NAME'].' ('.@$Intent_data[2]['ETO_LEAP_EMP_ID'].')</td>
        							<td  style="text-align:center;"  width="8%">'.@$Intent_data[2]['CNT'].'</td>
        							<td  style="text-align:center;"  width="18%">'.@$DNC_data[2]['ETO_LEAP_EMP_NAME'].' ('.@$DNC_data[2]['ETO_LEAP_EMP_ID'].')</td>
        							<td  style="text-align:center;"  width="7%">'.@$DNC_data[2]['CNT'].'</td>
        							</tr>
        							';
         }
 
 }
 
public function empWiseDetail($request,$vendorArr) {
		$errArr=array();
		$empHash=array();
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$start_time = $request->getParam('start_time',0);
		$end_time = $request->getParam('end_time',24);
		$strt1 = strtotime($start_date);
		$end1 = strtotime($end_date);
		$today = strtotime(date("d-M-Y"));
                
			$source = $request->getParam('source','A');			
                        $cntryArr = array('I' => 2,'F' => 3,'A' => 0);
                        $cntryFlag = isset($cntryArr[$source])?$cntryArr[$source]:0;
			$vendor = $request->getParam('vendor','ALL');
			$tlid = $request->getParam('tlid',0);			
			
			$sqlCondHash = array();
			$sqlCondHash['START_DATE'] = date("d-M-Y",strtotime($start_date));
			$sqlCondHash['END_DATE'] = date("d-M-Y",strtotime($end_date));
			$sqlCondHash['START_TIME'] = $start_time;
			$sqlCondHash['END_TIME'] = $end_time;
                        $recVendorAll=CommonVariable::get_active_vendor_list();
                        $vendor_ids='';
                        if($vendor<>'ALL'){
                        foreach($recVendorAll as $key => $value)
                        {
                            if($vendor == $value)
                            {
                                $vendor_ids = "'". $key."'";
                            }
                        } 
                        }
			$sqlCondHash['VENDOR_NAME_ARR_PARAM'] = $vendor;
                        $sqlCondHash['IN_VENDOR_IDS'] =$vendor_ids;
			$returnCurArr = $this->getTotalAssigned($sqlCondHash,$request);
			$sthCurCount = $returnCurArr['cursorCnt'];
 			$sthAppCount = $returnCurArr['appCnt'];
 			$sthAhtCount = $returnCurArr['ahtCnt'];
 			$CurCount=json_decode($sthCurCount,true);
                        $AppCount=json_decode($sthAppCount,true);
                        $AhtCount = json_decode($sthAhtCount,true);
 			$empHash = array();
 			foreach($CurCount as $rec1){
                                $rec=array_change_key_case($rec1, CASE_UPPER);
				$empID = $rec['ETO_LEAP_EMP_ID'];
				$empHash[$empID]["TTL_DELETED"] =$rec["TTL_DELETED"];
				$empHash[$empID]["TTL_NT_FLAGGED"] =$rec["TTL_NT_FLAGGED"];
                                $empHash[$empID]["TTL_AUTO_FLAGGED"] =$rec["TTL_AUTO_FLAGGED"];
				$empHash[$empID]["ETO_LEAP_AGENT_NAME"] =$rec["ETO_LEAP_AGENT_NAME"];
				$empHash[$empID]["ETO_LEAP_TL_NAME"] = $rec["ETO_LEAP_TL_NAME"];
				$empHash[$empID]["ETO_LEAP_AGENT_JOINING_DATE"] =!empty($rec["ETO_LEAP_AGENT_JOINING_DATE"])?$rec["ETO_LEAP_AGENT_JOINING_DATE"]:'NA';
			}
 			foreach($AppCount as $row){ 		
                                $rec=array_change_key_case($row, CASE_UPPER);
 				$empID = $rec['ETO_LEAP_EMP_ID'];
				$empHash[$empID]["TTL_APPROVAL"] =$rec["TTL_APPROVAL"];
				$empHash[$empID]["TTL_CALL_APPROVED"] =$rec["TTL_CALL_APPROVED"];
				$empHash[$empID]["TTL_DO_NOT_CALL"] =$rec["TTL_DO_NOT_CALL"];
                                $empHash[$empID]["TTL_DNC_FOREIGN"] =$rec["TTL_DNC_FOREIGN"];
                                if(isset($rec["TTL_LEAP"])){
                                    $empHash[$empID]["TTL_LEAP"] =$rec["TTL_LEAP"];
                                }else{
                                    $empHash[$empID]["TTL_LEAP"] =0;
                                }
                                if(isset($rec["TTL_INTENT"])){
                                    $empHash[$empID]["TTL_INTENT"] =$rec["TTL_INTENT"];
                                }else{
                                    $empHash[$empID]["TTL_INTENT"] =0;
                                }
                                
				$empHash[$empID]["APPROVED_12_MORE"] =$rec["APPROVED_12_MORE"];
				$empHash[$empID]["APPROVED_24_MORE"] =$rec["APPROVED_24_MORE"];
			}
 			foreach($AhtCount as $row)
			{
                                $rec=array_change_key_case($row, CASE_UPPER);
				$empID = $rec['ETO_LEAP_EMP_ID'];
				$tempAHT = !empty($rec['AHT'])? $rec['AHT']:'00:00:00';
				$empHash[$empID]["TEMP_AHT"] = $tempAHT;
				$empHash[$empID]["AHT"] = $this->findAHT($tempAHT);
			}		
        $obj = new Globalconnection();	
        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                $dbh = $obj->connect_db_oci('postgress_web77v');
        }else{                        
                $dbh = $obj->connect_db_oci('postgress_web68v');
        }
			
	//$dbh=pg_connect("host=192.170.156.68 port=5432 dbname=imbuyreq user=gladmin password=gladmin4iil") or die('cant connnect to postgresql: '. pg_last_error());		
	foreach($empHash as $empID => $empR)
                {		
		$empHash[$empID]["AHT"] = !empty($empHash[$empID]["AHT"])?$empHash[$empID]["AHT"]:'00:00:00';
		$empHash[$empID]["TEMP_AHT"] = !empty($empHash[$empID]["TEMP_AHT"])?$empHash[$empID]["TEMP_AHT"]:0;
		if(empty($empHash[$empID]["ETO_LEAP_AGENT_NAME"]))
                {
                        $agentNameSql = "SELECT
                        A.*,
                        (SELECT ETO_LEAP_AGENT_NAME FROM ETO_LEAP_MIS_INTERIM WHERE ETO_LEAP_EMP_ID = A.ETO_LEAP_TL_ID) ETO_LEAP_TL_NAME
                        from (
                        SELECT
                        ETO_LEAP_AGENT_NAME,
                        to_char(ETO_LEAP_AGENT_JOINING_DATE,'DD-MON-YY') ETO_LEAP_AGENT_JOINING_DATE,
                        ETO_LEAP_TL_ID
                        FROM ETO_LEAP_MIS_INTERIM WHERE ETO_LEAP_EMP_ID = $1
                        ) A";
                       
                        $params=array($empID);
                        $sth=pg_query_params($dbh,$agentNameSql,$params);                                       
                        $rec_emp=pg_fetch_array($sth);
                        $rec_emp=array_change_key_case($rec_emp, CASE_UPPER);
                        $empHash[$empID]["ETO_LEAP_AGENT_NAME"] =!empty($rec_emp["ETO_LEAP_AGENT_NAME"])?$rec_emp["ETO_LEAP_AGENT_NAME"]:'';
                        $empHash[$empID]["ETO_LEAP_TL_NAME"] =!empty($rec_emp["ETO_LEAP_TL_NAME"])?$rec_emp["ETO_LEAP_TL_NAME"]:''; 
                        $empHash[$empID]["ETO_LEAP_AGENT_JOINING_DATE"] =!empty($rec_emp["ETO_LEAP_AGENT_JOINING_DATE"])?$rec_emp["ETO_LEAP_AGENT_JOINING_DATE"]:'NA';
                }
		
		$empHash[$empID]["TTL_APPROVAL"]= !empty($empHash[$empID]["TTL_APPROVAL"])?$empHash[$empID]["TTL_APPROVAL"]:0;
		$empHash[$empID]["TTL_CALL_APPROVED"]= !empty($empHash[$empID]["TTL_CALL_APPROVED"])?$empHash[$empID]["TTL_CALL_APPROVED"]:0;
		$empHash[$empID]["TTL_DO_NOT_CALL"]= !empty($empHash[$empID]["TTL_DO_NOT_CALL"])?$empHash[$empID]["TTL_DO_NOT_CALL"]:0;
                $empHash[$empID]["TTL_DNC_FOREIGN"]= !empty($empHash[$empID]["TTL_DNC_FOREIGN"])?$empHash[$empID]["TTL_DNC_FOREIGN"]:0;
                $empHash[$empID]["TTL_INTENT"]= !empty($empHash[$empID]["TTL_INTENT"])?$empHash[$empID]["TTL_INTENT"]:0;
                $empHash[$empID]["TTL_LEAP"]= !empty($empHash[$empID]["TTL_LEAP"])?$empHash[$empID]["TTL_LEAP"]:0;                
                $empHash[$empID]["TTL_DELETED"]= !empty($empHash[$empID]["TTL_DELETED"])?$empHash[$empID]["TTL_DELETED"]:0;
		$empHash[$empID]["TTL_WORKED"] = $empHash[$empID]["TTL_APPROVAL"]+$empHash[$empID]["TTL_DELETED"];
		$empHash[$empID]["APPROVAL_PR"] = $this->findPercnt($empHash[$empID]["TTL_APPROVAL"],$empHash[$empID]["TTL_WORKED"]);
		$empHash[$empID]["APPROVED_12_MORE"]= !empty($empHash[$empID]["APPROVED_12_MORE"])?$empHash[$empID]["APPROVED_12_MORE"]:0;
		$empHash[$empID]["APPROVED_24_MORE"]= !empty($empHash[$empID]["APPROVED_24_MORE"])?$empHash[$empID]["APPROVED_24_MORE"]:0;
	}
	$colwidth ="55px";	$colwidth1 = "60px";	$cssClass = "$start_date";
	if($start_date != $end_date)
	{
		$cssClass = "$start_date - $end_date";
	}
					$cssClass .= "-$vendor";
				$html = '';
				$html .= '
				<div>
				<input type="hidden" value="'.$cssClass.'" name="startdt" id="startdt">
				<table border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1300px" >
				<tr id="trid">	
				<td class="intd" bgcolor="#dff8ff" width="65"><b>TL Name</b></td>
				<td class="intd" bgcolor="#dff8ff" width="65"><b>Emp ID</b></td>
				<td class="intd" bgcolor="#dff8ff" width="65"><b>Emp Name</b></td>
				<td class="intd" bgcolor="#dff8ff" width="65"><b>On Floor Date</b></td>
				<td class="intd" bgcolor="#dff8ff" width="55"><b>Deleted </b></td>
				<td class="intd" bgcolor="#dff8ff" width="60"><b>Approved </b></td>
				<td class="intd" bgcolor="#dff8ff" width="65"><b>Call</b></td>
				<td class="intd" bgcolor="#dff8ff" width="65"><b>DNC</b></td>
                                <td class="intd" bgcolor="#dff8ff" width="65"><b>Foreign</b></td>
                                <td class="intd" bgcolor="#dff8ff" width="65"><b>Intent</b></td>
                                <td class="intd" bgcolor="#dff8ff" width="65"><b>Leap MODID</b></td>                                
				<td class="intd" bgcolor="#dff8ff" width="70"><b>NT Manual</b></td>
                                 <td class="intd" bgcolor="#dff8ff" width="70"><b>NT Auto</b></td><td class="intd" bgcolor="#dff8ff" width="55"><b>Approval %</b></td>				
				<td class="intd" bgcolor="#dff8ff" width="55"><b>AHT </b></td>
				</tr>
				<tbody>';
				foreach($empHash as $empK => $empR) {					
                                        $nt=isset($empR["TTL_NT_FLAGGED"])?$empR["TTL_NT_FLAGGED"]:'0';
                                        $auto=isset($empR["TTL_AUTO_FLAGGED"])?$empR["TTL_AUTO_FLAGGED"]:'0';
					$html .= "
					 <tr>
					<td class='intd'   width='$colwidth1'>".$empR['ETO_LEAP_TL_NAME']."</td>
					<td class='intd'   width='$colwidth1'>$empK</td>
					<td class='intd'   width='$colwidth1'>".$empR['ETO_LEAP_AGENT_NAME']."</a></td>
					<td class='intd'   width='$colwidth1'>".$empR['ETO_LEAP_AGENT_JOINING_DATE']."</td>
					<td class='intd' 	 width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=empwisedd&start_date=$start_date&end_date=$end_date&vendor=$vendor&source=$source&employeeID=$empK&in_flag=4&start_time=$start_time&end_time=$end_time&total_records=".$empR['TTL_DELETED']."'>".$empR['TTL_DELETED']." </a></td>
					<td class='intd'   width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=empwisead&start_date=$start_date&end_date=$end_date&vendor=$vendor&source=$source&employeeID=$empK&in_flag=5&start_time=$start_time&end_time=$end_time&total_records=".$empR['TTL_APPROVAL']."'>
					".$empR['TTL_APPROVAL']."</a><input type='hidden' value='".$empR['TTL_APPROVAL']."' class='$cssClass' name='empapproved'></td>
					
					<td class='intd'   width='$colwidth1'>".$empR["TTL_CALL_APPROVED"]."</td>
					<td class='intd'   width='$colwidth1'>".$empR["TTL_DO_NOT_CALL"]."</td>
                                        <td class='intd'   width='$colwidth1'>".$empR["TTL_DNC_FOREIGN"]."</td>    
                                        <td class='intd'   width='$colwidth1'>".$empR["TTL_INTENT"]."</td>    
                                        <td class='intd'   width='$colwidth1'>".$empR["TTL_LEAP"]."</td>                                          
                                        <td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/ntdashboard&mid=3443&start_date=$start_date&end_date=$end_date&vendor=$vendor&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&employeeID=$empK&total_records=$nt'>$nt</a>
					 </td>                
					 <td class='intd' style='text-align:center;'  width='$colwidth'>
					<a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/autodashboard&mid=3443&start_date=$start_date&end_date=$end_date&vendor=$vendor&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&employeeID=$empK&total_records=$auto'>$auto</a>
					 </td>
					<td class='intd'   width='$colwidth'>".$empR['APPROVAL_PR']."<input type='hidden' value='".$empR["APPROVAL_PR"]."' class='$cssClass' name='empApprovalPR'></td>
					
					<td class='intd'   width='$colwidth'>".$empR["AHT"]."
					<input type='hidden' value='".$empR["TEMP_AHT"]."' class='$cssClass' name='empAHT'></td>
					</tr>";
				}
				$html .= '</tbody></table></div>';
				echo $html;
				
  }  
 public function empWiseDetail_oap($request,$vendorArr) {
		$errArr=array();
		$empHash=array();
                
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$start_time = $request->getParam('start_time',0);
		$end_time = $request->getParam('end_time',24);
		$strt1 = strtotime($start_date);
		$end1 = strtotime($end_date);
		$today = strtotime(date("d-M-Y"));
                
			$source = $request->getParam('source','A');			
                        $cntryArr = array('I' => 2,'F' => 3,'A' => 0);
                        $cntryFlag = isset($cntryArr[$source])?$cntryArr[$source]:0;
			$vendor = $request->getParam('vendor','ALL');
			$tlid = $request->getParam('tlid',0);			
			
			$sqlCondHash = array();
			$sqlCondHash['START_DATE'] = date("d-M-Y",strtotime($start_date));
			$sqlCondHash['END_DATE'] = date("d-M-Y",strtotime($end_date));
			$sqlCondHash['START_TIME'] = $start_time;
			$sqlCondHash['END_TIME'] = $end_time;
                        $recVendorAll=CommonVariable::get_active_vendor_list();
                        $vendor_ids='';
                        if($vendor<>'ALL'){
                        foreach($recVendorAll as $key => $value)
                        {
                            if($vendor == $value)
                            {
                                $vendor_ids = "'". $key."'";
                            }
                        } 
                        }
			$sqlCondHash['VENDOR_NAME_ARR_PARAM'] = $vendor;
                        $sqlCondHash['IN_VENDOR_IDS'] =$vendor_ids;
			$returnCurArr = $this->getTotalAssigned($sqlCondHash,$request);
			$sthCurCount = $returnCurArr['cursorCnt'];
 			$sthAppCount = $returnCurArr['appCnt'];
 			$CurCount=json_decode($sthCurCount,true);
                        $AppCount=json_decode($sthAppCount,true);
 			$empHash = array();
 			foreach($CurCount as $rec1){
                                $rec=array_change_key_case($rec1, CASE_UPPER);
				$empID = $rec['ETO_LEAP_EMP_ID'];
				$empHash[$empID]["TTL_DELETED"] =$rec["TTL_DELETED"];
				$empHash[$empID]["TTL_NT_FLAGGED"] =$rec["TTL_NT_FLAGGED"];
                                $empHash[$empID]["TTL_AUTO_FLAGGED"] =$rec["TTL_AUTO_FLAGGED"];
				$empHash[$empID]["ETO_LEAP_AGENT_NAME"] =$rec["ETO_LEAP_AGENT_NAME"];
				$empHash[$empID]["ETO_LEAP_TL_NAME"] = $rec["ETO_LEAP_TL_NAME"];
				$empHash[$empID]["ETO_LEAP_AGENT_JOINING_DATE"] =!empty($rec["ETO_LEAP_AGENT_JOINING_DATE"])?$rec["ETO_LEAP_AGENT_JOINING_DATE"]:'NA';
			}
 			foreach($AppCount as $row){ 		
                                $rec=array_change_key_case($row, CASE_UPPER);
 				$empID = $rec['ETO_LEAP_EMP_ID'];
				$empHash[$empID]["TTL_APPROVAL"] =$rec["TTL_APPROVAL"];
				$empHash[$empID]["TTL_CALL_APPROVED"] =$rec["TTL_CALL_APPROVED"];                                
				$empHash[$empID]["APPROVED_12_MORE"] =$rec["APPROVED_12_MORE"];
				$empHash[$empID]["APPROVED_24_MORE"] =$rec["APPROVED_24_MORE"];
			}
                        // COnnectc2c 
                           $obj = new Globalconnection();
						   $dbh = $obj->connect_db_yii('postgress_web68v'); 
                            $model = new GlobalmodelForm();
                            $loginemp="select fk_employee_id, sum((date_part('hour', leap_crm_logout_time-leap_crm_login_time)*60*60 + 
                                date_part('minute', leap_crm_logout_time-leap_crm_login_time)*60+date_part('second', leap_crm_logout_time-leap_crm_login_time))
                                )   loginhour from leap_login_activity_stats 
                                where date(leap_crm_login_time) = TO_DATE('$start_date','DD-MON-YYYY') "
                                    . " And leap_vendor_name='$vendor' 
                            group by fk_employee_id ";
		                $sthl = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $loginemp,array());
                while($temp=$sthl->read())
		{           
                    $empID=$temp['fk_employee_id'];
					if (array_key_exists($empID,$empHash)){
                    if($empHash[$empID]){
                    $empHash[$empID]["LOGINHOUR"]=$temp["loginhour"];
                    }
				      }
                }  
                          $agentSql = "Select fk_eto_leap_emp_id, total_payout,extract(day from now()- ETO_LEAP_AGENT_JOINING_DATE) aon,ETO_LEAP_AGENT_NAME,"
                                  . "to_char(ETO_LEAP_AGENT_JOINING_DATE,'DD-MON-YY') ETO_LEAP_AGENT_JOINING_DATE,
                        ETO_LEAP_TL_ID  from "
                                 . "leap_vendor_work_stats,eto_leap_mis_interim where fk_eto_leap_emp_id=eto_leap_emp_id and eto_leap_vendor_name='$vendor' "
                                . " and date(entered_on) = TO_DATE('$end_date','DD-MON-YYYY') "
                                . "and worked_leads_count > 0 order by fk_eto_leap_emp_id";
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $agentSql,array());
       
                while($temp=$sth->read())
		{
                        $empID=isset($temp['fk_eto_leap_emp_id'])? $temp['fk_eto_leap_emp_id'] :'';
                        $empHash[$empID]["TOTAL_PAYOUT"] =$temp["total_payout"];
                        $empHash[$empID]["AON"] =$temp["aon"];
                        if(empty($empHash[$empID]["ETO_LEAP_AGENT_NAME"]))
                        {
                          $empHash[$empID]["ETO_LEAP_AGENT_NAME"]= $temp["eto_leap_agent_name"];
                          $empHash[$empID]["ETO_LEAP_AGENT_JOINING_DATE"]= $temp["eto_leap_agent_joining_date"];
                          $empHash[$empID]["ETO_LEAP_TL_NAME"] = isset($rec["eto_leap_tl_id"])?$rec["eto_leap_tl_id"]:'';
                        }
                }
          // echo '<pre>'; print_r($empHash);  
                /// end connect c2c
        foreach($empHash as $empID => $empR)
                {       
		$empHash[$empID]["TTL_APPROVAL"]= !empty($empHash[$empID]["TTL_APPROVAL"])?$empHash[$empID]["TTL_APPROVAL"]:0;
		$empHash[$empID]["TTL_CALL_APPROVED"]= !empty($empHash[$empID]["TTL_CALL_APPROVED"])?$empHash[$empID]["TTL_CALL_APPROVED"]:0;
		$empHash[$empID]["TTL_DO_NOT_CALL"]= !empty($empHash[$empID]["TTL_DO_NOT_CALL"])?$empHash[$empID]["TTL_DO_NOT_CALL"]:0;
                $empHash[$empID]["TTL_DNC_FOREIGN"]= !empty($empHash[$empID]["TTL_DNC_FOREIGN"])?$empHash[$empID]["TTL_DNC_FOREIGN"]:0;
                $empHash[$empID]["TTL_INTENT"]= !empty($empHash[$empID]["TTL_INTENT"])?$empHash[$empID]["TTL_INTENT"]:0;
                $empHash[$empID]["TTL_LEAP"]= !empty($empHash[$empID]["TTL_LEAP"])?$empHash[$empID]["TTL_LEAP"]:0;                
                $empHash[$empID]["TTL_DELETED"]= !empty($empHash[$empID]["TTL_DELETED"])?$empHash[$empID]["TTL_DELETED"]:0;
		$empHash[$empID]["TTL_WORKED"] = $empHash[$empID]["TTL_APPROVAL"]+$empHash[$empID]["TTL_DELETED"];
		$empHash[$empID]["APPROVAL_PR"] = $this->findPercnt($empHash[$empID]["TTL_APPROVAL"],$empHash[$empID]["TTL_WORKED"]);
		$empHash[$empID]["APPROVED_12_MORE"]= !empty($empHash[$empID]["APPROVED_12_MORE"])?$empHash[$empID]["APPROVED_12_MORE"]:0;
		$empHash[$empID]["APPROVED_24_MORE"]= !empty($empHash[$empID]["APPROVED_24_MORE"])?$empHash[$empID]["APPROVED_24_MORE"]:0;
                $empHash[$empID]["LOGINHOUR"]= !empty($empHash[$empID]["LOGINHOUR"])?$empHash[$empID]["LOGINHOUR"]:0;
		$empHash[$empID]["TOTAL_PAYOUT"]= !empty($empHash[$empID]["TOTAL_PAYOUT"])?$empHash[$empID]["TOTAL_PAYOUT"]:0;
                $empHash[$empID]["AON"]= !empty($empHash[$empID]["AON"])?$empHash[$empID]["AON"]:0;
	}
        
$print_data="Tenurity\t Emp Name\t Emp ID\t TL Name\t Approval\t Deleted\t Call Back Later (NT Manual)\t Not Connected (NT Auto)\t Worked\t Approval%\t Login Hours\t Leads worked per hour\t Payout\t Connectivity\t Call Back Later %\t \n";
$filepath_download = $_SERVER['DOCUMENT_ROOT'];
$filepath_download .=  '/gl_global_upload/';
$emp_id=Yii::app()->session['empid'];
$timestamp=$emp_id."-".date("F-j-Y")."-".time();
$filename_return="Audit_Sample_$timestamp.xls";
$file_return = $filepath_download.$filename_return;
$FILE = fopen($file_return, "w");
fwrite($FILE, $print_data);


				$html = $rowtotal_payout=$rowtotal_app=$rowtotal_del =$rowtotal_nt =$rowtotal_auto =$rowtotal_login_hour=$rowtotal_worked='';
				foreach($empHash as $empK => $empR) {
                                        $nt=isset($empR["TTL_NT_FLAGGED"])?$empR["TTL_NT_FLAGGED"]:'0';
                                        $auto=isset($empR["TTL_AUTO_FLAGGED"])?$empR["TTL_AUTO_FLAGGED"]:'0';
                                        $worked=$nt + $auto + $empR['TTL_APPROVAL'] + $empR['TTL_DELETED'];
                                        $login_hour=$empR["LOGINHOUR"];
                                        $log_h=$leadworked='';
                                        if($login_hour>0){
                                            $hours = floor($login_hour / 3600);
                                            if($hours>0 && $hours<10){$hours="0".$hours;}

                                            $minutes = floor(($login_hour / 60) % 60);
                                            if($minutes>0 && $minutes<10){$minutes="0".$minutes;}

                                            $seconds = $login_hour % 60;
                                            if($seconds>0 && $seconds<10){$seconds="0".$seconds;}
                                            $log_h= "$hours:$minutes:$seconds";
                                              
                                            if($worked > 0 && $login_hour>0){
                                                $leadworked=round((($worked * 3600)/($login_hour)),2);
                                            }
                                        }
                                      
                                        $connectivity=(($nt + $empR['TTL_APPROVAL'] + $empR['TTL_DELETED'] ) /$worked ) *100;
                                        $callbacklater=($nt / $worked) * 100;
										 
                                        $AON=$empR['AON'];
                                        $TL_NAME=$empR['ETO_LEAP_TL_NAME'];
                                        $AGENT_NAME=$empR['ETO_LEAP_AGENT_NAME'];
                                        $del=$empR['TTL_DELETED'];
                                        $app=$empR['TTL_APPROVAL']; 
									
                                        $app_per=round((($app/$worked)*100),2);
										
                                        $rowtotal_payout=$rowtotal_payout + $empR["TOTAL_PAYOUT"];
                                        fwrite($FILE, $AON."\t ".$AGENT_NAME."\t ".$empK."\t ".$TL_NAME."\t ".$app." \t ".$del."\t ".$nt."\t ".$auto."\t ".
                                                $worked."\t ".$app_per."\t ".$log_h."\t ".$leadworked."\t ".$empR["TOTAL_PAYOUT"]."\t "
                                                . "".round($connectivity,2)."\t ".round($callbacklater,2)."\t \n");

					$html .= "<tr><td>".$empR['AON']."</td><td>".$AGENT_NAME."</td><td>".$empK."</td>
					<td>".$empR['ETO_LEAP_TL_NAME']."</td><td>
					<a target='_blank' style='text-decoration:none;color:#0000ff' 
                                        href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=empwisead&start_date=$start_date&end_date=$end_date&vendor=$vendor&source=$source&employeeID=$empK&in_flag=5&start_time=$start_time&end_time=$end_time&total_records=".$empR['TTL_APPROVAL']."'>".$empR['TTL_APPROVAL']." </a></td>
					<td><a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=empwisedd&start_date=$start_date&end_date=$end_date&vendor=$vendor&source=$source&employeeID=$empK&in_flag=4&start_time=$start_time&end_time=$end_time&total_records=".$empR['TTL_DELETED']."'>
					".$empR['TTL_DELETED']."</a></td>
					<td><a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/ntdashboard&mid=3443&start_date=$start_date&end_date=$end_date&vendor=$vendor&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&employeeID=$empK&total_records=$nt'>$nt</a>
					 </td><td><a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/autodashboard&mid=3443&start_date=$start_date&end_date=$end_date&vendor=$vendor&in_flag=3&source=$source&start_time=$start_time&end_time=$end_time&employeeID=$empK&total_records=$auto'>$auto</a>
					 </td><td >".$worked."</td><td>".$app_per."</td><td>".$log_h."</td><td>".$leadworked."</td>
                                         <td>".$empR["TOTAL_PAYOUT"]."</td><td>".round($connectivity,2)."</td><td>".round($callbacklater,2)."</td></tr>";
                                        $rowtotal_app = $rowtotal_app + $app;
                                        $rowtotal_del = $rowtotal_del + $del;
                                        $rowtotal_nt = $rowtotal_nt + $nt;
                                        $rowtotal_auto = $rowtotal_auto + $auto;
                                        $rowtotal_login_hour = $rowtotal_login_hour + $login_hour;
                                        $rowtotal_worked=$rowtotal_worked + $worked;
				}
                                fclose($FILE); 
                                $rowtotal_app_per=round((($rowtotal_app/$rowtotal_worked)*100),2);

                                $rowtotal_connectivity=round(((($rowtotal_app + $rowtotal_del + $rowtotal_nt + $rowtotal_auto ) /$rowtotal_worked ) *100),2);
                                $rowtotal_callbacklater=round((($rowtotal_nt / $rowtotal_worked) * 100),2);
                                $rowtotal_log_h='';
                                        if($rowtotal_login_hour>0){
                                            $hours = floor($rowtotal_login_hour / 3600);
                                            if($hours>0 && $hours<10){$hours="0".$hours;}

                                            $minutes = floor(($rowtotal_login_hour / 60) % 60);
                                            if($minutes>0 && $minutes<10){$minutes="0".$minutes;}

                                            $seconds = $rowtotal_login_hour % 60;
                                            if($seconds>0 && $seconds<10){$seconds="0".$seconds;}
                                            $rowtotal_log_h= "$hours:$minutes:$seconds";

                                            if($rowtotal_worked > 0){
                                                $rowtotal_leadworked=round((($rowtotal_worked * 3600)/($rowtotal_login_hour)),2);
                                            }
                                        }
                                        
                                        $html .= "<tr><td colspan='4' bgcolor='#dff8ff'><b>Summary</b></td><td bgcolor='#dff8ff'>".$rowtotal_app."</td>
					<td bgcolor='#dff8ff'>".$rowtotal_del."</td>
					<td bgcolor='#dff8ff'>".$rowtotal_nt."</td><td bgcolor='#dff8ff'>$rowtotal_auto</td>"
                                                . "<td bgcolor='#dff8ff'>".$rowtotal_worked."</td><td bgcolor='#dff8ff'>".$rowtotal_app_per."</td>"
                                                . "<td bgcolor='#dff8ff'>".$rowtotal_log_h."</td><td bgcolor='#dff8ff'>".$rowtotal_leadworked."</td>
                                         <td bgcolor='#dff8ff'>".$rowtotal_payout."</td><td bgcolor='#dff8ff'>".$rowtotal_connectivity."</td>"
                                                . "<td bgcolor='#dff8ff'>".$rowtotal_callbacklater."</td></tr>";
				

				echo '<div style="padding:4px;font-weight:bold;text-align:center;"><a href="/gl_global_upload/'.$filename_return.'">Click to Download</a></div>
				<table border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1300px" >
				<tr>	
				<td  bgcolor="#dff8ff" width="65"><b>Tenurity</b></td>                                
				<td  bgcolor="#dff8ff" width="65"><b>Emp Name</b></td>
                                <td  bgcolor="#dff8ff" width="65"><b>Emp ID</b></td>
                                <td  bgcolor="#dff8ff" width="65"><b>TL Name</b></td>
				<td  bgcolor="#dff8ff" width="55"><b>Approved </b></td>
				<td  bgcolor="#dff8ff" width="60"><b>Deleted </b></td>
				<td  bgcolor="#dff8ff" width="70"><b>Call Back Later (NT Manual)</b></td>
                                <td  bgcolor="#dff8ff" width="70"><b>Not Connected (NT Auto)</b></td>
                                 <td  bgcolor="#dff8ff" width="55"><b>Worked</b></td>
                                 <td  bgcolor="#dff8ff" width="55"><b>Approval %</b></td>				
				<td  bgcolor="#dff8ff" width="55"><b>Login Hours </b></td>
				<td  bgcolor="#dff8ff" width="55"><b>Leads worked per hour </b></td>
                                <td  bgcolor="#dff8ff" width="55"><b>Payout</b></td>
                                <td  bgcolor="#dff8ff" width="55"><b>Connectivity</b></td>
                                <td bgcolor="#dff8ff" width="55"><b>Call Back Later %</b></td></tr>
				<tbody>'.$html.'</tbody></table>';
                                
  }

	public function empWiseDeletionDump($request,$vendorArr) {
  		$obj = new Globalconnection();
		  $dbh=$obj->connect_db_oci('postgress_web68v');	
		$start = $request->getParam('start',1);
		$end = $request->getParam('end',5000);
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$modid = $request->getParam('modid','');
		$source = $request->getParam('source','A');
		$vendor = $request->getParam('vendor','ALL');
		$start_time=$request->getParam('start_time',0);
		$end_time=$request->getParam('end_time',24);
		$employeeID = $request->getParam('employeeID',0);
		$tlid = $request->getParam('tlid',0);
		$in_flag = $request->getParam('in_flag',0);
		$totalRecords = intval($request->getParam('total_records'));
                
		$numOfPages = ($totalRecords / 5000) + 1;
		
		$params = array();
		$params['START_DATE'] = date("d-M-Y",strtotime($start_date));
		$params['END_DATE'] = date("d-M-Y",strtotime($end_date));
		$params['START_TIME'] = $start_time;
		$params['END_TIME'] = $end_time;
		$params['VENDOR_NAME_ARR_PARAM'] = $vendor;
		$params['START_LIMIT'] = $start;
		$params['END_LIMIT'] = $end;
		$params['EMP_ID'] = $employeeID;
		$params['IN_FLAG'] = $in_flag;
		
		$returnCurArr = $this->getTotalAssigned($dbh,$params,$request);
                $sth_empwise = $returnCurArr['empwise'];
 		$empwise=json_decode($sth_empwise,true);
		$colwid = "6%";
		$recordingurl=  "NA";
		$tempDelAHT= 0;
		$sr_no=$delAHT = 0;$html = '';
                foreach($empwise as $rec1){  
                    $rec=array_change_key_case($rec1, CASE_UPPER);	
                    if($sr_no<=100){
				$recordingurl=  "NA";
				if($rec['ETO_OFR_CALL_RECORDING_URL'] && $rec['ETO_OFR_CALL_RECORDING_URL'] != 'NA')
				{
					$recordingurl = '<a href="'.$rec['ETO_OFR_CALL_RECORDING_URL'].'" target="_new">Primary</a>';
				}
				$html .= "<tr>
                                        <td  style='text-align:center;' width='20px'>".$sr_no."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['OFR_ID']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['SOURCE']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['ETO_LEAP_EMP_ID']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['DELETEDBY']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['FK_GLUSR_USR_ID']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['GLUSR_USR_PH_MOBILE']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['GLUSR_USR_PH_MOBILE_ALT']."</td>
                                       
					<td  style='text-align:center;'  width='$colwid'>".$rec['QUERY_LOCK_DATE']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['ETO_OFR_DELETIONDATE']."</td>";
				$tempDelAHT = !empty($rec['TIME_TAKEN_IN_MINUTE'])?$rec['TIME_TAKEN_IN_MINUTE']:0;
				$delAHT = $this->findAHT($tempDelAHT);
				$html .= "<td  style='text-align:center;'  width='$colwid'>$delAHT</td>";
	
				$html .= "<td  style='text-align:center;'  width='$colwid'>".$rec['DEL_FLAG']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['SOURCE_FLAG']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['FK_GL_COUNTRY_ISO']."</td>
					<td  style='text-align:center;'  width='$colwid'>".$rec['DEL_REASON']."</td>
					<td  style='text-align:center;'  width='14%'>".$rec['ETO_OFR_DESC']."</td>
					<td  style='text-align:center;'  width='$colwid'>$recordingurl</td>				
                                        <td  style='text-align:center;'  width='$colwid'>".$rec['POSTDATE']."</td>    
                                        <td  style='text-align:center;'  width='$colwid'>".$rec['DIR_QUERY_FREE_REFID']."</td> 
					</tr>";
                            }
                          $sr_no++;     
			}	
			$reArr = array(
				'start_date' => $start_date,			
				'end_date' => $end_date,			
				'vendor' => $vendor,			
				'source' => $source,			
				'employeeID' => $employeeID,
                                'tlid' => $tlid,
				'start_time' => $start_time,			
				'end_time' => $end_time,			
				'html' => $html,			
				'start' => $start,			
				'end' => $end,			
				'totalRecords' => $totalRecords,
				'in_flag' => $in_flag,
			);
			return $reArr;
		}
		
		public function empWiseApprovalDump($request,$vendorArr){ 
			$rec = array();
			$obj = new Globalconnection();
			$dbh=$obj->connect_db_oci('postgress_web68v');	
			$start = $request->getParam('start',1);
			$end = $request->getParam('end',5000);
			$start_date = $request->getParam('start_date','');
			$end_date = $request->getParam('end_date','');
			$modid = $request->getParam('modid','');
			$source = $request->getParam('source','A');
			$vendor = $request->getParam('vendor','ALL');
			$start_time=$request->getParam('start_time',0);
			$end_time=$request->getParam('end_time',24);
			$employeeID = $request->getParam('employeeID',0);
			$tlid = $request->getParam('tlid',0);
			$in_flag = $request->getParam('in_flag',0);
			
			$totalRecords = intval($request->getParam('total_records'));
			$limit = 5000;
			$numOfPages = ($totalRecords / $limit) + 1;
			$params = array();
			$params['START_DATE'] = date("d-M-Y",strtotime($start_date));
			$params['END_DATE'] = date("d-M-Y",strtotime($end_date));
			$params['START_TIME'] = $start_time;
			$params['END_TIME'] = $end_time;
			$params['VENDOR_NAME_ARR_PARAM'] = $vendor;
			$params['START_LIMIT'] = $start;
			$params['END_LIMIT'] = $end;
			$params['EMP_ID'] = $employeeID;
			$params['IN_FLAG'] = $in_flag;
 		if(!empty($vendor))
 		{
			$returnCurArr = $this->getTotalAssigned($dbh,$params,$request);
			$sthEmpWiseApproval = $returnCurArr['empwiseapp'];
                        $EmpWiseApproval=json_decode($sthEmpWiseApproval,true);
                            foreach($EmpWiseApproval as $rec1){ 
                                $rect=array_change_key_case($rec1, CASE_UPPER);
				array_push($rec,$rect); 
			}
		}
		$reArr = array(
				'start_date' => $start_date,			
				'end_date' => $end_date,			
				'vendor' => $vendor,			
				'source' => $source,			
				'employeeID' => $employeeID,
                                'tlid' => $tlid,
				'start_time' => $start_time,			
				'end_time' => $end_time,			
				'rec' => $rec,			
				'start' => $start,			
				'end' => $end,			
				'totalRecords' => $totalRecords,
				'in_flag' => $in_flag,
			);
			return $reArr;
	}
	
	public function exportToExcelApp($request){
			$rec = array();
			$start = $request->getParam('start',1);
			$end = $request->getParam('end',5000);
			$start_date = $request->getParam('start_date','');
			$end_date = $request->getParam('end_date','');
			$modid = $request->getParam('modid','');
			$source = $request->getParam('source','A');
			$vendor = $request->getParam('vendor','ALL');
			$start_time=$request->getParam('start_time',0);
			$end_time=$request->getParam('end_time',24);
			$employeeID = $request->getParam('employeeID',0);
			$tlid = $request->getParam('tlid',0);
			$in_flag = $request->getParam('in_flag',0);
			$totalRecords = intval($request->getParam('total_records'));			
			
			$limit = 5000;
			$numOfPages = ($totalRecords / $limit) + 1;
			$params = array();
			$params['START_DATE'] = date("d-M-Y",strtotime($start_date));
			$params['END_DATE'] = date("d-M-Y",strtotime($end_date));
			$params['START_TIME'] = $start_time;
			$params['END_TIME'] = $end_time;
			$params['VENDOR_NAME_ARR_PARAM'] = $vendor;
			$params['START_LIMIT'] = $start;
			$params['END_LIMIT'] = $end;
			$params['EMP_ID'] = $employeeID;
			$params['IN_FLAG'] = $in_flag;
			
			$d1 = array("OFFER_ID","SOURCE","EMP ID","EMP NAME","GLUSR ID","GLUSR_MOBILE","APPROVAL REASON","OFFER TITLE","LEAD AHT(in min)","WORKING_DATE","GEN DATE","IP Address","Pool Type","Lead Type");
 			if(!empty($vendor)) {
				$returnCurArr = $this->getTotalAssigned($params,$request);//print_r($returnCurArr);
				$sthEmpWiseApproval = $returnCurArr['empwiseapp'];
                                $EmpWiseApproval=json_decode($sthEmpWiseApproval,true);
				$d2 = array();
				array_push($d2,$d1);
                                        foreach($EmpWiseApproval as $row1){
                                            $row=array_change_key_case($row1, CASE_UPPER);
                                        $tempaddAHT = !empty($row['LEAD_AHT'])?$row['LEAD_AHT']:0;
                                        $addAHT = $this->findAHT($tempaddAHT);
                                        $POSTDATE='';
                                        if($row['POSTDATE']){
                                            $POSTDATE=$row['POSTDATE'];
                                        }
                                        $pool_type='Must Call';
                                        $user_identifier='';
                                        if($row['USER_IDENTIFIER_FLAG']){
                                            $dnc_array=array(2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99);
                                            $must_array=array(26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59);
                                            $intent_array=array(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79);
                                            $user_identifier=$row['USER_IDENTIFIER_FLAG'];
                                            if(in_array($user_identifier,$dnc_array)){
                                                    $pool_type='DNC';
                                            }elseif(in_array($user_identifier,$must_array)){
                                                if($row['ETO_OFR_CALL_DISPOSITION_TYPE'] && $row['ETO_OFR_CALL_DISPOSITION_TYPE']=='Validated'){                                                    
                                                        $pool_type='Must Call';
                                                    }else{
                                                         $pool_type='DNC';
                                                    }
                                            }elseif($user_identifier==11 || $user_identifier==12){
                                                    $pool_type='Service';
                                            }elseif($user_identifier==13 || $user_identifier==15){
                                                    $pool_type='Procmart';                                                    
                                            }elseif(in_array($user_identifier,$intent_array)){
                                                    $pool_type='Intent';                                                     
                                            }
                                        }
                                        
                                        $lead_type='';
                                        if($row['ETO_ENQ_TYP'] && ($row['ETO_ENQ_TYP']==1 || $row['ETO_ENQ_TYP']==3 || $row['ETO_ENQ_TYP']==5)){
                                            $lead_type='Retail';
                                        }elseif($row['ETO_ENQ_TYP']){
                                             $lead_type='Non Retail';
                                        }
					$val = array(	$row['OFFER_ID'],
							$row['MODID'],
							$row['GL_EMP_ID'],
							$row['GL_EMP_NAME'],
							$row['GLUSR_USR'],
							$row['ETO_OFR_S_PH_MOBILE'],
							$row['CALL_APPROVAL_REASON'],
							$row['ETO_OFR_TITLE'],							
							$addAHT,
							$row['WORKING_DATE'],							
                                                        $POSTDATE,
                                                        $row['ETO_OFR_S_IP'],
                                                        $pool_type,
                                                        $lead_type
					);
					array_push($d2,$val);
				}
		        Yii::import('application.extensions.phpexcel.JPhpExcel');
        		$xls = new JPhpExcel('UTF-8', false, 'Approval Dump');
        		$xls->addArray($d2);
        		$xls->generateXML('Approval_Dump');
			}
		}
		
		public function exportToExcelDel($request) {
			$rec = array();
			$start = $request->getParam('start',1);
			$end = $request->getParam('end',5000);
			$start_date = $request->getParam('start_date','');
			$end_date = $request->getParam('end_date','');
			$modid = $request->getParam('modid','');
			$source = $request->getParam('source','A');
			$vendor = $request->getParam('vendor','ALL');
			$start_time=$request->getParam('start_time',0);
			$end_time=$request->getParam('end_time',24);
			$employeeID = $request->getParam('employeeID',0);
			$tlid = $request->getParam('tlid',0);
			$in_flag = $request->getParam('in_flag',0);
			
			$totalRecords = intval($request->getParam('total_records'));
			$strt1 = strtotime($start_date);
			$end1 = strtotime($end_date);
			$today = strtotime(date("d-M-Y"));
			
			$limit = 5000;
			$numOfPages = ($totalRecords / $limit) + 1;
			$params = array();
			$params['START_DATE'] = date("d-M-Y",strtotime($start_date));
			$params['END_DATE'] = date("d-M-Y",strtotime($end_date));
			$params['START_TIME'] = $start_time;
			$params['END_TIME'] = $end_time;
			$params['VENDOR_NAME_ARR_PARAM'] = $vendor;
			$params['START_LIMIT'] = $start;
			$params['END_LIMIT'] = $end;
			$params['EMP_ID'] = $employeeID;
			$params['IN_FLAG'] = $in_flag;
                      
                         $d1 = array("S.No.","OFFER_ID","SOURCE","EMP ID","EMP NAME","GLUSR ID","MOBILE 1","MOBILE 2","ASSIGN DATE","DELETION DATE","DELETION AHT","DEL FLAG","SOURCE FLAG","COUNTRY ISO","DEL REASON","OFR DESC","CALL RECORDING URL","GEN DATE","DIR_QUERY_FREE_REFID");
                       
                        if(!empty($vendor)) {
				$returnCurArr = $this->getTotalAssigned($params,$request);
				$sthEmpWiseApproval = $returnCurArr['empwise'];
                                $EmpWiseApproval=json_decode($sthEmpWiseApproval,true);
				$d2 = array();
				array_push($d2,$d1);				
                                    foreach($EmpWiseApproval as $rec1){    
                                        $row=array_change_key_case($rec1, CASE_UPPER);
                                        $tempDelAHT = !empty($row['TIME_TAKEN_IN_MINUTE'])?$row['TIME_TAKEN_IN_MINUTE']:0;
                                        $row['TIME_TAKEN_IN_MINUTE'] = $this->findAHT($tempDelAHT);
                                         $val = array(  $row['RN'],
                                                        $row['OFR_ID'],
                                                        $row['SOURCE'],
                                                        $row['ETO_LEAP_EMP_ID'],
                                                        $row['DELETEDBY'],
                                                        $row['FK_GLUSR_USR_ID'],
                                                        $row['GLUSR_USR_PH_MOBILE'],
                                                        $row['GLUSR_USR_PH_MOBILE_ALT'],   
                                                        $row['QUERY_LOCK_DATE'],
                                                        $row['ETO_OFR_DELETIONDATE'],                           
                                                        $row['TIME_TAKEN_IN_MINUTE'],
                                                        $row['DEL_FLAG'],
                                                        $row['SOURCE_FLAG'],
                                                        $row['FK_GL_COUNTRY_ISO'],
                                                        $row['DEL_REASON'],                                                      
                                                        $row['ETO_OFR_DESC'],
                                                        $row['ETO_OFR_CALL_RECORDING_URL'], 
                                                        $row['POSTDATE'],
                                                        $row['DIR_QUERY_FREE_REFID']
                                        );
					//$val = array_values($row);
					array_push($d2,$val);
				}
				Yii::import('application.extensions.phpexcel.JPhpExcel');
        		$xls = new JPhpExcel('UTF-8', false, 'Deletion Dump');
        		$xls->addArray($d2);
        		$xls->generateXML('Deletion_Dump');
			}
		}
		
	public function exportToExcelNT($request) {
			
			$vendor = $request->getParam('vendor','ALL');
			$params['VENDOR_NAME_ARR_PARAM'] = $vendor;
			$vendorArr='';
                        if(!empty($vendor)) {
				$d2 = $this->ntDump($request,$vendorArr,'EXL');				
				
			Yii::import('application.extensions.phpexcel.JPhpExcel');
        		$xls = new JPhpExcel('UTF-8', false, 'NT Dump');
        		$xls->addArray($d2);
        		$xls->generateXML('NT_Dump');
			}
		}
		
	public function exportToExcelAUTO($request) {			
			$vendor = $request->getParam('vendor','ALL');		
			$params['VENDOR_NAME_ARR_PARAM'] = $vendor;			
                        $vendorArr='';
                       if(!empty($vendor)) {
				$d2= $this->autoDump($request,$vendorArr);				
				Yii::import('application.extensions.phpexcel.JPhpExcel');
        		$xls = new JPhpExcel('UTF-8', false, 'AUTO Flagged Dump');
        		$xls->addArray($d2);
        		$xls->generateXML('auto_Dump');
			}
		}		
		
	public function displayAgentInfo($request,$vendorArr){
		$bind=$bindflagEmp=array();
		$vendor = $request->getParam('vendor','');
		$vCon =$vCon_status='';
		$start = $request->getParam('start',1);
		$end = $request->getParam('end',100);
		if(empty($start))
		{
		 $start=1;
		 $end=100;
		}
		
	if($vendor == 'ALL')
	{
		$vCon  ='';
	}
	else
	{
		$vCon =" AND ETO_LEAP_VENDOR_NAME = :VENDOR ";
	}
        
	$agentstatus = $request->getParam('agentstatus');
	if($agentstatus == 'Active' || $agentstatus == '')
	{
		$vCon_status =" AND ETO_LEAP_EMP_IS_ACTIVE = -1 ";
	}else if($agentstatus == 'Inactive')
	{
		$vCon_status =" AND ETO_LEAP_EMP_IS_ACTIVE = 0 ";
	}

$sql=$sth=$flagEmpSql=$flagEmpSth='';$tlhash=$qahash =$flagemphash =$rec = array();
$obj = new Globalconnection();
$model = new GlobalmodelForm();
$dbh=$obj->connect_db_yii('postgress_web68v');
if($dbh)
{
        $sql="SELECT TEMP.* from (
		      SELECT  
			ROW_NUMBER() over (ORDER BY ETO_LEAP_EMP_ID)RN,
			COUNT(*) OVER () RESULT_COUNT ,
			ETO_LEAP_EMP_ID,
			ETO_LEAP_EMP_NAME,
			ETO_LEAP_AGENT_NAME,
			ETO_LEAP_TL_ID,
			FK_LEAP_LOGIN_STATUS_ID,
			ETO_LEAP_QA_ID,
			ETO_LEAP_FLAG_EMP_ID,
			TO_CHAR(ETO_LEAP_AGENT_JOINING_DATE,'DD-MON-YYYY') ETO_LEAP_AGENT_JOINING_DATE,SHIFT_TIME,VENDOR_EMPLOYEE_ID 
		      FROM eto_leap_mis_interim
		      WHERE eto_leap_emp_id>0 $vCon $vCon_status
		      order by ETO_LEAP_EMP_ID asc
		      )TEMP
		      WHERE RN BETWEEN :IN_START_LIMIT AND :IN_END_LIMIT";
		
		$bind['IN_START_LIMIT']=$start; 
		$bind[':IN_END_LIMIT']=$end; 
		if($vCon != ''){
                    $bind[':VENDOR']=$vendor; 
		}
		
                $flagEmpSql = "select ETO_LEAP_EMP_ID,ETO_LEAP_AGENT_NAME,ETO_LEAP_EMP_LEVEL 
						from eto_leap_mis_interim
						where
						 ETO_LEAP_EMP_LEVEL in (1,2,3)
						$vCon
						order by ETO_LEAP_EMP_ID";
		if($vCon != ''){
                    $bindflagEmp[':VENDOR']=$vendor; 
		} 	
		
	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind); 
        $sth2 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $flagEmpSql, $bindflagEmp); 
        
        while($row = $sth->read()) {
                $rec1=array_change_key_case($row, CASE_UPPER);
		array_push($rec,$rec1);
	}
	  while($rec1 = $sth2->read()) 
            {
            $rec2=array_change_key_case($rec1, CASE_UPPER);
            if($rec2['ETO_LEAP_EMP_LEVEL']==3){
                $tempid = $rec2['ETO_LEAP_EMP_ID'];
		$qahash[$tempid] = $rec2['ETO_LEAP_AGENT_NAME'];
            }
            if($rec2['ETO_LEAP_EMP_LEVEL']==2){
                $tempid = $rec2['ETO_LEAP_EMP_ID'];
		$tlhash[$tempid] = $rec2['ETO_LEAP_AGENT_NAME'];
            }
             if($rec2['ETO_LEAP_EMP_LEVEL']==1 || $rec2['ETO_LEAP_EMP_LEVEL']==2){
                $tempid = $rec2['ETO_LEAP_EMP_ID'];
		$flagemphash[$tempid] = $rec2['ETO_LEAP_AGENT_NAME'];
            }		
	}	
    }
	
	$rec_pool=array();
	 $reArr = array('flagemphash' => $flagemphash,
					 'tlhash' => $tlhash,
                                         'qahash' => $qahash,
					 'rec' => $rec,
					  'rec_pool'=>$rec_pool,
					  'start'=>$start,
					  'end'=>$end
					 );				 
	 return $reArr;	
	}
        
        public function saveAgentName($request,$updatedById){	
		$emp_id = Yii::app()->session['empid'];
        $obj = new Globalconnection();              
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        $rec=array();
	if($dbh && $updatedById != '')
	{
		$agentIdArr = array();
		$agentids = $request->getParam('agentID');
		$agentIdArr = explode(',', $agentids);
		$sql ='';
		$i=0;
		$seen=array();
		$uniqueAgentIdArr = array_unique($agentIdArr);
		foreach($uniqueAgentIdArr as $k=>$agenID)
		{		
			$agentName = $request->getParam($agenID,'');
			$tlID = $request->getParam("tl$agenID",'');
			$qaID = $request->getParam("qa$agenID",0) ;
			$joining =isset($_REQUEST["joindate$agenID"])?$_REQUEST["joindate$agenID"]:'';
			$date1=DateTime::createFromFormat('d-M-Y', $joining);
			           if($date1){
                        $joiningdate=$date1->format('Ymd');
					   }
			$flagempid =  $request->getParam("flagemp$agenID",'');
			$pool =  $request->getParam("pool$agenID",'');
                       
                        $st1 = $request->getParam("st1$agenID",'');	
                        $st2= $request->getParam("st2$agenID",'');	
                        $shifttime = $st1 .'-'.$st2;	
                        $vendor_emp_id = $request->getParam("vendor_emp_id$agenID",'');   
                        
			if($agentName)
			{
			$i++;
			if($pool=='-999'){                        
                            $model = new GlobalmodelForm();
                                $sql_check="SELECT COUNT(1) TOTAL FROM DIR_QUERY_FREE WHERE FK_EMPLOYEEID = :agenID AND COALESCE(ETO_OFR_IS_FLAGGED,0)=20";
                                $bind[':agenID']=$agenID; 
				$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_check, $bind); 
                                while($rec1 = $sth->read()) {
                                        $rec=array_change_key_case($rec1, CASE_UPPER);  
                                        if(isset($rec['TOTAL']) && $rec['TOTAL']>0){                                           
                                            $succMsg = '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="60%" align="center">
                                            <tr><td class="intd" style="color:red;text-align:center;font-family: arial;font-size: 13px;background-color:#eeffff"> '.$rec['TOTAL'].' Leads are already Locked to Agent -'.$agenID.'. Please release all Leads then update.</td></tr>
                                            <tr><td class="intd" style="text-align:center;font-family: arial;font-size: 13px;background-color:#eeffff"><a href="/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443">Change here</a> to go on BL Dashboard</td></tr></table>
                                            ';
                                           if($emp_id==75532 ||$emp_id==3575  ){
                                                echo"<pre>";
                                                print_r($rec);
                                            }
                                            return $succMsg; 
                                        }                           
                                   }
                                   
	// Service Implementation WAPI
	$serv_model =new ServiceGlobalModelForm();
	$param['token']	='imobile1@15061981';
	$param['modid']	='GLADMIN';
	$param['action']	='Update';
	$param['ETO_LEAP_AGENT_NAME']	=$agentName;
	$param['ETO_LEAP_TL_ID']	=$tlID;
	$param['ETO_LEAP_QA_ID']	=$qaID;
	$param['ETO_LEAP_EMP_ID']	=$agenID;
	$param['ETO_LEAP_AGENT_JOINING_DATE']=$joiningdate;
	$param['ETO_LEAP_FLAG_EMP_ID']	=$flagempid;
	$param['ETO_LEAP_AGENT_CHANGED_BY']	=$updatedById;
	$param['SHIFT_TIME']	=$shifttime;
	$param['VENDOR_EMPLOYEE_ID']	=$vendor_emp_id;
        $param['FK_LEAP_LOGIN_STATUS_ID']	='';

	$host_name = $_SERVER['SERVER_NAME'];
	if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net'){
		$curl = 'http://stg-leads.imutils.com/wservce/glreport/elm/';
		}else{                        
		$curl = 'http://leads.imutils.com/wservce/glreport/elm/';
		}	  

	$response=$serv_model->mapiService('LEAPMIS',$curl,$param,'No');

	if($emp_id==75532 ||$emp_id==3575  ){
		echo"<pre>";
		print_r($param);
		echo"<pre>";
		print_r($response);
	}
	
	$code=isset($response["Response"]["Code"])?$response["Response"]["Code"]:'';
	$message=isset($response["Response"]["Message"])?$response["Response"]["Message"]:'';
	
                              if($code!=200){
                                  $succMsg = '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="60%" align="center">
                                    <tr><td class="intd" style="text-align:center;font-family: arial;font-size: 13px;background-color:#eeffff">Some Error Occured</td></tr>
                                    <tr><td class="intd" style="text-align:center;font-family: arial;font-size: 13px;background-color:#eeffff"><a href="/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443">Change here</a> to go on BL Dashboard</td></tr></table>
                                    ';
                                  return $succMsg;   
                              }                          
                        }else{                             
        // Service Implementation WAPI
	$serv_model =new ServiceGlobalModelForm();
	$param['token']	='imobile1@15061981';
	$param['modid']	='GLADMIN';
	$param['action']	='Update';
	$param['ETO_LEAP_AGENT_NAME']	=$agentName;
	$param['ETO_LEAP_TL_ID']	=$tlID;
	$param['ETO_LEAP_QA_ID']	=$qaID;
	$param['ETO_LEAP_EMP_ID']	=$agenID;
	$param['ETO_LEAP_AGENT_JOINING_DATE']=$joiningdate;
	$param['ETO_LEAP_FLAG_EMP_ID']	=$flagempid;
	$param['ETO_LEAP_AGENT_CHANGED_BY']	=$updatedById;
	$param['FK_LEAP_LOGIN_STATUS_ID']	=$pool;
	$param['SHIFT_TIME']	=$shifttime;
	$param['VENDOR_EMPLOYEE_ID']	=$vendor_emp_id;

	$host_name = $_SERVER['SERVER_NAME'];
	if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net'){
		$curl = 'http://stg-leads.imutils.com/wservce/glreport/elm/';
		}else{                        
		$curl = 'http://leads.imutils.com/wservce/glreport/elm/';
		}	  

	$response=$serv_model->mapiService('LEAPMIS',$curl,$param,'No');

	if($emp_id==75532 ||$emp_id==3575  ){
		echo"<pre>";
		print_r($param);
		echo"<pre>";
		print_r($response);
	}
	$code=isset($response["Response"]["Code"])?$response["Response"]["Code"]:'';
	$message=isset($response["Response"]["Message"])?$response["Response"]["Message"]:'';

                              if($code!=200){
                                  $succMsg = '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="60%" align="center">
                                    <tr><td class="intd" style="text-align:center;font-family: arial;font-size: 13px;background-color:#eeffff">Some Error Occured</td></tr>
                                    <tr><td class="intd" style="text-align:center;font-family: arial;font-size: 13px;background-color:#eeffff"><a href="/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443">Change here</a> to go on BL Dashboard</td></tr></table>
                                    ';
                                  return $succMsg; 
                              }
                        }                        	
                    }
		}		  
		
		$succMsg = '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="60%" align="center">
				<tr><td class="intd" style="color:green;text-align:center;font-family: arial;font-size: 13px;background-color:#eeffff">'.$i.' Agent\'s Detail has been updated</td></tr>
				<tr><td class="intd" style="text-align:center;font-family: arial;font-size: 13px;background-color:#eeffff"><a href="/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443">Change here</a> to go on BL Dashboard</td></tr></table>
				';
		return $succMsg; 
	}
	else{
		echo "Cant connect to database";
	}
}
                    public function allvendernames(){
						$recVendorAll=CommonVariable::get_active_vendor_name();   	

			return $recVendorAll;
	              }
	              
 public function ntDump($request,$vendorArr,$callfor)
 {  $rec=array();
		$start = $request->getParam('start',1);
		$end = $request->getParam('end',5000);
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$modid = $request->getParam('modid','');
		$source = $request->getParam('source','A');
		$vendor = $request->getParam('vendor','ALL');
		$start_time=$request->getParam('start_time',0);
		$end_time=$request->getParam('end_time',24);
		$employeeID = $request->getParam('employeeID',0);
		$tlid = $request->getParam('tlid',0);
		
		$in_flag = $request->getParam('in_flag',0);
		$totalRecords = intval($request->getParam('total_records'));
		$strt1 = strtotime($start_date);
		$end1 = strtotime($end_date);
		$today = strtotime(date("d-M-Y"));
                $obj = new Globalconnection();
                $model = new GlobalmodelForm();
				$dbh=$obj->connect_db_yii('postgress_web68v');
                
		$numOfPages = ($totalRecords / 5000) + 1;
		
		$params = array();
		$params['START_DATE'] = date("d-M-Y",strtotime($start_date));
		$params['END_DATE'] = date("d-M-Y",strtotime($end_date));
		$params['START_TIME'] = $start_time;
		$params['END_TIME'] = $end_time;
		$params['VENDOR_NAME_ARR_PARAM'] = $vendor;
		$params['START_LIMIT'] = $start;
		$params['END_LIMIT'] = $end;
		$params['EMP_ID'] = $employeeID;
		$params['IN_FLAG'] = $in_flag;
                
                
            $cntryArr = array('I' => 2,'F' => 3,'A' => 0);
	    $cntryFlag = isset($cntryArr[$source])?$cntryArr[$source]:0;
            $condion_vendor=$condion_emp=$condion_tlid='';

$dtime= $request->getParam('start_date',strtoupper(date("d-M-Y")));
 
$bindParam[':IN_START_TIME'] = $start_time;
$bindParam[':IN_END_TIME'] = $end_time;
$bindParam[':IN_START_LIMIT'] = $start;
$bindParam[':IN_END_LIMIT'] = $end;
if($employeeID>0){
    $condion_emp =' AND T2.FK_EMPLOYEE_ID=:IN_LEAP_ID';
    $bindParam[':IN_LEAP_ID'] = $employeeID;
}
if($tlid>0){
    $condion_tlid =' AND T2.FK_EMPLOYEE_ID IN(SELECT ETO_LEAP_EMP_ID FROM ETO_LEAP_MIS_INTERIM WHERE ETO_LEAP_TL_ID=:IN_TL_LEAP_ID) ';
    $bindParam[':IN_TL_LEAP_ID'] = $tlid;
}
if($vendor<>'ALL'){
    $condion_vendor =" AND ETO_LEAP_VENDOR_NAME =:IN_VENDOR_NAME ";
    $bindParam[':IN_VENDOR_NAME'] = $vendor;
}
if($source<>'A'){
    $bindParam[':IN_CNTRY_FLAG'] = $cntryFlag;
    $condion_emp .="AND (case when :IN_CNTRY_FLAG=0::text then 1 else (case when FK_GL_COUNTRY_ISO=:IN_CNTRY_FLAG then 2 when FK_GL_COUNTRY_ISO='INDIA' then 2 else 3 end) end) = 
		(case when :IN_CNTRY_FLAG=0::text then 1 when :IN_CNTRY_FLAG=2::text then 2 when :IN_CNTRY_FLAG= 3::text then 3 end) ";
}


if(strtotime(date("d-M-Y")) == strtotime(date("d-M-Y",strtotime($dtime)))){    
           
        $sql="SELECT ETO_LEAP_VENDOR_NAME, AGENT_EMP_ID, ETO_LEAP_AGENT_NAME, P_DATE, NULL DISPLAY_TIME,ACTIVITY_TIME,DISPOSITION,ETO_OFR_DISPLAY_ID from (
        SELECT   ROW_NUMBER() over (ORDER BY FK_ETO_LEAD_POSTDATE_ORIG desc)RN,
         FK_ETO_OFR_DISPLAY_ID ETO_OFR_DISPLAY_ID,
         TO_CHAR(ACTIVITY_TIME,'DD-MON-YY HH24:MI:SS') ACTIVITY_TIME,
         FK_EMPLOYEE_ID AGENT_EMP_ID,ETO_LEAP_AGENT_NAME,
         ETO_LEAP_VENDOR_NAME,
         ACTION,
         TO_CHAR(FK_ETO_LEAD_POSTDATE_ORIG,'DD-MM-YY') P_DATE,
         (CASE when ACTION=29 then 'Connected But Flagged' WHEN ACTION=3 then 'Not Talked' when ACTION=6 then 'Full Ring' when ACTION=11 
         then 'Not Talk by associate through Predictive system' when ACTION=12 then 'Full Ring by associate through Predictive system'  
         when ACTION=13 then 'Connected but flagged' when ACTION=14 then 'Connected but flagged Predictive' else 'Predictive' end) DISPOSITION

       FROM LEAP_ACTIVITY_STATS T2, ETO_LEAP_MIS_INTERIM
       WHERE
       T2.FK_EMPLOYEE_ID = ETO_LEAP_MIS_INTERIM.ETO_LEAP_EMP_ID AND ACTION IN (3,6,11,12,13,14,29) 
       AND date(ACTIVITY_TIME) = date(now())              
       AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
        $condion_emp $condion_tlid $condion_vendor 
        ORDER BY ACTIVITY_TIME DESC) TEMP WHERE RN BETWEEN :IN_START_LIMIT AND :IN_END_LIMIT ";   

       } else { 
            $sql="SELECT ETO_LEAP_VENDOR_NAME, AGENT_EMP_ID, ETO_LEAP_AGENT_NAME, P_DATE, 
            (
                    select TO_CHAR(MAX(ACTIVITY_TIME),'DD-MON-YY HH24:MI:SS') DISPLAY_TIME 
                    FROM LEAP_ACTIVITY_STATS_ARCH WHERE FK_ETO_OFR_DISPLAY_ID=ETO_OFR_DISPLAY_ID AND ACTION =2
            ) DISPLAY_TIME,ACTIVITY_TIME ,disposition,ETO_OFR_DISPLAY_ID, TITLE, FK_GL_MODULE_ID, FK_GLUSR_USR_ID, GLUSR_USR_PH_MOBILE 
            FROM 
            ( 
                    SELECT ROW_NUMBER() over (ORDER BY P_DATE desc)RN, ETO_LEAP_VENDOR_NAME, ETO_OFR_DISPLAY_ID, 
                    TO_CHAR(P_DATE,'DD-MON-YY HH24:MI:SS') P_DATE, FK_GLUSR_USR_ID, FK_GL_MODULE_ID, AGENT_EMP_ID, ETO_LEAP_AGENT_NAME, GLUSR_USR_PH_MOBILE, 
                    TITLE,TO_CHAR(ACTIVITY_TIME,'DD-MON-YY HH24:MI:SS') ACTIVITY_TIME ,disposition 
                    FROM 
                    (
                            SELECT ETO_OFR_DISPLAY_ID, ETO_OFR_POSTDATE_ORIG P_DATE, FK_GLUSR_USR_ID, FK_GL_MODULE_ID, ETO_OFR_TITLE TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                            (CASE when ACTION=29 then 'Connected But Flagged' WHEN ACTION=3 then 'Not Talked' when ACTION=6 then 'Full Ring' when ACTION=11 then 'Not Talk by associate through Predictive system' when ACTION=12 then 'Full Ring by associate through Predictive system'  when ACTION=13 then 'Connected but flagged' when ACTION=14 then 'Connected but flagged Predictive' else 'Predictive' end) DISPOSITION

                            FROM ETO_OFR, LEAP_ACTIVITY_STATS_ARCH T2 

                            WHERE date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                            
                            AND ETO_OFR_DISPLAY_ID = T2.FK_ETO_OFR_DISPLAY_ID AND T2.ACTION IN (3,6,11,12,13,14,29)		
                            $condion_emp $condion_tlid 
                            UNION 
                            SELECT ETO_OFR_DISPLAY_ID, ETO_OFR_POSTDATE_ORIG P_DATE, FK_GLUSR_USR_ID, FK_GL_MODULE_ID, ETO_OFR_TITLE TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                            (CASE when ACTION=29 then 'Connected But Flagged' WHEN ACTION=3 then 'Not Talked' when ACTION=6 then 'Full Ring' when ACTION=11 then 'Not Talk by associate through Predictive system' when ACTION=12 then 'Full Ring by associate through Predictive system'  when ACTION=13 then 'Connected but flagged' when ACTION=14 then 'Connected but flagged Predictive' else 'Predictive' end) DISPOSITION

                            FROM ETO_OFR_EXPIRED, LEAP_ACTIVITY_STATS_ARCH T2 

                            WHERE date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                            AND ETO_OFR_DISPLAY_ID = T2.FK_ETO_OFR_DISPLAY_ID AND T2.ACTION IN (3,6,11,12,13,14,29) 
                            $condion_emp $condion_tlid  
                            UNION 		
                            SELECT ETO_OFR_DISPLAY_ID, ETO_OFR_POSTDATE_ORIG P_DATE, FK_GLUSR_USR_ID, FK_GL_MODULE_ID, ETO_OFR_TITLE TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                            (CASE when ACTION=29 then 'Connected But Flagged' WHEN ACTION=3 then 'Not Talked' when ACTION=6 then 'Full Ring' when ACTION=11 then 'Not Talk by associate through Predictive system' when ACTION=12 then 'Full Ring by associate through Predictive system'  when ACTION=13 then 'Connected but flagged' when ACTION=14 then 'Connected but flagged Predictive' else 'Predictive' end) DISPOSITION
                            FROM ETO_OFR_TEMP_DEL, LEAP_ACTIVITY_STATS_ARCH T2 
                            WHERE 
                            date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                             AND ETO_OFR_DISPLAY_ID = T2.FK_ETO_OFR_DISPLAY_ID AND T2.ACTION IN (3,6,11,12,13,14,29) 
                            $condion_emp $condion_tlid 
                            UNION 	

                            SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID, DATE_R P_DATE, FK_GLUSR_USR_ID, QUERY_MODID FK_GL_MODULE_ID, NULL TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                            (CASE when ACTION=29 then 'Connected But Flagged' WHEN ACTION=3 then 'Not Talked' when ACTION=6 then 'Full Ring' when ACTION=11 then 'Not Talk by associate through Predictive system' when ACTION=12 then 'Full Ring by associate through Predictive system'  when ACTION=13 then 'Connected but flagged' when ACTION=14 then 'Connected but flagged Predictive' else 'Predictive' end) DISPOSITION
                            FROM ETO_OFR_FROM_FENQ_ARCH, LEAP_ACTIVITY_STATS_ARCH T2 
                            WHERE date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                            AND DIR_QUERY_FREE_REFID = T2.FK_ETO_OFR_DISPLAY_ID 
                            AND T2.ACTION IN (3,6,11,12,13,14,29)
                            $condion_emp $condion_tlid  
                            UNION 

                            SELECT ETO_OFR_DISPLAY_ID, DATE_R P_DATE, FK_GLUSR_USR_ID, QUERY_MODID FK_GL_MODULE_ID, SUBJECT TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                            (CASE when ACTION=29 then 'Connected But Flagged' WHEN ACTION=3 then 'Not Talked' when ACTION=6 then 'Full Ring' when ACTION=11 then 'Not Talk by associate through Predictive system' when ACTION=12 then 'Full Ring by associate through Predictive system'  when ACTION=13 then 'Connected but flagged' when ACTION=14 then 'Connected but flagged Predictive' else 'Predictive' end) DISPOSITION
                            FROM DIR_QUERY_FREE, LEAP_ACTIVITY_STATS_ARCH T2 
                            WHERE date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                             AND ETO_OFR_DISPLAY_ID = T2.FK_ETO_OFR_DISPLAY_ID AND T2.ACTION IN (3,6,11,12,13,14,29) 
                            $condion_emp $condion_tlid  
                    ) T1, glusr_usr, ETO_LEAP_MIS_INTERIM
                    WHERE T1.FK_GLUSR_USR_ID = glusr_usr.GLUSR_USR_ID AND T1.AGENT_EMP_ID = ETO_LEAP_MIS_INTERIM.ETO_LEAP_EMP_ID 
                    $condion_vendor 
            ORDER BY ACTIVITY_TIME DESC 
            ) TEMP 
             WHERE RN BETWEEN :IN_START_LIMIT AND :IN_END_LIMIT";

            $bindParam[':start_date_time'] = $start_date;
            $bindParam[':end_date_time'] = $end_date;
            
 }
  $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bindParam);//echo $sql;print_r($bindParam);
    $d1 = array("VENDOR NAME","ASSOCIATE ID","ASSOCIATE NAME","Post date Orig","Display Time","Flag Time","Disposition Flag","OFFER_ID","ETO_OFR_TITLE","SOURCE","GLUSR ID","GLUSR_MOBILE");
   array_push($rec,$d1);               

    if($sth) {
		while($temp = $sth->read())
		{
			$rec1=array_change_key_case($temp, CASE_UPPER);   
			array_push($rec,$rec1);
		}
    }
  return $rec;
 }
  

   public function autoDump($request,$vendorArr)
 {
      $rec=array();
		$start = $request->getParam('start',1);
		$end = $request->getParam('end',5000);
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$modid = $request->getParam('modid','');
		$source = $request->getParam('source','A');
		$vendor = $request->getParam('vendor','ALL');
		$start_time=$request->getParam('start_time',0);
		$end_time=$request->getParam('end_time',24);
		$employeeID = $request->getParam('employeeID',0);
		$tlid = $request->getParam('tlid',0);
		
		$in_flag = $request->getParam('in_flag',0);
		$totalRecords = intval($request->getParam('total_records'));
		$strt1 = strtotime($start_date);
		$end1 = strtotime($end_date);
		$today = strtotime(date("d-M-Y"));
                $obj = new Globalconnection();
                
		$model = new GlobalmodelForm();
		$dbh=$obj->connect_db_yii('postgress_web68v');

                
                $numOfPages = ($totalRecords / 5000) + 1;
		
		$params = array();
                
		$params['START_DATE'] = date("d-M-Y",strtotime($start_date));
		$params['END_DATE'] = date("d-M-Y",strtotime($end_date));
		$params['START_TIME'] = $start_time;
		$params['END_TIME'] = $end_time;
		$params['VENDOR_NAME_ARR_PARAM'] = $vendor;
		$params['START_LIMIT'] = $start;
		$params['END_LIMIT'] = $end;
		$params['EMP_ID'] = $employeeID;
		$params['IN_FLAG'] = $in_flag;
                
                
            $cntryArr = array('I' => 2,'F' => 3,'A' => 0);
	    $cntryFlag = isset($cntryArr[$source])?$cntryArr[$source]:0;
            $condion_vendor='';
            
	    $bindParam[':IN_START_TIME'] = $start_time;
            $bindParam[':IN_END_TIME'] = $end_time;
            $bindParam[':IN_START_LIMIT'] = $start;
            $bindParam[':IN_END_LIMIT'] = $end;
			$condion_emp='';
			$condion_tlid='';
			 $condion_vendor='';
            if($employeeID>0){
                $condion_emp =' AND T2.FK_EMPLOYEE_ID=:IN_LEAP_ID';
                $bindParam[':IN_LEAP_ID'] = $employeeID;
            }
            if($tlid>0){
                $condion_tlid =' AND T2.FK_EMPLOYEE_ID IN(SELECT ETO_LEAP_EMP_ID FROM ETO_LEAP_MIS_INTERIM WHERE ETO_LEAP_TL_ID=:IN_TL_LEAP_ID) ';
                $bindParam[':IN_TL_LEAP_ID'] = $tlid;
            }
            if($vendor<>'ALL'){
                $condion_vendor =" AND ETO_LEAP_VENDOR_NAME =:IN_VENDOR_NAME ";
                $bindParam[':IN_VENDOR_NAME'] = $vendor;
            }
            if($source<>'A'){
                $bindParam[':IN_CNTRY_FLAG'] = $cntryFlag;
                $condion_emp .="AND (case when :IN_CNTRY_FLAG=0::text then 1 else (case when FK_GL_COUNTRY_ISO=:IN_CNTRY_FLAG then 2 when FK_GL_COUNTRY_ISO='INDIA' then 2 else 3 end) end) = 
                            (case when :IN_CNTRY_FLAG=0::text then 1 when :IN_CNTRY_FLAG=2::text then 2 when :IN_CNTRY_FLAG= 3::text then 3 end) ";
            }

$dtime= $request->getParam('start_date',strtoupper(date("d-M-Y")));
if(strtotime(date("d-M-Y")) == strtotime(date("d-M-Y",strtotime($dtime)))){ 

 $sql="SELECT ETO_LEAP_VENDOR_NAME,
  AGENT_EMP_ID, 
  ETO_OFR_DISPLAY_ID,
  P_DATE,
  ACTIVITY_TIME,
  DISPOSITION
FROM
  (SELECT ROW_NUMBER() over (ORDER BY FK_ETO_LEAD_POSTDATE_ORIG desc)RN,
    FK_ETO_OFR_DISPLAY_ID ETO_OFR_DISPLAY_ID,
    TO_CHAR(ACTIVITY_TIME,'DD-MON-YY HH24:MI:SS') ACTIVITY_TIME,
    FK_EMPLOYEE_ID AGENT_EMP_ID,
    ETO_LEAP_VENDOR_NAME,    
    TO_CHAR(FK_ETO_LEAD_POSTDATE_ORIG,'DD-MM-YY') P_DATE,
    (CASE when ACTION=28 then 'Not Talk Flagged' else 'Predictive Dialing' end) DISPOSITION 
FROM LEAP_ACTIVITY_STATS T2, ETO_LEAP_MIS_INTERIM
WHERE
T2.FK_EMPLOYEE_ID = ETO_LEAP_MIS_INTERIM.ETO_LEAP_EMP_ID
AND ACTION=7
AND date(ACTIVITY_TIME) = date(now())              
AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
 $condion_emp $condion_tlid $condion_vendor 
 ORDER BY ACTIVITY_TIME DESC) TEMP WHERE RN BETWEEN :IN_START_LIMIT AND :IN_END_LIMIT";    
}else
 {  
$sql="SELECT ETO_LEAP_VENDOR_NAME, AGENT_EMP_ID, ETO_LEAP_AGENT_NAME, P_DATE, 
            (
                    select TO_CHAR(MAX(ACTIVITY_TIME),'DD-MON-YY HH24:MI:SS') DISPLAY_TIME 
                    FROM LEAP_ACTIVITY_STATS_ARCH WHERE FK_ETO_OFR_DISPLAY_ID=ETO_OFR_DISPLAY_ID AND ACTION =2
            ) DISPLAY_TIME,ACTIVITY_TIME ,disposition,ETO_OFR_DISPLAY_ID, TITLE, FK_GL_MODULE_ID, FK_GLUSR_USR_ID, GLUSR_USR_PH_MOBILE 
            FROM 
            ( 
                    SELECT ROW_NUMBER() over (ORDER BY P_DATE desc)RN, ETO_LEAP_VENDOR_NAME, ETO_OFR_DISPLAY_ID, 
                    TO_CHAR(P_DATE,'DD-MON-YY HH24:MI:SS') P_DATE, FK_GLUSR_USR_ID, FK_GL_MODULE_ID, AGENT_EMP_ID, ETO_LEAP_AGENT_NAME, GLUSR_USR_PH_MOBILE, 
                    TITLE,TO_CHAR(ACTIVITY_TIME,'DD-MON-YY HH24:MI:SS') ACTIVITY_TIME ,disposition 
                    FROM 
                    (
                            SELECT ETO_OFR_DISPLAY_ID, ETO_OFR_POSTDATE_ORIG P_DATE, FK_GLUSR_USR_ID, FK_GL_MODULE_ID, ETO_OFR_TITLE TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                            (CASE when ACTION=28 then 'Not Talk Flagged' else 'Predictive Dialing' end) DISPOSITION 
                            FROM ETO_OFR, LEAP_ACTIVITY_STATS_ARCH T2 

                            WHERE date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                            
                            AND ETO_OFR_DISPLAY_ID = T2.FK_ETO_OFR_DISPLAY_ID AND T2.ACTION in(7,28) 		
                            $condion_emp $condion_tlid 
                            UNION 
                            SELECT ETO_OFR_DISPLAY_ID, ETO_OFR_POSTDATE_ORIG P_DATE, FK_GLUSR_USR_ID, FK_GL_MODULE_ID, ETO_OFR_TITLE TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                            (CASE when ACTION=28 then 'Not Talk Flagged' else 'Predictive Dialing' end) DISPOSITION 
                            FROM ETO_OFR_EXPIRED, LEAP_ACTIVITY_STATS_ARCH T2 

                            WHERE date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                            AND ETO_OFR_DISPLAY_ID = T2.FK_ETO_OFR_DISPLAY_ID AND T2.ACTION in(7,28)  
                            $condion_emp $condion_tlid  
                            UNION 		
                            SELECT ETO_OFR_DISPLAY_ID, ETO_OFR_POSTDATE_ORIG P_DATE, FK_GLUSR_USR_ID, FK_GL_MODULE_ID, ETO_OFR_TITLE TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                           (CASE when ACTION=28 then 'Not Talk Flagged' else 'Predictive Dialing' end) DISPOSITION 
                           FROM ETO_OFR_TEMP_DEL, LEAP_ACTIVITY_STATS_ARCH T2 
                            WHERE 
                            date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                             AND ETO_OFR_DISPLAY_ID = T2.FK_ETO_OFR_DISPLAY_ID AND T2.ACTION in(7,28)   
                            $condion_emp $condion_tlid 
                            UNION 	

                            SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID, DATE_R P_DATE, FK_GLUSR_USR_ID, QUERY_MODID FK_GL_MODULE_ID, NULL TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                           (CASE when ACTION=28 then 'Not Talk Flagged' else 'Predictive Dialing' end) DISPOSITION 
                           FROM ETO_OFR_FROM_FENQ_ARCH, LEAP_ACTIVITY_STATS_ARCH T2 
                            WHERE date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                            AND DIR_QUERY_FREE_REFID = T2.FK_ETO_OFR_DISPLAY_ID 
                            AND T2.ACTION in(7,28)  
                            $condion_emp $condion_tlid  
                            UNION 
                            SELECT ETO_OFR_DISPLAY_ID, DATE_R P_DATE, FK_GLUSR_USR_ID, QUERY_MODID FK_GL_MODULE_ID, SUBJECT TITLE, T2.ACTIVITY_TIME, 
                            T2.FK_EMPLOYEE_ID AGENT_EMP_ID,
                           (CASE when ACTION=28 then 'Not Talk Flagged' else 'Predictive Dialing' end) DISPOSITION 
                           FROM DIR_QUERY_FREE, LEAP_ACTIVITY_STATS_ARCH T2 
                            WHERE date(T2.ACTIVITY_TIME) BETWEEN date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(TO_DATE(:end_date_time,'DD-Mon-YYYY')) 
                            AND TO_CHAR(ACTIVITY_TIME,'HH24')::int>= :IN_START_TIME AND TO_CHAR(ACTIVITY_TIME,'HH24')::int< :IN_END_TIME
                             AND ETO_OFR_DISPLAY_ID = T2.FK_ETO_OFR_DISPLAY_ID  AND T2.ACTION in(7,28)  
                            $condion_emp $condion_tlid  
                    ) T1, glusr_usr, ETO_LEAP_MIS_INTERIM
                    WHERE T1.FK_GLUSR_USR_ID = glusr_usr.GLUSR_USR_ID AND T1.AGENT_EMP_ID = ETO_LEAP_MIS_INTERIM.ETO_LEAP_EMP_ID 
                    $condion_vendor 
            ORDER BY ACTIVITY_TIME DESC 
            ) TEMP 
             WHERE RN BETWEEN :IN_START_LIMIT AND :IN_END_LIMIT";


//echo $sql;
 $bindParam[':start_date_time'] = $start_date;
 $bindParam[':end_date_time'] = $end_date;
}

   $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bindParam);//echo $sql;print_r($bindParam); 
   $d1 = array("VENDOR NAME","ASSOCIATE ID","Post date Orig","Display Time","Flag Time","Disposition Flag","OFFER_ID","ETO_OFR_TITLE","SOURCE","GLUSR ID","GLUSR_MOBILE");
   array_push($rec,$d1);               
  
while($temp = $sth->read())																																																																
      {
         $rec1=array_change_key_case($temp, CASE_UPPER);   
         array_push($rec,$rec1);
      }
   return $rec;  
}

  	public function predictive_rpt($postgre,$request)
    {
			
		$model = new GlobalmodelForm();
		$dtime= $request->getParam('start_date',strtoupper(date("d-M-Y")));
		$returnArr=$pend=$total_pend=array();
		$etoModel =  new AdminEtoForm();
		$emp_id = Yii::app()->session['empid'];
		$arr_lvl_code = $etoModel->getLeapEmpLVL($emp_id);
		$prtype=isset($_REQUEST['prtype']) ? $_REQUEST['prtype'] : '';
                $rtype=isset($_REQUEST['rtype']) ? $_REQUEST['rtype'] : '';
		$vendor='';
		$vendor1=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : '';
		$vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
		$aov=isset($_REQUEST['aov']) ? $_REQUEST['aov'] : ''; 
		$currentDate = strtoupper(date("d-M-Y"));	
		$obj = new Globalconnection();	
		$vendorCon= $cond= '';
		$bind='';
		if (preg_match("/noida/i",$arr_lvl_code['ETO_LEAP_VENDOR_NAME']) || preg_match("/ddn/i",$arr_lvl_code['ETO_LEAP_VENDOR_NAME'])) {
			$vendor='';	
		}else{
                    if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME'])){
                     $vendor=" AND LEAP_VENDOR_NAME= :LEAP_VENDOR_NAME1 ";
                     $bind[':LEAP_VENDOR_NAME1']=$arr_lvl_code['ETO_LEAP_VENDOR_NAME']; 
                    }
                }
    
		if($vendorVal <>'ALL')
		{
                    $vendorVal="'".str_replace(",", "','", $vendorVal)."'";  
                    $vendorCon="AND LEAP_VENDOR_NAME in ($vendorVal) ";
                    //$vendorCon="AND LEAP_VENDOR_NAME in (SELECT SUBSTR(IDLIST,INSTR(IDLIST,',',1,LEVEL)+1,(INSTR(IDLIST,',',1,LEVEL+1)-INSTR(IDLIST,',',1,LEVEL))-1) FROM (SELECT REPLACE(REPLACE(','||TRIM('''' FROM :LEAP_VENDOR_NAME)||',',' ',''),',,',',') IDLIST FROM DUAL)TEMP_STR_TAB CONNECT BY LEVEL< LENGTH(IDLIST)-LENGTH(REPLACE(IDLIST,',','')))";
                   // $bind[':LEAP_VENDOR_NAME']=$vendorVal; 
                    $selcol=" LEAP_VENDOR_NAME ";
            	}else{
                    $vendorCon=" AND LEAP_VENDOR_NAME <> 'COGENTINTENT'";
                    $selcol=" 'MUST CALL' LEAP_VENDOR_NAME ";
                }
                if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                       $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{                        
                      $dbh = $obj->connect_db_yii('postgress_web68v');   
                }
		
		if($vendorVal =='BANREVIEW' && $rtype =='P')
		{		
			

			$sql = "SELECT DATE_PART('hour', gl_profile_enrichment_date::TIMESTAMP) HR,
			'BANREVIEW' LEAP_VENDOR_NAME,
			COUNT(1) TOTAL_SENT,
			COUNT(CASE WHEN gl_profile_audit_date IS NULL THEN 1  ELSE NULL END ) PENDING_CNT,
			COUNT(CASE WHEN gl_profile_audit_date IS NOT NULL THEN 1  ELSE NULL END ) ATTEMPT_CNT,
			COUNT(CASE WHEN minss::NUMERIC <= 5 THEN 1  ELSE NULL END ) ATTEMPTED_TIMLINESS_CNT_5,
			COUNT(CASE WHEN minss::NUMERIC > 5 THEN 1  ELSE NULL END ) NOT_ATTEMPTED_TIMLINESS_CNT_5,
			COUNT(CASE WHEN minss::NUMERIC <= 10 THEN 1  ELSE NULL END ) ATTEMPTED_TIMLINESS_CNT,
			COUNT(CASE WHEN minss::NUMERIC > 10 THEN 1  ELSE NULL END ) NOT_ATTEMPTED_TIMLINESS_CNT,
			COUNT(CASE WHEN minss::NUMERIC <= 15 THEN 1  ELSE NULL END ) ATTEMPTED_TIMLINESS_CNT_15,
			COUNT(CASE WHEN minss::NUMERIC > 15 THEN 1  ELSE NULL END ) NOT_ATTEMPTED_TIMLINESS_CNT_15
			FROM
			(
			SELECT gl_profile_enrichment_date,
			gl_profile_audit_date,
			fk_glusr_usr_id,
			eto_ofr_display_id,
			GL_PROFILE_AUDIT_STATUS,
			
			(DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) minss

			
			from bl_profile_enrichment,leap_banned_keyword
			where fk_gl_attribute_id=223
			and eto_ofr_display_id=fk_eto_ofr_display_id
			AND date(gl_profile_enrichment_date) = '$dtime'
			) a GROUP BY DATE_PART('hour', gl_profile_enrichment_date::TIMESTAMP)";

			$sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array()); 
			while($rec = $sth->read()){                
                            array_push($total_pend,array_change_key_case($rec, CASE_UPPER)); 
                        }
			                       
			$returnArr['pend']=$total_pend;  	
			return $returnArr;		
		}
		if($prtype =='flag')
		{
			$cond="AND CALL_DURATION IS NOT NULL";
		}
		elseif($prtype =='fresh')
		{
			$cond="AND CALL_DURATION IS NULL";
		}
		if($aov =='HIGHAOV')
		{
			$cond .=" AND SKILL_POOL_ID = 1 ";
		}elseif($aov =='REINSERT')
		{
			$cond .=" AND SKILL_POOL_ID = -1 ";
		}
                if($rtype=='P'){
                    if($dtime == $currentDate)
                    {
                          $sql="SELECT $selcol,
                                        To_char(send_date, 'HH24') HR,
                                        Count(1)                   TOTAL_SENT,
                                        Count(CASE
                                        WHEN call_attempt_date IS NULL THEN 1
                                        ELSE NULL
                                        END)                 PENDING_CNT,
                                        Count(CASE
                                        WHEN (extract(day from update_date - send_date)*24*60+extract(hour from update_date - send_date)*60 +
                                        extract(minute from update_date - send_date)) <= 10 THEN 1
                                        ELSE NULL
                                        END)                 PENDING_TIMLINESS_CNT,
                                        Count(CASE
                                        WHEN (extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 +
                                        extract(minute from call_attempt_date - send_date)) <= 10 THEN 1
                                        ELSE NULL
                                        END)                 ATTEMPTED_TIMLINESS_CNT,
                                        Count(CASE
                                        WHEN ( (extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 +
                                        extract(minute from call_attempt_date - send_date)) > 10
                                        OR call_attempt_date IS NULL ) THEN 1
                                        ELSE NULL
                                        END)                 NOT_ATTEMPTED_TIMLINESS_CNT,
                                        Count(CASE
                                        WHEN call_attempt_date IS NOT NULL THEN 1
                                        ELSE NULL
                                        END)                 ATTEMPT_CNT,
                                        Count(CASE
                                        WHEN update_date IS NOT NULL THEN 1
                                        ELSE NULL
                                        END)                 REC_CNT,
                                        Count(CASE
                                        WHEN (extract(day from update_date - call_attempt_date)*24*60+extract(hour from update_date - call_attempt_date)*60 +
                                        extract(minute from update_date - call_attempt_date)) <= 10 THEN 1
                                        ELSE NULL
                                        END)                 TIMLINESS_CNT,
                                        Count(CASE
                                        WHEN (extract(day from update_date - call_attempt_date)*24*60+extract(hour from update_date - call_attempt_date)*60 +
                                        extract(minute from update_date - call_attempt_date)) > 10 THEN 1
                                        ELSE NULL
                                        END)                 NOT_TIMLINESS_CNT,
                                        Count(CASE
                                        WHEN (extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 +
                                        extract(minute from call_attempt_date - send_date)) <= 1 THEN 1
                                        ELSE NULL
                                        END)                 ATTEMPTED_TIMLINESS_CNT_1,
                                        Count(CASE
                                        WHEN (extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 +
                                        extract(minute from call_attempt_date - send_date)) <= 2 THEN 1
                                        ELSE NULL
                                        END)                 ATTEMPTED_TIMLINESS_CNT_2,
                                        Count(CASE
                                        WHEN (extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 +
                                        extract(minute from call_attempt_date - send_date)) <= 5 THEN 1
                                        ELSE NULL
                                        END)                 ATTEMPTED_TIMLINESS_CNT_5
                                FROM   leap_dialer_response
                                WHERE  
                                        send_date >= date(now()) AND send_date < date(now()) + 1                                        
                                        $vendor $cond $vendorCon 
                                GROUP  BY leap_vendor_name,
                                To_char(send_date, 'HH24')
                                ORDER  BY leap_vendor_name, hr"; 
                    }
                    else
                    {                            
                            $bind[':STARTDATE']=$dtime; 
                            $sql="SELECT leap_vendor_name,
                                        To_char(send_date, 'HH24') HR,
                                        Count(1) TOTAL_SENT,
                                        Count(CASE WHEN call_attempt_date IS NULL THEN 1 ELSE NULL END) PENDING_CNT,
                                        Count(CASE WHEN (extract(day from update_date - send_date)*24*60+extract(hour from update_date - send_date)*60 + extract(minute from update_date - send_date)) <= 10 THEN 1 ELSE NULL END) PENDING_TIMLINESS_CNT,
                                        Count(CASE WHEN (extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 + extract(minute from call_attempt_date - send_date)) <= 10 THEN 1
                                        ELSE NULL END) ATTEMPTED_TIMLINESS_CNT,
                                        Count(CASE WHEN ((extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 + extract(minute from call_attempt_date - send_date)) > 10
                                        OR call_attempt_date IS NULL) THEN 1 ELSE NULL END)  NOT_ATTEMPTED_TIMLINESS_CNT,
                                        Count(CASE WHEN call_attempt_date IS NOT NULL THEN 1 ELSE NULL END) ATTEMPT_CNT,
                                        Count(CASE WHEN update_date IS NOT NULL THEN 1 ELSE NULL END) REC_CNT,
                                        Count(CASE WHEN (extract(day from update_date - call_attempt_date)*24*60+extract(hour from update_date - call_attempt_date)*60 + extract(minute from update_date - call_attempt_date))<= 10 THEN 1 ELSE NULL END) TIMLINESS_CNT,
                                        Count(CASE
                                        WHEN (extract(day from update_date - call_attempt_date)*24*60+extract(hour from update_date - call_attempt_date)*60 +
                                        extract(minute from update_date - call_attempt_date)) > 10 THEN 1
                                        ELSE NULL
                                        END)                 NOT_TIMLINESS_CNT,
                                        Count(CASE
                                        WHEN (extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 +
                                        extract(minute from call_attempt_date - send_date)) <= 1 THEN 1
                                        ELSE NULL
                                        END)                 ATTEMPTED_TIMLINESS_CNT_1,
                                        Count(CASE
                                        WHEN (extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 +
                                        extract(minute from call_attempt_date - send_date))<= 2 THEN 1
                                        ELSE NULL
                                        END)                 ATTEMPTED_TIMLINESS_CNT_2,
                                        Count(CASE
                                        WHEN (extract(day from call_attempt_date - send_date)*24*60+extract(hour from call_attempt_date - send_date)*60 +
                                        extract(minute from call_attempt_date - send_date)) <= 5 THEN 1
                                        ELSE NULL
                                        END)                 ATTEMPTED_TIMLINESS_CNT_5
                                        FROM   
                                        (
                                        SELECT call_attempt_date,
                                        update_date,
                                        send_date,
                                        $selcol
                                        FROM   leap_dialer_response
                                        WHERE  date(send_date) = To_date(:STARTDATE, 'DD-MON-YYYY')
                                        AND call_duration IS NULL
                                        AND leap_vendor_name <> 'COGENTINTENT'
                                        UNION
                                        SELECT call_attempt_date,
                                        update_date,
                                        send_date,
                                        $selcol 
                                    FROM   leap_dialer_response_arch
                                WHERE  
                                        date(send_date) = To_date(:STARTDATE, 'DD-MON-YYYY')
                                         $vendor $cond $vendorCon) a
                                GROUP  BY leap_vendor_name, To_char(send_date, 'HH24')
                                ORDER  BY leap_vendor_name, hr"; 

                    }
				
                    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind); 
					
					if($sth) {
						while($rec = $sth->read()) {
							array_push($pend,array_change_key_case($rec, CASE_UPPER)); 
						}
					}
                    $returnArr['pend']=$pend;
                }else{                       
                        $cond_sql='';$bind_pend=array();
                        if($vendor<>''){
                                $cond_sql=$vendor;
                                $bind_pend[':LEAP_VENDOR_NAME1']=$arr_lvl_code['ETO_LEAP_VENDOR_NAME']; 
                        }
                        if($cond<>''){
                                $cond_sql .= $cond;
                        }
                        $sql_tot = "SELECT LEAP_VENDOR_NAME,count(1) PENDING_CNT 
                        from LEAP_DIALER_RESPONSE WHERE coalesce(date(UPDATE_DATE),'01-APR-1996')='01-APR-1996' $cond_sql
                        group by LEAP_VENDOR_NAME";

                        $sth_tot = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_tot,$bind_pend);//echo $sql;
                        while($rec = $sth_tot->read()) {
                                array_push($total_pend,array_change_key_case($rec, CASE_UPPER));                                
                        }
                        $returnArr['total_pend']=$total_pend;
		}
		//print_r($returnArr);die;		
		return $returnArr;
    }
  
public function predictive_rpt_detail($postgre,$subtype,$vendor,$time,$start_date,$prtype,$export)
    {
		$model = new GlobalmodelForm();
		$dtime= strtoupper($start_date);
		$pend=array(); $total_pend=array();
		$obj = new Globalconnection();
		$dbh=$obj->connect_db_yii('postgress_web68v');
		$bind = array();
                $rownum="";
		$start=isset($_REQUEST['start']) ? $_REQUEST['start'] : 1;
		$end=isset($_REQUEST['end']) ? $_REQUEST['end'] : 100;
		if($time<10 && $time !='TOT'){
                    $time='0'.$time;
                }
                $cond = "";
		$currentDate = strtoupper(date("d-M-Y"));
		if($subtype =='SENT')
		{
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}elseif($subtype =='PEND')
                {
			$cond .=' AND CALL_ATTEMPT_DATE IS NULL';
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}elseif($subtype =='ATTEMP')
		{
			$cond .=' AND CALL_ATTEMPT_DATE IS NOT NULL';
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}elseif($subtype =='ATTEMP_1')
		{
			$cond .=' AND (CALL_ATTEMPT_DATE - SEND_DATE)*24*60 <=1';
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}elseif($subtype =='ATTEMP_2')
		{
			$cond .=' AND (CALL_ATTEMPT_DATE - SEND_DATE)*24*60 <=2';
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}elseif($subtype =='ATTEMP_5')
		{
			$cond .=' AND (CALL_ATTEMPT_DATE - SEND_DATE)*24*60 <=5';
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}elseif($subtype =='ATTEMP_TEN')
		{
			$cond .=' AND (CALL_ATTEMPT_DATE - SEND_DATE)*24*60 <=10';
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}
		elseif($subtype =='PEND_TEN')
		{
			$cond .=' AND ((CALL_ATTEMPT_DATE - SEND_DATE)*24*60 >10 OR CALL_ATTEMPT_DATE is null)';
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}elseif($subtype =='NOT_REC_TEN')
		{
			$cond .=' AND (UPDATE_DATE - CALL_ATTEMPT_DATE)*24*60 >10';
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}elseif($subtype =='REC_TEN')
		{
		 $cond .=' AND (UPDATE_DATE - CALL_ATTEMPT_DATE)*24*60 <=10';
			if($time !='TOT'){
				$cond .=" AND to_char(SEND_DATE,'HH24')=:time";
				$bind[':time'] = $time;
			}
		}

		if($prtype =='flag')
		{
			$cond2=" AND CALL_DURATION IS NOT NULL";
		}
		elseif($prtype =='fresh')
		{
			$cond2=" AND CALL_DURATION IS NULL";
		}
		else
		{
			$cond2="";
		}
                if($aov =='HIGHAOV')
		{
			$cond2 .=" AND SKILL_POOL_ID = 1 ";
		}elseif($aov =='REINSERT')
		{
			$cond2 .=" AND SKILL_POOL_ID = -1 ";
		}
                
                
                if($vendor=='MUST CALL'){
                     $cond_v="AND LEAP_VENDOR_NAME <> 'COGENTINTENT' ";
                }else{
                     $cond_v="AND LEAP_VENDOR_NAME=:vendor ";
                     $bind[':vendor']=$vendor; 
                }
                  
		if($dtime == $currentDate)
		{ 
                    if($export =='yes')
			{
                        $rownum ="  RN >= ".$start." AND RN <=".$end ;
                        }else{
			 $rownum ="  RN <= 100" ;						// 
                        }
                        $sql="SELECT * FROM (SELECT TEMP.*,ROW_NUMber() over (order by SEND_DATE)AS RN FROM (SELECT  
					LEAP_VENDOR_NAME, 
					FK_GLUSR_USR_ID, 
					MOBILE_NO,
					TO_CHAR(CALL_ATTEMPT_DATE, 'DD-Mon-yyyy HH24:MI:SS') CALL_ATTEMPT_DATE,
					TO_CHAR(SEND_DATE, 'DD-Mon-yyyy HH24:MI:SS') SEND_DATE,
					CALL_DURATION,CALL_DISPOSITION,
					TO_CHAR(UPDATE_DATE, 'DD-Mon-yyyy HH24:MI:SS') UPDATE_DATE,
					LEAP_AUTH_ID 
				from 
				LEAP_DIALER_RESPONSE 
				where 
				send_date >= date(now()) AND send_date < date(now()) + 1				
				$cond_v $cond $cond2 ) TEMP ORDER BY SEND_DATE ) A WHERE $rownum"; 
		}
		else
		{
                        if($export =='yes')
			{
			  $rownum ="  RN >= ".$start." AND RN <=".$end ;							
                        }else{
                            $rownum="  RN<=100";
                        }
                        $bind[':STARTDATE']=$dtime; 
			$sql="SELECT * FROM (SELECT TEMP.*,ROW_NUMber() over (order by SEND_DATE)AS RN FROM (
				SELECT  
					LEAP_VENDOR_NAME, 
					FK_GLUSR_USR_ID, 
					MOBILE_NO,
					TO_CHAR(CALL_ATTEMPT_DATE, 'DD-Mon-yyyy HH24:MI:SS') CALL_ATTEMPT_DATE,
					TO_CHAR(SEND_DATE, 'DD-Mon-yyyy HH24:MI:SS') SEND_DATE,
					CALL_DURATION,CALL_DISPOSITION,
					TO_CHAR(UPDATE_DATE, 'DD-Mon-yyyy HH24:MI:SS') UPDATE_DATE,
					LEAP_AUTH_ID 
				from 
				LEAP_DIALER_RESPONSE
				where 
				date(send_date) = To_date(:STARTDATE, 'DD-MON-YYYY') 				
				$cond_v $cond $cond2 
			UNION  
			SELECT  
					LEAP_VENDOR_NAME, 
					FK_GLUSR_USR_ID, 
					MOBILE_NO,
					TO_CHAR(CALL_ATTEMPT_DATE, 'DD-Mon-yyyy HH24:MI:SS') CALL_ATTEMPT_DATE,
					TO_CHAR(SEND_DATE, 'DD-Mon-yyyy HH24:MI:SS') SEND_DATE,
					CALL_DURATION,CALL_DISPOSITION,
					TO_CHAR(UPDATE_DATE, 'DD-Mon-yyyy HH24:MI:SS') UPDATE_DATE,
					LEAP_AUTH_ID 
				from 
				LEAP_DIALER_RESPONSE_ARCH
				where 
				date(send_date) = To_date(:STARTDATE, 'DD-MON-YYYY') 				
				$cond_v $cond $cond2 ) TEMP ORDER BY SEND_DATE ) A where $rownum"; 
		}
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);
		while($rec = $sth->read()) {
                     array_push($pend,array_change_key_case($rec, CASE_UPPER));
		}
//print_r($pend);die;
		if($export=='yes')
		{
			$dataexport=array();
			$dataexport[0][0]='AUTH ID';
			$dataexport[0][1]='VENDOR NAME';
			$dataexport[0][2]='GLUSER ID';
			$dataexport[0][3]='MOBILE NUMBER';
			$dataexport[0][4]='SEND DATE';
			$dataexport[0][5]='UPDATE DATE';
			$dataexport[0][6]='CALL ATTEMPT DATE';
			$dataexport[0][7]='CALL DURATION';
			$dataexport[0][8]='CALL DISPOSITION';

			for($i=1;$i<=count($pend);$i++)
			{
				$j=$i-1;
				$dataexport[$i][0]=$pend[$j]['LEAP_AUTH_ID'];
				$dataexport[$i][1]=$pend[$j]['LEAP_VENDOR_NAME'];
				$dataexport[$i][2]=$pend[$j]['FK_GLUSR_USR_ID'];
				$dataexport[$i][3]=$pend[$j]['MOBILE_NO'];
				$dataexport[$i][4]=$pend[$j]['SEND_DATE'];
				$dataexport[$i][5]=$pend[$j]['UPDATE_DATE'];
				$dataexport[$i][6]=$pend[$j]['CALL_ATTEMPT_DATE'];
				$dataexport[$i][7]=$pend[$j]['CALL_DURATION'];
				$dataexport[$i][8]=$pend[$j]['CALL_DISPOSITION']; 
			}

			Yii::import('application.extensions.phpexcel.JPhpExcel');
			$xls = new JPhpExcel('UTF-8', false, 'Predictive Report');
			$xls->addArray($dataexport);
			$xls->generateXML('Predictiv-Report');
		}
		else
		{
			return $pend;
		}                               
	}                                              

  public function getLead_dashboard_new($request)
    {
    $dtime= $request->getParam('start_date',strtoupper(date("d-M-Y"))); 
    $sel_pool= $request->getParam('drp_pool','All'); 
    $sel_rtype= $request->getParam('rtype','S'); 
      $obj = new Globalconnection();
        $model = new GlobalmodelForm();
      $ETO_OFR_TEMP_DEL='ETO_OFR_TEMP_DEL';
       $pendData_unique=array();
       $pendData_bl=$pendData_user=$flagged_bl=$fresh_bl='';
	   $appData_bl='';
	   $appData_user='';
	   $genData_bl='';
       $pendData=$deletedEnquiry=array();
       $current_date=0; 
	   $genData_user='';
      if(strtotime(date("d-M-Y")) == strtotime(date("d-M-Y",strtotime($dtime)))){       
		$dbh=$obj->connect_db_yii('postgress_web68v');
           $LEAP_ACTIVITY_STATS='LEAP_ACTIVITY_STATS';
           $ETO_OFR_FROM_FENQ='ETO_OFR_FROM_FENQ';
           $current_date=1;
        }else{
           echo 'This option is temporary Unavailbale for Old Days data.';exit;            
            $diff_sec=strtotime(date("d-M-Y")) - strtotime(date("d-M-Y",strtotime($dtime)));
            $days    = floor($diff_sec / 86400);   
            if($days > 15){
                $ETO_OFR_TEMP_DEL='ETO_OFR_TEMP_DEL_ARCH';
            }
            
            $LEAP_ACTIVITY_STATS='LEAP_ACTIVITY_STATS_ARCH';
            $ETO_OFR_FROM_FENQ='ETO_OFR_FROM_FENQ_ARCH';
        }        
  
   $poolcondition=$sel_pool_proc='';
   if($sel_pool=='DNC-INDIA'){
        $sel_pool_proc='DNC-INDIA';
        $poolcondition=" AND coalesce(USER_IDENTIFIER_FLAG,0) IN (13,15,2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) ";    
   }elseif($sel_pool=='MUST CALL'){
       $sel_pool_proc='MUST CALL';
        $poolcondition=" AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12,26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) ";   
   }elseif($sel_pool=='INTENT'){ 
        $sel_pool_proc='INTENT';
        $poolcondition=" AND coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) ";        
   }
   if($sel_rtype=='D'){
       $obj = new Globalconnection();
	   $dbh_pg=$obj->connect_db_oci('postgress_web68v');     
       $params = array($dtime,$sel_pool_proc);      
       $query = "SELECT * from SP_GET_PENDING_BL_CNT_V2($1,$2);";      
        $tr=pg_query_params($dbh_pg,$query,$params);
        $r=pg_fetch_all($tr);
        $out_cur_cnt=$r[0]['pending_bl_cnt_cur'];
        $genDatacursor_data1=json_decode($out_cur_cnt,true);
        foreach($genDatacursor_data1 as $rec){
        $genData=array_change_key_case($rec, CASE_UPPER);
	}
       
//echo '---- SP_GET_PENDING_BL_CNT_V2 end';
       $cursor_data='';
        $deletedEnquirySql="SELECT COUNT(distinct case when ( ETO_OFR_DELETIONDATE > to_date('$dtime', 'DD-Mon-YYYY HH24:MI:SS') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '1 hour') AND DATE_R > to_date('$dtime', 'DD-Mon-YYYY HH24:MI:SS') AND DATE_R <=(date('$dtime')+interval '1 hour')) then ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT1, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '1 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '2 hour') AND DATE_R > (date('$dtime')+interval '1 hour') AND DATE_R <=(date('$dtime')+interval '2 hour')) THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT2, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '2 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '3 hour') ) AND DATE_R > (date('$dtime')+interval '2 hour') AND DATE_R <=(date('$dtime')+interval '3 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT3, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '3 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '4 hour') ) AND DATE_R > (date('$dtime')+interval '3 hour') AND DATE_R <=(date('$dtime')+interval '4 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT4, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '4 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '5 hour') ) AND DATE_R > (date('$dtime')+interval '4 hour') AND DATE_R <=(date('$dtime')+interval '5 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT5, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '5 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '6 hour') ) AND DATE_R > (date('$dtime')+interval '5 hour') AND DATE_R <=(date('$dtime')+interval '6 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT6, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '6 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '7 hour') ) AND DATE_R > (date('$dtime')+interval '6 hour') AND DATE_R <=(date('$dtime')+interval '7 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT7, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '7 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '8 hour') ) AND DATE_R > (date('$dtime')+interval '7 hour') AND DATE_R <=(date('$dtime')+interval '8 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT8, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '8 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+ interval '9 hour')) AND DATE_R > (date('$dtime')+interval '8 hour') AND DATE_R <=(date('$dtime')+ interval '9 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT9, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+ interval '9 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '10 hour')) AND DATE_R > (date('$dtime')+ interval '9 hour') AND DATE_R <=(date('$dtime')+interval '10 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT10, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '10 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+ interval '11 hour')) AND DATE_R > (date('$dtime')+interval '10 hour') AND DATE_R <=(date('$dtime')+ interval '11 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT11, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+ interval '11 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '12 hour') ) AND DATE_R > (date('$dtime')+ interval '11 hour') AND DATE_R <=(date('$dtime')+interval '12 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT12, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '12 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '13 hour') ) AND DATE_R > (date('$dtime')+interval '12 hour') AND DATE_R <=(date('$dtime')+interval '13 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT13, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '13 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '14 hour') ) AND DATE_R > (date('$dtime')+interval '13 hour') AND DATE_R <=(date('$dtime')+interval '14 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT14, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '14 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '15 hour') ) AND DATE_R > (date('$dtime')+interval '14 hour') AND DATE_R <=(date('$dtime')+interval '15 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT15, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '15 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '16 hour') ) AND DATE_R > (date('$dtime')+interval '15 hour') AND DATE_R <=(date('$dtime')+interval '16 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT16, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '16 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '17 hour') ) AND DATE_R > (date('$dtime')+interval '16 hour') AND DATE_R <=(date('$dtime')+interval '17 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT17, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '17 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '18 hour')) AND DATE_R > (date('$dtime')+interval '17 hour') AND DATE_R <=(date('$dtime')+interval '18 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT18, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '18 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '19 hour')) AND DATE_R > (date('$dtime')+interval '18 hour') AND DATE_R <=(date('$dtime')+interval '19 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT19, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '19 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '20 hour')) AND DATE_R > (date('$dtime')+interval '19 hour') AND DATE_R <=(date('$dtime')+interval '20 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT20, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '20 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '21 hour')) AND DATE_R > (date('$dtime')+interval '20 hour') AND DATE_R <=(date('$dtime')+interval '21 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT21, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '21 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '22 hour')) AND DATE_R > (date('$dtime')+interval '21 hour') AND DATE_R <=(date('$dtime')+interval '22 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT22, COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '22 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '23 hour')) AND DATE_R > (date('$dtime')+interval '22 hour') AND DATE_R <=(date('$dtime')+interval '23 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT23, 
COUNT(distinct case when ( ETO_OFR_DELETIONDATE > (date('$dtime')+interval '23 hour') AND ETO_OFR_DELETIONDATE <=(date('$dtime')+interval '24 hour')) AND DATE_R > (date('$dtime')+interval '23 hour') AND DATE_R <=(date('$dtime')+interval '24 hour') THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED_CNT24,
COUNT(distinct case when ( DATE_R > (date('$dtime')+ interval '9 hour') AND DATE_R <=(date('$dtime')+interval '10 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT10, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '10 hour') AND DATE_R <=(date('$dtime')+ interval '11 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT11, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+ interval '11 hour') AND DATE_R <=(date('$dtime')+interval '12 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT12, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '12 hour') AND DATE_R <=(date('$dtime')+interval '13 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT13, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '13 hour') AND DATE_R <=(date('$dtime')+interval '14 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT14, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '14 hour') AND DATE_R <=(date('$dtime')+interval '15 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT15, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '15 hour') AND DATE_R <=(date('$dtime')+interval '16 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT16, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '16 hour') AND DATE_R <=(date('$dtime')+interval '17 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT17, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '17 hour') AND DATE_R <=(date('$dtime')+interval '18 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT18, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '18 hour') 
AND DATE_R <=(date('$dtime')+interval '19 hour')) AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT19, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '19 hour') AND DATE_R <=(date('$dtime')+interval '20 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT20, 
COUNT(distinct case when ( DATE_R > (date('$dtime')+interval '20 hour') AND DATE_R <=(date('$dtime')+interval '21 hour')) 
AND extract(day from ETO_OFR_DELETIONDATE - DATE_R) *24*60+extract(hour from ETO_OFR_DELETIONDATE - DATE_R) *60+extract(minute from DATE_R) BETWEEN 0 AND 15 THEN ETO_OFR_DISPLAY_ID end) ENQ_DELETED15_CNT21 
 FROM 
( 
SELECT ETO_OFR_DISPLAY_ID,ETO_OFR_DELETIONDATE,ETO_OFR_POSTDATE_ORIG DATE_R FROM $ETO_OFR_TEMP_DEL WHERE ETO_OFR_TYP = 'B' 
AND date(ETO_OFR_POSTDATE_ORIG) = date(TO_DATE(:start_date_time,'DD-mon-YYYY')) AND date(ETO_OFR_DELETIONDATE) = date(TO_DATE(:start_date_time,'DD-mon-YYYY')) 
$poolcondition  
UNION 
SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,ETO_OFR_FENQ_DATE ETO_OFR_DELETIONDATE,DATE_R FROM $ETO_OFR_FROM_FENQ WHERE FK_ETO_OFR_ID IS NULL 
AND date(DATE_R) = date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) AND date(ETO_OFR_FENQ_DATE) = date(TO_DATE(:start_date_time,'DD-Mon-YYYY')) 
$poolcondition )a ";  
        
        $bind[':start_date_time']=$dtime; 
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $deletedEnquirySql, $bind);//echo $sql; 

		$deletedEnquiry = array();
		if($sth){
			while($rec = $sth->read()) {
				$deletedEnquiry=array_change_key_case($rec, CASE_UPPER);     
			}
		}

      //Procedure added $sel_pool_proc
       // echo 'SP_GET_BL_DISP_FLAGGED_CNT start';
        $params = array($dtime,$sel_pool_proc); 
        $query = "SELECT * from SP_GET_BL_DISP_FLAGGED_CNT($1,$2);";
        $tr=pg_query_params($dbh_pg,$query,$params);
        $r=pg_fetch_all($tr);
        $out_cur_cnt=$r[0]['sp_get_bl_disp_flagged_cnt'];//print_r($out_cur_cnt);
        $flaggedcursor_data1=json_decode($out_cur_cnt,true);
        foreach($flaggedcursor_data1 as $rec){
        $flagged=array_change_key_case($rec, CASE_UPPER);
			}
       //print_r($flagged);//die;
}
        
        $returnArr = array(
            'genData'=>$genData,
            'deletedEnquiry'=> $deletedEnquiry,
            'flagged'=>$flagged,
            'pendData_bl' => $pendData_bl,   
            'pendData_user' => $pendData_user,           
            'appData_bl'=>$appData_bl,
            'appData_user'=>$appData_user,
            'genData_bl'=>$genData_bl,
            'genData_user'=>$genData_user,
            'flagged_bl'=>$flagged_bl,
            'fresh_bl'=>$fresh_bl
        );
       return $returnArr;
    }
       
public function getEmpDetail($request){
        $empId = $request->getParam("empId",'');        
       $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }           
        $empDet=array();
        if(!empty($empId) && $dbh && is_numeric($empId)){
                $sql ="SELECT GL_EMP_NAME,GL_EMP_EMAIL,ETO_LEAP_VENDOR_NAME,ETO_LEAP_EMP_LEVEL,ETO_LEAP_EMP_IS_ACTIVE,SHIFT_TIME,
                    VENDOR_EMPLOYEE_ID,FK_ETO_LEAP_VENDOR_ID,ETO_LEAP_EMP_SKILL_LEVEL,CERTIFICATION_DATE,ETO_LEAP_EMP_EXT_NUM
                FROM GL_EMP,ETO_LEAP_MIS_INTERIM WHERE GL_EMP_ID = ETO_LEAP_EMP_ID AND GL_EMP_ID = :EMP_ID";
                $bind[':EMP_ID']=$empId; 
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                while($rec = $sth->read()) {
                        $empDet=array_change_key_case($rec, CASE_UPPER);     
                   }
                }
                return $empDet;
}

	public function getNumberDetail($request){
		$number = $_REQUEST['number'];
		$obj = new Globalconnection();
		$host_name = $_SERVER['SERVER_NAME'];
    if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net'){
				$dbh = $obj->connect_db_oci('postgress_web77v');
      }else{                        
				$dbh = $obj->connect_db_oci('postgress_web68v');
			}
    
		if(!empty($number)){
			$sqlPhoneDet = "select CALL_CENTER_NUMBER,CALL_NUMBER_VENDOR_TYPE,UPPER(CALL_NUMBER_VENDOR_NAME) CALL_NUMBER_VENDOR_NAME,
											CALL_NUMBER_STATUS,CALL_NUMBER_CHANNEL,CALL_NUMBER_SERV_PROVIDER,CALL_NUMBER_VENDOR_OWNERSHIP
												FROM CALL_CENTER_NUMBERS WHERE CALL_CENTER_NUMBER = '$number'";
												
			$sthSel =pg_query($dbh,$sqlPhoneDet);
			$empDet = pg_fetch_array($sthSel);
			if($empDet){
			$empDet= array_change_key_case($empDet,CASE_UPPER);
		}
			return $empDet;
		}
	}
        
	public function addnumber($request,$empId) {
		$phoneno = $_REQUEST['add_number'];
		$vendortype = $_REQUEST['add_vendor_type'];
		$vendorName = $_REQUEST['add_vendor_name'];
		$status = $_REQUEST['add_status'];
		$channel = $_REQUEST['add_channel'];
		$serviceprovider= $_REQUEST['add_srvc_prvdr'];
		$noowner=$_REQUEST['add_no_owner'];
		$param=$response=array();
                
		if(empty($phoneno)){
			$msg = array("status" => "Fail","msg" => "Phone Number can't be empty");
			return $msg;		
		}
		
// Service Implementation WAPI

	$serv_model =new ServiceGlobalModelForm();
		$param['token']	='imobile1@15061981';
		$param['modid']	='GLADMIN';
		$param['action']	='Insert';
	  $param['CALL_CENTER_NUMBER']=$phoneno;
	  $param['CALL_NUMBER_VENDOR_TYPE']	=$vendortype;
	  $param['CALL_NUMBER_VENDOR_NAME']	=$vendorName;
	  $param['CALL_NUMBER_STATUS']	=$status;
	  $param['CALL_NUMBER_ADDED_BY_EMPID']	=$empId;
	  $param['CALL_NUMBER_CHANNEL']	=$channel;
	  $param['CALL_NUMBER_SERV_PROVIDER']	=$serviceprovider;
		$param['CALL_NUMBER_VENDOR_OWNERSHIP']	=$noowner;

		$host_name = $_SERVER['SERVER_NAME'];
    if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net'){
			$curl="http://dev-leads.imutils.com/wservce/glreport/ccn/";
      }else{                        
			$curl="http://leads.imutils.com/wservce/glreport/ccn/";
			}
	
		$response=$serv_model->mapiService('CALLCENTER',$curl,$param,'No');
		$code=isset($response["Response"]["Code"])?$response["Response"]["Code"]:'';
		$message=isset($response["Response"]["Message"])?$response["Response"]["Message"]:'';
		if($code==200){
			return array("status" => "Success",'msg' => "Number added successfully");  
		}else{
			return array("status" => "Fail",'msg' =>$message);	
                }
	}
        
  public function updatenumber($request,$empId) {
		$obj = new Globalconnection();
		$host_name = $_SERVER['SERVER_NAME'];
		$dbh = $obj->connect_db_oci('postgress_web68v');	
		
		$phoneno = $_REQUEST['update_number'];
		$status = $_REQUEST['update_status'];
		if(empty($phoneno)){
			$msg = array("status" => "Fail","msg" => "Phone Number can not be empty");
			return $msg;		
		}
		$sqlSel = "SELECT CALL_NUMBER_STATUS OLD_STATUS,CALL_CENTER_NUMBER CNT FROM CALL_CENTER_NUMBERS WHERE CALL_CENTER_NUMBER ='$phoneno'";
		$sthSel =pg_query($dbh,$sqlSel);	
		$empCount = pg_fetch_array($sthSel);
		$old=isset($empCount['old_status'])?$empCount['old_status']:0;

		if(!empty($empCount['cnt']) && $empCount['cnt'] != 0){
		if($old!=$status && is_numeric($phoneno)){
// Service Implementation WAPI

$serv_model =new ServiceGlobalModelForm();
$param['token']	='imobile1@15061981';
$param['modid']	='GLADMIN';
$param['action']	='Update';
$param['CALL_CENTER_NUMBER']=$phoneno;
$param['CALL_NUMBER_STATUS']	=$status;
$param['CALL_NUMBER_UPDATE_BY_EMPID']	=$empId;
$host_name = $_SERVER['SERVER_NAME'];

    if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net'){
			$curl="http://dev-leads.imutils.com/wservce/glreport/ccn/";
      }else{                        
			$curl="http://leads.imutils.com/wservce/glreport/ccn/";
			}
			
		

$response=$serv_model->mapiService('MCAT',$curl,$param,'No');
$code=isset($response["Response"]["Code"])?$response["Response"]["Code"]:'';
$message=isset($response["Response"]["Message"])?$response["Response"]["Message"]:'';

if($code==200){
	if($status==0)
			{$x="Inactive";
			}else{
				$x="Active";
			}
		$cc      = '';
		$to      ='leap@indiamart.com';
	$from    = 'gladmin-team@indiamart.com';
	$headers = "From:$from \n" . "Reply-To:$to\n" . "Cc:$cc\n" . "MIME-Version: 1.0 \n" . "Content-type: text/html; charset=UTF-8";
	$output= "Following changes done: $phoneno is updated as $x. Please change accordingly in the exemption list.";
	mail($to, "Modification in Call Center calling no", $output, $headers);
		}
		else{
					return array("status" => "Fail",'msg' => $message);	
		}	
		if($code != 200){
			return array("status" => "Fail",'msg' => $message);	
		}
		return array("status" => "Success",'msg' => "Number updated successfully");
		}
		else{
				return array("status" => "Fail",'msg' => "Please change status to update.");
		}
		}
		else {
			return array("status" => "Fail",'msg' => "Phone Number Does not exists");		
		}
	}     

        
	public function addVendorLeapMis($request) {
		$empId = $request->getParam('emp_id','');	
		$vendorName_arr = explode("|",$request->getParam('vendor_name',''));
		$vendor_id=$vendorName_arr[0];
		$vendorName=$vendorName_arr[1];
		$empLevel = $request->getParam('emp_level','');
		$st1 = $request->getParam('st1','');	
		$st2= $request->getParam('st2','');	
		$shifttime = $st1 .'-'.$st2;	
		$vendor_emp_id = $request->getParam('vendor_emp_id','');
                $empskillLevel = $request->getParam('emp_skill_level','');

		if(empty($empId) || empty($vendorName) || $empLevel == '' || $empskillLevel == ''){
			$msg = array("status" => "Fail","msg" => "Employee Ids /Vendor Name / Employee Level can not be empty");
			return $msg;		
		}

			// Service Implementation WAPI
			$serv_model =new ServiceGlobalModelForm();
			$param['token']	='imobile1@15061981';
			$param['modid']	='GLADMIN';
			$param['action']	='Insert';
			$param['ETO_LEAP_EMP_ID']=$empId;
			$param['ETO_LEAP_VENDOR_NAME']	=$vendorName;
			$param['ETO_LEAP_EMP_LEVEL']	=$empLevel;
			$param['SHIFT_TIME']	=$shifttime;
			$param['VENDOR_EMPLOYEE_ID']	=$vendor_emp_id;
			$param['FK_ETO_LEAP_VENDOR_ID']	=$vendor_id;
			$param['ETO_LEAP_EMP_SKILL_LEVEL']	=$empskillLevel; 
                        if($empskillLevel==20){
                            $param['CERTIFICATION_DATE']	= date("d-m-Y");  
                        }
                        if($vendorName=='DNCTRAIN'){
                            $param['ETO_LEAP_EMP_PROCESS_LEVEL']= 2;
                        }elseif($vendorName=='OAP_TRAINING'){
                            $param['ETO_LEAP_EMP_PROCESS_LEVEL']= 1;
                        }
			// echo "param array <pre>";print_r($param);
			$host_name = $_SERVER['SERVER_NAME'];
			if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net'){
				$curl = 'http://stg-leads.imutils.com/wservce/glreport/elm/';
				}else{                        
				$curl = 'http://leads.imutils.com/wservce/glreport/elm/';
				}	  
				
			$response=$serv_model->mapiService('LEAPMIS',$curl,$param,'No');
			// echo "Service Response <pre>";print_r($response);
			$code=isset($response["Response"]["Code"])?$response["Response"]["Code"]:'';
			$message=isset($response["Response"]["Message"])?$response["Response"]["Message"]:'';
		
			if($code==200){
                    return array("status" => "Success",'msg' => "Agent added successfully");  
		}else{
                    return array("status" => "Fail",'msg' => $message);	
                }
	}
	
	public function updateVendorLeapMis($request) {
		$empId = $request->getParam('emp_id','');	
		$vendorName_arr = explode("|",$request->getParam('vendor_name',''));
		$empLevel = $request->getParam('emp_level','');
        $empskillLevel = $request->getParam('emp_skill_level','');
        $certification_date = $request->getParam('certification_date','');
		$isWorking = $request->getParam('is_working',0);
		$st1 = $request->getParam('st1','');	
		$st2= $request->getParam('st2','');	
		$shifttime = $st1 .'-'.$st2;		
		$vendor_emp_id = $request->getParam('vendor_emp_id','');
		$ext_no= $request->getParam('extension_no','');
		$vendor_id=$vendorName_arr[0];
		$vendorName=$vendorName_arr[1];
		if($isWorking == 1){
                    $isWorking = -1;
		}
		if(empty($empId) || empty($vendorName) || $empLevel == '' || $empskillLevel == ''){
			$msg = array("status" => "Fail","msg" => "Employee Ids /Vendor Name / Employee Level can not be empty");
			return $msg;		
		}
		$obj = new Globalconnection();
                $model = new GlobalmodelForm(); 	
				if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
               
$empCount=array();
$sqlSel = "SELECT COUNT(1) CNT FROM ETO_LEAP_MIS_INTERIM WHERE ETO_LEAP_EMP_ID = :EMPID";
$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sqlSel, array(":EMPID"=>$empId));//echo $sql;        
while($rec = $sth->read()) {
        $empCount=array_change_key_case($rec, CASE_UPPER);                     
   }
$cnt = isset($empCount['CNT'])?$empCount['CNT']:0;
if(!empty($empCount['CNT']) && $empCount['CNT'] != 0){
			// Service Implementation WAPI
			$serv_model =new ServiceGlobalModelForm();
			$param['token']	='imobile1@15061981';
			$param['modid']	='GLADMIN';
			$param['action']	='Update';
			$param['ETO_LEAP_EMP_ID']	=$empId;
			$param['ETO_LEAP_VENDOR_NAME']	=$vendorName;
			$param['ETO_LEAP_EMP_LEVEL']	=$empLevel;
			$param['ETO_LEAP_EMP_IS_ACTIVE']=$isWorking;
			$param['SHIFT_TIME']	=$shifttime;
			$param['VENDOR_EMPLOYEE_ID']	=$vendor_emp_id;
			$param['FK_ETO_LEAP_VENDOR_ID']	=$vendor_id;
			$param['ETO_LEAP_EMP_EXT_NUM']	=$ext_no;
			//ETO_LEAP_EMP_EXT_NUM
                        $param['ETO_LEAP_EMP_SKILL_LEVEL']	=$empskillLevel;
                        if(($empskillLevel==20) && ($certification_date=='')){
                            $param['CERTIFICATION_DATE']	= date("d-m-Y");
                        }
                        if($vendorName=='DNCTRAIN'){
                            $param['ETO_LEAP_EMP_PROCESS_LEVEL']= 2;
                        }elseif($vendorName=='OAP_TRAINING'){
                            $param['ETO_LEAP_EMP_PROCESS_LEVEL']= 1;
                        }
			$host_name = $_SERVER['SERVER_NAME'];
			if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net'){
				$curl = 'http://dev-leads.imutils.com/wservce/glreport/elm/';
				}else{                        
				$curl = 'http://leads.imutils.com/wservce/glreport/elm/';
				}	  
			$response=$serv_model->mapiService('LEAPMIS',$curl,$param,'No');
			if(isset(Yii::app()->session['empid']) && (Yii::app()->session['empid']==86777)){
				echo "url <pre>";print_r($curl);
                        echo "param array <pre>";print_r($param);
                        echo "Service Response <pre>";print_r($response);
                        }
					//	exit;
			$code=isset($response["Response"]["Code"])?$response["Response"]["Code"]:'';
			$message=isset($response["Response"]["Message"])?$response["Response"]["Message"]:'';
			if($code==200){
				return array("status" => "Fail",'msg' => "Agent updated successfully");	
		}else{
				return array("status" => "Fail",'msg' => $message);	
					}
				}
				else {
					return array("status" => "Fail",'msg' => "Employee Does not exist");		
				}	
	} 
	
public function pending_rpt($postgre,$request)
 {
      $dtime= $request->getParam('start_date',strtoupper(date("d-M-Y"))); 
      $obj = new Globalconnection();       
      $model = new GlobalmodelForm();      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        
$pendingDataSql_User="
                     SELECT
                        COUNT(distinct FK_GLUSR_USR_ID) PENDING_USERS,  
                        COUNT(CASE WHEN FOREIGN_COUNT > 0 THEN FK_GLUSR_USR_ID END) PENDING_FOREIGN_USER,
                        COUNT(CASE WHEN DNC_COUNT > 0 AND FOREIGN_COUNT=0 THEN FK_GLUSR_USR_ID END) PENDING_DNC_USER,
                        COUNT(CASE WHEN MUST_CALL_COUNT > 0 AND DNC_COUNT=0 AND FOREIGN_COUNT=0 THEN FK_GLUSR_USR_ID END) PENDING_MUST_CALL_USER,
                        COUNT(CASE WHEN INTENT_COUNT > 0 AND MUST_CALL_COUNT=0 AND DNC_COUNT=0 AND FOREIGN_COUNT=0 THEN FK_GLUSR_USR_ID END) PENDING_INTENT_USER
                      FROM
                        (
                            SELECT FK_GLUSR_USR_ID,
                               COUNT(CASE WHEN NVL(ETO_OFR_IS_FLAGGED,0)  IN (0,20) AND NVL(USER_IDENTIFIER_FLAG,0) IN (11,12,26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) AND S_COUNTRY_UPPER IN ('INDIA','IN') THEN 1 END) MUST_CALL_COUNT,
                               COUNT(CASE WHEN NVL(ETO_OFR_IS_FLAGGED,0)  IN (0,20) AND NVL(USER_IDENTIFIER_FLAG,0) IN (13,15,2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) AND S_COUNTRY_UPPER IN ('INDIA','IN')THEN 1 END) DNC_COUNT,
                               COUNT(CASE WHEN NVL(ETO_OFR_IS_FLAGGED,0)  IN (0,20) AND  NVL(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) AND S_COUNTRY_UPPER IN ('INDIA','IN') THEN 1 END) INTENT_COUNT,
                               COUNT(CASE WHEN NVL(ETO_OFR_IS_FLAGGED,0)  IN (0,20) AND S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1  END) FOREIGN_COUNT
                            FROM
                                   DIR_QUERY_FREE
                              WHERE
                                  coalesce(ETO_OFR_IS_FLAGGED,0) IN (0,20,21) 
                              GROUP BY FK_GLUSR_USR_ID
                       )  ";  
                    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $pendingDataSql_User, array());//echo $sql;        
                    while($rec = $sth->read()) {
                            $pendData_user=array_change_key_case($rec, CASE_UPPER);                     
                       }

                     $pendingDataSql_bl="SELECT
                            sum(CASE
                                    WHEN coalesce(eto_ofr_is_flagged,0) IN(0,20)
                                    THEN 1 else 0
                                END
                            ) pending_leads,
                            sum(CASE
                                    WHEN coalesce(eto_ofr_is_flagged,0) IN(0,20)
                                         AND nvl(user_identifier_flag,0) IN(11,12,26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59)
                                         AND s_country_upper IN('INDIA','IN') 
                                                THEN 1 else 0
                                END
                            ) pending_must_call,
                            sum(CASE
                                    WHEN coalesce(eto_ofr_is_flagged,0) IN(0,20)
                                         AND nvl(user_identifier_flag,0) IN(13,15,2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99)
                                         AND s_country_upper IN('INDIA','IN')
                                    THEN 1 else 0
                                END
                            ) pending_dnc,  
                            sum(CASE
                                    WHEN s_country_upper NOT IN('INDIA','IN')
                                         AND nvl(eto_ofr_is_flagged,0) = 0 
                                                THEN 1 else 0
                                END
                            ) pending_foreign,
                            sum(CASE
                                    WHEN coalesce(user_identifier_flag,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)
                                         AND s_country_upper IN('INDIA','IN')
                                    THEN 1 else 0
                                END
                            ) pending_intent
                        FROM(
                                SELECT
                                    user_identifier_flag,
                                    s_country_upper,
                                    eto_ofr_is_flagged
                                FROM
                                    dir_query_free
                                WHERE
                                    coalesce(eto_ofr_is_flagged,0) IN (0, 20,21)
                            )  ";  
                    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $pendingDataSql_bl, array());//echo $sql;        
                    while($rec = $sth->read()) {
                            $pendData_bl=array_change_key_case($rec, CASE_UPPER);                     
                       }
                    $sql_tot="SELECT LEAP_VENDOR_NAME,CALL_DURATION,count(1) PENDING_CNT from LEAP_DIALER_RESPONSE WHERE coalesce(UPDATE_DATE,'01-APR-1996')='01-APR-1996' group by LEAP_VENDOR_NAME,CALL_DURATION";
                    
                   $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_tot, array());//echo $sql;        
                    while($rec = $sth->read()) {
                            $pendingtot_pred_sth=array_change_key_case($rec, CASE_UPPER);                     
                       }                    
                    return array($pendData_user,$pendData_bl,$pendingtot_pred_sth);
 }
 
 public function timeliness_rpt()
	{
		$GlobalmodelForm	= 	new GlobalmodelForm();

		$start = $_REQUEST['start_date'];
		$sysDate = strtoupper(date("d-M-Y"));
		$data =array();		
		$obj = new Globalconnection();
                $model = new GlobalmodelForm();
                
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
		//Pool wise condition block starts
		$poolClause = '';
		$poolType = isset($_REQUEST['drp_pool']) ? $_REQUEST['drp_pool'] : '';
		if($poolType == 'All'){
			$poolClause = "";
		}elseif($poolType == 'MUST CALL'){
			$poolClause = "AND UIF = 'MUSTCALL'";	
		}elseif($poolType == 'DNC-INDIA'){
			$poolClause = "AND UIF = 'DNC-INDIA'";	
		}elseif($poolType == 'DNC-FOREIGN'){
			$poolClause = "AND UIF = 'DNC-FOREIGN'";	
		}elseif($poolType == 'INTENT'){
			$poolClause = "AND UIF = 'INTENT'";	
		}
		
		//Vendor wise condition block starts
		$vendorName = isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
		$vendorVal = str_replace(",","','",$vendorName);
		
		$vendorClause = ($vendorName == '' || $vendorName == 'ALL' ) ? '' : "AND ETO_LEAP_VENDOR_NAME IN ('$vendorVal')";
                    $sql = "SELECT HR, SUM(APP_DEL) TOTAL_APPROVED, SUM(GEN_COUNT) GEN, SUM(APP_CNT) APP_WITH_IN_15MIN, SUM(DEL_cnt) DEL_WITH_IN_15MIN
				FROM    
				(
SELECT HR, COUNT(1) GEN_COUNT, SUM(CASE WHEN (ACTIONS = 4 OR ACTIONS = 5) 
								   AND TIME_DIFF::INTEGER <= 15 THEN 1 ELSE 0 END) APP_DEL,
SUM(CASE WHEN ACTIONS = 5 AND TIME_DIFF <= 15 THEN 1 ELSE 0 END) APP_CNT,
SUM(CASE WHEN ACTIONS = 4 AND TIME_DIFF <= 15 THEN 1 ELSE 0 END) DEL_CNT
					FROM
					( 
SELECT TO_CHAR(P_DATE, 'HH24')::INTEGER HR, UIF, ACTIONS  , 
	--((A_DATE - P_DATE)*24*60) 
	extract(day from A_DATE - P_DATE) *24*60
+  extract(hour from A_DATE - P_DATE) *60 +
extract(minute from A_DATE - P_DATE) TIME_DIFF
					  FROM
						(
		SELECT ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG P_DATE, ETO_OFR_APPROV_DATE A_DATE, 
	5::integer ACTIONs, FK_EMPLOYEE_ID EMPID,
							(CASE WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND  UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC-FOREIGN' 
                                                        WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' 
                                                        WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN  'MUSTCALL'
                                                        WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN  'INTENT'
                                                        WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN  'DNC-INDIA'
                                                        WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN  'INTENT'
                                                        ELSE 'UNDEFINED' END) UIF, 'DIRECT' SRC
							FROM ETO_OFR
		WHERE date(ETO_OFR_POSTDATE_ORIG) BETWEEN to_date(:START_DATE,'DD-MON-YYYY') AND to_date(:END_DATE,'DD-MON-YYYY') AND FK_GL_MODULE_ID <> 'FENQ'
							UNION
		SELECT ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG P_DATE, ETO_OFR_APPROV_DATE A_DATE, 5 ACTIONs,FK_EMPLOYEE_ID EMPID,
							(CASE WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND  UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC-FOREIGN' 
							WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' 
                                                        WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN  'MUSTCALL'
                                                        WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN  'INTENT'
                                                        WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN  'DNC-INDIA'
                                                        WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN  'INTENT'
                                                        ELSE 'UNDEFINED' END) UIF, 'DIRECT' SRC
							FROM ETO_OFR_EXPIRED
		WHERE date(ETO_OFR_POSTDATE_ORIG) BETWEEN to_date(:START_DATE,'DD-MON-YYYY') AND to_date(:END_DATE,'DD-MON-YYYY')  AND FK_GL_MODULE_ID <> 'FENQ'
							UNION
		SELECT ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG P_DATE, ETO_OFR_DELETIONDATE A_DATE, 4 ACTIONs,coalesce(FK_EMPLOYEE_ID,ETO_OFR_DELETEDBYID) EMPID,
							(CASE WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND  UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC-FOREIGN' 
							WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' 
                                                        WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN  'MUSTCALL'
                                                        WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN  'INTENT'
                                                        WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN  'DNC-INDIA'
                                                        WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN  'INTENT'
                                                        ELSE 'UNDEFINED' END) UIF, 'DIRECT' SRC
							FROM ETO_OFR_TEMP_DEL
		WHERE date(ETO_OFR_POSTDATE_ORIG) BETWEEN to_date(:START_DATE,'DD-MON-YYYY') AND to_date(:END_DATE,'DD-MON-YYYY') AND FK_GL_MODULE_ID <> 'FENQ'
							UNION
		SELECT ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG P_DATE, ETO_OFR_DELETIONDATE A_DATE, 4 ACTIONs,coalesce(FK_EMPLOYEE_ID,ETO_OFR_DELETEDBYID) EMPID,
							(CASE WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND  UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC-FOREIGN' 
							WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' 
                                                        WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN  'MUSTCALL'
                                                        WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN  'INTENT'
                                                        WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN  'DNC-INDIA'
                                                        WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN  'INTENT'
                                                        ELSE 'UNDEFINED' END) UIF, 'DIRECT' SRC
							FROM ETO_OFR_TEMP_DEL_ARCH
		WHERE date(ETO_OFR_POSTDATE_ORIG) BETWEEN to_date(:START_DATE,'DD-MON-YYYY') AND to_date(:END_DATE,'DD-MON-YYYY') AND FK_GL_MODULE_ID <> 'FENQ'
							UNION
		SELECT DIR_QUERY_FREE_REFID,DATE_R P_DATE, ETO_OFR_FENQ_DATE A_DATE, CASE WHEN FK_ETO_OFR_ID IS NULL THEN 4 ELSE 5 END ACTIONs,coalesce(ETO_OFR_FENQ_EMP_ID,FK_EMPLOYEEID) EMPID,
							(CASE WHEN (UPPER(S_COUNTRY_UPPER) <> 'INDIA' AND  UPPER(S_COUNTRY_UPPER) <> 'IN') THEN 'DNC-FOREIGN' 
							WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' 
                                                        WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN  'MUSTCALL'
                                                        WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN  'INTENT'
                                                        WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN  'DNC-INDIA'
                                                        WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN  'INTENT'
		ELSE 'UNDEFINED' END) UIF,
		case when QUERY_MODID ='INTENT' then 'INTENT' else 'FENQ' END SRC
							FROM ETO_OFR_FROM_FENQ
		WHERE date(DATE_R) BETWEEN to_date(:START_DATE,'DD-MON-YYYY') AND to_date(:END_DATE,'DD-MON-YYYY')
							UNION
		SELECT DIR_QUERY_FREE_REFID,DATE_R P_DATE, ETO_OFR_FENQ_DATE A_DATE, CASE WHEN FK_ETO_OFR_ID IS NULL THEN 4 ELSE 5 END ACTIONs,coalesce(ETO_OFR_FENQ_EMP_ID,FK_EMPLOYEEID) EMPID,
							(CASE WHEN (UPPER(S_COUNTRY_UPPER) <> 'INDIA' AND  UPPER(S_COUNTRY_UPPER) <> 'IN') THEN 'DNC-FOREIGN' 
							WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' 
                                                        WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN  'MUSTCALL'
                                                        WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN  'INTENT'
                                                        WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN  'DNC-INDIA'
                                                        WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN  'INTENT'
		ELSE 'UNDEFINED' END) UIF,
		case when QUERY_MODID ='INTENT' then 'INTENT' else 'FENQ' END SRC
							FROM ETO_OFR_FROM_FENQ_ARCH
		WHERE date(DATE_R) BETWEEN to_date(:START_DATE,'DD-MON-YYYY') AND to_date(:END_DATE,'DD-MON-YYYY') 
							UNION
		SELECT ETO_OFR_DISPLAY_ID,DATE_R P_DATE, NOW() + '1 DAY'::INTERVAL A_DATE,0 ACTIONs,FK_EMPLOYEE_ID EMPID,
							(CASE WHEN (UPPER(S_COUNTRY_UPPER) <> 'INDIA' AND  UPPER(S_COUNTRY_UPPER) <> 'IN') THEN 'DNC-FOREIGN' 
							WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' 
                                                        WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN  'MUSTCALL'
                                                        WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN  'INTENT'
                                                        WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN  'DNC-INDIA'
                                                        WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN  'INTENT'
		ELSE 'UNDEFINED' END) UIF,
		case when QUERY_MODID ='INTENT' then 'INTENT'
                ELSE CASE WHEN DIR_QUERY_FREE_BL_TYP = 1 THEN 'DIRECT' else 'FENQ' END END SRC
							FROM DIR_QUERY_FREE
		WHERE date(DATE_R) BETWEEN to_date(:START_DATE,'DD-MON-YYYY') AND to_date(:END_DATE,'DD-MON-YYYY')
) a left outer join  ETO_LEAP_MIS_INTERIM on  ETO_LEAP_EMP_ID = EMPID $vendorClause $poolClause 
					) DATA_CHUNK
					GROUP BY HR
) a
				GROUP BY HR
				ORDER BY HR";
                
		$sth = $GlobalmodelForm->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(":START_DATE"=>$start ,":END_DATE"=>$start ));	
		while($rec = $sth->read()) {
                        $row=array_change_key_case($rec, CASE_UPPER);    
			$hour = $row['HR'];
			$data[$hour] = $row;
		}
		return $data;
	}
        
  public function review_pool_timeliness_rpt(){
        $start = $_REQUEST['start_date'];
        $data =array();		
        $emp_id = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
	$obj = new Globalconnection();
	$host_name = $_SERVER['SERVER_NAME'];
    $dbh=$obj->connect_db_oci('postgress_web68v');
        $vendorName = isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
        $vendorVal = str_replace(",","','",$vendorName);
		
       
        $cond = " AND date(GL_PROFILE_AUDIT_DATE)='$start'";
        if($vendorVal <>'')
        {     
              $vendorClause = ($vendorName == '' || $vendorName == 'ALL' ) ? '' : "AND ETO_LEAP_VENDOR_NAME IN ('$vendorVal')";
                  
                $cond .=$vendorClause;               
        }
        
        $sql = "SELECT DATE_PART('hour', gl_profile_audit_date::TIMESTAMP) HR,
  COUNT(1) GEN_COUNT,
  COUNT(CASE WHEN minss::NUMERIC <= 5 THEN 1  ELSE NULL END ) timeliness,
  COUNT(CASE WHEN minss::NUMERIC <= 5 AND GL_PROFILE_AUDIT_STATUS='0' THEN 1 WHEN minss::NUMERIC <= 5 AND GL_PROFILE_AUDIT_STATUS='1' THEN 1 WHEN minss::NUMERIC <= 5 AND GL_PROFILE_AUDIT_STATUS='2' THEN 1 WHEN minss::NUMERIC <= 5 AND GL_PROFILE_AUDIT_STATUS='3' THEN 1  ELSE NULL END ) APP_DEL,
  COUNT(CASE WHEN minss::NUMERIC <= 2 THEN 1  ELSE NULL END ) timeliness_2,
  COUNT(CASE WHEN minss::NUMERIC <= 2 AND GL_PROFILE_AUDIT_STATUS='0' THEN 1 WHEN minss::NUMERIC <= 2 AND GL_PROFILE_AUDIT_STATUS='1' THEN 1 WHEN minss::NUMERIC <= 2 AND GL_PROFILE_AUDIT_STATUS='2' THEN 1 WHEN minss::NUMERIC <= 2 AND GL_PROFILE_AUDIT_STATUS='3' THEN 1  ELSE NULL END ) APP_DEL_2,
  COUNT(CASE WHEN minss::NUMERIC <= 1 THEN 1  ELSE NULL END ) timeliness_1,
  COUNT(CASE WHEN minss::NUMERIC <= 1 AND GL_PROFILE_AUDIT_STATUS='0' THEN 1 WHEN minss::NUMERIC <= 1 AND GL_PROFILE_AUDIT_STATUS='1' THEN 1 WHEN minss::NUMERIC <= 1 AND GL_PROFILE_AUDIT_STATUS='2' THEN 1 WHEN minss::NUMERIC <= 1 AND GL_PROFILE_AUDIT_STATUS='3' THEN 1  ELSE NULL END ) APP_DEL_1

FROM
  (SELECT gl_profile_enrichment_date,
    gl_profile_audit_date,
    fk_glusr_usr_id,
    eto_ofr_display_id,
    GL_PROFILE_AUDIT_STATUS,
    (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) minss
  FROM bl_profile_enrichment
  LEFT OUTER JOIN ETO_LEAP_MIS_INTERIM EMP
  ON GL_PROFILE_AUDIT_BY =EMP.ETO_LEAP_EMP_ID
  WHERE fk_gl_attribute_id =222
 $cond
  ) a
GROUP BY DATE_PART('hour', gl_profile_audit_date::TIMESTAMP)";
              

		$sth=pg_query($dbh,$sql); 
		
		while($temp = pg_fetch_array($sth))
		{
			$hour = $temp['hr'];
			$data[$hour] = $temp;
                }
//                echo "<pre>"."data array is";print_r($data);
    return $data;
        
        
  }
        
   public function ISQfeedback($request)
 {
              $reasonDesc = array(
					'1'=>'Wrong isq',
					'2'=>'Missing option',
					'3'=>'Spell error',
					'4'=>'Unable to understand',
                                        '5'=>'Comment'
		);
  $model = new GlobalmodelForm();
  $start_date = $request->getParam('start_date','');
  $end_date = $request->getParam('end_date','');
  $start_time = $request->getParam('start_time',0);
  $end_time = $request->getParam('end_time',24);
  $vendor=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : ''; 
  $vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
  $tlid = $request->getParam('tlselect',0);
  $tlidEmpWise = $request->getParam('tlid',0);
  $tlid = (!empty($tlidEmpWise) ? $tlidEmpWise : (!empty($tlid) ? $tlid : 0));
  $DataFinal=array();
  $tlCond='';
  $venCond='';
  $obj = new Globalconnection();
  $dbh = $obj->connect_db_yii('imblR');
  $datecond=" AND TRUNC(BL_ISQ_FEEDBACK_DATE) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY') ";
    
  
  if($tlid >0)
  {
   $tlCond=" AND ETO_LEAP_TL_ID =:IN_LEAP_ID";
  }
 
  if($vendor <>'ALL')
  {     
    $vendorstr= str_replace(",","','",$vendorVal);
    $venCond=" AND ETO_LEAP_VENDOR_NAME in ('$vendorstr')";
  }
 
  $sql="SELECT TRUNC(BL_ISQ_FEEDBACK_DATE) BL_ISQ_FEEDBACK_DATE,
    FK_REASON_ID,
    count(BL_ISQ_FEEDBACK_ID) CNT_FEEDBACK,
    ETO_LEAP_VENDOR_NAME,
   TABLE_FLAG 
  FROM   
  (
  SELECT BL_ISQ_FEEDBACK_ID,ETO_OFR_APPROV_BY_ORIG,OTHER_REASON_DESC,FK_REASON_ID,BL_ISQ_FEEDBACK_DATE,
  'L' TABLE_FLAG 
  FROM 
  ETO_OFR,BL_ISQ_FEEDBACK 
  WHERE 
  ETO_OFR_DISPLAY_ID=REF_ID 
   $datecond  
  UNION ALL
  SELECT BL_ISQ_FEEDBACK_ID,ETO_OFR_APPROV_BY_ORIG,OTHER_REASON_DESC,FK_REASON_ID,BL_ISQ_FEEDBACK_DATE,'E' TABLE_FLAG 
  FROM 
  ETO_OFR_EXPIRED,BL_ISQ_FEEDBACK 
  WHERE ETO_OFR_DISPLAY_ID=REF_ID 
  $datecond
  ),ETO_LEAP_MIS_INTERIM
  WHERE ETO_LEAP_EMP_ID =ETO_OFR_APPROV_BY_ORIG  
  $venCond $tlCond 
  GROUP BY TRUNC(BL_ISQ_FEEDBACK_DATE), ETO_LEAP_VENDOR_NAME, FK_REASON_ID, TABLE_FLAG
  ORDER BY TRUNC(BL_ISQ_FEEDBACK_DATE), ETO_LEAP_VENDOR_NAME,FK_REASON_ID";
      
     
      $bind[':start_date']=$start_date;
      $bind[':end_date']=$end_date;
      
     if($tlid >0)
     {
      $bind[':IN_LEAP_ID']=$tlid;
     }
    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,$bind);

 $returndata = '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">
        							<tr>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="16%"><b>Date</b></td>                                                                
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="17%"><b>Centre Name</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="16%"><b>Reason ID</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="17%"><b>ISQ Feedback Count</b></td>
        							</tr>';
	 while($temp=$sth->read())
	  {
	   $returndata .= "<tr>
		  <td  style='text-align:left;' >".$temp['BL_ISQ_FEEDBACK_DATE']."</td>
		  <td  style='text-align:left;' >".$temp['ETO_LEAP_VENDOR_NAME']."</td>
                  <td  style='text-align:left;' >".$reasonDesc[$temp['FK_REASON_ID']].' ['.$temp['FK_REASON_ID']."]</td>    
		  <td  style='text-align:center;' ><a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=isqfeedbackdetail&start_date=".$temp["BL_ISQ_FEEDBACK_DATE"]."&tableflag=".$temp["TABLE_FLAG"]."&vendor=".$temp["ETO_LEAP_VENDOR_NAME"]."&total_records=".$temp['CNT_FEEDBACK']."&rid=".$temp['FK_REASON_ID']."'>".$temp["CNT_FEEDBACK"]."</a>";
	  
		  $returndata .= '</tr>';
    }
    $returndata .= '</table>';   							
	echo $returndata;      
 }
   public function ISQfeedbackdetail($request,$action)
 {
       $reasonDesc = array(
					'1'=>'Wrong isq',
					'2'=>'Missing option',
					'3'=>'Spell error',
					'4'=>'Unable to understand',
                                        '5'=>'Comment'
		);
  $model = new GlobalmodelForm();
  $start_date = $request->getParam('start_date','');   
  $vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : ''; 
  $tlid = $request->getParam('tlselect',0);
  $tlidEmpWise = $request->getParam('tlid',0);
  $tlid = (!empty($tlidEmpWise) ? $tlidEmpWise : (!empty($tlid) ? $tlid : 0));
  $start = $request->getParam('start',1);
  $end = $request->getParam('end',500);
  $totalRecords = intval($request->getParam('total_records'));
  $tableflag= $request->getParam('tableflag');
  $reasonid= $request->getParam('rid');
  $DataFinal=array();
  $tlCond='';
  $venCond='';
  $d2=array();
  $obj = new Globalconnection();
  $dbh = $obj->connect_db_yii('imblR');
  
  if($tlid >0)
  {
   $tlCond=" AND ETO_LEAP_TL_ID =:IN_LEAP_ID ";
  }
  
   $venCond=" AND ETO_LEAP_VENDOR_NAME=:IN_VENDOR_NAME ";
   if($tableflag=='E'){
        $table="ETO_OFR_EXPIRED";
   }else{
        $table="ETO_OFR";
   }
  
      
      $sql="SELECT *
FROM
  (SELECT ROW_NUMBER() over (ORDER BY BL_ISQ_FEEDBACK_DATE DESC)RN,
    ETO_LEAP_VENDOR_NAME,
    ETO_LEAP_EMP_NAME,
    ETO_LEAP_EMP_ID ,
    BL_ISQ_FEEDBACK_ID ,
    TRUNC(BL_ISQ_FEEDBACK_DATE) BL_ISQ_FEEDBACK_DATE,
    FK_REASON_ID,
    OTHER_REASON_DESC,
    REF_ID
  FROM BL_ISQ_FEEDBACK,
    ETO_LEAP_MIS_INTERIM,
    $table 
  WHERE ETO_OFR_APPROV_BY_ORIG =ETO_LEAP_EMP_ID
  AND ETO_OFR_DISPLAY_ID =REF_ID
   $venCond $tlCond
  AND TRUNC(BL_ISQ_FEEDBACK_DATE) = TRUNC(to_date(:START_DATE,'DD-MON-YY'))
  AND FK_REASON_ID = :FK_REASON_ID
  ) A
WHERE RN BETWEEN :IN_START_LIMIT AND :IN_END_LIMIT"; 
      
      $bind[':START_DATE']=$start_date;
      $bind[':IN_START_LIMIT']=$start;
      $bind[':IN_END_LIMIT']=$end;
      $bind[':IN_VENDOR_NAME']=$vendor;
      $bind[':FK_REASON_ID']=$reasonid;
     if($tlid >0)
     {
      $bind[':IN_LEAP_ID']=$tlid;
     }
	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,$bind);
if($action=='export'){
     $d1 = array("BL_ISQ_FEEDBACK_DATE","ETO_LEAP_VENDOR_NAME","ETO_LEAP_EMP_NAME","ETO_LEAP_EMP_ID","BL_ISQ_FEEDBACK_ID","REASON","OTHER_REASON_DESC","REF_ID");
     array_push($d2,$d1);   
}else{
   $returndata = '<table style="border-collapse: collapse;align: center;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" >
		<tr>
                <td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>SN</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>BL_ISQ_FEEDBACK_DATE</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>ETO_LEAP_VENDOR_NAME</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>ETO_LEAP_EMP_NAME</b></td>
                <td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>ETO_LEAP_EMP_ID</b></td>
        	<td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>BL_ISQ_FEEDBACK_ID</b></td>
               <td  style="text-align:center;" bgcolor="#dff8ff"  width="20%"><b>REASON</b></td>		
                <td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>OTHER_REASON_DESC</b></td> 
                <td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>REF_ID</b></td>
		</tr>';
}

$cnt=0;
        while($temp=$sth->read())
        {
            $cnt++;
            if($action=='export'){
                 $val = array(
                    $temp['BL_ISQ_FEEDBACK_DATE'],
                    $temp['ETO_LEAP_VENDOR_NAME'],
                    $temp['ETO_LEAP_EMP_NAME'],
                    $temp['ETO_LEAP_EMP_ID'],
                    $temp['BL_ISQ_FEEDBACK_ID'],
                    $reasonDesc[$temp['FK_REASON_ID']].' ['.$temp['FK_REASON_ID'].']',                    
                    $temp['OTHER_REASON_DESC'],
                    $temp['REF_ID']);
                    array_push($d2,$val);              
            }else{
                    $returndata .= '<tr><td  style="text-align:center;" >'.$cnt.'</td>
		  <td  style="text-align:center;" >'.$temp['BL_ISQ_FEEDBACK_DATE'].'</td>
		  <td  style="text-align:center;" >'.$temp['ETO_LEAP_VENDOR_NAME'].'</td>
		  <td  style="text-align:center;" >'.$temp['ETO_LEAP_EMP_NAME'].'</td>
                  <td  style="text-align:center;" >'.$temp['ETO_LEAP_EMP_ID'].'</td>
		  <td  style="text-align:center;" >'.$temp['BL_ISQ_FEEDBACK_ID'].'</td>
                  <td  style="text-align:center;" >'.$reasonDesc[$temp['FK_REASON_ID']].' ['.$temp['FK_REASON_ID'].']</td>    
		  <td  style="text-align:center;" >'.$temp['OTHER_REASON_DESC'].'</td> 
                  <td  style="text-align:center;" >'.$temp['REF_ID'].'</td>';		  
		  $returndata .= '</tr>';
            }
        }
        
         if($action=='export'){
                Yii::import('application.extensions.phpexcel.JPhpExcel');
                $xls = new JPhpExcel('UTF-8', false, 'ISQ-Feedback-Dump');
                $xls->addArray($d2);               
                $xls->generateXML('ISQFeedback');	
         }else{   
              $returndata .= '</table>'; 
                $reArr = array(
				'start_date' => $start_date,
				'vendor' => $vendor,			
				'tlid' => $tlid,			
				'returndata' => $returndata,			
				'start' => $start,			
				'end' => $end,			
				'totalRecords' => $totalRecords,				
			);
			return $reArr;                
         }
        
 }
 
 
 public function PMCAT($request)
 {
  $model = new GlobalmodelForm();
  $start_date = $request->getParam('start_date','');
  $end_date = $request->getParam('end_date','');
  $vendor=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : ''; 
  $vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
  $tlid = $request->getParam('tlselect',0);
  $tlidEmpWise = $request->getParam('tlid',0);
  $start_time=isset($_REQUEST['start_time']) ? $_REQUEST['start_time'] : ''; 
  $end_time=isset($_REQUEST['end_time']) ? $_REQUEST['end_time'] : ''; 
  $tlid = (!empty($tlidEmpWise) ? $tlidEmpWise : (!empty($tlid) ? $tlid : 0));
  $DataFinal=array();
  $tlCond='';
  $venCond='';
  $obj = new Globalconnection();
  $vendorstr=$source='';
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
    
  if($tlid >0)
  {
   $tlCond=" AND ETO_LEAP_TL_ID=$tlid ";
  }
  if($vendor <>'ALL')
  {
    $vendorstr= str_replace(",","','",$vendorVal);
	
	$venCond=" AND ETO_LEAP_VENDOR_NAME in ('$vendorstr')";
  }
 
  
      
      $sql="SELECT ETO_OFR_APPROV_DATE,
        ETO_LEAP_VENDOR_NAME,
        COUNT(CASE WHEN GLCAT_MCAT_IS_GENERIC=1 THEN ETO_OFR_DISPLAY_ID ELSE NULL END ) TOTAL_PMCAT,
        COUNT(ETO_OFR_DISPLAY_ID) TOTAL 
FROM 
(SELECT GLCAT_MCAT_ID,GLCAT_MCAT_IS_GENERIC FROM GLCAT_MCAT )A,
(
SELECT date(ETO_OFR_APPROV_DATE_ORIG) ETO_OFR_APPROV_DATE,ETO_OFR_DISPLAY_ID,ETO_OFR_TITLE,FK_EMPLOYEE_ID,FK_GLCAT_MCAT_ID 
FROM ETO_OFR
WHERE date(ETO_OFR_APPROV_DATE_ORIG) = TO_DATE(:START_DATE,'DD-MON-YYYY') AND ETO_OFR_APPROV='A'
UNION
SELECT date(ETO_OFR_APPROV_DATE_ORIG) ETO_OFR_APPROV_DATE,ETO_OFR_DISPLAY_ID,ETO_OFR_TITLE,FK_EMPLOYEE_ID,FK_GLCAT_MCAT_ID 
FROM ETO_OFR_EXPIRED
WHERE date(ETO_OFR_APPROV_DATE_ORIG) = TO_DATE(:START_DATE,'DD-MON-YYYY') AND ETO_OFR_APPROV='A'

) B,
  ETO_LEAP_MIS_INTERIM
WHERE A.GLCAT_MCAT_ID = B.FK_GLCAT_MCAT_ID  
AND ETO_LEAP_MIS_INTERIM.ETO_LEAP_EMP_ID=B.FK_EMPLOYEE_ID 
$venCond
$tlCond 
GROUP BY ETO_OFR_APPROV_DATE
,ETO_LEAP_VENDOR_NAME"; 
      
      $bind[':START_DATE']=$start_date;
      
	 $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,$bind);
	
 $returndata = '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">
        							<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="5"><b>Summary Report</b></td></tr><tr>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>Date</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>Centre Name</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Total Approved</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>PMCAT Approved</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>%</b></td>
                                                                </tr>';

	if($sth){
	 while($temp=$sth->read())
	  {
             $per=0;
             $crVendork=$temp['eto_leap_vendor_name'];
             if($temp['total_pmcat']>0){
                 $per=round(($temp['total_pmcat']/$temp['total'])*100,2); 
             }
             
	   $returndata .= "<tr>
		  <td  style='text-align:center;' >".$temp['eto_ofr_approv_date']."</td>
                  <td class='intd' style='text-align:center;'  width='100px'>$crVendork<a href='javascript:void(0)' onclick=\"empWiseDetail('PMCAT_tl','divid1','$start_date','$end_date','$crVendork','$source','$start_time','$end_time','$tlid','','');\" style='text-decoration:none;color:#0000ff' ><b>+</b></a></td>
		  <td  style='text-align:center;' >".$temp['total']."</td><td  style='text-align:center;' >".$temp['total_pmcat']."</td>"
                   . "<td  style='text-align:center;' >".$per."</td>";
		  $returndata .= '</tr>';
    }
	}
    $returndata .= '</table><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>'; 
	echo $returndata;      
 }
  
 
   public function PMCAT_tl($request)
 {
  $model = new GlobalmodelForm();
  $start_date = $request->getParam('start_date','');
  $end_date = $request->getParam('end_date','');
  $vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : '';  
  $obj = new Globalconnection();
if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
{
    $dbh = $obj->connect_db_yii('postgress_web77v');   
}else{
    $dbh = $obj->connect_db_yii('postgress_web68v'); 
}
  $venCond=" AND ETO_LEAP_VENDOR_NAME =:vendor";
  $datecond=" date(ETO_OFR_APPROV_DATE_ORIG) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY') ";
  $sql="SELECT TO_CHAR(ETO_OFR_APPROV_DATE,'DD-MON-YYYY') ETO_OFR_APPROV_DATE,
         COUNT(CASE WHEN GLCAT_MCAT_IS_GENERIC=1 THEN ETO_OFR_DISPLAY_ID ELSE NULL END ) TOTAL_PMCAT,
        COUNT(ETO_OFR_DISPLAY_ID ) TOTAL,
        (SELECT T1.ETO_LEAP_EMP_NAME FROM ETO_LEAP_MIS_INTERIM T1 WHERE T1.ETO_LEAP_EMP_ID=T2.ETO_LEAP_TL_ID)  TL_NAME,
         T2.ETO_LEAP_EMP_ID EMP_ID,
         T2.ETO_LEAP_EMP_NAME EMP_NAME 
FROM 
(SELECT GLCAT_MCAT_ID,GLCAT_MCAT_IS_GENERIC FROM GLCAT_MCAT)A,
(
SELECT date(ETO_OFR_APPROV_DATE_ORIG) ETO_OFR_APPROV_DATE,ETO_OFR_DISPLAY_ID,FK_EMPLOYEE_ID,FK_GLCAT_MCAT_ID 
FROM ETO_OFR
WHERE $datecond 
UNION
SELECT date(ETO_OFR_APPROV_DATE_ORIG) ETO_OFR_APPROV_DATE,ETO_OFR_DISPLAY_ID,FK_EMPLOYEE_ID,FK_GLCAT_MCAT_ID 
FROM ETO_OFR_EXPIRED
WHERE $datecond 
) B,
  ETO_LEAP_MIS_INTERIM T2
WHERE A.GLCAT_MCAT_ID = B.FK_GLCAT_MCAT_ID  
AND T2.ETO_LEAP_EMP_ID=B.FK_EMPLOYEE_ID 
$venCond  
GROUP BY ETO_OFR_APPROV_DATE,T2.ETO_LEAP_EMP_ID,
         T2.ETO_LEAP_TL_ID,
         T2.ETO_LEAP_EMP_NAME";
      
    
$bind[':start_date']=$start_date;
      $bind[':end_date']=$end_date;
      $bind[':vendor']=$vendor;
	 $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,$bind);
	
 $returndata = '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">
        							<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="7"><b>Detail Report</b></td></tr><tr>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Date</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>TL Name</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>EMP NAME</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>EMP_ID</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Total Approved</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>PMCAT Approved</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>%</b></td>
                                               </tr>';
 $total=$total_pmcat=0;
 	$per=0;
	if($sth){
		while($temp=$sth->read())
		{
             $per=0;
             $crvendork=$temp['total_pmcat'];
             $empid=$temp['emp_id'];
             $sdate=$temp['eto_ofr_approv_date'];
             if($temp['total_pmcat']>0){
                 $per=round(($temp['total_pmcat']/$temp['total'])*100,2); 
             }
             $returndata .= "<tr>
		  <td  style='text-align:center;' >".$temp['eto_ofr_approv_date']."</td>
                  <td  style='text-align:center;' >".$temp['tl_name']."</td>
                  <td  style='text-align:center;' >".$temp['emp_name']."</td>  
                   <td  style='text-align:center;' >".$temp['emp_id']."</td>
                   <td  style='text-align:center;' >".$temp['total']."</td>    
                   <td class='intd' style='text-align:center;'  width='100px'><a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=PMCAT_agent&start_date=$sdate&tlid=$empid&total_records=".$crvendork."'>".$crvendork."</a></td><td  style='text-align:center;' >".$per."</td>
		  ";
		  $returndata .= '</tr>';
                  $total=$temp['total']+$total;
                  $total_pmcat=$total_pmcat+$temp['total_pmcat'];
    	}

		if($total_pmcat>0){
			$per=round(($total_pmcat/$total)*100,2); 
		}
	}

    $returndata .= '<tr><td colspan="4" style="text-align:center;"><b>Total</b></td><td style="text-align:center;" >'.$total.'</td><td style="text-align:center;" >'.$total_pmcat.'</td><td  style="text-align:center;" >'.$per.'</td></tr></table><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>'; 

	echo $returndata;      
 }
   public function pmcat_agent($request,$action)
 {
       $model = new GlobalmodelForm();
   $start_date =isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';  
  $tlid=isset($_REQUEST['tlid']) ? $_REQUEST['tlid'] : '';  
  $obj = new Globalconnection();
if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
{
    $dbh = $obj->connect_db_yii('postgress_web77v');   
}else{
    $dbh = $obj->connect_db_yii('postgress_web68v'); 
}
  $tlcond=" AND FK_EMPLOYEE_ID =:tlid";
  $returndata=$val=$d2=$d1=array();
  $datecond=" date(ETO_OFR_APPROV_DATE) =to_date(:start_date,'DD-MON-YYYY')  ";
  
  $sql="SELECT DISTINCT ETO_OFR_DISPLAY_ID,TO_CHAR(ETO_OFR_APPROV_DATE,'DD-MON-YYYY') ETO_OFR_APPROV_DATE,        
        (SELECT T1.ETO_LEAP_EMP_NAME FROM ETO_LEAP_MIS_INTERIM T1 WHERE T1.ETO_LEAP_EMP_ID=T2.ETO_LEAP_TL_ID)  TL_NAME,
         T2.ETO_LEAP_EMP_ID EMP_ID,
         T2.ETO_LEAP_EMP_NAME EMP_NAME 
FROM 
(SELECT GLCAT_MCAT_ID FROM GLCAT_MCAT WHERE GLCAT_MCAT_IS_GENERIC = 1)A,
(
SELECT date(ETO_OFR_APPROV_DATE) ETO_OFR_APPROV_DATE,ETO_OFR_DISPLAY_ID,FK_EMPLOYEE_ID,FK_GLCAT_MCAT_ID 
FROM ETO_OFR
WHERE $datecond 
UNION
SELECT date(ETO_OFR_APPROV_DATE) ETO_OFR_APPROV_DATE,ETO_OFR_DISPLAY_ID,FK_EMPLOYEE_ID,FK_GLCAT_MCAT_ID 
FROM ETO_OFR_EXPIRED
WHERE $datecond 

) B,
  ETO_LEAP_MIS_INTERIM T2
WHERE A.GLCAT_MCAT_ID = B.FK_GLCAT_MCAT_ID  
AND T2.ETO_LEAP_EMP_ID=B.FK_EMPLOYEE_ID 
$tlcond ";
      
      $bind[':start_date']=$start_date;
      $bind[':tlid']=$tlid;
     
     //echo $sql;
	 $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,$bind);
if($action=='export'){
     $d1 = array("Date","TL Name","EMP Name","EMP ID","Offer ID");
     array_push($d2,$d1);   
}else{	
 $returndata = '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">
        							<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="6"><b>Detail Report</b></td></tr><tr>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>Date</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>TL Name</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>EMP NAME</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>EMP_ID</b></td>
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>offer</b></td>		
        							</tr>';
}
	 while($temp=$sth->read())
	  {
              if($action=='export'){
                 $val = array(
                    $temp['eto_ofr_approv_date'],
                    $temp['tl_name'],
                    $temp['emp_name'],
                    $temp['emp_id'],
                    $temp['eto_ofr_display_id']);
                    array_push($d2,$val);                 
            }else{
                    $crvendork=$temp['eto_ofr_display_id'];  
                    $eto_ofr_approv_date=isset($temp['eto_ofr_approv_date'])?$temp['eto_ofr_approv_date']:'';
                    $tl_name=isset($temp['tl_name'])?$temp['tl_name']:'';
                    $emp_name=isset($temp['emp_name'])?$temp['emp_name']:'';
                    $emp_id=isset($temp['emp_id'])?$temp['emp_id']:'';
                     $returndata .= "<tr>
		  <td  style='text-align:center;' >".$eto_ofr_approv_date."</td>
                  <td  style='text-align:center;' >".$tl_name."</td>
                  <td  style='text-align:center;' >".$emp_name."</td>  
                   <td  style='text-align:center;' >".$emp_id."</td>";
                  $returndata .= "<td width='100px' style='text-align:center;'><a href='/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=".$crvendork."&mid=3424'  target='_blank' style='text-decoration:none;color:#0000ff;font-family: arial'>".$crvendork."</a></td>";
		  $returndata .= '</tr>';
            }
        }
       
        if($action=='export'){ 
                Yii::import('application.extensions.phpexcel.JPhpExcel');
                $xls = new JPhpExcel('UTF-8', false, 'pmcat-dump');
                $xls->addArray($d2);
                $xls->generateXML('pmcat');	
         }else{ 
            $returndata .= '</table><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>'; 
            echo $returndata;      
         }
 }
 
 public function isqfillrate($request,$vendorRe,$empId)
  {
                 $model = new GlobalmodelForm();
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$vendor=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : ''; 
                $vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
		$strt1 = strtotime($start_date);
		$end1 = strtotime($end_date);
		$today = strtotime(date("d-M-Y"));
		$source = $request->getParam('source','A');
                $cntryArr = array('I' => 2,'F' => 3,'A' => 0);
	    	$cntryFlag = isset($cntryArr[$source])?$cntryArr[$source]:0;
		$tlid = $request->getParam('tlselect',0);
                $tlidEmpWise = $request->getParam('tlid',0);
	        $tlid = (!empty($tlidEmpWise) ? $tlidEmpWise : (!empty($tlid) ? $tlid : 0));
                $obj = new Globalconnection();               
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
                $sqlcond =",eto_leap_mis_interim where ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG";  
                $sqlcond .=" and date_trunc('day'::text, eto_ofr_approv_date_orig) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY') ";  
		if($vendor <>'ALL')
		{
                    $vendorVal="'".str_replace(",", "','", $vendorVal)."'";                    
                    $sqlcond .=" AND ETO_LEAP_VENDOR_NAME IN ($vendorVal)";                   		}
		$bind[':start_date']=$start_date;
		$bind[':end_date']=$end_date;
                
                if($cntryFlag>0){
                    $sqlcond .=" AND (case when :IN_CNTRY_FLAG=0::text then 1 else (case when FK_GL_COUNTRY_ISO=:IN_CNTRY_FLAG then 2 when FK_GL_COUNTRY_ISO='INDIA' then 2 else 3 end) end) = 
                        (case when :IN_CNTRY_FLAG=0::text then 1 when :IN_CNTRY_FLAG=2::text then 2 when :IN_CNTRY_FLAG= 3::text then 3 end) ";
                        $bind[':IN_CNTRY_FLAG']=$cntryFlag;
                }
                     
                $sql_ques="WITH MY_ATTRIBUTES AS
(SELECT im_cat_spec_category_id AS glcat_mcat_id ,
FK_IM_SPEC_MASTER_ID IM_SPEC_MASTER_ID
FROM im_cat_specification,
IM_SPECIFICATION_MASTER
WHERE im_cat_spec_category_type =3
AND im_cat_spec_status =1
AND IM_SPEC_MASTER_BUYER_SELLER <> 2
AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID
),
MY_OFFERS AS
( 
            SELECT           
                (CASE  WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC'
                 WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' 
                 WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN  'MUSTCALL'
                 WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN  'INTENT'
                 WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN  'DNC'
                 WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN  'INTENT'
                 ELSE USER_IDENTIFIER_FLAG || 'UNDEFINED' END) MODULE, 
            ETO_OFR_DISPLAY_ID , FK_GLCAT_MCAT_ID,
            DATE(eto_ofr_approv_date_orig) APPROV_DATE, ETO_LEAP_VENDOR_NAME FROM ETO_OFR $sqlcond and ETO_OFR_APPROV='A' and ETO_OFR_TYP='B'
            UNION ALL 
            SELECT           
                (CASE WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC'
                WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' 
                WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN  'MUSTCALL'
                WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN  'INTENT'
                WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN  'DNC'
                WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN  'INTENT'
                ELSE USER_IDENTIFIER_FLAG || 'UNDEFINED' END) MODULE,
            ETO_OFR_DISPLAY_ID , FK_GLCAT_MCAT_ID,DATE(eto_ofr_approv_date_orig) APPROV_DATE, ETO_LEAP_VENDOR_NAME FROM ETO_OFR_EXPIRED $sqlcond 
                and ETO_OFR_APPROV='A' and ETO_OFR_TYP='B'    
)
SELECT to_char(APPROV_DATE,'dd-Mon-yyyy') APPROV_DATE ,MODULE,
COUNT(DISTINCT ETO_OFR_DISPLAY_ID) TOTAL_APPROVED, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else AVAIL_QUES end)) APP_ISQ_QUESTIONS_AVAIL, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else (case when QTYPE = 1 then  AVAIL_QUES end) end)) APP_ISQ_QUESTIONS_AVAIL_REG, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else (case when QTYPE=2 then AVAIL_QUES end) end)) APP_ISQ_QUESTIONS_AVAIL_CUST, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else FILLED_QUES end)) APP_ISQ_QUESTIONS_FILLED, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else (case when QTYPE=1 then  FILLED_QUES end) end)) APP_ISQ_QUESTIONS_FILL_REG, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else (case when QTYPE = 2 then FILLED_QUES end) end)) APP_ISQ_QUESTIONS_FILL_CUST,
ETO_LEAP_VENDOR_NAME
            FROM
            
(SELECT APPROV_DATE,MODULE, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_ID, ETO_OFR_DISPLAY_ID || '-' || IM_SPEC_MASTER_ID AVAIL_QUES, FK_GLCAT_MCAT_ID, 1 QTYPE, ETO_LEAP_VENDOR_NAME 
FROM MY_OFFERS LEFT OUTER JOIN MY_ATTRIBUTES 
ON FK_GLCAT_MCAT_ID = GLCAT_MCAT_ID
UNION ALL 
SELECT APPROV_DATE,MODULE, ETO_OFR_DISPLAY_ID, ETO_ATTRIBUTE_ID, ETO_OFR_DISPLAY_ID || '-' || ETO_ATTRIBUTE_ID, FK_GLCAT_MCAT_ID, 2 QTYPE, ETO_LEAP_VENDOR_NAME 
FROM MY_OFFERS , ETO_ATTRIBUTE 
WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID AND FK_IM_SPEC_MASTER_ID = -1 
)A LEFT OUTER JOIN
( 
SELECT DISTINCT ETO_OFR_DISPLAY_ID || '-' || (case when FK_IM_SPEC_MASTER_ID = -1 then ETO_ATTRIBUTE_ID else FK_IM_SPEC_MASTER_ID end) FILLED_QUES 
FROM MY_OFFERS, ETO_ATTRIBUTE 
WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID 
) FILLED_QUES_ALL 
ON AVAIL_QUES = FILLED_QUES GROUP BY APPROV_DATE, ETO_LEAP_VENDOR_NAME,MODULE ";
                    //echo $sql_ques;//die;
                     $sth_ques = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_ques, $bind);
		     //$rec_ques1=$sth_ques->readAll();
		     //$rec_ques=array_change_key_case($rec_ques1, CASE_UPPER);      
$i=0;
		     $IsqArray=array();
		    // echo '</pre>';print_r($rec_ques);echo '</pre>';die;
			if($sth_ques){
                    while($rec1=$sth_ques->read()){
		     $i++;
                    // echo '</pre>';print_r($rec1);echo '</pre>';
                     $rec_ques=array_change_key_case($rec1, CASE_UPPER);
		       $IsqArray[$i]['APPROV_DATE']=$rec_ques['APPROV_DATE'];		     
                       $IsqArray[$i]['ETO_LEAP_VENDOR_NAME']=$rec_ques['ETO_LEAP_VENDOR_NAME'];
                       $IsqArray[$i]['MODULE']=$rec_ques['MODULE'];
		       $IsqArray[$i]['TOTAL_APPROVED']=$rec_ques['TOTAL_APPROVED'];
		       
		       $IsqArray[$i]['APP_ISQ_QUESTIONS_AVAIL_REG']=$rec_ques['APP_ISQ_QUESTIONS_AVAIL_REG'];
		       $IsqArray[$i]['APP_ISQ_QUESTIONS_AVAIL_CUST']=$rec_ques['APP_ISQ_QUESTIONS_AVAIL_CUST'];	
                       $IsqArray[$i]['APP_ISQ_QUESTIONS_AVAIL']=$rec_ques['APP_ISQ_QUESTIONS_AVAIL'];
                       
                       
		       $IsqArray[$i]['APP_ISQ_QUESTIONS_FILL_REG']=$rec_ques['APP_ISQ_QUESTIONS_FILL_REG'];
		       $IsqArray[$i]['APP_ISQ_QUESTIONS_FILL_CUST']=$rec_ques['APP_ISQ_QUESTIONS_FILL_CUST'];
                       $IsqArray[$i]['APP_ISQ_QUESTIONS_FILLED']=$rec_ques['APP_ISQ_QUESTIONS_FILLED'];
                       
                       $IsqArray[$i]['REG_PERC']=sprintf('%0.2f',$rec_ques['APP_ISQ_QUESTIONS_FILL_REG']/$rec_ques['APP_ISQ_QUESTIONS_AVAIL_REG']*100);
		       $IsqArray[$i]['CUST_PERC']=sprintf('%0.2f',$rec_ques['APP_ISQ_QUESTIONS_FILLED']/$rec_ques['APP_ISQ_QUESTIONS_AVAIL']*100);
                       
		     }
			}
		    // echo '</pre>';print_r($IsqArray);echo '</pre>';//die;
		        $returnHash = '';
			$returnHash .= "<BR>";
			$returnHash .= '<div id="div1" style="width:1300px; margin:0px auto;">';
        	$returnHash .= '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1300px">
        							<tr>
        							<td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Date</b></td>
        							<td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Vendor Name</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Pool</b></td>
        							<td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>BL Approved</b></td>
                                                                
        							<td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>Opportunities Excluding Custom ISQ</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>Custom ISQ Opportunities</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>Total Opportunities</b></td>
                                                                
        							<td style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Opportunities Filled Without Custom ISQ</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Custom Opportunities Filled</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Total Opportunities Filled</b></td>
                                                                
                                                                 <td style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Fill Rate Without Custom ISQ</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Fill Rate With Custom ISQ</b></td>
        							</tr>';
						$TOT_BL_APRROVED=0;						
						$TOT_RESPONSE=0;
						$TOT_QUESTION=0;
                                                $TOT_RESPONSE_CUST=0;
                                                $TOT_RESPONSE_REG=0;
                                                $TOT_QUESTION_CUST=0;
                                                $TOT_QUESTION_REG=0;
						foreach($IsqArray as $temp)
						{
                                                    $APPROV_DATE=$temp['APPROV_DATE'];
                                                    $crVendork=$temp['ETO_LEAP_VENDOR_NAME'];
                                                    $MODULE=$temp['MODULE'];
                                                    $returnHash .= '<tr><td  style="text-align:center;"  width="5%">'.$temp['APPROV_DATE'].'</td>';
                                                    $returnHash .="<td style='text-align:center;'  width='100px'>".$crVendork." <a href='javascript:void(0)' "
                                                            . "onclick=\"empWiseDetail('isqfillrate_tl','divid1','".$APPROV_DATE."','','".$crVendork."','".$MODULE."',"
                                                            . "'','','','','');\" style='text-decoration:none;color:#0000ff' ><b>+</b></a></td>";
                                                    $returnHash .='<td  style="text-align:center;"  width="5%">'.$temp['MODULE'].'</td>';
        							
        							$returnHash .='<td  style="text-align:center;"  width="5%">'.$temp['TOTAL_APPROVED'].'</td>
        							
        							<td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_AVAIL_REG'].'</td>
                                                                <td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_AVAIL_CUST'].'</td>
                                                                <td style="text-align:center;"  width="5%">'.$temp['APP_ISQ_QUESTIONS_AVAIL'].'</td>
                                                                
                                                                <td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_FILL_REG'].'</td>
                                                                <td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_FILL_CUST'].'</td>
                                                                <td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_FILLED'].'</td>
                                                                <td  style="text-align:center;">'.$temp['REG_PERC'].'</td>
                                                                <td  style="text-align:center;">'.$temp['CUST_PERC'].'</td>
        							</tr>';
                                                
                                                $TOT_BL_APRROVED=$TOT_BL_APRROVED+$temp['TOTAL_APPROVED']; 
                                                
                                                $TOT_RESPONSE=$TOT_RESPONSE+$temp['APP_ISQ_QUESTIONS_FILLED'];
                                                $TOT_RESPONSE_CUST=$TOT_RESPONSE_CUST+$temp['APP_ISQ_QUESTIONS_FILL_CUST'];
                                                $TOT_RESPONSE_REG=$TOT_RESPONSE_REG+$temp['APP_ISQ_QUESTIONS_FILL_REG'];
                                                
                                                $TOT_QUESTION=$TOT_QUESTION+$temp['APP_ISQ_QUESTIONS_AVAIL'];
                                                $TOT_QUESTION_CUST=$TOT_QUESTION_CUST+$temp['APP_ISQ_QUESTIONS_AVAIL_CUST'];
                                                $TOT_QUESTION_REG=$TOT_QUESTION_REG+$temp['APP_ISQ_QUESTIONS_AVAIL_REG'];
                                                
        	}
                
                $TOT_RESPONSE_cper=sprintf('%0.2f', $TOT_RESPONSE/$TOT_QUESTION*100);                
        	$TOT_RESPONSE_per = sprintf('%0.2f', $TOT_RESPONSE_REG/$TOT_QUESTION_REG*100);
                
        	$returnHash .= '<tr>
                <td  colspan="3" style="text-align:center;" bgcolor="#dff8ff"><b>Total</b></td>
                <td  style="text-align:center;" bgcolor="#dff8ff" >'.$TOT_BL_APRROVED.'</td>
                <td  style="text-align:center;" bgcolor="#dff8ff" >'.$TOT_QUESTION_REG.'</td>               
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_QUESTION_CUST.'</td>
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_QUESTION.'</td> 
                            
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_RESPONSE_REG.'</td>                    
                <td  style="text-align:center;" bgcolor="#dff8ff" >'.$TOT_RESPONSE_CUST.'</td>  
                <td  style="text-align:center;" bgcolor="#dff8ff" >'.$TOT_RESPONSE.'</td>       
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_RESPONSE_per.'</td>                          
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_RESPONSE_cper.'</td>
                 </tr>';

                $returnHash .= '</table></div><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>';
        					
        return $returnHash;							
  
  }
  
public function isqfillrate_tl($request,$vendorRe,$empId)
  {
                $model = new GlobalmodelForm();
		$start_date = $request->getParam('start_date','');
		$vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : '';
                $pool=isset($_REQUEST['source']) ? $_REQUEST['source'] : '';
                $obj = new Globalconnection();               
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
                
                $sqlcond =",eto_leap_mis_interim where ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG";  
                $sqlcond .=" AND date(eto_ofr_approv_date_orig) =to_date(:start_date,'DD-Mon-YYYY') ";  
		$sqlcond .=" AND ETO_LEAP_VENDOR_NAME='$vendor' ";                   
		$bind[':start_date']=$start_date;
		$bind[':MODULE']=$pool;
               
                     
                $sql_ques="WITH MY_ATTRIBUTES AS 
(SELECT im_cat_spec_category_id AS glcat_mcat_id , FK_IM_SPEC_MASTER_ID IM_SPEC_MASTER_ID FROM im_cat_specification, IM_SPECIFICATION_MASTER WHERE im_cat_spec_category_type =3 AND im_cat_spec_status =1 AND IM_SPEC_MASTER_BUYER_SELLER <> 2 AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID 
), 
MY_OFFERS AS 
(SELECT (CASE WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC' WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'MUSTCALL' WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 'INTENT' WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 'DNC' WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN 'INTENT' ELSE USER_IDENTIFIER_FLAG || 'UNDEFINED' END) MODULE, ETO_OFR_DISPLAY_ID , FK_GLCAT_MCAT_ID,DATE(eto_ofr_approv_date_orig) APPROV_DATE,ETO_LEAP_EMP_ID,ETO_LEAP_EMP_NAME, ETO_LEAP_TL_ID,ETO_LEAP_VENDOR_NAME 
FROM ETO_OFR $sqlcond 
and ETO_OFR_APPROV='A' and ETO_OFR_TYP='B' 
UNION ALL 
SELECT (CASE WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC' WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'MUSTCALL' WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 'INTENT' WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 'DNC' WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN 'INTENT' ELSE USER_IDENTIFIER_FLAG || 'UNDEFINED' END) MODULE, ETO_OFR_DISPLAY_ID , FK_GLCAT_MCAT_ID,DATE(eto_ofr_approv_date_orig) APPROV_DATE,ETO_LEAP_EMP_ID,ETO_LEAP_EMP_NAME, ETO_LEAP_TL_ID,ETO_LEAP_VENDOR_NAME 
FROM ETO_OFR_EXPIRED $sqlcond  
and ETO_OFR_APPROV='A' and ETO_OFR_TYP='B' 
) 
SELECT to_char(APPROV_DATE,'dd-Mon-yyyy') APPROV_DATE ,MODULE, 
COUNT(DISTINCT ETO_OFR_DISPLAY_ID) TOTAL_APPROVED, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else AVAIL_QUES end)) APP_ISQ_QUESTIONS_AVAIL, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else (case when QTYPE = 1 then  AVAIL_QUES end) end)) APP_ISQ_QUESTIONS_AVAIL_REG, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else (case when QTYPE = 2 then  AVAIL_QUES end) end)) APP_ISQ_QUESTIONS_AVAIL_CUST, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else FILLED_QUES end)) APP_ISQ_QUESTIONS_FILLED, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else (case when QTYPE = 1 then FILLED_QUES end) end)) APP_ISQ_QUESTIONS_FILL_REG, 
COUNT(DISTINCT (case when IM_SPEC_MASTER_ID is NULL then NULL else (case when QTYPE = 2 then  FILLED_QUES end) end)) APP_ISQ_QUESTIONS_FILL_CUST, 
ETO_LEAP_EMP_ID, ETO_LEAP_EMP_NAME, ETO_LEAP_TL_ID, ETO_LEAP_TL_NAME, ETO_LEAP_VENDOR_NAME 
FROM 
(SELECT APPROV_DATE,MODULE, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_ID, ETO_OFR_DISPLAY_ID || '-' || IM_SPEC_MASTER_ID AVAIL_QUES, FK_GLCAT_MCAT_ID, 1 QTYPE, ETO_LEAP_EMP_ID, ETO_LEAP_EMP_NAME, ETO_LEAP_TL_ID, 
(SELECT T2.ETO_LEAP_EMP_NAME FROM ETO_LEAP_MIS_INTERIM T2 WHERE T2.ETO_LEAP_EMP_ID=MY_OFFERS.ETO_LEAP_TL_ID) ETO_LEAP_TL_NAME, ETO_LEAP_VENDOR_NAME 
FROM MY_OFFERS LEFT OUTER JOIN MY_ATTRIBUTES 
ON FK_GLCAT_MCAT_ID = GLCAT_MCAT_ID where MODULE=:MODULE 
UNION ALL 
SELECT APPROV_DATE,MODULE, ETO_OFR_DISPLAY_ID, ETO_ATTRIBUTE_ID, ETO_OFR_DISPLAY_ID || '-' || ETO_ATTRIBUTE_ID, FK_GLCAT_MCAT_ID, 2 QTYPE, ETO_LEAP_EMP_ID, ETO_LEAP_EMP_NAME, ETO_LEAP_TL_ID, (SELECT T2.ETO_LEAP_EMP_NAME FROM ETO_LEAP_MIS_INTERIM T2 WHERE T2.ETO_LEAP_EMP_ID=MY_OFFERS.ETO_LEAP_TL_ID) ETO_LEAP_TL_NAME, ETO_LEAP_VENDOR_NAME 
FROM MY_OFFERS , ETO_ATTRIBUTE WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID AND FK_IM_SPEC_MASTER_ID = -1 AND MODULE=:MODULE 
)A LEFT OUTER JOIN
( SELECT DISTINCT ETO_OFR_DISPLAY_ID || '-' || (case when FK_IM_SPEC_MASTER_ID = -1 then ETO_ATTRIBUTE_ID else FK_IM_SPEC_MASTER_ID end) FILLED_QUES 
FROM MY_OFFERS, ETO_ATTRIBUTE 
WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID AND MODULE=:MODULE
) FILLED_QUES_ALL 
ON AVAIL_QUES = FILLED_QUES 
GROUP BY APPROV_DATE,ETO_LEAP_EMP_ID,ETO_LEAP_EMP_NAME, ETO_LEAP_TL_ID,ETO_LEAP_TL_NAME,ETO_LEAP_VENDOR_NAME, MODULE ";
                    //echo $sql_ques;//die;
                     $sth_ques = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_ques, $bind);
		 
		     $IsqArray=array();
		   // echo '</pre>';print_r($rec_ques);echo '</pre>';//die;
                    while($rec1=$sth_ques->read()){
		     $i++;
                        $rec_ques=array_change_key_case($rec1, CASE_UPPER);
		       $IsqArray[$i]['APPROV_DATE']=$rec_ques['APPROV_DATE'];
                       $IsqArray[$i]['ETO_LEAP_VENDOR_NAME']=$rec_ques['ETO_LEAP_VENDOR_NAME'];
                       $IsqArray[$i]['ETO_LEAP_TL_NAME']=$rec_ques['ETO_LEAP_TL_NAME'];
                       $IsqArray[$i]['ETO_LEAP_TL_ID']=$rec_ques['ETO_LEAP_TL_ID'];
                       $IsqArray[$i]['ETO_LEAP_EMP_ID']=$rec_ques['ETO_LEAP_EMP_ID'];
                       $IsqArray[$i]['ETO_LEAP_EMP_NAME']=$rec_ques['ETO_LEAP_EMP_NAME'];
                       $IsqArray[$i]['MODULE']=$rec_ques['MODULE'];
		       $IsqArray[$i]['TOTAL_APPROVED']=$rec_ques['TOTAL_APPROVED'];
		       
		       $IsqArray[$i]['APP_ISQ_QUESTIONS_AVAIL_REG']=$rec_ques['APP_ISQ_QUESTIONS_AVAIL_REG'];
		       $IsqArray[$i]['APP_ISQ_QUESTIONS_AVAIL_CUST']=$rec_ques['APP_ISQ_QUESTIONS_AVAIL_CUST'];	
                       $IsqArray[$i]['APP_ISQ_QUESTIONS_AVAIL']=$rec_ques['APP_ISQ_QUESTIONS_AVAIL'];
                       
                       
		       $IsqArray[$i]['APP_ISQ_QUESTIONS_FILL_REG']=$rec_ques['APP_ISQ_QUESTIONS_FILL_REG'];
		       $IsqArray[$i]['APP_ISQ_QUESTIONS_FILL_CUST']=$rec_ques['APP_ISQ_QUESTIONS_FILL_CUST'];
                       $IsqArray[$i]['APP_ISQ_QUESTIONS_FILLED']=$rec_ques['APP_ISQ_QUESTIONS_FILLED'];
                       
                       $IsqArray[$i]['REG_PERC']=sprintf('%0.2f',$rec_ques['APP_ISQ_QUESTIONS_FILL_REG']/$rec_ques['APP_ISQ_QUESTIONS_AVAIL_REG']*100);
		       $IsqArray[$i]['CUST_PERC']=sprintf('%0.2f',$rec_ques['APP_ISQ_QUESTIONS_FILLED']/$rec_ques['APP_ISQ_QUESTIONS_AVAIL']*100);
                       
		     }
		        $returnHash = '';
			$returnHash .= "<BR>";
			$returnHash .= '<div id="div1" style="width:1300px; margin:0px auto;">';
        	$returnHash .= '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1300px">
        							<tr>
        							<td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>Date</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>Vendor</b></td>
        							<td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>TL Name</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>Emp Name/ID</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>Pool</b></td>
        							<td style="text-align:center;" bgcolor="#dff8ff" width="5%"><b>BL Approved</b></td>
                                                                
        							<td style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Opportunities Excluding Custom ISQ</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Custom ISQ Opportunities</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Total Opportunities</b></td>
                                                                
        							<td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Opportunities Filled Without Custom ISQ</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Custom Opportunities Filled</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Total Opportunities Filled</b></td>
                                                                
                                                                 <td style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Fill Rate Without Custom ISQ</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Fill Rate With Custom ISQ</b></td>
        							</tr>';
						$TOT_BL_APRROVED=0;						
						$TOT_RESPONSE=0;
						$TOT_QUESTION=0;
                                                $TOT_RESPONSE_CUST=0;
                                                $TOT_RESPONSE_REG=0;
                                                $TOT_QUESTION_CUST=0;
                                                $TOT_QUESTION_REG=0;
						foreach($IsqArray as $temp)
						{
                                                    $APPROV_DATE=$temp['APPROV_DATE'];
                                                    $crVendork=$temp['ETO_LEAP_EMP_ID'];
                                                    $returnHash .= '<tr><td  style="text-align:center;"  width="5%">'.$temp['APPROV_DATE'].'</td>';  
                                                    
                                                    $vendor=$temp['ETO_LEAP_VENDOR_NAME'];
                                                    $returnHash .= '<td  style="text-align:center;"  width="5%">'.$vendor.'</td>';  
                                                     $returnHash .='<td  style="text-align:center;"  width="5%">'.$temp['ETO_LEAP_TL_NAME'].'</td>';
                                                    $returnHash .="<td class='intd' style='text-align:center;'  width='100px'><a target='_blank' style='text-decoration:none;color:#0000ff' href='/index.php?r=admin_eto/AdminEto/leapdashboard&mid=3443&action=isqfillrate_agent&source=".$temp['MODULE']."&vendor=".$vendor."&start_date=".$APPROV_DATE."&tlid=$crVendork'>".$temp['ETO_LEAP_EMP_NAME'].'-'.$crVendork."</a></td>";
                                                    $returnHash .='<td  style="text-align:center;"  width="5%">'.$temp['MODULE'].'</td>';
        							
        							$returnHash .='<td  style="text-align:center;"  width="5%">'.$temp['TOTAL_APPROVED'].'</td>        							
        							<td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_AVAIL_REG'].'</td>
                                                                <td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_AVAIL_CUST'].'</td>
                                                                <td style="text-align:center;"  width="5%">'.$temp['APP_ISQ_QUESTIONS_AVAIL'].'</td>                                                                
                                                                <td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_FILL_REG'].'</td>
                                                                <td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_FILL_CUST'].'</td>
                                                                <td  style="text-align:center;">'.$temp['APP_ISQ_QUESTIONS_FILLED'].'</td>
                                                                <td  style="text-align:center;">'.$temp['REG_PERC'].'</td>
                                                                <td  style="text-align:center;">'.$temp['CUST_PERC'].'</td>
        							</tr>';
                                                
                                                $TOT_BL_APRROVED=$TOT_BL_APRROVED+$temp['TOTAL_APPROVED']; 
                                                
                                                $TOT_RESPONSE=$TOT_RESPONSE+$temp['APP_ISQ_QUESTIONS_FILLED'];
                                                $TOT_RESPONSE_CUST=$TOT_RESPONSE_CUST+$temp['APP_ISQ_QUESTIONS_FILL_CUST'];
                                                $TOT_RESPONSE_REG=$TOT_RESPONSE_REG+$temp['APP_ISQ_QUESTIONS_FILL_REG'];
                                                
                                                $TOT_QUESTION=$TOT_QUESTION+$temp['APP_ISQ_QUESTIONS_AVAIL'];
                                                $TOT_QUESTION_CUST=$TOT_QUESTION_CUST+$temp['APP_ISQ_QUESTIONS_AVAIL_CUST'];
                                                $TOT_QUESTION_REG=$TOT_QUESTION_REG+$temp['APP_ISQ_QUESTIONS_AVAIL_REG'];
                                                
        	}
                
                $TOT_RESPONSE_cper=sprintf('%0.2f', $TOT_RESPONSE/$TOT_QUESTION*100);                
        	$TOT_RESPONSE_per = sprintf('%0.2f', $TOT_RESPONSE_REG/$TOT_QUESTION_REG*100);
                
        	$returnHash .= '<tr>
                <td  colspan="5" style="text-align:center;" bgcolor="#dff8ff"><b>Total</b></td>
                <td  style="text-align:center;" bgcolor="#dff8ff" >'.$TOT_BL_APRROVED.'</td>
                <td  style="text-align:center;" bgcolor="#dff8ff" >'.$TOT_QUESTION_REG.'</td>               
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_QUESTION_CUST.'</td>
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_QUESTION.'</td> 
                            
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_RESPONSE_REG.'</td>                    
                <td  style="text-align:center;" bgcolor="#dff8ff" >'.$TOT_RESPONSE_CUST.'</td>  
                <td  style="text-align:center;" bgcolor="#dff8ff" >'.$TOT_RESPONSE.'</td>       
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_RESPONSE_per.'</td>                          
                <td  style="text-align:center;" bgcolor="#dff8ff">'.$TOT_RESPONSE_cper.'</td>
                 </tr>';

                $returnHash .= '</table></div><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>';
        					
        echo $returnHash;		
        die;
  
  }
  
public function isqfillrate_agent($request,$action)
  {
                $model = new GlobalmodelForm();
		$start_date = $request->getParam('start_date','');
		$tlid=isset($_REQUEST['tlid']) ? $_REQUEST['tlid'] : '';
                $vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : '';
                $pool=$request->getParam('source','');
                $obj = new Globalconnection();               
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
                $sqlcond =",eto_leap_mis_interim where ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG";  
                $sqlcond .=" AND date(eto_ofr_approv_date_orig) =to_date(:start_date,'DD-Mon-YYYY') ";  
		$sqlcond .=" AND ETO_LEAP_EMP_ID=:tlid ";
                $sqlcond .=" AND ETO_LEAP_VENDOR_NAME='$vendor' ";
                
              
		$bind[':start_date']=$start_date;
		$bind[':MODULE']=$pool;
                $bind[':tlid']=$tlid;
                
                $sql_ques="WITH MY_ATTRIBUTES AS 
(
SELECT im_cat_spec_category_id AS glcat_mcat_id , FK_IM_SPEC_MASTER_ID IM_SPEC_MASTER_ID FROM im_cat_specification, IM_SPECIFICATION_MASTER WHERE im_cat_spec_category_type =3 AND im_cat_spec_status =1 AND IM_SPEC_MASTER_BUYER_SELLER <> 2 AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID 
), 
MY_OFFERS AS 
( 
SELECT (CASE WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC' WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'MUSTCALL' WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 'INTENT' WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 'DNC' WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN 'INTENT' ELSE USER_IDENTIFIER_FLAG || 'UNDEFINED' END) MODULE, ETO_OFR_DISPLAY_ID , FK_GLCAT_MCAT_ID,DATE(eto_ofr_approv_date_orig) APPROV_DATE, ETO_LEAP_EMP_ID,ETO_LEAP_EMP_NAME,ETO_LEAP_VENDOR_NAME 
FROM ETO_OFR 
$sqlcond and ETO_OFR_APPROV='A' and ETO_OFR_TYP='B' 
UNION ALL 
SELECT (CASE WHEN (UPPER(FK_GL_COUNTRY_ISO) <> 'INDIA' AND UPPER(FK_GL_COUNTRY_ISO) <> 'IN') THEN 'DNC' WHEN USER_IDENTIFIER_FLAG= NULL THEN 'MUSTCALL' WHEN USER_IDENTIFIER_FLAG IN (26,27,0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'MUSTCALL' WHEN USER_IDENTIFIER_FLAG IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 'INTENT' WHEN USER_IDENTIFIER_FLAG IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 'DNC' WHEN USER_IDENTIFIER_FLAG IN (11,12) THEN 'INTENT' ELSE USER_IDENTIFIER_FLAG || 'UNDEFINED' END) MODULE, ETO_OFR_DISPLAY_ID , FK_GLCAT_MCAT_ID,DATE(eto_ofr_approv_date_orig) APPROV_DATE, ETO_LEAP_EMP_ID,ETO_LEAP_EMP_NAME,ETO_LEAP_VENDOR_NAME 
FROM ETO_OFR_EXPIRED  
$sqlcond and ETO_OFR_APPROV='A' and ETO_OFR_TYP='B' 
) 
SELECT DISTINCT ETO_OFR_DISPLAY_ID, to_char(APPROV_DATE,'dd-Mon-yyyy') APPROV_DATE ,MODULE, ETO_LEAP_EMP_ID,ETO_LEAP_EMP_NAME,ETO_LEAP_VENDOR_NAME FROM 
(
SELECT APPROV_DATE,MODULE, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_ID, ETO_OFR_DISPLAY_ID || '-' || IM_SPEC_MASTER_ID AVAIL_QUES, FK_GLCAT_MCAT_ID, 1 QTYPE, ETO_LEAP_EMP_ID,ETO_LEAP_EMP_NAME,ETO_LEAP_VENDOR_NAME 
FROM MY_OFFERS LEFT OUTER JOIN MY_ATTRIBUTES 
ON FK_GLCAT_MCAT_ID = GLCAT_MCAT_ID
UNION 
SELECT APPROV_DATE,MODULE, ETO_OFR_DISPLAY_ID, ETO_ATTRIBUTE_ID, ETO_OFR_DISPLAY_ID || '-' || ETO_ATTRIBUTE_ID, FK_GLCAT_MCAT_ID, 2 QTYPE, ETO_LEAP_EMP_ID,ETO_LEAP_EMP_NAME,ETO_LEAP_VENDOR_NAME 
FROM MY_OFFERS , ETO_ATTRIBUTE 
WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID AND FK_IM_SPEC_MASTER_ID = -1 
)A LEFT OUTER JOIN
( 
SELECT DISTINCT ETO_OFR_DISPLAY_ID || '-' || (case when FK_IM_SPEC_MASTER_ID = -1 then ETO_ATTRIBUTE_ID else FK_IM_SPEC_MASTER_ID end) FILLED_QUES 
FROM MY_OFFERS, ETO_ATTRIBUTE 
WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID 
) FILLED_QUES_ALL 
ON AVAIL_QUES = FILLED_QUES WHERE MODULE=:MODULE";
                     $sth_ques = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_ques, $bind);		 
		     $IsqArray=array();
                    while($rec1=$sth_ques->read()){
                       $rec_ques=array_change_key_case($rec1, CASE_UPPER);
		       $IsqArray[$i]['APPROV_DATE']=$rec_ques['APPROV_DATE'];
                       $IsqArray[$i]['ETO_LEAP_VENDOR_NAME']=$rec_ques['ETO_LEAP_VENDOR_NAME'];
                       $IsqArray[$i]['ETO_LEAP_EMP_NAME']=$rec_ques['ETO_LEAP_EMP_NAME'];
                       $IsqArray[$i]['ETO_LEAP_EMP_ID']=$rec_ques['ETO_LEAP_EMP_ID'];                       
                       $IsqArray[$i]['MODULE']=$rec_ques['MODULE'];
		       $IsqArray[$i]['ETO_OFR_DISPLAY_ID']=$rec_ques['ETO_OFR_DISPLAY_ID'];
		     }
		 //    echo '</pre>';print_r($IsqArray);echo '</pre>';die;
		        $returnHash = '';
                        if($action=='export'){
                            $d1=$d2=array();
                                $d1 = array("Date","Offer ID","Pool","Vendor","EMP Name","EMP ID");
                                array_push($d2,$d1); 
                                foreach($IsqArray as $temp)
				{
                                 $val = array(
                                    $temp['APPROV_DATE'],
                                    $temp['ETO_OFR_DISPLAY_ID'],
                                    $temp['MODULE'],
                                    $temp['ETO_LEAP_VENDOR_NAME'], 
                                    $temp['ETO_LEAP_EMP_NAME'],
                                    $temp['ETO_LEAP_EMP_ID']);
                                    array_push($d2,$val);  
                                }
                                 Yii::import('application.extensions.phpexcel.JPhpExcel');
                                $xls = new JPhpExcel('UTF-8', false, 'isqfillrate-dump');
                                $xls->addArray($d2);
                                $xls->generateXML('isqfillrate'); 
                           }else{    
                                                   $returnHash .= "<BR>";
                                                   $returnHash .= '<div id="div1" style="width:1300px; margin:0px auto;">';
                                           $returnHash .= '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1300px">
        							<tr>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>SN</b></td>
        							<td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Date</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Offer</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Pool</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Vendor</b></td>
        							<td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Emp Name</b></td>
                                                                <td style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Emp ID</b></td>
                                                                                                                                
        							</tr>';
                                                $cnt=0;
						foreach($IsqArray as $temp)
						{
                                                    $cnt++;
                                                    $crVendork=$temp['ETO_OFR_DISPLAY_ID'];
                                                    $MODULE=isset($temp['MODULE'])?$temp['MODULE']:'';
                                                    $ETO_LEAP_VENDOR_NAME=isset($temp['ETO_LEAP_VENDOR_NAME'])?$temp['ETO_LEAP_VENDOR_NAME']:'';
                                                    $ETO_LEAP_EMP_NAME=isset($temp['ETO_LEAP_EMP_NAME'])?$temp['ETO_LEAP_EMP_NAME']:'';
                                                    $ETO_LEAP_EMP_ID=isset($temp['ETO_LEAP_EMP_ID'])?$temp['ETO_LEAP_EMP_ID']:'';
                                                    $returnHash .= '<tr><td  style="text-align:center;"  width="5%">'.$cnt.'</td><td  style="text-align:center;"  width="5%">'.$temp['APPROV_DATE'].'</td>';  
                                                    $returnHash .= "<td width='100px' style='text-align:center;'><a href='/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=".$crVendork."&mid=3424'  target='_blank' style='text-decoration:none;color:#0000ff;font-family: arial'>".$temp['ETO_OFR_DISPLAY_ID']."</a></td>";

                                                    $returnHash .='<td  style="text-align:center;"  width="5%">'.$MODULE.'</td>'; 
                                                    
                                                    $returnHash .='<td  style="text-align:center;">'.$ETO_LEAP_VENDOR_NAME.'</td>'
                                                            . '<td  style="text-align:center;">'.$ETO_LEAP_EMP_NAME.'</td>
                                                    <td  style="text-align:center;">'.$ETO_LEAP_EMP_ID.'</td>
                                                    </tr>';
                                                }                         
                                    $returnHash .= '</table></div><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>';
                                    return $returnHash;
                       }
}
public function DNCCalling($request)
 {
  	$obj = new Globalconnection();
	  $host_name = $_SERVER['SERVER_NAME'];
	  $dbh=$obj->connect_db_oci('postgress_web68v');
		  $start_date = $request->getParam('start_date','');
	$end_date = $request->getParam('end_date','');
	$nodays=(strtotime($end_date) - strtotime($start_date))/ (60 * 60 * 24); //it will count no. of days

	if($nodays >= 0 && $nodays < 7)
	{   
		
		 $cond = " AND date(GL_PROFILE_ENRICHMENT_DATE) BETWEEN '$start_date' AND '$end_date' ";
                $vendor=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : '';
		$vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
		
		if($vendor <>'ALL')
		{
			$vendorVal="'".str_replace(",", "','", $vendorVal)."'";   
			$cond .=" AND EMP.ETO_LEAP_VENDOR_NAME IN ($vendorVal)";                 
			
		}
		$sql = "SELECT date( GL_PROFILE_ENRICHMENT_DATE) ENRICHMENT_DATE,
        EMP.ETO_LEAP_VENDOR_NAME,
        COUNT(ETO_OFR_DISPLAY_ID) TOTAL_OFFER
        FROM BL_PROFILE_ENRICHMENT,ETO_LEAP_MIS_INTERIM EMP, ETO_LEAP_MIS_INTERIM TL 
		WHERE FK_GL_ATTRIBUTE_ID =201 
		AND EMP.ETO_LEAP_EMP_ID = GL_PROFILE_UPDATED_BY_ID
		AND EMP.ETO_LEAP_TL_ID = TL.ETO_LEAP_EMP_ID
		$cond 
		GROUP BY date( GL_PROFILE_ENRICHMENT_DATE),EMP.ETO_LEAP_VENDOR_NAME";

		$sth=pg_query($dbh,$sql); 
		$html_str='';		
		
			$html_str .= '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">
			<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="5"><b>Summary Report</b></td></tr><tr>
			<td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>Date</b></td>
			<td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>Centre Name</b></td>
			<td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Total Count</b></td>                                                                
			</tr>';
		
		$html_str .='</tr>';
		while($temp = pg_fetch_array($sth))
		{
			$crVendork=$temp['eto_leap_vendor_name'];
			
			$html_str .= '<tr><td  style="text-align:center;" >'.$temp['enrichment_date'].'</td><td  style="text-align:center;" >'.$temp['eto_leap_vendor_name']."<a href='javascript:void(0)' onclick=\"empWiseDetail('DNC','divid1','$start_date','$end_date','$crVendork','','','','','','');\" style='text-decoration:none;color:#0000ff' ><b>+</b></a></td><td  style=\"text-align:center;\">".$temp['total_offer'].'</td></tr>';
		}
		echo $html_str .= '</table><div id="divid1" style="display:none; margin:0px auto;padding:8px 0px 8px 0px"></div>'; 						
	}else
	{
		echo 'You can select max 7 days date';    
	}
	die;
 }

 
 public function DNCdetail($request)
 {
        $obj = new Globalconnection();
		$dbh=$obj->connect_db_oci('postgress_web68v');
    
	$start_date = $request->getParam('start_date','');
	$end_date = $request->getParam('end_date','');
	$nodays=(strtotime($end_date) - strtotime($start_date))/ (60 * 60 * 24); //it will count no. of days

	if($nodays >= 0 && $nodays < 7)
	{   
		$cond = " AND date(GL_PROFILE_ENRICHMENT_DATE) BETWEEN '$start_date' AND '$end_date' ";
		$vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : '';
		
		if($vendor <>'ALL')
		{
			$vendor="'".$vendor."'";      
			$cond .=" AND EMP.ETO_LEAP_VENDOR_NAME = $vendor";               
		}
		$sql = "SELECT EMP.ETO_LEAP_EMP_ID,
		EMP.ETO_LEAP_EMP_NAME,
		TL.ETO_LEAP_EMP_NAME TLNAME,
		EMP.ETO_LEAP_VENDOR_NAME,
		FK_GLUSR_USR_ID,
		FK_GL_ATTRIBUTE_ID,
		FK_MODULE_NAME,
		SCREEN_NAME VENDOR_NAME,
		GL_PROFILE_OLD_VALUE OLD_UIF,
		GL_PROFILE_NEW_VALUE NEW_UIF,
	  TO_CHAR(GL_PROFILE_ENRICHMENT_DATE,'DD-MON-YYYY') FLAG_DATE,
		GL_PROFILE_UPDATED_BY_ID EMPID,
		ETO_OFR_DISPLAY_ID
	  FROM BL_PROFILE_ENRICHMENT,ETO_LEAP_MIS_INTERIM EMP, ETO_LEAP_MIS_INTERIM TL 
	  WHERE FK_GL_ATTRIBUTE_ID =201 
	  AND EMP.ETO_LEAP_EMP_ID = GL_PROFILE_UPDATED_BY_ID
	  AND EMP.ETO_LEAP_TL_ID = TL.ETO_LEAP_EMP_ID $cond
	  ORDER BY GL_PROFILE_ENRICHMENT_DATE";

		$sth=pg_query($dbh,$sql); 
		$html_str='';		
		$head=array('Date', 'Vendor', 'Emp ID', 'Emp Name', 'Team Leader', 'Offer ID', 'GL ID', 'Old Value', 'New Value');
		
		echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">';
		$html_str .='<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="9"><b>Detail Report</b></td></tr><tr>';
		for($i=0;$i<count($head);$i++){
			$html_str .= '<td  style="text-align:center;" bgcolor="#dff8ff" width="12%"><b>'.$head[$i].'</b></td>';
		}
		
		$html_str .='</tr>';
		while($temp = pg_fetch_array($sth))																																																																
		{
			$offer=$temp['eto_ofr_display_id'];
			$html_str .= '<tr> <td  style="text-align:center;" >'.$temp['flag_date'].'</td><td  style="text-align:center;" >'.$temp['eto_leap_vendor_name'].'</td><td  style="text-align:center;" >'.$temp['empid'].'</td><td  style="text-align:center;" >'.$temp['eto_leap_emp_name'].'</td><td  style="text-align:center;" >'.$temp['tlname'].'</td><td  style="text-align:center;" ><a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=ofrHist&offer='.$offer.'&mid=3424"  target="_blank" style="text-decoration:none;color:#0000ff;font-family: arial">'.$temp['eto_ofr_display_id'].'</a></td><td  style="text-align:center;" >'.$temp['fk_glusr_usr_id'].'</td><td  style="text-align:center;" >'.$temp['old_uif'].'</td><td  style="text-align:center;" >'.$temp['new_uif'].'</td></tr>';
		}
		echo $html_str.'</table>';						
	}else
	{
		echo 'You can select max 7 days date';    
	}
	die;     
 }
   public function reviewpool($request)
 {
        $emp_id = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
	$obj = new Globalconnection();
	$host_name = $_SERVER['SERVER_NAME'];
	$dbh=$obj->connect_db_oci('postgress_web68v');
    	$start_date = $request->getParam('start_date','');
	$end_date = $request->getParam('end_date','');
	$nodays=(strtotime($end_date) - strtotime($start_date))/ (60 * 60 * 24); //it will count no. of days

	if($nodays >= 0 && $nodays < 7)
	{   
		
		$cond = " AND date(GL_PROFILE_AUDIT_DATE) BETWEEN TO_DATE('$start_date','DD-MON-YYYY') AND TO_DATE('$end_date','DD-MON-YYYY') ";
                $vendor=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : '';
		$vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
		
		if($vendor <>'ALL')
		{
			$vendorVal="'".str_replace(",", "','", $vendorVal)."'";   
			$cond .=" AND EMP.ETO_LEAP_VENDOR_NAME IN ($vendorVal)";                 
			
		}               
		
                $sql = "WITH tbl AS
                                (SELECT GL_PROFILE_AUDIT_DATE,
                                ETO_LEAP_VENDOR_NAME ,
                                ETO_LEAP_TL_ID,
                                GL_PROFILE_AUDIT_BY,
                                NULLIF(GL_PROFILE_OLD_VALUE, '')::NUMERIC GL_PROFILE_OLD_VALUE,
                                CASE WHEN (GL_PROFILE_AUDIT_STATUS = '1') THEN 1 ELSE NULL
                                END CHANGES_MADE,
                                CASE WHEN (GL_PROFILE_AUDIT_STATUS = '3') THEN 1
                                ELSE NULL END REPOSTED,
                                CASE WHEN (GL_PROFILE_AUDIT_STATUS = '0')THEN 1 ELSE NULL
                                END NO_CHANGE,
                                CASE WHEN (GL_PROFILE_AUDIT_BY = '-1') THEN 1
                                WHEN (GL_PROFILE_AUDIT_STATUS = '2') THEN 1
                                ELSE NULL END EXPIRED
                                FROM BL_PROFILE_ENRICHMENT
                                LEFT OUTER JOIN ETO_LEAP_MIS_INTERIM EMP
                                ON GL_PROFILE_AUDIT_BY =EMP.ETO_LEAP_EMP_ID
                                WHERE FK_GL_ATTRIBUTE_ID =222
                                $cond
                                )
                                SELECT TO_CHAR(GL_PROFILE_AUDIT_DATE,'DD-MON-YYYY') AUDIT_DATE,
                                tbl.ETO_LEAP_VENDOR_NAME,
                                COUNT(1) AS TOTAL_COUNT,
                                ROUND(AVG( GL_PROFILE_OLD_VALUE ), 2 ) AHT,
                                COUNT(CHANGES_MADE) AS CHANGES_MADE,
                                COUNT(NO_CHANGE) NO_CHANGE,
                                COUNT(EXPIRED)EXPIRED_COUNT,
                                COUNT(REPOSTED)REPOSTED
                                FROM tbl
                                LEFT OUTER JOIN ETO_LEAP_MIS_INTERIM TL
                                ON tbl.ETO_LEAP_TL_ID=TL.ETO_LEAP_EMP_ID
                                GROUP BY TO_CHAR(GL_PROFILE_AUDIT_DATE,'DD-MON-YYYY'),tbl.ETO_LEAP_VENDOR_NAME 
                                ORDER BY TO_CHAR(GL_PROFILE_AUDIT_DATE,'DD-MON-YYYY') DESC;";
              

		$sth=pg_query($dbh,$sql); 
		$html_str='';		
		
			$html_str .= '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">
			<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="8"><b>Summary Report</b></td></tr><tr>
			<td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Audit date</b></td>
			<td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Centre Name</b></td>
			<td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Review Count</b></td>
                        <td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>AHT (sec)</b></td> 
                        <td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Changes Made</b></td> 
                        <td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>No Change</b></td> 
                        <td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Expired Count</b></td> 
                        <td  style="text-align:center;" bgcolor="#dff8ff" width="10%"><b>Reposted Count</b></td> 
			</tr>';
		
		$html_str .='</tr>';
		while($temp = pg_fetch_array($sth))
		{
                    $crVendork=$temp['eto_leap_vendor_name'];
                    $auditdate=$temp['audit_date'];
                    $reviewcount=$temp['total_count'];
                    $changesmade=$temp['changes_made'];
                    $nochange=$temp['no_change'];
                 
                                
			
    $html_str .= '<tr><td  style="text-align:center;" >'.$auditdate.'</td><td  style="text-align:center;" >'.$temp['eto_leap_vendor_name']."<a href='javascript:void(0)' "
            . "onclick=\"empWiseDetail('REVIEWPOOL','divid1','$start_date','$end_date','$crVendork','$auditdate','','','','','');\" style='text-decoration:none;color:#0000ff' ><b>+</b></a></td><td  style=\"text-align:center;\">".$temp['total_count'].'</td><td  style="text-align:center;" >'.$temp['aht'].'</td><td  style="text-align:center;" >'.$temp['changes_made'].'</td><td  style="text-align:center;" >'.$temp['no_change'].'</td><td  style="text-align:center;" >'.$temp['expired_count'].'</td><td  style="text-align:center;" >'.$temp['reposted'].'</td></tr>';
		}
		echo $html_str .= '</table><div id="divid1" style="display:none; margin:0px auto;padding:8px 0px 8px 0px"></div>'; 						
	}else
	{
		echo 'You can select max 7 days date';    
	}
	die;
 }
  public function pendingreviewpool($request)
 {
	$emp_id = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
	$obj = new Globalconnection();
	$host_name = $_SERVER['SERVER_NAME'];
	$dbh=$obj->connect_db_oci('postgress_web68v');
    	$start_date = $request->getParam('start_date','');
	$end_date = $request->getParam('end_date','');
	$nodays=(strtotime($end_date) - strtotime($start_date))/ (60 * 60 * 24); //it will count no. of days

	if($nodays >= 0 && $nodays < 7)
	{   
		
		$cond = " AND date(GL_PROFILE_ENRICHMENT_DATE) BETWEEN TO_DATE('$start_date','DD-MON-YYYY') AND TO_DATE('$end_date','DD-MON-YYYY') ";
                $vendor=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : '';
		$vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
		
		if($vendor <>'ALL')
		{
			$vendorVal="'".str_replace(",", "','", $vendorVal)."'";   
			$cond .=" AND EMP.ETO_LEAP_VENDOR_NAME IN ($vendorVal)";                 
			
		}               
		
                $sql = "with tbl as (select GL_PROFILE_ENRICHMENT_DATE,ETO_LEAP_TL_ID,GL_PROFILE_AUDIT_DATE
                        from BL_PROFILE_ENRICHMENT left outer join ETO_LEAP_MIS_INTERIM EMP on GL_PROFILE_AUDIT_BY=EMP.ETO_LEAP_EMP_ID
                        where FK_GL_ATTRIBUTE_ID =222 $cond
                        )
                        select TO_CHAR(GL_PROFILE_ENRICHMENT_DATE,'DD-MON-YYYY') REVIEW_DATE,COUNT(1) AS TOTAL_COUNT,
                        COUNT(CASE WHEN (GL_PROFILE_AUDIT_DATE IS NOT NULL) THEN 1 ELSE NULL END) REVIEW_COUNT
                        from tbl left outer join ETO_LEAP_MIS_INTERIM TL on tbl.ETO_LEAP_TL_ID=TL.ETO_LEAP_EMP_ID
                        GROUP BY TO_CHAR(GL_PROFILE_ENRICHMENT_DATE,'DD-MON-YYYY')
                        ORDER BY TO_CHAR(GL_PROFILE_ENRICHMENT_DATE,'DD-MON-YYYY') DESC";
              
		$sth=pg_query($dbh,$sql); 
		$html_str='';		
		
			$html_str .= '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">
			<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="5"><b>Summary Report</b></td></tr><tr>
			<td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>Reviewed on</b></td>
			<td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Total Count</b></td>  
			<td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Review Count</b></td>  
                        <td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Pending Count</b></td>  
			</tr>';
		
		$html_str .='</tr>';
		while($temp = pg_fetch_array($sth))
		{
                    $auditdate=$temp['review_date'];
                    $pendingcount=$temp['total_count']-$temp['review_count'];

                $html_str .= '<tr><td  style="text-align:center;" >'.$auditdate.'</td><td  style="text-align:center;" >'.$temp['total_count'].'</td><td  style="text-align:center;">'.$temp['review_count'].'</td><td  style="text-align:center;" >'.$pendingcount.'</td></tr>';
		}
		echo $html_str .= '</table><div id="divid1" style="display:none; margin:0px auto;padding:8px 0px 8px 0px"></div>'; 						
	}else
	{
		echo 'You can select max 7 days date';    
	}
	die;
 }
   public function reviewpooldetailemp($request)
 {
        $emp_id = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
	$obj = new Globalconnection();
	$dbh=$obj->connect_db_oci('postgress_web68v');
    	$start_date = $request->getParam('start_date','');
	$end_date = $request->getParam('end_date','');
	$nodays=(strtotime($end_date) - strtotime($start_date))/ (60 * 60 * 24); //it will count no. of days
        $auditdate=$request->getParam('source','');
	if($nodays >= 0 && $nodays < 7)
	{   
            if($auditdate<>''){
                $cond = " AND date(GL_PROFILE_AUDIT_DATE)='$auditdate'";
            }else{
                $cond = " AND date(GL_PROFILE_AUDIT_DATE)='$start_date'";
            }
		
		$vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : '';
		
		if($vendor <>'')
		{
			$vendor="'".$vendor."'";      
			$cond .=" AND EMP.ETO_LEAP_VENDOR_NAME = $vendor";               
		}else{
                    $cond .=" AND GL_PROFILE_AUDIT_BY IS NULL";
                }

		$sql = "WITH tbl AS
                        (SELECT TO_CHAR(GL_PROFILE_AUDIT_DATE,'DD-MON-YYYY') AS AUDIT_DATE,
                        EMP.ETO_LEAP_EMP_ID,
                        ETO_LEAP_TL_ID,
                        EMP.ETO_LEAP_EMP_NAME,
                        NULLIF(GL_PROFILE_OLD_VALUE, '')::NUMERIC GL_PROFILE_OLD_VALUE,
                        GL_PROFILE_AUDIT_STATUS,
                        GL_PROFILE_AUDIT_BY,
                        EMP.ETO_LEAP_VENDOR_NAME
                        FROM BL_PROFILE_ENRICHMENT
                        LEFT OUTER JOIN ETO_LEAP_MIS_INTERIM EMP
                        ON GL_PROFILE_AUDIT_BY =EMP.ETO_LEAP_EMP_ID
                        WHERE FK_GL_ATTRIBUTE_ID =222
                        $cond
                        )
                        SELECT tbl.AUDIT_DATE ,
                        tbl.ETO_LEAP_EMP_ID EMP_ID,
                        tbl.ETO_LEAP_EMP_NAME EMP_NAME,
                        tbl.ETO_LEAP_VENDOR_NAME VENDOR_NAME,
                        TL.ETO_LEAP_EMP_NAME TLNAME,
                        ROUND( AVG( GL_PROFILE_OLD_VALUE ), 2 ) AHT,
                        COUNT(1) AS TOTAL_COUNT,
                        COUNT(CASE WHEN (GL_PROFILE_AUDIT_STATUS = '1')THEN 1
                        ELSE NULL END) CHANGES_MADE,
                        COUNT(CASE WHEN (GL_PROFILE_AUDIT_STATUS = '3')THEN 1
                        ELSE NULL END) REPOSTED,
                        COUNT(CASE WHEN (GL_PROFILE_AUDIT_STATUS = '0')THEN 1
                        ELSE NULL END) NO_CHANGE,
                        COUNT(CASE WHEN (GL_PROFILE_AUDIT_BY = '-1') THEN 1
                        WHEN (GL_PROFILE_AUDIT_STATUS = '2')THEN 1
                        ELSE NULL END) EXPIRED
                        FROM tbl
                        LEFT OUTER JOIN ETO_LEAP_MIS_INTERIM TL
                        ON tbl.ETO_LEAP_TL_ID = TL.ETO_LEAP_EMP_ID
                        GROUP BY AUDIT_DATE,EMP_ID,EMP_NAME,VENDOR_NAME,TLNAME";
                

		$sth=pg_query($dbh,$sql); 
		$html_str='';		
		$head=array('Review Date', 'Centre Name', 'Emp Id', 'Emp Name', 'Team Leader', 'Review Count','AHT (sec)','Changes Made','No Change','Expired Count','Reposted Count');
		
		echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="80px">';
		$html_str .='<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="11"><b>Employee Wise Report</b></td></tr><tr>';
		for($i=0;$i<count($head);$i++){
			$html_str .= '<td  style="text-align:center;" bgcolor="#dff8ff" width="8%"><b>'.$head[$i].'</b></td>';
		}
		
		$html_str .='</tr>';
		while($temp = pg_fetch_array($sth))																																																																
		{       
                        $crVendork=$temp['vendor_name'];
                        $auditdate=$temp['audit_date'];
                        $empid=$temp['emp_id'];
    $html_str .= '<tr> <td  style="text-align:center;" >'.$temp['audit_date'].'</td><td  style="text-align:center;" >'.$temp['vendor_name'].'</td><td  style="text-align:center;" >'.$temp['emp_id'].'</td><td  style="text-align:center;" >'.$temp['emp_name']."<a href='javascript:void(0)' onclick=\"empWiseDetail('REVIEW','divid2','$start_date','$end_date','$crVendork','$auditdate','','','$empid','','');\" style='text-decoration:none;color:#0000ff' ><b>+</b></a></td><td style=\"text-align:center;\">".$temp['tlname'].'</td><td  style="text-align:center;">'.$temp['total_count'].'</td><td  style="text-align:center;">'.$temp['aht'].'</td><td  style="text-align:center;">'.$temp['changes_made'].'</td><td  style="text-align:center;">'.$temp['no_change'].'</td><td  style="text-align:center;">'.$temp['expired'].'</td><td  style="text-align:center;" >'.$temp['reposted'].'</td></tr>';
		}
		echo $html_str.'</table><div id="divid2" style="display:none; margin:0px auto;padding:8px 0px 8px 0px"></div>';						
	}else
	{
		echo 'You can select max 7 days date';    
	}
	die;     
 }
 
 
  public function reviewpooldetail($request)
 {
	$emp_id = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
	$obj = new Globalconnection();
	$dbh=$obj->connect_db_oci('postgress_web68v');	
    	$start_date = $request->getParam('start_date','');
	$end_date = $request->getParam('end_date','');
	$nodays=(strtotime($end_date) - strtotime($start_date))/ (60 * 60 * 24); //it will count no. of days
        $auditdate=$request->getParam('source','');
        $empid=$request->getParam('tlid','');
	if($nodays >= 0 && $nodays < 7)
	{   
		
                 if($auditdate<>''){
                    $cond = " AND date(GL_PROFILE_AUDIT_DATE)='$auditdate' and EMP.ETO_LEAP_EMP_ID=$empid";
                }else{
                    $cond = " AND date(GL_PROFILE_AUDIT_DATE)='$start_date' AND GL_PROFILE_AUDIT_BY IS NULL ";
                }
            
		$vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : '';
		
		if($vendor <>'')
		{
			$vendor="'".$vendor."'";      
			$cond .=" AND EMP.ETO_LEAP_VENDOR_NAME = $vendor";               
		}

$sql = "WITH tbl AS
                (SELECT TO_CHAR(GL_PROFILE_AUDIT_DATE,'DD-MON-YYYY') AS AUDIT_DATE ,
                  EMP.ETO_LEAP_EMP_ID,
                  ETO_LEAP_TL_ID,
                  EMP.ETO_LEAP_EMP_NAME,
                  EMP.ETO_LEAP_VENDOR_NAME,
                  ETO_OFR_DISPLAY_ID,
                  CASE
                    WHEN (GL_PROFILE_AUDIT_STATUS = 0)
                    THEN 'No Change'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1000')
                    THEN 'Title'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0100')
                    THEN 'Mcat'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0010')
                    THEN 'Description'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0001')
                    THEN 'ISQ'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1100')
                    THEN 'Title,Mcat'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1010')
                    THEN 'Title,Description'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1001')
                    THEN 'Title,ISQ'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0110')
                    THEN 'Mcat,Description'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0101')
                    THEN 'Mcat,ISQ'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0011')
                    THEN 'Description,ISQ'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1110')
                    THEN 'Title,Mcat,Description'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0111')
                    THEN 'Mcat,Description,ISQ'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1011')
                    THEN 'Title,Description,ISQ'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1101')
                    THEN 'Title,Mcat,ISQ'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1111')
                    THEN 'Title,Mcat,Description,Isq'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 2 AND GL_PROFILE_NEW_VALUE = '3') 
                    THEN 'Exp-Invalid Description'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 2 AND GL_PROFILE_NEW_VALUE = '14') 
                    THEN 'Exp-Is a Supplier'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 2 AND GL_PROFILE_NEW_VALUE = '10') 
                    THEN 'Exp-Wrong Contact details'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 2 AND GL_PROFILE_NEW_VALUE = '73') 
                    THEN 'Exp-Wrong Search Keyword'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 3 AND GL_PROFILE_NEW_VALUE = '3') 
                    THEN 'Re-Invalid Description'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 3 AND GL_PROFILE_NEW_VALUE = '14') 
                    THEN 'Re-Is a Supplier'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 3 AND GL_PROFILE_NEW_VALUE = '10') 
                    THEN 'Re-Wrong Contact details'
                    WHEN (GL_PROFILE_AUDIT_STATUS = 3 AND GL_PROFILE_NEW_VALUE = '73') 
                    THEN 'Re-Wrong Search Keyword'
                  END CHANGE_MADE,
                  NULLIF(GL_PROFILE_OLD_VALUE, '')::NUMERIC GL_PROFILE_OLD_VALUE
                FROM BL_PROFILE_ENRICHMENT
                LEFT OUTER JOIN ETO_LEAP_MIS_INTERIM EMP
                ON GL_PROFILE_AUDIT_BY                      =EMP.ETO_LEAP_EMP_ID
                WHERE FK_GL_ATTRIBUTE_ID                    =222
                  $cond
                ORDER BY TO_CHAR(GL_PROFILE_AUDIT_DATE,'DD-MON-YYYY')
                )
              SELECT AUDIT_DATE,
                tbl.ETO_LEAP_EMP_ID EMP_ID,
                tbl.ETO_LEAP_EMP_NAME EMP_NAME,
                tbl.ETO_LEAP_VENDOR_NAME VENDOR_NAME,
                TL.ETO_LEAP_EMP_NAME TLNAME,
                ETO_OFR_DISPLAY_ID,
                GL_PROFILE_OLD_VALUE AHT,
                CHANGE_MADE
                FROM tbl
              LEFT OUTER JOIN ETO_LEAP_MIS_INTERIM TL
              ON tbl.ETO_LEAP_TL_ID = TL.ETO_LEAP_EMP_ID";

		$sth=pg_query($dbh,$sql); 
		$html_str='';		
		$head=array('Audit Date', 'Centre Name', 'Emp Id', 'Emp Name', 'Team Leader', 'Offer Id','AHT (sec)','Status');
		
		echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">';
		$html_str .='<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="9"><b>Detail Report</b></td></tr><tr>';
		for($i=0;$i<count($head);$i++){
			$html_str .= '<td  style="text-align:center;" bgcolor="#dff8ff" width="12%"><b>'.$head[$i].'</b></td>';
		}
		$i=1;
		$html_str .='</tr>';
		while($temp = pg_fetch_array($sth))																																																																
		{
			$offer=$temp['eto_ofr_display_id'];
                        $crVendork=isset($temp['vendor_name'])? $temp['vendor_name'] :'';
                        $auditdate=isset($temp['audit_date'])? $temp['audit_date'] :''; 
                        $empid=isset($temp['emp_id'])? $temp['emp_id'] :''; $temp['emp_id'];
                        $eto_leap_emp_name=isset($temp['emp_name'])? $temp['emp_name'] :'';
                        $tlname=isset($temp['tlname'])? $temp['tlname'] :'';
                        $aht=isset($temp['aht'])? $temp['aht'] :'';
                        $status=isset($temp['change_made'])? $temp['change_made'] :'';
$html_str .= '<tr><td  style="text-align:center;" >'.$auditdate.'</td><td style="text-align:center;" >'.$crVendork.'</td><td  style="text-align:center;" >'.$empid.'</td><td  style="text-align:center;" >'.$eto_leap_emp_name.'</td><td  style="text-align:center;" >'.$tlname.'</td><td  style="text-align:center;" ><a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=ofrHist&offer='.$offer.'&mid=3424"  target="_blank" style="text-decoration:none;color:#0000ff;font-family: arial">'.$temp['eto_ofr_display_id'].'</a></td> <td  style="text-align:center;" >'.$aht.'</td> <td  style="text-align:center;" >'.$status.'</td></tr>';
		$i++;                        
                }
		echo $html_str.'</table>';						
	}else
	{
		echo 'You can select max 7 days date';    
	}
	die;     
 }

 public function DNCCallingdetail($request)
 {
  $model = new GlobalmodelForm();
  $start_date = $request->getParam('start_date','');
  $status = $request->getParam('status','');
  $vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : ''; 
  $tlid = $request->getParam('tlid',0);
  $tlCond='';
  $venCond='';
  $obj = new Globalconnection();  
      										
  if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))	
  {	
	  $dbh = $obj->connect_db_yii('postgress_web68v');   	
  }else{	
	  $dbh = $obj->connect_db_yii('postgress_web68v'); 	
  }	
  $dbh = $obj->connect_db_yii('postgress_web68v'); 
  $sql="";  
  if($tlid >0)
  {
   $tlCond=" AND ETO_LEAP_TL_ID =:IN_LEAP_ID";
  }
  if($vendor <>'ALL')
  {
       $venCond=" AND ETO_LEAP_VENDOR_NAME =:ETO_LEAP_VENDOR_NAME";
	$bind[':ETO_LEAP_VENDOR_NAME'] = $vendor;
  }
  if($status=='APPROVED'){
      $sql="SELECT  ETO_LEAP_VENDOR_NAME,ETO_LEAP_TL_ID,ETO_LEAP_AGENT_NAME,ETO_LEAP_EMP_ID,gen_date,eto_ofr_display_id FROM (
select
eto_ofr_display_id, date(eto_ofr_postdate_orig) gen_date,ETO_OFR_APPROV_BY_ORIG FK_EMPLOYEEID 
from
eto_ofr
where
date(eto_ofr_postdate_orig) = date(to_date(:start_date,'DD-MON-YY') )
and fk_gl_module_id <> 'FENQ'
AND coalesce(user_identifier_flag,0) = 39
union ALL
select
eto_ofr_display_id, date(eto_ofr_postdate_orig),ETO_OFR_APPROV_BY_ORIG FK_EMPLOYEEID
from
eto_ofr_expired
where
date(eto_ofr_postdate_orig) = date(to_date(:start_date,'DD-MON-YY') )
and fk_gl_module_id <> 'FENQ'
AND coalesce(user_identifier_flag,0) = 39 
) A , ETO_LEAP_MIS_INTERIM 
WHERE FK_EMPLOYEEID = ETO_LEAP_EMP_ID 
$venCond  " ; 

  }elseif($status=='DELETED'){
      $sql="SELECT  ETO_LEAP_VENDOR_NAME,ETO_LEAP_TL_ID,ETO_LEAP_AGENT_NAME,ETO_LEAP_EMP_ID,gen_date,eto_ofr_display_id FROM (
select
eto_ofr_display_id,date(eto_ofr_postdate_orig) gen_date,ETO_OFR_DELETEDBYID FK_EMPLOYEEID
from
eto_ofr_temp_del
where
date(eto_ofr_postdate_orig) = date(to_date(:start_date,'DD-MON-YY') )
and fk_gl_module_id <> 'FENQ'
AND coalesce(user_identifier_flag,0) = 39
union ALL 
select
dir_query_free_refid,date(date_r) gen_date,ETO_OFR_FENQ_EMP_ID FK_EMPLOYEEID
from
eto_ofr_from_fenq
where
date(date_r) =date(to_date(:start_date,'DD-MON-YY') )
AND coalesce(user_identifier_flag,0) = 39 
) A , ETO_LEAP_MIS_INTERIM  
WHERE FK_EMPLOYEEID = ETO_LEAP_EMP_ID 
$venCond  " ; 
  }else{
      $sql="SELECT  ETO_LEAP_VENDOR_NAME,ETO_LEAP_TL_ID,ETO_LEAP_AGENT_NAME,ETO_LEAP_EMP_ID,gen_date,eto_ofr_display_id FROM (
select
eto_ofr_display_id,date(date_r) gen_date, FK_EMPLOYEEID  
from
dir_query_free
where
date(date_r) = date(to_date(:start_date,'DD-MON-YY') ) 
AND coalesce(user_identifier_flag,0) = 39
) A , ETO_LEAP_MIS_INTERIM  
WHERE FK_EMPLOYEEID = ETO_LEAP_EMP_ID 
$venCond  " ; 
} 

     $bind[':start_date']=$start_date;      
     if($tlid >0)
     {
      $bind[':IN_LEAP_ID']=$tlid;      
     }
$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,$bind);
	
 $returndata = '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="1000px">
        							<tr>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Date</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>Centre Name</b></td>
        							<td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>TLID</b></td>  
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="20%"><b>Employee</b></td> 
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>EmployeeID</b></td> 
                                                                <td  style="text-align:center;" bgcolor="#dff8ff" width="15%"><b>Offer ID</b></td>                 
                                                                </tr>';
	 while($rec=$sth->read())
	  {
             $temp=array_change_key_case($rec, CASE_UPPER);  
                 $crVendork=$temp['ETO_OFR_DISPLAY_ID'];
                 $returndata .= "<tr>
		  <td  style='text-align:center;' >".$temp['GEN_DATE']."</td>
                  <td  style='text-align:center;'>".$temp['ETO_LEAP_VENDOR_NAME']."</td>
                  <td  style='text-align:center;' >".$temp['ETO_LEAP_TL_ID']."</td>
                  <td  style='text-align:center;' >".$temp['ETO_LEAP_AGENT_NAME']."</td>
                  <td  style='text-align:center;' >".$temp['ETO_LEAP_EMP_ID']."</td>";
                  $returndata .= "<td width='100px' style='text-align:center;'><a href='/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=".$crVendork."&mid=3424'  target='_blank' style='text-decoration:none;color:#0000ff;font-family: arial'>".$crVendork."</a></td>";
                  $returndata .= '</tr>';
    }   
    $returndata .= '</table><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>'; 
    echo $returndata;      
 }

	public function banned_report($request)
  {
        echo '<script type=\"text/javascript\">
		function showSearch(offer) 
                {        
                  var root = document.location.hostname;
                   root = "https://"+root
                  window.open(root+\'/index.php?r=admin_eto/OfferDetail/editflaggedleads&ban=1&mid=3424&offer=\'+offer+\'&go=Go\',\'_blank\');
                }
	    </script>';
    $start_date=isset($request['start_date'])?$request['start_date']:'';
    $rec=array();    
            $obj = new Globalconnection();
			$host_name = $_SERVER['SERVER_NAME'];
			$time=isset($_REQUEST['HR']) ? $_REQUEST['HR'] : '';
			$subtype=isset($_REQUEST['subtype']) ? $_REQUEST['subtype'] : '';
            if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net'){
                $dbh = $obj->connect_db_oci('postgress_web77v');
              }else{                        
                $dbh = $obj->connect_db_oci('postgress_web68v');
			  }
			  
			  if($time<10 && $time !='TOT' && $time !='TOT_9_9' &&$time !='TOT_9'){
				$time='0'.$time;
			}
			  $cond = "";
			$cond = " AND date(gl_profile_enrichment_date) = '$start_date'";
			
			if($subtype =='SENT')
		{	
			
			if($time !='TOT'){
				if($time =='TOT_9'){		
					$time1 = '09' ;
					$time2 = '21' ;
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24') BETWEEN '$time1' AND '$time2'";
				}else
				{
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";
				}
			}
		}
		elseif($subtype =='PEND')
                {
			$cond .=' AND gl_profile_audit_date IS NULL';
			if($time !='TOT'){
				$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";				
			}
		}
		elseif($subtype =='ATTEMP')
		{
			$cond .=' AND gl_profile_audit_date IS NOT NULL';
			if($time !='TOT'){
				if($time =='TOT_9_9'){		
					$time1 = '09' ;
					$time2 = '21' ;
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24') BETWEEN '$time1' AND '$time2'";
				}
				else{
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";				
				}				
			}
		}
		
        elseif($subtype =='ATTEMP_5')
		{

			$cond .=" AND (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) <=5";
			if($time !='TOT'){
				if($time =='TOT_9_9'){		
					$time1 = '09' ;
					$time2 = '21' ;
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24') BETWEEN '$time1' AND '$time2'";
				}
				else{
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";
				}
				
				
			}
		}
		elseif($subtype =='NOT_ATTEMP_5')
		{

			$cond .=" AND (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) >5";
			if($time !='TOT'){
				if($time =='TOT_9_9'){		
					$time1 = '09' ;
					$time2 = '21' ;
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24') BETWEEN '$time1' AND '$time2'";
				}
				else{
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";
				}
				
				
			}
		}

        elseif($subtype =='ATTEMP_TEN')
		{
			$cond .=" AND (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) <=10";
			if($time !='TOT'){
				if($time =='TOT_9_9'){		
					$time1 = '09' ;
					$time2 = '21' ;
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24') BETWEEN '$time1' AND '$time2'";
				}
				else{
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";
				}
			}
		}

		elseif($subtype =='NOT_ATTEMP_TEN')
		{
			$cond .=" AND (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) >10";
			if($time !='TOT'){
				if($time =='TOT_9_9'){		
					$time1 = '09' ;
					$time2 = '21' ;
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24') BETWEEN '$time1' AND '$time2'";
				}
				else{
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";
				}
			}
		}
		elseif($subtype =='PEND_TEN')
		{
			$cond .=" AND (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) >10 OR CALL_ATTEMPT_DATE is null)";
			if($time !='TOT'){
				if($time =='TOT_9_9'){		
					$time1 = '09' ;
					$time2 = '21' ;
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24') BETWEEN '$time1' AND '$time2'";
				}
				else{
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";
				}
			}
		}
		 elseif($subtype =='NOT_REC_TEN')
		{
			$cond .=' AND (gl_profile_enrichment_date - gl_profile_audit_date)*24*60 >10';
			if($time !='TOT'){
				$cond .=" AND (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)='$time'";				
			}
		}
		 elseif($subtype =='REC_TEN')
		{
		 $cond .=' AND (gl_profile_enrichment_date - gl_profile_audit_date)*24*60 <=10';
			if($time !='TOT'){
				$cond .=" AND (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)='$time'";
			}
		}
		elseif($subtype =='ATTEMP_15')
		{
			$cond .=" AND (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) <=15";
			if($time !='TOT'){
				if($time =='TOT_9_9'){		
					$time1 = '09' ;
					$time2 = '21' ;
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24') BETWEEN '$time1' AND '$time2'";
				}
				else
				{
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";
				}
			}
		}
		elseif($subtype =='NOT_ATTEMP_15')
		{
			$cond .=" AND (DATE_PART('day', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) * 24 + DATE_PART('hour', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP)) * 60 + DATE_PART('minute', gl_profile_audit_date::TIMESTAMP - gl_profile_enrichment_date::TIMESTAMP) >15";
			if($time !='TOT'){
				if($time =='TOT_9_9'){		
					$time1 = '09' ;
					$time2 = '21' ;
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24') BETWEEN '$time1' AND '$time2'";
				}
				else
				{
					$cond .=" AND to_char(gl_profile_enrichment_date,'HH24')='$time'";
				}
			}
		}
               $sql = "SELECT fk_glusr_usr_id userid,gl_profile_old_value AHT,screen_name,
                        BANNED_KEYWORD || ' [' ||
                  (CASE    WHEN(IS_AUTOMATED_BANNED='1') THEN 'From Service'
                          WHEN(IS_AUTOMATED_BANNED='2') THEN 'Adult'
                          WHEN(IS_AUTOMATED_BANNED='3') THEN 'Trademark'
                          WHEN(IS_AUTOMATED_BANNED='4') THEN 'Drugs' END) || '] ' BANNED_KEYWORD,
                  CASE    WHEN(gl_profile_new_value='1') THEN 'Service'
                          WHEN(gl_profile_new_value='2') THEN 'Both' ELSE 'Script' END Logic,
                           gl_profile_updated_by_id,gl_profile_audit_by,
                  CASE  WHEN(((gl_profile_audit_status='1') AND (gl_profile_audit_by <> -444))) THEN 'Deleted'
                          WHEN(gl_profile_audit_status='2') THEN 'Approved'
                          WHEN(gl_profile_audit_status='0' OR gl_profile_audit_status IS NULL) THEN 'Expired' 
                          WHEN gl_profile_audit_by=-444 THEN 'Pending' END Actions,
                          eto_ofr_display_id
                      from bl_profile_enrichment,leap_banned_keyword
                      where fk_gl_attribute_id=223
                      and eto_ofr_display_id=fk_eto_ofr_display_id $cond ";
                
                $sth = pg_query($dbh,$sql);	//echo"<br>$sql<br>";
                $head=array("SN","Buyer's GlID","Offer ID","Search Keyword","Banned Keyword [Banned Category]","Banned Logic","Action","Reviewers Emp id","Approvers Emp id","AHT");
                $html = '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
				$html.=  '<tr><td style="padding:4px;font-weight:bold;text-align:center;" colspan="10">Detailed Report</td></tr><tr style="background: #0195d3; color: white;">';
                foreach($head as $value){  
                     $html .= '<td style="padding:4px;color:white;font-weight:bold;text-align:center;">'.$value.'</td>'; 
                }
                 $i=0;
                while($rec=pg_fetch_array($sth)){
                    $i++;  
                    $rec=array_change_key_case($rec, CASE_UPPER); 
                    $html .= '<tr>    
                            <td style="padding:4px;text-align:center;"> '.$i.'</td>
                            <td style="padding:4px;text-align:center;"> '.$rec['USERID'].'</td>  
                            <td style="padding:4px;text-align:center;"> '.$rec['ETO_OFR_DISPLAY_ID'].'</td>
                            <td style="padding:4px;text-align:center;">'.$rec['SCREEN_NAME'].' </td>  
                            <td style="padding:4px;text-align:center;">'.$rec['BANNED_KEYWORD'].' </td>                           
                            <td style="padding:4px;text-align:center;">'.$rec['LOGIC'].'</td> 
                            <td style="padding:4px;text-align:center;">'.$rec['ACTIONS'].'</td>
                            <td style="padding:4px;text-align:center;">'.$rec['GL_PROFILE_AUDIT_BY'].'</td>
                            <td style="padding:4px;text-align:center;">'.$rec['GL_PROFILE_UPDATED_BY_ID'].'</td>
                            <td style="padding:4px;text-align:center;">'.$rec['AHT'].'</td> ';                         
                          
                    $html .= '</tr>'; 
                }   
				echo $html .='</table>';
				
		exit;		
  }

 
public function pppemp($request)
 {
        $emp_id = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
	$obj = new Globalconnection();
   	$dbh = $obj->connect_db_yii('postgress_web68v'); 
	$start_date = $request->getParam('start_date','');
        $model = new GlobalmodelForm();
		$fte=0;         
	        $cond = " AND date(login_approval_date) = TO_DATE('$start_date','DD-MON-YYYY') ";
		$vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : '';
		
		if($vendor <>'')
		{
			$vendor="'".$vendor."'";      
			$cond .=" AND fk_eto_leap_vendor_name = $vendor";               
		}

               $sql = "select TO_CHAR(login_approval_date,'DD-MON-YYYY') audit_date, fk_eto_leap_vendor_name vendor_name,"
                        . "fk_eto_leap_emp_id ename, sum(login_approved_by) login_approved_by,login_hour "
                        . "from leap_agent_login_activity, "
                        . "(select fk_employee_id, sum((date_part('hour', leap_crm_logout_time-leap_crm_login_time)*60*60 + "
                        . "date_part('minute', leap_crm_logout_time-leap_crm_login_time)*60"
                        . "+date_part('second', leap_crm_logout_time-leap_crm_login_time)))   login_hour "
                        . "from leap_login_activity_stats where date(leap_crm_login_time) = TO_DATE('$start_date','DD-MON-YYYY') 
                            group by fk_employee_id) 
                    leap_login_activity_stats 
                    where fk_employee_id=fk_eto_leap_emp_id
                     $cond group by TO_CHAR(login_approval_date,'DD-MON-YYYY') , fk_eto_leap_vendor_name, fk_eto_leap_emp_id ,login_hour 
                    order by fk_eto_leap_emp_id";

                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
		$html_str='';		
		$head=array('SN','Date', 'Centre Name', 'Associate Id', 'Total Approvals', 'Total Login Hours','FTE','PPP');
		
		echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="100%">';
		$html_str .='<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="8"><b>Detail Report</b></td></tr><tr>';
		for($i=0;$i<count($head);$i++){
			$html_str .= '<td  style="text-align:center;" bgcolor="#dff8ff" width="12%"><b>'.$head[$i].'</b></td>';
		}
		$i=0;
		$html_str .='</tr>';
                $total_appcount=$total_login_hour=0;
                while($temp=$sth->read())
		{
                    $i++;
                        $crVendork=isset($temp['vendor_name'])? $temp['vendor_name'] :'';
                        $ename=isset($temp['ename'])? $temp['ename'] :'';
                        $auditdate=isset($temp['audit_date'])? $temp['audit_date'] :''; 
                        $appcount=isset($temp['login_approved_by'])? $temp['login_approved_by'] :0;
                        
                        $login_hour=isset($temp['login_hour'])? $temp['login_hour'] :'';
                        
                        $hours = floor($login_hour / 3600);
                        if($hours<10){$hours="0".$hours;}
                        
                        $minutes = floor(($login_hour / 60) % 60);
                        if($minutes<10){$minutes="0".$minutes;}
                        $seconds = $login_hour % 60;
                        if($seconds<10){$seconds="0".$seconds;}

                        $fte=0;
                        $log_h= "$hours:$minutes:$seconds";
                        $ppp = 0;
                        if($appcount>0 && $login_hour >0){
                            $fte=round($login_hour / 28800,2);
                            if($fte > 0){
                            $ppp=round($appcount / $fte);
                            }
                        }else{
                            $ppp=0;
                        }
                        $html_str .= '<tr><td style="padding:4px;text-align:center;"> '.$i.'</td><td  style="text-align:center;" >'.$auditdate.'</td><td style="text-align:center;" >'.$crVendork."</td>"
                        . '<td  style="text-align:center;" >'.$ename.'</td><td  style="text-align:center;" >'.$appcount.'</td>'
                                . '<td  style="text-align:center;" >'.$log_h.'</td><td  style="text-align:center;" >'.$fte.'</td>'
                                . '<td  style="text-align:center;" >'.$ppp.'</td></tr>';
                         
                        $total_appcount = $total_appcount + $appcount;
                        $total_login_hour = $total_login_hour + $login_hour;
                }
                $hours = floor($total_login_hour / 3600);
                if($hours<10){$hours="0".$hours;}

                $minutes = floor(($total_login_hour / 60) % 60);
                if($minutes<10){$minutes="0".$minutes;}
                $seconds = $total_login_hour % 60;
                if($seconds<10){$seconds="0".$seconds;}
                $total_login_hour_h= "$hours:$minutes:$seconds";
                       if($total_appcount>0 && $total_login_hour >0){
                            $fte=round($total_login_hour / 28800,2);
                            $ppp=round($total_appcount / $fte);
                        }else{
                            $ppp=0;
                        }
        
		echo $html_str.'<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="4"><b>Summary</b></td>'
                        . '<td style="text-align:center;" bgcolor="#dff8ff"><b>'.$total_appcount.'</b></td>'
                        . '<td style="text-align:center;" bgcolor="#dff8ff"><b>'.$total_login_hour_h.'</b></td>'
                        . '<td style="text-align:center;" bgcolor="#dff8ff"><b>'.$fte.'</b></td>'
                        . '<td style="text-align:center;" bgcolor="#dff8ff"><b>'.$ppp.'</b></td></tr></table>';						
	die;  
 }
 
  public function ppp($request)
 {
	$obj = new Globalconnection();
	$dbh = $obj->connect_db_yii('postgress_web68v'); 
    	$start_date = $request->getParam('start_date','');
	$end_date = $request->getParam('end_date','');
	$nodays=(strtotime($end_date) - strtotime($start_date))/ (60 * 60 * 24); //it will count no. of days
        $model = new GlobalmodelForm();
        $cond=$cond2='';                
	if($nodays >= 0 && $nodays < 7)
	{   	
		$vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
		
		if($vendorVal <>'ALL')
		{
			$vendorVal="'".str_replace(",", "','", $vendorVal)."'";   
			$cond =" AND fk_eto_leap_vendor_name IN ($vendorVal)";
                        $cond2 =" AND leap_vendor_name IN ($vendorVal)";			
		}               
		$sql="select a.*,b.*
                        from (
                        select TO_CHAR(login_approval_date,'DD-MON-YYYY') audit_date,fk_eto_leap_vendor_name vendor_name,
                        count(distinct fk_eto_leap_emp_id) as total_count, sum(login_approved_by) AS total_appcount
                        from leap_agent_login_activity
                        where date(login_approval_date) BETWEEN TO_DATE('$start_date','DD-MON-YYYY') AND TO_DATE('$end_date','DD-MON-YYYY')
                        $cond 
                        group by TO_CHAR(login_approval_date,'DD-MON-YYYY'),fk_eto_leap_vendor_name
                        ) a full outer join
                        (
                        select leap_vendor_name,date(leap_crm_logout_time) leap_crm_logout_time,
                        sum((date_part('hour', leap_crm_logout_time-leap_crm_login_time)*60*60 +
                         date_part('minute', leap_crm_logout_time-leap_crm_login_time)*60
                        +date_part('second', leap_crm_logout_time-leap_crm_login_time))) login_hour
                        from leap_login_activity_stats
                        where date(leap_crm_login_time) BETWEEN TO_DATE('$start_date','DD-MON-YYYY')
                        AND TO_DATE('$end_date','DD-MON-YYYY') 
                        $cond2 
                        group by leap_vendor_name,date(leap_crm_logout_time)
                        ) b
                        on a.vendor_name = b.leap_vendor_name
                        and date(a.audit_date)= date(b.leap_crm_logout_time) 
                        where date(audit_date) BETWEEN TO_DATE('$start_date','DD-MON-YYYY')
                        AND TO_DATE('$end_date','DD-MON-YYYY')";
                
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
		$html_str='';		
		$head=array('Date', 'Centre Name',' Total Agents', 'Total Approvals', 'Total Login Hours', 'FTE','Overall PPP');
		
		echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="100%">';
		$html_str .='<tr><td  style="text-align:center;" bgcolor="#dff8ff" colspan="7"><b>Vendorwise Summary Report</b></td></tr><tr>';
		for($i=0;$i<count($head);$i++){
			$html_str .= '<td  style="text-align:center;" bgcolor="#dff8ff" width="12%"><b>'.$head[$i].'</b></td>';
		}
		$i=1;
		$html_str .='</tr>';
                while($temp=$sth->read())
		{
                        $crVendork=isset($temp['vendor_name'])? $temp['vendor_name'] :'';
                        $auditdate=isset($temp['audit_date'])? $temp['audit_date'] :''; 
                        $appcount=isset($temp['total_appcount'])? $temp['total_appcount'] :0;
                        $login_hour=isset($temp['login_hour'])? $temp['login_hour'] :0;
                        $total_empcount=isset($temp['total_count'])? $temp['total_count'] :0;
                        $fte=$ppp=0;$log_h='';
                        
                        if($login_hour>0){
                        $hours = floor($login_hour / 28800);
                        if($hours>0 && $hours<10){$hours="0".$hours;}
                        
                        $minutes = floor(($login_hour / 60) % 60);
                        if($minutes>0 && $minutes<10){$minutes="0".$minutes;}
                        
                        $seconds = $login_hour % 60;
                        if($seconds>0 && $seconds<10){$seconds="0".$seconds;}

                        
                        $log_h= "$hours:$minutes:$seconds";
                        
                        if($appcount > 0){
                            $fte=round($login_hour / 28800,2);
                            if($fte>0){$ppp=round($appcount / $fte);}
                        }
                        }
                         
                         
                        $html_str .= '<tr><td  style="text-align:center;" >'.$auditdate.'</td><td style="text-align:center;" >'.$crVendork.""
                                . "<a href='javascript:void(0)' "
            . "onclick=\"empWiseDetail('pppemp','divid1','$auditdate','','$crVendork','','','','','','');\" "
                                . "style='text-decoration:none;color:#0000ff' ><b>+</b></a></td>"
                        . '<td  style="text-align:center;" >'.$total_empcount.'</td><td  style="text-align:center;" >'.$appcount.'</td>'
                                . '<td  style="text-align:center;" >'.$log_h.'</td>'
                        . '<td  style="text-align:center;" >'.$fte.'</td>'
                                . '<td  style="text-align:center;" >'.$ppp.'</td></tr>';
                        $i++;                        
                }
		echo $html_str.'</table><div id="divid1" style="display:none;width:1300px; margin:0px auto;padding:8px 0px 8px 0px"></div>';						
	}else
	{
		echo 'You can select max 7 days date';    
	}
	die;     
 }

 
}