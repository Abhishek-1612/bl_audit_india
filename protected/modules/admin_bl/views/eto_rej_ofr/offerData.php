<html>
<body>
<div style="height: auto;width:100%;overflow-x: auto;">
<div ><b>&nbsp;Related Offers:(MCAT ID: <?php echo $mcatid; ?>)</b></div>
<table class="table table-bordered table-condensed" style="font-size: 13px;background-color:#F0F9FF;white-space: nowrap;">
		<tr style="background: none repeat scroll 0% 0% rgb(0, 109, 204); color: rgb(255, 255, 255);">
			<th>Offer ID</th>
			<th>Offer Title</th>
			<th>Prime MCAT Name</th>
			<th>Secondary MCAT Name</th>
			<th>Rejection Comment</th>
			<th>Search Text</th>
			<th>Buyer GLID</th>
            <th>Buyer City</th>
			<th>Matchmaking MCAT</th>
			<th>MCAT Rank</th>
			<th>Matchmaking Type</th>
			<th>Page</th>
            <th>Display Position</th>
			<th>City Preference Type</th>
            <th>Platform</th>
		</tr>
<?php	
// echo "<pre>";print_R($negMcats);
// echo "<pre>";print_R($arr);
// exit;	
foreach($offerList['offerList'] as $row)
{
	?>
    <tr>
			<td><?php echo @$row["BL_OFFER_ID"]?></td>
			<td><?php echo @$row["ETO_OFR_TITLE"]?></td>
			<td><?php echo @$row["PRIME_MCAT_NAME"] ?></td>
            <td><?php echo @$row["ALL_MCAT_NAME_GRP"]?></td>
			<td><?php echo @$row["REJECTION_COMMENT"]?></td>
			<td><?php echo @$row["SEARCH_TEXT"]?></td>
			<td><?php echo @$row["BUYER_GLID"] ?></td>
			<td><?php echo @$row["BUYER_CITY_NAME"]?></td>
            <td><?php echo @$row["MATCHMAKING_MCAT"]?></td>
			<td><?php echo @$row["MCAT_RANK"]?></td>
			<td><?php echo @$row["MATCH_TYPE"]?></td>
			<td><?php echo @$row["REJECT_PAGE"] ?></td>
			<td><?php echo @$row["LEAD_DISPLAY_POSITION"]?></td>
            <td><?php echo @$row["CITY_TYPE"] ?></td>
			<td><?php echo @$row["FK_GL_MODULE_ID"]?></td>
		</tr>
<?php } ?>

</table>
</div>

</body>
</html>