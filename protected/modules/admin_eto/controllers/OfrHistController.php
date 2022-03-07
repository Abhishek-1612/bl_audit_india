<?php 
class OfrHistController extends Controller
{	
	public function actionEtoHistory(){
		$returnRe = array();
		$request = Yii::app()->request;
		$params = $q = $_REQUEST;
		$valid= 1;
		
		$empId = Yii::app()->session['empid'];	
               if($empId){
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
		$mid_list = Yii::app()->session['mid_list'];
		$user_permissions = array();
		if (!empty($mid_list)) {
		foreach ($mid_list as $key => $val){
			if ($key == $mid){
			$user_permissions = $val;             
			}
		}
		if(empty($user_permissions)){
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
			}
		}
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
	//	if($user_view ==1)
		//{
		$offerId=isset($_REQUEST['offer']) ? $_REQUEST['offer'] : 0;
		$glModel =  new GlobalmodelForm();
        $status_type = array('1' => "U", '2' => "D", '3' => "E", '4' => "P", '5' => "R", '6' => "T",'7' => "A");
		$status_disp = array('U' => "Modified", 'D' => "Deleted", 'E' => "Expired", 'P' => "Reposted", 'R' => "Renewed", 'T' => "Push To Top", 'N' => "New Posted", 'A' => "All");
		$etoModel =  new AdminEtoForm();
                $model =  new AdminEtoModelForm();
		
		if(is_numeric($offerId) && $offerId>0)
		{
		if($params['act'] == "generate"){
			$returnResult = $etoModel->histUsrResult($request,$glModel,$status_type,$status_disp);exit;
		}else if(($params['act'] == "ofrHist") || ($params['act'] == "ofrHistold")){
			$returnResult = $etoModel->histOfrAllDet_pg($request,$glModel,$status_type,$status_disp,'');
			 $isqData=$etoModel->history_isq1_pg($offerId);
			$this->render("/admineto/offerhistory_pg",array("valid" => $valid,"returnResult"=>$returnResult,"param"=>$params,"status_type"=>$status_type,"status_disp"=>$status_disp,"isqData" => $isqData));
        
                } else if($params['act'] == "fenqHist"){
			$returnResult = $etoModel->histFENQOfrAllDet($glModel);
			$this->render("/admineto/fenqhistory",array("valid" => $valid,"returnResult"=>$returnResult,"param"=>$params,"status_type"=>$status_type,"status_disp"=>$status_disp));
		}else if($params['act'] == "autoHist"){
			$returnResult = $etoModel->autoapprove($offerId);			
			$this->render("/admineto/autohistory",array("offerId" => $offerId,"returnResult"=>$returnResult));
		}
		 else if($params['act'] == "mapHist"){		        
			$returnResult = $etoModel->histOfrMapDet($request,$glModel,$status_type,$status_disp);

			$this->render("/admineto/mappinghistory",array("valid" => $valid,"returnResult"=>$returnResult,"param"=>$params,"status_type"=>$status_type,"status_disp"=>$status_disp));
		} 
		else if($params['act'] == "locking")
		{
		   $approveDate=isset($_REQUEST['ad']) ? $_REQUEST['ad'] : ''; 
		   $deleteDate=isset($_REQUEST['dd']) ? $_REQUEST['dd'] : '';
		   $postDate=isset($_REQUEST['pd']) ? $_REQUEST['pd'] : '';
		   $Postby=isset($_REQUEST['postby']) ? $_REQUEST['postby'] : '';
		   $returnResult = $etoModel->histOfrLocking($approveDate,$deleteDate,$offerId);
		   $this->render("/admineto/lockinghistory",array("postDate" => $postDate,"returnResult"=>$returnResult,"offerId"=>$offerId,"Postby"=>$Postby));		   
		} 
		else if($params['act'] == "Isq_hist")
		{
		   $isqData=$etoModel->history_isq($offerId);
		   $this->render("/admineto/isqhistory",array("valid" => $valid,"returnResult"=>array(),"param"=>$params,"status_type"=>$status_type,"status_disp"=>$status_disp,"isqData" => $isqData));
		}else{
			 	exit;	
		}
                }
                else{
                    echo "Incorrect Offer Id";
                    exit;
                }
		//} else{
		//	echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
		//} 
	}
	/*	else{
                        echo "You are not logged in";
                        exit;
                }*/
	}
	
        public function actionCitydetail(){  
            if(isset($_REQUEST['glid'])){
		$glid=$_REQUEST['glid'];
                $etoModel =  new AdminEtoForm();
		$etoModel->citydetail($glid);
            }
                die;
	} 

}