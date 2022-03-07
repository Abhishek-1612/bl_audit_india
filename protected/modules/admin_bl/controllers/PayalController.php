<?php
class PayalController extends BlController
{
	
	public function actionIilMasterFlag()
	{
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
                          HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else
		{
			$tabledata='';
			$model=new iilMasterFlagReport();
			$dataDDL=$model->getDDL();
			if(isset($_REQUEST['tablename']))
			{
				$tabledata=$model->getdata($_REQUEST['tablename']);
			}
			$this->render('iilMasterFlag',array('dataDDL'=>$dataDDL,'tabledata'=>$tabledata));

		}
	}
	public function actionIilMasterDataFill()
	{
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
				HREF=\"http://gladmin.intermesh.net\" target=\"_top\">login</A><BR>";
		}
		else
		{
			$errorMsg='';
			$model=new iilMasterDataFillReport($_REQUEST);
			$empName=$model->getEmpName($emp_id);
			$dataDDL=$model->getDDL();
			if($_REQUEST)
			{
				if(isset($_REQUEST['iilMasterDataTypeSubmit']))
				{
					if(strlen($_REQUEST['iilMasterDataTypeTableName'])<=0)
						{$errorMsg.="TABLE NAME cannot be empty!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeTableName'])>500)
						{$errorMsg.="TABLE NAME exceeded Length!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeColumnName'])<=0)
						{$errorMsg.="COLUMN NAME cannot be empty!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeColumnName'])>30)
						{$errorMsg.="COLUMN NAME exceeded Length!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeComment'])<=0)
						{$errorMsg.="COMMENT Required!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeComment'])>30)
						{$errorMsg.="COMMENT exceeded Length!(max 30)<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeSelect'])<=0)
						{$errorMsg.="TYPE can't be blank!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeDesc'])>4000)
						{$errorMsg.="DESCRIPTION exceeded Length!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeUsage'])>4000)
						{$errorMsg.="USAGE exceeded Length!<br>\n";}
					else
						{$model->insertTableData($empName);}
				}
				if(isset($_REQUEST['iilMasterDataSubmit']))
				{
					if(strlen($_REQUEST['iilMasterDataValue'])<=0)
						{$errorMsg.="FLAG VALUE cannot be empty!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataValue'])>30)
						{$errorMsg.="FLAG VALUE exceeded Length!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataValuetext'])<=0)
						{$errorMsg.="FLAG VALUE TEXT cannot be empty!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataValuetext'])>100)
						{$errorMsg.="FLAG VALUE TEXT exceeded Length!<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataDesc'])>200)
						{$errorMsg.="COMMENT exceeded Length!<br>\n";}
					else
						{$model->insertFlagsData($empName);}
				}
			}
			$this->render('iilMasterDataFill',array('errorMsg'=>$errorMsg,'dataDDL'=>$dataDDL));

		}
	}
	public function actionIilMasterDataUpdate()
	{
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
				HREF=\"http://gladmin.intermesh.net\" target=\"_top\">login</A><BR>";
		}
		else
		{
			$errorMsg='';
			$recfetch='';
			$recfetch2='';
			$sthfetch1='';
			$REC='';
			$model=new iilMasterDataUpdateReport($_REQUEST);
			$dataDDL=$model->getDDL();
			if($_REQUEST)
			{
				if(isset($_REQUEST['iilMasterDataTypeUpdate']))
				{
					if(strlen($_REQUEST['iilMasterDataTypeComment'])<=0)
						{$errorMsg.="COMMENT Required<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeComment'])>30)
						{$errorMsg.="COMMENT exceeded Length(max 30)<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeSelect'])<=0)
						{$errorMsg.="Please Select a TYPE<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeDesc'])>4000)
						{$errorMsg.="DESCRIPTION exceeded Length<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataTypeUsage'])>4000)
						{$errorMsg.="USAGE exceeded Length<br>\n";}
					else
						{ $model->updateTableData(); }
				}
				elseif(isset($_REQUEST['iilMasterDataUpdate']))
				{
					if(strlen($_REQUEST['iilMasterFlagDataSelectFV'])<=0)
						{$errorMsg.="FLAG VALUE cannot be empty<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataValue'])>30)
						{$errorMsg.="FLAG VALUE exceeded Length<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataValuetext'])<=0)
						{$errorMsg.="FLAG VALUE COMMENT cannot be empty<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataValuetext'])>100)
						{$errorMsg.="FLAG VALUE COMMENT exceeded Length<br>\n";}
					elseif(strlen($_REQUEST['iilMasterDataDesc'])>200)
						{$errorMsg.="FLAG DESCRIPTION exceeded Length<br>\n";}
					else
						{ $model->updateFlagsData(); }
				}
				elseif(isset($_REQUEST['iilMasterFetch']))
				{

					list($recfetch,$sthfetch1)=$model->fetchAll();

				}
				elseif(isset($_REQUEST['iilMasterDataShow']))
				{
					list($REC,$recfetch2,$sthfetch1)=$model->showFlags();
				}
			}
			else
			{
				print "1234567890";
			}
			$this->render('iilMasterDataUpdate',array('errorMsg'=>$errorMsg,'dataDDL'=>$dataDDL,'recfetch'=>$recfetch,'sthfetch1'=>$sthfetch1,'REC'=>$REC,'recfetch2'=>$recfetch2));
		}
	}
	
	public function actionEtoTestGlusr()
	{
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
                          HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else
		{
			
			$this->render('etoTestGlusr');

		}
	}
	public function actionshowGluserTransForm()
	{
		
		$dbmodel = new BLGlobalmodelForm();
                $dbh = $dbmodel->connect_db();
		
		$emp_id = Yii::app()->session['empid'];
		
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
				HREF=\"http://gladmin.intermesh.net\" target=\"_top\">login</A><BR>";
		}
		else
		{
			
			if(!empty($_REQUEST['action'] ))
			{
				
				if($_REQUEST['action'] == 'transDetails' || $_REQUEST['action'] == 'purchaselimit' )
				{
					
					//echo "1";
					if(!empty($_REQUEST))
					{
					//print_r($_REQUEST);
					$glusrid=(!empty($_REQUEST['glusrid']))? $_REQUEST['glusrid'] :0;
					$email=(!empty($arr['email']))? $arr['email']: '';
					$action=$_REQUEST['action'];
					$modeltf=new TransactionReport;
					//$usg_typ = $modeltf->usg_typ($dbh,$glusrid);
						if($_REQUEST['action'] == 'purchaselimit')
						{
							$_REQUEST['checkbox']=array();
 							$_REQUEST['checkbox'][0]='Credit Alloc';
							$_REQUEST['checkbox'][1]='BL Purchased';
							$_REQUEST['checkbox'][2]='Credit Lapse';
							
						}
						if(!empty($_REQUEST['checkbox']))
						{
						
						list($trans_data,$glusr_data,$rec,$usg_typ)=$modeltf->transdetails($_REQUEST,$dbh);
						//echo "chk box exist";print_r($glusr_data);
						if($glusr_data==0)				
						{
						  $this->render('showGluserTransForm',array('checkbox'=>$_REQUEST['checkbox'],'glusrid'=>$glusrid,'email'=>$email,'glusr_data'=>$glusr_data));
						}
						//$trans_data=$modeltf->transdetails($_REQUEST,$dbh);
						//echo "controller data<br>";print_r($trans_data);
						//echo "<br>controller glusr data";print_r($glusr_data)
						else{$this->render('showGluserTransForm',array('checkbox'=>$_REQUEST['checkbox'],'action'=>$action,'email'=>$email,'glusrid'=>$glusrid,'trans_data'=>$trans_data,'glusr_data'=>$glusr_data,'rec'=>$rec,'usg_typ'=>$usg_typ));}	
						//echo "1a";
						}
						else
						{
						$_REQUEST['checkbox'][0]='All';//for clause in query
						
						//$modeltf=new TransactionReport;
						list($trans_data,$glusr_data,$rec,$usg_typ)=$modeltf->transdetails($_REQUEST,$dbh);
						$_REQUEST['checkbox'][0]='';// for invisible on ui
						//echo "chk box notexist";print_r($glusr_data);
						if($glusr_data==0)				
						{
						  $this->render('showGluserTransForm',array('checkbox'=>$_REQUEST['checkbox'],'glusrid'=>$glusrid,'email'=>$email,'glusr_data'=>$glusr_data));
						}
						else{$this->render('showGluserTransForm',array('action'=>$action,'email'=>$email,'glusrid'=>$glusrid,'trans_data'=>$trans_data,'glusr_data'=>$glusr_data,'rec'=>$rec,'usg_typ'=>$usg_typ));}
						//echo "1b";
						}
						
					
					}
					else
					{
						//echo "1Aa";
						$this->render('showGluserTransForm',array('checkbox'=>'','action'=>'','email'=>'','glusrid'=>''));
					}
				}
			
				if($_REQUEST['action'] == 'purchasers_email')
				{
					//echo "2";
					if(!empty($_REQUEST))
					{
						//print_r($_REQUEST);
						$email1=$_REQUEST['email1'];
						$action=$_REQUEST['action'];
						//$purchaseDetails=array();
						$modelpe=new TransactionReport;
						$purchaseDetails=$modelpe->purchaseDetailsviaemail($_REQUEST,$dbh);
															
						$this->render('showGluserTransForm',array('action'=>$action,'email1'=>$email1,'purchaseDetails'=>$purchaseDetails));	
						//echo "1a";
// 						$this->render('showGluserTransForm',array('action'=>$action,'email1'=>$email1));
					//echo "2a";
					}
					else
					{
						$this->render('showGluserTransForm',array('action'=>$action,'email1'=>''));
					//echo "2b";
					}
				
				}

				if($_REQUEST['action'] == 'purchasers')
				{
					//echo "3";
					if(!empty($_REQUEST))
					{
						//print_r($_REQUEST);
						$offer=$_REQUEST['offer'];
						$action=$_REQUEST['action'];
						$modelpe=new TransactionReport;
						$purchasers=$modelpe->purchaseDetails($dbh,$offer,$_REQUEST,'');
						//echo "offer search\n";print_r($purchaseDetails);
						$this->render('showGluserTransForm',array('action'=>$action,'offer'=>$offer,'purchasers'=>$purchasers));
					//	echo "3a";
					}
					else
					{
						$this->render('showGluserTransForm',array('action'=>$action,'offer'=>''));
					//      echo "3B";
					}
				}

				if($_REQUEST['action'] == 'purdetails')
				{
					//echo "4";
					if(!empty($_REQUEST))
					{
						//print_r($_REQUEST);
						$gl_id= $_REQUEST['gl_id'];
	 					$days = $_REQUEST['fromdays'];
						$action=$_REQUEST['action'];
						$ob = new TransactionReport;
						list($leaddata,$loginUserDet)= $ob->leadpurchaseDetails($_REQUEST,$dbh,$gl_id,$days);
						//echo "leaddata";print_r($leaddata);exit;
						//echo $loginUserDet;
						if(empty($leaddata))
						{
							$this->render('showGluserTransForm',array('leaddata'=>1));
						}
						else
						{
							$this->render('showGluserTransForm',array('action'=>$action,'gl_id'=>$gl_id,'leaddata'=>$leaddata,'loginUserDet'=>$loginUserDet));
						}
					// echo "4a";
					}
					else
					{
						$this->render('showGluserTransForm',array('action'=>$action,'gl_id'=>''));
					// echo "4B";
					}
					
				}
			}
			else
			{
				$this->render('showGluserTransForm');
			}		
		}
	}
	public function actionadminContact()
	{
		$this->render('adminContact');
	}
	public function actionBLCommonReport()
	{
		$model	= new BLGlobalmodelForm;
		$dbh	= $model->connect_oracledb('meshr');
		if(!empty($_REQUEST) && !empty($_REQUEST['glusr_submit']))
		{
		//echo "in cntroller";print_r($_REQUEST);exit;
			$ob 		= new CommonReportModel;
			$leadsummary	= $ob->lead_summary($_REQUEST,$dbh);
			$leadApproval	= $ob->lead_approval($_REQUEST,$dbh);
			$leadExpired	= $ob->lead_expired($_REQUEST,$dbh);
			$nosupplier	= $ob->Nosupplier($_REQUEST,$dbh);
			list($emailverify,$verify_call,$enrichcall)	= $ob->leadVerify($_REQUEST,$dbh);
			{$this->render('BLCommonReport',array('leadsummary'=>$leadsummary,'leadApproval'=>$leadApproval,'leadExpired'=>$leadExpired,'nosupplier'=>$nosupplier,'emailverify'=>$emailverify,'verify_call'=>$verify_call,'enrichcall'=>$enrichcall));}
		}
		else
		{
			$this->render('BLCommonReport');
		}
	}
	public function actionetoLeadQuality()
	{
		$this->render('etoLeadQuality');
	}
	public function actionuserinfo()
	{
		$this->render('userinfo');
	}	
}
