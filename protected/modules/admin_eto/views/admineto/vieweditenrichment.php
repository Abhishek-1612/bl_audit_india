<html><head>
       <link href="//utils.imimg.com/suggest/css/jquery-ui.css" type="text/css" rel="stylesheet" />
        <script language="javascript" type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" ></script>
       <script language="javascript" type="text/javascript" src="<?php echo CommonVariable::get_autosuggest_js();?>"></script>
   <style type="text/css">
    .hdfield{font-size:15px; color:#2676d1;}
    .admintext1 {font-family: arial;font-size: 12px; padding:0 5px;line-height:20px;}
    </style>
    <script type="text/javascript">
    $(document).ready(function(){
            if($("#r4").prop("checked") == true){
                $("#dbox").show();
            }
            function finalReview(){
                $("#qty_unit_final").val($("#ETO_OFR_QTY_UNIT").val());   
                if($("#ETO_OFR_QTY").length)
                    {
                if($("#ETO_OFR_QTY_UNIT").length && $("#ETO_OFR_QTY_UNIT").val() == 'Others' && $("#QTY_LIST_VAL_OTHER").length)
                {
                $("#qty_unit_final").val($("#QTY_LIST_VAL_OTHER").val());
                }
            }
        }
       
       
    });
    function confirmDel_Verify(){
        var offerVal = $("#offer").val();
        $("#delcallverify").val(1);
        document.myForm.action = "/index.php?r=admin_eto/AdminEto/updatecalldata&offer="+offerVal+"&action=save";
        return confirm("Are you sure you want to delete this offer from Call Verifiction records");   
    }
    var sugg_city1 = new Suggester({"element":"pref_city","onSelect":selecttext_city1,"onExplicitChange":onExplicitChangeCity1,"type":"city",fields: "std,state,id,stateid","placeholder":"", "minStringLengthToDisplaySuggestion":1,"autocompleteClass":"cls-city",displayFields:"value,state",displaySeparator:" >> "});
    var sugg_city2 = new Suggester({"element":"pref_city1","onSelect":selecttext_city2,"onExplicitChange":onExplicitChangeCity2,"type":"city",fields: "std,state,id,stateid","placeholder":"", "minStringLengthToDisplaySuggestion":1,"autocompleteClass":"cls-city",displayFields:"value,state",displaySeparator:" >> "});
    var sugg_city3 = new Suggester({"element":"pref_city2","onSelect":selecttext_city3,"onExplicitChange":onExplicitChangeCity3,"type":"city",fields: "std,state,id,stateid","placeholder":"", "minStringLengthToDisplaySuggestion":1,"autocompleteClass":"cls-city",displayFields:"value,state",displaySeparator:" >> "});
   
    function ShowHideOtherQuantDiv(){
        var $value = $("#ETO_OFR_QTY_UNIT").val();
        if($value == "Others"){
            $("#ETO_OFR_QTY_UNIT_OTHER").show();
        } else {
            $("#ETO_OFR_QTY_UNIT_OTHER").hide();
        }
    }

    function selecttext_city1(event, ui){
            this.value = ui.item.value;
            document.getElementById("city1").value=ui.item.data.id;
            document.getElementById("pref_state").value=ui.item.data.state;
    }
    function selecttext_city2(event, ui){
            this.value = ui.item.value;
            document.getElementById("city2").value=ui.item.data.id;
            document.getElementById("pref_state1").value=ui.item.data.state;
    }
    function selecttext_city3(event, ui){
            this.value = ui.item.value;
            document.getElementById("city3").value=ui.item.data.id;
            document.getElementById("pref_state2").value=ui.item.data.state;
    }
    function onExplicitChangeCity1(event, ui){
            if(ui.item){
                document.getElementById("city1").value=ui.item.data.id;
                document.getElementById("pref_state").value=ui.item.data.state;
            } else{
                document.getElementById("city1").value='';
                document.getElementById("pref_state").value='';
            }
    }
    function onExplicitChangeCity2(event, ui){
            if(ui.item){
                document.getElementById("city2").value=ui.item.data.id;
                document.getElementById("pref_state1").value=ui.item.data.state;
            } else{
                document.getElementById("city2").value='';
                document.getElementById("pref_state1").value='';
            }
    }
    function onExplicitChangeCity3(event, ui){
            if(ui.item){
                document.getElementById("city3").value=ui.item.data.id;
                document.getElementById("pref_state2").value=ui.item.data.state;
            } else{
                document.getElementById("city3").value='';
                document.getElementById("pref_state2").value='';
            }
    }
    function chckform()
    {
        $("#delcallverify").val(0);
        var poolFlag = $("#bl_wait_pool_id").val();
        if(poolFlag != 0){
            if($("#ETO_OFR_TITLE").val().trim() == ''){
                alert("Please enter offer title");
                $("#ETO_OFR_TITLE").focus();
                return false;       
            }
            if($("#ETO_OFR_DESC").val().trim() == ''){
                alert("Please enter offer description");   
                $("#ETO_OFR_DESC").focus();
                return false;   
            }
            var qty = $("#ETO_OFR_QTY").val().trim();
            var qty_unit = $("#ETO_OFR_QTY_UNIT").val().trim();
            var qty_unit_other = $("#ETO_OFR_QTY_UNIT_OTHER").val().trim();
            if(qty == "" && qty_unit != ""){
                alert("Please enter quantity");
                $("#ETO_OFR_QTY").focus();
                return false;           
            } else if(qty != "" && qty_unit == ""){
                alert("Please enter quantity unit");
                $("#ETO_OFR_QTY_UNIT").focus();
                return false;
            } else if(qty != "" && qty_unit != "" && qty_unit == 'Others' && qty_unit_other == ""){
                alert("Please enter quantity unit");
                $("#ETO_OFR_QTY_UNIT_OTHER").focus();
                return false;
            }
        }
        if(document.getElementById('pref_city').value=='')
        {
            document.getElementById('city1').value=''
        }       
        if(document.getElementById('pref_city1').value=='')
        {
            document.getElementById('city2').value=''
        }       
        if(document.getElementById('pref_city2').value=='')
        {
            document.getElementById('city3').value=''
        }

        if((document.getElementById('city1').value=="") && ((document.getElementById('city2').value!="") || (document.getElementById('city3').value!="")))
                {                       
                        document.getElementById('pref_city').focus();
            alert("Please Fill The First City & State");
                        return false;
                }
                else
                if((document.getElementById('city2').value=="") && (document.getElementById('city3').value!=""))
                {
                        document.getElementById('pref_city1').focus();
            alert("Please Fill The Second City & State");
                        return false;
                }
        else
        if(document.getElementById('r4').checked == true && document.getElementById('r4').value=="4" && document.getElementById('city1').value=="")
        {
            document.getElementById('pref_city').focus();
                    alert("Please Fill At least One City & State");
                    return false;
        }
        if(document.getElementById('require_freq2').checked == true && document.getElementById('reg_req_list').value == ""){
            alert('Select Regular Frequency');
            document.getElementById('reg_req_list').focus();
            return false;       
        }
    }
    function purchase_frm(id)
    {   
        var chkID="purchase_from"+id;
        if(document.getElementById(chkID).checked)
        {
            for (var i=1; i<=4 ; i++)
            {       
                if(i != id)
                    document.getElementById("purchase_from"+i).checked = false;
                if(id == 4)
                    document.getElementById('purchase_from_other').style.display = 'inline-block';
                else
                {
                    document.getElementById('purchase_from_other').style.display = 'none';
                    document.getElementById('purchase_from_other').value ="";
                }
            }
        }   
        else
        {
            for (var i=1; i<=4 ; i++)
            {
                document.getElementById("purchase_from"+i).checked = false;
                document.getElementById('purchase_from_other').style.display = 'none';
                document.getElementById('purchase_from_other').value ="";
            }       
        }
    }
    function check3(id)
    {
        var chkID="time_period"+id;
               
        if(document.getElementById(chkID).checked)
        {
           
                if(id == 1) {
                    document.getElementById("time_period4").checked = false;
                } else{
                    document.getElementById("time_period1").checked = false;
                }
        }   
    }
    function check2(id)
    {
        var chkID="n"+id;
        if(document.getElementById(chkID).checked)
        {
            for (var i=1; i<=3 ; i++)
            {
                if(i != id) {
                document.getElementById("n"+i).checked = false; }
            }
        }   
        else
        {
            for (var i=1; i<=3 ; i++)
            {
                document.getElementById("n"+i).checked = false;
            }   
        }
    }
    function oth_vl(id)
    {   
        var chkID="r"+id;
        if(document.getElementById(chkID).checked)
        {
            for (var i=1; i<=4 ; i++)
            {       
                if(i != id)
                {
                    document.getElementById("r"+i).checked = false;
                }
                if(id == 4)
                {
                    document.getElementById('dbox').style.display = 'block';
                }
                else
                {
                    document.getElementById('dbox').style.display = 'none';
                    document.getElementById('pref_city').value ="";
                    document.getElementById('pref_state').value ="";
                    document.getElementById('pref_city1').value ="";
                    document.getElementById('pref_state1').value ="";
                    document.getElementById('pref_city2').value ="";
                    document.getElementById('pref_state2').value ="";
                    document.getElementById('city1').value ="";
                    document.getElementById('city2').value ="";
                    document.getElementById('city3').value ="";
                }
            }
        }   
        else
        {
            for (var i=1; i<=4 ; i++)
            {
                document.getElementById("r"+i).checked = false;
                document.getElementById('dbox').style.display = 'none';
                document.getElementById('pref_city').value ="";
                document.getElementById('pref_state').value ="";
                document.getElementById('pref_city1').value ="";
                document.getElementById('pref_state1').value ="";
                document.getElementById('pref_city2').value ="";
                document.getElementById('pref_state2').value ="";
                document.getElementById('city1').value ="";
                document.getElementById('city2').value ="";
                document.getElementById('city3').value ="";
            }       
        }
    }

    function check_freq(id)
    {   
        var chkID="require_freq"+id;
        if(document.getElementById(chkID).checked)
        {
            for (var i=1; i<=2 ; i++)
            {       
                if(i != id)
                {
                    document.getElementById("require_freq"+i).checked = false;
                }
            }
            if(id == 2)
            {
                document.getElementById('req').style.display = 'inline-block';
            }
            else
            {
                document.getElementById('req').style.display = 'none';
                document.getElementById('reg_req_list').value='';
            }
        }
        else
        {
            for (var i=1; i<=2 ; i++)
            {
                document.getElementById("require_freq"+i).checked = false;
                document.getElementById('req').style.display = 'none';
                document.getElementById('reg_req_list').value='';
            }
        }
    }
    function req_type(id)
    {   
        var chkID="require_type"+id;
        if(document.getElementById(chkID).checked)
        {
            for (var i=2; i<=3 ; i++)
            {       
                if(i != id)
                    document.getElementById("require_type"+i).checked = false;
            }
        }   
       
    }   
    function check_enq_pur(id)
        {   
                var chkID="enq_purpose"+id;
                if(document.getElementById(chkID).checked)
                {
                        for (var i=1; i<=2 ; i++)
                        {       
                                if(i != id)
                                document.getElementById("enq_purpose"+i).checked = false;
                        }
                }   
                else
                {
                        for (var i=1; i<=2 ; i++)
                        {
                                document.getElementById("enq_purpose"+i).checked = false;
                        }       
                }
        }
    function check_enq_typ(id)
        {   
                var chkID="enq_typ"+id;
                if(document.getElementById(chkID).checked)
                {
                        for (var i=1; i<=2 ; i++)
                        {       
                                if(i != id)
                                document.getElementById("enq_typ"+i).checked = false;
                        }
                }   
                else
                {
                        for (var i=1; i<=2 ; i++)
                        {
                                document.getElementById("enq_typ"+i).checked = false;
                        }       
                }
        }
       
        function check_enq_typ1(id)
      {     
              var chkID="NOB"+id;
             if(document.getElementById(chkID).checked)
             {
                     for (var i=1; i<=4 ; i++)
                     {             
                             if(i != id)
                              document.getElementById("NOB"+i).checked = false;
                      }
              }     
             else
               {
                       for (var i=1; i<=4 ; i++)
                       {
                                document.getElementById("NOB"+i).checked = false;
                       }             
               }
        }
    function ajaxFunction()
        {
            var xmlHttp;
            try
            {    // Firefox, Opera 8.0+, Safari
                xmlHttp=new XMLHttpRequest();
            }
            catch (e){// Internet Explorer
                try
                {
                    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (e)
                {
                    try
                    {
                        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch (e)
                    {
                        alert("Your browser does not support AJAX!");
                        return false;
                    }
                }
            }
            return xmlHttp;
        }
   
    </script>
                  <?php $server_name = !empty($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'gladmin.intermesh.net' ;
                      if(preg_match('/dev-/',$server_name) == 1)
                     echo '<iframe id="textReader" src="/admin_approval/restricted_keywords_product.txt" style="display: none;"></iframe>';
              else if(preg_match('/stg-/',$server_name) == 1)
            echo '<iframe id="textReader" src="/admin_approval/restricted_keywords_product.txt" style="display: none;"></iframe>';
              else
            echo '<iframe id="textReader" src="/admin_approval/restricted_keywords_product.txt" style="display: none;"></iframe>';
              ?>
            <script language="javascript" src="//utils.gladmin.intermesh.net/protected/modules/admin_products/common-scripts/reserved_keywords_leap.js?v=2&_=1463462669637"></script>
         <script language="javascript">
        
        
        
         function validate_names(_value, _validateAs, _maxLength, action_name, txt_id,by_type) {
   
//     alert('by_type is in title : '+by_type);
//     banned_keywords
    var lower_txt = '';
    var txt = fetchText();
    txt = txt.replace(/<(.*?)>/, '');
    txt = txt.replace(/<(.*?)>/, '');
    var restypArr = new Array();
    var restypArr_title = new Array();
    var restypArr_title1 = new Array();

    var error = '';
    var _escape_value = _value;
    _value = unescape(_value);
    var temp = _value.toLowerCase();
    var temp_title = _value.toLowerCase();
    temp = temp.replace(/\s+$/, '');
    if (_value == '') {
        error = "Please check that " + _validateAs + " cannot be blank.";
        return error;
    }

   
    var res_type = [];
    var match_arr = '';
    var lines = txt.split("\n");
    for (var j = 0; j < lines.length; j++) {
        var lines1 = lines[j].split("=");

        lower_txt = lines1[0].toLowerCase();
        if ((lower_txt == 'mcat') || (lower_txt == 'url restriction')) {
        } else {
            var res_key = lines1[1];
            var reserved_key = lower_txt + "#" + res_key;
            match_arr += reserved_key + '|';
        }
    }
    match_arr = match_arr.replace(/\s+/g, ' ');
    match_arr = match_arr.replace(/\|$/, '');
    match_arr = match_arr.toLowerCase();
    var _keyword = match_arr;
    var res_type = _keyword.split("|");
    var not_city_cty = '';
    var city_cty = '';
    var match_word = '';
    for (var k = 0; k < res_type.length; k++) {
        var res_type1 = res_type[k].split("#");
        var reserved_type = res_type1[0];
        var reserved_kwd = res_type1[1];
        reserved_type = reserved_type.trim();
        /*if((reserved_type == 'city') || (reserved_type == 'country') || (reserved_type == 'adult') || (reserved_type == 'trademark') || (reserved_type == 'drugs') || (reserved_type == 'freemail-domains') || (reserved_type == 'special character'))*/
        if ((reserved_type == 'city') || (reserved_type == 'country') || (reserved_type == 'freemail-domains') || (reserved_type == 'special character')) {
            if (reserved_type == 'special character') {
                if (temp.indexOf(reserved_kwd) >= 0) {
                    var chk_flag = checkReserveTyp(restypArr, reserved_type);
                    if (chk_flag == 0) {
                        restypArr.unshift(reserved_type);
                        reserved_type = toTitleCase(reserved_type);
                        match_word += reserved_type + ":\n";
                    }
                    match_word += "\t\t\t\t : " + reserved_kwd.toUpperCase() + "\n";
                }
            } else if ((reserved_type == 'city') || (reserved_type == 'country') || (reserved_type == 'freemail-domains')) {
                //                     var kw_regex = new RegExp(reserved_kwd);
                //                     if(temp.match(kw_regex)) {
                //                         var chk_flag1=checkReserveTyp(restypArr_title,reserved_type);
                //                         if(chk_flag1 == 0) {
                //                             restypArr_title.unshift(reserved_type);
                //                             if(reserved_type == 'generic content restrictions') {
                //                                 reserved_type = reserved_type.replace(/\s+/g, '-')
                //                             }
                //                             match_word += "\t"+reserved_type+":\n";
                //                         }
                //                         if(match_word.indexOf('\t\t'+reserved_kwd) == -1) {
                //                             match_word += "\t\t"+reserved_kwd+"\n";
                //                         }
                //                     }
                if (reserved_kwd.match(/\s+/)) {

                    var prd_val = temp.split(" ");
                    for (var l = 0; l < prd_val.length; l++) {
                        if (prd_val[l] == reserved_kwd) {
                            //                               match_word += reserved_type+"->"+reserved_kwd+',\n\t';
                            var chk_flag = checkReserveTyp(restypArr_title, reserved_type);

                            if (chk_flag == 0) {
                                restypArr_title.unshift(reserved_type);
                                reserved_type = toTitleCase(reserved_type);
                                match_word += reserved_type + ":\n";
                            }
                            if (match_word.indexOf('\t\t\t\t' + reserved_kwd) == -1) {
                                match_word += "\t\t\t\t :" + reserved_kwd.toUpperCase() + "\n";
                            }
                            //                                 if ( match_word.search(reserved_kwd) == -1 )
                            {
                                match_word += "\t\t\t\t : " + reserved_kwd.toUpperCase() + "\n";
                            }
                            //                                                         match_word += "\t\t"+reserved_kwd+"\n";
                        }
                    }
                } else {

                    var prd_val = temp.split(" ");
                    for (var l = 0; l < prd_val.length; l++) {
                        if (prd_val[l] == reserved_kwd) {

                            //                              match_word += reserved_type+"->"+reserved_kwd+',\n\t';
                            var chk_flag1 = checkReserveTyp(restypArr_title1, reserved_type);
                            if (chk_flag1 == 0) {
                                restypArr_title1.unshift(reserved_type);
                                reserved_type = toTitleCase(reserved_type);
                                match_word += reserved_type + ":\n";
                            }
                            if (match_word.indexOf('\t\t\t\t' + reserved_kwd) == -1)
                            //                                 if ( match_word.search(reserved_kwd) == -1 )
                            {
                                match_word += "\t\t\t\t : " + reserved_kwd.toUpperCase() + "\n";
                            }
                            //                             match_word += "\t\t"+reserved_kwd+"\n";
                        }

                    }
                }
            }
        }
        //else if((reserved_type == 'Adult') || (reserved_type == 'Trademark') || (reserved_type == 'Drugs'))
        else if (reserved_type.match(/adult|trademark|drugs/ig)) {

            reserved_kwd_test=reserved_kwd;	
            reserved_kwd_test=reserved_kwd_test.replace(/([.^$|*+?()\[\]{}\\-])/g, "\\$1");  //comment by akash	

            var re = new RegExp('\\b' + reserved_kwd_test + '\\b', 'ig');
            if (temp_title.match(re)) {
                reserved_type = toTitleCase(reserved_type);
                match_word += reserved_type + ":\n";
                match_word += "\t\t\t\t : " + reserved_kwd.toUpperCase() + "\n";
            }
        } else {
            //alert(reserved_type+'->'+reserved_kwd);
            //not_city_cty += reserved_kwd+'|';
            if (temp.search(reserved_kwd) == -1 && reserved_type != '') {
                //failed, here search for HTML tag failed, means item name is OK
            } else if(reserved_type != '') {
                var prd_val = temp.split(" ");
                for (var l = 0; l < prd_val.length; l++) {
                    if (prd_val[l] == reserved_kwd) {
                        var chk_flag = checkReserveTyp(restypArr, reserved_type);
                        if (chk_flag == 0) {
                            restypArr.unshift(reserved_type);
                            reserved_type = toTitleCase(reserved_type);
                            match_word += reserved_type + ":\n";
                        }
                        if (match_word.indexOf('\t\t\t\t' + reserved_kwd) == -1)
                        //                             if ( match_word.search(reserved_kwd) == -1 )
                        {
                            match_word += "\t\t\t\t : " + reserved_kwd.toUpperCase() + "\n";
                        }
                    }
                }

            }

        }

    }
    match_word = match_word.replace(/,$/, '');
    console.log(match_word);
    if (match_word != '') {

        var break_word_key = '';
        var s = match_word;
        s = s.replace(/\s+/g, ' ');
        s = s.replace(/\t/g, ' ');
        s = s.replace(/\n/g, ' ');
        //             match_word =  toTitleCase(match_word);
        var arr = s.match(/([a-zA-Z\-]+?):/g);
        for (var k = 0; k < arr.length; k++) {
            var pure = arr[k].substring(0, arr[k].length - 1)
            arr[k] = pure;

        }

        var break_word = arr;
        for (var m = 0; m < break_word.length; m++) {
            //                 var breakword = break_word[m].split(',');
            var breakword = break_word[m];
            if ((breakword == 'adult') || (breakword == 'trademark') || (breakword == 'drugs')) {
                break_word_key += breakword[m] + ",";

            }
        }
        if ((break_word_key != '') && (action_name != 'reject' && action_name != 'reject1')) {
            break_word_key = break_word_key.replace(/,$/, '');
            //                   document.form1.item_name.focus();
            document.getElementById(txt_id).focus();
            error = "Following KeyWord is not allowed In "+ _validateAs +" :\n\n" + match_word + "\nRemoval of Adult,TradeMark and Drugs Type Keywords is Mandatory.";
            return error;
        } else {
            if (match_word.match(/adult|drugs|trademark/ig))
        {
         
        if(by_type == 'banned_keywords')
        {
          var conf1 = confirm( _validateAs +" cannot contain : \n\n" + match_word + " \nClick OK to continue, or Cancel to Change");
          if (conf1) {} else {
              document.getElementById(txt_id).focus();
              error = 'fail';
              return error;
          }
        }
        else
        {
               
                alert(_validateAs +" cannot contain:\n\n" + match_word);
                error = 'fail';
        return error;
        }
               
            } else {
                var conf1 = confirm(_validateAs +" cannot contain : \n\n" + match_word + " \nClick OK to continue, or Cancel to Change");

                if (conf1) {} else {
                    document.getElementById(txt_id).focus();
                    error = 'fail';
                    return error;
                }
            }
        }
    }


    //     }
    restypArr = '';
    restypArr_title = '';
    restypArr_title1 = '';
}

            function check_res_keyword(bodyonLoad)
            {
              var validate_msg_title = validate_names($('#ETO_OFR_REQ_APP_USAGE').val(), 'Product Application', 100,'','ETO_OFR_REQ_APP_USAGE','Title');
              if (validate_msg_title)
              {    
              if(validate_msg_title != "Please check that Product Application cannot be blank."){
              return false;      
             
              }
                                 
              }
                            var validate_msg_desc = validate_names($('#ETO_OFR_OTHER_DETAIL').val(), 'Other Details', 3999,'','ETO_OFR_OTHER_DETAIL','Description');
                if (validate_msg_desc)
                {   
                   if(validate_msg_desc != "Please check that Other Details cannot be blank.")
                   return false;      
                }
               
                
              return chckform();
              }
            function fetchText()
            {
                var d = document;
                var txtFrame = d.getElementById( 'textReader');
                var text = '';
                if (txtFrame.contentDocument)
                {
                    var d = txtFrame.contentDocument;
                    text = d.getElementsByTagName( 'BODY')[ 0].innerHTML;
                }
                else if (txtFrame.contentWindow)
                {
                    var w = txtFrame.contentWindow;
                    text = w.document.body.innerHTML;
                }
                return text;
            }
			
			function uncheckReview(id,counter)
			{
				var isChecked = document.getElementById(id).checked;
				if(!isChecked){
					$('#others_'+counter).val('');
				}
				else{
					var others1 = $('#others1_'+counter).val();
					$('#others_'+counter).val(others1);
				}
			}	
        </script>
   
    </head>
    <body>
    <?php
    if(!empty($result)){
        $qtyList = array("Kilogram","Metric Tons","Nos","Pieces","Tons");
       
        $approx_order_valueIn=array('100.0'=>'Upto 1,000','200.0'=>'1,000 to 3,000','300.0'=>'3,000 to 10,000','400.0'=>'10,000 to 20,000','500.0'=>'20,000 to 50,000','600.0'=>'50,000 to 1 Lakh','700.0'=>'1 to 2 Lakh','800.0'=>'2 to 5 Lakh','900.0'=>'5 to 10 Lakh','1000.0'=>'10 to 20 Lakh','1100.0'=>'20 to 50 Lakh','1200.0'=>'50 Lakh to 1 Crore','1300.0'=>'More than 1 Crore','100'=>'Upto 1,000','200'=>'1,000 to 3,000','300'=>'3,000 to 10,000','400'=>'10,000 to 20,000','500'=>'20,000 to 50,000','600'=>'50,000 to 1 Lakh','700'=>'1 to 2 Lakh','800'=>'2 to 5 Lakh','900'=>'5 to 10 Lakh','1000'=>'10 to 20 Lakh','1100'=>'20 to 50 Lakh','1200'=>'50 Lakh to 1 Crore','1300'=>'More than 1 Crore');
       
        $approx_order_valuefrn=array('100.0'=>'Upto 1,000','200.0'=>'1,000 to 3,000','300.0'=>'3,000 to 10,000','400.0'=>'10,000 to 20,000','500.0'=>'20,000 to 50,000','600.0'=>'50000 to 0.1 Million','700.0'=>'0.1 to 0.2 Million','800.0'=>'0.2 to 0.5 Million','900.0'=>'0.5 to 1 Million','1000.0'=>'1 to 2 Million','1100.0'=>'2 to 5 Million','1200.0'=>'5 to 10 Million','1300.0'=>'More than 10 Million','100'=>'Upto 1,000','200'=>'1,000 to 3,000','300'=>'3,000 to 10,000','400'=>'10,000 to 20,000','500'=>'20,000 to 50,000','600'=>'50000 to 0.1 Million','700'=>'0.1 to 0.2 Million','800'=>'0.2 to 0.5 Million','900'=>'0.5 to 1 Million','1000'=>'1 to 2 Million','1100'=>'2 to 5 Million','1200'=>'5 to 10 Million','1300'=>'More than 10 Million');
        $currencyArr=array('1'=>'INR - Indian Rupee','1.0'=>'INR - Indian Rupee','2'=>'USD - U.S Dollar','2.0'=>'USD - U.S Dollar','3'=>'GBP - Pound Sterling','3.0'=>'GBP - Pound Sterling','4'=>'EUR - Euro','4.0'=>'EUR - Euro','5'=>'AUD - Australian Dollar','5.0'=>'AUD - Australian Dollar','6'=>'CAD - Canadian Dollar','6.0'=>'CAD - Canadian Dollar','7'=>'CHF - Swiss Franc','7.0'=>'CHF - Swiss Franc','8'=>'PY - Japanese Yen','8.0'=>'PY - Japanese Yen','9'=>'HKD - Hong Kong Dollar','9.0'=>'HKD - Hong Kong Dollar','10'=>'NZD - New Zealand Dollar','10.0'=>'NZD - New Zealand Dollar','11'=>'SGD - Singapore Dollar','11.0'=>'SGD - Singapore Dollar','12'=>'NTD - Taiwan Dollar','12.0'=>'NTD - Taiwan Dollar','13'=>'RMB - Renminbi','13.0'=>'RMB - Renminbi');
       
         $qtyListOther = array("20' Container","40' Container","Bags","Barrel","Bottles","Boxes","Bushel","Cartons","Dozens","Foot","Gallon","Grams","Hectare","Kilogram","Kilometer","Litres","Long Ton","Meter","Metric Tons","Nos","Ounce","Packets","Packs","Pairs","Pieces","Pound","Reams","Rolls","Sets","Sheets","Short Ton","Square Feet","Square Meters","Tons","Units","Others");           
        $offerId = $result['offerId'];
        $start = $result['start'];
        $totalOffers = $result['totalOffers'];
        $poolFlag = $result['poolFlag'];
        $bl_wait_pool_id = $result['bl_wait_pool_id'];
        $poolData = $result['poolData'];
        $poolCount = $result['poolCount'];
        $ofrStatus = $result['ofrStatus'];
        $blType = $result['blType'];
        $tableType = $result['tableType'];
        $cntry_iso = $result['cntry_iso'];
        $cntry_name1 = $result['cntry_name1'];
        $status = $result['status'];
        $rec = $result['rec'];       
        $currencyIN = $masterValues['currencyIN'];
        $timePeriod = $masterValues['timePeriod'];
        $reqReason = $masterValues['reqReason'];
        $reqFreqArr = $masterValues['reqFreq'];
        $cityArr = $result['cityArr'];
        $shipmentModeArr = $masterValues['shipmentMode'];
        $paymentMode = $masterValues['paymentMode'];
        $ofrTitle = isset($rec['ETO_OFR_TITLE'])?$rec['ETO_OFR_TITLE']:'';
        $ofrDesc = isset($rec['ETO_OFR_DESC'])?$rec['ETO_OFR_DESC']:'';
        $ofrQty = isset($rec['ETO_OFR_QTY'])?$rec['ETO_OFR_QTY']:'';
        $ofrQtyUnit = isset($rec['ETO_OFR_QTY_UNIT'])?$rec['ETO_OFR_QTY_UNIT']:'';
        $appUsage = isset($rec['ETO_OFR_REQ_APP_USAGE'])?$rec['ETO_OFR_REQ_APP_USAGE']:'';
        $otherDetail = isset($rec['ETO_OFR_OTHER_DETAIL'])?$rec['ETO_OFR_OTHER_DETAIL']:'';
        $approxOrderValue = isset($rec['ETO_OFR_APPROX_ORDER_VALUE'])?$rec['ETO_OFR_APPROX_ORDER_VALUE']:'';
        $currId = isset($rec['ETO_OFR_CURRENCY_ID'])?$rec['ETO_OFR_CURRENCY_ID']:'';
        $userCountry = isset($rec['GLUSR_USR_COUNTRYNAME'])?$rec['GLUSR_USR_COUNTRYNAME']:'';
       
        $callVerifyDetails = (!empty($poolData))?$poolData['rec_verify']:array();
       
        foreach($timePeriod as $tK => $tR){
            $timePeriodArr[$tR['IIL_MASTER_DATA_VALUE']] = $tR['IIL_MASTER_DATA_VALUE_TEXT'];       
        }
        $colSpan = '2';$tdWidth = "85%";$textAreaColSpan = '3';
        if(!empty($poolFlag) && $poolFlag == 1 && !empty($callVerifyDetails)){
                $colSpan = '3';$tdWidth = "45%";$textAreaColSpan = '2';
                $callVerifyTitle = isset($callVerifyDetails['TITLE_UPDATED'])?trim($callVerifyDetails['TITLE_UPDATED']):'';           
                $callVerifyDesc = isset($callVerifyDetails['DESC_UPDATED'])?trim($callVerifyDetails['DESC_UPDATED']):'';           
                $callVerifyQuant = isset($callVerifyDetails['QTY_UPDATED'])?trim($callVerifyDetails['QTY_UPDATED']):'';
                $callVerifyGeo = isset($callVerifyDetails['GEOGRAPHY_ID_UPDATED'])?trim($callVerifyDetails['GEOGRAPHY_ID_UPDATED']):'';
               
                $callVerifyReqType = isset($callVerifyDetails['REQ_TYPE_UPDATED'])?trim($callVerifyDetails['REQ_TYPE_UPDATED']):'';//Requirement Type
                $callVerifyReqFreq = isset($callVerifyDetails['REQ_FREQ_UPDATED'])?trim($callVerifyDetails['REQ_FREQ_UPDATED']):'';               
               
                $callVerifyReqFreqUpdated = isset($callVerifyDetails['REQ_FREQUENCY_UPDATED'])?trim($callVerifyDetails['REQ_FREQUENCY_UPDATED']):'';               
                $callVerifyEnqType = isset($callVerifyDetails['ENQ_TYPE_UPDATED'])?trim($callVerifyDetails['ENQ_TYPE_UPDATED']):'';
                $callVerifyPayTerm = isset($callVerifyDetails['PAY_TERM_UPDATED'])?trim($callVerifyDetails['PAY_TERM_UPDATED']):'';
                $callVerifyShipTerm = isset($callVerifyDetails['SHIP_TERM_UPDATED'])?trim($callVerifyDetails['SHIP_TERM_UPDATED']):'';
                $callVerifyDescPort = isset($callVerifyDetails['DEST_PORT_UPDATED'])?trim($callVerifyDetails['DEST_PORT_UPDATED']):'';
                $callVerifyOtherDetails = isset($callVerifyDetails['OTHER_DETAILS_UPDATED'])?trim($callVerifyDetails['OTHER_DETAILS_UPDATED']):'';
                $callVerifyReqApp = isset($callVerifyDetails['REQ_APP_UPDATED'])?trim($callVerifyDetails['REQ_APP_UPDATED']):'';
                $callVerifyCity1 = isset($callVerifyDetails['CITY1_UPDATED'])?trim($callVerifyDetails['CITY1_UPDATED']):'';
                $callVerifyCity2 = isset($callVerifyDetails['CITY2_UPDATED'])?trim($callVerifyDetails['CITY2_UPDATED']):'';
                $callVerifyCity3 = isset($callVerifyDetails['CITY3_UPDATED'])?trim($callVerifyDetails['CITY3_UPDATED']):'';
               
                $enrichmentVal = $callVerifyDesc;
                $enrichmentVal .= "\n\n";
               
                if(!empty($callVerifyReqType)){
                    $enrichmentVal .= "Why do you need this : ";
                    if($callVerifyReqType == 1){
                                $enrichmentVal .= " For Reselling";           
                    } else if($callVerifyReqType == 2){
                                $enrichmentVal .= " For Your End Use";           
                    } else if($callVerifyReqType == 3){
                                $enrichmentVal .= " As Raw Material";           
                    }
                    $enrichmentVal .= "\n";       
                }
                if(!empty($callVerifyGeo)){
                    $enrichmentVal .= "Preferred supplier location: ";
                    if($callVerifyGeo == 1)
                    {    
                        $enrichmentVal .= "Local Only\n";
                    }
                    elseif($callVerifyGeo == 2){
                        $enrichmentVal .= "India Only\n";
                    } elseif($callVerifyGeo == 3){
                    $enrichmentVal .= "Global\n";
                    } elseif($callVerifyGeo == 4){
                    $enrichmentVal .= $callVerifyCity1.", ".$callVerifyCity1.", ".$callVerifyCity1;
                    }
                }
                if(!empty($callVerifyReqPeriod)){
                        $enrichmentVal .= "How soon do you want to purchase : ";
                        //$callVerifyReqPeriod = $timePeriodArr[$callVerifyReqPeriod];   
                        //$enrichmentVal .= "$callVerifyReqPeriod \n";
                }
               
                if(!empty($callVerifyEnqType)){
                    $callVerifyEnqType = $reqReason[$callVerifyEnqType];
                    $enrichmentVal .= "Why do you need this : $callVerifyEnqType\n";
                }
                if(!empty($callVerifyOtherDetails)){
                    $enrichmentVal .= "Other Details : $callVerifyOtherDetails\n";
                }
                if(!empty($callVerifyReqApp)){
                    $enrichmentVal .= "Application Usage : $callVerifyReqApp\n";
                }
               
        }
    ?>
    <div style="font-size:15px; font-weight:bold; text-align:center;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#E0E0E0">
          <tbody>
          <tr>
          <?php
                if(!empty($poolFlag) && $poolFlag == 1){
                echo '<td height="30" class="admintext" width="25%" align="left">
                <font color="#000">&nbsp;Total Offers : '.$poolCount.' </font></td>';
                }             
          ?>
          <td height="30" class="admintext" width="50%" align="center">
          <font color="#000">&nbsp;OFFER ID: <?php echo $offerId; ?></font>
          </td>
          <?php            
             if(!empty($poolFlag) && $poolFlag == 1){ ?>
            <td align="right" class="admintext" width="25%" height="30"><font color="#000" style="padding-right:20px;">&nbsp;
             <?php if (!empty($start) )
                    {
                    echo '<A HREF="/index.php?r=admin_eto/AdminEto/vieweditenrichment&move=first&offer='.$offerId.'&start='.$start.'&status='.$status.'&bl_wait_pool_id='.$bl_wait_pool_id.'">
                    <FONT COLOR="#0000FF">First</FONT></A>&nbsp;&nbsp;';
                    echo '<A HREF="/index.php?r=admin_eto/AdminEto/vieweditenrichment&move=prev&offer='.$offerId.'&start='.$start.'&status='.$status.'&bl_wait_pool_id='.$bl_wait_pool_id.'">
                    <FONT COLOR="#0000FF">Previous</FONT></A>&nbsp;&nbsp;';
               } if ($start < $totalOffers-1)
                    {
                    echo '<A HREF="/index.php?r=admin_eto/AdminEto/vieweditenrichment&move=next&offer='.$offerId.'&start='.$start.'&status='.$status.'&bl_wait_pool_id='.$bl_wait_pool_id.'">
                    <FONT COLOR="#0000FF">Next</FONT></A>&nbsp;&nbsp;';
                    echo '<A HREF="/index.php?r=admin_eto/AdminEto/vieweditenrichment&move=last&offer='.$offerId.'&start='.$start.'&status='.$status.'&bl_wait_pool_id='.$bl_wait_pool_id.'">
                    <FONT COLOR="#0000FF">Last</FONT></A>';
                }
          }
  ?></td>
          </tr>
        </tbody></table>
       
       
     
       
    <div><br>
    <form action="/index.php?r=admin_eto/AdminEto/updatecalldata&offer=<?php echo $offerId; ?>&action=save&modid=<?php echo $modid; ?>" method='post' name="myForm">
        <input type="hidden" name="ISO_ORIG" id="ISO_ORIG" value="IN">
        <input type="hidden" name="bl_wait_pool_id" id="bl_wait_pool_id" value="<?php echo $bl_wait_pool_id; ?>">
        <table style="border-collapse: collapse; font-size:12px; font-family:arial;" align="center" border="1" bordercolor="#ddf0ff" cellpadding="8" cellspacing="0" width="100%">
            <tr>
                <td class="hdfield" bgcolor="#eff8ff" width="15%"><b>Field Updated</b></td>
                <td class="hdfield" bgcolor="#eff8ff" align="center" width="85%" colspan="<?php echo $colSpan; ?>"><b>Field Value</b></td>
            </tr>
            <?php if(!empty($poolFlag) && $poolFlag == 1 && !empty($callVerifyDetails)){ ?>
            <tr>
                <td align="right" class="admintext1" width="15%"><b>Title</b></td>
                <td align="left" colspan="<?php echo $colSpan; ?>" width="85%">
                <input maxlength="100" style="width: 450px;height:20px;" value="<?php echo $ofrTitle; ?>" name="ETO_OFR_TITLE" id="ETO_OFR_TITLE" type="text" >                           
                </td>
            </tr>
            <?php
           
            }
          $errMsg = $resultArr['errMsg'];
          $quesArr = $resultArr['quesArr'];
          $html = '';
          $counter=0;
		  
		  
		if(!empty($quesArr))
		{
			foreach($quesArr as $quesKey => $quesValue)
			{
				if("$quesKey" !='OLD_DATA' && !empty($quesValue) && !array_key_exists('IM_SPEC_MASTER_ID',$quesValue))
				{
                    foreach($quesValue as $tempory)
                    {
						if($tempory['IM_SPEC_MASTER_DESC'] =='Quantity')
						{
							$counter++;
							echo '<tr>
							<td align="right" class="admintext1" width="15%"><b>Quantity</b></td>
										<td  align="left" width="15%">&nbsp;
											<input type="text" maxlength="100" style="width: 150px;height:20px;" id="ques'.$tempory['IM_SPEC_MASTER_ID'].'" name="ques'.$tempory['IM_SPEC_MASTER_ID'].'" maxlength="50" value="'.$tempory['ISQ_RESPONSE'].'" >
											<input type="hidden" name="quantity_masterId" value="'.$tempory['IM_SPEC_MASTER_ID'].'">
											<input type="hidden" name="quantity_optionId" value="'.$tempory['IM_SPEC_OPTIONS_ID'].'">
											<input type="hidden" name="quantity_response" value="'.$tempory['ISQ_RESPONSE'].'">
								<input type="hidden" name="quantity_responseId" value="'.$tempory['ISQ_RESPONSE_ID'].'">
											<input type="hidden" name="ETO_OFR_QTY" id ="ETO_OFR_QTY" value="">';
                           
						} 
         
						if($tempory['IM_SPEC_MASTER_DESC'] =='Quantity Unit')
						{              
							$questdescArray=explode(',',$tempory['IM_SPEC_OPTIONS_DESC']);
							$questIdArray=explode(',',$tempory['IM_SPEC_OPTIONS_ID']);
							$counter++;       
							
							$masterId = $tempory['IM_SPEC_MASTER_ID'];
							
							if($masterId != '-1'){
								echo '<select class="form-control" id="ques'.$tempory['IM_SPEC_MASTER_ID'].'" name="ques'.$tempory['IM_SPEC_MASTER_ID'].'" onchange="ShowHideOtherQuantDiv();" tabindex="160" style="width:150px;">
											  <option value="">--Select--</option>';
											  
								for($i=0;$i<count($questdescArray);$i++){
							 
									if($questdescArray[$i]==$tempory['ISQ_RESPONSE']){
										$sel = "selected";
									}
									else{
										$sel='';
									}
									
									echo '<option value="'.$questdescArray[$i].';'.$questIdArray[$i].'" '.$sel.' >'.$questdescArray[$i].'</option>';                  
								}
							}else{
								echo '<input type = "text" value ="'.@$tempory['ISQ_RESPONSE'].'"  name="ques'.$tempory['IM_SPEC_MASTER_ID'].'>';
							}	
                           
							echo '</select>
                                    <input type="hidden" name="quantityUnit_masterId" value="'.$tempory['IM_SPEC_MASTER_ID'].'">
									<input type="hidden" name="quantityUnit_total_opt" value="'.sizeof($questIdArray).'">
									<input type="hidden" name="quantityUnit_response" value="'.$tempory['ISQ_RESPONSE'].'">
									<input type="hidden" name="quantityUnit_responseId" value="'.$tempory['ISQ_RESPONSE_ID'].'">
                                    <input type="hidden" name="ETO_OFR_QTY_UNIT" id ="ETO_OFR_QTY_UNIT" value="">
                                    <input maxlength="100" style="width: 150px;height:20px;display:none;" value="" name="ETO_OFR_QTY_UNIT_OTHER" id="ETO_OFR_QTY_UNIT_OTHER" type="text" >
									<input maxlength="100" value="" name="qty_unit_final" id="qty_unit_final" type="hidden" >';
          
           
						}	
					}  
					if($counter > 0){
						echo '</td></tr>';
					}	
				}        
			}

			if($counter==0)
            {           
				 ?>
					<tr>
                        <td align="right" class="admintext1" width="15%"><b>Quantity*</b></td>
                        <td  align="left" width="15%">&nbsp;
							<input type="text" maxlength="100" style="width: 150px;height:20px;" id="ETO_OFR_QTY" name="ETO_OFR_QTY" maxlength="50" value="<?php echo $ofrQty; ?>" >
							<input type="hidden" name="quantityIsq" value="no">
                        </td>
                        <td class="admintext1" width="30%" align="left">
                        <select class="form-control" id="ETO_OFR_QTY_UNIT" name="ETO_OFR_QTY_UNIT" onchange="ShowHideOtherQuantDiv();" tabindex="160" style="width:150px;">
							<option value="">--Select--</option>
                    <?php                 foreach($qtyList as $ql=>$qtyList){
                                                    $sel = (!empty($ofrQtyUnit) && $ofrQtyUnit == $qtyList?"selected":'');                   
                                 ?>
                                          <option value="<?php echo $qtyList; ?>" <?php echo $sel; ?>><?php echo $qtyList; ?></option>
                    <?php                 } ?> 
                                          <option value="">--------</option>           
                    <?php                 foreach($qtyListOther as $qlo=>$qtyListOther){
                    $sel1 = (!empty($ofrQtyUnit) && $ofrQtyUnit == $qtyListOther?"selected":'');   
                              ?>
                                          <option value="<?php echo $qtyListOther; ?>" <?php echo $sel1; ?>><?php echo $qtyListOther; ?></option>
                    <?php                 } ?>
                                    </select>   <input type="hidden" name="quantityUnitIsq" value="no">                                    
                                   
                                   
                                        <input maxlength="100" style="width: 150px;height:20px;display:none;" value="" name="ETO_OFR_QTY_UNIT_OTHER" id="ETO_OFR_QTY_UNIT_OTHER" type="text" >
                                        <input maxlength="100" value="" name="qty_unit_final" id="qty_unit_final" type="hidden" >
                        </td>
                       
                                        <input maxlength="100" readonly style="background-color:#ffffca;width: 448px;height:20px;" value="<?php echo $callVerifyQuant; ?>" name="QTY_LIST_VAL_OTHER" id="QTY_LIST_VAL_OTHER" type="hidden" >
                        		</tr>
            <?php          
            }       
        }
        else 
		{
			 ?>
				<tr>
          
                        <td align="right" class="admintext1" width="15%"><b>Quantity*</b></td>
                        <td  align="left" width="15%">&nbsp;
                            <input type="text" maxlength="100" style="width: 150px;height:20px;" id="ETO_OFR_QTY" name="ETO_OFR_QTY" maxlength="50" value="<?php echo $ofrQty; ?>" >                   
                        </td>
                        <td class="admintext1" width="30%" align="left">
                        <select class="form-control" id="ETO_OFR_QTY_UNIT" name="ETO_OFR_QTY_UNIT" onchange="ShowHideOtherQuantDiv();" tabindex="160" style="width:150px;">
                                          <option value="">--Select--</option>
                    <?php                 foreach($qtyList as $ql=>$qtyList){
                                                    $sel = (!empty($ofrQtyUnit) && $ofrQtyUnit == $qtyList?"selected":'');                   
                                 ?>
                                          <option value="<?php echo $qtyList; ?>" <?php echo $sel; ?>><?php echo $qtyList; ?></option>
                    <?php                 } ?> 
                                          <option value="">--------</option>           
                    <?php                 foreach($qtyListOther as $qlo=>$qtyListOther){
                    $sel1 = (!empty($ofrQtyUnit) && $ofrQtyUnit == $qtyListOther?"selected":'');   
                              ?>
                                          <option value="<?php echo $qtyListOther; ?>" <?php echo $sel1; ?>><?php echo $qtyListOther; ?></option>
                    <?php                 } ?>
                                    </select>                                  
                                   
                                   
                                        <input maxlength="100" style="width: 150px;height:20px;display:none;" value="" name="ETO_OFR_QTY_UNIT_OTHER" id="ETO_OFR_QTY_UNIT_OTHER" type="text" >
                                        <input maxlength="100" value="" name="qty_unit_final" id="qty_unit_final" type="hidden" >
                        </td>
                        <td class="admintext1" width="40%" align="left">
                            <input maxlength="100" readonly style="background-color:#ffffca;width: 448px;height:20px;" value="<?php echo $callVerifyQuant; ?>" name="QTY_LIST_VAL_OTHER" id="QTY_LIST_VAL_OTHER" type="text" >
                        </td>
				</tr>    
	  <?php  ?>
	  
			<tr>
				<td align="right" class="admintext1" width="15%"><b>Description</b></td>
				<td  align="left" width="45%" colspan="2">&nbsp;
					<textarea style="width:549px;border: 1px solid #A5ACB2;" rows="7" id="ETO_OFR_DESC" class="txt_style" name="ETO_OFR_DESC" value=""><?php echo $ofrDesc; ?></textarea>
					<textarea readonly style="background-color:#ffffca;width:449px;border: 1px solid #A5ACB2;" rows="7" id="ETO_OFR_DESC_UPDATED" class="txt_style" name="ETO_OFR_DESC_UPDATED" value=""><?php echo $enrichmentVal; ?></textarea>
				</td>
			   
			</tr>
                       
  <?php }
  
		$errMsg = $resultArr['errMsg'];
		$quesArr = $resultArr['quesArr'];
		$html = '';
		$counter=0;
		if(!empty($quesArr))
		{
			foreach($quesArr as $quesKey => $quesValue)
			{
				if("$quesKey" !='OLD_DATA' && !empty($quesValue) && array_key_exists('IM_SPEC_MASTER_ID',$quesValue))
				{
					$imSpecMasterId = $quesValue['IM_SPEC_MASTER_ID'];
					$imSpecMasterType = $quesValue['IM_SPEC_MASTER_TYPE'];
					$imSpecMasterDesc = $quesValue['IM_SPEC_MASTER_DESC'];
					$imSpecMasterAnswer = isset($quesValue['ISQ_RESPONSE']) ? $quesValue['ISQ_RESPONSE'] : '';  
					if($imSpecMasterDesc =='Usage/Application')
					{
						$counter++;
						echo '<tr>
						<td align="right" class="admintext1" width="15%"><b>Product Application</b></td>
						<td  align="left" width="'.$tdWidth.'" colspan="'.$textAreaColSpan.'">&nbsp;<textarea style="width:549px;border: 1px solid #A5ACB2;" rows="7" id="ques'.$imSpecMasterId.'" class="txt_style" name="ques'.$imSpecMasterId.'" value="">'.$imSpecMasterAnswer.'</textarea>
						<input type="hidden" name="productapp_masterid" value="'.$imSpecMasterId.'">
						<input type="hidden" name="productapp_optionId" value="'.$quesValue['IM_SPEC_OPTIONS_ID'].'">
						<input type="hidden" name="productapp_optiondesc" value="'.$quesValue['IM_SPEC_OPTIONS_DESC'].'">
						<input type="hidden" name="productapp_response" value="'.$quesValue['ISQ_RESPONSE'].'">
						<input type="hidden" name="productapp_responseId" value="'.$quesValue['ISQ_RESPONSE_ID'].'">
						<input type="hidden" name="ETO_OFR_REQ_APP_USAGE" id ="ETO_OFR_REQ_APP_USAGE" value=""></td>
						</tr>';          
					}           
				}
			}
			   
			if($counter==0)
			{?>
				<tr>
					<td align="right" class="admintext1" width="15%"><b>Product Application</b></td>
					<td  align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $textAreaColSpan; ?>">&nbsp;<textarea style="width:549px;border: 1px solid #A5ACB2;" rows="7" id="ETO_OFR_REQ_APP_USAGE" class="txt_style" name="ETO_OFR_REQ_APP_USAGE" value=""><?php echo $appUsage; ?></textarea></td>
				</tr>
		<?php
				   
			}     
		}
		else 
		{ ?>   
		   
			<tr>
				<td align="right" class="admintext1" width="15%"><b>Product Application</b></td>
				<td  align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $textAreaColSpan; ?>">&nbsp;<textarea style="width:549px;border: 1px solid #A5ACB2;" rows="7" id="ETO_OFR_REQ_APP_USAGE" class="txt_style" name="ETO_OFR_REQ_APP_USAGE" value=""><?php echo $appUsage; ?></textarea></td>
			</tr>
		<?php
			}
		?>
	   
           
            <tr>
                <td align="right" class="admintext1" width="15%"><b>Other Detail</b></td>
                <td  align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $textAreaColSpan; ?>">&nbsp;<textarea style="width:549px;border: 1px solid #A5ACB2;" rows="7" id="ETO_OFR_OTHER_DETAIL" class="txt_style" name="ETO_OFR_OTHER_DETAIL" value=""><?php echo $otherDetail ?></textarea></td></tr>
           
           
            <?php
          $errMsg = $resultArr['errMsg'];
          $quesArr = $resultArr['quesArr'];
          $html = '';
          $counter=0;
          if(!empty($quesArr)){
          foreach($quesArr as $quesKey => $quesValue){
               
                if("$quesKey" !='OLD_DATA' && !empty($quesValue) && !array_key_exists('IM_SPEC_MASTER_ID',$quesValue))
                    {
                    foreach($quesValue as $tempory)
                    {
            if($tempory['IM_SPEC_MASTER_DESC'] =='Approximate Order Value')
            {
           
            $imSpecMasterDescOrdervalue=$tempory['IM_SPEC_MASTER_DESC'];
            $imSpecMasterIdOrdervalue=$tempory['IM_SPEC_MASTER_ID'];
            $IM_SPEC_OPTIONS_DESCOrdervalue=$tempory['IM_SPEC_OPTIONS_DESC'];
            $IM_SPEC_OPTIONS_IDOrdervalue=$tempory['IM_SPEC_OPTIONS_ID'];
            $ordervalueArray=explode(',',$IM_SPEC_OPTIONS_DESCOrdervalue);
            $ordervalueIdArray=explode(',',$IM_SPEC_OPTIONS_IDOrdervalue);
            $imSpecMasterAnswerOrdervalue=$tempory['ISQ_RESPONSE'];
            $resOrdervalue=$imSpecMasterAnswerOrdervalue;
            $counter++;
       
            }
           
            if($tempory['IM_SPEC_MASTER_DESC'] =='Currency')
            {
            $imSpecMasterDescCurrency=$tempory['IM_SPEC_MASTER_DESC'];
            $imSpecMasterIdCurrency=$tempory['IM_SPEC_MASTER_ID'];
            $IM_SPEC_OPTIONS_DESCCurrency=$tempory['IM_SPEC_OPTIONS_DESC'];
            $IM_SPEC_OPTIONS_IDCurrency=$tempory['IM_SPEC_OPTIONS_ID'];
            $currencyArray=explode(',',$IM_SPEC_OPTIONS_DESCCurrency);
            $currencyIdArray=explode(',',$IM_SPEC_OPTIONS_IDCurrency);
            $imSpecMasterAnswerCurrency=$tempory['ISQ_RESPONSE'];
            $resCurrency=$imSpecMasterAnswerCurrency;
            $counter++;
       
            }
            }
        }
    }
}   

            if($counter !=0)
            {
            echo '<tr>
                    <td align="right" class="admintext1" width="15%"><b>Approx Order Value:</b></td>
                    <td align="left" width="'.$tdWidth.'" colspan="'.$colSpan.'">
                       
                        <select name="ques'.$imSpecMasterIdOrdervalue.'" id="ques'.$imSpecMasterIdOrdervalue.'" style="width:170px;border: 1px solid #A5ACB2;">
                        <option value="">--Select Order Value--</option>
                        <optgroup label="Indian Range">';
                            for($i=0;$i<count($ordervalueArray);$i++) {
                            if(preg_match("/^INR/",$resCurrency) &&  ($approx_order_valueIn[$ordervalueArray[$i]]==$resOrdervalue))
                            {
                                echo '<option value="'.$ordervalueArray[$i].';IN;'.$ordervalueIdArray[$i].'" selected>'.$approx_order_valueIn[$ordervalueArray[$i]].'</option>';
                            } else
                            {
                                echo '<option value="'.$ordervalueArray[$i].';IN;'.$ordervalueIdArray[$i].'">'.$approx_order_valueIn[$ordervalueArray[$i]].'</option>';
                                      
                                }
                        }
                     
                        echo '</optgroup>
                        <optgroup label="Foreign Range">';
                          for($i=0;$i<count($ordervalueArray);$i++) {
                            if((!preg_match("/^INR/",$resCurrency)) && ($approx_order_valuefrn[$ordervalueArray[$i]]==$resOrdervalue))
                            {
                                echo '<option value="'.$ordervalueArray[$i].';FR;'.$ordervalueIdArray[$i].'" selected>'.$approx_order_valuefrn[$ordervalueArray[$i]].'</option>';
                            } else
                            {
                                echo '<option value="'.$ordervalueArray[$i].';FR;'.$ordervalueIdArray[$i].'">'.$approx_order_valuefrn[$ordervalueArray[$i]].'</option>';
                                      
                                }
                        }
                        echo '</optgroup>
                        </select><input type="hidden" name="approx_order_masterid" value="'.$imSpecMasterIdOrdervalue.'">
                        <input type="hidden" name="ETO_OFR_APPROX_ORDER_VALUE" id ="ETO_OFR_APPROX_ORDER_VALUE" value="">';
                       
                       
                       
                         echo '<select name="ques'.$imSpecMasterIdCurrency.'" id="ques'.$imSpecMasterIdCurrency.'" style="margin-left: 3px;width:170px;border: 1px solid #A5ACB2;" >
                            <option value="">--Select Currency--</option>';
                                for($i=0;$i<count($currencyArray);$i++){
                                      
                                    $tempCurr=explode('-',$currencyArr[$currencyArray[$i]]);
                                    $tempCurr=$tempCurr[0];
                                    $tempCurr=trim($tempCurr);
                                            if(preg_match("/^$tempCurr/",$resCurrency))
                                            {
                                                echo '<option value="'.$currencyArray[$i].';'.$currencyIdArray[$i].'" selected >'.$currencyArr[$currencyArray[$i]].'</option>';
                                            } else
                                            {
                                                echo '<option value="'.$currencyArray[$i].';'.$currencyIdArray[$i].'" >'.$currencyArr[$currencyArray[$i]].'</option>';
                                            }                       
                                }
                   
                   
                    echo '</select><input type="hidden" name="currencyMasterId" value="'.$imSpecMasterIdCurrency.'">
                    <input type="hidden" name="ETO_OFR_CURRENCY_ID" id ="ETO_OFR_CURRENCY_ID" value="">
                    </td>
                </tr>';
          
          
          
        
        }
       
         if($counter==0)
            {
            ?>
           <tr>
                    <td align="right" class="admintext1" width="15%"><b>Approx Order Value*:</b></td>
                    <td align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">
                       
                        <select name="ETO_OFR_APPROX_ORDER_VALUE" id="ETO_OFR_APPROX_ORDER_VALUE" style="width:170px;border: 1px solid #A5ACB2;">
                        <option value="">--Select Order Value--</option>
                        <optgroup label="Indian Range">
                        <?php $approxOrderValuetemp=0;
                            foreach($recvaluerangeIN as $k => $row) {
                            $id = $row['BL_VALUE_RANGE_ID'];
                            if($currId == '1' && $approxOrderValue == $id)
                            {
                                $approxOrderValuetemp=1;
                                echo '<option value="'.$id.'" selected>'.$row['VAL'].'</option>';
                            } else
                            {
                                echo '<option value="'.$id.'">'.$row['VAL'].'</option>';
                                      
                                }
                        }
                     ?>
                        </optgroup>
                        <optgroup label="Foreign Range">
                        <?php foreach($recvaluerangeFR as $kFR => $rowFR) {
                            $idFR = $rowFR['BL_VALUE_RANGE_ID'];
                            if($currId != '1' && $approxOrderValue == $idFR)
                            {       $approxOrderValuetemp=1;
                                echo '<option value="'.$idFR.'" selected>'.$rowFR['VAL'].'</option>';
                            }
                            else
                            {
                                echo '<option value="'.$idFR.'">'.$rowFR['VAL'].'</option>';
                               
                            }
                        } ?>
                        </optgroup>
                        </select>
                         <select name="ETO_OFR_CURRENCY_ID" id="ETO_OFR_CURRENCY_ID" style="margin-left: 3px;width:170px;border: 1px solid #A5ACB2;" >
                            <option value="">--Select Currency--</option>~;
                        <?php
                                foreach($currencyIN as $kC => $rowC){
                                            $idCurr = $rowC['IIL_MASTER_DATA_VALUE'];
                                            if($currId == $idCurr)
                                            {
                                                echo '<option value="'.$idCurr.'" selected >'.$rowC['IIL_MASTER_DATA_VALUE_TEXT'].'</option>';
                                            } else
                                            {
                                                echo '<option value="'.$idCurr.'" >'.$rowC['IIL_MASTER_DATA_VALUE_TEXT'].'</option>';
                                            }                       
                                }
                   
                     ?>
                    </select>
                    <?php if($approxOrderValuetemp==0 and !empty($approxOrderValue))           
                     echo '<br/><br/><input type="text" name="order_value_original" size="30" value="'.$approxOrderValue.'" readonly/>';?>
                    </td>
                </tr>
            <?php
           
            }
       
       
           
       
        ?>       
               
               
                <?php
                    $reqPurpose = isset($rec['ETO_ENQ_PURPOSE'])?$rec['ETO_ENQ_PURPOSE']:'';
                    $reqType = isset($rec['ETO_ENQ_TYP'])?$rec['ETO_ENQ_TYP']:'';
                ?>
            <tr>
                <td align="right" class="admintext1" width="15%"><b>Requirement Posting Purpose:</b></td>
                <td  align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">&nbsp;<input name="ETO_ENQ_PURPOSE" id="enq_purpose1" onclick="check_enq_pur(1);" value="1" type="checkbox" <?php echo ($reqPurpose == 1) ? "checked":'' ?>>
                <b>To Make Purchase</b>
                <input name="ETO_ENQ_PURPOSE" id="enq_purpose2" onclick="check_enq_pur(2);" value="2" type="checkbox" <?php echo ($reqPurpose == 2) ? "checked":'' ?>>
                <b>To Know Price Only</b>
                    </td>
        </tr>

                <tr>
                <td align="right" class="admintext1" width="15%"><b>Requirement Type:</b></td>
                <td  align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">&nbsp;<input name="ETO_ENQ_TYP" id="enq_typ1" onclick="check_enq_typ(1);" value="1" type="checkbox" <?php echo ($reqType == 1 || $reqType == 3) ? "checked":'' ?>>
                <b>Retail Enquiry</b>
                <input name="ETO_ENQ_TYP" id="enq_typ2" onclick="check_enq_typ(2);" value="2" type="checkbox" <?php echo ($reqType == 2 || $reqType == 4) ? "checked":'' ?>>
                <b>Bulk Enquiry</b>
                    </td>
            </tr>
            <tr>
            <td align="right" class="admintext1" width="15%"><b>Preferred suppliers location:</b></td>
                <td align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
            <?php
                    $ofrCountryIso = isset($rec['FK_GL_COUNTRY_ISO'])?$rec['FK_GL_COUNTRY_ISO']:'IN';
                    $ofrGeoId = isset($rec['ETO_OFR_GEOGRAPHY_ID'])?$rec['ETO_OFR_GEOGRAPHY_ID']:'';
                    $purchasePeriod = isset($rec['ETO_OFR_REQ_PURCHASE_PERIOD'])?$rec['ETO_OFR_REQ_PURCHASE_PERIOD']:'';
                    $reqType = isset($rec['ETO_OFR_REQ_TYPE'])?$rec['ETO_OFR_REQ_TYPE']:'';
                    $reqFreq = isset($rec['ETO_OFR_REQ_FREQ'])?$rec['ETO_OFR_REQ_FREQ']:'';
                    if($ofrCountryIso == 'IN'){ ?>
                            <tr>
                                    <td  class="admintext1">
                                        <input name="ETO_OFR_GEOGRAPHY_ID" id="r1" onclick="oth_vl(1);" value="1" type="checkbox" <?php echo ($ofrGeoId == 1)?'CHECKED':'' ?> >
                                        <b>Local Only</b>
                                       
                                        <input name="ETO_OFR_GEOGRAPHY_ID" id="r2" onclick="oth_vl(2);" value="2" type="checkbox" <?php echo ($ofrGeoId == 2)?'CHECKED':'' ?>>
                                        <b>Anywhere in India</b>
                                   
                                        <input name="ETO_OFR_GEOGRAPHY_ID" id="r3" onclick="oth_vl(3);" value="3" type="checkbox" <?php echo ($ofrGeoId == 3)?'CHECKED':'' ?> >
                                        <b>Global</b>
                                   
                                        <input name="ETO_OFR_GEOGRAPHY_ID" id="r4" onclick="oth_vl(4);" value="4" type="checkbox" <?php echo ($ofrGeoId == 4)?'CHECKED':'' ?>>
                                        <b>Specific Cities</b>
                                    </td>
                            </tr>              
           <?php } else { ?>
                       <tr>
                                    <td  class="admintext1">
                                        <input name="ETO_OFR_GEOGRAPHY_ID" id="r1" onclick="oth_vl(1);" value="1" type="checkbox" <?php echo ($ofrGeoId == 1)?'CHECKED':'' ?> >
                                        <b><?php echo $cntry_name1; ?> Only</b>
                                       
                                        <input name="ETO_OFR_GEOGRAPHY_ID" id="r2" onclick="oth_vl(2);" value="2" type="checkbox" <?php echo ($ofrGeoId == 2)?'CHECKED':'' ?> style="display:none;">
                                       
                                   
                                        <input name="ETO_OFR_GEOGRAPHY_ID" id="r3" onclick="oth_vl(3);" value="3" type="checkbox" <?php echo ($ofrGeoId == 3)?'CHECKED':'' ?> >
                                        <b>Global</b>
                                   
                                        <input name="ETO_OFR_GEOGRAPHY_ID" id="r4" onclick="oth_vl(4);" value="4" type="checkbox" <?php echo ($ofrGeoId == 4)?'CHECKED':'' ?> style="display:none;">
                                         
                                    </td>
                            </tr>        
         <?php  }?>
                            <tr>
                                    <td colspan="4">
                                    <?php if($ofrCountryIso == 4) {
                                        echo '<div id="dbox" style="display:block; padding-top:2px;">';
                                     } else {
                                        echo '<div id="dbox" style="display:none; padding-top:2px;">';
                                     } ?>
                                    <table style="font-size:11px; color:#949494">
                                    <tbody><tr>
   
                                    <td>
                                    <input style="width:65px; margin-left:4px;"  name="pref_city" id="pref_city" autocomplete="off" type="text" value="<?php echo $cityArr['loc_city1_name']; ?>">
                                    <br> <span style="padding-left:4px;">City</span></td>
                                    <td> <input style="width:65px; margin-left:4px;" onkeyup="" name="pref_state" id="pref_state" autocomplete="off" type="text" value="<?php echo $cityArr['loc_state1_name']; ?>">
                                    <br><input value="<?php echo $cityArr['loc_city1']; ?>" name="city1" id="city1" type="hidden">
                                    <span style="padding-left:4px;">State</span></td>
                                    <td> <input style="width:70px;margin-left:4px;" autocomplete="off" name="pref_city1" id="pref_city1" type="text" value="<?php echo $cityArr['loc_city2_name']; ?>">
                                    <br> <span style="padding-left:4px;">City</span></td>
                                    <td> <input style="width:65px;margin-left:4px;" autocomplete="off" onkeyup="" name="pref_state1" id="pref_state1" type="text" value="<?php echo $cityArr['loc_state2_name']; ?>">
                                    <br><input value="<?php echo $cityArr['loc_city2']; ?>" name="city2" id="city2" type="hidden">
                                    <span style="padding-left:4px;">State</span></td>
                                    <td> <input style="width:65px;margin-left:4px;" autocomplete="off" name="pref_city2" id="pref_city2" type="text" value="<?php echo $cityArr['loc_city3_name']; ?>">
                                    <br> <span style="padding-left:4px;">City</span></td>
                                    <td> <input style="width:65px;margin-left:4px;" autocomplete="off" onkeyup="" name="pref_state2" id="pref_state2" type="text" value="<?php echo $cityArr['loc_state3_name']; ?>">
                                    <br><input value="<?php echo $cityArr['loc_city3']; ?>" name="city3" id="city3" type="hidden">
                                    <span style="padding-left:4px;">State</span></td></tr>
                                    </tbody></table>
                                    </div> </td></tr>
                                    </tbody>
                                    </table>
                                    </td>
                            </tr>
                            <tr>
                                <td align="right" class="admintext1" width="15%"><b>How soon do you want to purchase:</b></td>
                                <td align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">&nbsp;
                                <?php foreach($timePeriod as $kTime => $rowTime){
                                    $timeId = $rowTime['IIL_MASTER_DATA_VALUE'];
                                    $timeName = $rowTime['IIL_MASTER_DATA_VALUE_TEXT'];
                                    $timeChecked =  ($purchasePeriod == $timeId)?"checked":'';
                                        echo '<input name="ETO_OFR_REQ_PURCHASE_PERIOD" id="time_period'.$timeId.'" onclick="check3('.$timeId.');" value="'.$timeId.'" type="checkbox" '.$timeChecked.'>';
                                        echo '<b>'.$timeName.'</b>';                               
                                } ?>
                                </td>
                            </tr>
                            <tr>
                                <td align="right" class="admintext1" valign="top" width="15%"><b>Why do you need this:</b></td>
                                <td align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">&nbsp;
                                <?php foreach($reqReason as $k=>$res){
                                        $reqreasonChecked = ($reqType == $k)?"checked":'';
                                        echo '<input name="ETO_OFR_REQ_TYPE" id="n'.$k.'" onclick="check2('.$k.')" value="'.$k.'" type="checkbox" '.$reqreasonChecked.' >';
                                        echo '<b>'.$res.'</b>';                           
                                 } ?>
                                 </td>
                            </tr>
                            <tr>
                                <td align="right" class="admintext1" valign="top" width="15%"><b>Requirement Frequency:</b></td>
                               
                                <td align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">&nbsp;
                                <?php $selectReqFreq = ($reqFreq >=2)?2:$reqFreq;
                                 foreach($reqFreqArr as $reqK => $reqRow){
                                    $reqFreqChecked = ($selectReqFreq == $reqK) ? "checked" : '' ;
                                        echo '<input name="ETO_OFR_REQ_FREQ" id="require_freq'.$reqK.'" onclick="check_freq('.$reqK.');" value="'.$reqK.'" type="checkbox" '.$reqFreqChecked.'>
                                        <b>'.$reqRow.'</b>';                               
                                } $selected = $reqFreq;?>
                               
                                <span id="req" style="display:<?php echo ($reqFreq >=2)?'inline-block;':'none;';?>">
                                <select name="reg_req_list" id="reg_req_list" name="reg_req_list" onchange="unchck_review();$('#reg_req_list').css('background-color','#FFF');hideErrorDiv('reqFreqMsg');" tabindex="189" style="width: 100px;float:left">
                        <option value="">--Select --</option>
                        <option value="3" <?php echo ($selected == 3)?"selected":'' ?>>Daily</option>
                        <option value="4" <?php echo ($selected == 4)?"selected":'' ?>>Weekly</option>
                        <option value="5" <?php echo ($selected == 5)?"selected":'' ?>>Monthly</option>
                        <option value="6" <?php echo ($selected == 6)?"selected":'' ?>>Quarterly</option>
                        <option value="7" <?php echo ($selected == 7)?"selected":'' ?>>Half Yearly</option>
                        <option value="8" <?php echo ($selected == 8)?"selected":'' ?>>Yearly</option>
                        </select>
                        </span>
                       
                                </td>
                            </tr>
<?php


    $errMsg = $resultArr['errMsg'];
    $quesArr = $resultArr['quesArr'];
    $flag = $resultArr['flag'];
    $html = '';
	$countr=0;
	$qMasterIdarray =array();
	$quesIdString = '';
	if(!empty($quesArr))
	{	
		$html .='<input type="hidden" name="ques_size" value='.$size.'><input type="hidden" name="flag" value='.$flag.'>';
		$n=1;
		foreach($quesArr as $quesKey => $quesValue)
		{
			if("$quesKey" !='OLD_DATA' && !empty($quesValue) && array_key_exists('IM_SPEC_MASTER_ID',$quesValue))
			{
				$imSpecMasterId = $quesValue['IM_SPEC_MASTER_ID'];
				$imSpecMasterType = $quesValue['IM_SPEC_MASTER_TYPE'];
				$imSpecMasterDesc = $quesValue['IM_SPEC_MASTER_DESC'];
				$imSpecMasterAnswer = isset($quesValue['ISQ_RESPONSE']) ? $quesValue['ISQ_RESPONSE'] : ''; 

				if($imSpecMasterDesc != 'Quantity#Quantity Unit' && $imSpecMasterDesc != 'Approximate Order Value#Currency' && $imSpecMasterDesc != 'Currency#Approximate Order Value' && $imSpecMasterDesc != 'Usage/Application' && 	$imSpecMasterDesc !='')
				{
					$countr++;
					array_push($qMasterIdarray,$imSpecMasterId);	

					$quesIdString .=  $imSpecMasterId;
					$quesIdString .=  ',';

					$html .='<tr>';
					$html .= '<td align="right" class="admintext1" width="15%">&nbsp;'.$quesValue['IM_SPEC_MASTER_DESC'].':</td>';

					if($imSpecMasterType == 1)
					{
						$html .= '<td align="left" width="'.$tdWidth.'">
						<input type="text"   style="width:170px;" rel="'.$imSpecMasterId.'" id="'.$imSpecMasterId.'" name="ques'.$imSpecMasterId.'[]" value="'.$imSpecMasterAnswer.'" >
						<input type="hidden" name="ques_master_id_'.$countr.'" value="'.$imSpecMasterId.'">
						<input type="hidden" name="ques_desc_'.$countr.'" value="'.$quesValue['IM_SPEC_MASTER_DESC'].'">
						<input type="hidden" name="ques_type_'.$countr.'" value="1">
						<input type="hidden" name="ques_options_id_'.$countr.'" value="'.$quesValue['IM_SPEC_OPTIONS_ID'].'">
					</td>';
					}
					else if($imSpecMasterType == 2)
					{
						$html .= '<td align="left" class="admintext1" width="'.$tdWidth.'">';
						$arraytt=explode(",",$quesValue['ISQ_RESPONSE_ID']);
						$arrayoptiondesc=explode(",",$quesValue['IM_SPEC_OPTIONS_DESC']);
						$arrayoptionId=explode(",",$quesValue['IM_SPEC_OPTIONS_ID']);
						for($i=0;$i<count($arrayoptionId);$i++)
						{
							if(in_array($arrayoptionId[$i],$arraytt)){
								$radioChecked ="Checked";
							}
							else{
								$radioChecked ="";
							}

							$html .= '
							<div style="margin-left: 4px;margin-right: 5px;display: inline-block;">
							<input   type="radio" rel="'.$arrayoptionId[$i].'" id="ques'.$imSpecMasterId.'" name="ques'.$imSpecMasterId.'[]" style="margin-top: 6px;" '.$radioChecked.' value="'.$arrayoptiondesc[$i].';'.$arrayoptionId[$i].'" onchange="uncheckReview()">
							<input type="hidden" name="'.$imSpecMasterId."_".$arrayoptiondesc[$i].'" value="'.$arrayoptionId[$i].'">
							<label for="ques'.$arrayoptionId[$i].'"></label>
							<span class="media-top">'.$arrayoptiondesc[$i].'</span>
							</div>';
						}
						$html .= '<input type="hidden" name="ques_master_id_'.$countr.'" value="'.$imSpecMasterId.'">
						<input type="hidden" name="ques_desc_'.$countr.'" value="'.$quesValue['IM_SPEC_MASTER_DESC'].'">
						<input type="hidden" name="ques_type_'.$countr.'" value="2"></td>';

					}
					else if($imSpecMasterType == 3)
					{
						$html .= '<td align="left" width="'.$tdWidth.'">&nbsp;<select  style="width:170px;border: 1px solid #A5ACB2;" name="ques'.$imSpecMasterId.'[]" rel="'.$imSpecMasterId.'" id="'.$imSpecMasterId.'" ><option value="">Select</option>';
						$arraytt=explode(",",$quesValue['ISQ_RESPONSE_ID']);
						$arrayoptiondesc=explode(",",$quesValue['IM_SPEC_OPTIONS_DESC']);
						$arrayoptionId=explode(",",$quesValue['IM_SPEC_OPTIONS_ID']);
						for($i=0;$i<count($arrayoptionId);$i++) 
						{
							if(in_array($arrayoptionId[$i],$arraytt)){
								$selected ="Selected";
							}
							else{
								$selected ="";
							}

							$html .= '<option value="'.$arrayoptiondesc[$i].';'.$arrayoptionId[$i].'" '.$selected.'>'.$arrayoptiondesc[$i].'</option>';
						}
						$html .= '</select>
						<input type="hidden" name="ques_master_id_'.$countr.'" value="'.$imSpecMasterId.'">
						<input type="hidden" name="ques_desc_'.$countr.'" value="'.$quesValue['IM_SPEC_MASTER_DESC'].'">
						<input type="hidden" name="ques_type_'.$countr.'" value="3"></td>';
					}
					else if($imSpecMasterType == 4)
					{
						$html .= '<td align="left" class="admintext1" width="'.$tdWidth.'">';

						$arraytt=explode(",",$quesValue['ISQ_RESPONSE_ID']);
						$arrayttValues=explode(",",$quesValue['ISQ_RESPONSE']);
						$arrayoptiondesc=explode(",",$quesValue['IM_SPEC_OPTIONS_DESC']);
						$arrayoptionId=explode(",",$quesValue['IM_SPEC_OPTIONS_ID']);

						$othersRespValue = $othersOptionId = $othersRespIndexValue = $othersDescIndexValue = $onChange = '';

						if(in_array("Others", $arrayoptiondesc)|| in_array("Other", $arrayoptiondesc))
						{
							$othersDescIndexValue = array_search('Others', $arrayoptiondesc);
							if(!$othersDescIndexValue){
								$othersDescIndexValue = array_search('Other', $arrayoptiondesc);
							}
							$othersOptionId = $arrayoptionId[$othersDescIndexValue];

							if(in_array($othersOptionId, $arraytt))
							{
								$othersRespIndexValue = array_search($othersOptionId, $arraytt);
								$othersRespValue = $arrayttValues[$othersRespIndexValue];
							}
						}

						for($i=0;$i<count($arrayoptionId);$i++) 
						{							
							$othersHtml = '';
							if(in_array($arrayoptionId[$i],$arraytt)){
								$checkBoxChecked ="Checked";
							}
							else{
								$checkBoxChecked ="";
							}
							
							if($othersOptionId == $arrayoptionId[$i])
							{
								$value = '';
								if(!preg_match('/Other/',$othersRespValue)){									
									$value = $othersRespValue;	
								}									
								$othersHtml = '<td style="padding-left:5px"><span class="media-top"><input type = "text" name = "others_'.$n.'" id = "others_'.$n.'" value="'.$value.'"><input type = "hidden" name = "others1_'.$n.'" id = "others1_'.$n.'"  value="'.$value.'"></span></td>';
								$checkBoxNo = 'check_opt_'.$n.'_'.($i+1);
							//passing the other checkbox id to the js function									
								$onChange = 'onchange="uncheckReview(\'check_opt_'.$n.'_'.($i+1).'\', \''.$n.'\')"';
							}

							$optionValue1 = str_replace(' ', '', $arrayoptiondesc[$i]);
							$optionValue1 = str_replace("'", "", $optionValue1);
							$optionValue1=$optionValue1.$arrayoptionId[$i];

							$html .= '<div><table><tbody><tr><td valign="top">
							<div class="check-box" style="margin-left: 4px;">
							<input type="checkbox"  rel="'.$arrayoptionId[$i].'" id="check_opt_'.$n.'_'.($i+1).'" class="regular-checkbox" '.$checkBoxChecked.' value="'.$arrayoptiondesc[$i].';'.$arrayoptionId[$i].'" name="check_opt_'.$n.'[]"'.$onChange.'>
							<input type="hidden" name="checkbox_opt_'.$n.'_'.($i+1).'" value="'.$arrayoptionId[$i].'">
							<label for="'.$arrayoptiondesc[$i].'"></label>
							</div>
							</td><td style="padding-left:5px"><span class="media-top">'.$arrayoptiondesc[$i].' </span></td>'.$othersHtml.'</tr></tbody></table></div>';		  
						}
						
						$html .='<input type="hidden" name="ques_master_id_'.$n.'" value="'.$imSpecMasterId.'">
						<input type="hidden" name="ques_desc_'.$n.'" value="'.$quesValue['IM_SPEC_MASTER_DESC'].'">
						<input type="hidden" name="ques_type_'.$n.'" value="4">
						<input type="hidden" name="othersOptionId_'.$n.'" value="'.$othersOptionId.'">
						<input type="hidden" name="total_opt_'.$n.'" value="'.count($arrayoptionId).'"></td>';
					}
					$html .='</tr>';
				}
				$n++;
			}
		}
		
		$uniqueQMasterIdCount = count(array_unique($qMasterIdarray));
		if($uniqueQMasterIdCount == 1){
			$uniquesnessFlag = "Same";
		}elseif($uniqueQMasterIdCount == $countr){
			$uniquesnessFlag = "Unique";
		}else{
			$uniquesnessFlag = "Mixed";
		}
		$quesIdString = rtrim($quesIdString, ",");

		$html .='<input type="hidden" name="ques_size" value='.$countr.'><input type="hidden" name="flag" value='.$flag.'> <input type="hidden" name="uniqueNess" value='.$uniquesnessFlag.'><input type="hidden" name="quesIds" value="'.$quesIdString.'">';        
	}
   echo $html;
   echo '<br>';
  
   $BIZ_ID=isset($NOBArr['FK_RFQ_TO_SUPPLIER_BIZ_ID']) ? $NOBArr['FK_RFQ_TO_SUPPLIER_BIZ_ID'] : '';
 

?>
                           
<tr>
               <td align="right" class="admintext1" width="15%"><b>Nature of Business of Supplier:</b></td>
               <td  align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">&nbsp;<input name="NOB" id="NOB1" onclick="check_enq_typ1(1);" value="30" type="checkbox" <?php echo ($BIZ_ID == 30) ? "checked":'' ?>>
               <b>Wholesaler</b>
            <input name="NOB" id="NOB2" onclick="check_enq_typ1(2);" value="40" type="checkbox" <?php echo ($BIZ_ID == 40 ) ? "checked":'' ?>>
               <b>Retailer</b>
                 <input name="NOB" id="NOB3" onclick="check_enq_typ1(3);" value="10" type="checkbox" <?php echo ($BIZ_ID == 10 ) ? "checked":'' ?>>
               <b>Manufacturer</b>
                <input name="NOB" id="NOB4" onclick="check_enq_typ1(4);" value="20" type="checkbox" <?php echo ($BIZ_ID == 20 ) ? "checked":'' ?>>
               <b>Exporter</b>
                                       </td>
          </tr>                            
                           
                           
           

<?php
    $destPort = isset($rec['ETO_OFR_REQ_DESTINATION_PORT'])?$rec['ETO_OFR_REQ_DESTINATION_PORT']:'';
    $shipmentMode = isset($rec['ETO_OFR_REQ_SHIPMENT_MODE'])?$rec['ETO_OFR_REQ_SHIPMENT_MODE']:'';
    $payMode = isset($rec['ETO_OFR_REQ_PAYMENT_MODE'])?$rec['ETO_OFR_REQ_PAYMENT_MODE']:'';
    if($cntry_iso != 'IN')
    { ?>
    <tr>
    <td align="right" class="admintext1" valign="top" width="15%"><b>Dest Port</b></td>
    <td align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">&nbsp;<input type='text' name='ETO_OFR_REQ_DESTINATION_PORT' id='ETO_OFR_REQ_DESTINATION_PORT' value='<?php echo $destPort; ?>'></td>           
    </tr>
    <tr>
    <td align="right" class="admintext1" valign="top" width="15%"><b>Shipment mode:</b></td>
    <td align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">&nbsp;<select name="ETO_OFR_REQ_SHIPMENT_MODE" id="ETO_OFR_REQ_SHIPMENT_MODE" style="margin-left: 3px;width:170px;border: 1px solid #A5ACB2;">
    <option value="">--Select Currency--</option>
    <?php foreach ($shipmentModeArr as $shipmentK => $shipmentVal){
        $selShip = ($shipmentMode == $shipmentK)?"selected":'';
        echo '<option value="'.$shipmentK.'" '.$selShip.'>'.$shipmentVal.'</option> ';
    } ?>
    </select></td>
    </tr>
    <tr>
    <td align="right" class="admintext1" valign="top" width="15%"><b>Preferred payment mode:</b></td>
    <td align="left" width="<?php echo $tdWidth; ?>" colspan="<?php echo $colSpan; ?>">&nbsp;<select name="ETO_OFR_REQ_PAYMENT_MODE" id="ETO_OFR_REQ_PAYMENT_MODE" style="margin-left: 3px;width:170px;border: 1px solid #A5ACB2;">
    <option value="">--Select Currency--</option>
    <?php foreach($paymentMode as $paymentK => $paymentVal){
                $paySel = ($payMode == $paymentK)?"selected":'';
                echo '<option value="'.$paymentK.'" '.$paySel.'>'.$paymentVal.'</option> ';
            } ?>
    </select></td>
    </tr>
   
   
   
<?php }  ?>
    </table>
    <br />
        <input type="hidden" name="offer" id="offer" value="<?php echo $offerId; ?>">
        <input type="hidden" name="status" id="status" value="<?php echo $status; ?>">
        <input type="hidden" name="delcallverify" id="delcallverify" value="">
        <input type="hidden" name="bltype" id="bltype" value="<?php echo $blType; ?>">
        <input type="hidden" name="tabletype" id="tabletype" value="<?php echo $tableType; ?>">
    <?php
     if(($lvl_code == 'E' || $lvl_code == 'V') && ($ofrStatus == 1) && ($tableType == 3))
    {
        echo '<input type="SUBMIT" name="SUBMIT" ID="SUBMIT"  value="SUBMIT" onclick="return check_res_keyword();">';
    }
    if(!empty($poolFlag) && $poolFlag == 1){   
    if ($lvl_code == 'E' || $lvl_code == 'V')
    {
            if ($status == 'E') {
                    echo '<INPUT TYPE="hidden" NAME="move" VALUE="next">
                    <INPUT TYPE="submit" NAME="cont" VALUE="Continue" onclick="document.myForm.action = \'/index.php?r=admin_eto/AdminEto/vieweditenrichment\';">';
            }                       
            echo '<INPUT TYPE="submit" NAME="del_call_verify" VALUE="Delete This Record" onClick="return confirmDel_Verify();">';
    }
    else {
                echo '<INPUT TYPE="hidden" NAME="move" VALUE="next">
                <INPUT TYPE="submit" NAME="cont" VALUE="Continue" onclick="document.myForm.action = \'/index.php?r=admin_eto/AdminEto/vieweditenrichment\';">';
    }
    }       
     ?>
    </form>
    <?php } else{
        echo "<span style='color:red'>No Offer Found</span>";   
    } ?>
</body></html>
