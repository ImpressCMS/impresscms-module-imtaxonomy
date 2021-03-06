<?php
/**
 * Tag management for XOOPS
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		module::tag
 */
include('header.php');

xoops_cp_header();

include ICMS_ROOT_PATH."/modules/tag/include/vars.php";
loadModuleAdminMenu(0);

$tag_handler =& xoops_getmodulehandler("tag", $xoopsModule->getVar("dirname"));
$count_tag = $tag_handler->getCount();

$count_item = 0;   
$sql  = "	SELECT COUNT(DISTINCT tl_id) FROM ".$xoopsDB->prefix("tag_link");
if( ($result = $xoopsDB->query($sql)) == false){
    xoops_error($xoopsDB->error());
}else{
	list($count_item) = $xoopsDB->fetchRow($result);
}

$sql  = "	SELECT tag_modid, SUM(tag_count) AS count_item, COUNT(DISTINCT tag_id) AS count_tag";
$sql .= "	FROM ".$xoopsDB->prefix("tag_stats");
$sql .= "	GROUP BY tag_modid";
$counts_module = array();
if( ($result = $xoopsDB->query($sql)) == false){
    xoops_error($xoopsDB->error());
}else{
	while ($myrow = $xoopsDB->fetchArray($result)) {
	    $counts_module[$myrow["tag_modid"]] = array("count_item" => $myrow["count_item"], "count_tag" => $myrow["count_tag"]);
	}
	if(!empty($counts_module)) {
		$module_handler =& xoops_gethandler("module");
		$module_list = $module_handler->getList(new Criteria("mid", "(".implode(", ", array_keys($counts_module)).")", "IN"));
	}
}

$output= "
	<style type=\"text/css\">
	label,text {
		display: block;
		float: left;
		margin-bottom: 2px;
	}
	label {
		text-align: right;
		width: 150px;
		padding-right: 20px;
	}
	br {
		clear: left;
	}
	</style>
";

$output .= "<fieldset><legend style='font-weight: bold; color: #900;'>" . TAG_AM_STATS . "</legend>";
$output .= "<div style='padding: 8px;'>";
$output .= "<label><strong>" . TAG_AM_COUNT_TAG . ":</strong></label><text>" . $count_tag . "</text><br />";
$output .= "<label><strong>" . TAG_AM_COUNT_ITEM . ":</strong></label><text>" . $count_item . "</text><br />";
$output .= "</div>";
$output .= "<div style='padding: 8px;'>";
$output .= "<label><strong>" . TAG_AM_COUNT_MODULE . "</strong>:</label><text>" . TAG_AM_COUNT_TAG . " - " . TAG_AM_COUNT_ITEM . "</text><br />";
foreach($counts_module as $module => $count){
	$output .= "<label>" . $module_list[$module] . ":</label><text>" . $count["count_tag"] . " - " . $count["count_item"] . "  [<a href=\"".ICMS_URL."/modules/tag/admin/admin.tag.php?modid={$module}\">".TAG_AM_EDIT."</a>]  [<a href=\"".ICMS_URL."/modules/tag/admin/syn.tag.php?modid={$module}\">".TAG_AM_SYNCHRONIZATION."</a>] </text><br />";
}
$output .= "</div>";
$output .= "</fieldset>";

echo $output;
xoops_cp_footer();
?>