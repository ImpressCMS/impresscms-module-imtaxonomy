<?php
/**
 * Initial functions
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::art
 */

if (!defined("FRAMEWORKS_ART_FUNCTIONS_INI")):
define("FRAMEWORKS_ART_FUNCTIONS_INI", true);

define("FRAMEWORKS_ROOT_PATH", ICMS_ROOT_PATH."/modules/".basename( dirname(  dirname(  dirname( __FILE__ ) ) ) )."/class");

global $xoops;
if (!is_object($xoops) || "xos_kernel_Xoops2" != get_class($xoops)):

if (!class_exists("xos_kernel_Xoops2")):
/**
 * Extremely reduced kernel class
 * This class should not really be defined in this file, but it wasn't worth including an entire
 * file for those two functions.
 * Few notes:
 * - modules should use this class methods to generate physical paths/URIs (the ones which do not conform
 * will perform badly when true URL rewriting is implemented)
 */
class xos_kernel_Xoops2 {
	var $paths = array(
		'www' => array(), 'modules' => array(), 'themes' => array(),
	);
	
	function xos_kernel_Xoops2()
	{
		$this->paths['www'] = array( ICMS_ROOT_PATH, ICMS_URL );
		$this->paths['modules'] = array( ICMS_ROOT_PATH . '/modules', ICMS_URL . '/modules' );
		$this->paths['themes'] = array( ICMS_ROOT_PATH . '/themes', ICMS_URL . '/themes' );
	}
	/**
	 * Convert a XOOPS path to a physical one
	 */
	function path( $url, $virtual = false )
	{
		$path = '';
		@list( $root, $path ) = explode( '/', $url, 2 );
		if ( !isset( $this->paths[$root] ) ) {
			list( $root, $path ) = array( 'www', $url );
		}
		if ( !$virtual ) {		// Returns a physical path
			return $this->paths[$root][0] . '/' . $path;
		}
		return !isset( $this->paths[$root][1] ) ? '' : ( $this->paths[$root][1] . '/' . $path );
	}
	
	/**
	* Convert a XOOPS path to an URL
	*/
	function url( $url )
	{
		return ( false !== strpos( $url, '://' ) ? $url : $this->path( $url, true ) );
	}
	
	/**
	* Build an URL with the specified request params
	*/
	function buildUrl( $url, $params = array() )
	{
		if ( $url == '.' ) {
			$url = $_SERVER['REQUEST_URI'];
		}
		$split = explode( '?', $url );
		if ( count($split) > 1 ) {
			list( $url, $query ) = $split;
			parse_str( $query, $query );
			$params = array_merge( $query, $params );
		}
		if ( !empty( $params ) ) {
			foreach ( $params as $k => $v ) {
				$params[$k] = $k . '=' . rawurlencode($v);
			}
			$url .= '?' . implode( '&', $params );
		}
		return $url;
	}
}
endif;
/* Be careful not to use reference for $xoops, otherwise the $xoops won't be kept alive for XOOPS 2.2 */
$GLOBALS["xoops"] =& new xos_kernel_Xoops2();

endif;

/**
 * Load declaration of an object handler
 *
 *
 * @param	string	$handler	handler name, optional
 * @return	bool
 */
function load_objectHandler($handler = "", $dirname = "art")
{
	if (empty($handler)) {
		$handlerClass	= "ArtObject";
		$fileName		= "object.php"; 
	}else{
		$handlerClass	= "ArtObject".ucfirst($handler)."Handler";
		$fileName		= "object.{$handler}.php"; 
	}
	
	class_exists($handlerClass) || require_once(FRAMEWORKS_ROOT_PATH."/{$dirname}/{$fileName}");
	return class_exists($handlerClass);
}


function load_object()
{
	return load_objectHandler();
}

/**
 * Load a collective functions of Frameworks
 *
 * @param	string	$group		name of  the collective functions, empty for functions.php
 * @return	bool
 */
function load_functions($group = "", $dirname = "art")
{
	$dirname = ("" == $dirname ) ? "art" : $dirname;
	$constant = strtoupper( "frameworks_{$dirname}_functions" . (($group) ? "_{$group}" : ""));
	if (defined($constant)) return true;
	return @include_once FRAMEWORKS_ROOT_PATH."/{$dirname}/functions.{$group}" . (empty($group) ? "" : "." ) . "php";
}


/**
 * Load a collective functions of a module
 *
 * The function file should be located in /modules/MODULE/functions.{$group}.php
 * To avoid slowdown caused by include_once, a constant is suggested in the corresponding file: capitalized {$dirname}_{functions}[_{$group}]
 *
 * The function is going to be formulated to use xos_kernel_Xoops2::loadService() in XOOPS 2.3+
 *
 * @param	string	$group		name of  the collective functions, empty for functions.php
 * @param	string	$dirname	module dirname, optional
 * @return	bool
 */
function mod_loadFunctions($group = "", $dirname = "")
{
	$dirname = !empty($dirname) ? $dirname : $GLOBALS["icmsModule"]->getVar("dirname", "n");
	$constant = strtoupper( "{$dirname}_functions" . ( ($group) ? "_{$group}" : "" ) . "_loaded" );
	if (defined($constant)) return true;
	$filename = ICMS_ROOT_PATH."/modules/{$dirname}/include/functions.{$group}" . (empty($group) ? "" : "." ) . "php";
	return include_once $filename;
}

/**
 * Load renderer for a class
 *
 * The class file should be located in /modules/MODULE/{$class}.renderer.php
 * The classf name should be defined as Capitalized(module_dirname)Capitalized(class_name)Renderer
 *
 * @param	string	$class		name of  the classname
 * @param	string	$dirname	module dirname, optional
 * @return	bool
 */
function mod_loadRenderer($class, $dirname = "")
{
	$dirname = !empty($dirname) ? $dirname : $GLOBALS["icmsModule"]->getVar("dirname", "n");
	$renderer = ucfirst($dirname).ucfirst($class)."Renderer";
	if (!class_exists($renderer)) {
		require_once ICMS_ROOT_PATH."/modules/{$dirname}/class/{$class}.renderer.php";
	}
	$instance = eval("{$renderer}::instance()");
	return $instance;
}
/**
 * Get completed DB prefix if it is defined 
 *
 * @param	string	$name	string to be completed
 * @param	boolean	$isRel	relative - do not add XOOPS->DB prefix
 */
if (!function_exists("mod_DB_prefix")) {
function mod_DB_prefix($name, $isRel = false)
{
	$relative_name = $GLOBALS["MOD_DB_PREFIX"]."_".$name;
	if ($isRel) return $relative_name;
	return $GLOBALS["xoopsDB"]->prefix($relative_name);
}
}

/**
 * Display contents of a variable, an array or an object or an array of objects 
 *
 * @param	mixed	$message	variable/array/object
 */
if (!function_exists("xoops_message")):
function xoops_message( $message, $userlevel = 0)
{
	global $xoopsUser;
	
	if (!$xoopsUser) $level = 0;
	elseif ($xoopsUser->isAdmin()) $level = 99;
	else $level = 1;
	if ($userlevel > $level) return;
	
	echo "<div style=\"clear:both\"> </div>";
	if (is_array($message) || is_object($message)){
		echo "<div><pre>";print_r($message);echo "</pre></div>";
	}else{
		echo "<div>$message</div>";
	}
	echo "<div style=\"clear:both\"> </div>";
}
endif;
function mod_message( $message )
{
	global $icmsModuleConfig;
	if (!empty($icmsModuleConfig["do_debug"])){
		if (is_array($message) || is_object($message)){
			echo "<div><pre>";print_r($message);echo "</pre></div>";
		}else{
			echo "<div>$message</div>";
		}
	}
	return true;
}

/**
 * Get dirname of a module according to current path
 *
 * @param	string	$current_path	path to where the function is called
 * @return	string	$dirname
 */
function mod_getDirname($current_path= null)
{
	if ( DIRECTORY_SEPARATOR != '/' ) $current_path = str_replace( strpos( $current_path, '\\\\', 2 ) ? '\\\\' : DIRECTORY_SEPARATOR, '/', $current_path);
	$url_arr = explode('/', strstr($current_path, '/modules/'));
	return $url_arr[2];
}

endif;
?>