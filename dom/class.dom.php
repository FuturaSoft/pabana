<?php
Class Pabana_Dom {
	private $oPabanaDebug;
	private $_sDoctype;
	private $_sLanguage;
	private $_arsMeta = array();
	private $_arsLink = array();
	
	public function __construct() {
		$this->_sDoctype = 'HTML5';
		$this->_sLanguage = substr(setlocale(LC_ALL, '0'), 0, 2);
		$this->_sCharset = 'UTF-8';
		$this->_sTitle = 'Pabana - ';
	}
	
	/* 
	Doctype 
	*/
	public function setDoctype($sDoctype) {
		$this->_sDoctype = strtoupper($sDoctype);
	}
	
	public function getDoctype() {
		if($this->_sDoctype == 'HTML5') {
			return '<!DOCTYPE html>' . PHP_EOL;
		} else if($this->_sDoctype == 'XHTML11') {
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">' . PHP_EOL;
		} else if($this->_sDoctype == 'XHTML1_STRICT') {
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . PHP_EOL;
		} else if($this->_sDoctype == 'XHTML1_TRANSITIONAL') {
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . PHP_EOL;
		} else if($this->_sDoctype == 'XHTML1_FRAMESET') {
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">' . PHP_EOL;
		} else if($this->_sDoctype == 'HTML4_STRICT') {
			return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">' . PHP_EOL;
		} else if($this->_sDoctype == 'HTML4_LOOSE') {
			return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">' . PHP_EOL;
		} else if($this->_sDoctype == 'HTML4_FRAMESET') {
			return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">' . PHP_EOL;
		}
	}

	/* 
	Language 
	*/
	public function setLanguage($sLanguage) {
		$this->_sLanguage = $sLanguage;
	}
	
	public function getLanguage() {
		return $this->_sLanguage;
	}
	
	/* 
	Charset 
	*/
	public function setCharset($sCharset) {
		$this->_sCharset = strtoupper($sCharset);
	}
	
	public function getCharset() {
		$arsCharset = array(
			'UTF-8' => 'utf-8',
			'UTF-16' => 'utf-16',
			'ISO-8859-1' => 'iso-8859-1',
			'ISO-8859-5' => 'iso-8859-5',
			'ISO-8859-15' => 'iso-8859-15',
			'CP1251' => 'windows-1251',
			'CP1252' => 'windows-1252',
			'KOI8-R' => 'koi8-r',
			'BIG5' => 'big5',
			'GB2312' => 'gb2312',
			'BIG5-HKSCS' => 'big5-hkscs',
			'SHIFT_JIS' => 'shift_jis',
			'EUC-JP' => 'euc-jp',
			'MACROMAN' => 'x-mac-roman'
		);
		$arsKeyCharset = array_keys($arsCharset);
		if(!in_array($this->_sCharset, $arsKeyCharset)) {
			$this->oPabanaDebug->exception(PE_ERROR, 'DOM_CHARSET_NAME', 'Charset ' . $this->_sCharset . ' isn\'t defined');
		} else {
			if($this->_sDoctype == 'HTML5') {
				return '<meta charset="' . $arsCharset[$this->_sCharset] . '">' . PHP_EOL;
			} else {
				if(substr($this->_sDoctype, 0, 1) == 'X') {
					return '<meta http-equiv="Content-Type" content="text/html; charset=' . $arsCharset[$this->_sCharset] . '" />' . PHP_EOL;
				} else {
					return '<meta http-equiv="Content-Type" content="text/html; charset=' . $arsCharset[$this->_sCharset] . '">' . PHP_EOL;
				}
			}
		}
	}
	
	/*
	Title
	*/
	public function setTitle($sTitle) {
		$this->_sTitle = $sTitle;
	}
	
	public function appendTitle($sTitle) {
		$this->_sTitle .= $sTitle;
	}
	
	public function prependTitle($sTitle) {
		$this->_sTitle = $sTitle . $this->_sTitle;
	}
	
	public function getTitle() {
		return '<title>' . $this->_sTitle . '</title>' . PHP_EOL;
	}
	
	/*
	Link head
	*/
	public function appendLinkFile($sLinkPath, $sRel = 'stylesheet', $arsAttribs = array()) {
		$this->_arsLink[] = array(
			'type' => 'append',
			'path' => $sLinkPath,
			'rel' => $sRel,
			'attribs' => $arsAttribs
		);
		return $this;
	}
	
	public function offsetLinkFile($nOffset, $sLinkPath, $sRel = 'stylesheet', $arsAttribs = array()) {
		$this->_arsLink[] = array(
			'type' => 'offset',
			'offset' => $nOffset,
			'path' => $sLinkPath,
			'rel' => $sRel,
			'attribs' => $arsAttribs
		);
		return $this;
	}
	
	public function prependLinkFile($sLinkPath, $sRel = 'stylesheet', $arsAttribs = array()) {
		$this->_arsLink[] = array(
			'type' => 'prepend',
			'path' => $sLinkPath,
			'rel' => $sRel,
			'attribs' => $arsAttribs
		);
		return $this;
	}
	
	public function getLink() {
		$armSortLinks = array();
		$armLinks = $this->_arsLink;
		foreach($armLinks as $arsLink) {
			if($arsLink['type'] == 'prepend') {
				array_unshift($armSortLinks, $arsLink);
			} else if($arsLink['type'] == 'offset') {
				$nOffset = $arsLink['offset'];
				$armSortLinks[$nOffset] = $arsLink;
			} else if($arsLink['type'] == 'append') {
				$armSortLinks[] = $arsLink;
			}
		}
		$sHtmlLink = '';
		foreach($armSortLinks as $arsLink) {
			$sHtmlLink .= '<link href="' . $arsLink['path'] . '" rel="' . $arsLink['rel'] . '"';
			if(isset($arsLink[2]['media'])) {
				$sHtmlLink .= ' media="' . $arsLink['attribs']['media'] . '"';
			}
			if(isset($arsLink[2]['type'])) {
				$sHtmlLink .= ' type="' . $arsLink['attribs']['type'] . '"';
			}
			$sHtmlLink .= ' />' . PHP_EOL;
		}
		return $sHtmlLink;
	}
	
	/*
	Script
	*/
	public function appendScriptFile($sScriptPath, $sMimeType = 'text/javascript', $arsAttribs = array()) {
		$this->_arsScript[] = array(
			'type' => 'append',
			'file' => true,
			'path' => $sScriptPath,
			'mime' => $sMimeType,
			'attribs' => $arsAttribs
		);
		return $this;
	}
	
	public function offsetScriptFile($nOffset, $sScriptPath, $sMimeType = 'text/javascript', $arsAttribs = array()) {
		$this->_arsScript[] = array(
			'type' => 'offset',
			'offset' => $nOffset,
			'file' => true,
			'path' => $sScriptPath,
			'mime' => $sMimeType,
			'attribs' => $arsAttribs
		);
		return $this;
	}
	
	public function prependScriptFile($sScriptPath, $sMimeType = 'text/javascript', $arsAttribs = array()) {
		$this->_arsScript[] = array(
			'type' => 'prepend',
			'file' => true,
			'path' => $sScriptPath,
			'mime' => $sMimeType,
			'attribs' => $arsAttribs
		);
		return $this;
	}
	
	public function appendScript($sScript, $sMimeType = 'text/javascript', $arsAttribs = array()) {
		$this->_arsScript[] = array(
			'type' => 'append',
			'file' => false,
			'script' => $sScript,
			'mime' => $sMimeType,
			'attribs' => $arsAttribs
		);
		return $this;
	}
	
	public function offsetScript($nOffset, $sScript, $sMimeType = 'text/javascript', $arsAttribs = array()) {
		$this->_arsScript[] = array(
			'type' => 'offset',
			'offset' => $nOffset,
			'file' => false,
			'script' => $sScript,
			'mime' => $sMimeType,
			'attribs' => $arsAttribs
		);
		return $this;
	}
	
	public function prependScript($sScript, $sMimeType = 'text/javascript', $arsAttribs = array()) {
		$this->_arsScript[] = array(
			'type' => 'prepend',
			'file' => false,
			'script' => $sScript,
			'mime' => $sMimeType,
			'attribs' => $arsAttribs
		);
		return $this;
	}
	
	public function getScript() {
		$armSortScripts = array();
		$arsScripts = $this->_arsScript;
		foreach($arsScripts as $arsScript) {
			if($arsScript['type'] == 'prepend') {
				array_unshift($armSortScripts, $arsScript);
			} else if($arsScript['type'] == 'offset') {
				$nOffset = $arsLink['offset'];
				$armSortScripts[$nOffset] = $arsScript;
			} else if($arsScript['type'] == 'append') {
				$armSortScripts[] = $arsScript;
			}
		}
		$arsHtmlScript = '';
		foreach($armSortScripts as $arsScript) {
			if(isset($arsScript['attribs']['conditional'])) {
				$arsHtmlScript .= '<!--[if ' . $arsScript['attribs']['conditional'] . ']>';
			}
			if($arsScript['file'] == true) {
				$arsHtmlScript .= '<script src="' . $arsScript['path'] . '" type="' . $arsScript['mime'] . '"></script>';
			}
			if($arsScript['file'] == false) {
				$arsHtmlScript .= '<script type="' . $arsScript['mime'] . '">' . $arsScript['script'] . '</script>';
			}
			if(isset($arsScript['attribs']['conditional'])) {
				$arsHtmlScript .= '<![endif]-->';
			}
			$arsHtmlScript .= PHP_EOL;
		}
		return $arsHtmlScript;
	}
	
	/*
	Meta
	*/
	public function appendMeta($sName, $sContent) {
		$this->_arsMeta[] = array(
			'type' => 'append',
			'type_meta' => 'name',
			'name' => $sName,
			'content' => $sContent
		);
		return $this;
	}
	
	public function offsetMeta($nOffset, $sName, $sContent) {
		$this->_arsMeta[] = array(
			'type' => 'offset',
			'offset' => $nOffset,
			'type_meta' => 'name',
			'name' => $sName,
			'content' => $sContent
		);
		return $this;
	}
	
	public function prependMeta($sName, $sContent) {
		$this->_arsMeta[] = array(
			'type' => 'prepend',
			'type_meta' => 'name',
			'name' => $sName,
			'content' => $sContent
		);
		return $this;
	}
	
	public function appendHttpEquiv($sName, $sContent) {
		$this->_arsMeta[] = array(
			'type' => 'append',
			'type_meta' => 'http-equiv',
			'name' => $sName,
			'content' => $sContent
		);
		return $this;
	}
	
	public function offsetHttpEquiv($nOffset, $sName, $sContent) {
		$this->_arsMeta[] = array(
			'type' => 'http-equiv',
			'offset' => $nOffset,
			'type_meta' => 'name',
			'name' => $sName,
			'content' => $sContent
		);
		return $this;
	}
	
	public function prependHttpEquiv($sName, $sContent) {
		$this->_arsMeta[] = array(
			'type' => 'prepend',
			'type_meta' => 'http-equiv',
			'name' => $sName,
			'content' => $sContent
		);
		return $this;
	}
	
	public function getMeta() {
		$armSortMetas = array();
		$arsMetas = $this->_arsMeta;
		foreach($arsMetas as $arsMeta) {
			if($arsMeta['type'] == 'prepend') {
				array_unshift($armSortMetas, $arsMeta);
			} else if($arsMeta['type'] == 'offset') {
				$nOffset = $arsMeta['offset'];
				$armSortMetas[$nOffset] = $arsMeta;
			} else if($arsMeta['type'] == 'append') {
                $armSortMetas[] = $arsMeta;
			}
		}
		$arsHtmlMeta = '';
		foreach($armSortMetas as $arsMeta) {
			$arsHtmlMeta .= '<meta ' . $arsMeta['type_meta'] . '="' . $arsMeta['name'] . '" content="' . $arsMeta['content'] . '" />' . PHP_EOL;
		}
		return $arsHtmlMeta;
	}
    
    /* URL */
    public function url($sController, $sAction = '', $arsParam = array()) {
        $sReturn = '/' . $sController;
        if(!empty($sAction)) {
            $sReturn .= '/' . $sAction;
        }
        if(!empty($arsParam)) {
            foreach($arsParam as $sParamName => $sParamValue) {
                $sReturn .= '/' . $sParamName . '/' . $sParamValue;
            }
        }
        return $sReturn;
    }
}
?>