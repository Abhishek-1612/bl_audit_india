function enrich(offerid,emp_id)
{
var r=confirm("Do you want to enrich this lead ?");
	if (r==true)
	{
		x="You pressed OK!";
		window.open('/cgi/eto-bl-call-leads-v2.mp?offer='+offerid+'&agency_code=3&emp_id='+emp_id, 'Lookupselect', 'toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=935,height=500');
	}
	else
	{

	}
}
function hide_msg()
{
document.getElementById("sp1").innerHTML="";
}

function save_cat(spn,offerId,emp_id)
{

	var spanID = spn;
	var xmlHttp=ajaxFunction();

var PcatId=document.adminForm.cat.value;
var mcatval=document.adminForm.mcat.value;
var PmcatId=document.adminForm.PmcatId.value;

	if(xmlHttp)
	{
		xmlHttp.onreadystatechange=function()
		{

			if(xmlHttp.readyState==4)
			{

				document.getElementById(spanID).innerHTML=xmlHttp.responseText;
				//document.getElementById(spanID).style.visibility="hidden";
			}
			else
			{

				document.getElementById(spanID).innerHTML='<DIV STYLE="color:red;font-weight:bold;height:12px; margin-right: 10px; padding: 1px 2px; float: right;">Updating category...</DIV>';
			}
		}
		xmlHttp.open("GET","eto-bl-call-leads-v2.mp?save_cat=save&offerId="+offerId+"&PcatId="+PcatId+"&mcatval="+mcatval+"&PmcatId="+PmcatId+"&emp_id="+emp_id,true);
		xmlHttp.send(null);
	}
}

function confirmDelete()
{
	if(document.adminForm.reason.value == '')
	{
	popup2('eto-del-reasons.mp');
	return false;
	}
	else
	{
	return confirm("Are you sure you want to delete this offer? Responses to this offer (if any) will also be deleted.");
	}
}

function confirmDeleteMail()
{
	if(document.adminForm.reason.value == '')
	{
		popup2('eto-del-reasons.mp');
		return false;
	}
	else
	{
		return true;
	}
}

function confirmCategory()
{	
	if(document.adminForm.usrstatus.value == 'D' || document.adminForm.usrstatus.value == 'M')
	{
		alert("This GLUser is Disabled. \nPlease Enable this GLUser First to Approve this offer.");
		return false;
	}	
	document.adminForm.oldmcat.value = '';
	document.adminForm.oldmcatIdNameVal.value = '';
	document.adminForm.mcatIdNameVal.value = '';
}

function mulCategory()
{	
	if(document.adminForm.cat.value == '' || document.adminForm.cat.value == -1)
	{
		alert("Please change the category for the Offer first !");
		document.adminForm.button1.focus();
		return false;
	}
	else if(document.adminForm.cat.value != '' || document.adminForm.cat.value != -1)
	{		
			return confirmCategory();		
	}
}

function mulCategory_B()
{
	if(document.adminForm.qty.value.match(/\?/g))
   {
   	document.adminForm.qty.value = document.adminForm.qty.value.replace(/\?+/g,' ');
  	} 
  	else if(document.adminForm.qty.value.trim() != '' && document.adminForm.qty_list_val.value == ""){
		alert("Please select quantity unit!");
		document.adminForm.qty_list_val.focus();
		return false;	
	} 
	else if(document.adminForm.qty.value.trim() == '' &&  document.adminForm.qty_list_val.value != ''){
		alert("Please Enter Quantity");
		document.adminForm.qty.focus();
		return false;
	}
	else if(document.adminForm.qty_list_val.value == 'Others' && document.adminForm.ETO_OFR_QTY_UNIT_OTHER.value == '')
	{
      
      alert("Please Enter Quantity Unit");
		document.adminForm.ETO_OFR_QTY_UNIT_OTHER.focus();
		return false;
		
   }
	else if(document.adminForm.cat.value == '' || document.adminForm.cat.value == -1)
	{
		alert("Please change the category for the Offer first !");
		document.adminForm.button1.focus();
		return false;
	}
	else if(document.adminForm.cat.value != '' || document.adminForm.cat.value != -1)
	{
		
		var email_val = document.getElementById('email').value;
		email_val = email_val.toLowerCase();
		var s = email_val.indexOf("@indiatimes.com");
		if (s != -1) //this will be true if the address contains indiatimes.com
		{
			alert("Indiatimes Domain\nKindly Flag The lead");
			return false;
		}

			if(document.getElementById('Reviewed').checked == true)
			{
				if(document.getElementById('chnge_txt').value == 1)
				{
				alert("Please first Update glusr changed detail");
				document.getElementById('action1').focus();
				return false;
				} else {
					$("#newStatus").val('A');
				return confirmCategory();
				return true;
				}

			}else{
				alert("Please check the Reviewed Field ");
				
						document.getElementById('Reviewed').focus();
					
				return false;
			}
		
	}
}
function confirmDeleteNormal()
{
	return confirm("Are you sure you want to delete this offer? Responses to this offer (if any) will also be deleted.");
}

function check(flag)
{

	if(flag == 1)
	{
		document.adminForm.image1.value='';
	}
	if(flag == 2)
	{
		document.adminForm.image2.value='';
	}
	if (flag == 3)
	{
		document.adminForm.image3.value='';
	}
}

function goback() { history.go(-1)} // End the hiding here.

function popup(url) {
	window.open(url,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=500,height=420');
}
function popup2(url) {
	window.open(url,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=400,height=500');
}

function displayReason(temp)
{
	if(temp == 1)
	{
		document.getElementById("blreason").style.display="block";
	}
	else
	{
		document.getElementById("blreason").style.display="none";
	}
}

function ofrAllDet(ofrid)
{
	var url = 'index.php?r=admin_eto/AdminEto/etohistory&action=etohistory&act=ofrHist&offer='+ofrid;
	popup1(url);
}

function fenqOfrAllDet(ofrid)
{
	var url = 'index.php?r=admin_eto/AdminEto/etohistory&action=etohistory&act=fenqHist&offer='+ofrid;
	popup1(url);
}

function OfrMapDet(ofrid)
{
	var url = 'index.php?r=admin_eto/AdminEto/etohistory&action=etohistory&act=mapHist&offer='+ofrid;
	popup1(url);
}

function popup1(url)
{
	window.open(url, 'Lookup', 'toolbar=no, location=no, width=1000,scrollbars=yes,resizable=yes, height=1000, left=10, top=10');
}


function checkLimit()
{
	if(document.adminForm.type.value == 'S')
	{
		var temp = tinyMCE.get('item_desc').getContent();
		temp = processTxt(temp);
		document.getElementById('item_desc').value = temp;
		if((temp.length > 4000))
		{
			alert("Offer description should not be more than 4000 characters.");
			tinyMCE.execCommand("mceFocus", false , 'item_desc');
			return false;
		}
	}
}



function setflag(id)
{
	if(document.getElementById('Reviewed').checked == true)
	{
		if(id == 1)
		{
			document.getElementById('flagval').value = 1;
			document['adminForm'].submit();
		}
		if(id == 2)
		{
			document.getElementById('flagval').value = 2;
			document['adminForm'].submit();
		}
		if(id == 3)
		{
			document.getElementById('flagval').value = 3;
			document['adminForm'].submit();
		}
		if(id == 4)
		{
			document.getElementById('flagval').value = 4;
			document['adminForm'].submit();
		}
		if(id == 5)
		{
			document.getElementById('flagval').value = 5;
			document['adminForm'].submit();
		}
		if(id == 6)
		{
			document.getElementById('flagval').value = 6;
			document['adminForm'].submit();
		}

	} else {
		alert("Please check the Reviewed Field ");
		
				document.getElementById('Reviewed').focus();
			
		return false;
	}
}

function searchval(val)
{
var srcval=val;
document.getElementById('gog').innerHTML = '<a TARGET="_blank" href="http://www.google.co.in/#hl=en&q=' + srcval + '">Google</a>';
}
function checkData(searchfor)
{
	var str='';
	var val=document.getElementById('title').value;
	val = val.replace(/^\s+/g, '').replace(/\s+$/g, '');
	while(val.indexOf('  ')>0)
	{
	val = val.replace('  ',' ');
	}
	val = val.replace(/-/i, ' ');
// 	val = val.replace(/[^a-zA-Z0-9+ ]/g, ' ');
	if(searchfor == "offer")
	{
		val = val.replace(/[^a-zA-Z0-9'+]/g, ' ');

	}
	else
	{
		val = val.replace(/[^a-zA-Z0-9+ ]/g, ' ');
	}
	val = val.replace(/(\+(\s*))+/g, '+');
	val = val.replace(/\s\s+/g, ' ');
	var temp=val.replace(/\s/g, '');
		if(searchfor == "product")
		{
			var b = val.replace(/\+/g, ' ');
			b = b.replace(/\s+/g, '+');
			str +='ss='+b;
			str = "https://dir.indiamart.com/cgi/catprdsearch.mp?"+str;
			str = myReplace(str,"\\\\?\\\\&","?");
			window.open(str);
		}
		else if(searchfor == "offer")
		{
			var c = val.replace(/\+/g, ' ');
			c = c.replace(/\s+/g, '+');
			str +='search='+c;
			str = "http://trade.indiamart.com/search.mp?"+str;
			str = myReplace(str,"\\\\?\\\\&","?");
			window.open(str);
		}
}

function myReplace(str, a, b)
{
	var re = new RegExp(a, "g");
	var ret = str.replace(re,b);
	return ret;
}

function fetchText()
{
	var d = document;
	var txtFrame = d.getElementById( 'textReader');
// 	txtFrame.src = txtFile;
	var text = '';
	if (txtFrame.contentDocument)
	{
		var d = txtFrame.contentDocument;
		text = d.getElementsByTagName( 'BODY')[ 0].innerHTML;
	}
	else if (txtFrame.contentWindow)
	{
		var w = txtFrame.contentWindow;
		text = w.document.body.innerHTML;
	}
	return text;
}
function showfcpdetail(offerid){
    $("#showfcp").hide();
    $("#fcpdetail").html('Processing...');
    $.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/showfcpdetail&offerid="+offerid,
                data: "",
        success: function(response){
            $("#fcpdetail").html(response);
                        $("#fcpdetail").show();  
        }
    });        
}
function showuserstats(offerid,glusrid){
    $("#showuserstat").hide();
    $("#userstat").html('Processing...');
    $.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/showuserstats&offerid="+offerid+"&glusrid="+glusrid,
                data: "",
        success: function(response){
            $("#userstat").html(response);
            $("#userstat").show();  
        }
    });        
}

function showragscale(offerid){
	$("#ragscale").hide();
    $("#spragscale").html('Processing...');
	$.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/showragscale&offerid="+offerid,
                data: "",
        success: function(response){
            $("#spragscale").html(response);
            $("#spragscale").show();  
        }
    });   
}
function showusage(offerid){
	$("#usage").hide();
    $("#usagestatus").html('Processing...');
	$.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/getglprofile&type=usage&offerid="+offerid,
                data: "",
        success: function(response){
            $("#usagestatus").html(response);
            $("#usagestatus").show();  
        }
    });   
}

function showtov(offerid){
	$("#tov").hide();
    $("#tovstatus").html('Processing...');
	$.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/getglprofile&offerid="+offerid,
                data: "",
        success: function(response){
            $("#tovstatus").html(response);
            $("#tovstatus").show();  
        }
    });   
}
function showragstats(offerid){
	$("#userstat").hide();
        $("#userstat").html('Processing...');
	$.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/showragstats&offerid="+offerid,
                data: "",
        success: function(response){
            $("#userstat").html(response);
            $("#userstat").show();  
        }
    });   
}
function showquantity(offerid){
	$("#quantity").hide();
        $("#quantitystatus").html('Processing...');
	$.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/getglprofilequantity&type=1&offerid="+offerid,
                data: "",
        success: function(response){
            $("#quantitystatus").html(response);
            $("#quantitystatus").show();  
        }
    });   
}