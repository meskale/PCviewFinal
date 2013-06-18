<?php                                                                                                                            

/**
 *	@desc
 *	@package
 *	@var		type	nom		desc
 *	@copyright
 *	@version 	1.0
 *	@since		1.0
 */
class Flotte {


	// Constructeur de la classe
	public function __construct() {
		$PCArray;
			
	}

	// Méthode pour ajouter un PC à la flotte
	public function addPC($pc) {
		$this->PCArray[] = $pc;
	}

	// Getter de la flotte : return La liste des PCs
	public function getFlotte() {
		return $this->PCArray;
	}
	
	// Fonction de récupération d'une liste de PC filtrée en fonction d'une valeur et d'un type
	public function getFilteredPC($filtreValue, $filtreType) {
		switch ($filtreType) {
			case "OS" :
				return $this->getPCListByOS($filtreValue);
				break;
	
			case "Nom" :
				return $this->getPCListByName($filtreValue);
				break;
					
			case "IPv4" :
				return $this->getPCListByIPV4($filtreValue);
				break;
	
			default :
				return $this->getPCListByField($filtreValue);
				break;
		}
	}
	
	// Fonction de récupération d'une liste de PC en testant tous les attributs
	public function getPcListByField($field){
		$PCList;
		foreach ($this->PCArray as $pc) {
			$fieldList = $pc->getFieldList();

			foreach ($fieldList as $pcField) {
				if (strpos($pcField, $field) !== false) {
					$PCList[]= $pc;
					break;
				}
			}
		}
		return $PCList;
	}
	
	// Return une liste de PC en fonction de l'OS
	public function getPCListByOS($os) {
		$PCList;
		foreach ($this->PCArray as $pc) {
			if (strpos($pc->getOS(), $os) !== false) $PCList [] = $pc;
		}
		return $PCList;
	}
	

	// Return une liste de PC dont l'ip d'une des interfaces contient $ip
	public function getPCListByIPV4($ip) {
		$PCList;
		foreach ($this->PCArray as $pc) {
			foreach ($pc->getIntferfaces() as $int) {
				if (strpos($int["Adresse"], $ip) !== false) $PCList[] = $pc;
			}
		}
		return $PCList;
	}
	
	// Return une liste de PCs dont le nom contient $name
	public function getPCListByName($name) {
		$PCList;
		foreach ($this->PCArray as $pc) {
				if (strpos($pc->getName(), $name) !== false) $PCList[] = $pc;
		}
		return $PCList;
	}
	
	// Fonction d'affichage d'une liste contenant l'intégralité des infos d'un PC
	public function displayByName($name) {
		foreach($this->getFlotte() as $i => $ua) {

			if ($ua->getName() == $name ) {
					
				echo "<h1 id=\"pc\">PC " . ($i+1) . " : " .$ua->getName() . "</h1><br />";

				echo "<ul id=\"pclist\">" ;
					
				echo "<li><h2>Stockages : </h2>";

				echo "<ul>" ;
				for ( $i = 0 ; $i < count($ua->getStockages()) ; $i++) {
					
					echo "<div class=\"stockage\">";
					echo "<li>Stockage " . ($i+1) . " :  " ;
					echo "<ul>" ;
					echo "<div class=\"item\">";
					foreach($ua->getStockages()[$i] as $key => $stoParam) {
						echo "<li>" . $key . " : " . $stoParam . "</li>";
					}
					echo "</div>";
					echo "</ul><br /></li>" ;
					echo "</div>";
					
				}
				echo "</ul><br /></li>" ;
					
				echo "<li><h2>Interfaces : </h2>";

				echo "<ul>" ;
				for ( $i = 0 ; $i < count($ua->getInterfaces()) ; $i++) {
					echo "<div class=\"interface\">";
					echo "<li>Interface " . ($i+1) . " :" ;
					echo "<ul>" ;
					foreach($ua->getInterfaces()[$i] as $key => $intParam) {
						echo "<div class=\"item\">";
						echo "<li>" . $key . " : " . $intParam . "</li>";
						echo "</div>";
					}
					echo "</ul><br /></li>" ;
					echo "</div>";

				}
				echo "</ul><br /></li>" ;
					
					
				echo "<li><h2>PŽriphŽriques : </h2>";

				echo "<ul class=\"peripheriques\">" ;
				for ( $i = 0 ; $i < count($ua->getPeripheriques()) ; $i++) {
					echo "<li id=\"peripherique\">PŽriphŽrique " . ($i+1) . " :  " ;
					echo "<ul>" ;
					foreach($ua->getPeripheriques()[$i] as $key => $perParam) {
						echo "<div class=\"item\">";
						echo "<li>" . $key . " : " . $perParam . "</li>";
						echo "</div>";
					}
					echo "</ul><br /></li>" ;
				}
				echo "</ul><br /></li>" ;
					
				echo "<li id=\"cpu\"><h2>CPU : </h2>";

				echo "<ul>" ;
				foreach($ua->getCPU() as $key => $cpuParam) {
					echo "<div class=\"item\">";
					echo "<li>" . $key . " : " . $cpuParam . "</li>";
					echo "</div>";
				}
				echo "</ul><br /></li>" ;
					
				echo "<li id=\"cm\"><h2>Carte M�re : </h2>";

				echo "<ul>" ;
				foreach($ua->getCM() as $key => $cmParam) {
					echo "<div class=\"item\">";
					echo "<li>" . $key . " : " . $cmParam . "</li>";
					echo "</div>";
				}
				echo "</ul><br /></li>" ;
					
				echo "<li id=\"ram\"><h2>RAM : </h2>";

				echo "<ul>" ;
				foreach($ua->getRAM() as $key => $ramParam) {
					echo "<div class=\"item\">";
					echo "<li>" . $key . " : " . $ramParam . "</li>";
					echo "</div>";
				}
				echo "</ul><br /></li>" ;
					
				echo "<li id=\"gpu\"><h2>GPU : </h2>";
					
				echo "<ul>" ;
				foreach($ua->getGPU() as $key => $gpuParam) {
					echo "<div class=\"item\">";
					echo "<li>" . $key . " : " . $gpuParam . "</li>";
					echo "</div>";
				}
				echo "</ul><br /></li>" ;
					
				echo "<li id=\"bios\"><h2>BIOS: </h2>";
					
				echo "<ul>" ;
				foreach($ua->getBIOS() as $key => $biosParam) {
					echo "<div class=\"item\">";
					echo "<li>" . $key . " : " . $biosParam . "</li>";
					echo "</div>";
				}
				echo "</ul><br /></li>" ;
					
				echo "<li id=\"softwares\"><h2>Softwares : </h2>";
					
				echo "<ul>" ;
				for ( $i = 0 ; $i < count($ua->getSoftwares()) ; $i++) {
					echo "<li id=\"soft\">Soft " . ($i+1) . " :" ;
					echo "<ul>" ;
					foreach($ua->getSoftwares()[$i] as $key => $softParam) {
						echo "<div class=\"item\">";
						echo "<li>" . $key . " : " . $softParam . "</li>";
						echo "</div>";
					}
					echo "</ul><br /></li>" ;

				}
				echo "</ul><br /></li>" ;
					
					
				echo "<li id=\"os\"><h2>OS : </h2>";
					
				echo "<ul>" ;
				foreach($ua->getOS() as $key => $osParam) {
					echo "<div class=\"item\">";
					echo "<li>" . $key . " : " . $osParam . "</li>";
					echo "</div>";
				}
				echo "</ul><br /></li>" ;
				echo "</ul><br />" ;

				break;
			}

		}
	}
}

?>