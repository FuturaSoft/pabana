<?php
Class Pabana_String {	
	private $_sValue;

	public function __construct($sValue) {
		$this->_sValue = $sValue;
	}
	
	public function __toString() {
        return $this->get();
    }
	
	public function get() {
		return $this->_sValue;
	}
	
	public function set($sValue) {
		$this->_sValue = $sValue;
	}
	
	public function charAt($nIndex) {
		return substr($this->_sValue, $nIndex, 1);
	}
	
	public function concat($sValue) {
		new Pabana_String($this->_sValue . $sValue);
	}
	
	public function equals($sValue, $bStrict = false) {
		if($bStrict) {
			return $this->_sValue === $sValue;
		} else {
			return $this->_sValue == $sValue;
		}
	}
	
	public function isEmpty() {
		return empty($this->_sValue);
	}
	
	public function indexOf($cValue) {
		return strstr($this->_sValue, $cValue);
	}
	
	public function length() {
		return strlen($this->_sValue);
	}
	
	public function replace($sOldString, $sNewString) {
		return new Pabana_String(str_replace($sOldString, $sNewString, $this->_sValue));
	}
	
	public function toLowerCase() {
		return new Pabana_String(strtolower($this->_sValue));
	}
	
	public function toUpperCase() {
		return new Pabana_String(strtoupper($this->_sValue));
	}
}
?>