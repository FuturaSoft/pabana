<?php
Class Pabana_Dom_Table {
	private $sId;
	private $arsColumns = array();
	
	public function __construct($sId) {
		$this->sId = $sId;
	}
	
	public function addColumn($sId, $sTitle = '') {
		$this->arsColumns[] = array(
			'id' => $sId,
			'title' => $sTitle
		);
	}
	
	public function getTable() {
		$sHtmlTable = '<table id="' . $this->sId . '">' . PHP_EOL;
		if(!empty($this->arsColumns)) {
			$sHtmlTable .= '<thead>' . PHP_EOL;
			foreach($this->arsColumns as $arsColumn) {
				$sHtmlTable .= '<th id="' . $arsColumn['id'] . '">';
				if(!empty($arsColumn['title'])) {
					$sHtmlTable .= $arsColumn['title'];
				}
				$sHtmlTable .= '</th>' . PHP_EOL;
			}
			$sHtmlTable .= '</thead>' . PHP_EOL;
			$sHtmlTable .= '<tbody></tbody>' . PHP_EOL;
		}
		$sHtmlTable .= '</table>' . PHP_EOL;
		return $sHtmlTable;
	}
}
?>