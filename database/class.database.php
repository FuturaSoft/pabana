<?php
Class Pabana_Database {
    private $_oPabanaDebug;
    private $_oCnx;
    private $_oPdo;
    private $_bPdo = false;
    private $_armPdoOption;

    public function __construct($sCnxName) {
		$this->_oPabanaDebug = $GLOBALS['pabanaInternalStorage']['pabana']['debug'];
        if(isset($GLOBALS['pabanaInternalStorage']['database'][$sCnxName])) {
            $this->_oCnx = $GLOBALS['pabanaInternalStorage']['database'][$sCnxName];
            if(is_object($this->_oCnx->getPdo())) {
               $this->_oPdo = $this->_oCnx->getPdo();
               $this->_bPdo = true;
            }
        } else {
            $sErrorMessage = 'This database connexion isn\'t exit';
            $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_NO_PDO', $sErrorMessage);
        }
	}
    
	public function beginTransaction() {
        if($this->checkPdo()) {
            return $this->_oPdo->beginTransaction();
        } else {
            return false;
        }
    }
    
    public function connect() {
        if($this->_bPdo === true) {
            $sErrorMessage = 'You are already connect to this database';
            $this->_oPabanaDebug->exception(PE_INFO, 'DATABASE_ALREADY_PDO', $sErrorMessage);
        } else {
            try {
                $this->setAttribut(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->_oPdo = new PDO($this->_oCnx->getDsn(), $this->_oCnx->getUser(), $this->_oCnx->getPassword(), $this->_armPdoOption);
                $this->_oCnx->setPdo($this->_oPdo);
                $this->_bPdo = true;
            }
            catch (PDOException $oException) {
                echo $oException->getMessage();
            }
        }
    }
    
    public function disconnect() {
        if($this->checkPdo()) {
            $this->_oCnx->setPdo(null);
            $this->_bPdo = false;
            return true;
        } else {
            return false;
        }
    }
    
    private function checkPdo() {
        if($this->_bPdo === false) {
            $sErrorMessage = 'You must be connected to database before execute something';
            $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_NO_PDO', $sErrorMessage);
            return false;
        } else {
            return true;
        }
    }
    
    public function commit() {
        if($this->checkPdo()) {
            return $this->_oPdo->commit();
        } else {
            return false;
        }
    }
    
    public function exec($sQuery) {
        if($this->checkPdo()) {
            try {
			    return $this->_oPdo->exec($sQuery);
            }
            catch (PDOException $e) {
                $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_EXEC', $sQuery . '<br />' . $e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function inTransaction() {
        if($this->checkPdo()) {
            return $this->_oPdo->inTransaction();
        } else {
            return false;
        }
    }
    
    public function lastInsertId($sObjectSequence = null) {
        if($this->checkPdo()) {
            return $this->_oPdo->lastInsertId($sObjectSequence);
        } else {
            return false;
        }
    }
    
    public function prepare() {
        if($this->checkPdo()) {
			try {
                return $this->_oPdo->prepare();
            }
            catch (PDOException $e) {
                $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_PREPARE', $e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }
	
	public function quote($sQuery) {
        if($this->checkPdo()) {
            try {
                return $this->_oPdo->quote($sQuery);
            }
            catch (PDOException $e) {
                $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_QUOTE', $sQuery . '<br />' . $e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function query($sQuery) {
        if($this->checkPdo()) {
            try {
                $oStatement = $this->_oPdo->query($sQuery);
                return new Pabana_Database_Statement($oStatement);
            }
            catch (PDOException $e) {
                $this->_oPabanaDebug->exception(PE_ERROR, 'DATABASE_QUERY', $sQuery . '<br />' . $e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function rollback() {
        if($this->checkPdo()) {
            return $this->_oPdo->rollback();
        } else {
            return false;
        }
    }
    
    public function setAttribut($nAttribut, $mValue) {
        $this->_armPdoOption[$nAttribut] = $mValue;
    }
}
?>