<?php
/**
* Index page
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @package imtagging
* @version		$Id$
*/
/** Include the module's header for all pages */
include_once 'header.php';

$xoopsOption['template_main'] = 'imtagging_index.html';
/** Include the ICMS header file */
include_once ICMS_ROOT_PATH . '/header.php';

// At which record shall we start display
$clean_start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$clean_tag_uid = isset($_GET['uid']) ? intval($_GET['uid']) : false;
$clean_year = isset($_GET['y']) ? intval($_GET['y']) : false;
$clean_month = isset($_GET['m']) ? intval($_GET['m']) : false;
$Basic_Check = defined ('_CALENDAR_TYPE') && _CALENDAR_TYPE == "jalali" && $icmsConfig['use_ext_date'] == 1;
if(!empty($_GET['y']) && !empty($_GET['m']) && $Basic_Check)
{
		$jyear = $clean_year;
		$jmonth = $clean_month;
		list($gyear, $gmonth, $gday) = jalali_to_gregorian( $jyear, $jmonth, '1' );
		$clean_year =  $gyear;
		$clean_month = $gmonth;

}

$imtagging_tag_handler = icms_getModulehandler('tag');

$icmsTpl->assign('imtagging_tags', $imtagging_tag_handler->getTags($clean_start, $icmsModuleConfig['tags_limit'], $clean_tag_uid, $clean_year, $clean_month));

/**
 * Create Navbar
 */
include_once ICMS_ROOT_PATH . '/class/pagenav.php';
$tags_count = $imtagging_tag_handler->getTagsCount($clean_tag_uid, $clean_year, $clean_month);
if ($clean_tag_uid) {
	$extr_arg = 'uid=' . $clean_tag_uid;
} else {
	$extr_arg = '';
}
$pagenav = new XoopsPageNav($tags_count, $icmsModuleConfig['tags_limit'], $clean_start, 'start', $extr_arg);
$icmsTpl->assign('navbar', $pagenav->renderNav());

$icmsTpl->assign('imtagging_module_home', imtagging_getModuleName(true, true));
if ($clean_tag_uid) {
	$icmsTpl->assign('imtagging_category_path', sprintf(_CO_IMTAGGING_TAG_FROM_USER, icms_getLinkedUnameFromId($clean_tag_uid)));
}
if ($clean_year && $clean_month) {
if($Basic_Check)
{
		$gyear = $clean_year;
		$gmonth = $clean_month;
		$gday = 1;
		list($jyear, $jmonth, $jday) = gregorian_to_jalali( $gyear, $gmonth, $gday );
		$clean_year =  icms_conv_nr2local($jyear);
		$clean_month = $jmonth;

}
	$icmsTpl->assign('imtagging_category_path', sprintf(_CO_IMTAGGING_TAG_FROM_MONTH, Icms_getMonthNameById($clean_month), $clean_year));
}
/** Include the module's footer */
include_once 'footer.php';
?>