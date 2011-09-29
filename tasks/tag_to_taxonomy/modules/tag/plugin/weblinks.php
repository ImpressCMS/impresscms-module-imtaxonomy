<?php

/**

 * Tag info

 *

 * @copyright	The XOOPS project http://www.xoops.org/

 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license

 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>

 * @since		1.00

 * @version		$Id$

 * @package		module::tag

 */

if (!defined('ICMS_ROOT_PATH')){ exit(); }



/**

 * Get item fields:

 * title

 * content

 * time

 * link

 * uid

 * uname

 * tags

 *

 * @var		array	$items	associative array of items: [modid][catid][itemid]

 *

 * @return	boolean

 * 

 */

function weblinks_tag_iteminfo(&$items)

{
	if(empty($items) || !is_array($items)){
		return false;
	}
	$items_id = array();
	foreach(array_keys($items) as $cat_id){
		// Some handling here to build the link upon catid
			// catid is not used in article, so just skip it
		foreach(array_keys($items[$cat_id]) as $item_id){
			// In article, the item_id is "lid"
			$items_id[] = intval($item_id);
		}
	}

//  $item_handler =& xoops_getmodulehandler("weblinks", "weblinks");

//	$items_obj = $item_handler->getObjects(new Criteria("lid", "(".implode(", ", $lid).")", "IN"), true);

	 include_once ICMS_ROOT_PATH.'/modules/weblinks/class/weblinks_link.php';

	foreach(array_keys($items) as $cat_id){

		foreach(array_keys($items[$cat_id]) as $item_id){
			// $weblink =& $weblinks[$item_id];
			$weblinks = new NewLink($item_id);
			$items[$cat_id][$item_id] = array(

				"title"		=> $weblinks->getVar("title"),

				"uid"		=> $weblinks->getVar("uid"),

				"link"		=> "singlelink.php?lid={$item_id}",

				"time"		=> $weblinks->getVar("time_update"),

			//	"tags"		=> tag_parse_tag($weblinks->getVar("tag", "n")),
		  	"tags"		=> tag_parse_tag($weblinks->keywords()),

				"content"	=> $weblinks->getVar("usercomment"),

				);

		}

	}

	unset($weblinks);	

}



/**

 * Remove orphan tag-item links

 *

 * @return	boolean

 * 

 */

function weblinks_tag_synchronization($mid)

{

	$item_handler =& xoops_getmodulehandler("title", "weblinks");

	$link_handler =& xoops_getmodulehandler("link", "tag");

        

	/* clear tag-item links */

	if($link_handler->mysql_major_version() >= 4):

    $sql =	"	DELETE FROM {$link_handler->table}".

    		"	WHERE ".

    		"		tag_modid = {$mid}".

    		"		AND ".

    		"		( tag_itemid NOT IN ".

    		"			( SELECT DISTINCT {$item_handler->keyName} ".

    		"				FROM {$item_handler->table} ".

    		"				WHERE {$item_handler->table}.art_time_publish > 0".

    		"			) ".

    		"		)";

    else:

    $sql = 	"	DELETE {$link_handler->table} FROM {$link_handler->table}".

    		"	LEFT JOIN {$item_handler->table} AS aa ON {$link_handler->table}.tag_itemid = aa.{$item_handler->keyName} ".

    		"	WHERE ".

    		"		tag_modid = {$mid}".

    		"		AND ".

    		"		( aa.{$item_handler->keyName} IS NULL".

    		"			OR aa.art_time_publish < 1".

    		"		)";

	endif;

    if (!$result = $link_handler->db->queryF($sql)) {

        //xoops_error($link_handler->db->error());

  	}

}

?>