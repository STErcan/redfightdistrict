<?php
function user_agent() {

	$useragent = $_SERVER['HTTP_USER_AGENT'];
	
	if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
		$browser_version=$matched[1];
		$browser = 'Internet Explorer';
	} else if (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
		$browser_version=$matched[1];
		$browser = 'Opera';
	} else if(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
		$browser_version=$matched[1];
		$browser = 'Firefox';
	} else if(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
		$browser_version=$matched[1];
		$browser = 'Chrome';
	} else if(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
		$browser_version=$matched[1];
		$browser = 'Safari';
	} else {
		// browser niet herkend!
		$browser_version = 0;
		$browser= '-Onbekend-';
	}
	
	return array($browser,$browser_version);
}

$browser = user_agent();

if ($browser[0] == 'Internet Explorer' && ($browser[1]*1)<8) {
	echo '
	<h1>Beste CMS gebruiker</h1>
	<p>Wij streven ernaar u de beste gebruikers-ervaring te bieden in dit CMS. <br />U browser: <b>'.$browser[0].' (versie '.$browser[1].')</b> 
	is helaas <span class="rood">niet geoptimaliseerd</span> om alle technieken, waarvan we gebruik maken, vloeiend en correct weer te geven. 
	Wij raden u daarom sterk aan om of de <a href="http://www.microsoft.com/netherlands/windows/internet-explorer/">nieuwste versie</a> van Internet Explorer te installeren of een keuze te maken uit deze alternatieven:</p>
	<ul id="browsers">
		<li id="firefox"><a href="http://www.mozilla-europe.org/nl/firefox/">Firefox</a></li>
		<li id="chrome"><a href="http://www.google.nl/chrome/">Google Chrome</a></li>
		<li id="opera"><a href="http://www.opera.com/download/">Opera</a></li>
	</ul>	
	';
} else {
	echo '
	<h1>Beste gebruiker</h1>
	<p>Wij streven ernaar u de beste gebruikers-ervaring te bieden in dit CMS. <br />Uw browser: <b>'.$browser[0].' (versie '.$browser[1].')</b> voldoet aan de eisen om dit mogelijk te maken.</p>	
	';
}
?>
