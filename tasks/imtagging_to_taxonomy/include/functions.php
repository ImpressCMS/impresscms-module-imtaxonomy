<?php
/**
* Common functions used by the module
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

/**
 * Get module admion link
 *
 * @todo to be move in icms core
 *
 * @param string $moduleName dirname of the moodule
 * @return string URL of the admin side of the module
 */
function imtagging_getModuleAdminLink($moduleName='imtagging') {
	global $icmsModule;
	if (!$moduleName && (isset ($icmsModule) && is_object($icmsModule))) {
		$moduleName = $icmsModule->getVar('dirname');
	}
	$ret = '';
	if ($moduleName) {
		$ret = "<a href='" . ICMS_URL . "/modules/$moduleName/admin/index.php'>" ._MD_IMTAGGING_ADMIN_PAGE . "</a>";
	}
	return $ret;
}

/**
 * @todo to be move in icms core
 */
function imtagging_getModuleName($withLink = true, $forBreadCrumb = false, $moduleName = false) {
	if (!$moduleName) {
		global $icmsModule;
		$moduleName = $icmsModule->getVar('dirname');
	}
	$icmsModule = icms_getModuleInfo($moduleName);
	$icmsModuleConfig = icms_getModuleConfig($moduleName);
	if (!isset ($icmsModule)) {
		return '';
	}

	if (!$withLink) {
		return $icmsModule->getVar('name');
	} else {
/*	    $seoMode = smart_getModuleModeSEO($moduleName);
	    if ($seoMode == 'rewrite') {
	    	$seoModuleName = smart_getModuleNameForSEO($moduleName);
	    	$ret = ICMS_URL . '/' . $seoModuleName . '/';
	    } elseif ($seoMode == 'pathinfo') {
	    	$ret = ICMS_URL . '/modules/' . $moduleName . '/seo.php/' . $seoModuleName . '/';
	    } else {
			$ret = ICMS_URL . '/modules/' . $moduleName . '/';
	    }
*/
		$ret = ICMS_URL . '/modules/' . $moduleName . '/';
		return '<a href="' . $ret . '">' . $icmsModule->getVar('name') . '</a>';
	}
}

/**
 * Get URL of previous page
 *
 * @todo to be moved in ImpressCMS 1.2 core
 *
 * @param string $default default page if previous page is not found
 * @return string previous page URL
 */
function imtagging_getPreviousPage($default=false) {
	global $impresscms;
	if (isset($impresscms->urls['previouspage'])) {
		return $impresscms->urls['previouspage'];
	} elseif($default) {
		return $default;
	} else {
		return ICMS_URL;
	}
}

/**
 * Get month name by its ID
 *
 * @todo to be moved in ImpressCMS 1.2 core
 *
 * @param int $month_id ID of the month
 * @return string month name
 */
function imtagging_getMonthNameById($month_id) {
	icms_loadLanguageFile('core', 'calendar');
	switch($month_id) {
		case 1:
			return _CAL_JANUARY;
		break;
		case 2:
			return _CAL_FEBRUARY;
		break;
		case 3:
			return _CAL_MARCH;
		break;
		case 4:
			return _CAL_APRIL;
		break;
		case 5:
			return _CAL_MAY;
		break;
		case 6:
			return _CAL_JUNE;
		break;
		case 7:
			return _CAL_JULY;
		break;
		case 8:
			return _CAL_AUGUST;
		break;
		case 9:
			return _CAL_SEPTEMBER;
		break;
		case 10:
			return _CAL_OCTOBER;
		break;
		case 11:
			return _CAL_NOVEMBER;
		break;
		case 12:
			return _CAL_DECEMBER;
		break;
	}
}
?>