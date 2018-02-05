<?php
namespace Pabana\Debug;

class Info {
	private $_armInfo;

	public function __construct() {
    }
	
	public function info() {
		$this->_armInfo = array(
			'Global' => array(
				'Pabana Version' => PC_VERSION
			),
			'Configuration' => array(
			)
		);
		$oHttpRequest = new Pabana\Http\Request();
		if(PHP_SAPI == 'cli' || $oHttpRequest->isAjax() === true) {
			echo $this->_infoText();
		} else {
			echo $this->_infoHtml();
		}
    }
	
	private function _infoText() {
		return '';
    }
	
	private function _infoHtml() {
		$sHtml = '<!DOCTYPE html>
		<html lang="en">
			<head>
				<meta charset="utf-8">
				<meta name="author" content="Pabana">
				<title>Pabana Info</title>
			</head>
			<body>';
		foreach($this->_armInfo as $sInfoCategoryName => $armInfoCategory) {
			$hHtml .= '<h2>' . $sInfoCategoryName . '</h2>
			<table>';
			foreach($armInfoCategory as $sInfoValueName => $sInfoValue) {
				$hHtml .= '<tr>
				<th>' . $sInfoValueName . '</th>
				<td>' . $sInfoValue . '</td>
				</tr>';
			}
			$sHtml .= '</table>';
		}
		$hHtml .= '</body>
		</html>';
		return $sHtml;
    }
}
?>