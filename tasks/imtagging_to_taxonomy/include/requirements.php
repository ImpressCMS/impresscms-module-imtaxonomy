<?php
/**
* Check requirements of the module
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
* @todo			this could easily be generalized in a IcmsRequirements class and put in ImpressCMS 1.2 for other modules to use
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

$failed_requirements = array();

/* ImpressCMS Builtd needs to be at lest 19 */
if (ICMS_VERSION_BUILD < 19) {
	$failed_requirements[] = _AM_IMTAGGING_REQUIREMENTS_ICMS_BUILD;
}

if (count($failed_requirements) > 0) {
	icms_cp_header();
	$icmsAdminTpl->assign('failed_requirements', $failed_requirements);
	$icmsAdminTpl->display(IMTAGGING_ROOT_PATH . 'templates/imtagging_requirements.html');
	icms_cp_footer();
	exit;
}
?>