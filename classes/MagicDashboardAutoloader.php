<?

class MagicDashboardAutoloader {

	protected static $pathes = array();
	
	public static function addPath($path) {
		static::$pathes[] = $path;
	}

	public static function load($class) {
		foreach( static::$pathes as $path ) {
			$path = str_replace('%class%', $class, $path);
			if( file_exists($path) ) {
				require($path);			
			}
		}
	}
}

spl_autoload_register('MagicDashboardAutoloader::load');
MagicDashboardAutoloader::addPath(__DIR__.'/%class%.php');
MagicDashboardAutoloader::addPath(__DIR__.'/widgettypes/%class%/%class%.php');
MagicDashboardAutoloader::addPath(__DIR__.'/widgets/%class%.php');

?>
