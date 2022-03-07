<?php
  class isq_edit_screen_pg extends CFormModel
  {
  public function show_isq_question($dbh_imbl,$mcat_id)
  {
 
		$type = 3;
		$errMsg = '';$quesArr = array();$buyerRespArr = array();
		if(empty($mcat_id)){
			$errMsg = "MCAT ID Empty";
		} else {                       
			if($dbh_imbl) {
				$questionChecksql = "SELECT COUNT(1) CNT FROM IM_CAT_SPECIFICATION WHERE IM_CAT_SPEC_CATEGORY_ID = $mcat_id AND IM_CAT_SPEC_STATUS = 1 AND IM_CAT_SPEC_CATEGORY_TYPE =$type";
				
		               
				$questionCheckSth = pg_query($dbh_imbl,$questionChecksql);
				$quesExistsCnt = pg_fetch_array($questionCheckSth);
				$quesExistsCnt=$quesExistsCnt['cnt'];
				
				
					$quesDetailsSql = "	SELECT 
								A.IM_SPEC_MASTER_ID,A.IM_SPEC_MASTER_DESC,A.IM_SPEC_MASTER_TYPE,
								B.IM_CAT_SPEC_CATEGORY_ID,B.IM_CAT_SPEC_PRIORITY,B.IM_CAT_SPEC_STATUS,C.IM_SPEC_OPTIONS_STATUS,
								C.IM_SPEC_OPTIONS_DESC,
								C.IM_SPEC_OPTIONS_ID,
								ROW_NUMBER() OVER (ORDER BY 1) RN
								FROM IM_SPECIFICATION_MASTER A 
								JOIN IM_CAT_SPECIFICATION B ON A.IM_SPEC_MASTER_ID = B.FK_IM_SPEC_MASTER_ID
								JOIN IM_SPECIFICATION_OPTIONS C ON A.IM_SPEC_MASTER_ID = C.FK_IM_SPEC_MASTER_ID
								WHERE 
								B.IM_CAT_SPEC_CATEGORY_ID = $mcat_id 
								AND B.IM_CAT_SPEC_CATEGORY_TYPE = $type															
								ORDER BY B.IM_CAT_SPEC_STATUS,B.IM_CAT_SPEC_PRIORITY
								";
								
								
					$quesDetailssth= pg_query($dbh_imbl,$quesDetailsSql);
					while($rec = pg_fetch_array($quesDetailssth)) {
					        $rec=array_change_key_case($rec, CASE_UPPER);  
					        $IM_SPEC_OPTIONS_DESC=isset($rec['IM_SPEC_OPTIONS_DESC']) ? $rec['IM_SPEC_OPTIONS_DESC'] : '';
					        $IM_SPEC_MASTER_DESC=isset($rec['IM_SPEC_MASTER_DESC']) ? $rec['IM_SPEC_MASTER_DESC'] : '';
					        $IM_SPEC_MASTER_TYPE=isset($rec['IM_SPEC_MASTER_TYPE']) ? $rec['IM_SPEC_MASTER_TYPE'] : '';
					        $IM_CAT_SPEC_PRIORITY=isset($rec['IM_CAT_SPEC_PRIORITY']) ? $rec['IM_CAT_SPEC_PRIORITY'] : '';
					        $IM_CAT_SPEC_STATUS=isset($rec['IM_CAT_SPEC_STATUS']) ? $rec['IM_CAT_SPEC_STATUS'] : '';
					        
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_MASTER_ID'] = $rec['IM_SPEC_MASTER_ID'];
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_MASTER_DESC'] = $IM_SPEC_MASTER_DESC;
						if($IM_SPEC_MASTER_TYPE == 1){
						        if($IM_SPEC_OPTIONS_DESC != '')
						        {
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_DESC'] = $IM_SPEC_OPTIONS_DESC;
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_ID'] = $rec['IM_SPEC_OPTIONS_ID'];
							
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_STATUS'] = $rec['IM_SPEC_OPTIONS_STATUS'];
							}
							
							
						} else if($IM_SPEC_MASTER_TYPE == 2 || $IM_SPEC_MASTER_TYPE == 3 || $IM_SPEC_MASTER_TYPE == 4){
						if($IM_SPEC_OPTIONS_DESC != ''){
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_DESC'][$rec['IM_SPEC_OPTIONS_ID']] = $IM_SPEC_OPTIONS_DESC;
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_ID'][$rec['IM_SPEC_OPTIONS_ID']] = $rec['IM_SPEC_OPTIONS_ID'];
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_STATUS'][$rec['IM_SPEC_OPTIONS_ID']] = $rec['IM_SPEC_OPTIONS_STATUS'];
							}
						}
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_MASTER_TYPE'] = $IM_SPEC_MASTER_TYPE;
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_CAT_SPEC_PRIORITY'] = $IM_CAT_SPEC_PRIORITY;
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_CAT_SPEC_STATUS'] = $IM_CAT_SPEC_STATUS;
						
						
					}
					
			}
			
		}
		
		$resultArr = array('errMsg'=>$errMsg,'quesArr' => $quesArr);
		
		return $resultArr;
		
  }
  
  public function showmcat($dbh)
  {
    
    $sql = "select Distinct GLCAT_MCAT.GLCAT_MCAT_NAME GL_MODULE_ID,GLCAT_MCAT_ID 
from IM_CAT_SPECIFICATION,GLCAT_MCAT 
where 
GLCAT_MCAT.GLCAT_MCAT_ID=im_cat_spec_category_id 
and  IM_CAT_SPEC_CATEGORY_TYPE=3
 ORDER BY GLCAT_MCAT_NAME";
 $sth= pg_query($dbh,$sql);
    return $sth;
		
  }
  
  public function Save_ISQ_PG($dbh,$resultArr,$mcat_id)
  {
    $etomodel =  new AdminEtoModelForm(); 
    $dbh_imbl= $etomodel->connectImblDb();
    
    $errMsg = $resultArr['errMsg'];
    $quesArr = $resultArr['quesArr'];
    $array1=array();
    $array2=array();
    $array3=array();
    $errormessage='';
    $j=1;
    if(!empty($quesArr)){
            foreach($quesArr as $quesKey => $quesValue){
                    if($quesValue['IM_CAT_SPEC_STATUS'] <> 2){
                    $imSpecMasterId = $quesValue['IM_SPEC_MASTER_ID'];
                    $imSpecMasterType = $quesValue['IM_SPEC_MASTER_TYPE'];
		    $imSpecMasterDesc = $quesValue['IM_SPEC_MASTER_DESC'];
                    $sql="BEGIN
			  update IM_SPECIFICATION_MASTER set IM_SPEC_MASTER_DESC=:IM_SPEC_MASTER_DESC,MASTER_MOD_DATE=sysdate where IM_SPEC_MASTER_ID=:IM_SPEC_MASTER_ID;
			  update IM_CAT_SPECIFICATION set IM_CAT_SPEC_PRIORITY=:IM_CAT_SPEC_PRIORITY,IM_CAT_SPEC_STATUS=:IM_CAT_SPEC_STATUS,SPECIFICATION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID and IM_CAT_SPEC_CATEGORY_ID=:IM_CAT_SPEC_CATEGORY_ID;
			END;";
		    $sth=oci_parse($dbh_imbl,$sql);
		    oci_bind_by_name($sth,':IM_SPEC_MASTER_DESC',$_REQUEST["quesdesc$j"]);
		    oci_bind_by_name($sth,':IM_SPEC_MASTER_ID',$imSpecMasterId);
		    oci_bind_by_name($sth,':IM_CAT_SPEC_PRIORITY',$_REQUEST["quesprior$j"]);
		    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
		    oci_bind_by_name($sth,':IM_CAT_SPEC_STATUS',$_REQUEST["quesstatus$j"]);
		    oci_bind_by_name($sth,':IM_CAT_SPEC_CATEGORY_ID',$mcat_id);
		    
		    $ex=@oci_execute($sth);
		    if(!$ex)		    
		    {
		    $errormessage .="Updation failed of Description,Priorty and Staus of question:$j\n";
		    }else{
                         $sql="update IM_SPECIFICATION_MASTER set IM_SPEC_MASTER_DESC=$1,MASTER_MOD_DATE=sysdate where IM_SPEC_MASTER_ID=$2;";
                            $params=array($_REQUEST["quesdesc$j"],$imSpecMasterId);
                            $sth=  pg_query_params($dbh,$sql,$params);
                            if(!$sth)		    
                            {   
                                $errormessage .="Updation failed of Priorty and Staus of question:$j\n";
                            }else{
                                $sql="update IM_CAT_SPECIFICATION set IM_CAT_SPEC_PRIORITY=$2,IM_CAT_SPEC_STATUS=$3,SPECIFICATION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$1 and IM_CAT_SPEC_CATEGORY_ID=$4;";
                                          $params=array($imSpecMasterId,$_REQUEST["quesprior$j"],$_REQUEST["quesstatus$j"],$mcat_id);
                                          $sth=  pg_query_params($dbh,$sql,$params);
                                          if(!$sth)		    
                                            {   
                                                $errormessage .="Updation failed of Priorty and Staus of question:$j\n";
                                            }
                            }
                    }
		   
                    if($_REQUEST["questype$j"] == 'Text'){
                        $index=0;
                         $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_STATUS=1,IM_SPEC_OPTIONS_DESC=:IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID";
                        
                        $sth=oci_parse($dbh_imbl,$sql);
                    
		        oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$_REQUEST["ques1$j"]);
		       $ex= @oci_execute($sth);
			if(!$ex)		    
			{
			$errormessage .="Updation failed of Options1 of question:$j\n";
			}else{
                             $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_STATUS=1,IM_SPEC_OPTIONS_DESC=$2,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$1";
                                $params=array($imSpecMasterId,$_REQUEST["ques1$j"]);
                                $sth=pg_query_params($dbh,$sql,$params);
                                if(!$sth)	    
                                {
                                $errormessage .="Updation failed of Options1 of question:$j\n";
                                }
                        }
                       
                   }
          if($_REQUEST["questype$j"] == 'Radio'){
                    $k=1;
                    $index=0;
                     $size=isset($quesValue['IM_SPEC_OPTIONS_ID']) ? sizeof($quesValue['IM_SPEC_OPTIONS_ID']) : 0;
                     if(!empty($quesValue['IM_SPEC_OPTIONS_ID']))
                       {  
                            
                      ksort($quesValue['IM_SPEC_OPTIONS_ID']);
                          
                             
                           foreach($quesValue['IM_SPEC_OPTIONS_ID'] as $optionKey => $optionValue){
                           
                              $desc1=isset($_REQUEST["ques$k$j"]) ? $_REQUEST["ques$k$j"] :'';
                               if($desc1 == "")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                        
                        $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=:IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS=:IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID and IM_SPEC_OPTIONS_ID=:IM_SPEC_OPTIONS_ID";
                        
                        $sth=oci_parse($dbh_imbl,$sql);
                        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
		        oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$optionValue);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
		         $ex= @oci_execute($sth);
			if(!$ex)		    
			{
                            $errormessage .="Updation failed of Option$k of question:$j\n";
			}else{
                            $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=$1,IM_SPEC_OPTIONS_STATUS=$4,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$ and IM_SPEC_OPTIONS_ID=$3";
                            $params=array($desc1,$imSpecMasterId,$optionValue,$IM_SPEC_OPTIONS_STATUS);
                            $sth=pg_query_params($dbh,$sql,$params);
                            if(!$sth)		    
                            {
                            $errormessage .="Updation failed of Option$k of question:$j\n";
                            }
                        }
		        $k=$k+1;
		      
                           }
                           }
                        for($z=$size+1;$z<=6;$z++)
                           {
                            $desc1=isset($_REQUEST["ques$z$j"]) ? $_REQUEST["ques$z$j"] :'';
                            if($desc1 == "")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                         $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values (:IM_SPEC_OPTIONS_DESC,sysdate,:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_STATUS) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
                        
			    $sth=oci_parse($dbh_imbl,$sql);
                            oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
			    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
			    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
			     oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
			      $ex= @oci_execute($sth);
				if(!$ex)		    
				{
				$errormessage .="Insertion failed of new Option$z of question:$j\n";
				}else{
                                     $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_ID,IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values ($4,$1,sysdate,$2,$3)";
                                     $params=array($desc1,$imSpecMasterId,$IM_SPEC_OPTIONS_STATUS,$IM_SPEC_OPTIONS_ID);
                                     $sth=pg_query_params($dbh,$sql,$params);
                                    if(!$sth){
                                            $errormessage .="Insertion failed of new Option$z of question:$j\n";
                                    }
                                }
                              
                       
                           } 
                          
                   }
           if($_REQUEST["questype$j"] == 'Dropdown' ){
                           
                          
                           $k=1;
                            $size=isset($quesValue['IM_SPEC_OPTIONS_ID']) ? sizeof($quesValue['IM_SPEC_OPTIONS_ID']) : 0;
                            if(!empty($quesValue['IM_SPEC_OPTIONS_ID']))
                            {
                           ksort($quesValue['IM_SPEC_OPTIONS_ID']);
                           foreach($quesValue['IM_SPEC_OPTIONS_ID'] as $optionKey => $optionValue) {
                           
                           $desc1=isset($_REQUEST["ques$k$j"]) ?  $_REQUEST["ques$k$j"] :'';
                           
                           if($desc1 == "")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                           
              $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=:IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS=:IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID and IM_SPEC_OPTIONS_ID=:IM_SPEC_OPTIONS_ID";
                        
	    $sth=oci_parse($dbh_imbl,$sql);
	    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
	    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
	    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$optionValue);
	     oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
	      $ex= @oci_execute($sth);
			if(!$ex)		    
			{
			$errormessage .="Updation failed of Option$k of question:$j\n";
			}else{
                            $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=$1,IM_SPEC_OPTIONS_STATUS=$4,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$2 and IM_SPEC_OPTIONS_ID=$3";
                            $params=array($desc1,$imSpecMasterId,$optionValue,$IM_SPEC_OPTIONS_STATUS);
                            $sth=pg_query_params($dbh,$sql,$params);
                            if(!$sth)	    		    
                            {
                            $errormessage .="Updation failed of Option$k of question:$j\n";
                            }
                        }
            
	    $k=$k+1;
	  
		        
                           }
                           }
            for($z=$size+1;$z<=6;$z++)
                           {
                            $desc1=isset($_REQUEST["ques$z$j"]) ? $_REQUEST["ques$z$j"] : '';
                           if($desc1 =="")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                            $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values (:IM_SPEC_OPTIONS_DESC,sysdate,:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_STATUS) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
                        
			    $sth=oci_parse($dbh_imbl,$sql);
                            oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
			    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
			    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
			    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
			     $ex= @oci_execute($sth);
			      if(!$ex)		    
			      {
                                $errormessage .="Insertion failed of new Option$z of question:$j\n";
			      }else{
                                $sql="insert into IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_ID,IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values ($4,$1,sysdate,$2,$3)";
                                $params=array($desc1,$imSpecMasterId,$IM_SPEC_OPTIONS_STATUS,$IM_SPEC_OPTIONS_ID);
                                $sth=pg_query_params($dbh,$sql,$params);
                                if(!$sth)	
                                  {
                                  $errormessage .="Insertion failed of new Option$z of question:$j\n";
                                  }
                              }   
                            
                           }               
                           
                  }
 if($_REQUEST["questype$j"] == 'Multiple Select'){
 $k=1;


  $size=isset($quesValue['IM_SPEC_OPTIONS_ID']) ? sizeof($quesValue['IM_SPEC_OPTIONS_ID']) : 0;
   if(!empty($quesValue['IM_SPEC_OPTIONS_ID']))
                            {
 
                         ksort($quesValue['IM_SPEC_OPTIONS_ID']);
                         foreach($quesValue['IM_SPEC_OPTIONS_ID'] as $optionKey => $optionValue) {
                         $desc1 =isset($_REQUEST["ques$k$j"]) ? $_REQUEST["ques$k$j"] :'';
                          if($desc1 == "")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                       $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=:IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS=:IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID and IM_SPEC_OPTIONS_ID=:IM_SPEC_OPTIONS_ID";
                        
                        $sth=oci_parse($dbh_imbl,$sql);
                        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
		        oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$optionValue);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
		          $ex= @oci_execute($sth);
			    if(!$ex)		    
			    {
                                $errormessage .="Updation failed of Option$k of question:$j\n";
			    }else{
                                 $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=$1,IM_SPEC_OPTIONS_STATUS=$4,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$2 and IM_SPEC_OPTIONS_ID=$3";
                                $params=array($desc1,$imSpecMasterId,$optionValue,$IM_SPEC_OPTIONS_STATUS);
                                $sth=pg_query_params($dbh,$sql,$params);
                                if(!$sth)		    
                                {
                                $errormessage .="Updation failed of Option$k of question:$j\n";
                                }
                            }                         
		        $k=$k+1;
                         }
                         }
                          for($z=$size+1;$z<=6;$z++)
                           {
                           $desc1=isset($_REQUEST["ques$z$j"]) ? $_REQUEST["ques$z$j"] :'';
                             if($desc1 =="")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                            
                            $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values (:IM_SPEC_OPTIONS_DESC,sysdate,:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_STATUS) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
                        
			    $sth=oci_parse($dbh_imbl,$sql);
                            
                            oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
			    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
			    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
			     oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
			      $ex= @oci_execute($sth);
			      if(!$ex)		    
			      {
                                $errormessage .="Insertion failed of Option$z of question:$j\n";
			      }else{
                                  $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_ID,IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values ($4,$1,sysdate,$2,$3)";
                                    $params=array($desc1,$imSpecMasterId,$IM_SPEC_OPTIONS_STATUS,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql,$params);
                                    if(!$sth)		    
                                    {
                                      $errormessage .="Insertion failed of Option$z of question:$j\n";
                                    }
                              }   
                            
                           } 
                         }
                  
                    }
		    $j=$j+1;
		    
		    }
		  }


  return $errormessage;
  }
  
 public function Save_ISQ_NEW($dbh,$mcat_id,$quesdsec,$questype,$quesprior,$quesstatus,$opt1,$opt2,$opt3,$opt4,$opt5,$opt6)
  {
    $etomodel =  new AdminEtoModelForm(); 
    $dbh_imbl= $etomodel->connectImblDb();
    
   $cattype=3;
   $quesstatus=1;
   $errormessage='';
  
  $sql1="insert into IM_SPECIFICATION_MASTER (IM_SPEC_MASTER_DESC,IM_SPEC_MASTER_TYPE,MASTER_MOD_DATE) values (:IM_SPEC_MASTER_DESC,:IM_SPEC_MASTER_TYPE,sysdate) RETURNING IM_SPEC_MASTER_ID INTO :IM_SPEC_MASTER_ID";
  $sth1=oci_parse($dbh_imbl,$sql1);
  oci_bind_by_name($sth1,':IM_SPEC_MASTER_ID',$masterid1,10);
  oci_bind_by_name($sth1,':IM_SPEC_MASTER_DESC',$quesdsec);
  oci_bind_by_name($sth1,':IM_SPEC_MASTER_TYPE',$questype);
  $ex= @oci_execute($sth1);
			      if(!$ex)		    
			      {
			      $errormessage .="Insertion failed query:$sql1 ,values :IM_SPEC_MASTER_ID=$masterid1,:IM_SPEC_MASTER_DESC=$quesdsec,:IM_SPEC_MASTER_TYPE=$questype <br>";
			      }else{
                                   $sql1="insert into IM_SPECIFICATION_MASTER (IM_SPEC_MASTER_ID,IM_SPEC_MASTER_DESC,IM_SPEC_MASTER_TYPE,MASTER_MOD_DATE) values ($1,$2,$3,sysdate) ";
                                   $params=array($masterid1,$quesdsec,$questype);
                                    $sth=pg_query_params($dbh,$sql1,$params);
                                    if(!$sth)		    
                                    {
                                      $errormessage .="Insertion failed query:$sql1 ,values :IM_SPEC_MASTER_ID=$masterid1,:IM_SPEC_MASTER_DESC=$quesdsec,:IM_SPEC_MASTER_TYPE=$questype <br>";
                                    }
                              }
  
 
  
  $sql2="insert into IM_CAT_SPECIFICATION (FK_IM_SPEC_MASTER_ID,IM_CAT_SPEC_CATEGORY_ID,IM_CAT_SPEC_PRIORITY,IM_CAT_SPEC_STATUS,IM_CAT_SPEC_CATEGORY_TYPE,SPECIFICATION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_CAT_SPEC_CATEGORY_ID,:IM_CAT_SPEC_PRIORITY,:IM_CAT_SPEC_STATUS,:IM_CAT_SPEC_CATEGORY_TYPE,sysdate)  RETURNING IM_CAT_SPEC_ID INTO :IM_CAT_SPEC_ID ";
  $sth2=oci_parse($dbh_imbl,$sql2);
  
  oci_bind_by_name($sth2,':IM_CAT_SPEC_ID',$IM_CAT_SPEC_ID,10);
  oci_bind_by_name($sth2,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth2,':IM_CAT_SPEC_CATEGORY_ID',$mcat_id);
  oci_bind_by_name($sth2,':IM_CAT_SPEC_PRIORITY',$quesprior);
  oci_bind_by_name($sth2,':IM_CAT_SPEC_STATUS',$quesstatus);
  oci_bind_by_name($sth2,':IM_CAT_SPEC_CATEGORY_TYPE',$cattype);
  $ex=@oci_execute($sth2);
  
  if(!$ex)		    
			      {
			      $errormessage .="Insertion failed query:$sql2 ,values :FK_IM_SPEC_MASTER_ID=$masterid1,:IM_CAT_SPEC_CATEGORY_ID=$mcat_id,:IM_CAT_SPEC_PRIORITY=$quesprior,:IM_CAT_SPEC_STATUS=$quesstatus,:IM_CAT_SPEC_CATEGORY_TYPE=$cattype \n";
			      }else{
                                   $sql2="insert into IM_CAT_SPECIFICATION (IM_CAT_SPEC_ID,FK_IM_SPEC_MASTER_ID,IM_CAT_SPEC_CATEGORY_ID,IM_CAT_SPEC_PRIORITY,IM_CAT_SPEC_STATUS,IM_CAT_SPEC_CATEGORY_TYPE,SPECIFICATION_MOD_DATE) values ($6,$1,$2,$3,$4,$5,sysdate)";
                                    $params=array($masterid1,$mcat_id,$quesprior,$quesstatus,$cattype,$IM_CAT_SPEC_ID);
                                    $sth=pg_query_params($dbh,$sql2,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed query:$sql2 ,values :FK_IM_SPEC_MASTER_ID=$masterid1,:IM_CAT_SPEC_CATEGORY_ID=$mcat_id,:IM_CAT_SPEC_PRIORITY=$quesprior,:IM_CAT_SPEC_STATUS=$quesstatus,:IM_CAT_SPEC_CATEGORY_TYPE=$cattype \n";
                                     }
                              }
  $optstatus=1;
  
  if($questype ==1)
  {
  
  $sql3_1="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_1);
  
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
 $ex= @oci_execute($sth3);
  
  if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option1 of New question \n";
			      }else{
                                   $sql3_1="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt1,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_1,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option1 of New question \n";                                     
                                    }
                              }
  
}
 else
 {
 if($opt1 != "")
 {
 
 $sql3_1="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate)  RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
 $ex= @oci_execute($sth3);  
  if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option1 of New question \n";
			      }else{
                                     $sql3_1="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                    $params=array($masterid1,$opt1,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_1,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option1 of New question \n";                                     
                                    }
                              }
  }
if($opt2 != "")
{
  
  $sql3_2="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_2);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt2);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=@oci_execute($sth3);
   if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option2 of New question \n";
			      }else{
                                    $sql3_2="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt2,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_2,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option2 of New question \n";                                     
                                    }
                              }
  
 }
 if($opt3 != "")
 {
 
  $sql3_3="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_3);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt3);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=@oci_execute($sth3);
  
   if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option3 of New question \n";
			      }else{
                                    $sql3_3="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt3,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_3,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option3 of New question \n";                                     
                                    }
                              }
  
  }
  if($opt4 != "")
  {
  
  $sql3_4="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_4);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt4);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=@oci_execute($sth3);
  
  
   if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option4 of New question \n";
			      }else{
                                    $sql3_4="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt4,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_4,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option4 of New question \n";                                     
                                    }
                              }
  
  }
 if($opt5 != "")
 {
  
  $sql3_5="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_5);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt5);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=@oci_execute($sth3);
  
   if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option5 of New question \n";
			      }else{
                                    $sql3_5="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt5,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_5,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option5 of New question \n";                                     
                                    }
                              }
  }
  if($opt6 != "")
  {
  
  $sql3_6="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_6);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt6);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=@oci_execute($sth3);
  
   if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option6 of New question \n";
			      }else{
                                    $sql3_6="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt6,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_6,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option6 of New question \n";                                     
                                    }
                              }
			      
}			      
  
  
  }
  
  
  if($errormessage)
  {
  echo "Error:$errormessage";
  }
  else{
  echo "Question Successfuly Added";
  }
  }
  
  
  public function MCAT_LIST($dbh,$SearchText)
  {
  $SearchText=strtolower($SearchText);
  $html='';
    $sql="SELECT GLCAT_MCAT_NAME,GLCAT_MCAT_ID FROM GLCAT_MCAT WHERE LOWER(GLCAT_MCAT_NAME) LIKE '%$SearchText%' AND GLCAT_MCAT_DELETE_STATUS <> 1 ORDER BY GLCAT_MCAT_NAME";
    $sth_mcat=pg_query($dbh,$sql);   
   
        	
	while ( $rec = pg_fetch_array($sth_mcat)) {
            $rec=array_change_key_case($rec, CASE_UPPER);  
                $html.= ' <option value="'.$rec['GLCAT_MCAT_ID'].'">'.$rec['GLCAT_MCAT_NAME'].'</option>';
	}
        
        if($html!=''){
            $html= '<table><tr><td><select name="mcat" id="mcat" style="width:200px;">'.$html;
            $html.= '</select></td>
	<td><input type="submit" name="searchsubmit" value="Show Detail"></td></tr></table>';
        }else{
	 $html= '<font size="2px" face="arial" color="red">No Mcat Found</font>';
	}echo $html;
  }
  
  
  public function GET_MCAT_NAME($dbh,$mcat_id)
  {
    $sql="SELECT GLCAT_MCAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=$mcat_id";
    $sth_mcat=pg_query($dbh,$sql);   
    $rec=pg_fetch_array($sth_mcat);    
    $mcatName=isset($rec['glcat_mcat_name']) ? $rec['glcat_mcat_name'] : '';   
   return $mcatName;
	
  }
  
public function show_isq_question_cat($dbh,$mcat_id)
{
$sql="select FK_GLCAT_CAT_ID from GLCAT_CAT_TO_MCAT WHERE FK_GLCAT_MCAT_ID=$mcat_id";
$sth_cat = pg_query($dbh,$sql);				
$rec = pg_fetch_array($sth_cat);
                                
$categoryId=isset($rec['fk_glcat_cat_id']) ? $rec['fk_glcat_cat_id'] : '';



$type =2;
		$errMsg = '';
		$quesArr = array();
		$buyerRespArr = array();
		if(empty($categoryId)){
			$errMsg = "CAT ID Empty";
		} else {

                        
                       
			if($dbh) {
				$questionChecksql = "SELECT COUNT(1) CNT FROM IM_CAT_SPECIFICATION WHERE IM_CAT_SPEC_CATEGORY_ID = $categoryId AND IM_CAT_SPEC_CATEGORY_TYPE =$type";
				$questionCheckSth = pg_query($dbh,$questionChecksql);				
				$quesExistsCnt = pg_fetch_array($questionCheckSth);
				$quesExistsCnt=$quesExistsCnt['cnt'];
				
				
					$quesDetailsSql = "	SELECT 
								A.IM_SPEC_MASTER_ID,A.IM_SPEC_MASTER_DESC,A.IM_SPEC_MASTER_TYPE,
								B.IM_CAT_SPEC_CATEGORY_ID,B.IM_CAT_SPEC_PRIORITY,B.IM_CAT_SPEC_STATUS,C.IM_SPEC_OPTIONS_STATUS,
								C.IM_SPEC_OPTIONS_DESC,
								C.IM_SPEC_OPTIONS_ID,
								ROW_NUMBER() OVER (ORDER BY 1) RN
								FROM IM_SPECIFICATION_MASTER A 
								JOIN IM_CAT_SPECIFICATION B ON A.IM_SPEC_MASTER_ID = B.FK_IM_SPEC_MASTER_ID
								JOIN IM_SPECIFICATION_OPTIONS C ON A.IM_SPEC_MASTER_ID = C.FK_IM_SPEC_MASTER_ID
								WHERE 
								B.IM_CAT_SPEC_CATEGORY_ID = $categoryId  
								AND B.IM_CAT_SPEC_CATEGORY_TYPE = $type
								--AND B.IM_CAT_SPEC_STATUS = 1								
								ORDER BY B.IM_CAT_SPEC_STATUS,B.IM_CAT_SPEC_PRIORITY
								";
                                        $quesDetailssth= pg_query($dbh,$quesDetailsSql);					                                                
					while($rec = pg_fetch_array($quesDetailssth)) {
					        $rec=array_change_key_case($rec, CASE_UPPER);  
					        $IM_SPEC_OPTIONS_DESC=isset($rec['IM_SPEC_OPTIONS_DESC']) ? $rec['IM_SPEC_OPTIONS_DESC'] : '';
					        $IM_SPEC_MASTER_DESC=isset($rec['IM_SPEC_MASTER_DESC']) ? $rec['IM_SPEC_MASTER_DESC'] : '';
					        $IM_SPEC_MASTER_TYPE=isset($rec['IM_SPEC_MASTER_TYPE']) ? $rec['IM_SPEC_MASTER_TYPE'] : '';
					        $IM_CAT_SPEC_PRIORITY=isset($rec['IM_CAT_SPEC_PRIORITY']) ? $rec['IM_CAT_SPEC_PRIORITY'] : '';
					        $IM_CAT_SPEC_STATUS=isset($rec['IM_CAT_SPEC_STATUS']) ? $rec['IM_CAT_SPEC_STATUS'] : '';
					        
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_MASTER_ID'] = $rec['IM_SPEC_MASTER_ID'];
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_MASTER_DESC'] = $IM_SPEC_MASTER_DESC;
						if($IM_SPEC_MASTER_TYPE == 1){
						        if($IM_SPEC_OPTIONS_DESC != '')
						        {
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_DESC'] = $IM_SPEC_OPTIONS_DESC;
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_ID'] = $rec['IM_SPEC_OPTIONS_ID'];
							
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_STATUS'] = $rec['IM_SPEC_OPTIONS_STATUS'];
							}
							
							
						} else if($IM_SPEC_MASTER_TYPE == 2 || $IM_SPEC_MASTER_TYPE == 3 || $IM_SPEC_MASTER_TYPE == 4){
						if($IM_SPEC_OPTIONS_DESC != ''){
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_DESC'][$rec['IM_SPEC_OPTIONS_ID']] = $IM_SPEC_OPTIONS_DESC;
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_ID'][$rec['IM_SPEC_OPTIONS_ID']] = $rec['IM_SPEC_OPTIONS_ID'];
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_STATUS'][$rec['IM_SPEC_OPTIONS_ID']] = $rec['IM_SPEC_OPTIONS_STATUS'];
							}
						}
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_MASTER_TYPE'] = $IM_SPEC_MASTER_TYPE;
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_CAT_SPEC_PRIORITY'] = $IM_CAT_SPEC_PRIORITY;
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_CAT_SPEC_STATUS'] = $IM_CAT_SPEC_STATUS;
						
						
					}
					
			}
			
		}
		
		$resultArr = array('errMsg'=>$errMsg,'quesArr' => $quesArr);
		
		return $resultArr;


}




// Subcat level ISQ Add/Edit

 public function show_isq_question_subcat($dbh_imbl,$cat_id)
  {
 
		$type = 2;
		$errMsg = '';$quesArr = array();$buyerRespArr = array();
		if(empty($cat_id)){
			$errMsg = "SUBCAT ID Empty";
		} else {                     
			if($dbh_imbl) {
				$questionChecksql = "SELECT COUNT(1) CNT FROM IM_CAT_SPECIFICATION WHERE IM_CAT_SPEC_CATEGORY_ID = $cat_id AND IM_CAT_SPEC_CATEGORY_TYPE =$type";
				
		               
				$questionCheckSth = pg_query($dbh_imbl,$questionChecksql);				
				$quesExistsCnt = pg_fetch_array($questionCheckSth);
				$quesExistsCnt=$quesExistsCnt['cnt'];				
				
					$quesDetailsSql = "	SELECT 
								A.IM_SPEC_MASTER_ID,A.IM_SPEC_MASTER_DESC,A.IM_SPEC_MASTER_TYPE,
								B.IM_CAT_SPEC_CATEGORY_ID,B.IM_CAT_SPEC_PRIORITY,B.IM_CAT_SPEC_STATUS,C.IM_SPEC_OPTIONS_STATUS,
								C.IM_SPEC_OPTIONS_DESC,
								C.IM_SPEC_OPTIONS_ID,
								ROW_NUMBER() OVER (ORDER BY 1) RN
								FROM IM_SPECIFICATION_MASTER A 
								JOIN IM_CAT_SPECIFICATION B ON A.IM_SPEC_MASTER_ID = B.FK_IM_SPEC_MASTER_ID
								JOIN IM_SPECIFICATION_OPTIONS C ON A.IM_SPEC_MASTER_ID = C.FK_IM_SPEC_MASTER_ID
								WHERE 
								B.IM_CAT_SPEC_CATEGORY_ID = $cat_id 
								AND B.IM_CAT_SPEC_CATEGORY_TYPE = $type
								--AND B.IM_CAT_SPEC_STATUS = 1								
								ORDER BY B.IM_CAT_SPEC_STATUS,B.IM_CAT_SPEC_PRIORITY
								";
								
					        
					$quesDetailssth= pg_query($dbh_imbl,$quesDetailsSql);					
					while($rec = pg_fetch_array($quesDetailssth)) {
					        $rec=array_change_key_case($rec, CASE_UPPER);  
					        $IM_SPEC_OPTIONS_DESC=isset($rec['IM_SPEC_OPTIONS_DESC']) ? $rec['IM_SPEC_OPTIONS_DESC'] : '';
					        $IM_SPEC_MASTER_DESC=isset($rec['IM_SPEC_MASTER_DESC']) ? $rec['IM_SPEC_MASTER_DESC'] : '';
					        $IM_SPEC_MASTER_TYPE=isset($rec['IM_SPEC_MASTER_TYPE']) ? $rec['IM_SPEC_MASTER_TYPE'] : '';
					        $IM_CAT_SPEC_PRIORITY=isset($rec['IM_CAT_SPEC_PRIORITY']) ? $rec['IM_CAT_SPEC_PRIORITY'] : '';
					        $IM_CAT_SPEC_STATUS=isset($rec['IM_CAT_SPEC_STATUS']) ? $rec['IM_CAT_SPEC_STATUS'] : '';
					        
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_MASTER_ID'] = $rec['IM_SPEC_MASTER_ID'];
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_MASTER_DESC'] = $IM_SPEC_MASTER_DESC;
						if($IM_SPEC_MASTER_TYPE == 1){
						        if($IM_SPEC_OPTIONS_DESC != '')
						        {
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_DESC'] = $IM_SPEC_OPTIONS_DESC;
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_ID'] = $rec['IM_SPEC_OPTIONS_ID'];
							
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_STATUS'] = $rec['IM_SPEC_OPTIONS_STATUS'];
							}
							
							
						} else if($IM_SPEC_MASTER_TYPE == 2 || $IM_SPEC_MASTER_TYPE == 3 || $IM_SPEC_MASTER_TYPE == 4){
						if($IM_SPEC_OPTIONS_DESC != ''){
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_DESC'][$rec['IM_SPEC_OPTIONS_ID']] = $IM_SPEC_OPTIONS_DESC;
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_ID'][$rec['IM_SPEC_OPTIONS_ID']] = $rec['IM_SPEC_OPTIONS_ID'];
							$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_OPTIONS_STATUS'][$rec['IM_SPEC_OPTIONS_ID']] = $rec['IM_SPEC_OPTIONS_STATUS'];
							}
						}
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_SPEC_MASTER_TYPE'] = $IM_SPEC_MASTER_TYPE;
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_CAT_SPEC_PRIORITY'] = $IM_CAT_SPEC_PRIORITY;
						$quesArr[$rec['IM_SPEC_MASTER_ID']]['IM_CAT_SPEC_STATUS'] = $IM_CAT_SPEC_STATUS;
						
						
					}
					
			}
			
		}		
		$resultArr = array('errMsg'=>$errMsg,'quesArr' => $quesArr);		
		return $resultArr;	
  }
  
  public function showcat($dbh)
  {
    
    $sql = "select Distinct GLCAT_CAT.GLCAT_CAT_NAME GL_MODULE_ID,GLCAT_CAT_ID from GLCAT_CAT ORDER BY GLCAT_CAT_NAME";
    $sth = pg_query($dbh,$sql);
    return $sth;
		
  }
  
 
  
    public function Save_ISQ_SUBCAT($dbh,$resultArr,$cat_id)
  {
    $errMsg = $resultArr['errMsg'];
    $quesArr = $resultArr['quesArr'];
    $array1=array();
    $array2=array();
    $array3=array();
    $errormessage='';
    $j=1;
    $etomodel =  new AdminEtoModelForm(); 
    $dbh_imbl= $etomodel->connectImblDb();
    
    if(!empty($quesArr)){
            foreach($quesArr as $quesKey => $quesValue){
                if($quesValue['IM_CAT_SPEC_STATUS'] <> 2){
                    $imSpecMasterId = $quesValue['IM_SPEC_MASTER_ID'];
                    $imSpecMasterType = $quesValue['IM_SPEC_MASTER_TYPE'];
		    $imSpecMasterDesc = $quesValue['IM_SPEC_MASTER_DESC'];

                    $sql="BEGIN
			  update IM_SPECIFICATION_MASTER set IM_SPEC_MASTER_DESC=:IM_SPEC_MASTER_DESC,MASTER_MOD_DATE=sysdate where IM_SPEC_MASTER_ID=:IM_SPEC_MASTER_ID;
			  update IM_CAT_SPECIFICATION set IM_CAT_SPEC_PRIORITY=:IM_CAT_SPEC_PRIORITY,IM_CAT_SPEC_STATUS=:IM_CAT_SPEC_STATUS,SPECIFICATION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID and IM_CAT_SPEC_CATEGORY_ID=:IM_CAT_SPEC_CATEGORY_ID;
			END;";
		    $sth=oci_parse($dbh_imbl,$sql);
		    oci_bind_by_name($sth,':IM_SPEC_MASTER_DESC',$_REQUEST["quesdesc$j"]);
		    oci_bind_by_name($sth,':IM_SPEC_MASTER_ID',$imSpecMasterId);
		    oci_bind_by_name($sth,':IM_CAT_SPEC_PRIORITY',$_REQUEST["quesprior$j"]);
		    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
		    oci_bind_by_name($sth,':IM_CAT_SPEC_STATUS',$_REQUEST["quesstatus$j"]);
		    oci_bind_by_name($sth,':IM_CAT_SPEC_CATEGORY_ID',$cat_id);
		    
		    $ex=@oci_execute($sth);
		    if(!$ex)		    
		    {
                        $errormessage .="Updation failed of Description,Priorty and Staus of question:$j\n";
                    }else{
                        $sql="update IM_SPECIFICATION_MASTER set IM_SPEC_MASTER_DESC=$1,MASTER_MOD_DATE=sysdate where IM_SPEC_MASTER_ID=$2;";
                        $params=array($_REQUEST["quesdesc$j"],$imSpecMasterId);		    
                        $sth=  pg_query_params($dbh,$sql,$params);
                        if($sth)		    
                        {                                
                                $sql="update IM_CAT_SPECIFICATION set IM_CAT_SPEC_PRIORITY=$2,IM_CAT_SPEC_STATUS=$3,SPECIFICATION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$1 and IM_CAT_SPEC_CATEGORY_ID=$4;";
                                $params=array($imSpecMasterId,$_REQUEST["quesprior$j"],$_REQUEST["quesstatus$j"],$cat_id);		    
                                $sth=  pg_query_params($dbh,$sql,$params);
                                if(!$sth)		    
                                {
                                $errormessage .="PG=Updation failed of Priorty and Status of question:$j\n";
                                }
                        }else{
                                 $errormessage .="PG=Updation failed of Description of question:$j\n";                            
                        }	
                    }
                        if($_REQUEST["questype$j"] == 'Text'){ 
                        
                        $index=0;
                        $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_STATUS=1,IM_SPEC_OPTIONS_DESC=:IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID";
                        
                        $sth=oci_parse($dbh_imbl,$sql);
                    
		        oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$_REQUEST["ques1$j"]);
		        $ex= @oci_execute($sth);
			if(!$ex)		    
			{
                            $errormessage .="Updation failed of Options1 of question:$j\n";
			}else{
                             $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_STATUS=1,IM_SPEC_OPTIONS_DESC=$2,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$1";
                            $params=array($imSpecMasterId,$_REQUEST["ques1$j"]);
                            $sth=  pg_query_params($dbh,$sql,$params);
                            if(!$sth)		    
                            {
                            $errormessage .="PG=Updation failed of Options1 of question:$j\n";
                            }
                        }
                   }
          if($_REQUEST["questype$j"] == 'Radio'){
                    $k=1;
                    $index=0;
                     $size=isset($quesValue['IM_SPEC_OPTIONS_ID']) ? sizeof($quesValue['IM_SPEC_OPTIONS_ID']) : 0;
                     if(!empty($quesValue['IM_SPEC_OPTIONS_ID']))
                       {  
                            
                      ksort($quesValue['IM_SPEC_OPTIONS_ID']);                        
                             
                           foreach($quesValue['IM_SPEC_OPTIONS_ID'] as $optionKey => $optionValue){
                           
                              $desc1=isset($_REQUEST["ques$k$j"]) ? $_REQUEST["ques$k$j"] :'';
                               if($desc1 == "")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                        $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=:IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS=:IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID and IM_SPEC_OPTIONS_ID=:IM_SPEC_OPTIONS_ID";
                        
                        $sth=oci_parse($dbh_imbl,$sql);
                        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
		        oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$optionValue);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
		         $ex= @oci_execute($sth);
			if(!$ex)		    
			{
			$errormessage .="Updation failed of Option$k of question:$j\n";
			}else{
                            $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=$1,IM_SPEC_OPTIONS_STATUS=$4,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$2 and IM_SPEC_OPTIONS_ID=$3";
                            $params=array($desc1,$imSpecMasterId,$optionValue,$IM_SPEC_OPTIONS_STATUS);		    
                            $sth=  pg_query_params($dbh,$sql,$params);                        
                            if(!$sth)		    
                            {
                            $errormessage .="PG=Updation failed of Option$k of question:$j\n";
                            }
                        }   
                               
		        $k=$k+1;
		      
                           }
                           }
                        for($z=$size+1;$z<=6;$z++)
                           {
                            $desc1=isset($_REQUEST["ques$z$j"]) ? $_REQUEST["ques$z$j"] :'';
                            if($desc1 == "")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                            $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values (:IM_SPEC_OPTIONS_DESC,sysdate,:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_STATUS) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
                        
			    $sth=oci_parse($dbh_imbl,$sql);
                            oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
			    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
			    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
			     oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
			      $ex= @oci_execute($sth);
				if(!$ex)		    
				{
                                    $errormessage .="Insertion failed of new Option$z of question:$j\n";
				}else{
                                     $sql="insert into IM_SPECIFICATION_OPTIONS(IM_SPEC_OPTIONS_ID,IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values ($4,$1,sysdate,$2,$3)";
                                    $params=array($desc1,$imSpecMasterId,$IM_SPEC_OPTIONS_STATUS,$IM_SPEC_OPTIONS_ID);		    
                                    $sth=  pg_query_params($dbh,$sql,$params);
                                        if(!$sth)		    
                                        {
                                        $errormessage .="PG=Insertion failed of new Option$z of question:$j\n";
                                        }
                                }
                           } 
                          
                   }
           if($_REQUEST["questype$j"] == 'Dropdown' ){
                           
                          
                           $k=1;
                            $size=isset($quesValue['IM_SPEC_OPTIONS_ID']) ? sizeof($quesValue['IM_SPEC_OPTIONS_ID']) : 0;
                            if(!empty($quesValue['IM_SPEC_OPTIONS_ID']))
                            {
                           ksort($quesValue['IM_SPEC_OPTIONS_ID']);
                           foreach($quesValue['IM_SPEC_OPTIONS_ID'] as $optionKey => $optionValue) {
                           
                           $desc1=isset($_REQUEST["ques$k$j"]) ?  $_REQUEST["ques$k$j"] :'';
                           
                           if($desc1 == "")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                           
             $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=:IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS=:IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID and IM_SPEC_OPTIONS_ID=:IM_SPEC_OPTIONS_ID";
                        
	    $sth=oci_parse($dbh_imbl,$sql);
	    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
	    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
	    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$optionValue);
	     oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
	      $ex= @oci_execute($sth);
			if(!$ex)		    
			{
			$errormessage .="Updation failed of Option$k of question:$j\n";
			}else{
                            $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=$1,IM_SPEC_OPTIONS_STATUS=$4,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$2 and IM_SPEC_OPTIONS_ID=$3";
                                $params=array($desc1,$imSpecMasterId,$optionValue,$IM_SPEC_OPTIONS_STATUS);		    
                                $sth=  pg_query_params($dbh,$sql,$params); 	    
                                if(!$sth)		    
                                {
                                $errormessage .="PG=Updation failed of Option$k of question:$j\n";
                                }
                        } 
            
	    $k=$k+1;
	  
		        
                           }
                           }
            for($z=$size+1;$z<=6;$z++)
                           {
                            $desc1=isset($_REQUEST["ques$z$j"]) ? $_REQUEST["ques$z$j"] : '';
                           if($desc1 =="")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                               
                            $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values (:IM_SPEC_OPTIONS_DESC,sysdate,:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_STATUS) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
                        
			    $sth=oci_parse($dbh_imbl,$sql);                            
                            oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
			    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
			    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
			    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
			     $ex= @oci_execute($sth);
			      if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of new Option$z of question:$j\n";
			      }else{
                                  $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_ID,IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values ($4,$1,sysdate,$2,$3)";
                                $params=array($desc1,$imSpecMasterId,$IM_SPEC_OPTIONS_STATUS,$IM_SPEC_OPTIONS_ID);		    
                                $sth=  pg_query_params($dbh,$sql,$params);            
                                  if(!$sth)		    
                                     {
                                     $errormessage .="Insertion failed of new Option$z of question:$j\n";
                                     }
                              } 
                           }               
                           
                  }
 if($_REQUEST["questype$j"] == 'Multiple Select'){
 $k=1;


  $size=isset($quesValue['IM_SPEC_OPTIONS_ID']) ? sizeof($quesValue['IM_SPEC_OPTIONS_ID']) : 0;
   if(!empty($quesValue['IM_SPEC_OPTIONS_ID']))
                            {
 
                         ksort($quesValue['IM_SPEC_OPTIONS_ID']);
                         foreach($quesValue['IM_SPEC_OPTIONS_ID'] as $optionKey => $optionValue) {
                         $desc1 =isset($_REQUEST["ques$k$j"]) ? $_REQUEST["ques$k$j"] :'';
                          if($desc1 == "")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                       $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=:IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS=:IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=:FK_IM_SPEC_MASTER_ID and IM_SPEC_OPTIONS_ID=:IM_SPEC_OPTIONS_ID";
                        
                        $sth=oci_parse($dbh_imbl,$sql);
                        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
		        oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$optionValue);
		        oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
		          $ex= @oci_execute($sth);
			    if(!$ex)		    
			    {
			    $errormessage .="Updation failed of Option$k of question:$j\n";
			    }else{
                                $sql="update IM_SPECIFICATION_OPTIONS set IM_SPEC_OPTIONS_DESC=$1,IM_SPEC_OPTIONS_STATUS=$4,SPEC_OPTION_MOD_DATE=sysdate where FK_IM_SPEC_MASTER_ID=$2 and IM_SPEC_OPTIONS_ID=$3";
                                $params=array($desc1,$imSpecMasterId,$optionValue,$IM_SPEC_OPTIONS_STATUS);		    
                                $sth=  pg_query_params($dbh,$sql,$params); 	    
                                if(!$sth)		    	    
                                    {
                                    $errormessage .="PG=Updation failed of Option$k of question:$j\n";
                                    }
                            }
                            
                          
		        $k=$k+1;
		       

                         }
                         }
                          for($z=$size+1;$z<=6;$z++)
                           {
                           $desc1=isset($_REQUEST["ques$z$j"]) ? $_REQUEST["ques$z$j"] :'';
                             if($desc1 =="")
                               {
                               $IM_SPEC_OPTIONS_STATUS=2;
                               }
                               else
                               {
                               $IM_SPEC_OPTIONS_STATUS=1;
                               }
                               $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values (:IM_SPEC_OPTIONS_DESC,sysdate,:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_STATUS) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
                        
			    $sth=oci_parse($dbh_imbl,$sql);
                            
                            oci_bind_by_name($sth,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
			    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_DESC',$desc1);
			    oci_bind_by_name($sth,':FK_IM_SPEC_MASTER_ID',$imSpecMasterId);
			    oci_bind_by_name($sth,':IM_SPEC_OPTIONS_STATUS',$IM_SPEC_OPTIONS_STATUS);
			      $ex= @oci_execute($sth);
			      if(!$ex)		    
			      {
                                $errormessage .="Insertion failed of Option$z of question:$j\n";
			      }else{
                                  $sql="insert into  IM_SPECIFICATION_OPTIONS  (IM_SPEC_OPTIONS_ID,IM_SPEC_OPTIONS_DESC,SPEC_OPTION_MOD_DATE,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_STATUS) values ($4,$1,sysdate,$2,$3)";
                                    $params=array($desc1,$imSpecMasterId,$IM_SPEC_OPTIONS_STATUS,$IM_SPEC_OPTIONS_ID);		    
                                    $sth=  pg_query_params($dbh,$sql,$params);            
                                      if(!$sth)
                                         {
                                         $errormessage .="Insertion failed of Option$z of question:$j\n";
                                         }
                              }
                               
                           } 
                         }
                  
                        }
		    $j=$j+1;
		    
		    }
		  }


  return $errormessage;
  }
  
 public function Save_ISQ_NEW_SUBCAT($dbh,$cat_id,$quesdsec,$questype,$quesprior,$quesstatus,$opt1,$opt2,$opt3,$opt4,$opt5,$opt6)
  {
    $etomodel =  new AdminEtoModelForm(); 
    $dbh_imbl= $etomodel->connectImblDb();
   $cattype=2;
   $quesstatus=1;
   $errormessage='';
  
  $sql1="insert into IM_SPECIFICATION_MASTER (IM_SPEC_MASTER_DESC,IM_SPEC_MASTER_TYPE,MASTER_MOD_DATE) values (:IM_SPEC_MASTER_DESC,:IM_SPEC_MASTER_TYPE,sysdate) RETURNING IM_SPEC_MASTER_ID INTO :IM_SPEC_MASTER_ID";
  $sth1=oci_parse($dbh_imbl,$sql1);
  oci_bind_by_name($sth1,':IM_SPEC_MASTER_ID',$masterid1,10);
  oci_bind_by_name($sth1,':IM_SPEC_MASTER_DESC',$quesdsec);
  oci_bind_by_name($sth1,':IM_SPEC_MASTER_TYPE',$questype);
  $ex= oci_execute($sth1);
    if(!$ex)		    
    {
    $errormessage .="Insertion failed query:$sql1 ,values :IM_SPEC_MASTER_ID=$masterid1,:IM_SPEC_MASTER_DESC=$quesdsec,:IM_SPEC_MASTER_TYPE=$questype ] Error Message-".$ex['message'];
    }else{
        $sql1="insert into IM_SPECIFICATION_MASTER (IM_SPEC_MASTER_ID,IM_SPEC_MASTER_DESC,IM_SPEC_MASTER_TYPE,MASTER_MOD_DATE) values ($1,$2,$3,sysdate) ";
        $params=array($masterid1,$quesdsec,$questype);
         $sth=pg_query_params($dbh,$sql1,$params);
         if(!$sth)		    
         {
           $errormessage .="Insertion failed query:$sql1 ,values :IM_SPEC_MASTER_ID=$masterid1,:IM_SPEC_MASTER_DESC=$quesdsec,:IM_SPEC_MASTER_TYPE=$questype ] Error Message-".$ex['message'];
         }
   }

  $sql2="insert into IM_CAT_SPECIFICATION (FK_IM_SPEC_MASTER_ID,IM_CAT_SPEC_CATEGORY_ID,IM_CAT_SPEC_PRIORITY,IM_CAT_SPEC_STATUS,IM_CAT_SPEC_CATEGORY_TYPE,SPECIFICATION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_CAT_SPEC_CATEGORY_ID,:IM_CAT_SPEC_PRIORITY,:IM_CAT_SPEC_STATUS,:IM_CAT_SPEC_CATEGORY_TYPE,sysdate) RETURNING IM_CAT_SPEC_ID INTO :IM_CAT_SPEC_ID ";
  $sth2=oci_parse($dbh_imbl,$sql2);
  oci_bind_by_name($sth2,':IM_CAT_SPEC_ID',$IM_CAT_SPEC_ID,10);
  oci_bind_by_name($sth2,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth2,':IM_CAT_SPEC_CATEGORY_ID',$cat_id);
  oci_bind_by_name($sth2,':IM_CAT_SPEC_PRIORITY',$quesprior);
  oci_bind_by_name($sth2,':IM_CAT_SPEC_STATUS',$quesstatus);
  oci_bind_by_name($sth2,':IM_CAT_SPEC_CATEGORY_TYPE',$cattype);
  $ex=oci_execute($sth2);
  
  if(!$ex)		    
    {
    $errormessage .="Insertion failed query:$sql2 ,values :FK_IM_SPEC_MASTER_ID=$masterid1,:IM_CAT_SPEC_CATEGORY_ID=$cat_id,:IM_CAT_SPEC_PRIORITY=$quesprior,:IM_CAT_SPEC_STATUS=$quesstatus,:IM_CAT_SPEC_CATEGORY_TYPE=$cattype Error Message-".$ex['message'];
    }else{
        $sql2="insert into IM_CAT_SPECIFICATION (IM_CAT_SPEC_ID,FK_IM_SPEC_MASTER_ID,IM_CAT_SPEC_CATEGORY_ID,IM_CAT_SPEC_PRIORITY,IM_CAT_SPEC_STATUS,IM_CAT_SPEC_CATEGORY_TYPE,SPECIFICATION_MOD_DATE) values ($6,$1,$2,$3,$4,$5,sysdate)";
         $params=array($masterid1,$cat_id,$quesprior,$quesstatus,$cattype,$IM_CAT_SPEC_ID);
         $sth=pg_query_params($dbh,$sql2,$params);
         if(!$sth)		    
         {
          $errormessage .="PG=Insertion failed query:$sql2 ,values :FK_IM_SPEC_MASTER_ID=$masterid1,:IM_CAT_SPEC_CATEGORY_ID=$cat_id,:IM_CAT_SPEC_PRIORITY=$quesprior,:IM_CAT_SPEC_STATUS=$quesstatus,:IM_CAT_SPEC_CATEGORY_TYPE=$cattype \n";
          }
   }
    
  $optstatus=1;
  
  if($questype ==1)
  {
  
  $sql3_1="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_1);
   oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
 $ex= @oci_execute($sth3);
  
  if(!$ex)		    
    {
    $errormessage .="Insertion failed of Option1 of New question \n";
    }else{
        $sql3_1="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
        $params=array($masterid1,$opt1,$optstatus,$IM_SPEC_OPTIONS_ID);
         $sth=pg_query_params($dbh,$sql3_1,$params);
         if(!$sth)		    
         {
          $errormessage .="PG=Insertion failed of Option1 of New question \n";                                     
         }
    }
  
}
 else
 {
 if($opt1 != "")
 {
 
 $sql3_1="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
 $ex= oci_execute($sth3);
  
  if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option1 of New question \n";
			      }else{
                                     $sql3_1="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                    $params=array($masterid1,$opt1,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_1,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option1 of New question \n";                                     
                                    }
                              }
  }
if($opt2 != "")
{
  
  $sql3_2="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_2);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt2);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=oci_execute($sth3);
   if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option2 of New question \n";
			      }else{
                                    $sql3_2="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt2,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_2,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option2 of New question \n";                                     
                                    }
                              }
  
 }
 if($opt3 != "")
 {
 
  $sql3_3="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_3);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt3);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=oci_execute($sth3);
  
   if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option3 of New question \n";
			      }else{
                                    $sql3_3="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt3,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_3,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option3 of New question \n";                                     
                                    }
                              }
  
  }
  if($opt4 != "")
  {
  
  $sql3_4="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_4);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt4);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=oci_execute($sth3);
  
  
   if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option4 of New question \n";
			      }else{
                                    $sql3_4="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt4,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_4,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option4 of New question \n";                                     
                                    }
                              }
  
  }
 if($opt5 != "")
 {
  
  $sql3_5="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate)  RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_5);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt5);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=oci_execute($sth3);
  
   if(!$ex)		    
			      {
			      $errormessage .="Insertion failed of Option5 of New question \n";
			      }else{
                                    $sql3_5="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
                                   $params=array($masterid1,$opt5,$optstatus,$IM_SPEC_OPTIONS_ID);
                                    $sth=pg_query_params($dbh,$sql3_5,$params);
                                    if(!$sth)		    
                                    {
                                     $errormessage .="PG=Insertion failed of Option5 of New question \n";                                     
                                    }
                              }
  }
  if($opt6 != "")
  {
  
  $sql3_6="insert into IM_SPECIFICATION_OPTIONS (FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values (:FK_IM_SPEC_MASTER_ID,:IM_SPEC_OPTIONS_DESC,:IM_SPEC_OPTIONS_STATUS,sysdate) RETURNING IM_SPEC_OPTIONS_ID INTO :IM_SPEC_OPTIONS_ID";
  $sth3=oci_parse($dbh_imbl,$sql3_6);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_ID',$IM_SPEC_OPTIONS_ID,10);
  oci_bind_by_name($sth3,':FK_IM_SPEC_MASTER_ID',$masterid1);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_DESC',$opt6);
  oci_bind_by_name($sth3,':IM_SPEC_OPTIONS_STATUS',$optstatus);
  $ex=oci_execute($sth3);
  
   if(!$ex)		    
        {
        $errormessage .="Insertion failed of Option6 of New question \n";
        }else{
            $sql3_6="insert into IM_SPECIFICATION_OPTIONS (IM_SPEC_OPTIONS_ID,FK_IM_SPEC_MASTER_ID,IM_SPEC_OPTIONS_DESC,IM_SPEC_OPTIONS_STATUS,SPEC_OPTION_MOD_DATE) values ($4,$1,$2,$3,sysdate)";
           $params=array($masterid1,$opt6,$optstatus,$IM_SPEC_OPTIONS_ID);
            $sth=pg_query_params($dbh,$sql3_6,$params);
            if(!$sth)		    
            {
             $errormessage .="PG=Insertion failed of Option6 of New question \n";                                     
            }
      }		      
    }	
  }
  if($errormessage)
  {
  echo "Error:$errormessage";
  }
  else{
  echo "Question Successfuly Added";
  }
  }
  
  
  
  
  
  }

?>