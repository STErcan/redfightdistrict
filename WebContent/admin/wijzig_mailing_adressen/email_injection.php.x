<?php
// requirements
require_once('../ajax_header.php');
require_once('config.php');

$array_naam[] = 'Joep';
$array_naam[] = 'Frank';
$array_naam[] = 'Jeroen';
$array_naam[] = 'Sandra';
$array_naam[] = 'Micha';
$array_naam[] = 'Marjolein';
$array_naam[] = 'Sander';
$array_naam[] = 'Harm';
$array_naam[] = 'Bjelke';
$array_naam[] = 'Ron';
$array_naam[] = 'Lucille';
$array_naam[] = 'Leila';
$array_naam[] = 'Cees';
$array_naam[] = 'Gisela';
$array_naam[] = 'Loes';
$array_naam[] = 'Sanne';
$array_naam[] = 'Roos';
$array_naam[] = 'Eva';
$array_naam[] = 'Henk';
$array_naam[] = 'Dennis';
$array_naam[] = 'Joris';
$array_naam[] = 'Bjorn';
$array_naam[] = 'Maarten';
$array_naam[] = 'Hans';
$array_naam[] = 'Bert';
$array_naam[] = 'Cor';
$array_naam[] = 'Danny';
$array_naam[] = 'Evert';
$array_naam[] = 'Ferry';
$array_naam[] = 'Goedele';
$array_naam[] = 'Harriet';
$array_naam[] = 'Jolanda';
$array_naam[] = 'Kim';
$array_naam[] = 'Lars';


$array_achter[] = ' van Son';
$array_achter[] = ' van Battum';
$array_achter[] = ' van Hert';
$array_achter[] = ' van der Weegen';
$array_achter[] = ' van Bom';
$array_achter[] = ' de Zomer';
$array_achter[] = ' de Baars';
$array_achter[] = ' den Hert';
$array_achter[] = ' de Weg';
$array_achter[] = ' de Bruijn';
$array_achter[] = ' de Koning';
$array_achter[] = ' de Bakker';
$array_achter[] = ' Jansen';
$array_achter[] = ' Janssen';
$array_achter[] = ' Evers';
$array_achter[] = ' de Groot';
$array_achter[] = ' Vercammen';
$array_achter[] = ' van Esch';
$array_achter[] = ' Aarts';
$array_achter[] = ' Schuijn';
$array_achter[] = ' Beekmans';
$array_achter[] = ' Beckmans';

$array_domein[] = 'hotmail.com';
$array_domein[] = 'hotmail.com';
$array_domein[] = 'gmail.com';
$array_domein[] = 'gmail.com';
$array_domein[] = 'hetnet.nl';
$array_domein[] = 'wanadoo.nl';
$array_domein[] = 'chello.nl';
$array_domein[] = 'kpn.nl';
$array_domein[] = 'home.nl';

$array_replace[] = '.';
$array_replace[] = '_';
$array_replace[] = '';

$array_type[] = 'html';
$array_type[] = 'txt';
$array_type[] = 'html';

// array mailing lijsten
$sql = "SELECT * FROM `mailing_lijsten` ORDER BY `positie`, `lijst_naam`";
$resultaat = mysql_query($sql) or die ("|$sql|:" . mysql_error());
$aantal = mysql_num_rows($resultaat);
if ($aantal >= 1) {
	for ($i=1; $i<=$aantal; $i++) {
		extract(mysql_fetch_array($resultaat));
			$array_lijsten[] = $lijst_id;
	}
}


// nieuw
if ($_GET['aantal'] > 0) {

	for ($i=1; $i<=$_GET['aantal']; $i++) {
		$flok = rand(0,(count($array_naam)-1));
		$plok = rand(0,(count($array_achter)-1));
		$klok = rand(0,(count($array_replace)-1));
		$blok = rand(0,(count($array_domein)-1));
		$slok = rand(0,1);
		$xlok = rand(0,(count($array_lijsten)-1));
		
		$email_naam = $array_naam[$flok].$array_achter[$plok];
		$email_adres = str_replace( ' ', $array_replace[$klok], strtolower($email_naam) ).'@'.$array_domein[$blok];
		$email_type = $array_type[$slok];
		$status = $_GET['status'];
		$email_lijst = ','.$array_lijsten[$xlok].',';
		
		// nieuwe record in dB
		$sql = "INSERT INTO `".$tabelnaam."` (email_id, email_adres, email_naam, email_type, email_lijst, status) ";
		$sql .= "VALUES (NULL, '".$email_adres."', '".$email_naam."', '".$email_type."', '".$email_lijst."', '".$status."')";
		mysql_query($sql) or die ("SQL-opdracht is mislukt [$sql]: ".mysql_error());
		
		echo '+ '.$email_naam.' - '.$email_adres.' ['.$email_type.']<br />';
	}
	
}
?>
<a href="?aantal=25&status=0">25 actieve abonnees</a><br />
<a href="?aantal=5&status=1">5 inactieve abonnees</a>
