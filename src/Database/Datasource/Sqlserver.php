<?php
namespace Pabana\Database\Datasource;

use Pabana\Database\Datasource;
use Pabana\Debug\Error;

class Sqlserver extends Datasource
{
    private $sApplication;
    private $sConnectionPooling;
    private $sEncrypt;
    private $sFailoverPartner;
    private $nLoginTimeout;
    private $sMultipleActiveResultSets;
    private $nQuotedId;
    private $sTraceFile;
    private $sTraceOn;
    private $nTransactionIsolation;
    private $sTrustServerCertificate;
    private $sWsid;
    
    public function construct($sName)
    {
        $this->setName($sName);
        $this->setDbms('Sqlserver');
	}
    
    protected function checkParam()
    {
        if(empty($this->getHost())) {
            $sErrorMessage = 'Connexion to SQL Server must have an host defined';
            throw new Error($sErrorMessage);
            return false;
        } else {
            return true;
        }
	}
    
    public function createDsn()
    {
        if($this->checkParam()) {
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
                $sDsn .= 'FailoverPartner=' . $this->getFailoverPartner() . ';';
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
            return $sDsn;
        } else {
            return false;
        }
    }
    
    public function getApplication()
    {
        return $this->sApplication;
    }
    
    public function getConnectionPooling()
    {
        return $this->sConnectionPooling;
    }
    
    public function getEncrypt()
    {
        return $this->sEncrypt;
    }
    
    public function getFailoverPartner()
    {
        return $this->sFailoverPartner;
    }
    
    public function getLoginTimeout()
    {
        return $this->nLoginTimeout;
    }
    
    public function getMultipleActiveResultSets()
    {
        return $this->sMultipleActiveResultSets;
    }
    
    public function getQuotedId()
    {
        return $this->nQuotedId;
    }
    
    public function getTraceFile()
    {
        return $this->sTraceFile;
    }
    
    public function getTraceOn()
    {
        return $this->sTraceOn;
    }
    
    public function getTransactionIsolation()
    {
        return $this->nTransactionIsolation;
    }
    
    public function getTrustServerCertificate()
    {
        return $this->sTrustServerCertificate;
    }
    
    public function getWsid()
    {
        return $this->sWsid;
    }
    
    public function setApplication($sApplication)
    {
        $this->sApplication = $sApplication;
        return $this;
    }
    
    public function setConnectionPooling($sConnectionPooling)
    {
        $this->sConnectionPooling = $sConnectionPooling;
        return $this;
    }
    
    public function setEncrypt($sEncrypt)
    {
        $this->sEncrypt = $sEncrypt;
        return $this;
    }
    
    public function setFailoverPartner($sFailoverPartner)
    {
        $this->sFailoverPartner = $sFailoverPartner;
        return $this;
    }
    
    public function setLoginTimeout($nLoginTimeout)
    {
        $this->nLoginTimeout = $nLoginTimeout;
        return $this;
    }
    
    public function setMultipleActiveResultSets($sMultipleActiveResultSets)
    {
        $this->sMultipleActiveResultSets = $sMultipleActiveResultSets;
        return $this;
    }
    
    public function setQuotedId($nQuotedId)
    {
        $this->nQuotedId = $nQuotedId;
        return $this;
    }
    
    public function setTraceFile($sTraceFile)
    {
        $this->sTraceFile = $sTraceFile;
        return $this;
    }
    
    public function setTraceOn($sTraceOn)
    {
        $this->sTraceOn = $sTraceOn;
        return $this;
    }
    
    public function setTransactionIsolation($nTransactionIsolation)
    {
        $this->nTransactionIsolation = $nTransactionIsolation;
        return $this;
    }
    
    public function setTrustServerCertificate($sTrustServerCertificate)
    {
        $this->sTrustServerCertificate = $sTrustServerCertificate;
        return $this;
    }
    
    public function setWsid($sWsid)
    {
        $this->sWsid = $sWsid;
        return $this;
    }
}