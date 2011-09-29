<?php
/**
* imTagging version infomation
*
* This file holds the configuration information of this module
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @package imtagging
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

/**  General Information  */
$modversion = array(
  'name'=> _MI_IMTAGGING_MD_NAME,
  'version'=> 1.0,
  'description'=> _MI_IMTAGGING_MD_DESC,
  'author'=> "The SmartFactory",
  'credits'=> "INBOX International inc.",
  'help'=> "",
  'license'=> "GNU General Public License (GPL)",
  'official'=> 0,
  'dirname'=> basename( dirname( __FILE__ ) ),

/**  Images information  */
  'iconsmall'=> "images/icon_small.png",
  'iconbig'=> "images/icon_big.png",
  'image'=> "images/icon_big.png", /* for backward compatibility */

/**  Development information */
  'status_version'=> "Beta 1",
  'status'=> "Beta",
  'date'=> "unreleased",
  'author_word'=> "",

/** Contributors */
  'developer_website_url' => "http://smartfactory.ca",
  'developer_website_name' => "The SmartFactory",
  'developer_email' => "info@smartfactory.ca");
$modversion['people']['developers'][] = "[url=http://smartfactory.ca/userinfo.php?uid=1]marcan[/url] (Marc-Andr&eacute; Lanciault)";
$modversion['people']['developers'][] = "[url=http://smartfactory.ca/userinfo.php?uid=112]felix[/url] (F&eacute;lix Tousignant)";
//$modversion['people']['testers'][] = "";
//$modversion['people']['translators'][] = "";
//$modversion['people']['documenters'][] = "";
//$modversion['people']['other'][] = "";
//$modversion['warning'] = _CO_SOBJECT_WARNING_BETA;

/** Administrative information */
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

/** Database information */
$modversion['object_items'][1] = 'category';
$modversion['object_items'][] = 'category_link';
$modversion['object_items'][] = 'tag';
$modversion["tables"] = icms_getTablesArray($modversion['dirname'], $modversion['object_items']);

/** Install and update informations */
$modversion['onInstall'] = "include/onupdate.inc.php";
$modversion['onUpdate'] = "include/onupdate.inc.php";

/** Search information */
$modversion['hasSearch'] = 1;
$modversion['search'] = array (
  'file' => "include/search.inc.php",
  'func' => "imtagging_search");

/** Menu information */
$modversion['hasMain'] = 0;

/** Blocks information */
$modversion['blocks'][1] = array(
  'file' => 'tag_recent.php',
  'name' => _MI_IMTAGGING_TAGRECENT,
  'description' => _MI_IMTAGGING_TAGRECENTDSC,
  'show_func' => 'imtagging_tag_recent_show',
  'edit_func' => 'imtagging_tag_recent_edit',
  'options' => '5',
  'template' => 'imtagging_tag_recent.html');

$modversion['blocks'][] = array(
  'file' => 'tag_by_month.php',
  'name' => _MI_IMTAGGING_TAGBYMONTH,
  'description' => _MI_IMTAGGING_TAGBYMONTHDSC,
  'show_func' => 'imtagging_tag_by_month_show',
  'edit_func' => 'imtagging_tag_by_month_edit',
  'options' => '',
  'template' => 'imtagging_tag_by_month.html');

/** Templates information */
$modversion['templates'][1] = array(
  'file' => 'imtagging_header.html',
  'description' => 'Module Header');

$modversion['templates'][] = array(
  'file' => 'imtagging_footer.html',
  'description' => 'Module Footer');

$modversion['templates'][]= array(
  'file' => 'imtagging_admin_tag.html',
  'description' => 'Tag Index');

$modversion['templates'][]= array(
  'file' => 'imtagging_admin_category.html',
  'description' => 'Category Index');

$modversion['templates'][]= array(
  'file' => 'imtagging_admin_category_link.html',
  'description' => 'Category Link Index');

$modversion['templates'][] = array(
  'file' => 'imtagging_index.html',
  'description' => 'Tag Index');

$modversion['templates'][] = array(
  'file' => 'imtagging_single_tag.html',
  'description' => 'Single tag template');

$modversion['templates'][] = array(
  'file' => 'imtagging_tag.html',
  'description' => 'Tag page');

$modversion['templates'][] = array(
  'file' => 'imtagging_persistable_singleview.html',
  'description' => 'Tag page');


/** Preferences information */

// Retrieve the group user list, because the automatic group_multi config formtype does not include Anonymous group :-(
$member_handler =& xoops_getHandler('member');
$groups_array = $member_handler->getGroupList();
foreach($groups_array as $k=>$v) {
	$select_groups_options[$v] = $k;
}

$modversion['config'][1] = array(
  'name' => 'tager_groups',
  'title' => '_MI_IMTAGGING_TAGERGR',
  'description' => '_MI_IMTAGGING_TAGERGRDSC',
  'formtype' => 'select_multi',
  'valuetype' => 'array',
  'options' => $select_groups_options,
  'default' =>  '1');

$modversion['config'][] = array(
  'name' => 'tags_limit',
  'title' => '_MI_IMTAGGING_LIMIT',
  'description' => '_MI_IMTAGGING_LIMITDSC',
  'formtype' => 'textbox',
  'valuetype' => 'text',
  'default' => 5);

/** Comments information */
$modversion['hasComments'] = 1;

$modversion['comments'] = array(
  'itemName' => 'tag_id',
  'pageName' => 'tag.php',
  /* Comment callback functions */
  'callbackFile' => 'include/comment.inc.php',
  'callback' => array(
    'approve' => 'imtagging_com_approve',
    'update' => 'imtagging_com_update')
    );

/** Notification information */
$modversion['hasNotification'] = 1;

$modversion['notification'] = array (
  'lookup_file' => 'include/notification.inc.php',
  'lookup_func' => 'imtagging_notify_iteminfo');

$modversion['notification']['category'][1] = array (
  'name' => 'global',
  'title' => _MI_IMTAGGING_GLOBAL_NOTIFY,
  'description' => _MI_IMTAGGING_GLOBAL_NOTIFY_DSC,
  'subscribe_from' => array('index.php', 'tag.php'));

$modversion['notification']['event'][1] = array(
  'name' => 'tag_published',
  'category'=> 'global',
  'title'=> _MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY,
  'caption'=> _MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_CAP,
  'description'=> _MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_DSC,
  'mail_template'=> 'global_tag_published',
  'mail_subject'=> _MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_SBJ);

?>