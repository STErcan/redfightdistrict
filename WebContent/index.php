<?php
## -- start sessie
session_start();


## -- requirements
require_once("class/db.class.php");
require_once("includes/config.inc.php");
require_once("includes/functies.inc.php");


## -- dB connectie maken
$db = new db($array_dbvars);


## -- redirect
if ($_GET['pagina']=='redirect') {
	header('Location: '.$base_href.'home.htm');
}


## -- header
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon"
	href="http://www.redfightdistrict.com/img/favicon.ico">
<base href="<?php echo $base_href; ?>" />
<?php include('meta.php'); ?>
<meta name="robots" content="index, follow" />
<meta name="author"
	content="BE interactive webdesign, www.beinteractive.nl" />
<meta name="copyright" content="Copyright (c) <?php echo date("Y"); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-style-type" content="text/css" />
<!-- css -->
<link rel="stylesheet" media="all" href="_main.css" />
<link rel="stylesheet" media="screen" href="css/jquery.fancybox.css" />
<link rel="stylesheet" media="screen"
	href="css/jquery-ui-1.8.5.custom.css" />
<!-- javascript -->
<script type="text/javascript"
	src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/corner.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.1.pack.js"></script>
<script type="text/javascript" src="js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/jquery.swf.js"></script>
<script type="text/javascript" src="js/dropdown.js"></script>
<script type="text/javascript" src="js/cufon.js"></script>
<script type="text/javascript" src="js/cg_omega_400.font.js"></script>
<script type="text/javascript" src="js/fbox.js"></script>
</head>
<body>
	<div id="wrapper">
		<!-- <div id="quick_games">
			<div id="quick_games_left">
				<img src="../img/images/GamesLeft_01.png" />
				<img src="../img/images/GamesLeft_02.png" />
				<img src="../img/images/GamesLeft_03.png" />
				<img src="../img/images/GamesLeft_04.png" />
			</div>
			
			<div id="quick_games_right">
				<img src="../img/images/GamesRight_01.png" />
				<img src="../img/images/GamesRight_02.png" />
				<img src="../img/images/GamesRight_03.png" />
				<img src="../img/images/GamesRight_04.png" />
			</div>
		</div>
		<div class="clear"></div> -->
		<div id="background_top">
		<nav id="navigation_menu">
			<nav id="navigation_menu_left">
				<a href="home.htm">HOME</a>
				<?php
				// get first url events
				$sql_menu_events = "SELECT `meta_url` AS `news_url`,`pagina_id` FROM `paginas` WHERE `type` = 'nieuws' ORDER BY `positie` LIMIT 1";
				$result_menu_events = $db->select($sql_menu_events);
				$rows_menu_events = $db->row_count;
				if ($rows_menu_events == 1)
				{
					$array_menu_events = $db->get_row($result_menu_events);
				}
	
				echo '<a href="news/'.$array_menu_events['news_url'].'.htm">NEWS</a>';
				?>
				<a href="games.htm">GAMES</a>
			</nav>
			<nav id="navigation_menu_right">
				<a href="tickets.htm">TICKETS</a>
				<a href="rules.htm">RULES</a>
				<a href="venue.htm">VENUE</a>
				<a href="about.htm">ABOUT</a>
			</nav>
		</nav>
			<div id="background_top1">
				<img src="../img/images/rfd_01.png" />
			</div>
			<div id="background_top2">
				<img src="../img/images/rfd_02.png" />
			</div>
			<div id="background_top3">
				<img src="../img/images/rfd_03.png" />
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_holder">
			<?php
			if ($_GET['meta_url']=='home')
			{
				echo '<div id="top_image"><img src="../img/images/topimages/home.jpg" /></div>';
				echo '<p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='rules')
			{
				echo '<h1 class="page_header">'.$array_meta['titel'].'</h1><p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='venue')
			{
				echo '<div id="top_image"><img src="../img/images/topimages/venue.png" /></div>';
				echo '<h1 class="page_header">'.$array_meta['titel'].'</h1><p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='about')
			{
				echo '<div id="top_image"><img src="../img/images/topimages/about.png" /></div>';
				echo '<h1 class="page_header">'.$array_meta['titel'].'</h1><p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='games')
			{
				echo '<h1 class="page_header">'.$array_meta['titel'].'</h1><p>'.$array_meta['tekst'].'</p>';
				echo '<div id="games_holder">
						<div>
						<a href="games/super-street-fighter-4.htm" ><img src="../img/games/ssf4.jpg"/></a>
						<a href="games/ultimate-marvel-vs-capcom-3.htm" ><img src="../img/games/umvsc3.jpg"/></a>
						<a href="games/tekken-tag-tournament-2.htm" ><img src="../img/games/ttt2.jpg"/></a>
						<a href="games/street-fighter-3.htm" ><img src="../img/games/ssf3.jpg"/></a>
						</div>
				
						<div>
						<a href="games/street-fighter-2-turbo.htm" ><img src="../img/games/ssf2t.jpg" width="200" height="100"/></a>
						<a href="games/soul-calibur-v.htm" ><img src="../img/games/scv.jpg" width="200" height="100"/></a>
						<a href="games/virtua-fighter-v.htm" ><img src="../img/games/vvv.jpg" width="200" height="100"/></a>
						<a href="games/KOF-XIII.htm" ><img src="../img/games/kofxiii.jpg" width="200" height="100"/></a>
						</div>
					</div>';
			}
			else if ($_GET['meta_url']=='super-street-fighter-4')
			{
				echo '<img class="game_image" src="../img/games/ssf4.jpg" />';
				echo '<div id="top_image"><img src="../img/images/topimages/AE.png" /></div>';
				echo '<p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='ultimate-marvel-vs-capcom-3')
			{
				echo '<img class="game_image" src="../img/games/umvsc3.jpg" />';
				echo '<div id="top_image"><img src="../img/images/topimages/MVC3a.png" /></div>';
				echo '<p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='tekken-tag-tournament-2')
			{
				echo '<img class="game_image" src="../img/games/ttt2.jpg" />';
				echo '<div id="top_image"><img src="../img/images/topimages/ttt2.png" /></div>';
				echo '<p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='street-fighter-3')
			{
				echo '<img class="game_image" src="../img/games/ssf3.jpg" />';
				echo '<div id="top_image"><img src="../img/images/topimages/SF3.png" /></div>';
				echo '<p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='street-fighter-2-turbo')
			{
				echo '<img class="game_image" src="../img/games/ssf2t.jpg" />';
				echo '<div id="top_image"><img src="../img/images/topimages/ST.png" /></div>';
				echo '<p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='soul-calibur-v')
			{
				echo '<img class="game_image" src="../img/games/scv.jpg" />';
				echo '<div id="top_image"><img src="../img/images/topimages/SCV.png" /></div>';
				echo '<p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='virtua-fighter-v')
			{
				echo '<img class="game_image" src="../img/games/vvv.jpg" />';
				echo '<div id="top_image"><img src="../img/images/topimages/VF5.png" /></div>';
				echo '<p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='KOF-XIII')
			{
				echo '<img class="game_image" src="../img/games/kofxiii.jpg" />';
				echo '<div id="top_image"><img src="../img/images/topimages/KOF13.png" /></div>';
				echo '<p>'.$array_meta['tekst'].'</p>';
			}
			else if ($_GET['meta_url']=='tickets')
			{
				echo '<h1 class="page_header">'.$array_meta['titel'].'</h1><p>'.$array_meta['tekst'].'</p>';
				require_once('paypal.php');
			}
			else
			{
				echo '<div id="content_holder_half">';
				echo '<h1 class="page_header">'.$array_meta['titel'].'</h1><p>'.$array_meta['tekst'].'</p>';
				echo '</div>';

				echo '<div id="content_news">';
				echo '<h1>Latest News</h1>';
				$sql_news = "SELECT * FROM `paginas` WHERE `type` = 'nieuws' ORDER BY `datum` DESC";
				$result = $db->select($sql_news);
				$rows = $db->row_count;
				if ($rows >= 1)
				{
					for ($i=1; $i<=$rows; $i++)
					{
						$array_news = ($db->get_row($result));
						echo '<div class="newsitem">';
						echo '<a class="newstitel" href="news/'.$array_news['meta_url'].'.htm">';
						echo '<div>'.$array_news['titel'].'</div>';
						echo '</a>';
						echo '<br />';
						echo '<i>'.$array_news['datum'].'</i>';
						echo '</div>';
					}
				}
				echo '</div>';
				echo '<div class="clear"></div>';
			}
			?>
		</div>
		<div id="background_bottom">
			<div id="background_bottom1">
				<img src="../img/images/rfd_06.png" />
			</div>
			<div id="background_bottom2">
				<img src="../img/images/rfd_09.png" />
			</div>
			<div id="background_bottom3">

				<img src="../img/images/rfd_08.png" />
			</div>
		</div>
		<div class="clear"></div>
	</div>
</body>
</html>
