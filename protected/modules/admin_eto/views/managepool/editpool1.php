<style>

	</style>
	<script type="text/javascript">
	
	</script>




<?php

     $industry_mcat=array();
     $industry_cat=array();
     $industry_grp=array();
     $html='';
    $mid=isset($_REQUEST['mid']) ? $_REQUEST['mid'] :'';
     echo '<form name="editpopup" METHOD="post" STYLE="margin-top:0;margin-bottom:0;" ACTION="/index.php?r=admin_eto/ManagePool/updatepool/mid/'.$mid.'" onsubmit="return nextField1()">
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="40%" align="right">';
    while($rec=pg_fetch_array($sth))
    {
     $rec=array_change_key_case($rec, CASE_UPPER);
    $Pollname=$rec['LEAP_POOL_NAME'];
    if(isset($rec['LEAP_POOL_INDUSTRY_TYPE']) && $rec['LEAP_POOL_INDUSTRY_TYPE'] ==1)
    {
    $industry_mcat[$rec['LEAP_POOL_INDUSTRY_ID']]=$rec['GLCAT_MCAT_NAME'];
    }
       if(isset($rec['LEAP_POOL_INDUSTRY_TYPE']) && $rec['LEAP_POOL_INDUSTRY_TYPE'] ==2)
    {
    $industry_cat[$rec['LEAP_POOL_INDUSTRY_ID']]=$rec['GLCAT_CAT_NAME'];
    }
 
    if(isset($rec['LEAP_POOL_INDUSTRY_TYPE']) && $rec['LEAP_POOL_INDUSTRY_TYPE'] ==3)
    {
    array_push($industry_grp,$rec['GLCAT_GRP_SHORTNAME']);
    }
 
    }
  
  
    
    $html .='<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Pool Name:</b> </td> 
       <td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><input type="text" name="poll_name1" id="poll_name1" value="'.htmlentities($Pollname).'"><div id="check_poolname" style="width:500px;margin-left: 510px; margin-top:px;"></div></td></tr>';
    $html .='<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Group Name:</b> </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">&nbsp;<select multiple name="grp1[]" id="grp1" style="width: 500px; height:150px;" onclick="checkgroup(this,'.$pool_id.')">';
	

      while($rec=pg_fetch_array($sth_grp))
	{
	 $rec=array_change_key_case($rec, CASE_UPPER);
	if(in_array($rec['GLCAT_GRP_SHORTNAME'],$industry_grp))
	{
	$html .='<option value="'.$rec['GLCAT_GRP_ID'].'" selected>'.$rec['GLCAT_GRP_SHORTNAME'].'</option>';
	}
	else
	{
	$html .='<option value="'.$rec['GLCAT_GRP_ID'].'">'.$rec['GLCAT_GRP_SHORTNAME'].'</option>';
	}
	}
	$html .='</select><div id="check_group" style="width:500px;margin-left: 510px; margin-top:px;"></div>
	</td>
	</tr>';
	
 $html .='<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Category:</b> </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">
	&nbsp;<select multiple name="cat1[]" id="cat1" style="width: 500px; height:150px;" onclick="checkcat(this,'.$pool_id.')">';
	

      foreach($industry_cat as $key=>$value)
	{
	$html .=' <option value="'.$key.'" selected>'.$value.'</option>';
	}
	$html .='</select><br>
	&nbsp;<input type="text" name="cattext" id="cattext" >
	&nbsp;<input type="button" value="submit"  onclick="catselect()"><br>
	<div id="check_category" style="width:500px;margin-left: 510px; margin-top:px;"></div><div id="check_catname"> </div>
	</td>
	</tr>';
 $html .='<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Mcat:</b> </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">
	&nbsp;<select multiple name="mcat1[]" id="mcat1" style="width: 500px; height:150px;" onclick="checkmcat(this,'.$pool_id.')">';
	

      foreach($industry_mcat as $key=>$value)
	{
	$html .=' <option value="'.$key.'" selected>'.$value.'</option>';
	}
	$html .='</select><br>
	&nbsp;<input type="text" name="mcattext" id="mcattext" >
	&nbsp;<input type="button" value="submit"  onclick="mcatselect()"><br>
	<div id="check_mcat1" style="width:500px;margin-left: 510px; margin-top:px;"></div><div id="check_mcatname"> </div>
	</td>
	</tr>';	
      $html .='<input type="hidden" name="pool_id" value="'.$pool_id.'">';	
    
     $html .='<tr><td colspan="2" style="text-align:center;"><input type="submit" name="update" value="update"></td></tr>';
    echo $html;
    die;