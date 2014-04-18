<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\Database\Drivers;

use Flame\DbBackup\Database\IDriver;
use Nette\Database\Connection;

class NetteDriver implements IDriver
{

	/** @var  \Nette\Database\Connection */
	private $connection;

	/** @var string  */
	private $charset;

	/**
	 * @param Connection $connection
	 * @param string $charset
	 */
	function __construct(Connection $connection, $charset = 'utf8')
	{
		$this->connection = $connection;
		$this->charset = (string) $charset;
	}

	/**
	 * @return \PDO
	 */
	public function getConnection()
	{
		return $this->connection->getPdo();
	}

	/**
	 * @return string
	 */
	public function getCharset()
	{
		return $this->charset;
	}
}