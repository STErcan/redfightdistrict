<?php
## -- algemene php functies


// print_r verkort
function pr($array) {
	echo '<pre class="print_r">'."\n";
	print_r($array);
	echo '</pre>'."\n";
}



// anti-skype fix for telephonenumbers
function unskype($string)
{
	$array_string = str_split($string);
	if (count($array_string)>0) {
		foreach ($array_string as $key => $val) {
			$new_string .= '&#'.ord($val).'';
		}
		return $new_string;
	} else {
		return $string;
	}
}



// json ajax
if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}


// set icon
function file_icon($file_naam, $dir = 'img/icons/doc_types/') {
	$icon_array = array(
		
		// documenten
		'txt' => 'txt',
		'doc' => 'doc',
		'docx' => 'doc',
		'rtf' => 'doc',
		'odt' => 'doc',
		'xls' => 'xls',
		'xlsx' => 'xls',
		'odf' => 'xls',
		'ods' => 'xls',
		'pdf' => 'pdf',
		'ppt' => 'ppt',
		'odp' => 'ppt',
		
		'html' => 'html',
		'htm' => 'html',
		'asp' => 'html',
		'php' => 'php',
		'sql' => 'sql',
		'xml' => 'xml',
		'js' => 'js',
		'css' => 'css_incl',
		'inc' => 'webdev_incl',
		
		// media
		'gif' => 'image',
		'jpg' => 'image',
		'png' => 'image',
		'jpeg' => 'image',
		'bmp' => 'image',
		'tiff' => 'image',
		'tif' => 'image',
		'odc' => 'image',
		'odg' => 'image',
		'odi' => 'image',
		
		'mp3' => 'audio',
		'ogg' => 'audio',
		'wma' => 'audio',
		'rm' => 'audio',
		'wav' => 'audio',
		'aiff' => 'audio',
		'm3u' => 'audio',
		
		'psd' => 'psd',
		'ai' => 'vector',
		'eps' => 'vector',
		'fla' => 'fla',
		'swf' => 'swf',
		
		'avi' => 'film',
		'wmv' => 'film',
		'mpg' => 'film',
		'mpeg' => 'film',
		'divx' => 'film',
		'mov' => 'mov',
		'asf' => 'film',
		'ram' => 'film',
		
		// archives
		'rar' => 'zip',
		'7z' => 'zip',
		'zip' => 'zip',
		'tar' => 'zip',
		'gz' => 'zip',
		'rpm' => 'zip',
		'iso' => 'zip',
		
		// meuk
		'rss' => 'feed',
		'log' => 'log',
		
		
		// default
		'default' => 'generic',
	);
	
	$file_ext = extention($file_naam);
	if (array_key_exists($file_ext, $icon_array)) {
		$icon = 'icon_'.$icon_array[$file_ext].'.gif';	
	} else {
		$icon = 'icon_'.$icon_array['default'].'.gif';	
	}
	
	if ($file_naam != '') {
		return '<img src="'.$dir.$icon.'" align="absmiddle" />';
	} else {
		return '';
	}
}



// privileges beveiliging admin
function priv($priv_array) {
	global $cms_config;
	if (in_array($_SESSION['safe_'.$cms_config['token']]['priv'],$priv_array)) {
		return true;
	} else {
		return false;
	}
}

// fix verboden karakters in url of database
function fix_url($str, $replace = '-') {
	if (is_string($str) && strlen($str) > 0){
		// nasty chars verwijderen
		$pattern[5] = '\'';
		$pattern[4] = '"';
		$pattern[0] = '&';
		$str = str_replace($pattern, '', html_entity_decode($str));
		$str = html_entity_decode(preg_replace('~&([a-z])(?:tilde|elig|zlig|cedil|acute|uml|grave|circ|slash|ring);~i', '$1', htmlentities($str)));
		return strtolower(str_replace(' ', $replace, trim(preg_replace('~(?:\s|[^a-z0-9_])+~i', ' ', $str))));
	}
	return '';
}



// vertaling
function _l($idx=''){
	if(empty($idx)) {
		return 'Taal-index leeg';
	}
	global $_lang;
	if(isset($_lang[$idx])) {
		return $_lang[$idx];
	}
	return '&raquo;'.$idx.'&laquo;';
}


// maak paginering via GET
function create_nav_get($totaal, $start, $limiet, $url_start, $url_einde) {
	// beginwaarden
	$nav_verder = $start + $limiet; 
	$nav_terug = $start - $limiet; 
	$nav_einde = (ceil($totaal /$limiet) - 1) * $limiet;
	$nav_begin = 0;
	$nav_show = 20;
	if(empty($start))$start=1;

	// verder en terug zoeken
	if (($start+1*$limiet)<= $totaal) {
		$vooruit = true;
	}
	if ($start>1) {
		$achteruit = true;
	}
	
	// paginering
	$nav_pagina_totaal = ceil($totaal/$limiet);
	$nav_pagina_huidig = (ceil($start/$limiet));
	$nav_pagina_volgende = ($vooruit ? ($start+1) : $start);
	$nav_pagina_vorige = ($achteruit ? ($start-1) : $start);
	
	// pagina navigatie
	if ($totaal > $limiet) {
		echo '<div class="terug_verder">pagina: ';
		echo '<a href="'.$url_start.'/1'.$url_einde.'" id="vorige">&laquo;</a>';
		if($start > $nav_show) print (" &hellip; ");
		for($pg=1; $pg<=$nav_pagina_totaal; $pg++) {
			$id = ($pg==$start) ? ' id="huidig"' : ' id="pagina"';
			if(($pg > ($start - $nav_show)) && ($pg < ($start + $nav_show))) {
				echo '<a'.$id.' href="'.$url_start.'/'.$pg.$url_einde.'">'.$pg.'</a>';
			}
		}
		if($nav_pagina_totaal>=($start+$nav_show)) print(" &hellip; ");
		echo '<a href="'.$url_start.'/'.$nav_pagina_totaal.$url_einde.'" id="volgende">&raquo;</a>';
		echo ' ('.$nav_pagina_totaal.' totaal)';
		echo '</div>';
	}
}


// array opschonen
function sanitize_html($string)
{
  $pattern[0] = '&';
  $pattern[4] = '"';
  $pattern[5] = '\'';
  $pattern[6] = "%";
  $pattern[7] = '(';
  $pattern[8] = ')';
  $replacement[0] = '&amp;';
  $replacement[4] = '&quot;';
  $replacement[5] = '&#39;';
  $replacement[6] = '&#37;';
  $replacement[7] = '&#40;';
  $replacement[8] = '&#41;';
  return str_replace($pattern, $replacement, $string);
}
function sanitize($input, $html=false){
    if(is_array($input)){
        foreach($input as $k=>$i){
            $output[$k]=sanitize($i);
        }
    } else {
        if(get_magic_quotes_gpc()){
            $input=stripslashes($input);
        }       

		if ($html == true) {
			$input=sanitize_html($input);
		}
		
		$output=mysql_real_escape_string($input);
    }   
   
    return $output;
}


// maak array
function maak_array($sql,$key,$waarde) {
	global $server, $gebruiker, $wachtwoord, $database;
	$resultaat = mysql_query($sql);
	if ($resultaat) {
		$aantal = mysql_num_rows($resultaat);
		if ($aantal >= 1)  {
			for ($i=1; $i<=$aantal; $i++) {
				extract(mysql_fetch_array($resultaat));
				$array[$$key] = $$waarde;
			}
		}
	} else {
		echo 'ERROR: fout in sql: ['.$sql.']';
	}
	return $array;
}


// verwijder een item uit array
function array_verwijder($val, &$arr) {
	  $array_remval = $arr;
	  for($x=0;$x<count($array_remval);$x++)
	  {
		  $i=array_search($val,$array_remval);
		  if (is_numeric($i)) {
			$array_temp  = array_slice($array_remval, 0, $i );
			$array_temp2 = array_slice($array_remval, $i+1, count($array_remval)-1 );
			$array_remval = array_merge($array_temp, $array_temp2);
		  }
	  }
	  return $array_remval;
}


// get url
function get_url() {
	if ($_SERVER['argv'][0]) {
		$urlstring = '?'.$_SERVER['argv'][0];
		return $urlstring;
	}
}


// filenaam inkorten met behoud extentie
function file_inkorten($tekst, $max_tekens) {
	$max_tekens;
	$tekst_clean = strip_tags(html_entity_decode($tekst));
  	
	$extentie_array = explode(".",$tekst_clean);
	$extentie = $extentie_array[count($extentie_array)-1];
	$tekst = array_verwijder($extentie, $extentie_array);
	$tekst_tmp = implode('',$tekst);
	if (strlen($tekst_tmp) <= $max_tekens) {
		return $tekst_clean;
	} else {
		$afbreken = (strlen($tekst_tmp)-$max_tekens);
		$tekst = substr($tekst_tmp, 0, -$afbreken);
		$tekst .= "&hellip;";
		return $tekst." .".$extentie;
	}
}


// tekst inkorten
function inkorten($string, $maxChars, $separator = ' ', $break = ' &hellip;', $charset = 'utf8'){
	$van = array('#(<[/]?br.*>)#U','#(<[/]?p.*>)#U','#(<[/]?div.*>)#U');
	$naar = ' ';
	$string = preg_replace($van, $naar, $string);
	$string = strip_tags(html_entity_decode($string));
	if ($charset == 'utf8') {
		$string = utf8_encode($string);
	}
	
    if(strlen($string) < $maxChars){
        return $string;
    }
    else{
        $words = explode($separator, $string);
        $numWords = (is_array($words)) ? count($words) : 1;
        if($numWords == 1){
            return substr($string, 0, $maxChars).$break;
        }
        else{
            $myStr = array();
            $sepLen = strlen($separator);
            for($i=0; $i < $numWords; $i++){
                    $myStr[] = $words[$i];
                    $curLen = strlen(implode($separator, $myStr));
                    $nextW = (array_key_exists(($i+1), $words)) ? strlen($words[($i+1)]) : 0;
                    $nextLen = (strlen(implode($separator, $myStr)) + $nextW)+$sepLen;
                    if($nextLen > $maxChars){
                        break;
                    }
            }
            return implode($separator, $myStr).$break;
        }
    }
}


// tekst inkorten
function inkorten_midden($string, $max, $separator = ' &hellip; '){
    if(strlen($string) < $max){
        return $string;
    }
	$separatorlength = strlen(($separator==' &hellip; ') ? '12345' : $separator) ;
	$maxlength = $max - $separatorlength;
	$start = $maxlength / 2 ;
	$trunc =  strlen($string) - $maxlength;
	
	return substr_replace($string, $separator, $start, $trunc);
}


// permalink
function permalink_check($permalink, $id, $return_clean=true, $site_id=1, $type = false) {
	
	$permalink = fix_url($permalink);
	
	$sql = "SELECT `meta_url` FROM `paginas` WHERE `meta_url` = '".$permalink."' AND `pagina_id` != '".$id."' AND `site_id` = '".$site_id."'".($type != false ? " AND `type` = '".$type."'" : "")." LIMIT 0,1";
	$resultaat = mysql_query($sql) or die ("|$sql|:" . mysql_error());
	$aantal = mysql_num_rows($resultaat);
	if ($aantal == 1) {
		extract(mysql_fetch_array($resultaat,MYSQL_ASSOC));
		$tmp['kort'] = inkorten_midden($meta_url.'-2',31);
		$tmp['normaal'] = $meta_url.'-2';
		
		//controleer nieuwe permalink
		$sql = "SELECT `meta_url` FROM `paginas` WHERE `meta_url` = '".$tmp['normaal']."' AND `pagina_id` != '".$id."' AND `site_id` = '".$site_id."'".($type != false ? " AND `type` = '".$type."'" : "")." LIMIT 0,1";
		$resultaat = mysql_query($sql) or die ("|$sql|:" . mysql_error());
		$aantal = mysql_num_rows($resultaat);
		if ($aantal == 1) {
			if(!$return_clean) {
				$tmp = permalink_check($tmp['normaal'], $id, $return_clean, $site_id);
				$tmp = explode('*',$tmp);
			} else {
				$tmp['normaal'] = permalink_check($tmp['normaal'], $id, $return_clean, $site_id, $type);
			}
		}
		
	} else {
		$tmp['kort'] = inkorten_midden($permalink,31);
		$tmp['normaal'] = $permalink;
	}
	
	return (!$return_clean ? implode('*',$tmp) : $tmp['normaal']);
}


//aanwezigheid checken van bestand (en hernoemen indien nodig)
function check_file($dir, $file_name, $file_counter=0, $file_name_clean=false, $file_name_ext=false) {
	
	// clean up filename
	if (!$file_name_clean) {
		$file_name_sanitized = sanitize_file_name($file_name);
		$file_name_ext = '.'.extention($file_name_sanitized);
		$file_name_ext_len = strlen($file_name_ext);
		$file_name_clean = substr($file_name_sanitized, 0, -$file_name_ext_len); // file_name without extention
	}
	
	if (file_exists($dir.$file_name_clean.($file_counter>0 ? '-'.$file_counter : '').$file_name_ext)) {
		$file_counter++;
		return check_file($dir, $file_name, $file_counter, $file_name_clean, $file_name_ext);
	} else {
		return $file_name_clean.($file_counter>0 ? '-'.$file_counter : '').$file_name_ext;
	}
}


// voor ajax module
function upload_file_ajax($input, $dir, $encrypt=false, $thumb=false) {
	if (@is_uploaded_file($input['tmp_name'])) {
		// bestandsnaam opschonen
		if ($encrypt == true) {
			$extentie = extention($input['name']);
			$file_naam = date('YmdHis').'_'.md5($input['name'].date('YmdHis').rand(0,1979)).'.'.$extentie;
		} else {
			$file_naam = $input['name'];
		}
		$file_naam = check_file($dir, $file_naam);
		
		if (move_uploaded_file($input['tmp_name'], $dir.$file_naam)) {
			$output = $file_naam;
		}
		// thumb extentie
		if ($thumb == true) {
			$extentie = extention($file_naam);
			$file_naam_clean = substr($file_naam, 0, -(strlen($extentie)+1));
			$thumb_naam = $file_naam_clean.'_thumb.'.$extentie;
			@copy($dir.$file_naam, $dir.$thumb_naam);
		}
		
	}
	return $output;
}


// dir verwijderen
function remove_dir($dir, $DeleteMe, $check_minutes=30) {
	$check_date = date('Y-m-d H:i:s', strtotime('-'.$check_minutes.' minutes'));
    if(!$dh = @opendir($dir)) return;
    while (false !== ($obj = readdir($dh))) {
        $last_modified = date('Y-m-d H:i:s',filemtime($dir.'/'.$obj)); 
		if($last_modified > $check_date) continue;
		if($obj=='.' || $obj=='..') continue;
        if (!@unlink($dir.'/'.$obj)) remove_dir($dir.'/'.$obj, true);
    }
    closedir($dh);
    if ($DeleteMe){
        @rmdir($dir);
    }
}


// bestandsgrootte weergeven
function file_size_info($bytes) { 
	$bytes = abs($bytes);
	$units = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
	$units = array_reverse($units, true);
	foreach($units as $num => $unit){
		if($bytes >= pow(1024, $num)){
			return sprintf("%.2f %s", $bytes / pow(1024, $num), $unit);
		}
	}
	return "0 b";
} 


// controleer op http in url
function check_url($url) {
  $check = substr($url, 0, 7);
  if ($check == 'http://') {
    return $url;
  } else {
    return 'http://'.$url;
  }
}

// string opschonen van spaties en ongewenste tekens
function sanitize_file_name($file_name) {
	// tekens vervangen met underscore
	$verboden_vervangen = array(' ', '%20');
	$file_name = str_replace($verboden_vervangen, '_', $file_name);
	// tekens verwijderen
	$verboden_verwijderen = array("+", "&", "@", "#", "\'", "\'", "\'", "\"", ":", ";", "!", "?", "%", "$", "~", "`", "^", "\\", ";", "/", "=", ">", "<", ",", "(", ")", "{", "}", "[", "]", "<", ">", chr(0));
	$file_name = str_replace($verboden_verwijderen, '', $file_name);
	// dubbele underscores verwijderen
	$file_name = str_replace('__', '_', $file_name);
	return strtolower($file_name);
}


// neem bestands extentie
function extention($file_name) {
	$array_file_name = explode(".",basename($file_name));
	return $array_file_name[count($array_file_name)-1];
}


// maak nieuwe file naam
function set_file_name($file_name, $thumb_ext = 'thumb') {
	$extention = extention($file_name);
	$file_name_clean = substr($file_name, 0, -(strlen($extention)+1));
	$thumb_name = $file_name_clean.'_'.$thumb_ext.'.'.$extention;
	return $thumb_name;
}

// js redirect functie 
function redirect($url, $tijd=1500) {
  $aap = "
  <script language=\"JavaScript\">
	$(document).ready(function(){
      setTimeout(\"window.location = '".$url."'\",".$tijd.");
	});
	$('#wijzig').show().append('<span id=\"loader\" style=\"background-color:#f60;width:0px;height:5px;display:none;\"></span>');
	$('#loader').animate({'width':'400px', 'opacity':'show'},".($tijd-100).");
  </script>
  ";
  return $aap;
}


// tijd minus de seconden
function tijd($a) {
	$tijd = substr($a, 0, 5);
	return $tijd;
}


// datum omzetten van EN naar NL + tijd
function datum_nl($datum, $tekst=false, $tijdnotatie=false, $tijdnotatie_clean=false) {
	if($datum=='') return;
	$dag = substr($datum, 8, 2);
	$maand = substr($datum, 5, 2);
	$jaar = substr($datum, 0, 4);
	if ($tekst) {
		$weekdag = weekdag($datum);
		$maand_naam = maand_naam($maand*1);
		$tijd = substr($datum, 11, 5);
		return $weekdag.' '.($dag*1).' '.$maand_naam.' '.$tijd.' '.$jaar;
	} else if ($tijdnotatie_clean) {
		$tijd = substr($datum, 11, 5);
		return "$dag-$maand-$jaar $tijd";
	} else if ($tijdnotatie) {
		$tijd = substr($datum, 11, 5);
		return "$dag-$maand-$jaar (<small>$tijd</small>)";
	} else {
		return "$dag-$maand-$jaar";
	}
}


// datum omzetten van NL naar EN + tijd
function datum_en($a, $tijd=false) {
  if($a=='') return;
  $dag = substr($a, 0, 2);
  $maand = substr($a, 3, 2);
  $jaar = substr($a, 6, 4);
	if ($tijd) {
		return "$jaar-$maand-$dag <small>($tijd)</small>";
	} else {
		return "$jaar-$maand-$dag";
	}
}


// retourneer de weekdag adhv datum (naam of nummer!)
function weekdag($datum, $nr = false) {
	if ($nr) {
		$week_dag = intval(substr($datum, 0, 2));
		return $week_dag;
	}
	$dagen_array = array('Zondag','Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag','Zaterdag');
	if ($datum != '0000-00-00' && $datum != '') {
		$week_num = date("w", strtotime($datum));
		$week_dag = $dagen_array[$week_num];
	} else {
		$week_dag = '&nbsp;';
	}
	return $week_dag;
}


function maand_naam($maand) {
	//--eerste item in array leeg zodat de index van array = maandnr
	$maanden_array = array('','januari','februari','maart','april','mei','juni','juli','augustus','september','oktober','november','december');
	if ($maand != '') {
		if ($maand<10 && strlen($maand)>1){
			$maand=substr($maand,1,2);
		}
		$maand_naam = $maanden_array[$maand];
	} else {
		$maand_naam = '&nbsp;';
	}
	return $maand_naam;
}


// format bedrag naar 0,00
function format_bedrag($doekoes) {
	$format = sprintf('%01.2f', $doekoes);
	$format = str_replace ('.', ',', $format);
	return $format;
}


// maak menu
function maak_menu($array) {
	echo "\n".'	  <ul>'."\n";
	if (count($array)>0) {
		foreach ($array as $key => $waarde) {
		  list($pagina, $link_type, $titel, $type) = $waarde;
			switch ($link_type) {
				case 'titel':
					echo '	    <li class="titel">'.$titel.'</li>'."\n";
					break;
				case 'link':
					echo '	    <li class="link'.(($_GET['pagina']==$pagina) && ($_GET['type']==$type) ? ' actief' : '').'"><a href="?pagina='.$pagina.($type ? '&amp;type='.$type : '').'&amp;content=overzicht">'.$titel.'</a></li>'."\n";
					break;
				case 'sublink':
					echo '	    <li class="sublink'.(($_GET['pagina']==$pagina) && ($_GET['type']==$type) ? ' actief' : '').'"><a href="?pagina='.$pagina.($type ? '&amp;type='.$type : '').'&amp;content=overzicht">&bull; '.$titel.'</a></li>'."\n";
					break;
				case 'spatie':
					echo '	    <li class="spatie">&nbsp;</li>'."\n";
					break;
			}
		}
	}
	echo '	  </ul>'."\n\n";
}

function check_email_adres($email) {
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		return false;
	}
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			return false;
		}
	}
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false;
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

function get_titel($id){
	$sql = "SELECT `titel` FROM `paginas` WHERE `pagina_id` = '".$id."' LIMIT 1";
	$resultaat = mysql_query($sql) or die (mysql_error());
	$aantal = mysql_num_rows($resultaat);
	if ($aantal == 1) {
		extract(mysql_fetch_assoc($resultaat));
		return $titel;
	}
}
?>