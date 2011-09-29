<?php
/**
* Configuring the amdin side menu for the module
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

$i = -1;

$i++;
$adminmenu[$i]['title'] = _MI_IMTAGGING_CATEGORIES;
$adminmenu[$i]['link'] = "admin/category.php";

$i++;
$adminmenu[$i]['title'] = _AM_IMTAGGING_CATEGORY_LINK;
$adminmenu[$i]['link'] = "admin/category_link.php";

$i++;
$adminmenu[$i]['title'] = _MI_IMTAGGING_TAGS;
$adminmenu[$i]['link'] = "admin/tag.php";

global $icmsModule;
if (isset($icmsModule)) {

	$i = -1;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $icmsModule->getVar('mid');

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_GOTOMODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/imtagging/';

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $icmsModule->getVar('dirname');

	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/imtagging/admin/about.php';
}
?>