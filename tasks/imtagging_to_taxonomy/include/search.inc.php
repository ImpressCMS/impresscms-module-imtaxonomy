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
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function imtagging_search($queryarray, $andor, $limit, $offset, $userid)
{
	/*
	$imtagging_tag_handler = icms_getModulehandler('tag', 'imtagging');
	$tagsArray = $imtagging_tag_handler->getTagsForSearch($queryarray, $andor, $limit, $offset, $userid);

	foreach ($tagsArray as $tagArray) {
		$item['image'] = "images/tag.png";
		$item['link'] = $tagArray['itemUrl'];
		$item['title'] = $tagArray['tag_title'];
		$item['time'] = strtotime($tagArray['tag_published_date']);
		$item['uid'] = $tagArray['tag_uid'];
		$ret[] = $item;
		unset($item);
	}
	return $ret;
	*/
}

?>