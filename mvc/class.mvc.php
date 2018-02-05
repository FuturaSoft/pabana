<?php
abstract Class Pabana_Mvc {
	static protected $_oDom;
	static protected $_oPabanaMvc;
	static protected $_bLayout;
	static protected $_sLayout;
	static protected $_bView;
	static protected $_sView;
	static protected $_armBridge;
	
    private function __clone() { } 
    public function __construct() {
    	self::$_oDom = new Pabana_Dom();
    	self::$_bLayout = true;
    	self::$_bView = true;
    } 
    private function __wakeup() { }
 
    final public static function getInstance() {
        if ( !isset( static::$_oPabanaMvc ) ) {
            static::$_oPabanaMvc = new static();
        }
        return static::$_oPabanaMvc;
    }

    final public static function Layout() {
		return self::$_oDom;
	}

	final public static function View() {
		return self::$_oDom;
	}
    
	final public static function disableLayout() {
		self::$_bLayout = false;
	}
	
	final public static function disableView() {
		self::$_bView = false;
	}
	
	final public static function enableLayout() {
		self::$_bLayout = true;
	}
	
	final public static function enableView() {
		self::$_bView = true;
	}

	final public static function getLayoutEnable() {
		return self::$_bLayout;
	}
	
	final public static function getViewEnable() {
		return self::$_bView;
	}

	final public static function setLayoutName($sLayoutName) {
		self::$_sLayout = $sLayoutName;
	}

	final public static function getLayoutName() {
		return self::$_sLayout;
	}

	final public static function setView($sView) {
		self::$_sView = $sView;
	}

	final public static function getView() {
		return self::$_sView;
	}

	final protected static function sendVariable($sMvcPart, $sVariableName, $mVariable) {
        self::$_armBridge[$sMvcPart][$sVariableName] = $mVariable;
    }

    final protected static function getVariableBridge($sMvcPart) {
    	return self::$_armBridge[$sMvcPart];
    }
    
    /*final public function getApplicationPath() {
		return $GLOBALS['pabanaConfigStorage']['pabana']['application_path'];
	}
	
	final public function getLayoutPart($sPartName) {
		include($GLOBALS['pabanaConfigStorage']['pabana']['application_path'] . $GLOBALS['pabanaConfigStorage']['layout']['path'] . '/' . $this->sLayout . '/layout.' . $sPartName . '.php');
	}
    
    final public function getModel($sModelName) {
        $sModelClassName = $sModelName . 'Model';
		if(!class_exists($sModelClassName)) {
			include($GLOBALS['pabanaConfigStorage']['pabana']['application_path'] . $GLOBALS['pabanaConfigStorage']['mvc']['model_path'] . '/model.' . $sModelName . '.php');
		}
		return new $sModelClassName();
    }
	
	final public function setLayout($sLayoutName) {
		$this->enableLayout();
		$GLOBALS['pabanaInternalStorage']['instance']['layout']['name'] = $sLayoutName;
		$this->cleanDom();
		include($GLOBALS['pabanaConfigStorage']['application_path'] . $GLOBALS['pabanaConfigStorage']['layout']['path'] . '/' . $sLayoutName . '/layout.init.php');
	}
	
	final public function setView($sViewName) {
		$this->enableView();
		$GLOBALS['pabanaInternalStorage']['instance']['view']['name'] = $sViewName;
	}
	
	final public function toLayout($sVariableName, $mVariable) {
        $this->sendVariable('layout', $sVariableName, $mVariable);
	}
	
	final public function toView($sVariableName, $mVariable) {
        $this->sendVariable('view', $sVariableName, $mVariable);
	}*/
}
?>