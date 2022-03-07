<head>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script type="text/javascript">
    $(function() {
    $('input:radio[name="rtype"]').change(function() {
            if (($("input[name='rtype']:checked").val()== 'G')) {
               $("#radiolocActionA").hide(); 
            }else{
               $("#radiolocActionA").show();
           }
    });
});
$(document).ready(
    function()
            {
                $('#submit_view').click(function(){
                    var startdate=$('#start_date').val();
                    var mdy = startdate.split('-');
                    var startdate=mdy[0] +' '+mdy[1]+' '+mdy[2];
                    var startdate = new Date(startdate);
                    var enddate=$('#end_date').val();
                    var mdy2 = enddate.split('-');
                    var enddate=mdy2[0] +' '+mdy2[1]+' '+mdy2[2];
                    var enddate = new Date(enddate);
                    var timeDiff = enddate.getTime() - startdate.getTime();
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    
                    if(diffDays>7)
                    {
                       alert("Kindly Select Dates In Span Of 7 Days Only");
                       return false;
                    }     
                        a={};
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val(); 

                        a['submit_view']=$('#submit_view').val();
                        a['radiolocAction']=$('input[name="radiolocAction"]:checked').val();
                        a['rtype']=$('input[name="rtype"]:checked').val();
                        
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/BLDisplayGrid/downloadwithdb&mid=3930",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#sampleresult").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....</DIV>");},
                success:function(result){                         
                               $('#sampleresult').html(result);                   
                            }
                        });                   
                    });                     
            }
); 

</script>

<style type="text/css">
.dark{background : #eefaff;     }.wbg{background : #ffffff;      }.fnt{font-size:12px;width:33%;height:15px;}
.tab-container{ background:#ffffff; width:100%; margin:0px auto; border:1px solid #80c0e5;}.eb{ padding:0px 0px 0px 0px; margin:0px auto;width:100%; float:left;}
.data_off{display:none}.data_on{display:block}
.nav{ float:left;width:100%;}.nav ul{ padding:0px; margin:0px;}.nav ul li{ float:left; font-size:14px;list-style:none; font-weight:bold;}
.nav ul li a{ float:left; font-size:14px; color:#12569d; list-style:none; font-weight:bold;  height:30px; padding:0px 11px; border-left:1px solid #80c0e5; line-height:30px; text-decoration:none;}
.nav ul li a:hover{color:#000000; text-decoration:none;}.nav ul li a.selected{ float:left;color:#bc0800; list-style:none; font-weight:bold; background:#ffffff; background-image:none; height:30px; padding:0px 11px;  line-height:30px; text-decoration:none;border-left:1px solid #80c0e5}
</style>
</head>
<body>
<?php 
$start_date1=isset($start_date)?$start_date:'';

    ?><form name="sampleForm" id="sampleForm" method="post" style="margin-top:0;margin-bottom:0;">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
             <TR id="tr2">
              <td WIDTH="10%">&nbsp;Date:</td>
              <td WIDTH="40%"> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" 
                                onfocus="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" 
                                onclick="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" 
                                readonly="readonly">&nbsp;<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" 
                                onfocus="displayCalendar(document.sampleForm.end_date,'dd-mm-yyyy',this,'','','from_date2')" 
                                onclick="displayCalendar(document.sampleForm.end_date,'dd-mm-yyyy',this,'','','from_date2')" id="end_date" TYPE="text" 
                                readonly="readonly"></td>
               </div>
    </td><TD bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 12px; width:10%;line-height:3px;" >
					<B>Location Type:</B>
				</TD>	
				<TD bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 12px;width:40%; line-height:3px;" >
                                            <input type="radio" name="radiolocAction" value="G" checked> &nbsp;Global &nbsp; &nbsp; &nbsp;                                          
                                            <input type="radio" name="radiolocAction" value="I" > &nbsp;India &nbsp;<br/> 
                                            <input type="radio" name="radiolocAction" value="F" > &nbsp;Foreign &nbsp; &nbsp; &nbsp;
                                          <input type="radio" name="radiolocAction" value="L" > &nbsp;Local &nbsp;<br/>
                                          <input type="radio" name="radiolocAction" value="H" > &nbsp;Hyperlocal &nbsp;&nbsp;&nbsp;		
				<span style="display:none" id="radiolocActionA"><input  type="radio" name="radiolocAction"   value="A" > &nbsp;All</span>
                                </TD>
</tr><tr>
                            <td colspan="2"><input type="radio" name="rtype" value="G" checked> &nbsp;Get Location wise Grid&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                           
<input type="radio" name="rtype" value="NI" > &nbsp;Get Grid wise NI Data &nbsp; &nbsp; &nbsp; <input type="radio" name="rtype" value="T" > &nbsp;Get Grid wise BL Transaction data &nbsp; &nbsp; &nbsp;
                                         
                            <TD colspan="2" align="center">                      
                        <input type="button" name="submit_view" id="submit_view" value="Submit" >
                        <input type="hidden" name="action" id="action" value="generate">
                        <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"></div>
                            </TD></tr>
                        </TABLE><div id="sampleresult" name="sampleresult"></div>
                        <div id="auditresult" name="auditresult" style="color:blue;text-align:center;"></div>
                        

</body><div style="clear:both;"><!-- --></div></div>