<?php

	$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';

	
	if(!empty($_REQUEST['action']) && $_REQUEST['action'] == 'get_weekly_gen_rpt')
	{
	$start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
	}
	else
	{
	  $start_date= $end_date='';
	}
	
	$hostname=$_SERVER['SERVER_NAME'];
	$q = $_REQUEST;
	$fields = array('start_date','end_date','modid','client');
	$param=array();
	foreach ($fields as $key) 
	{
     		if (!empty($q[$key])) 
		{
        		$param[$key]=$q[$key];
     		} 
		else 
		{
        		$param[$key]='';
     		}
  	}

	list($curr_year,$curr_month,$curr_day)= preg_split('/-/',date('Y-m-d'));


?>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">    
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery-ui.min.js"></script>
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
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                success:function(result){                         
                               $('#result').html(result);                   
                            }
                        }); 
            }
);
}
)

	function checkBuyForm()
	{

            var start=new Date(document.searchForm.start_date.value);
            if(document.searchForm.start_date.value =='' || document.searchForm.end_date.value =='')
            { 
            alert("Kindly Select Start and End Date");
               return false;
            }
            
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
 
<?php	
echo "function ShowDemandData(req)
{
		var xmlHttp=ajaxFunction();
		var obj='demand_data'+req;
		var start_date=\"$start_date\";
		var end_date=\"$end_date\";
		document.getElementById('show_data'+req).style.display = \"none\";
		if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					var temp=xmlHttp.responseText;
					document.getElementById(obj).innerHTML =temp;
				}
				else
				{
					document.getElementById(obj).innerHTML='<img src=\"gifs/indicator.gif\">&nbsp;<B style=\"color:blue;\">In Process...</B>';
				}
			}
			var str='index.php?r=admin_bl/reports/blgendetaildemand/req/'+req+'/start_date/'+start_date+'/end_date/'+end_date;
			xmlHttp.open(\"GET\",str,true);
			xmlHttp.send(null);
			return false;
		}
}"
?>
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

</SCRIPT>
<FORM name="searchForm" METHOD="post"  STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();">
	<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1">
			  <tbody><tr>
			  <td colspan="4" bgcolor="#dff8ff" align="center"><font color=" #333399"><b>BL Generation Report</b></font>			 
			  </td>	
			  </tr>
			  <tr>
                              <td>Enter GL ID:</td><TD><INPUT NAME="report" TYPE="text" value="<?php echo isset($sbjVal)?$sbjVal:''; ?>" style="width:130px;"> </TD>	
			  <td width="20%">&nbsp;Enter Date:</td>
		<TD width="40%">
               <input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
		&nbsp;to&nbsp;
                <input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','from_date1')" id="end_date" TYPE="text" readonly="readonly">
		
	</TD>
        <TD ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
		<input type="hidden" name="step" value="1" id ="step">
		<input type="hidden" name="action" value="get_weekly_gen_rpt">
		<INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report">
		</TD>
	</TR>	
	</TABLE></FORM>
