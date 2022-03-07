<?php 
if($permision > 0)
	{	
		
		if(isset($generate) and $generate == 1)
		{
			//displayTotal($q,$dbh,\@vendorArr);
		}		
		else
		{ 
		$tljson = $showForm['tljson'];
		$start_date = $showForm['start_date'];
		$end_date = $showForm['end_date'];
		$hours = $showForm['hours'];
		$vendor1 = $showForm['vendor1'];
		
		 ?>
		     
			<head>
			
			<title>BL Dashboard</title>
			<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
			
			<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
			     <script language="javascript" src="/js/calendar.js"></script>
			<!--google analytics async code start-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28761981-2']);
  _gaq.push(['_setDomainName', '.intermesh.net']);
  _gaq.push(['_setSiteSpeedSampleRate', 10]);
  _gaq.push(['_trackPageview','<?php echo $_SERVER['REQUEST_URI'];?>']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!--google analytics async code end-->

			<style>
				.trd{position:fixed;top:0px;width:100%;}
				.highlighted{background-color: #FFDEDB;}
				.intd{text-align:center;word-break:break-all;padding:2px 0px 2px 0px;}
			</style>
			<script language="javascript">			
			function empWiseDetail(type,divid,bdate,edate,vendor,source,stime,etime,tlid,sortby,orderdata)
			{
                            document.getElementById(divid).style.display = 'block';
                            document.getElementById(divid).focus();
                            document.getElementById(divid).innerHTML="<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='http://my.imimg.com/gifs/loading2.gif' align='absmiddle'></DIV>";

                            var url;
                            if(type =='D')
                            {
                              action='empwisedetail';
                            }else if(type =='S')
                            {
                              action='supplierdetail_tl';
                            }else if(type =='PMCAT_tl'){
                                 action='PMCAT_tl';                            
                            }else if(type =='isqfillrate_tl'){
                                 action='isqfillrate_tl';
                            }                            
                            else
                            {
                              action='empwiseIsqdetail';
                            }
                            url='/index.php?r=admin_eto/BLDashboard/leapdashboard&start_date='+bdate+'&end_date='+edate+'&vendor='+vendor+'&source='+source+'&start_time='+stime+'&end_time='+etime+'&action='+action+'&tlid='+tlid+'&emp_flag=0&sortby='+sortby+'&orderdata='+orderdata+'&in_flag=1&mid=3443';
                             a={};
                             result='';               
                             $.ajax({
                                url: url,
                                type: 'post',
                                data:a, 
                                success:function(result){    
                                   document.getElementById(divid).style.display = 'block';
								document.getElementById(divid).innerHTML = result;  
                                                                
								$(document).scroll(function() {
								var ht=$('#div1').height()+$('#showform1').height()+20;
								var src1=$(window).scrollTop();
								if(src1>ht)
								{
								$('#trid').addClass('trd');
								}
								else
								{
								$('#trid').removeClass('trd');
								}
								});
								var stclass1 = $('#startdt').val();
								var stclass2 = $('#vendr').val();
								var stclass = stclass1;
								var ttlselect = ':input.'+stclass+'[name="ttlapproved"]';
								var empselect =  ':input.'+stclass+'[name="empapproved"]';
								var ttlval = $(ttlselect).val();
								var ttlApprovalPRVal = $(':input.'+stclass+'[name="ttlApprovalPR"]').val();
								var ttlCallPRVal = $(':input.'+stclass+'[name="ttlCallPR"]').val();
								$(empselect).each(function(){
									if(parseFloat($(this).val()) < 40)
									{
										$(this).parent().addClass('highlighted');
									}
									});//end each
								$(':input.'+stclass+'[name="empAHT"]').each(function(){
									if(parseFloat($(this).val()) < 5)
									{
										$(this).parent().addClass('highlighted');
									}
									});//end each
								$(':input.'+stclass+'[name="empApprovalPR"]').each(function(){
									if(parseFloat($(this).val()) < parseFloat(ttlApprovalPRVal))
									{
										$(this).parent().addClass('highlighted');
									}
									});//end each
								$(':input.'+stclass+'[name="empCallPR"]').each(function(){
									if(parseFloat($(this).val()) < parseFloat(ttlCallPRVal))
									{
										$(this).parent().addClass('highlighted');
									}
									});//end each                   
                                }
                            }); 
			}
			
			var data = <?php echo $tljson; ?>;
			$(document).ready(
							function()
							{
								displayTLSection();
								$('input[name=vendor1]').click(function()
								{
									if($(this).val() == 'ALL')
									{
										$('input[name=vendor1]').each(function()
										{
											if($(this).val() != 'ALL')
											{
												$(this).prop('checked', false);
											}
										})
									}
									else
									{
										$("#ALL").prop('checked', false);
									}
									displayTLSection();
								});
							}
						);
			function displayTLSection()
			{
				var checkedLength = $('input[name=vendor1]:checked').length;
				$("#tldiv").hide();
				$("#tlselect").empty();
				if(checkedLength == 1)
				{       <?php $vendercheck='';
				              foreach($allVenders as $value)
				              $vendercheck.="checkedVendor =='".$value."' || ";
				              $vendercheck=substr($vendercheck,0,($vendercheck)-3);
				        ?>
					var checkedVendor = $('input[name=vendor1]:checked').val();
                                        if(<?php echo $vendercheck;?>)
					{
						$("#tldiv").show();
						$('<option/>',{value:"",text:"ALL"}).appendTo("#tlselect");
						$.each(data[checkedVendor], function(key,value){
							$('<option/>',{value:key,text:value}).appendTo("#tlselect");
						});
					}
				}
			}
			$(document).ready(
								function()
								{
									$('#submit1').click(function(){
                                                                            var vendorVal = '';
                                                                            var rtype = $('input[name="rtype"]:checked').val();
                                                                            var d = new Date();
                                                                            var n = d.getHours();
                                                                            if((rtype=='CONTACT' || rtype== 'PRODUCT') && (n<9 || n>10)){
                                                                                alert('Sorry! This report will work between 9 am - 10 am only.');
                                                                                return false;                            
                                                                            }
										vendorVal = $('input[name="vendor1"]:checked').map(function() {
    										return this.value;
										}).get().join();
										$("#vendorVal").val(vendorVal);
										$('#submit1').css( "display", "none" );
										
										if(rtype =='TOP')
										{
										  
										  	$.ajax({
											type : 'POST',
											url : '/index.php?r=admin_eto/BLDashboard/leapdashboard&mid=3443',
											data : $('#searchForm').serialize(),
											beforeSend: function(){$("#topperformerdiv").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='http://my.imimg.com/gifs/loading2.gif' align='absmiddle'></DIV>");},
											success:function(result){
												 $("#topperformerdiv").html(result);
												  $("#totatresultdiv").html('');
												 $("#vendorVal").val(''); 
												
												$('#submit1').css( "display", "block" );
											}
										});
										   
										}
										else
										{
										
										$.ajax({
											type : 'POST',
											url : '/index.php?r=admin_eto/BLDashboard/leapdashboard&mid=3443',
											data : $('#searchForm').serialize(),
											beforeSend: function(){$("#totatresultdiv").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='http://my.imimg.com/gifs/loading2.gif' align='absmiddle'></DIV>");},
											success:function(result){
												 $("#totatresultdiv").html(result);
												 $("#vendorVal").val(''); 
												
												$('#submit1').css( "display", "block" );
											}
										});
									    }	
									   
									return false;
									});
								
									$('#flaggeddatalrefresh').click(function(){
										$.ajax({
											type : 'POST',
											url : '/index.php?r=admin_eto/BLDashboard/leapdashboard&mid=3443',
											data : {action: "tlwiseflaggeddata"},
											beforeSend: function(){$("#flaggeddatadiv").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='http://my.imimg.com/gifs/loading2.gif' align='absmiddle'></DIV>");},
											success:function(result){												
												 $("#flaggeddatadiv").html(result); 
											}
										});
									return false;
									});
								}
							);

			//-->
			</SCRIPT></HEAD>
		    <div style="margin:0px auto;">			    
		    <div id="showform1" style="width:80%; margin:0px auto; float:left;">
		    <form name="searchForm" id="searchForm" method="post" action="/index.php?r=admin_eto/BLDashboard/leapdashboard&mid=3443" style="margin-top:0;margin-bottom:0;">
		    <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
			  <TR>
			  <td bgcolor="#dff8ff" colspan="2" align="center"><font COLOR =" #333399"><b>BL Approval Dashboard</b></font>			 
			  </td>	
			  </TR>
			  <tr>

			  <td WIDTH="20%">&nbsp;Enter Date:</td>
			  <td>
			  From
			  <input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To
			  <input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
			  </td>
			  </tr>			  
			  <TR>
			  <td WIDTH="20%">&nbsp;Vendor:</td>
			  <TD>
			  <?php 
                          $cogent='';$vaklp='';$kocharTech='';$call_api_link='';$vendorArr1=array();$vendor_name='';
                          if(count($vendor1)==1){
                              $vendor_name=$vendor1[0];
                               if(preg_match("/COGENT/i",$vendor_name)) {
                                $vendorArr1 = array('COGENT','COGENTBRB','COGENTDNC','COGENTINBOUND','COGENTINTENT','COGENTPNS' );
                                }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                                    $vendorArr1 = array('KOCHARTECH','KOCHARTECHCHN','KOCHARTECHDNC','KOCHARTECHLDH');
                                }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                                    $vendorArr1 = array('RADIATE','RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT');    
                                }else{
                                    $vendorArr1 = array($vendor_name);
                                }
                            }else{
                                    $vendorArr1 = $vendorArr;
                                    $vendor_name='ALL';
                            }
                           
                          foreach($vendorArr1 as $venR)
			  {
				  if($venR == $vendor_name)
                                    {
                                      echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" value="'.$venR.'" checked="checked" name="vendor1" id="'.$venR.'">&nbsp;'.$venR.'</input>';
                                    }
                                    else
                                    {
                                      echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" value="'.$venR.'"  name="vendor1" id="'.$venR.'">&nbsp;'.$venR.'</input>';
                                    }		 
				  
				 
                                  if (preg_match("/cogent/i", $venR)) {
                                        $cdate= date("Y-m-d");
                                        $cogent='http://182.75.225.82:8080/AgentCDR/agentCdrlistAgentCDr.action?agentendDateTime='.$cdate.'&phoneNumber=&campaigns=PRIORITY,cogent_leap,MUST_CALL,MUST_CALL1&userPass=INDIAMART&agentstartDateTime='.$cdate.'&&Submit=Submit&userName=INDIAMART';
                                    }elseif (preg_match("/vkalp/i", $venR)) {
                                        $vaklp='http://14.141.67.90/agcreport/reportcalldata.php';
                                    }elseif (preg_match("/kocharTech/i", $venR)) {
                                        $kocharTech='http://202.164.36.66/indiamartcalllogs/';    
                                    }
			  } 
                          if($cogent){
                             $call_api_link =  '<a href="'.$cogent.'" target="_blank">Call Attempt - Cogent</a><br>';
                          }
                         if($vaklp){
                             $call_api_link .=  '<a href="'.$vaklp.'" target="_blank">Call Attempt - Vkalp</a><br>';
                          }
                          if($kocharTech){
                             $call_api_link .=  '<a href="'.$kocharTech.'" target="_blank">Call Attempt - KocharTech</a><br>';
                          }
                          
                          ?>
				<input type="hidden" value="" name="vendorVal" id="vendorVal">			  
			  </td></TR>

			  <TR><TD WIDTH="20%" >&nbsp;Country:</TD>
				  <TD><input type="radio" name="source" value="A" checked>All &nbsp;&nbsp;
				  <input type="radio" name="source" value="I">Indian &nbsp;&nbsp;
				  <input type="radio" name="source" value="F">Foreign</TD>
				  </TR>
                                  <TR><TD WIDTH="20%" >&nbsp;Report Type:</TD>
				  <TD><input type="radio" name="rtype"  value="D" checked>Default &nbsp;&nbsp;                                  
				  <input type="radio" name="rtype"  value="TL">TL-Wise &nbsp;&nbsp;
                                   <input type="radio" name="rtype"  value="AON" >AON-Wise &nbsp;&nbsp;                                                      
                                   <input type="radio" name="rtype"  value="ISQ">ISQ &nbsp;&nbsp; 
                                   <input type="radio" name="rtype"  value="ISQFILLRATE">ISQ Fill Rate &nbsp;&nbsp; 
                                   <input type="radio" name="rtype"  value="TOP" >Top Performer &nbsp;&nbsp;
                                   <input type="radio" name="rtype"  value="CONTACT" >Contact Detail Enrichment &nbsp;&nbsp;
                                   <input type="radio" name="rtype"  value="PRODUCT" >Products We Buy &nbsp;&nbsp;
                                   <input type="radio" name="rtype"  value="FEEDBACK" >Fulfillment Feedback<br>
                                   <input type="radio" name="rtype"  value="ISQFEEDBACK" >ISQ Feedback&nbsp;&nbsp;
                                   <input type="radio" name="rtype"  value="SUPPLIER" >Search Keyword &nbsp;&nbsp;
                                   <input type="radio" name="rtype"  value="PMCAT" >PMCAT &nbsp;&nbsp;
                                   <input type="radio" name="rtype"  value="ENRICH">Buyer Profile Enrichment &nbsp;&nbsp;
				  </TD>
				  </TR>
				  <TR>
				  <TD WIDTH="20%">&nbsp;Time:</TD>
				  <TD>
				  <div style="float:left;margin:0 100 0 0">
				  <SELECT NAME="start_time">
				  <?php 
                                  $start_time='';
                                  foreach($hours as $k => $row) {
					  if($start_time == $k)
					  {
						  echo "<OPTION VALUE=\"$k\" SELECTED=\"SELECTED\" >$row</OPTION>";
					  }
					  else
					  {
						  echo "<OPTION VALUE=\"$k\">$row</OPTION>";
					  }
				  } ?>
				  </select>
				  &nbsp;&nbsp;to&nbsp;&nbsp;&nbsp;
				  <SELECT NAME="end_time">
				  <?php $end_time = empty($end_time)?24:$end_time;
				  foreach($hours as $k1 => $row1) {
				  	
					  if($end_time == $k1)
					  {
						  echo "<OPTION VALUE=\"$k1\" SELECTED=\"SELECTED\" >$row1</OPTION>";
					  }
					  else
					  {
						  echo "<OPTION VALUE=\"$k1\"  >$row1</OPTION>";
					  }
				  } ?>
				  </select>
				  </div>
				  <div style="margin:0 0 0 110;display:none" id="tldiv">TL:&nbsp;&nbsp;
				  <select id="tlselect" name="tlselect"></select>
				  </div>
				  

				  </TD>
				  </TR>
				  <TD colspan="2" align="center">
				  <input type="hidden" name="in_flag" value="0">
				  <input type="hidden" name="action" value="generate">
				  <input type="submit" name="submit1" id="submit1" value="Generate">
				  <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"> </div>
				  </TD>
				  </TR>
				  </TABLE></FORM>
			    </div>

			    <div style="width:200px; margin:10px 0 0 10px ; float:left;font-size: 12px;font-family: arial;">
                                <?php  if($permision != 3)
                                { ?>
                                  <a href="/index.php?r=admin_eto/Addvendor/vendorleapmis&mid=3443">Add Leap Associate</a><br>
				  <a href="/index.php?r=admin_eto/Addvendor/Changeagent&action=showch&mid=3443">Change Associate</a><br>                                  
			 <?php }  
                         if($call_api_link != '')
			    {
                                echo '<br>'.$call_api_link;                                
                            } ?>
			
                            </div>
		    <div style="clear:both;"></div><br>
		    <div id="topperformerdiv" style="width:100%; margin:0px auto;"></div><br>
		    <div id="totatresultdiv" style="width:100%; margin:0px auto;"></div><br>
			<?php	}
		}	 	
	 ?>
	