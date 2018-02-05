<?php
namespace Pabana\Core;

use Pabana\Debug\Error;

class Configuration {
    private static $_armValues = null;

    public static function base() {
        // Set default name of application
        self::set('application.name', 'Pabana Project');
        // Set default path of application
        self::set('application.path', 'MVC_PATH');
        // Set default path for bootstrap
        self::set('bootstrap.path', '/application/Bootstrap.php');
        // Set default path for controller
        self::set('controller.path', '/application/Controller');
        // Set debug level to all
        self::set('debug.level', E_ALL);
        // Set default path for layout
        self::set('layout.path', '/application/Layout');
        // Set default name for layout
        self::set('layout.default', 'Default');
        // Set auto render for layout
        self::set('layout.auto_render', 'true');
        // Set view file prefix
        self::set('layout.prefix', '');
        // Set view file extension
        self::set('layout.extension', 'php');
        // Set default path for model
        self::set('model.path', '/application/Model');
        // Set view file prefix
        self::set('model.prefix', '');
        // Set view file extension
        self::set('model.extension', 'php');
        // Set default path for router
        self::set('router.path', '/application/Router.php');
        // Set default separator for router
        self::set('router.separator', '/');
        // Set default path for view
        self::set('view.path', '/application/View');
        // Set auto render for view
        self::set('view.auto_render', 'true');
        // Set view file prefix
        self::set('view.prefix', '');
        // Set view file extension
        self::set('view.extension', 'php');
    }

    public static function clean($bBase = true) {
        self::$_armValues = null;
        if($bBase === true) {
            self::base();
        }
    }

    public static function exists($sName) {
        if(isset(self::$_armValues[$sName])) {
            return true;
        } else {
            return false;
        }
    }

    public static function get($sName) {
        if(!self::exists($sName)) {
            throw new Error('Configuration parameters "' . $sName . '" don\'t exists.');
            return false;
        }
        return self::$_armValues[$sName];
    }
	
	public static function getAll() {
        if(empty(self::$_armValues)) {
            throw new Error('No configuration parameters exists.');
            return false;
        }
        return self::$_armValues;
    }

    public static function remove($sName) {
        if(!self::exists($sName)) {
            throw new Error('Configuration parameters "' . $sName . '" don\'t exists.');
            return false;
        }
        self::$_armValues[$sName] = null;
        return true;
    }

    public static function set($sName, $mValue, $bCreateIfNotExist = true) {
        if(!self::exists($sName) && $bCreateIfNotExist === false) {
            throw new Error('Configuration parameters "' . $sName . '" don\'t exists.');
            return false;
        }
        $mValue = self::_specialValue($sName, $mValue);
        self::$_armValues[$sName] = $mValue;
        return true;
    }

    private static function _specialValue($sName, $mValue) {
        if($mValue == "true") {
            return true;
        } else if($mValue == "false") {
            return false;
        } else if($sName == 'application.path' && $mValue == "MVC_PATH") {
            $sLibraryPath = DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Pabana' . DIRECTORY_SEPARATOR . 'Core';
            return str_replace($sLibraryPath, '', dirname(__FILE__));
        } else if($sName == 'debug.level' && substr($mValue, 0, 2) == "E_") {
            return eval($mValue);
        }
        return $mValue;
    }
}