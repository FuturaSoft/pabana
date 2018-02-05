<?php
namespace Pabana\Html\Head;

use Pabana\Debug\Error;

class Title
{
	private static $arsTitle = array();

	public function __toString()
	{
		return $this->render();
	}

	public function append($sTitle)
	{
		self::$arsTitle[] = $sTitle;
		return $this;
	}

	public function clean()
	{
		self::$arsTitle = array();
		return $this;
	}

	public function prepend($sTitle)
	{
		array_unshift(self::$arsTitle, $sTitle);
		return $this;
	}

	public function render()
	{
		if(!empty(self::$arsTitle)) {
			return '<title>' . implode('', self::$arsTitle) . '</title>' . PHP_EOL;
		} else {
			return false;
		}
	}

	public function set($sTitle)
	{
		$this->clean();
		return $this->append($sTitle);
	}
}