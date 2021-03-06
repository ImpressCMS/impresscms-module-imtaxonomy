<?php
/**
 * Tag management for XOOPS
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id: list.tag.php 19246 2010-05-10 10:19:05Z underdogg $
 * @package		module::tag
 */
include dirname(__FILE__)."/header.php";

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

if(tag_parse_args($args_num, $args, $args_str)){
	$args["modid"]	= !empty($args["modid"]) ? $args["modid"] : @$args_num[0];
	$args["catid"]	= !empty($args["catid"]) ? $args["catid"] : @$args_num[1];
	$args["start"]	= !empty($args["start"]) ? $args["start"] : @$args_num[2];
}

$modid = intval( empty($_GET["modid"]) ? @$args["modid"] : $_GET["modid"] );
$catid = intval( empty($_GET["catid"]) ? @$args["catid"] : $_GET["catid"] );
$start = intval( empty($_GET["start"]) ? @$args["start"] : $_GET["start"] );
$sort	= "";
$order	= "";

if(empty($modid) && is_object($GLOBALS["xoopsModule"]) && "tag" != $GLOBALS["xoopsModule"]->getVar("dirname")){
	$modid = $GLOBALS["xoopsModule"]->getVar("mid");
}

if(!empty($tag_desc)){
	$page_title = $tag_desc;
}else{
	$module_name = ("tag" == $xoopsModule->getVar("dirname")) ? $xoopsConfig["sitename"] : $xoopsModule->getVar("name");
	$page_title = sprintf(TAG_MD_TAGLIST, $module_name);
}
$xoopsOption["template_main"] = "tag_list.html";
$xoopsOption["xoops_pagetitle"] = strip_tags($page_title);
include ICMS_ROOT_PATH."/header.php";

$mode_display = empty($mode_display) ? @$_GET["mode"] : $mode_display;
switch(strtolower($mode_display)){
	case "list":
		$mode_display = "list";
		$sort	= "count";
		$order	= "DESC";
		$limit = empty($tag_config["limit_tag_list"]) ? 10 : $tag_config["limit_tag"];
		break;
	case "cloud":
	default:
		$mode_display = "cloud";
		$sort	= "count";
		$order	= "DESC";
		$limit = empty($tag_config["limit_tag_could"]) ? 100 : $tag_config["limit_tag"];
		break;
}

$tag_handler =& xoops_getmodulehandler("tag", "tag");
$tag_config = tag_load_config();
tag_define_url_delimiter();

$criteria = new CriteriaCompo();
$criteria->setSort($sort);
$criteria->setOrder($order);
$criteria->setStart($start);
$criteria->setLimit($limit);
$criteria->add( new Criteria("o.tag_status", 0) );
if(!empty($modid)){
	$criteria->add( new Criteria("l.tag_modid", $modid) );
	if($catid >= 0){
		$criteria->add( new Criteria("l.tag_catid", $catid) );
	}
}
//$tags = $tag_handler->getByLimit($limit, $start, "count", "DESC", $modid, $catid); // Limist, start, sort, order, modid, catid
$tags = $tag_handler->getByLimit($criteria);


$count_max = 0;
$count_min = 0;
$tags_term = array();
foreach(array_keys($tags) as $key){
	if($tags[$key]["count"] > $count_max) $count_max = $tags[$key]["count"];
	if($tags[$key]["count"] < $count_min) $count_min = $tags[$key]["count"];
	$tags_term[] = strtolower($tags[$key]["term"]);
}
$count_interval = $count_max - $count_min;

$font_max = $tag_config["font_max"];
$font_min = $tag_config["font_min"];
$font_ratio = ($count_interval) ? ($font_max - $font_min) / $count_interval : 1;
array_multisort($tags_term, SORT_ASC, $tags);

$tags_data = array();
foreach(array_keys($tags) as $key) {
	$tags_data[] = array(
					/*
					 * Font-size = ((tag.count - count.min) * (font.max - font.min) / (count.max - count.min) ) * 100%
					 */
					"id"	=> $tags[$key]["id"],
					"level"	=> ($count_interval) ? ($tags[$key]["count"] - $count_min) * $font_ratio + $font_min : 100,
					"term"	=> $tags[$key]["term"],
					"count"	=> $tags[$key]["count"],
					);
}
unset($tags, $tags_term);

if (  !empty($start) || count($tags_data) >= $limit) {
	$count_tag = $tag_handler->getCount($criteria); // modid, catid

	if(strtolower($mode_display) == "list"){
		include(ICMS_ROOT_PATH."/class/pagenav.php");
		$nav = new XoopsPageNav($count_tag, $limit, $start, "start", "catid={$catid}&amp;mode={$mode_display}");
		$pagenav = $nav->renderNav(4);
	}else{
		$pagenav = "<a href=\"".xoops_getEnv("PHP_SELF")."?catid={$catid}&amp;mode={$mode_display}\">"._MORE."</a>";
	}
} else {
	$pagenav = "";
}

$xoopsTpl -> assign("lang_jumpto", 		TAG_MD_JUMPTO);

$xoopsTpl -> assign("tag_page_title",	$page_title);
$xoopsTpl -> assign_by_ref("tags",		$tags_data);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";
?>