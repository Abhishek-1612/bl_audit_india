<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<?php
class Eto_pbl_gen extends CFormModel
{

public function buyLeadGenerationForm($dbh,$mesg,$modidDrpDwn,$formtypeDrpDwn,$rprtfrnq,$rprtType,$indsitesUrl,$country,$countryExclude,$srchType,$rest_report,$param,$start_date,$end_date)
{
	 $defaultForm=0;
	if(!$rprtfrnq)
	{
		$defaultForm=1;
		$rprtfrnq=1;
	}
        
	echo '<HTML><HEAD><TITLE>Buy Lead Generation Report</TITLE>';
        ?>
        <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
        <script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script>
$(document).ready(
    function()
            {  
                $('#search').click(function(){
                        a={};
                        a['start_date']=$('#start_date').val();
                        a['search']=$('#search').val();
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_bl/Eto_pbl_generation/Index&mid=3435",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='http://my.imimg.com/gifs/loading2.gif' align='absmiddle'></DIV>");},
                success:function(result){                         
                               $('#result').html(result);                   
                            }
                        }); 
            }
);
}
)
</script>
	<?php echo '</HEAD><BODY>
	<SCRIPT LANGUAGE="JavaScript">
        
        function dayEnableDisable(rprtfrnq)
	{
		if(rprtfrnq == 3)
		{
			document.searchForm.end_date.style.backgroundColor="#EAEAEA";
			document.searchForm.end_date.style.color="#b5b2ad";
			document.searchForm.start_date.style.backgroundColor="#EAEAEA";
			document.searchForm.start_date.style.color="#b5b2ad";
		}
		else
		{
			document.searchForm.end_date.style.backgroundColor="";
			document.searchForm.end_date.style.color="";
			document.searchForm.start_date.style.backgroundColor="";
			document.searchForm.start_date.style.color="";
		}
	}
	function checkBuyForm()
	{
            var start=new Date(document.searchForm.start_date.value);
            var end=new Date(document.searchForm.end_date.value);
            var timeDiff = end.getTime() - start.getTime();
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
            if(diffDays>7)
            { 
            alert("Kindly Select Dates In Span Of 7 Days Only");
                       return false;
            }
             else if(diffDays<0)
                    {
                        alert("End Date Cant Be Smaller Than Start Date");
                        return false;
                    }
	}
	
	function setHiddenParams(postdate,modid,type,quality,infrn,unsold,sold,catid,grpid,afl_id)
	{
		document.searchForm.postdate.value="";
		document.searchForm.modid.value="";
		document.searchForm.type.value="";
		document.searchForm.quality.value="";
		document.searchForm.infrn.value="";
		document.searchForm.catid.value="";
		document.searchForm.grpid.value="";
		document.searchForm.afl_id.value="";
		
                document.searchForm.sold.value=sold;
                document.searchForm.unsold.value=unsold;
                document.searchForm.action.value="detail";
                document.searchForm.target="_blank";

                if(postdate && postdate != "")
                {
                        document.searchForm.postdate.value=postdate;
                }

                if(catid || grpid)
                {
                        if(catid)
                        {
                                document.searchForm.catid.value=catid;
                        }
                        else
                        {
                                document.searchForm.grpid.value=grpid;
                        }
                }
                else
                {
                        if(modid && modid != "")
                        {
                                document.searchForm.modid.value=modid;
                        }
                }

                if(type && type != "")
                {
                        document.searchForm.type.value=type;
                }

                if(quality && quality != "")
                {
                        document.searchForm.quality.value=quality;
                }

                if(infrn && infrn != "")
                {
                        document.searchForm.infrn.value=infrn;
                }
                if(afl_id && afl_id != "")
                {
                        document.searchForm.afl_id.value=afl_id;
                }


                document.searchForm.submit();

}
	function showhide_domain(Form)
	{
		var selectedmodid = Form.modiddrpdwn.options[Form.modiddrpdwn.selectedIndex].value;
		if(selectedmodid && selectedmodid == "PDTPTL")
		{
			document.getElementById("showdomain").style.display="block";
		}
		else
		{
			document.getElementById("showdomain").style.display="none";
		}
		
		if(selectedmodid && (selectedmodid == "DIR" || selectedmodid == "ETO"))
		{
			document.getElementById("searchOption").style.display="block";
		}
		else
		{
			document.getElementById("searchOption").style.display="none";
		}

		if(selectedmodid == -1)
		{
			for (counter = 0; counter < document.searchForm.grpcatsrch.length; counter++)
			{
				document.searchForm.grpcatsrch[counter].disabled=false;
			}
			document.searchForm.grpcatsrch[2].checked=true;
		}
		else
		{
			for (counter = 0; counter < document.searchForm.grpcatsrch.length; counter++)
			{
				document.searchForm.grpcatsrch[counter].checked=false;
				document.searchForm.grpcatsrch[counter].disabled=true;
			}
			document.searchForm.group.disabled=true;
		}
	}
	
	function check_count_change()
	{
		document.searchForm.countryexclude.checked=false;
		var val = document.searchForm.country.options[document.searchForm.country.selectedIndex].value;
		if(val == 0)
		{
			document.searchForm.countryexclude.disabled=true;
			document.searchForm.seca.disabled=false;
			document.searchForm.secb.disabled=false;
			document.searchForm.secc.disabled=false;
			document.searchForm.secd.disabled=false;
			document.searchForm.secin.disabled=false;
			document.searchForm.secfrn.disabled=false;
			document.searchForm.checkallsec.disabled=false;
		}
		else
		{
			document.searchForm.countryexclude.disabled=false;
			document.searchForm.seca.checked=false;
			document.searchForm.seca.disabled=true;
			document.searchForm.secb.checked=false;
			document.searchForm.secb.disabled=true;
			document.searchForm.secc.checked=false;
			document.searchForm.secc.disabled=true;
			document.searchForm.secd.checked=false;
			document.searchForm.secd.disabled=true;
			document.searchForm.secin.checked=false;
			document.searchForm.secin.disabled=true;
			document.searchForm.secfrn.checked=false;
			document.searchForm.secfrn.disabled=true;
			document.searchForm.checkallsec.checked=false;
			document.searchForm.checkallsec.disabled=true;
		}
	}
	
	function checkuncheck()
	{
		if(document.searchForm.checkallsec.checked)
		{
			document.searchForm.seca.checked=true;
			document.searchForm.seca.checked=true;
			document.searchForm.secb.checked=true;
			document.searchForm.secc.checked=true;
			document.searchForm.secd.checked=true;
			document.searchForm.secin.checked=true;
			document.searchForm.secfrn.checked=true;
		}
		else
		{
			document.searchForm.seca.checked=false;
			document.searchForm.seca.checked=false;
			document.searchForm.secb.checked=false;
			document.searchForm.secc.checked=false;
			document.searchForm.secd.checked=false;
			document.searchForm.secin.checked=false;
			document.searchForm.secfrn.checked=false;
		}
	}
	
	function unchecksecall(checkboxObj)
	{
		if(!checkboxObj.checked)
		{
			document.searchForm.checkallsec.checked=false;
		}
	}
	
	
	</SCRIPT>';
        
	if($mesg)
	{
		echo $mesg;
	}

         $dayStyle ='';
	if($rprtfrnq == 3)
	{
		$dayStyle='STYLE="background-color:#EAEAEA;color:#b5b2ad;"';
	}
	
      //$start_date=isset($request['start_date'])?$request['start_date']:'';
     // $end_date=isset($request['end_date'])?$request['end_date']:'';
      
       
print <<<p
	<FORM name="searchForm" METHOD="post" ACTION="index.php?r=admin_bl/Eto_pbl_generation/Index&mid=3435" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();">
    <TABLE WIDTH="100%" BORDER="1" CELLPADDING="0" CELLSPACING="0" border-color="#EAEAEA">
      <TR>
        <TD BGCOLOR="#F4F4F4" HEIGHT="30" COLSPAN="4" ALIGN="CENTER" 
        STYLE="font-family:arial;font-size:14px;font-weight:bold;">Buy Lead Generation Report</TD>
      </TR>
      <TR>
        <TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" WIDTH="10%">
	&nbsp;Start Date</TD>

        <TD BGCOLOR="#EAEAEA" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="40%">

        <TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
          <TR>  <td> &nbsp;<input name="start_date" type="text" VALUE="$start_date" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
          </TR>
        </TABLE>
	</TD>
        <TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="10%">
	&nbsp;Frequency </TD>
        <TD BGCOLOR="#EAEAEA" WIDTH="40%">
        <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
          <TR>
            <TD>
p;
	    if($rprtfrnq == 1)
	    {
	    	    echo '<INPUT TYPE="RADIO" NAME="rprtfrnq" VALUE="1" checked ONCLICK="dayEnableDisable(1);">';
	    }
	    else
	    {
	    	echo '<INPUT TYPE="RADIO" NAME="rprtfrnq" VALUE="1" ONCLICK="dayEnableDisable(1);">';
	    }
	    echo '
            Daily&nbsp;&nbsp;</TD>
            <TD>';
	    if($rprtfrnq == 2)
	    {
	    	    echo '<INPUT TYPE="RADIO" NAME="rprtfrnq" VALUE="2" checked ONCLICK="dayEnableDisable(2);">';
	    }
	    else
	    {
	    	echo '<INPUT TYPE="RADIO" NAME="rprtfrnq" VALUE="2" ONCLICK="dayEnableDisable(2);">';
	    }
	    echo '
            Weekly&nbsp;&nbsp;</TD>
	    <TD>';
	    if($rprtfrnq == 3)
	    {
	    	    echo '<INPUT TYPE="RADIO" NAME="rprtfrnq" VALUE="3" checked ONCLICK="dayEnableDisable(3);">';
	    }
	    else
	    {
	    	echo '<INPUT TYPE="RADIO" NAME="rprtfrnq" VALUE="3" ONCLICK="dayEnableDisable(3);">';
	    }
	    echo '
            Monthly&nbsp;&nbsp;</TD>
          </TR>
        </TABLE>
	</TD>
      </TR>
      <TR>
        <TD BGCOLOR="#DEF2FE" 
        STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30">&nbsp;End
        Date</TD>
        <TD BGCOLOR="#EAEAEA" STYLE="font-family:arial;font-size:12px;font-weight:bold;">

        <TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
          <TR>';
print <<<p
           <td> &nbsp;<input name="end_date" type="text" VALUE="$end_date" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','from_date1')" id="end_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
          </TR>
        </TABLE>
	</TD>
        <TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:12px;font-weight:bold;">
	&nbsp;Report Type</TD>
        <TD BGCOLOR="#EAEAEA">
        <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
          <TR>
            <TD>
p;
	    if($rprtType == 1)
	    {
	    	echo '<INPUT TYPE="RADIO" NAME="rprttype" VALUE="1" checked>';
	    }
	    else
	    {
	    	echo '<INPUT TYPE="RADIO" NAME="rprttype" VALUE="1">';
	    }


            echo 'Detailed&nbsp;&nbsp;
            <TD>';
	    if($rprtType == 2)
	    {
	    	echo '<INPUT TYPE="RADIO" NAME="rprttype" VALUE="2" checked>';
	    }
	    else
	    {
	    	echo '<INPUT TYPE="RADIO" NAME="rprttype" VALUE="2">';
	    }
	    
            echo 'Summary
          </TR>
        </TABLE>
	</TD>
      </TR>';

    
       $grpcatDisable='';
       $sql= " SELECT GL_MODULE_ID, GL_MODULE_NAME FROM GL_MODULE ORDER BY GL_MODULE_ID";
       
          $sth=oci_parse($dbh, $sql);
           oci_execute($sth);
        $modidDropDown='';
      if($modidDrpDwn === 0)
      {
	$modidDropDown='<OPTION VALUE="0" SELECTED>--- All ModID ---</OPTION>';
	$grpcatDisable='disabled';
      }
      else
      {
	$modidDropDown='<OPTION VALUE="0">--- All ModID ---</OPTION>';
      }
      while ($rec = oci_fetch_array($sth)) {
		if($modidDrpDwn && $modidDrpDwn == $rec['GL_MODULE_ID'])
		{
		$modidDropDown .= '<OPTION VALUE="'.$rec['GL_MODULE_ID'].'" SELECTED>'. $rec['GL_MODULE_ID'].' ('.$rec['GL_MODULE_NAME'].') </OPTION>';
		$grpcatDisable='disabled';
		}
		else
		{
		$modidDropDown .= '<OPTION VALUE="'.$rec['GL_MODULE_ID'].'">'. $rec['GL_MODULE_ID'].' ('.$rec['GL_MODULE_NAME'].') </OPTION>';
		}
	}
	


 $formtypeDropDown='';
 $sql2 = "SELECT IIL_MASTER_DATA_VALUE, IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID = 12 AND IIL_MASTER_DATA_IS_ACTIVE = -1";
$sth2=oci_parse($dbh, $sql2);
oci_execute($sth2);
 
if($formtypeDrpDwn == 0)
{
$formtypeDropDown='<OPTION VALUE="0" SELECTED>--- All Form Type ---</OPTION>';
}
else
{
$formtypeDropDown='<OPTION VALUE="0">--- All Form Type  ---</OPTION>';
}
while ($rec2 = oci_fetch_array($sth2)) {
	if($formtypeDrpDwn && $formtypeDrpDwn == $rec2['IIL_MASTER_DATA_VALUE'])
	{
	$formtypeDropDown .= '<OPTION VALUE="'.$rec2['IIL_MASTER_DATA_VALUE'].'" SELECTED>'. $rec2['IIL_MASTER_DATA_VALUE_TEXT'].' </OPTION>';
	}
	else
	{
	$formtypeDropDown .='<OPTION VALUE="'.$rec2['IIL_MASTER_DATA_VALUE'].'">'. $rec2['IIL_MASTER_DATA_VALUE_TEXT'].' </OPTION>';
	}
}
	  $glEtoModel = new AdminEtoModelForm();
          $dbh_meshr = $glEtoModel->connectMeshrDb();
	 $sqlIndsite = "SELECT IND_SITES_ID, IND_SITES_NAME, FNS_EXTRACT_DOMAIN(IND_SITES_URL) SITE_DOMAIN FROM IND_SITES WHERE FK_IND_SITES_TYPE_ID in (82,84) ORDER BY IND_SITES_NAME";
	
	$sthIndsite=oci_parse($dbh_meshr, $sqlIndsite);
        oci_execute($sthIndsite);
	$selectIndsite = '';
	if($sthIndsite!=0) {
		$selectIndsite = '<SELECT NAME="indsites_url">';
		if(!$indsitesUrl)
		{
			$selectIndsite .= '<OPTION VALUE="" SELECTED>--- Select Domain ---</OPTION>';
		}
		else
		{
			$selectIndsite .='<OPTION VALUE="">--- Select Domain ---</OPTION>';
		}
		
		if($indsitesUrl && $indsitesUrl == 'All')
		{
			$selectIndsite .='<OPTION VALUE="All" SELECTED>--- All Domain ---</OPTION>';
		}
		else
		{
			$selectIndsite .= '<OPTION VALUE="All">--- All Domain ---</OPTION>';
		}
		
		while ( $h =oci_fetch_array($sthIndsite)) {
			 $value = $h['SITE_DOMAIN'];
			  $name = $h['IND_SITES_NAME'];
			
			if($indsitesUrl && $indsitesUrl == $value)
			{
				$selectIndsite .='<OPTION VALUE="'.$value.'" SELECTED>'.$name.'</OPTION>';
			}
			else
			{
				$selectIndsite .= '<OPTION VALUE="'.$value.'">'.$name.'</OPTION>';
			}
			
		}
		$selectIndsite .= '</SELECT>';
	}
        $style='display:none;';
	$srch_style='display:none;';
	if($modidDrpDwn == 'PDTPTL')
	{
		$style='display:block;';
	}
	if($modidDrpDwn == 'DIR' || $modidDrpDwn == 'ETO')
	{
		$srch_style='display:block;';
	}
	
	print '
	<TR>
        <TD STYLE="font-family: arial; font-size: 12px; font-weight: bold;" 
        BGCOLOR="#def2fe" VALIGN="MIDDLE" WIDTH="10%">&nbsp;Select
        Country</TD>
        ';
        $countrySelect = $this->GetCountry($dbh,$country);
        
        
        $secDisabled='';
	$cntexcludeDisabled='disabled';
	if($country)
	{
		$secDisabled='disabled';
		$cntexcludeDisabled='';
	}
	echo '
	<TD STYLE="font-family: arial; font-size: 12px;" BGCOLOR="#eaeaea">&nbsp;'.$countrySelect.' &nbsp;&nbsp;&nbsp;';
	if($countryExclude)
	{
	echo '<INPUT TYPE="checkbox" NAME="countryexclude" VALUE="1" checked'. $cntexcludeDisabled.'>&nbsp;Except';
	}
	else
	{
	echo '<INPUT TYPE="checkbox" NAME="countryexclude" VALUE="1"'. $cntexcludeDisabled.'>&nbsp;Except';
	}
	echo '
	</TD>
	
        <TD STYLE="font-family: arial; font-size: 12px; font-weight: bold;" 
        BGCOLOR="#def2fe" VALIGN="MIDDLE" WIDTH="10%" >&nbsp;Select
        ModID</TD>
        
	<TD STYLE="font-family: arial; font-size: 12px;" BGCOLOR="#eaeaea">
        <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
          <TR>
            <TD STYLE="width:42%">&nbsp;<SELECT NAME="modiddrpdwn" onChange="showhide_domain(this.form);" style="width:250px"><OPTION VALUE="-1" >--- Select ModID ---</OPTION>'.$modidDropDown.'</SELECT></TD>

		<TD STYLE="width:42%">&nbsp;<SELECT NAME="formtypedrpdwn">'.$formtypeDropDown.'</SELECT></TD>


          </TR>
        </TABLE>
        <DIV ID="showdomain" STYLE="'.$style.'">
        <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
          <TR>
            <TD STYLE="width:84%">&nbsp;'.$selectIndsite.'</TD>
          </TR>
        </TABLE>
	</DIV>

<DIV ID="searchOption" STYLE="'.$srch_style.'">
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
	<TR>
	<TD STYLE="width:84%">&nbsp;';


	if($srchType == 1)
	{
	echo '<input type="radio" name="srchoption" value="1" checked >Only Search';
	}
	else
	{
	echo '<input type="radio" name="srchoption" value="1">Only Search';
	}
	
	if($srchType == 2)
	{
	echo '<input type="radio" name="srchoption" value="2" checked >Without Search';
	}
	else
	{
	echo '<input type="radio" name="srchoption" value="2">Without Search';
	}

	if($srchType == 3)
	{
	echo '<input type="radio" name="srchoption" value="3" checked >Both';
	}
	else
	{
	echo '<input type="radio" name="srchoption" value="3">Both';
	}
echo '
	</TR>
</TABLE>
</DIV>

	</TD>
      </TR>
      <TR>
        <TD STYLE="font-family: arial; font-size: 12px; font-weight: bold;" 
        BGCOLOR="#def2fe" HEIGHT="10" WIDTH="10%" VALIGN="TOP" ALIGN="CENTER">OR</TD>
        <TD STYLE="font-family: arial; font-size: 12px; font-weight: bold;" 
        BGCOLOR="#eaeaea" HEIGHT="10"></TD>
        <TD STYLE="font-family: arial; font-size: 12px; font-weight: bold;" 
        BGCOLOR="#def2fe" WIDTH="10%" VALIGN="TOP" HEIGHT="10" ALIGN="CENTER">OR</TD>
        <TD BGCOLOR="#eaeaea" HEIGHT="10"></TD>
      </TR>
      <TR>
        <TD STYLE="font-family: arial; font-size: 12px; font-weight: bold;" 
        BGCOLOR="#def2fe" HEIGHT="30" WIDTH="10%" VALIGN="MIDDLE">&nbsp;Select Sections</TD>
        <TD STYLE="font-family: arial; font-size: 12px;" BGCOLOR="#eaeaea">
        <TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
          <TR>
            <TD WIDTH="33%" STYLE="font-family: arial; font-size: 12px;">
	    ';
		if($defaultForm || $param['seca'])
		{
		echo '<INPUT TYPE="checkbox" NAME="seca" checked '. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;A Quality Leads';
		}
		else
		{
		echo '<INPUT TYPE="checkbox" NAME="seca"'. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;A Quality Leads';
		}
	   echo '
	   </TD>
            <TD WIDTH="33%" STYLE="font-family: arial; font-size: 12px;">
	    ';
		if($defaultForm || $param['secb'])
		{
		echo '<INPUT TYPE="checkbox" NAME="secb" checked '. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;B Quality Leads';
		}
		else
		{
		print '<INPUT TYPE="checkbox" NAME="secb"'. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;B Quality Leads';
		}
	    echo '
	    </TD>
            <TD WIDTH="34%" STYLE="font-family: arial; font-size: 12px;">
	    ';
		if($defaultForm || $param['secc'])
		{
		echo '<INPUT TYPE="checkbox" NAME="secc" checked '. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;C Quality Leads';
		}
		else
		{
		echo '<INPUT TYPE="checkbox" NAME="secc"'. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;C Quality Leads';
		}
	   echo '
	   </TD>
          </TR>
          <TR>
            <TD WIDTH="33%" STYLE="font-family: arial; font-size: 12px;">
	    ';
		if($defaultForm || $param['secd'])
		{
		echo '<INPUT TYPE="checkbox" NAME="secd" checked '. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;D Quality Leads';
		}
		else
		{
		echo '<INPUT TYPE="checkbox" NAME="secd"'. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;D Quality Leads';
		}
	    echo '
	    </TD>
            <TD WIDTH="33%" STYLE="font-family: arial; font-size: 12px;">
	    ';
		if($defaultForm || $param['secin'])
		{
		echo '<INPUT TYPE="checkbox" NAME="secin" checked '. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;Indian Leads';
		}
		else
		{
		echo '<INPUT TYPE="checkbox" NAME="secin"'. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;Indian Leads';
		}
	    echo '
            </TD>
            <TD WIDTH="34%" STYLE="font-family: arial; font-size: 12px;">
	    ';
		if($defaultForm || $param['secfrn'])
		{
		echo '<INPUT TYPE="checkbox" NAME="secfrn" checked '. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;Foreign Leads';
		}
		else
		{
		echo '<INPUT TYPE="checkbox" NAME="secfrn"'. $secDisabled .'ONCLICK="unchecksecall(this);">&nbsp;Foreign Leads';
		}
	    echo '
	    </TD>
          </TR>
          <TR>
            <TD WIDTH="33%" STYLE="font-family: arial; font-size: 12px;">
	    ';
		if($defaultForm || $param['checkallsec'])
		{
		echo '<INPUT TYPE="checkbox" NAME="checkallsec" checked '. $secDisabled .'ONCLICK="checkuncheck();">&nbsp;All Sections';
		}
		else
		{
		echo '<INPUT TYPE="checkbox" NAME="checkallsec"'. $secDisabled .'ONCLICK="checkuncheck();">&nbsp;All Sections';
		}
	    echo '
	    </TD>
            <TD WIDTH="33%" STYLE="font-family: arial; font-size: 12px;"></TD>
            <TD WIDTH="34%" STYLE="font-family: arial; font-size: 12px;"></TD>
          </TR>
        </TABLE></TD>
	<TD STYLE="font-family: arial; font-size: 12px; font-weight: bold;" 
        BGCOLOR="#def2fe" WIDTH="10%" VALIGN="MIDDLE">&nbsp;Select Grp / Cat</TD>
        <TD STYLE="font-family: arial; font-size: 12px;" BGCOLOR="#eaeaea">
	';
	echo  '
        <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" WIDTH="100%">
          <TR>
            <TD WIDTH="3%">
	    ';
		if($defaultForm || ($param['grpcatsrch'] && $param['grpcatsrch'] == 1))
		{
		echo  '<INPUT TYPE="RADIO" NAME="grpcatsrch" VALUE="1"'. $grpcatDisable .'ONCLICK="this.form.group.disabled=true;" checked>';
		}
		else
		{
		echo '<INPUT TYPE="RADIO" NAME="grpcatsrch" VALUE="1"'. $grpcatDisable .'ONCLICK="this.form.group.disabled=true;">';
		}
	    echo '
	    </TD>
            <TD STYLE="font-family: arial; font-size: 12px;">Group Wise&nbsp;&nbsp;</TD>
            <TD WIDTH="3%">
	    ';
		if($param['grpcatsrch'] && $param['grpcatsrch'] == 2)
		{
		echo '<INPUT TYPE="RADIO" NAME="grpcatsrch" VALUE="2"'. $grpcatDisable .'ONCLICK="this.form.group.disabled=true;" checked>';
		}
		else
		{
		print '<INPUT TYPE="RADIO" NAME="grpcatsrch" VALUE="2"'. $grpcatDisable .'ONCLICK="this.form.group.disabled=true;">';
		}
	    echo '
	    </TD>
            <TD STYLE="font-family: arial; font-size: 12px;">Category Wise&nbsp;&nbsp;</TD>
          </TR>
          
	    ';

echo '<TR><TD>';
		if($defaultForm || ($param['grpcatsrch'] && $param['grpcatsrch'] == 4))
		{
		echo '<INPUT TYPE="RADIO" NAME="grpcatsrch" VALUE="4"'. $grpcatDisable .'ONCLICK="this.form.group.disabled=true;" checked>';
		}
		else
		{
		echo '<INPUT TYPE="RADIO" NAME="grpcatsrch" VALUE="4"'. $grpcatDisable .'ONCLICK="this.form.group.disabled=true;">';
		}
	    echo '
	    </TD>
            <TD STYLE="font-family: arial; font-size: 12px;">No Category&nbsp;&nbsp;</TD>';





		$temp_group='';
		$temp_group = $this->dropdown_menu_data('GLCAT_GRP','GLCAT_GRP_NAME','GLCAT_GRP_ID','',$param['group'],'GLCAT_GRP_NAME');
		
		if($param['grpcatsrch'] && $param['grpcatsrch'] == 3 && $param['group'])
		{
		echo '
		
		<TD>
		<INPUT TYPE="RADIO" NAME="grpcatsrch" VALUE="3"'. $grpcatDisable .'ONCLICK="this.form.group.disabled=false;" checked></TD>
		<TD STYLE="font-family:arial;font-size:12px;" COLSPAN="3">All Categories of</TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" COLSPAN="4"><SELECT NAME="group" SIZE="1">'.$temp_group.'
		</SELECT>
		</TD>
		</TR>';
		}
		else
		{
		echo '
		
		<TD>
		<INPUT TYPE="RADIO" NAME="grpcatsrch" VALUE="3"'. $grpcatDisable .'ONCLICK="this.form.group.disabled=false;"></TD>
		<TD STYLE="font-family:arial;font-size:12px;" COLSPAN="3">All Categories of</TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" COLSPAN="4"><SELECT NAME="group" SIZE="1" DISABLED>'.$temp_group.'
		</SELECT>
		</TD>
		</TR>';
		}    
	    echo '
          
        </TABLE>
	</TD>
      </TR>
	';
	
      echo '
      <TR>
        <TD BGCOLOR="#F4F4F4" HEIGHT="30" COLSPAN="2">
	<input type="hidden" name="unsold" value="">
	<input type="hidden" name="sold" value="">
	<input type="hidden" name="postdate" value="">
	<input type="hidden" name="modid" value="">
	<input type="hidden" name="type" value="">
	<input type="hidden" name="quality" value="">
	<input type="hidden" name="infrn" value="">
	<input type="hidden" name="catid" value="">
	<input type="hidden" name="grpid" value="">
	<input type="hidden" name="afl_id" value="">
	<input type="hidden" name="action" value="generate">';

	
		if($rest_report == 'rest_report')
		{
			echo '<input type="checkbox" name="rest_report" id="rest_report" value="rest_report" checked disabled/><b>Rest Report of Buylead</b>';
		}
		else
		{
			echo '<input type="checkbox" name="rest_report" id="rest_report" value="rest_report" disabled/><b>Rest Report of Buylead</b>';
		}
	echo '</td><td colspan="2" BGCOLOR="#F4F4F4" align="left" style="font-family: arial; font-size: 15px;font-weight:bold;"><INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Submit" style="display:none">
	 Please use <a href="/index.php?r=admin_bl/reports/blgendetail&mid=3435" target="_blank">Buy Lead Detail Report</a></td>
      </TR>
    </TABLE></FORM>';

    
    }

    
public function rest_report($dbh,$start_date,$end_date)
{
 
#**********************query for customer activity*********************************
$start_date=isset($request['start_date'])?$request['start_date']:'';
$end_date=isset($request['end_date'])?$request['end_date']:'';

$sql_cust_activity="SELECT COUNT(A.GLUSR_USR_ID) TOTAL_CUSTOMERS 
	FROM 
		( SELECT GLUSR_USR.GLUSR_USR_ID, ( (SELECT SUM(ETO_CUST_PURCHASE_CREDITS) 
		FROM ETO_CUST_PURCHASE_HIST 
		WHERE TRUNC(ETO_CUST_PURCHASE_DATE) < TRUNC(TO_DATE(:end_date,'DD-MM-YYYY')) AND ETO_CUST_PURCHASE_HIST.FK_GLUSR_USR_ID = GLUSR_USR.GLUSR_USR_ID) 
		
		- 
		
		( (NVL( (SELECT SUM(ETO_CREDITS_USED) FROM ETO_LEAD_PUR_HIST 
		WHERE TRUNC(ETO_PUR_DATE) < TRUNC(TO_DATE(:end_date,'DD-MM-YYYY')) 
		AND ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR.GLUSR_USR_ID),0) )
		 + 
		(NVL( (SELECT SUM(GLUSR_DBM_CREDITS) FROM 
		GLUSR_DBM_CONTACT 
		WHERE GLUSR_DBM_CONTACT.FK_GLUSR_USR_ID = GLUSR_USR.GLUSR_USR_ID 
		AND GLUSR_DBM_CONTACT.GLUSR_DBM_CONTACT_DATE < TRUNC(TO_DATE(:end_date,'DD-MM-YYYY')) ),0 ) ) ) ) CRD_AV 
		FROM 
		GLUSR_USR WHERE GLUSR_USR.GLUSR_USR_ID IN ( SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_CUST_PURCHASE_HIST ) ) A 
		WHERE CRD_AV > 0";

           $sth_cust_activity=oci_parse($dbh, $sql_cust_activity);
           oci_bind_by_name($sth_cust_activity, ':end_date', $end_date);
           oci_execute($sth_cust_activity);
	   $rec_cust_activity = oci_fetch_array($sth_cust_activity);
	   $cust_activity = $rec_cust_activity['TOTAL_CUSTOMERS'];


#**************query for Total repeat buyers*****************************

 $sql_repeat_buyers="SELECT
			COUNT (DISTINCT A.FK_GLUSR_USR_ID) REPEAT_BUYERS
		FROM
			
			(
			SELECT FK_GLUSR_USR_ID 
			FROM ETO_OFR 
			WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' 
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
		UNION
			SELECT FK_GLUSR_USR_ID 
			FROM 
			ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) 
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
			) A,
			(
			SELECT FK_GLUSR_USR_ID 
			FROM ETO_OFR
			WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' 
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) 
		UNION
			SELECT FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE(:start_date,'DD-MM-YYYY'))
			) B
			
			WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID";
			
			$sth_repeat_buyers=oci_parse($dbh, $sql_repeat_buyers);
                      oci_bind_by_name($sth_repeat_buyers, ':start_date', $start_date);
                      oci_bind_by_name($sth_repeat_buyers, ':end_date', $end_date);
                      oci_execute($sth_repeat_buyers);
	              $rec_repeat_buyers = oci_fetch_array($sth_repeat_buyers);

			$repeat_buyers = $rec_repeat_buyers['REPEAT_BUYERS'];


#**************query for repeat buyers in last 3 months*****************************


 $sql_repeat_buyers_3mnths="SELECT
		COUNT (DISTINCT A.FK_GLUSR_USR_ID) REPEAT_BUYERS_3MNTHS
		FROM
		
		(
		SELECT FK_GLUSR_USR_ID 
		FROM ETO_OFR WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
	UNION
		SELECT FK_GLUSR_USR_ID 
		FROM ETO_OFR_EXPIRED 
		WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
		) A,
		
		
		
		(
			SELECT FK_GLUSR_USR_ID 
			FROM ETO_OFR WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' 
			AND TRUNC(ETO_OFR_POSTDATE_ORIG)>= ADD_MONTHS(TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')),-3) 
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE(:start_date,'DD-MM-YYYY'))
	UNION
			SELECT FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND TRUNC(ETO_OFR_POSTDATE_ORIG)>= ADD_MONTHS(TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')),-3) AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE(:start_date,'DD-MM-YYYY'))
		) B
		
		WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID


";
                      $sth_repeat_buyers_3mnths=oci_parse($dbh, $sql_repeat_buyers_3mnths);
                      oci_bind_by_name($sth_repeat_buyers_3mnths, ':start_date', $start_date);
                      oci_bind_by_name($sth_repeat_buyers_3mnths, ':end_date', $end_date);
                      oci_execute($sth_repeat_buyers_3mnths);
	              $rec_repeat_buyers_3mnths = oci_fetch_array($sth_repeat_buyers_3mnths);

		      $repeat_buyers_3mnths = $rec_repeat_buyers_3mnths['REPEAT_BUYERS_3MNTHS'];

#**************query for repeat buyers in last 12 months***************

$sql_repeat_buyers_12mnths="SELECT
		COUNT (DISTINCT A.FK_GLUSR_USR_ID) REPEAT_BUYERS_12MNTHS
		FROM
		
		(
		SELECT FK_GLUSR_USR_ID 
		FROM ETO_OFR WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
	UNION
		SELECT FK_GLUSR_USR_ID 
		FROM ETO_OFR_EXPIRED 
		WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
		) A,
		
		
		
		(
			SELECT FK_GLUSR_USR_ID 
			FROM ETO_OFR WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' 
			AND TRUNC(ETO_OFR_POSTDATE_ORIG)>= ADD_MONTHS(TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')),-12) 
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE(:start_date,'DD-MM-YYYY'))
	UNION
			SELECT FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND TRUNC(ETO_OFR_POSTDATE_ORIG)>= ADD_MONTHS(TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')),-12) AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE(:start_date,'DD-MM-YYYY'))
		) B
		
		WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID


";

                      $sth_repeat_buyers_12mnths=oci_parse($dbh, $sql_repeat_buyers_12mnths);
                      oci_bind_by_name($sth_repeat_buyers_12mnths, ':start_date', $start_date);
                      oci_bind_by_name($sth_repeat_buyers_12mnths, ':end_date', $end_date);
                      oci_execute($sth_repeat_buyers_12mnths);
	              $rec_repeat_buyers_12mnths = oci_fetch_array($sth_repeat_buyers_12mnths);
		      $repeat_buyers_12mnths = $rec_repeat_buyers_12mnths['REPEAT_BUYERS_12MNTHS'];

echo '<br><br>
<div id="1" align="center">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" align="CENTER" bgcolor="#ffffff">';
echo '<tr><td valign="top">
		<table  width="73%" border="0" cellspacing="0" cellpadding="0">
	<tr>
				<TD width="73%" colspan="2" BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>CUSTOMER ACTIVITY</B></TD>			
				</TR>
				<TR>			
				<TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Customers &#62;0 </TD>
				<TD STYLE="font-family:arial;font-size:11px;padding-left:9px" >'.$cust_activity.' 			 
				</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Repeat Buyers</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding-left:9px">'.$repeat_buyers .'</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Repeat Buyers in last 3 months</TD>
				<TD STYLE="font-family:arial;font-size:11px; padding-left:9px;">'.$repeat_buyers_3mnths.' 			 
				</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Repeat Buyers in last 12 months</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding-left:9px" >'.$repeat_buyers_12mnths .'</td></tr>			 
				</table></td></tr>';

#***********************query for leads Approved -Source-wise************************

$sql_sourcewise="SELECT
    	COUNT(DISTINCT ETO_OFR_DISPLAY_ID) TOTAL_LEADS_GEN_THIS_WEEK,

    	SUM(CASE WHEN ETO_OFR_APPROV = 'A' THEN 1 ELSE 0 END) TOTAL_LEADS_APPROVED_THIS_WEEK,

    	SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND NVL(FK_ETO_AFL_ID,0) NOT IN (-1,-2,-5) AND FK_GL_MODULE_ID IN ('MY','ETO','CTL','DIR') THEN 1 ELSE 0 END) 			LEADS_FROM_IM_MAIN,

	SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND FK_ETO_AFL_ID IN (-1,-2) THEN 1 ELSE 0 END) LEADS_FROM_IM_BL_FOOTER,
    	
	SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND NVL(FK_ETO_AFL_ID,0) NOT IN (-1,-2,-5) AND FK_GL_MODULE_ID = 'FENQ' THEN 1 ELSE 0 END) LEADS_FROM_FENQ,

    	SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND NVL(FK_ETO_AFL_ID,0) NOT IN (-1,-2,-5) AND FK_GL_MODULE_ID = 'EMKTG' THEN 1 ELSE 0 END) LEADS_FROM_EMKTG,

    	SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND NVL(FK_ETO_AFL_ID,0) NOT IN (-1,-2,-5) AND FK_GL_MODULE_ID IN 		('Z3EBD','ZAFRBUS','ZAHI','ZALCALA','ZALTIND','ZAPPSRCH','ZARBET','ZATGLB','ZB4IND','ZBLDTRKY','ZBSYTRDE', 'ZDBAICHM', 'ZDDEX', 'ZDMINDON', 'ZEKERALA', 'ZENF', 	'ZFOODMCH', 'ZFRNTRAD', 'ZFTASIA', 'ZGLOBAL', 'ZGRUPOF3', 'ZIDEA', 'ZIIFJS', 'ZIMP', 'ZINCNST', 'ZINDASTP', 'ZINDMAAL', 'ZINDSTK', 'ZINDSVE', 'ZINFUR','ZJETC', 'ZLCHAAT', 'ZLIVELST', 'ZMAST', 'ZMFINDIA', 'ZMKTUSA', 'ZMYCITY', 'ZMYTRADE', 'ZPESCAL', 'ZPINDEX', 'ZPRINTCT', 'ZPWEB', 'ZSHWMRT', 'ZSURAJ', 		'ZTDRCHN', 'ZTRADPLY', 'ZTRDEB2B', 'ZTRDEWRD', 'ZTRDEXL', 'ZTRDNMAP', 'ZTRDXPRO', 'ZTRSEAFD', 'ZUKWHOLE', 'ZWHLEUK', 'ZWHVAC', 'ZWTRADE', 'ZYPG', 'BLAFFLT') THEN 1 ELSE 0 END) LEADS_FROM_EXTERNAL_AFFILIATES,

    	SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND FK_ETO_AFL_ID IN (-5) THEN 1 ELSE 0 END) LEADS_FROM_PAID_FEEDBACK,

    	SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND NVL(FK_ETO_AFL_ID,0) NOT IN (-1,-2,-5) AND FK_GL_MODULE_ID NOT IN 			('Z3EBD','ZAFRBUS','ZAHI','ZALCALA','ZALTIND','ZAPPSRCH','ZARBET','ZATGLB','ZB4IND','ZBLDTRKY','ZBSYTRDE', 'ZDBAICHM', 'ZDDEX', 'ZDMINDON', 'ZEKERALA', 'ZENF', 	'ZFOODMCH', 'ZFRNTRAD', 'ZFTASIA', 'ZGLOBAL', 'ZGRUPOF3', 'ZIDEA', 'ZIIFJS', 'ZIMP', 'ZINCNST', 'ZINDASTP', 'ZINDMAAL', 'ZINDSTK', 'ZINDSVE', 'ZINFUR','ZJETC', 'ZLCHAAT', 'ZLIVELST', 'ZMAST', 'ZMFINDIA', 'ZMKTUSA', 'ZMYCITY', 'ZMYTRADE', 'ZPESCAL', 'ZPINDEX', 'ZPRINTCT', 'ZPWEB', 'ZSHWMRT', 'ZSURAJ', 'ZTDRCHN', 'ZTRADPLY', 'ZTRDEB2B', 'ZTRDEWRD', 'ZTRDEXL', 'ZTRDNMAP', 'ZTRDXPRO', 'ZTRSEAFD', 'ZUKWHOLE', 'ZWHLEUK', 'ZWHVAC', 'ZWTRADE', 'ZYPG', 'BLAFFLT','MY','ETO','DIR','CTL','EMKTG','FENQ') THEN 1 ELSE 0 END) LEADS_FROM_OTHERS,

	SUM(CASE WHEN FK_ETO_AFL_ID IN (-1,-2) THEN 1 ELSE 0 END) LEADS_GEN_THROUGH_BL_FOOTER

FROM
        (
        SELECT ETO_OFR_DISPLAY_ID , FK_GL_MODULE_ID,FK_ETO_AFL_ID,ETO_OFR_APPROV FROM ETO_OFR WHERE ETO_OFR_TYP = 'B'  
	AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC		(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY')) 

        UNION

       	SELECT ETO_OFR_DISPLAY_ID , FK_GL_MODULE_ID,FK_ETO_AFL_ID,ETO_OFR_APPROV  FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B'  AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= 		TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY')) 

        UNION

        SELECT ETO_OFR_DISPLAY_ID , FK_GL_MODULE_ID,FK_ETO_AFL_ID,ETO_OFR_APPROV  FROM ETO_OFR_TEMP_DEL WHERE ETO_OFR_TYP = 'B'  AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= 		TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY')) 
        ) LEADS";

                     $sth_sourcewise=oci_parse($dbh, $sql_sourcewise);
                      oci_bind_by_name($sth_sourcewise, ':start_date', $start_date);
                      oci_bind_by_name($sth_sourcewise, ':end_date', $end_date);
                      oci_execute($sth_sourcewise);
	              $rec_sourcewise = oci_fetch_array($sth_sourcewise);
        
			 $total_approved = $rec_sourcewise['TOTAL_LEADS_APPROVED_THIS_WEEK'];
			 $im_main = $rec_sourcewise['LEADS_FROM_IM_MAIN'];	
			 $bl_footer_approv = $rec_sourcewise['LEADS_FROM_IM_BL_FOOTER'];
			 $fenq = $rec_sourcewise['LEADS_FROM_FENQ'];	
			 $emktg = $rec_sourcewise['LEADS_FROM_EMKTG'];
			 $ext_afl = $rec_sourcewise['LEADS_FROM_EXTERNAL_AFFILIATES'];
			 $paid_feedback = $rec_sourcewise['LEADS_FROM_PAID_FEEDBACK'];
			 $others = $rec_sourcewise['LEADS_FROM_OTHERS'];
			 $bl_footer_gen=$rec_sourcewise['LEADS_GEN_THROUGH_BL_FOOTER'];

#**********************query for Slideshare approved leads***********************
			
 $sql_slideshare="SELECT NVL((SUM(CNT)),0) SLIDESHARE_APPROVED FROM (SELECT ETO_OFR_POSTDATE_ORIG,COUNT(1) CNT
FROM     
	(
	SELECT 
		ETO_OFR_ID,
		TRUNC(ETO_OFR_POSTDATE_ORIG) ETO_OFR_POSTDATE_ORIG
	FROM     
		ETO_OFR 
	WHERE 
		FK_ETO_AFL_ID = 471 
		AND ETO_OFR_TYP = 'B'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY'))
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
	UNION
	
	SELECT 
		ETO_OFR_ID,
		TRUNC(ETO_OFR_POSTDATE_ORIG) ETO_OFR_POSTDATE_ORIG
	FROM     
		ETO_OFR_EXPIRED
	WHERE 
		FK_ETO_AFL_ID = 471 
		AND ETO_OFR_TYP = 'B'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY'))
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
	) ETO_OFR
	GROUP BY 
	ETO_OFR_POSTDATE_ORIG
	ORDER BY ETO_OFR_POSTDATE_ORIG)";

 
		      $sth_slideshare=oci_parse($dbh, $sql_slideshare);
                      oci_bind_by_name($sth_slideshare, ':start_date', $start_date);
                      oci_bind_by_name($sth_slideshare, ':end_date', $end_date);
                      oci_execute($sth_slideshare);
	              $rec_slideshare = oci_fetch_array($sth_slideshare);
		      $slideshare = $rec_slideshare['SLIDESHARE_APPROVED'];

echo '<tr><td valign="top"><table  width="73%" border="0" cellspacing="0" cellpadding="0">

		<tr>

				<TD width="73%" colspan="2" BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>Leads Approved-Source-wise</B></TD>			
				</TR>
				<TR>			
				<TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Leads Approved</TD>
				<TD   STYLE="font-family:arial;font-size:11px;padding: 9px;" >'.$total_approved.'</TD>
				<TR>			

				<TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Leads From IM Main site</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$im_main .'</TD></tr>
<TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Leads From IM BL Footer Form</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$bl_footer_approv .'</TD>
				</tr><TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Leads From Fenq</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$fenq .'</TD>
				</tr><TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Leads From External Affiliates</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$ext_afl .'</TD>
				</tr><TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Leads From Email Marketing</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$emktg .'</TD>
				</tr><TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Leads From Slideshare</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$slideshare .'</TD>
				</tr><TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Leads From Paid Suppliers Feedback Campaign</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$paid_feedback .'</TD>
				</tr><TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Leads From other sources</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$others .'</TD></TR>
				
				</table></td></tr>';


#**********************query for leads approved from IM Paid Customers***************
			
$sql_impaid="SELECT COUNT(1) IM_PAID_CUSTOMERS FROM ETO_OFR,GLUSR_USR,CUSTTYPE WHERE GLUSR_USR_ID = FK_GLUSR_USR_ID AND GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID(+) AND ETO_OFR_APPROV = 'A' AND ETO_OFR_TYP = 'B' 
    AND CUSTTYPE_ID IN(1,2,10,12)  
    AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
";

                      $sth_impaid=oci_parse($dbh, $sql_impaid);
                      oci_bind_by_name($sth_impaid, ':start_date', $start_date);
                      oci_bind_by_name($sth_impaid, ':end_date', $end_date);
                      oci_execute($sth_impaid);
	              $rec_impaid = oci_fetch_array($sth_impaid);


		     $impaid = $rec_impaid['IM_PAID_CUSTOMERS'];

echo '<tr><td valign="top"><table width="73%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD width="73%" colspan="2" BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" ><b>&nbsp;Leads Approved From IM Paid Customers</b></TD>			
				</TR>
				<TR>			
				<TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Count</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$impaid.' 			 
				</TD></TR></table></td></tr>';


#*************Indian leads approved with no city************************


 $sql_nocity="SELECT COUNT(1) CNT FROM 
		(
		SELECT ETO_OFR_DISPLAY_ID 
		FROM ETO_OFR,GLUSR_USR 
		WHERE GLUSR_USR_ID = FK_GLUSR_USR_ID AND ETO_OFR_TYP = 'B'
		AND ETO_OFR_APPROV='A' 
		AND FK_GL_CITY_ID IS NULL 
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY')) AND GLUSR_USR.FK_GL_COUNTRY_ISO = 'IN'

UNION

		SELECT ETO_OFR_DISPLAY_ID 
		FROM ETO_OFR_EXPIRED,GLUSR_USR 
		WHERE GLUSR_USR_ID = FK_GLUSR_USR_ID 
		AND ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' 
		AND FK_GL_CITY_ID IS NULL 
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY')) AND GLUSR_USR.FK_GL_COUNTRY_ISO = 'IN'
		)";

		     $sth_nocity=oci_parse($dbh, $sql_nocity);
                      oci_bind_by_name($sth_nocity, ':start_date', $start_date);
                      oci_bind_by_name($sth_nocity, ':end_date', $end_date);
                      oci_execute($sth_nocity);
	              $rec_nocity = oci_fetch_array($sth_nocity);
		      $lead_nocity = $rec_nocity['CNT'];

echo '<tr><td valign="top"><table width="73%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD width="73%" colspan="2" BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" ><b>&nbsp;Leads Approved with no city</b></TD>			
				</TR>
				<TR>			
				<TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Count</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$lead_nocity.' 			 
				</TD></TR>
				</table></td></tr>';

#*************html for leads generated through BL-Footer form******************

echo '<tr><td valign="top">
<table width="73%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD width="73%" colspan="2" BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" ><b>&nbsp;Leads generated through BL Footer Form</b></TD>			
				</TR>
				<TR>			
				<TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Count</TD>
				<TD STYLE="font-family:arial;font-size:11px;padding:9px;" >'.$bl_footer_gen.' 			 
				</TD></TR></table><td></tr>
		
</table>
</div>';




}
    
public function showLeadGenerationResult($dbh,$rprtType,$rprtfrnq,$modidDrpDwn,$formtypeDrpDwn,$indsitesUrl,$country,$countryExclude,$secA,$secB,$secC,$secD,$secIN,$secFRN,$grpCatSrch,$groupID,$srchType,$start_date,$end_date,$rest_report,$param)
{
	$errArr =array();
	$flagError=0;
	
 $src_cnd = '';
if($srchType && $srchType == 1)
{
	if($modidDrpDwn && $modidDrpDwn == 'ETO'){
	$src_cnd =" AND (FULL_PAGE_REFERRER like '%http://trade.indiamart.com/search.mp%' OR FULL_PAGE_REFERRER like '%https://trade.indiamart.com/search.mp%')";
	}
	if($modidDrpDwn && $modidDrpDwn == 'DIR'){
	$src_cnd = " AND (FULL_PAGE_REFERRER like '%http://dir.indiamart.com/cgi/catprdsearch.mp%' OR FULL_PAGE_REFERRER like '%http://dir.indiamart.com/search.mp%' OR FULL_PAGE_REFERRER like '%https://dir.indiamart.com/cgi/catprdsearch.mp%' OR FULL_PAGE_REFERRER like '%https://dir.indiamart.com/search.mp%')";
	}
}
elseif($srchType && $srchType == 2)
{
        if($modidDrpDwn && $modidDrpDwn == 'ETO'){
	$src_cnd =" AND (FULL_PAGE_REFERRER NOT like '%http://trade.indiamart.com/search.mp%' AND FULL_PAGE_REFERRER NOT like '%https://trade.indiamart.com/search.mp%')";
	}
	if($modidDrpDwn && $modidDrpDwn == 'DIR')
	{
	$src_cnd =" AND (FULL_PAGE_REFERRER NOT like '%http://dir.indiamart.com/cgi/catprdsearch.mp%' AND FULL_PAGE_REFERRER NOT like '%http://dir.indiamart.com/search.mp%' AND FULL_PAGE_REFERRER NOT like '%https://dir.indiamart.com/cgi/catprdsearch.mp%' AND FULL_PAGE_REFERRER NOT like '%https://dir.indiamart.com/search.mp%')";
	}
}
elseif($srchType && $srchType == 3)
{
$src_cnd = '';
}

           $afl_id = 0;
	   $tableSize = 332;
	if($secA){
	$tableSize=$tableSize+262;
	}
	if($secB){
	$tableSize=$tableSize+262;
	}
	if($secC){
	$tableSize=$tableSize+262;
	}
	if($secD){
	$tableSize=$tableSize+262;
	}
	if($secIN){
	$tableSize=$tableSize+262;
	}
	if($secFRN){
	$tableSize=$tableSize+262;
	}
	
	
	 

	 $date  = date($start_date);
         $date1 = date($end_date);

	if(empty($start_date) || empty($end_date))
		{
			array_push($errArr,"Invalid Start Date");
			$flagError=1;
		}
	
	if ($flagError==1)
	{
		$mesg = '';
		$mesg ='<TABLE BORDER="0" WIDTH="100%"><TR>
			<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#FF0000" size="2"><B>Following Error(s) Occured:<BR><BR>';
		 $errorCounter=0;
		foreach ($errArr as $x)
		{
			$errorCounter++;
			$mesg .=' Error'. $errorCounter.':'. $x.'<BR>';
		}
		$mesg .='<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT></TD>
			</TR></TABLE>';

		$this->buyLeadGenerationForm($dbh,$mesg,$modidDrpDwn,$formtypeDrpDwn,$rprtfrnq,$rprtType,$indsitesUrl,$country,$countryExclude,$srchType,$rest_report,$param,$start_date,$end_date);
	} 
	else 
	{
	        $mesg=''; 	
		$this->buyLeadGenerationForm($dbh,$mesg,$modidDrpDwn,$formtypeDrpDwn,$rprtfrnq,$rprtType,$indsitesUrl,$country,$countryExclude,$srchType,$rest_report,$param,$start_date,$end_date);
		

		echo '
		<STYLE TYPE="text/css">.admintext {font-family:ms sans serif,verdana; font-size:9px;font-weight:bold;line-height:17px;}
		.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}
		.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
		
		.tab 
		{FONT-FAMILY:arial, ms Sans serif;
		FONT-SIZE:11px;
		COLOR: #000000;
		line-height:21px;
		margin-left:3px;
		}
		
		.tab1 
		{FONT-FAMILY:arial, ms Sans serif;
		FONT-SIZE:11px;
		line-height:23px;
		COLOR:#000000;
		margin-left:3px;
		}
		
		.tab1 A
		{
		COLOR:#000000;
		text-decoration:none;
		}
		.tab1 A:hover
		{
		COLOR:#ff0000;
		text-decoration:none;
		}
		
		.tab-head
		{FONT-FAMILY:arial, ms Sans serif;
		font-weight:bold;
		FONT-SIZE:18px;
		COLOR: #ff0000;
		padding:4px 4px 4px 0px;
		}

		.tab-table-new 
		{
		border:1px solid #C5D0FD;
		border-top:0px;
		}
		
		.tab-table-new td
		{
		border-left:1px solid #C5D0FD;
		}
		
		.tab-table-new td.a
		{
		border-left:0px;
		}
		</STYLE>';
		

		echo '<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" align="left" width="'.$tableSize.'">
		<TR>
		<TD bgcolor="#eaeaea" HEIGHT="30" ALIGN="CENTER" 
		STYLE="font-family:arial;font-size:14px;font-weight:bold;">Search Result:-</TD>
		</TR>
		</TABLE>
		<DIV><BR><BR><BR><BR><BR><BR><BR><BR></DIV> ';
		 $resultHeader='';
		$resultHeader.='<TABLE BORDER="1" CELLPADDING="0" CELLSPACING="0" STYLE="border-collapse:collapse;" BORDERCOLOR="#C5D0FD" WIDTH="'.$tableSize.'"><TR><TD ROWSPAN="2" BGCOLOR="#F2FAFF" WIDTH="70" VALIGN="MIDDLE"><DIV CLASS="tab">Posted On</DIV></TD><TD CLASS="tab" COLSPAN="4" BGCOLOR="#DEF2FE" ALIGN="CENTER"><B>Total Leads</B></TD>';
	
				if($secA)
				{
				$resultHeader.='<TD CLASS="tab" COLSPAN="4" BGCOLOR="#F2FAFF" ALIGN="CENTER"><B>A Quality Leads</B></TD>';
				}
				if($secB)
				{
				$resultHeader.='<TD CLASS="tab" COLSPAN="4" BGCOLOR="#DEF2FE" ALIGN="CENTER"><B>B Quality Leads</B></TD>';
				}
				if($secC)
				{
				$resultHeader.='<TD CLASS="tab" COLSPAN="4" BGCOLOR="#F2FAFF" ALIGN="CENTER"><B>C Quality Leads</B></TD>';
				}
				if($secD)
				{
				$resultHeader.='<TD CLASS="tab" COLSPAN="4" BGCOLOR="#DEF2FE" ALIGN="CENTER"><B>D Quality Leads</B></TD>';
				}
				if($secIN)
				{
				$resultHeader.='<TD CLASS="tab" COLSPAN="4" BGCOLOR="#F2FAFF" ALIGN="CENTER"><B>Indian Leads</B></TD>';
				}
				if($secFRN)
				{
				$resultHeader.='<TD CLASS="tab" COLSPAN="4" BGCOLOR="#DEF2FE" ALIGN="CENTER"><B>Foreign Leads</B></TD>';
				}
			$resultHeader.='</TR><TR><TD BGCOLOR="#DEF2FE" WIDTH="80" VALIGN="TOP"><DIV CLASS="tab">Approved (Generated - Waiting)</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="65" VALIGN="TOP"><DIV CLASS="tab">Sold no. of Times / Sold</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Unsold</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Credit Earned</DIV></TD>';
				if($secA)
				{
				$resultHeader.='<TD BGCOLOR="#F2FAFF" WIDTH="80" VALIGN="TOP"><DIV CLASS="tab">Approved (Generated - Waiting)</DIV></TD><TD BGCOLOR="#F2FAFF" WIDTH="65" VALIGN="TOP"><DIV CLASS="tab">Sold no. of Times / Sold</DIV></TD><TD BGCOLOR="#F2FAFF" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Unsold</DIV></TD><TD BGCOLOR="#F2FAFF" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Credit Earned</DIV></TD>';
				}
				if($secB)
				{
				$resultHeader.='<TD BGCOLOR="#DEF2FE" WIDTH="80" VALIGN="TOP"><DIV CLASS="tab">Approved (Generated - Waiting)</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="65" VALIGN="TOP"><DIV CLASS="tab">Sold no. of Times / Sold</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Unsold</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Credit Earned</DIV></TD>';
				}
				if($secC)
				{
				$resultHeader.='<TD BGCOLOR="#F2FAFF" WIDTH="80" VALIGN="TOP"><DIV CLASS="tab">Approved (Generated - Waiting)</DIV></TD><TD BGCOLOR="#F2FAFF" WIDTH="65" VALIGN="TOP"><DIV CLASS="tab">Sold no. of Times / Sold</DIV></TD><TD BGCOLOR="#F2FAFF" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Unsold</DIV></TD><TD BGCOLOR="#F2FAFF" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Credit Earned</DIV></TD>';
				}
				if($secD)
				{
				$resultHeader.='<TD BGCOLOR="#DEF2FE" WIDTH="80" VALIGN="TOP"><DIV CLASS="tab">Approved (Generated - Waiting)</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="65" VALIGN="TOP"><DIV CLASS="tab">Sold no. of Times / Sold</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Unsold</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Credit Earned</DIV></TD>';
				}
				if($secIN)
				{
				$resultHeader.='<TD BGCOLOR="#F2FAFF" WIDTH="80" VALIGN="TOP"><DIV CLASS="tab">Approved (Generated - Waiting)</DIV></TD><TD BGCOLOR="#F2FAFF" WIDTH="65" VALIGN="TOP"><DIV CLASS="tab">Sold no. of Times / Sold</DIV></TD><TD BGCOLOR="#F2FAFF" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Unsold</DIV></TD><TD BGCOLOR="#F2FAFF" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Credit Earned</DIV></TD>';
				}
				if($secFRN)
				{
				$resultHeader.='<TD BGCOLOR="#DEF2FE" WIDTH="80" VALIGN="TOP"><DIV CLASS="tab">Approved (Generated - Waiting)</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="65" VALIGN="TOP"><DIV CLASS="tab">Sold no. of Times / Sold</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Unsold</DIV></TD><TD BGCOLOR="#DEF2FE" WIDTH="55" VALIGN="TOP"><DIV CLASS="tab">Credit Earned</DIV></TD>';
				}
			$resultHeader.='</TR></TABLE>';
		
	echo
<<<MSG
		<SCRIPT LANGUAGE='JavaScript'>
		<!--
		
	
		document.write('<DIV ID="floatdiv" STYLE="top:0px; z-index:1000; display:none;  position:absolute;">$resultHeader</DIV><br>');

		function get()
		{
			var myWidth = 0, myHeight = 0;
			if( typeof( window.innerWidth ) == 'number' ) {
			myWidth = window.innerWidth;
			myHeight = window.innerHeight;
			} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
			myWidth = document.documentElement.clientWidth;
			myHeight = document.documentElement.clientHeight;
			} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			myWidth = document.body.clientWidth;
			myHeight = document.body.clientHeight;
			}
			var ht = window.pageYOffset ||
				document.body.scrollTop ||
			document.documentElement.scrollTop;
			var hp = document.body.offsetHeight;
			var hx = window.pageXOffset || 0;
			
			var total = ht+myHeight;
			if(ht > 335)
			{
				padtotal =ht;
			}
			else
			{
				padtotal =ht + (335 - ht);
			}
			document.getElementById('floatdiv').style.display='block';
			document.getElementById('floatdiv').style.marginTop=padtotal+'px';
		}
		
		function addEvent( obj, type, fn ){ 
		if (obj.addEventListener){ 
			obj.addEventListener( type, fn, false );
		}
		else if (obj.attachEvent){ 
			obj['e'+type+fn] = fn; 
			obj[type+fn] = function(){ obj['e'+type+fn]( window.event ); } 
			obj.attachEvent( 'on'+type, obj[type+fn] ); 
		} 
		
		}
		
		addEvent(window, 'load', get);
		addEvent(window, 'scroll', get);
		addEvent(window, 'resize', get);

		//-->
		</SCRIPT>
MSG;
		
		 $condition = '';
		
		if($rprtfrnq == 3) # In Monthly consider full month
		{
			if ($start_date != '') 
			{
				$condition .= " WHERE POSTDATE >= TRUNC(TO_DATE('$start_date','dd-mm-yyyy'),'MONTH') ";
			}
			if ($end_date != '') 
			{
				$condition .= " AND POSTDATE <= LAST_DAY(TO_DATE('$end_date','dd-mm-yyyy')) ";
			}
		}
		else
		{
			if ($start_date != '') 
			{
				$condition .= " WHERE POSTDATE >= TO_DATE('$start_date','dd-mm-yyyy') ";
			}
			if ($end_date != '') 
			{
				$condition .= " AND POSTDATE <= TO_DATE('$end_date','dd-mm-yyyy') ";
			}
		
		}
	
		
		if($modidDrpDwn && $modidDrpDwn != -1)
		{
			$condition .= " AND FK_GL_MODULE_ID = '$modidDrpDwn' ";
		}

if($formtypeDrpDwn && $formtypeDrpDwn <= -1)
{
	$condition .= " AND FK_ETO_AFL_ID = '$formtypeDrpDwn' ";
	$afl_id = $formtypeDrpDwn;
}

if($srchType)
{
	$condition .= $src_cnd ;
}

		if($country)
		{
			if($countryExclude)
			{
				$condition .=" AND FK_GL_COUNTRY_ISO <> '$country' ";
			}
			else
			{
				$condition .= " AND FK_GL_COUNTRY_ISO = '$country' ";
			}
		}
		
		
		 $sql = '';
		if(isset($modidDrpDwn) && $modidDrpDwn == 'PDTPTL' && isset($indsitesUrl))
		{
			if($indsitesUrl != 'All')
			{
				$condition .=" AND PAGE_REFERRER = '$indsitesUrl' ";
			}
			
			if($rprtfrnq == 3) #monthly
			{
			$sql .= "
				SELECT  
					PAGE_REFERRER FK_GL_MODULE_ID, POSTMON, POSTMON_NAME POSTEDON, 
					SUM(GENERATED) GENERATED, 
					SUM(APPROVED) APPROVED, 
					SUM(WAITING) WAITING, 
					SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
					SUM(UNSOLD) UNSOLD,
					SUM(SOLD) SOLD, 
					SUM(TOT_CRD_USED) TOT_CRD_USED, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
				FROM (
					SELECT TO_CHAR(POSTDATE,'YY-MM') POSTMON, TO_CHAR(POSTDATE,'MON-YY') POSTMON_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD
					FROM ETO_GENERATION_RPT
					$condition
				)
				GROUP BY PAGE_REFERRER, POSTMON, POSTMON_NAME 
				ORDER BY PAGE_REFERRER, POSTMON ";
			}
			elseif($rprtfrnq == 2) #weekly
			{
			$sql .= "
				SELECT  
					PAGE_REFERRER FK_GL_MODULE_ID, POSTWEEK, 'Week' || POSTWEEK_NAME POSTEDON, 
					SUM(GENERATED) GENERATED, 
					SUM(APPROVED) APPROVED, 
					SUM(WAITING) WAITING, 
					SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
					SUM(UNSOLD) UNSOLD,
					SUM(SOLD) SOLD, 
					SUM(TOT_CRD_USED) TOT_CRD_USED, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
				FROM (
					SELECT TO_CHAR(POSTDATE,'YY-IW') POSTWEEK, TO_CHAR(POSTDATE,'IW-YY') POSTWEEK_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD
					FROM ETO_GENERATION_RPT
					$condition
				)
				GROUP BY PAGE_REFERRER, POSTWEEK, POSTWEEK_NAME 
				ORDER BY PAGE_REFERRER, POSTWEEK ";
			}
			else
			{
			$sql .= "
				SELECT  
					PAGE_REFERRER FK_GL_MODULE_ID, POSTDATE POSTEDON, 
					SUM(GENERATED) GENERATED, 
					SUM(APPROVED) APPROVED, 
					SUM(WAITING) WAITING, 
					SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
					SUM(UNSOLD) UNSOLD,
					SUM(SOLD) SOLD, 
					SUM(TOT_CRD_USED) TOT_CRD_USED, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
				FROM (
					SELECT POSTDATE, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD
					FROM ETO_GENERATION_RPT
					$condition
				)
				GROUP BY PAGE_REFERRER, POSTDATE 
				ORDER BY PAGE_REFERRER, POSTDATE ";
			}
		}
		elseif($grpCatSrch)
		{
			if($grpCatSrch == 2 || $grpCatSrch == 3) # Cat Wise
			{
				if($groupID)
				{
					$condition .= " AND FK_GLCAT_CAT_ID IN (SELECT FK_GLCAT_CAT_ID FROM GLCAT_GRP_TO_CAT WHERE FK_GLCAT_GRP_ID='$groupID') ";
				}
				
				
				if($rprtfrnq == 3) #monthly
				{
				$sql .= "
					SELECT  
						FK_GLCAT_CAT_ID, 
						CAT_NAME FK_GL_MODULE_ID, POSTMON, POSTMON_NAME POSTEDON, 
						SUM(GENERATED) GENERATED, 
						SUM(APPROVED) APPROVED, 
						SUM(WAITING) WAITING, 
						SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
						SUM(UNSOLD) UNSOLD,
						SUM(SOLD) SOLD, 
						SUM(TOT_CRD_USED) TOT_CRD_USED, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
					FROM (
						SELECT TO_CHAR(POSTDATE,'YY-MM') POSTMON, TO_CHAR(POSTDATE,'MON-YY') POSTMON_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD, FK_GLCAT_CAT_ID, CAT_NAME
						FROM ETO_GENERATION_RPT
						$condition
					)
					GROUP BY FK_GLCAT_CAT_ID, CAT_NAME, POSTMON, POSTMON_NAME 
					ORDER BY CAT_NAME, POSTMON ";
				}
			
				elseif($rprtfrnq == 2) #weekly
				{
				$sql .= "
					SELECT  
						FK_GLCAT_CAT_ID, 
						CAT_NAME FK_GL_MODULE_ID, POSTWEEK, 'Week' || POSTWEEK_NAME POSTEDON, 
						SUM(GENERATED) GENERATED, 
						SUM(APPROVED) APPROVED, 
						SUM(WAITING) WAITING, 
						SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
						SUM(UNSOLD) UNSOLD,
						SUM(SOLD) SOLD, 
						SUM(TOT_CRD_USED) TOT_CRD_USED, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
					FROM (
						SELECT TO_CHAR(POSTDATE,'YY-IW') POSTWEEK, TO_CHAR(POSTDATE,'IW-YY') POSTWEEK_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD, FK_GLCAT_CAT_ID, CAT_NAME
						FROM ETO_GENERATION_RPT
						$condition
					)
					GROUP BY FK_GLCAT_CAT_ID, CAT_NAME, POSTWEEK, POSTWEEK_NAME 
					ORDER BY CAT_NAME, POSTWEEK ";
				}
				else
				{
				$sql .= "
					SELECT  
						FK_GLCAT_CAT_ID,
						CAT_NAME FK_GL_MODULE_ID, 
						POSTDATE POSTEDON, 
						SUM(GENERATED) GENERATED, 
						SUM(APPROVED) APPROVED, 
						SUM(WAITING) WAITING, 
						SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
						SUM(UNSOLD) UNSOLD,
						SUM(SOLD) SOLD, 
						SUM(TOT_CRD_USED) TOT_CRD_USED, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
					FROM (
						SELECT POSTDATE, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD, FK_GLCAT_CAT_ID, CAT_NAME
						FROM ETO_GENERATION_RPT
						$condition
					)
					GROUP BY FK_GLCAT_CAT_ID, CAT_NAME, POSTDATE 
					ORDER BY CAT_NAME, POSTDATE ";
				}
			}
			elseif($grpCatSrch == 4) # Group Wise
			{
				if($rprtfrnq == 3) #monthly
				{
				$sql .= "
					SELECT  
						POSTMON, POSTMON_NAME POSTEDON, 
						SUM(GENERATED) GENERATED, 
						SUM(APPROVED) APPROVED, 
						SUM(WAITING) WAITING, 
						SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
						SUM(UNSOLD) UNSOLD,
						SUM(SOLD) SOLD, 
						SUM(TOT_CRD_USED) TOT_CRD_USED, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
					FROM (
						SELECT TO_CHAR(POSTDATE,'YY-MM') POSTMON, TO_CHAR(POSTDATE,'MON-YY') POSTMON_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD, FK_GLCAT_CAT_ID, CAT_NAME
						FROM ETO_GENERATION_RPT
						$condition
					) A
					GROUP BY POSTMON, POSTMON_NAME 
					ORDER BY POSTMON ";
				}
				elseif($rprtfrnq == 2) #weekly
				{
				$sql .= "
					SELECT  
						POSTWEEK, 'Week' || POSTWEEK_NAME POSTEDON, 
						SUM(GENERATED) GENERATED, 
						SUM(APPROVED) APPROVED, 
						SUM(WAITING) WAITING, 
						SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
						SUM(UNSOLD) UNSOLD,
						SUM(SOLD) SOLD, 
						SUM(TOT_CRD_USED) TOT_CRD_USED, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
					FROM (
						SELECT TO_CHAR(POSTDATE,'YY-IW') POSTWEEK, TO_CHAR(POSTDATE,'IW-YY') POSTWEEK_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD, FK_GLCAT_CAT_ID, CAT_NAME
						FROM ETO_GENERATION_RPT
						$condition
					) A
					GROUP BY POSTWEEK, POSTWEEK_NAME 
					ORDER BY POSTWEEK ";
				}
				else
				{
				$sql .= "
					SELECT  
						POSTDATE POSTEDON, 
						SUM(GENERATED) GENERATED, 
						SUM(APPROVED) APPROVED, 
						SUM(WAITING) WAITING, 
						SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
						SUM(UNSOLD) UNSOLD,
						SUM(SOLD) SOLD, 
						SUM(TOT_CRD_USED) TOT_CRD_USED, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
					FROM (
						SELECT POSTDATE, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD, FK_GLCAT_CAT_ID, CAT_NAME
						FROM ETO_GENERATION_RPT
						$condition
					) A
					GROUP BY POSTDATE 
					ORDER BY POSTDATE ";
				}
			}
			else
			{
				if($rprtfrnq == 3) #monthly
				{
				$sql .= "
					SELECT  
						GLCAT_GRP_ID, GLCAT_GRP_NAME FK_GL_MODULE_ID, 
						POSTMON, POSTMON_NAME POSTEDON, 
						SUM(GENERATED) GENERATED, 
						SUM(APPROVED) APPROVED, 
						SUM(WAITING) WAITING, 
						SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
						SUM(UNSOLD) UNSOLD,
						SUM(SOLD) SOLD, 
						SUM(TOT_CRD_USED) TOT_CRD_USED, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
					FROM (
						SELECT TO_CHAR(POSTDATE,'YY-MM') POSTMON, TO_CHAR(POSTDATE,'MON-YY') POSTMON_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD, FK_GLCAT_CAT_ID, CAT_NAME
						FROM ETO_GENERATION_RPT
						$condition
					) A, GLCAT_GRP_TO_CAT, GLCAT_GRP 
					WHERE A.FK_GLCAT_CAT_ID = GLCAT_GRP_TO_CAT.FK_GLCAT_CAT_ID 
					AND GLCAT_GRP_TO_CAT.FK_GLCAT_GRP_ID=GLCAT_GRP.GLCAT_GRP_ID
					GROUP BY GLCAT_GRP_ID, GLCAT_GRP_NAME, POSTMON, POSTMON_NAME 
					ORDER BY GLCAT_GRP_NAME, POSTMON ";
				}
				elseif($rprtfrnq == 2) #weekly
				{
				$sql .= "
					SELECT  
						GLCAT_GRP_ID, GLCAT_GRP_NAME FK_GL_MODULE_ID, POSTWEEK, 'Week' || POSTWEEK_NAME POSTEDON, 
						SUM(GENERATED) GENERATED, 
						SUM(APPROVED) APPROVED, 
						SUM(WAITING) WAITING, 
						SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
						SUM(UNSOLD) UNSOLD,
						SUM(SOLD) SOLD, 
						SUM(TOT_CRD_USED) TOT_CRD_USED, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
					FROM (
						SELECT TO_CHAR(POSTDATE,'YY-IW') POSTWEEK, TO_CHAR(POSTDATE,'IW-YY') POSTWEEK_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD, FK_GLCAT_CAT_ID, CAT_NAME
						FROM ETO_GENERATION_RPT
						$condition
					) A, GLCAT_GRP_TO_CAT, GLCAT_GRP 
					WHERE A.FK_GLCAT_CAT_ID = GLCAT_GRP_TO_CAT.FK_GLCAT_CAT_ID 
					AND GLCAT_GRP_TO_CAT.FK_GLCAT_GRP_ID=GLCAT_GRP.GLCAT_GRP_ID
					GROUP BY GLCAT_GRP_ID, GLCAT_GRP_NAME, POSTWEEK, POSTWEEK_NAME 
					ORDER BY GLCAT_GRP_NAME, POSTWEEK ";
				}
				else
				{
				$sql .= "
					SELECT  
						GLCAT_GRP_ID,
						GLCAT_GRP_NAME FK_GL_MODULE_ID, 
						POSTDATE POSTEDON, 
						SUM(GENERATED) GENERATED, 
						SUM(APPROVED) APPROVED, 
						SUM(WAITING) WAITING, 
						SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
						SUM(UNSOLD) UNSOLD,
						SUM(SOLD) SOLD, 
						SUM(TOT_CRD_USED) TOT_CRD_USED, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
						SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
						SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
						SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
						SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
						SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
						SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
						SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
						SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
						SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
						SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
						SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
						SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
					FROM (
						SELECT POSTDATE, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD, FK_GLCAT_CAT_ID, CAT_NAME
						FROM ETO_GENERATION_RPT
						$condition
					) A, GLCAT_GRP_TO_CAT, GLCAT_GRP 
					WHERE A.FK_GLCAT_CAT_ID = GLCAT_GRP_TO_CAT.FK_GLCAT_CAT_ID 
					AND GLCAT_GRP_TO_CAT.FK_GLCAT_GRP_ID=GLCAT_GRP.GLCAT_GRP_ID
					GROUP BY GLCAT_GRP_ID, GLCAT_GRP_NAME, POSTDATE 
					ORDER BY GLCAT_GRP_NAME, POSTDATE ";
				}
			}
			
		}
		else
		{
			if($rprtfrnq == 3) #monthly
			{
			$sql .= "
				SELECT  
					FK_GL_MODULE_ID, POSTMON, POSTMON_NAME POSTEDON, 
					SUM(GENERATED) GENERATED, 
					SUM(APPROVED) APPROVED, 
					SUM(WAITING) WAITING, 
					SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
					SUM(UNSOLD) UNSOLD,
					SUM(SOLD) SOLD, 
					SUM(TOT_CRD_USED) TOT_CRD_USED, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
				FROM (
					SELECT TO_CHAR(POSTDATE,'YY-MM') POSTMON, TO_CHAR(POSTDATE,'MON-YY') POSTMON_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD
					FROM ETO_GENERATION_RPT
					$condition
				)
				GROUP BY FK_GL_MODULE_ID, POSTMON, POSTMON_NAME 
				ORDER BY FK_GL_MODULE_ID, POSTMON ";
			}
			elseif($rprtfrnq == 2) #weekly
			{
			$sql .= "
				SELECT  
					FK_GL_MODULE_ID, POSTWEEK, 'Week' || POSTWEEK_NAME POSTEDON, 
					SUM(GENERATED) GENERATED, 
					SUM(APPROVED) APPROVED, 
					SUM(WAITING) WAITING, 
					SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
					SUM(UNSOLD) UNSOLD,
					SUM(SOLD) SOLD, 
					SUM(TOT_CRD_USED) TOT_CRD_USED, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
				FROM (
					SELECT TO_CHAR(POSTDATE,'YY-IW') POSTWEEK, TO_CHAR(POSTDATE,'IW-YY') POSTWEEK_NAME, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD
					FROM ETO_GENERATION_RPT
					$condition
				)
				GROUP BY FK_GL_MODULE_ID, POSTWEEK, POSTWEEK_NAME 
				ORDER BY FK_GL_MODULE_ID, POSTWEEK ";
			}
			else
			{
			$sql .= "
				SELECT  
					FK_GL_MODULE_ID, POSTDATE POSTEDON, 
					SUM(GENERATED) GENERATED, 
					SUM(APPROVED) APPROVED, 
					SUM(WAITING) WAITING, 
					SUM(TOT_SOLD_TIMES) TOT_SOLD_TIMES, 
					SUM(UNSOLD) UNSOLD,
					SUM(SOLD) SOLD, 
					SUM(TOT_CRD_USED) TOT_CRD_USED, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',GENERATED,0)) GENERATED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',APPROVED,0)) APPROVED_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',WAITING,0)) WAITING_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',UNSOLD,0)) UNSOLD_A,
					SUM(DECODE(ETO_OFR_QUALITY,'A',SOLD,0)) SOLD_A, 
					SUM(DECODE(ETO_OFR_QUALITY,'A',TOT_CRD_USED,0)) TOT_CRD_USED_A,
					SUM(DECODE(ETO_OFR_QUALITY,'B',GENERATED,0)) GENERATED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',APPROVED,0)) APPROVED_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',WAITING,0)) WAITING_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',UNSOLD,0)) UNSOLD_B,
					SUM(DECODE(ETO_OFR_QUALITY,'B',SOLD,0)) SOLD_B, 
					SUM(DECODE(ETO_OFR_QUALITY,'B',TOT_CRD_USED,0)) TOT_CRD_USED_B,
					SUM(DECODE(ETO_OFR_QUALITY,'C',GENERATED,0)) GENERATED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',APPROVED,0)) APPROVED_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',WAITING,0)) WAITING_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',UNSOLD,0)) UNSOLD_C,
					SUM(DECODE(ETO_OFR_QUALITY,'C',SOLD,0)) SOLD_C, 
					SUM(DECODE(ETO_OFR_QUALITY,'C',TOT_CRD_USED,0)) TOT_CRD_USED_C,
					SUM(DECODE(ETO_OFR_QUALITY,'D',GENERATED,0)) GENERATED_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',APPROVED,0)) APPROVED_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',WAITING,0)) WAITING_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',UNSOLD,0)) UNSOLD_D,
					SUM(DECODE(ETO_OFR_QUALITY,'D',SOLD,0)) SOLD_D, 
					SUM(DECODE(ETO_OFR_QUALITY,'D',TOT_CRD_USED,0)) TOT_CRD_USED_D,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',GENERATED,0)) GENERATED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',APPROVED,0)) APPROVED_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',WAITING,0)) WAITING_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_SOLD_TIMES,0)) TOT_SOLD_TIMES_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',UNSOLD,0)) UNSOLD_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',SOLD,0)) SOLD_IN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',TOT_CRD_USED,0)) TOT_CRD_USED_IN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,GENERATED)) GENERATED_FRN,
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,APPROVED)) APPROVED_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,WAITING)) WAITING_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_SOLD_TIMES)) TOT_SOLD_TIMES_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,UNSOLD)) UNSOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,SOLD)) SOLD_FRN, 
					SUM(DECODE(FK_GL_COUNTRY_ISO,'IN',0,TOT_CRD_USED)) TOT_CRD_USED_FRN
				FROM (
					SELECT POSTDATE, FK_GL_MODULE_ID, PAGE_REFERRER, FK_GL_COUNTRY_ISO, ETO_OFR_QUALITY, GENERATED, APPROVED, WAITING, TOT_SOLD_TIMES, SOLD, TOT_CRD_USED, UNSOLD
					FROM ETO_GENERATION_RPT
					$condition
				)
				GROUP BY FK_GL_MODULE_ID, POSTDATE 
				ORDER BY FK_GL_MODULE_ID, POSTDATE ";
			}
		}

		
		      $sth =oci_parse($dbh, $sql);
                
                      oci_execute($sth);
	              
		
		 $i = 0;
		 $prevModID = '';
		 $catID=0;
		 $grpID=0;
		 $approved = 0;
		 $generated = 0; 
		 $waiting = 0;
		 $tot_sold_times = 0; 
		 $sold = 0;
		 $unsold = 0;
		 $tot_crd_used = 0;
		 $approved_A = 0;
		 $generated_A = 0;
		 $waiting_A = 0;
		 $tot_sold_times_A = 0;
	         $sold_A = 0;
		 $unsold_A = 0;
		 $tot_crd_used_A = 0;
		 $approved_B = 0;
		 $generated_B = 0;
		 $waiting_B = 0;
		 $tot_sold_times_B = 0;
		 $sold_B = 0;
		 $unsold_B = 0;
		 $tot_crd_used_B = 0;
		 $approved_C = 0;
		 $generated_C = 0;
		 $waiting_C = 0;
		 $tot_sold_times_C = 0;
		 $sold_C = 0;
		 $unsold_C = 0;
		 $tot_crd_used_C = 0;
		 $approved_D = 0;
		 $generated_D = 0;
		 $waiting_D = 0;
		 $tot_sold_times_D = 0;
		 $sold_D = 0;
		 $unsold_D = 0;
		 $tot_crd_used_D = 0;
		 $approved_IN = 0;
		 $generated_IN = 0;
		 $waiting_IN = 0;
		 $tot_sold_times_IN = 0;
		 $sold_IN = 0;
		 $unsold_IN = 0;
		 $tot_crd_used_IN = 0;
		 $approved_FRN = 0;
		 $generated_FRN = 0;
		 $waiting_FRN = 0;
		 $tot_sold_times_FRN = 0;
		 $sold_FRN = 0;
		 $unsold_FRN = 0;
		 $tot_crd_used_FRN = 0;
		 $tableClass = '';
		
		while($rec = oci_fetch_array($sth,OCI_BOTH))
		{
			$i++;
			$tableClass=' CLASS="tab-table-new" ';
			if(isset($rec['FK_GL_MODULE_ID']))
			{
			if($prevModID != $rec['FK_GL_MODULE_ID'])
			{
				$tableClass='';
				
				if($i > 1)
				{
					echo '
					<TABLE WIDTH="'.$tableSize.'" BORDER="1" CELLPADDING="0" CELLSPACING="0" 
					STYLE="border-collapse:collapse;" BORDERCOLOR="#C5D0FD" CLASS="tab-table-new">
					<TR>
						<TD CLASS="a" WIDTH="70" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><B>Summary </B></DIV></TD>
						
						<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting.'</A>)</DIV></TD>
						<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times.' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used.'</DIV></TD>
						';
						if($secA)
						{
						echo '
						<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'A\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_A.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'A\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_A.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'A\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_A.'</A>)</DIV></TD>
						<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_A.' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'A\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_A.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'A\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_A.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_A.'</DIV></TD>
						';
						}
						if($secB)
						{
						echo '
						<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'B\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_B.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'B\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_B.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'B\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_B.'</A>)</DIV></TD>
						<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_B.' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'B\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_B.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'A\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_B.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_B.'</DIV></TD>
						';
						}
						if($secC)
						{
						echo '
						<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'C\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_C.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'C\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_C.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'C\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_C.'</A>)</DIV></TD>
						<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_C .'/ <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'C\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_C.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'C\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_C.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_C.'</DIV></TD>
						';
						}
						if($secD)
						{
						echo '
						<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'D\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_D.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'D\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_D.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'D\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_D.'</A>)</DIV></TD>
						<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_D.' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'D\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_D.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'D\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_D.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_D.'</DIV></TD>
						';
						}
						if($secIN)
						{
						echo '
						<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'IN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_IN.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'\',\'IN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_IN.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'\',\'IN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_IN.'</A>)</DIV></TD>
						<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_IN.' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'IN\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_IN.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'IN\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_IN.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_IN.'</DIV></TD>
						';
						}
						if($secFRN)
						{
						echo '
						<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'FRN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_FRN.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'\',\'FRN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_FRN.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'\',\'FRN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_FRN.'</A>)</DIV></TD>
						<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_FRN.' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'FRN\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_FRN.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'FRN\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_FRN.'</A></DIV></TD>
						<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_FRN.'</DIV></TD>
						';
						}
						
						echo '
					</TR>
					</TABLE>
					';
				
					$approved = 0;
					$generated = 0; 
					$waiting = 0;
					$tot_sold_times = 0; 
					$sold = 0;
					$unsold = 0;
					$tot_crd_used = 0;
					
					$approved_A = 0;
					$generated_A = 0;
					$waiting_A = 0;
					$tot_sold_times_A = 0;
					$sold_A = 0;
					$unsold_A = 0;
					$tot_crd_used_A = 0;
					
					$approved_B = 0;
					$generated_B = 0;
					$waiting_B = 0;
					$tot_sold_times_B = 0;
					$sold_B = 0;
					$unsold_B = 0;
					$tot_crd_used_B = 0;
					
					$approved_C = 0;
					$generated_C = 0;
					$waiting_C = 0;
					$tot_sold_times_C = 0;
					$sold_C = 0;
					$unsold_C = 0;
					$tot_crd_used_C = 0;
					
					$approved_D = 0;
					$generated_D = 0;
					$waiting_D = 0;
					$tot_sold_times_D = 0;
					$sold_D = 0;
					$unsold_D = 0;
					$tot_crd_used_D = 0;
					
					$approved_IN = 0;
					$generated_IN = 0;
					$waiting_IN = 0;
					$tot_sold_times_IN = 0;
					$sold_IN = 0;
					$unsold_IN = 0;
					$tot_crd_used_IN = 0;
					
					$approved_FRN = 0;
					$generated_FRN = 0;
					$waiting_FRN = 0;
					$tot_sold_times_FRN = 0;
					$sold_FRN = 0;
					$unsold_FRN = 0;
					$tot_crd_used_FRN = 0;
				}
			
			echo '
			<DIV CLASS="tab-head"><BR>'.$rec['FK_GL_MODULE_ID'].'</DIV>';
			}
			}
			if(isset($rec['FK_GL_MODULE_ID']))
			{
			$prevModID=$rec['FK_GL_MODULE_ID'];
			}
			else
			{
			$prevModID='';
			}
			if(isset($rec['FK_GLCAT_CAT_ID']))
			{
			$catID=$rec['FK_GLCAT_CAT_ID'];
			}
			else{
			$catID=0;
			}
			if(isset($rec['GLCAT_GRP_ID']))
			{
			$grpID=$rec['GLCAT_GRP_ID'];
			}
			else{
			$grpID=0;
			}
			if($rprtType == 1)
			{
			
                         if(isset($rec['FK_GL_MODULE_ID']))
                         {
                         $temp11=$rec['FK_GL_MODULE_ID'];
                         }
                         else{
                         $temp11='';
                         }
                         
				echo '
				<TABLE WIDTH="'.$tableSize.'" BORDER="1" CELLPADDING="0" CELLSPACING="0" 
				STYLE="border-collapse:collapse;" BORDERCOLOR="#C5D0FD" '.$tableClass.'>
				<TR>
					<TD CLASS="a" WIDTH="70"><DIV CLASS="tab1">'.$rec['POSTEDON'].'</DIV></TD>
					<TD WIDTH="80" BGCOLOR="#F6F7F8">
					<DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['APPROVED'].'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'\',\'\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['GENERATED'].'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'W\',\'\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['WAITING'].'</A>)</DIV></TD>
					<TD WIDTH="65" BGCOLOR="#F6F7F8"><DIV CLASS="tab1">'.$rec['TOT_SOLD_TIMES'].' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['SOLD'].'</A></DIV></TD>
					<TD WIDTH="55" BGCOLOR="#F6F7F8"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['UNSOLD'].'</A></DIV></TD>
					<TD WIDTH="55" BGCOLOR="#F6F7F8"><DIV CLASS="tab1">'.$rec['TOT_CRD_USED'].'</DIV></TD>
					';
					if($secA)
					{
					if(isset($rec['FK_GL_MODULE_ID']))
                         {
                         $temp11=$rec['FK_GL_MODULE_ID'];
                         }
                         else{
                         $temp11='';
                         }
					
					echo '
					<TD WIDTH="80">
					<DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'A\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['APPROVED_A'].'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'\',\'A\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['GENERATED_A'].'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'W\',\'A\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['WAITING_A'].'</A>)</DIV></TD>
					<TD WIDTH="65"><DIV CLASS="tab1">'.$rec['TOT_SOLD_TIMES_A'].' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'A\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['SOLD_A'].'</A></DIV></TD>
					<TD WIDTH="55"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'A\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['UNSOLD_A'].'</A></DIV></TD>
					<TD WIDTH="55"><DIV CLASS="tab1">'.$rec['TOT_CRD_USED_A'].'</DIV></TD>
					';
					}
					if($secB)
					{
					if(isset($rec['FK_GL_MODULE_ID']))
                         {
                         $temp11=$rec['FK_GL_MODULE_ID'];
                         }
                         else{
                         $temp11='';
                         }
					echo '
					<TD WIDTH="80" BGCOLOR="#F6F7F8">
					<DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'B\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['APPROVED_B'].'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'\',\'B\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['GENERATED_B'].'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'W\',\'B\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['WAITING_B'].'</A>)</DIV></TD>
					<TD WIDTH="65" BGCOLOR="#F6F7F8"><DIV CLASS="tab1">'.$rec['TOT_SOLD_TIMES_B'].' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'B\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['SOLD_B'].'</A></DIV></TD>
					<TD WIDTH="55" BGCOLOR="#F6F7F8"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'B\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['UNSOLD_B'].'</A></DIV></TD>
					<TD CLASS="tab1" WIDTH="55" BGCOLOR="#F6F7F8"><DIV CLASS="tab1">'.$rec['TOT_CRD_USED_B'].'</DIV></TD>
					';
					}
					if($secC)
					{
					if(isset($rec['FK_GL_MODULE_ID']))
                         {
                         $temp11=$rec['FK_GL_MODULE_ID'];
                         }
                         else{
                         $temp11='';
                         }
					echo '
					<TD WIDTH="80">
					<DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'C\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['APPROVED_C'].'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'\',\'C\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['GENERATED_C'].'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'W\',\'C\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['WAITING_C'].'</A>)</DIV></TD>
					<TD WIDTH="65"><DIV CLASS="tab1">'.$rec['TOT_SOLD_TIMES_C'].' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'C\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['SOLD_C'].'</A></DIV></TD>
					<TD WIDTH="55"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'C\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['UNSOLD_C'].'</A></DIV></TD>
					<TD WIDTH="55"><DIV CLASS="tab1">'.$rec['TOT_CRD_USED_C'].'</DIV></TD>
					';
					}
					if($secD)
					{
					if(isset($rec['FK_GL_MODULE_ID']))
                         {
                         $temp11=$rec['FK_GL_MODULE_ID'];
                         }
                         else{
                         $temp11='';
                         }
					echo '
					<TD WIDTH="80" BGCOLOR="#F6F7F8">
					<DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'D\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['APPROVED_D'].'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'\',\'D\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['GENERATED_D'].'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'W\',\'D\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['WAITING_D'].'</A>)</DIV></TD>
					<TD WIDTH="65" BGCOLOR="#F6F7F8"><DIV CLASS="tab1">'.$rec['TOT_SOLD_TIMES_D'].' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'D\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['SOLD_D'].'</A></DIV></TD>
					<TD WIDTH="55" BGCOLOR="#F6F7F8"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'D\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['UNSOLD_D'].'</A></DIV></TD>
					<TD WIDTH="55" BGCOLOR="#F6F7F8"><DIV CLASS="tab1">'.$rec['TOT_CRD_USED_D'].'</DIV></TD>
					';
					}
					if($secIN)
					{
					if(isset($rec['FK_GL_MODULE_ID']))
                         {
                         $temp11=$rec['FK_GL_MODULE_ID'];
                         }
                         else{
                         $temp11='';
                         }
					echo '
					<TD WIDTH="80">
					<DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'\',\'IN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['APPROVED_IN'].'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'\',\'\',\'IN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['GENERATED_IN'].'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'W\',\'\',\'IN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['WAITING_IN'].'</A>)</DIV></TD>
					<TD WIDTH="65"><DIV CLASS="tab1">'.$rec['TOT_SOLD_TIMES_IN'].' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'\',\'IN\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['SOLD_IN'].'</A></DIV></TD>
					<TD WIDTH="55"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'\',\'IN\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['UNSOLD_IN'].'</A></DIV></TD>
					<TD WIDTH="55"><DIV CLASS="tab1">'.$rec['TOT_CRD_USED_IN'].'</DIV></TD>
					';
					}
					if($secFRN)
					{
					if(isset($rec['FK_GL_MODULE_ID']))
                         {
                         $temp11=$rec['FK_GL_MODULE_ID'];
                         }
                         else{
                         $temp11='';
                         }
					echo '
					<TD WIDTH="80" BGCOLOR="#F6F7F8">
					<DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'\',\'FRN\',0,0,$catID,'.$grpID.','.$afl_id.')">'.$rec['APPROVED_FRN'].'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'\',\'\',\'FRN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['GENERATED_FRN'].'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'W\',\'\',\'FRN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['WAITING_FRN'].'</A>)</DIV></TD>
					<TD WIDTH="65" BGCOLOR="#F6F7F8"><DIV CLASS="tab1">'.$rec['TOT_SOLD_TIMES_FRN'].' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'\',\'FRN\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['SOLD_FRN'].'</A></DIV></TD>
					<TD WIDTH="55" BGCOLOR="#F6F7F8"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\''.$rec['POSTEDON'].'\',\''.$temp11.'\',\'A\',\'\',\'FRN\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$rec['UNSOLD_FRN'].'</A></DIV></TD>
					<TD WIDTH="55" BGCOLOR="#F6F7F8"><DIV CLASS="tab1">'.$rec['TOT_CRD_USED_FRN'].'</DIV></TD>
					';
					}
					echo '
				</TR>
				</TABLE>
				';

				
	}
	
			$approved = $approved + $rec['APPROVED'];
			$generated = $generated + $rec['GENERATED']; 
			$waiting = $waiting + $rec['WAITING'];
			$tot_sold_times = $tot_sold_times + $rec['TOT_SOLD_TIMES']; 
			$sold = $sold + $rec['SOLD'];
			$unsold = $unsold + $rec['UNSOLD'];
			$tot_crd_used = $tot_crd_used + $rec['TOT_CRD_USED'];
			
			$approved_A = $approved_A + $rec['APPROVED_A'];
			$generated_A = $generated_A + $rec['GENERATED_A'];
			$waiting_A = $waiting_A + $rec['WAITING_A'];
			$tot_sold_times_A = $tot_sold_times_A + $rec['TOT_SOLD_TIMES_A'];
			$sold_A = $sold_A + $rec['SOLD_A'];
			$unsold_A = $unsold_A + $rec['UNSOLD_A'];
			$tot_crd_used_A = $tot_crd_used_A + $rec['TOT_CRD_USED_A'];
			
			$approved_B = $approved_B + $rec['APPROVED_B'];
			$generated_B = $generated_B + $rec['GENERATED_B'];
			$waiting_B = $waiting_B + $rec['WAITING_B'];
			$tot_sold_times_B = $tot_sold_times_B + $rec['TOT_SOLD_TIMES_B'];
			$sold_B = $sold_B + $rec['SOLD_B'];
			$unsold_B = $unsold_B + $rec['UNSOLD_B'];
			$tot_crd_used_B = $tot_crd_used_B + $rec['TOT_CRD_USED_B'];
			
			$approved_C = $approved_C + $rec['APPROVED_C'];
			$generated_C = $generated_C + $rec['GENERATED_C'];
			$waiting_C = $waiting_C + $rec['WAITING_C'];
			$tot_sold_times_C = $tot_sold_times_C + $rec['TOT_SOLD_TIMES_C'];
			$sold_C = $sold_C + $rec['SOLD_C'];
			$unsold_C = $unsold_C + $rec['UNSOLD_C'];
			$tot_crd_used_C = $tot_crd_used_C + $rec['TOT_CRD_USED_C'];
			
			$approved_D = $approved_D + $rec['APPROVED_D'];
			$generated_D = $generated_D + $rec['GENERATED_D'];
			$waiting_D = $waiting_D + $rec['WAITING_D'];
			$tot_sold_times_D = $tot_sold_times_D + $rec['TOT_SOLD_TIMES_D'];
			$sold_D = $sold_D + $rec['SOLD_D'];
			$unsold_D = $unsold_D + $rec['UNSOLD_D'];
			$tot_crd_used_D = $tot_crd_used_D + $rec['TOT_CRD_USED_D'];
			
			$approved_IN = $approved_IN + $rec['APPROVED_IN'];
			$generated_IN = $generated_IN + $rec['GENERATED_IN'];
			$waiting_IN = $waiting_IN + $rec['WAITING_IN'];
			$tot_sold_times_IN = $tot_sold_times_IN + $rec['TOT_SOLD_TIMES_IN'];
			$sold_IN = $sold_IN + $rec['SOLD_IN'];
			$unsold_IN = $unsold_IN + $rec['UNSOLD_IN'];
			$tot_crd_used_IN = $tot_crd_used_IN + $rec['TOT_CRD_USED_IN'];
			
			$approved_FRN = $approved_FRN + $rec['APPROVED_FRN'];
			$generated_FRN = $generated_FRN + $rec['GENERATED_FRN'];
			$waiting_FRN = $waiting_FRN + $rec['WAITING_FRN'];
			$tot_sold_times_FRN = $tot_sold_times_FRN + $rec['TOT_SOLD_TIMES_FRN'];
			$sold_FRN = $sold_FRN + $rec['SOLD_FRN'];
			$unsold_FRN = $unsold_FRN + $rec['UNSOLD_FRN'];
			$tot_crd_used_FRN = $tot_crd_used_FRN + $rec['TOT_CRD_USED_FRN'];
		}
		
		if($i > 0)
		{
			echo '
			<TABLE WIDTH="'.$tableSize.'" BORDER="1" CELLPADDING="0" CELLSPACING="0" 
			STYLE="border-collapse:collapse;" BORDERCOLOR="#C5D0FD" CLASS="tab-table-new">
			<TR>
				<TD CLASS="a" WIDTH="70" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><B>Summary </B></DIV></TD>
				
				<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting.'</A>)</DIV></TD>
				<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times .'/ <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used.'</DIV></TD>
				';
				if($secA)
				{
				echo '
				<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\','.$prevModID.',\'A\',\'A\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_A.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\','.$prevModID.',\'\',\'A\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_A.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'A\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_A.'</A>)</DIV></TD>
				<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_A .'/ <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'A\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_A.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'A\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_A.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_A.'</DIV></TD>
				';
				}
				if($secB)
				{
				echo '
				<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'B\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_B.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'B\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_B.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'B\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_B.'</A>)</DIV></TD>
				<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_B.' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'B\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_B.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'A\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_B.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_B.'</DIV></TD>
				';
				}
				if($secC)
				{
				echo '
				<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'C\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_C.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'C\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_C.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'C\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_C.'</A>)</DIV></TD>
				<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_C .'/ <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'C\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_C.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'C\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_C.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_C.'</DIV></TD>
				';
				}
				if($secD)
				{
				echo '
				<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'D\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_D.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'D\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_D.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'D\',\'\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_D.'</A>)</DIV></TD>
				<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_D.' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'D\',\'\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_D.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'D\',\'\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_D.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_D.'</DIV></TD>
				';
				}
				if($secIN)
				{
				echo '
				<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'IN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_IN.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'\',\'IN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_IN.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'\',\'IN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_IN.'</A>)</DIV></TD>
				<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_IN .'/ <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'IN\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_IN.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'IN\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_IN.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_IN.'</DIV></TD>
				';
				}
				if($secFRN)
				{
				echo '
				<TD WIDTH="80" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'FRN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$approved_FRN.'</A> (<A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'\',\'\',\'FRN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$generated_FRN.'</A> - <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'W\',\'\',\'FRN\',0,0,'.$catID.','.$grpID.','.$afl_id.')">'.$waiting_FRN.'</A>)</DIV></TD>
				<TD WIDTH="65" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_sold_times_FRN.' / <A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'FRN\',0,1,'.$catID.','.$grpID.','.$afl_id.')">'.$sold_FRN.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1"><A HREF="javascript:void(0);" ONCLICK="setHiddenParams(\'\',\''.$prevModID.'\',\'A\',\'\',\'FRN\',1,0,'.$catID.','.$grpID.','.$afl_id.')">'.$unsold_FRN.'</A></DIV></TD>
				<TD WIDTH="55" BGCOLOR="#eaeaea"><DIV CLASS="tab1">'.$tot_crd_used_FRN.'</DIV></TD>
				';
				}
				echo '
			</TR>
			</TABLE>
			';
		
			$approved = 0;
			$generated = 0; 
			$waiting = 0;
			$tot_sold_times = 0; 
			$sold = 0;
			$unsold = 0;
			$tot_crd_used = 0;
			
			$approved_A = 0;
			$generated_A = 0;
			$waiting_A = 0;
			$tot_sold_times_A = 0;
			$sold_A = 0;
			$unsold_A = 0;
			$tot_crd_used_A = 0;
			
			$approved_B = 0;
			$generated_B = 0;
			$waiting_B = 0;
			$tot_sold_times_B = 0;
			$sold_B = 0;
			$unsold_B = 0;
			$tot_crd_used_B = 0;
			
			$approved_C = 0;
			$generated_C = 0;
			$waiting_C = 0;
			$tot_sold_times_C = 0;
			$sold_C = 0;
			$unsold_C = 0;
			$tot_crd_used_C = 0;
			
			$approved_D = 0;
			$generated_D = 0;
			$waiting_D = 0;
			$tot_sold_times_D = 0;
			$sold_D = 0;
			$unsold_D = 0;
			$tot_crd_used_D = 0;
			
			$approved_IN = 0;
			$generated_IN = 0;
			$waiting_IN = 0;
			$tot_sold_times_IN = 0;
			$sold_IN = 0;
			$unsold_IN = 0;
			$tot_crd_used_IN = 0;
			
			$approved_FRN = 0;
			$generated_FRN = 0;
			$waiting_FRN = 0;
			$tot_sold_times_FRN = 0;
			$sold_FRN = 0;
			$unsold_FRN = 0;
			$tot_crd_used_FRN = 0;
		}
		
		
		
		if($i == 0)
		{
			echo ' <DIV CLASS="tab-head"><br>No Record Found !</DIV> ';
		}		
	}
}







public function showGeneratedLeads($dbh,$rprtType,$rprtfrnq,$modidDrpDwn,$ofrApprovType,$ofrModid,$ofrQuality,$ofrIndianFrn,$postdate,$unsold,$sold,$indsitesUrl,$country,$countryExclude,$grpCatSrch,$catID,$grpID,$afl_id,$start_date,$end_date)
{
       
        
	 $errArr =array();
	 $flagError=0;
	
	 $date  = date($start_date);
  	 $date1 = date($end_date);

	if(!(defined($date)))
		{
			array_push($errArr,"Invalid Start Date");
// 			$flagError=1;
		}
	
		elseif(!(defined($date1)))
		{
			array_push($errArr,"Invalid End Date");
// 			$flagError=1;
		}
  	
	if ($flagError==1)
	{
	      
	      
	      $mesg = '';
		$mesg ='<TABLE BORDER="0" WIDTH="100%"><TR>
			<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#FF0000" size="2"><B>Following Error(s) Occured:<BR><BR>';
	        $errorCounter=0;
		foreach ($errArr as $x)
		{
			$errorCounter++;
			$mesg .=' Error '.$errorCounter.':'.$x.'<BR>';
		}
		$mesg .='<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT></TD>
			</TR></TABLE>';

	} 
	else 
	{
		
	
		echo '<STYLE TYPE="text/css">.admintext {font-family:ms sans serif,verdana; font-size:9px;font-weight:bold;line-height:17px;}
		.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}
		.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
	
		.m-row {width:100%;BORDER-COLLAPSE: collapse; FONT-FAMILY: arial,ms sans serif; COLOR: #000000;FONT-SIZE: 10px}
		.m-row A{COLOR: #0000ff}
		.m-row .td1{padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;}
		.m-row .td2{padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;}
		.m-row .td3{padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;}
		.m-row .td4{padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:5%;height:24px;}
		.m-row .td5{padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;}
		.m-row .td6{padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:15%;height:24px;}
		.m-row .td7{padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:15%;height:24px;}
		.m-row .td8{background:url("gifs/v-detail.gif") center center no-repeat;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;color:#0012FF;text-align:CENTER;}
		.m-row .td9{padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:15%;height:24px;}
		
		.m-row1 {width:100%;BORDER-COLLAPSE: collapse; FONT-FAMILY: ms sans serif,arial; COLOR: #000000;FONT-SIZE: 10px}
		.m-row1 A{COLOR: #0000ff}
		.m-row1 .td1{background:#FFFFAA;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;}
		.m-row1 .td2{background:#FFFFAA;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;}
		.m-row1 .td3{background:#FFFFAA;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;}
		.m-row1 .td4{background:#FFFFAA;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:5%;height:24px;}
		.m-row1 .td5{background:#FFFFAA;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;}
		.m-row1 .td6{background:#FFFFAA;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:15%;height:24px;}
		.m-row1 .td7{background:#FFFFAA;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:15%;height:24px;}
		.m-row1 .td8{background:url("gifs/hid-detail.gif") center center no-repeat;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:10%;height:24px;color:#0012FF;text-align:CENTER;}
		.m-row1 .td9{background:#FFFFAA;padding-left: 5px;border:1px #ddf0ff solid;border-bottom:none;width:15%;height:24px;}
	
		.tabl-n2{width:100%;BORDER-COLLAPSE: collapse;}
		.tabl-n2 A{COLOR: #0000ff}
		.tabl-n2 .bdr-left{border-left:1px #DDF0FF solid;border-right:1px #DDF0FF solid;}
		.tabl-n2 .td-bdr1{border-bottom:1px #ddf0ff solid;height:1px;}
		
		.tabl-n3{width:100%;margin-top:15px;FONT-FAMILY: arial,ms sans serif;COLOR: #000000;line-height:17px;}
		.tabl-n3 .block1{FONT-SIZE: 12px; border-right:1px #DDF0FF solid;padding-left:10px;padding-right:10px;}
		.tabl-n3 .block1 a{COLOR: #0000ff}
		.tabl-n3 .block1 .res{font-weight:bold; }
		.tabl-n3 .block1 .off{font-weight:bold; COLOR: #000000;}
		.tabl-n3 .block1 b{COLOR: #FF4800;FONT-SIZE: 14px;}
		.tabl-n3 .block2{padding-left:10px;padding-right:10px;FONT-SIZE: 13px}
		.tabl-n3 .block2 a{COLOR: #0000ff}
		.tabl-n3 .block2 b{COLOR: #000000;FONT-SIZE: 15px}
		.submenu { display:none; }
		.pt { float:right;font-size:15px;font-weight:bold; }
		</STYLE>
	
		<script language="javascript">
		<!--	
		function SwitchMenu2(obj)
		{
			var already_details = document.getElementById("offer_details").value;
			if(document.getElementById)
			{
				var el = document.getElementById(obj);
				var ar = document.getElementById("masterdiv").getElementsByTagName("div");
				if(el.style.display != "block")
				{
					if(already_details != 0)
					{
						document.getElementById("s"+already_details).style.display="none";
						document.getElementById("n"+already_details).className = "m-row";
					}
					el.style.display = "block";

					var obj1 = obj.split("s");
					document.getElementById("offer_details").value=obj1[1];
				}
				else
				{
					el.style.display = "none";
				}
			}
		}
		
		function bg(obj)
		{
			if(document.getElementById)
			{
				var el1 = document.getElementById(obj);
				var ar1 = document.getElementById("masterdiv").getElementsByTagName("div");
				if(el1.className != "m-row1")
				{ 
					el1.className = "m-row1";
				}
				else
				{
					el1.className = "m-row";
				}
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

		function pushToTop(obj,ofr)
		{
			var xmlHttp=ajaxFunction();
			if(xmlHttp)
			{
				xmlHttp.onreadystatechange=function()
				{
					if(xmlHttp.readyState==4)
					{
						var temp=xmlHttp.responseText;
						if(temp == 1) { temp = "Push to Top Successfully"; }
						else if(temp == 0) { temp = "Offer is Expired or not Exist"; }
						document.getElementById(obj).innerHTML = "<B style="color:red;">"+temp+"</font>";
					}
					else
					{
						document.getElementById(obj).innerHTML="<img src="gifs/indicator.gif">&nbsp;<B style="color:blue;">processing...</B>";
					}
				}
				var str="eto-push-to-top.mp?offer="+ofr+"&action=refresh";
				xmlHttp.open("GET",str,true);
				xmlHttp.send(null);
				return false;
			}
		}
		-->
		</script>';
	
		echo '<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" align = "center" width="100%">
		<TR>
			<TD HEIGHT="30" COLSPAN="4" ALIGN="CENTER" bgcolor="#eaeaea"
			STYLE="font-family:arial;font-size:14px;font-weight:bold;">Generated Buy Lead Details :- </TD>
		</TR>
		</TABLE>
	
		<DIV ID="masterdiv" STYLE="clear:both;">
		<TABLE BORDER="1" CELLPADDING="2" CELLSPACING="0" align="center" STYLE="border-collapse:collapse;" BORDERCOLOR="#C5D0FD" width="100%">
		<TR>
			<td class="admintext" align="center" bgcolor="#DEF2FE" width="10%"><B>Offer ID</B></TD>
			<td class="admintext" align="center" bgcolor="#DEF2FE" width="10%"><B>Orig Date</B></TD>
			<td class="admintext" align="center" bgcolor="#DEF2FE" width="10%"><B>Refresh Date</B></TD>
			<td class="admintext" align="center" bgcolor="#DEF2FE" width="5%"><B>Status</B></TD>
			<td class="admintext" align="center" bgcolor="#DEF2FE" width="10%"><B>Offer Gluser</B></TD>
			<td class="admintext" align="center" bgcolor="#DEF2FE" width="15%"><B>Offer Country</B></TD>
			<td class="admintext" align="center" bgcolor="#DEF2FE" width="15%"><B>Offer Category</B></TD>
			<td class="admintext" align="center" bgcolor="#DEF2FE" width="10%"><B>Enquiry Details</B></TD>
			<td class="admintext" align="center" bgcolor="#DEF2FE" width="15%"><B>Preferred Gluser</B></TD>
		</TR>
		</table>
		<input type="hidden" id="offer_details" value="0">';
		
		
	
		$bind = array();
		$condition = '';
		$conditionETO = '';
		$conditionETOexp = '';
		
		
		
		if($postdate != '')
		{
			if($rprtfrnq == 3) # In Monthly consider full month
			{      
			       
				$condition .= " AND TO_CHAR(ETO_OFR_POSTDATE_ORIG,'MON-YY') = :postdate ";
				$bind[':postdate']=$postdate;
			}
			elseif($rprtfrnq == 2)
			{       
			        
				$condition .= " AND 'Week' || TO_CHAR(ETO_OFR_POSTDATE_ORIG,'IW-YY') = :postdate ";
				$bind[':postdate']=$postdate;
			}
			else
			{      
			       
				$condition .= " AND TRUNC(ETO_OFR_POSTDATE_ORIG) = TRUNC(TO_DATE(:postdate,'dd-mon-yy')) ";
				$bind[':postdate']=$postdate;
			}
		}
		else
		{
			if($rprtfrnq == 3) # In Monthly consider full month
			{
				if ($start_date != '') 
				{
					$condition .= " AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:startdate,'dd-mm-yyyy'),'MONTH') ";
					$bind[':startdate']=$start_date;
				}
				if ($end_date != '') 
				{
					$condition .= " AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= LAST_DAY(TO_DATE(:enddate,'dd-mm-yyyy')) ";
					$bind[':enddate']=$end_date;
				}
			}
			else
			{
				if ($start_date != '') 
				{
					$condition .= " AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:startdate,'dd-mm-yyyy')) ";
					$bind[':startdate']=$start_date;
				}
				if ($end_date != '') 
				{
					$condition .= " AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:enddate,'dd-mm-yyyy')) ";
					$bind[':enddate']=$end_date;
				}
			}
		}
		
		if($modidDrpDwn && $modidDrpDwn == 'PDTPTL' && $ofrModid != 'PDTPTL')
		{
			if($ofrModid == '')
			{
				$condition .= " AND FK_GL_MODULE_ID = :modid ";
				$condition .= " AND FNS_EXTRACT_DOMAIN(ETO_OFR_PAGE_REFERRER) IS NULL ";
				$bind[':modid']=$modidDrpDwn;
			}
			else
			{
				$condition .= " AND FNS_EXTRACT_DOMAIN(ETO_OFR_PAGE_REFERRER) = :domainurl ";
				$bind[':domainurl']=$ofrModid;
			}
		}
		elseif($grpCatSrch)
		{
			if($catID)
			{
				$condition .=" AND FK_GLCAT_CAT_ID = :catid ";
				$bind[':catid']=$catID;
			}
			elseif($grpID)
			{
				$condition .= " AND FK_GLCAT_CAT_ID IN (SELECT FK_GLCAT_CAT_ID FROM GLCAT_GRP_TO_CAT WHERE FK_GLCAT_GRP_ID=:grpid) ";
				$bind[':grpid']=$grpID;
			}
		}
		else
		{
			if($ofrModid)
			{
				$condition .= " AND FK_GL_MODULE_ID = :modid ";
				$bind[':modid']=$ofrModid;
			}
		}
		
		if($ofrApprovType)
		{
			$condition .= " AND ETO_OFR_APPROV = :ofrapprov ";
			$bind[':ofrapprov']=$ofrApprovType;
		}
		if($ofrQuality)
		{
			$condition .=" AND ETO_OFR_QUALITY = :ofrquality ";
			$bind[':ofrquality']=$ofrQuality;
		}
		
		if($country)
		{
			if($countryExclude)
			{
				$conditionETO .= " AND ETO_OFR.FK_GL_COUNTRY_ISO <> :ofrcountry ";
				$conditionETOexp .=" AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO <> :ofrcountry ";
				$bind[':ofrcountry']=$country;
			}
			else
			{
				$conditionETO .= " AND ETO_OFR.FK_GL_COUNTRY_ISO = :ofrcountry ";
				$conditionETOexp .=" AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO = :ofrcountry ";
				$bind[':ofrcountry']=$country;
			}
		}
		else
		{
			if($ofrIndianFrn)
			{
				if($ofrIndianFrn == 'IN')
				{
					$conditionETO .= " AND ETO_OFR.FK_GL_COUNTRY_ISO = :ofrindianfrn ";
					$conditionETOexp .=" AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO = :ofrindianfrn ";
					$bind[':ofrindianfrn']=$ofrIndianFrn;
				}
				else # foreign
				{
					$conditionETO .=" AND ETO_OFR.FK_GL_COUNTRY_ISO <> 'IN' ";
					$conditionETOexp .=" AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO <> 'IN' ";
				}
			}
		}
		


		if($afl_id && $afl_id <=-1)
		{
			$condition .= " AND FK_ETO_AFL_ID = :afl_id ";
			$bind[':afl_id']=$afl_id;
		}

	        $sql = '';
		
		if($unsold || $sold)
		{
			if($unsold)
			{
				$condition .= " AND ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID(+) AND FK_ETO_OFR_ID IS NULL ";
			}
			else
			{
				$condition .= " AND ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID ";
			}
			
		$sql ="
		SELECT * 
		FROM (
			SELECT * 
			FROM ( 
				SELECT
					'Live' LIVESTATUS,
					ETO_OFR_DISPLAY_ID ETO_OFR_ID,
					ETO_OFR_POSTDATE_ORIG,
					TO_CHAR(ETO_OFR_POSTDATE_ORIG,'dd Mon yyyy') AS ORIG_DATE,
					TO_CHAR(ETO_OFR_DATE,'dd Mon yyyy') AS REFRESH_DATE,
					DECODE(ETO_OFR_APPROV,'W','Waiting','A','Approved') AS STATUS,
					NULL ETO_CREDITS,
					ETO_OFR_QUALITY,
					ETO_OFR_TITLE,
					ETO_OFR_DESC,
					TRIM(ETO_OFR_QTY) ETO_OFR_QTY,
					TRIM(ETO_OFR_PAY_TERM) ETO_OFR_PAY_TERM,
					TRIM(ETO_OFR_SUPPLY_TERM) ETO_OFR_SUPPLY_TERM,
					ETO_OFR_S_IP,
					ETO_OFR_S_IP_COUNTRY,
					DECODE(FK_GL_MODULE_ID,'ETO','https://trade.indiamart.com/','TSPBL', DECODE(ETO_OFR_MODREFID,NULL,NULL,ETO_OFR_MODREF_DISPNAME),ETO_OFR_PAGE_REFERRER) ETO_OFR_PAGE_REFERRER,
					NVL(GLCAT_CAT_NAME,'Undefined Category') GLCAT_CAT_NAME,
					GLUSR_USR_ID,
					(GLUSR_USR_SALUTE || ' ' || GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
					DECODE(LTRIM(GLUSR_USR_PH_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER)) GLUSR_PHONE,
					DECODE(LTRIM(GLUSR_USR_FAX_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_FAX_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_FAX_AREA, NULL, NULL,'(' || GLUSR_USR_FAX_AREA || ')' || '-') || GLUSR_USR_FAX_NUMBER)) GLUSR_FAX,
					GLUSR_USR_FAX_NUMBER GLUSR_USR_FAX_NUMBER,
					GLUSR_USR_PH_MOBILE GLUSR_MOBILE,
					NULL ETO_OFR_GLUSR_DISP_URL,
					LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY,
					LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
					LTRIM(GLUSR_USR_STATE) GLUSR_STATE,
					ETO_OFR_GL_COUNTRY_NAME GLUSR_COUNTRY,
					LTRIM(GLUSR_USR_ADD1) GLUSR_ADDRESS,
					GLUSR_USR_EMAIL,
					ETO_OFR_GL_COUNTRY_FLAG GL_COUNTRY_FLAG_SMALL,
					LTRIM(GLUSR_USR_DESIGNATION) GLUSR_DESIGNATION,
					GLUSR_USR_PH_MOBILE_ALT,
					GLUSR_USR_PH_COUNTRY,
					LTRIM(GLUSR_USR_ZIP) GLUSR_ZIP,
					FK_GL_MODULE_ID
				FROM 
					ETO_OFR, GLUSR_USR, GLCAT_CAT, ETO_LEAD_PUR_HIST 
				WHERE 
					ETO_OFR_TYP = 'B' 
					AND ETO_OFR_APPROV = 'A'
					AND GLUSR_USR_ID = ETO_OFR.FK_GLUSR_USR_ID
					AND ETO_OFR.FK_GLCAT_CAT_ID = GLCAT_CAT.GLCAT_CAT_ID(+)
					$condition 
					$conditionETO
				UNION 
				SELECT
					/*+ INDEX(ETO_OFR_EXPIRED ETO_OFR_EXP_TPOSTDATE) */
					'Expired' LIVESTATUS,
					ETO_OFR_DISPLAY_ID ETO_OFR_ID,
					ETO_OFR_POSTDATE_ORIG,
					TO_CHAR(ETO_OFR_POSTDATE_ORIG,'dd Mon yyyy') AS ORIG_DATE,
					TO_CHAR(ETO_OFR_DATE,'dd Mon yyyy') AS REFRESH_DATE,
					DECODE(ETO_OFR_APPROV,'W','Waiting','A','Approved') AS STATUS,
					NULL ETO_CREDITS,
					ETO_OFR_QUALITY,
					ETO_OFR_TITLE,
					ETO_OFR_DESC,
					TRIM(ETO_OFR_QTY) ETO_OFR_QTY,
					TRIM(ETO_OFR_PAY_TERM) ETO_OFR_PAY_TERM,
					TRIM(ETO_OFR_SUPPLY_TERM) ETO_OFR_SUPPLY_TERM,
					ETO_OFR_S_IP,
					ETO_OFR_S_IP_COUNTRY,
					DECODE(FK_GL_MODULE_ID,'ETO','https://trade.indiamart.com/','TSPBL', DECODE(ETO_OFR_MODREFID,NULL,NULL,ETO_OFR_MODREF_DISPNAME),ETO_OFR_PAGE_REFERRER) ETO_OFR_PAGE_REFERRER,
					NVL(GLCAT_CAT_NAME,'Undefined Category') GLCAT_CAT_NAME,
					GLUSR_USR_ID,
					(GLUSR_USR_SALUTE || ' ' || GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
					DECODE(LTRIM(GLUSR_USR_PH_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER)) GLUSR_PHONE,
					DECODE(LTRIM(GLUSR_USR_FAX_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_FAX_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_FAX_AREA, NULL, NULL,'(' || GLUSR_USR_FAX_AREA || ')' || '-') || GLUSR_USR_FAX_NUMBER)) GLUSR_FAX,
					GLUSR_USR_FAX_NUMBER GLUSR_USR_FAX_NUMBER,
					GLUSR_USR_PH_MOBILE GLUSR_MOBILE,
					NULL ETO_OFR_GLUSR_DISP_URL,
					LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY,
					LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
					LTRIM(GLUSR_USR_STATE) GLUSR_STATE,
					ETO_OFR_GL_COUNTRY_NAME GLUSR_COUNTRY,
					LTRIM(GLUSR_USR_ADD1) GLUSR_ADDRESS,
					GLUSR_USR_EMAIL,
					ETO_OFR_GL_COUNTRY_FLAG GL_COUNTRY_FLAG_SMALL,
					LTRIM(GLUSR_USR_DESIGNATION) GLUSR_DESIGNATION,
					GLUSR_USR_PH_MOBILE_ALT,
					GLUSR_USR_PH_COUNTRY,
					LTRIM(GLUSR_USR_ZIP) GLUSR_ZIP,
					FK_GL_MODULE_ID
				FROM 
					ETO_OFR_EXPIRED, GLUSR_USR, GLCAT_CAT, ETO_LEAD_PUR_HIST
				WHERE 
					ETO_OFR_TYP = 'B' 
					AND ETO_OFR_APPROV = 'A'
					AND GLUSR_USR_ID = ETO_OFR_EXPIRED.FK_GLUSR_USR_ID
					AND ETO_OFR_EXPIRED.FK_GLCAT_CAT_ID = GLCAT_CAT.GLCAT_CAT_ID(+)
					$condition 
					$conditionETOexp
			)
			ORDER BY ETO_OFR_POSTDATE_ORIG DESC 
		) 
		WHERE ROWNUM < 101 ";
		
		}
		else
		{
		$sql = "
		SELECT * 
		FROM (
			SELECT * 
			FROM (
				SELECT
					'Live' LIVESTATUS,
					ETO_OFR_DISPLAY_ID ETO_OFR_ID,
					ETO_OFR_POSTDATE_ORIG,
					TO_CHAR(ETO_OFR_POSTDATE_ORIG,'dd Mon yyyy') AS ORIG_DATE,
					TO_CHAR(ETO_OFR_DATE,'dd Mon yyyy') AS REFRESH_DATE,
					DECODE(ETO_OFR_APPROV,'W','Waiting','A','Approved') AS STATUS,
					NULL ETO_CREDITS,
					ETO_OFR_QUALITY,
					ETO_OFR_TITLE,
					ETO_OFR_DESC,
					TRIM(ETO_OFR_QTY) ETO_OFR_QTY,
					TRIM(ETO_OFR_PAY_TERM) ETO_OFR_PAY_TERM,
					TRIM(ETO_OFR_SUPPLY_TERM) ETO_OFR_SUPPLY_TERM,
					ETO_OFR_S_IP,
					ETO_OFR_S_IP_COUNTRY,
					DECODE(FK_GL_MODULE_ID,'ETO','https://trade.indiamart.com/','TSPBL', DECODE(ETO_OFR_MODREFID,NULL,NULL,ETO_OFR_MODREF_DISPNAME),ETO_OFR_PAGE_REFERRER) ETO_OFR_PAGE_REFERRER,
					NVL(GLCAT_CAT_NAME,'Undefined Category') GLCAT_CAT_NAME,
					GLUSR_USR_ID,
					(GLUSR_USR_SALUTE || ' ' || GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
					DECODE(LTRIM(GLUSR_USR_PH_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER)) GLUSR_PHONE,
					DECODE(LTRIM(GLUSR_USR_FAX_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_FAX_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_FAX_AREA, NULL, NULL,'(' || GLUSR_USR_FAX_AREA || ')' || '-') || GLUSR_USR_FAX_NUMBER)) GLUSR_FAX,
					GLUSR_USR_FAX_NUMBER GLUSR_USR_FAX_NUMBER,
					GLUSR_USR_PH_MOBILE GLUSR_MOBILE,
					NULL ETO_OFR_GLUSR_DISP_URL,
					LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY,
					LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
					LTRIM(GLUSR_USR_STATE) GLUSR_STATE,
					ETO_OFR_GL_COUNTRY_NAME GLUSR_COUNTRY,
					LTRIM(GLUSR_USR_ADD1) GLUSR_ADDRESS,
					GLUSR_USR_EMAIL,
					ETO_OFR_GL_COUNTRY_FLAG GL_COUNTRY_FLAG_SMALL,
					LTRIM(GLUSR_USR_DESIGNATION) GLUSR_DESIGNATION,
					GLUSR_USR_PH_MOBILE_ALT,
					GLUSR_USR_PH_COUNTRY,
					LTRIM(GLUSR_USR_ZIP) GLUSR_ZIP,
					FK_GL_MODULE_ID
				FROM 
					ETO_OFR, GLUSR_USR, GLCAT_CAT
				WHERE 
					ETO_OFR_TYP = 'B'
					AND GLUSR_USR_ID = ETO_OFR.FK_GLUSR_USR_ID
					AND ETO_OFR.FK_GLCAT_CAT_ID = GLCAT_CAT.GLCAT_CAT_ID(+)
					$condition 
					$conditionETO
				UNION 
				SELECT
					/*+ INDEX(ETO_OFR_EXPIRED ETO_OFR_EXP_TPOSTDATE) */
					'Expired' LIVESTATUS,
					ETO_OFR_DISPLAY_ID ETO_OFR_ID,
					ETO_OFR_POSTDATE_ORIG,
					TO_CHAR(ETO_OFR_POSTDATE_ORIG,'dd Mon yyyy') AS ORIG_DATE,
					TO_CHAR(ETO_OFR_DATE,'dd Mon yyyy') AS REFRESH_DATE,
					DECODE(ETO_OFR_APPROV,'W','Waiting','A','Approved') AS STATUS,
					NULL ETO_CREDITS,
					ETO_OFR_QUALITY,
					ETO_OFR_TITLE,
					ETO_OFR_DESC,
					TRIM(ETO_OFR_QTY) ETO_OFR_QTY,
					TRIM(ETO_OFR_PAY_TERM) ETO_OFR_PAY_TERM,
					TRIM(ETO_OFR_SUPPLY_TERM) ETO_OFR_SUPPLY_TERM,
					ETO_OFR_S_IP,
					ETO_OFR_S_IP_COUNTRY,
					DECODE(FK_GL_MODULE_ID,'ETO','https://trade.indiamart.com/','TSPBL', DECODE(ETO_OFR_MODREFID,NULL,NULL,ETO_OFR_MODREF_DISPNAME),ETO_OFR_PAGE_REFERRER) ETO_OFR_PAGE_REFERRER,
					NVL(GLCAT_CAT_NAME,'Undefined Category') GLCAT_CAT_NAME,
					GLUSR_USR_ID,
					(GLUSR_USR_SALUTE || ' ' || GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
					DECODE(LTRIM(GLUSR_USR_PH_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER)) GLUSR_PHONE,
					DECODE(LTRIM(GLUSR_USR_FAX_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_FAX_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_FAX_AREA, NULL, NULL,'(' || GLUSR_USR_FAX_AREA || ')' || '-') || GLUSR_USR_FAX_NUMBER)) GLUSR_FAX,
					GLUSR_USR_FAX_NUMBER GLUSR_USR_FAX_NUMBER,
					GLUSR_USR_PH_MOBILE GLUSR_MOBILE,
					NULL ETO_OFR_GLUSR_DISP_URL,
					LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY,
					LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
					LTRIM(GLUSR_USR_STATE) GLUSR_STATE,
					ETO_OFR_GL_COUNTRY_NAME GLUSR_COUNTRY,
					LTRIM(GLUSR_USR_ADD1) GLUSR_ADDRESS,
					GLUSR_USR_EMAIL,
					ETO_OFR_GL_COUNTRY_FLAG GL_COUNTRY_FLAG_SMALL,
					LTRIM(GLUSR_USR_DESIGNATION) GLUSR_DESIGNATION,
					GLUSR_USR_PH_MOBILE_ALT,
					GLUSR_USR_PH_COUNTRY,
					LTRIM(GLUSR_USR_ZIP) GLUSR_ZIP,
					FK_GL_MODULE_ID
				FROM 
					ETO_OFR_EXPIRED, GLUSR_USR, GLCAT_CAT
				WHERE 
					ETO_OFR_TYP = 'B'
					AND GLUSR_USR_ID = ETO_OFR_EXPIRED.FK_GLUSR_USR_ID
					AND ETO_OFR_EXPIRED.FK_GLCAT_CAT_ID = GLCAT_CAT.GLCAT_CAT_ID(+)
					$condition 
					$conditionETOexp 
			)
			ORDER BY ETO_OFR_POSTDATE_ORIG DESC 
		) 
		WHERE ROWNUM < 101 ";
		
		}
	
	
		  
	$sth=oci_parse($dbh,$sql);
	
	
	if($postdate != '')
		{
			if($rprtfrnq == 3) # In Monthly consider full month
			{      
			       
				oci_bind_by_name($sth,':postdate',$postdate);
			}
			elseif($rprtfrnq == 2)
			{       
			        
				oci_bind_by_name($sth,':postdate',$postdate);
			}
			else
			{      
			       
				oci_bind_by_name($sth,':postdate',$postdate);
			}
		}
		else
		{
			if($rprtfrnq == 3) # In Monthly consider full month
			{
				if ($start_date != '') 
				{
					oci_bind_by_name($sth,':startdate',$start_date);
				}
				if ($end_date != '') 
				{
					oci_bind_by_name($sth,':enddate',$end_date);
					
				}
			}
			else
			{
				if ($start_date != '') 
				{
					oci_bind_by_name($sth,':startdate',$start_date);
				}
				if ($end_date != '') 
				{
					oci_bind_by_name($sth,':enddate',$end_date);
				}
			}
		}
		
		if($modidDrpDwn && $modidDrpDwn == 'PDTPTL' && $ofrModid != 'PDTPTL')
		{
			if($ofrModid == '')
			{
				oci_bind_by_name($sth,':modid',$modidDrpDwn);
			}
			else
			{
				oci_bind_by_name($sth,':domainurl',$ofrModid);
			}
		}
		elseif($grpCatSrch)
		{
			if($catID)
			{
				oci_bind_by_name($sth,':catid',$catID);
			}
			elseif($grpID)
			{
				oci_bind_by_name($sth,':grpid',$grpID);
			}
		}
		else
		{
			if($ofrModid)
			{
				oci_bind_by_name($sth,':modid',$ofrModid);
			}
		}
		
		if($ofrApprovType)
		{
			oci_bind_by_name($sth,':ofrapprov',$ofrApprovType);
		}
		if($ofrQuality)
		{
			oci_bind_by_name($sth,':ofrquality',$ofrQuality);
		}
		
		if($country)
		{
			if($countryExclude)
			{
				oci_bind_by_name($sth,':ofrcountry',$country);
			}
			else
			{
				oci_bind_by_name($sth,':ofrcountry',$country);
			}
		}
		else
		{
			if($ofrIndianFrn)
			{
				if($ofrIndianFrn == 'IN')
				{
					oci_bind_by_name($sth,':ofrindianfrn',$ofrIndianFrn);
				}
				else # foreign
				{

				}
			}
		}
		


		if($afl_id && $afl_id <=-1)
		{
			oci_bind_by_name($sth,':afl_id',$afl_id);
		}
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		      
		
				
// 	 $sth = $this->ExecQuery(__CLASS__,__FILE__, __LINE__, $dbh, $sql,$bind );

         oci_execute($sth);

	       $i = 0;
		while ($rec = oci_fetch_array($sth)) 
		{
			$i++;
			
			$mainDesc = $rec['ETO_OFR_DESC'];
// 			$mainDesc = $this->removeUnwantedInfo($mainDesc);
			
			$mainDesc = preg_replace('/\n/', '<BR>\n',$mainDesc);
			$mainDesc = preg_replace('/\t/', '&nbsp;&nbsp;&nbsp;&nbsp;',$mainDesc);
			
			echo '
			<DIV ID="n'.$i.'">
			<TABLE BORDER="1" CELLPADDING="2" CELLSPACING="0" align = "center" width="100%" CLASS="m-row">
			<TR>
			<td CLASS="td1"><a href="index.php?r=admin_eto/AdminEto/editflaggedleads&offer='.$rec['ETO_OFR_ID'].'&go=Go&mid=3424" TARGET="_blank">'.$rec['ETO_OFR_ID'].' ('.$rec['LIVESTATUS'].')</a></TD>
			<td CLASS="td2">'.$rec['ORIG_DATE'].'</TD>
			<td CLASS="td3">'.$rec['REFRESH_DATE'].'</TD>
			<td CLASS="td4">'.$rec['STATUS'].'</TD>
			<td CLASS="td5">'.$rec['GLUSR_USR_ID'].'</TD>
			<td CLASS="td6">'.$rec['GLUSR_COUNTRY'].'</TD>
			<td CLASS="td7">'.$rec['GLCAT_CAT_NAME'].'</TD>
			<td CLASS="td8"><IMG SRC="gifs/zero.gif" WIDTH="76" HEIGHT="13" STYLE="cursor:pointer;" ONCLICK="SwitchMenu2("s'.$i.'");bg("n'.$i.'");">
			<td CLASS="td9"></TD>
			</table>
			</div>
	
			<div ID="s$i" class="submenu">
			<table class="tabl-n2" cellpadding="0" cellspacing="0">
			
			<TR>
			<TD CLASS="td-bdr1" WIDTH="87%"></TD>
			<TD HEIGHT="1" WIDTH="13%"></TD>
			</TR>
			<tr>
			<td colspan="2" class="bdr-left">
			
			<table class="tabl-n3" cellpadding="0" cellspacing="0">
				<tr>
				<td class="block1" valign="top">';

			if($rec['LIVESTATUS'] == 'Live')
			{
				echo '<div class="pt"><span id="push'.$i.'"><A href="javascript:void(0);" onclick="pushToTop("push'.$i.'",'.$rec['ETO_OFR_ID'].');">Push To Top</A></span></div>';
			}

			echo '<div><strong>Offer Title:</strong>
			'.$rec['ETO_OFR_TITLE'].'</div>
			<div><strong>Offer Details:</strong>
			'.$mainDesc.'</div>';
	
			if($rec['ETO_OFR_QTY'])
			{
				echo '<div><strong>Preferred Quantity:</strong> '.$rec['ETO_OFR_QTY'].'</div>';
			}
		
			if($rec['ETO_OFR_SUPPLY_TERM'])
			{
				echo '<div><strong>Delivery Terms:</strong> '.$rec['ETO_OFR_SUPPLY_TERM'].'</div>';
			}
		
			if($rec['ETO_OFR_PAY_TERM'])
			{
				echo '<div><strong>Payment Terms:</strong> '.$rec['ETO_OFR_PAY_TERM'].'</div>';
			}
	

			if($rec['ETO_OFR_PAGE_REFERRER'])
			{
				if($rec['FK_GL_MODULE_ID'] == 'TSPBL')
				{
					echo '<div><strong>Enquiry Source: </strong>'.$rec['ETO_OFR_PAGE_REFERRER'].'</div>';
				}
				else
				{
					echo '<div><strong>Enquiry Source: </strong><a href="'.$rec['ETO_OFR_PAGE_REFERRER'].'" target="_new">'.$rec['ETO_OFR_PAGE_REFERRER'].'</a></div>';
				}
			}
			echo '<BR>';
		
			if($rec['ETO_OFR_S_IP'])
			{
				echo '
				This enquiry has been generated through IP:-'. $rec['ETO_OFR_S_IP'];
				if($rec['ETO_OFR_S_IP_COUNTRY'] != 'NA')
				{
					echo '('.$rec['ETO_OFR_S_IP_COUNTRY'].')';
				}
				echo '<BR>';
			}
			echo '</td>

			<TD CLASS="block2" WIDTH="260" VALIGN="TOP">';
			if($rec['GLUSR_COMPANY'])
			{
				echo '<DIV><B>'.$rec['GLUSR_COMPANY'].'</B></DIV>';
			}
			
			echo '
			<DIV>Contact Person:'. $rec['GLUSR_NAME'];

			if($rec['GLUSR_DESIGNATION'])
			{
				echo ' ('.$rec['GLUSR_DESIGNATION'].')';
			}

			echo '</DIV>';

			if($rec['GLUSR_ADDRESS'])
			{
				echo '<DIV>Address:'. $rec['GLUSR_ADDRESS'].'</DIV>';
			}

			echo '<DIV>Location: ';
			if($rec['GLUSR_CITY'])
			{
				echo $rec['GLUSR_CITY'].',';
			}
			if($rec['GLUSR_STATE'])
			{
				echo $rec['GLUSR_STATE'].',';
			}

			echo $rec['GLUSR_COUNTRY'].'&nbsp;
			<IMG SRC="'.$rec['GL_COUNTRY_FLAG_SMALL'].'" WIDTH="26" HEIGHT="18"  ALIGN="ABSMIDDLE" ALT="'.$rec['GLUSR_COUNTRY'].'"></DIV>';

			if($rec['GLUSR_PHONE'])
			{
				echo '<DIV>Telephone: '.$rec['GLUSR_PHONE'].'</DIV>';
			}
			
			if($rec['GLUSR_USR_FAX_NUMBER'])
			{
				echo '<DIV>Fax: '.$rec['GLUSR_FAX'].'</DIV>';
			}

			if($rec['GLUSR_MOBILE'])
			{
				 $mobile = '+('.$rec['GLUSR_USR_PH_COUNTRY'].')-'.$rec['GLUSR_MOBILE'];
				if($rec['GLUSR_USR_PH_MOBILE_ALT'])
				{
					$mobile .= '/'.$rec['GLUSR_USR_PH_MOBILE_ALT'];
				}
				echo '<DIV>Mobile / Cell Phone:'. $mobile.'</DIV>';
			}

			if($rec['GLUSR_ZIP'])
			{
				echo '<DIV>Postal Code:'. $rec['GLUSR_ZIP'].'</DIV>';
			}

			 $limit = 30;
			 $url = isset($rec['ETO_OFR_GLUSR_DISP_URL']) ? $rec['ETO_OFR_GLUSR_DISP_URL'] : '';
			if($url)
			{	
				$count =strlen($url);
				if($count > $limit)
				{
					 $length1 = substr($url,0,$limit);
					 $length2 = substr($url,$limit,$count);
					 $url = "$length1 $length2";
				}
				echo '<DIV>Website: <A HREF="'.$rec['ETO_OFR_GLUSR_DISP_URL'].'" target="_new">'.$url.'</A></DIV>';
			}
			echo '<DIV>Email: '.$rec['GLUSR_USR_EMAIL'].'</DIV>
			<BR>
			</TD>

			</tr>
			</table>
			</td>
			</tr>
			<tr>
				<td colspan="2" background="gifs/bot-bg1.gif"><img src="gifs/bot-bgl.gif" align="left" border="0" height="19" hspace="0" width="12"><img src="gifs/bot-bgr.gif" align="right" border="0" height="19" hspace="0" width="12"></td>
			</tr>
	
			</table>
			</div>';
		}
		
		 $max100Text='';
		if($i == 100)
		{
			$max100Text='<FONT COLOR="#FF0000" SIZE="2">(Showing Latest 100 Offers at Maximum)</FONT>&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		echo '
		<TABLE BORDER="0" CELLPADDING="2" CELLSPACING="0" align = "center" width="100%">
		<TR>
		<TD CLASS="login" align="right" width="80%">
		'.$max100Text.'<FONT size="2"><B>Total Records - </B></font></a></div>
		</TD>
		<TD CLASS="login" align="center" width="80%">
		<FONT size="2"><B>'.$i.'</B></font></a></div>
		</TD>
	
		</TR>
		</TABLE></DIV>';

	}
}

public function ExecQuery($class_name, $file_name, $lineno, $dbh, $sql, $params)
    { 
    
      
        try
        {
            $command = oci_parse($dbh,$sql);
        }
        catch(Exception $e)
        {
            $MYMailSMS = new MYMailSMS;
            $errorMsg = $e->getMessage();
            $MYMailSMS->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle", $errorMsg, 0);
        }
        if($params)
         { 
         $value1='02-feb-16';
         $value2='a';
          oci_bind_by_name($command, ':postdate', $value1);
          oci_bind_by_name($command, ':ofrapprov', $value2);
//             foreach ($params as $key=>$value)
//             {   
// //                $key ="'$key'";
//              
//           oci_bind_by_name($command, "$key", $value);
//             }
           
         
        }   
        
        try
        {
            oci_execute($command);
        }
        catch(Exception $e)
        {
            $MYMailSMS = new MYMailSMS;
            $errorMsg = $e->getMessage();
            $MYMailSMS->print_oracle_error(__class__,__FILE__,__LINE__,"Cant run  the query on Oracle", "Cant run  the query on Oracle", $errorMsg, 0);
        }

        return $command;
    }


public function  GetCountry($dbh,$country)
{
    

	if(!$dbh) 
	{
	$glEtoModel = new AdminEtoModelForm();
          $dbh = $glEtoModel->connectImblrDb();
	if(!$dbh)
	{
          echo "Cant connect to database";
	 }
	}

	 $st = "SELECT * FROM GL_COUNTRY ORDER BY GL_COUNTRY_NAME";
	 $sth = oci_parse($dbh,$st);
	 oci_execute($sth);
	 $select ='';
	
		$select = '<SELECT  NAME="country" onChange="check_count_change();">';
		$select .= '<OPTION VALUE="0">---Choose One---</OPTION>';
		while ($h = oci_fetch_assoc($sth))
		{
		
			 $value = $h['GL_COUNTRY_ISO'];
			 $name = $h['GL_COUNTRY_NAME'];
			
			 
	        
	        
			 
			if($country == $value)
			{
				$select .= '<OPTION VALUE="'.$value.'" SELECTED>'.$name.'</OPTION>';
			}
			else
			{
				$select .= '<OPTION VALUE="'.$value.'">'.$name.'</OPTION>';
			}
		}
		
		$select .= '</SELECT>';
	
	return $select;
}

public function dropdown_menu_data($table_name,$display_column,$value_column,$criteria,$value,$order) 
{
 
     $return_value ='';
     $userDet='';
     $sql='';

    if ($table_name != '' && $display_column != '' && $value_column != '') 
    {
    	 $glEtoModel = new AdminEtoModelForm();
          $dbh = $glEtoModel->connectImblrDb();
	if(!preg_match('/^\s*$/',$criteria,$match1))
	{
		if (!$order) {
			$sql = "Select $display_column,$value_column from $table_name where $criteria";
	        } else {
			$sql = "Select $display_column,$value_column from $table_name where $criteria order by $order";
	        }
	} else {
		if (!$order) {
			$sql = "Select $display_column,$value_column from $table_name";
	        } else {
			$sql = "Select $display_column,$value_column from $table_name order by $order";
	        }
	}
	   $sth=oci_parse($dbh, $sql);
           oci_execute($sth);
	
	while ($userDet = oci_fetch_array($sth)) {
	      $return_value= $return_value.'<OPTION VALUE=\"'.$userDet[$value_column].'\""';
	      if ($value) {
	         if ($value != '' && $value == $userDet[$value_column]) {
	      		$return_value=$return_value." SELECTED ";
	      	 }
	      }
	      $return_value= $return_value.'>'.$userDet[$display_column].'</OPTION>\n';
	}

	return $return_value;
    }
	else {
    	return "Invalid arguments";
    }
}


public function removeUnwantedInfo($str)
{

	//$str =~ s/(<\s*a\b.*?\/\s*a\s*>)|(<\s*\/?\s*a\b.*?\s*>)//ig; # removing Anchor Tags
	$str = preg_replace('/(<\s*a\b.*?\/\s*a\s*>)|(<\s*\/?\s*a\b.*?\s*>)/i', '',$str);
	//$str =~ s/(<\s*img\b.*?\s*>)//ig; # removing IMG Tags
	$str = preg_replace('/(<\s*img\b.*?\s*>)/i', '',$str);
	//$str =~ s/(http|www)(.*?)(\s+?|$)//ig;
	$str = preg_replace('/(http|www)(.*?)(\s+?|$/i', '',$str);
	//$str =~ s/\b([\w\-\_\.]*?)(\@[\w\-\_\.]*?)(\s+?|$)//ig;
	$str = preg_replace('/\b([\w\-\_\.]*?)(\@[\w\-\_\.]*?)(\s+?|$)/i', '',$str);
	return ($str);
}  






}
?>
