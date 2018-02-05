<?php
namespace Pabana\Html\Head;

use Pabana\Debug\Error;

class Icon {
	private static $_arsIconList = array();

	public function __toString() {
		return $this->render();
	}

	public function append($sHref) {
		self::$_arsIconList[] = array('/img/' . $sHref);
		return $this;
	}

	public function clean() {
		self::$_arsIconList = array();
		return $this;
	}

	public function prepend($sHref) {
		$arsIcon = array('/img/' . $sHref);
		array_unshift(self::$_arsIconList, $arsIcon);
		return $this;
	}

	public function render() {
		$sHtml = '';
		foreach(self::$_arsIconList as $arsIcon) {
			$sHtml .= '<link href="' . $arsIcon[0] . '" rel="icon">' . PHP_EOL;
		}
		return $sHtml;
	}
}