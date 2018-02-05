<?php
namespace Pabana\Html\Head;

use Pabana\Debug\Error;
use Pabana\Html\Doctype;

class Charset
{
	private static $sCharset = 'UTF-8';

	public function __toString()
	{
		return $this->render();
	}

	public function clean()
	{
		self::$sCharset = 'UTF-8';
	}

	public function render()
	{
		$oDoctype = new Doctype();;
		$arsCharset = array(
			'UTF-8' => 'utf-8',
			'UTF-16' => 'utf-16',
			'ISO-8859-1' => 'iso-8859-1',
			'ISO-8859-5' => 'iso-8859-5',
			'ISO-8859-15' => 'iso-8859-15',
			'CP1251' => 'windows-1251',
			'CP1252' => 'windows-1252',
			'KOI8-R' => 'koi8-r',
			'BIG5' => 'big5',
			'GB2312' => 'gb2312',
			'BIG5-HKSCS' => 'big5-hkscs',
			'SHIFT_JIS' => 'shift_jis',
			'EUC-JP' => 'euc-jp',
			'MACROMAN' => 'x-mac-roman'
		);
		$arsKeyCharset = array_keys($arsCharset);
		if(!in_array(self::$sCharset, $arsKeyCharset)) {
			$sErrorMessage = 'Charset ' . self::$sCharset . ' isn\'t defined';
			throw new Error($sErrorMessage);
		} else {
			if($oDoctype->get() == 'HTML5') {
				return '<meta charset="' . $arsCharset[self::$sCharset] . '">' . PHP_EOL;
			} else {
				if(substr($oDoctype->get(), 0, 1) == 'X') {
					return '<meta http-equiv="Content-Type" content="text/html; charset=' . $arsCharset[self::$sCharset] . '" />' . PHP_EOL;
				} else {
					return '<meta http-equiv="Content-Type" content="text/html; charset=' . $arsCharset[self::$sCharset] . '">' . PHP_EOL;
				}
			}
		}
	}

	public function set($sCharset)
	{
		self::$sCharset = $sCharset;
		return $this;
	}
}