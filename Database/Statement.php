<?php
namespace Pabana\Database;

use Pabana\Debug\Error;

class Statement {
	private $_oPabanaDebug;
    private $_oStatement;

    public function __construct($oStatement) {
		$this->_oStatement = $oStatement;
	}
	
	public function bindParam($mParameter, $mValue, $nDataType =  null, $nValueLength = null) {
		try {
			return $this->_oStatement->bindParam($mParameter, $mValue, $nDataType, $nValueLength);
		}
		catch (PDOException $e) {
			$this->_oPabanaDebug->exception(PE_ERROR, 'DB_STAT_BIND_PARAM', $e->getMessage());
			return false;
		}
	}
	
	public function bindValue($mParameter, $mValue, $nDataType =  null) {
		try {
			return $this->_oStatement->bindValue($mParameter, $mValue, $nDataType);
		}
		catch (PDOException $e) {
			$this->_oPabanaDebug->exception(PE_ERROR, 'DB_STAT_BIND_VALUE', $e->getMessage());
			return false;
		}
	}
	
	public function columnCount() {
		try {
			return $this->_oStatement->columnCount();
		}
		catch (PDOException $e) {
			$this->_oPabanaDebug->exception(PE_ERROR, 'DB_STAT_COL_COUNT', $e->getMessage());
			return false;
		}
	}
	
	public function execute($armValues = null) {
		try {
			return $this->_oStatement->execute($armValues);
		}
		catch (PDOException $e) {
			$this->_oPabanaDebug->exception(PE_ERROR, 'DB_STAT_EXEC', $e->getMessage());
			return false;
		}
	}
    
    public function fetch($nFetchType = null) {
		try {
			return $this->_oStatement->fetch($nFetchType);
		}
		catch (PDOException $e) {
			$this->_oPabanaDebug->exception(PE_ERROR, 'DB_STAT_FETCH', $e->getMessage());
			return false;
		}
	}
    
    public function fetchAll($nFetchType = null) {
		try {
			return $this->_oStatement->fetchAll($nFetchType);
		}
		catch (PDOException $e) {
			$this->_oPabanaDebug->exception(PE_ERROR, 'DB_STAT_FETCH_ALL', $e->getMessage());
			return false;
		}
	}
}
?>