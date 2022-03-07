<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
if (!empty($resultArr)) {
    $show_isq = $no_isq = '';
    $mcatid = isset($_REQUEST['mcatid']) ? $_REQUEST['mcatid'] : '';
    $mcat_name = isset($_REQUEST['mcat_name']) ? $_REQUEST['mcat_name'] : '';
    $quesArr = !empty($resultArr['quesArr']) ? $resultArr['quesArr'] : array();
    // echo"<pre>";print_r($quesArr);echo"</pre>";
    $isq_count = sizeof($quesArr);
    $img_url1 = isset($resultArr['mcat_url']['img_url']) ? $resultArr['mcat_url']['img_url'] : '';
    $dir_url = isset($resultArr['mcat_url']['dir_url']) ? $resultArr['mcat_url']['dir_url'] : '';
    $dir_link = "https://dir.indiamart.com/impcat/$dir_url.html";
    $img_url = substr($img_url1, 5);
    $mcat_name1 = explode("(", $mcat_name);
    if ($isq_count > 0) {
        $no_isq = "display:none;";
    } else {
        $show_isq = 'style = "display:none;"';
    }
    $empId = Yii::app()->session['empid'];
    $validationKey = isset(Yii::app()->session['imgauth']) ? Yii::app()->session['imgauth'] : '';
    $env = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
    if ($env == 'dev-gladmin.intermesh.net' || $env == 'stg-gladmin.intermesh.net') {
        $uploadUrl = "https://stg-uploading.imimg.com/uploadimage";
    } else {
        $uploadUrl = "https://uploading.imimg.com/uploadimage";
    }
}
$i = 0;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <LINK HREF="protected/modules/admin_marketplace/views/isq_edit_screen/isqstyle.css?v=2" REL="STYLESHEET" TYPE="text/css">
    <script language="javascript" src="/protected/modules/admin_marketplace/common-scripts/isq.js?v=7">
    </script>
    <script>
        function OpenSellerScreen(){
            window.open("/index.php?r=admin_marketplace/Isq_edit_screen/Index&mid=3504","_self");
        }
    </script>

</head>

<body>
    <?php
    if ($action == '') {
    ?>
        <div id="header">
            <?php if ($action == '') ?><div id="isq_heading">ISQ Edit Screen</div>
        </div>
        <div id="searchform_div" style="min-width:1118px;">
            <form name="searchForm" METHOD="post" ACTION="" id="searchForm">
                <label for="mcat_name" id="search_label">MCAT</label>
                <input type="TEXT" name="mcat_name" id="mcat_name" autocomplete="off" 
                onkeyup="lookup('mcat_name','MCAT','mcats');" value="">
                <input type="hidden" name="mcat_id" id="mcat_id" value="">
                <span id="question_for">Question for</span>
                <input type="radio" name="questypeMain" id="rad_buyer" value="buyer" class="buysuppradio" checked>
                <label for="rad_buyer" class="buysupptext">Buyer </label>
                <input type="radio" name="questypeMain" id="rad_supp" value="Supplier" class="buysuppradio" onclick = "OpenSellerScreen()" >
                <label for="rad_supp" class="buysupptext">Supplier</label>
                <input type="hidden" name="action" id="action" value="Isq_edit_report">
            </form>
        </div>

    <?php } ?>
    <div id="mcatsmain" 
    style="height:200px;overflow:auto;display:none; font-family: arial;font-size: 13px;width:425px;">
        <div id="mcats"></div>
    </div>
    <div id="result" style="margin-top:1%;margin-bottom:1%;"></div>
    <!-- <div id="result_tmp" style="margin-top:1%;margin-bottom:1%;"></div> -->

    <?php
    if ($action == 'Isq_edit_report') {

    ?>
        <div id="mcatimage">
            <img id="mcat_image" src="<?php echo $img_url ?>" width="100px" height="100px">
            <a href="<?php echo $dir_link ?>" target="_blank">
                <h3 id="mcat_image_name"><?php echo $mcat_name1[0] ?></h3>
                <h3 id="mcat_image_id">(<?php echo $mcatid ?>)</h3>
            </a>
        </div>
        <div id="aovlink">
            <a href="/index.php?r=admin_marketplace/Isq_edit_screen/Searchmcatlist&act=decode" target="popup" onclick="window.open('/index.php?r=admin_marketplace/Isq_edit_screen/Searchmcatlist&act=decode','popup','width=600,height=600'); return false;">
                AOV Decoded Value
            </a>
        </div>
        <div id="isqHistory">
            <a target="_blank" style="text-decoration: none;" href="/index.php?r=admin_marketplace/MarketplaceCategories/ISQHistory&mid=3597&action=ISQ - MCAT&glmetaid=<?php echo $mcatid ?>">
                View History
            </a>
        </div>
        <form METHOD="post" ACTION="" id="saveisqform" name="saveisqform" <?php echo $show_isq ?>>
            <div class="Question_list" id="question_list">
                <div class="question_header">
                    <div class="ques_header1">ISQ</div>
                    <div class="ques_header2">Type
                        <span style="margin-left: 3px;">
                            <img src="gifs/info.png" width="18px" height="18px" title="T=Text, R=Radio, D=Dropdown, MS=Multiple Select"></img>
                        </span>
                    </div>
                    <div class="ques_header3">Action</div>
                </div>
                <input type="hidden" name="mcatid" value="<?php echo $mcatid ?>">
                <div class="questions" id="questions">
                    <?php
                    $i = 0;
                    foreach ($quesArr as $value) {
                        $i++;
                        $quesdesc = isset($value['IM_SPEC_MASTER_DESC']) ? $value['IM_SPEC_MASTER_DESC'] : '';
                        $questype = isset($value['IM_SPEC_MASTER_TYPE']) ? $value['IM_SPEC_MASTER_TYPE'] : '';
                        $ques_opt  = is_array($value['IM_SPEC_OPTIONS_DESC']) ? $value['IM_SPEC_OPTIONS_DESC'] : array();
                        $imSpecMasterId = isset($value['IM_SPEC_MASTER_ID']) ? $value['IM_SPEC_MASTER_ID'] : '';
                        $supplier_prior = isset($value['IM_CAT_SPEC_SUP_PRIORITY']) ? $value['IM_CAT_SPEC_SUP_PRIORITY'] : '';
                        $quesdesc = isset($value['IM_SPEC_MASTER_DESC']) ? $value['IM_SPEC_MASTER_DESC'] : '';
                        $t_sel = $r_sel = $d_sel = $ms_sel = $plusbutton = $disable_text = $displaynone = '';
                        if ($questype == 1) {
                            if ($questype == 1 && empty($ques_opt)) {
                                $quesoptid = isset($value['IM_SPEC_OPTIONS_ID']) ? $value['IM_SPEC_OPTIONS_ID'] : '';
                                $ques_opt[$quesoptid] = "None";
                                $disable_text = '';
                                $displaynone = 'style="display:none"  ';
                            }
                            $t_sel = 'checked="checked"';
                            $plusbutton = 'display :none;';
                        } else if ($questype == 2) {
                            $r_sel = 'checked="checked"';
                        } else if ($questype == 3) {
                            $d_sel = 'checked="checked"';
                        } else {
                            $ms_sel = 'checked="checked"';
                        }
                        $option_count = sizeof($ques_opt);
                    ?>
                        <div class="ques" id="ques_<?php echo $i ?>">
                            <input type="hidden" class="quesprior" id="quesprior<?php echo $i ?>" name="quesprior<?php echo $i ?>" value="<?php echo $i ?>">
                            <input type="hidden" name="cat_spec_status<?php echo $i ?>" id="cat_spec_status<?php echo $i ?>" value=1>
                            <input type="hidden" name="quesmasterid<?php echo $i ?>" id="quesmasterid<?php echo $i ?>" value="<?php echo $imSpecMasterId ?>">
                            <input type="hidden" name="supplier_prior<?php echo $i ?>" id="supplier_prior<?php echo $i ?>" value="<?php echo $supplier_prior ?>">
                            <input type="hidden" name="questype<?php echo $i ?>" value="<?php echo $questype ?>">
                            <input type="hidden" name="total_opt<?php echo $i ?>" id="total_opt<?php echo $i ?>" value=<?php echo $option_count ?>>
                            <div class="ques_priority" id="ques_priority<?php echo $i ?>">
                                <div style=" padding:5px; border-radius:3px; background-color:#bfddf3" class="ques_priority_val" id="ques_priority_val<?php echo $i ?>">
                                    <?php echo $i ?>
                                </div>
                            </div>
                            <div class="ques_description">
                                <div>
                                    <span>
                                        <input type="text" value="<?php echo $quesdesc ?>" name="quesdesc<?php echo $i ?>">
                                    </span>
                                </div>
                            </div>
                            <div class="ques_type">
                                <div>
                                    <span style="margin-right:22px"><input type="radio" name="questypename_<?php echo $i ?>" value=1 <?php echo $t_sel ?> onclick="return false;"></span>
                                    <span style="font-size: 14px;font-weight: bolder;"> T</span>
                                </div>
                                <div>
                                    <span style="margin-right:22px"><input type="radio" name="questypename_<?php echo $i ?>" value=2 <?php echo $r_sel ?> onclick="return false;"> </span>
                                    <span style="font-size: 14px;font-weight: bolder;">R</span>
                                </div>
                                <div>
                                    <span style="margin-right:22px"><input type="radio" name="questypename_<?php echo $i ?>" value=3 <?php echo $d_sel ?> onclick="return false;"> </span>
                                    <span style="font-size: 14px;font-weight: bolder;">D</span>
                                </div>
                                <div>
                                    <span style="margin-right:22px"><input type="radio" name="questypename_<?php echo $i ?>" value=4 <?php echo $ms_sel ?> onclick="return false;"></span>
                                    <span style="font-size: 14px;font-weight: bolder;">MS</span>
                                </div>

                            </div>
                            <div class="ques_delete">
                                <img src="gifs/bin.png" width="24px" height="24px" onclick="delete_isq(<?php echo $i ?>)"></img>
                            </div>
                            <div class="ques_options" id="ques_options_<?php echo $i ?>" <?php echo $displaynone ?>>
                                <?php
                                $j = 0;

                                if (!empty($ques_opt)) {
                                    $total_opt = sizeof($ques_opt);
                                    if ($questype == 2 || $questype == 4) {
                                        if ($total_opt >= 4) {
                                            $plusbutton = 'display :none;';
                                        }
                                    }
                                    foreach ($ques_opt as $opkey => $opvalue) {
                                        $j++;
                                        $option = "option" . $i . "_" . $j;
                                        $optionid = "optionid" . $i . "_" . $j;
                                        $quesoptenable = "quesoptenable" . $i . "_" . $j;
                                        $opt_prior = "opt_prior" . $i . "_" . $j;
                                ?>

                                        <div class="option" id="<?php echo $option ?>" data-id="<?php echo $i ?>">
                                            <div class="op1">
                                                <img src="gifs/menu.gif"></img>
                                            </div>
                                            <div class="op2">
                                                <input type="text" name="<?php echo $option ?>" value="<?php echo trim($opvalue) ?>" <?php echo $disable_text ?>>
                                            </div>
                                            <div class="op3">
                                                <img src="gifs/bin.png" width="15px" height="18px" onclick="delete_option(<?php echo $i ?> , <?php echo $j ?>)"></img>
                                            </div>
                                            <input type="hidden" class="opt_prior" name="<?php echo $opt_prior ?>" value="<?php echo $j ?>">
                                            <input type="hidden" name="<?php echo $optionid ?>" value="<?php echo $opkey ?>">
                                            <input type="hidden" name="<?php echo $quesoptenable ?>" id="<?php echo $quesoptenable ?>" value="1">
                                        </div>
                                <?php }
                                }
                                ?>
                                <div id="addoption<?php echo $i ?>" style="font-size: 35px;color: #0065ca; <?php echo $plusbutton ?>" class="addnewoption" onclick="add_option(<?php echo $i ?>)">+</div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="total_ques" id="total_ques" value=<?php echo $isq_count ?>>
            </div>
            <div id="save_btn_result">
            </div>
            <div class="save_btn" id="save_btn">
                <input type="submit" onclick="return checksubmit()" value="Save"></input>
            </div>


            <!-- start - The Save comment section -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close" onclick="toggle_modal(0)">&times;</span>
                        <h2>Detailed Findings for ISQ Update</h2>
                    </div>
                    <br>
                    <div class="modal-body">
                        <textarea name = "save_comment" id = "save_comment" class="comment" rows="10" style=" width: 90%; padding:20px;margin-bottom: 2px;" placeholder="Comment" onkeyup="updateCountdown();" maxlength="3800" ></textarea><br>
                        <div style="width: 90%;margin-bottom: 5px;text-align: left;font-size: 12px;color: grey;padding-left: 25px;" id="remaining">
                            Remaining : <span class="countdown">3799 </span> (Maximum of 3800 characters)</div>
                        <label for="file" style="color:#232323"><b>Upload Document </b></label>
                        <input id="file" class="doc_attach" name="file" type="file" onchange='docuploadWithName(<?php echo $empId ?>,"<?php echo $validationKey ?>","<?php echo $uploadUrl ?>");'>
                        <span id="docuploaded"> </span> <span id="delete_doc" style="display:none; margin-left:10px;"> <img src="gifs/bin.png" width="18px" height="18px"  onclick="delete_doc()"></img></span>
                        <br>
                        <button class="save_comment" onclick="return toggle_modal(2);">Save</button>
                    </div>
                </div>
            </div>
            <!-- End - The Save comment section -->
            <input type="hidden" id="docurl" name="docurl" value=''>

        </form>
        <div id="no_isq" style="text-align:center; font-size:30px; <?php echo $no_isq ?>">
            <hr>
            No ISQ Available
            <hr>
        </div>


        <div class="button1">
            <button id="add_new_ques" onclick="toggle_button()">Add New Isq</button>
        </div>
        <div class="Question_list" id="add_question_list" style="display:none;">
            <form METHOD="post" ACTION="" id="saveisqformNew" name="saveisqformNew">
                <div class="question_header">

                    <div class="ques_header1">ISQ</div>
                    <div class="ques_header2">Type
                        <span style="margin-left: 3px;">
                            <img src="gifs/info.png" width="18px" height="18px" title="T=Text, R=Radio, D=Dropdown, MS=Multiple Select"></img>

                        </span>
                    </div>
                    <div class="ques_header3">Action</div>
                </div>
                <input type="hidden" name="mcatid" value="<?php echo $mcatid ?>">
                <div class="questions add_questions" id="add_questions">
                    <?php
                    $maxprior = $i + 1;
                    $l = $i;
                    for ($i = 1; $i <= 5; $i++) {
                        $l++;
                    ?>
                        <div class="ques" id="add_ques_<?php echo $i ?>">
                            <input type="hidden" name="add_questype<?php echo $i ?>" id="add_questype<?php echo $i ?>" value="">
                            <input type="hidden" name="add_quesprior<?php echo $i ?>" id="add_quesprior<?php echo $i ?>" value="<?php echo $l ?>">
                            <input type="hidden" name="add_cat_spec_status<?php echo $i ?>" id="add_cat_spec_status<?php echo $i ?>" value=1>
                            <div class="ques_priority" id="add_ques_priority<?php echo $i ?>">
                                <div style=" padding:5px; border-radius:3px; background-color:#bfddf3" class="add_ques_priority_val" id="add_ques_priority_val<?php echo $i ?>">
                                    <?php echo $l ?>
                                </div>
                            </div>
                            <div class="ques_description">
                                <div>
                                    <span>
                                        <input type="text" value="" name="add_quesdesc<?php echo $i ?>" class="add_quesdesc" onchange="default_isq_autosuggest(<?php echo $i ?>)" data-id="<?php echo $i ?>">
                                    </span>
                                </div>
                                <div id="defaultautosuggest<?php echo $i ?>" class="defaultautosuggest">
                                </div>
                            </div>
                            <div class="ques_type">
                                <div>
                                    <span style="margin-right:22px"><input type="radio" name="add_questypename_<?php echo $i ?>" value=1 onclick="change_ques_type(1,<?php echo $i ?>)"></span>
                                    <span style="font-size: 14px;font-weight: bolder;"> T</span>
                                </div>
                                <div>
                                    <span style="margin-right:22px"><input type="radio" name="add_questypename_<?php echo $i ?>" value=2 onclick="change_ques_type(2,<?php echo $i ?>)">
                                    </span>
                                    <span style="font-size: 14px;font-weight: bolder;">R</span>
                                </div>
                                <div>
                                    <span style="margin-right:22px"><input type="radio" name="add_questypename_<?php echo $i ?>" value=3 onclick="change_ques_type(3,<?php echo $i ?>)">
                                    </span>
                                    <span style="font-size: 14px;font-weight: bolder;">D</span>
                                </div>
                                <div>
                                    <span style="margin-right:22px"><input type="radio" name="add_questypename_<?php echo $i ?>" value=4 onclick="change_ques_type(4,<?php echo $i ?>)"></span>
                                    <span style="font-size: 14px;font-weight: bolder;">MS</span>
                                </div>
                            </div>
                            <div class="ques_delete" id=>
                                <img src="gifs/bin.png" width="24px" height="24px" id="add_ques_delete<?php echo $i ?>" style="display:none;" onclick="new_delete_isq(<?php echo $i ?>)"></img>
                            </div>
                            <div class="ques_options" id="add_ques_options_<?php echo $i ?>" style="display:none;">
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="add_total_ques" value="5">
                <div class="save_btn" id="addvalue_save_btn">
                    <input type="submit" onclick="return addchecksubmit()" value="Add New Isq"></input>
                </div>
            </form>
        </div>
    <?php } ?>
</body>

</html>