<?php
namespace Pabana\Database\Connection;

use Pabana\Database\Connection;
use Pabana\Debug\Error;

class Access extends Connection {
    private $_sDriver = 'Microsoft Access Driver (*.mdb, *.accdb)';
    private $_nExclusive;
    private $_nExtendedAnsiSql;
    private $_nLocaleIdentifier;
    private $_sSystemDatabase;

    public function __construct($sCnxName) {
        $this->setName($sCnxName);
        $this->setDbms('Access');
    }

    protected function _checkParam() {
        if(empty($this->getDriver()) || empty($this->getDatabase())) {
            $sErrorMessage = 'Connexion to Access must have a driver and a database defined';
            throw new Error($sErrorMessage);
            return false;
        } else {
            return true;
        }
    }

    public function getDriver() {
        return $this->_sDriver;
    }
    
    public function getExclusive() {
        return $this->_nExclusive;
    }
    
    public function getExtendedAnsiSql() {
        return $this->_nExtendedAnsiSql;
    }
    
    public function getLocaleIdentifier() {
        return $this->_nLocaleIdentifier;
    }
    
    public function getSystemDatabase() {
        return $this->_sSystemDatabase;
    }
    
    public function setDriver($sDriver) {
        $this->_sDriver = $sDriver;
        return $this;
    }
    
    public function setExclusive($nExclusive) {
        $this->_nExclusive = $nExclusive;
        return $this;
    }
    
    public function setExtendedAnsiSql($nExtendedAnsiSql) {
        $this->_nExtendedAnsiSql = $nExtendedAnsiSql;
        return $this;
    }
    
    public function setLocaleIdentifier($nLocaleIdentifier) {
        $this->_nLocaleIdentifier = $nLocaleIdentifier;
        return $this;
    }
    
    public function setSystemDatabase($sCnxSystemDatabase) {
        $this->_sSystemDatabase = $sSystemDatabase;
        return $this;
    }
}