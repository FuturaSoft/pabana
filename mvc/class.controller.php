<?php
Class Pabana_Mvc_Controller extends Pabana_Mvc {
	private $_oPabanaDebug;
	private $_oPabanaConfig;
	private $_sViewContent;
	private $_sLayoutContent;
	
	final public function __construct() {
		// Initialise Pabana_Debug class
		$this->_oPabanaDebug = Pabana_Debug::getInstance();
		$this->_oPabanaConfig = Pabana_Core_Config::getInstance();
		$oPabanaRouter = Pabana_Core_Router::getInstance();
		if($this->_oPabanaConfig->getLayoutEnable()) {
			// Set layout
			$this->setLayout($this->_oPabanaConfig->getLayoutDefault());
		}
		// Set view
		$this->setView($oPabanaRouter->getAction());
		ob_start();
	}
	
	final public function __destruct() {
		// Check if a fatal exception was catched by Pabana_Debug
		if($this->_oPabanaDebug->getFatalException() !== true) {
			if($this->getViewEnable() === true) {
				echo $this->getViewContent();
			}
			$this->_sViewContent = ob_get_contents();
			ob_end_clean();
			if($this->getLayoutEnable() === true) {
				$this->_sLayoutContent = $this->getLayout();
			} else {
				$this->_sLayoutContent = $this->_sViewContent;
			}
			// Show generate HTML code
			echo $this->_sLayoutContent;
		} else {
			ob_end_flush();
		}
	}

	final public function getLayout() {
		$sLayoutPath = $this->_oPabanaConfig->getLayoutPath() . '/' . $this->getLayoutName() . '/layout.index.php';
		ob_start();
		include($sLayoutPath);
		$sLayoutContent = ob_get_contents();
		ob_end_clean();
		return $sLayoutContent;
	}

	final public function setLayout($sLayout) {
		$this->setLayoutName($sLayout);
		$sLayoutClass = $sLayout . 'Layout';
		$sLayoutPath = $this->_oPabanaConfig->getLayoutPath() . '/' . $sLayout . '/layout.init.php';
		require_once($sLayoutPath);
		$oLayout = $sLayoutClass::getInstance();
	}
    
    final public function getViewContent() {
    	$oPabanaRouter = Pabana_Core_Router::getInstance();
    	$sControllerPath = $this->_oPabanaConfig->getControllerPath() . '/' . $oPabanaRouter->getController();
    	$sViewPath = $sControllerPath . '/view/view.' . $this->getView() . '.php';
		ob_start();
		include($sViewPath);
		$sReturn = ob_get_contents();
		ob_end_clean();
		return $sReturn;
	}

	final public function getContent() {
    	return $this->_sViewContent;
	}
}
?>