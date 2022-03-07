<html><head>
<LINK HREF="/css/jquery.dataTables.min.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/jquery.dataTables.min.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
           $('#result_det').DataTable( {
               "columnDefs": [{"className": "dt-center", "targets": "_all"}],
               "order": [[ 4, "asc" ]],
               "lengthMenu": [[50, 100, -1], [50, 100, "All"]]
           } );
           
        })
    </script>
</head>
<body>
<?php $vendor_approve=isset($vendor_approve) ? $vendor_approve : 'ALL';
$vendor_audit=isset($vendor_audit) ? $vendor_audit : 'ALL';
$start_date=isset($start_date) ? $start_date : '';
$end_date=isset($end_date) ? $end_date : '';

                    $filepath_download = $_SERVER['DOCUMENT_ROOT'];
                    $filepath_download .=  '/gl_global_upload/';
                    $emp_id=Yii::app()->session['empid'];
                    $timestamp=$emp_id."-".date("F-j-Y")."-".time();
                    $filename_return="blaudit_$timestamp.xls";
                    $file_return = $filepath_download.$filename_return;
                    $FILE = fopen($file_return, "w");

            if($stype=='R'){ 
                // print_r($dataArr); 
                 $tot_records=count($dataArr);
                $totalpass=0;
                $remark_display=$prevId='';$cnt=0;$html='';$row_num=0;    
                if($tot_records>0){
                 $html = '<table class="display" id="result_det" width="100%" align="center">';       
                    for($i=0;$i<count($dataArr);$i++){  
                                
                           if($i==0){
                                     $html .= '<thead><tr><th>S No</th>'
                                       . '<th>'.$dataArr[$i][0].'</th>                         
                                      <th>'.$dataArr[$i][1].'</th>
                                      <th>'.$dataArr[$i][2].'</th>
                                      <th>'.$dataArr[$i][3].'</th>
                                      <th>'.$dataArr[$i][4].'</th>
                                      <th>'.$dataArr[$i][5].'</th>
                                      <th>'.$dataArr[$i][6].'</th>
                                      <th>'.$dataArr[$i][7].'</th>
                                      <th>'.$dataArr[$i][8].'</th>
                                      <th>'.$dataArr[$i][9].'</th>
                                      <th>'.$dataArr[$i][10].'</th>
                                      <th>'.$dataArr[$i][11].'</th>'
                                       . '<th>'.$dataArr[$i][12].'</th>
                                      </tr></thead>';
                           }else{
                               if($dataArr[$i][8]=='Pass' && $dataArr[$i][9]=='Pass' && $dataArr[$i][10]=='Pass'){
                                 $dataArr[$i][11]=1;
                                 $totalpass = $totalpass +1;
                               }
                                 $html .= '<tr><td>'.$i.'</td><td>'.$dataArr[$i][0].'</td>
                                      <td>'.$dataArr[$i][1].'</td>
                                    <td style="padding:4px;widtd:100px;">'.$dataArr[$i][2].'</td>
                                      <td>
                                      <a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Auditedit/stype/R/audit_id/'.$dataArr[$i][3].'/ven_app/'.$vendor_approve.'/ven_audit/'.$vendor_audit.'/sd/'.$start_date.'/ed/'.$end_date.'/offer_id/'.$dataArr[$i][4].'/r/'.$remark_display.'/\',\'_blank\',\'scrollbars=yes,widtd=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      '.$dataArr[$i][3].'</a>';
                                if((preg_match("/DDN/", $dataArr[$i][1]) == 0 && preg_match("/NOIDA/", $dataArr[$i][1])==0)){ 
                                       $html .= '<br/><br/><div><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Index&tabselect=7&reaudit=1&offerID='.$dataArr[$i][4].'\',\'_blank\',\'scrollbars=1,widtd=900, height=800\');" style="text-decoration:none;color:#0000ff"><font color="red">Re-Audit</font></a></div>';
                                }
                                       $html .= '</td>
                                      <td><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='.$dataArr[$i][4].'&go=Go&mid=3424" style="text-decoration:none;color:#0000ff" target="_blank">'.$dataArr[$i][4].'</a></td>
                                      <td>'.$dataArr[$i][5].'</td>
                                      <td>'.$dataArr[$i][6].'</td>
                                      <td>'.$dataArr[$i][7].'</td>
                                      <td>'.$dataArr[$i][8].'</td>
                                      <td>'.$dataArr[$i][9].'</td>
                                      <td>'.$dataArr[$i][10].'</td>
                                      <td>'.$dataArr[$i][11].'</td><td>'.$dataArr[$i][12].'</td>
                                      ';

                                     $html .= '</tr>';
                                }
                                $a0=$dataArr[$i][0];
                                $a1=$dataArr[$i][1];
                                $a2=$dataArr[$i][2];
                                $a3=$dataArr[$i][3];
                                $a4=$dataArr[$i][4];
                                $a5=$dataArr[$i][5];
                                $a6=$dataArr[$i][6];
                                $a7=preg_replace('/[^A-Za-z0-9. -]/', " ", $dataArr[$i][7]);
                                $a8=preg_replace('/[^A-Za-z0-9. -]/', " ", $dataArr[$i][8]);
                                $a9=preg_replace('/[^A-Za-z0-9. -]/', " ", $dataArr[$i][9]);
                                $a10=preg_replace('/[^A-Za-z0-9. -]/', " ", $dataArr[$i][10]);
                                $a11=preg_replace('/[^A-Za-z0-9. -]/', " ", $dataArr[$i][11]);
                                $a12=preg_replace('/[^A-Za-z0-9. -]/', " ", $dataArr[$i][12]);
                               fwrite($FILE, "$a0\t $a1\t $a2\t $a3\t $a4\t $a5\t $a6\t $a7\t $a8\t $a9\t $a10\t $a11\t $a12\t \n");

                            }
                            $html .="</table>";
                            if(count($dataArr)>1){

                                $totalaudit=count($dataArr) -1;
                                         echo $html;
                                   }else{
                                      echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
                                   }
                      }
             }elseif($stype=='NONBL'){
                 $tot_records=count($dataArr);
                $totalpass=0;
                $remark_display=$prevId='';$cnt=0;$html='';$row_num=0;    
                if($tot_records>0){
                 $html = '<table class="display" id="result_det" width="100%" align="center">';       
                    for($i=0;$i<count($dataArr);$i++){ 

                           if($i==0){
                               $html .= '<thead><tr><th>S No</th>'
                                       . '<th>'.$dataArr[$i][0].'</th>                         
                                      <th>'.$dataArr[$i][1].'</th>
                                      <th>'.$dataArr[$i][2].'</th>
                                      <th>'.$dataArr[$i][3].'</th>
                                      <th>'.$dataArr[$i][4].'</th>
                                      <th>'.$dataArr[$i][5].' / Call Recording Url</th>
                                      <th>'.$dataArr[$i][6].'</th>
                                      <th>'.$dataArr[$i][7].'</th>
                                      <th>'.$dataArr[$i][8].'</th>
                                      <th>'.$dataArr[$i][9].'</th>
                                      <th>'.$dataArr[$i][10].'</th>
                                      <th>'.$dataArr[$i][11].'</th>'
                                       . '<th>'.$dataArr[$i][12].'</th>
                                      <th>'.$dataArr[$i][13].'</th>'
                                       . '<th>'.$dataArr[$i][14].'</th>
                                      <th>'.$dataArr[$i][15].'</th>
                                      </tr></thead>';
                           }else{ //echo '<pre>';print_r($dataArr);
                                if((($dataArr[$i][15]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][15]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][15])) && (($dataArr[$i][14]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][14]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][14])) && (($dataArr[$i][13]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][13]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][13])) && (($dataArr[$i][9]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][9]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][9])) && (($dataArr[$i][10]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][10]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][10])) && (($dataArr[$i][11]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][11]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][11])) && (($dataArr[$i][12]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][12]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][12]))){
                                 $totalpass = $totalpass + 1;
                               }
                                 $html .= '<tr><td>'.$i.'</td><td>'.$dataArr[$i][0].'</td>
                                      <td>'.$dataArr[$i][1].'</td>
                                    <td style="padding:4px;widtd:100px;">'.$dataArr[$i][2].'</td>
                                      <td><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/NonBLAudit/Auditedit/stype/NONBL/audit_id/'.$dataArr[$i][3].'/call_id/'.$dataArr[$i][4].'/\',\'_blank\',\'scrollbars=yes,widtd=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      '.$dataArr[$i][3].'</a></td>
                                      <td>'.$dataArr[$i][4].'</td>
                                      <td>'.$dataArr[$i][5].'<br> <a href="'.$dataArr[$i][17].'" '
                                         . 'target="_blank">Play Recording</a></td>
                                      <td>'.$dataArr[$i][6].'</td>
                                      <td>'.$dataArr[$i][7].'</td>
                                      <td>'.$dataArr[$i][8].'</td>
                                      <td>'.$dataArr[$i][9].'</td>
                                      <td>'.$dataArr[$i][10].'</td>
                                      <td>'.$dataArr[$i][11].'</td>
                                      <td>'.$dataArr[$i][12].'</td>
                                      <td>'.$dataArr[$i][13].'</td>
                                      <td>'.$dataArr[$i][14].'</td>
                                      <td>'.$dataArr[$i][15].'</td>';

                                     $html .= '</tr>';
                                }
                                $a0=$dataArr[$i][0];
                                $a1=$dataArr[$i][1];
                                $a2=$dataArr[$i][2];
                                $a3=$dataArr[$i][3];
                                $a4=$dataArr[$i][4];
                                $a5=$dataArr[$i][5];
                                $a6=$dataArr[$i][6];
                                $a7=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][7]));
                                $a8=$dataArr[$i][8];
                                $a9=$dataArr[$i][9];
                                $a10=$dataArr[$i][10];
                                $a11=$dataArr[$i][11];
                                $a12=$dataArr[$i][12];
                                $a13=$dataArr[$i][13];
                                $a14=$dataArr[$i][14];
                                $a15=$dataArr[$i][15];
                               fwrite($FILE, "$a0\t $a1\t $a2\t $a3\t $a4\t $a5\t $a6\t $a7\t $a8\t $a9\t $a10\t $a11\t $a12\t $a13\t $a14\t $a15\t \n");
                            }
                            $html .="</table>";
                            if(count($dataArr)>1){
                                echo $html;
                            }else{
                              echo '<table class="display" id="result_det" width="100%" align="center"><tr><td>No Record found</td></tr></table>';  
                              }
                      }
             
         
        
            }elseif($stype=='AUTO' || $stype=='AUTO2' || $stype=='AUTO3'){
                $tot_records = count($dataArr);
                $q1 =$q2=$q3=$q4=$q5=$q6=$q7= 0;
                
                $prevId = '';
                $cnt = 0;
                $html = '';
                $row_num = 0;
                if ($tot_records > 0) {
                    $html.= '<table class="display" id="result_det" width="100%" align="center">';
                    for ($i = 0;$i < count($dataArr);$i++) {                                
                        if ($i == 0) {
                            $html.= '<thead><tr><th>S No</td>' . '<th>' . $dataArr[$i][0] . '</th>                         
                                      <th>' . $dataArr[$i][1] . '</th>
                                      <th>' . $dataArr[$i][2] . '</th>
                                      <th>' . $dataArr[$i][3] . '</th>
                                      <th>' . $dataArr[$i][4] . '</th>
                                      <th>' . $dataArr[$i][5] . '</th>
                                      <th>' . $dataArr[$i][6] . '</th>
                                      <th>' . $dataArr[$i][7] . '</th>
                                      <th>' . $dataArr[$i][8] . '</th>
                                      <th>' . $dataArr[$i][9] . '</th>
                                      <th>' . $dataArr[$i][10] . '</th>
                                      <th>' . $dataArr[$i][11] . '</th>
                                      <th>' . $dataArr[$i][12] . '</th>
                                      <th>' . $dataArr[$i][13] . '</th>
                                      <th>' . $dataArr[$i][14] . '</th>
                                      <th>' . $dataArr[$i][15] . '</th>
                                      </tr></thead>';
                        } else {
                            $remark_display = 0;
                            if ($dataArr[$i][7] == '-') {
                                $remark_display = 1;
                            }
                            if($dataArr[$i][8]=='Pass'){
                            $q1 = $q1 + 1;
                            }
                            if($dataArr[$i][9]=='Pass'){
                            $q2 = $q2 + 1;
                            }
                            if($dataArr[$i][10]=='Pass'){
                            $q3 = $q3 + 1;
                            }
                            if($dataArr[$i][11]=='Pass'){
                            $q4 = $q4 + 1;
                            }
                            if($dataArr[$i][12]=='Pass'){
                            $q5 = $q5 + 1;
                            }
                            if($dataArr[$i][13]=='Pass'){
                            $q6 = $q6 + 1;
                            }
                           if(($dataArr[$i][8]=='Pass') && ($dataArr[$i][9]=='Pass') && ($dataArr[$i][10]=='Pass') && ($dataArr[$i][11]=='Pass') 
                                   && ($dataArr[$i][12]=='Pass') && ($dataArr[$i][13]=='Pass')){
                                $dataArr[$i][14]=1;
                               $q7 = $q7 + 1; 
                            }else{
                                $dataArr[$i][14]=0;
                            }
                            
                            $html.= '<tr><td>' . $i . '</td><td>' . $dataArr[$i][0] . '</td>
                                      <td>' . $dataArr[$i][1] . '</td>
                                    <td style="padding:4px;width:100px;">' . $dataArr[$i][2] . '</td>
                                      <td>
                                      <a href="#" onclick="javascript:window.open(\'index.php?r=admin_eto/auditEto/Auditedit/stype/'.$stype.'/audit_id/' . $dataArr[$i][3] . '/ven_app/' . $vendor_approve . '/ven_audit/' . $vendor_audit . '/sd/' . $start_date . '/ed/' . $end_date . '/offer_id/' . $dataArr[$i][4] . '/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      ' . $dataArr[$i][3] . '</a>';
                            $html.= '</td>
                                      <td><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=' . $dataArr[$i][4] . '&go=Go&mid='.$mid.'" style="text-decoration:none;color:#0000ff" target="_blank">' . $dataArr[$i][4] . '</a></td>
                                      <td>' . $dataArr[$i][5] . '</td>
                                      <td>' . $dataArr[$i][6] . '</td>
                                      <td>' . $dataArr[$i][7] . '</td>
                                      <td>' . $dataArr[$i][8] . '</td>
                                      <td>' . $dataArr[$i][9] . '</td>
                                      <td>' . $dataArr[$i][10] . '</td>
                                      <td>' . $dataArr[$i][11] . '</td>
                                      <td>' . $dataArr[$i][12] . '</td>
                                      <td>' . $dataArr[$i][13] . '</td>
                                      <td>' . $dataArr[$i][14] . '</td>
                                      <td>' . $dataArr[$i][15] . '</td>
                                   ';
                            $html.= '</tr>';
                        }
                   $a0=$dataArr[$i][0];
                        $a1=$dataArr[$i][1];
                        $a2=$dataArr[$i][2];
                        $a3=$dataArr[$i][3];
                        $a4=$dataArr[$i][4];
                        $a5=$dataArr[$i][5];
                        $a6=$dataArr[$i][6];
                        $a7=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][7]));
                        $a8=$dataArr[$i][8];
                        $a9=$dataArr[$i][9];
                        $a10=$dataArr[$i][10];
                        $a11=$dataArr[$i][11];
                        $a12=$dataArr[$i][12];
                        $a13=$dataArr[$i][13];
                        $a14=$dataArr[$i][14];
                        $a15=$dataArr[$i][15];
                       fwrite($FILE, "$a0\t $a1\t $a2\t $a3\t $a4\t $a5\t $a6\t $a7\t $a8\t $a9\t $a10\t $a11\t $a12\t $a13\t $a14\t $a15\t \n");

                        
                    }
                    $html.= "</table>";
                }
                $totalaudit = count($dataArr) - 1;
                if (count($dataArr) > 1) {
                    echo $html ;
                } else {
                    echo '<table class="display" id="result_det" width="100%" align="center"><tr><td>No Record found</td></tr></table>';  
                }
        } 
        else{
             
                $tot_records = count($dataArr);               
                $prevId = '';
                $cnt = 0;
                $html = '';
                $row_num = 0;
                if ($tot_records > 0) {
                    $html.= '<table class="display" id="result_det" width="100%" align="center">';
                    for ($i = 0;$i < count($dataArr);$i++) {                       
                        if ($i == 0) {
                            $html.= '<thead><tr><th>S No</th>' . '<th>' . $dataArr[$i][0] . '</th>                         
                                      <th>' . $dataArr[$i][1] . '</th>
                                      <th>' . $dataArr[$i][2] . '</th>
                                      <th>' . $dataArr[$i][3] . '</th>
                                      <th>' . $dataArr[$i][4] . '</th>
                                      <th>' . $dataArr[$i][5] . '</th>
                                      <th>' . $dataArr[$i][6] . '</th>
                                      <th>' . $dataArr[$i][7] . '</th>
                                      <th>' . $dataArr[$i][8] . '</th>
                                      <th>' . $dataArr[$i][9] . '</th>
                                      <th>' . $dataArr[$i][10] . '</th>
                                      <th>' . $dataArr[$i][11] . '</th>
                                      <th>' . $dataArr[$i][12] . '</th>
                                      <th>' . $dataArr[$i][13] . '</th>
                                      <th>' . $dataArr[$i][14] . '</th>
                                      <th>' . $dataArr[$i][15] . '</th>
                                      <th>' . $dataArr[$i][16] . '</th>
                                      <th>' . $dataArr[$i][17] . '</th>
                                      <th>' . $dataArr[$i][18] . '</th>
                                      <th>' . $dataArr[$i][19] . '</th>
                                      <th>' . $dataArr[$i][20] . '</th>
                                      <th>' . $dataArr[$i][21] . '</th>
                                      <th>' . $dataArr[$i][22] . '</th>
                                      <th>' . $dataArr[$i][23] . '</th>
                                      <th>' . $dataArr[$i][24] . '</th>
                                      </tr></thead><tbody>';
                        } else {
                            $remark_display = 0;
                            if ($dataArr[$i][7] == '-') {
                                $remark_display = 1;
                            }
                            $html.= '<tr><td>' . $i . '</td><td>' . $dataArr[$i][0] . '</td>
                                      <td>' . $dataArr[$i][1] . '</td>
                                    <td style="padding:4px;width:100px;">' . $dataArr[$i][2] . '</td>
                                      <td><a href="#" onclick="javascript:window.open(\'/index.php?mid='.$mid.'&r=admin_eto/auditEto/Auditedit_v1/audit_id/' . $dataArr[$i][3] . '/ven_app/' . $vendor_approve . '/ven_audit/' . $vendor_audit . '/sd/' . $start_date . '/ed/' . $end_date . '/offer_id/' . $dataArr[$i][4] . '/r/' . $remark_display . '/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      ' . $dataArr[$i][3] . '</a>';
                            $html.= '</td>
                                      <th><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=' . $dataArr[$i][4] . '&go=Go&mid='.$mid.'" style="text-decoration:none;color:#0000ff" target="_blank">' . $dataArr[$i][4] . '</a></td>
                                      <td>' . $dataArr[$i][5] . '</td>
                                      <td>' . $dataArr[$i][6] . '</td>
                                      <td>' . $dataArr[$i][7] . '</td>
                                      <td>' . $dataArr[$i][8] . '</td>
                                      <td>' . $dataArr[$i][9] . '</td>
                                      <td>' . $dataArr[$i][10] . '</td>
                                      <td>' . $dataArr[$i][11] . '</td>
                                      <td>' . $dataArr[$i][12] . '</td>
                                      <td>' . $dataArr[$i][13] . '</td>
                                      <td>' . $dataArr[$i][14] . '</td>
                                      <td>' . $dataArr[$i][15] . '</td>
                                      <td>' . $dataArr[$i][16] . '</td>
                                      <td>' . $dataArr[$i][17] . '</td>
                                      <td>' . $dataArr[$i][18] . '</td>
                                      <td>' . $dataArr[$i][19] . '</td>
                                      <td>' . $dataArr[$i][20] . '</td>
                                      <td>' . $dataArr[$i][21] . '</td>
                                      <td>' . $dataArr[$i][22] . '</td>
                                      <td>' . $dataArr[$i][23] . '</td>
                                      <td>' . $dataArr[$i][24] . '</td>
                                   ';
                            $html.= '</tr>';
                        }
                     $a0=$dataArr[$i][0];
                                $a1=$dataArr[$i][1];
                                $a2=$dataArr[$i][2];
                                $a3=$dataArr[$i][3];
                                $a4=$dataArr[$i][4];
                                $a5=$dataArr[$i][5];
                                $a6=$dataArr[$i][6];
                                $a7=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][7]));
                                $a8=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][8]));
                                $a9=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][9]));
                                $a10=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "",$dataArr[$i][10]));
                                $a11=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "",$dataArr[$i][11]));
                                $a12=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "",$dataArr[$i][12]));
                                $a13=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][13]));
                                $a14=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][14]));
                                $a15=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][15]));
                                $a16=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][16]));
                                $a17=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][17]));
                                $a18=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][18]));
                                $a19=$dataArr[$i][19];
                                $a20=$dataArr[$i][20];
                                $a21= $dataArr[$i][21];
                                $a22= $dataArr[$i][22];
                                $a23= $dataArr[$i][23];
                                $a24= $dataArr[$i][24];
                               fwrite($FILE, "$a0\t $a1\t $a2\t $a3\t $a4\t $a5\t $a6\t $a7\t $a8\t $a9\t $a10\t $a11\t $a12\t $a13\t $a14\t $a15\t $a16\t $a17\t $a18\t $a19\t $a20\t $a21\t $a22\t $a23\t $a24\t \n");
    
                    }
                    $html.= "</tbody></table>";
                }
                $totalaudit = count($dataArr) - 1;
                if (count($dataArr) > 1) {
                    echo $html ;
                } else {
                    echo '<table class="display" id="result_det" width="100%" align="center"><tr><td>No Record found</td></tr></table>';  
                }
       }
     fclose($FILE);
    echo '<div style="padding:4px;font-weight:bold;text-align:center;"><a href="/gl_global_upload/'.$filename_return.'">Click to Download</a></div>';   
       ?></body>
</html>