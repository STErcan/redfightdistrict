<?php
## -- kennisbank class
class kennisbank_tree {

	var $tree = ''; // Tree output
	var $depth = 1; // diepte level startpunt voor kinderen
	var $exclude = array(); // Maak exclusion array
	
	function init($open=false, $edit=false) {
		
		array_push($this->exclude, 0);	// Maak eerste val
		
		$this->tree = '<ul id="kennisbank_tree">'."\n";
		$nav_query = mysql_query("SELECT * FROM `paginas` WHERE `type` = 'cat' AND `parent_id` = 0 ORDER BY `positie`, `titel`");
		while ( $nav_row = mysql_fetch_array($nav_query) ) {
			$goOn = 1;
			for($x = 0; $x < count($this->exclude); $x++ ) { /* controle op reeds weergegeven items */
				if ( $this->exclude[$x] == $nav_row['pagina_id'] ) {
					$goOn = 0;
					break;
				}
			}
			if ( $goOn == 1 ) {
				$this->tree .= '<li class="'.$nav_row['type'].'" rel="0" id="item_'.$nav_row['pagina_id'].'">';
				if($edit) {
					$this->tree .= '<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;opdracht=nieuw&amp;id=0&amp;get_parent_id='.$nav_row['pagina_id'].'" class="add" onmouseover="hoover(\'item_'.$nav_row['pagina_id'].'\',\'hover_add\');" onmouseout="hoover(\'item_'.$nav_row['pagina_id'].'\',\'hover_add\',1);">&nbsp;</a>'."\n";
					$this->tree .= '<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;opdracht=wijzig&amp;id='.$nav_row['pagina_id'].'" class="edit" onmouseover="hoover(\'item_'.$nav_row['pagina_id'].'\',\'hover_edit\');" onmouseout="hoover(\'item_'.$nav_row['pagina_id'].'\',\'hover_edit\',1);">&nbsp;</a>'."\n";
					$this->tree .= '<a href="#" onClick="verwerk_item('.$nav_row['pagina_id'].',\'verwijder\'); return false;" onmouseover="hoover(\'item_'.$nav_row['pagina_id'].'\',\'hover_del\');" class="del" onmouseout="hoover(\'item_'.$nav_row['pagina_id'].'\',\'hover_del\',1);">&nbsp;</a>'."\n";

				}
				$this->tree .= '<span class="handler'.($open ? ' open' : ' dicht').'" id="map_'.$nav_row['pagina_id'].'">&nbsp;</span>'."\n";
				$this->tree .= '<a href="#" onclick="showlist('.$nav_row['pagina_id'].'); return false;" class="link'.($this->has_children($nav_row['pagina_id']) ? ' sub' : '').'" id="item_'.$nav_row['pagina_id'].'">'.$nav_row['titel'].'</a>'."\n"; /* hoofdmappen */
				
				array_push($this->exclude, $nav_row['pagina_id']);
				$this->tree .= $this->build_child($nav_row['pagina_id'], $open, $edit); /* Ga door naar de kinderen */
				$this->tree .= '</li>'."\n";
			}
		}
		$this->tree .= '</ul>'."\n";
		echo $this->tree;
	}
	
	
	function build_child($oldID, $open=false, $edit=false) {
		
		$sql = "SELECT * FROM `paginas` WHERE `type` = 'cat' AND `parent_id` = ".$oldID." ORDER BY `positie`, `titel`";
		$resultaat = mysql_query($sql) or die ("SQL-opdracht is mislukt [$sql]: ".mysql_error());
		$aantal = mysql_num_rows($resultaat);
		if ($aantal >= 1) {
			$tempTree .= "\n";
			/* diepte levels maken */ for ( $c=0;$c<$this->depth;$c++ ) { $tempTree .= "\t"; }
			$tempTree .= '<ul id="list_'.$oldID.'" style="display:'.($open ? 'block' : 'none').';">'."\n";
			for ($i=1; $i<=$aantal; $i++) {
				$child = mysql_fetch_array($resultaat);
				
				/* diepte levels maken */ for ( $c=0;$c<$this->depth;$c++ ) { $tempTree .= "\t"; }
				$tempTree .= '<li class="'.$child['type'].'" rel="'.$this->depth.'" id="item_'.$child['pagina_id'].'">';
				
				if($edit) {
					$tempTree .= '<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;opdracht=nieuw&amp;id=0&amp;get_parent_id='.$child['pagina_id'].'" class="add" onmouseover="hoover(\'item_'.$child['pagina_id'].'\',\'hover_add\');" onmouseout="hoover(\'item_'.$child['pagina_id'].'\',\'hover_add\',1);">&nbsp;</a>'."\n";
					$tempTree .= '<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;opdracht=wijzig&amp;id='.$child['pagina_id'].'" class="edit" onmouseover="hoover(\'item_'.$child['pagina_id'].'\',\'hover_edit\');" onmouseout="hoover(\'item_'.$child['pagina_id'].'\',\'hover_edit\',1);">&nbsp;</a>'."\n";
					$tempTree .= '<a class="del" href="#" onClick="verwerk_item('.$child['pagina_id'].',\'verwijder\'); return false;" onmouseover="hoover(\'item_'.$child['pagina_id'].'\',\'hover_del\');" onmouseout="hoover(\'item_'.$child['pagina_id'].'\',\'hover_del\',1);">&nbsp;</a>'."\n";

				}	
				$tempTree .= '<span class="'.($open ? 'open' : 'dicht').'" id="map_'.$child['pagina_id'].'">&nbsp;</span>'."\n";
				$tempTree .= '<a href="#" onclick="showlist('.$child['pagina_id'].'); return false;" class="link'.($this->has_children($child['pagina_id']) ? ' sub' : '').'" id="item_'.$child['pagina_id'].'">'.$child['titel'].'</a>';
				
				$this->depth++;
				$tempTree .= $this->build_child($child['pagina_id'], $open, $edit);
				$this->depth--;
				array_push($this->exclude, $child['pagina_id']);
				
				$tempTree .= "</li>\n";
			}
			/* diepte levels maken */ for ( $c=0;$c<$this->depth;$c++ ) { $tempTree .= "\t"; }
			$tempTree .= "</ul>\n";
			/* diepte levels maken */ for ( $c=0;$c<$this->depth;$c++ ) { $tempTree .= "\t"; }
		}
		return $tempTree; /* return gehele tree */
		
	}
	
	function has_children($id) {
		$sql = "SELECT * FROM `paginas` WHERE `type` = 'cat' AND `parent_id` = ".$id." LIMIT 0,1";
		$resultaat = mysql_query($sql) or die ("SQL-opdracht is mislukt [$sql]: ".mysql_error());
		$aantal = mysql_num_rows($resultaat);
		if ($aantal == 1) {
			return true;
		} else {
			return false;
		}
	}

}

## -- categorien
class kennisbank_cat {

	var $tree = '';				// Tree output
	var $depth = 1;				// diepte level startpunt voor kinderen
	var $exclude = array();		// Maak exclusion array
	
	function init($curr_parent_id,$curr_id) {
		
		array_push($this->exclude, 0);	// Maak eerste val
		
		$this->tree = '<select name="parent_id">'."\n";
		$this->tree .= '<option value="0"'.($curr_parent_id==0 ? ' selected="selected"' : '').'>Dit is een hoofdcategorie &nbsp; </option>'."\n";
		$nav_query = mysql_query("SELECT * FROM `paginas` WHERE `type` = 'cat' AND  parent_id = '0' ORDER BY `positie`");
		while ( $nav_row = mysql_fetch_array($nav_query) ) {
			$goOn = 1;
			for($x = 0; $x < count($this->exclude); $x++ ) { /* controle op reeds weergegeven items */
				if ( $this->exclude[$x] == $nav_row['pagina_id'] ) {
					$goOn = 0;
					break;
				}
			}
			if ( $goOn == 1 ) {
				if ($curr_id==$nav_row['pagina_id']) {
					// niks doen, dit is de huidige cat
				} else {
					$this->tree .= '<option value="'.$nav_row['pagina_id'].'"'.($curr_parent_id==$nav_row['pagina_id'] ? ' selected="selected" class="selected">&raquo; ' : '>').''.$nav_row['titel'].'</option>'."\n";
					array_push($this->exclude, $nav_row['pagina_id']);
					$this->tree .= $this->build_child($nav_row['pagina_id'],$nav_row['titel'],$curr_parent_id,$curr_id); /* Ga door naar de kinderen */
				}
			}
		}
		$this->tree .= '</select>'."\n";
		echo $this->tree;
	}
	
	
	function build_child($oldID, $parent_naam, $curr_parent_id, $curr_id) {
		
		if ($curr_id==$oldID) {
			// niks doen dit is een child van de huidige cat
		} else {
			$sql = "SELECT * FROM `paginas` WHERE `type` = 'cat' AND `parent_id` = ".$oldID." ORDER BY `positie`";
			$resultaat = mysql_query($sql) or die ("SQL-opdracht is mislukt [$sql]: ".mysql_error());
			$aantal = mysql_num_rows($resultaat);
			if ($aantal >= 1) {
				$tab = '';
				/* diepte levels maken */ for ( $c=0;$c<$this->depth;$c++ ) { $tab .= "&raquo; "; }
				for ($i=1; $i<=$aantal; $i++) {
					$child = mysql_fetch_array($resultaat);
					if ($curr_id==$child['pagina_id']) {
						// niks doen, dit is de huidige cat
					} else {
						$tempTree .= '<option value="'.$child['pagina_id'].'"'.($curr_parent_id==$child['pagina_id'] ? ' selected="selected" class="selected">&raquo; ' : '>').''.$parent_naam.' / '.$child['titel'].'</option>'."\n";
						$tempTree .= $this->build_child($child['pagina_id'], $parent_naam.' / '.$child['titel'], $curr_parent_id,$curr_id);
						array_push($this->exclude, $child['pagina_id']);
					}
				}
			}
			return $tempTree;
		}
		
	}

}

?>