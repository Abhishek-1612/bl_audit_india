<?php 
error_reporting(0); 
class Bulkbigbuyer_upload extends CFormModel{
public $host_name;
  function __construct() 
   {
        $this->host_name = $_SERVER['SERVER_NAME'];
    }
   
    public function Managebigbuyerorg($empid,$dbh_mesh,$excel_row,$action){
        $status='Error in query execution';
       
        if($action =='MGR_ADD'){
                try 
                {
                $IIL_BIG_BUYER_ORG_ID=   '';
                $IIL_BIG_BUYER_ORG_NAME=   preg_replace("/\'/","''",$excel_row['IIL_BIG_BUYER_ORG_NAME']);          
                $IIL_BIG_BUYER_ORG_ABBR=   preg_replace("/\'/","''",$excel_row['IIL_BIG_BUYER_ORG_ABBR']);          
                $FK_GL_COUNTRY_ISO=   $excel_row['FK_GL_COUNTRY_ISO'];                 
                
                $IIL_BIG_BUYER_DATA_SOURCE=   $excel_row['IIL_BIG_BUYER_DATA_SOURCE'];        
                $IIL_BIG_BUYER_OPER_SECTOR=   $excel_row['IIL_BIG_BUYER_OPER_SECTOR'];        
                $IIL_BIG_BUYER_OPER_CAT=   $excel_row['IIL_BIG_BUYER_OPER_CAT'];            
                $IIL_BIG_BUYER_URL1=   $excel_row['IIL_BIG_BUYER_URL1'];                 
                $IIL_BIG_BUYER_URL2=   $excel_row['IIL_BIG_BUYER_URL2'];                 
                $IIL_BIG_BUYER_URL3=   $excel_row['IIL_BIG_BUYER_URL3'];                
                $IIL_BIG_BUYER_ORG_ALIAS=   $excel_row['IIL_BIG_BUYER_ORG_ALIAS'];
                $IIL_BIG_BUYER_REVENUE_BN_DLR=   $excel_row['IIL_BIG_BUYER_REVENUE_BN_DLR']; 
                $ENABLED_STATUS=   $excel_row['ENABLED_STATUS'];  
                $EMAIL_DOMAIN=   $excel_row['EMAIL_DOMAIN'];  

                if( $IIL_BIG_BUYER_REVENUE_BN_DLR==''){
                                    $sql_insert="INSERT INTO IIL_BIG_BUYER_ORG (
                                    IIL_BIG_BUYER_DATE,
                                    FK_UPDATED_BY_EMPID,
                                    IIL_BIG_BUYER_ORG_NAME,             
                                    IIL_BIG_BUYER_ORG_ABBR ,            
                                    FK_GL_COUNTRY_ISO,
                                    IIL_BIG_BUYER_REVENUE_BN_DLR,
                                    IIL_BIG_BUYER_DATA_SOURCE,          
                                    IIL_BIG_BUYER_OPER_SECTOR,          
                                    IIL_BIG_BUYER_OPER_CAT,
                                    IIL_BIG_BUYER_URL1,                 
                                    IIL_BIG_BUYER_URL2,                 
                                    IIL_BIG_BUYER_URL3,                 
                                    IIL_BIG_BUYER_ORG_ALIAS,
                                    ENABLED_STATUS,
                                    ENABLED_DATE,
                                    EMAIL_DOMAIN
                                )
                                VALUES (SYSDATE,
                                             $empid,           
                                            '$IIL_BIG_BUYER_ORG_NAME',             
                                            '$IIL_BIG_BUYER_ORG_ABBR',            
                                            '$FK_GL_COUNTRY_ISO',
                                             NULL,
                                            '$IIL_BIG_BUYER_DATA_SOURCE',          
                                            '$IIL_BIG_BUYER_OPER_SECTOR',          
                                            '$IIL_BIG_BUYER_OPER_CAT',
                                            '$IIL_BIG_BUYER_URL1',                 
                                            '$IIL_BIG_BUYER_URL2',                 
                                            '$IIL_BIG_BUYER_URL3',                 
                                            '$IIL_BIG_BUYER_ORG_ALIAS',
                                            '$ENABLED_STATUS',                 
                                             SYSDATE,                 
                                            '$EMAIL_DOMAIN'
                                )"; 


                }else{
                    
                     $sql_insert="INSERT INTO IIL_BIG_BUYER_ORG (
                    IIL_BIG_BUYER_DATE,
                    FK_UPDATED_BY_EMPID,
                    IIL_BIG_BUYER_ORG_NAME,             
                    IIL_BIG_BUYER_ORG_ABBR ,            
                    FK_GL_COUNTRY_ISO,
                    IIL_BIG_BUYER_REVENUE_BN_DLR,
                    IIL_BIG_BUYER_DATA_SOURCE,          
                    IIL_BIG_BUYER_OPER_SECTOR,          
                    IIL_BIG_BUYER_OPER_CAT,
                    IIL_BIG_BUYER_URL1,                 
                    IIL_BIG_BUYER_URL2,                 
                    IIL_BIG_BUYER_URL3,                 
                    IIL_BIG_BUYER_ORG_ALIAS,
                    ENABLED_STATUS,
                    ENABLED_DATE,
                    EMAIL_DOMAIN
                    )
                        VALUES (SYSDATE,
                                     $empid,           
                                    '$IIL_BIG_BUYER_ORG_NAME',             
                                    '$IIL_BIG_BUYER_ORG_ABBR',            
                                    '$FK_GL_COUNTRY_ISO',
                                     $IIL_BIG_BUYER_REVENUE_BN_DLR,
                                    '$IIL_BIG_BUYER_DATA_SOURCE',          
                                    '$IIL_BIG_BUYER_OPER_SECTOR',          
                                    '$IIL_BIG_BUYER_OPER_CAT',
                                    '$IIL_BIG_BUYER_URL1',                 
                                    '$IIL_BIG_BUYER_URL2',                 
                                    '$IIL_BIG_BUYER_URL3',                 
                                    '$IIL_BIG_BUYER_ORG_ALIAS',
                                    '$ENABLED_STATUS',                  
                                    SYSDATE,                 
                                    '$EMAIL_DOMAIN'
                        )"; 


                }
                $sth_insert=oci_parse($dbh_mesh,$sql_insert);
                
                    if(oci_execute($sth_insert)){                      
                        $status='success';
                    }else{
                        $e = oci_error($sth_insert);
                        $status='Error in query execution'.htmlentities($e['message']);
                    }
                } catch (Exception $e) 
                {echo $e->getMessage();
                        
                        Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);                        
                }

        }else if($action =='MGR_UPDATE'){
                try 
                {
                $IIL_BIG_BUYER_ORG_ID=   $excel_row['IIL_BIG_BUYER_ORG_ID'];
                $IIL_BIG_BUYER_ORG_NAME=   preg_replace("/\'/","''",$excel_row['IIL_BIG_BUYER_ORG_NAME']);          
                $IIL_BIG_BUYER_ORG_ABBR=   preg_replace("/\'/","''",$excel_row['IIL_BIG_BUYER_ORG_ABBR']);          
                $FK_GL_COUNTRY_ISO=   $excel_row['FK_GL_COUNTRY_ISO'];                 
                $IIL_BIG_BUYER_REVENUE_BN_DLR=   $excel_row['IIL_BIG_BUYER_REVENUE_BN_DLR'];     
                $IIL_BIG_BUYER_DATA_SOURCE=   $excel_row['IIL_BIG_BUYER_DATA_SOURCE'];        
                $IIL_BIG_BUYER_OPER_SECTOR=   $excel_row['IIL_BIG_BUYER_OPER_SECTOR'];        
                $IIL_BIG_BUYER_OPER_CAT=   $excel_row['IIL_BIG_BUYER_OPER_CAT'];            
                $IIL_BIG_BUYER_URL1=   $excel_row['IIL_BIG_BUYER_URL1'];                 
                $IIL_BIG_BUYER_URL2=   $excel_row['IIL_BIG_BUYER_URL2'];                 
                $IIL_BIG_BUYER_URL3=   $excel_row['IIL_BIG_BUYER_URL3'];                
                $IIL_BIG_BUYER_ORG_ALIAS=   $excel_row['IIL_BIG_BUYER_ORG_ALIAS'];
                $ENABLED_STATUS=   $excel_row['ENABLED_STATUS'];
                $EMAIL_DOMAIN=   $excel_row['EMAIL_DOMAIN'];

                if( $IIL_BIG_BUYER_REVENUE_BN_DLR==''){
                     $sql_update="UPDATE IIL_BIG_BUYER_ORG SET 
                        IIL_BIG_BUYER_MODIFIED_DATE = sysdate,
                        FK_UPDATED_BY_EMPID=$empid,
                        IIL_BIG_BUYER_ORG_NAME='$IIL_BIG_BUYER_ORG_NAME',             
                        IIL_BIG_BUYER_ORG_ABBR='$IIL_BIG_BUYER_ORG_ABBR' ,            
                        FK_GL_COUNTRY_ISO='$FK_GL_COUNTRY_ISO',
                        IIL_BIG_BUYER_REVENUE_BN_DLR=NULL,
                        IIL_BIG_BUYER_DATA_SOURCE='$IIL_BIG_BUYER_DATA_SOURCE',          
                        IIL_BIG_BUYER_OPER_SECTOR='$IIL_BIG_BUYER_OPER_SECTOR',          
                        IIL_BIG_BUYER_OPER_CAT='$IIL_BIG_BUYER_OPER_CAT',
                        IIL_BIG_BUYER_URL1='$IIL_BIG_BUYER_URL1',                
                        IIL_BIG_BUYER_URL2='$IIL_BIG_BUYER_URL2',                  
                        IIL_BIG_BUYER_URL3='$IIL_BIG_BUYER_URL3',                
                        IIL_BIG_BUYER_ORG_ALIAS='$IIL_BIG_BUYER_ORG_ALIAS',
                        ENABLED_STATUS='$ENABLED_STATUS',
                        EMAIL_DOMAIN='$EMAIL_DOMAIN' 
                    WHERE IIL_BIG_BUYER_ORG_ID = :IIL_BIG_BUYER_ORG_ID"; 
                }
                else{
                     $sql_update="UPDATE IIL_BIG_BUYER_ORG SET 
                    IIL_BIG_BUYER_MODIFIED_DATE = sysdate,
                    FK_UPDATED_BY_EMPID=$empid,
                    IIL_BIG_BUYER_ORG_NAME='$IIL_BIG_BUYER_ORG_NAME',             
                    IIL_BIG_BUYER_ORG_ABBR='$IIL_BIG_BUYER_ORG_ABBR' ,            
                    FK_GL_COUNTRY_ISO='$FK_GL_COUNTRY_ISO',
                    IIL_BIG_BUYER_REVENUE_BN_DLR=$IIL_BIG_BUYER_REVENUE_BN_DLR,
                    IIL_BIG_BUYER_DATA_SOURCE='$IIL_BIG_BUYER_DATA_SOURCE',          
                    IIL_BIG_BUYER_OPER_SECTOR='$IIL_BIG_BUYER_OPER_SECTOR',          
                    IIL_BIG_BUYER_OPER_CAT='$IIL_BIG_BUYER_OPER_CAT',
                    IIL_BIG_BUYER_URL1='$IIL_BIG_BUYER_URL1',                
                    IIL_BIG_BUYER_URL2='$IIL_BIG_BUYER_URL2',                  
                    IIL_BIG_BUYER_URL3='$IIL_BIG_BUYER_URL3',                
                    IIL_BIG_BUYER_ORG_ALIAS='$IIL_BIG_BUYER_ORG_ALIAS',
                    ENABLED_STATUS='$ENABLED_STATUS',
                    EMAIL_DOMAIN='$EMAIL_DOMAIN' 
                WHERE IIL_BIG_BUYER_ORG_ID = :IIL_BIG_BUYER_ORG_ID"; 
                }           
                $sth_update=oci_parse($dbh_mesh,$sql_update);
                oci_bind_by_name($sth_update, ':IIL_BIG_BUYER_ORG_ID', $IIL_BIG_BUYER_ORG_ID);  
                

                if(oci_execute($sth_update)){
                 
                    $num_update=oci_num_rows($sth_update);
                    
                    if($num_update > 0){
                        $status='success';
                        }else{
                        $status='No data found';
                        }
                 }else{
                        $e = oci_error($sth_update);
                        $status='Error in query execution'.htmlentities($e['message']);
                    }       
                } catch (Exception $e) 
                {echo $e->getMessage();
                        Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
                }

        }else if($action =='MGR_DELETE'){
                try 
                {
                $IIL_BIG_BUYER_ORG_ID=   $excel_row['IIL_BIG_BUYER_ORG_ID'];   
                if($IIL_BIG_BUYER_ORG_ID > 0){  
                $sql_delete="DELETE FROM IIL_BIG_BUYER_ORG WHERE IIL_BIG_BUYER_ORG_ID =:IIL_BIG_BUYER_ORG_ID"; 
                $sth_delete=oci_parse($dbh_mesh,$sql_delete);
                 oci_bind_by_name($sth_delete, ':IIL_BIG_BUYER_ORG_ID', $IIL_BIG_BUYER_ORG_ID);   
                    if(oci_execute($sth_delete)){    
                            $num_delete=oci_num_rows($sth_delete);
                            if($num_delete > 0){
                               $status='success';
                           }else{
                               $status='No data found';
                           }
                     }else{
                        $e = oci_error($sth_delete);
                        $status='Error in query execution'.htmlentities($e['message']);
                    } 
                }      
                } catch (Exception $e) 
                {echo $e->getMessage();
                        Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
                }

        }
        return $status;
}

public function mailsent($content,$filename_out,$process_time,$action)
	{
		$empname       =  Yii::app()->session['empname'];
		$empmail     = Yii::app()->session['empemail'];
		$subject='';
		$body = "Hi $empname !";
		$to       = "$empname<$empmail>";
		   if($action=='MGR_ADD'){
                    $subject='Bigbuyer Bulk Creation Status Report ['.$process_time . " END TIME : " . date("F j, Y, g:i a") .")";                        
                    $body     = "Please find the attached excel file for complete status of Bulk Bigbuyer Creation\n\n";   
                }else if($action=='MGR_UPDATE'){
                    $subject='Bigbuyer Bulk Update Status Report ['.$process_time . " END TIME : " . date("F j, Y, g:i a") .")";                        
                    $body     = "Please find the attached excel file for complete status of Bulk Bigbuyer Update\n\n";   
                }else if($action=='MGR_DELETE'){
                    $subject='Bigbuyer Bulk Delete Status Report ['.$process_time . " END TIME : " . date("F j, Y, g:i a") .")";                        
                    $body     = "Please find the attached excel file for complete status of Bulk Bigbuyer Delete\n\n";    
                 }else if($action=='MGR_ADDEMAILDOMAIN'){
                    $subject='Add Email Domains Bulk Update Status Report ['.$process_time . " END TIME : " . date("F j, Y, g:i a") .")";                        
                    $body     = "Please find the attached excel file for complete status of Bulk Add Email Domains\n\n";  
                }else if($action=='MGR_MERGE'){
                    $subject='Bigbuyer Bulk Merge Status Report ['.$process_time . " END TIME : " . date("F j, Y, g:i a") .")";                        
                    $body     = "Please find the attached excel file for complete status of Bulk Bigbuyer Merge\n\n";  
                }else if($action=='MGR_UPDATEUSERS'){
                    $subject='Update Big Buyer Users Status Report ['.$process_time . " END TIME : " . date("F j, Y, g:i a") .")";                        
                    $body     = "Please find the attached excel file for complete status of Update Big Buyer Users\n\n";  
                }
                 
		$uid     = md5(uniqid(time()));
		$message = "";
		$header  = "From: Gladmin-Team <gladmin-team@indiamart.com>\r\n";
		$header .= "Reply-To: " . $to . "\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
		$message .= "This is a multi-part message in MIME format.\r\n";
		$message .= "--" . $uid . "\r\n";
		$message .= "Content-type:text/plain; charset=iso-8859-1\r\n". $body;
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
        
public function show_html_mgr($cookie_mid, $js_file) {

$head='';
if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'addemaildomain') { 
    $head='Add Email Domain';
    $action='addemaildomain';
}else if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'merge') { 
    $head='Merge  Big-Buyer organization';
    $action='merge';
}else if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'updateusers') { 
    $head='Update Big Buyer Users';
    $action='updateusers';
}else if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'update') { 
    $head='Update Bulk Bigbuyer';
    $action='update';
}else if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'delete') { 
    $head='Delete Bulk Bigbuyer';
    $action='delete';
}else{ 
    $head='Create Bulk Bigbuyer';
    $action='add';
}

        print <<<ae
    <html>
        <head><title>Bulk Big-Buyer organization Creation</title>
    <LINK HREF="$js_file/css/report.css" REL="STYLESHEET" TYPE="text/css">
    <style type="text/css"> 
        table td {font-size:12px;background-color:#F0F9FF;} 
        .bg { background-color:#F0F9FF;} 
        select {  width: 180px;  background-color: #ffffff;}
    </style>   
    <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script language="javascript" src="/protected/js/bulk_bb_mgr.js"></script>
    </head>
    <body>
        <form name="Search" method="post" enctype="multipart/form-data" action="/index.php?r=admin_bl/Bigbuyer/Bulkmgr&act=$action&mid=$cookie_mid">
            <input type="hidden" name="mid" value="$cookie_mid">
            <table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0">
                <TR>
                    <TD colspan="2" align="center" style="background-color:#006DCC;color:#fff">
                        <B><FONT SIZE = "2px">$head</FONT></B>
                    </TD>
                </tr>
                <tr>
                    <TD bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 12px; line-height:2px;" width="15%">
                        <B>Upload Excel:</B>
                    </TD>
                    <TD bgcolor="#F0F9FF" style="line-height:2px;" width="30%">
                        <input type="FILE" name="S_attachment" value="" >
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
    </table><br> 
jk;
echo '<table width=100%><tr>
<td width=50%>
<div style="float:left"><B><a href="/index.php?r=admin_bl/Bigbuyer/Bulkmgr&act=add&mid='.$cookie_mid.'">Add Big-Buyer organization</a></B></div><br/>                      
<div style="float:left"><B><a href="/index.php?r=admin_bl/Bigbuyer/Bulkmgr&act=update&mid='.$cookie_mid.'">Update Big-Buyer organization</a></B></div><br/>
<div style="float:left"><B><a href="/index.php?r=admin_bl/Bigbuyer/Bulkmgr&act=delete&mid='.$cookie_mid.'">Delete Big-Buyer organization</a></B></div><br/>
<div style="float:left"><B><a href="/index.php?r=admin_bl/Bigbuyer/Bulkmgr&act=merge&mid='.$cookie_mid.'">Merge Big-Buyer organization</a></B></div><br/><br/>

<div style="float:left"><B><a href="/index.php?r=admin_bl/Bigbuyer/Bulkmgr&act=addemaildomain&mid='.$cookie_mid.'">Add Email Domains</a></B></div><br/>
<div style="float:left"><B><a href="/index.php?r=admin_bl/Bigbuyer/Bulkmgr&act=updateusers&mid='.$cookie_mid.'">Update Big Buyer Users</a></B></div><br/>

</td>
<td width=50%>
<div style="float:left"><B><a href="/protected/modules/admin_bl/samplefile/bb_creation_format.xls">Download Sample Excel of Bulk Bigbuyer Addition</a></B></div><br/>
<div style="float:left"><B><a href="/protected/modules/admin_bl/samplefile/bb_update_format.xls">Download Sample Excel of Bulk Bigbuyer Update</a></B></div><br/>
<div style="float:left"><B><a href="/protected/modules/admin_bl/samplefile/bb_delete_format.xls">Download Sample Excel of Bulk Bigbuyer Delete</a></B></div><br/>
<div style="float:left"><B><a href="/protected/modules/admin_bl/samplefile/bb_merge_format.xls">Download Sample Excel of Merge Big-Buyer organization</a></B></div><br/><br/>

<div style="float:left"><B><a href="/protected/modules/admin_bl/samplefile/bb_addemaildomain_format.xls">Download Sample Excel of Add Email Domains</a></B></div><br/>
<div style="float:left"><B><a href="/temp_sample/admin_bl/bb_updateusers_format.xls">Download Sample Excel of Update Big Buyer Users</a></B></div><br/>
</td>
</tr>
    </table>';
}

public function upload_mgr($empid,$cookie_mid) {
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
        $date             = substr($time['month'], 0, 3) . "-" . $time['mday'] . "-" . $time['year'];
        $file_name        = $file_name_upload;      
       
       
        $file_name        = basename($file_name);
        $file_name        = preg_replace("/\s+/", '_', $file_name);
        $file_name        = preg_replace("/.xls/", '', $file_name);
        $file_name .= "_";
        $file_name .= $date;
        $file_name .= "(" . (floor((mt_rand() / mt_getrandmax()) * 10000000)) . ")";
        $file_name .= "-" . $empid;
        $file_name .= ".xls";
        $split_empid  = '';
        $split_empid1 = '';
        $html         = '';
        $i            = 0;
        $arr          = explode("-", $file_name);
        $arr1         = array();
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
                $arr1 = explode("-", $file);
                foreach ($arr1 as $_) {
                    preg_match("/(.*).xls/", $_, $match);
                    if ($match) {
                        $temp         = explode('.', $_);
                        $split_empid1 = $temp[0];
                    }
                }
                
                if ($split_empid1 == $split_empid) {
                    $tr .= <<<ll
<TR><TD align="right" bgcolor="#F0F9FF"><b><font size= "2" color="black" >$file</font>
<img src="/temp_sample/trash.gif" border="0" onclick = "return remove_file('$file','excel','$action','$cookie_mid','mgr');"><input type="hidden" name="excel" value="$file"></b>
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
                if (!file_exists($folder)) {
                    $html .= " : Folder don't exist.";
                } elseif (!is_writable($folder)) {
                    $html .= " : Folder not writable.";
                } elseif (!is_writable($uploadfile)) {
                    $html .= " : File not writable.";
                }
                $file_name = '';
            } else {
                if (!$_FILES[$file_id]['size']) {
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
<script language="JavaScript" type="text/javascript"> document.getElementById('disable').disabled=true;
            document.getElementById('Upload').disabled=true;</script>
gh;
        }
        if ($i == 1) {
            $excelfile = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$file_name"; 
            Yii::import('ext.phpexcelreader.JPhpExcelReader');
            $data          = new JPhpExcelReader($excelfile);           
            $row           = 0;           
            $heading_error = '';




if($action=='merge'){
    $heading_hash  = array(
        'TARGET_ORG_ID' => '',
        'SOURCE_ORG_ID' => '',                        
    );
    if (isset($data->sheets[0]['cells'][1][1])) {
        $heading_hash['TARGET_ORG_ID'] = $data->sheets[0]['cells'][1][1];
    }
    if (isset($data->sheets[0]['cells'][1][2])) {
        $heading_hash['SOURCE_ORG_ID'] = $data->sheets[0]['cells'][1][2];
    }
    
        if ($heading_hash['TARGET_ORG_ID'] != 'TARGET_ORG_ID') {
            $heading_error .= "<BR>Column - A should be TARGET_ORG_ID";
        }
        if ($heading_hash['SOURCE_ORG_ID'] != 'SOURCE_ORG_ID') {
            $heading_error .= "<BR>Column - B should be SOURCE_ORG_ID";
        }
        
}
elseif($action=='updateusers'){
            $heading_hash  = array(                             
                'FK_GLUSR_USR_ID' =>'',
                'ENABLED_STATUS' => ''
            );            
            if (isset($data->sheets[0]['cells'][1][1])) {
                $heading_hash['FK_GLUSR_USR_ID'] = $data->sheets[0]['cells'][1][1];
            }
            if (isset($data->sheets[0]['cells'][1][2])) {
                $heading_hash['ENABLED_STATUS'] = $data->sheets[0]['cells'][1][2];
            }
           
            if ($heading_hash['FK_GLUSR_USR_ID'] != 'FK_GLUSR_USR_ID') {
                $heading_error .= "<BR>Column - A should be FK_GLUSR_USR_ID";
            }
            if ($heading_hash['ENABLED_STATUS'] != 'ENABLED_STATUS') {
                $heading_error .= "<BR>Column - B should be ENABLED_STATUS";
            }

}
elseif($action=='addemaildomain'){ 
    $heading_hash  = array(
        'IIL_BIG_BUYER_EMAIL_DOMAIN' => '',
        'ENABLED_STATUS' => '',                        
    );
    if (isset($data->sheets[0]['cells'][1][1])) {
        $heading_hash['IIL_BIG_BUYER_EMAIL_DOMAIN'] = $data->sheets[0]['cells'][1][1];
    }
    if (isset($data->sheets[0]['cells'][1][2])) {
        $heading_hash['ENABLED_STATUS'] = $data->sheets[0]['cells'][1][2];
    }
    
        if ($heading_hash['IIL_BIG_BUYER_EMAIL_DOMAIN'] != 'IIL_BIG_BUYER_EMAIL_DOMAIN') {
            $heading_error .= "<BR>Column - A should be IIL_BIG_BUYER_EMAIL_DOMAIN";
        }
        if ($heading_hash['ENABLED_STATUS'] != 'ENABLED_STATUS') {
            $heading_error .= "<BR>Column - B should be ENABLED_STATUS";
        }
}
elseif (($action == 'add') || ($action == 'update')) 
     {   

            $heading_hash  = array(
                'IIL_BIG_BUYER_ORG_ID' => '',
                'IIL_BIG_BUYER_ORG_NAME' => '',
                'IIL_BIG_BUYER_ORG_ABBR' => '',
                'FK_GL_COUNTRY_ISO' => '',
                'IIL_BIG_BUYER_REVENUE_BN_DLR' => '',
                'IIL_BIG_BUYER_DATA_SOURCE' => '',
                'IIL_BIG_BUYER_OPER_SECTOR' => '',
                'IIL_BIG_BUYER_OPER_CAT' => '',               
                'IIL_BIG_BUYER_URL1' => '',
                'IIL_BIG_BUYER_URL2' => '',
                'IIL_BIG_BUYER_URL3' => '',
                'IIL_BIG_BUYER_ORG_ALIAS' => '',
                'ENABLED_STATUS'=>'',
                'EMAIL_DOMAIN'=>'',
            );
            if (isset($data->sheets[0]['cells'][1][1])) {
                $heading_hash['IIL_BIG_BUYER_ORG_ID'] = $data->sheets[0]['cells'][1][1];
            }
            if (isset($data->sheets[0]['cells'][1][2])) {
                $heading_hash['IIL_BIG_BUYER_ORG_NAME'] = $data->sheets[0]['cells'][1][2];
            }
            if (isset($data->sheets[0]['cells'][1][3])) {
                $heading_hash['IIL_BIG_BUYER_ORG_ABBR'] = $data->sheets[0]['cells'][1][3];
            }
            if (isset($data->sheets[0]['cells'][1][4])) {
                $heading_hash['FK_GL_COUNTRY_ISO'] = $data->sheets[0]['cells'][1][4];
            }
            if (isset($data->sheets[0]['cells'][1][5])) {
                $heading_hash['IIL_BIG_BUYER_REVENUE_BN_DLR'] = $data->sheets[0]['cells'][1][5];
            }
            if (isset($data->sheets[0]['cells'][1][6])) {
                $heading_hash['IIL_BIG_BUYER_DATA_SOURCE'] = $data->sheets[0]['cells'][1][6];
            }
            if (isset($data->sheets[0]['cells'][1][7])) {
                $heading_hash['IIL_BIG_BUYER_OPER_SECTOR'] = $data->sheets[0]['cells'][1][7];
            }
            if (isset($data->sheets[0]['cells'][1][8])) {
                $heading_hash['IIL_BIG_BUYER_OPER_CAT'] = $data->sheets[0]['cells'][1][8];
            }
            
            if (isset($data->sheets[0]['cells'][1][9])) {
                $heading_hash['IIL_BIG_BUYER_URL1'] = $data->sheets[0]['cells'][1][9];
            }
            if (isset($data->sheets[0]['cells'][1][10])) {
                $heading_hash['IIL_BIG_BUYER_URL2'] = $data->sheets[0]['cells'][1][10];
            }
            if (isset($data->sheets[0]['cells'][1][11])) {
                $heading_hash['IIL_BIG_BUYER_URL3'] = $data->sheets[0]['cells'][1][11];
            }
            if (isset($data->sheets[0]['cells'][1][12])) {
                $heading_hash['IIL_BIG_BUYER_ORG_ALIAS'] = $data->sheets[0]['cells'][1][12];
            }            
            if (isset($data->sheets[0]['cells'][1][13])) {
                $heading_hash['ENABLED_STATUS'] = $data->sheets[0]['cells'][1][13];
            }
             if (isset($data->sheets[0]['cells'][1][14])) {
                $heading_hash['EMAIL_DOMAIN'] = $data->sheets[0]['cells'][1][14];
            }
            
            if ($heading_hash['IIL_BIG_BUYER_ORG_ID'] != 'IIL_BIG_BUYER_ORG_ID') {
                $heading_error .= "<BR>Column - A should be IIL_BIG_BUYER_ORG_ID";
            }
            if ($heading_hash['IIL_BIG_BUYER_ORG_NAME'] != 'IIL_BIG_BUYER_ORG_NAME') {
                $heading_error .= "<BR>Column - B should be IIL_BIG_BUYER_ORG_NAME";
            }
            if ($heading_hash['IIL_BIG_BUYER_ORG_ABBR'] != 'IIL_BIG_BUYER_ORG_ABBR') {
                $heading_error .= "<BR>Column - C should be IIL_BIG_BUYER_ORG_ABBR";
            }
            if ($heading_hash['FK_GL_COUNTRY_ISO'] != 'FK_GL_COUNTRY_ISO') {
                $heading_error .= "<BR>Column - D should be FK_GL_COUNTRY_ISO";
            }
            if ($heading_hash['IIL_BIG_BUYER_REVENUE_BN_DLR'] != 'IIL_BIG_BUYER_REVENUE_BN_DLR') {
                $heading_error .= "<BR>Column - E should be IIL_BIG_BUYER_REVENUE_BN_DLR";
            }
            if ($heading_hash['IIL_BIG_BUYER_DATA_SOURCE'] != 'IIL_BIG_BUYER_DATA_SOURCE') {
                $heading_error .= "<BR>Column - F should be IIL_BIG_BUYER_DATA_SOURCE";
            }
            if ($heading_hash['IIL_BIG_BUYER_OPER_SECTOR'] != 'IIL_BIG_BUYER_OPER_SECTOR') {
                $heading_error .= "<BR>Column - G should be IIL_BIG_BUYER_OPER_SECTOR";
            }
            if ($heading_hash['IIL_BIG_BUYER_OPER_CAT'] != 'IIL_BIG_BUYER_OPER_CAT') {
                $heading_error .= "<BR>Column - H should be IIL_BIG_BUYER_OPER_CAT";
            }
           
            if ($heading_hash['IIL_BIG_BUYER_URL1'] != 'IIL_BIG_BUYER_URL1') {
                $heading_error .= "<BR>Column - I should be IIL_BIG_BUYER_URL1";
            }
            if ($heading_hash['IIL_BIG_BUYER_URL2'] != 'IIL_BIG_BUYER_URL2') {
                $heading_error .= "<BR>Column - J should be IIL_BIG_BUYER_URL2";
            }
            if ($heading_hash['IIL_BIG_BUYER_URL3'] != 'IIL_BIG_BUYER_URL3') {
                $heading_error .= "<BR>Column - K should be IIL_BIG_BUYER_URL3";
            }
            if ($heading_hash['IIL_BIG_BUYER_ORG_ALIAS'] != 'IIL_BIG_BUYER_ORG_ALIAS') {
                $heading_error .= "<BR>Column - L should be IIL_BIG_BUYER_ORG_ALIAS";
            }
            if ($heading_hash['ENABLED_STATUS'] != 'ENABLED_STATUS') {
                $heading_error .= "<BR>Column - M should be ENABLED_STATUS";
            }
             if ($heading_hash['EMAIL_DOMAIN'] != 'EMAIL_DOMAIN') {
                $heading_error .= "<BR>Column - N should be EMAIL_DOMAIN";
            }
}
else if ($action == 'delete') { 
            $heading_hash  = array('IIL_BIG_BUYER_ORG_ID' => '');
            if (isset($data->sheets[0]['cells'][1][1])) {
                $heading_hash['IIL_BIG_BUYER_ORG_ID'] = $data->sheets[0]['cells'][1][1];
            }
            if ($heading_hash['IIL_BIG_BUYER_ORG_ID'] != 'IIL_BIG_BUYER_ORG_ID') {
                $heading_error .= "<BR>Column - A should be IIL_BIG_BUYER_ORG_ID";
            }
}


         if ($heading_error) {
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
            } else {
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
    }

public function Process_mgr($empid,$excel_data, $cookie_mid, $user_del, $user_download, $uploaded_filename, $process_time) {
$finaldata  = array();      
        $tr         = 1;       
        $j = 0;
        print '<div id="processing"></div>';
        if ($excel_data == 'excel') {
            $DIR = opendir("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/");
            while (false !== ($file1 = readdir($DIR))) {
                $file_name   = '';
                $upload_path = '';
                $tr          = 1;               
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
                    if ($user_del || 1) {
                        print <<<mk
<INPUT type="image" name="search_file" src="/temp_sample/trash.gif" border="0" onclick = "return remove('$uploaded_filename','excel');"><input type="hidden" name="excel" value="$uploaded_filename"></b>
mk;
                    }
                    print "</TD></tr></table>";
                    $j++;
                }
            }           
        }
      
        
        if ($excel_data == 'excel_data') {

            if (isset($_REQUEST['act'])) { 
                $action='MGR_'.strtoupper($_REQUEST['act']);
            }

             $glEtoModel = new AdminEtoModelForm();        
             $dbh_mesh    = $glEtoModel->connectMeshDb();
            

            $DIR       = opendir("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/");
            $cntry_iso = '';
            while (false !== ($file1 = readdir($DIR))) {
                preg_match("/.xls/", $file1, $match);
                if ($match) {
                    $arr1 = explode("-", $file1);
                    foreach ($arr1 as $_) {
                        preg_match("/(.*).xls/", $_, $match);
                        if ($match) {
                            $temp         = explode('.', $_);
                            $split_empid1 = $temp[0];
                        }
                    }
                    $file_name   = '';
                    $upload_path = '';
                     if ($split_empid1 == $empid) {
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
                        $excel=$data->sheets[0];
                       
                        if ($total_rows > 500) {
                            print <<<jh
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF">Record Limit Exceed !! Only 500 Records Are Allowed. You Have Entered <b>$total_rows</b> Records. Re-Upload Excel The File and Try Again.</TD></TR><TABLE>
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
                                        
                        $row            = 1;                        
                        $filename_out      = $upload_path ."mgr_bulk_".$action.".xls";               
                        $BBFILE       = fopen($filename_out, "w");
                        if ($BBFILE === FALSE)
                            $remark = "Cannot open file [$filename_out] for writing";

                       if($action=='MGR_MERGE'){ 
                            if (fwrite($BBFILE, "TARGET_ORG_ID\t SOURCE_ORG_ID\t REMARK\t \n") === FALSE)
                            $remark = "Cannot write to file [$filename_out]";
                        }elseif($action=='MGR_ADDEMAILDOMAIN'){ 
                            if (fwrite($BBFILE, "IIL_BIG_BUYER_EMAIL_DOMAIN\t ENABLED_STATUS\t REMARK\t \n") === FALSE)
                            $remark = "Cannot write to file [$filename_out]";
                        }elseif($action=='MGR_UPDATEUSERS'){ 
                            if (fwrite($BBFILE, "FK_GLUSR_USR_ID\t ENABLED_STATUS\t REMARK\t \n") === FALSE)
                            $remark = "Cannot write to file [$filename_out]";
                        }elseif($action =='MGR_ADD' || $action=='MGR_UPDATE'){
                            if (fwrite($BBFILE, "IIL_BIG_BUYER_ORG_ID\t IIL_BIG_BUYER_ORG_NAME\t IIL_BIG_BUYER_ORG_ABBR\t FK_GL_COUNTRY_ISO\t IIL_BIG_BUYER_REVENUE_BN_DLR\t IIL_BIG_BUYER_DATA_SOURCE\t IIL_BIG_BUYER_OPER_SECTOR\t IIL_BIG_BUYER_OPER_CAT\t IIL_BIG_BUYER_URL1\t IIL_BIG_BUYER_URL2\t IIL_BIG_BUYER_URL3\t IIL_BIG_BUYER_ORG_ALIAS\t ENABLED_STATUS\t EMAIL_DOMAIN\t REMARK\t \n") === FALSE)
                                $remark = "Cannot write to file [$filename_out]";
                        }else if($action =='MGR_DELETE'){
                            if (fwrite($BBFILE, "IIL_BIG_BUYER_ORG_ID\t REMARK\t \n") === FALSE)
                                $remark = "Cannot write to file [$filename_out]";
                        }
                        $process_flag = 0;
                        foreach (range(2, $total_rows) as $i) {                            
                            $excel_row=array();
                            $finalmsg='';$iserror_id = 1;$iserror_dlr = 1;
                            if($action=='MGR_ADDEMAILDOMAIN'){ 
                                $iserror_domain = 1;$iserror_status = 1;                               
                                $excel_row['IIL_BIG_BUYER_EMAIL_DOMAIN']='';
                                $excel_row['ENABLED_STATUS']='';   
                               
                                if (isset($data->sheets[0]['cells'][$i][1])) {                                  
                                    $excel_row['IIL_BIG_BUYER_EMAIL_DOMAIN']=$data->sheets[0]['cells'][$i][1];
                                    $iserror_domain= 0;                                     
                                }
                                if (isset($data->sheets[0]['cells'][$i][2])) {
                                    $status = isset($excel['cellsInfo'][$i][2]['raw']) ? $excel['cellsInfo'][$i][2]['raw'] : '';
                                   if ($status == '' || is_numeric($status)) {
                                            $excel_row['ENABLED_STATUS']=$status;
                                            $iserror_status= 0;
                                     } 
                                }
                                if($iserror_domain == 0 && $iserror_status == 0){
                                       $finalmsg=$this->manage_addemaildomain($action,$dbh_mesh,$excel_row);                          
                                }else{
                                    $finalmsg="Error in Data format";
                                }
                                
                                $IIL_BIG_BUYER_EMAIL_DOMAIN=   "\"" . $excel_row['IIL_BIG_BUYER_EMAIL_DOMAIN']. "\"";          
                                $ENABLED_STATUS=   "\"" . $excel_row['ENABLED_STATUS']. "\"";
                                $REMARK=   "\"" . $finalmsg. "\"";   
                                if($finalmsg=='success'){                                                         
                                    $process_flag = 1;
                                }
                                   if (fwrite($BBFILE, "$IIL_BIG_BUYER_EMAIL_DOMAIN\t $ENABLED_STATUS\t $REMARK\t \n") === FALSE)
                                    $remark = "Cannot write to file [$filename_out]";
                            }else if($action=='MGR_MERGE'){
                                $iserror_tid = 1;$iserror_sid = 1;
                                $excel_row['TARGET_ORG_ID']=''; 
                                $excel_row['SOURCE_ORG_ID']='';   
                                if (isset($data->sheets[0]['cells'][$i][1])) {
                                    $target_org_id= isset($excel['cellsInfo'][$i][1]['raw']) ? $excel['cellsInfo'][$i][1]['raw'] : '';
                                     if (is_numeric($target_org_id)) {
                                            $excel_row['TARGET_ORG_ID']=$target_org_id;
                                            $iserror_tid= 0;
                                     }                                 
                                }
                                if (isset($data->sheets[0]['cells'][$i][2])) {
                                    $source_org_id= isset($excel['cellsInfo'][$i][2]['raw']) ? $excel['cellsInfo'][$i][2]['raw'] : '';
                                   if (is_numeric($source_org_id)) {
                                            $excel_row['SOURCE_ORG_ID']=$source_org_id;
                                            $iserror_sid= 0;
                                     } 
                                }
                                if($excel_row['TARGET_ORG_ID'] == '' || $excel_row['SOURCE_ORG_ID'] == '' || $excel_row['TARGET_ORG_ID'] == 0 || $excel_row['SOURCE_ORG_ID'] == 0){
                                        $finalmsg="Source and Target Org should be greater than Zero";
                                }else if($excel_row['TARGET_ORG_ID'] == $excel_row['SOURCE_ORG_ID']){
                                        $finalmsg="Source and Target Org should be different";
                                }else if($iserror_tid == 0 && $iserror_sid == 0){
                                       $finalmsg=$this->manage_mgr($action,$dbh_mesh,$excel_row);                         
                                }else{                                    
                                    $finalmsg="Error in Data format";
                                }
                                        $TARGET_ORG_ID=   "\"" . $excel_row['TARGET_ORG_ID']. "\"";
                                        $SOURCE_ORG_ID=   "\"" . $excel_row['SOURCE_ORG_ID']. "\"";          

                                        $REMARK=   "\"" . $finalmsg. "\"";   
                                if($finalmsg=='success'){                                                         
                                    $process_flag = 1;
                                }
                                   if (fwrite($BBFILE, "$TARGET_ORG_ID\t $SOURCE_ORG_ID\t $REMARK\t \n") === FALSE)
                                    $remark = "Cannot write to file [$filename_out]";
                            }else if($action=='MGR_UPDATEUSERS'){
                                $iserror_oid = 1;$iserror_d = 1;
                                $excel_row['FK_GLUSR_USR_ID']=$excel_row['ENABLED_STATUS']='';   
                                if (isset($data->sheets[0]['cells'][$i][1])) {
                                    $gl_id= isset($excel['cellsInfo'][$i][1]['raw']) ? $excel['cellsInfo'][$i][1]['raw'] : '';
                                     if (is_numeric($gl_id)) {
                                            $excel_row['FK_GLUSR_USR_ID']=$gl_id;
                                            $iserror_oid= 0;
                                     }                                 
                                }  
                                if (isset($data->sheets[0]['cells'][$i][2])) {
                                    $status= isset($excel['cellsInfo'][$i][2]['raw']) ? $excel['cellsInfo'][$i][2]['raw'] : '';
                                     if (trim($status) != '') {
                                            $excel_row['ENABLED_STATUS']=$status;
                                            $iserror_did= 0;
                                     }                                 
                                }
                                if($iserror_oid == 0 && $iserror_did == 0){
                                       $finalmsg=$this->manage_mgr($action,$dbh_mesh,$excel_row);                    
                                }else{                                    
                                    $finalmsg="Error in Data format";
                                }
                                        $FK_GLUSR_USR_ID=   "\"" . $excel_row['FK_GLUSR_USR_ID']. "\"";
                                        $ENABLED_STATUS=   "\"" . $excel_row['ENABLED_STATUS']. "\"";          

                                        $REMARK=   "\"" . $finalmsg. "\"";   
                                if($finalmsg=='success'){                                                         
                                    $process_flag = 1;
                                }
                                   if (fwrite($BBFILE, "$FK_GLUSR_USR_ID\t $ENABLED_STATUS\t $REMARK\t \n") === FALSE)
                                    $remark = "Cannot write to file [$filename_out]";
                            }else if($action =='MGR_ADD' || $action=='MGR_UPDATE'){
                            $excel_row['IIL_BIG_BUYER_ORG_ID']=""; 
                            $excel_row['IIL_BIG_BUYER_ORG_NAME']="";          
                            $excel_row['IIL_BIG_BUYER_ORG_ABBR']="";          
                            $excel_row['FK_GL_COUNTRY_ISO'] ="";                 
                            $excel_row['IIL_BIG_BUYER_REVENUE_BN_DLR']='';     
                            $excel_row['IIL_BIG_BUYER_DATA_SOURCE']="";        
                            $excel_row['IIL_BIG_BUYER_OPER_SECTOR']="";        
                            $excel_row['IIL_BIG_BUYER_OPER_CAT']="";            
                            $excel_row['IIL_BIG_BUYER_URL1']="";                 
                            $excel_row['IIL_BIG_BUYER_URL2']="";                 
                            $excel_row['IIL_BIG_BUYER_URL3']="";               
                            $excel_row['IIL_BIG_BUYER_ORG_ALIAS']="";
                            $excel_row['ENABLED_STATUS']="";               
                            $excel_row['EMAIL_DOMAIN']="";
                            
                           if($action =='MGR_UPDATE'){
                            if (isset($data->sheets[0]['cells'][$i][1])) {
                                $id = isset($excel['cellsInfo'][$i][1]['raw']) ? $excel['cellsInfo'][$i][1]['raw'] : '';
                                 if (is_numeric($id)) {
                                        $excel_row['IIL_BIG_BUYER_ORG_ID']=$id;
                                        $iserror_id= 0;
                                 }                                 
                            }
                           }else{
                               $excel_row['IIL_BIG_BUYER_ORG_ID']='';$iserror_id= 0;
                           }
                            if (isset($data->sheets[0]['cells'][$i][2])) {
                               $excel_row['IIL_BIG_BUYER_ORG_NAME']=$data->sheets[0]['cells'][$i][2];
                            }
                            if (isset($data->sheets[0]['cells'][$i][3])) {
                               $excel_row['IIL_BIG_BUYER_ORG_ABBR']=$data->sheets[0]['cells'][$i][3];
                            }
                            if (isset($data->sheets[0]['cells'][$i][4])) {
                               $excel_row['FK_GL_COUNTRY_ISO']=$data->sheets[0]['cells'][$i][4];
                            } 
                            
                            if (isset($data->sheets[0]['cells'][$i][5])) {
                                $dlr =  isset($excel['cellsInfo'][$i][5]['raw']) ? $excel['cellsInfo'][$i][5]['raw'] : '';
                                if ($dlr == '' || is_numeric($dlr)) {
                                    $excel_row['IIL_BIG_BUYER_REVENUE_BN_DLR']=$dlr;
                                    $iserror_dlr= 0;
                                }
                            }else{
                                $iserror_dlr= 0;
                            }
                            if (isset($data->sheets[0]['cells'][$i][6])) {
                               $excel_row['IIL_BIG_BUYER_DATA_SOURCE']=$data->sheets[0]['cells'][$i][6];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][7])) {
                               $excel_row['IIL_BIG_BUYER_OPER_SECTOR']=$data->sheets[0]['cells'][$i][7];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][8])) {
                               $excel_row['IIL_BIG_BUYER_OPER_CAT']=isset($excel['cellsInfo'][$i][8]['raw']) ? $excel['cellsInfo'][$i][8]['raw'] : '';
                            } 
                            
                            if (isset($data->sheets[0]['cells'][$i][9])) {
                               $excel_row['IIL_BIG_BUYER_URL1']=$data->sheets[0]['cells'][$i][9];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][10])) {
                               $excel_row['IIL_BIG_BUYER_URL2']=$data->sheets[0]['cells'][$i][10];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][11])) {
                               $excel_row['IIL_BIG_BUYER_URL3']=$data->sheets[0]['cells'][$i][11];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][12])) {
                               $excel_row['IIL_BIG_BUYER_ORG_ALIAS']=$data->sheets[0]['cells'][$i][12];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][13])) {
                               $es = isset($excel['cellsInfo'][$i][13]['raw']) ? $excel['cellsInfo'][$i][13]['raw'] : '';
                               $excel_row['ENABLED_STATUS']=$es;
                            }
                            if (isset($data->sheets[0]['cells'][$i][14])) {
                               $excel_row['EMAIL_DOMAIN']=$data->sheets[0]['cells'][$i][14];
                            }
                            if($iserror_id == 0 && $iserror_dlr == 0){
                                   $finalmsg=$this->Managebigbuyerorg($empid,$dbh_mesh,$excel_row,$action);                           
                            }else{
                                $finalmsg="Error in Data format";
                            }
                                    $IIL_BIG_BUYER_ORG_ID=   "\"" . $excel_row['IIL_BIG_BUYER_ORG_ID']. "\"";
                                    $IIL_BIG_BUYER_ORG_NAME=   "\"" . $excel_row['IIL_BIG_BUYER_ORG_NAME']. "\"";          
                                    $IIL_BIG_BUYER_ORG_ABBR=   "\"" . $excel_row['IIL_BIG_BUYER_ORG_ABBR']. "\"";          
                                    $FK_GL_COUNTRY_ISO=   "\"" . $excel_row['FK_GL_COUNTRY_ISO']. "\"";                
                                    $IIL_BIG_BUYER_REVENUE_BN_DLR=   "\"" . $excel_row['IIL_BIG_BUYER_REVENUE_BN_DLR']. "\"";     
                                    $IIL_BIG_BUYER_DATA_SOURCE=   "\"" . $excel_row['IIL_BIG_BUYER_DATA_SOURCE']. "\"";       
                                    $IIL_BIG_BUYER_OPER_SECTOR=   "\"" . $excel_row['IIL_BIG_BUYER_OPER_SECTOR']. "\"";       
                                    $IIL_BIG_BUYER_OPER_CAT=   "\"" . $excel_row['IIL_BIG_BUYER_OPER_CAT']. "\"";            
                                    $IIL_BIG_BUYER_URL1=   "\"" . $excel_row['IIL_BIG_BUYER_URL1']. "\"";                
                                    $IIL_BIG_BUYER_URL2=   "\"" . $excel_row['IIL_BIG_BUYER_URL2']. "\"";                
                                    $IIL_BIG_BUYER_URL3=   "\"" . $excel_row['IIL_BIG_BUYER_URL3']. "\"";                
                                    $IIL_BIG_BUYER_ORG_ALIAS=   "\"" . $excel_row['IIL_BIG_BUYER_ORG_ALIAS']. "\"";                                                  
                                    $ENABLED_STATUS=   "\"" . $excel_row['ENABLED_STATUS']. "\"";
                                    $EMAIL_DOMAIN=   "\"" . $excel_row['EMAIL_DOMAIN']. "\"";  
                                    $REMARK=   "\"" . $finalmsg. "\"";  
                                    if($finalmsg=='success'){                                                         
                                        $process_flag = 1;
                                    }
                                    
                                       if (fwrite($BBFILE, "$IIL_BIG_BUYER_ORG_ID\t $IIL_BIG_BUYER_ORG_NAME\t $IIL_BIG_BUYER_ORG_ABBR\t $FK_GL_COUNTRY_ISO\t $IIL_BIG_BUYER_REVENUE_BN_DLR\t $IIL_BIG_BUYER_DATA_SOURCE\t $IIL_BIG_BUYER_OPER_SECTOR\t $IIL_BIG_BUYER_OPER_CAT\t $IIL_BIG_BUYER_URL1\t $IIL_BIG_BUYER_URL2\t $IIL_BIG_BUYER_URL3\t $IIL_BIG_BUYER_ORG_ALIAS\t $ENABLED_STATUS\t $EMAIL_DOMAIN\t $REMARK\t \n") === FALSE)
                                        $remark = "Cannot write to file [$filename_out]";


                        }
                        else if($action =='MGR_DELETE'){
                                    $excel_row['IIL_BIG_BUYER_ORG_ID']="";  
                                    if (isset($data->sheets[0]['cells'][$i][1])) {
                                        if (is_numeric($data->sheets[0]['cells'][$i][1])) {
                                               $excel_row['IIL_BIG_BUYER_ORG_ID']= isset($excel['cellsInfo'][$i][1]['raw']) ? $excel['cellsInfo'][$i][1]['raw'] : '';
                                               $iserror_id= 0;
                                        }                                 
                                    }

                                    if($iserror_id == 0){
                                           $finalmsg=$this->Managebigbuyerorg($empid,$dbh_mesh,$excel_row,$action);                           
                                    }else{
                                        $finalmsg="Error in Data format";
                                    }
                                    $IIL_BIG_BUYER_ORG_ID=   "\"" . $excel_row['IIL_BIG_BUYER_ORG_ID']. "\"";
                                    $REMARK=   "\"" . $finalmsg. "\"";

                                     if($finalmsg=='success'){                                                         
                                         $process_flag = 1;
                                     }
                                        if (fwrite($BBFILE, "$IIL_BIG_BUYER_ORG_ID\t $REMARK\t \n") === FALSE)
                                         $remark = "Cannot write to file [$filename_out]";
                        }
                            
                        }
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
                        $content   = fread($handle, $file_size);
                        fclose($handle);
                        $content = chunk_split(base64_encode($content));                       
                        $this->mailsent($content,$filename_out,$process_time,$action);                        
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
}

public function manage_mgr($action,$dbh_mesh,$excel_row)
    {
        $status='error';
        try 
	{        
 if($action=='MGR_UPDATEUSERS'){       
        $FK_GLUSR_USR_ID=   $excel_row['FK_GLUSR_USR_ID'];
        if($excel_row['ENABLED_STATUS'] !== ''){
             $ENABLED_STATUS=   $excel_row['ENABLED_STATUS'];
             $sql_update="UPDATE IIL_BIG_BUYER_TO_GLUSR SET ENABLED_STATUS=:ENABLED_STATUS WHERE  FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID ";
             $sth_mgr = oci_parse($dbh_mesh, $sql_update);            
            oci_bind_by_name($sth_mgr, ':ENABLED_STATUS', $ENABLED_STATUS);
            oci_bind_by_name($sth_mgr, ':FK_GLUSR_USR_ID', $FK_GLUSR_USR_ID);

        }  
}else if($action=='MGR_MERGE'){
        $IN_TARGET_ORG_ID=   $excel_row['TARGET_ORG_ID'];
        $IN_SOURCE_ORG_ID=   $excel_row['SOURCE_ORG_ID'];  

            $source_exist=0;
            $sourcesql = "SELECT count(1) CNT FROM IIL_BIG_BUYER_ORG WHERE IIL_BIG_BUYER_ORG_ID= :IN_SOURCE_ORG_ID";
	      $stid = oci_parse($dbh_mesh, $sourcesql);
	      oci_bind_by_name($stid, ':IN_SOURCE_ORG_ID', $IN_SOURCE_ORG_ID);
	      oci_execute($stid);
	      $rec = oci_fetch_assoc($stid);
	      if($rec){
                $source_exist = $rec['CNT'];
	      }
              if($source_exist == 0){
                    return $status='SOURCE ORG not found';
              }
              
              $target_exist=0;
              $targetsql = "SELECT count(1) CNT FROM IIL_BIG_BUYER_ORG WHERE IIL_BIG_BUYER_ORG_ID= :IN_TARGET_ORG_ID";
	      $targetstid = oci_parse($dbh_mesh, $targetsql);
	      oci_bind_by_name($targetstid, ':IN_TARGET_ORG_ID', $IN_TARGET_ORG_ID);
	      oci_execute($targetstid);
	      $target_rec = oci_fetch_assoc($targetstid);
	      if($target_rec){
                $target_exist = $target_rec['CNT'];
	      }
              if($target_exist == 0){
                    return $status='Target ORG not found';
              }



        $sql_merge_del="BEGIN 
        UPDATE IIL_BIG_BUYER_ORG_TO_EMAIL SET FK_IIL_BIG_BUYER_ORG_ID = :IN_TARGET_ORG_ID WHERE FK_IIL_BIG_BUYER_ORG_ID = :IN_SOURCE_ORG_ID; 
        INSERT INTO IIL_BIG_BUYER_TO_GLUSR(FK_IIL_BIG_BUYER_ORG_ID, FK_GLUSR_USR_ID, IIL_BIG_BUYER_R_MANAGER_ID)
	SELECT :IN_TARGET_ORG_ID FK_IIL_BIG_BUYER_ORG_ID, FK_GLUSR_USR_ID, IIL_BIG_BUYER_R_MANAGER_ID FROM IIL_BIG_BUYER_TO_GLUSR WHERE FK_IIL_BIG_BUYER_ORG_ID = :IN_SOURCE_ORG_ID;  
        DELETE FROM IIL_BIG_BUYER_TO_GLUSR WHERE FK_IIL_BIG_BUYER_ORG_ID = :IN_SOURCE_ORG_ID;         
        DELETE FROM IIL_BIG_BUYER_ORG WHERE IIL_BIG_BUYER_ORG_ID = :IN_SOURCE_ORG_ID;
        COMMIT;
        EXCEPTION WHEN OTHERS THEN
                ROLLBACK;                
                SEND_MAIL('gladmin-team@indiamart.com','gladmin-team@indiamart.com','Big Buyer Bulk Upload- Oracle Error ',SQLERRM || CHR(13) || CHR(10)||DBMS_UTILITY.FORMAT_ERROR_BACKTRACE,'');
        END; ";	
        $sth_mgr = oci_parse($dbh_mesh, $sql_merge_del);
        oci_bind_by_name($sth_mgr, ':IN_TARGET_ORG_ID', $IN_TARGET_ORG_ID);
        oci_bind_by_name($sth_mgr, ':IN_SOURCE_ORG_ID', $IN_SOURCE_ORG_ID);
}

	if(oci_execute($sth_mgr)){
             $num_update=oci_num_rows($sth_mgr);
                if($num_update > 0){
                    $status='success';
                }else{
                    $status='No data found';
                }       
        }        
        } catch (Exception $e) 
        {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $status;
    }


public function manage_addemaildomain($action,$dbh_mesh,$excel_row)
    {
        $status='error';
        try 
	{ 
         $IIL_BIG_BUYER_EMAIL_DOMAIN=   $excel_row['IIL_BIG_BUYER_EMAIL_DOMAIN'];
         $ENABLED_STATUS=$excel_row['ENABLED_STATUS'];

            $email_domain_exist=0;
            $sourcesql = "SELECT count(IIL_BIG_BUYER_EMAIL_ID) CNT FROM IIL_BIG_BUYER_EMAIL WHERE IIL_BIG_BUYER_EMAIL_DOMAIN=:IIL_BIG_BUYER_EMAIL_DOMAIN";
	      $stid = oci_parse($dbh_mesh, $sourcesql);
	      oci_bind_by_name($stid, ':IIL_BIG_BUYER_EMAIL_DOMAIN', $IIL_BIG_BUYER_EMAIL_DOMAIN);  
	      oci_execute($stid);
          $rec = oci_fetch_assoc($stid);       
          
	      if($rec){
                $email_domain_exist = $rec['CNT'];
          }
          

             if($email_domain_exist == 0){ 
                     $sql_create_domain="INSERT INTO IIL_BIG_BUYER_EMAIL (IIL_BIG_BUYER_EMAIL_DOMAIN,IIL_BIG_BUYER_MODIFIED_DATE,IIL_BIG_BUYER_EMAIL_ADDED_DATE,ENABLED_STATUS) values 
                    (:IIL_BIG_BUYER_EMAIL_DOMAIN, SYSDATE, SYSDATE,:ENABLED_STATUS)";	        
                    $sth_create_domain = oci_parse($dbh_mesh, $sql_create_domain);
                    oci_bind_by_name($sth_create_domain, ':IIL_BIG_BUYER_EMAIL_DOMAIN', $IIL_BIG_BUYER_EMAIL_DOMAIN);  
                    oci_bind_by_name($sth_create_domain, ':ENABLED_STATUS', $ENABLED_STATUS); 
                    if(oci_execute($sth_create_domain)){                        
                       return 'success';                                    
                     }else{
                            return 'Error in create_domain';
                     }                   
            }
            else{

                $status = 'error: Email domain already exist';
            }

	  
        } catch (Exception $e) 
        {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $status;
    }

public function showInst() {
        print <<<hj
<div id="div_inst">
    <table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0">
    <TR>
    <TD align="center" bgcolor="#F0F9FF"><B>Bulk Big Buyer Bulk Data process Instructions</B></TD>
    </TR>
    <TR>
    <TD bgcolor="#F0F9FF" style="font-size: 11px;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">
    <ul>
    <li>Document must be in Excel Format (File Format Should be in .xls)</li>
    <li>Only 500 records will be process in one excel.</li>
    <li>All headings should be in first row of Excel.</li>
    <li>Delete blank rows from excel before upload. Otherwise all blank rows will be skipped.</li>
    <li>All headings should be in given format and Don't change the given headings. Please download sample excel and refer all given headings.</li>
    <li>Only one excel will be process at once. If you have uploaded one excel it must be processed or deleted before uploading another excel. </li>
    </ul>
    </TD>
    </TR></Table></div>
hj;
    }

}
?>