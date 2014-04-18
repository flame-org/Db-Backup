<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup;

interface IBackup 
{

	/**
	 * @param string $tempDirPath
	 * @return void
	 */
	public function create($tempDirPath);
} 