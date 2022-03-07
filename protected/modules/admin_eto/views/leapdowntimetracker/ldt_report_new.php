<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<html><head>
<title>Leap Banned Keyword Report</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:204px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:1px;border-style:solid;border-color:#0195d3;
}
</style>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script>
$(document).ready(
    function()
            {  
                $('#search').click(function(){

                    var date1=$('#start_date').val();
                    var mdy = date1.split('-');
                    var date1=mdy[0] +' '+mdy[1]+' '+mdy[2];
                    var date1 = new Date(date1);

                    var date2=$('#end_date').val();
                    var mdy2 = date2.split('-');
                    var date2=mdy2[0] +' '+mdy2[1]+' '+mdy2[2];
                    var date2 = new Date(date2);
                    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    if(diffDays>7)
                    {
                        alert('Please Select maximum 7 days difference Only');
                        return false;
                    }
                        a={};
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['search']=$('#search').val();
                        a['ban_reason']=$('#ban_reason').val();
                        a['key_category']=$('#key_category').val();
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapDowntimeTracker/flaggedbankeyword&mid=3711",
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

    function Detail(type,divid,bdate,edate,newdate,ban_reason,key_category){
        document.getElementById(divid).style.display = 'block';
        document.getElementById(divid).focus();
        document.getElementById(divid).innerHTML="<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....</DIV>";


        url='/index.php?r=admin_eto/LeapDowntimeTracker/FlaggedBanKeyword&detail='+newdate+'&start_date='+bdate+'&end_date='+edate+'&mid=3711&ban_reason='+ban_reason+'&key_category='+key_category;
                             a={};
                             result='';               
                             $.ajax({
                                url: url,
                                type: 'post',
                                data:a, 
                                success:function(result){    
                                   document.getElementById(divid).style.display = 'block';
								document.getElementById(divid).innerHTML = result;  
                            }
										});
        }


function showSearch(offer) 
{        
  window.open('/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='+offer+'&go=Go&mid=3424&ban=1','_blank');
}
</script>
</head>
<body>
    <input name="frame_height" id="frame_height" value="" type="hidden">
<form name="searchForm" id="searchForm" method="post" action="" style="margin-top:0;margin-bottom:0;">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
                  <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Leap Banned Keyword Report</b></font>             
              </td>   
              </TR>
              <tr>
              <td WIDTH="20%">&nbsp;Issue Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="end_date" type="text" VALUE="<?php echo $end_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;              
                     <select name="ban_reason" id="ban_reason"><OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="A">Approved</option>
                        <option value="R">Deleted</option><option value="E">Expired</option></select>&nbsp;&nbsp;&nbsp;
                        
                      <select name="key_category" id="key_category"><OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="2">Adult</option>
                        <option value="4">Drug</option><option value="3">Trademark</option></select>
             
              </td>
     </tr>      
    <tr><TD colspan="4" align="center">
    <input type="button" name="search" id="search" value="Search">
    <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"> </div>
    </TD>
    </TR>
    </TABLE> 
    <div id="result" name="result"></div>
</form>
</body>
</html>
