<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\Database;

class Schema
{
	/** @var IContext  */
	private $database;

	/** @var  IDriver */
	private $driver;

	/**
	 * @param IContext $database
	 * @param IDriver $driver
	 */
	function __construct(IContext $database, IDriver $driver)
	{
		$this->database = $database;
		$this->driver = $driver;
	}

	/**
	 * @return string
	 */
	public function create()
	{
		$return = "";
		$return .= 'SET NAMES ' . $this->driver->getCharset() . ';' . PHP_EOL;
		$return .= 'SET foreign_key_checks = 0;' . PHP_EOL;
		$return .= 'SET sql_mode = \'NO_AUTO_VALUE_ON_ZERO\';' . PHP_EOL . PHP_EOL;

		$tables = $this->database->getTableList();

		foreach($tables as $tableName) {
			$table = $this->database->getTable($tableName);

			$return .= 'DROP TABLE IF EXISTS `' . $tableName . '`;';
			$return .= "\n" . $table->getTableSchema() . ";\n\n";

			if ($table->getRowCount()) {
				$return.= 'INSERT INTO '.$tableName.' VALUES '. PHP_EOL;
				$num_fields = $table->getColumnCount();
				while($row = $table->fetch()) {

					$return .= '(';
					for($j=0; $j<$num_fields; $j++){

						if (isset($row[$j])) {
							$row[$j] = addslashes($row[$j]);
							$row[$j] = str_replace("\n","\\n",$row[$j]);
							$return.= '"'.$row[$j].'"' ;
						} else {
							$return.= 'NULL';
						}

						if ($j<($num_fields-1)) { $return.= ', '; }
					}

					$return .= '),' . PHP_EOL;
				}


				$return = substr($return, 0, -2) . ';' . PHP_EOL . PHP_EOL;
			}
		}


		return $return;
	}
} 