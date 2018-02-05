<?php
namespace Pabana\Network;

class Request {
	private static $_sController = null;
	private static $_sAction = null;
	private static $_arsParamList = null;
	private static $_sUrl = null;

	public function __construct() {
		self::$_sUrl = $_SERVER['REQUEST_URI'];
	}

	public static function getAction() {
		return self::$_sAction;
	}

	public static function getController() {
		return self::$_sController;
	}

	public static function getParamList() {
		return self::$_arsParamList;
	}

	public static function getUrl() {
		return self::$_sUrl;
	}

	public static function setAction($sAction) {
		self::$_sAction = $sAction;
	}

	public static function setController($sController) {
		self::$_sController = $sController;
	}

	public static function setParamList($arsParamList) {
		self::$_arsParamList = $arsParamList;
		$_GET = $arsParamList;
	}

	public function getHost() {
		return $_SERVER['HTTP_HOST'];
	}

	public function getUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}

	public function getMethod() {
		return $_SERVER['REQUEST_METHOD'];
	}
	
	public function isAjax() {
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			return true;
		} else {
			return false;
		}
	}

	public function isGet() {
		if($_SESSION['REQUEST_METHOD'] == 'GET') {
			return true;
		} else {
			return false;
		}
	}

	public function isPost() {
		if($_SESSION['REQUEST_METHOD'] == 'POST') {
			return true;
		} else {
			return false;
		}
	}

	public function isPut() {
		if($_SESSION['REQUEST_METHOD'] == 'PUT') {
			return true;
		} else {
			return false;
		}
	}

	public function isDelete() {
		if($_SESSION['REQUEST_METHOD'] == 'DELETE') {
			return true;
		} else {
			return false;
		}
	}
}
?>