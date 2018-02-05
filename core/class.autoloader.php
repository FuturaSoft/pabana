<?php
namespace Pabana\Core;

class Autoloader {
	/**
     * Instance of Pabana_Core_Autoloader
     * @static
     * @var Pabana_Core_Autoloader
     */
    static private $_oPabanaCoreAutoloader;
	private $_oPabanaDebug;
	private $_bAutoloader = false;

	public function __construct() {
		// Set autoloader boolean to false
		$this->_bAutoloader = false;
		// Initialise Pabana_Debug class
		$this->_oPabanaDebug = \Pabana\Debug\Debug::getInstance();
    }
	
	/**
     * Singleton of class
     * @return Pabana_Core_Autoloader
     */
    public static function getInstance() {
        if(!isset(self::$_oPabanaCoreAutoloader)) {
            self::$_oPabanaCoreAutoloader = new \Pabana\Core\Autoloader();
		}
        return self::$_oPabanaCoreAutoloader;
    }
	
	public function autoLoader() {
		if($this->_bAutoloader === true) {
			$sErrorMessage = 'Autoloader class is already registered';
			$this->_oPabanaDebug->exception(PE_WARNING, 'CORE_AUTOLOADER_REGISTRED', $sErrorMessage);
			return false;
		} 
		// Declare new autoload function
		spl_autoload_register(function($sAutoLoadClass) {
			// Check if autoload function is ask by Pabana
			if(stripos($sAutoLoadClass, 'Pabana') !== false) {
				// Explode class name in array
				$arsAutoLoadClass = explode('\\', $sAutoLoadClass);
				// Generate directory path for class
				$sGeneralPath = strtolower($arsAutoLoadClass[0]) . '/' . strtolower($arsAutoLoadClass[1]) . '/';
				if(count($arsAutoLoadClass) == 2) {
					// Autoloader class name eq Pabana_Module
					$sClassPath = $sGeneralPath . 'class.' . $arsAutoLoadClass[1] . '.php';
					$sConstantPath = $sGeneralPath . 'constant.' . $arsAutoLoadClass[1] . '.php';
				} elseif(count($arsAutoLoadClass) == 3) {
					// Autoloader class name eq Pabana_Module_Class
					$sClassPath = $sGeneralPath . 'class.' . $arsAutoLoadClass[2] . '.php';
					$sConstantPath = $sGeneralPath . 'constant.' . $arsAutoLoadClass[2] . '.php';
				} elseif(count($arsAutoLoadClass) == 4) {
					// Autoloader class name eq Pabana_Module_Class_Class2
					$sClassPath = $sGeneralPath . strtolower($arsAutoLoadClass[2]) . '/class.' . $arsAutoLoadClass[3] . '.php';
					$sConstantPath = $sGeneralPath . strtolower($arsAutoLoadClass[2]) . '/constant.' . $arsAutoLoadClass[3] . '.php';
				}
                // If exists include constant file
                if(stream_resolve_include_path($sConstantPath)) {
					include_once($sConstantPath);
				}
				// If exists include class file
				if(stream_resolve_include_path($sClassPath)) {
					include($sClassPath);
				} else {
					// Show error message coz class file don't exists
					$sErrorMessage = 'Autoloading of <strong>' . $sAutoLoadClass . '</strong> abort, cause <strong>"' . $sClassPath . '"</strong> file can\'t be read';
					$this->_oPabanaDebug->exception(PE_ERROR, 'CORE_AUTOLOADER_FILE', $sErrorMessage);
				}
			} else {
				return false;
			}
		}, true, true);
		$this->_bAutoloader = true;
		return true;
	}
}
?>