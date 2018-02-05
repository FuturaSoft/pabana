<?php
class Pabana_Parse_Json {
	private $armContent;
	
	function __construct($sFilePath) {
		$sJsonFile = file_get_contents($sFilePath);
		$this->armContent = json_decode($sJsonFile, TRUE);
    }
	
	function toArray() {
		return $this->armContent;
	}
}
?>