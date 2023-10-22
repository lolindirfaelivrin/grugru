<?php
declare(strict_types=1); 
namespace Libreria;
use Core\GruGru;

/**
 * Simple autoloader, so we don't need Composer just for this.
 * https://www.php.net/manual/en/language.oop5.autoload.php
 */
class Autoload
{
	public static function register()
	{
		spl_autoload_register(function ($class) {
			$base = dirname(__DIR__);
			$file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';

			if (file_exists($base.DIRECTORY_SEPARATOR.$file)) {
				require_once $base.DIRECTORY_SEPARATOR.$file;
				return true;
			}
            return false;
		});
	}
}
