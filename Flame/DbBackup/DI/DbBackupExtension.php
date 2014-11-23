<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\DI;

use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;

class DbBackupExtension extends CompilerExtension
{

	/** @var array  */
	public $defaults = array(
		'ftp' => array(
			'server' => '',
			'user' => '',
			'password' => '',
			'path' => ''
		)
	);

	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		$container->addDefinition($this->prefix('dbBackup'))
			->setClass('Flame\DbBackup\Backup');

		if (isset($config['ftp']) && $config['ftp']) {
			Validators::assertField($config['ftp'], 'server', 'string');
			Validators::assertField($config['ftp'], 'user', 'string');
			Validators::assertField($config['ftp'], 'password', 'string');
			Validators::assertField($config['ftp'], 'path', 'string');
			$container->addDefinition($this->prefix('ftpContext'))
				->setClass('Flame\DbBackup\FTP\Context', array($config['ftp']['server'], $config['ftp']['user'], $config['ftp']['password'], $config['ftp']['path']));
		}



	}

} 