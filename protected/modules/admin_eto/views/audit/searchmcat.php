<head>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(
    function()
            {            
                $('#search').click(function(){  alert($('#ss').val());               
                        a={};
                         a['ss']=$('#ss').val();
                         result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/AuditEto/SearchMcat/",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#sampleresult").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='http://my.imimg.com/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#sampleresult').html(result);                   
                            }
                        });                   
                    });                   
            }
);
</script>
</head>
<body>
<form>
 <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
<tr><td class="tt" width="20%" style="vertical-align:middle;color: #08c;font-weight: bold;line-height: 20px;font-size: 14px;text-align: left;">
Sugg. MCAT</td><td  style="border:0px;" class="tt" ><input type="text" size="20" id="ss" value="" style="font-size: 14px;font-weight: normal;line-height: 20px;"></td>
<td style="border:0px;" class="tt"><input type="button" name="search" id="search" value="Go">
</td>
</tr>
</table>
</form><br>
<div id="sampleresult"></div>
</body>