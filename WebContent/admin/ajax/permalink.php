<?php
include('../ajax_header.php');
include('../../includes/config.inc.php');

echo permalink_check($_GET['permalink'], $_GET['id'], false,$_SESSION['safe_'.$cms_config['token']]['site_id']);
?>