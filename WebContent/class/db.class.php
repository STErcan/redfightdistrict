<?php
/*
Database class 
Company:	BE Interactive 
Author:		Jeroen Evers
Date: 		2010-07-22

Opmerking:
Ik programmeer deze eerste officiele class met engeltalige functies en variabelen.
Alle opmerkingen blijven nog wel nederlands
*/


class db { 
	public $host;
	public $username;
	public $password;
	public $database;
	public $db_link;
	
	private $debug;
	private $utf8; // set UTF8 verbinding
     
	function __construct($array_dbvars) { 
		$this->host = $array_dbvars['host']; 
		$this->username = $array_dbvars['username']; 
		$this->password = $array_dbvars['password']; 
		$this->database = $array_dbvars['database']; 
		
		$this->debug = ($array_dbvars['debug'] ? $array_dbvars['debug'] : false); 
		$this->utf8 = ($array_dbvars['utf8'] ? $array_dbvars['utf8'] : true); 
		
		$this->connect(); 
	} 

	function connect() {
 
		$this->db_link = mysql_connect($this->host, $this->username, $this->password);
 
		// controleer op een connectie error
		if (!$this->db_link) {
			$this->set_error(mysql_error());
			return false;
		} 
  
		// selecteer dB
		if (!$this->select_db()) return false;
		
		return $this->db_link;  // success
	}

	function select_db($alt_database=false) {
		
		// set utf-8 verbinding
		if ($this->utf8==true) {
			mysql_query('SET NAMES utf8');
		}
		
		// standaard dB overschrijven indien nodig
		if (!empty($alt_database)) $this->database = $alt_database; 
      
		if (!mysql_select_db($this->database)) {
			$this->set_error(mysql_error());
			return false;
		}
 
		return true;
	}

	function select($sql) {
	
		$this->current_sql = $sql;
		
		// geef resultaat terug
		$result = mysql_query($sql);
		if (!$result) {
			$this->set_error(mysql_error());
			return false;
		} else {
			$this->row_count = mysql_num_rows($result);
			return $result;
		}
	}

	function get_row($result) {
	
		// geef rij waardes terug
		if (!$result) {
			$this->set_error('Invalid resource identifier passed to get_row() function.');
			return false;  
		} else {
			$row = mysql_fetch_assoc($result);
		}
		
		if (!$row) {
			return false;
		} else {
			return $row;
		}
	}

	function get_array($result) {
	
		// maak totaal array van resultaat
		$rows = $this->row_count;
		if ($rows >= 1) {
			for ($i=1; $i<=$rows; $i++) {
				$array_data[] = $this->get_row($result);
			}
			return $array_data;
		} else {
			return array();
		}
	}
	
	function insert_sql($sql) {
	
		$this->current_sql = $sql;
		
		// insert record in dB
		$result = mysql_query($sql);
		if (!$result) {
			$this->set_error(mysql_error());
			return false;
		}
		
		// geeft laatste id terug
		$id = mysql_insert_id();
		if ($id == 0){
			return true;
		} else {
			return $id;
		} 
	}

	function update_sql($sql) {

		$this->last_query = $sql;
		
		// update (of verwijder) record(s) in dB
		$result = mysql_query($sql);
		if (!$result) {
			$this->set_error(mysql_error());
			return false;
		}
      
		// geeft aantal affected rows terug
		$rows = mysql_affected_rows();
		if ($rows == 0) {
			return true;  // geen update
		} else {
			return $rows;
		}
	}

	function set_error($error) {
		$this->current_error = $error;
		
		// echo errors
		if ($this->debug) {
			echo '-=| '.$this->current_sql.' |=-<br />'.$this->current_error;
		}
	}


} 

/*
praktische voorbeelden voor gebruik van de class
header('Content-Type: text/html; charset=UTF-8');

$array_dbvars = array(
	'host' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'cms_beta',
	'debug' => true,
);
$db = new db($array_dbvars);

// query met normale loop
$sql = "SELECT * FROM `sites`";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	for ($i=1; $i<=$rows; $i++) {
		pr($db->get_row($result));
	}
}

// query met 1 result
$sql = "SELECT * FROM `sitesa` limit 0,1";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows == 1) {
	pr($db->get_row($result));
}

// query met result in array dump
$sql = "SELECT * FROM `sites`";
$result = $db->select($sql);
$array_data = $db->get_array($result);
pr($array_data);


// laatste query nog eens
$result = $db->select($db->current_sql);
$array_data = $db->get_array($result);
pr($array_data);

// laatste error uitspugen
echo '<br />laatste error: '.$db->current_error;

// insert query
$sql = "INSERT INTO `testtabel` VALUES (0,'".date('His')."')";
$last_id = $db->insert_sql($sql);
echo '<br />laatste id: '.$last_id;

// update query
$sql = "UPDATE `testtabel` SET `waarde` = '".date('His')."' WHERE `id` = '".$last_id."'";
$affected_rows = $db->update_sql($sql);
echo '<br />affected rows: '.$affected_rows;

exit();

// update query
$sql = "DELETE FROM `testtabel` WHERE `id` > 0";
$affected_rows = $db->update_sql($sql);
echo '<br />affected rows: '.$affected_rows;

// update query
$sql = "TRUNCATE TABLE `testtabel`";
$affected_rows = $db->update_sql($sql);
echo '<br />affected rows: '.$affected_rows;
*/

?>