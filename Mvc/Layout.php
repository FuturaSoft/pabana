<?php
namespace Pabana\Mvc;

use Pabana\Core\Configuration;
use Pabana\Debug\Error;
use Pabana\Html\Html;
use Pabana\Mvc\View;
use Pabana\Network\Request;

class Layout {
	private static $_armVariable;
	private static $bAutoRender;
	private static $sDirectory;
	private static $sExtension;
	private static $sName;
	private static $sPrefix;
	public $Html;
	public $View;

	public function __construct() {
		// Load Mvc\Html helper to $Html var
		$this->Html = new Html();
		// Load Mvc\View to $View var
		$this->View = new View();
		// Set auto render status from configuration
		$this->setAutoRender(Configuration::get('layout.auto_render'));
		// Set default directory for view
		$sDirectory = Configuration::get('application.path') . Configuration::get('layout.path');
		$this->setDirectory($sDirectory);
		// Set extension from configuration
		$this->setExtension(Configuration::get('layout.extension'));
		// Set prefix from configuration
		$this->setPrefix(Configuration::get('layout.prefix'));
		// Set default layout name
		$this->setName(ucfirst(Configuration::get('layout.default')));
	}

	public function __toString() {
        return $this->render();
    }

    public function element($sElement) {
		$sPath = $this->getDirectory() . '/' . $this->getName() . '/' . $this->getPrefix() . $sElement . '.' . $this->getExtension();
		ob_start();
		require($sPath);
		echo PHP_EOL;
		$sHtml = ob_get_contents();
		ob_end_clean();
		return $sHtml;
	}

	public function getAutoRender() {
		return self::$bAutoRender;
	}

	public function getDirectory() {
		return self::$sDirectory;
	}

	public function getExtension() {
		return self::$sExtension;
	}

	public function getName() {
		return self::$sName;
	}

	public function getPrefix() {
		return self::$sPrefix;
	}

	public function getVar($sVarName) {
		return self::$_armVariable[$sVarName];
	}

	public function render() {
		return $this->element('index');
	}

	public function renderInit() {
		$this->Html->clean();
		$sInitPath = $this->getDirectory() . '/' . $this->getName() . '/' . $this->getPrefix() . 'init.' . $this->getExtension();
		require($sInitPath);
	}

	public function setAutoRender($bAutoRender) {
		self::$bAutoRender = $bAutoRender;
		return true;
	}

	public function setDirectory($sDirectory) {
		self::$sDirectory = $sDirectory;
		return true;
	}

	public function setExtension($sExtension) {
		self::$sExtension = $sExtension;
		return true;
	}

	public function setName($sName) {
		self::$sName = $sName;
		return true;
	}

	public function setPrefix($sPrefix) {
		self::$sPrefix = $sPrefix;
		return true;
	}

	public function setVar($sVarName, $sVarValue) {
		if(!isset(self::$_armVariable[$sVarName])) {
			self::$_armVariable[$sVarName] = $sVarValue;
			return true;
		} else {
			throw new Error("La variable " . $sVarName . " est déja défini dans le Layout");
			return false;
		}
	}
}