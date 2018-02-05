<?php
Class Pabana_Database_Connection_Mysql extends Pabana_Database_Connection {
    private $_sCnxHost;
    private $_nCnxPort;
    private $_sCnxUnixSocket;
    
    public function __construct() {
        $this->setDbms('mysql');
	}
    
    protected function _checkParam() {
        if(empty($this->getHost()) || empty($this->getUnixSocket())) {
            $sErrorMessage = 'Connexion to Mysql must have an host or path to unix socket defined';
            $this->_oPabanaDebug->exception(PE_ERROR, 'DB_CNX_MYSQL_HOST_OR_UNIX_SOCKET', $sErrorMessage);
            return false;
        } else {
            return true;
        }
	}
    
    public function createDsn() {
        if(!empty($this->getHost())) {
            $sDsn = 'mysql:host=' . $this->getHost() . ';';
            if(!empty($this->getPort())) {
                $sDsn .= 'port=' . $this->getPort() . ';';
            }
        } else {
            $sDsn = 'mysql:unix_socket=' . $this->getUnixSocket() . ';';
        }
        if(!empty($this->getDatabase())) {
            $sDsn .= 'dbname=' . $this->getDatabase() . ';';
        }
        if(!empty($this->getCharset())) {
            $sDsn .= 'charset=' . $this->getCharset() . ';';
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
    
    public function getUnixSocket() {
        return $this->_sCnxUnixSocket;
    }
    
    public function setHost($sCnxHost) {
        $this->_sCnxHost = $sCnxHost;
        return $this;
    }
    
    public function setPort($nCnxPort) {
        $this->_nCnxPort = $nCnxPort;
        return $this;
    }
    
    public function setUnixSocket($sCnxUnixSocket) {
        $this->_sCnxUnixSocket = $sCnxUnixSocket;
        return $this;
    }
}
?>