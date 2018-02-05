<?php
namespace Pabana\Database;

use Pabana\Database\Database;

Class ConnectionCollection
{
	private static $armConnectionList = array();
	private static $sDefaultConnectionName = null;

	public static function add($sConnectionName, $oConnection)
	{
		self::$armConnectionList[$sConnectionName] = $oConnection;
		if ($oConnection->Datasource->isDefault()) {
			self::$sDefaultConnectionName = $sConnectionName;
		}
	}

	public static function get($sConnectionName)
	{
		return self::$armConnectionList[$sConnectionName];
	}

	public static function getDefault()
	{
		return self::$armConnectionList[self::$sDefaultConnectionName];
	}

	public static function getList()
	{
		return self::$armConnectionList;
	}
}