<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\Database;

interface ITable 
{

	/**
	 * @return string
	 */
	public function getTableSchema();

	/**
	 * @return int
	 */
	public function getRowCount();

	/**
	 * @return int
	 */
	public function getColumnCount();

	/**
	 * @return array
	 */
	public function fetch();
} 