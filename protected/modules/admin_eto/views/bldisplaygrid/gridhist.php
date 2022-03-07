<?php 
                $request = Yii::app()->request;
                $currentDate = date("d-m-Y");

                $start_date= $request->getParam('start_date','');
		$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));		
		$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
		$end_date=$request->getParam('start_date','');
                $end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));		
		$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));

?>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">   
<script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script type="text/javascript">
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
                    
                    if(diffDays>31)
                    {
                       alert("Kindly Select Dates In Span Of 31 Days Only");
                       return false;
                    }     
                        a={};
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['submit_view']=$('#submit_view').val();
                        a['radiolocAction']=$('input[name="radiolocAction"]:checked').val();
                        
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/BLDisplayGrid/Gethist&mid=3931",
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
<STYLE TYPE="text/css">
	.admintext {font-family:arial; font-size:11px;line-height:15px;}
	.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}
	.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
	</STYLE>

<form name="sampleForm" id="sampleForm" method="post" style="margin-top:0;margin-bottom:0;">
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
                                            <input type="radio" name="radiolocAction" value="G" checked> &nbsp;Global India&nbsp; &nbsp; &nbsp;                                          
                                            <input type="radio" name="radiolocAction" value="F" > &nbsp;Foreign&nbsp; &nbsp; &nbsp;
                                          <input type="radio" name="radiolocAction" value="L" > &nbsp;Local&nbsp;&nbsp; &nbsp;
                                          <input type="radio" name="radiolocAction" value="H" > &nbsp;Hyperlocal&nbsp;&nbsp;&nbsp;		
				
                                </TD>
</tr><tr>
                           <TD colspan="4" align="center">                      
                        <input type="button" name="submit_view" id="submit_view" value="Submit" >
                        <input type="hidden" name="action" id="action" value="generate">
                        <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"></div>
                            </TD></tr>
                        </TABLE>
      
		<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1">
<tbody><div id="sampleresult" name="sampleresult"></div></tbody></table>