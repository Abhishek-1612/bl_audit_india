<?php
	if(!empty($manualMcatResult)){
	
		
	$count = 0;
	$hash = $manualMcatResult['ha'];
	$mcat = $manualMcatResult['mcat'];
	$mcatStr = (is_array($mcat) && !empty($mcat))?implode(',', $mcat):'';
?>
	<form name='postcheck'><TABLE BORDER='0' CELLPADDING='3' CELLSPACING='0' CLASS='result_text'>
	<input name="searchedManualMcat" id="searchedManualMcat" value="<?php echo $mcatStr; ?>" type="hidden">
	<?php
	foreach($hash as $k=>$ha){
	$mcatAdultFlag = isset($ha['GLCAT_MCAT_ADULT_FLAG'])?$ha['GLCAT_MCAT_ADULT_FLAG']: ''; ?>
	
	<?php if($ha['MCAT_NAME']){
		if ($mcatAdultFlag == '1')
					{
						$mcat_name = $ha['MCAT_NAME'];
						$mcat_name = str_replace("'","\'",$mcat_name);
						$count++;
						$val = $ha['MCAT_ID']."__".$ha['MCAT_NAME']."__".$ha['CAT_ID']."__".$ha['CAT_NAME']."__".$ha['GRP_ID']."__".$ha['GRP_NAME'];
						$val1= $ha['GRP_NAME']." &gt;&gt;". $ha['CAT_NAME']." &gt;<span style='color:#DC143C;'>".$ha['MCAT_NAME']."</span>";
						?>
						
                	<tr><td>
                	<input name="radio" id="Radio1" value="<?php echo $val; ?>" type="radio" onclick="return display('<?php echo $mcat_name ?>','<?php echo $ha['MCAT_ID'] ?>',1)"><?php echo $val1; ?>
                	</td></tr>
                	
                	<?php
               } else {
               	$mcat_name = $ha['MCAT_NAME'];
               	$mcat_name =str_replace("'","\'",$mcat_name);
               	$count++;
               	$val = $ha['MCAT_ID']."__".$ha['MCAT_NAME']."__".$ha['CAT_ID']."__".$ha['CAT_NAME']."__".$ha['GRP_ID']."__".$ha['GRP_NAME'];
               	$val1 = $ha['GRP_NAME']."&gt;&gt; ".$ha['CAT_NAME']." &gt; ".$ha['MCAT_NAME'];	
               	?>	
               								
						<tr><td>
						<input name="Radio1" id="Radio1" value="<?php echo $val ?>" type="radio" onclick="return display('<?php echo $mcat_name ?>','<?php echo $ha['MCAT_ID'] ?>',1)"><?php echo $val1 ?>
						</td></tr>
										
					<?php }
		if($count == 10)
			{
				break;
			}			
	}
	
				
}?></table></form> <?php
}
