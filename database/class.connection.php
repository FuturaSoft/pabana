<?php
Class Pabana_Database_Connection {
	protected $_oPabanaDebug;
    protected $_sCnxCharset;
    protected $_sCnxDatabase;
    protected $_sCnxDbms;
    protected $_sCnxDsn;
    protected $_sCnxName;
    protected $_sCnxPassword;
    protected $_oPdo;
    protected $_bCnxPersistent;
    protected $_sCnxUser;
	
	public function __construct($sCnxDbms) {
		$this->_oPabanaDebug = $GLOBALS['pabanaInternalStorage']['pabana']['debug'];
        $this->setDbms($sCnxDbms);
        $sErrorMessage = 'Dbms <strong>' . $sCnxDbms . '</strong> isn\'t supported by Pabana Database';
        $this->_oPabanaDebug->exception(PE_INFO, 'DATABASE_CONNEXION_DBMS', $sErrorMessage);
	}
    
    public function getCharset() {
        return $this->_sCnxCharset;
    }
    
    public function getConnexion($sCnxName) {
        if(isset($GLOBALS['pabanaInternalStorage']['database'][$sCnxName])) {
            return $GLOBALS['pabanaInternalStorage']['database'][$sCnxName];
        } else {
            $sErrorMessage = 'Connexion <strong>' . $sCnxName . '</strong> doesn\'t exist';
            $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_CONNEXION_GET', $sErrorMessage);
            return false;
        }
    }
    
    public function getDatabase() {
        return $this->_sCnxDatabase;
    }
    
    public function getDbms() {
        return $this->_sCnxDbms;
    }
    
    public function getDsn() {
        return $this->_sCnxDsn;
    }
    
    public function getName() {
        return $this->_sCnxName;
    }
    
    public function getPassword() {
        return $this->_sCnxPassword;
    }
    
    public function getPdo() {
        return $this->_oPdo;
    }
    
    public function getPersistent() {
        return $this->_sCnxPersistent;
    }
    
    public function getUser() {
        return $this->_sCnxUser;
    }
    
    public function setCharset($sCnxCharset) {
        $this->_sCnxCharset = $sCnxCharset;
        return $this;
    }
    
    public function setConnexion() {
        if(empty($this->getDsn())) {
            if($this->_checkParam()) {
                $this->createDsn();
                $GLOBALS['pabanaInternalStorage']['database'][$this->_sCnxName] = $this;
                return $this;
            } else {
                return false;
            }
        } else {
            $GLOBALS['pabanaInternalStorage']['database'][$this->_sCnxName] = $this;
            return $this;
        }
    }
    
    public function setDatabase($sCnxDatabase) {
        $this->_sCnxDatabase = $sCnxDatabase;
        return $this;
    }
    
    public function setDbms($sCnxDbms) {
        $this->_sCnxDbms = $sCnxDbms;
        return $this;
    }
    
    public function setDsn($sCnxDsn) {
        $this->_sCnxDsn = $sCnxDsn;
        return $this;
    }
    
	public function setName($sCnxName) {
        $this->_sCnxName = $sCnxName;
        return $this;
    }
    
    public function setPassword($sCnxPassword) {
        $this->_sCnxPassword = $sCnxPassword;
        return $this;
    }
    
    public function setPdo($oPdo) {
        $this->_oPdo = $oPdo;
        return $this;
    }
    
    public function setPersistent($bCnxPersistent) {
        $this->_bCnxPersistent = $bCnxPersistent;
        return $this;
    }
    
    public function setUser($sCnxUser) {
        $this->_sCnxUser = $sCnxUser;
        return $this;
    }
}
?>