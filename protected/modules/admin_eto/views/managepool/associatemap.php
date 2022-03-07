
	<style>
      .button1 {
cursor: pointer;
-webkit-appearance: button;
background-color: #009DCC;
font-weight: bold;
height: 25px;
width: 80px;
border: 1px solid #CCCCCC;
color: #FFFFFF;
text-align: center;
} 
	</style>
	<script type = "text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript">
	
	
$(window).bind("load", function() {
	    var pool1=document.getElementById("pool1").value;
	    var pool2=document.getElementById("pool2").value;
	    var pool3=document.getElementById("pool3").value;
	    var pool4=document.getElementById("pool4").value;
	    
	    var region1=document.getElementById("region1").value;
	    var region2=document.getElementById("region2").value;
	    var region3=document.getElementById("region3").value;
	    var region4=document.getElementById("region4").value;
	    
	    if(pool1 != '' || region1 != '')
	    {
	    document.getElementById("row1").value=pool1+','+region1;
	    }
	    if(pool2 != '' || region2 != '')
	    {
	    document.getElementById("row2").value=pool2+','+region2;
	    }
	    if(pool3 != '' || region3 != '')
	    {
	    document.getElementById("row3").value=pool3+','+region3;
	    }
	    if(pool4 != '' || region4 != '')
	    {
	    document.getElementById("row4").value=pool4+','+region4;
	    }
	
 });
	
	function checkFields()
	{
	
	if(document.getElementById("pool1").value =='' && document.getElementById("pool2").value =='' && document.getElementById("pool3").value =='' && document.getElementById("pool4").value =='' && document.getElementById("region1").value =='' && document.getElementById("region2").value =='' && document.getElementById("region3").value ==''  && document.getElementById("region4").value =='')
	{
	alert("Please Select Atleast One Pool OR One Region");
	return false;
	}
	
	
	for(i=1;i<=4;i++)
	{
// 	if(document.getElementById("pool"+i).value !='' && document.getElementById("region"+i).value =='')
// 	{
// 	alert("Please select Region of selected Pool");
// 	document.getElementById("region"+i).focus();
// 	return false;
// 	}
      if(document.getElementById("priorty"+i).value !='' && (document.getElementById("pool"+i).value =='' && document.getElementById("region"+i).value ==''))
	{
	alert("Please Select Pool OR  Region of selected Priorty");
 	document.getElementById("priorty"+i).focus();
 	return false;
 	}
	if((document.getElementById("pool"+i).value !='' || document.getElementById("region"+i).value !='') && document.getElementById("priorty"+i).value =='')
	{
	alert("Please Select Priorty of selected Pool and Region");
	document.getElementById("priorty"+i).focus();
	return false;
	}
	
	
	}
	if(document.getElementById("duplicate_check").innerHTML =='<b style="color:red;">Duplicate field selected</b>')
	{
	alert("Duplicate field selected");
	return false;
	}
	
	var pool1=document.getElementById("pool1").value;
        var pool2=document.getElementById("pool2").value;
        var pool3=document.getElementById("pool3").value;
        var pool4=document.getElementById("pool4").value;
        
        var region1=document.getElementById("region1").value;
        var region2=document.getElementById("region2").value;
        var region3=document.getElementById("region3").value;
        var region4=document.getElementById("region4").value;
        
        if(pool1 != '' || region1 != '')
        {
        document.getElementById("row1").value=pool1+','+region1;
        }
	if(pool2 != '' || region2 != '')
        {
        document.getElementById("row2").value=pool2+','+region2;
        }
        if(pool3 != '' || region3 != '')
        {
        document.getElementById("row3").value=pool3+','+region3;
        }
        if(pool4 != '' || region4 != '')
        {
        document.getElementById("row4").value=pool4+','+region4;
        }
	
	for(i=1;i<=4;i++)
	{
	if(i != 1)
	{
	if(document.getElementById("row1").value !=''  && document.getElementById("row1").value ==document.getElementById("row"+i).value)
	{
	 alert('Duplicate mapping selected');
	 document.getElementById("pool1").focus();
	 document.getElementById("region1").focus();
	 return false;
	}
	}
		if(i != 2)
	{
	if(document.getElementById("row2").value !='' && document.getElementById("row2").value ==document.getElementById("row"+i).value)
	{
	 alert('Duplicate mapping selected');
	 document.getElementById("pool2").focus();
	 document.getElementById("region2").focus();
	 return false;
	}
	}
		if(i != 3)
	{
	if(document.getElementById("row3").value !='' && document.getElementById("row3").value ==document.getElementById("row"+i).value)
	{
	 alert('Duplicate mapping selected');
	 document.getElementById("pool3").focus();
	 document.getElementById("region3").focus();
	 return false;
	}
	}
		if(i != 4)
	{
	if(document.getElementById("row4").value !='' && document.getElementById("row4").value ==document.getElementById("row"+i).value)
	{
	 alert('Duplicate mapping selected');
	 document.getElementById("pool4").focus();
	 document.getElementById("region4").focus();
	 return false;
	}
	}
	}
	
  for(i=1;i<=4;i++)
  {
   if(i != 1)
	{
	if(document.getElementById("priorty1").value != '' && document.getElementById("priorty1").value ==document.getElementById("priorty"+i).value)
	{
	 alert('Duplicate Priorty selected');
	 document.getElementById("priorty1").focus();
	 return false;
	}
	}
  if(i != 2)
	{
	if(document.getElementById("priorty2").value != '' && document.getElementById("priorty2").value ==document.getElementById("priorty"+i).value)
	{
	 alert('Duplicate Priorty selected');
	 document.getElementById("priorty2").focus();
	 return false;
	}
	}
  if(i != 3)
	{
	if(document.getElementById("priorty3").value != '' && document.getElementById("priorty3").value ==document.getElementById("priorty"+i).value)
	{
	 alert('Duplicate Priorty selected');
	 document.getElementById("priorty3").focus();
	 return false;
	}
	}
   if(i != 4)
	{
	if(document.getElementById("priorty4").value != '' && document.getElementById("priorty4").value ==document.getElementById("priorty"+i).value)
	{
	 alert('Duplicate Priorty selected');
	 document.getElementById("priorty4").focus();
	 return false;
	}
	}	
  }
	
	
	}
  function checkpool_region(pool_id,id)
    {
    var xmlHttp=ajaxFunction();
    var pool_combination=document.getElementById("row"+id).value;
    var res = pool_combination.split(",");
    var pool_id=res[0];
    var region_id=res[1];
    if(pool_id == '' || typeof(pool_id) == 'undefined')
      {
      pool_id=0;
      }
    if(region_id == '' || typeof(region_id) == 'undefined')
      {
      region_id=0;
      }
  
    if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					var temp=xmlHttp.responseText;
					var a=confirm("Associates Mapped:"+temp);
					if(a ==false)
					{
					document.getElementById("pool"+id).value='';
					}
					return false;
					
					
					
				}
				
			}
			var str='index.php?r=admin_eto/ManagePool/checkpoolcount/pool_id/'+pool_id+'/region_id/'+region_id+'/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}
    
   
    
    }
	

	
	
	function checkpriorty(id)
	{
	for(i=1;i<=4;i++)
	{
	if(i !=id)
	{
	if(document.getElementById("priorty"+id).value ==document.getElementById("priorty"+i).value)
	{
	alert("Duplicate Priorty is not Allowded");
	document.getElementById("priorty"+i).focus();
	}
	}
	}
	}
	
 function checkDelete(row_no)
 {
    var pool_id=document.getElementById("pool"+row_no).value;
    var region_id =document.getElementById("region"+row_no).value;
    var temo;
         
           $.ajax({
                  url: '/index.php?r=admin_eto/ManagePool/checkpoolcount',
                  data: {pool_id: pool_id,region_id :region_id,delete_check :"yes"},
                  async:false,
                  success: function(data) {
                  temo=data;
        }
    });
          var a=confirm("Associates Mapped:"+temo);
              if(a ==false)
              {
               return false;
              }
              else
              {
              return true;
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
	</script>
	
	
		

	<?php
	
	if($addAssociate)
	{
	?>
	<body>
	<form name="addAssociate" method="post" action="" onsubmit="">
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%" align="left">
	<tr>
	<td class="intd" width="25%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>IndiaMART Emp Id</b> </td>
	<td class="intd" width="25%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b><?php echo $empId ?></b> </td>
	<td class="intd" width="25%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>IndiaMART Emp Name</b> </td>
	<td class="intd" width="25%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b><?php echo $empName ?></b> </td>
	</tr>
	</table>
	<br>
	<br>
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="50%" align="center">
	<tr>
	<td class="intd" width="25%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Pool</b> </td>
	<td class="intd" width="25%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Region</b> </td>
	<td class="intd" width="25%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Priorty</b> </td>
	<td class="intd" width="25%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Delete</b> </td>
	</tr>
	<?php
	$i=1;
	while($rec=pg_fetch_array($sth_map))
	{
	$rec=array_change_key_case($rec, CASE_UPPER);
	 echo '<tr><td class="intd" width="20%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff">
	       <select name="pool'.$i.'" id="pool'.$i.'" onchange="checkpool_region(this,'.$i.');"><option value="">Select</option>';
	       
	       
	      $j=0; 
	      foreach($pool_array['LEAP_POOL_ID'] as $temp)
	      {
	      if($pool_array['LEAP_POOL_ID'][$j] ==$rec['FK_LEAP_POOL_ID'])
	      {
	      echo '<option value="'.$pool_array['LEAP_POOL_ID'][$j].'" selected>'.$pool_array['LEAP_POOL_NAME'][$j].'</option>';
	      }
	      else
	      {
	      echo '<option value="'.$pool_array['LEAP_POOL_ID'][$j].'">'.$pool_array['LEAP_POOL_NAME'][$j].'</option>';
	      }
	      $j=$j+1;
	      }
	      echo '</select></td>';
	     echo '<td class="intd" width="20%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff">
	       <select name="region'.$i.'" id="region'.$i.'" onchange="checkpool_region(this,'.$i.');"><option value="">Select</option>'; 
	       
	       $k=0;
	       foreach($region_array['LEAP_REGION_ID'] as $temp)
	       {
	        if(isset($rec['FK_LEAP_REGION_ID']) && $region_array['LEAP_REGION_ID'][$k] ==$rec['FK_LEAP_REGION_ID'])
	        {
	         echo '<option value="'.$region_array['LEAP_REGION_ID'][$k].'" selected>'.$region_array['LEAP_REGION_NAME'][$k].'</option>';
	        }
	        else
	        {
	        echo '<option value="'.$region_array['LEAP_REGION_ID'][$k].'">'.$region_array['LEAP_REGION_NAME'][$k].'</option>';
	        }
	         $k=$k+1;
	       }
	      echo '</select></td>
	      <td class="intd" width="10%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff">
	       <select name="priorty'.$i.'" id="priorty'.$i.'" onchange="checkpriorty('.$i.')"><option value="">Select</option>';
	   
	       if($rec['LEAP_AGENT_PRIORITY'] ==1)
	       {
	       echo '<option value="1" selected>1</option>';
	       }
	       else
	       {
	        echo '<option value="1">1</option>';
	       }
	        if($rec['LEAP_AGENT_PRIORITY'] ==2)
	       {
	        echo '<option value="2" selected>2</option>';
	       }
	       else
	       {
	        echo '<option value="2">2</option>';
	       }
	        if($rec['LEAP_AGENT_PRIORITY'] ==3)
	       {
	          echo '<option value="3" selected>3</option>';
	       }
	       else
	       {
	       echo '<option value="3">3</option>';
	       }
	        if($rec['LEAP_AGENT_PRIORITY'] ==4)
	       {
	       echo '<option value="4" selected>4</option>';
	       }
	       else
	       {
	        echo '<option value="4">4</option>';
	       }
	      echo '</select></td>
	       <td class="intd" width="10%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff">
	       
	       <input type="submit" name="Delete'.$i.'" id="Delete'.$i.'" value="Delete" onclick="return checkDelete('.$i.');"></td>
	      </tr>';
	      $i++;
	}
	for($n=$count+1;$n<=4;$n++)
	{
	echo '<tr><td class="intd" width="20%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff">
	       <select name="pool'.$n.'" id="pool'.$n.'" onchange="checkpool_region(this,'.$n.');"><option value="">Select</option>';
	       
	    $j=0; 
	      foreach($pool_array['LEAP_POOL_ID'] as $temp)
	      {
	        echo '<option value="'.$pool_array['LEAP_POOL_ID'][$j].'">'.$pool_array['LEAP_POOL_NAME'][$j].'</option>';
	        $j=$j+1;
	      }   
	      
	      echo '</select></td>';
	     echo '<td class="intd" width="20%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff">
	       <select name="region'.$n.'" id="region'.$n.'" onchange="checkpool_region(this,'.$n.');"><option value="">Select</option>'; 
	       
	        $k=0;
	       foreach($region_array['LEAP_REGION_ID'] as $temp)
	       {
	         echo '<option value="'.$region_array['LEAP_REGION_ID'][$k].'">'.$region_array['LEAP_REGION_NAME'][$k].'</option>';
	         $k=$k+1;
	       }
	      echo '</select></td>
	      <td class="intd" width="10%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff">
	       <select name="priorty'.$n.'" id="priorty'.$n.'" onchange="checkpriorty('.$n.')"><option value="">Select</option>
	       
	      <option value="1" >1</option>
	      <option value="2" >2</option>
	      <option value="3" >3</option>
	      <option value="4" >4</option></select></td>
	      <td class="intd" width="10%" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"></td>
	      </tr>';
	
	}
	?>
	<tr>
	<td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" colspan="4">
	 
	<?php 
	
	   echo '<input class="button1" type="submit" name="addAssociate" value="Submit" onclick="return checkFields();">&nbsp;&nbsp;&nbsp;<span id="duplicate_check" style="width:500px"><div id="status">'.$status.'</div>';
	
	?>
	</td>
	<tr>
	</table>
	<input type="hidden" name="empId" value="<?php echo $empId ?>">
	<input type="hidden" name="row1" id="row1" >
	<input type="hidden" name="row2" id="row2" >
	<input type="hidden" name="row3" id="row3" >
	<input type="hidden" name="row4" id="row4" >
	</form>
	</body>
	<?php
	}
	?>