<?php
$updisable='';
$disable='';
$excelfile='';
$msg='';
$js_path='';
$file_name=isset($param['attachment'])?$param['attachment']:'';
$excelfile=isset($param['excel'])?$param['excel']:'';
$empid=isset($param['empid'])?$param['empid']:'';
$file_name=isset($param['file_name'])?$param['file_name']:'';
$subject=isset($param['subject'])?$param['subject']:'';
$gridCategory=isset($param['gridCategory'])?$param['gridCategory']:'';
$utm_src=isset($param['utm_src'])?$param['utm_src']:'';
$campaign=isset($param['campaign'])?$param['campaign']:'';
$verify_screen=isset($param['verify_screen'])?$param['verify_screen']:'';
$sname=isset($param['sname'])?$param['sname']:'';
$semail=isset($param['semail'])?$param['semail']:'';
$refurl=isset($param['refurl'])?$param['refurl']:'';
$replyTo=isset($param['replyTo'])?$param['replyTo']:'';
$testEmailsids=isset($param['testIds'])?$param['testIds']:'';
$testEmailsnames=isset($param['testNames'])?$param['testNames']:'';
$testGlid   =isset($param['testGlid'])?$param['testGlid']:'';
$mid=isset($param['mid'])?$param['mid']:'';

$gridAccount=isset($param['gridAccount'])?$param['gridAccount']:'';
$select1=$gridAccount=='rajkamal@indiamart.com'?'Selected':'';
$select2=$gridAccount=='myimmails@indiamart.com'?'Selected':'';
$select3=$gridAccount=='my-admin@indiamart.com'?'Selected':'';
$select4=$gridAccount=='thirdpartymails'?'Selected':'';
?>
<html>
    <head>
        <link rel="stylesheet" href="<?php echo $js_path; ?>/bootstrap/css/bootstrap.min.css"  media="screen">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="http://utils.imimg.com/suggest/css/jquery-ui.css"  media="screen">

        <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
        <script src="http://utils.imimg.com/suggest/js/jq-ac-ui.js" type="text/javascript"></script>
        <link href="/css/report.css" rel="STYLESHEET" type="text/css">
        
        <script>
            function upload(){
                var idVal=   $('#attachment').val();
                if(idVal=="")
                {
                        alert("Please Enter a  Excel File");
                        return false;
                }
                else
                {
                        var check=idVal.split(".");
                        //alert(check[1]);
                        if(check[1]!='csv' )
                        {
                                alert("Please Enter Only Excel File");
                                return false;
                        }
                }
            
            }
            function process(){
         //alert('hi');alert(file);
            var file    =  $('#excel').val();
            var empid   = $('#empid').val();
            var mid     = $('#mid').val();
           //alert('hi');alert(file);
            
            var quer_str = 'action1=Process&empid=' + empid + '&mid=' + mid + '&file=' + file;
            $.ajax({
                    type: "POST", 
                    url: "/index.php?r=admin_bl/EmailVerificationredis/uploadExcel&"+quer_str,
                    data: "",
                    success: function(res){  
                        //alert(res);
                        $( "#Process" ).prop( "disabled", true );
                        $("#processexcel").html(res);
                    }
            });
            
        }
            function remove_file(file,type){ $.ajax({
                url: "/index.php?r=admin_bl/EmailVerificationredis&mid=<?php echo $mid ?>&action=remove&excel="+file,
                type: 'post',
                data: "",
                success: function(result) {
                    $("#removedexcel").hide();
                    $("#removedexcel").html();
                    $("#excel1").val('');
                     $("#rslt").html(result);
                     $("#rslt1").show();  
                     $("#rslt").show();  
                    
                }
            });
            }   
            function submitForm(button_type){
                  
                var mailBody=$('#htmlContent').val();
                var subject=$('#subject').val();
                var gridAcc=$('#gridAcc').val();
                var gridCategory=$('#gridCategory').val();
                var semail=$('#semail').val();
                
                
                  if(mailBody==''){
                       alert('Mailer field can not be blank');
                       $('#htmlContent').focus();
                       return false;
                   }
                   if(subject==''){
                       alert('Subject field can not be blank');
                       $('#subject').focus()
                       return false;
                   }
                   if(gridAcc=='Account'){
                       alert('Select a Sendgrid Account');
                       $('#gridAcc').focus()
                       return false;
                   }
                   if(gridCategory==''){
                       alert('Sendgrid Category can not be blank');
                       $('#gridCategory').focus()
                       return false;
                   }
                   
                   var refurl=$('#refurl').val();
                   if(refurl!=''){
                       
                       var campaign=$('#campaign').val();
                       var utm_src=$('#utm_src').val();
                       var verify_screen=$('#verify_screen').val();
                       
                       if(campaign==''){
                        alert('Campaign field can not be blank');
                        $('#campaign').focus()
                        return false;
                       }
                       if(utm_src==''){
                        alert('utm source field can not be blank');
                        $('#campaign').focus()
                        return false;
                       }
                       if(verify_screen==''){
                        alert('verify screen field can not be blank');
                        $('#campaign').focus()
                        return false;
                       }
                    }
                   
                   if(semail==''){
                       alert('Sender Email field can not be blank');
                       $('#semail').focus()
                       return false;
                   }
                   
                if(button_type=='Test Submit'){
                    $('#testmailer').val('yes');
                    var testids= $('#testIds').val();
                    var testnames= $('#testNames').val();
                    var testGlid= $('#testGlid').val();
                    
                    if(testids=='' || testnames=='' || testGlid==''){
                       alert('Test fields can not be blank for testing');
                       $('#testIds').focus()
                       return false;
                   }
                }
                else{
                    
                    var excel=$('#excel1').val();
                    excel2=excel.trim();
                   if(excel2==''){
                       alert('Excel can not be blank');
                       return false;
                   }
                } 
            }
        </script>
    </head>
    <body>
        
        <form id='template1' name='template1' action="/index.php?r=admin_bl/EmailVerificationredis&mid=<?php echo $mid ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" id="empid" name="empid" value="<?php echo $empid?>">
        <input type="hidden" id="mid" name="mid" value="<?php echo $mid?>">
	<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"> 
     <tr>
        <td colspan="2" align="center" style="background-color:#006DCC;color:#fff">
            <B><FONT SIZE = "2px">Gluser's Mailer Excel</FONT></B>  
        </td>
     </tr>
     <tr>
                    <TD bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 12px; line-height:2px;" width="15%">
                        <B>Upload Excel:</B>
                    </TD>
                    <TD bgcolor="#F0F9FF" style="line-height:2px;" width="30%">
                        <input type="FILE" id= "attachment" name="attachment" value="<?php echo $excelfile?>" >
                        <input type="hidden" id="excel1" name="excel1" value="<?php echo $file_name ?>">

                        
                    </TD>
     </tr>
     <tr>
                    <td align="center" colspan="2" bgcolor="#F0F9FF">
                        <input type="submit" name="action" id ="Upload" value="Upload" onclick="return upload();" <?php echo $updisable?> class="btn btn-small btn-primary" style="font-weight:normal">
                    </td>
    </tr>
    <tr>
    <td colspan = "4" align="left" bgcolor="#F0F9FF">
        <div style="float:left"><B><a href="/admin_glmeta/mailerformat.csv" >Download Sample Excel of Gluser's Mailer.</a></B></div>
    </td>
    </tr>
    <tr>
        <td colspan = "4" align="left" bgcolor="#F0F9FF">
            <div style="float:left"><B><a href="/admin_glmeta/Mailerguidelines.txt" target="_blank">Click For Guidelines Of Sending Mails To Gluser.</a></B></div>
        </td>
    </tr>
 </table>

<br>
<?php
if(!empty($param['msg'])|| !empty($param['file_name'])){
            
    $msg=isset($param['msg'])?$param['msg']:'';
    
?>   

<div id="removedexcel">
    <input type="hidden" id="excel" name="excel" value="<?php echo $file_name ?>">
    <TABLE bordercolor="#bedaff" border="1" cellspacing="0" cellpadding="4" align="center" class="table_txt" style="border-collapse: collapse; width:98%">
        <TR><TD bgcolor="#F0F9FF" width="15%" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:25px;"><b><?php echo $msg ?></b></TD>
            <TD align="right" bgcolor="#F0F9FF">
                <b><img src="/admin_glusr/gifs/trash.gif" border="0" onclick = "return remove_file('<?php echo $file_name ?>','excel');">
                    <font size= "2" color="black" ><?php echo $file_name?></font>
            </TD>        
        </TR>
    </TABLE>   
</div>
<?php
}
?>
<span id='rslt1' style='display:none'>
    <TABLE bordercolor="#bedaff" border="1" cellspacing="0" cellpadding="4" align="center" class="table_txt" style="border-collapse: collapse; width:98%">
        <TR><TD  bgcolor="#F0F9FF" width="15%" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:25px;"><div id='rslt' style='display:none'></div></TD>
        </TR>
    </TABLE> 
</span>
<div id="processexcel">

</div>
<div id="template2">      
        <table bordercolor="#bedaff" border="1" cellspacing="0" cellpadding="4" align="center" class="table_txt" style="border-collapse: collapse; width:98%">
            
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Mailer HTML</td>
                <td><textarea name="htmlContent"  id="htmlContent" style="width: 1500px; height: 500px;"></textarea></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Subject</td>
                <td><input type="text" id="subject" name="subject" value="<?php echo $subject?>"></td>
            </tr>
           
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Sendgrid&nbspAccount</td>
                <td>
                    <select id="gridAcc" name="gridAccount" style="width:15%">
                        <option>Account</option>
                        <option <?php echo $select1?>>rajkamal@indiamart.com</option>
                        <option <?php echo $select2?>>myimmails@indiamart.com</option> 
                        <option <?php echo $select3?>>my-admin@indiamart.com</option> 
                        <option <?php echo $select4?>>thirdpartymails</option> 
                    </select>
                </td>               
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Sendgrid&nbspCategory</td>
                <td><input type="text" id="gridCategory" name="gridCategory" value="<?php echo $gridCategory?>"></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Sender Name</td>
                <td><input type="text" id="sname" name="sname" value="<?php echo $sname ?>"></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Sender Email</td>
                <td><input type="text" id="semail" name="semail" value="<?php echo $semail ?>"></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Reply To</td>
                <td><input type="text" id="replyTo" name="replyTo" value="<?php echo $replyTo ?>"></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Redirect URL</td>
                <td><input type="text" id="refurl" name="refurl" value="<?php echo $refurl?>"></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">UTM Source</td>
                <td><input type="text" id="utm_src" name="utm_src" value="<?php echo $utm_src ?>"></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">UTM Campaign</td>
                <td ><input type="text" id="campaign" name="campaign" value="<?php echo $campaign ?>"></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Verify Screen</td>
                <td ><input type="text" id="verify_screen" name="verify_screen" value="<?php echo $verify_screen ?>"></td>
            </tr>
            
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Test EMail</td>
                <td><input type="text" id="testIds" name="testIds" value="<?php echo $testEmailsids ?>"></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Test Name</td>
                <td><input type="text" id="testNames" name="testNames" value="<?php echo $testEmailsnames ?>"></td>
            </tr>
            <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td width="15%">Test Gluserid</td>
                <td><input type="text" id="testGlid" name="testGlid" value="<?php echo $testGlid ?>"></td>
            </tr>
             <tr bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 15px; line-height:2px;" width="15%">
                <td>
                    <input type="hidden" name="testmailer" id="testmailer" value="no">
                    <input class="btn btn-small btn-primary" type='submit' name="testsubmit" value="Test Submit" onclick="return submitForm(this.value);">
                </td>
                <td>
                    <input class="btn btn-small btn-primary" type='submit' name="submit" value="Submit" onclick="return submitForm(this.value);">
                </td>
            </tr>
            
        </table>
    
        </div>
</form>
    </body>
</html>
