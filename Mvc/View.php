<?php
namespace Pabana\Mvc;

use Pabana\Core\Configuration;
use Pabana\Html\Html;
use Pabana\Network\Request;

class View {
	private static $_armVariable;
	private static $bAutoRender;
	private static $sDirectory;
	private static $sExtension;
	private static $sName;
	private static $sPrefix;
	public $Html;

	public function __construct() {
		// Load Mvc\Html helper to $Html var
		$this->Html = new Html();
		// Set auto render status from configuration
		$this->setAutoRender(Configuration::get('view.auto_render'));
		// Set default directory for view
		$sDirectory = Configuration::get('application.path') . Configuration::get('view.path') . '/' . ucfirst(Request::getController());
		$this->setDirectory($sDirectory);
		// Set extension from configuration
		$this->setExtension(Configuration::get('view.extension'));
		// Set prefix from configuration
		$this->setPrefix(Configuration::get('view.prefix'));
	}

	public function __toString() {
        return $this->render();
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
		$sViewPath = $this->getDirectory() . '/'. $this->getPrefix() . $this->getName() . '.' . $this->getExtension();
		ob_start();
		require($sViewPath);
		$sHtmlView = ob_get_contents();
		ob_end_clean();
		return $sHtmlView;
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
		self::$_armVariable[$sVarName] = $sVarValue;
		return true;
	}
}