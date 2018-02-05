<?php
namespace Pabana\Core;

use Pabana\Core\Configuration;
use Pabana\Debug\Error;
use Pabana\Network\Request;

const PE_VERSION = '1.0.0.0';
const PE_PHP_MIN_VERSION = '5.5';
const E_NO = 0;

class Core {

	public function __construct() {
		// Check if this version of PHP can be use by Pabana
		$this->_checkPhpVersion();
		// Store default settings for Pabana
		Configuration::base();
    }
	
	private function _checkPhpVersion() {
		// Compare current PHP version with min require version of PHP for Pabana
		if(version_compare(PHP_VERSION, PE_PHP_MIN_VERSION, '<')) {
			// If current PHP version is less than require version, show error
			$sErrorMessage = 'Your PHP version "' . PHP_VERSION . '" is less than require version of PHP "' . PE_PHP_MIN_VERSION . '" to use Pabana';
			throw new Error($sErrorMessage);
		}
	}
	
	public function run() {
		// Init request object
		new Request();
		// Start routing
		$sRouterPath = Configuration::get('application.path') . Configuration::get('router.path');
		require($sRouterPath);
		new \Application\Router();
		// Load bootstrap file
		$sBootstrapPath = Configuration::get('application.path') . Configuration::get('bootstrap.path');
		require($sBootstrapPath);
		$oBootstrap = new \Application\Bootstrap();
		$oBootstrap->initialize();
		// Start controller
		$this->_runController();
	}

	private function _runController() {
		$sControllerPath = Configuration::get('application.path') . Configuration::get('controller.path');
		$sController = '\Application\Controller\\' . ucfirst(Request::getController());
		$sAction = Request::getAction();
		require($sControllerPath . '/' . ucfirst(Request::getController()) . '.php');
		$oController = new $sController();
		$oController->init();
		if(method_exists($oController, 'initialize')) {
			$oController->initialize();
		}
		$oController->$sAction();
		// Clean Controller object (and launch __destroy method of controller)
		unset($oController);
	}
}