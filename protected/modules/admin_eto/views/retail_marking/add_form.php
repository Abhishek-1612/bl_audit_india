<?php
if(isset($_REQUEST["rtype"])){
    $rtype=$_REQUEST["rtype"];
}else{
    $rtype='P';
}

$html = '';
$this->pageTitle=Yii::app()->name . ' - Add / Edit Retail On Quantity';
$ga="/index.php?r=admin_bl/Isq_edit_screen/mcat&mid=3504";	

echo '<html><head><style type="text/css">
.hdfield{font-size:15px; color:#2676d1;}
.admintext1 {font-family: arial;font-size: 12px; padding:0 5px;line-height:20px;}
.admintext2 {font-family: arial;font-size: 12px; font-weight: bold; padding:0 5px;line-height:20px;}
.search { width: 10em;  height: 2em;}
</style>	
	<!--google analytics async code start-->
  <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-28761981-2\']);
  _gaq.push([\'_setDomainName\', \'.intermesh.net\']);
  _gaq.push([\'_setSiteSpeedSampleRate\', 10]);
  _gaq.push([\'_trackPageview\',\''.$ga.'\']);
  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript">
function showdiv(){
            document.getElementById(\'div_quotes\').style.display = "block";
           
        }
        function addTextArea1(){
            var div = document.getElementById(\'div_quotes\');
            div.innerHTML = "";
            div.innerHTML += "\n<br />";
        }

 function lookup(idd,obj,divId) {
		
		$("#mcatsmain").css("display", "block");
		var inputString=$(\'#\'+idd).val();
                
		if(inputString.length == 0) {
			$(\'#\'+divId).html(\'<div></div>\');
		} else if(inputString.length > 2){
			if(/[.]/.test(inputString)){
				$(\'#\'+divId).html(\'<div></div>\');
			}
			else
			{
				var typ=\'\';
				
                                        var reportType=$(\'input[name="rtype"]:checked\').val();
                            				
                                $.post("/cron/rpc3.php", {queryString: ""+inputString+"", ff: ""+reportType+"",searchtype:""+obj+""}, function(data){
					if(data.length >0) {
						$(\'#\'+divId).html(data);
					}
					else{
						$(\'#\'+divId).html(\'<div></div>\');
					}

				});
                            
                            
			}
		}
		else if(inputString.length <=2){
			$(\'#\'+divId).html(\'<div></div>\');
		}
	}
	
	function abcMcats(mcatname,mcatid){
            
           mcat_name.value=mcatname;
           mcatid_sel.value=mcatid;
           $("#mcatsmain").hide();
           
        }
        
        function chechform()
        {
         if(mcat_name.value.trim() =="")
         {
          alert("Please Enter Mcat Name");
          return false;
         }
        }
        
</script>';
?>
    
    
<script>
function addretail(){
        a={};
        a['unitid']=$('#unitid').val();
        a['industry_id']=$('#industry_id').val();
        a['industry_type']=$('#industry_type').val();
        a['cutoff']=$('#cutoff').val();                            
        a['action']=$('#add').val();
        if(a['cutoff'] == ""){
            alert('Please Select Cut OFF');
        }else{
            $("#add").hide();          
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Retail_marking/Index",	
            data: a, 
            success: function(result) 	 	
            { 	 
                    $("#add_message").html(result);                     
            }
            , 	 	
            error: function(result) {
                    alert(result.responseText);
                    return false;
                    alert('Error occured');
                    result = false;
                    $("#add").show(); 
            } 	 	
            });   
        }
       
}

function Update(){
        a={};
        a['unitid']=$('#unitid').val();
        a['industry_id']=$('#industry_id').val();
        a['industry_type']=$('#industry_type').val();
        a['cutoff']=$('#cutoff').val();                            
        a['action']=$('#update').val();
        if(a['cutoff'] == ""){
            alert('Please Select Cut OFF');
        }else{
            $("#update").hide();          
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Retail_marking/Index",	
            data: a, 
            success: function(result) 	 	
            { 	 
                    $("#update_message").html(result);                     
            }
            , 	 	
            error: function(result) {
                    alert(result.responseText);
                    return false;
                    alert('Error occured');
                    result = false;
                    $("#update").show(); 
            } 	 	
            });   
        }
       
}

</script>
</head><body>
<?php
	echo '<TABLE bordercolor="#bedaff" border="1" cellpadding="4" class="table_txt" style="border-collapse: collapse; width:98%">
	<TR><TD colspan="2" bgcolor="#F0F9FF"><div ALIGN="CENTER" STYLE="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" width="70%">Add / Edit Retail Making Screen</div></TD></TR>
	<TR><TD width="30%" bgcolor="#F0F9FF">
	<FORM name="searchForm" METHOD="post" ACTION="" STYLE="margin-top:0;margin-bottom:0;" onsubmit="return chechform();">
	<input type="hidden" name="mid" value="'.$_REQUEST["mid"].'">
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
	<TR>';
echo '<td WIDTH="90%" class="admintext1"><b>MCAT:</b>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="TEXT" style="width:300px" class="admintext1" name="mcat_name" id="mcat_name" autocomplete="off" onkeyup="lookup(\'mcat_name\',\'MCAT\',\'mcats\');" value="'.$mcatName.'">
<INPUT TYPE="hidden" name="mcatid_sel" id="mcatid_sel" value="'.$mcat_id.'">';
if($rtype =='P' || $rtype =='')
{
 echo '<input type="radio" name="rtype" value="P" CHECKED>&nbsp;Product&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="radio" name="rtype" value="P">&nbsp;Product&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if($rtype =='S')
{
 echo '<input type="radio" name="rtype" value="S" CHECKED>&nbsp;Service&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
echo '<input type="radio" name="rtype" value="S">&nbsp;Service&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
 echo '<input type="hidden" name="action" value="Search"><INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Show Detail">
</TD>
</TR>
<TR>
<TD width="40%"><div id="mcatsmain" style="height:200px;overflow:auto;display:none; font-family: arial;font-size: 11px;width:500px;"><div id="mcats"></div></div></TD>
</TR>
</TABLE></TABLE></FORM><br><br>';
 $html = '<FORM name="retail_edit" METHOD="post" ACTION="index.php?r=admin_eto/Retail_marking/Index&mid='.$cookie_mid.'" STYLE="margin-top:0;margin-bottom:0;">';
      
 if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Search' && $mcat_id > 0)) 
 {
    $errMsg = $resultArr['errMsg'];
    $rec = $resultArr['rec'];
    $html_unit='';$value=$text='';
    while($rec_unit=$sth->read()){            
            if(isset($rec_unit['GL_UNIT_ID'])){
                    $value = $rec_unit['GL_UNIT_ID'];
            }
            if(isset($rec_unit['GL_UNIT_NAME'])){
                    $text = $rec_unit['GL_UNIT_NAME'];
            }
            if(isset($rec['FK_GL_UNIT_ID']) && ($rec['FK_GL_UNIT_ID']==$value)){
                $html_unit .= '<OPTION selected VALUE="'.$value.'">'.$text.'</OPTION>';
            }else{
                $html_unit .= '<OPTION VALUE="'.$value.'">'.$text.'</OPTION>';
            }
        }

        $html .='<table style="border-collapse: collapse;" width="99%" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" id="s">
             <th colspan="2" style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff">Add New Retail on Quantity</th>
                <tr><td class="admintext2">Unit ID:</td><td><select class="admintext1" width="100px" name="unitid" id="unitid">'.$html_unit.'</select></td></tr>
                <tr><td class="admintext2">Mcat ID:</td><td><input readonly type="text" class="admintext1" width="100px" value="'.$mcat_id.'" name="industry_id" id="industry_id"></td></tr>
                <tr><td class="admintext2">Industry type:</td><td><select class="admintext1" style="width:100px;" id="industry_type" name="industry_type"><option value="1">MCAT</option></select></td></tr>
                <tr><td class="admintext2">Qty Cutoff:</td><td><input type="text" class="admintext1" width="100px"  name="cutoff" id="cutoff" value=""></td></tr>               
                <tr>';
                if($user_edit ==1){
                    $html .='<td colspan="2" align="center"><input style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" type="button" name="add" id="add" value="Add" onClick="addretail()">
                <br><span id="add_message" style="width:500px">
                </td>';
                }else{
                    $html .='<td colspan="2" align="center"><font color="blue" size="3">You do not have Permission to add new Retial on Quantity.</font></td>';
                }
                $html .='</tr>
            </table>';       
       
         
    
    $html .='</FORM>';
 
   echo $html;
}
 
?>