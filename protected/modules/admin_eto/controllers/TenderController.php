<?php

class TenderController extends Controller
{   	
public function actionSearch() 
{       
        $emp_id = Yii::app()->session['empid'];
        if($emp_id>0){
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        
		$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}
		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		if($user_view ==1)
		{
		  $rec=$rec_det=array();
		  $obj =new TenderModel;		
                   if(isset($_REQUEST['search']))
                   {                         
                      $rec_det=$obj->tender_details(); 
                      $rec=$obj->search();                      
                   }$this->render('/admineto/tendersearch',array('rec_det'=>$rec_det,'rec'=>$rec));                
                   }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                }    
        }else{
            echo "You are not logged in";
            exit;
        } 
}
  public function actionPurchaseTender() 
{       
        $emp_id = Yii::app()->session['empid'];
        if($emp_id>0){
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';        
		$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}
		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		if($user_view==1)
		{
                    $rec_det=array();
                    $obj =new TenderModel;		
                     if(isset($_REQUEST['tid']))
                     {  
                        $rec_det=$obj->tender_purdetails(); 
                     }
                     $this->render('/admineto/pur_tender',array('rec'=>$rec_det));                
                   }else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                   }    
        }else{
            echo "You are not logged in";
            exit;
        } 
}   
}