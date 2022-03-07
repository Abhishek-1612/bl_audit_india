<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<html><head>
<title>Training Report</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:204px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:1px;border-style:solid;border-color:#0195d3;
}
</style>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script language="javascript">	
function empWiseDetail(start_date,dateflag,att_eid,vendor)
{	var url; 
                document.getElementById('quality'+dateflag+'').style.display = 'block';
                document.getElementById('quality'+dateflag+'').focus();
                document.getElementById('quality'+dateflag+'').innerHTML="<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....</DIV>";
                if(dateflag ===1 || dateflag === 3){
                url='index.php?r=admin_eto/LeapCallReport/TrainingReport&quality=1&start_date='+start_date+'&dateflag='+dateflag+'&att_id='+att_eid+'&vendor_approve='+vendor+'&vendor_audit=DDN&mid=3922';
                }else{
                url='index.php?r=admin_eto/LeapCallReport/TrainingReport&quality=1&start_date='+start_date+'&dateflag='+dateflag+'&att_id='+att_eid+'&vendor_approve='+vendor+'&vendor_audit='+vendor+'&mid=3922';
                }
        a={};
         result='';               
         $.ajax({
            url: url,
            type: 'post',
            data:a, 
            success:function(result){   
               document.getElementById('quality'+dateflag+'').style.display = 'block';
               document.getElementById('quality'+dateflag+'').innerHTML = result;
         }
    }); 
}

function trainingdetail(start_date,dateflag,t_id,vendor)
{	var url; 
                document.getElementById('training').style.display = 'block';
                document.getElementById('training').focus();
                document.getElementById('training').innerHTML="<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....</DIV>";
                url='index.php?r=admin_eto/LeapCallReport/TrainingReport&training=1&start_date='+start_date+'&dateflag='+dateflag+'&t_id='+t_id+'&vendor_approve='+vendor+'&vendor_audit=DDN&mid=3922';
                
        a={};
         result='';               
         $.ajax({
            url: url,
            type: 'post',
            data:a, 
            success:function(result){   
               document.getElementById('training').style.display = 'block';
               document.getElementById('training').innerHTML = result;
         }
    }); 
}
$(document).ready(
    function()
            {  
                $('#search').click(function(){
                    $('#training').html('');
                        a={};
                        a['vendor_id']=$('#vendor_id').val();                          
                        a['start_date']=$('#start_date').val();                        
                        a['end_date']=$('#end_date').val();
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
                   if(diffDays>7){
                        alert("Kindly Select Dates In Span Of 7 Days Only");
                        return false;
                    }                    
                       a['search']=$('#search').val();
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapCallReport/TrainingReport&mid=3922",
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
</script>
</head>
<body><input name="frame_height" id="frame_height" value="" type="hidden">
<form name="searchForm" id="searchForm" method="post" action="" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
                  <td bgcolor="#dff8ff" colspan="5" align="center"><font COLOR =" #333399"><b>LEAP Training Report</b></font>             
              </td>   
              </TR>
              <tr>
              <td WIDTH="20%">&nbsp;Start Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
	&nbsp;<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
              </td>
                
    <td WIDTH="20%">&nbsp;Vendor Name:</td>
<td> &nbsp;<select id="vendor_id">
 <?php $vendorArr1=array();
               if(count($vendorArr)==1){                                       
                     $vendor_name=key($vendorArr);
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('16'=>'COGENTBRB','15'=>'COGENTDNC','23'=>'COGENTPNS','4'=>'COMPETENT');
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('28'=>'KOCHARTECHAUTO','6'=>'KOCHARTECHCHN','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH','30'=>'KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('24'=>'RADIATEAUTO','1'=>'RADIATEDNC','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL');    
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('10'=>'VKALPAUTOIND','5'=>'VKALPDNC','11'=>'VKALPINTENT','29'=>'VKALPREVIEW');       
                      }else{
                          $vendorArr1 = $vendorArr;
                      }
                }else{
                        $vendorArr1 = $vendorArr;
                }
        foreach($vendorArr1 as  $key => $value)
        {
            if($value<>"ALL"){
            echo '<OPTION VALUE="'.$key.'" >'.$value.'</OPTION>';
            }
        } echo '</select>';

 ?>
    </select>
</td><td><input type="button" name="search" id="search" value="Search"></td>
     </tr>
     </TABLE> 
        <div id="quality1" ></div><br/>
        <div id="quality2" ></div><br/>
        <div id="quality3" ></div><br/>
        <div id="quality4" ></div>

    <div id="result" name="result"></div>
    <div id="training"></div>
</form>
               
</body>
</html>
