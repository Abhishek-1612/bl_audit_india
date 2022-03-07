<html>
   <head>
   <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
        <script>
   

        function updateEmployee(){
            $("#saveEmp").attr('disabled', true);
            $('#success3').css('display','none');
	        $('#failed3').css('display','none');
            var selectArr = [];
            // $("input[name=name2]:checked").each(function(){
			// 	mcatList.push($(this).val());
			// });
            var counter = 0;
            $("td.selectClass select").each(function(){
                
                var empid=$(this).val();
                if(empid){
                    var glid=$(this).attr('data-id');
                    
                    selectArr[counter]=glid+"-"+empid;
                    //selectArr[counter]['empid']=empid;
                    counter++;
                }
            });
    // alert(selectArr);
    console.log(selectArr);
          var url = "/index.php?r=admin_bl/Eto_rej_ofr/UpdateEmp";
			
                $.ajax({
                    type: "POST",
                    url: url,
                    data:{selectArr:selectArr},
                    //async: false,
                    success: function(result){
                        $("#saveEmp").attr('disabled', false);
                        if(result=='Yes'){
                            $('#success2').css('display','inline-block');
                            // setTimeout(function(){$('#success2').fadeIn();  }, 6000);
                        }else{
                            $('#failed2').css('display','inline-block');
                        // setTimeout(function(){ $('#failed2').fadeIn(); }, 6000);
                        }
                                
                            },
                    error: function() {
                        $('#failed2').css('display','inline-block');
                         }
                });
        }
        </script>
        <body>
      <div >
    <center><h3 style="background-color:rgb(0, 109, 204);color: rgb(255, 255, 255);padding: 2px;">Glid to be worked upon today :</h3></center>


<br>
<div id="drop_info" class="inline">
                <div id="loading" style="display:none;" align="center"><img src="/images/loading2-new.gif"> Loading...</div>
                <div id="error" style="display:none;" align="center"><font color="red">Something Went Wrong. Kindly Try again.</font></div>
                <div id="drop_div" class="inline">
                <div style="height: auto;width:100%;margin-left:10%;overflow-x: auto;">
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
    <tr class="test1" style="text-align: center;" >
			<td><span ><a style="text-decoration:none;color:black;cursor:pointer" href="/index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3373&report=<?php echo @$row["SUPPLIER_GLID"]?>" target= "_blank"><?php echo @$row["SUPPLIER_GLID"]?></a></span></td>
			<td><?php echo @$row["REJ_CNT_TOP20_YESTERDAY"]?></td>
			<td><?php echo @$row["REJ_CNT_TOP20_30DAYS"]?></td>
			<td class="selectClass">
            <?php  
            if(isset($row["employeeid"])){ ?>
                        <select data-id="<?php echo $row['SUPPLIER_GLID'] ?>" id="micro" name="micro" style="width: 50%;">
                            <option value="">--Select--</option>
                      <?php if(!empty($dropDown['employee'])){ ?>
                            <?php foreach($dropDown['employee'] as $key=>$value) { 
                            if($key == $row['employeeid']){ ?>
                               <option value="<?php echo $key ?>" selected>   <?php echo $value ?></option> 
                               <?php } else {  ?>
                                <option value="<?php echo $key ?>">   <?php echo $value ?></option> 
                              <?php } ?>
                               <?php } ?>
                               <?php } ?>
                        </select>
                        <?php } else { ?>
                            <select data-id="<?php echo $row['SUPPLIER_GLID'] ?>" id="micro" name="micro" style="width: 50%;">
                            <option value="" selected>--Select--</option>
                      <?php if(!empty($dropDown['employee'])){ ?>
                            <?php foreach($dropDown['employee'] as $key=>$value) { ?>
                               <option value="<?php echo $key ?>">   <?php echo $value ?></option> 
                               <?php } ?>
                               <?php } ?>
                        </select>
                      <?php  } ?>
                       </td>
			
		</tr>
<?php } 
 ?>

</table>
<div style="margin-left: 35%;    margin-top: 15px;"><a id="saveEmp" ONCLICK="return updateEmployee()" style="background-color: #2a88da;cursor: pointer;padding: 5px;border-radius: 2px;font-family:arial;font-size:14px;font-weight:bold;" align="center">
Update
</a>
<span id="success3" style="margin-left:10px;color:green;display:none">Success!</span>
<span id="failed3" style="margin-left:10px;color:red;display:none">Failed!</span>
</div></div>
                </div>
             
            </div>
      </div>
      </body>
      </head>
      </html>