<?php
Class Pabana_Core_Router {
	protected static $_oPabanaRouter = null;
	protected $_armRouteList;
	protected $_cUrlSeparator;
	protected $_sUri;
	protected $_sController;
	protected $_sAction;
	
    public function __construct() {
		$this->_sUri = $_SERVER['REQUEST_URI'];
		$this->_sController = 'index';
		$this->_sAction = 'index';
		$this->_cUrlSeparator = '/';
		$this->_armRouteList = array();
	}
	
	public function getController() {
		return $this->_sController;
	}
	
	public function getAction() {
		return $this->_sAction;
	}
	
	/**
     * Singleton of class
     * @return Pabana_Core_Router
     */
    public static function getInstance() {
        if(!isset(self::$_oPabanaRouter)) {
			self::$_oPabanaRouter = new Pabana_Core_Router();
		}
        return self::$_oPabanaRouter;
    }
	
	protected function clearEmptyItem(&$array) {
        foreach ($array as $key => $value) {
            if (empty($value))
                unset($array[$key]);
        }
        $array = array_values($array);
    }
	
	public function runRouter() {
		$sUrl = $_SERVER['REQUEST_URI'];
		$armRoute = $this->matchRoute($sUrl);
		if(!empty($armRoute)) {
			
		} else {
			$this->_defaultRoutage();
		}
	}
	
	protected function _defaultRoutage() {
		$arsUri = explode($this->_cUrlSeparator, $this->_sUri);
		$nSplitUri = count($arsUri);
		if($nSplitUri >= 2 && !empty($arsUri[1])) {
			$this->_sController = $arsUri[1];
		}
		if($nSplitUri >= 3 && !empty($arsUri[2])) {
			$this->_sAction = $arsUri[2];
		}
		$sKeyGetVariable = '';
		$armGetVariable = array();
		for($i=3; $i<$nSplitUri; $i++) {
			if(($i+1)%2 == 0) {
				$sKeyGetVariable = urldecode($arsUri[$i]);
				$armGetVariable[$sKeyGetVariable] = null;
			} else {
				$armGetVariable[$sKeyGetVariable] = urldecode($arsUri[$i]);
			}
		}
		$_GET = $armGetVariable;
	}
	
	public function setRoute($sUrl, $sController = 'index', $sAction = 'index', $arsParam = null) {
		$nUrlItem = substr_count($this->_cUrlSeparator, $sUrl);
		$this->_armRouteList[] = array(
			'url' => $sUrl,
			'url_item' => $nUrlItem,
			'controller' => $sController,
			'action' => $sAction,
			'param' => $arsParam
		);
	}
	
	private function matchRoute($sUrl) {
		$arsUrlItemList = explode($this->_cUrlSeparator, $sUrl);
		$this->clearEmptyItem($arsUrlItemList);
		$nUrlItemList = count($arsUrlItemList);
		if(!empty($this->_armRouteList)) {
			foreach($this->_armRouteList as $armRoute) {
				if($armRoute['url_item'] == $nUrlItemList) {
					$bRoute = true;
					$arsRouteItemList = explode($this->_cUrlSeparator, $armRoute['url']);
					foreach($arsUrlItemList as $nIndexUrlItem => $arsUrlItem) {
						if($arsRouteItemList[$nIndexUrlItem] != $arsUrlItem) {
							$bRoute = false;
						}
					}
					if($bRoute === true) {
						return $armRoute;
					}
				}
			}
		}
		return false;
	}
}
?>