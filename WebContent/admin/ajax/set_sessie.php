<?php
// requirements
include('../ajax_header.php');

$_SESSION[$_GET['sessie_naam']] = $_GET['sessie_waarde'];
?>