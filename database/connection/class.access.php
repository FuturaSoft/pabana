<?php
Class Pabana_Database_Connection_Access extends Pabana_Database_Connection {
    private $_sCnxDriver = 'Microsoft Access Driver (*.mdb, *.accdb)';
    private $_nCnxExclusive;
    private $_nCnxExtendedAnsiSql;
    private $_nCnxLocaleIdentifier;
    private $_sCnxSystemDatabase;
    
    public function __construct() {
        $this->setDbms('access');
	}
    
    protected function _checkParam() {
        if(empty($this->getDriver()) || empty($this->getDatabase())) {
            $sErrorMessage = 'Connexion to Access must have a driver and a database defined';
            $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_CONNEXION_ACCESS_DRIVER_AND_DATABASE', $sErrorMessage);
            return false;
        } else {
            return true;
        }
	}
    
    public function createDsn() {
        $sDsn = 'odbc:Driver={' . $this->getDriver() . '};';
        $sDsn .= 'Dbq=' . $this->getDatabase() . ';';
		if(!empty($this->getSystemDatabase())) {
			$sDsn .= 'SystemDB=' . $this->getSystemDatabase() . ';';
		}
        if(!empty($this->getUser())) {
			$sDsn .= 'Uid=' . $this->getUser() . ';';
		}
        if(!empty($this->getPassword())) {
			$sDsn .= 'Pwd=' . $this->getPassword() . ';';
		}
        if(!empty($this->getExclusive())) {
            $sDsn .= 'Exclusive=' . $this->getLocaleIdentifier() . ';';
		}
        if(!empty($this->getExtendedAnsiSql())) {
            $sDsn .= 'ExtendedAnsiSQL=' . $this->getLocaleIdentifier() . ';';
		}
        if(!empty($this->getLocaleIdentifier())) {
			$sDsn .= 'Locale Identifier=' . $this->getLocaleIdentifier() . ';';
		}
        $this->_sCnxDsn = $sDsn;
		return $this;
    }
    
    public function getDriver() {
        return $this->_sCnxDriver;
    }
    
    public function getExclusive() {
        return $this->_nCnxExclusive;
    }
    
    public function getExtendedAnsiSql() {
        return $this->_nCnxExtendedAnsiSql;
    }
    
    public function getLocaleIdentifier() {
        return $this->_nCnxLocaleIdentifier;
    }
    
    public function getSystemDatabase() {
        return $this->_sCnxSystemDatabase;
    }
    
    public function setDriver($sCnxDriver) {
        $this->_sCnxDriver = $sCnxDriver;
        return $this;
    }
    
    public function setExclusive($nCnxExclusive) {
        $this->_nCnxExclusive = $nCnxExclusive;
        return $this;
    }
    
    public function setExtendedAnsiSql($nCnxExtendedAnsiSql) {
        $this->_nCnxExtendedAnsiSql = $nCnxExtendedAnsiSql;
        return $this;
    }
    
    public function setLocaleIdentifier($nCnxLocaleIdentifier) {
        $this->_nCnxLocaleIdentifier = $nCnxLocaleIdentifier;
        return $this;
    }
    
    public function setSystemDatabase($sCnxSystemDatabase) {
        $this->_sCnxSystemDatabase = $sCnxSystemDatabase;
        return $this;
    }
}
?>