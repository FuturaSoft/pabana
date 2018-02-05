<?php
namespace Pabana\Router;

use Pabana\Core\Configuration;
use Pabana\Network\Request;
use Pabana\Router\Route;
use Pabana\Router\RouteList;

Class Router {
	public $RouteList = null;
	private $_arcSeparator = array('/', '?', '&', '=');

	public function __construct() {
		// Get route list
		$this->RouteList = new RouteList();
		// Set separator
		if(Configuration::exists('router.separator')) {
			$this->setSeparator(Configuration::get('router.separator'));
		}
		// Check if a router config file is enable
		if(Configuration::exists('router.path')) {
			// Init routage
			$this->initialize();
		}
		// Resolve routage
		$this->resolve();
	}

	public function resolve() {
		// Get current URL
		$sUrl = Request::getUrl();
		// Remove last char of URL if it's a separator
		$sUrl = $this->_removeLastSeparator($sUrl);
		// Get list of separator for this URL
		$arcUrlSeparator = $this->_listSeparator($sUrl);
		// Get list of value of this URL
		$arsUrlValue = $this->_listValue($sUrl);
		// Check route
		$bCheckResult = $this->_checkRoute($arcUrlSeparator, $arsUrlValue);
		if (!$bCheckResult) {
			$this->_checkDefault($arsUrlValue);
		}
		$this->_checkFile();
	}

	public function setSeparator($mSeparator) {
		$arcSeparator = array('?', '&', '=');
		if(is_array($mSeparator)) {
			$arcSeparator += $mSeparator;
		} else {
			$arcSeparator[] = $mSeparator;
		}
		$this->_arcSeparator = $arcSeparator;
	}

	private function _checkRoute($arcUrlSeparator, $arsUrlValue) {
		foreach ($this->RouteList->getList() as $oRoute) {
			// Get route
			$sRoute = $oRoute->getRoute();
			// Remove last char of route if it's a separator
			$sRoute = $this->_removeLastSeparator($sRoute);
			// Get list of separator for this route
			$arcRouteSeparator = $this->_listSeparator($sRoute);
			// If URL and route have same number of separator in same position
			if ($arcUrlSeparator == $arcRouteSeparator) {
				// Get list of value of this route
				$arsRouteValueList = $this->_listValue($sRoute);
				// Valid boolean
				$bGoodRoute = true;
				// Array to store param
				$arsParamList = array();
				// Check each value of url to compare with route
				foreach($arsRouteValueList as $nParamIndex => $sRouteValue) {
					if(isset($arsUrlValue[$nParamIndex])) {
						// Get first char of 
						$cFirstCharValue = substr($sRouteValue, 0, 1);
						if($cFirstCharValue == ':') {
							$arsParamList[substr($sRouteValue, 1)] = $arsUrlValue[$nParamIndex];
						} else if($sRouteValue != $arsUrlValue[$nParamIndex] && $cFirstCharValue != '*') {
							$bGoodRoute = false;
						}
					} else {
						$bGoodRoute = false;
					}
				}
				// If valid boolean is true
				if($bGoodRoute) {
					// Set controller to route controller
					Request::setController($oRoute->getController());
					// Set action to route action
					Request::setAction($oRoute->getAction());
					// Add route param to param list
					if(is_array($oRoute->getParamList())) {
						$arsParamList = $arsParamList + $oRoute->getParamList();
					}
					// Set param list
					Request::setParamList($arsParamList);
					// End of check route
					return true;
				}
			}
		}
		// No route is found
		return false;
	}

	private function _checkDefault($arsUrlValueList) {
		$sController = 'index';
		$sAction = 'index';
		$arsParamList = array();
		foreach ($arsUrlValueList as $nIndexValue => $sUrlValue) {
			if($nIndexValue == 0) {
				$sController = $sUrlValue;
			} else if($nIndexValue == 1) {
				$sAction = $sUrlValue;
			} else {
				if(isset($arsUrlValueList[$nIndexValue]) && $nIndexValue % 2 == 0) {
					$sParamName = $arsUrlValueList[$nIndexValue];
					$sParamValue = null;
					if(isset($arsUrlValueList[$nIndexValue + 1])) {
						$sParamValue = $arsUrlValueList[$nIndexValue + 1];
					}
					$arsParamList[$sParamName] = $sParamValue;
				}
			}
		}
		Request::setController($sController);
		// Set action to route action
		Request::setAction($sAction);
		// Set param list
		Request::setParamList($arsParamList);
	}

	private function _checkFile() {
		$sController = Request::getController();
		$sControllerPath = Configuration::get('application.path') . Configuration::get('controller.path');

		if(!file_exists($sControllerPath . DIRECTORY_SEPARATOR . ucfirst($sController) . '.php')) {
			Request::setController('error');
			// Set action to route action
			Request::setAction('index');
			// Set param list
			Request::setParamList(array('code' => 404));
		}
	}

	private function _listSeparator($sUrl) {
		$armSeparatorPosition = array();
		foreach ($this->_arcSeparator as $cSeparator) {
			$sUrlSearch = $sUrl;
			while ($nSeparatorPosition = strrpos($sUrlSearch, $cSeparator)) {
		        $armSeparatorPosition[$nSeparatorPosition] = $cSeparator;
		        $sUrlSearch = substr($sUrlSearch, 0, $nSeparatorPosition);
		    }
		}
		ksort($armSeparatorPosition);
		return array_values($armSeparatorPosition);
	}

	private function _removeLastSeparator($sUrl) {
		$cLastChar = substr($sUrl, -1);
		if(in_array($cLastChar, $this->_arcSeparator)) {
			$sUrl = substr($sUrl, 0, -1);
		}
		return $sUrl;
	}

	private function _listValue($sUrl) {
		$sRegexSeparator = implode('', $this->_arcSeparator);
		$sRegexSeparator = preg_quote($sRegexSeparator);
		$arsListValue = preg_split("{[" . $sRegexSeparator . "]}", $sUrl);
		array_shift($arsListValue);
		return $arsListValue;
	}
}
?>