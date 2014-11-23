<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\Database;

class Context implements IContext
{

	/** @var  IDriver */
	private $driver;

	/**
	 * @param IDriver $driver
	 */
	function __construct(IDriver $driver)
	{
		$this->driver = $driver;
	}

	/**
	 * @return array
	 */
	public function getTableList()
	{
		return $this->driver->getConnection()->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
	}

	/**
	 * @param string $name
	 * @return Table
	 */
	public function getTable($name)
	{
		return new Table($name, $this->driver);
	}

	/**
	 * @return string
	 */
	public function getCharset()
	{
		return $this->driver->getCharset();
	}


}