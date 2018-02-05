<?php
namespace Pabana\Mvc;

use Pabana\Core\Configuration;
use Pabana\Database\Database;

class Model {
	public $Database;
	private static $sDirectory;
	private static $sExtension;
	private static $sPrefix;

	public function __construct() {
		$this->Database = new Database();
		// Set default directory for model
		$sDirectory = Configuration::get('application.path') . Configuration::get('model.path');
		$this->setDirectory($sDirectory);
		// Set extension from configuration
		$this->setExtension(Configuration::get('model.extension'));
		// Set prefix from configuration
		$this->setPrefix(Configuration::get('model.prefix'));
	}

	public function get($sModel) {
		$sModelPath = $this->getDirectory() . '/'. $this->getPrefix() . $sModel . '.' . $this->getExtension();
		require($sModelPath);
		$sModel = 'Application\Model\\' . ucFirst($sModel);
		return new $sModel;
	}

	public function getDirectory() {
		return self::$sDirectory;
	}

	public function getExtension() {
		return self::$sExtension;
	}

	public function getPrefix() {
		return self::$sPrefix;
	}

	public function setDirectory($sDirectory) {
		self::$sDirectory = $sDirectory;
		return true;
	}

	public function setExtension($sExtension) {
		self::$sExtension = $sExtension;
		return true;
	}

	public function setPrefix($sPrefix) {
		self::$sPrefix = $sPrefix;
		return true;
	}
}