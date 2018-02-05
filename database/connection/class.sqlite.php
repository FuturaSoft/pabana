<?php
Class Pabana_Database_Connection_Sqlite extends Pabana_Database_Connection {
    private $_bCnxMemory = false;
    
    public function __construct() {
        $this->setDbms('sqlite');
	}
    
    protected function _checkParam() {
        if(empty($this->getDatabase()) && $this->getMemory() === false) {
            $sErrorMessage = 'Connexion to SQLite must have a database defined';
            $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_CONNEXION_SQLITE_DATABASE', $sErrorMessage);
            return false;
        } else {
            return true;
        }
	}
    
    public function createDsn() {
        $sDsn = 'sqlite:';
        if($this->getMemory() === true) {
            $sDsn .= ':memory:';
        } else {
            $sDsn .= $this->getDatabase();
        }
        $this->_sCnxDsn = $sDsn;
		return $this;
    }
    
    public function getMemory() {
        return $this->_bCnxMemory;
    }
    
    public function setMemory($bCnxMemory) {
        $this->_bCnxMemory = $bCnxMemory;
    }
}
?>