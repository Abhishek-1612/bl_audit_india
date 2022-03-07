<HTML>
<?php $this->pageTitle=Yii::app()->name . ' - Retail User Listing'; 
      $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';

?>
		<HEAD>
		<script type="text/javascript">var NREUMQ=NREUMQ||[];NREUMQ.push(["mark","firstbyte",new Date().getTime()]);</script><LINK HREF="<?php echo$utilsHost?>/css/report.css" REL="STYLESHEET" TYPE="text/css">
		<script language="javascript" src="<?php echo$utilsHost?>/protected/modules/admin_query/js/enquiry-by-sender.js"></script>

		<script language="javascript">
		function Reset_form()
		{
			document.fcp_report.from_date.value = '';
			document.fcp_report.to_date.value = '';
			document.fcp_report.mod_id.value = '';
			document.fcp_report.searchstr.value = '';
			if(document.fcp_report.searchby.value =='email')
			{
				document.fcp_report.searchby.value = 'id';
			}
			if(document.fcp_report.query_status.value =='A')
			{
				document.fcp_report.query_status.value = 'ALL';
			}
			else if(document.fcp_report.query_status.value =='R')
			{
				document.fcp_report.query_status.value = 'ALL';
			}

		}
		
		function deleteEntry(glid,empid)
		{
		
		  
		  var del_id="delete_";
		  var temp_glid=glid.toString();
		  var final_del_id = del_id.concat(temp_glid);
		    var res= confirm("Are you sure you want to Delete this Record?");
		 if(res)
		  {
		  
 	$.ajax({
        type: "POST",
        url: "protected/modules/admin_bl/models/SaveGlidExclude.php",
        data: {glid : glid, empid : empid},
        success:function() {
   			   document.getElementById(final_del_id).value="DELETED";
  			   document.getElementById(final_del_id).disabled = true;
		      }
       
    });
		  }
		}
		</script>
		 <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"  media="screen">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"> 
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-2.1.4.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
        <style type="text/css">
        div.ui-datepicker  
       {
        font-size: 15px;
       }
	   </style> 
       <script>
       $(function(){
        $('#from_date1, #to_date1').datepicker({
         dateFormat: "dd-M-yy",
   	     changeYear: "true",
         changeMonth: "true",
         beforeShow: range
        });
        function range(input)
	    {
	     var min = new Date(1999, 11 - 1, 1), 
         dateMin = min,
         dateMax = null;
         if (input.id == "from_date1") {
         if ($("#to_date1").datepicker("getDate")!= null) {
	     dateMax = $("#from_date1").datepicker("getDate");
         dateMin = $("#to_date1").datepicker("getDate");
         dateMin.setDate(dateMin.getDate() - 1600);
         if (dateMin < min) {
          dateMin = min;
          }
	    }
        else {
            dateMax = new Date;
         }                      
         }
        else 
    	if (input.id == "to_date1") {
          dateMax = new Date; 
          if ($("#from_date1").datepicker("getDate")!= null) {
          dateMin = $("#from_date1").datepicker("getDate");
          var rangeMax = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() +1600);
          if(rangeMax < dateMax) {
              dateMax = rangeMax; 
            }
           }
         }
        return {
         minDate: dateMin, 
         maxDate: dateMax
           };
	     }  
	   });
     </script>
     <style type="text/css">
		body{background:#fff;padding:0px;margin:0px;font-family:arial;font-size:14px;line-height:20px;}
		#bfix{ position:inherit;}
		.top-slbox{font-size:14px;fon-family:arial;background:#eaf7ff;padding:10px;line-height:22px; margin:0px auto;}
		.top-slbox table tr td{font-size:13px; padding:4px;border:none!important;}
		select{font-size:13px;font-family:arial;line-height:20px;border:1px solid #bbc9d2;background:#fff;}
		.ssbtn{background:#136af8;border:1px solid #0751d1;color:#fff;padding:4px 10px;line-height:18px;font-size:20px;font-weight:700;font-family:Trebuchet Ms;border-radius:3px;cursor:pointer;}
		.data-list{}
		
		.data-list table tr td{font-size:13px; padding:4px;border:1px solid #d4d4d4; margin:0px;border-top:none;border-left:0px;}
		.gbgcolor{background:#f1f1f1!important}
		.wbgcolor{background:#ffffff !important}
		.rbdrtd{border-left:1px solid #d4d4d4!important;}
		.data-list table tr th{font-size:14px; padding:4px;border:1px solid #d4d4d4; margin:0px;border-left:0px;color:#fff; background:#267ddf;}
		
		
		
		
		
		
		.onlycssmenu-paging, .onlycssmenu-paging a, .onlycssmenu-paging span {
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
.onlycssmenu-paging {
height:20px;
line-height:20px;
margin:0;
padding:0;
}
.onlycssmenu-paging a, .onlycssmenu-paging span {
background:#edefea;
float:left;
padding:0 5px;
margin:0 1px;
border:solid 1px #d3d0c9;
color:#373f1e;
text-decoration:none;
}
.onlycssmenu-paging span {
background:#FFFFFF;
color:#636363;
}
.onlycssmenu-paging a:hover, .onlycssmenu-paging .active {
background:#FFFFFF;
color:#636363;
}
</style>
	</head><body>
<div align="center" style="width:100%; margin:0px auto;" class="data-list">
<div id="bfix">
<div class="top-slbox">
<form name="data" action="index.php?r=admin_bl/Report4/eto_cust_purchase_report" method="POST">
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td align="right"><strong style="margin-left:70px;">Start Date</strong> </td>
    <td><?php if(isset($data['from_date']))
    echo '<input name="from_date" type="text" VALUE="'.$data['from_date'].'" SIZE="10" id="from_date1" TYPE="text" readonly="readonly" required="required">';
    else
      {$date = new DateTime('now');
        $date1=$date->format('d-M-y');
      echo '<input name="from_date" type="text" VALUE="'.$date1.' " SIZE="10" id="from_date1" TYPE="text" readonly="readonly" required />'; 
       }
      ?>
    </td>
    <td align="right"><strong style="margin-left:0px;">End Date</strong> </td><td>
    <?php if(isset($data['to_date']))
    echo '<input name="to_date" type="text" VALUE="'.$data['to_date'].'" SIZE="10" id="to_date1" TYPE="text" readonly="readonly" required="required">';
   else 
   {   $date = new DateTime('now');
       $date2=$date->format('d-M-y');     
   echo '<input name="to_date" type="text" VALUE="'.$date2.' " SIZE="10" id="to_date1" TYPE="text" readonly="readonly" required />';
   }
   ?>
   <?php $mid=$data['mid'];
echo '<input type="hidden" name="mid" id="mid" value="'.$mid.'">';?>
    </td>
    <td rowspan="2" style="padding-left:10px;">
<input type="submit" value=" Submit " class="ssbtn" name="Get Data"></td>
 <td rowspan="2" style="padding-left:10px;"> <input type="reset" value=" Reset " class="ssbtn" name="Get Data1"></td>
  </tr>

</table>

</div>
</div>
</table></div>


<?php

    if(isset($data['rec']))
    {
        
 ///////////////
 
 ///////////////////

       
    echo '<div align="center" style="width:100%;" class="data-list">';
 echo '<a href="index.php?r=admin_bl/Report4/eto_cust_purchase_report/action/export_data/from_date/'.$data['from_date'].'/to_date/'.$data['to_date'].'/mid/'.$mid.'" style="float:left;color: rgb(0,0,166);
    font-weight: 700;
    border:solid 1px #d3d0c9;
    text-decoration: none"><b>Export To Excel</b></a>';
   if(isset($data['count']))
    {
     echo '<div class="onlycssmenu-paging clearfix" style="float:right">';          
           $x=ceil($data['count']/100);
          for($i=1;$i<=$x;$i++)
          {
            echo '<a href="index.php?r=admin_bl/Report4/eto_cust_purchase_report/from_date/'.$data['from_date'].'/to_date/'.$data['to_date'].'/mid/'.$mid.'/pg/'.$i.'">'.$i.'</a>';
          }
         echo '
         </div>';
        
    }

echo '</form><div id="bfix">

<div class="top-slbox"><Table width="99%" border="0" align="center" cellpadding="0" cellspacing="0"   style="table-layout:fixed;">

<TR>
		<!--<th>IIL_CR_COM_DECISION_ID</th>--><th width="6%">S.NO</th><th width="9%">ORDER ID</th><th width="9%">GL USER ID</th><th width="13%">PURCHASE DATE</th><th width="13%">PURCHASE CREDITS</th><th width="28%">EMAIL</th><th width="28%">Alternate EMAIL ID</th>
		<th width="12%">MOBILE NO.</th><th width="17%">COMPANY</th><th width="15%">PURCHASE CUSTTYPE</th><th width="10%">LISTING STATUS</th>
		<th width="11%">PRIORITY RANGE</th>
		<th width="10%"> </th></tr>
    </Table>
</div>
<Table width="99%" border="0" align="center" cellpadding="0" cellspacing="0"  style="table-layout:fixed;">';

      $value=$data['rec'];
	$cnt=1;
	$x=0;
	$emp_id=$data['emp_id'];
// 	echo"<pre>";
// 	$count_value=count($data);
// 	var_dump($count_value);
	
//  	print_r($value);
 	$size_value_array=count($value);
	/*
	 foreach($value as $key)
	{
	 foreach($key as $y)
	 { */
	 
	$glid_exclude='';
	 for($i=0;$i<$size_value_array;$i++)
	 {
	      $class=($cnt%2==0)?"gbgcolor":"wbgcolor";
	 echo '<tr><td width="6%" align="center" class="'.$class.'" style="border-left:1px solid #d4d4d4">'.$cnt.'</td>';
	if(isset($value[$x]["ETO_CUST_ORDER_ID"]) && $value[$x]["ETO_CUST_ORDER_ID"] != NULL)
	{    echo '<td width="9%" align="center" class="'.$class.'" style="border-left:1px solid #d4d4d4">'.$value[$x]["ETO_CUST_ORDER_ID"].'</td>';
	}
    else {
            echo '<td width="9%" align="center" class="'.$class.'" style="border-left:1px solid #d4d4d4"></td>';
          }
	if(isset($value[$x]["FK_GLUSR_USR_ID"]) && $value[$x]["FK_GLUSR_USR_ID"]!= NULL)
	{    echo '<td width="9%" align="center" class="'.$class.'" style="border-left:1px solid #d4d4d4">'.$value[$x]["FK_GLUSR_USR_ID"].'</td>';
	     $glid_exclude=$value[$x]["FK_GLUSR_USR_ID"]; 
	}
    else {
            echo '<td width="9%" align="center" class="'.$class.'" style="border-left:1px solid #d4d4d4"></td>';
          }
	if (isset($value[$x]['ETO_CUST_PURCHASE_DATE']) && $value[$x]['ETO_CUST_PURCHASE_DATE']!=NULL)
	{ echo '<td width="13%" align="center" class="'.$class.'" >'.$value[$x]['ETO_CUST_PURCHASE_DATE'].'</td>';
         }
        else
         {
         echo '<td width="13%" align="center" class="'.$class.'" ></td>';
         }
         if(isset($value[$x]['ETO_CUST_PURCHASE_CREDITS']) && $value[$x]['ETO_CUST_PURCHASE_CREDITS']!=NULL)
         {
         echo '<td width="13%" align="center" class="'.$class.'" >'.$value[$x]['ETO_CUST_PURCHASE_CREDITS'].'</td>';
         }
         else
         {echo '<td width="13%" align="center" class="'.$class.'" ></td>';
         }
         if(isset($value[$x]['GLUSR_USR_EMAIL']) && $value[$x]['GLUSR_USR_EMAIL']!=NULL)
         {
         echo '<td width="28%" align="center" class="'.$class.'" >'.$value[$x]['GLUSR_USR_EMAIL'].'</td>';
         }
         else
         {echo '<td width="28%" align="center" class="'.$class.'" ></td>';
         }
         if(isset($value[$x]['GLUSR_USR_EMAIL_ALT']) && $value[$x]['GLUSR_USR_EMAIL_ALT']!=NULL)
         {
         echo '<td width="28%" align="center" class="'.$class.'" >'.$value[$x]['GLUSR_USR_EMAIL_ALT'].'</td>';
         }
         else
         {echo '<td width="28%" align="center" class="'.$class.'" ></td>';
         }
         if(isset($value[$x]['GLUSR_USR_PH_MOBILE']) && $value[$x]['GLUSR_USR_PH_MOBILE']!=NULL)
         {
         echo '<td width="12%" align="center" class="'.$class.'" >'.$value[$x]['GLUSR_USR_PH_MOBILE'].'</td>';
         }
         else
         {echo '<td width="12%" align="center" class="'.$class.'" ></td>';
         }
         if(isset($value[$x]['ETO_CUST_GLUSR_ORGANIZATION']) && $value[$x]['ETO_CUST_GLUSR_ORGANIZATION']!=NULL)
         {
         echo '<td width="17%" align="center" class="'.$class.'" >'.$value[$x]['ETO_CUST_GLUSR_ORGANIZATION'].'</td>';
         }
         else
         {echo '<td width="17%" align="center" class="'.$class.'" ></td>';
         }
         
         if(isset($value[$x]['ETO_CUST_PURCHASE_CUSTTYPE']) && $value[$x]['ETO_CUST_PURCHASE_CUSTTYPE']!=NULL)
         {
         echo '<td width="15%" align="center" class="'.$class.'" >'.$value[$x]['ETO_CUST_PURCHASE_CUSTTYPE'].'</td>';
         }
         else
         {echo '<td width="15%" align="center" class="'.$class.'" ></td>';
         }
         if(isset($value[$x]['GLUSR_USR_LISTING_STATUS']) && $value[$x]['GLUSR_USR_LISTING_STATUS']!=NULL) 
         { echo '<td width="10%" align="center" class="'.$class.'" >'.$value[$x]['GLUSR_USR_LISTING_STATUS'].'</td>';
           }
          else {
          echo '<td width="10%" align="center" class="'.$class.'" ></td>';
          
          }
           if(isset($value[$x]['PRIORITY_RANGE']) && $value[$x]['PRIORITY_RANGE']!=NULL) 
         { echo '<td width="10%" align="center" class="'.$class.'" >'.$value[$x]['PRIORITY_RANGE'].'</td>';
           }
          else {
          echo '<td width="10%" align="center" class="'.$class.'" ></td>';
          
          }
$x++;
		$cnt++;
		$delete_id="delete_"."$glid_exclude";
		
	  echo '<td width="10%" align="center" class="'.$class.'" >
		  <input type="button" name="delete" id="'.$delete_id.'" value="Delete" onclick="deleteEntry('.$glid_exclude.','.$emp_id.')">
		</td>';
	}
	
     //echo $cnt;
	die;
	
	
		
    }
    echo '</div></div>';
    

    ?>



</body>
</html>
