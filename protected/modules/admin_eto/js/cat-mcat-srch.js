


function ajaxFunction()
{
	var xmlHttp;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
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

function ListOnChange(txt,CatId,Catcount,cat_div_count)
{
	txt=document.getElementById('txt_cat_mcat').value;
	document.getElementById("head").innerHTML = '';
	document.getElementById("s_result").style.display="block";
	if(txt == 'type the keyword here ....' || txt.length < 3)
	{
		document.getElementById("s_result").style.display="none";
		alert("Enter at least three characters for search.");
		document.ssss.txt_cat_mcat.focus();
		return false;
	}
			
	if(txt.length > 2)
	{
		$.ajax({
			url: '/index.php?r=admin_eto/AdminEto/searchmanualmcat&action=searchmanualmcat',
			type: "POST",
					data: {
						action:'searchmanualmcat',
						escaped_item_name:escape(txt),
						item_name:txt
					},
			success:function (response) {
				if(response.indexOf("session expired") > -1){
					var root = document.location.hostname;
					window.location.href = root+"/index.php"; 		
				}
				
				if(response){
					$("#head").html('<B>Top categories found for "'+txt+'" </B>');
				$("#ajax").html(response);
				}
				else{
				$("#head").html('No related categories found for "'+txt+'" <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -Kindly search with another product name to find related categories<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT COLOR="#FF0000" size="1"> OR </font><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Click here to <a href="javascript:beowswcat();">Browse Categories</a>');
				$("#ajax").html('');	
				}
			},
			error:function(){
				$("#ajax").html('Searching..........<img src=/images/spinner.gif><BR>');
						
			},
			beforeSend: function(){$("#ajax").html('Searching..........<img src=/images/spinner.gif><BR>');},
		});
	}
	return false;
}

function suggOnChange(txt,CatId,Catcount,cat_div_count)
{
	txt=document.getElementById('sugg_cat_mcat').value;
	document.getElementById("s_result").style.display="block";
	document.getElementById("head").innerHTML='';

	if(txt == 'type the keyword here ....' || txt.length < 3)
	{
		document.getElementById("s_result").style.display="none";
		alert("Enter at least three characters for search.");
		document.ssss.sugg_cat_mcat.focus();
		return false;
	}
			
	if(txt.length > 2)
	{
		var xmlHttp=ajaxFunction();
		if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					if(xmlHttp.responseText)
					{
					document.getElementById("head").innerHTML='<B>Top categories found for "'+txt+'" </B>';
					document.getElementById("ajax").innerHTML=xmlHttp.responseText;
					}
					else
					{
					document.getElementById("head").innerHTML='No related categories found for "'+txt+'" <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -Kindly search with another product name to find related categories<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT COLOR="#FF0000" size="1"> OR </font><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Click here to <a href="javascript:beowswcat();">Browse Categories</a>';
					document.getElementById("ajax").innerHTML='';
					}
				}
				else
				{
					document.getElementById("ajax").innerHTML='Searching..........<img src=gifs/indicator.gif><BR>';
				}
			}
// 		var str="/cgi/prd-search-new.pl?ss="+escape(txt)+"&opt=2&smode=1&module=TEST&tpl=7";


		var str="/admin_eto/eto-my-prd-search.mp?type=sugg&item_name="+escape(txt);
		xmlHttp.open("GET",str,true);
		xmlHttp.send(null);
		}
	}
	return false;
}

var selectedValue = '';
function display(f,id,flag)
{

	var ofrTyp = 'B';
	var mcatresponse='0';
	if(ofrTyp == 'B') 
	{
		buyerID=getBuyerID();
		$.ajax({
			url: "/index.php?r=admin_eto/AdminEto/getcatoffers&action=getcatoffers",
			type: "POST",
					data: {
						action:'getcatoffers',
						mcatid:id,
						buyerID:buyerID
					},
			success:function (response) {
				
				mcatresponse = response;
			},
			error:function(){
				$("#ajax").html('Searching..........<img src=/images/spinner.gif><BR>');
						
			}
		});					
	}
	if(mcatresponse == '1')
        {
                alert("You have selected a GENERIC MCAT. Please Try to select another MCAT.");		
        }
	else if(mcatresponse == '7')
        {
                alert("You have selected a GENERIC MCAT. Please Try to select another MCAT.");
		alert("One Lead Already Approved in this MCAT.");		
        }
	else if(mcatresponse == '6')
        {                
		alert("One Lead Already Approved in this MCAT.");		
        }
		
	reset_mcat_list(f,id,flag);	
}

function reset_mcat_list(f,id,flag)
{
	var mcatIdNameVal = $("#mcatIdNameVal").val();

	var myarr = new Array();
	if(mcatIdNameVal != '') {
		myarr = mcatIdNameVal.split("____");
	}
	var lastLen = myarr.length; var temp = 0;
	
	for(var i=0; i < myarr.length; i++) {
		var myarr1 = myarr[i].split("__");
		if(myarr1[0] == id) {
			temp = 1; break;
		}
	}

	if(temp == 1) {
		alert("Already Selected");
		return false;
	}
	else {
		if(lastLen < 5) {
			var frm = document.test;
			if(id == '' && lastLen > 0) {
				alert("You can not select a sub category along with MCAT Mapping");
				for (var j = 0; j < document.test.mcat.length; j++) {
					if (document.test.mcat[j].checked) {
						document.test.mcat[j].checked = false;
						break;
					}
				}
				return false;
			}
			else {
				var sv ='';
				var pushVal = '';  //mcat id text cat id text grp id text
				if(flag) { // search Page Listing
					pushVal = searchDisp();

					if(document.getElementById("getcatoffers") && document.getElementById("getcatoffers").value == 1) {
					var myar = pushVal.split("__");
					getcatoffers(myar[2]);
					}
				}
				else {
					 sv = frm.cat.options[frm.cat.selectedIndex].value+'__'+frm.cat.options[frm.cat.selectedIndex].text+'__'+frm.grp.options[frm.grp.selectedIndex].value+'__'+frm.grp.options[frm.grp.selectedIndex].text;
					 pushVal = id+'__'+f+'__'+sv;
				}

				if(id) {
				myarr.push(pushVal);
				var currLen = myarr.length;
				add_mcat_list(myarr,currLen);
				}
				else {
				add_cat_list(sv);
				}
			}
		}
		else {
			alert("You can Select upto 5 Mapping\n\nTo select this MCAT, first remove\nanyone MCAT mapping from mapped categories");

			if(flag) { // mcat search button
				if (document.postcheck.Radio1[0]) {
					for (var counter = 0; counter < document.postcheck.Radio1.length; counter++) {
						if (document.postcheck.Radio1[counter].checked)
						{
						document.postcheck.Radio1[counter].checked = false; break;
						}
					}
				}
				else {
					if (document.postcheck.Radio1.checked) {
						document.postcheck.Radio1.checked = false;
					}
				}
			}
			else {
				for (var j = 0; j < document.test.mcat.length; j++) {
					if (document.test.mcat[j].checked) {
						document.test.mcat[j].checked = false;
						break;
					}
				}
			}
			return false;
		}
	}
}

function add_mcat_list(myarr,currLen)
{

	if(currLen > 0) {                

		var mcat_list = ''; var new_mcat_ids = ''; var mcat = ''; var mcat_list_pg = '';
		document.getElementById('p1').innerHTML = '';
		var img = '';
		currLen = currLen-1;
		for(var i=0; i < myarr.length; i++) {
			var myarr2 = myarr[i].split("__");
			new_mcat_ids += myarr[i];
			mcat += myarr2[0]+',';
			if(i < currLen) new_mcat_ids +=  '____';			

			var primeMcat="";
			primeMcat="primeMcat"+i;			

			img = '<img src="/images/remove.gif" height="10" hspace="6" align="absmiddle" vspace="3" width="44" onclick="delete_mcat_mapping(\''+myarr2[0]+'\')" style="cursor: pointer;"><br>';

			mcat_list += '<input type="radio" name="pr_mcat" id="pr_mcat" value="'+myarr2[0]+'" onclick="assignPmcat(\''+myarr2[0]+'\',1);"><input type="hidden" name="'+primeMcat+'" id="'+primeMcat+'" value="'+myarr2[0]+'">';
			mcat_list_pg += '- ';

			if(myarr2[5]) {
				mcat_list_pg += myarr2[5]+' > ';
				mcat_list += myarr2[5]+' >> ';
			}
			mcat_list += myarr2[3]+' > '+myarr2[1]+img;
			mcat_list_pg += myarr2[3]+' >> '+myarr2[1]+'<br>';
		}
		mcat = mcat.slice(0, -1);
		document.getElementById('selected_mcat_list').innerHTML = mcat_list;
		document.getElementById('i1').innerHTML = mcat_list_pg;
		$("#mcatIdNameVal").val(new_mcat_ids);
		$("#mcat").val(mcat);
	}
	else {
	document.getElementById('selected_mcat_list').innerHTML = '- Undefined Category';
	document.getElementById('i1').innerHTML = '- Undefined Category';
	
	$("#cat").val('');
	$("#mcat").val('');
	$("#grp").val('');
	$("#PmcatId").val('');
	$("#mcatIdNameVal").val('');
	}
}

function add_cat_list(sv)
{

	var myarr2 = sv.split("__"); // catid text grpid text

	var img = '<img src="/images/remove.gif" height="10" hspace="6" align="absmiddle" vspace="3" width="44" onclick="delete_mcat_mapping(\''+myarr2[0]+'\')" style="cursor: pointer;"><br>';

	var cat_list = myarr2[3]+' >> '+myarr2[1]+img;
	var cat_list_pg = '- '+myarr2[3]+' >> '+myarr2[1]+'<br>';

	document.getElementById('selected_mcat_list').innerHTML = cat_list;
	document.getElementById('i1').innerHTML = cat_list_pg;
	$("#mcatIdNameVal").val('');
	$("#cat").val(myarr2[0]);
	$("#grp").val(myarr2[2]);
	$("#mcat").val('');
	$("#PmcatId").val('');
}

function assignPmcat(id,flag)
{
	ofrTyp = "B";

	if(ofrTyp == 'B' && flag == '1')
	{
		/*var divTag = document.createElement("div");
		divTag.id = "mcatdiv";		
		document.body.appendChild(divTag);*/ 

		var buyerID=getBuyerID();
                var paraPrimeMcat="primeMcat=1";
        
                if(document.MapFrm.primeMcat0 && document.MapFrm.primeMcat0.value)
                {
                        paraPrimeMcat +="&primeMcat0="+document.MapFrm.primeMcat0.value;
                }
                if(document.MapFrm.primeMcat1 && document.MapFrm.primeMcat1.value)
                {
                        paraPrimeMcat +="&primeMcat1="+document.MapFrm.primeMcat1.value;
                }
                var primemcatresponse='0';
						$.ajax({
							url: "/index.php?r=admin_eto/AdminEto/getcatoffers&action=getcatoffers",
							type: "POST",
									data: {
										action:'getcatoffers',
										paraPrimeMcat:paraPrimeMcat,
										id:id,
										buyerID:buyerID
									},
							success:function (response) {
								if(response.indexOf("session expired") > -1){
					var root = document.location.hostname;
					window.location.href = root+"/index.php"; 		
				}
								primemcatresponse = response;
							}
						});				

		if((primemcatresponse == '8') || (primemcatresponse == '7' && !document.MapFrm.primeMcat1))
                {
                        alert("You have selected a GENERIC MCAT.");
			alert("One Lead Already Approved in this MCAT.");			
                }
		else if((primemcatresponse == '2') || (primemcatresponse == '1' && !document.MapFrm.primeMcat1))
                {
                        alert("You have selected a GENERIC MCAT.");			
                }
		else if(primemcatresponse == '6')
                {                       
			alert("One Lead Already Approved in this MCAT.");			
                }           
                else if((primemcatresponse == '1' || primemcatresponse == '7') && document.MapFrm.primeMcat1)
                {
                        var mcat_response='0';
                        $.ajax({
							url: "index.php",
							type: "POST",
									data: {
										action:'getcatoffers',
										mcatid:id,
										buyerID:buyerID
									},
							success:function (response) {
								mcat_response = response;
							}
						});					
                
                        if(mcat_response== '1' || mcat_response== '7')
                        {
				if(mcat_response== '1' && document.MapFrm.pr_mcat[1])
				{
                                	alert("You can not select Generic Mcat as Prime Mcat.");
				}
				else if(mcat_response== '7')
				{
					alert("You can not select Generic Mcat as Prime Mcat.");
					alert("One Lead Already Approved in this MCAT.");
				}
				else
				{
					alert("You have selected a GENERIC MCAT.");
				}

                        	if((mcat_response== '1' || mcat_response== '7') && document.MapFrm.pr_mcat[1])
				{
                                        if(document.MapFrm.pr_mcat.checked)
                                        {
                                                document.MapFrm.pr_mcat.checked=false;
                                        }
                                        else if(document.MapFrm.pr_mcat[0].checked)
                                        {
                                                document.MapFrm.pr_mcat[0].checked=false;
                                        }
                                        else
                                        {
                                                document.MapFrm.pr_mcat[1].checked=false;
                                        }		
                                        return false;
				}
                        }
			else if(mcat_response== '6')
			{
				alert("One Lead Already Approved in this MCAT.");
			}
                }
	}

	$("#PmcatId").val(id);
	$("#mcatchanged").val(1);
	var PmcatID = id;
	var mcatIdNameVal = $("#mcatIdNameVal").val();

	var myarr = mcatIdNameVal.split("____");
	var arlen = myarr.length;
	for(var i=0; i < arlen; i++) {
		var myarr1 = myarr[i].split("__");
		if(myarr1[0] == PmcatID) {
			if(arlen > 1) {
			document.getElementById('p1').innerHTML = '&nbsp;<span  style="background:#c90000; color:#fff; padding:0 2px">Prime MCAT </span> - '+myarr1[1]; }
			$("#cat").val(myarr1[2]);
			$("#grp").val(myarr1[4]);
			break;
		}
	}
}

function delete_mcat_mapping(id)
{

	var myarr2 = new Array();
	var mcatIdNameVal = $("#mcatIdNameVal").val();

	if(mcatIdNameVal) 
	{
		var myarr = mcatIdNameVal.split("____");
		for(var i=0; i < myarr.length; i++) {
			var myarr1 = myarr[i].split("__");
			if(myarr1[0] != id) {
				myarr2.push(myarr[i]);
			}
		}				    		

		var currLen = myarr2.length;
		add_mcat_list(myarr2,currLen);
	}
	else {
	add_mcat_list('',0);
	}
}

function searchDisp()
{
	var disp = '';
	if (document.postcheck.Radio1[0]) {
		for (var counter = 0; counter < document.postcheck.Radio1.length; counter++)
		{
			if (document.postcheck.Radio1[counter].checked)
			{
				disp=document.postcheck.Radio1[counter].value;
			}
		}
	}
	else {
		if (document.postcheck.Radio1.checked) {
			disp=document.postcheck.Radio1.value;
		}
	}
	return disp;
}

function grpajaxFunction()
{
	document.getElementById('sel_mcat').value='';
	 $.ajax({
							url: "/index.php?r=admin_eto/AdminEto/manualgrouplist&action=manualGroupList",
							type: "POST",
									data: {
										action:'manualGroupList',
									},
							success:function (response) {								
								var display_grp='<SELECT STYLE="width:100%" SIZE="10" name="grp" ID="grp" onchange="catajaxFunction(this.value);">'+response+'</SELECT>';
								document.getElementById('grp1').innerHTML=display_grp;
							}
						}); 
}

function catajaxFunction(id)
{
	document.getElementById("s1").value = '';
	selectedValue = document.test.grp.options[document.test.grp.selectedIndex].text;
	
	var id= document.test.grp.options[document.test.grp.selectedIndex].value;
	
	//var url = "/approval/grp.mp?grpid="+id;
	document.getElementById('css').className='displayon';
	$.ajax({
			url: "/index.php?r=admin_eto/AdminEto/manualgrouplist&action=manualGroupList",
			type: "POST",
					data: {
						action:'manualGroupList',
						grpid:id
					},
			success:function (response) {
				if(response.indexOf("session expired") > -1){
					var root = document.location.hostname;
					window.location.href = root+"/index.php"; 		
				}
				var display_cat = '<SELECT name="cat" id="cat" STYLE="width:100%" SIZE="10" onchange="mcatajaxFunction(this.value);">'+response+'</SELECT>';
				$('#cat1').html(display_cat);
			}
		});

	
}

function mcatajaxFunction(id)
{

	selectedValue = document.test.grp.options[document.test.grp.selectedIndex].text+' >> '+document.test.cat.options[document.test.cat.selectedIndex].text;

	document.getElementById('sel_mcat').value='';
	document.getElementById('s1').value=selectedValue;

// 	var ofrTyp = document.adminForm.type.options[document.adminForm.type.selectedIndex].value;

	var ofrTyp = 'B';

	if($("#mcat").val() == '') {
	var frm = document.test;
	var sv = frm.cat.options[frm.cat.selectedIndex].value+'__'+frm.cat.options[frm.cat.selectedIndex].text+'__'+frm.grp.options[frm.grp.selectedIndex].value+'__'+frm.grp.options[frm.grp.selectedIndex].text;
	add_cat_list(sv);
	}

	if(document.getElementById("getcatoffers") && document.getElementById("getcatoffers").value == 1) { getcatoffers(id); }

	//var url = "/approval/grp.mp?catid="+id;
	$.ajax({
			url: "/index.php?r=admin_eto/AdminEto/manualgrouplist&action=manualGroupList",
			type: "POST",
					data: {
						action:'manualGroupList',
						catid:id
					},
			success:function (response) {
				if(response.indexOf("session expired") > -1){
					var root = document.location.hostname;
					window.location.href = root+"/index.php"; 		
				}
				var display_mcat='<div style="border: 1px solid rgb(51, 102, 153); background-color:#ffffff; overflow: auto; height: 165px; padding-left:1px; font-size: 13px;" id="mcat"></div>';
			temp=response;
			myarr = temp.split("###");
			if(myarr[1] > 0)
			{
				document.getElementById('display_mcat').className='displayon';
				document.getElementById('div_mcat').innerHTML=myarr[0];
			}
			else
			{
				document.getElementById('display_mcat').className='displayoff';
			}
			}
		});
	
}

function getScrollHeight()
{
	var h = window.pageYOffset ||
	document.body.scrollTop ||
	document.documentElement.scrollTop;

	var myWidth = 0, myHeight = 0;

	if( typeof( window.innerWidth ) == 'number' )
	{
		myWidth = window.innerWidth;
		myHeight = window.innerHeight;
	}

	else if( document.documentElement && ( 
	document.documentElement.clientWidth || 
	document.documentElement.clientHeight ) ) {
	myWidth = document.documentElement.clientWidth;
	myHeight = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || 
	document.body.clientHeight ) ) {
	myWidth = document.body.clientWidth;
	myHeight = document.body.clientHeight;
	}

	var div_width = myWidth - 20;
	var div_info_height = $(document).height();
	document.getElementById('dynamicheight').style.height=h+"px";
	document.getElementById('div_info').style.width=div_width+"px";
	document.getElementById('div_info').style.height=div_info_height+"px";
}

function win_open(val)
{

// 	if(document.getElementById("div_info").className == "win-close") {
	  if($('#div_info').hasClass('win-close'))
	  {
		document.getElementById("div_info").className = "show";
		
		document.getElementById('txt_cat_mcat').focus();
		
		if(val=='grp') {
			grpajaxFunction();
			document.getElementById('display_mcat').className = "displayoff";
			document.getElementById('css').className = "displayoff";
			return false;
		}
	}
	else {

		if(document.getElementById("pr_mcat")) {
			var radio_choice1 = false; var disp=''; var len = 0;
			if (document.MapFrm.pr_mcat[0]) {
				len = document.MapFrm.pr_mcat.length;
				for (var counter = 0; counter < len; counter++) {
					if (document.MapFrm.pr_mcat[counter].checked) {
					radio_choice1 = true;
					break;
					}
				}
			}
			else {
				document.MapFrm.pr_mcat.checked = true;
				assignPmcat(document.MapFrm.pr_mcat.value);
				radio_choice1 = true;
			}
	
			if (!radio_choice1) {
				alert("Please select Prime MCAT.");
				document.MapFrm.pr_mcat[0].focus();
				return false;
			}
		}

		if(val == 'cl_win') {
			if(document.getElementById("Radio1") && document.getElementById("s_result").style.display == "block") {
			var catv = $("#cat").val();
				if(catv == '' || catv == -1) {
					alert("Please select Categories.");
					if(document.postcheck.Radio1[0]) {
					document.postcheck.Radio1[0].focus();
					}
					else {
					document.postcheck.Radio1.focus();
					}
					return false;
				}
			}
			else {
				var catv = $("#cat").val();
				if(catv == '' || catv == -1) {
					alert("Please select atleast one product category\nfrom 2nd box Or Search Option\n\n*** to submit category ***");
					return false;
				}
			}

			if($("#PmcatId").val() == ''){
				alert("Please select atleast one MCAT \nfrom 3rd box Or Search Option\n\n*** to submit category ***");
				return false;
			}

		}
		document.getElementById("div_info").className = "col-md-12 win-close";
		
		document.getElementById('cat-bt').className = "btn displayoff";
		document.getElementById('chg-bt').className = "btn displayon";
	}
}

function beowswcat(flag)
{
	document.getElementById("browse_cat").style.display="block";
	document.getElementById("search_cat").style.display="none";
	document.getElementById("b_tab").className="tabopen";
	document.getElementById("s_tab").className="tabclose";
	document.getElementById("s_result").style.display="none";
	if(flag == 'sugg') {
		document.getElementById("sg_tab").className="tabclose";
		document.getElementById("sug_cat").style.display="none";
	}
}

function searchcat(flag)
{
	document.getElementById("browse_cat").style.display="none";
	document.getElementById("search_cat").style.display="block";
	document.getElementById("b_tab").className="tabclose";
	document.getElementById("s_tab").className="tabopen";
	if(flag == 'sugg') {
		document.getElementById("sg_tab").className="tabclose";
		document.getElementById("sug_cat").style.display="none";
		document.getElementById("ajax").innerHTML='';
	}
}

function getcatoffers(catid)
{
	var memid = $("#glusrid").val();
	
	//url = "/approval/eto-pbl-getcatoffers.mp?catid="+catid+"&memid="+memid;
	$.ajax({
			url: "index.php",
			type: "POST",
					data: {
						action:'getcatoffers',
						catid:catid,
						memid:memid
					},
			success:function (response) {
				if(response.indexOf("session expired") > -1){
					var root = document.location.hostname;
					window.location.href = root+"/index.php"; 		
				}
				document.getElementById('selectedcatoffer').innerHTML= response;
			},error:function(){
				document.getElementById('selectedcatoffer').innerHTML='Searching..........<BR>Offers on your selected Category...';			
			}
		});
	
}

function capturekey(t,e) {
	var keyPressed;
	if(window.event)
	{
		keyPressed = window.event.keyCode; // IE
	}
	else
	{
		keyPressed = e.which; // Firefox & others
	}
		
	if (keyPressed && keyPressed == 118){
		// F7
		t.value = t.value.toUpperCase();
		t.select();
		return false;
	}
	else if (keyPressed && keyPressed == 119){
		// F8
		t.value = t.value.toLowerCase();
		t.select();
		return false;
	}
	else if (keyPressed && keyPressed == 113){
		// F2
		changeCase(t);
		t.select();
		return false;
	}
}

function changeCase(frmObj) {
	var index;
	var tmpStr;
	var tmpChar;
	var preString;
	var postString;
	var strlen;
	tmpStr = frmObj.value.toLowerCase();
	strLen = tmpStr.length;
	if (strLen > 0)  {
		for (index = 0; index < strLen; index++)  {
			if (index == 0)  {
				tmpChar = tmpStr.substring(0,1).toUpperCase();
				postString = tmpStr.substring(1,strLen);
				tmpStr = tmpChar + postString;
			}
			else {
				tmpChar = tmpStr.substring(index, index+1);
				if (tmpChar == " " && index < (strLen-1))  {
					tmpChar = tmpStr.substring(index+1, index+2).toUpperCase();
					preString = tmpStr.substring(0, index+1);
					postString = tmpStr.substring(index+2,strLen);
					tmpStr = preString + tmpChar + postString;
				}
			}
		}
	}
	frmObj.value = tmpStr;
}

function get_keywords()
{
	var xmlHttp=ajaxFunction();
	var ofrTitle=document.getElementById("txtTitle").value;
	if(xmlHttp)
	{
		if(ofrTitle && ofrTitle.length > 2 && ofrTitle != "Looking for...")
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
				document.getElementById("txtKeywords").value=xmlHttp.responseText;
				}
			}
			xmlHttp.open("GET","/cgi/eto-dirsearch-mcat.mp?ss="+escape(ofrTitle),true);
			xmlHttp.send(null);
		}
	}
}

function get_area()
{
	var xmlHttp=ajaxFunction();
	var city=document.getElementById("txtCity").value;
	if(xmlHttp)
	{
		xmlHttp.onreadystatechange=function()
		{
			if(xmlHttp.readyState==4)
			{
			document.getElementById("txtArea").value=xmlHttp.responseText;
			}
		}
		xmlHttp.open("GET","/cgi/GetAreaCode.mp?city="+escape(city),true);
		xmlHttp.send(null);
	}
}

function trim(sString)
{ 
	while (sString.substring(0,1) == ' ')
	{
	sString = sString.substring(1, sString.length);
	}
	while (sString.substring(sString.length-1, sString.length) == ' ')
	{
	sString = sString.substring(0,sString.length-1);
	}
	return sString;
}

function trim(sString)
{ 
	while (sString.substring(0,1) == ' ')
	{
	sString = sString.substring(1, sString.length);
	}
	while (sString.substring(sString.length-1, sString.length) == ' ')
	{
	sString = sString.substring(0,sString.length-1);
	}
	return sString;
}

function getBuyerID()
{
	var buyerID='';
	if(document.adminForm)
        {
                if(document.adminForm.glid)
                {
                        buyerID=document.adminForm.glid.value;
                }
                else if(document.adminForm.GLUSR_USR_ID)
                {
                        buyerID=document.adminForm.GLUSR_USR_ID.value;
                }
        }	
        else if(document.postForm)
        {
                if($("#glusrid").length)
                {
                        buyerID= $("#glusrid").val();
                }
        }
	return buyerID;
}