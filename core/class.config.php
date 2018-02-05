<?php
namespace Pabana\Core;

class Config {
	/**
     * Instance of Pabana_Core_Autoloader
     * @static
     * @var Pabana_Core_Autoloader
     */
    static private $_oPabanaCoreConfig;
	private $_oPabanaDebug;
	private $_sApplicationPath;
    private $_sApplicationEnvironment;
    private $_bBootstrapEnable;
    private $_sBootstrapPath;
    private $_sCharset;
    private $_sLocale;
    private $_sControllerPath;

	public function __construct() {
		// Initialise Pabana_Debug class
		$this->_oPabanaDebug = Pabana\Debug\Debug::getInstance();
        // Application path
        $this->setApplicationPath('{MVC_PATH}');
        // Application environment
        $this->_sApplicationEnvironment = 'prod';
        // Bootstrap enable
        $this->_bBootstrapEnable = true;
        // Bootstrap path
        $this->_sBootstrapPath = '/application/bootstrap.php';
        // Localization charset
        $this->_sCharset = 'UTF-8';
        // Localization locale
        $this->_sLocale = setlocale(LC_ALL, '0');
        // MVC enable
        $this->_bMvcEnable = true;
        // Controller path
        $this->_sControllerPath = '/application/controller';
        // Model path
        $this->_sModelPath = '/application/model';
        // Layout enable
        $this->_bLayoutEnable = true;
        // Layout path
        $this->_sLayoutPath = '/application/layout';
        // Layout default
        $this->_sLayoutDefault = 'default';
        // Router enable
        $this->_bRouterEnable = true;
        // Router path
        $this->_sRouterPath = '/application/router.php';
    }

    public function getApplicationEnvironment() {
        return $this->_sApplicationEnvironment;
    }

    public function getApplicationPath() {
        return $this->_sApplicationPath;
    }

    public function getBootstrapEnable() {
        return $this->_bBootstrapEnable;
    }

    public function getBootstrapPath() {
        return $this->getApplicationPath() . $this->_sBootstrapPath;
    }

    public function getCharset() {
        return $this->_sCharset;
    }

    public function getControllerPath() {
        return $this->getApplicationPath() . $this->_sControllerPath;
    }

    /**
     * Singleton of class
     * @return Pabana_Core_Config
     */
    public static function getInstance() {
        if(!isset(self::$_oPabanaCoreConfig)) {
            self::$_oPabanaCoreConfig = new \Pabana\Core\Config();
        }
        return self::$_oPabanaCoreConfig;
    }

    public function getLayoutEnable() {
        return $this->_bLayoutEnable;
    }

    public function getLayoutDefault() {
        return $this->_sLayoutDefault;
    }

    public function getLayoutPath() {
        return $this->getApplicationPath() . $this->_sLayoutPath;
    }

    public function getLocale() {
        return $this->_sLocale;
    }

    public function getModelPath() {
        return $this->getApplicationPath() . $this->_sModelPath;
    }

    public function getMvcEnable() {
        return $this->_bMvcEnable;
    }

    public function getRouterEnable() {
        return $this->_bRouterEnable;
    }

    public function getRouterPath() {
        return $this->getApplicationPath() . $this->_sRouterPath;
    }

    public function config($armConfig) {
    	$armConfigMerged = $armConfig['global'];
		if(isset($armConfig['global']['application_env'])) {
			$arsApplicationEnv = $armConfig['global']['application_env'];
			foreach($arsApplicationEnv as $sEnv=>$sUrl) {
				if($sUrl == $_SERVER['HTTP_HOST']) {
					$armConfigMerged = $armConfig[$sEnv] + $armConfig['global'];
					$this->_sApplicationEnv = $sEnv;
					break;
				}
			}
		} elseif(defined(APPLICATION_ENV)) {
			$armConfigMerged = $armConfig[APPLICATION_ENV] + $armConfig['global'];
			$this->_sApplicationEnv = APPLICATION_ENV;
		}
    	// Change application_path
    	$this->setApplicationPath($armConfigMerged['application_path']);
    	// Set debug var
    	if(isset($armConfigMerged['debug'])) {
    		if(isset($armConfigMerged['debug']['show_level'])) {
	    		$this->_oPabanaDebug->setShowLevel($armConfigMerged['debug']['show_level']);
	    	}
	    	if(isset($armConfigMerged['debug']['environment'])) {
	    		$bEnvironment = false;
	    		if($armConfigMerged['debug']['environment'] == 'true' || $armConfigMerged['debug']['environment'] == '1') {
	    			$bEnvironment = true;
	    		}
	    		$this->_oPabanaDebug->setEnvironment($bEnvironment);
	    	}
	    	if(isset($armConfigMerged['debug']['backtrace'])) {
	    		$bBacktrace = false;
	    		if($armConfigMerged['debug']['backtrace'] == 'true' || $armConfigMerged['debug']['backtrace'] == '1') {
	    			$bBacktrace = true;
	    		}
	    		$this->_oPabanaDebug->setBacktrace($bBacktrace);
	    	}
    	}
    	// Bootstrap
    	if(isset($armConfigMerged['bootstrap'])) {
    		$bBootstrap = false;
    		if($armConfigMerged['bootstrap']['@attributes']['enable'] == 'true'|| $armConfigMerged['bootstrap']['@attributes']['enable'] == '1') {
    			$bBootstrap = true;
    			if(isset($armConfigMerged['bootstrap']['path'])) {
    				$this->_sBootstrapPath = $armConfigMerged['bootstrap']['path'];
    			}
    		}
    		$this->_bBootstrap = $bBootstrap;
    	}
    	// Router
    	if(isset($armConfigMerged['router'])) {
    		$bRouter = false;
    		if($armConfigMerged['router']['@attributes']['enable'] == 'true'|| $armConfigMerged['router']['@attributes']['enable'] == '1') {
    			$bRouter = true;
    			if(isset($armConfigMerged['router']['path'])) {
    				$this->_sRouterPath = $armConfigMerged['router']['path'];
    			}
    		}
    		$this->_bRouter = $bRouter;
    	}
    	// Mvc
    	if(isset($armConfigMerged['mvc'])) {
    		$bMvc = false;
    		if($armConfigMerged['mvc']['@attributes']['enable'] == 'true'|| $armConfigMerged['mvc']['@attributes']['enable'] == '1') {
    			$bMvc = true;
    		}
    		$this->_bMvc = $bMvc;
    	}
    	// PHP
        if(isset($armConfigMerged['php'])) {
            foreach($armConfigMerged['php'] as $sParam=>$sParamValue) {
                $sParamOldValue = ini_get($sParam);
                $sReturn = ini_set($sParam, $sParamValue);
                if($sParamOldValue !== $sReturn) {
                    $sErrorMessage = 'PHP parameter <strong>' . $sParam . '</strong> can\'t be modify';
                    $this->_oPabanaDebug->exception(PE_WARNING, 'CORE_CONFIG_PHP', $sErrorMessage);
                }
            }
		}
    }

    public function setApplicationEnvironment($sApplicationEnvironment) {
        $this->_sApplicationEnvironment = $sApplicationEnvironment;
    }

    public function setApplicationPath($sApplicationPath) {
        if($sApplicationPath == '{MVC_PATH}') {
            $sLibraryPath = DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'pabana' . DIRECTORY_SEPARATOR . 'core';
            $this->_sApplicationPath = str_replace($sLibraryPath, '', realpath(dirname(__FILE__)));
        } else {
            $this->_sApplicationPath = $sApplicationPath;
        }
    }

    public function setBootstrapEnable($bBootstrapEnable) {
        $this->_bBootstrapEnable = $bBootstrapEnable;
    }

    public function setBootstrapPath($sBootstrapPath) {
        $this->_sBootstrapPath = $sBootstrapPath;
    }

    public function setCharset($sCharset) {
        $this->_sCharset = $sCharset;
    }

    public function setControllerPath($sControllerPath) {
        $this->_sControllerPath = sControllerPath;
    }

    public function setLayoutEnable($bLayoutEnable) {
        $this->_bLayoutEnable = bLayoutEnable;
    }

    public function setLayoutDefault($sLayoutDefault) {
        $this->_sLayoutDefault = $sLayoutDefault;
    }

    public function setLayoutPath($sLayoutPath) {
        $this->_sLayoutPath = $sLayoutPath;
    }

    public function setLocale($sLocale) {
        $this->_sLocale = $sLocale;
    }

    public function setModelPath($sModelPath) {
        return $this->_sModelPath = $sModelPath;
    }

    public function setMvcEnable($bMvcEnable) {
        $this->_bMvcEnable = $bMvcEnable;
    }

    public function setRouterEnable($bRouterEnable) {
        $this->_bRouterEnable = $bRouterEnable;
    }

    public function setRouterPath($bRouterEnable) {
        $this->_sRouterPath = $bRouterEnable;
    }
}
?>