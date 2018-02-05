<?php
class Pabana_Http {
	public function setLocation($sUrl, $bExit = true) {
		header("Location: " . $sUrl);
		if($bExit === true) {
			exit();
		}
		return true;
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