<?php
if (!$_POST) { 
echo "stap 1: Select items.";
echo'
	<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
	<table class="table_paypal">
		<tr><td><input type="checkbox" name="amount_2" value="10"></td><td>Street fighter 2</td></tr>
		<tr><td><input type="checkbox" name="amount_3" value="10"></td><td>Street fighter 3: Third Strike</td></tr>
		<tr><td><input type="checkbox" name="amount_4" value="10"></td><td>Blazblue: Continuum Shift</td></tr>
		<tr><td><input type="checkbox" name="amount_5" value="10"></td><td>Super Street Fighter 4</td></tr>
		<tr><td><input type="checkbox" name="amount_6" value="10"></td><td>Tekken 6</td></tr>
		<tr><td><input type="checkbox" name="amount_7" value="10"></td><td>Mortal Kombat 9</td></tr>
		<tr><td><input type="checkbox" name="amount_8" value="10"></td><td>Marvel Vs Capcom 3: Fate of Two Worlds</td></tr>
		<tr><td colspan="2">Nickname:</td></tr>
		<tr><td colspan="2"><input type="text" name="custom"></td></tr>
		<tr><td colspan="2"><input type="submit" value="Bevestig bestelling" class="button"></td></tr>
	</table>
	</form>
';
} else {
	//naam = Richard Ramcharan
	echo 'stap 2: Bevestig bestelling.
	<ul class="table_paypal">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_cart">
		<input type="hidden" name="upload" value="1">
		<input type="hidden" name="business" value="R.ramcharan@dutchnoobz.nl">
		<input type="hidden" name="currency_code" value="EUR">
		<input type="hidden" name="item_number_1" value="1">
		<input type="hidden" name="item_name_1" value="entree voor: '.$_POST['custom'].' ">
		<input type="hidden" name="amount_1" value="16.54">
';
		echo 'Nickname: '.$_POST['custom'].'<br /><br /> Games:';
	$i = 2;
	if ($_POST['amount_2']) {
		echo '<li>
		<input type="hidden" name="item_name_'.$i.'" value="Street fighter 2">
		<input type="hidden" name="amount_'.$i.'" value="10" checked>Street fighter 2<br /></li>';
		$i++;
	}
	if ($_POST['amount_3']) {
		echo '<li>
		<input type="hidden" name="item_name_'.$i.'" value="Street fighter 3: Third Strike">
		<input type="hidden" name="amount_'.$i.'" value="10" checked>Street fighter 3: Third Strike<br /></li>';
		$i++;
	}
	if ($_POST['amount_4']) {
		echo '<li>
		<input type="hidden" name="item_name_'.$i.'" value="Blazblue: Continuum Shift">
		<input type="hidden" name="amount_'.$i.'" value="10" checked>Blazblue: Continuum Shift<br /></li>';
		$i++;
	}	
	if ($_POST['amount_5']) {
		echo '<li>
		<input type="hidden" name="item_name_'.$i.'" value="Super Street Fighter 4">
		<input type="hidden" name="amount_'.$i.'" value="10" checked>Super Street Fighter 4<br /></li>';
		$i++;
	}
	if ($_POST['amount_6']) {
		echo '<li>
		<input type="hidden" name="item_name_'.$i.'" value="Tekken 6">
		<input type="hidden" name="amount_'.$i.'" value="10" checked>Tekken 6<br /></li>';
		$i++;
	}
	if ($_POST['amount_7']) {
		echo '<li>
		<input type="hidden" name="item_name_'.$i.'" value="Mortal Kombat 9">
		<input type="hidden" name="amount_'.$i.'" value="10" checked>Mortal Kombat 9<br /></li>';
		$i++;
	}
	if ($_POST['amount_8']) {
		echo '<li>
		<input type="hidden" name="item_name_'.$i.'" value="Marvel Vs Capcom 3: Fate of Two Worlds">
		<input type="hidden" name="amount_'.$i.'" value="10" checked>Marvel Vs Capcom 3: Fate of Two Worlds<br /></li>';
		$i++;
	}
	echo '
		</ul><input type="submit" value="to PayPal" class="button">
		
		</form>';
}
?>