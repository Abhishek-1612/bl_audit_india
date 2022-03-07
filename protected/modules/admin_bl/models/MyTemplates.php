<?php
class MyTemplates extends CFormModel
{
	public function userinfo_html($title,$heading,$heading1,$heading2,$message,$trdalerts,$stshistory)
	{
	$stshistoryxml='';
// 	echo $title.'<--title'.$heading.'<--h'.$heading1.'<--h1'.$heading2.'<--h2'.$message.'<--msg'.$trdalerts.'<--trdalert'.$stshistory.'<--stshistory';
	$message = <<<MSG

<HTML>  
  <HEAD>
    <TITLE>$title</TITLE>
<script type="text/javascript">
function filterbyfield()
{
	if(document.getElementById('select1').selectedIndex >0)
	{

document.getElementById('checkbox1').checked=false;
document.getElementById('checkbox2').checked=false;
document.getElementById('checkbox3').checked=false;
var flag=0;	field=document.getElementById('select1').options[document.getElementById('select1').selectedIndex].value;
	var xmlDoc=init(text);
	var x=xmlDoc.getElementsByTagName("history");
	for(i=0;i<x.length;i++)
	{
		flag=0;
		var z=x[i].childNodes;
		for(j=0;j<z.length;j++)
		{
			var y=x[i].childNodes[j].nodeName;
			if(y == 'modifiedfields')
			{
				var s='';
				var total=x[i].getElementsByTagName(y);
				var t_cnt=total.length;
				if(t_cnt>1)
				{
					s=x[i].getElementsByTagName(y)[i];
				}
				else
				{
					s=x[i].getElementsByTagName(y)[0];
				}
				var ts=s.childNodes;
				for(k=0;k<ts.length;k++)
				{
					var fieldname=x[i].getElementsByTagName('field')[k].getAttribute("name");					
					if(fieldname==field)
					{
						flag=1;
					}
				}
			}

		}
		if(flag==0)
		{
			re=xmlDoc.getElementsByTagName("history")[i];
			z=xmlDoc.documentElement.removeChild(re);				
			x=xmlDoc.getElementsByTagName("history");
			--i;
		}
	}
	var display='';
	if(xmlDoc)
	{
		display=display_html(xmlDoc);
	}
	document.getElementById("display").innerHTML=display;
	}
	else
	{
		document.getElementById('checkbox1').checked=true;
		parseXML();
	}
}
function filterbyaction(user)
{
	var user1=user;
	var re='';	
	document.getElementById('select1').selectedIndex=0;
	var xmlDoc=init(text);
	var x=xmlDoc.getElementsByTagName("step");
	
 	for(i=0;i<x.length;i++)
	{		
		var who=x[i].getAttribute("who");
		if(user1 =='User')
		{
			if(document.getElementById('checkbox2').checked)
			{
				if(document.getElementById('checkbox1').checked)
				document.getElementById('checkbox1').checked=false;
				if(document.getElementById('checkbox3').checked)
				document.getElementById('checkbox3').checked=false;
			}
			else
			{
				document.getElementById('checkbox1').checked=true;
				parseXML();
			}
			if(who != user1)
			{	
				re=xmlDoc.getElementsByTagName("history")[i];
				z=xmlDoc.documentElement.removeChild(re);				
				x=xmlDoc.getElementsByTagName("step");
				--i;
			}
		}
		else
		{
			if(document.getElementById('checkbox3').checked)
			{
				if(document.getElementById('checkbox1').checked)
				document.getElementById('checkbox1').checked=false;
				if(document.getElementById('checkbox2').checked)
				document.getElementById('checkbox2').checked=false;
			}
			else
			{
				document.getElementById('checkbox1').checked=true;
				parseXML();
			}			
			if(who == 'User')
			{
				
				re=xmlDoc.getElementsByTagName("history")[i];
				z=xmlDoc.documentElement.removeChild(re);				
				x=xmlDoc.getElementsByTagName("step");
				--i;
				
				
				
			}
		}
	}
	var display_test='';
	if(xmlDoc)
	{
		display_test=display_html(xmlDoc);
	}
	document.getElementById("display").innerHTML=display_test;
}

function parseXMLfilter()
{
	xmlDoc1=filter_who('User');
	display=display_html(xmlDoc1);
	document.getElementById("display").innerHTML=display;
}

function parseXML()
{	
	document.getElementById('select1').selectedIndex=0;
	if(document.getElementById('checkbox1').checked)
	{
		if(document.getElementById('checkbox2').checked)
		document.getElementById('checkbox2').checked=false;
		if(document.getElementById('checkbox3').checked)
  		document.getElementById('checkbox3').checked=false;
		var xmlDoc=init(text);
		var display=display_html(xmlDoc);
		document.getElementById("display").innerHTML=display;
	}
	else
	{
		
  		//if(document.getElementById('checkbox2').checked)
		document.getElementById('checkbox1').checked=true;
		document.getElementById('checkbox3').checked=false;
		document.getElementById('checkbox2').checked=false;
		parseXML();
		//if(document.getElementById('checkbox3').checked)
  		//document.getElementById('checkbox3').checked=false;
		//document.getElementById("display").innerHTML='';
	}

}

function init(text)
{
	try //Internet Explorer
	{
	xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
	xmlDoc.async="false";
	xmlDoc.loadXML(text);
	}
	catch(e)
	{
	try // Firefox, Mozilla, Opera, etc.
	{
	parser=new DOMParser();
	xmlDoc=parser.parseFromString(text,"text/xml");
	}
	catch(e)
	{
	alert(e.message);
	return;
	}
	}
	return xmlDoc;
}



function display_html(xmlDoc)
{
var display='';
var display1='';
 var x=xmlDoc.getElementsByTagName("history");
  for(i=0;i<x.length;i++)
  {
  	var z=x[i].childNodes;
	for(j=0;j<z.length;j++)
	{
		var y=x[i].childNodes[j].nodeName;
		if(y == 'step')
		{
			var s='';
			var total=x[i].getElementsByTagName(y);
			var t_cnt=total.length;
			if(t_cnt>1)
			{
				s=x[i].getElementsByTagName(y)[i];
			}
			else
			{
				s=x[i].getElementsByTagName(y)[0];
			}
			var type=s.getAttribute("type");
			var who=s.getAttribute("who");
			var date=s.getAttribute("date");
			var ip=s.getAttribute("ip");
			var ipcountry=s.getAttribute("ipcountry");
			var module=s.getAttribute("module");
			var step=type+': "'+who+'" on "'+date+'" from "'+ip+'" ['+ipcountry+'] using "'+module+'"';
			display =display+'<table style="border-collapse: collapse;" class="table_txt" border="1" bordercolor="#ffffff" width="100%"><tr><td>'+step+'</td></tr></table>';

		}
		if(y == 'status')
		{
			var s='';
			var total=x[i].getElementsByTagName(y);
			var t_cnt=total.length;

			if(t_cnt>1)
			{
				s=x[i].getElementsByTagName(y)[i];
			}
			else
			{
				s=x[i].getElementsByTagName(y)[0];
			}
			var old=s.getElementsByTagName('old')[0].childNodes[0].nodeValue;
			var new1 =s.getElementsByTagName('new')[0].childNodes[0].nodeValue;
			var status='Status changed from '+old+' to '+new1;

			display =display+'<table style="border-collapse: collapse;" class="table_txt" border="1" bordercolor="#ffffff" width="100%"><tr><td>'+status+'</td></tr></table>';
		}
		if(y == 'comments')
		{
			var s='';
			var total=x[i].getElementsByTagName(y);
			var t_cnt=total.length;
			if(t_cnt>1)
			{
				s=x[i].getElementsByTagName(y)[i].childNodes[0].nodeValue;
			}
			else
			{
				s=x[i].getElementsByTagName(y)[0].childNodes[0].nodeValue;
			}

			display =display+'<table style="border-collapse: collapse;" class="table_txt" border="1" bordercolor="#ffffff" width="100%"><tr><td>'+s+'</td></tr></table>';
		}
		if(y == 'referer')
		{
			var s='';
			var total=x[i].getElementsByTagName(y);
			var t_cnt=total.length;
			if(t_cnt>1)
			{				s=x[i].getElementsByTagName(y)[i].childNodes[0].nodeValue;
			}
			else
			{				s=x[i].getElementsByTagName(y)[0].childNodes[0].nodeValue;
			}

			display =display+'<table style="border-collapse: collapse;" class="table_txt" border="1" bordercolor="#ffffff" width="100%"><tr><td>'+s+'</td></tr></table>';
		}
		if(y == 'referer_modid')
		{
			var s='';
			var total=x[i].getElementsByTagName(y);
			var t_cnt=total.length;
			if(t_cnt>1)
			{
				s=x[i].getElementsByTagName(y)[i].childNodes[0].nodeValue;
			}
			else
			{
				s=x[i].getElementsByTagName(y)[0].childNodes[0].nodeValue;
			}

			display =display+'<table style="border-collapse: collapse;" class="table_txt" border="1" bordercolor="#ffffff" width="100%"><tr><td>'+s+'</td></tr></table>';
		}
		if(y == 'modifiedfields')
		{
			var s='';
			var total=x[i].getElementsByTagName(y);
			var t_cnt=total.length;
			if(t_cnt>1)
			{
				s=x[i].getElementsByTagName(y)[i];
			}
			else
			{
				s=x[i].getElementsByTagName(y)[0];
			}
			var ts=s.childNodes;
			display=display+'<table style="border-collapse: collapse;" class="table_txt" border="1" bordercolor="#bedaff" width="100%"><tr><td bgcolor="#dff8ff" width="10%"><b>S.No.</b></td><td bgcolor="#dff8ff" width="30%"><b>Changed Data </b></td><td bgcolor="#dff8ff" width="30%"><b>Old Value</b></td><td bgcolor="#dff8ff" width="30%"><b>New Value</b></td></tr>';
			for(k=0;k<ts.length;k++)
			{
				var displayname=x[i].getElementsByTagName('field')[k].getAttribute("displayname");
				var counter=x[i].getElementsByTagName('field')[k].getAttribute("counter");
			var field=x[i].getElementsByTagName('field')[k];
			var t=field.getElementsByTagName('old')[0].childNodes;
			var old='';
			var new1='';
			if(t.length>0)
			{
			old=field.getElementsByTagName('old')[0].childNodes[0].nodeValue;
			}
			t=field.getElementsByTagName('new')[0].childNodes;
			if(t.length>0)
			{
			new1=field.getElementsByTagName('new')[0].childNodes[0].nodeValue;
			}
			display =display+'<tr><td>'+counter+'</td><td>'+displayname+'</td><td>'+old+'</td><td>'+new1+'</td></tr>';
			}
			display=display+'<table>';

		}

	}
	display1=display1+display+'<div><br></div>';
	display='';
  }
  return display1;
}
 </script>
<STYLE TYPE="text/css">
.table_txt
{
width:100%;
padding:0px;
font-family:arial;
font-size:12px;
color:#414141;
border-collapse:collapse;
border:1px solid #BEDAFF;
}

.table_txt td
{
padding-left:8px;
border:1px solid #BEDAFF;
height:21px;
}

.table_txt td b
{
font-size:13px;
color:#093772;
}

.table_txt1
{
width:90%;
padding:0px;
font-family:arial;
font-size:12px;
color:#414141;
border-collapse:collapse;
border:1px solid #FFFFFF;
}

.table_txt1 td
{
padding-left:8px;
border:1px solid #BEDAFF;
height:21px;
}

.table_txt1 td b
{
font-size:13px;
color:#093772;
}
</STYLE>
<STYLE TYPE="text/css">
.admintext {font-family:ms sans serif,verdana; font-size:9px;font-weight:bold;}
.admintext1 {font-family:ms sans serif,verdana; font-size:9px;}
.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}</STYLE>
<!--google analytics async code start-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28761981-2']);
  _gaq.push(['_setDomainName', '.intermesh.net']);
  _gaq.push(['_setSiteSpeedSampleRate', 10]);
  _gaq.push(['_trackPageview','/admin_glusr/!%ACTION%!?mid=!%moduleId%!']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!--google analytics async code end-->

  </HEAD>  
  <BODY LEFTMARGIN="0" TOPMARGIN="0" MARGINHEIGHT="0" MARGINWIDTH="0" onload="parseXML();">
    <DIV ALIGN="CENTER">
    <FORM METHOD="POST">
	<TABLE style="border-collapse: collapse;" class="table_txt" border="1" bordercolor="#ffffff" WIDTH="100%">
	  <TR>
		<TH ALIGN="CENTER" VALIGN="TOP" COLSPAN="4"><FONT SIZE="-1" FACE="arial" COLOR="#804040">$heading</FONT></TH>
	  </TR>
	$message
	</TABLE>
    <TABLE style="border-collapse: collapse;" class="table_txt" border="1" bordercolor="#ffffff" WIDTH="100%">
       <TR>
        <TH ALIGN="CENTER" VALIGN="TOP" COLSPAN="2"><FONT SIZE="-1" FACE="arial" COLOR="#804040">$heading1</FONT></TH>
       </TR>
		$trdalerts
    </TABLE>
    <TABLE WIDTH="100%" style="border-collapse: collapse;" border="1" bordercolor="#ffffff">
       <TR>
        <TH ALIGN="CENTER" VALIGN="TOP" COLSPAN="2"><FONT SIZE="-1" FACE="arial" COLOR="#804040">$heading2</FONT></TH>
       </TR>
		<tr><td><TABLE WIDTH="100%" style="border-collapse: collapse;" class="table_txt" border="0" bordercolor="#ffffff">

		<TR>
		<TD bgcolor="#dff8ff"><INPUT TYPE="CHECKBOX" value="1" NAME="CheckBox1" ID="checkbox1" onclick="return parseXML();" checked></TD>
		<TD bgcolor="#dff8ff" WIDTH="25%" HEIGHT="25">Complete history</TD>
		<TD bgcolor="#dff8ff"><INPUT TYPE="CHECKBOX" value="2" NAME="CheckBox2" ID="checkbox2" onclick="filterbyaction('User');"></TD>
		<TD bgcolor="#dff8ff" WIDTH="25%">User</TD>
		<TD bgcolor="#dff8ff"><INPUT TYPE="CHECKBOX" value="3" NAME="CheckBox3" ID="checkbox3" onclick="filterbyaction();"></TD>
		<TD bgcolor="#dff8ff" WIDTH="25%">Gladmin</TD>

		<TD bgcolor="#dff8ff">Fields</TD>
		<TD bgcolor="#dff8ff" WIDTH="25%"><SELECT NAME="searchfor" SIZE="1" onChange="filterbyfield();" id="select1">
            <OPTION VALUE="" SELECTED="SELECTED">Choose field</OPTION>
	    <OPTION VALUE="GLUSR_USR_EMAIL_ALT">Alternate Email</OPTION>
	    <OPTION VALUE="GLUSR_USR_ADD1">Address</OPTION>
	    <OPTION VALUE="GLUSR_USR_PH2_COUNTRY">Alternate Phone Country Code</OPTION>
		<OPTION VALUE="GLUSR_USR_PH2_AREA">Alternate Phone Area Code</OPTION>
		<OPTION VALUE="GLUSR_USR_PH2_NUMBER">Alternate Phone Number</OPTION>
		<OPTION VALUE="GLUSR_USR_COMPANYNAME">Company Name</OPTION>
		<OPTION VALUE="GLUSR_USR_CITY">City</OPTION>
		<OPTION VALUE="GLUSR_USR_COMPANY_DESC">Company Description</OPTION>
		<OPTION VALUE="GLUSR_USR_COUNTRYNAME">Country</OPTION>
		<OPTION VALUE="GLUSR_USR_CFIRSTNAME">CEO First Name</OPTION>
		<OPTION VALUE="GLUSR_USR_CLASTNAME">CEO Last Name</OPTION> 
		<OPTION VALUE="GLUSR_USR_DESIGNATION">Designation</OPTION>
		<OPTION VALUE="GLUSR_USR_EMAIL">Email</OPTION>
		<OPTION VALUE="GLUSR_USR_FIRSTNAME">First Name</OPTION>
		<OPTION VALUE="GLUSR_USR_INFRASTRUCTURE">Factory & Infrastructure</OPTION>
		<OPTION VALUE="GLUSR_USR_FAX_COUNTRY">Fax Country Code</OPTION>
		<OPTION VALUE="GLUSR_USR_FAX_AREA">Fax Area Code</OPTION>
		<OPTION VALUE="GLUSR_USR_FAX_NUMBER">Fax Number</OPTION>
		<OPTION VALUE="FREESHOWROOM_URL">Free Showroom Url</OPTION>
		<OPTION VALUE="GLUSR_USR_LASTNAME">Last Name</OPTION>
		<OPTION VALUE="GLUSR_USR_PH_MOBILE">Mobile Number</OPTION>
		<OPTION VALUE="FK_GLUSR_NOOF_EMP_ID">No. of Employee</OPTION>
		<OPTION VALUE="FK_GLUSR_BIZ_IDS">Nature of biz</OPTION> 
		<OPTION VALUE="FK_GL_LEGAL_STATUS_ID">Ownership type</OPTION>     
	        <OPTION VALUE="GLUSR_USR_PASS">Password</OPTION>
		<OPTION VALUE="GLUSR_USR_PH_COUNTRY">Phone Country Code</OPTION>
		<OPTION VALUE="GLUSR_USR_PH_AREA">Phone Area Code</OPTION>
		<OPTION VALUE="GLUSR_USR_PH_NUMBER">Phone Number</OPTION>
		<OPTION VALUE="GLUSR_USR_SELLINTEREST">Product Profile</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT1">Product1</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT2">Product2</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT3">Product3</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT4">Product4</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT5">Product5</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT6">Product6</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT7">Product7</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT8">Product8</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT9">Product9</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT10">Product10</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT11">Product11</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT12">Product12</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT13">Product13</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT14">Product14</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT15">Product15</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT16">Product16</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT17">Product17</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT18">Product18</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT19">Product19</OPTION>
		<OPTION VALUE="GLUSR_USR_PRODUCT20">Product20</OPTION>
		<OPTION VALUE="PAIDSHOWROOM_URL">Paid Showroom Url</OPTION>
		<OPTION VALUE="GLUSR_USR_QUALITY">Quality policy</OPTION>
		<OPTION VALUE="GLUSR_USR_STATE">State</OPTION>
		<OPTION VALUE="GLUSR_USR_TRADEMEMBERSHIP">Trade Membership</OPTION>
		<OPTION VALUE="FK_GLUSR_TURNOVER_ID">Turnover changed</OPTION>
		<OPTION VALUE="GLUSR_USR_VILLAGETOWN">Village/Town</OPTION>
		<OPTION VALUE="GLUSR_USR_URL">Website</OPTION>
		<OPTION VALUE="GLUSR_USR_YEAR_OF_ESTB">Year of Estb.</OPTION>
		<OPTION VALUE="GLUSR_USR_ZIP">Zip/Postal Code</OPTION></select></TD>
		</TR></table><DIV><BR></DIV><span id="display"></span></td></tr>
				<TR>
            <TD ALIGN="CENTER" VALIGN="TOP" COLSPAN="2">
			<INPUT TYPE=BUTTON VALUE="Close Window"
			OnClick="JavaScript: window.close();"></TD>
          </TR>
    </TABLE>

    </FORM></DIV>
  </BODY>
</HTML>
MSG;
echo $message;
	}
}
?>