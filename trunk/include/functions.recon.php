<?php
/**
 * Tag management for XOOPS
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id: functions.recon.php 19246 2010-05-10 10:19:05Z underdogg $
 * @package		module::tag
 */

if (!defined('ICMS_ROOT_PATH')){ exit(); }

defined("TAG_FUNCTIONS_INI") || include dirname(__FILE__)."/functions.ini.php";
define("TAG_FUNCTIONS_RECON_LOADED", TRUE);

IF(!defined("TAG_FUNCTIONS_RECON")):
define("TAG_FUNCTIONS_RECON", 1);

function tag_synchronization()
{
	$module_handler =& xoops_gethandler("module");
	$criteria = new CriteriaCompo(new Criteria("isactive", 1));
	$criteria->add(new Criteria("dirname", "('system', 'tag')", "NOT IN"));
	$modules_obj = $module_handler->getObjects($criteria, true);
	
	$link_handler =& xoops_getmodulehandler("link", "tag");
	$link_handler->deleteAll(new Criteria("tag_modid", "(".implode(", ", array_keys($modules_obj)).")", "NOT IN"), true);
	
	foreach(array_keys($modules_obj) as $mid){
		$dirname = $modules_obj[$mid]->getVar("dirname");
		if(!@include_once ICMS_ROOT_PATH."/modules/{$dirname}/include/plugin.tag.php"){
			if(!@include_once ICMS_ROOT_PATH."/modules/tag/plugin/{$dirname}.php"){
				continue;
			}
		}
		$func_tag = "{$dirname}_tag_synchronization";
		if(!function_exists($func_tag)){
			continue;
		}
		$res = $func_tag($mid);
	}
	
	tag_cleanOrphan();
	return true;
}

function tag_cleanOrphan()
{
	$tag_handler =& xoops_getmodulehandler("tag", "tag");
	
	/* clear item-tag links */
	if($tag_handler->mysql_major_version() >= 4):
    $sql = "DELETE FROM {$tag_handler->table_link}".
    		" WHERE ({$tag_handler->keyName} NOT IN ( SELECT DISTINCT {$tag_handler->keyName} FROM {$tag_handler->table}) )";
    else:
    $sql = 	"DELETE {$tag_handler->table_link} FROM {$tag_handler->table_link}".
    		" LEFT JOIN {$tag_handler->table} AS aa ON {$tag_handler->table_link}.{$tag_handler->keyName} = aa.{$tag_handler->keyName} ".
    		" WHERE (aa.{$tag_handler->keyName} IS NULL)";
	endif;
    if (!$result = $tag_handler->db->queryF($sql)) {
        //xoops_error($tag_handler->db->error());
    }
    
	/* remove empty stats-tag links */
    $sql = "DELETE FROM {$tag_handler->table_stats}".
    		" WHERE tag_count = 0";
    if (!$result = $tag_handler->db->queryF($sql)) {
        //xoops_error($tag_handler->db->error());
    }
    
	/* clear stats-tag links */
	if($tag_handler->mysql_major_version() >= 4):
    $sql = "DELETE FROM {$tag_handler->table_stats}".
    		" WHERE ({$tag_handler->keyName} NOT IN ( SELECT DISTINCT {$tag_handler->keyName} FROM {$tag_handler->table}) )";
    else:
    $sql = 	"DELETE {$tag_handler->table_stats} FROM {$tag_handler->table_stats}".
    		" LEFT JOIN {$tag_handler->table} AS aa ON {$tag_handler->table_stats}.{$tag_handler->keyName} = aa.{$tag_handler->keyName} ".
    		" WHERE (aa.{$tag_handler->keyName} IS NULL)";
	endif;
    if (!$result = $tag_handler->db->queryF($sql)) {
        //xoops_error($tag_handler->db->error());
    }
    
	if($tag_handler->mysql_major_version() >= 4):
    $sql =	"	DELETE FROM {$tag_handler->table_stats}".
    		"	WHERE NOT EXISTS (	SELECT * FROM {$tag_handler->table_link} ".
    		"						WHERE  {$tag_handler->table_link}.tag_modid={$tag_handler->table_stats}.tag_modid".
    		"						AND  {$tag_handler->table_link}.tag_catid={$tag_handler->table_stats}.tag_catid".
    		" 					)";
    else:
    $sql = 	"DELETE {$tag_handler->table_stats} FROM {$tag_handler->table_stats}".
    		" LEFT JOIN {$tag_handler->table_link} AS aa ON (".
    		"											{$tag_handler->table_stats}.{$tag_handler->keyName} = aa.{$tag_handler->keyName} ".
    		"											AND {$tag_handler->table_stats}.tag_modid = aa.tag_modid ".
    		"											AND {$tag_handler->table_stats}.tag_catid = aa.tag_catid ".
    		"										) ".
    		" WHERE (aa.tl_id IS NULL)";
	endif;
    if (!$result = $tag_handler->db->queryF($sql)) {
        //xoops_error($tag_handler->db->error());
    }
    
	/* clear empty tags */
	if($tag_handler->mysql_major_version() >= 4):
    $sql = "DELETE FROM {$tag_handler->table}".
    		" WHERE ({$tag_handler->keyName} NOT IN ( SELECT DISTINCT {$tag_handler->keyName} FROM {$tag_handler->table_link}) )";
    else:
    $sql = 	"DELETE {$tag_handler->table} FROM {$tag_handler->table}".
    		" LEFT JOIN {$tag_handler->table_link} AS aa ON {$tag_handler->table_link}.{$tag_handler->keyName} = aa.{$tag_handler->keyName} ".
    		" WHERE (aa.tl_id IS NULL)";
	endif;
    if (!$result = $tag_handler->db->queryF($sql)) {
        //xoops_error($tag_handler->db->error());
    }
    
    return true;
}

endif;
?>