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
namespace Pabana\Routing;

/**
 * Route class
 *
 * Define a route
 */
class Route
{
    /**
     * @var    string Route
     * @since   1.0.0
     */
    private $sRoute = null;

    /**
     * @var    string Redirect controller
     * @since   1.0.0
     */
    private $sController = 'index';

    /**
     * @var    string Redirect action
     * @since   1.0.0
     */
    private $sAction = 'index';

    /**
     * @var    string Redirect param list
     * @since   1.0.0
     */
    private $arsParamList = null;

    /**
     * Create an object Route from parameters
     *
     * @since   1.0.0
     * @param   string $sRoute Route.
     * @param   array $arsOption Option (controller, action and param).
     */
    public function __construct($sRoute, $arsOption = array())
    {
        $this->sRoute = $sRoute;
        if (isset($arsOption['controller'])) {
            $this->sController = $arsOption['controller'];
        }
        if (isset($arsOption['action'])) {
            $this->sAction = $arsOption['action'];
        }
        if (isset($arsOption['param'])) {
            $this->arsParamList = $arsOption['param'];
        }
    }

    /**
     * Get route defined
     *
     * @since   1.0.0
     * @return  string Route.
     */
    public function getRoute()
    {
        return $this->sRoute;
    }

    /**
     * Get controller defined
     *
     * @since   1.0.0
     * @return  string Controller.
     */
    public function getController()
    {
        return $this->sController;
    }

    /**
     * Get action defined
     *
     * @since   1.0.0
     * @return  string Action.
     */
    public function getAction()
    {
        return $this->sAction;
    }

    /**
     * Get param list.
     *
     * @since   1.0.0
     * @return  string Param list.
     */
    public function getParamList()
    {
        return $this->arsParamList;
    }
}
