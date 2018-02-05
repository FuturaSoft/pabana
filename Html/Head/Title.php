<?php
namespace Pabana\Html\Head;

use Pabana\Debug\Error;

class Title {
	private static $_arsTitle = array();

	public function __toString() {
		return $this->render();
	}

	public function append($sTitle) {
		self::$_arsTitle[] = $sTitle;
		return $this;
	}

	public function clean() {
		self::$_arsTitle = array();
		return $this;
	}

	public function prepend($sTitle) {
		array_unshift(self::$_arsTitle, $sTitle);
		return $this;
	}

	public function render() {
		if(!empty(self::$_arsTitle)) {
			return '<title>' . implode('', self::$_arsTitle) . '</title>' . PHP_EOL;
		} else {
			return false;
		}
	}

	public function set($sTitle) {
		$this->clean();
		return $this->append($sTitle);
	}
}