<?php
namespace Pabana\Core;

use \Pabana\Debug\Debug;

class Core {
	// Pabana version
	const PC_VERSION = '1.0.0.0';
	// Pabana version for online documentation
	const PC_DOC_VERSION = '1.0';
	// Minimum version of PHP to launch Pabana
	const PC_PHP_MIN_VERSION = '5.5.0';
	private $_oPabanaDebug;
	private $_oPabanaConfig;

	public function __construct() {
		// Include Pabana_Core constant
		include('pabana/core/constant.core.php');
		// Include Pabana_Debug class
		include('pabana/debug/class.debug.php');
		// Initialise Pabana_Debug class
		$this->_oPabanaDebug = \Pabana\Debug\Debug::getInstance();
		// Check if this version of PHP can be use by Pabana
		$this->_checkPhpVersion();
		// Include Pabana_Core_Autoloader class
		include('pabana/core/class.autoloader.php');
		// Load class autoloader function
		$oAutoloader = \Pabana\Core\Autoloader::getInstance();
		$bAutoloader = $oAutoloader->autoLoader();
		if($bAutoloader === true) {
			$this->_oPabanaDebug->setAutoloader(true);
		}
		// Initialize Pabana_Core_Config class
		$this->_oPabanaConfig = new \Pabana\Core\Config();
		$oPabanaInfo = \Pabana\Debug\Info();
		$oPabanaInfo->info();
    }
	
	private function _checkPhpVersion() {
		// Compare current PHP version with min require version of PHP for Pabana
		if(version_compare(PHP_VERSION, PC_PHP_MIN_VERSION, '<')) {
			// If current PHP version is less than require version, show error
			$sErrorMessage = 'Your PHP version "' . PHP_VERSION . '" is less than require version of PHP "' . PC_PHP_MIN_VERSION . '" to use Pabana';
			$this->_oPabanaDebug->exception(PE_CRITICAL, 'CORE_VERSION_PHP', $sErrorMessage);
		}
	}
	
	public function getConfigByFile($sConfigPath) {
		// Initialize Pabana_File class for config file
		$oConfigFile = new Pabana_File($sConfigPath);
		// Check if this file exists
		if(!$oConfigFile->exists()) {
			$this->_oPabanaDebug->exception(PE_WARNING, 'CORE_CONFIG_FILE', 'File <strong>"' . $oConfigFile . '"</strong> isn\'t found');
			return false;
		}
		// Get extension of this file
		$sConfigFileExtension = $oConfigFile->getExtension();
		if($sConfigFileExtension == 'json') {
			$oConfigFileParse = new Pabana_Parse_Json($oConfigFile);
		} elseif($sConfigFileExtension == 'xml') {
			$oConfigFileParse = new Pabana_Parse_Xml($oConfigFile);
		} else {
			$sErrorMessage = '<strong>*.' . $sConfigFileExtension . '</strong> file isn\'t accepted by <strong>Pabana_Debug->getConfigByFile()</strong>';
			$this->_oPabanaDebug->exception(PE_WARNING, 'CORE_CONFIG_FILETYPE', $sErrorMessage);
			return false;
		}
		// Put parse content on array
		$armConfig = $oConfigFileParse->toArray();
		// Merge config
		$this->getConfigByArray($armConfig);
	}
	
	public function getConfigByArray($armConfig) {
		$this->_oPabanaConfig = Pabana_Core_Config::getInstance();
		$this->_oPabanaConfig->config($armConfig);
	}
	
	public function run() {
		// Check if a bootstrap file must be load
		if($this->_oPabanaConfig->getBootstrapEnable()) {
			require_once($this->_oPabanaConfig->getBootstrapPath());
            $oPabanaBootstrap = new applicationBootstrap();
            $oPabanaBootstrap->runBootstrap();
		}
        // Check if Pabana is launch in router mode
        if($this->_oPabanaConfig->getRouterEnable()) {
            require_once($this->_oPabanaConfig->getRouterPath());
            $oPabanaRouter = applicationRouter::getInstance();
        } else {
        	$oPabanaRouter = Pabana_Core_Router::getInstance();
        }
        $oPabanaRouter->runRouter();
        // Check if Pabana is launch on MVC mode
		if($this->_oPabanaConfig->getMvcEnable()) {
			$sController = $oPabanaRouter->getController() . 'Controller';
			$sControllerPath = $this->_oPabanaConfig->getControllerPath() . '/' . $oPabanaRouter->getController() . '/controller.' . $oPabanaRouter->getController() . '.php';
			$sAction = $oPabanaRouter->getAction() . 'Action';
			require_once($sControllerPath);
            $oPabanaController = $sController::getInstance();
            $oPabanaController->$sAction();
            unset($oPabanaController);
		}
	}
}
?>