<?php
namespace Pabana\Database\Connection;

use Pabana\Database\Connection;
use Pabana\Debug\Error;

class Mysql extends Connection {
    private $_sHost;
    private $_nPort = 3306;
    private $_sUnixSocket;
    
    public function __construct() {
        $this->setDbms('Mysql');
    }

    public function getDsn() {
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
        return $sDsn;
    }

    public function getHost() {
        return $this->_sHost;
    }

    public function getPort() {
        return $this->_nPort;
    }

    public function setHost($sHost) {
        $this->_sHost = $sHost;
        return $this;
    }

    public function setPort($nPort) {
        $this->_nPort = $nPort;
        return $this;
    }
}