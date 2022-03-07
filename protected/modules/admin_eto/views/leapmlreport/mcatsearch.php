<?php  
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
$start_date = (!empty($start_date)?$start_date:strtoupper(date('d-M-Y')));
$end_date = (!empty($end_date)?$end_date:strtoupper(date('d-M-Y')));
$mcat_name=isset($mcat_name) ? $mcat_name : '';
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
<title>Buylead ML Search</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:204px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:1px;border-style:solid;border-color:#0195d3;
}
 .table .thead-dark th {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }
</style>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>

<LINK HREF="/css/jquery.dataTables.min.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/jquery.dataTables.min.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>

<script>
    function  ShowHideDiv(id){
        
   var ele = document.getElementsByName('tov_'+id);
   for(i = 0; i < ele.length; i++) {
                 if(ele[i].checked){
                    var ch= ele[i].value;
                    
              
                 if(ch==1){
                    document.getElementById("reason_"+id).style.display = "none";
                    
                 }
                 else{
                    document.getElementById("reason_"+id).style.display = "";
                    
                 }
               }
            }
   }
  

function showprice()
{ 
    window.open('/index.php?r=admin_marketplace/McatPriceAnalytics/McatPriceDisplay&mid=3822','_blank','width=1000,height=600');
}

function pagination(start,end)
{ 
    a={};
        a['mcat_name']=$('#mcat_name').val();
        a['mcat_id']=$('#mcatid11').val();
        a['start_date']=$('#start_date').val();
        a['end_date']=$('#end_date').val();
        a['search']=$('#search').val();
        a['ml_model_version']=$('#version').val();
        a['quantity_flag']=$('#quantity_flag').val();
        a['predicted_req_typ']=$('#predicted_req_typ').val();
        a['rtype']=$('input[name=rtype]:radio:checked').val();  
        if(a['rtype']=='M'){
            if(a['mcat_id']==''){
                alert("Please Select Mcat");
                return false;
            }
        }
        a['start']=start;
        a['end']=end;

        result='';               
        $.ajax({
            url:"/index.php?r=admin_eto/LeapMLReport/Mcatreport&mid=3852",
            type: 'post',
            data:a,
            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
            success:function(result){                          
               $('#result').html(result);                    
            }
        });
}
$(document).ready(
    function()
            { 
        $('input[type="radio"]').click(function(){        
        if($(this).attr("value")=="M"){
                $('#mcatsearch').show();
            }else{
                $('#mcatsearch').hide();
            }
        });


                $('#search').click(function(){
                        a={};
                        a['mcat_name']=$('#mcat_name').val();
                        a['mcat_id']=$('#mcatid11').val();
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['search']=$('#search').val();
                        a['ml_model_version']=$('#version').val();
                        a['quantity_flag']=$('#quantity_flag').val();
                        a['predicted_req_typ']=$('#predicted_req_typ').val();
                        a['rtype']=$('input[name=rtype]:radio:checked').val();  
                        if(a['rtype']=='M'){
                            if(a['mcat_id']==''){
                                alert("Please Select Mcat");
                                return false;
                            }
                        }
                         result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapMLReport/Mcatreport&mid=3852",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#result').html(result);
                            }
                        }); 
            }); 
            $('#showkpis').click(function(){
                        a={};
                        a['mcat_name']=$('#mcat_name').val();
                        a['mcat_id']=$('#mcatid11').val();
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['showkpis']=$('#showkpis').val();
                        if(a['mcat_id']==''){
                            alert("Please Select Mcat");
                            return false;
                        }                        
                         result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapMLReport/Mcatreport&mid=3852",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#result').html(result);                   
                            }
                        }); 
            }); 
            

            $('#showprice').click(function(){
                        a={};
                        a['mcat_id']=$('#mcatid11').val();
                        if(a['mcat_id']==''){
                            alert("Please Select Mcat");
                            return false;
                        }  
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
                        });
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
                    var tov_reason= $('#reason_'+ml_model_retail_marking_id).val();
                    var predicted_val= $('#predicted_'+ml_model_retail_marking_id).val();
                    var remarks_usage=$('#remarks_usage_'+ml_model_retail_marking_id).val();
                    var remarks_tov=$('#remarks_tov_'+ml_model_retail_marking_id).val();
                    var remarks_retail=$('#remarks_retail_'+ml_model_retail_marking_id).val();
                    
      
          var  predicted_id='1';
         
         if(predicted_val=='Personal Use')
         {
            predicted_id='2';
         }
         if(predicted_val=='Amber')
         {
            predicted_id='3';
         }
                    if((tov_val === '0') && (tov_reason === null)){
                        alert('Please select TOV Reason for ID:'+selofrid);
                        return false;
                    }
                    if((tov_val === '0') && (remarks_tov == '')){
                        alert('Please Fill TOV Remark for ID:'+selofrid);
                        return false;
                    }
                    if(usage_val !== '-1'){
                    if((usage_val !== predicted_id) && (remarks_usage == '')){
                        alert('Please Fill Usage Remark for ID:'+selofrid);
                        return false;
                    }
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
                            tov_reason:tov_reason,
                            retail_val:retail_val,
                            remarks_usage:remarks_usage,
                            remarks_tov:remarks_tov,
                            remarks_retail:remarks_retail,
                            predicted_val:predicted_val
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
                        pagination(1,5);
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
</script>
<script>
function lookup(idd,obj,divId) 
{	var auto_ajax_call=0;
	$("#mcatsmain").css("display", "block");
	var inputString=$('#'+idd).val();
	obj = "find";
			
	if(inputString.length == 0) {
		$('#'+divId).html('<div></div>');
	} 
	else if(inputString.length > 2)
	{
		if(/[.]/.test(inputString)){
			$('#'+divId).html('<div></div>');
		}
		else
		{
			var typ='P';			
            if(document.searchForm.radio_val.value == 'p')
					{
						typ='P';
					}
					else if(document.searchForm.radio_val.value == 's')
					{
						typ='S';
					}
					auto_ajax_call++;
                $.post("/cron/rpc2.php", {queryString: ""+inputString+"", ff: ""+typ+"",searchtype:""+obj+"", ajax_rq: ""+auto_ajax_call+""}, function(data){
				if(data.length >0) {
                     var mcat_arr = data.split("###");
                     if(mcat_arr[0] == auto_ajax_call)
                     {
                        $('#'+divId).html(mcat_arr[1]);
					 }
				}
				else{
					$('#'+divId).html('<div></div>');
				}
			});				
		}
	}
	else if(inputString.length <=2){
		$('#'+divId).html('<div></div>');
	}
}
	
function abc(mcatname,mcatid)
{	
	mcat_name.value=mcatname;
	mcatid11.value=mcatid;
	$("#mcatsmain").hide(); 
}
   
</script>
<style>
    th.dt-center, td.dt-center { text-align: center; }
</style>
</head>
<body><input name="frame_height" id="frame_height" value="" type="hidden">
<form name="searchForm" id="searchForm" method="post" action="" style="margin-top:0;margin-bottom:0;">
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
<TR>
    <td colspan="2" style="width:10%;padding:4px;" align="center"><a target="_new" href="LEAP-ML-Model-Audit-SOP.pdf"><b>Download Leap ML Model Audit SOP PDF</b></a></td>
</tr>
<tr>
<td WIDTH="40%" style="font-weight: bold">&nbsp;Approval Date:&nbsp;&nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
&nbsp;<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
</td>  
<td>&nbsp;  <input type="button" name="search" id="search" value="Search Buyleads"> &nbsp;&nbsp;
    <?php $emp_id   = Yii::app()->session['empid'];
if($emp_id==3575 || $emp_id==74876 || $emp_id==40207){?>
<input type="button" name="showkpis" id="showkpis" value="Show KPIs"><?php } ?>
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;<input type="button" name="showprice" id="showprice" value="MCAT Price Analytics" >
</td>
</tr><tr>
<td align="left"><input type="hidden" name="mcatid11" value="<?php echo $mcat_id;?>"><input type="hidden" name="mcat_name" value="<?php echo $mcat_name;?>">
 <b>Report Type:</b>&nbsp;<input type="radio" id="rtypeR" name="rtype" value="R" CHECKED>&nbsp;Random BL Search
&nbsp;&nbsp;&nbsp;<input type="radio" id="rtypeM" name="rtype" value="M" >&nbsp;Mcat Search 
</td><td>
<b>Select Qty:</b> &nbsp;<select name="quantity_flag" id="quantity_flag"><OPTION VALUE="">ALL</OPTION> 
<option value="wq">Qty Filled</option>
<option value="woutq">Qty Not Filled</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;
    <b>Usage Prediction:</b> &nbsp;&nbsp;
    <select name="predicted_req_typ" id="predicted_req_typ"><OPTION VALUE="">ALL</OPTION> 
                        <option value="-1">No Prediction</option>
                        <option value="1">Business Use</option>
                        <option value="2">Personal use</option>
                         <option value="3">Amber</option>
</select>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp<b>Version:</b> &nbsp;<select name="version" id="version"><OPTION VALUE="">ALL</OPTION> 
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
 </select></td>
</tr>                      
<tr id="mcatsearch" style="display:none;"><td colspan="2">
<?php               
echo '<FORM name="searchForm" METHOD="post" ACTION="" STYLE="margin-top:0;margin-bottom:0;" id = "searchForm">
<input type="hidden" name="mid" value="'.$_REQUEST["mid"].'">
<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
<TR>';
echo '<td WIDTH="8%"><b>MCAT:</b>&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT TYPE="TEXT" name="mcat_name" id="mcat_name" autocomplete="off" onkeyup="lookup(\'mcat_name\',\'MCAT\',\'mcats\');" value="'.$mcat_name.'"><INPUT TYPE="hidden" name="mcatid11" id="mcatid11" value="'.$mcat_id.'">';
echo '<input type="hidden" name="action1" id="action1" value="">'
. '<input type="hidden" name="radio_val" value="'.$radio_val1.'"><input type="radio" id="radioval1" name="radioval" value="P" '.$p.' onclick="showhide();">Product
<input type="radio" id="radioval2" name="radioval" value="S" '.$s.' onclick="showhide();">Service';
echo '</TD>
</TR>
<TR>
<TD width="30%"><div id="mcatsmain" style="height:200px;overflow:auto;display:none; font-family: arial;font-size: 13px;width:425px;">
<div id="mcats"></div></div>
</span></TD>
</TR>
</TABLE></FORM>';?>
</td></tr>
</TABLE> 
    <div id="result_p" name="result_p"></div>
<div id="result" name="result"></div>

</form>
</body>
</html>
