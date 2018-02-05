<?php
Class Pabana_Database_Connection_Pgsql extends Pabana_Database_Connection {
    private $_sCnxHost;
    private $_nCnxPort;
    
    public function __construct() {
        $this->setDbms('pgsql');
	}
    
    protected function _checkParam() {
        if(empty($this->getHost())) {
            $sErrorMessage = 'Connexion to PostgreSQL must have an host defined';
            $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_CONNEXION_PGSQL_HOST', $sErrorMessage);
            return false;
        } else {
            return true;
        }
	}
    
    public function createDsn() {
        $sDsn = 'pgsql:host=' . $this->getHost() . ';';
        if(!empty($this->getPort())) {
            $sDsn .= 'port=' . $this->getPort() . ';';
        }
        if(!empty($this->getDatabase())) {
            $sDsn .= 'dbname=' . $this->getDatabase() . ';';
        }
        $this->_sCnxDsn = $sDsn;
		return $this;
    }
    
    public function getHost() {
        return $this->_sCnxHost;
    }
    
    public function getPort() {
        return $this->_nCnxPort;
    }
    
    public function setHost($sCnxHost) {
        $this->_sCnxHost = $sCnxHost;
    }
    
    public function setPort($nCnxPort) {
        $this->_nCnxPort = $nCnxPort;
    }
}
?>