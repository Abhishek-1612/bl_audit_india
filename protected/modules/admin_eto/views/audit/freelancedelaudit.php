<head>
<title>Buy Lead Audit CRM</title>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script type="text/javascript">
function showuserstats(offerid,glusrid){  
    $("#showuserstat_"+offerid).hide();
    $("#userstat_"+offerid).html('Processing...');    
    $.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/showuserstats&offerid="+offerid+"&glusrid="+glusrid,
                data: "",
        success: function(response){            
            $("#userstat_"+offerid).html(response);            
        }
    });        
}   
function validate_opt(grpname){

       var group =document.getElementsByName(grpname);

       
        if (group[0].checked === true) {
            radioname=grpname.replace("chk", "delopt");
            $('input:radio[name=\''+radioname+'\'][value="2"]').attr('checked',true);           
        }
        if (group[1].checked === true) {
            radioname=grpname.replace("chk", "delopt");
            $('input:radio[name=\''+radioname+'\'][value="2"]').attr('checked',true);           
        }
        if (group[2].checked === true) {
            radioname=grpname.replace("chk", "delopt");
            $('input:radio[name=\''+radioname+'\'][value="2"]').attr('checked',true);           
        }
        if (group[3].checked === true) {
            radioname=grpname.replace("chk", "delopt");
            $('input:radio[name=\''+radioname+'\'][value="2"]').attr('checked',true);           
        }
}
function validate_radio(radioname){
        grpname=radioname.replace("delopt", "chk");
        var opt_val= $('input:radio[name=\''+radioname+'\']:checked').val();
        if(opt_val===2){
            
        }else{  
            $('input[name=\''+grpname+'\']').each(function() {
                    this.checked = false;
            });
        }
}

function validate(){
                         var a ={};
                        var x={};
                        var ids = document.getElementById("all_ofr_id").value.split(",");
              
               for(var j=0;j<ids.length;j++)
                {
                        ofrid= ids[j];
                        primeId="delopt_"+ofrid;
                        var opt_val= $('input:radio[name=\''+primeId+'\']:checked').val();
                        if(opt_val==2){                        
                            var grpname="chk_" + ofrid;
                            var sel_grp=false;
                             var group =document.getElementsByName(grpname);   
                             for (var opt=0; opt< group.length; opt++) {
                                     if(group[opt].checked === true){                                         
                                         sel_grp=true;                                         
                                     }                      
                             }
                             if(sel_grp === false){
                                 alert("Please Select Atleast one error option for Offer Id " + ofrid);                                 
                                 return false;
                             } 
                        }  
                }
                for(var j=0;j<ids.length;j++)
                {
                    var optionvalues = new Array();
                    var questionvalues = new Array();
                    ofrid= ids[j];
                    primeId="delopt_"+ofrid;
                    primeId2="chk_"+ofrid;
                    var opt_val= $('input:radio[name=\''+primeId+'\']:checked').val();
                        optionvalues.push(opt_val);
                        questionvalues.push('32');
                        var rem_val=$('#remarks_'+ofrid).val();
                        var opt_id=ofrid;
                        if(opt_val==227){                            
                            x[opt_id]={
                                    ofr_id:ofrid,
                                    opt_val:optionvalues,
                                    ques_val:questionvalues,
                                    rem_val:rem_val
                                };                   
                             }
                        else{
                            var optionvalues = new Array();
                            var questionvalues = new Array();
                            var opt_val= document.getElementsByName(primeId2);
                            for(var i=0;i<opt_val.length;i++)
                            {
                                if(opt_val[i].checked === true ){
                                    optionvalues.push(opt_val[i].value); 
                                    questionvalues.push('32'); 
                                }
                            }
                           
                            x[opt_id]={
                                    ofr_id:ofrid,
                                    opt_val:optionvalues,
                                    ques_val:questionvalues,
                                    rem_val:rem_val
                                };  
                        }
                       
                }                
                var newArr=JSON.stringify(x);
                document.getElementById("selopt_val").value= newArr;
                document.getElementById("save").style.display = "none";
                document.getElementById("save_close").style.display = "none";
                clearInterval(xtimer); 

        return true;
}
</script>

<style type="text/css">
.dark{background : #eefaff;     }.wbg{background : #ffffff;      }.fnt{font-size:12px;width:33%;height:15px;}
.tab-container{ background:#ffffff; width:100%; margin:0px auto; border:1px solid #80c0e5;}.eb{ padding:0px 0px 0px 0px; margin:0px auto;width:100%; float:left;}
.data_off{display:none}.data_on{display:block}
.nav{ float:left;width:100%;}.nav ul{ padding:0px; margin:0px;}.nav ul li{ float:left; font-size:14px;list-style:none; font-weight:bold;}
.nav ul li a{ float:left; font-size:14px; color:#12569d; list-style:none; font-weight:bold;  height:30px; padding:0px 11px; border-left:1px solid #80c0e5; line-height:30px; text-decoration:none;}
.nav ul li a:hover{color:#000000; text-decoration:none;}.nav ul li a.selected{ float:left;color:#bc0800; list-style:none; font-weight:bold; background:#ffffff; background-image:none; height:30px; padding:0px 11px;  line-height:30px; text-decoration:none;border-left:1px solid #80c0e5}
#savediv{display: none;}
</style>
</head>
<body>
 <?php
 if(isset($message) && $message!=''){
                        echo '<div style="color:red;text-align:center;">'.$message.'</div>';
                    }  
?>
<form name="sampleForm" id="sampleForm" method="post" style="margin-top:0;margin-bottom:0;">
            <div id="sampleresult" name="sampleresult"><?php echo $sampleresult;?></div>
             <div id="auditresult" name="auditresult" style="color:blue;text-align:center;"><?php echo $auditresult;?></div>

             <input id="job_type" name="job_type" type="hidden" value="<?php echo $job_type_id;?>"> 
            <input type="hidden" name="maxtimelimit" id="maxtimelimit" value="<?php echo $maxtimelimit;?>">  
            <input type="hidden" name="mintimelimit" id="mintimelimit" value="<?php echo $mintimelimit;?>">   
            <input type="hidden" name="midfortimer" id="midfortimer" value="<?php echo $mid_for_timer;?>"> 
             <div id="add_to_me"></div><script src="protected\js\timerforall.js?v=8"></script> 
             <link rel="stylesheet" href="protected\css\timerforall.css">           
</body><div style="clear:both;"><!-- --></div></div>