<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup;

use Flame\DbBackup\Database\Schema;
use Flame\DbBackup\FTP\Context;

class Backup implements IBackup
{

	/** @var  Schema */
	private $schema;

	/** @var  Context */
	private $ftp;

	/**
	 * @param Context $ftp
	 * @param Schema $schema
	 */
	function __construct(Context $ftp, Schema $schema)
	{
		$this->ftp = $ftp;
		$this->schema = $schema;
	}

	/**
	 * @param string $tempDirPath
	 * @throws \ErrorException
	 */
	public function create($tempDirPath)
	{
		if(!file_exists($tempDirPath)) {
			if(!mkdir($tempDirPath)) {
				throw new \ErrorException('File path "' . $tempDirPath . '" does not exist');
			}
		}

		$backupName = $this->getBackupFileName();
		$localPath = $tempDirPath . DIRECTORY_SEPARATOR . $backupName;
		$schema = $this->schema->create();

		if (file_put_contents($localPath, $schema) === false) {
			throw new \ErrorException('Creating of sql file failed.');
		}

		$this->ftp->upload($localPath);

		if (file_exists($localPath)) {
			@unlink($localPath);
		}
	}


	/**
	 * @return string
	 */
	protected function getBackupFileName()
	{
		return 'db_backup[' . date("d.m.Y-H:i") . '].sql';
	}
}