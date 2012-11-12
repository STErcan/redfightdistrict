<?php
/*
Login & sessie beheer.

inladen met $cms_config['token'] als argument
*/
class login extends db { 
	public $sessie;
	public $admin_login = true;
	
	private $user_id;
	private $user_priv;
	private $user_naam;
	private $wachtwoord;
	private $sites = array();
	private $cookie_time = time()+10800;
	
	private $bf_teller = 0;
	
	function __construct($token) { 
		if ($this->admin_login == true) {
			$this->sessie = 'safe_'.$token;
		} else {
			$this->sessie = 'front_'.$token;
		}
		# hier moet ook de post komen; denk ik.
	}
	
	function login() {		
		$sql = "SELECT `user_id`,`user_priv`,`user_naam` FROM `users` WHERE `user_login` = '".$this->user_naam."' 
		AND `user_pass` = SHA1(CONCAT('".$this->wachtwoord."','+',`user_id`)) LIMIT 0,1";
		$result = $db->select($sql);
		$rows = $db->row_count;
		if ($rows == 1) {
			# log in correct
			extract($db->get_row($result));
			# - class variabelen setten
			$this->user_id = $user_id;
			$this->user_priv = $user_priv;
			$this->user_naam = $user_naam;
			
			# - sessie variabelen setten
			$_SESSION[$this->sessie]['id'] = $user_id;
			$_SESSION[$this->sessie]['priv'] = $user_priv;		
			$_SESSION[$this->sessie]['naam'] = $user_naam;		
			
			# - cookie variabelen setten			
			setcookie($this->sessie.'[id]', $user_id, $this->cookie_time);
			setcookie($this->sessie.'[priv]', $user_priv, $this->cookie_time);
			setcookie($this->sessie.'[naam]', $user_naam, $this->cookie_time);
			
			if ($this->admin_login == true) {
				$this->check_rechten;
			}
		} else {
			// gebruiker bestaat niet of login is incorrect
			$this->check_bruteforce;
			$this->clear_vars;
		}
	}
	
	function check_rechten() {
		// check site rechten (verplicht)
		$sql_user = "SELECT * FROM `users_2_sites` 
		JOIN `sites` ON (`sites`.`site_id` = `users_2_sites`.`site_id`)
		WHERE `user_id` = '".$this->user_id."' ORDER BY `sites`.`positie`";
		$result_user  = $db->select($sql_user);
		$rows_user  = $db->row_count;
		if ($rows_user >= 1) {
			for ($i=1; $i<=$rows_user; $i++) {
				extract($db->get_row($result_user));
				
				$this->sites[$i] = $site_id;
				$_SESSION[$this->sessie]['sites'][$i] = $site_id;
				setcookie('sites_'$this->sessie.'['.$i.']', $site_id, $this->cookie_time);
			}
		
			// LET OP: de user MOET aan een site_id gekoppeld zijn!
			// 1e uit array gebruiken voor site-id start
			$_SESSION[$this->sessie]['site_id'] = $_SESSION[$this->sessie]['sites'][1];
			setcookie($this->sessie.'[site_id]', $_SESSION[$this->sessie]['site_id'], $this->cookie_time);
		} else {
			// user is niet gekoppeld aan site_id
		}
	}
	
	function clear_vars() {
		# Gebruiken bij loguit en als login incorrect is
		setcookie($this->sessie.'[id]', '', time()-3600);
		setcookie($this->sessie.'[priv]', '', time()-3600);
		setcookie($this->sessie.'[naam]', '', time()-3600);
		if (count($_SESSION[$this->sessie]['sites'])>0) {
			foreach ($_SESSION[$this->sessie]['sites'] as $key => $waarde) {
				setcookie('sites_'.$this->sessie.'['.$key.']', '', time()-3600);
			}
		}
		setcookie('sites_'.$this->sessie.'', '', time()-3600);
		setcookie($this->sessie.'[site_id]', '', time()-3600);
		$_SESSION[$this->sessie] = array();
		
		$this->user_id = 0;
		$this->user_priv = 0;
		$this->user_naam = '';
		$this->wachtwoord = '';
		$this->sites = array();
	}
	
	function check_bruteforce() {
		if ($this->bf_teller == 0) {
			$this->bf_teller = 1;
		} else {
			$this->bf_teller = ($this->bf_teller+1);
		}
		
		if ($this->bf_teller >= 5) {
			$sql = "INSERT INTO `userban` (id, timestamp, ip_adres, blokkeer) ";
			$sql .= "VALUES (NULL, NOW(), '".$_SERVER['REMOTE_ADDR']."', 1) ";
			$db->update_sql($sql);
		}
	}
	
	function cookie_sessie() {
		# gebruik deze functie als de cookie bestaat & de sessie niet.
		$_SESSION[$this->sessie]['id'] = $_COOKIE[$this->sessie]['id'];
		$_SESSION[$this->sessie]['priv'] = $_COOKIE[$this->sessie]['priv'];
		$_SESSION[$this->sessie]['naam'] = $_COOKIE[$this->sessie]['naam'];
		$_SESSION[$this->sessie]['sites'] = $_COOKIE['sites_'.$this->sessie];
		$_SESSION[$this->sessie]['site_id'] = $_COOKIE[$this->sessie]['site_id'];
	}
	
	function cookies() {
		# elke pageload mag dit worden uitgevoerd.
		setcookie($this->sessie.'[id]', $_SESSION[$this->sessie]['id'], time()+$this->cookie_time);
		setcookie($this->sessie.'[priv]', $_SESSION[$this->sessie]['priv'], time()+$this->cookie_time);
		setcookie($this->sessie.'[naam]', $_SESSION[$this->sessie]['naam'], time()+$this->cookie_time);
		if (count($_SESSION[$this->sessie]['sites'])>0) {
			foreach($_SESSION[$this->sessie]['sites'] as $key => $waarde) {
				setcookie('sites_'.$this->sessie.'['.$key.']', $waarde, time()+$this->cookie_time);
			}
		}
		setcookie($this->sessie.'[site_id]', $_SESSION[$this->sessie]['site_id'], time()+$this->cookie_time);

	}
	
}
?>