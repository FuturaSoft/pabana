<?php
namespace Pabana\Network\Http;

use Pabana\Type\Array;

class Request
{
	public $request;
	public $query;
	public $cookies;
	public $files;
	public $server;
	public $headers;
	public $ajax = false;
	public $connection;
	public $host;
	public $method;
	public $url;
	public $userAgent;


	public function __construct($oRequest = array(), $oQuery = array(), $oCookies = array(),
								$oFiles = array(), $oServer = array(), $oHeaders = array())
	{
		$this->request = new Array($oRequest);
		$this->query = new Array($oQuery);
        $this->cookies = new Array($oCookies);
        $this->files = new Array($oFiles);
        $this->server = new Array($oServer);
        $this->headers = new Array($oHeaders);
        $this->initialize();
	}

	public function createFromGlobals()
	{
		$this->request = new Array($_POST);
		$this->query = new Array($_GET);
        $this->cookies = new Array($_COOKIES);
        $this->files = new Array($_FILES);
        $this->server = new Array($_SERVER);
        $this->headers = new Array(getallheaders());
        $this->initialize();
	}

	public function initialize()
	{
		if(!empty($this->server->get('HTTP_X_REQUESTED_WITH')) && strtolower($this->server->get('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest') {
			$this->ajax = true;
		}
		$this->connection = $this->server->get('HTTP_CONNECTION');
		$this->host = $this->server->get('HTTP_HOST');
		$this->method = $this->server->get('REQUEST_METHOD');
		$this->url = $this->server->get('REQUEST_URI');
		if(isset($this->server->get('HTTP_USER_AGENT'))) {
			$this->userAgent = $this->server->get('HTTP_USER_AGENT');
		}
	}

	public static function getUrl()
	{
		return $this->url;
	}

	public function getHost()
	{
		return $this->host;
	}

	public function getUserAgent()
	{
		return $this->userAgent;
	}

	public function getMethod()
	{
		return $this->method;
	}
	
	public function isAjax()
	{
		return $this->ajax;
	}

	public function isGet()
	{
		if($this->method == 'GET') {
			return true;
		} else {
			return false;
		}
	}

	public function isPatch()
	{
		if($this->method == 'PATCH') {
			return true;
		} else {
			return false;
		}
	}

	public function isPost()
	{
		if($this->method == 'POST') {
			return true;
		} else {
			return false;
		}
	}

	public function isPut()
	{
		if($this->method == 'PUT') {
			return true;
		} else {
			return false;
		}
	}

	public function isDelete()
	{
		if($this->method == 'DELETE') {
			return true;
		} else {
			return false;
		}
	}
}