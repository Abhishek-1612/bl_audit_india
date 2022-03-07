<script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script> 
<LINK HREF="/css/jquery.dataTables.min.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "searching": true,
        "info":     false,
        "order": [[ 3, "desc" ]],
    } );
    

} );


function selectdisposition(selectedid,selectedValues) 
{
 var res = selectedid.replace("final", "micro");
 $('#'+res).empty();
 if(selectedValues==='1'){
            $('#'+res).append(`<option value="${1}">${"No More Dealing Into this MCAT"}</option>`); 
            $('#'+res).append(`<option value="${2}">${"By Mistake BL Purchased By User"}</option>`);
            $('#'+res).append(`<option value="${3}">${"Want Buyleads deboosting from Mcat"}</option>`);
}else if(selectedValues==='2'){
            $('#'+res).append(`<option value="${1}">${"Wrong Or Generic Product Name By User"}</option>`); 
            $('#'+res).append(`<option value="${2}">${"Wrong Or Generic Product Mapping By User"}</option>`);
            $('#'+res).append(`<option value="${3}">${"Wrong Product Added by User"}</option>`);
}else if(selectedValues==='3'){
            $('#'+res).append(`<option value="${1}">${"Wrong Or Generic Product Name By Employee"}</option>`); 
            $('#'+res).append(`<option value="${2}">${"Wrong Or Generic Product Mapping By Employee"}</option>`);
            $('#'+res).append(`<option value="${3}">${"Wrong Or Generic Product Mapping By Auto Mapping"}</option>`);
            $('#'+res).append(`<option value="${4}">${"Wrong Or Generic Product Mapping At Production"}</option>`); 
            $('#'+res).append(`<option value="${5}">${"Wrong Or Generic Product Mapping At Production - Precise MCAT Not Available"}</option>`);
            $('#'+res).append(`<option value="${6}">${"Wrong Or Generic Product Mapping At Production - Precise MCAT Available"}</option>`);
            $('#'+res).append(`<option value="${7}">${"Wrong Or Generic Product Mapping By Auto Mapping - Precise MCAT Not Available"}</option>`);
            $('#'+res).append(`<option value="${8}">${"Wrong Or Generic Product Mapping By Auto Mapping - Precise MCAT Available"}</option>`);
            $('#'+res).append(`<option value="${9}">${"Wrong Product Added by Employee"}</option>`);
            
}else if(selectedValues==='4'){
            $('#'+res).append(`<option value="${1}">${"Wrong Keyword Searched at LEAP"}</option>`); 
            $('#'+res).append(`<option value="${2}">${"Wrong Buylead Approved"}</option>`);
            $('#'+res).append(`<option value="${3}">${"Wrong MCAT Mapping by Associate"}</option>`);
            $('#'+res).append(`<option value="${4}">${"Generic MCAT Mapping - Specific Not Available"}</option>`); 
            $('#'+res).append(`<option value="${5}">${"Generic MCAT Mapping - Specific Available"}</option>`);
            $('#'+res).append(`<option value="${6}">${"Insufficient Details in Buyleads - Must Call Cases"}</option>`);
}else if(selectedValues==='5'){
            $('#'+res).append(`<option value="${1}">${"Wrong Auto MCAT Mapped by Search - Precise Available"}</option>`); 
            $('#'+res).append(`<option value="${2}">${"Wrong MCAT Suggested by Search"}</option>`);
            $('#'+res).append(`<option value="${3}">${"Wrong Supplier Selected by Auto Selection"}</option>`);
}else if(selectedValues==='6'){
            $('#'+res).append(`<option value="${1}">${"Wrong MCAT to Subcat Mapping or Cleaning"}</option>`); 
            $('#'+res).append(`<option value="${2}">${"Duplicate MCAT - MCAT Merging Required"}</option>`);
            $('#'+res).append(`<option value="${3}">${"Alternate Name Correction-Updation Required"}</option>`);
            $('#'+res).append(`<option value="${4}">${"Wrong MCAT Name - Renaming Required"}</option>`);
}else if(selectedValues==='7'){
            $('#'+res).append(`<option value="${1}">${"Buyer's Preferred Location & Supplier's Location Mismatch"}</option>`); 
}else if(selectedValues==='8'){
            $('#'+res).append(`<option value="${1}">${"Users Deals into Specific Product-Service Type"}</option>`); 
            $('#'+res).append(`<option value="${2}">${"MOQ Issue"}</option>`);
            $('#'+res).append(`<option value="${3}">${"Dont Deal into Specific Brand"}</option>`);
            $('#'+res).append(`<option value="${4}">${"Wrong MCAT Name - Renaming Required"}</option>`);
}else if(selectedValues==='9'){
            $('#'+res).append(`<option value="${1}">${"Product Out of Stock"}</option>`); 
            $('#'+res).append(`<option value="${2}">${"Wrong NI Disposition Selected"}</option>`);
            $('#'+res).append(`<option value="${3}">${"No More Deals into Specific Product (Obsolete Product Exists)"}</option>`);
            $('#'+res).append(`<option value="${4}">${"By Mistake NI Marked"}</option>`);
            $('#'+res).append(`<option value="${5}">${"Other Issue"}</option>`);
}
selectsubdisposition(res,'1');
}

function selectsubdisposition(selectedid,selectedValues) 
{ 
 var major_dis = selectedid.replace("micro", "final");
 var res_comment = selectedid.replace("micro", "sp");
 var major_dis_val = $('#'+major_dis).val();
 if((major_dis_val==='1') && (selectedValues==='1')){
    $("#"+res_comment).html('MCAT to be marked as Negative MCAT.');
 }else if((major_dis_val==='1') && (selectedValues==='2')){
    $("#"+res_comment).html('MCAT to be marked as Negative MCAT.');
  }else if((major_dis_val==='1') && (selectedValues==='3')){
    $("#"+res_comment).html('No Action Required (Expectation Setting of User/Employee to be done)');
 }else if((major_dis_val==='2') && (selectedValues==='1')){
    $("#"+res_comment).html('Product Name to be modified');
 }else if((major_dis_val==='2') && (selectedValues==='2')){
    $("#"+res_comment).html('MCAT to be removed or not removed (if removed mark as Negative MCAT)');
 }else if((major_dis_val==='2') && (selectedValues==='3')){
    $("#"+res_comment).html('Product to be removed from Catalog');
 }else if((major_dis_val==='3') && (selectedValues==='1')){
    $("#"+res_comment).html('Product Name to be modified');
 }else if((major_dis_val==='3') && (selectedValues==='2')){
    $("#"+res_comment).html('MCAT to be removed or not removed (if removed mark as Negative MCAT)');
 }else if((major_dis_val==='3') && (selectedValues==='3')){
    $("#"+res_comment).html('MCAT to be removed or not removed (if removed mark as Negative MCAT)');
 }else if((major_dis_val==='3') && (selectedValues==='4')){
    $("#"+res_comment).html('MCAT to be removed or not removed (if removed mark as Negative MCAT)');
 }else if((major_dis_val==='3') && (selectedValues==='5')){
    $("#"+res_comment).html('MCAT to be removed or not removed (if removed mark as Negative MCAT)');
 }else if((major_dis_val==='3') && (selectedValues==='6')){
    $("#"+res_comment).html('MCAT to be removed or not removed and add precise MCAT (if removed mark as Negative MCAT)');
 }else if((major_dis_val==='3') && (selectedValues==='7')){
    $("#"+res_comment).html('MCAT to be removed or not removed (if removed mark as Negative MCAT)');
 }else if((major_dis_val==='3') && (selectedValues==='8')){
    $("#"+res_comment).html('MCAT to be removed or not removed (if removed mark as Negative MCAT)');
 }else if((major_dis_val==='3') && (selectedValues==='9')){
    $("#"+res_comment).html('Product to be removed from Catalog');
}else if((major_dis_val==='4') && (selectedValues==='1')){
    $("#"+res_comment).html('Mention Offer Id for the Wrong Keyword Searched');
 }else if((major_dis_val==='4') && (selectedValues==='2')){
    $("#"+res_comment).html('Mention Offer Id for the Wrong Buylead Approved');
 }else if((major_dis_val==='4') && (selectedValues==='3')){
    $("#"+res_comment).html('Mention Offer Id for the Wrong MCAT Mapping');
 }else if((major_dis_val==='4') && (selectedValues==='4')){
    $("#"+res_comment).html('Mention Offer Id for the Generic MCAT Mapping - Specific Not Available');
 }else if((major_dis_val==='4') && (selectedValues==='5')){
    $("#"+res_comment).html('Mention Offer Id for the Generic MCAT Mapping - Specific Available');
 }else if((major_dis_val==='4') && (selectedValues==='6')){
    $("#"+res_comment).html('Mention Offer Id for the Insufficient Details in Buyleads');
}else if((major_dis_val==='5') && (selectedValues==='1')){
    $("#"+res_comment).html('Bug to be opened for the Wrong Auto MCAT Mapped by Search.');
 }else if((major_dis_val==='5') && (selectedValues==='2')){
    $("#"+res_comment).html('Bug to be opened for the Wrong MCAT Suggested by Search');
 }else if((major_dis_val==='5') && (selectedValues==='3')){
    $("#"+res_comment).html('Bug to be opened for the Wrong Supplier Selected by Auto Selection');
 }else if((major_dis_val==='6') && (selectedValues==='1')){
    $("#"+res_comment).html('Bug to be opened for the MCAT to Subcat Mapping or Cleaning');
 }else if((major_dis_val==='6') && (selectedValues==='2')){
    $("#"+res_comment).html('Bug to be opened for the Duplicate MCAT - MCAT Merging Required');
 }else if((major_dis_val==='6') && (selectedValues==='3')){
    $("#"+res_comment).html('Bug to be opened for the Alternate Name Correction-Updation Required');
 }else if((major_dis_val==='6') && (selectedValues==='4')){
    $("#"+res_comment).html('Bug to be opened for the Wrong MCAT Name - Renaming Required');
 }else if((major_dis_val==='7') && (selectedValues==='1')){
    $("#"+res_comment).html('Guidance to be provided for the correct disposition');
 }else if((major_dis_val==='8') && (selectedValues==='1')){
    $("#"+res_comment).html('Guidance to be provided for the correct disposition');
 }else if((major_dis_val==='8') && (selectedValues==='2')){
    $("#"+res_comment).html('MOQ to be checked & Guidance to be provided for the correct disposition');
 }else if((major_dis_val==='8') && (selectedValues==='3')){
    $("#"+res_comment).html('Guidance to be provided for the correct disposition');
 }else if((major_dis_val==='9') && (selectedValues==='1')){
    $("#"+res_comment).html('Product to be marked Out Of Stock');
 }else if((major_dis_val==='9') && (selectedValues==='2')){
    $("#"+res_comment).html('Guidance to be provided for the correct disposition');
 }else if((major_dis_val==='9') && (selectedValues==='3')){
    $("#"+res_comment).html('Product to be removed from Catalog');
 }else if((major_dis_val==='9') && (selectedValues==='4')){
    $("#"+res_comment).html('No Action Required (Educate User about when to use which option)');
 }else if((major_dis_val==='9') && (selectedValues==='5')){
    $("#"+res_comment).html('No Action Required (Expectation Setting of User to be done)');
 }
 }
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
		<td style="text-align:center"><input type="checkbox" value="<?php echo $mcat["MCAT_ID"] ?>" id="check_<?php echo $mcat["MCAT_ID"]?> " 
                                                     name="name2" />
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
                                    <table width="100%" border="0"><tr>
                     <td style="width: 40%;"><b>Major Disposition:</b></td><td style="width: 60%;">
                    <select id="final<?php echo $mcat["MCAT_ID"]?>" name="final<?php echo $mcat["MCAT_ID"]?>" 
                            style="width: 99%;margin-left: 4px;margin-top: 2px;" onchange="selectdisposition(this.id,this.value)" >
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
                        <select id="micro<?php echo $mcat["MCAT_ID"]?>" name="micro<?php echo $mcat["MCAT_ID"]?>" style="width: 99%;" onchange="selectsubdisposition(this.id,this.value)">
                        </select>
                           </td></tr>
                    <tr><td><b>Comments:</b><br/>
                        <span id="sp<?php echo $mcat["MCAT_ID"];?>" style="color:#00A619"></span></td><td>
                            <textarea type="text" maxlength="1000" id="comment<?php echo $mcat["MCAT_ID"];?>" name="comment<?php echo $mcat["MCAT_ID"];?>" dir="auto" aria-label="Comments:" title="" 
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
