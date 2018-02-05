<?php
Class Pabana_Database_Connection_Sqlserver extends Pabana_Database_Connection {
    private $_sCnxApplication;
    private $_sCnxConnectionPooling;
    private $_sCnxEncrypt;
    private $_sCnxFailoverPartner;
    private $_nCnxLoginTimeout;
    private $_sCnxMultipleActiveResultSets;
    private $_nCnxQuotedId;
    private $_sCnxTraceFile;
    private $_sCnxTraceOn;
    private $_nCnxTransactionIsolation;
    private $_sCnxTrustServerCertificate;
    private $_sCnxWsid;
    
    public function __construct() {
        $this->setDbms('sqlserver');
	}
    
    protected function _checkParam() {
        if(empty($this->getHost())) {
            $sErrorMessage = 'Connexion to SQL Server must have an host defined';
            $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_CONNEXION_SQLSERVER_HOST', $sErrorMessage);
            return false;
        } else {
            return true;
        }
	}
    
    public function createDsn() {
        $sDsn = 'sqlsrv:';
        if(!empty($this->getApplication())) {
            $sDsn .= 'APP=' . $this->getApplication() . ';';
        }
        if(!empty($this->getConnectionPooling())) {
            $sDsn .= 'ConnectionPooling=' . $this->getConnectionPooling() . ';';
        }
        if(!empty($this->getDatabase())) {
            $sDsn .= 'Database=' . $this->getDatabase() . ';';
        }
        if(!empty($this->getEncrypt())) {
            $sDsn .= 'Encrypt=' . $this->getEncrypt() . ';';
        }
        if(!empty($this->getFailoverPartner())) {
            $sDsn .= 'Failover_Partner=' . $this->getFailoverPartner() . ';';
        }
        if(!empty($this->getLoginTimeout())) {
            $sDsn .= 'LoginTimeout=' . $this->getLoginTimeout() . ';';
        }
        if(!empty($this->getMultipleActiveResultSets())) {
            $sDsn .= ' MultipleActiveResultSets=' . $this->getMultipleActiveResultSets() . ';';
        }
        if(!empty($this->getQuotedId())) {
            $sDsn .= 'QuotedId=' . $this->getQuotedId() . ';';
        }
        if(!empty($this->getHost())) {
            $sDsn .= 'Server=' . $this->getHost();
            if(!empty($this->getPort())) {
                $sDsn .= ',' . $this->getPort();
            }
            $sDsn .= ';';
        }
        if(!empty($this->getTraceFile())) {
            $sDsn .= 'TraceFile=' . $this->getTraceFile() . ';';
        }
        if(!empty($this->getTraceOn())) {
            $sDsn .= 'TraceOn=' . $this->getTraceOn() . ';';
        }
        if(!empty($this->getTransactionIsolation())) {
            $sDsn .= 'TransactionIsolation=' . $this->getTransactionIsolation() . ';';
        }
        if(!empty($this->getTrustServerCertificate())) {
            $sDsn .= 'TrustServerCertificate=' . $this->getTrustServerCertificate() . ';';
        }
        if(!empty($this->getWsid())) {
            $sDsn .= 'WSID=' . $this->getWsid() . ';';
        }
        $this->_sCnxDsn = $sDsn;
		return $this;
    }
    
    public function getApplication() {
        return $this->_sCnxApplication;
    }
    
    public function getConnectionPooling() {
        return $this->_sCnxConnectionPooling;
    }
    
    public function getEncrypt() {
        return $this->_sCnxEncrypt;
    }
    
    public function getFailoverPartner() {
        return $this->_sCnxFailoverPartner;
    }
    
    public function getLoginTimeout() {
        return $this->_nCnxLoginTimeout;
    }
    
    public function getMultipleActiveResultSets() {
        return $this->_sCnxMultipleActiveResultSets;
    }
    
    public function getQuotedId() {
        return $this->_nCnxQuotedId;
    }
    
    public function getTraceFile() {
        return $this->_sCnxTraceFile;
    }
    
    public function getTraceOn() {
        return $this->_sCnxTraceOn;
    }
    
    public function getTransactionIsolation() {
        return $this->_nCnxTransactionIsolation;
    }
    
    public function getTrustServerCertificate() {
        return $this->_sCnxTrustServerCertificate;
    }
    
    public function getWsid() {
        return $this->_sCnxWsid;
    }
    
    public function setApplication($sCnxApplication) {
        $this->_sCnxApplication = $sCnxApplication;
        return $this;
    }
    
    public function setConnectionPooling($sCnxConnectionPooling) {
        $this->_sCnxConnectionPooling = $sCnxConnectionPooling;
        return $this;
    }
    
    public function setEncrypt($sCnxEncrypt) {
        $this->_sCnxEncrypt = $sCnxEncrypt;
        return $this;
    }
    
    public function setFailoverPartner($sCnxFailoverPartner) {
        $this->_sCnxFailoverPartner = $sCnxFailoverPartner;
        return $this;
    }
    
    public function setLoginTimeout($nCnxLoginTimeout) {
        $this->_nCnxLoginTimeout = $nCnxLoginTimeout;
        return $this;
    }
    
    public function setMultipleActiveResultSets($sCnxMultipleActiveResultSets) {
        $this->_sCnxMultipleActiveResultSets = $sCnxMultipleActiveResultSets;
        return $this;
    }
    
    public function setQuotedId($nCnxQuotedId) {
        $this->_nCnxQuotedId = $nCnxQuotedId;
        return $this;
    }
    
    public function setTraceFile($sCnxTraceFile) {
        $this->_sCnxTraceFile = $sCnxTraceFile;
        return $this;
    }
    
    public function setTraceOn($sCnxTraceOn) {
        $this->_sCnxTraceOn = $sCnxTraceOn;
        return $this;
    }
    
    public function setTransactionIsolation($nCnxTransactionIsolation) {
        $this->_nCnxTransactionIsolation = $nCnxTransactionIsolation;
        return $this;
    }
    
    public function setTrustServerCertificate($sCnxTrustServerCertificate) {
        $this->_sCnxTrustServerCertificate = $sCnxTrustServerCertificate;
        return $this;
    }
    
    public function setWsid($sCnxWsid) {
        $this->_sCnxWsid = $sCnxWsid;
        return $this;
    }
}
?>