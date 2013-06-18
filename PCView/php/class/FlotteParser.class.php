<?php

require('class/Flotte.class.php');
require('class/PC.class.php');

/**
 *	@desc
 *	@package
 *	@var		type	nom		desc
 *	@copyright
 *	@version 	1.0
 *	@since		1.0
 */
class FlotteParser {
	
	private $copyNode;
	private $doc;
	
	public function __construct() {
		
	}

	public function parse() {
		$this->doc = new DOMDocument();
		$this->doc->load( 'Flotte.xml' );
		$flotte = new Flotte();
			
		$nodes = $this->doc->getElementsByTagName( "PC" );
			
		foreach ($nodes as $ua) {
			$this->copyNode = $ua;
			
			$poste = new PC();
			
			$tmp = array();
			$tmp2 = array();
			$tmp3 = array();
			$tmp4 = array();
			
			$poste->setName($this->getPCNameByNode($ua));
			$poste->setModele($this->getPCModeleByNode($ua));
			$poste->setBIOS($this->getBIOSByNode($ua));
			$poste->setCPU($this->getCPUByNode($ua));
			$poste->setGPU($this->getGPUByNode($ua));
			$poste->setCM($this->getCMByNode($ua));
			$poste->setRAM($this->getRAMByNode($ua));
			for ($i = 0 ; $i < $this->getStockages($ua)->length ; $i++) {
				$tmp[] = $this->getStockage($ua, $i);
			}
			$poste->setStockages($tmp);
			for ($i = 0 ; $i < $this->getInterfaces($ua)->length ; $i++) {
				$tmp2[] = $this->getInterface($ua, $i);
			}
			$poste->setInterfaces($tmp2);
			for ($i = 0 ; $i < $this->getPeripheriques($ua)->length ; $i++) {
				$tmp3[] = $this->getPeripherique($ua, $i);
			}
			$poste->setPeripheriques($tmp3);
			for ($i = 0 ; $i < $this->getSoftwares($ua)->length ; $i++) {
				$tmp4[] = $this->getSoftware($ua, $i);
			}
			$poste->setSoftwares($tmp4);
			$poste->setOS($this->getOSByNode($ua));
			
			
			$flotte->addPC($poste);
			
		}
		
		return $flotte;
	}
	
	public function createPC($pc) {
		$newNode = $this->copyNode->cloneNode(true);
		$newNode->setAttribute("id","id".rand(0,1000));
		$this->doc->documentElement->appendChild($newNode);
		$this->doc->save('PCView/model/Flotte.xml');
	}
	

	private function getPCNameByNode($pc) {
		return $this->getValue($pc, "Nom", 0);
	}

	private function getPCModeleByNode($pc) {
		return $this->getValue($pc, "Modele", 0);
	}

	private function getBIOSByNode($pc) {
		$BIOS["Nom"] = $this->getNode($pc, "BIOS", 0)->getAttribute("Nom");
		$BIOS["Version"] = $this->getNode($pc, "BIOS", 0)->getAttribute("Version");
		
		return $BIOS;
	}
	
	private function getCPUByNode($pc) {
		$CPU["Nom"] = $this->getNode($pc, "CPU", 0)->getAttribute("Nom");
		$CPU["Freq"] = $this->getNode($this->getNode($pc, "CPU", 0), "Freq", 0)->nodeValue . " " . $this->getNode($this->getNode($pc, "CPU", 0), "Freq", 0)->getAttribute("Unite");
		$CPU["Cache"] = $this->getNode($this->getNode($pc, "CPU", 0), "Capacite", 0)->nodeValue . " " . $this->getNode($this->getNode($pc, "CPU", 0), "Capacite", 0)->getAttribute("Unite") . " (" . $this->getNode($this->getNode($pc, "CPU", 0), "Cache", 0)->getAttribute("Niveau") .")" ;
		$CPU["NbCore"] = $this->getValue($pc, "NbCore", 0);
		$CPU["Arch"] = $this->getNode($pc, "Arch", 0)->getAttribute("Nom");


		return $CPU;
	}
	
	private function getGPUByNode($pc) {
		$GPU["Nom"] = $this->getNode($pc, "GPU", 0)->getAttribute("Nom");
		$GPU["Freq"] = $this->getNode($this->getNode($pc, "GPU", 0), "Freq", 0)->nodeValue . " " . $this->getNode($this->getNode($pc, "GPU", 0), "Freq", 0)->getAttribute("Unite");
		$GPU["Connectique"] = $this->getNode($this->getNode($pc, "GPU", 0), "Connectique", 0)->getAttribute("Nom");
	
		return $GPU;
	}

	private function getCMByNode($pc) {
		$CM["Chipset"] = $this->getValue($pc, "Chipset", 0);
		$CM["Socket"] = $this->getValue($pc, "Socket", 0);
		return $CM;
	}

	private function getRAMByNode($pc) {
		$RAM["Freq"] = $this->getValue($this->getNode($pc, "RAM", 0), "Freq", 0) . " " . $this->getNode($this->getNode($pc, "RAM", 0), "Freq", 0)->getAttribute("Unite");
		$RAM["Capacite"] = $this->getValue($this->getNode($pc, "RAM", 0), "Capacite", 0) . " " . $this->getNode($this->getNode($pc, "RAM", 0), "Capacite", 0)->getAttribute("Unite");
		$RAM["TYPE"] = $this->getValue($this->getNode($pc, "RAM", 0), "TYPE", 0);
		
		return $RAM;
	}

	private function getStockages($pc) {
		return $this->getNodes($pc, "Stockage");
	}

	private function getStockage($pc, $i) {
		$stockage["Nom"] = $this->getNode($pc, "Stockage", $i)->getAttribute("Nom");
		$stockage["Support"] = $this->getNode($this->getNode($pc, "Stockage", $i), "Support", 0)->getAttribute("Nom");
		$stockage["Connectique"] = $this->getNode($this->getNode($pc, "Stockage", $i), "Connectique", 0)->getAttribute("Nom");
		$stockage["Capacite"] = $this->getValue($this->getNode($pc, "Stockage", $i), "Capacite", 0) . " " . $this->getNode($this->getNode($pc, "Stockage", $i), "Capacite", 0)->getAttribute("Unite");

		return $stockage;
	}

	private function getInterfaces($pc) {
		return $this->getNodes($pc, "Interface");
	}

	private function getInterface($pc, $i) {

		$interface["Nom"] = $this->getNode($pc, "Interface", $i)->getAttribute("Nom");
		$interface["TYPE"] = $this->getValue($pc, "TYPE", $i);
		$interface["MAC"] = $this->getValue($pc, "MAC", $i);
		$interface["IPV4"] = $this->getValue($pc, "IPV4", $i);
		$interface["SUBNET"] = $this->getValue($pc, "SUBNET", $i);
		$interface["GATEWAY"] = $this->getValue($pc, "GATEWAY", $i);

		return $interface;
	}

	private function getPeripheriques($pc) {
		return $this->getNodes($pc, "Peripherique");
	}
	
	private function getSoftwares($pc) {
		return $this->getNodes($pc, "Software");
	}

	private function getPeripherique($pc, $i) {

		$peripherique["Nom"] = $this->getNode($pc, "Peripherique", $i)->getAttribute("Nom");
		$peripherique["Connectique"] = $this->getNode($this->getNode($pc, "Peripherique", $i), "Connectique", 0)->getAttribute("Nom");
		$peripherique["TYPE"] = $this->getValue($this->getNode($pc, "Peripherique", $i), "TYPE", 0);

		return $peripherique;
	}
	
	private function getOSByNode($pc) {
		$OS["Nom"] = $this->getNode($pc, "OS", 0)->getAttribute("Nom");
		$OS["Arch"] = $this->getNode($this->getNode($pc, "OS", 0), "Arch", 0)->getAttribute("Nom");
		
		return $OS;
	}
	
	private function getSoftware($pc, $i) {

		$soft["Nom"] = $this->getNode($pc, "Software", $i)->getAttribute("Nom");
		$soft["Version"] = $this->getNode($pc, "Software", $i)->getAttribute("Version");
		$soft["Arch"] = $this->getNode($this->getNode($pc, "Software", $i), "Arch", 0)->getAttribute("Nom");

		return $soft;
	}

	private function getNodes($node, $valueName) {
		return $node->getElementsByTagName( $valueName );
	}

	private function getNode($pc, $valueName, $i) {
		return $this->getNodes($pc, $valueName)->item($i);
	}

	private function getValue($pc, $valueName, $i) {
		return $this->getNode($pc, $valueName, $i)->nodeValue;
	}

}
?>