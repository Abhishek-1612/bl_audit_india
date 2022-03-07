<?php
    if(!isset($_REQUEST['relevancyreport']))
   {
        $currentDate = date("d-m-Y", strtotime('-8 days'));
        $prevdate =date('d-m-Y', strtotime('-1 days'));
        $request = Yii::app()->request;
        $start_date= $request->getParam('start_date','');
        $start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));

        $end_date= $request->getParam('end_date','');
        $end_date = (!empty($end_date)?$end_date:(!empty($prevdate)?$prevdate: ''));
        $start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
        $end_date = strtoupper(date("d-M-Y",strtotime($end_date)));        
  ?>
<html>
<head><title>Not Interested Report</title>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">    
<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script>

function validate()
{       

 if(document.f1.report.value == "" || document.f1.report.value == null)
     {   
     
         
                if(document.f1.detail.value ==="1") {
		alert("Please Enter GLUSER-ID");}
		else if(document.f1.detail.value =="2"){
		alert("Please Enter OFFER-ID");}
		document.f1.report.focus();
		return false;	
     }


	else if(document.f1.report.value != "")
	{
		report1=document.f1.report.value;
		if(document.f1.detail.value =="2" && (report1.length < '10' || report1.length > '11'))
		{
			alert("Please Enter valid OFFER-ID");
			document.f1.report.focus();
			return false;
		}
	}
	report=document.f1.report.value;
	for(i=0; i<report.length; i++)
	{
		if(report.charAt(i) < "0" || report.charAt(i) > "9")
		{
			alert("ID must be Numeric");
			document.f1.report.focus(); 
			document.f1.report.select(); 
			return false;
		}
	}
        var start=new Date(document.f1.start_date.value);
            if(document.f1.start_date.value =='' || document.f1.end_date.value =='')
            { 
            alert("Kindly Select Start and End Date");
               return false;
            }
            
            var end=new Date(document.f1.end_date.value);
            var timeDiff = end.getTime() - start.getTime();
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
            if(diffDays>30)
            { 
            alert("Kindly Select Dates In Span Of 30 Days Only");
                       return false;
            }
            else if(diffDays<0)
            {
                alert("End Date Cant Be Smaller Than Start Date");
                return false;
            }
}
function win_detail(urlpage)
{
myWindow=window.open(urlpage,'','scrollbars=1');
myWindow.focus();
}

// function openLiveMcatPage(arg){
// 	glid = $("#report").val();
// 	mcat_id = arg;
// 	window.location.href = ;

// }

function updateNegativeMcats(arg){
	glid = $("#report").val();
    var mcatList = new Array();
		if(arg == 1){
			$("input[name=name2]:checked").each(function(){
				mcatList.push($(this).val());
			});
		}else if(arg == 2){
			$("input[name=name1]:checked").each(function(){
				mcatList.push($(this).val());
			});	
		}
		//console.log(mcatList);
	  mcatList = mcatList.toString();
	   	   url = "/index.php?r=admin_bl/NonInterested/SaveNegativeMcats";
	$.ajax({
			type: "POST",
			url: url,
			data:{mcatList:mcatList,glid:glid},
			//async: false,
			success: function(result){
				$("input[type=Submit]").attr('disabled', false);
				if(result=='Yes'){
					$('#success1').css('display','inline-block');
					// setTimeout(function(){$('#success2').fadeIn();  }, 6000);
				}else{
				  $('#failed1').css('display','inline-block');
				  // setTimeout(function(){ $('#failed2').fadeIn(); }, 6000);
				}
			},
			error: function() {
				$('#failed1').css('display','inline-block');
				  // setTimeout(function(){ $('#failed2').fadeIn(); }, 6000);
				}
		});
}

function updateCaseClosure(){
	glid = $("#report").val();
	var micro = $("#micro").val();
    var final = $("#final").val();
		var comment = $("#text").val();
	url = "/index.php?r=admin_bl/NonInterested/SaveCaseClosure";
	$.ajax({
			type: "POST",
			url: url,
			data:{micro:micro,glid:glid,final:final,comment:comment},
			//async: false,
			success: function(result){
				$("input[type=Submit]").attr('disabled', false);
				if(result=='Yes'){
					$('#success2').css('display','inline-block');
					// setTimeout(function(){$('#success2').fadeIn();  }, 6000);
				}else{
					$('#failed2').css('display','inline-block');
				  // setTimeout(function(){ $('#failed2').fadeIn(); }, 6000);
				}
				
			},
			error: function() {
				$('#failed2').css('display','inline-block');
				//  setTimeout(function(){ $('#failed2').fadeIn(); }, 6000);
				}
		});
}

function relatedOffers(mcatid){
	$(".offerTable tr td:first-child").removeClass("selectivemc");
	$(".offerTable tr#"+mcatid+" td:first-child").addClass("selectivemc");
	glid = $("#report").val();
	tdate = $("#end_date").val();
	sdate = $("#start_date").val();
	url = "/index.php?r=admin_bl/NonInterested/OfferDetails&mcatid="+mcatid+"&sdate="+sdate+"&tdate="+tdate+"&glid="+glid;
	$.ajax({
			type: "POST",
			url: url,
			data:"",
			//async: false,
			success: function(result){
				$("input[type=Submit]").attr('disabled', false);
				if(result!=''){
					$("#offerDetails").html(result);
				}else{
				  $("#offerDetails").html('<span><center><font size = "3"><b>No Data Found.</b></font></center></span>');
				}
				$('#negMcat').css('display','inline-block');
			},
			error: function() {
				$("input[type=Submit]").attr('disabled', false);
				$("#offerDetails").html('<span><center><font size = "3"><b>Something Went Wrong. Kindly Try again.</b></font></center></span>');
			
				}
		});
}

		function getNegativeMcats(){
			glid = $("#report").val();
			url = "/index.php?r=admin_bl/NonInterested/GetNegativeMcats&glid="+glid;
	$.ajax({
			type: "POST",
			url: url,
			data:"",
			//async: false,
			success: function(result){
				$("input[type=Submit]").attr('disabled', false);
				if(result!=''){
					$("#negativeMcats").html(result);
				}else{
				  $("#negativeMcats").html('<span><center><font size = "3"><b>No Data Found.</b></font></center></span>');
				}
			},
			error: function() {
				$("input[type=Submit]").attr('disabled', false);
				$("#negativeMcats").html('<span><center><font size = "3"><b>Something Went Wrong. Kindly Try again.</b></font></center></span>');
			
				}
		});
		}

</script>
<style>
td{
	border: 1px solid black;
}

.selectivemc{
	background-color: aqua;
}
</style>
</head><BODY>
	
    <FORM ACTION="index.php?r=admin_bl/NonInterested/SecondPage&mid=3439" METHOD="post" NAME="f1">
    <table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1">  <TR>
            <td colspan="4" bgcolor="#dff8ff" align="center"><font color=" #333399"><b>Rejection Report</b></font></td>			 	
      </TR>
      <tr>
      </tr>
	  <?php 
	  echo '<TR><TD width="40%" colspan="2">&nbsp;<label>Glusr ID</label>
	  <input name="report" type="text" value="'.$sbjVal.'" SIZE="13" id="report">
      </TD>';?>      
      <!-- echo '<TR><TD width="40%" colspan="2">&nbsp;<SELECT NAME="detail" id="detail"> -->
		<!-- <OPTION VALUE="1" '; if ( $Frmdetail == "1" ){ echo ' Selected ';}  echo ' >GLUSER-ID</OPTION> -->
		<!-- <OPTION VALUE="2" '; if ( $Frmdetail == "2" ){ echo 'Selected ';} echo ' >OFFER-ID</OPTION> -->
		<!-- </SELECT>&nbsp;<INPUT NAME="report" TYPE="text" value="'.$sbjVal.'" style="width:130px;"> </TD>';?>       -->
	<TD width="60%" colspan="2">&nbsp;Enter Date:&nbsp;
       <input name="start_date" type="text" VALUE="" SIZE="13" onfocus="displayCalendar(document.f1.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.f1.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
        &nbsp;to&nbsp;
        <input name="end_date" type="text" VALUE="" SIZE="13" onfocus="displayCalendar(document.f1.end_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.f1.end_date,'dd-mm-yyyy',this,'','','from_date1')" id="end_date" TYPE="text" readonly="readonly">
	</TD>
      </tr>
      <tr>	
        <TD colspan="4" style="font-family:arial;font-size:14px;font-weight:bold;" align="center">
            <input type="submit" value="Generate Report" ONCLICK="return validate()" name="genmis">
        </TD></tr>
		<!-- <tr>
        <td COLSPAN="4" ALIGN="right">1. <a href="index.php?r=admin_bl/Eto_rej_ofr/Relevancyreport&mid=3439" target="_blank"> Relevancy Report </a><br>
                        2. <a href="index.php?r=admin_bl/Eto_rej_ofr/Summary&mid=3439" target="_blank"> Buy Leads Rejection Summary </a></td>
      </TR> -->
    </TABLE></FORM>
<?php	
}

if($Frmdetail == 1)
 {
 if(isset($rec['GLUSR_USR_COMPANYNAME']))
	    {
	    $company = $rec['GLUSR_USR_COMPANYNAME'];
	    }
	    else
	    {
	    $company = '';
	    }

	    if(isset($rec['GLUSR_USR_CUSTTYPE_NAME']))
	    {
	    $custtype_name = $rec['GLUSR_USR_CUSTTYPE_NAME']; 
	    }
	    else 
	    {$custtype_name = '';}

	    if(isset($rec['GLUSR_NAME']))
	    {$name = $rec['GLUSR_NAME'];}
	    else
	    {$name = '';}

	    if(isset($rec['GLUSR_USR_EMAIL']))
	    {$email = $rec['GLUSR_USR_EMAIL'];}
	    else
	    {$email = '';}

	    if(isset($rec['GLUSR_MOBILE']))
	    {$mobile = $rec['GLUSR_MOBILE'];}
	    else
	    {$mobile= '';}

	    if(isset($rec['GLUSR_PH_NUMBER']))
	    {$phone = $rec['GLUSR_PH_NUMBER'];}
	    else
	    {$phone = '';}

	    if(isset($rec['GLUSR_USR_ID']))
	    {$glid = $rec['GLUSR_USR_ID'];} 
	    else
	    {$glid = '';}

	    if(isset($rec['GLUSR_ADD']))
	    {$address = $rec['GLUSR_ADD'];}
	    else
	    {$address = '';}

	    if(isset($rec['GLUSR_USR_ZIP']))
	    {$zipcode = $rec['GLUSR_USR_ZIP'];} 
	    else
	    {$zipcode = '';}

	    if(isset($rec['GLUSR_USR_CITY']))
	    {$city = $rec['GLUSR_USR_CITY'];}
	    else
	    {$city = '';}

	    if(isset($rec['GLUSR_USR_STATE']))
	    {$state = $rec['GLUSR_USR_STATE'];}
	    else
	    {$state = '';} 

	    if(isset($rec['GL_COUNTRY_NAME']))
	    {$country = $rec['GL_COUNTRY_NAME'];}
	    else
	    {$country = '';}

	    if(isset($rec['URL']))
	    {$url = $rec['URL'];}
	    else
	    {$url = '';}

	    if(isset($rec['GLUSR_USR_LOC_PREF']))
	    {$loc_pref = $rec['GLUSR_USR_LOC_PREF'];} 
	    else
	    {$loc_pref = '';}

	    if(isset($rec['GLUSR_ETO_CUST_CREDITS_AV']))
	    {$credit = $rec['GLUSR_ETO_CUST_CREDITS_AV'];}
	    else
	    {$credit = '';}

	    if(isset($rec['GLUSR_USR_COMPID']))
	    {$cmpid=$rec['GLUSR_USR_COMPID'];}
	    else
	    {$cmpid = '';}

	      echo '<br><table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tbody>
		<tr>
		<td  valign="top" width="400" style="line-height:18px"><b>GLID:</b>&nbsp;'.$glid.'<br>
		<div><b>'.$company.'('.$custtype_name.')</b></div>
		<b>Mobile:</b>&nbsp;'.$mobile.'<br>
		<b>Address:</b>&nbsp;'.$address.'-'.$city.'-'.$zipcode.'<br>
		<b>Country:</b>&nbsp;'.$country.'<br>
		</td>';
		
		
		echo '<td  valign="top" width="300" style="line-height:18px"><b>Email:</b>&nbsp;'.$email.'<br>
		<b>Name:</b>&nbsp;'.$name.'<br>
		<b>Telephone:</b>&nbsp;'.$phone.'<br>
		<b>State:</b>&nbsp;'.$state.'<br>
		<b>URL:</b>&nbsp;<a href='.$url.' target="_blank">'.$url.'</a><br>
		<b>Location preference:</b>';
		if($loc_pref==1)
		{
		echo "Global";
		}
		elseif($loc_pref==2){
		echo 'India only';
 		}
		elseif($loc_pref==3){
		echo 'Foreign only';
		}
		elseif($loc_pref==4){
		echo 'Local only ';
		}
		else{
		echo 'N/A ';
		}
                $emp_id =Yii::app()->session['empid'];
		echo '&nbsp;</td>';
		echo '</tr>
                </tbody></TABLE>';
                
    }
    
    if($Frmdetail == 2)
    {
     if(isset($rec['ETO_OFR_TITLE']))
	      {$Title = $rec['ETO_OFR_TITLE'];} 
	      else
	      {$Title = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_EXP_DATE']))
	      {$Expire_date = $rec['ETO_OFR_EXP_DATE'];} 
	      else
	      {$Expire_date = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_DESC']))
	      {$Decription = $rec['ETO_OFR_DESC'];} 
	      else
	      {$Decription = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_QTY']))
	      {$Quanity = $rec['ETO_OFR_QTY'];}
	      else
	      {$Quanity = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_POSTDATE_ORIG']))
	      {$Post_date = $rec['ETO_OFR_POSTDATE_ORIG'];}
	      else
	      {$Post_date = 'N/A';}
	      
	      if(isset( $rec['ETO_OFR_APPROV_DATE_ORIG']))
	      {$Approve_date = $rec['ETO_OFR_APPROV_DATE_ORIG'];} 
	      else
	      {$Approve_date = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_QUALITY']))
	      {$Quality = $rec['ETO_OFR_QUALITY'];}
	      else
	      {$Quality = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_REFRESHCOUNT']))
	      {$Ref_count = $rec['ETO_OFR_REFRESHCOUNT'];}
	      else
	      {$Ref_count = '0';}
	      
	      if(isset($rec['ETO_OFR_LOCATION']))
	      {$Location = $rec['ETO_OFR_LOCATION'];}
	      else
	      {$Location = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_S_STATE']))
	      {$State = $rec['ETO_OFR_S_STATE'];}
	      else
	      {$State = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_GL_COUNTRY_NAME']))
	      {$Country = $rec['ETO_OFR_GL_COUNTRY_NAME'];}
	      else
	      {$Country = 'N/A' ;}
	      
	      if(isset($rec['ETO_OFR_GLUSR_USERNAME']))
	      {$Usr_name = $rec['ETO_OFR_GLUSR_USERNAME'];}
	      else
	      {$Usr_name = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_GLCAT_MCAT_NAME']))
	      {$Prime_mcat = $rec['ETO_OFR_GLCAT_MCAT_NAME'];} 
	      else
	      {$Prime_mcat = '';}
	      
	      if(isset($rec['FK_GLUSR_USR_ID']))
	      {$Usr_id = $rec['FK_GLUSR_USR_ID'];}
	      else
	      {$Usr_id = ''; }
	      
	      if(isset($rec['ETO_OFR_POSTEDBYEMPLOYEE']))
	      {$Posted_by = $rec['ETO_OFR_POSTEDBYEMPLOYEE'];} 
	      else
	      {$Posted_by = '';}
	      
	      if(isset($rec['FK_EMPLOYEE_ID']))
	      {$Emp_id = $rec['FK_EMPLOYEE_ID'];}
	      else
	      {$Emp_id = '';}
	      
	      if(isset($rec['NAME_OF_EMPLOYEE']))
	      {$Emp_name = $rec['NAME_OF_EMPLOYEE'];} 
	      else
	      {$Emp_name  = '';}
	      
	      if(isset($rec['MCAT_NAME']))
	      {$Mcat_name = $rec['MCAT_NAME'];}
	      else
	      {$Mcat_name = '';}
	      
	      if(isset($rec['ETO_OFR_LAST_UPDATED']))
	      {$Update_date = $rec['ETO_OFR_LAST_UPDATED'];}
	      else
	      {$Update_date = 'N/A';}
	      
	      if(isset($rec['TOTAL_PURCHASE']))
	      {$Purchased_count = $rec['TOTAL_PURCHASE'];} 
	      else
	      {$Purchased_count = '0';}
	      
	      if(isset( $rec['GLUSR_MOBILE']))
	      {$Mobile = $rec['GLUSR_MOBILE'];} 
	      else
	      {$Mobile = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_COMPANYNAME']))
	      {$Company_Name = $rec['ETO_OFR_COMPANYNAME'];}
	      else
	      {$Company_Name = 'N/A';}
	      
	      if(isset($rec['ETO_OFR_CALL_VERIFIED']))
	      {$Call_verified = $rec['ETO_OFR_CALL_VERIFIED'];}
	      else
	      {$Call_verified = '' ;}
	      
	      if(isset($rec['ETO_OFR_EMAIL_VERIFIED']))
	      {$Email_verified = $rec['ETO_OFR_EMAIL_VERIFIED'];} 
	      else
	      {$Email_verified = '';}
	      if($Call_verified == 2)
	      {	
		  $Call_verified='Call Verified & Updated';
	      }
	      elseif($Call_verified==1)
	      {
		      $Call_verified='Call Verified';
	      }
	      elseif($Call_verified==3)
	      {
		      $Call_verified='Call Updated';
	      }
	      if($Email_verified==2)
	      {	
		      $Email_verified='Email Verified & Updated';
		      if ($Call_verified)
		      {
		      $Email_verified=$Call_verified.' , '.$Email_verified ;}
		      
	      }
	      elseif($Email_verified==1)
	      {
		      $Email_verified='Email Verified';
		      if ($Call_verified)
		      {
		      $Email_verified=$Call_verified.' , '.$Email_verified ;
		      }
	      }
	      elseif($Email_verified==3)
	      {
		      $Email_verified='Email Updated';
		      if ($Call_verified)
		      {
		      $Email_verified=$Call_verified.' , '.$Email_verified;
		      }
	      }
	      if ($Posted_by == 0 ||'')
	      {
		      $Posted_by='User';
	      }
	      else
	      {
		      $Posted_by=$Emp_name;
		      $Usr_id='';
	      }
	      echo '
	      <table style="font-family:arial;font-size:13px;padding-bottom:3px;"><tbody>
	      <tr>
			      <td  valign="top" width="300" style="line-height:18px"><b>Date Posted:</b>&nbsp;'.$Post_date.'<br>
			      <b>Expiry Date:</b>&nbsp;'.$Expire_date.'<br>
			      <b>Last Update:</b>&nbsp;'.$Update_date.'<br>
			      <b>Name:</b>&nbsp;'.$Usr_name.'<br>
			      <b>Refresh Count:</b>&nbsp;'.$Ref_count.'<br>
			      <b>Quality:</b>&nbsp;'.$Quality.'<br>
			      <b>Posted By:</b>&nbsp;'.$Posted_by.'';
			      if ($Usr_id)
			      {
				echo '-<strong>'.$Usr_id.'</strong>';
			      }
			      echo '<br>
			      <b>Approved By:</b>&nbsp;'.$Emp_name.'-<strong>'.$Emp_id.'</strong><br>
			      </td>
			      <td  valign=\"top\" width=\"300\" style=\"line-height:18px\"><b>Company-Name:</b>&nbsp;'.$Company_Name.'<br>
			      <b>Quantity:</b>&nbsp;'.$Quanity.'<br>
			      <b>City:</b>&nbsp;'.$Location.'<br>
			      <b>State:</b>&nbsp;'.$State.'<br>
			      <b>Country:</b>&nbsp;'.$Country.'<br>
			      <b>Mobile No:</b>&nbsp;'.$Mobile.'<br>
			      <b>Lead Purchased Count:&nbsp;<label onclick="javascript:window.open(\'index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439&offer_id='.$sbjVal.'&pur_count=1\',\'_blank\',\'directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=600, height=280,top=200,left=200\')" style=\'color:blue;cursor:pointer\'>'.$Purchased_count.'</b><br></td>' ; 

			      echo  '<td  valign="top" width="300" style="line-height:18px"><b>Lead Title:</b>&nbsp;'.$Title.'<br>
			      <b>Description:&nbsp;'.$Email_verified.'</b><textarea rows="4" cols="50" style="background-color:White;border:1px solid #ccc;padding:2px;resize:none" readonly >'.$Decription.'</textarea><br>
			      <b>Mcat Mapping:</b>&nbsp;<strong>'.$Prime_mcat.'</strong>';
			      if ($Mcat_name)
			      {
				echo ','.$Mcat_name;
			      }
			      echo '<br>
			      </td></tr>
	      </tbody></TABLE>';
	     
    }

if(isset($_REQUEST['relevancyreport']) && ($_REQUEST['relevancyreport'] == 1 || isset($_REQUEST['relevant'])))
{
	echo '<tr style="display:table-row;">';


echo '<td width="900" style=" background:#ffffff;font-size:13px;font-family:arial;">
<form method="POST" action="index.php?r=admin_bl/Eto_rej_ofr/Index&relevancyreport=1&mid=3439" style="margin:5px 0;">
<table width="100%" bordercolor="#ffffff" border="1" bgcolor="#EFFBFB" style="border-collapse:collapse">
<tr><td colspan="4" style="font-size:14px; padding:5px 0px;"><b>Start Date:</b> ';


list($curr_sec,$curr_min,$curr_hour,$curr_day,$curr_month,$curr_year) = localtime(time());
$curr_month=$curr_month+1;

if($curr_month < 10)
{
	$curr_month='0'.$curr_month;
}
$curr_year = $curr_year + 1900;


if(isset($_REQUEST['s_day']))
{
	$curr_day = $_REQUEST['s_day'];
	$curr_month = $_REQUEST['s_month'];
	$curr_year = $_REQUEST['s_year'];
}
 $months = array('01' => "January",
             '02' => "February",
	     '03' => "March",
	     '04' => "April",
	     '05' => "May",
	     '06' => "June",
	     '07' => "July",
	     '08' => "August",
	     '09' => "September",
	     '10' => "October",
	     '11' => "November",
	     '12' => "December");

echo '<select size="1" name="s_day" id="s_day">';
foreach(range(1,31) as $day)
{       
        if($day < 10)
	{ 
	$day = "0$day" ;
	}
	if($day == $curr_day)
	{
		echo '<option value="'.$day.'" selected>'.$day.'</option>';
	}
	else
	{
		echo '<option value="'.$day.'">'.$day.'</option>';
	}
}
echo '</select>';
echo '<select size="1" name="s_month" id="s_month">';
foreach(range(1,12) as $month)
{       
      if($month < 10)
	{
	$month = "0$month" ;
	}
	if($curr_month == $month)
	{
	echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
	}
	else
	{
        echo '<option value="'.$month.'">'.$months[$month].'</option>';
	}
}
echo '</select>';
echo '<select size="1" name="s_year" id="s_year">';
foreach(range(($curr_year-5),($curr_year+5)) as $year)
{
	if($curr_year == $year)
	{
		echo '<option value="'.$year.'" selected>'.$year.'</option>';
	}
	else
	{
		echo '<option value="'.$year.'">'.$year.'</option>';
	}
}
echo '</select>';
if(isset($_REQUEST['e_day']))
{
	$curr_day = $_REQUEST['e_day'];
	$curr_month = $_REQUEST['e_month'];
	$curr_year = $_REQUEST['e_year'];
}
echo '<b style="padding-left:60px;font-size:14px">End Date: </b>';
echo '<select size="1" name="e_day" id="e_day">';

foreach(range(1,31) as $day)
{       if($day < 10)
        {
	$day = "0$day" ;
	}
	if($day == $curr_day)
	{
           echo '<option value="'.$day.'" selected>'.$day.'</option>';
	}
	else
	{
	   echo '<option value="'.$day.'">'.$day.'</option>';
	}
}
echo '</select>';
echo '<select size="1" name="e_month" id="e_month">';
foreach(range(1,12) as $month)
{       if($month < 10)
        {
	$month = "0$month";
	}
	if($curr_month == $month)
	{
		echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
	}
	else
	{
		echo '<option value="'.$month.'">'.$months[$month].'</option>';
	}
}
echo '</select>';
echo '<select size="1" name="e_year" id="e_year">';
foreach(range(($curr_year-5),($curr_year+5)) as $year)
{
	if($curr_year == $year)
	{
		echo '<option value="'.$year.'" selected>'.$year.'</option>';
	}
	else
	{
		echo '<option value="'.$year.'">'.$year.'</option>';
	}
}

echo '</select></td></tr>
<tr>
<td style="font-size:14px" width="150"><strong>Rejection Source: </strong></td>
<td style="font-size:14px" colspan=3><input type="radio" name="r1" id="r1" onclick="enableElements()" value="ALL" checked>&nbsp;&nbsp;All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input type="radio" name="r1" id="r2" onclick="enableElements()" value="MY"';

if(isset($_REQUEST["r1"]) && isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'MY')
{echo 'checked';}

echo '>&nbsp;&nbsp;MY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="r1" id="r3" onclick="enableElements()" value="Email"';
   if(isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'Email')
   {echo 'checked';}
   
echo '>&nbsp;&nbsp;Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="r1" id="r4" onclick="disableElements()" value="Search"';
   if(isset($_REQUEST["r1"]) && isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'Search')
   {
   echo ' checked';
   }
echo '>&nbsp;&nbsp;Search&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="radio" name="r1" id="r5" onclick="enableElements()" value="MIM"';
   if(isset($_REQUEST["r1"]) && isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'MIM')
   {
   echo ' checked';
   }
echo '>&nbsp;&nbsp;M.IM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<input type="radio" name="r1" id="r6" onclick="enableElements()" value="APP"';
   if(isset($_REQUEST["r1"]) && isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'APP')
   {
   echo ' checked';
   }
echo '>&nbsp;&nbsp;APP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


</td>
</tr>


<script>
function disableElements()
{	
	document.getElementById("rej_id").disabled=true;	
}
function enableElements()
{	
	document.getElementById("rej_id").disabled=false;	
}
</script>
<tr>
<td style="font-size:14px;font-family:arial;">
<strong>Select Reason</strong></td>
<td style="font-size:14px;font-family:arial;padding-left:6px;">';

$reason='';
 if(isset($_REQUEST['email_relevancy']))
  {
  $reason=$_REQUEST['reason'];
  }
 $reason= array('Product not relevant','1','Some important specification is missing in BL','10','Insufficient description','3','Location issue','5','Price is high','6','Any other','7','Lead is not related to the searched keyword','8','Removing this old buy lead for cleaning','9','Retail leads','11');
 $cntverify=0;
echo '
<select name="reason" id="reason"><option value="ALL">All</option>';
while ($cntverify < count($reason))
{       if(isset($reason[$cntverify+1]) && isset($reason[$cntverify]))
	{
	if($reason[$cntverify+1] == $reason)
	{
		echo '<option value="'.$reason[$cntverify+1].'" selected>'.$reason[$cntverify].'</option>';
	}
	
	else
	{
		echo '<option value="'.$reason[$cntverify+1].'"> '.$reason[$cntverify].'</option>';
	}
	}
$cntverify += 2;
}
 $comment='';
 if(isset($_REQUEST['email_relevancy']))
 {
 $comment=$_REQUEST['comment'];
 }
 
 $comment1 = array("1" =>"Yes","2" => "No");
 echo '</select>
</td>
<td style="font-size:14px;font-family:arial;padding-left:6px;"><strong>With Comment</strong></td>
<td style="font-size:14px;font-family:arial;padding-left:6px;">
 <select name="comment" id="comment"><option value="ALL">All</option>';
 
while (list($key1, $value1) = each($comment1))
{
	if ($key1==$comment)
	{
		echo '<option value="'.$key1.'" selected>'.$value1.'</option>';
	}
	else
	{
		echo '<option value="'.$key1.'" >'.$value1.'</option>';
	}
}
echo '</select></td></tr>
<tr>
<td style="font-size:14px"><strong></strong></td>
<td style="font-size:14px" colspan="1">&nbsp;&nbsp;</td>
<td style="font-size:14px;padding-left:6px;"><strong>With Disable Mcat: </strong></td>
<td style="font-size:14px" colspan="4"><input type="checkbox" name="rej_id" id="rej_id" value="Mcat_value"';
   if(isset($_REQUEST["rej_id"]) && isset($_REQUEST["rej_id"]) && $_REQUEST["rej_id"] == 'Mcat_value')
   {
   echo 'checked';
   }
echo '>&nbsp;&nbsp;</td>
</tr>
<tr style="display:none;">
<td style="font-size:14px"><strong>Credits Available: </strong></td> 
<td style="font-size:14px"><input type="radio" name="r3" id="r5" value=">=1000" checked>&nbsp;&nbsp;>=1000</td>
<td style="font-size:14px" colspan="3"><input type="radio" name="r3" id="r6" value="<1000"';
if(isset($_REQUEST["r3"]) && $_REQUEST["r3"] == '<1000')
 {
 echo 'checked';
 }
echo '>&nbsp;&nbsp;<1000</td>
</tr>


';
if(isset($_REQUEST['relevancyreport']) && ($_REQUEST['relevancyreport']==1 || isset($_REQUEST['relevant'])))
{
echo '<tr style="display:table-row;">';
}
else
{
echo '<tr style="display:none;">';

}

echo '<td colspan="5" align="center" style="padding:5px 0px 0" bgcolor="#ffffff"><input type="hidden" name="relevant" value="1"/>
&nbsp;&nbsp;&nbsp;<input type="Submit" align="center" value="Submit" id="email_relevancy" class="btn" name="email_relevancy"/>
</td>
</tr>';
echo '
</table>
</form>
</td>
</tr>
</TABLE>
</td>
</tr>';

echo '</table>';
}
else
{
	echo '<tr style="display:none;">';
}
if(isset($_REQUEST['relevant']))
{	
$var = '';
$var1 = '';
	echo '<TABLE WIDTH="100%" BORDER="0" CELLPADDING="3" CELLSPACING="1"  bgcolor="#ECECEC"  style="font-family:arial; font-size:12px; margin:5px auto;">
		<TR bgcolor="#f5f5f5">
		<TD ALIGN="CENTER"><B STYLE="font-size:13px;">Gl Id</B></TD>
		<TD ALIGN="CENTER"><B STYLE="font-size:13px;">Company Name</B></TD>
		<TD ALIGN="CENTER"><B STYLE="font-size:13px;">Customer Type</B></TD>
		<TD ALIGN="CENTER"><B STYLE="font-size:13px;">Lead Purchased</B></TD>
		<TD ALIGN="CENTER"><B STYLE="font-size:13px;">Lead Rejected Till Date</B></TD>
		<TD ALIGN="CENTER"><B STYLE="font-size:13px;">Lead rejected in the Duration</B></TD>
		<TD ALIGN="CENTER"><B STYLE="font-size:13px;">Available Credits</B></TD>
                <TD ALIGN="CENTER"><B STYLE="font-size:13px;">Last Consumption Date</B></TD>
		</TR>';
		$cnt = 0;
		$row = 1;
                if($dbtype=='PG'){
                 while($rec =  pg_fetch_array($sth1)) {
                    $rec=array_change_key_case($rec, CASE_UPPER);  
		
			$cnt++;
			if(isset($rec['LAST_CNSMP']))
			{
			$rec['LAST_CNSMP'] = $rec['LAST_CNSMP'];
			}
			else
			{$rec['LAST_CNSMP'] = '';}
			
			if(isset($rec['GLUSR_USR_COMPANYNAME']))
			{
			$rec['GLUSR_USR_COMPANYNAME']=$rec['GLUSR_USR_COMPANYNAME'];
			}
			else{$rec['GLUSR_USR_COMPANYNAME'] = '';}
			
			if(isset($rec['GLUSR_USR_CUSTTYPE_NAME']))
			{
			$rec['GLUSR_USR_CUSTTYPE_NAME']=$rec['GLUSR_USR_CUSTTYPE_NAME'];
			}
			else
			{$rec['GLUSR_USR_CUSTTYPE_NAME'] = '';}
			if($row==1)
			{ 
			$var = "Gl Id  , Company Name, Customer Type ,Lead Purchased ,Lead Rejected Till Date , Lead rejected in the Duration , Available Credits , Last Consumption Date";
			if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                        }else{
                            fwrite($fp,"$var\n");
                        }

			}
			echo '
			<TR  bgcolor="#ffffff" >
			<TD ALIGN="CENTER"><a href="index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439&fromdays=365&genmis=Generate&report='.$rec['FK_GLUSR_USR_ID'].'&detail=1" target="'.$rec['FK_GLUSR_USR_ID'].':GLusr_detail">'.$rec['FK_GLUSR_USR_ID'].'</a></TD>
			<TD ALIGN="LEFT">'.$rec['GLUSR_USR_COMPANYNAME'].'</TD>
			<TD ALIGN="LEFT">'.$rec['GLUSR_USR_CUSTTYPE_NAME'].'</TD>
			<TD ALIGN="CENTER">'.$rec['LEAD_PUR'].'</td>
			<TD ALIGN="CENTER">'.$rec['LEAD_REJ_TILLDATE'].'</TD>
			<TD ALIGN="CENTER">'.$rec['LEAD_REJ_IN_DUR'].'</TD>
                        <TD ALIGN="CENTER">'.$rec['GLUSR_ETO_CUST_CREDITS_AV'].'</TD>
                        <TD ALIGN="CENTER">'.$rec['LAST_CNSMP'].'</TD>		
			</TR>';
			$GLUSR_USR_COMPANYNAME=$rec['GLUSR_USR_COMPANYNAME'];
			
			$var1 = $rec['FK_GLUSR_USR_ID'].','.str_replace(',', ' ', $GLUSR_USR_COMPANYNAME).','.$rec['GLUSR_USR_CUSTTYPE_NAME'].','.$rec['LEAD_PUR'].','.$rec['LEAD_REJ_TILLDATE'].','. $rec['LEAD_REJ_IN_DUR'].','.$rec['GLUSR_ETO_CUST_CREDITS_AV'].','.$rec['LAST_CNSMP'];

                        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                        }else{
                            fwrite($fp,"$var1\n");
                        }
			
			$row++;
		}
                }else{
                    		while ( $rec =  oci_fetch_assoc($sth1))
		{
			$cnt++;
			if(isset($rec['LAST_CNSMP']))
			{
			$rec['LAST_CNSMP'] = $rec['LAST_CNSMP'];
			}
			else
			{$rec['LAST_CNSMP'] = '';}
			
			if(isset($rec['GLUSR_USR_COMPANYNAME']))
			{
			$rec['GLUSR_USR_COMPANYNAME']=$rec['GLUSR_USR_COMPANYNAME'];
			}
			else{$rec['GLUSR_USR_COMPANYNAME'] = '';}
			
			if(isset($rec['GLUSR_USR_CUSTTYPE_NAME']))
			{
			$rec['GLUSR_USR_CUSTTYPE_NAME']=$rec['GLUSR_USR_CUSTTYPE_NAME'];
			}
			else
			{$rec['GLUSR_USR_CUSTTYPE_NAME'] = '';}
			if($row==1)
			{ 
			$var = "Gl Id  , Company Name, Customer Type ,Lead Purchased ,Lead Rejected Till Date , Lead rejected in the Duration , Available Credits , Last Consumption Date";
			if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                        }else{
                            fwrite($fp,"$var\n");
                        }

			}
			echo '
			<TR  bgcolor="#ffffff" >
			<TD ALIGN="CENTER"><a href="index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439&fromdays=365&genmis=Generate&report='.$rec['FK_GLUSR_USR_ID'].'&detail=1" target="'.$rec['FK_GLUSR_USR_ID'].':GLusr_detail">'.$rec['FK_GLUSR_USR_ID'].'</a></TD>
			<TD ALIGN="LEFT">'.$rec['GLUSR_USR_COMPANYNAME'].'</TD>
			<TD ALIGN="LEFT">'.$rec['GLUSR_USR_CUSTTYPE_NAME'].'</TD>
			<TD ALIGN="CENTER">'.$rec['LEAD_PUR'].'</td>
			<TD ALIGN="CENTER">'.$rec['LEAD_REJ_TILLDATE'].'</TD>
			<TD ALIGN="CENTER">'.$rec['LEAD_REJ_IN_DUR'].'</TD>
                        <TD ALIGN="CENTER">'.$rec['GLUSR_ETO_CUST_CREDITS_AV'].'</TD>
                        <TD ALIGN="CENTER">'.$rec['LAST_CNSMP'].'</TD>		
			</TR>';
			$GLUSR_USR_COMPANYNAME=$rec['GLUSR_USR_COMPANYNAME'];
			
			$var1 = $rec['FK_GLUSR_USR_ID'].','.str_replace(',', ' ', $GLUSR_USR_COMPANYNAME).','.$rec['GLUSR_USR_CUSTTYPE_NAME'].','.$rec['LEAD_PUR'].','.$rec['LEAD_REJ_TILLDATE'].','. $rec['LEAD_REJ_IN_DUR'].','.$rec['GLUSR_ETO_CUST_CREDITS_AV'].','.$rec['LAST_CNSMP'];

                        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                        }else{
                            fwrite($fp,"$var1\n");
                        }
			
			$row++;
		}
                }

		echo '<div style="font-size:15px;font-family:arial" align="CENTER">'.$cnt.' Records Found</div>';
		echo '</TABLE>';
	       echo '</BODY></HTML>';
	if($row > 1)
	{
		echo '</table></div><div align="center"><A HREF="/email-notification/'.$filename.'" style="font-family:arial;font-size:16px;font-weight:bold">CLICK HERE TO DOWNLOAD ALL RECORDS</A></div></body></html>';
	}
	else
	{
		echo '<br><div style="color:#FF0000;font-size:18px;font-family:arial" align="center">Sorry! 0 Records Found</div>';
	}

}
 
 

if ($anyError == "false")
{
	
			
  echo '<br><table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1">
			<TR>
				<td align="LEFT" width="100" bgcolor="#f5f5f5" class="th-heading">Product Preferences - &nbsp;Enable:<label onclick="javascript:window.open(\'index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439&glid='.$sbjVal.'&enableFlag=1\',\'_blank\',\'directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=600, height=280,top=200,left=200\')" style=\'color:blue;cursor:pointer\'> Show </td> '
          . '<td align="LEFT" width="100" bgcolor="#f5f5f5" class="th-heading"> Disable: <label onclick="javascript:window.open(\'index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439&glid='.$sbjVal.'&enableFlag=2\',\'_blank\',\'directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=600, height=280,top=200,left=200\')" style=\'color:blue;cursor:pointer\'>Show</td> 
				
				<td align="LEFT" width="100" bgcolor="#f5f5f5" class="th-heading"></td>				
				<td align="CENTER" width="85" bgcolor="#f5f5f5" class="th-heading">Mobile</td>
			</TR>';
echo '</TABLE>';
#by sarvesh
		echo '<br><table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1">
			<TR  bgcolor="#dddddd">
				<td align="LEFT" width="200"  bgcolor="#f5f5f5" class="th-heading">SUMMARY</td>
				<td align="CENTER" width="13%"  bgcolor="#f5f5f5" class="th-heading">All</td>
				<td width="100" align="CENTER" bgcolor="#f5f5f5" class="th-heading">India</td>
				<td width="100" align="CENTER" bgcolor="#f5f5f5" class="th-heading">Foreign</td>
				<td width="100" align="CENTER" bgcolor="#f5f5f5" class="th-heading">Web</td>
				<td width="100" align="CENTER" bgcolor="#f5f5f5" class="th-heading">Email</td>
				<td width="100" align="CENTER" bgcolor="#f5f5f5" class="th-heading">M.IM</td>
				<td width="100" align="CENTER" bgcolor="#f5f5f5" class="th-heading">Mobile App</td>
			</TR>';		
                     while ( $rec = oci_fetch_assoc($sth_pur))
		{
			$all = $rec['INLEADS'] + $rec['FRLEADS'];
			$other_leads = $rec['WEB'];
			$inleads = $rec['INLEADS'];
			$frleads = $rec['FRLEADS'];
		        $myleads = $rec['MY'] - $rec['WEB'];
			$etoleads = $rec['ETO'];
			$emailleads = $rec['EMAIL'];
			$mobleads = $rec['MOBILE_SITE'];
                        $mobileapp=$rec['MOBILE_APP'];
				if($all == 0)
				{
					$all = '-';
				}
				if($other_leads == 0)
				{
					$other_leads = '-';
				}
				if($inleads == 0)
				{
					$inleads = '-';
				}
				if($frleads == 0)
				{
					$frleads = '-';
				}
				if($myleads == 0)
				{
					$myleads = '-';
				}
				if($etoleads == 0)
				{
					$etoleads = '-';
				}
				if($emailleads == 0)
				{
					$emailleads = '-';
				}
				if($mobleads == 0)
				{
					$mobleads = '-';
				}
				if($mobileapp == 0)
				{
				$mobileapp='-';
				}
				echo '<TR bgcolor="#ffffff">
					<TD ALIGN="LEFT"  class="ttext">Leads Purchased</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$all.'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$inleads.'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$frleads.'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$myleads.'</td>
					<TD ALIGN="CENTER" class="ttext1">'.$emailleads.'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$mobleads.'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$mobileapp.'</TD>
				</TR>';
			}
			
	$total_rejection=0;
			while ($rec =  oci_fetch_assoc($sth_tot_rej))
			{
			  $all = $rec['INLEADS'] + $rec['FRLEADS'];
		          $inleads = $rec['INLEADS'];
			  $frleads = $rec['FRLEADS'];
			 $srcleads = $rec['SEARCH'];
			 $myleads = $rec['MY'] - $rec['SEARCH'];
			 $emailleads = $rec['EMAIL'];
			 $mobleads = $rec['MOBILE_SITE'];
                         $mobileapp=$rec['MOBILE_APP'];
			 $total_rejection = $all;
                         $report=$_REQUEST['report'];
			 echo '<TR bgcolor="#ffffff" >
					<TD ALIGN="LEFT"  class="ttext">Leads Rejected&nbsp;&nbsp;';
                         
			echo '</TD><TD ALIGN="CENTER" class="ttext1">'.$all.'';
                         echo '</TD>';
					if ($inleads == 0)
					{
						echo '<TD ALIGN="CENTER" class="ttext1">-</TD>';
					}
					else
					{
						echo '<TD ALIGN="CENTER" class="ttext1">'.$inleads.'</TD>';
					}
					if ($frleads == 0)
					{
						echo '<TD ALIGN="CENTER" class="ttext1">-</TD>';
					}
					else
					{
						echo '<TD ALIGN="CENTER" class="ttext1">'.$frleads.'</TD>';
					}
					if ($myleads == 0)
					{
						echo '<TD ALIGN="CENTER" class="ttext1">-</TD>';
					}
					else
					{
						echo '<TD ALIGN="CENTER" class="ttext1">'.$myleads.'</TD>';
					}
					
					if ($emailleads == 0)
					{
						echo '<TD ALIGN="CENTER" class="ttext1">-</TD>';
					}
					else
					{
						echo '<TD ALIGN="CENTER" class="ttext1">'.$emailleads.'</TD>';
					}
					if ($mobleads == 0)
					{
						echo '<TD ALIGN="CENTER" class="ttext1">-</TD>';
					}
					else
					{
						echo '<TD ALIGN="CENTER" class="ttext1">'.$mobleads.'</TD>';
					}
					if ($mobileapp == 0)
					{
						echo '<TD ALIGN="CENTER" class="ttext1">-</TD>';
					}
					else
					{
						echo '<TD ALIGN="CENTER" class="ttext1">'.$mobileapp.'</TD>';
					}
			echo '</TR>';
			}
	
	while ( $rec =  oci_fetch_assoc($sth_sum))
			{
				$all = $rec['INLEADS'] + $rec['FRLEADS'];
				$reason = $rec['REASON'];
				$inleads = $rec['INLEADS'];
				$frleads = $rec['FRLEADS'];
				$srcleads = $rec['SEARCH'];
				$myleads = $rec['MY'] - $rec['SEARCH'];
				$emailleads = $rec['EMAIL'];
				$mobleads = $rec['MOBILE_SITE'];
                                $mobileapp=$rec['MOBILE_APP'];
				$srcleads1 = '';
				$myleads1 = '';
				if($total_rejection != 0)
				{
					if($myleads != 0)
					{
					$myleads1 = ($myleads / $total_rejection) * 100;
					$myleads1 = floor( $myleads1 + 0.5 );
					}
					if($srcleads != 0)
					{
					$srcleads1 = ($srcleads / $total_rejection) * 100;
					$srcleads1 = floor( $srcleads1 + 0.5 );
					}	
				}
				if($inleads == 0)
				{
					$inleads = '-';
				}
				if($all == 0)
				{
					$all = '-';
				}
				if($frleads == 0)
				{
					$frleads = '-';
				}
				if($emailleads == 0)
				{
					$emailleads = '-';
				}
				if($mobleads == 0)
				{
					$mobleads = '-';
				}
				if($mobileapp == 0)
				{
					$mobileapp = '-';
				}
				echo '<TR bgcolor="#ffffff" >
					<TD ALIGN="LEFT" class="ttext2">'.$rec['REASON'].'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$all.'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$inleads.'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$frleads.'</TD>';
					if ($myleads == 0)
					{
						echo '<TD ALIGN="CENTER" class="ttext1">-</TD>';
					}
					else
					{
						echo '<TD ALIGN="CENTER" class="ttext1">'.$myleads.'<strong> &#91 '.$myleads1.'% &#93  </strong></TD>';
					}
					
					echo '<TD ALIGN="CENTER" class="ttext1">'.$emailleads.'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$mobleads.'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$mobileapp.'</TD>
				</TR>';
}
echo '</TABLE>';
if(isset($mcatList) && isset($mcatList['mcatList'][0]["MCAT_ID"])){
echo '<br>
<br><table class="table table-bordered table-condensed offerTable" style="font-size: 13px;background-color:#F0F9FF;white-space: nowrap;">
<tr style="background: none repeat scroll 0% 0% rgb(0, 109, 204); color: rgb(255, 255, 255);">
	<th style="text-align:center">MCAT ID</th>
	<th style="text-align:center">MCAT Name</th>
	<th style="text-align:center">MCAT RANK</th>

	<th style="text-align:center">BLNI Total</th>
	<th style="text-align:center">BLNI Prime</th>
	<th style="text-align:center">BLNI Non-Prime</th>
	<th style="text-align:center">Txn Total</th>
	<th style="text-align:center">Txn Prime</th>
	<th style="text-align:center">Txn Non-Prime</th>
	<th style="text-align:center">NO of PRODUCTS</th>
	<th style="text-align:center">Select</th>
	</tr>';
foreach ($mcatList['mcatList'] as $mcat){
	echo '<tr id="'.$mcat["MCAT_ID"].'">
	<td style="text-align:center"><span style="cursor:pointer" onclick="relatedOffers('.$mcat["MCAT_ID"].')">'. $mcat["MCAT_ID"].'</span></td>
			<td style="text-align:center">'. $mcat["MCAT_NAME"].'</td>
			<td style="text-align:center">'. $mcat["MCAT_RANK"].'</td>
			
			<td style="text-align:center">'. $mcat["BLNI_TOTAL"].'</td>
			<td style="text-align:center">'. $mcat["BLNI_PRIME"].'</td>
			<td style="text-align:center">'. $mcat["BLNI_NON_PRIME"].'</td>
			<td style="text-align:center">'. $mcat["TXN_TOTAL"].'</td>
			<td style="text-align:center">'. $mcat["TXN_PRIME"].'</td>
			<td style="text-align:center">'. $mcat["TXN_NON_PRIME"].'</td>
			<td style="text-align:center"><span style="background-color: #2a88da;padding: 3px;border-radius: 3px;"><a style="text-decoration:none;color:black;cursor:pointer" href="/index.php?r=admin_marketplace/Keyword/McatbyGlusr&action=BLNI&mid=3373&gl_id_search='.$sbjVal.'&mcat_id_search='.$mcat["MCAT_ID"].'" target= "_blank"><b>Product List</b></a></span></td>
			<td style="text-align:center"><input type="checkbox" value="'. $mcat["MCAT_ID"].'" id="check_'. $mcat["MCAT_ID"].'" name="name2" /></td>
			</tr>';
}
echo '</table>';
echo '<br><div style= "text-align: center;"><a id="negMcat1" ONCLICK="return updateNegativeMcats(1)" style="background-color: #2a88da;cursor: pointer;padding: 5px;border-radius: 2px;font-family:arial;font-size:14px;font-weight:bold;" align="center">
Update
</a></div>';
}else{
	echo '<div><center style="color: black;margin-top: 30px;font-weight: bold;">No records of MCAT for respective GLID.</center></div>' ;
}
echo '<br><br><div id ="offerDetails"></div>';
echo '<br><div style= "text-align: center;"><a id="negMcat" ONCLICK="return getNegativeMcats()" style="display:none;background-color: #2a88da;cursor: pointer;padding: 5px;border-radius: 2px;font-family:arial;font-size:14px;font-weight:bold;" align="center">
Negative MCAT
</a></div>';
echo '<div id ="negativeMcats"></div>';

}
echo '<div id="details" ></div>';
if ($anyError2 == "false")
	{
	 echo '<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"> <TR>
				<TD ALIGN="CENTER" class="th-heading"><B STYLE="font-size:13px;">Glusr ID</B></TD>
				<TD ALIGN="CENTER" class="th-heading"><B STYLE="font-size:13px;">Rejection Date</B></TD>
				<TD ALIGN="CENTER" class="th-heading"><B STYLE="font-size:13px;">Source</B></TD>
				<TD ALIGN="CENTER" class="th-heading"><B STYLE="font-size:13px;">Mail Sent Date/Search Text</B></TD>
				<TD ALIGN="CENTER" class="th-heading"><B STYLE="font-size:13px;">Rejection Reason</B></TD>
			</TR>';
	while ( $rec =oci_fetch_assoc( $sth ))
			{echo '
			<TR  bgcolor="#ffffff" >
					<TD ALIGN="CENTER" class="ttext1"><a href="index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439&start_date='.$start_date.'&end_date='.$end_date.'&genmis=Generate&report='.$rec['FK_GLUSR_USR_ID'].'&detail=1" target="'.$rec['FK_GLUSR_USR_ID'].':GLusr_ofr_rej_detail">'.$rec['FK_GLUSR_USR_ID'].'</a></TD>
					<TD ALIGN="CENTER" class="ttext1">'.$rec['ETO_OFR_REJECT_DT_DISP'].'</td>';

                                        if(isset($rec['ETO_OFR_MAIL_SENT_DATE']))
					{
					$maildate1=$rec['ETO_OFR_MAIL_SENT_DATE'];
					}
					elseif(isset($rec['ETO_SRCH_TEXT']))
					{
					$maildate1 = $rec['ETO_SRCH_TEXT'];
					}
					
					if (!isset($maildate1))
					$maildate1='' ;
					
					if (isset($rec['FK_ETO_OFR_DISPLAY_ID']))
					{
						echo '<TD ALIGN="CENTER" class="ttext1">'.$rec['FLAG'].'<span style="color:red;font-weight:bold;">#</span></TD>';
					}
					else
					{
						echo '<TD ALIGN="CENTER" class="ttext1">'.$rec['FLAG'].'</TD>';
					}
					echo '<TD ALIGN="CENTER" class="ttext1">'.$maildate1.'</TD>';
					if(isset($rec['ETO_OFR_REJECT_COMMENT']))
					{
					echo '<TD ALIGN="LEFT" style="background-color: #FFF7C9;" class="ttext1 commented"><a class="info">'.$rec['ETO_OFR_REJECT_REASON'].'<div style="background-color: #FFEECA;word-wrap:break-word;"><u>Comment</u>:<br><br>'.$rec['ETO_OFR_REJECT_COMMENT'].'<br></div></a></TD>';
					}
					else
					{
						echo '<TD ALIGN="LEFT" class="ttext1">'.$rec['ETO_OFR_REJECT_REASON'].'</TD>';
					}
					echo '</TR>';
			}
}
echo '</BODY></HTML>';
?>