<html>
<body>
<div style="height: auto;width:100%;margin-left:10%;overflow-x: auto;">
<div ><b>&nbsp;Details: </b></div>
<table class="table table-bordered table-condensed" style="width:80%;font-size: 13px;background-color:#F0F9FF;white-space: nowrap;">
		<tr style="background: none repeat scroll 0% 0% rgb(0, 109, 204); color: rgb(255, 255, 255);">
			<th>Glid</th>
			<th>No. Of Wrong Product NI Feedback(Yesterday)</th>
			<th>No. Of Wrong Product NI Feedback(Last 30 Days)</th>
			<th>Assigned To</th>
        </tr>
<?php	
// echo "<pre>";print_R($negMcats);
// echo "<pre>";print_R($data);
// exit;	
foreach($data['data'] as $row)
{
    // print_r($row);
	?>
    <tr   style="text-align: center;">
			<td><span ><a style="text-decoration:none;color:black;cursor:pointer" href="/index.php?r=admin_bl/NonInterested/SecondPage&mid=3373&report=<?php echo @$row["SUPPLIER_GLID"]?>" target= "_blank"><?php echo @$row["SUPPLIER_GLID"]?></a></span></td>
			<td><?php echo @$row["REJ_CNT_TOP20_YESTERDAY"]?></td>
			<td><?php echo @$row["REJ_CNT_TOP20_30DAYS"]?></td>
			<td>
            <?php 
            if(isset($row["employeeid"])){ ?>
                        <select onchange="updateEmployee(<?php echo @$row['SUPPLIER_GLID']?>,this)" id="micro" name="micro" style="width: 50%;">
                            <option value="">--Select--</option>
                      <?php if(!empty($dropDown['employee'])){ ?>
                            <?php foreach($dropDown['employee'] as $value) { 
                            if($value['employeeid'] == $row['employeeid']){ ?>
                               <option  value="<?php echo $value['employeeid'] ?>" selected>   <?php echo $value['employeename'] ?></option> 
                               <?php } else {  ?>
                                <option  value="<?php echo $value['employeeid'] ?>">   <?php echo $value['employeename'] ?></option> 
                              <?php } ?>
                               <?php } ?>
                               <?php } ?>
                        </select>
                        <?php } else { ?>
                            <select onchange="updateEmployee(<?php echo @$row['SUPPLIER_GLID']?>,this)" id="micro" name="micro" style="width: 50%;">
                            <option value="" selected>--Select--</option>
                      <?php if(!empty($dropDown['employee'])){ ?>
                            <?php foreach($dropDown['employee'] as $value) { ?>
                               <option  value="<?php echo $value['employeeid'] ?>">   <?php echo $value['employeename'] ?></option> 
                               <?php } ?>
                               <?php } ?>
                        </select>
                      <?php  } ?>
                       </td>
			
		</tr>
<?php } 
exit; ?>

</table>
</div>

</body>
</html>