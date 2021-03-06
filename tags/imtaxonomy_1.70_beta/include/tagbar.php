<?php
/**
 * Tag management
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id: tagbar.php 19246 2010-05-10 10:19:05Z underdogg $
 * @package		module::tag
 */
 
if (!defined('ICMS_ROOT_PATH') || !is_object($GLOBALS["xoopsModule"])) {
	die();
}

/**
 * Display tag list
 *
 * @var		array	$tags	array of tag string
 * OR
 * @var		integer	$itemid
 * @var		integer	$catid
 * @var		integer	$modid
 *
 * @return 	array	(subject language, array of linked tags)
 */
function tagBar($tags, $catid = 0, $modid = 0) {
	static $loaded, $delimiter;
	
	if(empty($tags)) return array();
	
	if(!isset($loaded)):
	include ICMS_ROOT_PATH."/modules/tag/include/vars.php";
	include_once ICMS_ROOT_PATH."/modules/tag/include/functions.php";
	tag_define_url_delimiter();
	if(!is_object($GLOBALS["xoopsModule"]) || "tag" != $GLOBALS["xoopsModule"]->getVar("dirname")){
		if(function_exists("xoops_load_lang_file")){
			xoops_load_lang_file("main", "tag");
		}else{
			$path = ICMS_ROOT_PATH . "/modules/tag/language";
			if ( !@include_once( "{$path}/{$GLOBALS['xoopsConfig']['language']}/main.php" ) ) {
				$ret = @include_once( "{$path}/english/main.php" );
			}
		}
	}
	$loaded		= 1;
	$delimiter	= @file_exists(ICMS_ROOT_PATH."/modules/tag/images/delimiter.gif") ? "<img src=\"" .ICMS_URL."/modules/tag/images/delimiter.gif\" alt=\"\" />" : "<img src=\"" .ICMS_URL."/images/pointer.gif\" alt=\"\" />";
	endif;
	
	// itemid
	if(is_numeric($tags)){
		if(empty($modid) && is_object($GLOBALS["xoopsModule"])){
			$modid = $GLOBALS["xoopsModule"]->getVar("mid");
		}
		$tag_handler =& xoops_getmodulehandler("tag", "tag");
		if(!$tags = $tag_handler->getByItem($tags, $modid, $catid)) {
			return array();
		}
		
	// if ready, do nothing
	}elseif(is_array($tags)) {
		
	// parse
	}elseif(!$tags = tag_parse_tag($tags)) {
		return array();
	}
	$tags_data = array();
	foreach($tags as $tag){
		$tags_data[] = "<a href=\"".ICMS_URL."/modules/tag/view.tag.php".URL_DELIMITER.urlencode($tag)."\" title=\"".htmlspecialchars($tag)."\">".htmlspecialchars($tag)."</a>";
	}
	return array(
			"title"		=> TAG_MD_TAGS, 
			"delimiter"	=> $delimiter, 
			"tags"		=> $tags_data);
}
?>