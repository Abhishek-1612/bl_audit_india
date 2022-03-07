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
<body><?php  
                  
                    $filepath_download = $_SERVER['DOCUMENT_ROOT'];
                    $filepath_download .=  '/gl_global_upload/';
                    $emp_id=Yii::app()->session['empid'];
                    $timestamp=$emp_id."-".date("F-j-Y")."-".time();
                    $filename_return="blaudit_$timestamp.xls";
                    $file_return = $filepath_download.$filename_return;
                    $FILE = fopen($file_return, "w");

            $tot_records                   = count($dataArr);
            $wrong_del_dis_selection_error = 0;
            $wrong_del_error               = 0;
            $call_ettiquettes              = 0;
            $error_score                   = 0;
            
            $prevId  = '';
            $cnt     = 0;
            $html    = '';
            $row_num = 0;
            if ($tot_records > 0) {
                $html .= '<table class="display" id="result_det" width="100%" align="center">';
                
                for ($i = 0; $i < count($dataArr); $i++) {                               
                    if ($i == 0) {
                        $html .= '<thead><tr>'
                                . '<th>S No</td>' . '<th>' . @$dataArr[$i][0] . '</th>                         
                                      <th>' . @$dataArr[$i][1] . '</th>
                                      <th>' . @$dataArr[$i][2] . '</th>
                                      <th>' . @$dataArr[$i][3] . '</th>
                                      <th>' . @$dataArr[$i][4] . '</th>
                                      <th>' . @$dataArr[$i][5] . '</th>
                                      <th>' . @$dataArr[$i][6] . '</th>
                                      <th>' . @$dataArr[$i][7] . '</th>
                                      <th>' . @$dataArr[$i][8] . '</th>
                                      <th>' . @$dataArr[$i][9] . '</th>
                                      <th>' . @$dataArr[$i][10] . '</th>
                                      <th>' . @$dataArr[$i][11] . '</th>
                                      <th>' . @$dataArr[$i][12] . '</th>
                                      <th>' . @$dataArr[$i][13] . '</th>                                      
                                      </tr></thead>';
                    } else {
                        $remark_display = 0;
                        if ($dataArr[$i][7] == '-') {
                            $remark_display = 1;
                        }
                        $html .= '<tr><td style="padding:4px;">' . $i . '</td><td style="padding:4px;">' . @$dataArr[$i][0] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][1] . '</td>
                                    <td style="padding:4px;width:100px;">' . @$dataArr[$i][2] . '</td>
                                      <td style="padding:4px;">
                                      <a href="/index.php?r=admin_eto/BulkAuditEto/AuditMis_Edit&offer_id=' . @$dataArr[$i][4] . '&auditid='.@$dataArr[$i][3].'&mid=3549" style="text-decoration:none;color:#0000ff" target="_blank">' . @$dataArr[$i][3] . '</a>';
                        if ( (preg_match("/DDN/", @$dataArr[$i][1]) == 0 && preg_match("/NOIDA/", @$dataArr[$i][1]) == 0)) {
                            $html .= '<br/><br/><div><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Index&tabselect=7&reaudit=1&offerID=' . @$dataArr[$i][4] . '\',\'_blank\',\'scrollbars=1,width=900, height=800\');" style="text-decoration:none;color:#0000ff"><font color="red">Re-Audit</font></a></div>';
                        }
                        $html .= '</td>
                                      <td style="padding:4px;"><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=' . @$dataArr[$i][4] . '&go=Go&mid=3424" style="text-decoration:none;color:#0000ff" target="_blank">' . @$dataArr[$i][4] . '</a></td>
                                      <td style="padding:4px;">' . @$dataArr[$i][5] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][6] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][7] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][8] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][9] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][10] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][11] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][12] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][13] . '</td>';
                        
                        $html .= '</tr>';
                        if ($dataArr[$i][8] != '-') {
                            $wrong_del_dis_selection_error++;
                        }
                        if ($dataArr[$i][9] != '-') {
                            $wrong_del_error++;
                        }
                        if ($dataArr[$i][10] != '-') {
                            $call_ettiquettes++;
                        }
                        if ($dataArr[$i][13] == '0') {
                            $error_score++;
                        }
                        
                    }
                                $a0=$dataArr[$i][0];
                                $a1=$dataArr[$i][1];
                                $a2=$dataArr[$i][2];
                                $a3=$dataArr[$i][3];
                                $a4=$dataArr[$i][4];
                                $a5=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][5]));
                                $a6=$dataArr[$i][6];
                                $a7=$dataArr[$i][7];
                                $a8=$dataArr[$i][8];
                                $a9=$dataArr[$i][9];
                                $a10=$dataArr[$i][10];
                                $a11=$dataArr[$i][11];
                                $a12=preg_replace("/br/","",preg_replace('/[^A-Za-z0-9. -]/', "", $dataArr[$i][12]));
                                $a13=$dataArr[$i][13];
                               fwrite($FILE, "$a0\t $a1\t $a2\t $a3\t $a4\t $a5\t $a6\t $a7\t $a8\t $a9\t $a10\t $a11\t $a12\t $a13\t \n");
     
                }
                $html .= "</table>";
                
            }
            $totalaudit = count($dataArr) - 1;            
            if (count($dataArr) > 1) {
                echo $html;
            echo '<div style="padding:4px;font-weight:bold;text-align:center;"><a href="/gl_global_upload/'.$filename_return.'">Click to Download</a></div>';   
                
            } else {
                echo '<table class="display" id="result_det" width="100%" align="center"><tr><td>No Record found</td></tr></table>';
            }
         fclose($FILE);       
?></body>
</html>