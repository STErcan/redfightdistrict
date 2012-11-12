<?php
$sql = "SELECT `email_lijst` FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."'";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows == 1)  {
	extract($db->get_row($result));
	$array_lijsten = explode(',',$email_lijst);

	$formactie = 'wijzig';
	$submit_txt = 'Wijzigingen opslaan';
} else {
	$formactie = 'nieuw';
	$submit_txt = 'Koppelingen opslaan';
}

echo '
<form action="#" method="post" enctype="multipart/form-data" name="form">
	<input name="'.$prefix.'id" type="hidden" value="'.$user_id.'">
	<input name="tab" type="hidden" value="'.$_GET['tab'].'">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Users koppelen met beschikbare sites</td>
		</tr>
		<tr class="sub_lijn">
			<td>Sites</td>
			<td>
				<div id="labels">
';

$sql = "SELECT * FROM `mailing_lijsten` ORDER BY `positie`, `lijst_naam`";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1)  {
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '<label for="lijst_'.$lijst_id.'"><input type="checkbox" id="lijst_'.$lijst_id.'" name="lijst_'.$lijst_id.'"'.(in_array($lijst_id,$array_lijsten) ? $check : '').' value="'.$lijst_id.'" onchange="check_lijsten();" /> '.$lijst_naam.'</label>'."\n";
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
function check_lijsten() {
	loader_show();
	var input_data = $(":input");
	var output = '';
	$.each(input_data, function( intIndex, objValue ){
		var check = $('#'+input_data[intIndex].name).is(':checked');
		if (check) {
			output += '&lijst[]='+input_data[intIndex].value;
		}
	});
	$.ajax({
		url: 'wijzig_<?php echo $tabelnaam; ?>/ajax_check_lijst.php',
		data: 'email_id=<?php echo $_GET['id']; ?>'+output,
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