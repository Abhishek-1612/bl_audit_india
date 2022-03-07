//Post Form Javascripts

// $Id: $
// $HeadURL: $
function check_count_change()
{
	var val = document.postForm.country.options[document.postForm.country.selectedIndex].value;
	if(val != document.postForm.country_iso.value)
	{
		document.postForm.city.value = '';
		document.postForm.city_others.value = '';
		document.postForm.state.value = '';
		document.postForm.state_others.value = '';
		
		if(phonecode[document.postForm.country.selectedIndex] != '')
		{
			document.postForm.ph_country.value = phonecode[document.postForm.country.selectedIndex];

			if(document.postForm.fax_country)
			{
				document.postForm.fax_country.value = phonecode[document.postForm.country.selectedIndex];
			}
			if(document.postForm.mob_country)
			{
				document.postForm.mob_country.value = phonecode[document.postForm.country.selectedIndex];
			}
		}
	}
	document.postForm.country_iso.value = val;
	document.postForm.country_name.value = document.postForm.country.options[document.postForm.country.selectedIndex].text;
}


function changeEnq(quid,email,glusrid,qc_flag)
{
	var spanID = 'currentenq';
	var spanID1 = 'fenqOfrDet';
	var spanID2 = 'fenqOfrDisp';
	var xmlHttp=ajaxFunction();

	var emp = document.getElementById('emp').value;
	var date = document.getElementById('date').value;
	var month = document.getElementById('month').value;
	var modiddrpdwn = document.getElementById('modiddrpdwn').value;
	var stat = document.getElementById('status').value;
	var report = document.getElementById('report').value;
	var cntry = document.getElementById('cntry').value;
	var rating = document.getElementById('rating').value;
	var usr_cnt = document.getElementById('usr_cnt').value;

// 	if(document.getElementById('dupflag'))
// 	{
// 		document.getElementById('dupOffer').value=0;
// 		document.getElementById('dupflag').value=0;
// 		document.getElementById('isdupofr').innerHTML='';
// 	}

	var more_link = '&date='+date+'&emp='+emp+'&modiddrpdwn='+modiddrpdwn+'&status='+stat+'&report='+report+'&month='+month+'&cntry='+cntry+'&rating='+rating+'&usr_cnt='+usr_cnt;
	var dis = 'eto-history-fenq.mp?action=detail&getenq=1&quid='+quid+'&email='+escape(email)+'&glusrid='+glusrid+'&qc='+qc_flag;
	dis = dis+more_link;
	
	if(xmlHttp)
	{
		xmlHttp.onreadystatechange=function()
		{
			if(xmlHttp.readyState==4)
			{
				var temp = xmlHttp.responseText;
				var my_array=temp.split("::::");
				document.getElementById(spanID).innerHTML=my_array[0];
				document.getElementById(spanID1).innerHTML=my_array[1];
				document.getElementById(spanID2).innerHTML=my_array[2];
			}
			else
			{
				document.getElementById(spanID).innerHTML='<FONT COLOR="#4f4f4f"><B>Changing enquiry ...</B><img src="gifs/indicator.gif"></FONT>';

				document.getElementById(spanID1).innerHTML='<FONT COLOR="#4f4f4f"><B>FENQ in Buy Lead ...</B><img src="gifs/indicator.gif"></FONT>';
			}
		}
		xmlHttp.open("GET",dis,true);
		xmlHttp.send(null);
	}
}


function checkBuyForm()
{
	if(document.searchForm.bdate_day.value == 0 || document.searchForm.bdate_month.value == 0 || document.searchForm.bdate_year.value == 0)
	{
		alert("Fill Start Date");
		return false;
	}

	if(document.searchForm.adate_day.value == 0 || document.searchForm.adate_month.value == 0 || document.searchForm.adate_year.value == 0)
	{
		alert("Fill End Date");
		return false;
	}

	if(document.searchForm.bdate_month.value == 2 || document.searchForm.bdate_month.value == 4
	|| document.searchForm.bdate_month.value == 6|| document.searchForm.bdate_month.value == 9|| document.searchForm.bdate_month.value == 11)
	{
		if(document.searchForm.bdate_day.value == 31)
		{
		alert("This date does not exists");
		return false;
		}
	}
	if(document.searchForm.adate_month.value == 2 || document.searchForm.adate_month.value == 4
	|| document.searchForm.adate_month.value == 6|| document.searchForm.adate_month.value == 9|| document.searchForm.adate_month.value == 11)
	{
		if(document.searchForm.adate_day.value == 31)
		{
		alert("This date does not exists");
		return false;
		}
	}
}

function dayEnableDisable(rprtfrnq)
{
	if(rprtfrnq == 2)
	{
		document.searchForm.bdate_day.style.backgroundColor='#EAEAEA';
		document.searchForm.bdate_day.style.color='#b5b2ad';
		document.searchForm.adate_day.style.backgroundColor='#EAEAEA';
		document.searchForm.adate_day.style.color='#b5b2ad';
	}
	else
	{
		document.searchForm.bdate_day.style.backgroundColor='';
		document.searchForm.bdate_day.style.color='';
		document.searchForm.adate_day.style.backgroundColor='';
		document.searchForm.adate_day.style.color='';
	}
}

function disModule(modtype)
{
	var counter = 0;
	if(modtype == 1) /*country*/
	{
		document.searchForm.cntry[counter].checked = true;
	}
	else /*rating*/
	{
		counter = 5;
		document.searchForm.rating[counter].checked = true;
	}
}


function copyData()
{
	document.postForm.desc.value=document.frmfreequery.desc.value;
	if((document.frmfreequery.s_modid) && (document.frmfreequery.s_modid.value == 'FCP'))
	{
		document.postForm.page_referrer.value='';
	}
	else
	{
		document.postForm.page_referrer.value=document.frmfreequery.page_referrer.value;
	}
	document.postForm.s_ip.value=document.frmfreequery.s_ip.value;
	document.postForm.s_ip_country.value=document.frmfreequery.s_ip_country.value;
	
	if(document.postForm.email)
	{
		document.postForm.email.value=document.frmfreequery.email.value;
	}
	
	if(document.postForm.comp_name)
	{
		document.postForm.comp_name.value=trim(document.frmfreequery.s_organization.value);
	}
	
	if(document.postForm.first_name)
	{
		var actualname=trim(document.frmfreequery.sendername.value);
		if(actualname.indexOf(" ") != -1)
		{
			namearray = actualname.split(" ");
			if(namearray[0].length > 0){
				document.postForm.first_name.value=namearray[0];
			}
			if(namearray[1].length > 0){
				document.postForm.last_name.value=namearray[1];
			}
		}
		else
		{
			document.postForm.first_name.value=actualname;
		}
	}
	
	if(document.postForm.str_add1)
	{
		var my_str_add=trim(document.frmfreequery.s_streetaddress.value);
		if(my_str_add)
		{
			if(my_str_add.length > 75)
			{
				document.postForm.str_add1.value=my_str_add.substring(0,75);
				document.postForm.str_add2.value=my_str_add.substring(75);
			}
			else
			{
				document.postForm.str_add1.value=my_str_add;
			}
		}
	}
	
	if(document.postForm.zip)
	{
		document.postForm.zip.value=trim(document.frmfreequery.s_zip.value);
	}

	if(document.postForm.usr_cnt)
	{
		document.postForm.usr_cnt.value=document.getElementById('usr_cnt').value;
	}
	
	return false;
}

function assign_hidden_param(Form)
{
	if(Form.txtState_SelectedValue)
	{
		if(Form.txtState_SelectedValue.value != '')
		{
			Form.state_others.value=Form.txtState.value;
			Form.state.value=Form.txtState_SelectedValue.value;
		}
		else
		{
			Form.state_others.value=Form.txtState.value;
			Form.state.value='';
		}
	}
	
	if(Form.txtCity_SelectedValue)
	{
		if(Form.txtCity_SelectedValue.value != '')
		{
			Form.city_others.value=Form.txtCity.value;
			Form.city.value=Form.txtCity_SelectedValue.value;
		}
		else
		{
			Form.city_others.value=Form.txtCity.value;
			Form.city.value='';
		}
	}
	
	if(Form.usr_pass)
	{
		Form.usr_pass.value = Math.floor(Math.random()*9999)+100000;
	}
	
	Form.free_enq_del.value = document.frmfreequery.current_free_enq.value;
	Form.free_enq_next.value = document.frmfreequery.next_free_enq.value;
}

function Check_ModReg(Form)
{
	assign_hidden_param(Form); // setting the hidden parameters of states & cites ...

	if((Form.indsites) && Form.indsites.value == 0) {
		alert("Kindly select portal first.");
		//Form.category.focus();
		return false;
	}
		
	if ((Form.website) && Form.website.value.length != 0)
	{
		if(Form.website.value.indexOf(" ") != -1)	{
		alert("Kindly enter correct URL without any spaces in it.");
		Form.website.focus();
		return false;
		}
		if(Form.website.value.indexOf("@") != -1)	{
		alert("Invalid Website ! Kindly enter correct website.");
		Form.website.focus();
		return false;
		}
		if(Form.website.value.indexOf(".") == -1)	{
		alert("Invalid Website ! Kindly enter correct website.");
		Form.website.focus();
		return false;
		}
		validarr = Form.website.value.split(".");
	
		if(validarr[0].length<2)   	{
		alert("Invalid Website ! Kindly enter correct website.");
		Form.website.focus();
		return false;
		}
		if(validarr[1].length<2)   	{
		alert("Invalid Website ! Kindly enter correct website.");
		Form.website.focus();
		return false;
		}
	}
	
	if((Form.first_name) && Form.first_name.value == "" ) {
		alert("Kindly enter your First Name.");
		Form.first_name.focus();
		return false;
	}
	
	if((Form.email) && Form.email.value == "" ) {
		alert("Kindly enter your E-mail ID.");
		Form.email.focus();
		return false;
	}
	else if ((Form.email) && Form.email.value.length != 0)
	{

		if(Form.email.value.indexOf(" ") != -1)	{
		alert("Kindly enter correct E-Mail ID without any spaces in it.");
		Form.email.focus();
		return false;
		}
	
		if(Form.email.value.indexOf("@") == -1)	{
		alert("Invalid E-Mail ID! Kindly enter correct E-Mail ID.");
		Form.email.focus();
		return false;
		}
		if(Form.email.value.indexOf(",") != -1)	{
		alert("Invalid E-Mail ID! Kindly enter correct E-Mail ID.");
		Form.email.focus();
		return false;
		}
		if(Form.email.value.indexOf(")") != -1)	{
		alert("Invalid E-Mail ID! Kindly enter correct E-Mail ID.");
		Form.email.focus();
		return false;
		}
		if(Form.email.value.indexOf("(") != -1)	{
		alert("Invalid E-Mail ID! Kindly enter correct E-Mail ID.");
		Form.email.focus();
		return false;
		}
		validarr = Form.email.value.split("@");
	
		if(validarr[0].length==0)   	{
		alert("Invalid E-Mail ID! Kindly enter the correct E-mail ID.");
		Form.email.focus();
		return false;
		}
		if(validarr[0].length != 0)   	{
			if(validarr[0].indexOf(".") != -1)     	{
			validemail = validarr[0].split(".");
			if(validemail[0].length<1)   		{
			alert("Invalid E-Mail ID! Kindly enter the correct E-mail ID.");
			Form.email.focus();
			return false;
			}
			if(validemail[1].length<1)  		{
			alert("Invalid E-Mail ID! Kindly enter the correct E-mail ID.");
			Form.email.focus();
			return false;
			}
			}
		}   // end of of validemail
		if(validarr[1].indexOf("@") >=0)   	{
		alert("Invalid E-Mail ID! Kindly enter the correct E-mail ID.");
		Form.email.focus();
		return false;
		}
		if(validarr[1].length==0)   	{
		alert("Invalid E-Mail ID! Kindly enter the correct E-mail ID.");
		Form.email.focus();
		return false;
		}
		if(validarr[1].length != 0)   	{
	
			if(validarr[1].indexOf(".") == -1)     	{
			alert("Invalid E-Mail ID! Kindly enter the correct E-mail ID.");
			Form.email.focus();
			return false;
			}
			validemail = validarr[1].split(".");
			if(validemail[0].length<1)   		{
			alert("Invalid E-Mail ID! Kindly enter the correct E-mail ID.");
			Form.email.focus();
			return false;
			}
			if(validemail[validemail.length-1].length<2)  		{
			alert("Invalid E-Mail ID! Kindly enter the correct E-mail ID.");
			Form.email.focus();
			return false;
			}
		}   // end of of validemail
	
	} // end of valid email-id check
	
	if((Form.country_name) && Form.country_name.value == "") {
		alert("Kindly select the Country.");
		Form.country.focus();
		return false;
	}
	
	if((Form.ph_country) && Form.ph_country.value == "") {
		alert("Kindly enter country code for Telephone Number.");
		Form.ph_country.focus();
		return false;
	}
	/* new ph & mob code */
	if((Form.ph_no) && (Form.mobile))
	{
		if (((Form.ph_no.value =='') || (Form.ph_no.value.length == 0 )) && ((Form.mobile.value == '') || (Form.mobile.value.length == 0)))
		{
			alert ("Kindly enter either Phone Number or Mobile Number.");
			Form.ph_no.focus();
			return false;
		}
			
		if(/^\s+$/.test(Form.ph_area.value))
		{
			alert ("Remove spaces from Phone (Area Code).");
			Form.ph_area.focus();
			return false;
		}
		
		if((/\s+/.test(Form.ph_no.value)) && (Form.ph_no.value != ''))
		{
			alert ("Remove spaces from Phone Number.");
			Form.ph_no.focus();
			return false;
		}
		
		if(!(/^\d+$/.test(Form.mobile.value)) && (Form.mobile.value != ''))
		{
			alert ("Kindly enter numeric value in Mobile Number.");
			Form.mobile.focus();
			return false;
		}
	}
	/* new ph & mob code ends */
	//fax start
	if(Form.fax_country && Form.fax_country.value.length > 6) 
	{
		alert("Fax (Country Code) should not exceed 6 characters.");
		Form.fax_country.focus();
		return false;
	}
	if(Form.fax_area && Form.fax_area.value !='') 
	{
		if(isNaN(Form.fax_area.value))
		{
			alert("Fax (Area Code) should be an integer value.");
			Form.fax_area.focus();
			return false;
		}

		if(Form.fax_area.value.length > 6) 
		{
			alert("Fax (Area Code) should not exceed 6 characters.");
			Form.fax_area.focus();
			return false;
		}
	}
	
	if(Form.fax_no && Form.fax_no.value.length > 35) 
	{
		alert("Fax (Number) should not exceed 35 characters.");
		Form.fax_no.focus();
		return false;
	}
	//fax end

	/* Trade offer feilds checking Starts... */
	if(trim(Form.title.value) == "") {
		alert("Kindly enter offer title.");
		Form.title.focus();
		return false;
	}
	
	if(trim(Form.desc.value) == "" ) {
		alert("Kindly describe your correct requirements.");
		Form.desc.focus();
		return false;
	}
	if(Form.desc.value.length > 2000) {
		alert("Your description should be less than 2000 charecters.");
		Form.desc.focus();
		return false;
	}

// 	if(document.getElementById('dupflag') && document.getElementById('dupflag').value == 0)
// 	{
// 		isdupofr(); // dupliate Offer checking
// 	}

	if(Form.category.value == "") {
		alert("Kindly select category first.");
		//Form.category.focus();
		return false;
	}
	
// 	var dupOffer =0;
// 	if(document.getElementById('dupOffer'))
// 	{
// 		dupOffer = document.getElementById('dupOffer').value;
// 		if(dupOffer > 0)
// 		{
// 			var cnf=confirm('Already Posted Buy Lead by Offer ID - '+dupOffer+', want to Post Again?');
// 			if (cnf==true)
// 			{
// 				return true;
// 			}
// 			else
// 			{
// 				return false;
// 			}
// 		}
// 	}

	if ((Form.first_name) && Form.first_name.value.length  > 20)
	{
		alert("First Name should not exceed 20 characters.");
		Form.first_name.focus();
		return false;
	}
	if ((Form.last_name) && Form.last_name.value.length  > 20)
	{
		alert("Last Name should not exceed 20 characters.");
		Form.last_name.focus();
		return false;
	}
	
	if((Form.email) && Form.email.value.length > 100)
	{
		alert("Email should not exceed 100 characters.");
		Form.email.focus();
		return false;
	}
	
	if((Form.country_name) && Form.country_name.value.length > 40) {
		alert("Country Name should not exceed 40 characters.");
		Form.country_name.focus();
		return false;
	}
	if((Form.ph_country) && Form.ph_country.value.length > 6) {
		alert("Telephone (Country Code) should not exceed 6 characters.");
		Form.ph_country.focus();
		return false;
	}
	if((Form.ph_area) && Form.ph_area.value !='') {
		if(isNaN(Form.ph_area.value))
		{
			alert("Telephone (Area Code) should be an integer value.");
			Form.ph_area.focus();
			return false;
		}
	}
	if((Form.ph_area) && Form.ph_area.value.length > 6) {
		alert("Telephone (Area Code) should not exceed 6 characters.");
		Form.ph_area.focus();
		return false;
	}
	if((Form.ph_no) && Form.ph_no.value.length > 35) {
		alert("Telephone (Number) should not exceed 35 characters.");
		Form.ph_no.focus();
		return false;
	}
	
	if(Form.comp_name && Form.comp_name.value.length > 100) {
		alert("Company Name should not exceed 100 characters.");
		Form.comp_name.focus();
		return false;
	}
	/*
	if((Form.str_add1) && Form.str_add1.value.length > 150) {
		alert("Street Address should not exceed 150 characters.");
		Form.str_add1.focus();
		return false;
	}
	*/
	if((Form.mobile) && Form.mobile.value !='') {
		if(Form.mobile.value.length > 40) {
			alert("Your Mobile no. should not exceed 40 digits.");
			Form.mobile.focus();
			return false;
		}
		if(Form.mobile.value.length < 8) {
			alert("Your Mobile no. should be greater than 7 digits.");
			Form.mobile.focus();
			return false;
		}
	}
	
	if((Form.cat_ofr_cnt) && Form.cat_ofr_cnt.value > 0) 
	{
		var cnf=confirm("User have already Live offer in this category. \nAre you sure to post offer on the same ?");
		if (cnf==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	if((Form.ind_companyid) && (document.frmfreequery.r_companyid.value != Form.ind_companyid.value))
	{
		var cnf=confirm("Are you sure to post offer for the selected portal ?");
		if (cnf==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function set_indsites_det(MyForm)
{
	var val = MyForm.sl_indsites.options[MyForm.sl_indsites.selectedIndex].value;
	myarr = val.split("###");

	if(myarr[1])
	{
		MyForm.indsites.value=myarr[0];
		MyForm.ind_companyid.value=myarr[1];
	}
	else
	{
		MyForm.indsites.value=myarr[0];
	}
}

function popup1(url)
{
	window.open(url, 'Lookup', 'toolbar=no, location=no, width=300, height=170, left=200, top=200, screenX=200, screenY=200');
}

function isdupofr()
{
	var xmlHttp=ajaxFunction();
	var spanID = 'isdupofr';
	var spanID1 = 'dupflag';
	var spanID2 = 'dupOffer';

	document.getElementById(spanID2).value=0;
	document.getElementById(spanID1).value=0;
	document.getElementById(spanID).innerHTML='';

	var desc = document.getElementById('desc').value;
	var titl = document.getElementById('title').value;
	var glusrid = document.getElementById('glusrid').value;
	desc = desc.replace(/\+/g,"&#43;"); // +not work in browser make it blank
	
	if(glusrid)
	{
		var url = 'eto-history-fenq.mp';
		var params = 'action=isdupofr&glusrid='+glusrid+'&desc='+escape(desc)+'&title='+titl+"&encode=1&sid="+Math.random();
		xmlHttp.open("POST", url, true);
		//Send the proper header information along with the request
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttp.setRequestHeader("Content-length", params.length);
		xmlHttp.setRequestHeader("Connection", "close");

		if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					var temp = xmlHttp.responseText;
					if(temp > 0)
					{
						var disp = '<A HREF="eto-rightframes.pl?openpg=admin-eto.pl?search=y%26offer='+temp+'" target="_new">'+temp+'</A>';

						document.getElementById(spanID2).value=temp;
						document.getElementById(spanID).innerHTML='Already Posted Buy Lead by Offer ID - '+disp;
						document.getElementById(spanID1).value=1;
					}
				}
			}
		}
		xmlHttp.send(params);
	}
}

function deleteEnquery(MyForm)
{
	var quid=MyForm.quid.value;
	var empid=MyForm.empid.value;
	var spanID = 'enqrec'+quid;
	var xmlHttp=ajaxFunction();

	if(xmlHttp)
	{
		xmlHttp.onreadystatechange=function()
		{

			if(xmlHttp.readyState==4)
			{

				document.getElementById(spanID).innerHTML=xmlHttp.responseText;
			}
			else
			{

				document.getElementById(spanID).innerHTML='<DIV STYLE="color:red;font-weight:bold;height:35px;">Deleting enquiry...</DIV>';
			}
		}
		xmlHttp.open("GET","eto-pbl-del-free-enq.mp?quid="+quid+"&empid="+empid,true);
		xmlHttp.send(null);
	}
}

function processReviewedFlag(Form,queryid,email,date)
{	
	document.getElementById('is_reviewed').disabled = true;	
	var xmlHttp=ajaxFunction();

	if(xmlHttp)
	{
		xmlHttp.onreadystatechange=function()
		{
			if(xmlHttp.readyState==4)
			{
				document.getElementById('successDiv').innerHTML='Successfully Reviewed<br><span style="color:#0000FF; line-height:13px;">Kindly Click on Next Sender</span>';
			}
			else
			{
				document.getElementById('successDiv').innerHTML='Processing...';	
			}
		}
		xmlHttp.open("GET","eto-history-fenq.mp?action=Reviewed&quid="+queryid+"&email="+email+"&date="+date,true);
		xmlHttp.send(null);
	}

}