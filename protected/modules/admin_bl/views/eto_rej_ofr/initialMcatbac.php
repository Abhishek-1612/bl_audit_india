<script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script> 
<LINK HREF="/css/jquery.dataTables.min.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/jquery.dataTables.min.js"></script>
<script>
var get_dispositions ={"1":{"62206":"Varun Chopra","72327":"Vishal"},"2":{"59240":"Vijay Singh","58895":"Yogesh Chhabra"}};
 $(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "searching": false,
        "info":     false,
        "order": [[ 3, "desc" ]],
    } );
$('#final').change(function() {
    var selectedValues = $(this).val();  alert(selectedValues);
});
</script>
<?php 
if(isset($mcatList) && isset($mcatList['mcatList'][0]["MCAT_ID"])){
    ?>
	<table id="example" class="cell-border stripe" style="width:100%;">
	<thead><tr>
		<th style="text-align:center">MCAT ID</th>
		<th style="text-align:center">MCAT Name</th>
		<th style="text-align:center">MCAT RANK</th>	
		<th style="text-align:center">BLNI Total</th>
		<th style="text-align:center">BLNI Prime</th>
		<th style="text-align:center">BLNI Non-Prime</th>
		<th style="text-align:center">Txn Total</th>
		<th style="text-align:center">Txn Prime</th>
		<th style="text-align:center">Txn Non-Prime</th>
		<th style="text-align:center;width:30%;">Case Closure</th>		
		</tr></thead>
		<?php 
		$count = 1;
	foreach ($mcatList['mcatList'] as $mcat){
		
        ?>
		<tr id= "<?php echo $mcat["MCAT_ID"] ?>">
		<td style="text-align:center"><input type="radio" value="<?php echo $mcat["MCAT_ID"] ?>" id="check_<?php echo $mcat["MCAT_ID"]?> " name="name2" />
                    <span style="cursor:pointer" onclick="relatedOffers(<?php echo $mcat['MCAT_ID'] ?>)"><?php echo $mcat["MCAT_ID"] ?></span><br>
                    <a href="/index.php?r=admin_marketplace/Keyword/McatbyGlusr&action=BLNI&mid=3373&gl_id_search=<?php echo $sbjVal; ?>&mcat_id_search=<?php echo $mcat["MCAT_ID"] ?>" target= "_blank">View Product List</a></td>
				<td style="text-align:center"><?php echo $mcat["MCAT_NAME"] ?></td>
				<td style="text-align:center"><?php echo $mcat["MCAT_RANK"] ?></td>				
				<td style="text-align:center"><?php echo $mcat["BLNI_TOTAL"] ?></td>
				<td style="text-align:center"><?php echo $mcat["BLNI_PRIME"] ?></td>
				<td style="text-align:center"><?php echo $mcat["BLNI_NON_PRIME"] ?></td>
				<td style="text-align:center"><?php echo $mcat["TXN_TOTAL"] ?></td>
				<td style="text-align:center"><?php echo  $mcat["TXN_PRIME"] ?></td>
				<td style="text-align:center"><?php echo  $mcat["TXN_NON_PRIME"] ?> </td>
				
				<td style="text-align:left;">
                                    <table width="100%" border="0">
                                        <tr>
                     <td style="width: 40%;"><b>Major Disposition:</b></td><td style="width: 60%;">
                    <select id="final" name="final" style="width: 99%;margin-left: 4px;margin-top: 2px;">
                    <option value="" selected>--Select--</option>
                      <?php if(!empty($arr['final_disp'])){ ?>
                            <?php foreach($arr['final_disp'] as $key=>$value) { ?>
                               <option  value="<?php echo $key ?>">   <?php echo $value ?></option> 
                               <?php } ?>
                               <?php } ?>
                        </select>
                        </td></tr>
                                        <tr>
                                    <td style="width: 40%;"><b>Minor Disposition:</b></td><td style="width: 60%;">
                        <select id="micro" name="micro" style="width: 99%;">
                            <option value="" selected>--Select--</option>
                        </select>
                           </td></tr>
                    
                    <tr><td><b>Comments:</b></td><td>
                            <textarea type="text" maxlength="1000" id="text" name="text" dir="auto" aria-label="Comments:" title="" 
                                      style="width:99%;border:solid 1px #cccccc;box-shadow:1px 1px 1px #333;word-wrap: break-word;"></textarea> 
                        <td></tr>
                    <tr><td colspan="2" align="center"><a ONCLICK="return updateCaseClosure(<?php echo $count; ?>,<?php echo $mcat["MCAT_ID"] ?>)" 
                                           style="color:white;background-color: #5A5A5A;cursor: pointer;padding: 5px;border-radius: 2px;font-family:arial;font-size:14px;font-weight:bold;" align="center">
Update</a>
<span class="errorClss" id="success1<?php echo $count; ?>" style="color:green;display:none">Success!</span>
<span class="errorClss" id="failed1<?php echo $count; ?>" style="color:red;display:none">Failed!</span>
</td>  
                    </tr></table>
				</td>
				
				</tr>
                <?php
				$count++;
    }
    ?>
	</table>
	<br><div style= "text-align: center;"><a id="negMcat1" ONCLICK="return updateNegativeMcats(1)" 
          style="color:white;background-color: #5A5A5A;cursor: pointer;padding: 5px;border-radius: 2px;font-family:arial;font-size:14px;font-weight:bold;" 
          align="center">
	Update
	</a>
	
	<span id="success1" style="margin-left:10px;color:green;display:none">Success!</span>
<span id="failed1" style="margin-left:10px;color:red;display:none">Failed!</span>
</div>

    <?php
	}else{
        ?>
		<div><center style="color: black;margin-top: 30px;font-weight: bold;">No records of MCAT for respective GLID.</center></div>
    <?php }
    ?>
	<div id ="offerDetails"></div>
	<br><div style= "text-align: center;"><a id="negMcat" ONCLICK="return getNegativeMcats()" style="display:none;background-color: #2a88da;cursor: pointer;padding: 5px;border-radius: 2px;font-family:arial;font-size:14px;font-weight:bold;" align="center">
	Negative MCAT
	</a></div>
	<div id ="negativeMcats"></div>
