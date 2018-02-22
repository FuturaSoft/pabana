<?php
/**
 * Pabana : PHP Framework (https://pabana.futurasoft.fr)
 * Copyright (c) FuturaSoft (https://futurasoft.fr)
 *
 * Licensed under BSD-3-Clause License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) FuturaSoft (https://futurasoft.fr)
 * @link          https://pabana.futurasoft.fr Pabana Project
 * @since         1.0.0
 * @license       https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause License
 */
namespace Pabana\Html;

/**
 * Doctype class
 *
 * Define doctype use
 */
class Doctype
{
    /**
     * @var     string Doctype version (by default HTML5).
     * @since   1.0.0
     */
    private static $sDoctype = 'HTML5';

    /**
     * toString
     *
     * Activate the render method
     *
     * @since   1.0.0
     * @return  string Html code for Doctype
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Clean
     *
     * Reinitialize Doctype value to HTML5
     *
     * @since   1.0.0
     * @return  string HTML5
     */
    public function clean()
    {
        return self::$sDoctype = 'HTML5';
    }

    /**
     * Get doctype
     *
     * Get current defined doctype
     *
     * @since   1.0.0
     * @return  string Current defined doctype
     */
    public function get()
    {
        return self::$sDoctype;
    }

    /**
     * Render
     *
     * Return HTML code for Doctype
     *
     * @since   1.0.0
     * @return  string Html code for Doctype
     */
    public function render()
    {
        if (self::$sDoctype == 'HTML5') {
            $type = '';
            $url = '';
        } elseif (self::$sDoctype == 'XHTML11') {
            $type = '-//W3C//DTD XHTML 1.1//EN';
            $url = 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd';
        } elseif (self::$sDoctype == 'XHTML1_STRICT') {
            $type = '-//W3C//DTD XHTML 1.0 Strict//EN';
            $url = 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd';
        } elseif (self::$sDoctype == 'XHTML1_TRANSITIONAL') {
            $type = '-//W3C//DTD XHTML 1.0 Transitional//EN';
            $url = 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd';
        } elseif (self::$sDoctype == 'XHTML1_FRAMESET') {
            $type = '-//W3C//DTD XHTML 1.0 Frameset//EN';
            $url = 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd';
        } elseif (self::$sDoctype == 'HTML4_STRICT') {
            $type = '-//W3C//DTD HTML 4.01//EN';
            $url = 'http://www.w3.org/TR/html4/strict.dtd';
        } elseif (self::$sDoctype == 'HTML4_LOOSE') {
            $type = '-//W3C//DTD HTML 4.01 Transitional//EN';
            $url = 'http://www.w3.org/TR/html4/loose.dtd';
        } elseif (self::$sDoctype == 'HTML4_FRAMESET') {
            $type = '-//W3C//DTD HTML 4.01 Frameset//EN';
            $url = 'http://www.w3.org/TR/html4/frameset.dtd';
        }
        $doctype = '<!DOCTYPE html';
        if (!empty($type) && !empty($url)) {
            $doctype .= ' PUBLIC "' . $type . '" "' . $url . '"';
        }
        $doctype .= '>' . PHP_EOL;
        return $doctype;
    }

    /**
     * Set doctype
     *
     * Set doctype
     *
     * @since   1.0.0
     * @param   string $sDoctype Doctype
     * @return  $this
     */
    public function set($sDoctype)
    {
        self::$sDoctype = $sDoctype;
        return $this;
    }
}
