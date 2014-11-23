<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup;

use Flame\DbBackup\Database\Context;
use Flame\DbBackup\Database\IDriver;
use Flame\DbBackup\Database\Schema;

class ContextContainer
{

	/**
	 * @var IDriver[]
	 */
	private $drivers;

	/**
	 * @param IDriver $driver
	 */
	public function addDriver(IDriver $driver)
	{
		$this->drivers[] = $driver;
	}

	/**
	 * @return array|Schema[]
	 */
	public function getSchemas()
	{
		$schemas = array();
		foreach($this->drivers as $driver) {
			$schemas[] = new Schema($this->createContext($driver));
		}

		return $schemas;
	}

	/**
	 * @param IDriver $driver
	 * @return Context
	 */
	private function createContext(IDriver $driver)
	{
		return new Context($driver);
	}

} 