<?php
namespace Pabana\Intl;

use Pabana\Debug\Error;

class Translate {
	private static $_arsTranslation = array();

	public function clean() {
		return self::$_arsTranslation = array();
	}

	public function get($sKey) {
		return self::$_arsTranslation[$sKey];
	}

	public function set($sKey, $sValue) {
		self::$_arsTranslation[$sKey] = $sValue;
		return true;
	}

	public function show($sKey) {
		echo self::$_arsTranslation[$sKey];
	}
}
?>