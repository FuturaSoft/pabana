<?php
namespace Pabana\Html\Head;

use Pabana\Debug\Error;

class Css
{
	private static $sCssCode = '';
	private static $arsCssList = array();

	public function __toString()
	{
		return $this->render();
	}

	public function appendCss($sCssCode)
	{
		self::$sCssCode .= $sCssCode;
		return $this;
	}

	public function appendFile($sHref, $sMedia = null, $bAutoPath = true)
	{
		if ($bAutoPath === true) {
			$sHref = '/css/' . $sHref;
		}
		self::$arsCssList[] = array($sHref, $sMedia);
		return $this;
	}

	public function appendLibrary($sLibrary, $sHref, $sMedia = null)
	{
		self::$arsCssList[] = array('/lib/' . $sLibrary . '/css/' . $sHref, $sMedia);
		return $this;
	}

	public function clean()
	{
		self::$sCssCode = '';
		self::$arsCssList = array();
		return $this;
	}

	public function prependCss($sCssCode)
	{
		self::$sCssCode = $sCssCode . self::$sCssCode;
		return $this;
	}

	public function prependFile($sHref, $sMedia = null, $bAutoPath = true)
	{
		if ($bAutoPath === true) {
			$sHref = '/css/' . $sHref;
		}
		$arsCss = array($sHref, $sMedia);
		array_unshift(self::$arsCssList, $arsCss);
		return $this;
	}

	public function prependLibrary($sLibrary, $sHref, $sMedia = null)
	{
		self::$arsCssList[] = array('/lib/' . $sLibrary . '/css/' . $sHref, $sMedia);
		return $this;
	}

	public function render()
	{
		$sHtml = '';
		foreach(self::$arsCssList as $arsCss) {
			$sHtml .= '<link href="' . $arsCss[0] . '" rel="stylesheet" type="text/css"';
			if(!empty($arsCss[1])) {
				$sHtml .= ' media="' . $arsCss[1] . '"';
			}
			$sHtml .= '>' . PHP_EOL;
		}
		if(!empty(self::$sCssCode)) {
			$sHtml .= '<style type="text/css">' . self::$sCssCode . '</style>' . PHP_EOL;
		}
		return $sHtml;
	}
}