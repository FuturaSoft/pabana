<?php
Class Pabana_Intl_Charset {
    public function changeCharset($mValue, $sInCharset, $sOutCharset, $bTranslit = true, $bIgnore = true) {
		$mReturn = $mValue;
		if(is_string($mValue)) {
			if($bTranslit === true) {
				$sOutCharset .= '//TRANSLIT';
			} else if($bIgnore === true) {
				$sOutCharset .= '//IGNORE';
			}
			$mReturn = @iconv($sInCharset, $sOutCharset, $mValue);
		} else if(is_array($mValue)) {
			$mReturn = array();
			foreach($mValue as $mArrayKey=>$mArrayValue) {
				$mArrayKey = $this->changeCharset($mArrayKey, $sInCharset, $sOutCharset, $bTranslit, $bIgnore);
				$mArrayValue = $this->changeCharset($mArrayValue, $sInCharset, $sOutCharset, $bTranslit, $bIgnore);
				$mReturn[$mArrayKey] = $mArrayValue;
			}
		}
		return $mReturn;
	}
}
?>