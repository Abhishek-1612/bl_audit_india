var country_iso = '';
$(document).ready(function(){
	country_iso = $("#country_iso").val();
});

$(window).load(function(){
	call_suggester();
});

function changetext()
{
        document.getElementById('chnge_txt').value=1;
}
function chng_textval()
{
        document.getElementById('chnge_txt').value=2;
}

function q_http_val(val)
{
    if(val.length<11 && val!='http://www.')
    {
        document.getElementById('url').value='http://www.';
    }
}

function showimage(Form,name,show)
{
if (name !='NO')
{
        switch (name)
        {
	case "url":
	if((document.getElementById('url').value=='' || document.getElementById('url').value=='http://www.') && (show=='show'))
	{
		document.getElementById('url').value='';
        }
	else
	{
        	 //   document.form1.GLUSR_USR_URL.className='home_style';
        }
                break;
        }
}
}


function updateval()
{

if(!document.getElementById('email').value && document.getElementById('alt_email').value)
{
document.getElementById('email').value=document.getElementById('alt_email').value;
document.getElementById('alt_email').value='';
}


if(!document.getElementById('ph_area').value && document.getElementById('ph_area2').value)
{
document.getElementById('ph_area').value=document.getElementById('ph_area2').value;
document.getElementById('ph_area2').value='';
}


if(!document.getElementById('Ph_phone').value && document.getElementById('Ph_phone1').value)
{
document.getElementById('Ph_phone').value=document.getElementById('Ph_phone1').value;
document.getElementById('Ph_phone1').value='';
}

if(!document.getElementById('mobile1').value && document.getElementById('mobile2').value)
{
document.getElementById('mobile1').value=document.getElementById('mobile2').value;
document.getElementById('mobile2').value='';
}
var i=0;
    if(document.getElementById('country_iso').value == 'IN'){ 
	if(!document.getElementById('mobile1').value)
	{
		alert("Mobile is missing");
		document.getElementById('mobile1').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
	}
    }else{
        if(!document.getElementById('email').value)
	{
		alert("Email is missing");
		document.getElementById('email').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
	}
    }	
	
	
	var myPh_area =  $('#ph_area').val();
	phAreaNumber = ($("#Ph_phone").val() + $("#ph_area").val());
	
	if(isNaN(myPh_area))
	{
		alert("Area Code should be Numeric");
					document.getElementById('ph_area').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
	} else if($('#country_iso').val() == 'IN' && /^[9]/gm.test(myPh_area)) 
        {
        alert("Invalid Phone Number");
			document.getElementById('ph_area').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
        }
	else if($('#country_iso').val() == 'IN' && $("#Ph_phone").val() != "" && myPh_area == "") 
        {
        	document.getElementById('ph_area').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
        }
        else if(($('#country_iso').val() == 'IN' && phAreaNumber.length != 10 && phAreaNumber.length > 0) || ($('#country_iso').val() == 'IN' && /^[0189]/gm.test($("Ph_phone").val())))
	{
	document.getElementById('ph_area').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
	}
	//
	var myPh_phone =  $('#Ph_phone').val();
	var phAreaNumber = ($("#Ph_phone").val() + $("#ph_area").val());	
	if($('#country_iso').val() == 'IN' && $("#ph_area").val() == "" && myPh_phone != "") 
        {
        	alert("Invalid Area Code");
        	Form.Ph_phone.focus();
			return false;
        }
	else if(($('#country_iso').val() == 'IN' && phAreaNumber.length != 10 && phAreaNumber.length > 0) || ($('#country_iso').val() == 'IN' && /^[0189]/gm.test(myPh_phone)))
	{
		alert("Invalid Phone Number");
        	Form.Ph_phone.focus();
			return false;
	}
	else if($('#country_iso').val() != 'IN' && myPh_phone.length > 15)
	{
		alert("Invalid Phone Number");
        	Form.Ph_phone.focus();
			return false;
	}
	else if(isNaN(myPh_phone))
	{
		alert("Invalid Phone Number");
		Form.Ph_phone.focus();
			return false;
	} 
	else if($('#country_iso').val() == 'IN' && /^[9]/gm.test(myPh_phone)) 
        {
        	alert("Invalid Phone Number");
		Form.Ph_phone.focus();
			return false;
        }
	 
	//
	var myPh_area2 =  $('#ph_area2').val();
	var phAreaNumber = ($("#Ph_phone1").val() + $("#ph_area2").val());
	if(isNaN(myPh_area2))
	{
		alert("Area Code should be Numeric value");
			document.getElementById('ph_area2').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
	} 
	else if($('#country_iso').val() == 'IN' && /^[9]/gm.test(myPh_area2)) 
        {
        alert("Invalid Phone Number");
		document.getElementById('Ph_phone1').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
        }
	else if($('#country_iso').val() == 'IN' && $("#Ph_phone1").val() != "" && myPh_area2 == "") 
        {
        	alert("Invalid Area Code");
		document.getElementById('ph_area2').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
        }
        else if(($('#country_iso').val() == 'IN' && phAreaNumber.length != 10 && phAreaNumber.length > 0) || ($('#country_iso').val() == 'IN' && /^[0189]/gm.test($("Ph_phone1").val())))
	{
		alert("Invalid Phone Number");
        document.getElementById('Ph_phone1').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
	}
    
	var myPh_phone1 =  $('#Ph_phone1').val();
	var phAreaNumber = ($("#Ph_phone1").val() + $("#ph_area2").val());
	if($('#country_iso').val() == 'IN' && $("#ph_area2").val() == "" && myPh_phone1 != "") 
        {
        	alert("Invalid Area Code");
        	document.getElementById('Ph_phone1').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
        }
	else if(($('#country_iso').val() == 'IN' && phAreaNumber.length != 10 && phAreaNumber.length > 0) || ($('#country_iso').val() == 'IN' && /^[0189]/gm.test(myPh_phone1)))
	{
		alert("Invalid Phone Number");
        	document.getElementById('Ph_phone1').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
	}
	else if($('#country_iso').val() != 'IN' && myPh_phone1.length > 15)
	{
		alert("Invalid Phone Number");
        document.getElementById('Ph_phone1').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
	}
	else if(isNaN(myPh_phone1))
	{
					alert("Invalid Phone Number");
					document.getElementById('Ph_phone1').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
	} 
	else if($('#country_iso').val() == 'IN' && /^[9]/gm.test(myPh_phone1)) 
        {
        			alert("Invalid Phone Number");
					document.getElementById('Ph_phone1').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
        }		
  
	if(document.getElementById('country_iso').value == 'IN')
	{
		if(document.getElementById('city_others').value && !document.getElementById('city').value)
		{
			alert("City name exists but city ID is blank");
			document.getElementById('city_others').focus();
               document.getElementById('Reviewed').checked=false;
               i = 1;
		}
	}
	
	//
	var myMobile1 =  $('#mobile1').val();
	myMobile1 = myMobile1.replace(/ /g,"");
	if(myMobile1.trim() == '' && $('#country_iso').val() == 'IN')
	{
		alert("Invalid Mobile Number");
		document.getElementById('mobile1').focus();
				document.getElementById('Reviewed').checked=false;
				i = 1;
	}
	else if((myMobile1.length != 10 || /^[012345]/gm.test(myMobile1)) && $('#country_iso').val() == 'IN')
	{
		alert("Invalid Mobile Number");
		document.getElementById('mobile1').focus();
				document.getElementById('Reviewed').checked=false;
				i = 1;
	}
	else if(isNaN(myMobile1))
	{
		alert("Invalid Mobile Number");
		document.getElementById('mobile1').focus();
				document.getElementById('Reviewed').checked=false;
				i = 1;
	}
	var myMobile2 =  $('#mobile2').val();
	myMobile2 = myMobile2.replace(/ /g,"");	
	if(((myMobile2.length != 10 && myMobile2.trim() != '') || /^[012345]/gm.test(myMobile2)) && $('#country_iso').val() == 'IN')
	{		
		alert("Invalid Mobile Number");
		document.getElementById('mobile2').focus();
				document.getElementById('Reviewed').checked=false;
				i = 1;
	}
	else if(isNaN(myMobile2))
	{
		alert("Invalid Mobile Number");
		document.getElementById('mobile2').focus();
				document.getElementById('Reviewed').checked=false;
				i = 1;
	}

	if(document.getElementById('country_iso').value == 'IN')
	{
		if(document.getElementById('city_others').value && !document.getElementById('city').value)
		{
			alert("City name exists but city ID is blank");
			document.getElementById('city_others').focus();
			document.getElementById('Reviewed').checked=false;
			i = 1;
		}
	}
	if(document.getElementById('country_iso').value == 'IN')
	{
		if(document.getElementById('ph_area').value && !document.getElementById('city_others').value)
		{
			alert("STD code exists but City Name is blank");
			document.getElementById('city_others').focus();
			document.getElementById('Reviewed').checked=false;
			i = 1;
		}
	}
	if(document.getElementById('country_iso').value == 'IN')
	{
		if((document.getElementById('Pin')) && document.getElementById('Pin').value !='')
		{	
			if(!(/^[0-9]+$/.test(document.getElementById('Pin').value)))
			{
			alert ("Kindly enter numeric value in Pin Code.");
			document.getElementById('Reviewed').checked=false;
			i = 1;
			}
			if(document.getElementById('Pin').value.length != 6)
			{
			alert ("Pincode should be 6 digit.");
			document.getElementById('Reviewed').checked=false;
			i = 1;
			}
		}
	}
// check for website format on 25th sept
var validarr='';


	if ((document.getElementById('url').value) && document.getElementById('url').value.length != 0)
            {
                if(document.getElementById('url').value.indexOf(" ") != -1)    {
                alert("Kindly enter correct URL without any spaces in it.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
                if(document.getElementById('url').value.indexOf("@") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
                if(document.getElementById('url').value.indexOf(".") == -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
                if(document.getElementById('url').value.indexOf("..") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
                if(document.getElementById('url').value.indexOf(",") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
                if(document.getElementById('url').value.indexOf("_") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
		if(document.getElementById('url').value.indexOf("/.") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
// 		if(document.form1.GLUSR_USR_URL.value.indexOf("\/") != -1)    {
//                 alert("Invalid Website ! Kindly enter correct website.");
//                 document.form1.GLUSR_USR_URL.focus();
// 		return false;
//                 }

                validarr = document.getElementById('url').value.split(".");

                if(validarr && validarr.length<3)       {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
                if(validarr[0].indexOf("www") == -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
		if(validarr[0].indexOf("wwww") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
                if(validarr[0] && validarr[0].length<2)       {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
                if(validarr[1] && validarr[1].length<2)       {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
                if( validarr[2].length<2)       {
                alert("Invalid Website ! Kindly enter correct website.");
                document.getElementById('url').focus();
		document.getElementById('Reviewed').checked=false;
		i = 1;
                }
            }

// chck end
	if(i == 0)
	{
		var warnmsg='';
	
		if(document.getElementById('country_iso').value != 'IN')
		{
			if(document.getElementById('city_others').value && !document.getElementById('city').value)
			{
				warnmsg=" City name exists but city ID is blank \n" ;
			}
		}
		if(document.getElementById('url').value && !document.getElementById('company').value)
		{
			warnmsg = warnmsg + " URL exists but Company Name is blank \n" ;
			
		}
		if(document.getElementById('url').value && !document.getElementById('Address1').value)
		{
			warnmsg = warnmsg + " URL exists but Address is blank \n" ;
		}
		if(document.getElementById('url').value && !document.getElementById('city_others').value)
		{
			warnmsg = warnmsg + " URL exists but City is blank \n";
		}
		if(document.getElementById('email_sugg').value)
		{
			var email_sug=document.getElementById('email_sugg').value;
			var email=document.getElementById('email').value;
			var domain_val=document.getElementById('domain_name').value;
			var new_email=email.replace(domain_val,email_sug);
			warnmsg = warnmsg + "Valid Email should be " + new_email + "\n";
		}
// 		alert(document.frmfreequery.sendername.value);
// 		alert(parent.document.frmfreequery.sendername.value);
		var s_name ='';

		var fname='';
		var lname='';
		var usr_name='';
		
		fname = $('#txtfname').val();
		lname = $('#txtlname').val() ;
		

			if($("#sender_name").val())
			{
				s_name = $("#sender_name").val().trim();
			}

		usr_name = fname +  lname ;
		usr_name = usr_name.replace(/\s/g,'');
		s_name = s_name.replace(/\s/g,'');
		s_name = s_name.toLowerCase();
		usr_name =usr_name.toLowerCase();

		if(s_name) {
			if(s_name != usr_name) {
				warnmsg = warnmsg + "Contact Person Name in GL User not Matching with S_Details";
			}
		}
		if(warnmsg) {
			alert(warnmsg);
		}
	}
	var email_val=document.getElementById('email').value;
	var m = email_val.indexOf("@airtelmail.in");
	if (m != -1) //this will be true if the address contains indiatimes.com
	{
		alert("\"Airtel\" Domain\nKindly Flag The lead");
	}
	
}

function ajaxFunction()
        {
                var xmlHttp;
                try
                {	// Firefox, Opera 8.0+, Safari
                        xmlHttp=new XMLHttpRequest();
                }
                catch (e){// Internet Explorer
                        try
                        {
                                xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                        }
                        catch (e)
                        {
                                try
                                {
                                        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                                }
                                catch (e)
                                {
                                        alert("Your browser does not support AJAX!");
                                        return false;
                                }
                        }
                }
                return xmlHttp;
        }

function checkDuplicateMobile(glusrID,glusrPhCntryCode,glusrPhMobile) {
	var duplicatGlusrCount;
	glusrPhCntryCode = glusrPhCntryCode.replace(/\+/g,'');
	$.ajax({
                url: "/index.php?r=admin_eto/EtoAjax/CheckDuplicateMobile",
                type: "POST",
                async: false,
                data: {
                        action:'checkDuplicateMobile',
                        glusrID:glusrID,
                        glusrPhCntryCode:glusrPhCntryCode,
                        glusrPhMobile:glusrPhMobile
                },
		success:function (response) {
			response = $.parseJSON(response);
			count = response[0].CNT;
			htmlData = '<input name="dupusrcnt" id="dupusrcnt" value="'+count+'" type="hidden">';
			$('#chdupmob1').html(htmlData);
			duplicatGlusrCount =  parseInt($('#dupusrcnt').val());
			if(duplicatGlusrCount > 0 )
			{
				alert("Duplicate Mobile Number! Kindly Flag this Lead under Mobile Already Exists");
				flagDupMob = 0;
				$('#dupmobcount').val(duplicatGlusrCount);
				$('#Reviewed').attr('checked',false);
				$('#chdupmob').hide();
				window.location.href="#mobile1";
				$("#mobile1").focus();
				return false;
			} else {
				$('#dupmobcount').val(0);
				flagDupMob = 1;
				$('#chdupmob').hide();
			}
		},
		error:function(response){
			document.getElementById('chdupmob').style.display='inline';
		},
	});
}


function popup(url) {
             window.open(url,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=500,height=350');
        }

function capturekey(e,t)
{
	var code;
	if(!e) var e = window.event;
	if(e.keyCode)
	{
		code = e.keyCode;
	}
	else if(e.which)
	{
		code = e.which;
	}
	if (code == 118)
	{
			// F7
			//	var myVar = document.selection.createRange().text;
			//	alert (myVar);
			//alert(t.value);

			t.value = t.value.toUpperCase();
			t.select();
			return false;
	}
	else if (code == 119)
	{
			// F8
			t.value = t.value.toLowerCase();
			t.select();
			return false;
	}
	else if (code == 120)
	{
			// F9
			t.value = sCase(t.value);
			t.select();
			return false;
	}
	else if (code == 113)			{
			// F2
			changeCase(t,'chk');
			t.select();
			return false;
	}
}

function changeCase(frmObj,flag)
{
	var index;
	var tmpStr;
	var tmpChar;
	var preString;
	var postString;
	var strlen;
	tmpStr = frmObj.value.toLowerCase();
	strLen = tmpStr.length;
	if (strLen > 0)
	{
		for (index = 0; index < strLen; index++)
		{
			if (index == 0)  {
				tmpChar = tmpStr.substring(0,1).toUpperCase();
				postString = tmpStr.substring(1,strLen);
				tmpStr = tmpChar + postString;
			}
			else
			{
				tmpChar = tmpStr.substring(index, index+1);
				if (tmpChar == " " && index < (strLen-1))
				{
					tmpChar = tmpStr.substring(index+1, index+2).toUpperCase();
					preString = tmpStr.substring(0, index+1);
					postString = tmpStr.substring(index+2,strLen);
					tmpStr = preString + tmpChar + postString;
				}

			}

		}
	}
	if (flag=='chk')
	{
		frmObj.value = tmpStr;
	}
	else
	{
		return tmpStr;
	}


}
function sCase(text_val)
{

		result=new Array();
		result2='';
		count=0;
		endSentence=new Array();
		for (var i=1;i<text_val.length;i++)
		{
			if(text_val.charAt(i)=='.'||text_val.charAt(i)=='!'||text_val.charAt(i)=='?')
			{
				endSentence[count]=text_val.charAt(i);
				count++
			}
		}
		var val2=text_val.split(/[.|?|!]/);
		if(val2[val2.length-1]=='')val2.length=val2.length-1;
		for (var j=0;j<val2.length;j++)
		{
			val3=val2[j];
			if(val3.substring(0,1)!=' ')val2[j]=' '+val2[j];
			var temp=val2[j].split(' ');
			var incr=0;
			if(temp[0]=='')
			{
				incr=1;
			}
			temp2=temp[incr].substring(0,1);
			temp3=temp[incr].substring(1,temp[incr].length);
			temp2=temp2.toUpperCase();
			temp3=temp3.toLowerCase();
			temp[incr]=temp2+temp3;
			for (var i=incr+1;i<temp.length;i++)
			{
				temp2=temp[i].substring(0,1);
				temp2=temp2.toLowerCase();
				temp3=temp[i].substring(1,temp[i].length);
				temp3=temp3.toLowerCase();
				temp[i]=temp2+temp3;
			}
			if(endSentence[j]==undefined)endSentence[j]='';
			result2+=temp.join(' ')+endSentence[j];
		}
		if(result2.substring(0,1)==' ')result2=result2.substring(1,result2.length);
		return result2;

}





function chckUpdt(Form)
{
	if($("#Reviewed").prop("checked") == false){
		alert("Kindly check Reviewed Button");
		$("#Reviewed").focus();
		return false;
	}
	if((Form.txtfname) && Form.txtfname.value == ""){
			alert("Kindly enter First Name");
			Form.txtfname.focus();
			return false;
	} else if($("#txtfname").val() == 'Manager')
	{
		 alert("Invalid Buyer Name");
			$("#txtfname").focus();
			return false;
	} else if($("#txtfname").val().match(/\d/g) || $("#txtfname").val().match(/_/g))
	{
		 alert("Invalid Buyer Name");
			$("#txtfname").focus();
			return false;
	}
	else if($("#txtlname").val().match(/\d/g) || $("#txtlname").val().match(/_/g))
	{
		 alert("Invalid Buyer Name");
			$("#txtfname").focus();
			return false;
	}
	var myEmail =  $('#email').val().trim();
        if($('#country_iso').val() != 'IN'){
            if(myEmail == '')
            {
                    alert("Please enter Email.");
                    $("#email").focus();
                    return false;
            }
        }
	if((Form.country_name) && Form.country_name.value == ""){
			alert("Kindly enter Country Name");
			Form.country_name.focus();
			return false;
		}
		if($('#country_iso').val() == 'IN')
        {
        	 if($('#ph_area').val() && $('#city_others').val() == '') {
				alert("STD code exists but City Name is blank"); 
				Form.city_others.focus();
				return false;
		 } 
		 if((Form.Pin) && Form.Pin.value !='')
		{	
			if(!(/^[0-9]+$/.test(Form.Pin.value)))
			{
			alert ("Kindly enter numeric value in Pin Code.");
			Form.Pin.focus();
			return false;
			}
			if(Form.Pin.value.length != 6)
			{
			alert ("Pincode should be 6 digit.");
			Form.Pin.focus();
			return false;
			}
		}
		}

	if(Form.Address1.value.length > 100)
	{
		alert("Address1 length should not be greater than 100 character");
		Form.Address1.focus();
		return false;
	}
	if(Form.Address2.value.length > 100)
	{
		alert("Address2 length should not be greater than 100 character");
		Form.Address2.focus();
		return false;	
	}
	var myPh_area =  $('#ph_area').val();
	phAreaNumber = ($("#Ph_phone").val() + $("#ph_area").val());
	
	if(isNaN(myPh_area))
	{
		alert("Area Code should be Numeric");
					Form.ph_area.focus();
					return false;
	} else if($('#country_iso').val() == 'IN' && /^[9]/gm.test(myPh_area)) 
        {
        alert("Invalid Phone Number");
			Form.ph_area.focus();
			return false;
        }
	else if($('#country_iso').val() == 'IN' && $("#Ph_phone").val() != "" && myPh_area == "") 
        {
        	alert("Invalid Area Code");
		Form.ph_area.focus();
					return false;
        }
        else if(($('#country_iso').val() == 'IN' && phAreaNumber.length != 10 && phAreaNumber.length > 0) || ($('#country_iso').val() == 'IN' && /^[0189]/gm.test($("Ph_phone").val())))
	{
		alert("Invalid Phone Number");
			Form.Ph_phone.focus();
			return false;
	}
	var myPh_phone =  $('#Ph_phone').val();
	var phAreaNumber = ($("#Ph_phone").val() + $("#ph_area").val());	
	if($('#country_iso').val() == 'IN' && $("#ph_area").val() == "" && myPh_phone != "") 
        {
        	alert("Invalid Area Code");
        	Form.Ph_phone.focus();
			return false;
        }
	else if(($('#country_iso').val() == 'IN' && phAreaNumber.length != 10 && phAreaNumber.length > 0) || ($('#country_iso').val() == 'IN' && /^[0189]/gm.test(myPh_phone)))
	{
		alert("Invalid Phone Number");
        	Form.Ph_phone.focus();
			return false;
	}
	else if($('#country_iso').val() != 'IN' && myPh_phone.length > 15)
	{
		alert("Invalid Phone Number");
        	Form.Ph_phone.focus();
			return false;
	}
	else if(isNaN(myPh_phone))
	{
		alert("Invalid Phone Number");
		Form.Ph_phone.focus();
			return false;
	} 
	else if($('#country_iso').val() == 'IN' && /^[9]/gm.test(myPh_phone)) 
        {
        	alert("Invalid Phone Number");
		Form.Ph_phone.focus();
			return false;
        }
	 
	//
	var myPh_area2 =  $('#ph_area2').val();
	var phAreaNumber = ($("#Ph_phone1").val() + $("#ph_area2").val());
	if(isNaN(myPh_area2))
	{
		alert("Area Code should be Numeric value");
		Form.ph_area2.focus();
			return false;
	} 
	else if($('#country_iso').val() == 'IN' && /^[9]/gm.test(myPh_area2)) 
        {
        alert("Invalid Phone Number");
		Form.Ph_phone1.focus();
			return false;
        }
	else if($('#country_iso').val() == 'IN' && $("#Ph_phone1").val() != "" && myPh_area2 == "") 
        {
        	alert("Invalid Area Code");
		Form.ph_area2.focus();
			return false;
        }
        else if(($('#country_iso').val() == 'IN' && phAreaNumber.length != 10 && phAreaNumber.length > 0) || ($('#country_iso').val() == 'IN' && /^[0189]/gm.test($("Ph_phone1").val())))
	{
		alert("Invalid Phone Number");
        	Form.Ph_phone1.focus();
			return false;
	}
    
	var myPh_phone1 =  $('#Ph_phone1').val();
	var phAreaNumber = ($("#Ph_phone1").val() + $("#ph_area2").val());
	if($('#country_iso').val() == 'IN' && $("#ph_area2").val() == "" && myPh_phone1 != "") 
        {
        	alert("Invalid Area Code");
        	Form.Ph_phone1.focus();
			return false;
        }
	else if(($('#country_iso').val() == 'IN' && phAreaNumber.length != 10 && phAreaNumber.length > 0) || ($('#country_iso').val() == 'IN' && /^[0189]/gm.test(myPh_phone1)))
	{
		alert("Invalid Phone Number");
        	Form.Ph_phone1.focus();
			return false;
	}
	else if($('#country_iso').val() != 'IN' && myPh_phone1.length > 15)
	{
		alert("Invalid Phone Number");
        Form.Ph_phone1.focus();
			return false;
	}
	else if(isNaN(myPh_phone1))
	{
		alert("Invalid Phone Number");
		Form.Ph_phone1.focus();
			return false;
	} 
	else if($('#country_iso').val() == 'IN' && /^[9]/gm.test(myPh_phone1)) 
        {
        	alert("Invalid Phone Number");
		Form.Ph_phone1.focus();
			return false;
        }		
  
	if(document.getElementById('country_iso').value == 'IN')
	{
		if(document.getElementById('city_others').value && !document.getElementById('city').value)
		{
			alert("City name exists but city ID is blank");
			document.getElementById('city_others').focus();
			return false;
		}
	}
	
// check for website format on 25th sept
var validarr='';
	if ((Form.url.value) && Form.url.value.length != 0)
            {
                if(Form.url.value.indexOf(" ") != -1)    {
                alert("Kindly enter correct URL without any spaces in it.");
                Form.url.focus();
                return false;
                }
                if(Form.url.value.indexOf("@") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
                return false;
                }
                if(Form.url.value.indexOf(".") == -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
               return false;
                }
                if(Form.url.value.indexOf("..") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
                return false;
                }
                if(Form.url.value.indexOf(",") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
		return false;
                }
                if(Form.url.value.indexOf("_") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
		return false;
                }
		if(Form.url.value.indexOf("/.") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
		return false;
                }
// 		if(document.form1.GLUSR_USR_URL.value.indexOf("\/") != -1)    {
//                 alert("Invalid Website ! Kindly enter correct website.");
//                 document.form1.GLUSR_USR_URL.focus();
// 		return false;
//                 }

                validarr = Form.url.value.split(".");

                if(validarr && validarr.length<3)       {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
		return false;
                }
                if(validarr[0].indexOf("www") == -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
		return false;
                }
		if(validarr[0].indexOf("wwww") != -1)    {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
                return false;
                }
                if(validarr[0] && validarr[0].length<2)       {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
                return false;
                }
                if(validarr[1] && validarr[1].length<2)       {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
                return false;
                }
                if( validarr[2].length<2)       {
                alert("Invalid Website ! Kindly enter correct website.");
                Form.url.focus();
                return false;
                }
            }
	if(document.getElementById('email_sugg').value)
	{
		var email_sug=document.getElementById('email_sugg').value;
		var email=document.getElementById('email').value
		var domain_val=document.getElementById('domain_name').value;
		var new_email=email.replace(domain_val,email_sug);
		var msg1 = "Valid Email should be " + new_email + "\n";
		alert(msg1);
	}

// chck end
	var glusrID = $('#glusr_id').val();
	var glusrPhMobile = $('#mobile1').val();
	var glusrPhCntryCode = $('#ph_country').val();
	checkDuplicateMobile(glusrID,glusrPhCntryCode,glusrPhMobile);
	var DupMobileCount = document.getElementById('dupmobcount').value;
	if(DupMobileCount >0)
	{
		return false;
	}

return true;	
}



function createRequestObject()
{
var req;
    try
    {
	    req = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e)
    {
	    try
	    {
		    req = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    catch(oc)
	    {
		    req = null;
	    }
    }
    if(!req && typeof XMLHttpRequest != "undefined")
    {
	    req = new XMLHttpRequest();
    }
    return (req);
}

var http = createRequestObject();

 var res_status=0;

function ShowCity(populate,id)
{
	//alert (populate+'----------,'+data12)

     var len =data12.length;
    var i=0;
    var j=0;
    var k=0;
    var code=0;
    var count=0;
    var short='';
    len=len+1;

	for(i=0;i<=len;i++)
	{
		if(data12[i]!=undefined)
		{
		var myvalue=data12[i].toString();
		if(isNaN(myvalue))
		{
		populate=populate.replace(/&gt;/g,">");
		populate=populate.replace(/&amp;/g,"&");
		myvalue=myvalue.replace(/[^0-9A-Za-z]/g,"");
		populate=populate.replace(/[^0-9A-Za-z]/g,"");
		populate=populate.toLowerCase();
		myvalue=myvalue.toLowerCase();


		if(myvalue == populate)
		{

			count=1;
			j=i+1;
			code=data12[i];
			var arr=data12[i].split(/ \>\> /);
			document.getElementById("city_others").value=arr[0];
			document.getElementById("city").value=data12[j];
			if(arr[1])
			{
			document.getElementById("state_others").value=arr[1];
			}
			document.getElementById("state").value=data12[j+1];
			AutoComplete_HideDropdown('city_others');
			break;
			//alert(short);
		}
		}
		}
		if(i==len-2)
		{
			if(count==0)
			{
			document.getElementById("city").value='';
			document.getElementById("state").value='';
			}
		}

	}


    }


function Showonblur1(id,val)
{

	id="city_others";
	var lower = val.toLowerCase();
	val=lower.substr(0,1).toUpperCase() + lower.substr(1);
	if (__AutoComplete[id] !=undefined)
	{
	if (__AutoComplete[id]['highlighted'] == null) {
            if(__AutoComplete[id]['dropdown'].childNodes[0])
		{
            __AutoComplete[id]['dropdown'].childNodes[0].className = 'autocomplete_item_highlighted';
	    	}
            __AutoComplete[id]['highlighted'] = 0;

        }
	if (__AutoComplete[id]['highlighted'] == null && val=='') {
		AutoComplete_HideDropdown(id);
		document.getElementById("city_others").value='';
		document.getElementById("city").value='';
		document.getElementById("state_others").value='';
		document.getElementById("state").value='';
	}
	//ShowCity(val,id);
	}


}


function sendRequest(fromstate) {

	if(fromstate.length==3 && res_status==0)
	{
	var q=document.getElementById('country_iso').value;
	
	if(!q)
	{
		alert('Kindly select your country');
		document.getElementById("country_name").focus();
		return false;
	}


       //http.open('GET', '/cgi/get_city.cgi?C='+q+'&action=state&state='+fromstate,true);
       http.onreadystatechange = handleResponse;
       http.send(null);
	}

    }
data11=[];
function handleResponse() {

       if(http.readyState == 4 && http.status == 200){
	res_status=0;
	document.getElementById("state_others").className = 'stat_name';
          // Text returned FROM the perl script
          var response = http.responseText;
		eval(response);
		AutoComplete_Create('state_others', data11);
		AutoComplete_ShowDropdown('state_others');
        }
	else
	{	res_status=1;
		document.getElementById("state_others").className = 'busy';
	}

    }

function ShowState(populate,id){

      var len =data11.length;
    var i=0;
    var j=0;
    var k=0;
    var code=0;
    var count=0;
    var short='';
    len=len+1;

for(i=0;i<=len;i++)
{
	if(data11[i]!=undefined)
	{
	var myvalue=data11[i].toString();
	if(isNaN(myvalue))
	{
	populate=populate.replace(/&amp;/g,"&");
	myvalue=myvalue.replace(/[^0-9A-Za-z]/g,"");
	populate=populate.replace(/[^0-9A-Za-z]/g,"");
	populate=populate.toLowerCase();
	myvalue=myvalue.toLowerCase();
	if(myvalue == populate)
	{
		j=i+1;
		code=data11[i];
		document.getElementById("state_others").value=code;
		document.getElementById("state").value=data11[j];
		AutoComplete_HideDropdown('state_others');
		break;
		//alert(short);
	}
	}
	}
	if(i==len-2)
	{
		if(count==0)
		{
		document.getElementById("state").value='';
		}
	}



}

}


function onselect_country(event, ui)
{
	sugg_city = new Suggester({"element":"city_others","onSelect":selecttext_city,"onExplicitChange":onExplicitChangeCity,"type":"city",fields: "std,state,id,stateid","placeholder":"", "minStringLengthToDisplaySuggestion":1,"autocompleteClass":"bl-sugg",displayFields:"value,state",displaySeparator:" >> ",filters:"iso:"+ui.item.data.iso});
	this.value = ui.item.value;
	//document.getElementById('isd').value = ui.item.data.isd;
	var isd = ui.item.data.isd;
	var ccode=new Array();
if(isd.match(/-/))
{
	ccode=isd.split(/-/);
}
else
{
	ccode[0]=isd;
	ccode[1]='';
}

	document.getElementById('ph_country').value = '+'+ccode[0];
	document.getElementById('ph_country2').value = '+'+ccode[0];
	document.getElementById('mob_country').value = '+'+ccode[0];
	if (typeof(document.getElementById('fax_country')) != 'undefined' && document.getElementById('fax_country') != null)
	{  
        document.getElementById('fax_country').value = '+'+ccode[0];
	}

	document.getElementById('country_iso').value = ui.item.data.iso;	
}
function call_suggester(){
	var sugg_country = new Suggester({"element":"country_name", "onSelect":onselect_country, "placeholder":"", "classPlaceholder":"ui-placeholder-input",minStringLengthToFetchSuggestion:1, updateCache:false, type: "country", fields: "isd,iso",minStringLengthToDisplaySuggestion:1});

var sugg_city = new Suggester({"element":"city_others","onSelect":selecttext_city,"onExplicitChange":onExplicitChangeCity,"type":"city",fields: "std,state,id,stateid","placeholder":"", "minStringLengthToDisplaySuggestion":1,"autocompleteClass":"cls-city",displayFields:"value,state",displaySeparator:" >> ",filters:"iso:"+country_iso});
}


function selecttext_city(event, ui)
 {
         this.value = ui.item.value;
        document.getElementById("city").value=ui.item.data.id;
        document.getElementById("state_others").value=ui.item.data.state;
        document.getElementById("state").value=ui.item.data.stateid;
}

function onExplicitChangeCity(event, ui)
 {
         if(ui.item)
        {
                document.getElementById("city").value=ui.item.data.id;
                document.getElementById("state_others").value=ui.item.data.state;
                document.getElementById("state").value=ui.item.data.stateid;
        }
         else
        {
                document.getElementById("city").value='';
                 document.getElementById("state_others").value='';
                document.getElementById("state").value='';
         }
 }
