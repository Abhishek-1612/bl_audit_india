<?php
ini_set('max_input_vars', '30000');
class Isq_copy_screenController extends Controller
{
    public $obj_copy='';
    public $obj_edit = '';  
    public $glomodel='';  
	
    public function init(){
        $this->glomodel =  new GlobalmodelForm();
        $this->obj_copy=new isq_copy_screen;
        $this->obj_edit=new isq_edit_screen;
	}
	
	public function actionIndex()
	{  
		$loginPath  = $_SERVER['ADMIN_URL'];
		$hostname   = $_SERVER['SERVER_NAME'];
		$emp_id =Yii::app()->session['empid'];    
		$errormessage='';
		$isPMCAT = 1;		
		if(!$emp_id){
            print "Your are not logged in<BR> Click here to <A
            HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
        }       
		else{         
			$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
			$mid_list = Yii::app()->session['mid_list'];
			$user_permissions = array();
			if (!empty($mid_list)) {
				foreach ($mid_list as $key => $val) {
					if ($key == $mid) {
						$user_permissions = $val;
					}
				}
				
				if(empty($user_permissions)){
					$user_permissions['TOVIEW'] = '';
					$user_permissions['TOADD'] = '';
					$user_permissions['TOEDIT'] = '';
					$user_permissions['TODELETE'] = '';
					$user_permissions['TODOWNLOAD'] = '';				
				}
			}
               
			$user_view = $user_permissions['TOVIEW'];
			$user_edit = $user_permissions['TOEDIT'];
			$user_add = $user_permissions['TOADD'];
			
			if($user_view==1)
			{
				$resultArr = $resultArr1 = '';
				$thin_mcatname=isset($_REQUEST['thin_mcatname']) ? $_REQUEST['thin_mcatname'] : '';
				$thin_mcatid=isset($_REQUEST['thin_mcatid']) ? $_REQUEST['thin_mcatid'] : '';
				
				$thick_mcatname=isset($_REQUEST['thick_mcatname']) ? $_REQUEST['thick_mcatname'] : '';
				$thick_mcatid=isset($_REQUEST['thick_mcatid']) ? $_REQUEST['thick_mcatid'] : '';
				$cookie_mid=isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
				$unification = isset($_REQUEST['unification']) ? $_REQUEST['unification'] : 0;
      
				if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'isq_copy_report'))
				{
					$resultArr = $this->obj_edit->show_isq_question($thin_mcatid);
					
					if($thick_mcatid != ''){
						$isPMCAT = $this->obj_copy->IsPMCAT($thin_mcatid,$thick_mcatid);			
						$resultArr1=$this->obj_edit->show_isq_question($thick_mcatid);
					}	
				}
				if($unification == 1){
					$this->render('isq_unification_form', array("thin_mcatid"=>$thin_mcatid,"thick_mcatid"=>$thick_mcatid,"resultArr"=>$resultArr,"resultArr1"=>$resultArr1,"cookie_mid"=>$cookie_mid,"user_edit"=>$user_edit,"user_add"=>$user_add,"thin_mcatname"=>$thin_mcatname,"thick_mcatname"=>$thick_mcatname,'errormessage'=>$errormessage,'isPMCAT'=>$isPMCAT));
				}else{				
					$this->render('isq_copy_form', array("thin_mcatid"=>$thin_mcatid,"thick_mcatid"=>$thick_mcatid,"resultArr"=>$resultArr,"resultArr1"=>$resultArr1,"cookie_mid"=>$cookie_mid,"user_edit"=>$user_edit,"user_add"=>$user_add,"thin_mcatname"=>$thin_mcatname,"thick_mcatname"=>$thick_mcatname,'errormessage'=>$errormessage));
				}				
			}    
			else{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
			}
		}
	}
 
	public function actionCopy()
	{ 
        $user_edit=$user_add=1;
        $resultArr = $resultArr1 = $errormessage='';
        $thin_mcatname=isset($_REQUEST['thin_mcatname']) ? $_REQUEST['thin_mcatname'] : '';
        $thin_mcatid=isset($_REQUEST['thin_mcatid']) ? $_REQUEST['thin_mcatid'] : '';
        
        $thick_mcatname=isset($_REQUEST['thick_mcatname']) ? $_REQUEST['thick_mcatname'] : '';
        $thick_mcatid=isset($_REQUEST['thick_mcatid']) ? $_REQUEST['thick_mcatid'] : '';
        $cookie_mid=isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
		$unification = isset($_REQUEST['unification']) ? $_REQUEST['unification'] : 0;
       
        if($thin_mcatid>0){
            $errormessage=$this->obj_copy->Copy_ISQ($thick_mcatid); 
        }else{
            $errormessage='Please select MCAT ID';
        }
        $resultArr=$this->obj_edit->show_isq_question($thin_mcatid);
		
		if($thick_mcatid != ''){
			$resultArr1=$this->obj_edit->show_isq_question($thick_mcatid);
		}	
        if($unification == 1){
			$this->render('isq_unification_form', array("thin_mcatid"=>$thin_mcatid,"thick_mcatid"=>$thick_mcatid,"resultArr"=>$resultArr,"resultArr1"=>$resultArr1,"cookie_mid"=>$cookie_mid,"user_edit"=>$user_edit,"user_add"=>$user_add,"thin_mcatname"=>$thin_mcatname,"thick_mcatname"=>$thick_mcatname,'errormessage'=>$errormessage,'isPMCAT'=>1));
		}else{				
			$this->render('isq_copy_form', array("thin_mcatid"=>$thin_mcatid,"thick_mcatid"=>$thick_mcatid,"resultArr"=>$resultArr,"resultArr1"=>$resultArr1,"cookie_mid"=>$cookie_mid,"user_edit"=>$user_edit,"user_add"=>$user_add,"thin_mcatname"=>$thin_mcatname,"thick_mcatname"=>$thick_mcatname,'errormessage'=>$errormessage));
		}	
	}
 
	public function actionSearchmcatlist()
	{
		$SearchText=isset($_REQUEST['SearchMcat']) ? $_REQUEST['SearchMcat'] : '';
		$act=isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
		if($act =='decode'){
			$this->obj_edit->DECODED_LIST();
		}
		else{
		  $this->obj_edit->MCAT_LIST($SearchText);
		}
	}
}

?>