<?php
namespace Pabana\Mvc;

use Pabana\Core\Configuration;
use Pabana\Network\Request;

class Controller extends Mvc {
	final public function init() {
		if($this->Layout->getAutoRender()) {
			// Get Layout init
			$this->Layout->renderInit();
		}
	}

	final public function __destruct() {
		$sOutHtml = null;
		if($this->View->getAutoRender()) {
			// Get view
			$sOutHtml = $this->View->render();
		}
		if($this->Layout->getAutoRender()) {
			// Get layout and view
			$sOutHtml = $this->Layout->render();
		}
		// Send Html
		if(!empty($sOutHtml)) {
			echo $sOutHtml;
		}
	}
}