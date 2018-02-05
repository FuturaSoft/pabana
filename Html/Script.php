<?php
namespace Pabana\Html;

use Pabana\Debug\Error;

class Script {
	private static $_arsScriptList = array();

	public function __toString() {
		return $this->render();
	}

	public function append($sHref) {
		self::$_arsScriptList[] = array($sHref);
		return $this;
	}

	public function appendFile($sHref) {
		self::$_arsScriptList[] = array('/js/' . $sHref);
		return $this;
	}

	public function appendLibrary($sLibrary, $sHref) {
		self::$_arsScriptList[] = array('/lib/' . $sLibrary . '/js/' . $sHref);
		return $this;
	}

	public function clean() {
		self::$_arsScriptList = array();
		return $this;
	}

	public function prepend($sHref) {
		$arsScript = array($sHref);
		array_unshift(self::$_arsScriptList, $arsScript);
		return $this;
	}

	public function prependFile($sHref) {
		$arsScript = array('/js/' . $sHref);
		array_unshift(self::$_arsScriptList, $arsScript);
		return $this;
	}

	public function prependLibrary($sLibrary, $sHref) {
		$arsScript = array('/lib/' . $sLibrary . '/js/' . $sHref);
		array_unshift(self::$_arsScriptList, $arsScript);
		return $this;
	}

	public function render() {
		$sHtml = '';
		foreach(self::$_arsScriptList as $arsScript) {
			$sHtml .= '<script src="' . $arsScript[0] . '" type="text/javascript"></script>' . PHP_EOL;
		}
		return $sHtml;
	}
}
?>