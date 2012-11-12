<?php
$sql = "SELECT * FROM `".$tabelnaam."_2_sites` WHERE `".$prefix."id` = '".$_GET['id']."'";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		$array_sites[$site_id] = true;
	}
	$formactie = 'wijzig';
	$submit_txt = 'Wijzigingen opslaan';
} else {
	$formactie = 'nieuw';
	$submit_txt = 'Koppelingen opslaan';
}

echo '
<form action="#" method="post" enctype="multipart/form-data" name="form">
	<input name="id" type="hidden" value="'.$user_id.'">
	<input name="tab" type="hidden" value="'.$_GET['tab'].'">
	<input name="formactie" type="hidden" value="'.$formactie.'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;content=overzicht">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">User koppelen met beschikbare sites</td>
		</tr>
		<tr class="sub_lijn">
			<td>Sites</td>
			<td>
				<div id="labels">
';
$sql = "SELECT * FROM `sites` ORDER BY `positie`,`site_naam`";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '<label for="site_'.$site_id.'"><input type="checkbox" id="site_'.$site_id.'" name="site_'.$site_id.'"'.($array_sites[$site_id]==true ? $check : '').' value="1" onchange="check_site(\''.$site_id.'\');" /> '.$site_naam.'</label>'."\n";
	}
}
echo '			</div>	
			</td>
		</tr>
	</table>
</form>
';
?>
<script language="javascript">
function check_site(site_id) {
	loader_show();
	var check = $("#site_"+site_id).is(':checked');
	$.ajax({
		url: 'wijzig_<?php echo $tabelnaam; ?>/ajax_verwerking.php',
		data: 'sites=1&site_id='+site_id+'&user_id=<?php echo $_GET['id']; ?>&checked='+check,
		type: 'GET',
		success: function(feedback){
			loader_hide();
		}
	});
}
$(document).ready(function(){
	check_labels('#labels');
});
</script>