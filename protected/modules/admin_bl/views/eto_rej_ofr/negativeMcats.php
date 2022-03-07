
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
<span id="success3" style="margin-left:10px;color:green;display:none">Success!</span>
<span id="failed3" style="margin-left:10px;color:red;display:none">Failed!</span>
</div>
</div>
<?php }else { ?>
    <div><center style="color: black;margin-top: 30px;font-weight: bold;">No records of Negative MCAT for respective GLID.</center></div>
 <?php   }?>

 <div style="margin-left: 10%;width: 80%;border:solid 2px black;margin-top:8px;font-family: sans-serif;">
<p style="text-align:center"><b>&nbsp;Call Update:</b></p> 
<div style="text-align: center;margin-bottom: 25px;font-size: 13px;">

<span style="padding-right: 25px;"><input name="rType" id="rType1" value="callAnswered" type="radio"> Call Answered&nbsp;&nbsp;</span>

<span style="padding-left: 25px;"><input name="rType" id="rType2" value="callNotAnswered" type="radio"> Call Not Answered&nbsp;&nbsp;</span>
<div style="text-align:center;margin-top: 15px;"><a ONCLICK="return updateCall()" style="margin-bottom: 15px;margin-top: 10px;background-color: #2a88da;cursor: pointer;padding: 5px;border-radius: 2px;font-family:arial;font-size:14px;font-weight:bold;" align="center">
Update
</a>
<span id="success4" style="margin-left:10px;color:green;display:none">Success!</span>
<span id="failed4" style="margin-left:10px;color:red;display:none">Failed!</span>
</div>                        </div> 
                        </div>


</body>
</html>