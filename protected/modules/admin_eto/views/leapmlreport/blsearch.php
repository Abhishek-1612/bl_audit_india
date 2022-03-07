<?php  
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
$start_date = (!empty($start_date)?$start_date:strtoupper(date('d-M-Y')));
$end_date = (!empty($end_date)?$end_date:strtoupper(date('d-M-Y')));
$mcatName=isset($mcatName) ? $mcatName : '';
$mcat_id=isset($mcat_id) ? $mcat_id : '';
$p = '';
$s = '';
$radio_val1 = isset($_REQUEST['radio_val']) ? $_REQUEST['radio_val'] : '';
if ($radio_val1 == "") {
   $radio_val1 = isset($_REQUEST['radio_val1']) ? $_REQUEST['radio_val1'] : '';
}

if (($radio_val1 == 'p') or ($radio_val1 == "")) {
       $p = 'checked';
   } else {
       $s = 'checked';
   }
?>
<html><head>
<title>Buylead Search</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:204px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:1px;border-style:solid;border-color:#0195d3;
}
</style>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<LINK HREF="/css/jquery.dataTables.min.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/jquery.dataTables.min.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>

<script>
$(document).ready(
    function()
            {  
                $('#search').click(function(){
                        a={};
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['ofrid']=$('#ofrid').val();                       
                        a['search']=$('#search').val();
                        a['rtype']=$('input[name=rtype]:radio:checked').val();  
                        a['ml_model_version']=$('#version').val();
                        a['predicted_req_typ']=$('#predicted_req_typ').val();
                        if((a['rtype']=='B') && (a['ofrid']=='')){
                            alert("Please Enter offer ID ");
                            return false;
                        }
                        
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapMLReport/Report&mid=3851",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                success:function(result){                         
                               $('#result').html(result);                   
                            }
                        }); 
            }
);  
}
)  

function check_validate(){
                        var x={};
                        var ids = document.getElementById("all_ml_model_retail_marking_id").value.split(",");             
                for(var j=0;j<ids.length;j++)
                {
                    ml_model_retail_marking_id= ids[j];
                    var selofrid=$('#ofr_id_'+ml_model_retail_marking_id).val();  
                    usage_Id="usage_"+ml_model_retail_marking_id;
                    tov_Id="tov_"+ml_model_retail_marking_id;
                    retail_Id="retail_"+ml_model_retail_marking_id;
                    
                    var usage_val= $('input:radio[name=\''+usage_Id+'\']:checked').val();
                    var tov_val= $('input:radio[name=\''+tov_Id+'\']:checked').val();
                    var retail_val= $('input:radio[name=\''+retail_Id+'\']:checked').val();
                    
                    var remarks_usage=$('#remarks_usage_'+ml_model_retail_marking_id).val();
                    var remarks_tov=$('#remarks_tov_'+ml_model_retail_marking_id).val();
                    var remarks_retail=$('#remarks_retail_'+ml_model_retail_marking_id).val();
                    
                    
                    if((usage_val === '0') && (remarks_usage == '')){
                        alert('Please Fill Usage Remark for ID:'+selofrid);
                        return false;
                    }
                    if((tov_val === '0') && (remarks_tov == '')){
                        alert('Please Fill TOV Remark for ID:'+selofrid);
                        return false;
                    }
                    if((retail_val === '0') && (remarks_retail == '')) {
                        alert('Please Fill Retail Remark for ID:'+selofrid);
                        return false;
                    }
                    if(/^[a-zA-Z0-9- ]*$/.test(remarks_usage) == false) {
                        alert('Usage Remark contains Unsupported characters.');
                        return false;
                    }
                    if(/^[a-zA-Z0-9- ]*$/.test(remarks_tov) == false) {
                        alert('TOV Remark contains Unsupported characters.');
                        return false;
                    }
                   if(/^[a-zA-Z0-9- ]*$/.test(remarks_retail) == false) {
                        alert('Retail Remark contains Unsupported characters.');
                        return false;
                    }

                    x[ml_model_retail_marking_id]={
                            ml_model_retail_marking_id:ml_model_retail_marking_id,
                            ofr_id:selofrid,
                            usage_val:usage_val,
                            tov_val:tov_val,
                            retail_val:retail_val,
                            remarks_usage:remarks_usage,
                            remarks_tov:remarks_tov,
                            remarks_retail:remarks_retail
                        };
                }  
                var conf1 = confirm('Are you sure want to Audit?');
            if(conf1)
            {  
                var newArr=JSON.stringify(x);
                a['ofrarray']=newArr;
                $("#save_all").hide();   
                $.ajax({ 	 	
                    type: "POST", 	
                    async: false,
                    url: "index.php?r=admin_eto/LeapMLReport/Saveaudit&mid=3851", 	 	
                    data: a, 
                    success: function(result){ 	
                        alert(result);                                                      
                    }, 	 	
                    error: function() { 
                            alert('Error occured');
                            result = false;
                    } 	 	
                });  
            }
}

function showretail(offerid){
	$("#retail"+offerid).hide();
       $.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/LeapMLReport/showretailidentification&mid=3851&offerid="+offerid,
                data: "",
        success: function(response){
            $("#retail"+offerid).html(response);
            $("#retail"+offerid).show();  
        }
    });   
}

function ondemandCount(mcat_id)
{
	 a={};
                        a['mcat_id']=mcat_id;
                        a['showprice']='showprice';
                         result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapMLReport/Mcatreport&mid=3852",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result_p").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){
                                 $('#result_p').html(result);     
                                     $('#example').DataTable( {
                                        "columnDefs": [{"className": "dt-center", "targets": "_all"}],
                                        "order": [[ 1, "desc" ]],
                                        "lengthMenu": [[5,10,25, 50, -1], [5,10,25, 50, "All"]]
                                    } );

                            }
                        });            
                        
}

</script>
</head>
<body><input name="frame_height" id="frame_height" value="" type="hidden">
<form name="searchForm" id="searchForm" method="post" action="" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
<TR>
    <td colspan="2" style="width:10%;padding:4px;" align="center"><a target="_new" href="LEAP-ML-Model-Audit-SOP.pdf"><b>Download Leap ML Model Audit SOP PDF</b></a></td>
</tr>
<tr id="mcatsearch">
<td WIDTH="20%" style="font-weight: bold">Approval Date:</td>
<td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
&nbsp;<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
</td> 

</tr>
<tr>
 <TD align="left" style="font-weight: bold">Offer ID : &nbsp;<input id="ofrid" type="text" VALUE="" SIZE="13" TYPE="number" ></td>   
 <td align="left"><b>Version:</b> &nbsp;&nbsp;
    <select name="version" id="version"><OPTION VALUE="">ALL</OPTION> 
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                         <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;
    <b>Usage Prediction:</b> &nbsp;&nbsp;
    <select name="predicted_req_typ" id="predicted_req_typ"><OPTION VALUE="">ALL</OPTION> 
                        <option value="-1">No Prediction</option>
                        <option value="1">Business Use</option>
                        <option value="2">Personal use</option>
                         <option value="3">Amber</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;<input type="button" name="search" id="search" value="Search"></td></tr>
</TABLE> 
    
    <div id="result" name="result"></div>
    <div id="auditresult" name="auditresult" style="color:blue;text-align:center;"></div>
     <div id="result_p" name="result_p"></div>
   
</form>
               
</body>
</html>
