<?php

if (isset($_REQUEST['report']) && ($_REQUEST['report'] == 'detailed'))
     {
     
     echo $html;
     }
elseif (isset($_REQUEST['report']) && $_REQUEST['report'] == 'summary')
     {
     $cnt = 0;
     $cnt_IN = 0;
     $cnt_FN = 0;
     $opening_reason = array();
     $closing_reason = array();
     $ofrcount_verified = array();
     $ofrcount_updated = array();
     $ofrcount_notverified = array();
     $tot_lead_deleted = 0;
     $tot_lead_deleted_IN = 0;
     $tot_lead_deleted_FN = 0;
     $tot_leadnotdeleted = 0;
     $tot_leadnotdeleted_IN = 0;
     $tot_leadnotdeleted_FN = 0;
     $tot_credit_reversed = 0;
     $tot_credit_reversed_IN = 0;
     $tot_credit_reversed_FN = 0;
     $lead_reversed = 0;
     $lead_reversed_IN = 0;
     $lead_reversed_FN = 0;
     $lead_notreversed = 0;
     $lead_notreversed_IN = 0;
     $lead_notreversed_FN = 0;
     $ver_up = 0;
     $ver_up_IN = 0;
     $ver_up_FN = 0;
     $no_update = 0;
     $no_update_IN = 0;
     $no_update_FN = 0;
     $tot_open = 0;
     $tot_open_IN = 0;
     $tot_open_FN = 0;
     $tot_close = 0;
     $tot_close_IN = 0;
     $tot_close_FN = 0;
     $tot_wip = 0;
     $tot_wip_IN = 0;
     $tot_wip_FN = 0;
     $verified = 0;
     $verified_IN = 0;
     $verified_FN = 0;
     $verifiedUpdated = 0;
     $verifiedUpdated_IN = 0;
     $verifiedUpdated_FN = 0;
     $Updated = 0;
     $Updated_IN = 0;
     $Updated_FN = 0;
     $notverified = 0;
     $notverified_IN = 0;
     $notverified_FN = 0;
     $ofrcount_notverified['wip']['ALL'] = 0;
     $ofrcount_notverified['wip']['IN'] = 0;
     $ofrcount_notverified['wip']['FN'] = 0;
     $ofrcount_notverified['totclose']['ALL'] = 0;
     $ofrcount_notverified['totclose']['IN'] = 0;
     $ofrcount_notverified['totclose']['FN'] = 0;
     $ofrcount_notverified['totopen']['ALL'] = 0;
     $ofrcount_notverified['totopen']['IN'] = 0;
     $ofrcount_notverified['totopen']['FN'] = 0;
     $ofrcount_notverified['leadnotdeleted']['ALL'] = 0;
     $ofrcount_notverified['leadnotdeleted']['IN'] = 0;
     $ofrcount_notverified['leadnotdeleted']['FN'] = 0;
     $ofrcount_notverified['leaddeleted']['ALL'] = 0;
     $ofrcount_notverified['leaddeleted']['IN'] = 0;
     $ofrcount_notverified['leaddeleted']['FN'] = 0;
     $ofrcount_notverified['leadnotreversed']['ALL'] = 0;
     $ofrcount_notverified['leadnotreversed']['IN'] = 0;
     $ofrcount_notverified['leadnotreversed']['FN'] = 0;
     $ofrcount_notverified['leadreversed']['ALL'] = 0;
     $ofrcount_notverified['leadreversed']['IN'] = 0;
     $ofrcount_notverified['leadreversed']['FN'] = 0;
     $ofrcount_notverified['noupdate']['ALL'] = 0;
     $ofrcount_notverified['noupdate']['IN'] = 0;
     $ofrcount_notverified['noupdate']['FN'] = 0;
     $ofrcount_notverified['vup']['ALL'] = 0;
     $ofrcount_notverified['vup']['IN'] = 0;
     $ofrcount_notverified['vup']['FN'] = 0;
     $ofrcount_verified['wip']['ALL'] = 0;
     $ofrcount_verified['wip']['IN'] = 0;
     $ofrcount_verified['wip']['FN'] = 0;
     $ofrcount_verified['totclose']['ALL'] = 0;
     $ofrcount_verified['totclose']['IN'] = 0;
     $ofrcount_verified['totclose']['FN'] = 0;
     $ofrcount_verified['totopen']['ALL'] = 0;
     $ofrcount_verified['totopen']['IN'] = 0;
     $ofrcount_verified['totopen']['FN'] = 0;
     $ofrcount_verified['leadnotdeleted']['ALL'] = 0;
     $ofrcount_verified['leadnotdeleted']['IN'] = 0;
     $ofrcount_verified['leadnotdeleted']['FN'] = 0;
     $ofrcount_verified['leaddeleted']['ALL'] = 0;
     $ofrcount_verified['leaddeleted']['IN'] = 0;
     $ofrcount_verified['leaddeleted']['FN'] = 0;
     $ofrcount_verified['leadnotreversed']['ALL'] = 0;
     $ofrcount_verified['leadnotreversed']['IN'] = 0;
     $ofrcount_verified['leadnotreversed']['FN'] = 0;
     $ofrcount_verified['leadreversed']['ALL'] = 0;
     $ofrcount_verified['leadreversed']['IN'] = 0;
     $ofrcount_verified['leadreversed']['FN'] = 0;
     $ofrcount_verified['noupdate']['ALL'] = 0;
     $ofrcount_verified['noupdate']['IN'] = 0;
     $ofrcount_verified['noupdate']['FN'] = 0;
     $ofrcount_verified['vup']['ALL'] = 0;
     $ofrcount_verified['vup']['IN'] = 0;
     $ofrcount_verified['vup']['FN'] = 0;

     // **************adding new***********************

     $ofrcount_updated['wip']['ALL'] = 0;
     $ofrcount_updated['wip']['IN'] = 0;
     $ofrcount_updated['wip']['FN'] = 0;
     $ofrcount_updated['totclose']['ALL'] = 0;
     $ofrcount_updated['totclose']['IN'] = 0;
     $ofrcount_updated['totclose']['FN'] = 0;
     $ofrcount_updated['totopen']['ALL'] = 0;
     $ofrcount_updated['totopen']['IN'] = 0;
     $ofrcount_updated['totopen']['FN'] = 0;
     $ofrcount_updated['leadnotdeleted']['ALL'] = 0;
     $ofrcount_updated['leadnotdeleted']['IN'] = 0;
     $ofrcount_updated['leadnotdeleted']['FN'] = 0;
     $ofrcount_updated['leaddeleted']['ALL'] = 0;
     $ofrcount_updated['leaddeleted']['IN'] = 0;
     $ofrcount_updated['leaddeleted']['FN'] = 0;
     $ofrcount_updated['leadnotreversed']['ALL'] = 0;
     $ofrcount_updated['leadnotreversed']['IN'] = 0;
     $ofrcount_updated['leadnotreversed']['FN'] = 0;
     $ofrcount_updated['leadreversed']['ALL'] = 0;
     $ofrcount_updated['leadreversed']['IN'] = 0;
     $ofrcount_updated['leadreversed']['FN'] = 0;
     $ofrcount_updated['noupdate']['ALL'] = 0;
     $ofrcount_updated['noupdate']['IN'] = 0;
     $ofrcount_updated['noupdate']['FN'] = 0;
     $ofrcount_updated['vup']['ALL'] = 0;
     $ofrcount_updated['vup']['IN'] = 0;
     $ofrcount_updated['vup']['FN'] = 0;

     // *************************************

     while ($rec = oci_fetch_assoc($sth))
          {
          $cmplnt_reason = $rec['REASON'];
          $cmplnt_rev_desc = $rec['ETO_BL_CMPLNT_CRD_REV_DESC'];
          $credit_reversed = $rec['ETO_BL_CMPLNT_CRD_REV_FLG'];
          $credit_reversed1 = $rec['ETO_BL_CMPLNT_CRD_REV_STATUS'];
          $lead_deleted = $rec['ETO_BL_CMPLNT_LEAD_DEL_FLG'];
          $ofr_crd_used = $rec['CREDITS_USED'];
          $byer_iso = $rec['BUYER_COUNTRY_ISO'];
          $ofr_verified = $rec['ETO_OFR_VERIFIED'];
          if ($byer_iso == 'IN')
               {
               $cnt_IN++;
               }
            else
               {
               $cnt_FN++;
               }

          $cnt++;

          // counting hash for opening reasons
          if(isset($opening_reason[$cmplnt_reason]))
				{
				    $opening_reason[$cmplnt_reason]['ALL'] = isset($opening_reason[$cmplnt_reason]['ALL'])?$opening_reason[$cmplnt_reason]['ALL']:0;
				    $opening_reason[$cmplnt_reason]['ALL'] = $opening_reason[$cmplnt_reason]['ALL'] + 1;

				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified["o$cmplnt_reason"]['ALL'] = isset($ofrcount_verified["o$cmplnt_reason"]['ALL']) ? $ofrcount_verified["o$cmplnt_reason"]['ALL']:0;
					$ofrcount_verified["o$cmplnt_reason"]['ALL'] = $ofrcount_verified["o$cmplnt_reason"]['ALL'] + 1;
				    }
                                    elseif($ofr_verified == 'Updated')
                                    {
                                        $ofrcount_updated["o$cmplnt_reason"]['ALL'] = isset($ofrcount_updated["o$cmplnt_reason"]['ALL'])?$ofrcount_updated["o$cmplnt_reason"]['ALL']:0;
                                        $ofrcount_updated["o$cmplnt_reason"]['ALL'] = $ofrcount_updated["o$cmplnt_reason"]['ALL'] + 1;
                                    }
				    else
				    {
				        $ofrcount_notverified["o$cmplnt_reason"]['ALL']=isset($ofrcount_notverified["o$cmplnt_reason"]['ALL'])?$ofrcount_notverified["o$cmplnt_reason"]['ALL']:0;
					$ofrcount_notverified["o$cmplnt_reason"]['ALL'] = $ofrcount_notverified["o$cmplnt_reason"]['ALL'] + 1;
				    }

				    if($byer_iso == 'IN')
				    {
					$opening_reason[$cmplnt_reason]['IN'] = isset($opening_reason[$cmplnt_reason]['IN'])?$opening_reason[$cmplnt_reason]['IN']:0;
					$opening_reason[$cmplnt_reason]['IN'] = $opening_reason[$cmplnt_reason]['IN'] + 1;

					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
					        $ofrcount_verified["o$cmplnt_reason"]['IN']=isset($ofrcount_verified["o$cmplnt_reason"]['IN'])?$ofrcount_verified["o$cmplnt_reason"]['IN']:0;
						$ofrcount_verified["o$cmplnt_reason"]['IN'] = $ofrcount_verified["o$cmplnt_reason"]['IN'] + 1;
					}
                                        elseif($ofr_verified == 'Updated')
					{
					        $ofrcount_updated["o$cmplnt_reason"]['IN'] = isset($ofrcount_updated["o$cmplnt_reason"]['IN'])?$ofrcount_updated["o$cmplnt_reason"]['IN']:0;
						$ofrcount_updated["o$cmplnt_reason"]['IN'] = $ofrcount_updated["o$cmplnt_reason"]['IN'] + 1;
					}
					else
					{
						$ofrcount_notverified["o$cmplnt_reason"]['IN']=isset($ofrcount_notverified["o$cmplnt_reason"]['IN'])?$ofrcount_notverified["o$cmplnt_reason"]['IN']:0;
						$ofrcount_notverified["o$cmplnt_reason"]['IN'] = $ofrcount_notverified["o$cmplnt_reason"]['IN'] + 1;
					}
				    }
				    else
				    {
					$opening_reason[$cmplnt_reason]['FN']=isset($opening_reason[$cmplnt_reason]['FN'])?$opening_reason[$cmplnt_reason]['FN']:0;
					$opening_reason[$cmplnt_reason]['FN'] = $opening_reason[$cmplnt_reason]['FN'] + 1;

					if($ofr_verified == 'Verified' || $ofr_verified || 'Verified AND Updated')
					{
						$ofrcount_verified["o$cmplnt_reason"]['FN']=isset($ofrcount_verified["o$cmplnt_reason"]['FN'])?$ofrcount_verified["o$cmplnt_reason"]['FN']:0;
						$ofrcount_verified["o$cmplnt_reason"]['FN'] = $ofrcount_verified["o$cmplnt_reason"]['FN'] + 1;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated["o$cmplnt_reason"]['FN']=isset($ofrcount_updated["o$cmplnt_reason"]['FN'])?$ofrcount_updated["o$cmplnt_reason"]['FN']:0;
						$ofrcount_updated["o$cmplnt_reason"]['FN'] = $ofrcount_updated["o$cmplnt_reason"]['FN'] + 1;
					}
					else
					{
						$ofrcount_notverified["o$cmplnt_reason"]['FN'] = isset($ofrcount_notverified["o$cmplnt_reason"]['FN'])?$ofrcount_notverified["o$cmplnt_reason"]['FN']:0;
						$ofrcount_notverified["o$cmplnt_reason"]['FN'] = $ofrcount_notverified["o$cmplnt_reason"]['FN'] + 1;
					}
				    }									
				}
				elseif(isset($cmplnt_reason))
				{
				    $opening_reason[$cmplnt_reason]['ALL']=isset($opening_reason[$cmplnt_reason]['ALL'])?$opening_reason[$cmplnt_reason]['ALL']:0;
				    $opening_reason[$cmplnt_reason]['ALL'] = 1;

				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified["o$cmplnt_reason"]['ALL'] = isset($ofrcount_verified["o$cmplnt_reason"]['ALL'])?$ofrcount_verified["o$cmplnt_reason"]['ALL']:0;
					$ofrcount_verified["o$cmplnt_reason"]['ALL'] = 1;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated["o$cmplnt_reason"]['ALL']=isset($ofrcount_updated["o$cmplnt_reason"]['ALL'])?$ofrcount_updated["o$cmplnt_reason"]['ALL']:0;
					$ofrcount_updated["o$cmplnt_reason"]['ALL'] = 1;
				    }
				    else
				    {
					$ofrcount_notverified["o$cmplnt_reason"]['ALL'] = isset($ofrcount_notverified["o$cmplnt_reason"]['ALL'])?$ofrcount_notverified["o$cmplnt_reason"]['ALL']:0;
					$ofrcount_notverified["o$cmplnt_reason"]['ALL'] = 1;
				    }

				    if($byer_iso == 'IN')
				    {
					$opening_reason[$cmplnt_reason]['IN'] = isset($opening_reason[$cmplnt_reason]['IN'])?$opening_reason[$cmplnt_reason]['IN']:0;
					$opening_reason[$cmplnt_reason]['IN'] = 1;

					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
                                        {
                                        	$ofrcount_verified["o$cmplnt_reason"]['IN'] = isset($ofrcount_verified["o$cmplnt_reason"]['IN'])?$ofrcount_verified["o$cmplnt_reason"]['IN']:0;
                                        	$ofrcount_verified["o$cmplnt_reason"]['IN'] = 1;
				    	}
                                        elseif($ofr_verified == 'Updated')
                                        {
                                        	$ofrcount_updated["o$cmplnt_reason"]['IN'] = isset($ofrcount_updated["o$cmplnt_reason"]['IN'])?$ofrcount_updated["o$cmplnt_reason"]['IN']:0;
                                        	$ofrcount_updated["o$cmplnt_reason"]['IN'] = 1;
				    	}
                                        else
                                        {
                                        	$ofrcount_notverified["o$cmplnt_reason"]['IN'] = isset($ofrcount_notverified["o$cmplnt_reason"]['IN'])?$ofrcount_notverified["o$cmplnt_reason"]['IN']:0;
                                        	$ofrcount_notverified["o$cmplnt_reason"]['IN'] = 1;
                                        }
				    }
				    else
				    {
					$opening_reason[$cmplnt_reason]['FN'] = isset($opening_reason[$cmplnt_reason]['FN'])?$opening_reason[$cmplnt_reason]['FN']:0;
					$opening_reason[$cmplnt_reason]['FN'] = 1;

					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
                                        {
                                        	$ofrcount_verified["o$cmplnt_reason"]['FN'] = isset($ofrcount_verified["o$cmplnt_reason"]['FN'])?$ofrcount_verified["o$cmplnt_reason"]['FN']:0;
                                        	$ofrcount_verified["o$cmplnt_reason"]['FN'] = 1;
					}
                                        elseif($ofr_verified == 'Updated')
                                        {
                                        	$ofrcount_updated["o$cmplnt_reason"]['FN']=isset($ofrcount_updated["o$cmplnt_reason"]['FN'])?$ofrcount_updated["o$cmplnt_reason"]['FN']:0;
                                        	$ofrcount_updated["o$cmplnt_reason"]['FN'] = 1;
					}
                                        else
                                        {
                                        	$ofrcount_notverified["o$cmplnt_reason"]['FN']=isset($ofrcount_notverified["o$cmplnt_reason"]['FN'])?$ofrcount_notverified["o$cmplnt_reason"]['FN']:0;
                                        	$ofrcount_notverified["o$cmplnt_reason"]['FN'] = 1;
                                        }
				    }
				}
				#counting hash for closing reasons
				if(isset($closing_reason[$cmplnt_rev_desc]))
				{
				    $closing_reason[$cmplnt_rev_desc]['ALL']=isset($closing_reason[$cmplnt_rev_desc]['ALL'])?$closing_reason[$cmplnt_rev_desc]['ALL']:0;
				    $closing_reason[$cmplnt_rev_desc]['ALL'] = $closing_reason[$cmplnt_rev_desc]['ALL'] + 1;

				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified[$cmplnt_rev_desc]['ALL']=isset($ofrcount_verified[$cmplnt_rev_desc]['ALL'])?$ofrcount_verified[$cmplnt_rev_desc]['ALL']:0;
					$ofrcount_verified[$cmplnt_rev_desc]['ALL'] = $ofrcount_verified[$cmplnt_rev_desc]['ALL'] + 1;
				    }
                                    elsEif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated[$cmplnt_rev_desc]['ALL']= isset($ofrcount_updated[$cmplnt_rev_desc]['ALL'])?$ofrcount_updated[$cmplnt_rev_desc]['ALL']:0;
					$ofrcount_updated[$cmplnt_rev_desc]['ALL'] = $ofrcount_updated[$cmplnt_rev_desc]['ALL'] + 1;
				    }
				    else
				    {
					$ofrcount_notverified[$cmplnt_rev_desc]['ALL']=isset($ofrcount_notverified[$cmplnt_rev_desc]['ALL'])?$ofrcount_notverified[$cmplnt_rev_desc]['ALL']:0;
					$ofrcount_notverified[$cmplnt_rev_desc]['ALL'] = $ofrcount_notverified[$cmplnt_rev_desc]['ALL'] + 1;
				    }

				    if($byer_iso == 'IN')
				    {
					$closing_reason[$cmplnt_rev_desc]['IN'] = isset($closing_reason[$cmplnt_rev_desc]['IN'])?$closing_reason[$cmplnt_rev_desc]['IN']:0;
					$closing_reason[$cmplnt_rev_desc]['IN'] = $closing_reason[$cmplnt_rev_desc]['IN'] + 1;

					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified[$cmplnt_rev_desc]['IN'] = isset($ofrcount_verified[$cmplnt_rev_desc]['IN'])?$ofrcount_verified[$cmplnt_rev_desc]['IN']:0;
						$ofrcount_verified[$cmplnt_rev_desc]['IN'] = $ofrcount_verified[$cmplnt_rev_desc]['IN'] + 1;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated[$cmplnt_rev_desc]['IN']=isset($ofrcount_updated[$cmplnt_rev_desc]['IN'])?$ofrcount_updated[$cmplnt_rev_desc]['IN']:0;
						$ofrcount_updated[$cmplnt_rev_desc]['IN'] = $ofrcount_updated[$cmplnt_rev_desc]['IN'] + 1;
					}
					else
					{
					        $ofrcount_notverified[$cmplnt_rev_desc]['IN'] = isset($ofrcount_notverified[$cmplnt_rev_desc]['IN'])?$ofrcount_notverified[$cmplnt_rev_desc]['IN']:0;
						$ofrcount_notverified[$cmplnt_rev_desc]['IN'] = $ofrcount_notverified[$cmplnt_rev_desc]['IN'] + 1;
					}
				    }
				    else
				    {
					$closing_reason[$cmplnt_rev_desc]['FN']= isset($closing_reason[$cmplnt_rev_desc]['FN'])?$closing_reason[$cmplnt_rev_desc]['FN']:0;
					$closing_reason[$cmplnt_rev_desc]['FN'] = $closing_reason[$cmplnt_rev_desc]['FN'] + 1;

					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified[$cmplnt_rev_desc]['FN']=isset($ofrcount_verified[$cmplnt_rev_desc]['FN'])?$ofrcount_verified[$cmplnt_rev_desc]['FN']:0;
						$ofrcount_verified[$cmplnt_rev_desc]['FN'] = $ofrcount_verified[$cmplnt_rev_desc]['FN'] + 1;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated[$cmplnt_rev_desc]['FN'] = isset($ofrcount_updated[$cmplnt_rev_desc]['FN'])?$ofrcount_updated[$cmplnt_rev_desc]['FN']:0;
						$ofrcount_updated[$cmplnt_rev_desc]['FN'] = $ofrcount_updated[$cmplnt_rev_desc]['FN'] + 1;
					}
					else
					{
						$ofrcount_notverified[$cmplnt_rev_desc]['FN'] = isset($ofrcount_notverified[$cmplnt_rev_desc]['FN'])?$ofrcount_notverified[$cmplnt_rev_desc]['FN']:0;
						$ofrcount_notverified[$cmplnt_rev_desc]['FN'] = $ofrcount_notverified[$cmplnt_rev_desc]['FN'] + 1;
					}
				    }					
				}
				elseif($cmplnt_rev_desc && $cmplnt_rev_desc != 'Verification Under Process')
				{
				    $closing_reason[$cmplnt_rev_desc]['ALL'] = isset($closing_reason[$cmplnt_rev_desc]['ALL'])?$closing_reason[$cmplnt_rev_desc]['ALL']:0;
				    $closing_reason[$cmplnt_rev_desc]['ALL'] = 1;
					
				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified[$cmplnt_rev_desc]['ALL'] = isset($ofrcount_verified[$cmplnt_rev_desc]['ALL'])?$ofrcount_verified[$cmplnt_rev_desc]['ALL']:0;
					$ofrcount_verified[$cmplnt_rev_desc]['ALL'] = 1;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
				        $ofrcount_updated[$cmplnt_rev_desc]['ALL'] = isset($ofrcount_updated[$cmplnt_rev_desc]['ALL'])?$ofrcount_updated[$cmplnt_rev_desc]['ALL']:0;
					$ofrcount_updated[$cmplnt_rev_desc]['ALL'] = 1;
				    }
				    else
				    {
					$ofrcount_notverified[$cmplnt_rev_desc]['ALL'] = isset($ofrcount_notverified[$cmplnt_rev_desc]['ALL'])?$ofrcount_notverified[$cmplnt_rev_desc]['ALL']:0;
					$ofrcount_notverified[$cmplnt_rev_desc]['ALL'] = 1;
				    }

				    if($byer_iso == 'IN')
				    {
					$closing_reason[$cmplnt_rev_desc]['IN'] = isset($closing_reason[$cmplnt_rev_desc]['IN'])?$closing_reason[$cmplnt_rev_desc]['IN']:0;
					$closing_reason[$cmplnt_rev_desc]['IN'] = 1;
					
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified[$cmplnt_rev_desc]['IN'] = isset($ofrcount_verified[$cmplnt_rev_desc]['IN'])?$ofrcount_verified[$cmplnt_rev_desc]['IN']:0;
						$ofrcount_verified[$cmplnt_rev_desc]['IN'] = 1;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated[$cmplnt_rev_desc]['IN'] = isset($ofrcount_updated[$cmplnt_rev_desc]['IN'])?$ofrcount_updated[$cmplnt_rev_desc]['IN']:0;
						$ofrcount_updated[$cmplnt_rev_desc]['IN'] = 1;
					}
					else
					{
						$ofrcount_notverified[$cmplnt_rev_desc]['IN'] = isset($ofrcount_notverified[$cmplnt_rev_desc]['IN'])?$ofrcount_notverified[$cmplnt_rev_desc]['IN']:0;
						$ofrcount_notverified[$cmplnt_rev_desc]['IN'] = 1;
					}
				    }
				    else
				    {
					$closing_reason[$cmplnt_rev_desc]['FN'] = isset($closing_reason[$cmplnt_rev_desc]['FN'])?$closing_reason[$cmplnt_rev_desc]['FN']:0;
					$closing_reason[$cmplnt_rev_desc]['FN'] = 1;
					
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified[$cmplnt_rev_desc]['FN']=isset($ofrcount_verified[$cmplnt_rev_desc]['FN'])?$ofrcount_verified[$cmplnt_rev_desc]['FN']:0;
						$ofrcount_verified[$cmplnt_rev_desc]['FN'] = 1;
					}
                                        elseif($ofr_verified == 'Updated')
					{
					        $ofrcount_updated[$cmplnt_rev_desc]['FN']=isset($ofrcount_updated[$cmplnt_rev_desc]['FN'])?$ofrcount_updated[$cmplnt_rev_desc]['FN']:0;
						$ofrcount_updated[$cmplnt_rev_desc]['FN'] = 1;
					}
					else
					{
						$ofrcount_notverified[$cmplnt_rev_desc]['FN'] = isset($ofrcount_notverified[$cmplnt_rev_desc]['FN'])?$ofrcount_notverified[$cmplnt_rev_desc]['FN']:0;
						$ofrcount_notverified[$cmplnt_rev_desc]['FN'] = 1;
					}
				    }					
				}
				if($cmplnt_rev_desc == 'Verification Under Process')
				{
				    $ver_up++;
				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified['vup']['ALL']++;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated['vup']['ALL']++;
				    }
				    else
				    {
					$ofrcount_notverified['vup']['ALL']++;
				    }

				    if($byer_iso == 'IN')
				    {					
					$ver_up_IN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['vup']['IN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['vup']['IN']++;
					}
					else
					{
						$ofrcount_notverified['vup']['IN']++;
					}
				    }
				    else
				    {
					$ver_up_FN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['vup']['FN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['vup']['FN']++;
					}
					else
					{
						$ofrcount_notverified['vup']['FN']++;
					}
				    }					
				}
				if(!$cmplnt_rev_desc)
				{
				    $no_update++;
				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified['noupdate']['ALL']++;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated['noupdate']['ALL']++;
				    }
				    else
				    {
					$ofrcount_notverified['noupdate']['ALL']++;
				    }

				    if($byer_iso == 'IN')
				    {					
					$no_update_IN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['noupdate']['IN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['noupdate']['IN']++;
					}
					else
					{
						$ofrcount_notverified['noupdate']['IN']++;
					}
				    }
				    else
				    {
					$no_update_FN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['noupdate']['FN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['noupdate']['FN']++;
					}
					else
					{
						$ofrcount_notverified['noupdate']['FN']++;
					}
				    }
				}
				if($credit_reversed1 == 1 || $credit_reversed1 == 2)
				{
				    $tot_credit_reversed = $tot_credit_reversed + $ofr_crd_used;
				    $lead_reversed++;

				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified['leadreversed']['ALL']++;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated['leadreversed']['ALL']++;
				    }
				    else
				    {
					$ofrcount_notverified['leadreversed']['ALL']++;
				    }

				    if($byer_iso == 'IN')
				    {
					$tot_credit_reversed_IN = $tot_credit_reversed_IN + $ofr_crd_used;
				    	$lead_reversed_IN++;

					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['leadreversed']['IN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['leadreversed']['IN']++;
					}
					else
					{
						$ofrcount_notverified['leadreversed']['IN']++;
					}
				    }
				    else
				    {
					$tot_credit_reversed_FN = $tot_credit_reversed_FN + $ofr_crd_used;
				    	$lead_reversed_FN++;

					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['leadreversed']['FN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['leadreversed']['FN']++;
					}
					else
					{
						$ofrcount_notverified['leadreversed']['FN']++;
					}
				    }					
				}
				elseif($credit_reversed1 == 3)
				{
				    $lead_notreversed++;

				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified['leadnotreversed']['ALL']++;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated['leadnotreversed']['ALL']++;
				    }
				    else
				    {
					$ofrcount_notverified['leadnotreversed']['ALL']++;
				    }

				    if($byer_iso == 'IN')
				    {
					$lead_notreversed_IN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['leadnotreversed']['IN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['leadnotreversed']['IN']++;
					}
					else
					{
						$ofrcount_notverified['leadnotreversed']['IN']++;
					}
				    }
				    else
				    {
					$lead_notreversed_FN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['leadnotreversed']['FN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['leadnotreversed']['FN']++;
					}
					else
					{
						$ofrcount_notverified['leadnotreversed']['FN']++;
					}
				    }					
				}
				
				if($lead_deleted)
				{
				    $tot_lead_deleted++;

				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified['leaddeleted']['ALL']++;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated['leaddeleted']['ALL']++;
				    }
				    else
				    {
					$ofrcount_notverified['leaddeleted']['ALL']++;
				    }

				    if($byer_iso == 'IN')
				    {
					$tot_lead_deleted_IN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['leaddeleted']['IN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['leaddeleted']['IN']++;
					}
					else
					{
						$ofrcount_notverified['leaddeleted']['IN']++;
					}
				    }
				    else
				    {
					$tot_lead_deleted_FN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['leaddeleted']['FN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['leaddeleted']['FN']++;
					}
					else
					{
						$ofrcount_notverified['leaddeleted']['FN']++;
					}
				    }					
				}
				else
				{
				    $tot_leadnotdeleted++;

				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified['leadnotdeleted']['ALL']++;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated['leadnotdeleted']['ALL']++;
				    }
				    else
				    {
					$ofrcount_notverified['leadnotdeleted']['ALL']++;
				    }

				    if($byer_iso == 'IN')
				    {
					$tot_leadnotdeleted_IN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['leadnotdeleted']['IN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['leadnotdeleted']['IN']++;
					}
					else
					{
						$ofrcount_notverified['leadnotdeleted']['IN']++;
					}
				    }
				    else
				    {
					$tot_leadnotdeleted_FN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['leadnotdeleted']['FN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['leadnotdeleted']['FN']++;
					}
					else
					{
						$ofrcount_notverified['leadnotdeleted']['FN']++;
					}
				    }					
				}
				#tottal counts of all
				if($cmplnt_reason)
				{
				    $tot_open++;
				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified['totopen']['ALL']++;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated['totopen']['ALL']++;
				    }   
				    else
				    {
					$ofrcount_notverified['totopen']['ALL']++;
				    }

				    if($byer_iso == 'IN')
				    {
					$tot_open_IN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['totopen']['IN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['totopen']['IN']++;
					}
					else
					{
						$ofrcount_notverified['totopen']['IN']++;
					}
				    }
				    else
				    {
					$tot_open_FN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['totopen']['FN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['totopen']['FN']++;
					}
					else
					{
						$ofrcount_notverified['totopen']['FN']++;
					}
				    }					
				}
				if($cmplnt_rev_desc && $cmplnt_rev_desc != 'Verification Under Process')
				{
				    $tot_close++;
				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified['totclose']['ALL']++;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					$ofrcount_updated['totclose']['ALL']++;
				    }
				    else
				    {
					$ofrcount_notverified['totclose']['ALL']++;
				    }

				    if($byer_iso == 'IN')
				    {
					$tot_close_IN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['totclose']['IN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['totclose']['IN']++;
					}
					else
					{
						$ofrcount_notverified['totclose']['IN']++;
					}
				    }
				    else
				    {
					$tot_close_FN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['totclose']['FN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['totclose']['FN']++;
					}
					else
					{
						$ofrcount_notverified['totclose']['FN']++;
					}
				    }					
				}
				if(!($cmplnt_rev_desc) || $cmplnt_rev_desc == 'Verification Under Process')
				{
				    $tot_wip++;
				    if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
				    {
					$ofrcount_verified['wip']['ALL']++;
				    }
                                    elseif($ofr_verified == 'Updated')
				    {
					
					$ofrcount_updated['wip']['ALL']++;
				    }
				    else
				    {
					$ofrcount_notverified['wip']['ALL']++;
				    }

				    if($byer_iso == 'IN')
				    {
					$tot_wip_IN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['wip']['IN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['wip']['IN']++;
					}
					else
					{
						$ofrcount_notverified['wip']['IN']++;
					}
				    }
				    else
				    {
					$tot_wip_FN++;
					if($ofr_verified == 'Verified' || $ofr_verified == 'Verified AND Updated')
					{
						$ofrcount_verified['wip']['FN']++;
					}
                                        elseif($ofr_verified == 'Updated')
					{
						$ofrcount_updated['wip']['FN']++;
					}
					else
					{
						$ofrcount_notverified['wip']['FN']++;
					}
				    }					
				}

				if($ofr_verified == 'Verified')
				{
					$verified++;
					if($byer_iso == 'IN')
					{
					    $verified_IN++;
					}
					else
					{
					    $verified_FN++;
					}
				}
				if($ofr_verified == 'Verified AND Updated')
				{
					$verifiedUpdated++;
					if($byer_iso == 'IN')
					{
					    $verifiedUpdated_IN++;
					}
					else
					{
					    $verifiedUpdated_FN++;
					}
				}
                                if($ofr_verified == 'Updated')
				{
					$Updated++;
					if($byer_iso == 'IN')
					{
					    $Updated_IN++;
					}
					else
					{
					    $Updated_FN++;
					}
				}
				if($ofr_verified == 'Not Verified')
				{
					$notverified++;
					if($byer_iso == 'IN')
					{
					    $notverified_IN++;
					}
					else
					{
					    $notverified_FN++;
					}
				}
          
          }

     echo '<br /><div id="crmreport" style="display:block;">
			<br />
                        <table width="99%" cellspacing="1" cellpadding="0" border="0" bgcolor="#badae5" align="center">
                        <tr>
                        <td width="30%" bgcolor="#0195D3" style="padding:4px; font-family:arial; font-size:14px; font-weight:bold; color:#fff;">Summary</td>
			<td width="23%" align="center" bgcolor="#0195D3" style="padding:4px; font-family:arial; font-size:14px;font-weight:bold;color:#fff;">Total</td>
                        <td width="23%" align="center" bgcolor="#0195D3" style="padding:4px; font-family:arial; font-size:14px;font-weight:bold;color:#fff;">India</td>
                        <td width="23%" align="center" bgcolor="#0195D3" style="padding:4px; font-family:arial; font-size:14px;font-weight:bold;color:#fff;">Foreign</td>
                        </tr>
                        <tr>
                        <td bgcolor="#C1EDFF">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#1DAFEC" style="padding:12px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;">Total</td>
                                </tr>
                        </table>
                        </td>
			<td bgcolor="#1DAFEC">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold; color:#fff;">' . $cnt . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff; border-left:1px solid #badae5;">Percentage(%)</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;border-left:1px solid #badae5;">Verified</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;border-left:1px solid #badae5;">Updated</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;border-left:1px solid #badae5;">Not Verified</td>
                        </tr>
                        </table>
                        </td>

                        <td bgcolor="#1DAFEC">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold; color:#fff;">' . $cnt_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff; border-left:1px solid #badae5;">Percentage(%)</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;border-left:1px solid #badae5;">Verified</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;border-left:1px solid #badae5;">Updated</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;border-left:1px solid #badae5;">Not Verified</td>
                        </tr>
                        </table>
                        </td>
                        <td bgcolor="#1DAFEC">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold; color:#fff;">' . $cnt_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff; border-left:1px solid #badae5;">Percentage(%)</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;border-left:1px solid #badae5;">Verified</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;border-left:1px solid #badae5;">Updated</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold; color:#fff;border-left:1px solid #badae5;">Not Verified</td>
                                </tr>
                                </table>
                        </td>
                        </tr>';
     echo '
                        <tr>
                        <td bgcolor="#C1EDFF">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">Opening Reason</td>
                                <td bgcolor="#C1EDFF" width="80%" style="padding:4px; font-family:arial; font-size:12px; border-left:1px solid #badae5;"></td>
                                </tr>
                        </table>
                        </td>

			<td bgcolor="#C1EDFF">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_open . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['totopen']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['totopen']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['totopen']['ALL'] . '</td>
                        </tr>
                        </table>
                        </td>

                        <td bgcolor="#C1EDFF">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_open_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['totopen']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['totopen']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['totopen']['IN'] . '</td>
                        </tr>
                        </table>
                        </td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_open_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['totopen']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['totopen']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['totopen']['FN'] . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     //                 foreach my $key (sort {$opening_reason{$b} <=> $opening_reason{$a}} keys%opening_reason)

     asort($opening_reason);
     foreach(array_keys($opening_reason) as $key)
          {
          $per_open = '0.00';
          $per_open_IN = '0.00';
          $per_open_FN = '0.00';
          if (isset($opening_reason[$key]['ALL']) && $tot_open)
               {
               $per_open = sprintf("%.2f", ($opening_reason[$key]['ALL'] / $tot_open) * 100);
               }

          if (isset($opening_reason[$key]['IN']) && $tot_open_IN)
               {
               $per_open_IN = sprintf("%.2f", ($opening_reason[$key]['IN'] / $tot_open_IN) * 100);
               }

          if (isset($opening_reason[$key]['FN']) && $tot_open_FN)
               {
               $per_open_FN = sprintf("%.2f", ($opening_reason[$key]['FN'] / $tot_open_FN) * 100);
               }

          if (!isset($ofrcount_verified["o$key"]['ALL']))
               {
               $ofrcount_verified["o$key"]['ALL'] = 0;
               }

          if (!isset($ofrcount_verified["o$key"]['IN']))
               {
               $ofrcount_verified["o$key"]['IN'] = 0;
               }

          if (!isset($ofrcount_verified["o$key"]['FN']))
               {
               $ofrcount_verified["o$key"]['FN'] = 0;
               }

          if (!isset($ofrcount_updated["o$key"]['ALL']))
               {
               $ofrcount_updated["o$key"]['ALL'] = 0;
               }

          if (!isset($ofrcount_updated["o$key"]['IN']))
               {
               $ofrcount_updated["o$key"]['IN'] = 0;
               }

          if (!isset($ofrcount_updated["o$key"]['FN']))
               {
               $ofrcount_updated["o$key"]['FN'] = 0;
               }

          if (!isset($ofrcount_notverified["o$key"]['ALL']))
               {
               $ofrcount_notverified["o$key"]['ALL'] = 0;
               }

          if (!isset($ofrcount_notverified["o$key"]['IN']))
               {
               $ofrcount_notverified["o$key"]['IN'] = 0;
               }

          if (!isset($ofrcount_notverified["o$key"]['FN']))
               {
               $ofrcount_notverified["o$key"]['FN'] = 0;
               }

          echo '
				<tr>
                                <td bgcolor="#C1EDFF">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                        <td bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">&nbsp;</td>
                                        <td width="80%" bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px;border-left:1px solid #badae5; font-weight:bold;">' . $key . '</td>
                                  </tr>
                                  </table>
				</td>

				<td bgcolor="#EEFAFF">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                        <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">';
          if (isset($opening_reason[$key]['ALL'])) echo $opening_reason[$key]['ALL'];
          echo '</td>
                                        <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_open . '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
          if (isset($ofrcount_verified["o$key"]['ALL'])) echo $ofrcount_verified["o$key"]['ALL'];
          echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
          if (isset($ofrcount_updated["o$key"]['ALL'])) echo $ofrcount_updated["o$key"]['ALL'];
          echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
          if (isset($ofrcount_notverified["o$key"]['ALL'])) echo $ofrcount_notverified["o$key"]['ALL'];
          echo '</td>
                                  </tr>
                                  </table>
				</td>

                                <td bgcolor="#EEFAFF">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                        <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">';
          if (isset($opening_reason[$key]['IN'])) echo $opening_reason[$key]['IN'];
          echo '</td>
                                        <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_open_IN . '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
          if (isset($ofrcount_verified["o$key"]['IN'])) echo $ofrcount_verified["o$key"]['IN'];
          echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
          if (isset($ofrcount_updated["o$key"]['IN'])) echo $ofrcount_updated["o$key"]['IN'];
          echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
          if (isset($ofrcount_notverified["o$key"]['IN'])) echo $ofrcount_notverified["o$key"]['IN'];
          echo '</td>
                                  </tr>
                                  </table>
				</td>
                                <td bgcolor="#EEFAFF">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                        <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">';
          if (isset($opening_reason[$key]['FN'])) echo $opening_reason[$key]['FN'];
          echo '</td>
                                        <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_open_FN . '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
          if (isset($ofrcount_verified["o$key"]['FN'])) echo $ofrcount_verified["o$key"]['FN'];
          echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
          if (isset($ofrcount_updated["o$key"]['FN'])) echo $ofrcount_updated["o$key"]['FN'];
          echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
          if (isset($ofrcount_notverified["o$key"]['FN'])) echo $ofrcount_notverified["o$key"]['FN'];
          echo '</td>
                                  </tr>
                                  </table>
				</td>
                                </tr>
                                ';
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">Closing Reason</td>
                                <td width="80%" bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; border-left:1px solid #badae5;"></td>
                                </tr>
                        </table>
                        </td>

			<td bgcolor="#C1EDFF">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_close . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_verified['totclose']['ALL'])) echo $ofrcount_verified['totclose']['ALL'];
     echo '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_updated['totclose']['ALL'])) echo $ofrcount_updated['totclose']['ALL'];
     echo '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_notverified['totclose']['ALL'])) echo $ofrcount_notverified['totclose']['ALL'];
     echo '</td>
                        </tr>
                        </table>
			</td>

                        <td bgcolor="#C1EDFF">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_close_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_verified['totclose']['IN'])) echo $ofrcount_verified['totclose']['IN'];
     echo '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_updated['totclose']['IN'])) echo $ofrcount_updated['totclose']['IN'];
     echo '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_notverified['totclose']['IN'])) echo $ofrcount_notverified['totclose']['IN'];
     echo '</td>
                        </tr>
                        </table>
			</td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_close_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_verified['totclose']['FN'])) echo $ofrcount_verified['totclose']['FN'];
     echo '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_updated['totclose']['FN'])) echo $ofrcount_updated['totclose']['FN'];
     echo '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_notverified['totclose']['FN'])) echo $ofrcount_notverified['totclose']['FN'];
     echo '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     //                      foreach my $key (sort {$closing_reason{$b} <=> $closing_reason{$a}} keys%closing_reason)

     asort($closing_reason);
     foreach(array_keys($closing_reason) as $key)
          {
          $per_close = '0.00';
          $per_close_IN = '0.00';
          $per_close_FN = '0.00';
          if ($tot_close && isset($closing_reason[$key]['ALL']))
               {
               $per_close = sprintf("%.2f", ($closing_reason[$key]['ALL'] / $tot_close) * 100);
               }

          if ($tot_close_IN && isset($closing_reason[$key]['IN']))
               {
               $per_close_IN = sprintf("%.2f", ($closing_reason[$key]['IN'] / $tot_close_IN) * 100);
               }

          if ($tot_close_FN && isset($closing_reason[$key]['FN']))
               {
               $per_close_FN = sprintf("%.2f", ($closing_reason[$key]['FN'] / $tot_close_FN) * 100);
               }

          if (!isset($ofrcount_verified[$key]['ALL']))
               {
               $ofrcount_verified[$key]['ALL'] = 0;
               }

          if (!isset($ofrcount_verified[$key]['IN']))
               {
               $ofrcount_verified[$key]['IN'] = 0;
               }

          if (!isset($ofrcount_verified[$key]['FN']))
               {
               $ofrcount_verified[$key]['FN'] = 0;
               }

          if (!isset($ofrcount_updated[$key]['ALL']))
               {
               $ofrcount_updated[$key]['ALL'] = 0;
               }

          if (!isset($ofrcount_updated[$key]['IN']))
               {
               $ofrcount_updated[$key]['IN'] = 0;
               }

          if (!isset($ofrcount_updated[$key]['FN']))
               {
               $ofrcount_updated[$key]['FN'] = 0;
               }

          if (!isset($ofrcount_notverified[$key]['ALL']))
               {
               $ofrcount_notverified[$key]['ALL'] = 0;
               }

          if (!isset($ofrcount_notverified[$key]['IN']))
               {
               $ofrcount_notverified[$key]['IN'] = 0;
               }

          if (!isset($ofrcount_notverified[$key]['FN']))
               {
               $ofrcount_notverified[$key]['FN'] = 0;
               }

          echo '
                                <tr>
                                <td bgcolor="#C1EDFF">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                        <td bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">&nbsp;</td>
                                        <td width="80%" bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px;border-left:1px solid #badae5; font-weight:bold;">' . $key . '</td>
                                        </tr>
                                </table>
                                </td>

				<td bgcolor="#EEFAFF">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                        <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">';
          if (isset($closing_reason[$key]['ALL'])) echo $closing_reason[$key]['ALL'];
          echo '</td>
                                        <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_close . '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' ;
                                        if(isset($ofrcount_verified[$key]['ALL']))
                                        echo $ofrcount_verified[$key]['ALL'] ;
                                        echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' ;
                                        if(isset($ofrcount_updated[$key]['ALL']))
                                        echo $ofrcount_updated[$key]['ALL'] ;
                                        echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' ;
                                        if(isset($ofrcount_notverified[$key]['ALL']))
                                        echo $ofrcount_notverified[$key]['ALL'] ;
                                        echo '</td>
                                </tr>
                                </table>
                                </td>

                                <td bgcolor="#EEFAFF">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                        <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">';
          if (isset($closing_reason[$key]['IN'])) echo $closing_reason[$key]['IN'];
          echo '</td>
                                        <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_close_IN . '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' ;
                                        if(isset($ofrcount_verified[$key]['IN']))
                                        echo $ofrcount_verified[$key]['IN'] ;
                                        echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' ;
                                        if(isset($ofrcount_updated[$key]['IN']))
                                        echo $ofrcount_updated[$key]['IN'] ;
                                        echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' ;
                                        if(isset($ofrcount_notverified[$key]['IN']))
                                        echo $ofrcount_notverified[$key]['IN'] ;
                                        echo '</td>
                                </tr>
                                </table>
                                </td>
                                <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                        <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' ; if(isset($closing_reason[$key]['FN'])) echo $closing_reason[$key]['FN'] ;
                                        echo '</td>
                                        <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_close_FN . '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' ;
                                        if(isset($ofrcount_verified[$key]['FN']))
                                        echo $ofrcount_verified[$key]['FN'];
                                        echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' ;
                                        if(isset($ofrcount_updated[$key]['FN']))
                                        echo $ofrcount_updated[$key]['FN'] ;
                                        echo '</td>
                                        <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' ;
                                        if(isset($ofrcount_notverified[$key]['FN']))
                                        echo $ofrcount_notverified[$key]['FN'] ;
                                        echo '</td>
                                </tr>
                                </table></td>
                                </tr>
                                ';
          }

     // WIP

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">WIP</td>
                        <td  width="80%" bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; border-left:1px solid #badae5;"></td>
                                </tr>
                        </table></td>

			<td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_wip . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['wip']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">';
     if (isset($ofrcount_updated['wip']['ALL']))
          {
          echo $ofrcount_updated['wip']['ALL'];
          }

     echo '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['wip']['ALL'] . '</td>
                        </tr>
                        </table>
			</td>

                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_wip_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['wip']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['wip']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['wip']['IN'] . '</td>
                        </tr>
                        </table>
			</td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_wip_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['wip']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['wip']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['wip']['FN'] . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // verification under process

     $per_vup = '0.00';
     $per_vup_IN = '0.00';
     $per_vup_FN = '0.00';
     if ($tot_wip)
          {
          $per_vup = sprintf("%.2f", ($ver_up / $tot_wip) * 100);
          }

     if ($tot_wip_IN)
          {
          $per_vup_IN = sprintf("%.2f", ($ver_up_IN / $tot_wip_IN) * 100);
          }

     if ($tot_wip_FN)
          {
          $per_vup_FN = sprintf("%.2f", ($ver_up_FN / $tot_wip_FN) * 100);
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">&nbsp;</td>
                                <td width="80%" bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px;border-left:1px solid #badae5; font-weight:bold;">Verification Under Process</td>
                        </tr>
                        </table></td>

			<td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $ver_up . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_vup . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['vup']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['vup']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['vup']['ALL'] . '</td>
                        </tr>
                        </table>
			</td>

                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $ver_up_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_vup_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['vup']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['vup']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['vup']['IN'] . '</td>
                        </tr>
                        </table>
			</td>
                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $ver_up_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_vup_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['vup']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['vup']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['vup']['FN'] . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // no update

     $per_nu = '0.00';
     $per_nu_IN = '0.00';
     $per_nu_FN = '0.00';
     if ($tot_wip)
          {
          $per_nu = sprintf("%.2f", ($no_update / $tot_wip) * 100);
          }

     if ($tot_wip_IN)
          {
          $per_nu_IN = sprintf("%.2f", ($no_update_IN / $tot_wip_IN) * 100);
          }

     if ($tot_wip_FN)
          {
          $per_nu_FN = sprintf("%.2f", ($no_update_FN / $tot_wip_FN) * 100);
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">&nbsp;</td>
                                <td width="80%" bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px;border-left:1px solid #badae5; font-weight:bold;">No Update</td>
                        </tr>
                        </table></td>
			<td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $no_update . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_nu . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['noupdate']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['noupdate']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['noupdate']['ALL'] . '</td>
                        </tr>
                        </table>
			</td>
                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $no_update_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_nu_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['noupdate']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['noupdate']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['noupdate']['IN'] . '</td>
                        </tr>
                        </table>
			</td>
                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $no_update_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_nu_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['noupdate']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['noupdate']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['noupdate']['FN'] . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // offer verified details

     $tot_ofr = $verified + $verifiedUpdated + $Updated + $notverified;
     $tot_ofr_IN = $verified_IN + $verifiedUpdated_IN + $Updated_IN + $notverified_IN;
     $tot_ofr_FN = $verified_FN + $verifiedUpdated_FN + $Updated_FN + $notverified_FN;
     $verified = $verified + $verifiedUpdated;
     $verified_IN = $verified_IN + $verifiedUpdated_IN;
     $verified_FN = $verified_FN + $verifiedUpdated_FN;
     echo '   <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">All</td>
                                <td width="80%" bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; border-left:1px solid #badae5;"></td>
                                </tr>
                        </table></td>
			<td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_ofr . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $verified . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $Updated . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $notverified . '</td>
                        </tr>
                        </table>
			</td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_ofr_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $verified_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $Updated_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $notverified_IN . '</td>
                        </tr>
                        </table>
			</td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_ofr_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $verified_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $Updated_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $notverified_FN . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // offer verified

     $per_ofr_ver = '0.00';
     $per_ofr_ver_IN = '0.00';
     $per_ofr_ver_FN = '0.00';
     if ($tot_wip)
          {
          $per_ofr_ver = sprintf("%.2f", ($verified / $tot_ofr) * 100);
          }

     if ($tot_wip_IN)
          {
          $per_ofr_ver_IN = sprintf("%.2f", ($verified_IN / $tot_ofr_IN) * 100);
          }

     if ($tot_wip_FN)
          {
          $per_ofr_ver_FN = sprintf("%.2f", ($verified_FN / $tot_ofr_FN) * 100);
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">&nbsp;</td>
                                <td width="80%" bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px;border-left:1px solid #badae5; font-weight:bold;">Verified</td>
                        </tr>
                        </table></td>
			<td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $verified . '
                                </td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ofr_ver . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $verified . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $verified_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ofr_ver_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $verified_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $verified_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ofr_ver_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $verified_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // offer updated

     $per_ofr_upd = '0.00';
     $per_ofr_upd_IN = '0.00';
     $per_ofr_upd_FN = '0.00';
     if ($tot_wip)
          {
          $per_ofr_upd = sprintf("%.2f", ($Updated / $tot_ofr) * 100);
          }

     if ($tot_wip_IN)
          {
          $per_ofr_upd_IN = sprintf("%.2f", ($Updated_IN / $tot_ofr_IN) * 100);
          }

     if ($tot_wip_FN)
          {
          $per_ofr_upd_FN = sprintf("%.2f", ($Updated_FN / $tot_ofr_FN) * 100);
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">&nbsp;</td>
                                <td width="80%" bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px;border-left:1px solid #badae5; font-weight:bold;">Updated</td>
                        </tr>
                        </table></td>
			<td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $Updated . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ofr_upd . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $Updated . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $Updated_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ofr_upd_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $Updated_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $Updated_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ofr_upd_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $Updated_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // offer not verified

     $per_ofr_notver = '0.00';
     $per_ofr_notver_IN = '0.00';
     $per_ofr_notver_FN = '0.00';
     if ($tot_wip)
          {
          $per_ofr_notver = sprintf("%.2f", ($notverified / $tot_ofr) * 100);
          }

     if ($tot_wip_IN)
          {
          $per_ofr_notver_IN = sprintf("%.2f", ($notverified_IN / $tot_ofr_IN) * 100);
          }

     if ($tot_wip_FN)
          {
          $per_ofr_notver_FN = sprintf("%.2f", ($notverified_FN / $tot_ofr_FN) * 100);
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">&nbsp;</td>
                                <td width="80%" bgcolor="#EEFAFF" style="padding:4px; font-family:arial; font-size:12px;border-left:1px solid #badae5; font-weight:bold;">Not Verified</td>
                        </tr>
                        </table></td>
			<td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $notverified . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ofr_notver . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $notverified . '</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $notverified_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ofr_notver_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $notverified_IN . '</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#EEFAFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $notverified_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ofr_notver_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">0</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $notverified_FN . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // lead count reversed

     $per_rev = '0.00';
     $per_rev_IN = '0.00';
     $per_rev_FN = '0.00';
     if ($lead_reversed + $lead_notreversed)
          {
          $per_rev = sprintf("%.2f", ($lead_reversed / ($lead_reversed + $lead_notreversed) * 100));
          }

     if ($lead_reversed_IN + $lead_notreversed_IN)
          {
          $per_rev_IN = sprintf("%.2f", ($lead_reversed_IN / ($lead_reversed_IN + $lead_notreversed_IN) * 100));
          }

     if ($lead_reversed_FN + $lead_notreversed_FN)
          {
          $per_rev_FN = sprintf("%.2f", ($lead_reversed_FN / ($lead_reversed_FN + $lead_notreversed_FN) * 100));
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">Credits Reversed</td>
                                <td width="80%" bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; border-left:1px solid #badae5;"></td>
                                </tr>
                        </table></td>
			<td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $lead_reversed . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_rev . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leadreversed']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leadreversed']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leadreversed']['ALL'] . '</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $lead_reversed_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_rev_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leadreversed']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leadreversed']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leadreversed']['IN'] . '</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $lead_reversed_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_rev_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leadreversed']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leadreversed']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leadreversed']['FN'] . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // lead count not reversed

     $per_nrev = '0.00';
     $per_nrev_IN = '0.00';
     $per_nrev_FN = '0.00';
     if ($lead_reversed + $lead_notreversed)
          {
          $per_nrev = sprintf("%.2f", ($lead_notreversed / ($lead_reversed + $lead_notreversed) * 100));
          }

     if ($lead_reversed_IN + $lead_notreversed_IN)
          {
          $per_nrev_IN = sprintf("%.2f", ($lead_notreversed_IN / ($lead_reversed_IN + $lead_notreversed_IN) * 100));
          }

     if ($lead_reversed_FN + $lead_notreversed_FN)
          {
          $per_nrev_FN = sprintf("%.2f", ($lead_notreversed_FN / ($lead_reversed_FN + $lead_notreversed_FN) * 100));
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">Credit Not Reversed</td>
                                <td width="80%" bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; border-left:1px solid #badae5;"></td>
                                </tr>
                        </table></td>
			 <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $lead_notreversed . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_nrev . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leadnotreversed']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leadnotreversed']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leadnotreversed']['ALL'] . '</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $lead_notreversed_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_nrev_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leadnotreversed']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leadnotreversed']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leadnotreversed']['IN'] . '</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $lead_notreversed_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_nrev_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leadnotreversed']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leadnotreversed']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leadnotreversed']['FN'] . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // total credits reversed

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">Total Credits Reversed</td>
                                <td width="80%" bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; border-left:1px solid #badae5;"></td>
                                </tr>
                        </table></td>

			<td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_credit_reversed . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                        </tr>
                        </table></td>

                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_credit_reversed_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_credit_reversed_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">&nbsp;</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // leads deleted

     $per_del = '0.00';
     $per_del_IN = '0.00';
     $per_del_FN = '0.00';
     if ($tot_lead_deleted + $tot_leadnotdeleted)
          {
          $per_del = sprintf("%.2f", $tot_lead_deleted / ($tot_lead_deleted + $tot_leadnotdeleted) * 100);
          }

     if ($tot_lead_deleted_IN + $tot_leadnotdeleted_IN)
          {
          $per_del_IN = sprintf("%.2f", $tot_lead_deleted_IN / ($tot_lead_deleted_IN + $tot_leadnotdeleted_IN) * 100);
          }

     if ($tot_lead_deleted_FN + $tot_leadnotdeleted_FN)
          {
          $per_del_FN = sprintf("%.2f", $tot_lead_deleted_FN / ($tot_lead_deleted_FN + $tot_leadnotdeleted_FN) * 100);
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">Buy Leads Deleted</td>
                                <td width="80%" bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; border-left:1px solid #badae5;"></td>
                                </tr>
                        </table></td>

			<td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_lead_deleted . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_del . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leaddeleted']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leaddeleted']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leaddeleted']['ALL'] . '</td>
                        </tr>
                        </table></td>

                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_lead_deleted_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_del_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leaddeleted']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leaddeleted']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leaddeleted']['IN'] . '</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_lead_deleted_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_del_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leaddeleted']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leaddeleted']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leaddeleted']['FN'] . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';

     // leads not deleted

     $per_ndel = '0.00';
     $per_ndel_IN = '0.00';
     $per_ndel_FN = '0.00';
     if ($tot_lead_deleted + $tot_leadnotdeleted)
          {
          $per_ndel = sprintf("%.2f", $tot_leadnotdeleted / ($tot_lead_deleted + $tot_leadnotdeleted) * 100);
          }

     if ($tot_lead_deleted_IN + $tot_leadnotdeleted_IN)
          {
          $per_ndel_IN = sprintf("%.2f", $tot_leadnotdeleted_IN / ($tot_lead_deleted_IN + $tot_leadnotdeleted_IN) * 100);
          }

     if ($tot_lead_deleted_FN + $tot_leadnotdeleted_FN)
          {
          $per_ndel_FN = sprintf("%.2f", $tot_leadnotdeleted_FN / ($tot_lead_deleted_FN + $tot_leadnotdeleted_FN) * 100);
          }

     echo '
                        <tr>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">Buy Leads Not Deleted</td>
                                <td width="80%" bgcolor="#C1EDFF" style="padding:4px; font-family:arial; font-size:12px; border-left:1px solid #badae5;"></td>
                                </tr>
                        </table></td>

			<td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_leadnotdeleted . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ndel . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leadnotdeleted']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leadnotdeleted']['ALL'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leadnotdeleted']['ALL'] . '</td>
                        </tr>
                        </table></td>

                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_leadnotdeleted_IN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ndel_IN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leadnotdeleted']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leadnotdeleted']['IN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leadnotdeleted']['IN'] . '</td>
                        </tr>
                        </table></td>
                        <td bgcolor="#C1EDFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="10%" style="padding:4px; font-family:arial; font-size:12px; font-weight:bold;">' . $tot_leadnotdeleted_FN . '</td>
                                <td width="30%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $per_ndel_FN . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_verified['leadnotdeleted']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_updated['leadnotdeleted']['FN'] . '</td>
                                <td width="20%" style="padding:4px; font-family:arial; font-size:12px;font-weight:bold;border-left:1px solid #badae5;">' . $ofrcount_notverified['leadnotdeleted']['FN'] . '</td>
                        </tr>
                        </table></td>
                        </tr>
                        ';
     echo '
			</table>
			</div>
			<br />
			<br />
			<br />';
     }
elseif (isset($_REQUEST['report']) && $_REQUEST['report'] == 'performance')
     {
     $emp_cnt = array();
     $cnt = 0;
     while ($rec = oci_fetch_assoc($sth))
          {
          $cnt++;
          $cmplnt_emp_close = $rec['EMP_CLOSED'];
          if (isset($emp_cnt[$cmplnt_emp_close]))
               {
               $emp_cnt[$cmplnt_emp_close] = $emp_cnt[$cmplnt_emp_close] + 1;
               }
          elseif ($cmplnt_emp_close)
               {
               $emp_cnt[$cmplnt_emp_close] = 1;
               }
          }

     echo '<br /><div id="crmreport" style="display:block;"><br />
			<table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="0" width="98%" align="center">
			<tbody><tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">
			<td width="13%" style="padding:4px; font-family:arial; font-size:13px;">Employee Performance</td>
			</tr>
			</tbody></table>
			<table bgcolor="#80c0e5" border="0" cellpadding="0" cellspacing="1" width="98%" align="center">
			<tr style="background: #1dafec; color: white; font-weight: bold; font-family:arial; font-size: 12px;">
			<td bgcolor="#00a2e6" style="padding:6px;">Total Closed</td>
			<td bgcolor="#00a2e6"  style="padding:4px; text-align:right;">' . $cnt . '</td>
			</tr>';
     $cnt = 0;
     $bgcolor = '';

     // 			foreach my $key (sort keys %emp_cnt)
     asort($emp_cnt);
     foreach($emp_cnt as $key)
          {
          $cnt++;
          if ($cnt % 2 == 0)
               {
               $bgcolor = '#c1edff';
               }
            else
               {
               $bgcolor = '#eefaff';
               }

          echo '<tr style="background: #0195d3; color:#000000; font-weight: bold;font-family:arial; font-size: 12px;">
				<td bgcolor="' . $bgcolor . '"  style="padding:4px 4px 4px 10px;">' . $key . '</td>
				<td width="10%" align="right" bgcolor="' . $bgcolor . '" style="padding:4px;">' ;
				if(isset($emp_cnt[$key]))
				echo $emp_cnt[$key];
				echo '</td>
				</tr>';
          }

     echo '</table></div>
			<br /><br /><br />';
     }

?>