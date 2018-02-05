<?php
namespace Pabana\Database;

use Pabana\Debug\Error;

class Connection {
    protected $_sCharset;
    protected $_sDatabase;
    protected $_sDbms = null;
	protected $_sName;
    protected $_sPassword;
    protected $_sUser;

    public function getCharset() {
        return $this->_sCharset;
    }

    public function getDatabase() {
        return $this->_sDatabase;
    }

    public function getOption() {
        return array();
    }
	
	public function getName() {
        return $this->_sName;
    }

    public function getPassword() {
        return $this->_sPassword;
    }

    public function getUser() {
        return $this->_sUser;
    }

    public function setCharset($sCharset) {
        $this->_sCharset = $sCharset;
        return $this;
    }

    public function setDatabase($sDatabase) {
        $this->_sDatabase = $sDatabase;
        return $this;
    }

    public function setDbms($sDbms) {
        $this->_sDbms = $sDbms;
        return $this;
    }

	public function setName($sName) {
        $this->_sName = $sName;
        return $this;
    }
	
    public function setPassword($sPassword) {
        $this->_sPassword = $sPassword;
        return $this;
    }

    public function setUser($sUser) {
        $this->_sUser = $sUser;
        return $this;
    }
}