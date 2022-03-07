<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
?>
<?php
if($valid == 1)  {	
 $checkDelete=isset($_REQUEST['check']) ? $_REQUEST['check'] : '';
 $checkproductlisting=isset($_REQUEST['pl']) ? $_REQUEST['pl'] : '';
	if(empty($param['offer']) || $param['offer'] == 0 || !preg_match('/^\d+$/', $param['offer'])){ ?>	
		<div align="center" style="font-family: arial; font-size: 14px; font-weight: bold;">
			<font color="red">Sorry, Please enter Valid Offer ID</font>
		</div>
	<?php exit; 
	}  ?>
	<html>
	<head>
	<style TYPE="text/css">
	.admintext {font-family:arial; font-size:11px;line-height:15px;}
	.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}
	.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
	
        .block1{FONT-SIZE: 12px; border-right:1px #DDF0FF solid;padding-left:10px;padding-right:10px;}
        .block1 a{COLOR: #0000ff}
        .block1 .res{font-weight:bold; }
        .block1 .off{font-weight:bold; COLOR: #000000;}
        .block1 b{COLOR: #FF4800;FONT-SIZE: 14px;}

	</style>
             <script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
             <script type="text/javascript">

function getcity(glid){
            a={};
            a['glid']=glid;
            var btnid='city_'+glid;
            var dvcity='dvcity'+glid;
            result='';               
            $.ajax({
               url:"index.php?r=admin_eto/OfrHist/Citydetail/",
                type: 'post',
                data:a,
                success:function(result){                
                    document.getElementById(btnid).style.display = 'none';
                    document.getElementById(dvcity).innerHTML = result;  
                }
            });                    
    }
  
</script>
	</head>
	<script>
	function changecheckbox()
	{
	   
	   <?php 
	  if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
	      { ?>
	      var url ='/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=mapHist&offer=<?php echo $param['offer']; ?>&mid=3424&status=<?php echo $param['status']; ?>';
	      <?php }
	      else
	      { ?>
	     var url ='/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=mapHist&offer=<?php echo $param['offer']; ?>&mid=3424&status=<?php echo $param['status']; ?>';
	     <?php  } ?>
	    if(document.getElementById("productlisting").checked == true){
	      url += '&pl=yes'
	    }else{
	      url += '&pl=no'
	    }
	    window.location.href = url;
	}
	</script>
	<body>
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td colspan="3" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Mcat Mapping Detail for Offer ID - <font color="red"><?php echo $param['offer']; ?></font> <BR>

	</td>
	<td style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30"> 
	<input type="checkbox" name="productlisting" id="productlisting" onchange="changecheckbox();" <?php if($checkproductlisting =='yes') { echo 'checked'; } ?> >&nbsp;With Product listing Details
	</td>
	</tr>
	</tbody></table>
	
	<div id="masterdiv" style="clear: both;">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
<?php
	$i =$j =$orderID =$histID = $empid=0;
	$prime_mcat=$bId='';
	$recMap1 = $returnResult['recMap1'];
        $recmcat_mondatory=$returnResult['recmcat_mondatory'];
	foreach($returnResult['recMapResult'] as $recK => $recMap){
		if(isset($recMap1['ETO_OFR_HIST_COMMENTS']) && $recMap1['ETO_OFR_HIST_COMMENTS'] == 'Manual Mcat Mapping') {
		$i++;		
		if($empid != $recMap['GL_EMP_ID'])	{					
				$actionDisp = '<B style="color:red;">Manual Mcat Selection </B>';
                                echo '<tr><td><BR></td></tr>
                                <tr><td class="admintext1" align="left"> '.$actionDisp.' by '.$recMap['GL_EMP_NAME'].' (';
                                echo ($recMap['GL_EMP_ID'])?' Emp ID - '.$recMap['GL_EMP_ID']:'';
                                echo ')';			
                                echo ($recMap['ETO_OFR_MAPPING_DATE'])?' On '.$recMap['ETO_OFR_MAPPING_DATE']:'';			
                                echo '</td>
                                </tr>';
                                $j=1;
			
		}

                echo '<tr><td class="admintext" align="left" width="100%">
                <table align="center" border="0" cellpadding="1" cellspacing="1" width="100%">';

                if($j == 1) {
                        echo '
                        <tr>
                        <td class="admintext" align="left" width="20%" bgcolor="#ccccff"><b>Mcat ID</b></td>
                        <td class="admintext" align="left" width="80%" bgcolor="#ccccff"><b>Mcat Name</b></td>
                        <td class="admintext" align="left" width="30%" bgcolor="#ccccff"><b>Status</b></td> 
                        </tr>';
                }

                echo '
                <tr>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="20%">'.$recMap['GLCAT_MCAT_ID'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="80%">'.$recMap['GLCAT_MCAT_NAME'].'&nbsp;<font color="red">'.@$recMap['IS_GENERIC'].'</font></td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="30%">Selected</td>
                </tr>';
                echo '</table>
                </td>
                </tr>';
                $j++;        
		$empid = $recMap['GL_EMP_ID'];                
	}
        $prime_mcat = isset($recMap['PRIME_MCAT'])?$recMap['PRIME_MCAT']:'';
        $bId = isset($recMap['GLCAT_MCAT_IS_BUSINESS_TYPE'])?$recMap['GLCAT_MCAT_IS_BUSINESS_TYPE']:'';
	}
	echo '</tbody></table>';
#### Auto Selected Mcats Details ####
	echo '<div id="masterdiv1" style="clear: both;"><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>'; 
	$j = $orderID =$histID =$empid=0;

	foreach ($returnResult['recNotMapResult'] as $recNotMapK => $recNotMap) {
             if($recNotMap['ETO_AUTO_MCAT_RANK'] > 0)
		$actionDisp = 'Selected';
		else
		$actionDisp = 'Not Selected';		
		$i++;		
		if($empid != $recNotMap['GL_EMP_ID']) {	
			echo '<tr><td><BR></td></tr><tr><td class="admintext1" align="left"> <B style="color:red;">Auto Suggested MCATs</B> by ';
			echo ($recNotMap['GL_EMP_ID'])?' Emp ID - '.$recNotMap['GL_EMP_ID']:'';
			echo ($recNotMap['ETO_AUTO_MCAT_SELECTION_DATE'])?' On '.$recNotMap['ETO_AUTO_MCAT_SELECTION_DATE']:'';			
			echo '</td></tr>';
			$j=1;
		}
                echo '
                <tr>
                <td class="admintext" align="left" width="100%">
                <table align="center" border="0" cellpadding="1" cellspacing="1" width="100%">';

                if($j == 1) {
                        echo '<tr>
                        <td class="admintext" align="left" width="20%" bgcolor="#ccccff"><b>Mcat ID</b></td>
                        <td class="admintext" align="left" width="30%" bgcolor="#ccccff"><b>Mcat Name</b></td> 
                        <td class="admintext" align="left" width="20%" bgcolor="#ccccff"><b>Status</b></td>   
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>Position</b></td>
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>Relevancy Score</b></td>
                        </tr>';
                }
                $gen=isset($recNotMap['IS_GENERIC'])?$recNotMap['IS_GENERIC']:'';
                $bId = isset($recNotMap['GLCAT_MCAT_IS_BUSINESS_TYPE'])?$recNotMap['GLCAT_MCAT_IS_BUSINESS_TYPE']:'';

                if($prime_mcat==$recNotMap['GLCAT_MCAT_ID']){
                    $gen .=' [Prime]';
                    if($bId==1){
                            $gen .=' [Business MCAT]';
                    }
                }
                foreach ($recmcat_mondatory as $rec) {
                    $gl_profile_new_value=isset($rec['gl_profile_new_value'])?$rec['gl_profile_new_value']:'';
                    $gl_profile_old_value=isset($rec['gl_profile_old_value'])?$rec['gl_profile_old_value']:'';
                    if($gl_profile_new_value==$recNotMap['GLCAT_MCAT_ID']){
                        if($gl_profile_old_value==''){
                            $gen .=' [Mandatory MCAT, deselected by associate]'; 
                        }else{
                            $gen .=' [Mandatory MCAT]'; 
                        }                       
                    }
                }
                
                $rank=isset($recNotMap['ETO_AUTO_MCAT_RANK'])?$recNotMap['ETO_AUTO_MCAT_RANK']:'';
                $score=isset($recNotMap['MCAT_RELEVANCY_SCORE'])?$recNotMap['MCAT_RELEVANCY_SCORE']:'';
                if($rank < -99){
                    $score=$score.' (Child MCAT)';
                }
                echo '<tr>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="20%">'.$recNotMap['GLCAT_MCAT_ID'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="30%">'.$recNotMap['GLCAT_MCAT_NAME'].'&nbsp;<font color="red">'.$gen.'</font></td> 
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="20%">'.$actionDisp.'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="15%">'.$recNotMap['ETO_AUTO_MCAT_RANK'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" width="15%">'.$score.'</td>    
                </tr>';
                
                echo '</table></td></tr>';
                $j++;
        
		$empid = $recNotMap['GL_EMP_ID'];
	//}
        }
	
if($i == 0) {
		echo '
		<tr>
		<td class="admintext1" align="center" colspan="14">
		<DIV CLASS="tab-head">No Record Found !</DIV> </td>
		</tr>';
	}
echo '</tbody></table>';
	#### Not Selected Mcats Details ####
	echo '	
	<div id="masterdiv1" style="clear: both;">';

unset($returnResult['recNotMapResult']); 
unset($returnResult['recMap1']); 
unset($returnResult['recmcat_mondatory']); 

	#### Supplier Selection Details ####
        if(!empty($returnResult['hash'])) {
		echo '
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top:25px;padding-bottom:20px;">
		<tbody><tr>
		<td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Supplier Selection Details for Offer ID - <font color="red">'.$param["offer"].'</font> <BR></td>
		</tr>
		</tbody></table>';

                echo $returnResult['relcat'].'
        	<table width="100%" border="0" bgcolor="#f3f3f3" cellspacing="1" cellpadding="0">
        	<tr>
                <td width="6%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Glusr ID</b></td>
                <td width="18%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Glusr Company</b></td>
                <td width="12%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;" align="center"><b>Mobile</b></td>
                <td width="8%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;" align="center"><b>Deduced Loc Pref</b></td>
		<td width="8%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;" align="center"><b>Glusr Loc Pref</b></td>
		<td width="13%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;" align="center"><b>Product</b></td>
		<td width="15%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;" align="center"><b>Offer Title</b></td>
		<td width="18%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;" align="center"><b>Search Keyword</b></td>
		<td width="3%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Rank</b></td>
		<td width="3%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Supplier Type</b></td>
		<td width="3%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>NOB</b></td>
		<td width="8%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Selection Mode</b></td>';
                if($checkproductlisting=='yes'){
                echo '<td width="8%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>MCAT Name/ID</b></td>
                <td width="3%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Rank</b></td>
                <td width="3%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>MCAT Primary/Secondary[Prime]</b></td>
		<td width="3%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Premium Listing</b></td>
                <td width="8%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Distance</b></td>
		<td width="8%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Product Accuracy score</b></td>		
                <td width="8%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Product ID</b></td>
                <td width="8%" bgcolor="#FFFFFF" class="block1" style="padding:2px;border-right: none;"><b>Supplier Preferred City</b></td>';
                }
        	echo '</tr>';		
        }

	$i=1;
	$n=0;
	$bgcolorRANK='';
        foreach ($returnResult['hash'] as $k => $hash) {
            $dloc='';     	
			if(preg_match('/-/',$hash["SUPPLIER_RANK"])) { 
			$bgcolorRANK = 'bgcolor="#FFDADA"'; 
			} else { 
			$bgcolorRANK = ' bgcolor="#FFFFFF"';
			}
                    if($hash["DEDUCED_LOC"]==1){
                            $dloc='Global';
                    }elseif($hash["DEDUCED_LOC"]==2){
                            $dloc='India';
                    }elseif($hash["DEDUCED_LOC"]==3){
                            $dloc='Foreign';
                    }elseif($hash["DEDUCED_LOC"]==4){
                            $dloc='Local';
                    }
                      $city = !empty($hash["GLUSR_USR_CITY"])?','.$hash["GLUSR_USR_CITY"]:'';
			 echo '<tr>
			 <td $bgcolorRANK class="block1" style="padding:2px;border-right: none;"> '.$hash["GLUSR_USR_ID"].' </td>
			 <td $bgcolorRANK class="block1" style="padding:2px;border-right: none;">
			 <a href="'.$hash["GLUSR_USR_URL"].'" target="_blank">'.$hash["GLUSR_COMPANY"].'</a> '.$city.'</td>
                        <td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$hash["MOBILE"]. ' &nbsp;&nbsp; 
                       </td>
                       <td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$dloc.' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$hash["GLUSR_USR_LOC_PREF"].' </td>';
			if($hash["ITEM_OFR_NAME"])
			    {   
                                if($hash["ITEM_OFR_NAME"]=='Virtual Product'){
                                     echo '<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;color:#FF0000"> '.$hash["ITEM_OFR_NAME"].' </td>';
                                }else{
                                     echo '<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$hash["ITEM_OFR_NAME"].' </td>';
                                }			   
			    }
			    else
			    {
                                $glid=$hash["GLUSR_USR_ID"];
                                $pid=$hash["SD_DISPLAY_ID"];
                                echo '<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;color:#FF0000"> Product Removed <a href="/index.php?r=admin_products/ProductHistory/ItemHistory&iid='.$pid.'&GLID='.$glid.'&id_type=did&mid=3424" target="_blank">View History</a> </td>';
			    }
			
			if(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='M' && $hash["SUPPLIER_RANK"] < 0)
			{
			 $Selected_mode='Manual Deselected';
			}
			elseif(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='M' && $hash["SUPPLIER_RANK"] > 0)
			{
			 $Selected_mode='Manual Selected';
			}
			elseif(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='A' && $hash["SUPPLIER_RANK"] < 0)
			{
			 $Selected_mode='Auto Deselected';
			}
			elseif(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='A' && $hash["SUPPLIER_RANK"] > 0)
			{
			 $Selected_mode='Auto Selected';
			}
			elseif(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='R' && $hash["SUPPLIER_RANK"] < 0)
			{
			 $Selected_mode='Review Deselected';
			}
			elseif(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='R' && $hash["SUPPLIER_RANK"] > 0)
			{
			 $Selected_mode='Review Selected';
			}
                        elseif(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='B' && $hash["SUPPLIER_RANK"] < 0)
			{
			 $Selected_mode='Is Buyer: Deselected';
			}
                        elseif(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='B' && $hash["SUPPLIER_RANK"] > 0)
			{
			 $Selected_mode='Is Buyer: Selected';
			}
                        elseif(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='I' && $hash["SUPPLIER_RANK"] < 0)
			{
			 $Selected_mode='Introduced within 15 days: Deselected';
			}
                        elseif(isset($hash["ETO_LEADSUPMAP_TYP"]) && $hash["ETO_LEADSUPMAP_TYP"] =='I' && $hash["SUPPLIER_RANK"] > 0)
			{
			 $Selected_mode='Introduced within 15 days: Selected';
			}
			else
			{
			 $Selected_mode='Not Selected';
			}
			
			echo '<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$hash["ETO_OFR_TITLE"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$hash["SEARCH_KEYWORD"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none; font-weight:bold;"> '.$hash["SUPPLIER_RANK"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$hash["SUPPLIER_TYPE"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$hash["NOB_SUPPLIER_TYPE"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$Selected_mode.' </td>';
                        if($checkproductlisting=='yes'){
				$score='';
				if(@$hash["QUALITY_SCORE"]==3){
					$score='High(3)';
				}elseif(@$hash["QUALITY_SCORE"]==2){
					$score='Medium(2)';
				}elseif(@$hash["QUALITY_SCORE"]==1){
					$score='Low(1)';
				}elseif(@$hash["QUALITY_SCORE"]==0){
					$score='Medium(0)';
				}
			echo '<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.@$hash["MCATID_NAMES"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.@$hash["RANK"].' </td>
                        <td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.@$hash["PRIME"].' </td>
                        <td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.@$hash["KWD_PREM"].' </td>                            
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.@$hash["DISTANCE"].' </td>
			<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.$score.' </td>
                        <td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"> '.@$hash["SD_DISPLAY_ID"].' </td>';
                        
                        echo '<td align="center" '.$bgcolorRANK.' class="block1" style="padding:2px;border-right: none;"><input type="button" id="city_'.@$hash["GLUSR_USR_ID"].'" value="View City" onClick="getcity('.$hash["GLUSR_USR_ID"].')"><div id="dvcity'.$hash["GLUSR_USR_ID"].'"></div></td>';
                        echo '</tr>';
                        }
                        $i++;
       }	
	echo '</table>';
	echo '</body></html> ';
	}