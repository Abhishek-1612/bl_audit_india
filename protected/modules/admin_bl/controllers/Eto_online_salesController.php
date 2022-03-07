<?php
class Eto_online_salesController extends Controller
{

public function actionIndex()
   {  
if(isset($_REQUEST['bdate_day']) && isset($_REQUEST['bdate_month']) && isset($_REQUEST['bdate_year']))
{
$start_date =$_REQUEST['bdate_day'].'-'.$_REQUEST['bdate_month'].'-'.$_REQUEST['bdate_year'];
}
else{
$start_date='';
}
if(isset($_REQUEST['adate_day']) && isset($_REQUEST['adate_month']) && isset($_REQUEST['adate_year']))
{
$end_date = $_REQUEST['adate_day'].'-'.$_REQUEST['adate_month'].'-'.$_REQUEST['adate_year'];
}
else{
$end_date='';
}
list($Second, $Minute, $Hour, $Day, $Month, $Year) = localtime(time());
foreach (range(1,31) as $x)
{
	if(($x == $Day) && ($x < 10)) 
	{
	$Day = '0'.$x;
	}
	
}
$Year = $Year + 1900;
$Month = $Month + 1;
$cur_date =$Day.'-'.$Month.'-'.$Year;
$daylen = 60*60*24;
$ofr_old_day = 0;
$diff_sded = 0;
if($start_date)
{
	$ofr_old_day = (strtotime($cur_date)-strtotime($start_date))/$daylen;
	$diff_sded = (strtotime($end_date)-strtotime($cur_date))/$daylen;
}
if($ofr_old_day > 1)
{
	 $glEtoModel = new AdminEtoModelForm();
          $dbh = $glEtoModel->connectMeshrDb();
}
else
{
	$dbh = $this->connect_db();
}
  
  
if($dbh)
 {
  $hostname=$_SERVER['SERVER_NAME'];
  $emp_id =Yii::app()->session['empid'];
             if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
			HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else
		{ 
		
                      $obj1=new Eto_online_sales;		    
		   if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'get_rej_rpt')
			{	
				$obj1->showSalesReport($dbh);
			}
	 		else
			{

				$obj1->showSalesForm($dbh);
			}                }
                
   }
   
   }
   
public function connect_db()
{

$db = ""; 
	 $pwd = "";
	 $dbh;

	$_SERVER['MY_COUNTRY'] = $_SERVER['MY_COUNTRY'] or '';
	$username = 'indiamart';
	if($_SERVER['MY_COUNTRY'] == 'INDIA' )
	{
		if($_SERVER['MY_COMPUTERNAME'] == 'SERVER')
		{
			$db = "main";
			$pwd='ref0cl39';
		}
		else
		{
			$username = 'mart';
			$db = "mart";
			$pwd='ref0cl39';
		}
	}

	elseif($_SERVER['MY_COUNTRY'] == 'INDIA2' )
	{
	$db = "main";
	$pwd='ref0cl39';
	} ### ON NET IT SHOULD BE "mesh"

	elseif($_SERVER['MY_COUNTRY'] == 'US' )
	{
	$db = "mesh";
	$pwd='ora926meSh)%';
	} ### ON NET IT SHOULD BE "mesh"

	else
	{
	return 0; 
	}

	if ($dbh = oci_pconnect($username,$pwd,$db))
	{
		return $dbh;
	}
	else
	{
		return 0;
	}

}
   
   
   
 }  