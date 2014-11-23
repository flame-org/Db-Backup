<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\Database;

interface IContext
{

	/**
	 * @return array
	 */
	public function getTableList();

	/**
	 * @param string $name
	 * @return ITable
	 */
	public function getTable($name);

	/**
	 * @return string
	 */
	public function getCharset();
} 