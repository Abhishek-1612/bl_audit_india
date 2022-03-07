<?php
$arc = isset($_REQUEST['arc']) ? $_REQUEST['arc'] : '';
$ban = isset($_REQUEST['ban']) ? $_REQUEST['ban'] : '';
$empId = Yii::app()->session['empid'];
$arc_checked = '';
$arc_checked_msg = "Please check on Archive Data option";
if ($arc == 1) {
    $arc_checked = "CHECKED";
    $arc_checked_msg = "Please uncheck Archive Data option";
}

if ($valid == 1 && !empty($result['rec'])) {
    $flagOfferNotFound = 0;
    $rec = $result['rec'];
    $status = $result['status'];
    $mcat_is_generic = '';
    $array_vendor_check = array('DDN', 'NOIDA');
    $associate_status = $ETO_LEAP_VENDOR_NAME = '';
    if (isset($rec['ETO_LEAP_VENDOR_NAME'])) {
        if (preg_match("/In-Active/", $rec['ETO_LEAP_VENDOR_NAME']) > 0) {
            $associate_status = "In-Active";
            $ETO_LEAP_VENDOR_NAME = rtrim($rec['ETO_LEAP_VENDOR_NAME'], "|In-Active");
        } elseif (preg_match("/Active/", $rec['ETO_LEAP_VENDOR_NAME'])) {
            $ETO_LEAP_VENDOR_NAME = rtrim($rec['ETO_LEAP_VENDOR_NAME'], "|Active");
            $associate_status = "Active";
        } else {
            $ETO_LEAP_VENDOR_NAME = $rec['ETO_LEAP_VENDOR_NAME'];
        }
    }
    $vendormatch = array();
    $vendormatch = array($ETO_LEAP_VENDOR_NAME);
    if (!empty($arr_lvl_code)) {
        if (isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] == 4 && isset($arr_lvl_code['ETO_LEAP_EMP_IS_ACTIVE']) && $arr_lvl_code['ETO_LEAP_EMP_IS_ACTIVE'] = - 1) {
            if (preg_match("/COMPETENT/i", $ETO_LEAP_VENDOR_NAME)) {
                $vendormatch = array('COMPETENT', 'BANREVIEW', 'COMPETENTDNC');
            } elseif (preg_match("/KOCHAR/i", $ETO_LEAP_VENDOR_NAME)) {
                $vendormatch = array('KOCHARTECHCHN', 'KOCHARTECHAUTO', 'KOCHARTECHDNC', 'KOCHARTECHLDH', 'KOCHARTECHINTENT');
            } elseif (preg_match("/RADIATE/i", $ETO_LEAP_VENDOR_NAME)) {
                $vendormatch = array('RADIATEPNSTOBL', 'RADIATEINTENT', 'RADIATEPNSMRK', 'RADIATEAUTO');
            } elseif (preg_match("/VKALP/i", $ETO_LEAP_VENDOR_NAME)) {
                $vendormatch = array('VKALPDNC', 'VKALPAUTOFRN', 'VKALPAUTOIND', 'VKALPINTENT');
            } else {
                $vendormatch = array($ETO_LEAP_VENDOR_NAME);
            }
        }
    }
    $approveby = isset($rec['GL_EMP_ID']) ? $rec['GL_EMP_ID'] : '';
    if (($approveby == - 11) || (($vendor_name == 'COMPETENT') && ($ban == 1)) || empty($vendor_name) || in_array($vendor_name, $array_vendor_check) || in_array($vendor_name, $vendormatch) || $status == 'W' || $status == 'F' || $status == 'P' || $status == 'Q') {
        $start = $result['start'];
        $mcatmapping = $result['mcatmapping'];
        $postParamArr = $result['postParamArr'];
        $userDetail = $result['userDetail'];
        $userDet = $result['userDet'];
        $blType = isset($rec['DIR_QUERY_FREE_BL_TYP']) ? $rec['DIR_QUERY_FREE_BL_TYP'] : 1;
        $tableType = isset($rec['TABLE_TYP']) ? $rec['TABLE_TYP'] : 3;
        $flagRecFound = 0;
        $rowCounter = 0;
        $mcatval = '';
        $catval = '';
        $Pmcatval = '';
        $map = 0;
        $PmcatId = 0;
        $PcatId = 0;
        $disp = '';
        $disp1 = '';
        $mcatIdNameVal = '';
        $disp_cat = '';
        $Pmcatflag = '';
        $pcat = '';
        foreach ($arr_map_ref as $k => $rec_map) {
            $map++;
            $catval.= $rec_map['FK_GLCAT_CAT_ID'] . ",";
            if ($rec_map['FK_GLCAT_MCAT_ID'] == $rec_map['PRIME_MCAT']) {
                $Pmcatval = $rec_map['GLCAT_MCAT_NAME'];
                $PcatId = $rec_map['FK_GLCAT_CAT_ID'];
                $PmcatId = $rec_map['PRIME_MCAT'];
                $bId = isset($rec_map['GLCAT_MCAT_IS_BUSINESS_TYPE']) ? $rec_map['GLCAT_MCAT_IS_BUSINESS_TYPE'] : '';
                if ($bId == 1) {
                    $pcat = '<span style="background:#c90000; color:#fff; padding:0 2px">Prime</span>&nbsp;<span style="background:#c90000; color:#fff; padding:0 2px">Business MCAT</span>';
                } else {
                    $pcat = '<span style="background:#c90000; color:#fff; padding:0 2px">Prime</span>';
                }
            } else {
                $pcat = '';
            }
            if (!empty($rec_map['GLCAT_CAT_NAME']) and !empty($rec_map['GLCAT_MCAT_NAME'])) $disp.= "- " . $rec_map['GLCAT_CAT_NAME'] . " >> " . $rec_map['GLCAT_MCAT_NAME'] . " " . $pcat . "<br>";
            if (!empty($rec_map['GLCAT_GRP_NAME']) and !empty($rec_map['GLCAT_CAT_NAME'])) $disp_cat = $rec_map['GLCAT_GRP_NAME'] . " >> " . $rec_map['GLCAT_CAT_NAME'];
            else $disp_cat = '';
            if (!empty($rec_map['FK_GLCAT_MCAT_ID'])) {
                $mcatID = $rec_map['FK_GLCAT_MCAT_ID'];
                $mcatval.= $rec_map['FK_GLCAT_MCAT_ID'] . ",";
                $mcatIdNameVal.= $rec_map['FK_GLCAT_MCAT_ID'] . "__" . $rec_map['GLCAT_MCAT_NAME'] . "__" . $rec_map['GLCAT_CAT_ID'] . "__" . $rec_map['GLCAT_CAT_NAME'] . "__" . $rec_map['GLCAT_GRP_ID'] . "__" . $rec_map['GLCAT_GRP_NAME'] . "____";
                $disp1.= '<input type="radio" name="pr_mcat" id="pr_mcat" value="' . $mcatID . '"';
                if ($PmcatId == $mcatID) {
                    $disp1.= ' checked ';
                }
                $disp1.= ' onclick="assignPmcat(' . $mcatID . ');"> ' . $disp_cat . ' >> ' . $rec_map['GLCAT_MCAT_NAME'] . ' <img src="/images/remove.gif" height="10" hspace="6" align="absmiddle" vspace="3" width="44" onclick="delete_mcat_mapping(' . $mcatID . ')" style="cursor: pointer;"><br>';
            }
        }
        $pmcatDisp = '';
        if (!empty($map)) {
            $catval = rtrim($catval, ',');
            $mcatval = rtrim($mcatval, ',');
            $mcatIdNameVal = rtrim($mcatIdNameVal, "_");
            if ($map > 1) {
                $pmcatDisp = '&nbsp;<span style="background:#c90000; color:#fff; padding:0 2px">Prime MCAT -</span> ' . $Pmcatval;
            } else {
                if (!empty($PmcatId)) {
                    $PcatId = $catval;
                } else {
                    $disp1 = $disp_cat . ' <img src="/images/remove.gif" height="10" hspace="6" align="absmiddle" vspace="3" width="44" onclick="delete_mcat_mapping(' . $catval . ')" style="cursor: pointer;">';
                }
            }
        } else {
            if (isset($rec['FK_GLCAT_CAT_ID']) && $rec['FK_GLCAT_CAT_ID'] == - 1) {
                $disp = '- Undefined Catagory';
                $disp1 = $disp;
            } else {
                $mcat_name = '';
                $catName = isset($rec['GLCAT_CAT_NAME']) ? $rec['GLCAT_CAT_NAME'] : '';
                if (isset($rec['FK_GLCAT_MCAT_ID']) && !empty($rec['FK_GLCAT_MCAT_ID'])) {
                    $mcat_name = isset($rec['GLCAT_MCAT_NAME']) ? $rec['GLCAT_MCAT_NAME'] : '';
                    $mcatID = isset($rec['FK_GLCAT_MCAT_ID']) ? $rec['FK_GLCAT_MCAT_ID'] : '';
                    $catID = isset($rec['FK_GLCAT_CAT_ID']) ? $rec['FK_GLCAT_CAT_ID'] : '';
                    if (preg_match("/( Generic )/", $mcat_name)) {
                        $rec['GLCAT_MCAT_NAME'] = rtrim($mcat_name, "( Generic )");
                        $mcat_is_generic = '<font color="red">(Generic)</font>';
                    }
                    $mcat_name = '&gt;&gt; ' . $mcat_name;
                    $mcatIdNameVal = $mcatID . '__' . $mcat_name . '__' . $catID . '__' . $catName;
                    if (!empty($catName) and !empty($mcat_name)) $disp = '- ' . $catName . ' ' . $mcat_name;
                    else $disp = '';
                    $disp_cat = $catName . ' ' . $mcat_name;
                    $disp1 = $disp_cat . ' <img src="/gifs/remove.gif" height="10" hspace="6" align="absmiddle" vspace="3" width="44" onclick="delete_mcat_mapping(' . $rec['FK_GLCAT_MCAT_ID'] . ')" style="cursor: pointer;">';
                }
            }
        }
        //Variables End
        
?>
	
	<html><head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">	
	<style type="text/css">	       
	body{margin:0; padding:0; font-size:12px; color:#333; font-family:Arial, Helvetica, sans-serif}
	table{font-family: Arial, Helvetica, sans-serif}
	textarea{width:97%; height:100px; font-family:arial; font-size:12px; margin:0; padding:0;}
	input, select, textarea{ font-family:arial; font-size:12px}
	.hd{color:#fff; font-size:13px}
	strong{color:#333333; font-size:12px}
	.fs11{font-size:11px}
	.red{color:red}
	.link a{color:#fff; text-decoration:underline}
	.link a:hover{color:#fff; text-decoration:none}
	a{color:#0000ff; text-decoration:underline}
	a:hover{color:#c90000; text-decoration:none}
	.impPara{font-size:12px; font-family:Helvetica, Arial; margin-bottom:2px}
	.lh{height:32px; }
	
	.clint{color:#c90000; font-weight:bold;FONT-SIZE:16px;letter-spacing:0px;padding-left:0px;}
	.ffl{float:left}
	.ffr{float:right}
	.cll{clear:left}
	.clR{clear:right}
	.clb{clear:both}
	.pp5{padding:3px 0 3px 8px}
	.modid{color:#000090; FONT-SIZE:14px; font-weight:bold; padding-top:3px; padding-right:15px}
	.bo{font-weight:bold;}
	.b_form td{font-size:12px;color:#292929;padding:3px 0 3px 0;}
	.b_form td.lab{text-align:right;font-weight:bold;width:124px;padding-right:6px}
	.btn_style{font-size:14px;padding:3px 5px;cursor:pointer;font-weight:bold; font-family:arial;color:#fff}
	.prime{background:#c90000; color:#fff; padding:0 2px}
	.lh20{line-height:20px;padding-top:2px;}
	.alrt span{color:#999999;font-size:11px;}
	.alrt a{color:#0000ff}
	.alrt a:hover{color:#000}
	.pd5{padding-left:10px}
	table{border-collapse:collapse}
	table td{border-collapse:collapse;}
	.gluser_info{border-collapse:collapse; border:1px solid #ededed;border-left:0px}
	.gluser_info td{border-collapse:collapse; border:1px solid #ededed;height:35px}
	.gluser_info td input{border:1px solid #d9d9d9; height:25px}
	.gluser_info td.lfb{border-left:0px}
	.admintext-h{font-family:arial,ms sans serif,verdana; font-size:12px; height:22px; padding-left:3px;}
	.flagtext{font-family:arial; font-size:12px;line-height:17px; padding:0px 30px 0px 3px; color:#0000ff;}
	.flagtext a{color:#0000ff; text-decoration:none;padding:0px 15px 0px 3px}
	.flagtext a:hover{color:#000000; text-decoration:underline;padding:0px 15px 0px 3px}
	.dw_sw{border: 0px;color:#0000FF; background:white; padding: 0px; height: 16px; line-height: 12px; _line-height: 15px;}	
	.admintext {font-family:arial,ms sans serif,verdana; font-size:12px;font-weight:bold;}
	.admintext1 {font-family:arial,ms sans serif,verdana; font-size:12px;}
	.admintext2 {font-family:ms sans serif,verdana; font-size:12px;}
	.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
	
	.admintlt_new {font-family:verdana,arial,ms sans serif; font-size:13px; color:800000; font-weight:bold;}
	.win-close { display:none; }
	.win-open { position:absolute; width:60%;}
	.displayoff { display:none; }
	.tabopen { border-collapse:collapse; border:1px solid #C2E6FF; border-bottom:0px; color:#0054C7; font-family:arial; font-size:15px; font-weight:bold; text-align:center; padding-top:4px; padding-bottom:4px; background-color:#F8FCFF; }
	.tabclose { border-collapse:collapse; border:1px solid #C2E6FF; background-color:#D2ECFF; color:#2161B8; font-family:arial; font-size:15px; font-weight:bold; text-align:center; padding-top:4px; padding-bottom:4px; cursor:pointer; }
	.blw1 { PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-SIZE: 11px; COLOR: #535353; FONT-FAMILY: verdana, arial; TEXT-DECORATION: none }
	.select_cat { font-family:arial; font-size:15px; padding-left:10px; font-weight:bold; padding-top:3px; }
	
	
	.tabborder { border-collapse:collapse; border-bottom:1px solid #C2E6FF; }
	.border_bottom { border-collapse:collapse; border:1px solid #C2E6FF; border-top:0px solid #C2E6FF; }
	.blw { PADDING-RIGHT: 10px; MARGIN-TOP: 2px; PADDING-LEFT: 10px; FONT-SIZE: 12px; MARGIN-BOTTOM: 4px; COLOR: #030303; FONT-FAMILY: verdana, arial; TEXT-DECORATION: none }
	.blw A { COLOR: #0000ff; TEXT-DECORATION: none }
	.blw A:hover { COLOR: #ff0000; TEXT-DECORATION: underline }
	.blw1 { PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-SIZE: 11px; COLOR: #535353; FONT-FAMILY: verdana, arial; TEXT-DECORATION: none }
	.myims { BORDER-RIGHT: #adc2d5 1px solid; BORDER-TOP: #adc2d5 1px solid; MARGIN-LEFT: 9px; BORDER-LEFT: #adc2d5 1px solid; WIDTH: 200px; BORDER-BOTTOM: #adc2d5 1px solid }
	.s_text { font-family:arial; font-size:13px; padding-left:12px; }
	.result_text td { font-family:arial; font-size:13px; color:#1F60A2; }
	.result_text td a { font-family:arial; color:#004C9A; }
	.bg_border { background-color:#AEAEAE; border:1px solid #C9C9C9; border-bottom:1px solid #AEAEAE; border-right:1px solid #AEAEAE; padding-left:0px; padding-right:3px; padding-bottom:3px; width:700px; }
	.co {color:#FF0000;}
	.co1 {color:#ff8000;}
	table.nme td{height:25px}
	.borderMid {width: 1.5px;background-color: #e8e0e0;position: absolute;top: 50%;height: 60%;right: 0;margin: 0 auto;left: 0;transform: translate(0,-50%);bottom: 0;vertical-align: middle;}
	</style>
	<script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js" ></script>
	<script language="JavaScript" src="/protected/modules/admin_eto/js/eto-admin.js?v=46"></script>
 	<script language="JavaScript" src="/protected/modules/admin_eto/js/cat-mcat-srch.js?y=8"></script>
	 <script type="text/javascript" src="/protected/modules/admin_eto/js/dropdowncontent.js?v=1"></script> 
        
                      <?php $server_name = !empty($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'gladmin.intermesh.net';
        if (preg_match('/dev-/', $server_name) == 1) echo '<iframe id="textReader" src="/admin_approval/restricted_keywords_product.txt" style="display: none;"></iframe>';
        else if (preg_match('/stg-/', $server_name) == 1) echo '<iframe id="textReader" src="/admin_approval/restricted_keywords_product.txt" style="display: none;"></iframe>';
        else echo '<iframe id="textReader" src="/admin_approval/restricted_keywords_product.txt" style="display: none;"></iframe>';
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
                   if (reserved_kwd.match(/\s+/)) {

                    var prd_val = temp.split(" ");
                    for (var l = 0; l < prd_val.length; l++) {
                        if (prd_val[l] == reserved_kwd) {
                            //   							match_word += reserved_type+"->"+reserved_kwd+',\n\t';
                            var chk_flag = checkReserveTyp(restypArr_title, reserved_type);

                            if (chk_flag == 0) {
                                restypArr_title.unshift(reserved_type);
                                reserved_type = toTitleCase(reserved_type);
                                match_word += reserved_type + ":\n";
                            }
                            if (match_word.indexOf('\t\t\t\t' + reserved_kwd) == -1) {
                                match_word += "\t\t\t\t :" + reserved_kwd.toUpperCase() + "\n";
                            }
                            // 								if ( match_word.search(reserved_kwd) == -1 )
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

                            //  							match_word += reserved_type+"->"+reserved_kwd+',\n\t';
                            var chk_flag1 = checkReserveTyp(restypArr_title1, reserved_type);
                            if (chk_flag1 == 0) {
                                restypArr_title1.unshift(reserved_type);
                                reserved_type = toTitleCase(reserved_type);
                                match_word += reserved_type + ":\n";
                            }
                            if (match_word.indexOf('\t\t\t\t' + reserved_kwd) == -1)
                            // 								if ( match_word.search(reserved_kwd) == -1 )
                            {
                                match_word += "\t\t\t\t : " + reserved_kwd.toUpperCase() + "\n";
                            }
                            // 							match_word += "\t\t"+reserved_kwd+"\n";
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
            
            else
	    {
	     temp_title=temp_title.trim(); 
	     var res1= reserved_kwd+'s';
		 var res2= reserved_kwd+'es';
		 
		 res1=res1.replace(/([.^$|*+?()\[\]{}\\-])/g, "\\$1");  //comment by akash	
		 res2=res2.replace(/([.^$|*+?()\[\]{}\\-])/g, "\\$1");  //comment by akash

	     var re1 = new RegExp('\\b' + res1 + '\\b', 'ig');
	     var re2 = new RegExp('\\b' + res2 + '\\b', 'ig');
	     if (temp_title.match(re1) || temp_title.match(re2)) {
                reserved_type = toTitleCase(reserved_type);
                match_word += reserved_type + ":\n";
                match_word += "\t\t\t\t : " + reserved_kwd.toUpperCase() + "\n";
            }
            
	      if(reserved_kwd.match(/es$/))
		{
		  res1=reserved_kwd.replace(/es$/,'');
		  res1=res1.replace(/([.^$|*+?()\[\]{}\\-])/g, "\\$1");  //comment by akash
		}
		else if(reserved_kwd.match(/s$/))
		{
		  res2=reserved_kwd.replace(/s$/,'');
		  res2=res2.replace(/([.^$|*+?()\[\]{}\\-])/g, "\\$1");  //comment by akash
		}
	     var re1 = new RegExp('\\b' + res1 + '\\b', 'ig');
	     var re2 = new RegExp('\\b' + res2 + '\\b', 'ig');
	     
	     if (temp_title.match(re1) || temp_title.match(re2)) {
                reserved_type = toTitleCase(reserved_type);
                match_word += reserved_type + ":\n";
                match_word += "\t\t\t\t : " + reserved_kwd.toUpperCase() + "\n";
            }
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
                        // 							if ( match_word.search(reserved_kwd) == -1 )
                        {
                            match_word += "\t\t\t\t : " + reserved_kwd.toUpperCase() + "\n";
                        }
                    }
                }

            }

        }

    }
    match_word = match_word.replace(/,$/, '');
    if (match_word != '') {

        var break_word_key = '';
        var s = match_word;
        s = s.replace(/\s+/g, ' ');
        s = s.replace(/\t/g, ' ');
        s = s.replace(/\n/g, ' ');
        // 			match_word =  toTitleCase(match_word);
        var arr = s.match(/([a-zA-Z\-]+?):/g);
        for (var k = 0; k < arr.length; k++) {
            var pure = arr[k].substring(0, arr[k].length - 1)
            arr[k] = pure;

        }

        var break_word = arr;
        for (var m = 0; m < break_word.length; m++) {
            // 				var breakword = break_word[m].split(',');
            var breakword = break_word[m];
            if ((breakword == 'adult') || (breakword == 'trademark') || (breakword == 'drugs')) {
                break_word_key += breakword[m] + ",";

            }
        }
        if ((break_word_key != '') && (action_name != 'reject' && action_name != 'reject1')) {
            break_word_key = break_word_key.replace(/,$/, '');
            //   				document.form1.item_name.focus();
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


    // 	}
    restypArr = '';
    restypArr_title = '';
    restypArr_title1 = '';
}

			function check_res_keyword(bodyonLoad)
			{
			  var validate_msg_title = validate_names($('#title').val().trim(), 'Title', 100,'','title','Title');

			  if (validate_msg_title)
			  { 	
		  
					if(validate_msg_title == "Please check that Title cannot be blank."){
						alert("Buy Lead Title is Wrong/Invalid");
						return false;       					
					}
		            			  
			  }
                            var validate_msg_desc = validate_names($('#desc').val().trim(), 'Description', 3999,'','desc','Description');
			    if (validate_msg_desc)
			    {	
			       if(validate_msg_desc == "Please check that Description cannot be blank."){
					   	alert("Buy Lead Description is Wrong/Invalid");
						return false;   
				   }
			    }
				
			
				var QtyValue = $('#qty').val().trim();
							
				if(/[~`!#$%\^&*\[\]\\;/\\":<>\?]/g.test(QtyValue)) {
					alert('Oops! Seems some special character present in Quantity. Kindly remove that.');
					return false;
				}
	
				var QtyListValue = $('#qty_list_val').val();
								
				if(QtyValue === '0'){
					alert('Buy Lead Quantity is Wrong/Invalid');
					return false;
				}
				
			    var validate_msg_qty = validate_names($('#qty').val(), 'Quantity', 100,'','qty','Quantity');
			    if (validate_msg_qty)
			    {	
			       if(validate_msg_qty != "Please check that Quantity cannot be blank.")
			       return false;
			    } 			  
				var validate_msg_qty_other = validate_names($('#ETO_OFR_QTY_UNIT_OTHER').val(), 'Quantity', 100,'','ETO_OFR_QTY_UNIT_OTHER','Quantity');
			    if (validate_msg_qty_other)
			    {	
 			       if(validate_msg_qty_other != "Please check that Quantity cannot be blank.")
			       return false;
 			     }
			    // return true;
			  return mulCategory_B();;
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
            function secondary_data(prevoffer,status_check,mid,prev_vendor_name)
            {
                var newData = {'prevoffer':prevoffer,'status_check':status_check,'mid':3442,'prev_vendor_name':prev_vendor_name,};
                if (status_check == 'A' || status_check == 'E')
                {
                    $.ajax({
                        type: 'POST',
                        dataType: 'HTML',
                        data: newData,
                        url: "index.php?r=admin_eto/OfferDetail/ShowsecondaryDetails",
                        async : false,
                        success : function(jsonResult){
                            if (jsonResult == '')
                            {
                                document.getElementById("secondary_data").innerHTML = 'Nothing to display.';
                            }
                            else
                            {
                                document.getElementById("secondary_data").innerHTML = jsonResult;
                            }
                        },
                        error: function(e) {
                            return false;
                        }
                    });
                }
            }
            function astbuy_data(prevoffer,status_check,mid,prev_vendor_name)
            {
                var newData = {'prevoffer':prevoffer,'status_check':status_check,'mid':3442,'prev_vendor_name':prev_vendor_name,};
                if (status_check == 'A' || status_check == 'E')
                {
                    $.ajax({
                        type: 'POST',
                        dataType: 'HTML',
                        data: newData,
                        url: "index.php?r=admin_eto/OfferDetail/ShowsecondaryDetails",
                        async : false,
                        success : function(jsonResult){
                           
                        },
                        error: function(e) {
                            return false;
                        }
                    });
                }
            }
           
            $(window).on('load',function(){
                secondary_data(<?php echo $offerID;?>,'<?php echo $status_check;?>',<?php echo $mid;?>,'<?php echo $prev_vendor_name;?>');
                });
		</script>

<script>
/*$(document).ready(
   
   function()
            { $('#fetch_data').click(function(){
                var newData = {'prevoffer':prevoffer,'status_check':status_check,'mid':3442,'prev_vendor_name':prev_vendor_name,'data':'showastbuy'};
                if (status_check == 'A' || status_check == 'E')
                {
                    $.ajax({
                        type: 'POST',
                        dataType: 'HTML',
                        data: newData,
                        url: "index.php?r=admin_eto/OfferDetail/ShowsecondaryDetails",
                        async : false,
                        success : function(jsonResult){
                            
                        },
                        error: function(e) {
                            return false;
                        }
                    });
                }
            }); 
            }
)

    </script>
	</head>
        <body bgcolor="#FFFFFF">
        <form name="jumpForm" method="post" action="/index.php?r=admin_eto/OfferDetail/editflaggedleads&mid=3424" style="margin-top:0;margin-bottom:0;">       
        <table cellspacing="0" cellpadding="0" border="0" bgcolor="#0056cc" align="center" width="100%" style="color: rgb(255, 255, 255); font-family: arial; font-size: 12px;"><tbody><tr>
        <?php
        if (!empty($rec) && !empty($offerID) && isset($rec['ETO_OFR_ID'])) { ?>
		<td height="5" align="left" bgcolor="#0056cc">		
		<strong style="color: rgb(255, 255, 255);padding-left:15px">GL ID: </strong><strong style="color: #ffde00;"><?php echo $rec['FK_GLUSR_USR_ID']; ?></strong>
		</TD>
	<?php
        } ?>
	<td bgcolor="#0056cc">&nbsp;&nbsp;</td>
<td class="link" bgcolor="#0056cc">&nbsp;
<input type="hidden" name="ofrtype" value="b">
<?php $ofrtype_link = "&ofrtype=B";
        $mcatmapping_link = '';
        if (!empty($mcatmapping) && $mcatmapping == 'N' && !empty($status) && $status == 'A') {
            if ($mcatmapping) {
                $mcatmapping_link = "&mcatmapping=" . $mcatmapping;
            }
            echo '<INPUT TYPE="hidden" NAME="mcatmapping" VALUE="' . $mcatmapping . '">';
        }
?>
        </TD>
        <TD bgcolor="#0056cc">&nbsp;
        
        </TD><?php
        if (!empty($rec) && !empty($offerID) && isset($rec['ETO_OFR_ID'])) {
            $lblstatus = '';
            if ($status == "W" || $status == 'F' || $status == 'P' || $status == 'Q') {
                $lblstatus = $status . "- Waiting";
            } else if ($status == "A") {
                $lblstatus = "Approved";
            } else if ($status == "E") {
                $lblstatus = "Expired";
            } else if ($status == "D") {
                $lblstatus = "Deleted";
            } else if ($status == "T") {
                $lblstatus = "Deleted";
            } else if ($status == "L") {
                $lblstatus = "All";
            }
?>
        <td height="25px">
        	<input type="hidden" name="action" value="edit">			
			<span style="font-weight:bold;float:left;margin:3px 0px 0px 0px;">Offer ID:</span>
                        <input type="text" name="offer" id="offer" style="width: 100px; float:left;margin:0px 0px 0px 3px;" maxlength="15" value="<?php echo $offerID; ?>" ><span style="float:left;"><input type="checkbox" name="arc" id="arc" value="1" <?php echo $arc_checked; ?> >&nbsp;<b>Archive Data</b>&nbsp;</span>
	<input type="hidden" name="status" value="<?php echo $status ?>">
	<input type="hidden" name="flag" value="<?php echo CHtml::encode($postParamArr['flag']); ?>">
	<input type="submit" name="jump" style="font-weight:bold;font-size: 11px; font-family: arial; padding: 0px; margin: 0px 0px 0px 3px;float:left;width:60px;height:21px; text-align:center;" value="Search" 
	onclick="if(offer.value.match('^[0-9]+\$')){}else{alert('Enter only Numeric Value'); return false;}"></td>
        <td  align="right"><b>Status:</b><span class="pp5" style="color: rgb(255, 222, 0); font-weight: bold;"></span><span title="<?php if ($status == 'P') {
                echo 'Waiting due to banned keyword found';
            } elseif ($status == 'Q') {
                echo 'Waiting due to banned web-service check failed';
            } else echo $lblstatus; ?>" style="color:#ffde00; font-weight:bold;padding-right:15px;">
	<?php echo $lblstatus . "</span></td>";
	        } ?></tr></table></form>
	<?php if (!empty($result['mesg'])) {
	            echo '<br><table align="center" border="0" cellspacing="1" cellpadding="1">
			<tr><td>
			<font color="#ff0000">' . $mesg . '</font>
			</td></tr>
			</table>';
	        }
	?>
	<input type="hidden" name="mcat" id="sel_mcat" value="">
	<input type="hidden" id='s1' value=''>
	<div style="position:absolute; z-index:1000;  top:0px; margin-top:0px; left:0px; " align="center" 
	class="win-close" id="div_info">
	<table width="620px" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td align="center">
	<div id="dynamicheight" style="margin-top:0px;"></div>
	<div class="bg_border">
	<div style="background-color:#ffffff;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td bgcolor="#e6e6e6">
	<div class="select_cat">Select Your Category</div></td>
	<td align="right" style="padding-right:14px;" bgcolor="#e6e6e6"><img src="/gifs/close1.gif" width="20" height="14" onclick="win_open()"></td>
	</tr>
	</table> <br>
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td  class="tabopen" width="180" id="s_tab" onclick="searchcat()">Search
	Categories</td>
	<td class="tabborder" width="10"><img height="1" src="/images/zero.gif" width="10"></td>
	<td width="170" class="tabclose"  id="b_tab" onclick="beowswcat()">Browse
	Categories</td>
	<td class="tabborder"><img height="1" src="/images/zero.gif" width="1"></td>
	</tr>
	</table>
	<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="border_bottom" height="350">
	<tr>
	<td bgcolor="#f8fcff" valign="top">
	<div id="browse_cat" style="display:none;"><br>
	<form style="margin: 0px" name="test">
	<table cellspacing="0" cellpadding="0" width="98%" border="0" 
	align="center">
	<tbody>
	<tr>
	<td width="50%" 
	style="font-family:arial; font-size:12px; padding-left:3px;"><b>1:</b><br>
	<span id="grp1"></span>
	</td>
	<td><img src="/images/zero.gif" width="4" height="1"></td>
	<td width="50%" style="font-family:arial; font-size:12px;">
	<div class="displayoff" id="css"><b>2:</b><br>
	<span id="cat1"></span></div></td>
	</tr>
	<tr>
	<td width="50%"><img src="/images/zero.gif" width="4" height="8"></td>
	<td></td>
	<td width="50%"></td>
	</tr>
	<tr>
	<td width="50%" 
	style="font-family:arial; font-size:12px; padding-left:3px;">

	<div class="displayoff" id="display_mcat"><b>3:</b><br>
	<div style="border: 1px solid rgb(51, 102, 153); background-color:#ffffff; overflow: auto; height: 165px; padding-left: 1px; font-size: 13px;"><span id="div_mcat"></span></div></DIV></TD>
	<td></td>
	<td width="50%"></td>
	</tr></tbody>
	</table>
	</form> </div>

            
	<div id="search_cat" ><br>
	<div class="blw" style="padding-left:6px; margin-top:6px; padding-bottom:4px;"><b style="font-size:13px;"><font color="#e95801">
	Enter	product keywords to find a category</font></b></div>
	<form name="ssss" onsubmit="return ListOnChange();">
	<table cellspacing="0" cellpadding="0" width="525" border="0">
	<tbody>
	<tr>
	<td><input class="myims" maxlength="60" size="33" name="txt_cat_mcat" id="txt_cat_mcat"></td>
	<td style="cursor:pointer;">
	<input type="button" name="button5" value="search" onclick="return ListOnChange();">
	</td>
	<td>
	<div class="blw1">For example, &quot;arm chair&quot; not &quot;furniture&quot;</div><img height="1" src="/images/zero.gif" width="240"></td>
	</tr></tbody>
	</table></form></div>

	<div id="s_result" style="display:none;">
	<div class="s_text">
	<span id ="head"></span>
	<span id="ajax"></span>
	</div>
	</div>
	<div class="select_cat">Mapping Categories</div>
	<form name="MapFrm">
	<div class="s_text" id="selected_mcat_list"><?php echo $disp1; ?></div>
	</form>	
	<div align="center" id='submit'> <img height="7" src="/images/zero.gif" width="1"><br>
	<input type="button" name="button2" value="Submit Category" onclick="win_open('cl_win')"></div>
	<div><br>
	</div></td>
	</tr>
	</table><br>
	</div></div></td>
	</tr>
	</table></div>
	
<!-- ending mapping cat -->
<?php $err1 = '';
        $err2 = '';
        $err3 = '';
        $err4 = '';
        $err5 = '';
        $err6 = '';
        $err7 = '';
        $err8 = '';
        $err9 = '';
        $err10 = '';
        $err21 = '';
        $err22 = '';
        $err24 = '';
        $err25 = '';
        if (!empty($rec) && !empty($offerID) && isset($rec['ETO_OFR_ID'])) {
            $flagRecFound = 1;
            $rowCounter++; ?>

<!-- new view only section akash start-->
<div align="center" id='secondary_data'> <img height="7" src="/images/zero.gif" width="1">

<br>
                </div>
<input type="button" name="fetch_data" id="fetch_data" value="Fetch data"  ONCLICK=" astbuy_data(<?php echo $offerID;?>,'<?php echo $status_check;?>',<?php echo $mid;?>,'<?php echo $prev_vendor_name;?>');"> 
<!-- new view only section akash  end-->
	<form name="adminForm" method="post" action="/index.php?r=admin_eto/AdminEto/setflag&mid=3424" style="margin-top:0;margin-bottom:0;" onsubmit="return checkLimit();">
<?php
            if ($result['show_client1']) {
                echo '<input type="hidden" name="is_client" value="1">';
            } else {
                echo '<input type="hidden" name="is_client" value="0">';
            }
?>
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
	<td bgcolor="#c6def1" class="pp5" height="28">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 	<tr>
   	<td><div class="ffl"><select name="type" style="width:106px;font-size:15px;margin-left:3px;font-weight:bold">
   	<option value="B" selected >Buy Leads</option></select></div></td>
   	<?php
            if ($result['show_client1']) {
                echo '<td><div class="clint ffl">' . $result['show_client1'] . '</div></td>';
            }
            $catsrch = '';
            $title = isset($rec['ETO_OFR_TITLE']) ? trim($rec['ETO_OFR_TITLE']) : '';
            $catsrch = isset($rec['ETO_OFR_TITLE']) ? trim($rec['ETO_OFR_TITLE']) : '';
            $catsrch = htmlentities(strip_tags($catsrch));
            //$catsrch =~ s/\s+/+/g;
            $Source = '';
            $origModidNew = '';
            if (preg_match("/FENQ/", $result['origModid'])) {
                $origModidNew = explode('-', $result['origModid']);
                $origModidNew = isset($origModidNew[1]) ? $origModidNew[1] : '';
                $Source = 'FENQ';
            } else {
                $origModidNew = $result['origModid'];
                $Source = 'DIRECT';
            }
            $title = htmlentities(strip_tags($title));
            $rag = isset($rec['RAG_SCORE']) ? $rec['RAG_SCORE'] : 'NA';
            $color = preg_replace("/AMBER/", "Yellow", $rag);
?><td>
        <div class="ffr modid"><span>Source: </span><span style="color:#c90000"><?php echo $Source; ?></span>    
	<span>&nbsp;&nbsp;Mod ID: <span style="color:#c90000"><?php echo $origModidNew; ?></span>
	<span>&nbsp;&nbsp;Pool: </span><span style="color:#c90000"><?php echo $result['pool_type']; ?></span>
        <span>&nbsp;&nbsp;High AOV: </span><span style="color:#c90000"><?php echo $rec['AOV_FLAG']; ?></span>
	<span>&nbsp;&nbsp;Is Retail: <span style="color:#c90000"><?php echo $result['lead_type']; ?></span>
	<span>&nbsp;&nbsp;Type: </span><span style="color:#c90000"><?php echo $result['ps_type']; ?></span>
        <span>&nbsp;&nbsp;RAG: </span><span style="color:<?php echo $color; ?>"><?php echo $rag; ?></span></div>	
	</div></td></tr></table></td>
	<td width="320" class="pp5" bgcolor="#c6def1">	
	<div class="ffr modid">Country Quality: <span style="color:#c90000"><?php echo isset($rec['ETO_OFR_QUALITY']) ? $rec['ETO_OFR_QUALITY'] : '' ?> </span></div></td>
	</tr> 

		<tr>
		<td class="pp5" valign="top">
		
		<table cellpadding="0" cellspacing="0" border="0" class="b_form" width="100%">
		
		<tr>
		
		<td class="lab" width="130">Title:</td>
		<td align="left" width="80%">
		<input type="text" name="title" id="title" value="<?php echo $title; ?>" style="width:97%;_width:625px" onkeyup="searchval(this.value);" onkeydown="searchval(this.value); return capturekey(this,event);" />
		</td>
		</tr>
		<tr>
		<td class="lab" valign="top">Description:<br><br>
		<div style="color:green;font-size:11px;font-weight:normal">
	<?php
            if (isset($rec['ETO_OFR_CALL_VERIFIED']) && $rec['ETO_OFR_CALL_VERIFIED'] == '2' && isset($rec['ETO_OFR_ONLINE_VERIFIED']) && $rec['ETO_OFR_ONLINE_VERIFIED'] == '2') {
                echo "[ UPDATED & CALL VERIFIED ]<br/>";
            } else if (isset($rec['ETO_OFR_CALL_VERIFIED']) && $rec['ETO_OFR_CALL_VERIFIED'] == '1') {
                echo "[ CALL VERIFIED ]<br/>";
            } else if (isset($rec['ETO_OFR_CALL_VERIFIED']) && $rec['ETO_OFR_CALL_VERIFIED'] == '2') {
                echo "[ CALL VERIFIED & UPDATED ]<br/>";
            }
            if (isset($rec['ETO_OFR_EMAIL_VERIFIED']) && $rec['ETO_OFR_EMAIL_VERIFIED'] == '1') {
                echo "[ EMAIL VERIFIED ]<br/>";
            } else if (isset($rec['ETO_OFR_EMAIL_VERIFIED']) && $rec['ETO_OFR_EMAIL_VERIFIED'] == '2') {
                echo "[ EMAIL VERIFIED & UPDATED ]<br/>";
            }
            if (isset($rec['ETO_OFR_ONLINE_VERIFIED']) && $rec['ETO_OFR_ONLINE_VERIFIED'] == '2' || isset($rec['ETO_OFR_CALL_VERIFIED']) && $rec['ETO_OFR_CALL_VERIFIED'] == '3') {
                echo "[ UPDATED ]<br/>";
            }
            $ETO_OFR_DESC = '';
            if (isset($rec['ETO_OFR_DESC'])) {
                $ETO_OFR_DESC = htmlentities(strip_tags($rec['ETO_OFR_DESC']));
            }
?>
		</div><br />
		</td>
		<td valign="top" height="100" >
		<textarea name="desc" wrap="physical"  id="desc" onkeydown="return capturekey(this,event);"  style="padding:3px;"><?php echo $ETO_OFR_DESC; ?></textarea>
		</td>
		</tr>
<?php
            $qty = isset($rec['ETO_OFR_QTY']) ? trim($rec['ETO_OFR_QTY']) : '';
            $qtyUnit = isset($rec['ETO_OFR_QTY_UNIT']) ? trim($rec['ETO_OFR_QTY_UNIT']) : '';
            $showVar = "none";
            $qtyUnitOther = '';
            $selOtherFlag = 0;
            if (!empty($qtyUnit) && !in_array($qtyUnit, $this->qtyList) && !in_array($qtyUnit, $this->qtyListOther)) {
                $showVar = "inline-block";
                $qtyUnitOther = $qtyUnit;
                $selOtherFlag = 1;
            }
?>
			<tr>
			<td class="lab">Quantity:</td>
			<td >
				<input type="text" name="qty" id="qty" value='<?php echo htmlentities(strip_tags($qty)); ?>' maxlength="30" onkeydown="return capturekey(this,event);" style="width:30%" />
				<select class="form-control" id="qty_list_val" name="qty_list_val" onchange="ShowHideOtherQuantDiv();$('#qty_list_val').css('background-color','#FFF');" style="width:30%">
              			    <option value="">--Select--</option>
<?php foreach ($this->qtyList as $ql => $qtyList) {
                $sel = (($qtyUnit == $qtyList) ? "selected" : '');
?>
              			    <option value="<?php echo $qtyList; ?>" <?php echo $sel; ?>><?php echo $qtyList; ?></option>
<?php
            } ?>  
              		    	    <option value="">--------</option>            
<?php foreach ($this->qtyListOther as $qlo => $qtyListOther) {
                $sel1 = (($qtyUnit == $qtyListOther) ? "selected" : (($selOtherFlag == 1 && $qtyListOther == "Others") ? "selected" : '')); ?>
              			    <option value="<?php echo $qtyListOther; ?>" <?php echo $sel1; ?>><?php echo $qtyListOther; ?></option>
<?php
            } ?>
            			</select>
            			<input maxlength="100" style="width: 150px;height:20px;display:<?php echo $showVar; ?>;" value="<?php echo $qtyUnitOther; ?>" name="ETO_OFR_QTY_UNIT_OTHER" id="ETO_OFR_QTY_UNIT_OTHER" type="text" >
			</td>
			</tr>
		<?php
            $keyWords = isset($rec['ETO_OFR_KEYWORDS']) ? trim($rec['ETO_OFR_KEYWORDS']) : '';
            if (!empty($keyWords) && preg_match('/\s/', $keyWords)) { ?>
			<tr>
			<td class="lab">Keywords:</td>
			<td ><input name="keywords" type="text" style="width:75%" maxlength="500" value='<?php echo $keyWords; ?>' /></td>
			</tr>
		<?php
            }
            $ofrSpec = isset($rec['ETO_OFR_SPEC']) ? trim($rec['ETO_OFR_SPEC']) : '';
            if (!empty($ofrSpec) && !preg_match('/\s/', $ofrSpec)) { ?>
			<tr>
			<td class="lab">Specifications:</td>
			<td ><input name="spec" value='<?php echo $ofrspec; ?>' type="text" style="width:75%" onkeydown="return capturekey(this,event);" maxlength="500" /></td>
			</tr>
		<?php
            }
            $qualty = isset($rec['ETO_OFR_QLTY']) ? trim($rec['ETO_OFR_QLTY']) : '';
            if (!empty($qualty) && !preg_match('/\s/', $qualty)) { ?>
		<tr>
			<td class="lab">quality certifications:</td>
			<td ><input type="text" name="qlty" value='<?php echo $qualty; ?>' maxlength="100" onkeydown="return capturekey(this,event);" style="width:75%" /></td>
			</tr>
		<?php
            }
            $payTerm = isset($rec['ETO_OFR_PAY_TERM']) ? trim($rec['ETO_OFR_PAY_TERM']) : '';
            if (!empty($payTerm) && preg_match('/\s/', $payTerm)) { ?>
		<tr>
			<td class="lab">Payment Terms:</td>
			<td ><input type="text" name="pay" value='<?php echo $payTerm; ?>' style="width:75%" maxlength="100" onkeydown="return capturekey(this,event);" /></td>
			</tr>
	      <?php
            }
            $supplyTerm = isset($rec['ETO_OFR_SUPPLY_TERM']) ? trim($rec['ETO_OFR_SUPPLY_TERM']) : '';
            if (!empty($supplyTerm) && preg_match('/\s/', $supplyTerm)) { ?>
			<tr>
			<td class="lab">Supply Terms:</td>
			<td ><input name="supply" value='<?php echo $supplyTerm; ?>'  maxlength="100" onkeydown="return capturekey(this,event);" type="text" style="width:75%" /></td>
			</tr>
		<?php
            } ?>
		<tr>
		<td class="lab" valign="top" style="padding-top:8px;">Mapping:<br><span><?php echo $mcat_is_generic; ?></span></td>
		<td style="line-height:19px" >
		<input type="button" name="button1" value="Select Category" ONCLICK=" getScrollHeight(); win_open('grp')" style="font-size:14px;  font-weight:bold; font-family:arial; background:#0871c3; border:solid 1px #0a66ad; color:#fff; padding:3px 5px; cursor:pointer" id="cat-bt" class="displayon">
		<input type="button" name="button2" value="Change Category"  ONCLICK=" getScrollHeight(); win_open('grp')" CLASS="displayoff" style="font-size:14px;  font-weight:bold; font-family:arial; background:#0871c3; border:solid 1px #0a66ad; color:#fff; padding:3px 5px; cursor:pointer" id="chg-bt" width="158" height="22">
		<div class="lh20" ID="i1"><?php echo $disp ?></div>
                <span id="p1" ></span>
		<input type="hidden" name="glid" value="<?php echo $rec['FK_GLUSR_USR_ID']; ?>">
		<?php
        }
        if ($flagRecFound != 0) {
            if ($status != 'W' && $status != 'F' && $status != 'P' && $status != 'Q') {
                echo '<input type="hidden" name="approv" value="A">';
            }
            $mcatval = ($mcatval == '') ? isset($rec['FK_GLCAT_MCAT_ID']) ? $rec['FK_GLCAT_MCAT_ID'] : '' : $mcatval;
            $PcatId = ($PcatId == 0) ? isset($rec['FK_GLCAT_CAT_ID']) ? $rec['FK_GLCAT_CAT_ID'] : '' : $PcatId;
            $PmcatId = ($PmcatId == 0) ? isset($rec['FK_GLCAT_MCAT_ID']) ? $rec['FK_GLCAT_MCAT_ID'] : '' : $PmcatId;
?>
		 <input type="hidden" name="status" id="status" value="<?php echo CHtml::encode($status) ?>">
		 <input type="hidden" name="newStatus" id="newStatus" value="">
		<input type="hidden" name="s_city"  id="s_city"value="<?php echo CHtml::encode($postParamArr['S_city']); ?>">
		<input type="hidden" name="usr_city" id="usr_city" value="<?php echo CHtml::encode($postParamArr['usr_city']); ?>">
		<input type="hidden" name="usr_cityid" id="usr_cityid" value="<?php echo CHtml::encode($postParamArr['usr_cityId']); ?>">
		<input type="hidden" name="flag" id="flag" value="<?php echo CHtml::encode($postParamArr['flag']); ?>">
                <input type="hidden" name="offer" id="offer" value="<?php echo $offerID; ?>">
                <input type="hidden" name="cat" id="cat" value="<?php echo $PcatId; ?>">
                <input type="hidden" name="act" id="act" value="edit">
		<input type="hidden" name="mcat" id="mcat" value="<?php echo $mcatval; ?>">
		<input type="hidden" name="grp" id="grp" value="0">
		<input type="hidden" name="ofrtype" id="ofrtype" value="<?php echo $postParamArr['ofrtype']; ?>">
		<input type="hidden" name="usrstatus" id="usrstatus" value="<?php echo $postParamArr['userStatus']; ?>">
		<input type="hidden" name="oldcat" id="oldcat" value="<?php echo $PcatId; ?>">
		<input type="hidden" name="oldmcat" id="oldmcat" value="<?php echo $mcatval; ?>">
		<input type="hidden" name="oldmcatIdNameVal" id="oldmcatIdNameVal" value="<?php echo $mcatIdNameVal; ?>">
		<input type="hidden" name="oldPmcatId" id="oldPmcatId" value="<?php echo $PmcatId; ?>">
		<input type="hidden" id="mcatIdNameVal" name="mcatIdNameVal" value="<?php echo $mcatIdNameVal; ?>">
		<input type="hidden" name="PmcatId" id="PmcatId" value="<?php echo $PmcatId; ?>">
		<input type="hidden" name="mcatchanged" id="mcatchanged" value="">
		<input type="hidden" name="frmname" id="frmname" value="adminForm">
		<script type="text/javaScript">
		var FrmObj = document.adminForm;
		FrmObj.grp.value = 0;
		FrmObj.cat.value = FrmObj.oldcat.value;
		FrmObj.mcat.value = FrmObj.oldmcat.value;
		FrmObj.mcatIdNameVal.value = FrmObj.oldmcatIdNameVal.value;
		FrmObj.PmcatId.value = FrmObj.oldPmcatId.value;
		</script>
       		 <?php
            if (!empty($postParamArr['client'])) {
                echo '<input type="hidden" name="client" value="' . $postParamArr['client'] . '">';
            }
            if (!empty($postParamArr['ofrcnt'])) {
                echo '<input type="hidden" name="ofrcnt" value="' . $postParamArr['ofrcnt'] . '">';
            }
            if (!empty($postParamArr['user'])) {
                echo '<input type="hidden" name="user" value="' . $postParamArr['user'] . '">';
            }
            if (!empty($postParamArr['bl_wait_pool_id'])) {
                echo '<input type="hidden" name="bl_wait_pool_id" value="' . $postParamArr['bl_wait_pool_id'] . '">';
            }
            if ($status == 'W' || $status == 'F' || $status == 'P' || $status == 'Q') {
                echo '<input type="hidden" name="approv" value="W">';
            }
            echo '</td></tr>';
            if (isset($rec['ETO_OFR_PAGE_REFERRER'])) { ?>
		  <tr>
		  <td class="lab" style="padding-top:8px;">Page Referrer:</td>
		  <td align="left"><div style="text-align:left ! important;" title="<?php echo $rec['ETO_OFR_PAGE_REFERRER'] ?>" id="selectable" onclick="SelectText1()">
                   <?php if (preg_match('/http/', $rec['ETO_OFR_PAGE_REFERRER'])) {
                    echo '<p style="width:50em;word-wrap:break-word;"><a href="' . $rec['ETO_OFR_PAGE_REFERRER'] . '" style="text-decoration:none" target="_blank" >' . $rec['ETO_OFR_PAGE_REFERRER'] . '</a></p>';
                } else if (preg_match('/www/', $rec['ETO_OFR_PAGE_REFERRER']) or preg_match('/m\.indiamart\.com/', $rec['ETO_OFR_PAGE_REFERRER'])) {
                    echo '<p style="width:50em;word-wrap:break-word;"><a href="http://' . $rec['ETO_OFR_PAGE_REFERRER'] . '" style="text-decoration:none" target="_blank" >' . $rec['ETO_OFR_PAGE_REFERRER'] . '</a></p>';
                } else {
                    echo '<p style="width:50em;word-wrap:break-word;">' . $rec['ETO_OFR_PAGE_REFERRER'] . '</p>';
                }
?>
		  </div></td>
		  <br></tr>
		 <?php
            } ?>
	      <tr><td colspan="2" align="center">
      	        <?php if ($status == 'W' || $status == 'F' || $status == 'P' || $status == 'Q') { ?>
      	        <input type="hidden" name="flagval" id="flagval" value="0">&nbsp;&nbsp;
      	        <input type="hidden" name="bltype" id="bltype" value="<?php echo $blType; ?>">
      	        <input type="hidden" name="tabletype" id="tabletype" value="<?php echo $tableType; ?>">      	        	
		<?php
            }
            if ($lvl_code == 'E' || $lvl_code == 'V' || $approveby == - 11) {
                if ($status == 'A') {
                    echo '&nbsp;<INPUT TYPE="submit" NAME="pushtotop" VALUE="Push to Top"  style="font-size:14px;  font-weight:bold; font-family:arial; background:#63ac31; border:solid 1px #499218; color:#fff; padding:3px 0; width:130px; cursor:pointer">';
                    echo '&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<INPUT TYPE="submit" NAME="savecont" VALUE="Save & Continue" onClick="return check_res_keyword();" style="font-size:14px;  font-weight:bold; font-family:arial; background:#63ac31; border:solid 1px #499218; color:#fff; padding:3px 0; width:130px; cursor:pointer">';
                } elseif ($status == 'W' || $status == 'F' || $status == 'P' || $status == 'Q') {
                    if ($approvPermit == 'Y') {
                        echo '&nbsp;&nbsp;<input type="submit" onClick="return mulCategory_B();confirmCategory();" value="Approve" name="approvcont" style="font-size:14px;  font-weight:bold; font-family:arial; background:#63ac31; border:solid 1px #499218; color:#fff; padding:3px 0; width:130px; cursor:pointer">';
                    }
                }
            } ?>
<script language="javascript">
<!--
function SelectText(id) {
document.getElementById(id).select();
}
function checkOnBlur(element){
	$("#Reviewed").attr("checked",false);
}

function checkOwnerShip() {
	var regExpPvt = /Private(\.|\s)*?Limited(\.?)$|Pvt(\.|\s)*?Ltd(\.?)$|Private(\.|\s)*?Ltd(\.?)$|Pvt(\.|\s)*?Limited(\.?)$/ig;
	var regExpPub = /Ltd(\.?)$|Limited(\.?)$/ig;
	var str = $('#company').val();
	if(str.match(regExpPvt))
	{		
		$("#legal_status_id").val('2');
	}
	else if(str.match(regExpPub))
	{
		$("#legal_status_id").val('1');
	}
}
function ShowHideOtherQuantDiv(){
		var $value = $("#qty_list_val").val();
		if($value == "Others"){
			$("#ETO_OFR_QTY_UNIT_OTHER").show();
		} else {
			$("#ETO_OFR_QTY_UNIT_OTHER").hide();
		}
	}
function SelectText1() 
{
	if (document.selection) 
	{
		var range = document.body.createTextRange();
		range.moveToElementText(document.getElementById('selectable'));
		range.select();
	}
	else if (window.getSelection) 
	{
		var range = document.createRange();
		range.selectNode(document.getElementById('selectable'));
		window.getSelection().addRange(range);
	}
}
function confirmDeleteBL()
{
	if(document.adminForm.reason.value == '')
	{
		return confirm("Please select a reason to delete");
		return false;
	}
	else 
	{
		if(document.adminForm.reason.value == 15){
			$("#call_recording_url").show();		
		}
		var val = confirm("Are you sure you want to delete this offer? Responses to this offer (if any) will also be deleted.");
//		alert("--" + val + "--");
		if(val == true)
		{
			document.adminForm.delsilent.value=1;
			document.adminForm.submit();
			return true;
		}
		else
		{
			return false;
		}
	}
}

function confirmDeleteMailBL()
{
	if(document.adminForm.reason.value == '')
	{
		return confirm("Please select a reason to delete");
		return false;
	}
	else
	{
		document.adminForm.delform.value=1;
		document.adminForm.submit();
		return true;
	}
}
function checkURL(url) {
    var u=url;
    if (u.toString().indexOf("/http/") == -1) {
        alert("The Recording URL is incorrect. Please check with the concerned team.");
        return false;
    }
    else{
        return true;
    }
}
-->
</script>
<?php
            if ($lvl_code == 'E' || $lvl_code == 'V' || $approveby == - 11) {
                if ($status == 'A' || $status == 'W' || $status == 'F' || $status == 'P' || $status == 'Q') { ?>
				<INPUT TYPE="hidden" NAME="reason" ID="reason" VALUE="">
				<INPUT TYPE="hidden" NAME="reasondesc" ID="reasondesc" VALUE="">
				<?php
                    if ($status == 'W' || $status == 'F' || $status == 'P' || $status == 'Q') {
?>
					&nbsp;&nbsp;<input type="submit" onclick="return mulCategory();confirmCategory();" value="Delete Silent"  REL="subcontentsilent" ID="contentlinksilent" name="approvcont" style="font-size:14px;  font-weight:bold; font-family:arial; background:#d93531; border:solid 1px #a62724; color:#fff; padding:3px 0; width:130px; cursor:pointer"><input type="hidden" NAME="delsilent" value="0" />
					<div ID="subcontentsilent" STYLE="visibility:hidden; position:absolute; ">
					<iframe  src="/index.php?r=admin_eto/AdminEto/showoffersdelreason&action=showoffersdelreason&button=delsilent&mid=3424" border="0" bordercolor="0" frameborder="0" framespacing="0" scrolling="no" scrollbar="no" marginwidth="0" width="230px;" height="320px" marginheight="0" hspace="0">
					</iframe>	
					</div>
					&nbsp;&nbsp;<input type="submit" onclick="return  confirmDeleteMailBL();"  REL="subcontentmail" ID="contentlinkmail" value="Delete with Mail"  style="font-size:14px;  font-weight:bold; font-family:arial; background:#d93531; border:solid 1px #a62724; color:#fff; padding:3px 0; cursor:pointer; width:130px;">
					<input type="hidden" NAME="delform" value="0" />&nbsp;&nbsp;
					<input type="hidden" NAME="delmail" value="0" />&nbsp;&nbsp;
					<div id="subcontentmail" STYLE="visibility:hidden; position:absolute; ">
					<iframe  src="/index.php?r=admin_eto/AdminEto/showoffersdelreason&action=showoffersdelreason&button=delform&mid=3424" border="0" bordercolor="0" frameborder="0" framespacing="0" scrolling="no" scrollbar="no" marginwidth="0" width="230px;" height="320px" marginheight="0" hspace="0">
					</iframe>	
					</div>
				<?php
                    } else { ?>
					&nbsp;&nbsp;
					<input type="submit" onclick="return  confirmDeleteBL();" REL="subcontentsilentsec" ID="contentlinksilentsec"  VALUE="Delete Silent"  style="font-size:14px;  font-weight:bold; font-family:arial; background:#d93531; border:solid 1px #a62724; color:#fff; padding:3px 0; width:130px; cursor:pointer">
					<input type="hidden" NAME="delsilent" value="0" />&nbsp;&nbsp;
					<div id="subcontentsilentsec" STYLE="visibility: hidden; position:absolute; ">
					<IFRAME  src="/index.php?r=admin_eto/AdminEto/showoffersdelreason&action=showoffersdelreason&button=delsilent&mid=3424" BORDER="0" BORDERCOLOR="0" FRAMEBORDER="0" FRAMESPACING="0" scrolling="no" scrollbar="no" marginwidth="0" width="230px;" height="320px" marginheight="0" hspace="0">
					</IFRAME>	
					</div>
					<input type="submit" onclick="return  confirmDeleteMailBL();"  REL="subcontentmailsec" ID="contentlinkmail" value="Delete with Mail"  style="font-size:14px;  font-weight:bold; font-family:arial; background:#d93531; border:solid 1px #a62724; color:#fff; padding:3px 0; cursor:pointer; width:130px;">
					<input type="hidden" NAME="delform" value="0" />&nbsp;&nbsp;
					<input type="hidden" NAME="delmail" value="0" />&nbsp;&nbsp;
					<div id="subcontentmailsec" STYLE="visibility: hidden; position:absolute; ">
					<IFRAME  src="/index.php?r=admin_eto/AdminEto/showoffersdelreason&action=showoffersdelreason&button=delform&mid=3424" BORDER="0" BORDERCOLOR="0" FRAMEBORDER="0" FRAMESPACING="0" scrolling="no" scrollbar="no" marginwidth="0" width="230px;" height="320px" marginheight="0" hspace="0">
					</IFRAME>	
					</div>
					<?php
                    }
                }
            } ?>
		</td></tr></table></td>
		<SCRIPT TYPE="text/javascript">
			//Call dropdowncontent.init("anchorID", "positionString", glideduration, "revealBehavior") at the end of the page:
			
			dropdowncontent.init("searchlink", "right-bottom", 500, "click")
			dropdowncontent.init("contentlink", "right-top", 300, "mouseover")
			dropdowncontent.init("contentlinksilent", "right-top", 300, "mouseover")
			dropdowncontent.init("contentlinkmail", "right-top", 300, "mouseover")
			dropdowncontent.init("contentlinksilentsec", "right-top", 300, "mouseover")
			dropdowncontent.init("contentlinkmailsec", "right-top", 300, "mouseover")
			dropdowncontent.init("contentlinkflag", "right-top", 300, "mouseover")
			</SCRIPT>
			<td valign="top" width="320">
			<table width="100%" cellpadding="2" cellspacing="0" class="impPara" border="1" style="border-collapse:collapse;border:1px solid #FFF;background:#eeeeee">
			<tr>
			  <td width="92" class="pd5">Posted On:</td>
			  <?php $postDataOrig = isset($rec['POST_DATE_ORIG']) ? $rec['POST_DATE_ORIG'] : ''; ?>
			  <td> <span style="color:#000090"><?php echo $postDataOrig ?></span></td>
			</tr>
                       
			<tr>
			  <td class="pd5">Posted By:</td>
			  <td><span style="color:#000090">
			  <?php if (isset($rec['POSTEDBYEMPLOYEE_NAME'])) {
                echo $rec['POSTEDBYEMPLOYEE_NAME'];
            } else {
                echo $rec['FK_GLUSR_USR_ID'];
            }
            echo "</span></td></tr>";
?>
                       <tr>
			  <td  class="pd5" >Deleted On :</td>
			  <?php $expiredDate = '';
            $deletedon = '';
            if ($status == "T" or $status == "D") {
                $deletedon = isset($rec['EXPIRED_ON_DATE']) ? $rec['EXPIRED_ON_DATE'] : '';
            } else {
                $expiredDate = isset($rec['EXPIRED_ON_DATE']) ? $rec['EXPIRED_ON_DATE'] : '';
            }
?>
			  <td> <span style="color:#000090"><?php echo $deletedon ?></span> </td>
			</tr>
                        <?php echo '<tr><td class="pd5">Deleted By:</td><td><span style="color:#000090">';
            if ($status == "T" or $status == "D") {
                if(isset($rec['GL_EMP_ID'])) {
                    echo $rec['GL_EMP_ID'];
                } else {
                    if ($ETO_LEAP_VENDOR_NAME == 'Auto Delete') {
                        echo 'Auto Delete';
                    }
                }
            }
            echo '</span></td></tr>';
            echo '<tr><td class="pd5">Del Reason:</td><td><span style="color:#000090">';
            if (isset($rec['CALL_DEL_REASON']) && $rec['CALL_DEL_REASON'] <> '-') {
                if($rec['CALL_DEL_REASON'] =='(24)'){
                   echo "Not Ready To Confirm".$rec['CALL_DEL_REASON'];
                }else{
                echo $rec['CALL_DEL_REASON'];
                }
            }
            echo '</span></td></tr>';
            echo '<tr><td width="92" class="pd5">Approved On:</td>';
            $postDataOrig = isset($rec['APPROV_DATE']) ? $rec['APPROV_DATE'] : '';
            echo '<td> <span style="color:#000090">' . $postDataOrig . '</span></td></tr>';
            
            if (($status == 'A' || $status == 'E') && isset($rec['GL_EMP_ID'])) {
                echo '<tr><td class="pd5">Approved By:</td><td><span style="color:#000090">';
                echo  $rec['GL_EMP_ID'];
                echo '</span></td></tr>';
                if(isset($bandetail['gl_profile_updated_by_id'])){
                    echo '<tr><td width="92" class="pd5">Reviewed In BAN Pool By</td>';
                    echo '<td> <span style="color:#000090">' . @$bandetail['gl_profile_audit_by'] . '</span></td></tr>';
                }                
            }else{               
                if(isset($bandetail['gl_profile_updated_by_id'])){
                    echo '<tr><td width="92" class="pd5">Approved By</td>';
                    echo '<td> <span style="color:#000090">' . $bandetail['gl_profile_updated_by_id'] . '</span></td></tr>';
                    echo '<tr><td width="92" class="pd5">Reviewed In BAN Pool By</td>';
                    echo '<td> <span style="color:#000090">' . @$bandetail['gl_profile_audit_by'] . '</span></td></tr>';
                }else{
                    echo '<tr><td class="pd5">Approved By:</td><td></td></tr>';
                }
            }
            
?>
                        <tr>
			  <td  class="pd5" >Expired On:</td>			  
			  <td> <span style="color:#000090"><?php echo $expiredDate ?></span> </td>
			</tr>
			 <tr>
			  <td  class="pd5" >Expiry Date:</td>
			  <?php $expiryDate = isset($rec['EXP_DATE']) ? $rec['EXP_DATE'] : ''; ?>
			  <td> <span style="color:#000090"><?php echo $expiryDate ?></span> </td>
			</tr>
			<tr>
			  <td class="pd5">Last Update:</td>
			  <td> <span style="color:#000090"><?php echo $rec['OFFER_DATE'] ?></span> </td>
			</tr>
                 <?php
            $glid = $rec['FK_GLUSR_USR_ID'];
            echo '<tr><td class="pd5">Partner:</td><td><span style="color:#000090">';
            if (isset($ETO_LEAP_VENDOR_NAME) and $ETO_LEAP_VENDOR_NAME != 'Auto Delete') {
                echo $ETO_LEAP_VENDOR_NAME;
            }
            $ASSOCIATE_VINTAGE = $LEADER_NAME = '';
            if (isset($rec['ASSOCIATE_VINTAGE'])) {
                $ASSOCIATE_VINTAGE = $rec['ASSOCIATE_VINTAGE'];
            }
            $LEADER_NAME = isset($rec['LEADER_NAME']) ? $rec['LEADER_NAME'] : '';
            $lat = isset($rec['ETO_OFR_LATITUDE']) ? $rec['ETO_OFR_LATITUDE'] : '';
            $long = isset($rec['ETO_OFR_LONGITUDE']) ? $rec['ETO_OFR_LONGITUDE'] : '';
            if ($long <> '') {
                $lat = $lat . ', ' . $long;
            }
            echo '</span></td></tr>';
            echo '<tr><td class="pd5">Associate Status:</td><td><span style="color:#000090">' . $associate_status . '</span></td></tr>';
            echo '<tr><td class="pd5">Associate Vintage(Days):</td><td><span style="color:#000090">' . $ASSOCIATE_VINTAGE . '</span></td></tr>';
            echo '<tr><td class="pd5">Team Leader:</td><td><span style="color:#000090">' . $LEADER_NAME . '</span></td></tr>			
		<tr>
		<td class="pd5">
		Lat Long:
		</td>
		<td ><span style="color:#000090">' . $lat . '</span>
		</td>
		</tr>';
            echo '</table>';
?>		<link href="//utils.imimg.com/suggest/css/jquery-ui.css" type="text/css" rel="stylesheet" />
        <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js" ></script>
		<script language="javascript" type="text/javascript" src="<?php echo CommonVariable::get_autosuggest_js(); ?>"></script>
		<STYLE TYPE="text/css"> .ui-menu,.ui-menu-item a{color:#000000;} </style><link rel="stylesheet" href="/gl-include/AutoComplete.css"  type="text/css">
	    <script language="javascript" type="text/javascript" src="/gl-include/autocomplete_more.js"></script>	
	    <script type="text/javascript" src="/protected/modules/admin_eto/js/glusr-update-by-eto-buylead.js?v=6"></script> 
		<?php
            echo '</td></tr></table>';
?>
<table style="border-collapse:collapse;" width="100%" cellspacing="0" cellpadding="3" bordercolor="#ebebeb" border="1">
                     
        <td width="50%">
            	<div style="line-height:24px;padding-left:10px;padding-top:5px;font-size:12px;">
            <b style="color:#000090"><span style="color:#000090">&#187;</span>History</b>
	    <b> &nbsp;&nbsp; <a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=ofrHist&offer=<?php echo $offerID; ?>&mid=3424" target="_blank">Offer</a></b>         
               <?php
            $PostBy = isset($rec['POSTEDBYEMPLOYEE_NAME']) ? $rec['POSTEDBYEMPLOYEE_NAME'] : '';
            if ($Source == 'FENQ') {
                echo '&nbsp;|| <b>&nbsp;<a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=fenqHist&offer=' . $offerID . '&mid=3424" target="_blank">FENQ</a></b>';
            }
            echo '&nbsp;|| 
		<b>&nbsp;<a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=mapHist&offer=' . $offerID . '&status=' . $status . '&mid=3424" target="_blank">Mapping</a></b>&nbsp;||
		<b><a href="/index.php?r=admin_glusr/GlusrHistory/GlusrHistory&id=' . $rec['FK_GLUSR_USR_ID'] . '&mid=46" target="_blank">GLUser </a></b>
		&nbsp;||
		<b><a href="/index.php?r=admin_eto/OfrHist/etohistory&act=locking&ad=' . $postDataOrig . '&dd=' . $deletedon . '&pd=' . $rec['POST_DATE_ORIG'] . '&offer=' . $offerID . '&postby=' . $PostBy . '&mid=3424"." target="_blank">Locking </a></b>
		&nbsp;||
		<b><a href="/index.php?r=admin_eto/OfrHist/etohistory&act=Isq_hist&offer=' . $offerID . '&mid=3424" target="_blank">ISQ</a></b>';
if($status_check == 'A' || $status_check == 'E')
{
		echo '&nbsp;||<b><a href="/index.php?r=admin_eto/OfrHist/etohistory&act=autoHist&offer=' . $offerID . '&mid=3424" target="_blank">Auto Approval</a></b>
		&nbsp;||
		<b><a href="/index.php?r=admin_bl/Transaction_report/Index&mid=3442&offer=' . $offerID . '&action=purchasers&Submit1=Generate Report" target="_blank">Transaction</a></b>';
}               
            echo '<br /><b style="color:#000090"><span style="color:#0000ff">&#187;</span> Is Verified</b>';
            echo '<INPUT TYPE="checkbox" NAME="verify" id="verify" VALUE="1" ';
            if (isset($rec['ETO_OFR_VERIFIED']) && ($rec['ETO_OFR_VERIFIED'] == 1 || $rec['ETO_OFR_VERIFIED'] == 2)) {
                echo 'checked="checked"  onclick="return false;" ';
            }
            print '/>';
            echo 'Do not check this box.
		<input type="hidden" name="verify_hid" id="verify_hid" value="';
            if (isset($postParamArr['verify_hid'])) {
                echo $postParamArr['verify_hid'];
            } else {
                if (isset($rec['ETO_OFR_VERIFIED']) && ($rec['ETO_OFR_VERIFIED'] == 1 || $rec['ETO_OFR_VERIFIED'] == 2)) {
                    echo '1';
                } else {
                    echo '0';
                }
            }
            echo '">';
            $modid = $result['origModid'];
            $appDate = '';
            if ($postDataOrig <> '') {
                $appDate = substr($postDataOrig, 0, 11);
            }
            echo '<br /><b><span style="color:#000090">&#187;</span>';
            echo '&nbsp;<a href="/index.php?r=admin_eto/EnrichmentDetail/viewenrichment&offer=' . $offerID . '&modid=' . $modid . '&tabletype=' . $tableType . '&mid=3424" target="_blank">Enrichment Details</a>&nbsp;||';
            echo '&nbsp; <a href="/index.php?r=admin_eto/AdminEto/feedback&offer=' . $offerID . '" target="_blank">Feedback Detail</a><br />';
            if (isset($rec['CALL_RECORDING_URL'])) {
                $prim1 = $rec['CALL_RECORDING_URL'];
                echo '<a href="' . $prim1 . '" TARGET="_blank" onclick="return checkURL("'.$prim1.'")">&#187;&nbsp;Play Recording</A>';
            } else {
                echo '&#187;&nbsp;Recording Not Available';
            }
            echo '<br />&#187;&nbsp;<a href="index.php?r=admin_eto/AdminEto/multipleattachment&offer=' . $offerID . '" target="_blank">View Attachment</A>';
            echo '&nbsp;||&nbsp;<a href="index.php?r=admin_eto/OfferDetail/multiplecallrecord&offer=' . $offerID . '&glid=' . $glid . '&dt=' . $appDate . '&mid=3424" target="_blank">View All Recordings</A>';
?>  
                </div>
        </td>
               <td width="50%"> 
               <table border="0" align="center" cellpadding="2" cellspacing="0"  width="100%" >
	    <tr>
		<td style="padding:5px 5px 5px 8px;color:#000090;font-size:12px;font-weight:bold;">
		<span id="spragscale" name="spragscale">&nbsp;5 scale RAG&nbsp;<input type="button" name="ragscale" id="ragscale" value="Show" 
                    onclick="showragscale(<?php echo $offerID ?>);">
                </span></td>
                </tr>
          <tr>
		<td style="padding:5px 5px 5px 8px">
		<b style="color:#000090;font-size:12px;">&nbsp;Unrealistic Usage&nbsp; </b><input type="button" name="usage" id="usage" value="Show" onclick="showusage(<?php echo $offerID ?>);"><span id="usagestatus" name="usagestatus" style="text-align:center;color:green" bgcolor="#dff8ff" width="12%"></span>
		</td>
                </tr>
                <tr>
		<td style="padding:5px 5px 5px 8px">
		<b style="color:#000090;font-size:12px;">&nbsp;TOV removed By LEAP identifier&nbsp; </b><input type="button" name="tov" id="tov" value="Show" onclick="showtov(<?php echo $offerID ?>);"><span id="tovstatus" name="tovstatus" style="text-align:center;color:green" bgcolor="#dff8ff" width="12%"></span>
		</td>
                </tr>
                <tr>
		<td style="padding:5px 5px 5px 8px">
		<b style="color:#000090;font-size:12px;">&nbsp;Unrealistic Quantity&nbsp; </b><input type="button" name="quantity" id="quantity" value="Show" onclick="showquantity(<?php echo $offerID ?>);"><span id="quantitystatus" name="quantitystatus" style="text-align:center;color:green" bgcolor="#dff8ff" width="12%"></span>
		</td>
                </tr>
                 <tr>
		<td style="padding:5px 5px 5px 8px">
		<b style="color:#000090;font-size:12px;">&nbsp;User Stats&nbsp; </b><input type="button" name="showuserstat" id="showuserstat" value="Show" onclick="showuserstats(<?php echo $offerID . ',' . $rec['FK_GLUSR_USR_ID']; ?>);">&nbsp;&nbsp;
		<b style="color:#000090;font-size:12px;">&nbsp;RAG Input Parameters &nbsp; </b><input type="button" name="showrag" id="showrag" value="Show" onclick="showragstats(<?php echo $offerID ?>);"></td>
		</tr>
                <tr><td id='userstat' style="font-size:14px;padding:2px 2px 2px 2px; line-height:20px;letter-spacing:-0.02em; color:#c90000;font-weight:bold">
                            
</td>		
	    </tr>

	</table></td></tr></table>
           

            <?php
        }
        if ($flagRecFound != 0) {
            $count = 0;
            $td = '';
            $count1 = 0;
            $counter = 0;
            echo '<div id="lastcallmade" name="lastcallmade" style="line-height:30px;color:green;">
		</div>';
            echo '<div style="overflow:hidden;height:10px"></div>';
            /* Disabled User Part */
?>
		<table border="1" cellpadding="3" cellspacing="0" bordercolor="#ebebeb" style="border-collapse:collapse;" width="100%">
		<tr><td width="128" align="left" bgcolor="#c6def1"><div class="clint ffl" style="padding-left:2px">
		<?php if ($result['show_client1']) {
                echo $result['show_client1'];
            }
            echo '</div></td>
		<td width="340" bgcolor="#c6def1" style="font-size:15px"><b>Current Gluser Details ';
            echo '<span style="color:#c90000;font-size:11px">';
            echo isset($userDet['GLUSR_USR_APPROV']) ? '<b>' . $userStatusDesc[$userDet['GLUSR_USR_APPROV']] . '</b>' : ''; ?>
		</span>
		</b> </td>
                          <td bgcolor="#c6def1"><strong class="hd" style="color:#000; font-size:14px">New Contact Details</strong> &nbsp; <span id="fcpdetail"><input type="button" name="showfcp" id="showfcp" value="Show FCP Applicable" onclick="showfcpdetail(<?php echo $offerID; ?>);"></span> &nbsp;
                     &nbsp;&nbsp;&nbsp;<a href="/index.php?r=admin_eto/OfferDetail/showproduct&glid=<?php echo $rec['FK_GLUSR_USR_ID']; ?>&mid=3424" TARGET="_blank">View Products I Sell</a>
                </td>
		</tr>
		</table>
		</form>
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
		<?php $senderName = isset($rec['ETO_OFR_S_SENDERNAME']) ? $rec['ETO_OFR_S_SENDERNAME'] : ''; ?>
		<td width="482"  valign="top"><input type="hidden" name="sender_name" id="sender_name" value="<?php echo $senderName ?>" >
		<!--//User Detail Start-->
		<FORM NAME="userForm" METHOD="post" ACTION="/index.php?r=admin_eto/AdminEto/saveglusrdetails&action=saveglusrdetails" ONSUBMIT="return chckUpdt(document.userForm);"  STYLE="margin-top:0;margin-bottom:0;">
	    <table border="0" class="gluser_info" cellpadding="0" cellspacing="0" style="border-top:0px" width="100%">
 	    <tr>
		<td width="130" CLASS="admintext"><strong>Name&nbsp;<FONT COLOR="red">*</FONT></strong></TD>
		<TD CLASS="admintext1" >
		<?php
            $email = isset($userDet['GLUSR_USR_EMAIL']) ? trim($userDet['GLUSR_USR_EMAIL']) : '';
            $email = preg_replace('/\s/', "", $email);
            $firstname = isset($userDet['GLUSR_USR_FIRSTNAME']) ? $userDet['GLUSR_USR_FIRSTNAME'] : '';
            //$firstname =~ s/"/&#34;/g;
            $lastname = isset($userDet['GLUSR_USR_LASTNAME']) ? $userDet['GLUSR_USR_LASTNAME'] : '';
            //$lastname =~ s/"/&#34;/g;
            $companyname = isset($userDet['GLUSR_USR_COMPANYNAME']) ? $userDet['GLUSR_USR_COMPANYNAME'] : '';
            //$companyname =~ s/"/&#34;/g;
            $altEmail = isset($userDet['GLUSR_USR_EMAIL_ALT']) ? $userDet['GLUSR_USR_EMAIL_ALT'] : '';
            $desin = isset($userDet['GLUSR_USR_DESIGNATION']) ? $userDet['GLUSR_USR_DESIGNATION'] : '';
            $countryIso = isset($userDet['FK_GL_COUNTRY_ISO']) ? $userDet['FK_GL_COUNTRY_ISO'] : '';
            $city = isset($userDet['GLUSR_USR_CITY']) ? $userDet['GLUSR_USR_CITY'] : '';
            $cityID = isset($userDet['FK_GL_CITY_ID']) ? $userDet['FK_GL_CITY_ID'] : '';
            $state = isset($userDet['GLUSR_USR_STATE']) ? $userDet['GLUSR_USR_STATE'] : '';
            $stateID = isset($userDet['FK_GL_STATE_ID']) ? $userDet['FK_GL_STATE_ID'] : '';
            $stateOther = isset($userDet['GLUSR_USR_STATE_OTHERS']) ? $userDet['GLUSR_USR_STATE_OTHERS'] : '';
            $countryName = isset($userDet['GLUSR_USR_COUNTRYNAME']) ? $userDet['GLUSR_USR_COUNTRYNAME'] : ''; ?>
	      	<input type="Hidden" name="chnge_txt" id="chnge_txt" value="">
		
		<input name="txtfname" type="text" id="txtfname" maxlength="100" style="width: 125px;" value="<?php echo $firstname; ?>" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" CLASS="admintext-h" onblur="checkOnBlur(this);">
		<input id="txtlname" name="txtlname" type="text" maxlength="100"  style="width: 116px;" value ="<?php echo $lastname; ?>" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" CLASS="admintext-h" onblur="checkOnBlur(this);"> 
       
		<input id="email_sugg" name="email_sugg" type="hidden"  value ="<?php echo $result['correct_domain']; ?>" >
		<input id="domain_name" name="domain_name" type="hidden"  value ="<?php echo $result['domain_val']; ?>" >
		</TD> <td>		
		</td>
	    </TR>
	    <TR>
		<TD CLASS="admintext" style="height:45px">
		<strong>Email</strong>&nbsp;&nbsp;<span id="emailval1" name="emailval1"></span>
		</TD>
		<TD>
		    <input name="email" id="email"  type="text"  style="width: 300px;" CLASS="admintext-h" readonly value="<?php echo $email; ?>" >
		</TD>
		<td>
		<!--<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'109'} eq 'Y');-->
		</td>
	    </TR>
	    <TR>
		<TD CLASS="admintext" style="height:45px"><strong>Alt Email</strong>&nbsp;&nbsp;<span id="emailval2" name="emailval2">
		</span>
		</TD>
		<TD>
		<input name="alt_email" id="alt_email"  type="text"  readonly style="width: 300px;" CLASS="admintext-h"  onblur="check_value('altemail','emailval2');"  value="<?php echo $altEmail; ?>" onblur="checkOnBlur(this);">
		</TD>
		<td>
		</td>
	    </TR>
	    <TR>
		<TD CLASS="admintext"><strong>Designation</strong></TD>
		<TD> 
		<input name="desi" type="text" CLASS="admintext-h" value="<?php echo $desin; ?>"  style="width: 300px;" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" onblur="checkOnBlur(this);">
		</TD>
		<td>		
		</td>
	    </TR>
	    <TR>
		<TD CLASS="admintext"><strong>Company Name</strong></TD>
		<TD>
		<input name="company" id="company" CLASS="admintext-h" type="text" value="<?php echo $companyname; ?>" style="width: 300px;" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" onblur="checkOwnerShip();checkOnBlur(this);" >
		</TD>
		<td>		
		</td>
	    </TR>
	    <TR><TD CLASS="admintext"><strong>Ownership Type</strong></TD><TD>
	    <SELECT  NAME="legal_status_id" id="legal_status_id" onchange="changetext();checkOnBlur(this);">
	   <OPTION VALUE="">---Choose One---</OPTION>
	   <?php
            $legalStatusRow = CommonVariable::GetOwnerShip_values();
            foreach ($legalStatusRow as $key => $value) {
                if (isset($userDet['FK_GL_LEGAL_STATUS_ID']) && $userDet['FK_GL_LEGAL_STATUS_ID'] == $key) {
                    echo '<OPTION VALUE="' . $key . '" selected>' . $value . '</OPTION>';
                } else {
                    echo '<OPTION VALUE="' . $key . '">' . $value . '</OPTION>';
                }
            } ?>
	    </SELECT>
	    </TD>
	    <td>
	    </td>
	</TR>
	
	<TR>
		<TD CLASS="admintext"><strong>Country&nbsp;<FONT COLOR="red">*</FONT></strong></strong></TD>
		<TD >
			<Input type="Hidden" name="country_iso" value="<?php echo $countryIso; ?>" id="country_iso"> 
			<Input type="Hidden" name="country" value="<?php echo $countryIso; ?>" id="country_id">
			<span id="xyz"><INPUT NAME="country_name" id="country_name" SIZE="33" VALUE="<?php echo $countryName; ?>" TYPE="text" autocomplete="off"  style="width: 300px;" class="country_name" maxlength="40"  onchange="changetext();checkOnBlur(this);">
			</span>
		</TD>
		<td>
		</td>
	</TR>
	<TR>
		<TD CLASS="admintext"><strong>Senders IP (Country)</strong></TD>
		<TD style="font-size:12px;" > NA </TD>
		<td></td>
	</TR>
	<TR>
		<TD CLASS="admintext"><strong>City</strong></TD>
		<TD>
			<input name="city_others"  id="city_others" type="text" value="<?php echo $city; ?>"  onblur="('city_others',this.value);"  onchange="changetext();checkOnBlur(this);"  style="width: 125px;"> 
			<input type="hidden" name="city" id="city" value="<?php echo $cityID; ?>"  CLASS="admintext-h">
		 	<strong style="font-size:12px;">State&nbsp&nbsp</strong>
			<input name="state_others" id="state_others" type="text" value="<?php echo $state; ?>" onkeyup="sendRequest(this.value);"  onchange="changetext();" style="width: 128px;" >
			<input type="hidden" name="state" id="state" value="<?php echo $stateID; ?>" CLASS="admintext-h"> 
		<?php
            $val = "";
            if (!empty($stateID) || !empty($stateOther)) {
                if (!empty($stateID)) {
                    $val = $stateID;
                } else {
                    $val = $stateOther;
                }
            }
            $glusr_add1 = isset($userDet['GLUSR_USR_ADD1']) ? $userDet['GLUSR_USR_ADD1'] : '';
            $glusr_add2 = isset($userDet['GLUSR_USR_ADD2']) ? $userDet['GLUSR_USR_ADD2'] : '';
            $zip = isset($userDet['GLUSR_USR_ZIP']) ? $userDet['GLUSR_USR_ZIP'] : '';
            $ph_country = isset($userDet['GLUSR_USR_PH_COUNTRY']) ? $userDet['GLUSR_USR_PH_COUNTRY'] : '';
            $phArea = isset($userDet['GLUSR_USR_PH_AREA']) ? $userDet['GLUSR_USR_PH_AREA'] : '';
            $phNumber = isset($userDet['GLUSR_USR_PH_NUMBER']) ? $userDet['GLUSR_USR_PH_NUMBER'] : '';
            $ph_country2 = '';
            $phArea2 = isset($userDet['GLUSR_USR_PH2_AREA']) ? $userDet['GLUSR_USR_PH2_AREA'] : '';
            $phNumber2 = isset($userDet['GLUSR_USR_PH2_NUMBER']) ? $userDet['GLUSR_USR_PH2_NUMBER'] : '';
            $fax_country = isset($userDet['GLUSR_USR_FAX_COUNTRY']) ? $userDet['GLUSR_USR_FAX_COUNTRY'] : '';
            $faxArea = isset($userDet['GLUSR_USR_FAX_AREA']) ? $userDet['GLUSR_USR_FAX_AREA'] : '';
            $faxNumber = isset($userDet['GLUSR_USR_FAX_NUMBER']) ? $userDet['GLUSR_USR_FAX_NUMBER'] : '';
            $mobile = isset($userDet['GLUSR_USR_PH_MOBILE']) ? $userDet['GLUSR_USR_PH_MOBILE'] : '';
            $mobileAlt = isset($userDet['GLUSR_USR_PH_MOBILE_ALT']) ? $userDet['GLUSR_USR_PH_MOBILE_ALT'] : '';
            //$glusr_add1 =~ s/"/&#34/g;
            //$glusr_add2 =~ s/"/&#34/g;
            
?>
		
			<input type="Hidden" name="usr_state_id" value="<?php echo $val; ?>"></TD>
			<td>
			<!--<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'114'} eq 'Y' && $verifyInfohash->{'115'} eq 'Y');-->
		</td>
		</TR>
		<TR>
			<TD CLASS="admintext" ><strong>Pin Code</strong></TD>
			<TD><input name="Pin" type="text" id="Pin"  CLASS="admintext-h" value="<?php echo $zip; ?>" onchange="changetext();" style="width: 125px;" onblur="checkOnBlur(this);"></TD>
			<td>
			<!--<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'117'} eq 'Y');-->
		</td>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Address1</strong></TD>
			<TD><input name="Address1" id="Address1" type="text" CLASS="admintext-h" value="<?php echo $glusr_add1; ?>" style="width: 300px;" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" onblur="checkOnBlur(this);"></TD>
			<td>
			<!--print qq~<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'112'} eq 'Y');-->
			</td>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Address2</strong></TD>
			<TD><input name="Address2" type="text" CLASS="admintext-h" value="<?php echo $glusr_add2; ?>" style="width: 300px;"  ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" onblur="checkOnBlur(this);"></TD>
			<td>
			</td>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Phone1&nbsp;<FONT COLOR="red">*</FONT></strong></TD>
			<TD>
				<input name="ph_country" id="ph_country" type="text" size="6" CLASS="admintext-h" style="width: 40px;"  readonly value="<?php echo $ph_country; ?>">
				<input name="ph_area" id="ph_area" type="text" maxlength="6" size="10" CLASS="admintext-h" style="width: 50px;" value="<?php echo $phArea; ?>"  onchange="changetext();" onblur="checkOnBlur(this);">
				<input name="Ph_phone" id="Ph_phone" type="text" size="10" CLASS="admintext-h" style="width: 120px;" value="<?php echo $phNumber; ?>"  onchange="changetext();" onblur="checkOnBlur(this);">
			</TD>
			<td>
			</td>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Phone2 &nbsp;<FONT COLOR="red">*</FONT></strong></strong></TD>
			<TD>
			<input name="ph_country2" id="ph_country2" type="text" size="6" CLASS="admintext-h" style="width: 40px;" readonly value="<?php echo $ph_country2; ?>">
			<input name="ph_area2"  id= "ph_area2" type="text" maxlength="6" size="10" CLASS="admintext-h" style="width: 50px;" value="<?php echo $phArea2; ?>"  onchange="changetext();" onblur="checkOnBlur(this);">
			<input name="Ph_phone1" id="Ph_phone1" type="text" size="10" CLASS="admintext-h" style="width: 120px;" value="<?php echo $phNumber2; ?>"  onchange="changetext();" onblur="checkOnBlur(this);">
			</TD>
			<td>
		<!--<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'118'} eq 'Y' && $verifyInfohash->{'119'} eq 'Y' && $verifyInfohash->{'156'} eq 'Y');-->
			</td>	
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Mobile1&nbsp;<FONT COLOR="red">*</FONT></strong></strong></TD>
			<TD>
				<input name="mob_country" id="mob_country" type="text" size="6"  style="width: 40px;"  value="<?php echo $ph_country; ?>" CLASS="admintext-h" readonly >
				<input readonly name="mobile1" id="mobile1" style="width: 85px;" type="text" value="<?php echo $mobile; ?>" size"20" CLASS="admintext-h"  onchange="changetext();" onblur="checkOnBlur(this);">
		<strong class="admintext">&nbsp;&nbsp;Mobile2&nbsp;&nbsp;&nbsp;</strong>
<?php
            $dispurl = isset($rec['GLUSR_USR_URL']) ? $rec['GLUSR_USR_URL'] : '';
?>
		<input type="text" readonly name="mobile2" id="mobile2"  style="width: 85px;" value="<?php echo $mobileAlt; ?>" size="20" CLASS="admintext-h"  onchange="changetext();" onblur="checkOnBlur(this);"></td><td>
		</TD>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Website</strong></TD>
			<TD >
				<input name="url" id="url" size = "60" type="text" onkeyup="q_http_val(this.value);" onkeypress="q_http_val(this.value);" onfocus="showimage(document.postForm,this.name,'hide');q_http_val(this.value);" onblur="showimage(document.postForm,this.name,'show');checkOnBlur(this);" style="width: 300px;" value="<?php echo $dispurl; ?>" size="35" CLASS="admintext-h"  onchange="changetext();" >
			</TD>
			<td>
			</td>
		</TR>
                
                
                
                
		<TR><td><input type="hidden" name="Empid" value="<?php echo $emp_id; ?>">
		<input type="hidden" name="glusr_id" value="<?php echo $rec['FK_GLUSR_USR_ID']; ?>" id="glusr_id">
		<input type="hidden" name="ofrtype" value="B"></td>
		<TD CLASS="admintext" valign="middle" align="center">
		<?php
            $submit_button = '';
            $Reviewed_button = '';
            $submit_button = '<input type="hidden" name="action" id="action" value="UPDATE">
		<input type="SUBMIT" NAME="action1" style="font-size: 14px; font-weight: bold; font-family: arial; background: none repeat scroll 0% 0% rgb(8, 113, 195); border: 1px solid rgb(10, 102, 173); color: rgb(255, 255, 255); padding: 3px 5px; cursor: pointer;" onclick="chng_textval();" value="Update GL User Details" id="action1">';
            $Reviewed_button = '&nbsp;<span id="chdupmob" name="chdupmob" style="display: none">
		<img src="//gladmin.intermesh.net/template_admin/spinner.gif"></span><span id="chdupmob1" name="chdupmob" style="display: none">
		</span><input name="dupmobcount" id="dupmobcount" type="hidden"  value="0"> &nbsp; <INPUT NAME="Reviewed" id="Reviewed" TYPE="CHECKBOX" onclick="updateval()" value="0"> <b>Reviewed</b>';
            if (!empty($postParamArr['flag']) && empty($result['is_client1'])) {
                echo $submit_button;
            } else if (($lvl_code == 'E' || $lvl_code == 'V' || $approvPermit == 'Y') && empty($result['is_client1'])) {
                echo $submit_button;
            } else {
                echo '<input type="hidden" name="action" id="action" value="UPDATE">
		<input type="hidden" NAME="action1" value="" id="action1">';
            }
            echo $Reviewed_button;
            echo '<input type="hidden" name="flag" id="flag" value="' . $postParamArr["flag"] . '">';
            echo ' 
		</TD>
	    </TR>
	    </TABLE>';
            echo '</form>'; ?>
		</td>
		<td valign="top">
		<table border="0" class="gluser_info" cellpadding="0" cellspacing="0" style="border-top:0px;font-size:12px" width="100%">
		<tr><td width="30%" class="lfb">&nbsp;<?php echo $senderName; ?></td><td>&nbsp;</td>
		</tr>
		<tr>
  		 <td class="lfb" style="height:45px;" >&nbsp;NA </td><td>
<?php
            if ($postParamArr['status'] == 'W') {
                if (!empty($err2)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err2 . '</span>';
                } else if (!empty($err22)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err22 . '</span>';
                } else if (!empty($err21)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err21 . '</span>';
                } else if (!empty($err24)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err24 . '</span>';
                } else if (!empty($err25)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err25 . '</span>';
                }
            }
            $designation = isset($rec['ETO_OFR_S_DESIGNATION']) ? $rec['ETO_OFR_S_DESIGNATION'] : '';
            $organization = isset($rec['ETO_OFR_S_ORGANIZATION']) ? $rec['ETO_OFR_S_ORGANIZATION'] : '';
            echo '</TD></TR>
		<TR><td class="lfb" style="height:45px;" >&nbsp;NA</TD><TD>&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;' . $designation . '</TD><TD>&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;' . $organization . '</TD><TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err9)) {
                    echo '&nbsp;<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;">
			  <span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err9 . '</span>';
                }
            }
            $sCountry = isset($rec['ETO_OFR_S_COUNTRY']) ? $rec['ETO_OFR_S_COUNTRY'] : '';
            $sIp = isset($rec['ETO_OFR_S_IP']) ? $rec['ETO_OFR_S_IP'] : '';
            echo '&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;</TD><TD>&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;' . $sCountry . '</TD><TD>&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;' . $sIp;
            if (isset($rec['ETO_OFR_S_IP_COUNTRY'])) {
                echo ' ( ' . $rec['ETO_OFR_S_IP_COUNTRY'] . ' ) ';
            }
            echo '

		</TD><TD class="lfb" >';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err1)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err1 . '</span>';
                }
            }
            $sState = isset($rec['ETO_OFR_S_STATE']) ? $rec['ETO_OFR_S_STATE'] : '';
            $sCity = isset($rec['ETO_OFR_S_CITY']) ? $rec['ETO_OFR_S_CITY'] : '';
            echo '</TD></TR>
			<TR><TD class="lfb" >&nbsp;' . $sState . ' &nbsp;&nbsp; ' . $sCity . '</TD>
			<TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err7)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err7 . '</span>';
                } else if (!empty($err4)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err4 . '</span>';
                }
            }
            $sZip = isset($rec['ETO_OFR_S_ZIP']) ? $rec['ETO_OFR_S_ZIP'] : '';
            $sStreetAdd = isset($rec['ETO_OFR_S_STREETADDRESS']) ? $rec['ETO_OFR_S_STREETADDRESS'] : '';
            echo '</TD></TR>
		<TR><TD class="lfb" >&nbsp;' . $sZip . '</TD><TD></TD></TR>
		<TR><TD  class="lfb" >&nbsp;' . $sStreetAdd . '</TD><TD></TD></TR>
		<TR><TD class="lfb">&nbsp;</TD><TD></TD></TR>
		<TR>';
            echo '<TD class="lfb" >';
            if (isset($rec['ETO_OFR_S_PH_NUMBER'])) {
                if (isset($rec['ETO_OFR_S_PH_AREA'])) {
                    echo @$rec['ETO_OFR_S_PH_COUNTRY'] . ' - ' . $rec['ETO_OFR_S_PH_AREA'] . ' - ' . $rec['ETO_OFR_S_PH_NUMBER'];
                } else {
                    echo @$rec['ETO_OFR_S_PH_COUNTRY'] . ' - ' . $rec['ETO_OFR_S_PH_NUMBER'];
                }
            }
            echo '&nbsp;</TD><TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err8)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err8 . '</span>';
                } else if (!empty($err6)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err6 . '</span>';
                }
            }
            echo '</TD></TR><TR>';
            echo '<TD class="lfb">&nbsp;NA </TD><TD></TD></TR>';
            $sPhMobile = isset($rec['ETO_OFR_S_PH_MOBILE']) ? $rec['ETO_OFR_S_PH_MOBILE'] : '';
            echo '<TR><TD class="lfb">&nbsp;' . $sPhMobile . '</TD><TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err3)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err3 . '</span>';
                }
            }
            $sUrl = isset($rec['ETO_OFR_S_URL']) ? $rec['ETO_OFR_S_URL'] : '';
            echo '</TD></TR>
			<TR><td class="lfb">&nbsp;' . $sUrl . '</TD><TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err9)) {
                    echo '&nbsp;<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err9 . '</span>';
                }
            }
            echo '</TD></TR>  <tr>
		<td class="lfb" style="height:43px/height:35px">&nbsp;</td><TD>';
            echo '</td></tr>
		</TABLE>
		</TD>
		</TR>
		</tbody>
		</table><br><br><br><br><br>
		';
            //}
            
        } else {
            echo '<TR><TD ALIGN="center" CLASS="admintlt"><CENTER>No Offer Found</CENTER></TD></TR></table>';
        }
        echo '</BODY></HTML>';
    } else {
        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
        exit;
    }
} else {
    if ($offerID <> '') { ?>
<div style="font-weight:bold;align:center;color:red;">No detail Found for Offer: <?php echo $offerID . '. ' . $arc_checked_msg; ?> </div><br> 
 <?php
    } ?>
<form name="jumpForm" method="post" action="/index.php?r=admin_eto/OfferDetail/editflaggedleads&mid=3424&ban=<?php echo $ban; ?>" style="margin-top:0;margin-bottom:0;">       
<table valign="center" cellspacing="4" cellpadding="4" border="0" bgcolor="#0056cc" align="center" width="100%" style="color: rgb(255, 255, 255); font-family: arial; font-size: 12px;"><tbody><tr>
<td width="100px" align="left">&nbsp;
<span style="font-weight:bold;float:left;">Offer ID:</span>&nbsp;
</td><td width="400px" align="left"><input type="text" name="offer" id="offer" style="width: 200px; float:left;" maxlength="15" value="<?php echo $offerID; ?>">&nbsp;
&nbsp;<input type="checkbox" name="arc" id="arc" value="1" <?php echo $arc_checked; ?> title="Click to Fetch  Data From Archive (ETO_OFR_FROM_FENQ_ARCH+ETO_OFR_TEMP_DEL_ARCH+ETO_OFR_EXP_ARCH)">&nbsp;<b>Archive Data</b>
</td><td>&nbsp;&nbsp;<input type="submit" name="jump" style="font-weight:bold;font-size: 13px; font-family: arial; padding: 0px; float:left;width:80px;height:25px; text-align:center;" value="Search" 
onclick="if(offer.value.match('^[0-9]+\$')){}else{alert('Enter only Numeric Value'); return false;}">
</td>
</tr></table></form>
<?php
} ?>