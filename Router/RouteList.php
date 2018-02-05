<?php
namespace Pabana\Router;

use Pabana\Router\Route;

Class RouteList {
	private $_arsRouteList = null;

	public function __construct() {
		$this->_arsRouteList = array();
	}

	public function add($sRoute, $arsOption) {
		$this->_arsRouteList[] = new Route($sRoute, $arsOption);
	}

	public function getList() {
		return $this->_arsRouteList;
	}
}
?>