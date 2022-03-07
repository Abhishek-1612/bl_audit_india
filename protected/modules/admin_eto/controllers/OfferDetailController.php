<?php
class OfferDetailController extends Controller {
    public $statusDesc = array();
    public $userStatusDesc = array();
    public $model = '';
    public $etoModel = '';
    public $glModel = '';
    public $qtyList = array();
    public $qtyListOther = array();
    public $use_posgre = 0;
    public function init() {
        $this->statusDesc = array('W' => 'Waiting', 'A' => 'Approved');
        $this->userStatusDesc = array('W' => 'Waiting', 'A' => 'Approved', 'D' => 'Disabled', 'M' => 'Error Disabled');
        $this->use_posgre = 0;
        $this->etoModel = new AdminEtoForm();
        // $this->model = new AdminEtoModelForm();
        $this->glModel = new GlobalmodelForm();
        $this->qtyList = array("Kilogram", "Metric Tons", "Nos", "Pieces", "Tons");
        $this->qtyListOther = array("20' Container", "40' Container", "Bags", "Barrel", "Bottles", "Boxes", "Bushel", "Cartons", "Dozens", "Foot", "Gallon", "Grams", "Hectare", "Kilogram", "Kilometer", "Litres", "Long Ton", "Meter", "Metric Tons", "Nos", "Ounce", "Packets", "Packs", "Pairs", "Pieces", "Pound", "Reams", "Rolls", "Sets", "Sheets", "Short Ton", "Square Feet", "Square Meters", "Tons", "Units", "Others");
    }
    public function actionEditFlaggedLeads() {
        $bandetail=array();
        $resultData = array();
        $arr_map_ref = array();
        $approvPermit = 'N';
        $request = Yii::app()->request;
        $valid = 0;
        $q = $_REQUEST;
        $fcpdetail = '';
        $lvl_code = '';
        $vendor_name = '';
        $empId = Yii::app()->session['empid'];
        if ($empId) {
            $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
            $offerID = $request->getParam('offer', '');
            $email = Yii::app()->session['empemail'];
            $mid_list = Yii::app()->session['mid_list'];
            $user_permissions = array();
            if (!empty($mid_list)) {
                foreach ($mid_list as $key => $val) {
                    if ($key == $mid) {
                        $user_permissions = $val;
                    }
                }
                if (empty($user_permissions)) {
                    $user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] = $user_permissions['TOADD'] = $user_permissions['TODELETE'] = '';
                }
            }
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
            if ($user_view == 1) {
                $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);
                if (isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2) {
                    $lvl_code = 'E';
                } elseif (isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')) {
                    $lvl_code = 'V';
                }
                if (isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME'])) {
                    $vendor_name = $arr_lvl_code['ETO_LEAP_VENDOR_NAME'];
                }
                if (isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] != 1 && isset($arr_lvl_code['ETO_LEAP_EMP_IS_ACTIVE']) && $arr_lvl_code['ETO_LEAP_EMP_IS_ACTIVE'] = - 1) {
                    $approvPermit = 'Y';
                }
                $path = $_SERVER['SERVER_NAME'];
                if (!empty($empId)) {
                    $valid = 1;
                }
                $prev_vendor_name = '';
                $status_check = '';
                if ($valid != 0) {
	                $param['action'] = $request->getParam('action');
	                $param['offer'] = $request->getParam('offer');
                    if (!empty($param['offer']) && is_numeric($param['offer'])) {
                        $resultData = $this->etoModel->editOffer($request, $empId, $path, $this->statusDesc, $this->userStatusDesc, '', '', '', $this->glModel);
                        $ofrStatus = isset($resultData['status']) ? $resultData['status'] : '';
                        $arr_map_ref = $this->etoModel->getCatMcatDetail($param['offer'], $this->glModel, $ofrStatus);
                        $status_check = isset($resultData['status']) ? $resultData['status'] : '';
                        $prev_vendor_name = isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) ? $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] : '';
                        $rec = $resultData['rec'];
                        if (isset($rec['CALL_DEL_REASON']) && preg_match("/Ban/", $rec['CALL_DEL_REASON']) > 0) {            
                          $bandetail = $this->etoModel->bandetail($param['offer']); 
                        }elseif($status_check=='A' || $status_check == 'E'){
                            $bandetail = $this->etoModel->bandetail($param['offer']);
                        }
                      }
                }
                $returnArr = array("bandetail"=>$bandetail,"lvl_code" => $lvl_code, "valid" => $valid, 'result' => $resultData, 'arr_map_ref' => $arr_map_ref, 'offerID' => $param['offer'], 'emp_id' => $empId, 'statusDesc' => $this->statusDesc, 'userStatusDesc' => $this->userStatusDesc, 'qtyListOther' => $this->qtyListOther, 'qtyList' => $this->qtyList, 'approvPermit' => $approvPermit, 'vendor_name' => $vendor_name, 'fcpdetail' => $fcpdetail, 'arr_lvl_code' => $arr_lvl_code, 'prev_vendor_name'=>$prev_vendor_name, 'status_check'=>$status_check, 'mid'=>$mid/*, 'offerdetHTML' => $offerdetHTML, 'transactiondetHTML' => $transactiondetHTML, 'BuyersDetailsHtml' => $BuyersDetailsHtml*/);
                $this->render("/admineto/editflaggedleads", $returnArr);
            } else {
                echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                exit;
            }
        } else {
            echo "You are not logged in";
            exit;
        }
    }
    public function actionShowsecondaryDetails()
    {
    	// print_r($_REQUEST);//return;
        $data= isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
    	$resultData = array();
        $request = Yii::app()->request;
        $valid = 0;
        $q = $_REQUEST;
        $lvl_code = '';
        $empId = Yii::app()->session['empid'];
        $user_permissions = array();

            $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
            $mid_list = Yii::app()->session['mid_list'];
            if (!empty($mid_list)) {
                foreach ($mid_list as $key => $val) {
                    if ($key == $mid) {
                        $user_permissions = $val;
                    }
                }
                if (empty($user_permissions)) {
                    $user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] = $user_permissions['TOADD'] = $user_permissions['TODELETE'] = '';
                }
            }
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
    	$offerdetHTML = '';
        $BuyersDetailsHtml = '';
        $transactiondetHTML = '';
            $param['offer'] = isset($q['prevoffer']) ? $q['prevoffer'] : '';
            if (!empty($param['offer']) && is_numeric($param['offer'])) {
                $ofrStatus = isset($q['status_check']) ? $q['status_check'] : '';
                $status_check = isset($q['status_check']) ? $q['status_check'] : '';
             //   if (isset($status_check) && ($status_check == 'A' || $status_check == 'E')) {
                    $obj = new BuyleadSearchModel();
                   // if ((isset($q['prev_vendor_name']) && ($q['prev_vendor_name'] == 'NOIDA' || $q['prev_vendor_name'] == 'DDN')) || ($user_view == 1)) {
                        $res2 = $obj->purchaseDetails_new('', $param['offer'], '', '',$status_check);
                        $transactiondetHTML = $res2[1];
                        $transactiondetHTML2 = $res2[2];
                        if($data == 'showastbuy' && isset($transactiondetHTML2)){
                            print_r($transactiondetHTML2);
                            exit;
                        }
                   // }
                    $res1 = $obj->offerDetail($param['offer']);
                    $offerdetHTML = $res1[0];
                    $BuyersDetailsHtml = $res1[1];
               // }
            }
        
        $status = isset($q['status_check']) ? $q['status_check'] : '';
        if (isset($status) && ($status == 'A' || $status == 'E'))
        {
	        if ($offerdetHTML == '') {
	            $offerdetHTML = "No information for Offer Details";
	        }
	        if ($BuyersDetailsHtml == '') {
	            $BuyersDetailsHtml = 'No information for Buyers Details';
	        }
	        if ($transactiondetHTML == '') {
	            $transactiondetHTML = "No information for Transaction Details";
	        }
	        if ($offerdetHTML != '' || $BuyersDetailsHtml != '' || $transactiondetHTML != '')
	        {
	        	echo '<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: arial;font-size: 12px;color: #000000;border: 0.2px solid grey;">
						<th>';
				// <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: arial;font-size: 12px;color: #000000;border: 0.2px solid grey;">
				// 	<th>
				if ((isset($q['prev_vendor_name']) && ($q['prev_vendor_name'] == 'NOIDA' || $q['prev_vendor_name'] == 'DDN')) || ($user_view == 1))
				{
					echo '<td style="padding-left:20px; padding-top:2px;" width="20%">
								'.$offerdetHTML.'
							</td>
							<td>
								<hr width="3%" size="230"></hr>
							</td>
							<td style="padding-left:3px; " width="20%">
								'.$BuyersDetailsHtml.'
							</td>
							<td>
								<hr width="4%" size="230"></hr>
							</td>
							<td  width="53%" style="padding-top:2px;" >
								'.$transactiondetHTML.'
							 </td>';
	            }
	            else
	            {
	            	echo '<td style="padding-left:20px; padding-top:2px;" width="50%">
								'.$offerdetHTML.'
							</td>
							<td>
								<hr width="3%" size="230"></hr>
							</td>
							<td style="padding-left:3px; " width="50%">
								'.$BuyersDetailsHtml.'
							</td>';
				}
				echo '</th> </table> </fieldset>';	
	        }
	    }
	    return;
    }
    public function actionshowuserstats() {	
        //  if (isset(Yii::app()->session['empid'])) {	
              if (isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid'] > 0) {	
                  $glusrid = isset($_REQUEST['glusrid']) ? $_REQUEST['glusrid'] : 0;	
                  $obj = new Globalconnection();	
                      echo $fcpdetail = $this->etoModel->getleaddetail($this->glModel, $_REQUEST['offerid'], $glusrid, '');	
                      
                  exit;	
              }	
        //  } else {	
       //       echo "You are not logged in";	
       //       exit;	
         // }	
      }
    public function actionshowragstats() {
        if (isset(Yii::app()->session['empid'])) {
            if (isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid'] > 0) {
                echo $fcpdetail = $this->etoModel->getragdetail();
            }
        } else {
            echo "You are not logged in";
            exit;
        }
    }
    public function actionshowfcpdetail() {
        if (isset(Yii::app()->session['empid'])) {
            if (isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid'] > 0) {
                echo $fcpdetail = $this->etoModel->FCPDetail($_REQUEST['offerid']);
                exit;
            }
        } else {
            echo "You are not logged in";
            exit;
        }
    }
    public function actionshowproduct() {
        $request = Yii::app()->request;
        $glid = $request->getParam('glid');
        echo $Result = $this->etoModel->showproduct($glid);
        die;
    }
    public function actionSetFlag() {
        $q = $_REQUEST;
        $updateFlag = '';
        $lvl_code = '';
        $empId = Yii::app()->session['empid'];
        if ($empId) {
            $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);
            if (isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2) {
                $lvl_code = 'E';
            } elseif (isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')) {
                $lvl_code = 'V';
            }
        }
        if (isset($_REQUEST['pushtotop']) && $_REQUEST['pushtotop'] == 'Push to Top') {
            $pushed = $this->etoModel->pushProductOnTop($empId);
            $this->redirect(Yii::app()->request->urlReferrer);
            die;
        }
        if ($lvl_code == 'E' || $lvl_code == 'V') {
            $updateFlag = $this->etoModel->saveOffer($empId, $this->glModel);
            if ($updateFlag["status"] == "SUCCESS") {
                echo $updateFlag["msg"];
                $this->redirect(Yii::app()->request->urlReferrer);
            } else {
                return $updateFlag["msg"];
            }
        }
    }
    public function actionSearchManualMcat() {
        $q = $_REQUEST;
        $updateFlag = '';
        $empId = Yii::app()->session['empid'];
        $manualMcatResult = $this->etoModel->manualMcat($empId, $this->glModel);
        $this->render("/admineto/searchmanualmcat", array("manualMcatResult" => $manualMcatResult));
    }
    public function actionGetCatOffers() {
        $manualMcatResult = $this->etoModel->getManualMcatList($this->glModel);
        die;
    }
    public function actionShowOffersDelReason() {
        $request = Yii::app()->request;
        $button = $request->getParam("button", '');
        $deleteResonResult = $this->etoModel->showOfferDelReasons($this->glModel, $request);
        $result = $deleteResonResult['result'];
        $fromAnchor = $deleteResonResult['fromAnchor'];
        $redirectURL = $deleteResonResult['redirectURL'];
        $this->render("/admineto/showofferdelreasons", array("deleteResonResult" => $result, 'button' => $button, "fromAnchor" => $fromAnchor, "redirectURL" => $redirectURL));
    }
    public function actionDeleteSilent() {
        $q = $_REQUEST;
        $request = Yii::app()->request;
        $referalUrl = $request->getParam('referalUrl', '');
        $lvl_code = '';
        $empId = Yii::app()->session['empid'];
        if ($empId) {
            $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);
            if (isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2) {
                $lvl_code = 'E';
            } elseif (isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')) {
                $lvl_code = 'V';
            }
        }
        if ($lvl_code == 'E' || $lvl_code == 'V') {
            $deleted = $this->etoModel->delRec($this->glModel, $request, $empId, '');
        }
        if (!empty($referalUrl)) {
            $this->redirect($referalUrl);
        } else {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }
    public function actionShowDelReason() {
        $request = Yii::app()->request;
        $fromAnchor = $request->getParam('fromanchor', 0);
        $redirectURL = $request->getParam('url', '');
        $button = $request->getParam("button", '');
        $deleteResonResult = $this->etoModel->showOfferDelReasons($this->glModel, $request);
        $result = $deleteResonResult['result'];
        $fromAnchor = $deleteResonResult['fromAnchor'];
        $redirectURL = $deleteResonResult['redirectURL'];
        $this->render("/admineto/offerdelreason", array("deleteResonResult" => $result, 'redirectURL' => $redirectURL, 'fromAnchor' => $fromAnchor, 'button' => $button, 'fromAnchor' => $fromAnchor, 'redirectURL' => $redirectURL));
    }
    public function actionSaveGlusrDetails() {
        $request = Yii::app()->request;
        $q = $_REQUEST;
        $empId = Yii::app()->session['empid'];
        if ($empId > 0) {
            $updateResult = $this->etoModel->saveGlUsrDetails($request, $this->glModel, $empId);
            if ($updateResult == "FAIL") {
                echo "Glusr Updation Failed.";
            } else {
                echo "Glusr Updated Successfully.";
            }
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }
    public function actionViewEditEnrichment() {
        error_reporting(1);
        $request = Yii::app()->request;
        $param['offerId'] = $request->getParam('offer', 0);
        $param['field'] = $request->getParam('field', '');
        $param['allowPrem'] = 'N';
        $path = $_SERVER['SERVER_NAME'];
        $q = $_REQUEST;
        $valid = 0;
        $lvl_code = '';
        $adm_lvl = '';
        $empId = Yii::app()->session['empid'];
        if (!empty($empId) && $empId > 0) {
            $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);
            if (isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2) {
                $lvl_code = 'E';
            } elseif (isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')) {
                $lvl_code = 'V';
            }
            $valid = 1;
        }
        $permission = $this->model->getEmpAccess($request, $this->glModel, $empId);
        if (isset($permission['CNT']) && !empty($permission['CNT'])) {
            $param['allowPrem'] = 'Y';
        }
        $recvaluerange = $this->model->getApproxOrderValue($this->glModel);
        $recvaluerangeIN = $recvaluerange['recvaluerangeIN'];
        $recvaluerangeFR = $recvaluerange['recvaluerangeFR'];
        $masterValues = $this->model->getMasterValues($this->glModel);
        $result = $this->etoModel->showPrevCallData($request, $param, $this->glModel);
        $resultData = $this->etoModel->editOffer($request, $empId, $path, $this->statusDesc, $this->userStatusDesc, '', '', '', $this->glModel);
        $mcat_id = isset($resultData['mcat_id']) ? $resultData['mcat_id'] : '';
        $resultArr = $this->etoModel->getIndustrySpecQuesDetails($request, $mcat_id);
        $NOBArr = $this->etoModel->NOB($param['offerId']);
        $modid = $_REQUEST['modid'];
        $this->render("/admineto/vieweditenrichment", array("valid" => $valid, "result" => $result, "recvaluerangeFR" => $recvaluerangeFR, "recvaluerangeIN" => $recvaluerangeIN, "masterValues" => $masterValues, "allowPrem" => $param['allowPrem'], "lvl_code" => $lvl_code, "resultArr" => $resultArr, "NOBArr" => $NOBArr, "modid" => $modid));
    }
    public function actionUpdateCallData() {
        $request = Yii::app()->request;
        $fieldsArr = array();
        $empId = Yii::app()->session['empid'];
        $path = $_SERVER['SERVER_NAME'];
        $NOBVal = $_REQUEST['NOB'];
        $OFFERID = $request->getParam('offer', 0);
        $resultData = $this->etoModel->editOffer($request, $empId, $path, $this->statusDesc, $this->userStatusDesc, '', '', '', $this->glModel);
        $mcat_id = isset($resultData['mcat_id']) ? $resultData['mcat_id'] : '';
        $resultArr = $this->etoModel->getIndustrySpecQuesDetails($request, $mcat_id);
        $re = $this->etoModel->updateCallData($request, $this->glModel, $resultArr, $mcat_id);
        $modid = $_REQUEST['modid'];
        $this->etoModel->NOB_UPDATE($OFFERID, $NOBVal, $modid);
        $this->redirect(Yii::app()->request->urlReferrer);
    }
    public function actionmanualgrouplist() {
        $manualMcatResult = $this->etoModel->getManualGroupList($this->glModel);
    }
    public function actionComplaint() {
        $complaintResult = $this->etoModel->showAllComplaint($this->glModel);
        $this->render("/admineto/complaint", array('complaintResult' => $complaintResult));
    }
    public function actionBlDeleteReason() {
        $loginPath = $_SERVER['SERVER_NAME'];
        $referalUrl = Yii::app()->request->urlReferrer;
        $delReasons = array();
        $request = Yii::app()->request;
        $q = $_REQUEST;
        $valid = 1;
        $empId = Yii::app()->session['empid'];
        $delReasons = $this->etoModel->showOfferDelReasons($this->glModel, $request);
        $this->render("/admineto/bldeletereasons", array('referalUrl' => $referalUrl, 'valid' => $valid, 'delResult' => $delReasons, 'loginPath' => $loginPath));
    }
    public function actionmultiplecallrecord() {
        $request = Yii::app()->request;
        $offer = $request->getParam('offer', 0);
        $glid = $request->getParam('glid', 0);
        $ofrdate = $request->getParam('dt', '');
        $empid = Yii::app()->session['empid'];
        $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $mid_list = Yii::app()->session['mid_list'];
        $user_permissions = array();
        if (!empty($mid_list)) {
            foreach ($mid_list as $key => $val) {
                if ($key == $mid) {
                    $user_permissions = $val;
                }
            }
            if (empty($user_permissions)) {
                $user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] = $user_permissions['TODOWNLOAD'] = $user_permissions['TODELETE'] = '';
            }
        }
        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        if ($user_view == 1 && $empid > 0) {
            if ($offer > 0 && is_numeric($offer)) {
                $multiplecallrecordsth = $this->etoModel->multiplecallrecord($offer);
                $multiplecallrecordsth_c2c = $this->etoModel->multiplecallrecord_c2c($glid, $ofrdate);
                $this->render("/admineto/multiplecallrec", array('offer' => $offer, "multiplecallrecordsth" => $multiplecallrecordsth, 'multiplecallrecordsth_c2c' => $multiplecallrecordsth_c2c));
            } else {
                echo "<b style='font-size:15px;color:red;padding-left:20px'>Offer ID should be Numeric<b>";
                exit;
            }
        } else {
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
            exit;
        }
    }
    // New Function for Unrealistic TOV
    public function actiongetglprofile() {
        if (isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid'] > 0) {
            $offerid = $_REQUEST['offerid'];
            $gl_profile = $this->etoModel->unrealistictov($offerid);
            echo $gl_profile;
            exit;
        }
    }
    // New Function for Unrealistic TOV
    public function actionshowragscale() {
        if (isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid'] > 0) {
            $offerid = $_REQUEST['offerid'];
            $gl_profile = $this->etoModel->showragscale($offerid);
            echo $gl_profile;
            exit;
        }
    }
    
    public function actiongetglprofilequantity() {
        if (isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid'] > 0) {
            $offerid = $_REQUEST['offerid'];
            $gl_profile = $this->etoModel->unrealisticquantity($offerid);
            echo $gl_profile;
            exit;
        }
    }
    public function logCreation($content) { //$data .= $content_neft[$i][0]."\r\n".$content_neft[$i][1]."\r\n";
        $time = getdate();
        $date = substr($time['month'], 0, 3) . "-" . $time['mday'] . "-" . $time['year'];
        $file = $_SERVER['DOCUMENT_ROOT'] . '/gl_global_upload/offer_' . $date . '.txt';
        if (file_exists($file)) {
            $myFile = fopen($file, 'a+');
        } else {
            $myFile = fopen($file, 'w');
        }
        fwrite($myFile, $content);
        fclose($myFile);
    }
    
}
