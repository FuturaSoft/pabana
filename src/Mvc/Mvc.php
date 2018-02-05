<?php
namespace Pabana\Mvc;

use Pabana\Core\Configuration;
use Pabana\Html\Html;
use Pabana\Mvc\Layout;
use Pabana\Mvc\View;
use Pabana\Router\Router;

class Mvc
{
	protected $Html;
	protected $Layout;
	protected $View;

	final public function __construct()
	{
		// Load Mvc\Html helper to $Html var
		$this->Html = new Html();
		// Load Mvc\Layout to $Layout var
		$this->Layout = new Layout();
		// Load Mvc\View to $View var
		$this->View = new View();
		// Set default layout name
		$this->Layout->setName(ucfirst(Configuration::get('layout.default')), false);
		// Set default view name
		$this->View->setName(ucfirst(Router::$action));
	}

	final public function getModel($sModelName)
	{
		$sModelClass = 'Application\Model\\' . ucFirst($sModelName);
		return new $sModelClass;
	}
}