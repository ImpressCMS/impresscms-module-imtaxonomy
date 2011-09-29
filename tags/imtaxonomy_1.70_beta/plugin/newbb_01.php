<?php

/**

 * Tag info

 *

 * @copyright	The XOOPS project http://www.xoops.org/

 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license

 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>

 * @since		1.00

 * @version		$Id: newbb_01.php 19246 2010-05-10 10:19:05Z underdogg $

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
 
	include_once ICMS_ROOT_PATH . '/modules/newbb/class/text.php';
//	include_once ICMS_ROOT_PATH . '/modules/newbb/class/topic.php';
	include_once ICMS_ROOT_PATH . '/modules/newbb/class/post.php';
//  include ICMS_ROOT_PATH.'/modules/newbb/include/functions.ini.php';
//  require_once(ICMS_ROOT_PATH.'/modules/newbb/include/functions.php');	
//  include_once ICMS_ROOT_PATH."/modules/tag/include/formtag.php" ;

function newbb_tag_iteminfo(&$items)

{

	if(empty($items) || !is_array($items)){

		return false;

	}


	

	$items_id = array();

	foreach(array_keys($items) as $cat_id){
		// Some handling here to build the link upon catid
			// catid is post_id
			$catid[] = intval($item_id);
		foreach(array_keys($items[$cat_id]) as $item_id){
			// In article, the item_id is "topic_id"
			$items_id[] = intval($item_id);
		}
	}
	
//	$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
//	$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
	$text_handler =& xoops_getmodulehandler('text', 'newbb');
	$item_handler =& xoops_getmodulehandler('post', 'newbb');

	
	// $item_handler =& xoops_getmodulehandler('forum', 'newbb');
	// $item_handler =& xoops_getmodulehandler('topic', 'newbb');
	$items_obj = $item_handler->getObjects(new Criteria("post_id", "(".implode(", ", $items_id).")", "IN"), true);


//  $texts_obj = $text_handler->getObjects(new Criteria("texte", "(".implode(", ", $cat_id).")", "IN"), true);
//	$items_topic = $item_handler->getObjects(new Criteria("topic_id", "(".implode(", ", $items_id).")", "IN"), true);

//   $forumpost =& $text_handler->get($cat_id);

// global $xoopsDB, $xoopsConfig, $myts, $xoopsUser;  
//  $asksql = 'SELECT post_text FROM '.$xoopsDB->prefix('bb_posts').' WHERE post_id = 7 ';
//  $themessage = $xoopsDB->query($asksql) ;
// 	include ICMS_ROOT_PATH."/modules/tag/include/vars.php"; 	
 	

	
	 foreach(array_keys($items) as $cat_id){
		foreach(array_keys($items[$cat_id]) as $item_id){
		$item_obj =& $items_obj[$item_id];
	

if (empty($item_tag)) {
//	$tag_handler =& xoops_getmodulehandler("tag", "tag");
//	$tag_obj =& $tag_handler->get($item_id, "newbb");
//	$item_tag = $tag_obj->getVar("tag_term", "n");
$item_tag = $tag_desc ;
}		

			$items[$cat_id][$item_id] = array(
				"title"		=> $item_obj->getVar("subject"),
				"uid"		=> $item_obj->getVar("uid"),
				"link"		=> "viewtopic.php?topic_id={$item_id}&post_id={$cat_id}#forumpost{$cat_id}",
				"time"		=> $item_obj->getVar("post_time"),
//				"tags"		=> tag_parse_tag($item_obj->getVar("item_tags", "n")),
				"tags"		=> tag_parse_tag("{$item_tag}") ,
//				"content"	=> "" ,
//			   	"content"	=> "Das ist der Inhalt: {$themessage} oder {$forumpost}" ,				
				"content"	=> $item_obj->getVar("post_text"),
				);
		}

	}

	unset($items_obj);	

}



/**

 * Remove orphan tag-item links

 *

 * @return	boolean

 * 

 */

function newbb_tag_synchronization($mid)

{

	$item_handler =& xoops_getmodulehandler("post", "newbb");
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

    		"				WHERE {$item_handler->table}.approved > 0".

    		"			) ".

    		"		)";

    else:

    $sql = 	"	DELETE {$link_handler->table} FROM {$link_handler->table}".

    		"	LEFT JOIN {$item_handler->table} AS aa ON {$link_handler->table}.tag_itemid = aa.{$item_handler->keyName} ".

    		"	WHERE ".

    		"		tag_modid = {$mid}".

    		"		AND ".

    		"		( aa.{$item_handler->keyName} IS NULL".

    		"			OR aa.approved < 1".

    		"		)";

	endif;

    if (!$result = $link_handler->db->queryF($sql)) {

        //xoops_error($link_handler->db->error());

  	}

}

?>