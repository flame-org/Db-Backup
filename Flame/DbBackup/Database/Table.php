<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\Database;

class Table implements ITable
{

	/** @var null */
	private $statement;

	/** @var IDriver */
	private $context;

	/** @var  string */
	private $tableName;

	/**
	 * @param $table
	 * @param IContext $context
	 */
	function __construct($table, IContext $context)
	{
		$this->tableName = (string) $table;
		$this->context = $context;
	}

	/**
	 * @return \PDOStatement
	 */
	private function getStatement()
	{
		if ($this->statement === null) {
			$this->statement = $this->context->getConnection()->query('SELECT * FROM ' . addslashes($this->tableName));
		}

		return $this->statement;
	}

	/**
	 * @return int
	 */
	public function getRowCount()
	{
		return $this->getStatement()->rowCount();
	}

	/**
	 * @return int
	 */
	public function getColumnCount()
	{
		return $this->getStatement()->columnCount();
	}

	/**
	 * @return array
	 */
	public function fetch()
	{
		return $this->getStatement()->fetch();
	}

	/**
	 * @return string
	 */
	public function getTableSchema()
	{
		$result = $this->context->getConnection()->query('SHOW CREATE TABLE . ' . addslashes($this->tableName))->fetch(\PDO::FETCH_ASSOC);
		if (isset($result['Create Table'])) {
			return $result['Create Table'];
		}
	}


}