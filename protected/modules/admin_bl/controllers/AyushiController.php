<?php
class AyushiController extends BlController
{
public function actionshowPendingLimit(){

$fetch_cnt=0;
if(!empty($_REQUEST['ajax'])){
$fromdate=$_REQUEST['fromdate'];
$todate=$_REQUEST['todate'];
$status=$_REQUEST['status'];
$fetch_cnt=$_REQUEST['fetch_cnt'];
$ob = new PendingLimit; 
$arr = $ob->pendinglimits($fromdate,$todate,$status,$fetch_cnt);
$data=$arr[0];
$result='';
$count=$fetch_cnt*50 + 1;
foreach($data as $rec)
{
$rec['ETO_BL_PUR_STATUS'] = ($rec['ETO_BL_PUR_STATUS'] == 1) ? 'Done' : '<font color="#ff0000">WIP</font>';
  echo '<tr><td class="intd" width="100px" style="text-align:center;">'.$count.'</td>
                <td class="intd" width="100px" style="text-align:center;">
                <a href="eto-bl-pur-limit.mp?action=detail&gluserid='.$rec['FK_GLUSR_USR_ID'].'" target="blank">'.$rec['FK_GLUSR_USR_ID'].'</td>
                <td class="intd" width="100px" style="text-align:center;">'. $rec['ETO_BL_PUR_COUNT'].'</td>
                <td class="intd" width="100px" style="text-align:center;">'. $rec['ETO_BL_PUR_OFR_ID'];
 if($rec['ETO_BL_PUR_LEAD_TYPE'] == 'T')
{ echo '<font color="RED"><sub>Tender</sub></font>';
}
 echo '</td>
                <td class="intd" width="100px" style="text-align:center;">'.$rec['ETO_BL_PUR_MOD_ID'].'</td>
                <td class="intd" width="100px" style="text-align:center;">'.$rec['ETO_BL_PUR_DATE_DISP'].'</td>
                <td class="intd" width="100px" style="text-align:center;">'.$rec['ETO_BL_PUR_STATUS'].'</td></tr>';

$count++;
}
return;
}
if(!empty($_REQUEST['fromdate']) && !empty($_REQUEST['todate'])){
$fromdate=$_REQUEST['fromdate'];
$todate=$_REQUEST['todate'];
$status= (!empty($_REQUEST['status']))?$_REQUEST['status']:'pending';
$ob = new PendingLimit;
$arr = $ob->pendinglimits($fromdate,$todate,$status,$fetch_cnt);
$rec=$arr[0];
$rec1=$arr[1];
$this->render('showPendingLimit',array('data'=>$rec,'status'=>$status,'total_rec'=>$rec1,'fromdate'=>$fromdate,'todate'=>$todate));
}
else{ 
$ob = new PendingLimit;
$status= (!empty($_REQUEST['status']))?$_REQUEST['status']:'pending';
$arr = $ob->pendinglimits('','',$status,'');
$rec=$arr[0];
$rec1=$arr[1];
$this->render('showPendingLimit',array('data'=>$rec,'status'=>$status,'total_rec'=>$rec1,'fromdate'=>'','todate'=>''));
}
}

public function actioneto_rej_ofr()
{
if(!empty($_REQUEST['gl_ofr_id']))
{//model
$id = $_REQUEST['gl_ofr_id'];
$detail=$_REQUEST['detail'];
$ob = new RejectionReport;
$arr = $ob->rejreport($id,$detail);
if($detail==1)
$this->render('eto_rej_ofr',array('REQUEST'=>$_REQUEST,'rec'=>$arr[0],'rec1'=>$arr[1],'rec2'=>$arr[2],'rec3'=>$arr[3],'rec4'=>$arr[4]));
else
$this->render('eto_rej_ofr',array('REQUEST'=>$_REQUEST,'rec'=>$arr[0]));
}
else
{
$this->render('eto_rej_ofr');
}
}

public function actionpush_not()

{
$this->render('push_not');
}

}
