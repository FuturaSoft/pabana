<?php
namespace Pabana\Html;

use Pabana\Debug\Error;
use Pabana\Html\Head\Charset;
use Pabana\Html\Head\Css;
use Pabana\Html\Head\Icon;
use Pabana\Html\Head\Link;
use Pabana\Html\Head\Meta;
use Pabana\Html\Head\Title;

class Head {
	public $Charset;
	public $Css;
	public $Icon;
	public $Link;
	public $Meta;
	public $Title;

	public function __construct() {
		$this->Charset = new Charset();
		$this->Css = new Css();
		$this->Icon = new Icon();
		$this->Link = new Link();
		$this->Meta = new Meta();
		$this->Title = new Title();
	}

	public function __toString() {
		return $this->render();
	}

	public function clean() {
		$this->Charset->clean();
		$this->Css->clean();
		$this->Icon->clean();
		$this->Link->clean();
		$this->Meta->clean();
		$this->Title->clean();
	}

	public function render() {
		$sHtml = '';
		$sHtml .= $this->Charset->render();
		$sHtml .= $this->Meta->render();
		$sHtml .= $this->Title->render();
		$sHtml .= $this->Link->render();
		$sHtml .= $this->Css->render();
		$sHtml .= $this->Icon->render();
		return $sHtml;
	}
}
?>