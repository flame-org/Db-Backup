<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\Database;

interface IDriver 
{

	/**
	 * @return \PDO
	 */
	public function getConnection();

	/**
	 * @return string
	 */
	public function getCharset();

} 