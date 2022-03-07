<?php

class Buyerfunnel_reportController extends Controller
{
public function actionIndex()
{
//   $dbh = oci_connect('indiamart','cas212clkstm','cassendra');
 $dbh1=oci_connect('indiamart','ora926meSh)%','mesh');

if(!empty($_REQUEST['action']) && $_REQUEST['action'] == 'getbuyerfunnelreport')
			{
 				$todate= trim($_REQUEST['todate']);
 				$fromdate = trim($_REQUEST['fromdate']);
				$this->render('buyerfunnel_view_reprt',array('todate'=>$todate,'fromdate'=>$fromdate));
			}
			else
			{
				$this->render('buyerfunnel_view',array());
			}

}
}
?>