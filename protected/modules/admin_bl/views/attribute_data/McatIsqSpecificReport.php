<?php
    $mid=isset($param['mid'])?$param['mid']:'';
    
    $selectType=isset($param['propertyType'])?$param['propertyType']:'';
    $mcatType=isset($param['selectType'])?$param['selectType']:'';
    $modid=isset($param['modid'])?$param['modid']:'';
    $orgselect=isset($param['orgselect'])?$param['orgselect']:'';
    $prodType=isset($param['prodType'])?$param['prodType']:'';
    $hostType=isset($param['hostType'])?$param['hostType']:'';
    $start_date=isset($param['start_date'])?$param['start_date']:'';
    $end_date=isset($param['end_date'])?$param['end_date']:'';
    $leadtype=isset($param['leadtype'])?$param['leadtype']:'';        
    $obuy=isset($selectType)&& $selectType  ==    'OverAll Buylead'?"selected":'';
    $dbuy=isset($selectType)&& $selectType  ==    'Direct Buylead'?"selected":'';
    $fenq=isset($selectType)&& $selectType  ==    'FENQ'?"selected":'';
    $enq=isset($selectType)&& $selectType   ==    'Enquires'?"selected":'';
    $prod=isset($selectType)&& $selectType  ==    'Products'?"selected":'';
    
    $msel=isset($mcatType)&& $mcatType=='MCAT'?"selected":'';
    $csel=isset($mcatType)&& $mcatType=='CATEGORY'?"selected":'';
    
    
    $des=isset($modid)&& $modid=='Desktop'?"selected":'';
    $mob=isset($modid)&& $modid=='Mobile'?"selected":'';
    $app=isset($modid)&& $modid=='App'?"selected":'';
    
    $organicchecked=isset($orgselect)&& ($orgselect=='organic' || $orgselect=='')?"checked":'';
    $inorganicchecked=isset($orgselect)&& $orgselect=='inorganic'?"checked":'';
    $freechecked=isset($prodType)&& $prodType=='free' || $prodType=='' ? "checked":'';
    $paidchecked=isset($prodType)&& $prodType=='paid'?"checked":'';
    $newchecked=isset($hostType)&& $hostType=='new'?"checked":'';
    $allchecked=isset($hostType)&& $hostType=='all'?"checked":'';
    $leadtype_gen=isset($leadtype)&& ($leadtype=='Generation' || $leadtype=='') ? "checked":'';
    $leadtype_app=isset($leadtype)&& $leadtype=='Approved'?"checked":'';
    
            
?>
<head>
    
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script language="javascript" src="/js/calendar.js"></script>
        <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
        <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
   <style type="text/css">
             .ui-datepicker  
              {
                font-size: 15px;
              }
</style> 
    <script>
        

      function lookup(idd,obj,divId) {
		var inputString=$('#'+idd).val();
                
		if(inputString.length == 0) {
			$('#'+divId).html('<div></div>');
		} else if(inputString.length > 2){
			if(/[.]/.test(inputString)){
				$('#'+divId).html('<div></div>');
			}
			else
			{
				var typ='';
				
                                         var reportType=$('input[name="radioService"]:checked').val();
                            				
                                $.post("/cron/rpc3.php", {queryString: ""+inputString+"", ff: ""+reportType+"",searchtype:""+obj+""}, function(data){
					if(data.length >0) {
						$('#'+divId).html(data);
					}
					else{
						$('#'+divId).html('<div></div>');
					}

				});
                            
                            
			}
		}
		else if(inputString.length <=2){
			$('#'+divId).html('<div></div>');
		}
	}
        function showhide(tab){
            if(tab=='product'){
                    
                    $("#radio_val").val('P');
            }
            else{
                    $("#radio_val").val('S');
            }
        }
        function abcMcats(mcatname,mcatid){
            var newmcatlist=$("<div id='"+mcatid+"'><input  name='new_mcat[]' id='"+mcatid+"' type='text' value='"+mcatname+"' readonly style='height:30px'><a id='link"+mcatid+"' href=\"javascript:removeElement('"+mcatid+"','moreMcats');\" ><img id='img"+mcatid+"' src='<?php echo Yii::app()->request->baseUrl; ?>/gifs/minus.gif'/></a></div>");
            
            $("#moreMcats").append(newmcatlist);
            $x=$("#McatsIDs").val();
            if($x==''){
                $x=mcatid;
            }
            else{
                $x=$x+','+mcatid;
            }
            
            $("#McatsIDs").val($x);
        }
        function abcCats(catname,catid){
            var newcatlist=$("<div id='"+catid+"'><input  name='new_cat[]' id='"+catid+"' type='text' value='"+catname+"' readonly style='height:30px'><a id='link"+catid+"' href=\"javascript:removeElement('"+catid+"','moreCats');\" ><img id='img"+catid+"' src='<?php echo Yii::app()->request->baseUrl; ?>/gifs/minus.gif'/></a></div>");
            $("#moreCats").append(newcatlist);
            var $x=$("#CatsIDs").val();
            if($x==''){
                $x=catid;
            }
            else{
                $x=$x+','+catid;
            }
            
            $("#CatsIDs").val($x);
        }
        
        function removeElement(mcatid,spanid){
            var mcatString =$('#McatsIDs').val();
            var mcatarr = mcatString.split(",");

            var index = mcatarr.indexOf(mcatid);
            mcatarr= mcatarr.splice(index, 1);
            mcatString=mcatarr.join(',');

            $('#McatsIDs').val(mcatString);
            var d = document.getElementById(spanid);
            var oldmcatid = document.getElementById(mcatid);
            var imgid = document.getElementById("img"+mcatid);
            var linkid= document.getElementById("link"+mcatid);
            d.removeChild(oldmcatid);
            d.removeChild(linkid);
            imgid.parentNode.removeChild(imgid);
        }
        function setCriteriaType(){

       criteriatyp =$( "#radioCriteria option:selected" ).text();
       if(criteriatyp!='Select Search Type'){
       $('#search_'+criteriatyp).show();
       $('#spanhide').show();
       $('#tr1').show();
       $('#tr2').show();
       $("#product").attr('checked', true);
   }
   if(criteriatyp=='Select Search Type'){
       $('#tr1').hide();
        $('#tr2').hide();
   }
   if(criteriatyp=='MCAT'){
        $('#search_CATEGORY').hide();
       
        $('#moreCats').html('');
        $('#cats').html('');
        $('#cat_name').val('');
        
        $("#CatsIDs").val('');
        $("#McatsIDs").val('');
   }
   else if(criteriatyp=='CATEGORY'){
        $('#search_MCAT').hide();
        
         $('#moreMcats').html('');
         $('#mcats').html('');
         $('#mcat_name').val('');
         
         $("#McatsIDs").val('');
         
   }
   
   }
   function setorganic(org,sel){
    if(org=='organic'){
         $("#organic").val(org);
         $("#"+org).attr('checked', true);
    }
    else if(org=='inorganic'){
         $("#inorganic").val(org);
         $("#"+org).attr('checked', true);
    }
    if(org=='free'){
         $("#free").val(org);
         $("#"+org).attr('checked', true);
    }
    if(org=='paid'){
         $("#paid").val(org);
         $("#"+org).attr('checked', true);
    }
    if(org=='new'){
         $("#new").val(org);
         $("#"+org).attr('checked', true);
    }
    if(org=='all'){
         $("#all").val(org);
         $("#"+org).attr('checked', true);
    }
    if(org=='Products'){
        $(".prd").show();
        $(".leadtype").hide();
        $(".mod").show();
        
    }
    if(org=='Enquires'){
       $(".leadtype").hide();
    }
     if(org=='OverAll Buylead' || org=='Direct Buylead' || org=='FENQ'){
       $(".leadtype").show();
    }
    
    
    else if(sel=='select' && org!='Products'){
        $(".prd").hide();
        $("#free").prop('checked', false);
        $("#paid").prop('checked', false);
        $("#new").prop('checked', false);
        $("#all").prop('checked', false);
        
    }
    
   }
   
    function setorganic1(org){
    
    if(org.value=='Generation')
    {
     $(".typeOrg").hide();
    }
    
    if(org.value=='Approved')
    {
     $(".typeOrg").show();
    }
    
    }
   function check_validation(){
       var start_date=$("#start_date").val();
       var end_date=$("#end_date").val();
       if(!start_date || !end_date){
            alert('start date and end date are mandatory.')
            return false;
        }
   }
    </script>
</head>
<body><input name="frame_height" id="frame_height" value="" type="hidden">
    <form  id='dataform' name='dataform' action="/index.php?r=admin_bl/Attribute_data/McatISQReport&mid=<?php echo $mid?>" method="POST" onsubmit="return check_validation()">
        <table cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1" width="100%" style="border-collapse: collapse;">
            <tr>
                <td bgcolor="#dff8ff" align="center" colspan="2"><font color=" #333399"><b>MCAT Specific ISQ Report</b></font></td>
            </tr>
            <tr>
                <td width="32%"> Select date: </td>
                <td>
                    
                        <input name="start_date" type="text"  VALUE="<?php echo $start_date; ?>" SIZE="13" 
                               onfocus="displayCalendar(document.dataform.start_date,'dd-mm-yyyy',this,'','','start_date')" 
                               onclick="displayCalendar(document.dataform.start_date,'dd-mm-yyyy',this,'','','start_date')" 
                               id="start_date" TYPE="text" readonly="readonly" >
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                        <input name="end_date" type="text"  required VALUE="<?php echo $end_date; ?>" SIZE="13" 
                               onfocus="displayCalendar(document.dataform.end_date,'dd-mm-yyyy',this,'','','end_date')" 
                               onclick="displayCalendar(document.dataform.end_date,'dd-mm-yyyy',this,'','','end_date')" 
                               id="end_date" TYPE="text" readonly="readonly" >
                    
                </td>
            </tr>
            <tr>
                
                <td width="32%">Property type:<font color="red">*</font></td>
                <td>
                    <select  name="propertyType" id="propertyType"  onchange="setorganic(this.value,'select')" required>
                        
                        <option value="OverAll Buylead" <?php echo $obuy?>>OverAll Buylead</option>
                        <option value="Direct Buylead" <?php echo $dbuy?>>Direct Buylead</option>
                        <option value="FENQ" <?php echo $fenq?>>FENQ</option>
                        <option value="Enquires" <?php  echo $enq?>>Enquires</option>
                        <option value="Products" <?php  echo $prod?>>Products</option>
                    </select>
                </td>

            </tr>
            
            <tr class="leadtype">
                <td width="32%">Select Generation/Approved</td>
                <td>
                     Generation&nbsp;<input type="radio" name="leadtype" id="leadtype" value="Generation"    <?php echo $leadtype_gen?> onclick="setorganic1(this)" > &nbsp;&nbsp;&nbsp;&nbsp;
                    Approved&nbsp;<input type="radio" name="leadtype" id="leadtype" value="Approved"   <?php echo $leadtype_app?> onclick="setorganic1(this)">
                </td>
            </tr>
            
            
            <tr class="mod">
                
                <td width="32%">Modid:</td>
                <td>
                    <select  name="modid" id="modid" >
                        <option value=""> Modid</option>
                        <option <?php echo $des?>>Desktop</option>
                        <option <?php echo $mob?>>Mobile</option>
                        <option <?php echo $app?>>App</option>
                    </select>
                </td>
            </tr>
            <tr class="typeOrg" style="display:none">
                <td width="32%">Select Organic/Inorganic</td>
                <td>

                    Organic<input type="radio" name="orgselect" id="organic" value="organic"    <?php echo $organicchecked?>  onclick="setorganic(this.id,'')"> &nbsp;&nbsp;&nbsp;
                    Organic + Inorganic<input type="radio" name="orgselect" id="inorganic" value="inorganic"   <?php echo $inorganicchecked?> onclick="setorganic(this.id,'')">
                </td>
            </tr>
           
            

                <tr class="prd" style="display:none">
                    <td width="32%">Select Product Type </td>
                    <td>

                        Free<input type="radio" name="prodType" id="free" value=""    <?php echo $freechecked?>  onclick="setorganic(this.id,'')"> &nbsp;&nbsp;&nbsp;
                        Paid<input type="radio" name="prodType" id="paid" value=""   <?php echo $paidchecked?> onclick="setorganic(this.id,'')">
                    </td>
                </tr>

            <tr class="prd" style="display:none">
                <td width="32%">Select Hosting Type </td>
                <td>

                    New Hosting<input type="radio" name="hostType" id="new" value=""    <?php echo $newchecked?>  onclick="setorganic(this.id,'')"> &nbsp;&nbsp;&nbsp;
                    OverAll<input type="radio" name="hostType" id="all" value=""   <?php echo $allchecked?> onclick="setorganic(this.id,'')">
                </td>
            </tr>

            <tr>
                
                <td width="32%">Search type:</td>
                <td>
                    <select  name="selectType" id="radioCriteria" onChange="setCriteriaType();">
                        <option value="">Select Search Type</option>
                        <option <?php echo $msel?>>MCAT</option>
                        <option <?php echo $csel?>>CATEGORY</option>
                        
                    </select>
                </td>
            </tr>
            
            <tr id="tr1" style="display:none">
            
            <td> 
                <div id="search_MCAT" style="display:none;">
                    <span>
                        Mcat Id:&nbsp;&nbsp;&nbsp;
                        <input type="text" name="mcat_name" id="mcat_name" autocomplete="off" onkeyup="lookup('mcat_name','MCAT','mcats');" value="" style="height:30px">                        
                    </span>
                    
                    
                    
                </div>
                <div id="search_CATEGORY" style="display:none;">
                    <span>
                        Category Id:
                        &nbsp;&nbsp;&nbsp;
                        <input type="text" name="cat_name" id="cat_name" autocomplete="off" onkeyup="lookup('cat_name','CATEGORY','cats');" value="" style="height:30px">                        
                    </span>
                  </div>
                
                
            </td>
            <td>
                <span id="spanhide" style="display:none">
                        <input type="radio" name="radioService" id="product"  value="P"  onclick="showhide('product');">Product
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="radioService" id="service" value="S" onclick="showhide('service');" >Service
                </span>
                <input type="hidden" value="P" id="radio_val" name="radio_val">
            </td>
        </tr>
        <tr id="tr2" style="display:none;">
            <td>
                <div style="height:300px;overflow:auto;">
                    <div id="mcats"></div>
                    <div id="cats"></div>
                    
                </div>
            </td>
          <td>
                <div style="height:300px;overflow:auto">
                    <span style="overflow:auto;" id="moreMcats"></span>
                    <input type="hidden" name="McatsIDs" value="" id="McatsIDs">
                    <span style="overflow:auto;" id="moreCats"></span>
                    <input type="hidden" name="CatsIDs" value="" id="CatsIDs">
                    
                </div>
            </td>  
        </tr>
        
            <tr>
                <td align="center" colspan="2">
                    <input type="Submit" name="Report" value="Report" class="btn btn-small btn-primary" >        
                </td>
            </tr>
        </table>
</body>
<?php
if(!empty($param['Report'])){
    if(!empty($param['data'])){
       
        $data=$param['data'];
        ?>
<BR><BR>
<?php if($selectType=='OverAll Buylead' || $selectType=='Direct Buylead' || $selectType=='FENQ'){ 

 if($orgselect =='organic')
 $typ="Generated";
 if($orgselect =='inorganic')
 {
  if($leadtype =='Generation')
  {
  $typ="Generated";
  }
  else
  {
   $typ="Approved";
  }
 }
 
 echo '<table cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1" width="100%" style="border-collapse: collapse;">
    
    <tr>
        <td bgcolor="#dff8ff" align="center" colspan="8"><font color=" #333399"><b>Summary</b></font></td>
    </tr>
    <tr>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Mcat ID</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total '.$typ.' BL</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>'.$typ.' With ISQ Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>'.$typ.'  ISQ Filled</b></font></td>
         <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Filled</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Fill Rate%</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Oppturnity Fill Rate%</b></font></td>
    </tr>';
    $TOTAL_GENERATED=0;
    $GENERATED_WITH_ISQ_AVAIL=0;
    $GEN_ISQ_QUESTIONS_FILLED_USER=0;
    $GEN_ISQ_QUESTIONS_AVAIL=0;
    $GEN_ISQ_QUESTIONS_FILLED=0;
    $j=0;
 foreach($data as $row){
     
      if($orgselect =='organic'){
      
        $TOTAL_GENERATED=$TOTAL_GENERATED+$row['TOTAL_GENERATED'];
        $GENERATED_WITH_ISQ_AVAIL=$GENERATED_WITH_ISQ_AVAIL+$row['GENERATED_WITH_ISQ_AVAIL'];
        $GEN_ISQ_QUESTIONS_FILLED_USER=$GEN_ISQ_QUESTIONS_FILLED_USER+$row['GEN_ISQ_QUESTIONS_FILLED_USER'];
        $GEN_ISQ_QUESTIONS_AVAIL=$GEN_ISQ_QUESTIONS_AVAIL+$row['GEN_ISQ_QUESTIONS_AVAIL'];
        $GEN_ISQ_QUESTIONS_FILLED=$GEN_ISQ_QUESTIONS_FILLED+$row['GEN_ISQ_QUESTIONS_FILLED'];
        
      
      }
     if($orgselect =='inorganic'){
     if($leadtype =='Generated')
      {
        $TOTAL_GENERATED=$TOTAL_GENERATED+$row['TOTAL_GENERATED'];
        $GENERATED_WITH_ISQ_AVAIL=$GENERATED_WITH_ISQ_AVAIL+$row['GENERATED_WITH_ISQ_AVAIL'];
        $GEN_ISQ_QUESTIONS_FILLED_USER=$GEN_ISQ_QUESTIONS_FILLED_USER+$row['GEN_ISQ_QUESTIONS_FILLED_USER'];
        $GEN_ISQ_QUESTIONS_AVAIL=$GEN_ISQ_QUESTIONS_AVAIL+$row['GEN_ISQ_QUESTIONS_AVAIL'];
        $GEN_ISQ_QUESTIONS_FILLED=$GEN_ISQ_QUESTIONS_FILLED+$row['GEN_ISQ_QUESTIONS_FILLED'];
      }
    
      else
      {
        $TOTAL_GENERATED=$TOTAL_GENERATED+$row['TOTAL_APPROVED'];
        $GENERATED_WITH_ISQ_AVAIL=$GENERATED_WITH_ISQ_AVAIL+$row['APPROVED_WITH_ISQ_AVAIL'];
        $GEN_ISQ_QUESTIONS_FILLED_USER=$GEN_ISQ_QUESTIONS_FILLED_USER+$row['APP_ISQ_QUESTIONS_FILLED_USER'];
        $GEN_ISQ_QUESTIONS_AVAIL=$GEN_ISQ_QUESTIONS_AVAIL+$row['APP_ISQ_QUESTIONS_AVAIL'];
        $GEN_ISQ_QUESTIONS_FILLED=$GEN_ISQ_QUESTIONS_FILLED+$row['APP_ISQ_QUESTIONS_FILLED'];
      }
     }
     $j++;
     }
       $fill_rate=round(($GEN_ISQ_QUESTIONS_FILLED_USER/$GENERATED_WITH_ISQ_AVAIL),2)*100;
       $fill_rate_opp=round(($GEN_ISQ_QUESTIONS_FILLED/$GEN_ISQ_QUESTIONS_AVAIL),2)*100;
       
       
        echo '<tr>
        <td align="center">ALL</td>
        <td align="center">'.$TOTAL_GENERATED.'</td>
        <td align="center">'.$GENERATED_WITH_ISQ_AVAIL.'</td>
        <td align="center">'.$GEN_ISQ_QUESTIONS_FILLED_USER.'</td>
        <td align="center">'.$GEN_ISQ_QUESTIONS_AVAIL.'</td>
        <td align="center">'.$GEN_ISQ_QUESTIONS_FILLED.'</td>
        <td align="center">'.$fill_rate.'%</td>
        <td align="center">'.$fill_rate_opp.'%</td>
                    </tr>';
 
 echo '</table>';
 
 echo '<br><br><table cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1" width="100%" style="border-collapse: collapse;">
    
    <tr>
        <td bgcolor="#dff8ff" align="center" colspan="8"><font color=" #333399"><b>Total Records:'.$j.'</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<input type="Submit" name="Report" value="Export To XL" class="" ></td>
    </tr>
    <tr>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Mcat ID</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total '.$typ.' BL</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>'.$typ.' With ISQ Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>'.$typ.'  ISQ Filled</b></font></td>
         <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Filled</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Fill Rate%</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Oppturnity Fill Rate%</b></font></td>
    </tr>';
     
       $i=0;
        foreach($data as $row){
           
      if($orgselect =='organic'){
      
       $fill_rate=round(($row['GEN_ISQ_QUESTIONS_FILLED_USER']/$row['GENERATED_WITH_ISQ_AVAIL']),2)*100;
       $fill_rate_opp=round(($row['GEN_ISQ_QUESTIONS_FILLED']/$row['GEN_ISQ_QUESTIONS_AVAIL']),2)*100;
        
        if($row['GENERATED_WITH_ISQ_AVAIL'] != 0 || $row['GEN_ISQ_QUESTIONS_FILLED_USER'] != 0 || $row['GEN_ISQ_QUESTIONS_AVAIL'] != 0 || $row['GEN_ISQ_QUESTIONS_FILLED'] != 0)
        {
        echo '<tr>
        <td align="center">'.$row['FK_GLCAT_MCAT_ID'].'</td>
        <td align="center">'.$row['TOTAL_GENERATED'].'</td>
        <td align="center">'.$row['GENERATED_WITH_ISQ_AVAIL'].'</td>
        <td align="center">'.$row['GEN_ISQ_QUESTIONS_FILLED_USER'].'</td>
         <td align="center">'.$row['GEN_ISQ_QUESTIONS_AVAIL'].'</td>
        <td align="center">'.$row['GEN_ISQ_QUESTIONS_FILLED'].'</td>
        <td align="center">'.$fill_rate.'%</td>
        <td align="center">'.$fill_rate_opp.'%</td>
                    </tr>';
         $i++;           
        }
        }
        if($orgselect =='inorganic'){
        if($leadtype =='Generated')
        {
        $fill_rate=round(($row['GEN_ISQ_QUESTIONS_FILLED_USER']/$row['GENERATED_WITH_ISQ_AVAIL']),2)*100;
        $fill_rate_opp=round(($row['GEN_ISQ_QUESTIONS_FILLED']/$row['GEN_ISQ_QUESTIONS_AVAIL']),2)*100;
        
        if($row['GENERATED_WITH_ISQ_AVAIL'] != 0 || $row['GEN_ISQ_QUESTIONS_FILLED_USER'] != 0 || $row['GEN_ISQ_QUESTIONS_AVAIL'] != 0 || $row['GEN_ISQ_QUESTIONS_FILLED'] != 0)
        {
        echo '<tr>
        <td align="center">'.$row['FK_GLCAT_MCAT_ID'].'</td>
        <td align="center">'.$row['TOTAL_GENERATED'].'</td>
        <td align="center">'.$row['GENERATED_WITH_ISQ_AVAIL'].'</td>
        <td align="center">'.$row['GEN_ISQ_QUESTIONS_FILLED_USER'].'</td>
        <td align="center">'.$row['GEN_ISQ_QUESTIONS_AVAIL'].'</td>
        <td align="center">'.$row['GEN_ISQ_QUESTIONS_FILLED'].'</td>
        <td align="center">'.$fill_rate.'%</td>
        <td align="center">'.$fill_rate_opp.'%</td>
                    </tr>';
         $i++;
         }
        }
        else
        {
         $fill_rate=round(($row['APP_ISQ_QUESTIONS_FILLED_USER']/$row['APPROVED_WITH_ISQ_AVAIL']),2)*100;
         $fill_rate_opp=round(($row['APP_ISQ_QUESTIONS_FILLED']/$row['APP_ISQ_QUESTIONS_AVAIL']),2)*100;
        if($row['APPROVED_WITH_ISQ_AVAIL'] != 0 || $row['APP_ISQ_QUESTIONS_FILLED_USER'] != 0 || $row['APP_ISQ_QUESTIONS_AVAIL'] != 0 || $row['APP_ISQ_QUESTIONS_FILLED'] != 0)
        {
        echo '<tr>
        <td align="center">'.$row['FK_GLCAT_MCAT_ID'].'</td>
        <td align="center">'.$row['TOTAL_APPROVED'].'</td>
        <td align="center">'.$row['APPROVED_WITH_ISQ_AVAIL'].'</td>
        <td align="center">'.$row['APP_ISQ_QUESTIONS_FILLED_USER'].'</td>
        <td align="center">'.$row['APP_ISQ_QUESTIONS_AVAIL'].'</td>
        <td align="center">'.$row['APP_ISQ_QUESTIONS_FILLED'].'</td>
        <td align="center">'.$fill_rate.'%</td>
        <td align="center">'.$fill_rate_opp.'%</td>
                    </tr>';
       $i++;
        }
        }
        
        }
         if($i==10)
         break;
        }
        echo '</table>';
        
        }
        
        if($selectType =='Enquires')
        {
         echo '<table cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1" width="100%" style="border-collapse: collapse;">
    
    <tr>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Mcat ID</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Enquires</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Enquires With ISQ Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Enquires  ISQ Filled</b></font></td>
         <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Fill Rate%</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Oppturnity Fill Rate%</b></font></td>
    </tr>';
    
    $TOTAL_GENERATED=0;
    $ENQUIRY_WITH_ISQ=0;
    $TOTAL_FILLED_QUES=0;
    $TOTAL_DIST_QUESTIONS=0;
    $j=0;
    
    foreach($data as $row){
     
        $TOTAL_GENERATED=$TOTAL_GENERATED+$row['TOTAL_ENQUIRY'];
        $ENQUIRY_WITH_ISQ=$ENQUIRY_WITH_ISQ+$row['ENQUIRY_WITH_ISQ'];
        $TOTAL_FILLED_QUES=$TOTAL_FILLED_QUES+$row['TOTAL_FILLED_QUES'];
        $TOTAL_DIST_QUESTIONS=$TOTAL_DIST_QUESTIONS+$row['TOTAL_DIST_QUESTIONS'];
       $j++;
       }
    
       $fill_rate=round(($TOTAL_FILLED_QUES/$TOTAL_DIST_QUESTIONS),2)*100;
       $fill_rate_opp=round(($ENQUIRY_WITH_ISQ/$TOTAL_DIST_QUESTIONS),2)*100;
       
        echo '<tr>
        <td align="center">ALL</td>
        <td align="center">'.$TOTAL_GENERATED.'</td>
        <td align="center">'.$ENQUIRY_WITH_ISQ.'</td>
        <td align="center">'.$TOTAL_FILLED_QUES.'</td>
        <td align="center">'.$TOTAL_DIST_QUESTIONS.'</td>
        <td align="center">'.$fill_rate.'%</td>
        <td align="center">'.$fill_rate_opp.'%</td>
                    </tr>';
          echo '</table>'; 
     
     
     echo '<br><br><table cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1" width="100%" style="border-collapse: collapse;">
         
          <tr>
	  <td bgcolor="#dff8ff" align="center" colspan="8"><font color=" #333399"><b>Total Records:'.$j.'</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<input type="Submit" name="Report" value="Export To XL" class="" ></td>
	  </tr>
    
    <tr>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Mcat ID</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Enquires</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Enquires With ISQ Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Enquires With ISQ Filled</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Fill Rate</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Fill Rate Oppturnity</b></font></td>
    </tr>';
    $i=0;
    foreach($data as $row)
    {
   
    $fill_rate=round(($row['TOTAL_FILLED_QUES']/$row['TOTAL_DIST_QUESTIONS']),2)*100;
    $fill_rate_opp=round(($row['ENQUIRY_WITH_ISQ']/$row['TOTAL_DIST_QUESTIONS']),2)*100;
    if($row['ENQUIRY_WITH_ISQ'] !=0 || $row['TOTAL_FILLED_QUES'] != 0 || $row['TOTAL_DIST_QUESTIONS'])
    {
     echo '<tr>
        <td align="center">'.$row['DIR_QUERY_MCATID'].'</td>
        <td align="center">'.$row['TOTAL_ENQUIRY'].'</td>
        <td align="center">'.$row['ENQUIRY_WITH_ISQ'].'</td>
        <td align="center">'.$row['TOTAL_FILLED_QUES'].'</td>
        <td align="center">'.$row['TOTAL_DIST_QUESTIONS'].'</td>
        <td align="center">'.$fill_rate.'%</td>
        <td align="center">'.$fill_rate_opp.'%</td>
                    </tr>';
    $i++;
    }
    if($i==10)
    break;
    }
          echo '</table>'; 
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
        
        }
        if($selectType =='Products')
        {
        
        echo '<table cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1" width="100%" style="border-collapse: collapse;">
    
    <tr>
        <td bgcolor="#dff8ff" align="center" colspan="8"><font color=" #333399"><b>Summary</b></font></td>
    </tr>
    <tr>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Mcat ID</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Products</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Products With ISQ Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Products  ISQ Filled</b></font></td>
         <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Filled</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Fill Rate%</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Oppturnity Fill Rate%</b></font></td>
    </tr>';
    $TOTAL_GENERATED=0;
    $GENERATED_WITH_ISQ_AVAIL=0;
    $GEN_ISQ_QUESTIONS_FILLED_USER=0;
    $GEN_ISQ_QUESTIONS_AVAIL=0;
    $GEN_ISQ_QUESTIONS_FILLED=0;
    $j=0;
    
    foreach($data as $row){
     
        $TOTAL_GENERATED=$TOTAL_GENERATED+$row['TOTAL_APPROVED'];
        $GENERATED_WITH_ISQ_AVAIL=$GENERATED_WITH_ISQ_AVAIL+$row['APPROVED_WITH_ISQ_AVAIL'];
        $GEN_ISQ_QUESTIONS_FILLED_USER=$GEN_ISQ_QUESTIONS_FILLED_USER+$row['APPROVED_WITH_ISQ_FILLED'];
        $GEN_ISQ_QUESTIONS_AVAIL=$GEN_ISQ_QUESTIONS_AVAIL+$row['APP_ISQ_QUESTIONS_FILLED'];
        $GEN_ISQ_QUESTIONS_FILLED=$GEN_ISQ_QUESTIONS_FILLED+$row['APP_ISQ_QUESTIONS_AVAIL'];
       $j++;
       }
    
       $fill_rate=round(($GEN_ISQ_QUESTIONS_FILLED_USER/$GENERATED_WITH_ISQ_AVAIL),2)*100;
       $fill_rate_opp=round(($GEN_ISQ_QUESTIONS_FILLED/$GEN_ISQ_QUESTIONS_AVAIL),2)*100;
       
        echo '<tr>
        <td align="center">ALL</td>
        <td align="center">'.$TOTAL_GENERATED.'</td>
        <td align="center">'.$GENERATED_WITH_ISQ_AVAIL.'</td>
        <td align="center">'.$GEN_ISQ_QUESTIONS_FILLED_USER.'</td>
        <td align="center">'.$GEN_ISQ_QUESTIONS_AVAIL.'</td>
        <td align="center">'.$GEN_ISQ_QUESTIONS_FILLED.'</td>
        <td align="center">'.$fill_rate.'%</td>
        <td align="center">'.$fill_rate_opp.'%</td>
                    </tr>';
 
echo '</table>';
        
        
         echo '<br><br><table cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1" width="100%" style="border-collapse: collapse;">
         
          <tr>
	  <td bgcolor="#dff8ff" align="center" colspan="8"><font color=" #333399"><b>Total Records:'.$j.'</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<input type="Submit" name="Report" value="Export To XL" class="" ></td>
	  </tr>
    
    <tr>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Mcat ID</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Products</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Products With ISQ Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Products With ISQ Filled</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Available</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Total Questions Filled</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Fill Rate</b></font></td>
        <td bgcolor="#dff8ff" align="center" ><font color=" #333399"><b>Fill Rate Oppturnity</b></font></td>
    </tr>';
    $i=0;
    foreach($data as $row)
    {
   
    $fill_rate=round(($row['APPROVED_WITH_ISQ_FILLED']/$row['APPROVED_WITH_ISQ_AVAIL']),2)*100;
    $fill_rate_opp=round(($row['APP_ISQ_QUESTIONS_AVAIL']/$row['APP_ISQ_QUESTIONS_FILLED']),2)*100;
    if($row['APPROVED_WITH_ISQ_AVAIL'] !=0 || $row['APPROVED_WITH_ISQ_FILLED'] != 0 || $row['APP_ISQ_QUESTIONS_FILLED'] !=0 || $row['APP_ISQ_QUESTIONS_AVAIL'] != 0 )
    {
     echo '<tr>
        <td align="center">'.$row['FK_GLCAT_MCAT_ID'].'</td>
        <td align="center">'.$row['TOTAL_APPROVED'].'</td>
        <td align="center">'.$row['APPROVED_WITH_ISQ_AVAIL'].'</td>
        <td align="center">'.$row['APPROVED_WITH_ISQ_FILLED'].'</td>
        <td align="center">'.$row['APP_ISQ_QUESTIONS_FILLED'].'</td>
        <td align="center">'.$row['APP_ISQ_QUESTIONS_AVAIL'].'</td>
        <td align="center">'.$fill_rate.'%</td>
        <td align="center">'.$fill_rate_opp.'%</td>
                    </tr>';
    $i++;
    }
    if($i==10)
    break;
    }
          echo '</table>'; 
        
        }
        
        
          
    }
    else{
        echo '<table><tr><td bgcolor="#dff8ff" align="center" colspan="6"><font color=" #333399"><b>No result found</b></font></td></tr></table>';
    }
}

?>



