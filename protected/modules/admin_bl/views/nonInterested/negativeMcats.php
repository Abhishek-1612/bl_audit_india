
<html>
<body>
<div style="height: auto;width:80%;margin-left: 10%;">
<?php 
if(isset($negMcats['negMcats']) && isset($negMcats['negMcats'][0]['FK_GLCAT_MCAT_ID'])){
    ?>
<div ><b>&nbsp;Suggested Negative MCATs:</b></div>
<table class="table table-bordered table-condensed" style="text-align: center;font-size: 13px;background-color:#F0F9FF;white-space: nowrap;">
		<tr style="background: none repeat scroll 0% 0% rgb(0, 109, 204); color: rgb(255, 255, 255);">
			<th>MCAT ID</th>
			<th>MCAT Name</th>
			<th>NI Prime Count</th>
			<th>NI Non-Prime Count</th>
            <th>Txn Prime Count</th>
			<th>Txn Non-Prime Count</th>
			<th>Select</th>
		</tr>
<?php	
// echo "<pre>";print_R($negMcats);
// echo "<pre>";print_R($arr);
// exit;	
foreach($negMcats['negMcats'] as $row)
{
	?>
    <tr>
			<td><?php echo @$row["FK_GLCAT_MCAT_ID"]?></td>
			<td><?php echo @$row["GLCAT_MCAT_NAME"]?></td>
			<td style="background-color:yellow"><?php echo @$row["NI_PRIME_COUNT"]?></td>
            <td><?php echo @$row["NI_NON_PRIME_COUNT"]?></td>
			<td style="background-color:lightgreen"><?php echo @$row["TXN_PRIME_COUNT"] ?></td>
            <td><?php echo @$row["TXN_NON_PRIME_COUNT"] ?></td>
			<td><input type="checkbox" value="<?php echo @$row["FK_GLCAT_MCAT_ID"];?>" id="check_<?php echo @$row["FK_GLCAT_MCAT_ID"];?>" name="name1" /></td>
		</tr>
<?php } ?>
</table>
<div style="text-align:center;margin-top: 10px;">
<a ONCLICK="return updateNegativeMcats(2)" style="background-color: #2a88da;cursor: pointer;padding: 5px;border-radius: 2px;font-family:arial;font-size:14px;font-weight:bold;" align="center">
Update
</a>
<span id="success1" style="margin-left:10px;color:green;display:none">Success!</span>
<span id="failed1" style="margin-left:10px;color:green;display:none">Failed!</span>
</div>
</div>
<?php }else { ?>
    <div><center style="color: black;margin-top: 30px;font-weight: bold;">No records of Negative MCAT for respective GLID.</center></div>
 <?php   }?>
<div style="margin-left: 10%;width: 80%;">
<b>&nbsp;Case Closure:</b>
<div style="border:1px solid black;margin-top: 10px;height: 210px;">
<div style="padding: 10px;"><b>Micro Disposition:</b>
                        <select id="micro" name="micro" style="width: 50%;">
                            <option value="" selected>--Select--</option>
                      <?php if(!empty($arr['micro_disp'])){ ?>
                            <?php foreach($arr['micro_disp'] as $value) { ?>
                               <option  value="<?php echo $value['ENQUIRY_MICRO_DISPOSITIONS_ID'] ?>">   <?php echo $value['ENQUIRY_MICRO_DISPOSITIONS_DSC'] ?></option> 
                               <?php } ?>
                               <?php } ?>
                        </select>
                        </div>
                    <div style="padding: 10px;">
                        <b>Final Disposition:</b>
                    <select id="final" name="final" style="width: 50%;margin-left: 6px;">                                                
                            <option value="" selected>--Select--</option>
                      <?php if(!empty($arr['final_disp'])){ ?>
                              <?php foreach($arr['final_disp'] as $value) { ?>
                               <option  value="<?php echo $value['ENQUIRY_FINAL_DISPOSITIONS_ID'] ?>">   <?php echo $value['ENQUIRY_FINAL_DISPOSITIONS_DSC'] ?></option> 
                               <?php } ?>
                                <?php } ?> 
                          

                        </select>
                        </div>
                        <div style="padding: 10px;">
                        <label>Comments:</label>
                        <textarea type="text" maxlength="450" id="text" name="text" dir="auto" aria-label="Comments:" title="" style="width:97%;padding:12px 5px;border:solid 1px #cccccc;box-shadow:1px 1px 1px #333;word-wrap: break-word;"></textarea> 
                        </div><div style="text-align:center"><a ONCLICK="return updateCaseClosure()" style="background-color: #2a88da;cursor: pointer;padding: 5px;border-radius: 2px;font-family:arial;font-size:14px;font-weight:bold;" align="center">
Update Case
</a>
<span id="success2" style="margin-left:10px;color:green;display:none">Success!</span>
<span id="failed2" style="margin-left:10px;color:red;display:none">Failed!</span>
</div>                        </div>
                        </div>


</body>
</html>