<?php
/**
 * Tag management for XOOPS
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id: syn.tag.php 19246 2010-05-10 10:19:05Z underdogg $
 * @package		module::tag
 */
include('header.php');
require_once(ICMS_ROOT_PATH . "/class/xoopsformloader.php");

xoops_cp_header();

include ICMS_ROOT_PATH."/modules/tag/include/vars.php";
loadModuleAdminMenu(2);

$limit = 10;
$modid = intval( @$_GET['modid'] );
$start = intval( @$_GET['start'] );
$limit = isset($_GET['limit']) ? intval( $_GET['limit'] ) : 100;

$sql  = "	SELECT tag_modid, COUNT(DISTINCT tag_id) AS count_tag";
$sql .= "	FROM ".$xoopsDB->prefix("tag_link");
$sql .= "	GROUP BY tag_modid";
$counts_module = array();
if( ($result = $xoopsDB->query($sql)) == false){
    xoops_error($xoopsDB->error());
}else{
	while ($myrow = $xoopsDB->fetchArray($result)) {
	    $counts_module[$myrow["tag_modid"]] = $myrow["count_tag"];
	}
	if(!empty($counts_module)) {
		$module_handler =& xoops_gethandler("module");
		$module_list = $module_handler->getList(new Criteria("mid", "(".implode(", ", array_keys($counts_module)).")", "IN"));
	}
}

$opform = new XoopsSimpleForm('', 'moduleform', xoops_getenv("PHP_SELF"), "get");
$tray = new XoopsFormElementTray('');
$mod_select = new XoopsFormSelect(_SELECT, 'modid', $modid);
$mod_select->addOption(-1, TAG_AM_GLOBAL);
$mod_select->addOption(0, TAG_AM_ALL);
foreach($module_list as $module => $module_name){
	$mod_select->addOption($module, $module_name." (".$counts_module[$module].")");
}
$tray->addElement($mod_select);
$num_select = new XoopsFormSelect(TAG_AM_NUM, 'limit', $limit);
foreach(array(10, 50, 100, 500) as $_num){
	$num_select->addOption($_num);
}
$num_select->addOption(0, _ALL);
$tray->addElement($num_select);
$tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$tray->addElement(new XoopsFormHidden("start", $start));
$opform->addElement($tray);
$opform->display();


if( isset($_GET['start']) ) {

	$tag_handler =& xoops_getmodulehandler("tag", $xoopsModule->getVar("dirname"));
	
	$criteria = new CriteriaCompo();
	//$criteria->setSort("time");
	//$criteria->setOrder("DESC");
	$criteria->setStart($start);
	$criteria->setLimit($limit);
	if($modid > 0){
		$criteria->add( new Criteria("l.tag_modid", $modid) );
	}
	$tags = $tag_handler->getByLimit($criteria, false);
	if(empty($tags)) {
		echo "<p><h2>".TAG_AM_FINISHED."</h2></p>";
	}else{
		
		foreach(array_keys($tags) as $tag_id) {
			$tag_handler->update_stats($tag_id, ( $modid == -1 ) ? 0 : $tags[$tag_id]["modid"]);
		}
		redirect_header("syn.tag.php?modid={$modid}&amp;start=".($start+$limit)."&amp;limit={$limit}", 2, TAG_AM_IN_PROCESS);
	}
}

xoops_cp_footer();
?>