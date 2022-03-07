<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
  <html>
    <head>
      <title>Manage Leap Center Numbers</title>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js" ></script>
  </head>
      <body>
      <style>
	.td-label{font-size:18px;padding-right: 20px;}
      </style>
      <script type="text/javascript">
      setInterval(function () {
      	 $("#errMsg,#succMsg").delay(1000).hide(); }
      , 30000);
      function changeVal(){
			 if($('#is_working').is(":checked")){
     			$("#is_working").val(1);
     		}else{
				$("#is_working").val(0);     	
     		}     
      }
     
  			
			
	function checkFields(){
	    var phoneno = $("#add_number").val().trim();
            var vendortype = $("#vendor_type").val().trim();
	    var vendorname = $("#vendor_name").val().trim();
            var status= $("#add_status").val().trim();
            var channel= $("#channel").val().trim();
            var serviceprovider= $("#srvc_prvdr").val().trim();
	    var numberowner= $("#no_owner").val().trim();
            
	    if(phoneno == ''){
		alert("Please enter Phone Number");
		$("#add_number").focus();
		return false;
	    } 
            else if(!phoneno.match(/(\d+)$/)){
		alert("Invalid Phone Number");
		$("#add_number").focus();
		return false;
	    } 
             else if(vendortype == ''){
		alert("Please select Vendor Type");
		$("#vendor_type").focus();
		return false;
	    }
            else if(vendorname == ''){
		alert("Please select Vendor Name");
		$("#vendor_name").focus();
		return false;
	    } 
            else if(status == ''){
		alert("Please select Status");
		$("#add_status").focus();
		return false;
	    }
            else if(channel == ''){
		alert("Please select Channel");
		$("#channel").focus();
		return false;
	    }
            else if(serviceprovider == ''){
		alert("Please enter Service Provider");
		$("#srvc_prvdr").focus();
		return false;
	    }
            else if(numberowner == ''){
		alert("Please select Number Owner");
		$("#no_owner").focus();
		return false;
	    }
            else{
	      $("#vendorLoginAccess").submit();
	    }
	}
        
	function checkUpdateFields(){
	    var phoneno = $("#update_number").val().trim();
	    var status= $("#status1").val().trim();
           
           
	    if(phoneno == ''){
		alert("Please enter Phone Number");
		$("#number_").focus();
		return false;
	    }
            else if(!phoneno.match(/(\d+)$/)){
		alert("Invalid Phone Number");
		$("#emp_id_updt").focus();
		return false;
            }
            else if(status == ''){
		alert("Please select Status");
		$("#status").focus();
		return false;
	    }
	     else{
	      $("#updateVendorLoginAccess").submit();
	    }
	}
	function phoneDetails(update_number){
		$("#errMsg").hide();
		var number = $("#"+update_number).val();
		if(number == ""){
			alert("Please enter Phone Number");
			$("#update_number").focus();
			return false;		
		}
		 $.ajax({
                        url: "/index.php?r=admin_eto/Addnumber/LeapNumber&mid=<?php echo $cookie_mid;?>",
                        type: "POST",
                        data: {
                                action:'getphonenumber',
                                number:number					
                        },
                        //beforeSend: function(){$("#pttspanid"+ofrID).html("<img src='/public/images/spinner.gif'>");},
                        success:function (result) {
                            console.log(result);
                        	var res = $.parseJSON(result);
                                if(result.errmsg != ''){
                                    $("#errMsg").html(res.errmsg);
                                    $("#errMsg").show();                  	
                                    $("#succMsg").hide();                  	
                        	}
                        	// $.each(result,function(key,value) { });
                           
                         
var i=0;
$('#vendor_type1 option').each(function(){
    if($(this).val()==res['vendor_type']){
        i++;
       return false;}
    i++;});
document.getElementById('vendor_type1').getElementsByTagName('option')[i-1].selected = 'selected';

i=0;
$('#vendor_name1 option').each(function(){
    if($(this).val()==res['vendor_name']){
        i++;
       return false;}
    i++;});
document.getElementById('vendor_name1').getElementsByTagName('option')[i-1].selected = 'selected';

i=0;
$('#add_status option').each(function(){
    if($(this).val()==res['status']){
        i++;
       return false;}
    i++;});
document.getElementById('status1').getElementsByTagName('option')[i-1].selected = 'selected';

i=0;
$('#channel1 option').each(function(){
    if($(this).val()==res['channel']){
        i++;
       return false;}
    i++;});
document.getElementById('channel1').getElementsByTagName('option')[i-1].selected = 'selected';

i=0;
$('#no_owner1 option').each(function(){
    if($(this).val()==res['numberowner']){
        i++;
       return false;}
    i++;});
document.getElementById('no_owner1').getElementsByTagName('option')[i-1].selected = 'selected';

$('#srvc_prvdr1').val(res['serviceprovider']);
                        }
                        });
        
	}
      </script>	  
	      <div style="width:100%;font-size:23px;font-family:arial">
		  <div style="font-size:23px;background:#c70408;color:#ffffff;text-align:center;font-family:arial;padding:10px 0px">Manage Leap Center Numbers</div>
		  <div style="padding:10px;background:#edeaea;border:1px solid #cccccc; text-align:center;  background:#E0DDDD; vertical-align:top; box-shadow: 1px 3px 1px #cccccc;text-shadow:1px 1px 1px #ffffff; border:1px solid #ffffff;">
		  <div><span style='color:red;font-size:20px;display:none;' id="errMsg"></span>
 		    <span style='color:green;font-size:20px;display:<?php echo !empty($succMsg)?"block":"none"; ?>' id="succMsg"><?php echo $succMsg; ?></span>
 		    <span style='color:red;font-size:20px;display:<?php echo !empty($errMsg)?"block":"none"; ?>' id="errMsg"><?php echo $errMsg; ?></span>
 			  </div>
		    <div style="width:35%;display:inline-block; margin:10px 10px 0px 10px; ; vertical-align:top; border-right:dotted 1px #A09D9D">
		    <?php
 		    if($showForm == 1){?>
		    <form action="/index.php?r=admin_eto/Addnumber/LeapNumber&mid=<?php echo $cookie_mid;?>" method="post" name="vendorLoginAccess" id="vendorLoginAccess">
                        <input type="hidden" name="mid" value="<?php echo $cookie_mid;?>" >
                        
		      <table width="70%" border="0" align="center" cellpadding="3" cellspacing="0">
			<tbody>
			  <tr>
			    <td width="40%" align="right" class="td-label">Number</td>
			    <td align="left" width="50%">
			      <input style="width:80%;height:25px" id='add_number' name='add_number'></input>
			    </td>
			  </tr>  
			  <tr> 
                              <td width="40%" align="right" class="td-label">Vendor Type </td>
			   <td align="left" width="50%">
				<select id='vendor_type' name='add_vendor_type' style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
                                  <option value="LEAP">LEAP</option>
                                  </select>
                           </td>
                          </tr>
                        <tr>
			    <td width="40%" align="right" class="td-label">Vendor Name </td>
			   <td align="left" width="50%">
				<select id='vendor_name' name='add_vendor_name' style="width:83%;height:25px">
																	<option value="">--SELECT--</option>
																	<option value="VKALP">VKALP</option>
																	<option value="COMPETENT">COMPETENT</option>
																	<option value="KOCHARTECHINTENT">KOCHARTECHINTENT </option>
                                  <option value="RADIATE">RADIATE</option>
																	<option value="RADIATEINTENT">RADIATEINTENT</option>
																
				</select>
			    </td>
			  </tr>
			  <tr>
			    <td width="40%" align="right" class="td-label">Status </td>
			      <td align="left" width="50%">
				<select id='add_status' name='add_status' style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <option value="0">Inactive</option>
				  <option value="1">Active</option>
			      </select>
			    </td>
			  </tr> 
                           <tr>
                               <td width="40%" align="right" class="td-label">T_Channel </td>
			      <td align="left" width="50%">
				<select id='channel' name='add_channel' style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <option value="PRI">PRI</option>
				  <option value="GSM">GSM</option>
			      </select>
			    </td>
                            </tr>
                            <tr>
			    <td width="40%" align="right" class="td-label">Service Provider</td>
			    <td align="left" width="50%">
			      <input style="width:80%;height:25px" id='srvc_prvdr' name='add_srvc_prvdr'></input>
			    </td>
			  </tr> 
                            <tr>
			    <td width="40%" align="right" class="td-label">Number Owner </td>
			      <td align="left" width="50%">
				<select id='no_owner' name='add_no_owner' style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <option value="0">Vendor</option>
				  <option value="1">Indiamart</option>
			      </select>
			    </td>
			  </tr> 
			  <tr>
			    <td align="center" colspan="4" style="text-align:center;padding-top:20px">
			      <input type="button" value="Add Number" id='add_agent' name='add_number' onclick='checkFields();'>
			    </td>
			  </tr>
			</tbody>
		      </table>
		    </form> 
		    <?php } ?>
		  </div>

		<div style="width:35%; display:inline-block;  margin:10px 0px 0px 10px; ">
		<form action="/index.php?r=admin_eto/Addnumber/LeapNumber&mid=<?php echo $cookie_mid;?>" method="post" name="updateVendorLoginAccess" id="updateVendorLoginAccess">
		      <table width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
			<tbody>
			  <tr>
			    <td width="40%" align="right" class="td-label">Number</td>
			    <td align="left" width="50%" valign="top">
			      <input style="width:80%;height:25px" name="update_number" id="update_number">
			      <img src="/images/srch.jpg" style="vertical-align:middle; margin-left:4px;cursor:pointer;" onclick="phoneDetails('update_number');" title="Search Phone Number">
			    </td>
			  </tr>  
			  <tr> 
			    <td width="40%" align="right" class="td-label">Vendor Type </td>
			   <td align="left" width="50%">
                               <select id='vendor_type1' name='update_vendor_type' style="width:83%;height:25px" disabled="true" >
				  <option value="">--SELECT--</option>
                                  <option value="LEAP">LEAP</option>
                                  </select>
			    </td>
			  </tr>
               		<tr> 
			    <td width="40%" align="right" class="td-label">Vendor Name </td>
			   <td align="left" width="50%">
				<select id="vendor_name1"  name="update_vendor_name" style="width:83%;height:25px" disabled="true" >
																	<option value="">--SELECT--</option>
																	<option value="VKALP">VKALP</option>
																	<option value="COMPETENT">COMPETENT</option>
																	<option value="KOCHARTECHINTENT">KOCHARTECHINTENT </option>
                                  <option value="RADIATE">RADIATE</option>
																	<option value="RADIATEINTENT">RADIATEINTENT</option>
				  </select>
			    </td>
			  </tr>
			  <tr>
			    <td width="40%" align="right" class="td-label">Status</td>
                             <td align="left" width="50%">
				<select id='status1' name='update_status' style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <option value="0">Inactive</option>
				  <option value="1">Active</option>
			      </select>
			    </td>
			  </tr>
                           <tr>
			    <td width="40%" align="right" class="td-label">T_Channel </td>
			      <td align="left" width="50%">
				<select id='channel1' name='update_channel' style="width:83%;height:25px" disabled="true">
				  <option value="">--SELECT--</option>
				  <option value="PRI">PRI</option>
				  <option value="GSM">GSM</option>
			      </select>
                              </td>
			  </tr>
                          <tr>
			    <td width="40%" align="right" class="td-label">Service Provider</td>
			    <td align="left" width="50%">
			      <input style="width:80%;height:25px" id='srvc_prvdr1' name='update_srvc_prvdr' disabled="true"></input>
			    </td>
			  </tr>  
                           <tr>
			    <td width="40%" align="right" class="td-label" >Number Owner</td>
			      <td align="left" width="50%">
                                  <select id='no_owner1' name='update_no_owner' style="width:83%;height:25px" disabled="true">
				  <option value="">--SELECT--</option>
				  <option value="0">Vendor</option>
				  <option value="1">Indiamart</option>
			      </select>
			    </td>
			  </tr> 
              <input type="hidden" value="1" name="isUpdate" id="isUpdate">
			  <tr><td>&nbsp;</td>
			    <td align="left" style="text-align:center;padding-top:20px" class="td-label">
			      <input type="button" value="Update Number" name="update" id="update" onclick='checkUpdateFields();'>
			    </td>
			  </tr>
			</tbody>
		      </table>
		    </form></div>
			<div style="clear:both"></div>
	      </div>
	  </div>
      </body>
   </html>