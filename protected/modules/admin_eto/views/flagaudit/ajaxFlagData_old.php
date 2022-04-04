
<br>
<table style="border-collapse: collapse;" border="0" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
    <?php 
        $i = 1;
        $all_ofr_id = '';
        $checkradio1 = "checked";
        $checkradio2 = "";
        $check1 = $check2 =  $check3 =$check4= '';
        foreach($data as $viewData){
            $title   = isset($viewData['ETO_OFR_TITLE']) ? $viewData['ETO_OFR_TITLE'] : '';
            $offerID = isset($viewData['ETO_OFR_DISPLAY_ID']) ? $viewData['ETO_OFR_DISPLAY_ID'] : '';
            $all_ofr_id .= $offerID . ",";
            $ETO_OFR_APPROV_DATE = isset($viewData['ETO_OFR_APPROV_DATE']) ? $viewData['ETO_OFR_APPROV_DATE'] : '';
            if (isset($viewData['CALL_RECORDING_URL'])) {
                $prim1              = $viewData['CALL_RECORDING_URL'];
                $CALL_RECORDING_URL = '<a href="' . $prim1 . '" TARGET="_blank"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A>';
            } else {
                $CALL_RECORDING_URL = '<b style="color:#0000ff">&#187;&nbsp;Recording Not Available </b>';
            }
            $glid = $viewData["FK_GLUSR_USR_ID"];
    ?>
        <tr>
            <td style="background: #0195d3; color: white;padding:4px;">
                <b>SNo:</b>
                &nbsp;<?= $i?>&nbsp;&nbsp;
                <b>ID:</b>
                &nbsp; <a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=<?= $viewData['ETO_OFR_DISPLAY_ID'];?>&go=Go&mid=3424" style="text-decoration:none;color: white;" target="_blank"><?= $viewData['ETO_OFR_DISPLAY_ID'];?></a>
            </td>
            <td style="background: #0195d3; color: white;padding:4px;">
                <b>Lead title:</b>
                &nbsp;<?= $title;?>
            </td>
            <td style="background: #0195d3; color: white;padding:4px;">
                <b>History:</b>
                &nbsp; <a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=ofrHist&offer=<?= $viewData['ETO_OFR_DISPLAY_ID'];?>&mid=3424" style="text-decoration:none;color: white;" target="_blank"><?= $viewData['ETO_OFR_DISPLAY_ID']?></a>
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">
                <b>Associate:</b>
                &nbsp;<?= $viewData['ETO_LEAP_EMP_NAME'] . '(' . $viewData['ETO_LEAP_EMP_ID'] . ')';?>
            </td>
            <td style="padding:4px;">
                <b>Call Recording:</b>
                &nbsp;<?= $viewData['$CALL_RECORDING_URL'];?>
            </td>
            <td style="padding:4px;">
                <a href="index.php?r=admin_eto/OfferDetail/multiplecallrecord&offer=<?= $offerID;?>&mid=3424" target="_blank">&#187;&nbsp;View All Recordings</a>
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">
                <b>Flagged On:</b>
                &nbsp;<?= $ETO_OFR_APPROV_DATE;?>
            </td>
            <td style="padding:4px;">
                <input onclick = "validate_radio(this.name)" type="radio" name="<?= 'delopt_' . $offerID;?>" value="298"  id="<?= 'delopt_' . $offerID;?> " <?= $checkradio1;?> >
                <font color="green">&nbsp;Correctly Flagged</font>
            </td>  
            <td width="40%" rowspan=2>
                <table border=0 cellpadding="0" cellspacing="0"  width="100%">
                    <tr>
                        <td>
                            <input onclick = "validate_opt(this.name)"  type="checkbox" <?= $check1;?> width="100px" value="299" name="<?= 'chk_' . $offerID;?>" id="<?= 'chk_299_'. $offerID; ?>" >
                            <font color="red">Second Call Attempt Required but Flagged</font>
                        </td>
                        <td>
                            <input onclick = "validate_opt(this.name)"  type="checkbox" <?= $check3;?> width="100px" value="301" name="<?= 'chk_' . $offerID;?>" id="<?= 'chk_301_'. $offerID; ?>">
                            <font color="red"> Approval Required but Flagged</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input onclick = "validate_opt(this.name)"  type="checkbox" <?= $check2;?> width="100px" value="300" name="<?= 'chk_' . $offerID;?>" id="<?= 'chk_300_'. $offerID; ?>">
                            <font color="red">Deletion Required but Flagged</font>
                        </td>
                        <td>
                            <input onclick = "validate_opt(this.name)"  type="checkbox" <?= $check4;?> width="100px" value="302" name="<?= 'chk_' . $offerID;?>" id="<?= 'chk_302_'. $offerID; ?>">
                            <font color="red">Others</font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">
                <b>Flagged Reason: </b>
                &nbsp;Call Back Later
            </td>
            <td>
                <input type="radio" <?= $checkradio2?> onclick = "validate_radio(this.name)" name="<?= 'delopt_' . $offerID;?>" id="<?= 'delopt_' . $offerID;?>" value="2" ><font color="red">&nbsp;Wrongly Flagged</font>
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">
                <b>User Stats: </b>
                &nbsp;<input type="button" name="<?= 'showuserstat_'. $offerID; ?>" id="<?= 'showuserstat_'. $offerID; ?>" value="Show" onclick="showuserstats('<?= $offerID?>','<?= $glid;?>')">
                <div style="font-size:12px;padding:8px 15px 8px 8px; line-height:23px;letter-spacing:-0.02em;font-weight:bold" id="<?= 'userstat_'. $offerID; ?>">
                </div>
            </td>
            <td style="padding:4px;" colspan=2>
                <textarea id="<?= 'remarks_'. $offerID; ?>" name="remarks" style="width: 98%; height: 40px; margin-bottom:8px; ">Comment(if any):</textarea>
            </td>
        </tr>
    
    <?php $i++; } $all_ofr_id = trim($all_ofr_id, ",");?>



    <tr>
        <td valign="top"  align="center" colspan=3>
            <input id = "save_all" type="button" name="save_all" value="Save All" class="btn btn-success" ONCLICK="return check_validate();">
            <input id = "all_ofr_id" type="hidden" name="all_ofr_id" value="<?= $all_ofr_id;?>"> 
        </td>
    </tr>
    
</table>