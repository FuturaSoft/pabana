<?php
namespace Pabana\Html;

use Pabana\Debug\Error;

class Doctype
{
	private static $sDoctype = 'HTML5';

	public function __toString()
	{
		return $this->render();
	}

	public function clean()
	{
		return self::$sDoctype = 'HTML5';
	}

	public function get()
	{
		return self::$sDoctype;
	}

	public function render()
	{
		if(self::$sDoctype == 'HTML5') {
			return '<!DOCTYPE html>' . PHP_EOL;
		} else if(self::$sDoctype == 'XHTML11') {
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">' . PHP_EOL;
		} else if(self::$sDoctype == 'XHTML1_STRICT') {
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . PHP_EOL;
		} else if(self::$sDoctype == 'XHTML1_TRANSITIONAL') {
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . PHP_EOL;
		} else if(self::$sDoctype == 'XHTML1_FRAMESET') {
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">' . PHP_EOL;
		} else if(self::$sDoctype == 'HTML4_STRICT') {
			return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">' . PHP_EOL;
		} else if(self::$sDoctype == 'HTML4_LOOSE') {
			return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">' . PHP_EOL;
		} else if(self::$sDoctype == 'HTML4_FRAMESET') {
			return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">' . PHP_EOL;
		}
	}

	public function set($sDoctype)
	{
		self::$sDoctype = $sDoctype;
		return $this;
	}
}