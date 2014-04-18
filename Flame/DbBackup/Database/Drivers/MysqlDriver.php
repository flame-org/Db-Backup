<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\Database\Drivers;

use Flame\DbBackup\Database\IDriver;

class MysqlDriver implements IDriver
{

	/** @var  array */
	private $credits;

	/** @var  \PDO */
	private $connection;

	/**
	 * @param $host
	 * @param $username
	 * @param $password
	 * @param $database
	 * @param string $charset
	 */
	function __construct($host, $username, $password, $database, $charset = 'utf8')
	{
		$this->credits = array(
			'host' => (string) $host,
			'username' => (string) $username,
			'password' => (string) $password,
			'database' => (string) $database,
			'charset' => (string) $charset
		);
	}

	/**
	 * @return \PDO
	 */
	public function getConnection()
	{
		if ($this->connection === null) {
			$pdo = new \PDO('mysql:host=' . $this->credits['host'] . ';dbname=' . $this->credits['database'], $this->credits['username'], $this->credits['password']);
			$this->connection = $this->setUpConnection($pdo);
		}

		return $this->connection;
	}

	/**
	 * @return string
	 */
	public function getCharset()
	{
		return $this->credits['charset'];
	}


	/**
	 * @param \PDO $connection
	 * @return \PDO
	 */
	protected function setUpConnection(\PDO $connection)
	{
		if ($connection !== false) {
			$connection->exec('SET NAMES ' . $this->credits['charset']);
		}

		return $connection;
	}
}