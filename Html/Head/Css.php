<?php
namespace Pabana\Html\Head;

use Pabana\Debug\Error;

class Css {
	private static $_arsCssList = array();

	public function __toString() {
		return $this->render();
	}

	public function appendFile($sHref, $sMedia = null) {
		self::$_arsCssList[] = array('/css/' . $sHref, $sMedia);
		return $this;
	}

	public function appendLibrary($sLibrary, $sHref, $sMedia = null) {
		self::$_arsCssList[] = array('/lib/' . $sLibrary . '/css/' . $sHref, $sMedia);
		return $this;
	}

	public function clean() {
		self::$_arsCssList = array();
		return $this;
	}

	public function prependFile($sHref, $sMedia = null) {
		$arsCss = array('/css/' . $sHref, $sMedia);
		array_unshift(self::$_arsCssList, $arsCss);
		return $this;
	}

	public function prependLibrary($sLibrary, $sHref, $sMedia = null) {
		self::$_arsCssList[] = array('/lib/' . $sLibrary . '/css/' . $sHref, $sMedia);
		return $this;
	}

		public function render() {
		$sHtml = '';
		foreach(self::$_arsCssList as $arsCss) {
			$sHtml .= '<link href="' . $arsCss[0] . '" rel="stylesheet" type="text/css"';
			if(!empty($arsCss[1])) {
				$sHtml .= ' media="' . $arsCss[1] . '"';
			}
			$sHtml .= '>' . PHP_EOL;
		}
		return $sHtml;
	}
}
?>