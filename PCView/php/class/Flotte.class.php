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
	
	

		
	
}

?>