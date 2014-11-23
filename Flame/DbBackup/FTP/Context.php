<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\DbBackup\FTP;

class Context
{

	/** @var  null */
	private $connection;

	/** @var array  */
	private $credits;

	/**
	 * @param string $server
	 * @param string $user
	 * @param string $password
	 * @param string $path
	 */
	function __construct($server, $user, $password, $path)
	{
		$this->credits = array(
			'server' => (string) $server,
			'user' => (string) $user,
			'password' => (string) $password,
			'path' => (string) $path
		);
	}

	/**
	 * @return null|resource
	 * @throws \ErrorException
	 */
	public function getConnection()
	{
		if ($this->connection === null) {
			$id = ftp_connect($this->credits['server']);
			$login = ftp_login($id, $this->credits['user'], $this->credits['password']);

			if (!$login) {
				throw new \ErrorException('Login to FTP server failed');
			}

			$this->connection = $id;
		}

		return $this->connection;
	}

	/**
	 * @param $file
	 * @param null $additionalPath
	 * @return bool
	 */
	public function upload($file, $additionalPath = null)
	{
		$path = $this->getPath($file, $additionalPath);
		return @ftp_put($this->getConnection(), $path, $file, FTP_ASCII);
	}

	/**
	 * @param string $filePath
	 * @param null $additional
	 * @return string
	 */
	private function getPath($filePath, $additional = null)
	{
		$path = $this->credits['path'];
		if (substr($path, 0, -1) !== '/') {
			$path .= '/';
		}

		if ($additional) {
			if (substr($additional, 0, -1) !== '/') {
				$additional .= '/';
			}

			$path .= $additional;
		}

		return $path . basename($filePath);
	}

	function __destruct()
	{
		@ftp_close($this->getConnection());
	}


} 