<?php
namespace Pabana\Debug;

class Debug {
	const PE_ALL = -1;
	const PE_DEBUG = 1;
	const PE_INFO = 2;
	const PE_DEPRECATED = 4;
	const PE_WARNING = 8;
	const PE_ERROR = 16;
	const PE_CRITICAL = 32;
	/**
     * Instance of Pabana_Debug
     * @static
     * @var Pabana_Debug
     */
    static private $_oPabanaDebug;
	
	private $_arsErrorLevel = array(
		1 => 'DEBUG',
		2 => 'INFO',
		4 => 'DEPRECATED',
		8 => 'WARNING',
		16 => 'ERROR',
		32 => 'CRITICAL'
	);
	private $_arbShowLevel;
	private $_bBacktrace;
	private $_bEnvironment;
	private $_bAutoloader;
	private $_bFatalException;
	private $_armError;
	private $_armBacktrace;
	private $_armEnvironment;
	
	public function __construct() {
		$this->_arbShowLevel = $this->_getIntToArrayDebug(self::PE_ALL);
		$this->_bBacktrace = true;
		$this->_bEnvironment = true;
		$this->_bAutoloader = false;
		$this->_bFatalException = false;
    }
	
	/**
     * Singleton of class
     * @return Pabana_Debug
     */
    public static function getInstance() {
        if(!isset(self::$_oPabanaDebug)) {
            self::$_oPabanaDebug = new \Pabana\Debug\Debug();
		}
        return self::$_oPabanaDebug;
    }

    public function getFatalException() {
    	return $this->_bFatalException;
    }

    public function setAutoloader($bAutoloader) {
    	$this->_bAutoloader = $bAutoloader;
    }
	
	public function setShowLevel($nShowLevel) {
		$this->_arbShowLevel = $this->_getIntToArrayDebug($nShowLevel);
	}

	public function setEnvironment($bEnvironment) {
		$this->_bEnvironment = $bEnvironment;
	}

	public function setBacktrace($bBacktrace) {
		$this->_bBacktrace = $bBacktrace;
	}
	
	private function _getIntToArrayDebug($nDebugLevel) {
		$arsErrorLevel = $this->_arsErrorLevel;
		$arbErrorLevelReturn = $arsErrorLevel;
		krsort($arsErrorLevel);
		foreach($arsErrorLevel as $nKeyErrorLevel => $sValueErrorLevel) {
			if($nDebugLevel >= $nKeyErrorLevel || $nDebugLevel == -1) {
				$arbErrorLevelReturn[$nKeyErrorLevel] = true;
				if($nDebugLevel != -1) {
					$nDebugLevel = $nDebugLevel - $nKeyErrorLevel;
				}
			} else {
				$arbErrorLevelReturn[$nKeyErrorLevel] = false;
			}
			
		}
		return $arbErrorLevelReturn;
	}
	
	public function exception($nErrorLevel = 1, $sErrorCode = 'UNKNOW', $sErrorMessage = 'Unknow error') {
		$this->_armError = array(
			'level' => $nErrorLevel,
			'code' => $sErrorCode,
			'message' => $sErrorMessage
		); 
		$this->_armBackTrace = debug_backtrace();
		$this->_armEnvironment = array(
			'date' => date('Y/m/d H:i:s'),
			'memory' => round(memory_get_usage() / 1000000, 3),
			'generation' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4)
		);
		if($this->_arbShowLevel[$nErrorLevel] == true) {
			$bIsAjax = false;
			if($this->_bAutoloader == true) {
				$oHttp = new Pabana_Http();
				$bIsAjax = $oHttp->isAjax();
			}
			if(PHP_SAPI == 'cli' || $bIsAjax === true) {
				echo $this->_exceptionText();
			} else {
				echo $this->_exceptionHtml();
			}
		}
		// Stop application if error level is ERROR or CRITICAL
		if($nErrorLevel >= 16) {
			$this->_bFatalException = true;
			exit(1);
		}
    }
	
	private function _exceptionText() {
		$sErrorMessage = str_replace('<br />', PHP_EOL, $this->_armError['message']);
		$sErrorMessage = strip_tags($sErrorMessage);
		$sReturnText = $this->_arsErrorLevel[$this->_armError['level']] . ': ';
		$sReturnText .= $sErrorMessage . ' ';
		$sReturnText .= '(Error code : ' . $this->_armError['code'] .')' . PHP_EOL;
		$sReturnText .= 'Class: ' . $this->_armBackTrace[1]['class'] . ' ';
		$sReturnText .= 'on method ' . $this->_armBackTrace[1]['function'] . PHP_EOL;
		if(isset($this->_armBackTrace[1]['file'])) {
			$sReturnText .= 'File: ' . $this->_armBackTrace[1]['file'] . ' ';
			$sReturnText .= 'on line ' . $this->_armBackTrace[1]['line'] . PHP_EOL;
		}
		if($this->_bEnvironment == true) {
			$sReturnText .= 'Date: ' . $this->_armEnvironment['date'] . ' | ';
			$sReturnText .= 'Memory usage: ' . $this->_armEnvironment['memory'] . 'Mo | ';
			$sReturnText .= 'Generation time: ' . $this->_armEnvironment['generation'] . 's' . PHP_EOL;
		}
		$sReturnText .= PHP_EOL;
		return $sReturnText;
    }
	
	private function _exceptionHtml() {
		$sErrorUrl = 'http://pabana.co/documentation/error/err_id/' . $this->_armError['code'] . '/ver_name/' . PC_DOC_VERSION;
		$sCssStyle = 'border: 1px solid; margin: 10px; padding: 10px; border-radius: 5px; font-size: 14px; font-weight:normal; text-transformation:none; font-family:verdana;';
		if($this->_armError['level'] >= 16) {
			$sCssStyle .= ' color: #D8000C; background-color: #FFBABA;';
		}
		elseif($this->_armError['level'] >= 4) {
			$sCssStyle .= ' color: #9F6000; background-color: #FEEFB3;';
		}
		else {
			$sCssStyle .= ' color: #00529B; background-color: #BDE5F8;';
		}
		$sReturnText = '<p style="'.$sCssStyle.'">';
		$sReturnText .= '<strong>' . $this->_arsErrorLevel[$this->_armError['level']] . ':</strong> ';
		$sReturnText .= $this->_armError['message'] . ' ';
		$sReturnText .= '(Error code : <a href="'.$sErrorUrl.'" target="_blank" title="Pabana online documentation">' . $this->_armError['code'] .'</a>)<br />';
		$sReturnText .= 'Class : <strong>' . $this->_armBackTrace[1]['class'] . '</strong> ';
		$sReturnText .= 'on method  <strong>' . $this->_armBackTrace[1]['function'] . '</strong><br />';
		if(isset($this->_armBackTrace[1]['file'])) {
			$sReturnText .= 'File : <strong>' . $this->_armBackTrace[1]['file'] . '</strong> ';
			$sReturnText .= 'on line <strong>' . $this->_armBackTrace[1]['line'] . '</strong><br />';
		}
		if($this->_bEnvironment == true) {
			$sReturnText .= 'Memory usage : <strong>' . $this->_armEnvironment['memory'] . 'Mo</strong> | ';
			$sReturnText .= 'Generation time : <strong>' . $this->_armEnvironment['generation'] . 's</strong><br />';
		}
		if($this->_bBacktrace == true) {
			$sReturnText .= '<br /><strong>Backtrace:</strong><br />';
			$nCountBacktrace = count($this->_armBackTrace);
			$j = 1;
			for($i = ($nCountBacktrace - 1); $i >= 1; $i--) {
				$sReturnText .= '#' . $j . '] ';
				if(!empty($this->_armBackTrace[$i]['class'])) {
					$sReturnText .= $this->_armBackTrace[$i]['class'];
				}
				if(!empty($this->_armBackTrace[$i]['type'])) {
					$sReturnText .= $this->_armBackTrace[$i]['type'];
				}
				if(!empty($this->_armBackTrace[$i]['function'])) {
					$sReturnText .= $this->_armBackTrace[$i]['function'];
				}
				if(!empty($this->_armBackTrace[$i]['args'])) {
					$sReturnText .= '(' . print_r($this->_armBackTrace[$i]['args'], true) .')';
				}
				if(isset($this->_armBackTrace[$i]['file'])) {
					$sReturnText .= ' called at [' . $this->_armBackTrace[$i]['file'] . ':' . $this->_armBackTrace[$i]['line'] . ']';
				}
				$sReturnText .= '<br />';
				$j++;
			}
		}
		$sReturnText .= '</p>';
		return $sReturnText;
    }
}
?>