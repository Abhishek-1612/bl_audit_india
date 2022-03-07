<?php
class BulkvendorForm extends CFormModel
{
    public function show_html($cookie_mid, $js_file) {
        print <<<ae
    <html>
        <head><title>Bulk Upload of ID's while Agent Creation</title>
    <LINK HREF="$js_file/css/report.css" REL="STYLESHEET" TYPE="text/css">
    <style type="text/css"> 
        table td {font-size:12px;background-color:#F0F9FF;} 
        .bg { background-color:#F0F9FF;} 
        select {  width: 180px;  background-color: #ffffff;}
    </style>   
    <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script language="javascript" src="protected/modules/admin_eto/common-scripts/agent.js"></script>
    </head>
    <body><input name="frame_height" id="frame_height" value="" type="hidden">
        <form name="Search" method="post" enctype="multipart/form-data" action="/index.php?r=admin_eto/Bulkvendor/Index&mid=$cookie_mid">
            <input type="hidden" name="mid" value="$cookie_mid">
            <table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" 
                cellpadding="4" cellspacing="0">
                <TR>
                    <TD colspan="2" align="center" style="background-color:#006DCC;color:#fff">
                        <B><FONT SIZE = "2px">Bulk Upload of ID's while Agent Creation</FONT></B>
                    </TD>
                </tr>
                <tr>
                    <TD bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 12px; line-height:2px;" width="15%">
                        <B>Upload Excel:</B>
                    </TD>
                    <TD bgcolor="#F0F9FF" style="line-height:2px;" width="30%">
                        <input type="FILE" name="S_attachment" value="" >
&nbsp;
                    </TD>
                </tr>
                <tr id ="tspbl_data"></tr>
                <tr>
                    <td align="center" colspan="2" bgcolor="#F0F9FF">
ae;
        print <<<hj
<input type="submit" name="action" id ="Upload" value="Upload" onclick="return upload();" class="btn btn-small btn-primary" style="font-weight:normal">
<input type="submit" name="action1" id ="disable" value="Process" onclick = "process();" class="btn btn-small btn-primary" style="font-weight:normal">
hj;
        print <<<jk
</td>
    </tr>
    <tr>
    <td colspan = "4" align="left" bgcolor="#F0F9FF">
        <div style="float:left"><B><a href="/bulkagentsample.xls">Download Sample Excel of Bulk Upload of ID's while Agent Creation.</a></B></div></td>
    </tr>
    </table><br> 
jk;
        
    }
    
    public function showInst() {
        print <<<hj
<div id="div_inst">
    <table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0">
    <TR>
    <TD align="center" bgcolor="#F0F9FF"><B>Bulk Upload of ID's while Agent Creation Instructions</B></TD>
    </TR>
    <TR>
    <TD bgcolor="#F0F9FF" style="font-size: 11px;width:45%;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;vertical-align:top">
    <div><ul>
    <li>Document must be in Excel Format (File Format Should be in .xls)</li>
    <li>Only 50 records will be process in one excel.</li>
    <li>All headings should be in first row of Excel.</li>
    <li>Delete blank rows from excel before upload. Otherwise all blank rows will be skipped.</li>
    <li>All headings should be in given format and Don't change the given headings. Please download sample excel and refer all given headings.</li>
    <li>Emp ID, Vendor Name, Access Level and skill level are Mandatory Fields.</li>
    <li>Only one excel will be process at once. If you have uploaded one excel it must be processed or deleted before uploading another excel. </li>
    <li>Access Level: EMP - 0 , AGENT - 1 , TL - 2 , QA - 3 , MGR - 4</li>
    <li>Skill Level: Under certification (50 worked leads only) - 10 , Certification done, training payment pending and new contract - 20 , Certification done, training payment pending and old contract - 25 , Training payment done - 30</li>
</ul></div>
    </TD>
    </TR></Table></div>
hj;
        
    }
    
        public function upload($empid, $cookie_mid) {
        $action='';
        if (isset($_REQUEST['act'])) {
            $action=$_REQUEST['act'];
        }
        $file_id          = 'S_attachment';
        $file_name        = '';
        $upload_path      = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/";
        $j                = 0;

        $file_name_upload = $_FILES[$file_id]['name'];
        $time             = getdate();
        $date             = substr($time['month'], 0, 3) . "-" . $time['mday'] . "-" . $time['year']."-".$time['hours']."-".$time['minutes']."-".$time['seconds'];
        $file_name        = $file_name_upload;

        $file_name        = "Bulkagent";
        $file_name        = preg_replace("/\s+/", '_', $file_name);
        $file_name        = preg_replace("/.xls/", '', $file_name);
        $file_name .= "_";
        $file_name .= $date;
        $file_name .= "_" . $empid;
        $file_name .= ".xls";
        $split_empid  = '';
        $html         = '';
        $i            = 0;
        $arr          = explode("_", $file_name);
        foreach ($arr as $_) {
            if (preg_match("/(.*)\.xls/", $_, $match)) {
                $temp        = explode('.', $_);
                $split_empid = $temp[0];
            }
        }


        $DIR = opendir("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/");
        print <<<sd
<input type="hidden" name="mid" value="$cookie_mid"><TABLE bordercolor="#bedaff" border="1" cellspacing="0" cellpadding="4" align="center" class="table_txt" style="border-collapse: collapse; width:98%">
sd;
        $tr              = '';
        $match_filecount = 0;
        while (false !== ($file = readdir($DIR))) {
            preg_match("/.xls/i", $file, $match);
            if ($match) {
                $temp1 = explode("_", $file);
                $split_empid1=isset(explode(".",$temp1[sizeof($temp1)-1])[0])?explode(".",$temp1[sizeof($temp1)-1])[0]:'';


                if ($split_empid1 == $split_empid) {
                    $tr .= <<<ll
<TR><TD align="right" bgcolor="#F0F9FF"><b><font size= "2" color="black" >$file</font>
<img src="/temp_sample/trash.gif" border="0" onclick = "return remove_file('$file','excel','$action','$cookie_mid','bb');"><input type="hidden" name="excel" value="$file"></b>
<div id="removedexcel" style="display:none"> ( Removed ) </div>                                
ll;

                    $tr .= "</TD></tr>";
                    $match_filecount++;
                }
            }
        }

        $uploadfile = $upload_path . $file_name;
        if ($match_filecount == 0) {
            if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {
                $html = "Cannot upload the file '" . $_FILES[$file_id]['name'] . "'";
                if (!file_exists($uploadfile)) {
                    $html .= " : Folder don't exist.";
                } elseif (!is_writable($uploadfile)) {
                    $html .= " : Folder not writable.";
                } elseif (!is_writable($uploadfile)) {
                    $html .= " : File not writable.";
                }
                $file_name = '';
            } else {
                if (!$_FILES[$file_id]['size']) {
                    print_r('in size');exit();
                    @unlink($uploadfile);
                    $file_name = '';
                    $html      = "Empty file found - please use a valid file.";
                } else {
                    chmod($uploadfile, 0777);
                    $i = 1;
                }
            }
        } else {
            print <<<lk
<TR><TD align="Left" bgcolor="#F0F9FF">You Already Upload These Files. Kindly Process Them Before Uploading New File or Delete Below Files.</TD></TR>$tr</table>
lk;
            print <<<gh
<script language="JavaScript" type="text/javascript"> document.getElementById('disable').disabled=false;
            document.getElementById('Upload').disabled=true;</script>
gh;
        }
        $heading_error = '';

        if ($i == 1) {
            $excel_file = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$file_name";

            Yii::import('ext.phpexcelreader.JPhpExcelReader');
            $data = new JPhpExcelReader($excel_file);
            $heading_error = '';
            $heading_hash = array( 'emp_id' => '','vendor_name' => '', 'access_level' => '', 'skill_level' => '');
            if (isset($data->sheets[0]['cells'][1][1])) {
                $heading_hash['emp_id'] = $data->sheets[0]['cells'][1][1];
            } else {
                $heading_hash['emp_id'] = '';
            }
             if (isset($data->sheets[0]['cells'][1][2])) {
                $heading_hash['vendor_name'] = $data->sheets[0]['cells'][1][2];
            } else {
                $heading_hash['vendor_name'] = '';
            }
           
            
            if (isset($data->sheets[0]['cells'][1][3])) {
                $heading_hash['access_level'] = $data->sheets[0]['cells'][1][3];
            } else {
                $heading_hash['access_level'] = '';
            }
            if (isset($data->sheets[0]['cells'][1][4])) {
                $heading_hash['skill_level'] = $data->sheets[0]['cells'][1][4];
            } else {
                $heading_hash['skill_level'] = '';
            }
            
            if ($heading_hash['emp_id'] != 'EMP_ID') {
                $heading_error.= "<BR>Column - A should be EMP_ID";
            }
            if ($heading_hash['vendor_name'] != 'VENDOR_NAME') {
                $heading_error.= "<BR>Column - B should be VENDOR_NAME*";
            }
            if ($heading_hash['access_level'] != 'ACCESS_LEVEL') {
                $heading_error.= "<BR>Column - C should be ACCESS_LEVEL*";
            }
            if ($heading_hash['skill_level'] != 'SKILL_LEVEL') {
                $heading_error.= "<BR>Column - D should be SKILL_LEVEL*";
            }
            
        } elseif ($match_filecount == 0) {
            print <<<hj
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF"> Error while uploading: $html</TD></TR></TABLE>
hj;
            print <<<lp
<script language="JavaScript" type="text/javascript">
		document.getElementById('disable').disabled=true;
		</script>
lp;
            exit;
        }
        if ($heading_error)
        {
            print <<<hj
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF"> Heading Mismatch Please Follow These  : $heading_error</TD></TR></TABLE>
hj;
            print <<<lp
<script language="JavaScript" type="text/javascript">
		document.getElementById('disable').disabled=true;
		</script>
lp;
            unlink("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$file_name");
            exit;
        }
        elseif ($match_filecount == 0) {
            print <<<ki
<div id="ok_tab"><table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF"> All Headings Are OK !! Click on Process Button to Proceed.</TD></TR></div><TABLE>
ki;
            print <<<bh
<script language="JavaScript" type="text/javascript">
			document.getElementById('disable').disabled=false;
			document.getElementById('Upload').disabled=true;
			</script>
bh;
        }

        return $file_name;
    }

    public function Process($empid,$excel_data, $cookie_mid, $user_del, $user_download, $uploaded_filename, $process_time)
    { //echo $excel_data.'Process'.$uploaded_filename;
    
        $j = 0;
        if ($excel_data == 'excel') {
            $DIR = opendir("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/");
            while (false !== ($file1 = readdir($DIR))) {
                if (preg_match("/^\.\.?$/", $file1)) {
                    continue;
                }
                if (preg_match("/.xls/", $file1) && ($file1 == $uploaded_filename)) {
                    print <<<hj
<input type="hidden" name="mid" value="$cookie_mid">
<TABLE bordercolor="#bedaff" border="1" cellspacing="0" cellpadding="4" align="center" class="table_txt" style="border-collapse: collapse; width:98%" align="center"><TR><TD align="right" bgcolor="#F0F9FF"><b>
hj;
                    print <<<kl
<font size= "2" color="black" >$uploaded_filename</font>
kl;
                    print <<<mk
<INPUT type="image" name="search_file" src="/temp_sample/trash.gif" border="0" onclick = "return remove('$uploaded_filename','excel');"><input type="hidden" name="excel" value="$uploaded_filename"></b>
mk;
                    print "</TD></tr></table>";
                    $j++;
                }
            }
            echo '</form>';
        }

        if ($excel_data == 'excel_data') {

            $DIR       = opendir("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/");
            while (false !== ($file1 = readdir($DIR)))
            {    
                preg_match("/.xls/", $file1, $match);
                if ($match && substr($file1, 0, 9)=="Bulkagent") {
                    $temp = explode("_", $file1);
                    $split_empid1=isset(explode(".",$temp[sizeof($temp)-1])[0])?explode(".",$temp[sizeof($temp)-1])[0]:'';

                    if ($split_empid1 == $empid)
                    {
                        print <<<gf
<script language="JavaScript" type="text/javascript">
                    document.getElementById('disable').disabled=false;
                    </script>
gf;
                        $upload_path = "/home3/indiamart/public_html/excel_download/bulk_bigbuyer_output/";
                        $filename_input   = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$uploaded_filename";
                        Yii::import('ext.phpexcelreader.JPhpExcelReader');
                        $data       = new JPhpExcelReader($filename_input);
                        $total_rows = $data->sheets[0]['numRows'];
                        if ($total_rows > 50) {
                            print <<<jh
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF">Record Limit Exceed !! Only 250 Records Are Allowed. You Have Entered <b>$total_rows</b> Records. Re-Upload Excel The File and Try Again.</TD></TR><TABLE>
jh;
                            unlink("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$uploaded_filename");
                            print <<<vg
<script language="JavaScript" type="text/javascript">document.getElementById('disable').disabled=true;document.getElementById('Upload').disabled=false;</script>
vg;
                            exit;
                        } else if ($total_rows == 0 || $total_rows == 1) {
                            print <<<fd
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF" align="Center"><B>No Records Found in Excel. Kindly Enter Some Data To Proceed.</B></TD></TR><TABLE>
fd;
                            unlink("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$uploaded_filename");
                            print <<<mn
<script language="JavaScript" type="text/javascript">document.getElementById('disable').disabled=true;document.getElementById('Upload').disabled=false;</script>
mn;
                            exit;
                        }

                        $filename_out      = $upload_path ."bulkagentstatus.xls";
                        $BBFILE       = fopen($filename_out, "w");
                        if ($BBFILE === FALSE)
                            $remark = "Cannot open file [$filename_out] for writing";
        $serv_model =new ServiceGlobalModelForm();  
        $model = new GlobalmodelForm();
        $ref = $model->Geo_IP();
        $remark = '';
        if(fwrite($BBFILE, "EMP_ID\tVENDOR_NAME\tAGENT_LEVEL\tSKILL_LEVEL\tSTATUS\tREMARKS\n") === FALSE)
            $remark = "Cannot write to file [$filename_out]";
        $total_rows = $data->sheets[0]['numRows'];
        $process_flag = 0;
        $recVendorAll=CommonVariable::get_active_vendor_list();  

        foreach (range(2, $total_rows) as $i)
        {// print_r($data->sheets[0]['cellsInfo'][$i]);
             $emp_id = $vendor_name = $agent_level = $skill_level='';
                $finalmsg = '';
                $mandatory_check=1;
               
             if (isset($data->sheets[0]['cellsInfo'][$i][1]['raw'])) {
                    $emp_id = $data->sheets[0]['cellsInfo'][$i][1]['raw'];
                    if (!empty($emp_id) && !is_numeric($emp_id)) {
                        $finalmsg = "Please fill Numeric EMP ID";
                        $mandatory_check=0;
                     }
                } else {
                    $finalmsg = "Please fill EMP ID";
                    $mandatory_check=0;
                }
                if (isset($data->sheets[0]['cells'][$i][2])) {
                    $vendor_name = $data->sheets[0]['cells'][$i][2];                    
                } else {
                    $finalmsg = "Please fill EMP ID / Vendor Name / Agent Level / Skill Level";
                    $mandatory_check=0;
                }
                if (isset($data->sheets[0]['cells'][$i][3])) {
                    $agent_level = $data->sheets[0]['cells'][$i][3];                    
                } else {
                    $finalmsg = "Please fill EMP ID / Vendor Name / Agent Level / Skill Level";
                    $mandatory_check=0;
                }
                if (isset($data->sheets[0]['cells'][$i][4])) {
                    $skill_level = $data->sheets[0]['cells'][$i][4];                    
                } else {
                    $finalmsg = "Please fill EMP ID / Vendor Name / Agent Level / Skill Level";
                    $mandatory_check=0;
                }
                if($emp_id =='' && $vendor_name =='' && $agent_level=='' && $skill_level==''){
                   continue;
                }
                $vendor_id='';
                    foreach($recVendorAll as $key => $value)
                    {
                        if($vendor_name == $value)
                        {
                            $vendor_id=$key; 
                        }
                    }
                    if($vendor_id==''){
                       $finalmsg = "Please fill Correct Vendor Name";
                       $mandatory_check=0;                       
                     }
                    
                if ($mandatory_check == 0) {
                    if (fwrite($BBFILE, "$emp_id\t$vendor_name\t$agent_level\t$skill_level\tFAILED\t$finalmsg\n") === FALSE) $remark = "Cannot write to file [$filename_out]";
                    continue;
                }else{
                    $finalmsg= $this->saveagentdata($serv_model,$emp_id,$vendor_name,$vendor_id,$agent_level,$skill_level);
                    print_r($finalmsg);
                    exit;
                     $process_flag = 1;
                } 
                if(strpos($finalmsg,'successfully')>0){
                    if (fwrite($BBFILE, "$emp_id\t$vendor_name\t$agent_level\t$skill_level\tSUCCESS\t$finalmsg\n") === FALSE) $remark = "Cannot write to file [$filename_out]";
                }else{
                    if (fwrite($BBFILE, "$emp_id\t$vendor_name\t$agent_level\t$skill_level\tFAILED\t$finalmsg\n") === FALSE) $remark = "Cannot write to file [$filename_out]";
                }
         
        }
        if ($remark) {
            print_r($remark);exit();
        }        
            }else{continue;}

                    if ($process_flag == 1) {
                        print <<<jk
<script language="JavaScript" type="text/javascript">
					document.getElementById('processing').style.display = "none";
					</script>
jk;
                    }

                    fclose($BBFILE);
                    chmod($filename_out, 0755);
                    $file_size = filesize($filename_out);
                    $handle    = fopen($filename_out, "r");
                    if(filesize($filename_out) > 0)
                        $content = fread($handle,filesize($filename_out));
                    else
                        return 0;
                    fclose($handle);
                    $content = chunk_split(base64_encode($content));
                    $operation = 'Insert';
                    //var_dump($content);die;
                    $this->mailsent($content,$filename_out,$process_time, $operation);

                    unlink("$filename_out");
                    unlink("$filename_input");

                    print <<<kl
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF">Process Complete. Please Check Your Mail For Summary.</TD></TR></TABLE>
kl;
                    print <<<op
<script language="JavaScript" type="text/javascript">
				document.getElementById('disable').disabled=true;document.getElementById('Upload').disabled=false;
				</script>
op;
                    $j++;
                } else {
                    print <<<bh
<script language="JavaScript" type="text/javascript">
					document.getElementById('disable').disabled=true;
					</script>
bh;
                }
            }
        
    }
    }
    public function mailsent($content,$filename_out,$process_time, $action)
    {
        $empname       =  Yii::app()->session['empname'];
        $empmail     = Yii::app()->session['empemail'];
        $mailbody = "Hi $empmail!";
        $to       = "$empname<$empmail>";
        $subject='Agent Creation Upload Process Status ['.$process_time . " - " . date("F j, Y, g:i a") ."]";
        $mailbody .= "\n Please find the attached excel file for complete status of Agent Creation Upload for $action operation\n\n";

        $uid     = md5(uniqid(time()));
        $message = "";
        $header  = "From: Gladmin-Team <gladmin-team@indiamart.com>\r\n";

        $header .= "Reply-To: " . $to . "\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";

        $message .= "This is a multi-part message in MIME format.\r\n";
        $message .= "--" . $uid . "\r\n";
        $message .= "Content-type:text/plain; charset=iso-8859-1\r\n". $mailbody;
        $message .= "--" . $uid . "\r\n";
        $message .= "Content-Type: application/ms-excel; name=\"" . $filename_out . "\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "Content-Disposition: attachment; filename=\"" . $filename_out . "\"\r\n\r\n";
        $message .= $content . "\r\n\r\n";
        $message .= "--" . $uid . "--";

        if (mail($to, $subject,$message, $header));
        else
            echo "mail send ... ERROR!";
    }

    

   
 function saveagentdata($serv_model,$leapempId,$vendorName,$vendor_id,$empLevel,$skillLevel){
    $emp_id=Yii::app()->session['empid'];
    $serv_model =new ServiceGlobalModelForm();
                     
                // Service Implementation WAPI
			$param['token']	='imobile1@15061981';
			$param['modid']	='GLADMIN';
			$param['action']	='Insert';
			$param['ETO_LEAP_EMP_ID']=$leapempId;
			$param['ETO_LEAP_VENDOR_NAME']	=$vendorName;
			$param['ETO_LEAP_EMP_LEVEL']	=$empLevel;
			$param['SHIFT_TIME']='0-0';
                        $param['ETO_LEAP_EMP_SKILL_LEVEL']=$skillLevel; 
			$param['VENDOR_EMPLOYEE_ID']	='';
			$param['FK_ETO_LEAP_VENDOR_ID']	=$vendor_id;
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
                            $msg= "Agent added successfully";  
                        }else{
                            $msg = $message;	
                        }  
                        return $msg;
        
         }
}