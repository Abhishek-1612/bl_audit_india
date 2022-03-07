<table style="background-color: #FFFFFF;width: 1300px;">
<tr>
    <td width = "90%" align="left" height="30" style="font-family:arial;font-size:14px;font-weight:bold;">
        <?php 
                $start = $request->getParam('start',1);
		$end = $request->getParam('end',5000);
		$start_date = $request->getParam('start_date','');
		$end_date = $request->getParam('end_date','');
		$modid = $request->getParam('modid','');
		$source = $request->getParam('source','A');
		$vendor = $request->getParam('vendor','ALL');
		$start_time=$request->getParam('start_time',0);
		$end_time=$request->getParam('end_time',24);
		$employeeID = $request->getParam('employeeID',0);
		$tlid = $request->getParam('tlid',0);
		$in_flag = $request->getParam('in_flag',0);
		$totalRecords = intval($request->getParam('total_records')); 
		
        if($totalRecords > 0){                               						
                 $total_pg=ceil($totalRecords/5000);
                 $nextStart=1;
                 $nextEnd=5000;
                 for($i=1;$i<=$total_pg;$i++){                                                    
                    echo '<div><a class="pagina" href="http://'.$_SERVER['SERVER_NAME'].'/index.php?r=admin_eto/AdminEto/autodashboard&mid=3443&action=export&total_records='.$totalRecords.'&start_date='.$start_date.'&end_date='.$end_date.'&vendor='.$vendor.'&source='.$source.'&employeeID='.$employeeID.'&start_time='.$start_time.'&end_time='.$end_time.'&tlid='.$tlid.'&in_flag='.$in_flag.'&start='.$nextStart.'&end='.$nextEnd.'"&mid=3443> Download Excel ( Page '.$i.' )</a></div><br>';
                    $nextStart=$nextStart+5000;
                    $nextEnd=$nextEnd + 5000;
                 }
        }
        ?>
    </td></tr>
		</table>


