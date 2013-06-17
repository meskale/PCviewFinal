<?php

/**
 *	@desc
 *	@package
 *	@var		type	nom		desc
 *	@copyright
 *	@version 	1.0
 *	@since		1.0
 */
class PC {


		private $name = "PC Name";
		private $modele = "PC Modele";
		private $bios;
		private $cpu;
		private $gpu;
		private $cm ;
		private $ram;
		private $stockages;
		private $interfaces;
		private $peripheriques;
		private $softwares;
		private $OS;
		
		
	public function PC() {

	}


	public function setName($var_name) {
		$this->name = $var_name;
	}

	public function setModele($var_modele) {
		$this->modele = $var_modele;
	}

	public function setBIOS($var_bios) {
		$this->bios = $var_bios;
	}

	public function setCPU($var_cpu) {
		$this->cpu = $var_cpu;
	}

	public function setGPU($var_gpu) {
		$this->gpu = $var_gpu;
	}

	public function setCM($var_cm) {
		$this->cm= $var_cm;
	}

	public function setRAM($var_ram) {
		$this->ram= $var_ram;
	}

	public function setStockages($var_stockages) {
		$this->stockages= $var_stockages;
	}

	public function setInterfaces($var_interfaces) {
		$this->interfaces= $var_interfaces;
	}

	public function setPeripheriques($var_peripheriques) {
		$this->peripheriques= $var_peripheriques;
	}

	public function setSoftwares($var_softwares) {
		$this->softwares = $var_softwares;
	}

	public function setOS($var_os) {
		$this->os = $var_os;
	}
	
	public function getName() {
		return $this->name;
	}

	public function getModele() {
		return $this->modele;
	}

	public function getBIOS() {
		return $this->bios;
	}

	public function getCPU() {
		return $this->cpu;
	}

	public function getGPU() {
		return $this->gpu;
	}

	public function getCM() {
		return $this->cm;
	}

	public function getRAM() {
		return $this->ram;
	}

	public function getStockages() {
		return $this->stockages;
	}

	public function getInterfaces() {
		return $this->interfaces;
	}

	public function getPeripheriques() {
		return $this->peripheriques;
	}

	public function getSoftwares() {
		return $this->softwares;
	}

	public function getOS() {
		return $this->os;
	}


}

?>