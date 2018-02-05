<?php
namespace Pabana\Database;

use Pabana\Database\Statement;
use Pabana\Debug\Error;

class Database {
	private static $oPdo = null;

	public function connect($oConnection) {
		try {
            //echo $oConnection->getDsn();
            //exit();
			self::$oPdo = new \PDO($oConnection->getDsn(), $oConnection->getUser(), $oConnection->getPassword(), $oConnection->getOption());
		}
        catch (PDOException $e) {
        	throw new Error($e->getMessage());
            return false;
        }
	}

	public function disconnect() {
		if($this->isConnected()) {
			self::$oPdo = null;
			return true;
		} else {
            return false;
        }
	}

    public function exec($sQuery) {
        if($this->isConnected()) {
            try {
                return self::$oPdo->exec($sQuery);
            }
            catch (PDOException $e) {
                throw new Error($e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }

	public function getPdo() {
		return self::$oPdo;
	}

	public function isConnected() {
		return !empty(self::$oPdo);
	}

    public function lastInsertId() {
        return self::$oPdo->lastInsertId();
    }

	public function query($sQuery) {
        if($this->isConnected()) {
            try {
                $oStatement = self::$oPdo->query($sQuery);
                return new Statement($oStatement);
            }
            catch (PDOException $e) {
            	throw new Error($e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }
}