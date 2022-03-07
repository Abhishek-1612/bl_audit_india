<?php
class PblpurcreditController extends Controller
{
     public function actionpbl_pur_credit()
	{	       
		$email='';
		$mid1 = '';
		$gluserID='';
		$glusr_data='';
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
				HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
               else
                   {
                    
                       $_REQUEST['emp_id']= $emp_id;
                       $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                        $_REQUEST['emp_id']=$emp_id;
                        $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                            if(empty($user_permissions))
                            { 
                                $user_permissions['TOEDIT']= '';
                            }

                            
                           
                            $user_view =isset($user_permissions['TOEDIT']) ? $user_permissions['TOEDIT'] : 0;
// 		$_REQUEST['emp_id']=$emp_id;
		$err_msg='';
                $pblpur = new Pblpurcredit;
                $objcon = new Globalconnection();
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $objcon->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $objcon->connect_db_yii('postgress_web68v'); 
                }                                
		if(isset($_REQUEST['action']) && $_REQUEST['action']== 'purchase')
		{
			
			 if(isset($_REQUEST['workorder']))
 			                      $workorder = $_REQUEST['workorder'];
 			                      else
 			                      $workorder = '';
			if($workorder != '')
			{
				//$workorder =~ s/^\s+|\s+$//g;
			       $workorder=trim($workorder, " ");
			}
			if(isset($_REQUEST['scheme']))
 			                     $scheme=$_REQUEST['scheme'];
 			                     else
 			                     $scheme='';
			 if(isset($_REQUEST['rate']))
 			                      $rate = $_REQUEST['rate'];
 			                      else
 			                      $rate = 0;
		        if(isset($_REQUEST['credit_purchase']))
 			                      $credit_purchase =$_REQUEST['credit_purchase'];
 			                      else
 			                      $credit_purchase = 0;
			if(isset($_REQUEST['list_price']))
 			                      $list_price= $_REQUEST['list_price'];
 			                      else
 			                      $list_price= 0;
			 if(isset($_REQUEST['discount']))
 			                     $discount =$_REQUEST['discount'];
 			                     else
 			                     $discount =0;
			if(isset($_REQUEST['total_amount']))
 			                      $total_amount = $_REQUEST['total_amount'];
 			                      else
 			                      $total_amount = 0;
			if(isset($_REQUEST['service_tax']))
 			                      $service_tax = $_REQUEST['service_tax'];
 			                      else
 			                      $service_tax = 0;
			if(isset($_REQUEST['actual_amount']))
 			                      $actual_amount = $_REQUEST['actual_amount'];
 			                      else
 			                      $actual_amount = 0;
                        if(isset($_REQUEST['ref']))
			$ref = $_REQUEST['ref'];
			else
			$ref = '';
			if(isset($_REQUEST['pendOrd']))
			$pendOrd = $_REQUEST['pendOrd'];
			else
			$pendOrd = '';
			if(isset($_REQUEST['abcpId']))
			$abcpId = $_REQUEST['abcpId'];
			else
			$abcpId = '';
			if(isset($_REQUEST['pay_site2']))
			$pay_site = $_REQUEST['pay_site2'];
			else
			$pay_site = 'ETO';
			
			if($workorder == '')
			{
				$err_msg='<font face="arial" size="2" color="RED"> <b>&nbsp;Workorder Should not be blank.</b></font><br>';
			}
			$wo_type='';
			if($workorder)
			{
				 $array_wo = explode("_",$workorder);
				$workorder = $array_wo[0];
				$wo_type = $array_wo[1] or '';
			}

			if($workorder && $wo_type == 'P' && $ref == 'OS') #Online Process
			{
				if($pendOrd == '')
				{
					$err_msg .='<font  face="arial" size="2" color="RED"> <b>&nbsp;You must select Order Id</b></font><br>';
				}
				if($abcpId == '')
				{
					$err_msg .='<font  face="arial" size="2" color="RED"> <b>&nbsp;You must select Payment Gateway Id</b></font><br>';
				}
			}
			else
			{
				if($scheme == '-999')
				{
					$err_msg .='<font  face="arial" size="2" color="RED"> <b>&nbsp;You must select one Scheme.</b></font><br>';
				}
				if($rate == '' || $rate <= 0)
				{
					$err_msg .='<font  face="arial" size="2" color="RED"> <b>&nbsp;Rate Should be greater than zero.</b></font><br>';
				}
				if($credit_purchase == '' || $credit_purchase <= 0)
				{
					$err_msg .='<font  face="arial" size="2" color="RED"> <b>&nbsp;Credit Purchase Should greater than zero.</b></font><br>';
				}
				if($list_price != $rate * $credit_purchase)
				{
					$err_msg .='<font  face="arial" size="2" color="RED"> <b>&nbsp;List Price Should be (Rate x Credit Purchase).</b></font><br>';
				}

				if($actual_amount == '' || ($actual_amount <= 0 && $wo_type == 'P') || ($actual_amount < 0 && $wo_type != 'P'))
				{
					$err_msg .='<font  face="arial" size="2" color="RED"> <b>&nbsp;Actual Amount Should be numeric and Greater than zero.</b></font><br>';
				}
			}

			if($err_msg == '')
			{
				$status=0;
				$custToServErr=0;
				$_REQUEST['workorder']=$workorder;
				if($wo_type == 'P')
				{
					if($ref == 'OS')
					{      	if(isset($_REQUEST['email']))
		                               { $email=$_REQUEST['email'];
		                                  }
		                                   else
		                            { $email='';
		                            }
					if(isset($_REQUEST['comp']))
	                           {
	                           $comp=$_REQUEST['comp'];
	                            }
	                            else $comp='';
					     if(isset($_REQUEST['s_tax_rate']))
 			                     $s_tax_rate=$_REQUEST['s_tax_rate'];
 			                     else
 			                      $s_tax_rate='';
 			                      
 			                      if(isset($_REQUEST['scheme']))
 			                      $scheme=$_REQUEST['scheme'];
 			                      else
 			                      $scheme='';
 			                      if(isset($_REQUEST['workorder']))
 			                      $workorder = $_REQUEST['workorder'];
 			                      else
 			                      $workorder = '';
 			                      if(isset($_REQUEST['purchasedate']))
 			                      $purchasedate = $_REQUEST['purchasedate'];
 			                      else
 			                      $purchasedate = '';
 			                      if(isset($_REQUEST['rate']))
 			                      $rate = $_REQUEST['rate'];
 			                      else
 			                      $rate = '';
 			                      if(isset($_REQUEST['credit_new']))
 			                      $credit_new = $_REQUEST['credit_new'];
 			                      else
 			                      $credit_new = '';
 			                      if(isset($_REQUEST['credit_purchase']))
 			                      $credit_purchase =$_REQUEST['credit_purchase'];
 			                      else
 			                      $credit_purchase = '';
 			                      if(isset($_REQUEST['list_price']))
 			                      $list_price= $_REQUEST['list_price'];
 			                      else
 			                      $list_price= '';
 			                      if(isset($_REQUEST['discount']))
 			                      $discount =$_REQUEST['discount'];
 			                      else
 			                      $discount ='';
 			                      if(isset($_REQUEST['total_amount']))
 			                      $total_amount = $_REQUEST['total_amount'];
 			                      else
 			                      $total_amount = '';
 			                      if(isset($_REQUEST['service_tax']))
 			                      $service_tax = $_REQUEST['service_tax'];
 			                      else
 			                      $service_tax = '';
 			                      if(isset($_REQUEST['actual_amount']))
 			                      $actual_amount = $_REQUEST['actual_amount'];
 			                      else
 			                      $actual_amount = '';
 			                      if(isset($_REQUEST['credit_new']))
 			                      $credit_new = $_REQUEST['credit_new'];
 			                      else
 			                      $credit_new='';
				////////////	
					$data1=array('gluserid'=>$_REQUEST['gluserid'],'workorder'=>$_REQUEST['workorder'],'pendOrd' => $_REQUEST['pendOrd'],'abcpId' => $_REQUEST['abcpId'],'comp'=>$comp,'credit_new' => $credit_new, 'email'=>$email,'s_tax_rate'=>$s_tax_rate,'scheme'=>$scheme,'rate'=>$rate,'purchasedate' =>$purchasedate, 'credit_purchase' =>$credit_purchase,'list_price' => $list_price,'discount' =>$discount,'total_amount' => $total_amount,'service_tax' => $service_tax,'actual_amount' => $actual_amount,'user_view'=>$user_view);
						
					}
					else
					{      
					if(isset($_REQUEST['email']))
		                               { $email=$_REQUEST['email'];
		                                  }
		                                   else
		                            { $email='';
		                            }
					if(isset($_REQUEST['comp']))
	                           {
	                           $comp=isset($_REQUEST['comp'])?$_REQUEST['comp']:'';
	                            }
	                            else
	                            $comp='';
	                            if(isset($_REQUEST['gluserid']))
	                           {
	                           $gluserid=$_REQUEST['gluserid'];
	                            }
	                            else
	                            $gluserid='';
			///////////////////
			if(isset($_REQUEST['s_tax_rate']))
 			                     $s_tax_rate=$_REQUEST['s_tax_rate'];
 			                     else
 			                      $s_tax_rate='';
 			                      
 			                      if(isset($_REQUEST['scheme']))
 			                      $scheme=$_REQUEST['scheme'];
 			                      else
 			                      $scheme='';
 			                      if(isset($_REQUEST['workorder']))
 			                      $workorder = $_REQUEST['workorder'];
 			                      else
 			                      $workorder = '';
 			                      if(isset($_REQUEST['purchasedate']))
 			                      $purchasedate = $_REQUEST['purchasedate'];
 			                      else
 			                      $purchasedate = '';
 			                      if(isset($_REQUEST['rate']))
 			                      $rate = $_REQUEST['rate'];
 			                      else
 			                      $rate = '';
 			                      if(isset($_REQUEST['credit_new']))
 			                      $credit_new = $_REQUEST['credit_new'];
 			                      else
 			                      $credit_new = '';
 			                      if(isset($_REQUEST['credit_purchase']))
 			                      $credit_purchase =$_REQUEST['credit_purchase'];
 			                      else
 			                      $credit_purchase = '';
 			                      if(isset($_REQUEST['list_price']))
 			                      $list_price= $_REQUEST['list_price'];
 			                      else
 			                      $list_price= '';
 			                      if(isset($_REQUEST['discount']))
 			                      $discount =$_REQUEST['discount'];
 			                      else
 			                      $discount ='';
 			                      if(isset($_REQUEST['total_amount']))
 			                      $total_amount = $_REQUEST['total_amount'];
 			                      else
 			                      $total_amount = '';
 			                      if(isset($_REQUEST['service_tax']))
 			                      $service_tax = $_REQUEST['service_tax'];
 			                      else
 			                      $service_tax = '';
 			                      if(isset($_REQUEST['actual_amount']))
 			                      $actual_amount = $_REQUEST['actual_amount'];
 			                      else
 			                       $actual_amount = '';
					     if(isset($_REQUEST['ref']))
			                     $ref = $_REQUEST['ref'];
			                     else
			                       $ref = '';
					
					
					
					
					$data1=array('gluserid'=>$_REQUEST['gluserid'],'name'=>$_REQUEST['name'],'company'=>$_REQUEST['company'],'eml'=>$_REQUEST['eml'],'country'=>$_REQUEST['country'],'state'=>$_REQUEST['state'],'zip'=>$_REQUEST['zip'],'city'=>$_REQUEST['city'],'phone'=>$_REQUEST['phone'],'street'=>$_REQUEST['street'],'designation'=>$_REQUEST['designation'],'fax'=>$_REQUEST['fax'],'workorder'=>$workorder,'scheme'=>$scheme,'rate'=>$rate,'credit_purchase'=>$credit_purchase,'list_price'=>$list_price,'discount'=>$discount,'total_amount'=>$total_amount,'service_tax'=>$service_tax,'actual_amount'=>$actual_amount,'ref'=>$ref,'user_view'=>$user_view);
 						
					}
				}
				else
				{        if(isset($_REQUEST['email']))
		                               { $email=$_REQUEST['email'];
		                                  }
		                                   else
		                            { $email='';
		                            }
					if(isset($_REQUEST['comp']))
	                           {
	                           $comp=$_REQUEST['comp'];
	                            }
	                            else
	                            $comp='';
	                            if(isset($_REQUEST['gluserid']))
	                           {
	                           $gluserid=$_REQUEST['gluserid'];
	                            }
	                            else
	                            $gluserid='';
			///////////////////
			if(isset($_REQUEST['s_tax_rate']))
 			                     $s_tax_rate=$_REQUEST['s_tax_rate'];
 			                     else
 			                      $s_tax_rate='';
 			                      
 			                      if(isset($_REQUEST['scheme']))
 			                      $scheme=$_REQUEST['scheme'];
 			                      else
 			                      $scheme='';
 			                      if(isset($_REQUEST['workorder']))
 			                      $workorder = $_REQUEST['workorder'];
 			                      else
 			                      $workorder = '';
 			                      if(isset($_REQUEST['purchasedate']))
 			                      $purchasedate = $_REQUEST['purchasedate'];
 			                      else
 			                      $purchasedate = '';
 			                      if(isset($_REQUEST['rate']))
 			                      $rate = $_REQUEST['rate'];
 			                      else
 			                      $rate = '';
 			                      if(isset($_REQUEST['credit_new']))
 			                      $credit_new = $_REQUEST['credit_new'];
 			                      else
 			                      $credit_new = '';
 			                      if(isset($_REQUEST['credit_purchase']))
 			                      $credit_purchase =$_REQUEST['credit_purchase'];
 			                      else
 			                      $credit_purchase = '';
 			                      if(isset($_REQUEST['list_price']))
 			                      $list_price= $_REQUEST['list_price'];
 			                      else
 			                      $list_price= '';
 			                      if(isset($_REQUEST['discount']))
 			                      $discount =$_REQUEST['discount'];
 			                      else
 			                      $discount ='';
 			                      if(isset($_REQUEST['total_amount']))
 			                      $total_amount = $_REQUEST['total_amount'];
 			                      else
 			                      $total_amount = '';
 			                      if(isset($_REQUEST['service_tax']))
 			                      $service_tax = $_REQUEST['service_tax'];
 			                      else
 			                      $service_tax = '';
 			                      if(isset($_REQUEST['actual_amount']))
 			                      $actual_amount = $_REQUEST['actual_amount'];
 			                      else
 			                       $actual_amount = '';
			         
			         $data1=array('gluserid'=>$_REQUEST['gluserid'],'name'=>$_REQUEST['name'],'company'=>$_REQUEST['company'],'eml'=>$_REQUEST['eml'],'country'=>$_REQUEST['country'],'state'=>$_REQUEST['state'],'zip'=>$_REQUEST['zip'],'city'=>$_REQUEST['city'],'phone'=>$_REQUEST['phone'],'street'=>$_REQUEST['street'],'designation'=>$_REQUEST['designation'],'fax'=>$_REQUEST['fax'],'workorder'=>$workorder,'scheme'=>$scheme,'rate'=>$rate,'credit_purchase'=>$credit_purchase,'list_price'=>$list_price,'discount'=>$discount,'total_amount'=>$total_amount,'service_tax'=>$service_tax,'actual_amount'=>$actual_amount,'user_view'=>$user_view);
					
				}
				
				if($custToServErr == '')
				{
					if($status>0) {
						$err_msg = '<font  face="arial" size="2" color="BLUE"> <b>&nbsp;'.$status.' Credits alloted successfully.</b></font>'; }
					elseif($status == -1) {
						$err_msg = '<font  face="arial" size="2" color="BLUE"> <b>&nbsp;Work Order Updated successfully.</b></font>'; }
					elseif($status == -2) {
						$err_msg = '<font  face="arial" size="2" color="BLUE"> <b>&nbsp;Work Order already exists</b></font>'; }
				}
				else
				{
				        $errMsg = 'while Customer to Service Id is not Updated.';
					if($status>0) {
						$err_msg = '<font face="arial" size="2" color="BLUE"> <b>&nbsp;'.$status.' Credits allocated successfully,'. $errMsg.'</b></font>'; }
					elseif($status == -1) {
						$err_msg = '<font  face="arial" size="2" color="BLUE"> <b>&nbsp;Work Order Updated successfully,'. $errMsg.'</b></font>'; }
				}

				if($err_msg)
				{       $_REQUEST['action']='';
					//$_REQUEST['action_s']='';
					$_REQUEST['email']='';
					$_REQUEST['gluserid']='';
					$_REQUEST['comp']='';
				/////////////////////////////
				if(isset($_REQUEST['s_tax_rate']))
 			                     $s_tax_rate=$_REQUEST['s_tax_rate'];
 			                     else
 			                      $s_tax_rate='';
 			                      
 			                      if(isset($_REQUEST['scheme']))
 			                      $scheme=$_REQUEST['scheme'];
 			                      else
 			                      $scheme='';
 			                      if(isset($_REQUEST['workorder']))
 			                      $workorder = $_REQUEST['workorder'];
 			                      else
 			                      $workorder = '';
 			                      if(isset($_REQUEST['purchasedate']))
 			                      $purchasedate = $_REQUEST['purchasedate'];
 			                      else
 			                      $purchasedate = '';
 			                      if(isset($_REQUEST['rate']))
 			                      $rate = $_REQUEST['rate'];
 			                      else
 			                      $rate = '';
 			                      if(isset($_REQUEST['credit_new']))
 			                      $credit_new = $_REQUEST['credit_new'];
 			                      else
 			                      $credit_new = '';
 			                      if(isset($_REQUEST['credit_purchase']))
 			                      $credit_purchase =$_REQUEST['credit_purchase'];
 			                      else
 			                      $credit_purchase = '';
 			                      if(isset($_REQUEST['list_price']))
 			                      $list_price= $_REQUEST['list_price'];
 			                      else
 			                      $list_price= '';
 			                      if(isset($_REQUEST['discount']))
 			                      $discount =$_REQUEST['discount'];
 			                      else
 			                      $discount ='';
 			                      if(isset($_REQUEST['total_amount']))
 			                      $total_amount = $_REQUEST['total_amount'];
 			                      else
 			                      $total_amount = '';
 			                      if(isset($_REQUEST['service_tax']))
 			                      $service_tax = $_REQUEST['service_tax'];
 			                      else
 			                      $service_tax = '';
 			                      if(isset($_REQUEST['actual_amount']))
 			                      $actual_amount = $_REQUEST['actual_amount'];
 			                      else
 			                      $actual_amount = '';
 				$data1=array('action'=>$_REQUEST['action'],'email'=>$_REQUEST['email'],'err_msg'=>$err_msg,'gluserid'=>$_REQUEST['gluserid'],'comp'=>$_REQUEST['comp'],'emp_id' => $_REQUEST['emp_id'],'workorder' =>$workorder,'credit_new' => $credit_new,
			's_tax_rate'=>$s_tax_rate,'scheme'=>$scheme,'rate'=>$rate,'purchasedate' =>$purchasedate, 'credit_purchase' =>$credit_purchase,'list_price' => $list_price,'discount' =>$discount,'total_amount' => $total_amount,'service_tax' => $service_tax,'actual_amount' => $actual_amount,'user_view'=>$user_view
			);
			$pblpur->showNewPurchaseForm1($dbh,$data1);
		
			}
			}
			else
			{
				$_REQUEST['action']='detail';
				if(isset($_REQUEST['email']))
		                               { $email=$_REQUEST['email'];
		                                  }
		                                   else
		                            { $email='';
		                            }
					if(isset($_REQUEST['comp']))
	                           {
	                           $comp=$_REQUEST['comp'];
	                            }
	                            else
	                            $comp='';
	                            if(isset($_REQUEST['gluserid']))
	                           {
	                           $gluserid=$_REQUEST['gluserid'];
	                            }
	                            else
	                            $gluserid='';
			///////////////////
			if(isset($_REQUEST['s_tax_rate']))
 			                     $s_tax_rate=$_REQUEST['s_tax_rate'];
 			                     else
 			                      $s_tax_rate='';
 			                      
 			                      if(isset($_REQUEST['scheme']))
 			                      $scheme=$_REQUEST['scheme'];
 			                      else
 			                      $scheme='';
 			                      if(isset($_REQUEST['workorder']))
 			                      $workorder = $_REQUEST['workorder'];
 			                      else
 			                      $workorder = '';
 			                      if(isset($_REQUEST['purchasedate']))
 			                      $purchasedate = $_REQUEST['purchasedate'];
 			                      else
 			                      $purchasedate = '';
 			                      if(isset($_REQUEST['rate']))
 			                      $rate = $_REQUEST['rate'];
 			                      else
 			                      $rate = '';
 			                      if(isset($_REQUEST['credit_new']))
 			                      $credit_new = $_REQUEST['credit_new'];
 			                      else
 			                      $credit_new = '';
 			                      if(isset($_REQUEST['credit_purchase']))
 			                      $credit_purchase =$_REQUEST['credit_purchase'];
 			                      else
 			                      $credit_purchase = '';
 			                      if(isset($_REQUEST['list_price']))
 			                      $list_price= $_REQUEST['list_price'];
 			                      else
 			                      $list_price= '';
 			                      if(isset($_REQUEST['discount']))
 			                      $discount =$_REQUEST['discount'];
 			                      else
 			                      $discount ='';
 			                      if(isset($_REQUEST['total_amount']))
 			                      $total_amount = $_REQUEST['total_amount'];
 			                      else
 			                      $total_amount = '';
 			                      if(isset($_REQUEST['service_tax']))
 			                      $service_tax = $_REQUEST['service_tax'];
 			                      else
 			                      $service_tax = '';
 			                      if(isset($_REQUEST['actual_amount']))
 			                      $actual_amount = $_REQUEST['actual_amount'];
 			                      else
 			                      $actual_amount = '';
			////////////////////
			$data1=array('action'=>$_REQUEST['action'],'email'=>$email,'gluserid'=>$gluserid,'comp'=>$comp,'emp_id' => $_REQUEST['emp_id'],'workorder' =>$workorder,'credit_new' => $credit_new,'err_msg'=>$err_msg,
			's_tax_rate'=>$s_tax_rate,'scheme'=>$scheme,'rate'=>$rate,'purchasedate' =>$purchasedate, 'credit_purchase' =>$credit_purchase,'list_price' => $list_price,'discount' =>$discount,'total_amount' => $total_amount,'service_tax' => $service_tax,'actual_amount' => $actual_amount,'user_view'=>$user_view
			);	$pblpur->showNewPurchaseForm1($dbh,$data1);
			}
		}
		else
		{
			echo '543'; 
			if(isset($_REQUEST['email']) && $_REQUEST['email'] == '' && isset($_REQUEST['gluserid']) && $_REQUEST['gluserid'] == '' &&  isset($_REQUEST['comp']) && $_REQUEST['comp'] == '')
			{
				$err_msg='<font  face="arial" size="2" color="RED"> <b>&nbsp;Please enter any one of the E-Mail ID, Gluser ID or Company</b></font>';
				if (isset($_REQUEST['action']))
				{$_REQUEST['action']='';
				}
			}
			elseif(isset($_REQUEST['email']) && $_REQUEST['email'] != '' && isset($_REQUEST['gluserid']) && $_REQUEST['gluserid'] != '' && isset($_REQUEST['comp']) && $_REQUEST['comp'] != '')
			{
				$err_msg='<font  face="arial" size="2" color="RED"> <b>&nbsp;Enter any one of the options.</b></font>';
				if (isset($_REQUEST['action']))
				{$_REQUEST['action']='';
				}
			}//$_REQUEST['gluserid'] =~ /\D+/
			elseif(isset($_REQUEST['gluserid']) && preg_match("/\D+/",$_REQUEST['gluserid']))
			{
				$err_msg='<font  face="arial" size="2" color="RED"> <b>&nbsp;GlUser ID should be Numeric</b></font>';
				if (isset($_REQUEST['action']))
				{$_REQUEST['action']='';
				}
			}   
			
			//showNewPurchaseForm1(__FILE__, __LINE__, $q,$dbh,$err_msg);
		               if(!isset($_REQUEST['action_s']))
		               {if(isset($_REQUEST['email']))
		                 { $email=$_REQUEST['email'];
		                 }
		                 else
		                 { $email='';
		                 }
	                         if(isset($_REQUEST['gluserid']))
	                         {
	                         $gluserID=$_REQUEST['gluserid'];
	                         }
	                         else
	                         {
	                          $gluserID= '';	                          
	                          }
	                           if(isset($_REQUEST['comp']))
	                           {
	                           $comp=$_REQUEST['comp'];
	                            }
	                            else $comp='';
	                            $data=array('email'=>$email,'gluserid'=>$gluserID,'comp'=>$comp,'user_view'=>$user_view);
								echo '588'; 
 			             $this->render('pblpurcredit1',array('data'=>$data));
 			          }
 			          else {
 			                      $_REQUEST['action']='detail';
 			                     if(isset($_REQUEST['s_tax_rate']))
 			                     $s_tax_rate=$_REQUEST['s_tax_rate'];
 			                     else
 			                      $s_tax_rate='';
 			                      
 			                      if(isset($_REQUEST['scheme']))
 			                      $scheme=$_REQUEST['scheme'];
 			                      else
 			                      $scheme='';
 			                      if(isset($_REQUEST['workorder']))
 			                      $workorder = $_REQUEST['workorder'];
 			                      else
 			                      $workorder = '';
 			                      if(isset($_REQUEST['purchasedate']))
 			                      $purchasedate = $_REQUEST['purchasedate'];
 			                      else
 			                      $purchasedate = '';
 			                      if(isset($_REQUEST['rate']))
 			                      $rate = $_REQUEST['rate'];
 			                      else
 			                      $rate = '';
 			                      if(isset($_REQUEST['credit_new']))
 			                      $credit_new = $_REQUEST['credit_new'];
 			                      else
 			                      $credit_new = '';
 			                      if(isset($_REQUEST['credit_purchase']))
 			                      $credit_purchase =$_REQUEST['credit_purchase'];
 			                      else
 			                      $credit_purchase = '';
 			                      if(isset($_REQUEST['list_price']))
 			                      $list_price= $_REQUEST['list_price'];
 			                      else
 			                      $list_price= '';
 			                      if(isset($_REQUEST['discount']))
 			                      $discount =$_REQUEST['discount'];
 			                      else
 			                      $discount ='';
 			                      if(isset($_REQUEST['total_amount']))
 			                      $total_amount = $_REQUEST['total_amount'];
 			                      else
 			                      $total_amount = '';
 			                      if(isset($_REQUEST['service_tax']))
 			                      $service_tax = $_REQUEST['service_tax'];
 			                      else
 			                      $service_tax = '';
 			                      if(isset($_REQUEST['actual_amount']))
 			                      $actual_amount = $_REQUEST['actual_amount'];
 			                      else
 			                      $actual_amount = '';
								   echo '642'; 
				                $data1=array('action'=>$_REQUEST['action'],'email'=>$_REQUEST['email'],'gluserid'=>$_REQUEST['gluserid'],'comp'=>$_REQUEST['comp'],'s_tax_rate'=>$s_tax_rate,'err_msg'=>'','emp_id'=>$emp_id,'scheme'=>$scheme,'workorder' => $workorder,'purchasedate' => $purchasedate,'rate' => $rate,'credit_new' => $credit_new,'credit_purchase' => $credit_purchase,'list_price' => $list_price,'discount' =>$discount,'total_amount' => $total_amount,'service_tax' => $service_tax,'actual_amount' => $actual_amount,'emp_id' => $_REQUEST['emp_id'],'user_view'=>$user_view);
				                $pblpur->showNewPurchaseForm1($dbh,$data1);
				   }
		}
	}
}

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////