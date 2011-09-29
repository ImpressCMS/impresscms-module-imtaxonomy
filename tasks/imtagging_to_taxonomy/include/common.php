<?php
/**
* Common file of the module included on all pages of the module
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("IMTAGGING_DIRNAME"))		define("IMTAGGING_DIRNAME", $modversion['dirname'] = basename(dirname(dirname(__FILE__))));
if(!defined("IMTAGGING_URL"))			define("IMTAGGING_URL", ICMS_URL.'/modules/'.IMTAGGING_DIRNAME.'/');
if(!defined("IMTAGGING_ROOT_PATH"))	define("IMTAGGING_ROOT_PATH", ICMS_ROOT_PATH.'/modules/'.IMTAGGING_DIRNAME.'/');
if(!defined("IMTAGGING_IMAGES_URL"))	define("IMTAGGING_IMAGES_URL", IMTAGGING_URL.'images/');
if(!defined("IMTAGGING_ADMIN_URL"))	define("IMTAGGING_ADMIN_URL", IMTAGGING_URL.'admin/');

// Include the common language file of the module
icms_loadLanguageFile('imtagging', 'common');

include_once(IMTAGGING_ROOT_PATH . "include/functions.php");

// Creating the module object to make it available throughout the module
$imtaggingModule = icms_getModuleInfo(IMTAGGING_DIRNAME);
if (is_object($imtaggingModule)){
	$imtagging_moduleName = $imtaggingModule->getVar('name');
}

// Find if the user is admin of the module and make this info available throughout the module
$imtagging_isAdmin = icms_userIsAdmin(IMTAGGING_DIRNAME);

// Creating the module config array to make it available throughout the module
$imtaggingConfig = icms_getModuleConfig(IMTAGGING_DIRNAME);

// including the tag class
include_once(IMTAGGING_ROOT_PATH . 'class/tag.php');

// creating the icmsPersistableRegistry to make it available throughout the module
global $icmsPersistableRegistry;
$icmsPersistableRegistry = IcmsPersistableRegistry::getInstance();

?>