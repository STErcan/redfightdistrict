<?php
session_start();

## -- requirements en start mysql
require_once("../../class/db.class.php");
require_once("../../includes/config.inc.php");
require_once("../../includes/functies.inc.php");

## -- dB connectie maken
$db = new db($array_dbvars);
?>