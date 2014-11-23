<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup;

use Flame\DbBackup\Database\Schema;
use Flame\DbBackup\FTP\Context;
use Tracy\Debugger;

class Backup implements IBackup
{

	/** @var ContextContainer  */
	private $container;

	/** @var  Context */
	private $ftp;

	/**
	 * @param Context $ftp
	 * @param ContextContainer $contextContainer
	 */
	function __construct(Context $ftp, ContextContainer $contextContainer)
	{
		$this->ftp = $ftp;
		$this->container = $contextContainer;
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

		foreach($this->container->getSchemas() as $k => $schema) {

			try {

				$backupName = $this->getBackupFileName($k);
				$path = $tempDirPath . DIRECTORY_SEPARATOR . $backupName;

				$this->process($path, $schema);

			} catch (\Exception $e) {
				Debugger::log($e);
			}

		}
	}


	private function process($localPath, Schema $schema)
	{

		$backup = $schema->create();

		if (file_put_contents($localPath, $backup) === false) {
			throw new \ErrorException('Creating of sql file failed.');
		}

		$this->ftp->upload($localPath);

		if (file_exists($localPath)) {
			@unlink($localPath);
		}
	}


	/**
	 * @param $counter
	 * @return string
	 */
	private function getBackupFileName($counter)
	{
		return 'db_backup_' . $counter . '_[' . date("d.m.Y-H:i") . '].sql';
	}
}