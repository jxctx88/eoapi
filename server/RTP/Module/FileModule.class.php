<?php
/**
 * @name eoapi open source，eoapi开源版本
 * @link https://www.eoapi.cn
 * @package eoapi
 * @author www.eoapi.cn 深圳波纹聚联网络科技有限公司 ©2015-2016

 *  * eoapi，业内领先的Api接口管理及测试平台，为您提供最专业便捷的在线接口管理、测试、维护以及各类性能测试方案，帮助您高效开发、安全协作。
 * 如在使用的过程中有任何问题，欢迎加入用户讨论群进行反馈，我们将会以最快的速度，最好的服务态度为您解决问题。
 * 用户讨论QQ群：284421832
 *
 * 注意！eoapi开源版本仅供用户下载试用、学习和交流，禁止“一切公开使用于商业用途”或者“以eoapi开源版本为基础而开发的二次版本”在互联网上流通。
 * 注意！一经发现，我们将立刻启用法律程序进行维权。
 * 再次感谢您的使用，希望我们能够共同维护国内的互联网开源文明和正常商业秩序。
 *
 */

namespace RTP\Module;

class FileModule
{
	/**
	 * 自动在用户目录下面创建空白index.html文件，用于保护文件目录
	 */
	public static function createSecurityIndex()
	{
		$path = PATH_APP;
		$dirs = array();
		$ban_dirs = array(
			'./',
			'.',
			'../',
			'..'
		);
		self::getAllDirs($path, $dirs, $ban_dirs);

		foreach ($dirs as $dir)
		{
			if (file_exists($dir . '/index.html') || file_exists($dir . '/index.php'))
				continue;
			else
			{
				$file = fopen($dir . '/index.html', 'w');
				fwrite($file, '');
				fclose($file);
			}
		}
	}

	/**
	 * 获取路径下的所有目录
	 * @param String $path 目标路径
	 * @param array $dirs 用于储存返回路径的数组
	 * @param array $ban_dirs [可选]需要过滤的目录的相对地址的数组
	 */
	public static function getAllDirs($path, array &$dirs, array &$ban_dirs = array())
	{
		$paths = scandir($path);
		foreach ($paths as $nextPath)
		{
			if (!in_array($nextPath, $ban_dirs) && is_dir($path . DIRECTORY_SEPARATOR . $nextPath))
			{
				$dirs[] = realpath($path . DIRECTORY_SEPARATOR . urlencode($nextPath));
				self::getAllDirs($path . DIRECTORY_SEPARATOR . $nextPath, $dirs, $ban_dirs);
			}
		}
	}

	/**
	 * 获取路径下的所有文件
	 * @param String $path 目标路径
	 * @param array $dirs 用于储存返回路径的数组
	 * @param array $ban_dirs [可选]需要过滤的文件名的数组
	 */
	public static function getAllFiles($path, &$dirs, &$ban_dirs = array())
	{
		$paths = scandir($path);
		foreach ($paths as $nextPath)
		{
			if (!in_array($nextPath, $ban_dirs) && is_file($path . DIRECTORY_SEPARATOR . $nextPath))
			{
				$dirs[] = realpath($path . DIRECTORY_SEPARATOR . urlencode($nextPath));
				self::getAllFiles($path . DIRECTORY_SEPARATOR . $nextPath, $dirs, $ban_dirs);
			}
		}
	}

}
?>