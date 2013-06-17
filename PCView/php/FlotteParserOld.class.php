<?php
/**
 * flotte parser/(writer)
 * se charge de fournir l'interface avec le fichier XML
 * 
 * @author jojo
 *
 */

class FlotteParser{

			
	private $flotteX;
	private $flotte;

	/**
	 *   instancie et initialise l'arborescence ˆ partir d'un fichier
	 */
	function __construct($file){
		$this->flotte = new DOMDocument();
		$this->flotte->load($file);

		$this->flotte->validate() or
		 die("fichier XML corrompu, merci de contacter le webadmin");
		
		$this->flotteX = new DOMXpath($this->flotte);
	}


	/**
	 * Liste de tout les pcs present dans la flotte
	 * filtrage par occurence dans la totalitŽ des nodevalue
	 * 	
	 * @return DOMNodeList
	 */
	public function getPcList($filtre =""){
	
		if($filtre==""){
			return $this->flotte->getElementsByTagName("PC");
		}
		else 
		{
			//php support XPath 1.0 -> pas de lower/upper-case translate a la place
			$query = "//PC[contains(translate(.,'abcdefghijklmnopqrstuvwxyz','ABCDEFGHIJKLMNOPQRSTUVWXYZ'),
					translate('".$filtre."','abcdefghijklmnopqrstuvwxyz','ABCDEFGHIJKLMNOPQRSTUVWXYZ'))]";
	
			return $this->flotteX->query($query);
		}
	}

	/**
	 * Retourne le PC ciblŽ par $id
	 * @param ID $id
	 * @return DOMNode
	 */
	public function getPcById($id){

		 return $this->flotte->getElementById("$id");
		
	}
	
	public function getXpath(){
		return $this->flotteX;
	}
	

}

?>