<?php
namespace Pabana\Mvc;

use Pabana\Core\Configuration;
use Pabana\Html\Html;
use Pabana\Mvc\Layout;
use Pabana\Mvc\Model;
use Pabana\Mvc\View;
use Pabana\Network\Request;
use Pabana\Intl\Translate;

class Mvc {
	protected $Html;
	protected $Layout;
	protected $Model;
	protected $View;

	final public function __construct() {
		// Load Mvc\Html helper to $Html var
		$this->Html = new Html();
		// Load Mvc\Layout to $Layout var
		$this->Layout = new Layout();
		// Load Mvc\Model to $Model var
		$this->Model = new Model();
		// Load Mvc\View to $View var
		$this->View = new View();
		// Set default view name
		$this->View->setName(ucfirst(Request::getAction()));
	}
}