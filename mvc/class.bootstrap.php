<?php
Class Pabana_Mvc_Bootstrap extends Pabana_Mvc {
	final public function toController($sVariableName, $mVariable) {
        $this->sendVariable('controller', $sVariableName, $mVariable);
	}
}
?>