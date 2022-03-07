<?php
class PendingLimit  extends CFormModel
{


	public function pendinglimits($fromdate,$todate,$status,$fetch_cnt)
	{
		$dbmodel = new BLGlobalmodelForm;
		$dbh = $dbmodel->connect_db();
		$limit=50;
		$rec1=0;
		if($fetch_cnt){
			$start=($fetch_cnt*$limit)+1;
			$end=$start+$limit-1;
		}

		else
		{
			$start=1;
			$end=50;
		}


		$subquery='';
		if($status)
		{
			if($status =='done')
				$subquery=' and ETO_BL_PUR_STATUS=1';
			else if($status == 'pending')
				$subquery=' and ETO_BL_PUR_STATUS=0';
		}


		if($fromdate && $todate)
		{

			$fromdate= preg_replace('/\//','-',$fromdate);
			$todate=preg_replace('/\//','-',$todate);
			$subquery.=" and trunc(ETO_BL_PUR_DATE)>=TO_DATE(:FROMDATE,'DD-MM-YYYY') and trunc(ETO_BL_PUR_DATE)<=TO_DATE(:TODATE,'DD-MM-YYYY')";
		}



		$sql=" SELECT outer.* FROM (SELECT ROWNUM rn, inner.*
			FROM (SELECT FK_GLUSR_USR_ID, ETO_BL_PUR_COUNT, ETO_BL_PUR_OFR_ID, ETO_BL_PUR_MOD_ID, 
					ETO_BL_PUR_LEAD_TYPE, ETO_BL_PUR_CLIENT_IP, ETO_BL_PUR_IP_COUNTRY, ETO_BL_PUR_IP_CITY,
					TO_CHAR(ETO_BL_PUR_DATE, 'dd Mon, yyyy HH24:MI:SS') ETO_BL_PUR_DATE_DISP,
					TO_CHAR(ETO_BL_PUR_UPDATED, 'dd Mon, yyyy HH24:MI:SS') ETO_BL_PUR_UPDATED, ETO_BL_PUR_STATUS 
					FROM ETO_BL_PUR_LIMIT_PEND where 1=1 $subquery ORDER BY ETO_BL_PUR_DATE DESC) inner) outer
					WHERE outer.rn >= $start AND outer.rn <= $end";

		$sql_rslt = $dbh->createCommand($sql);

		if($fromdate && $todate){

			$sql_rslt->bindValue(':FROMDATE',$fromdate);
			$sql_rslt->bindValue(':TODATE',$todate);
		}

		$dataReader=$sql_rslt->query();
		$rec=$dataReader->readAll();


		if(empty($fetch_cnt)){

			$sql1="select count(1) as total from ETO_BL_PUR_LIMIT_PEND where 1=1 $subquery";
			$sql_rslt = $dbh->createCommand($sql1);


			if($fromdate && $todate){

				$sql_rslt->bindValue(':FROMDATE',$fromdate);
				$sql_rslt->bindValue(':TODATE',$todate);
				//echo "$fromdate $todate";
			}

			$dataReader=$sql_rslt->query();
			$rec1=$dataReader->readAll(); 
			//                $total_count=$rec1->{'TOTAL';
			//echo "model";print_r($rec);

		}

		return array($rec,$rec1);
		}}
?>
