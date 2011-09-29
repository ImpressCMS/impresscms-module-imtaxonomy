<?php
/**
* Admin page to manage tags
*
* List, add, edit and delete tag objects
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

/**
 * Edit a Tag
 *
 * @param int $tag_id Tagid to be edited
*/
function edittag($tag_id = 0)
{
	global $imtagging_tag_handler, $icmsModule, $icmsUser, $icmsAdminTpl;

	$tagObj = $imtagging_tag_handler->get($tag_id);

	if (!$tagObj->isNew()){
		$icmsModule->displayAdminMenu(1, _AM_IMTAGGING_TAGS . " > " . _CO_ICMS_EDITING);
		$sform = $tagObj->getForm(_AM_IMTAGGING_TAG_EDIT, 'addtag');
		$sform->assign($icmsAdminTpl);

	} else {
		$tagObj->setVar('tag_uid', $icmsUser->uid());
		$icmsModule->displayAdminMenu(1, _AM_IMTAGGING_TAGS . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $tagObj->getForm(_AM_IMTAGGING_TAG_CREATE, 'addtag');
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display('db:imtagging_admin_tag.html');
}

include_once("admin_header.php");

$imtagging_tag_handler = icms_getModulehandler('tag');
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('mod','changedField','addtag','del','view','');

if (isset($_GET['op'])) $clean_op = htmlentities($_GET['op']);
if (isset($_POST['op'])) $clean_op = htmlentities($_POST['op']);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_tag_id = isset($_GET['tag_id']) ? (int) $_GET['tag_id'] : 0 ;

/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
*/
if (in_array($clean_op,$valid_op,true)){
  switch ($clean_op) {
  	case "mod":
  	case "changedField":

  		icms_cp_header();

  		edittag($clean_tag_id);
  		break;
  	case "addtag":
          include_once ICMS_ROOT_PATH."/kernel/icmspersistablecontroller.php";
          $controller = new IcmsPersistableController($imtagging_tag_handler);
  		$controller->storeFromDefaultForm(_AM_IMTAGGING_TAG_CREATED, _AM_IMTAGGING_TAG_MODIFIED);

  		break;

  	case "del":
  	    include_once ICMS_ROOT_PATH."/kernel/icmspersistablecontroller.php";
          $controller = new IcmsPersistableController($imtagging_tag_handler);
  		$controller->handleObjectDeletion();

  		break;

  	case "view" :
  		$tagObj = $imtagging_tag_handler->get($clean_tag_id);

  		smart_icms_cp_header();
  		smart_adminMenu(1, _AM_IMTAGGING_TAG_VIEW . ' > ' . $tagObj->getVar('tag_title'));

  		smart_collapsableBar('tagview', $tagObj->getVar('tag_title') . $tagObj->getEditItemLink(), _AM_IMTAGGING_TAG_VIEW_DSC);

  		$tagObj->displaySingleObject();

  		smart_close_collapsable('tagview');

  		smart_collapsableBar('tagview_tags', _AM_IMTAGGING_TAGS, _AM_IMTAGGING_TAGS_IN_TAG_DSC);

  		$criteria = new CriteriaCompo();
  		$criteria->add(new Criteria('tag_id', $clean_tag_id));

  		$objectTable = new SmartObjectTable($imtagging_tag_handler, $criteria);
  		$objectTable->addColumn(new SmartObjectColumn('tag_date', _GLOBAL_LEFT, 150));
  		$objectTable->addColumn(new SmartObjectColumn('tag_message'));
  		$objectTable->addColumn(new SmartObjectColumn('tag_uid', _GLOBAL_LEFT, 150));

  		$objectTable->addIntroButton('addtag', 'tag.php?op=mod&tag_id=' . $clean_tag_id, _AM_IMTAGGING_TAG_CREATE);

  		$objectTable->render();

  		smart_close_collapsable('tagview_tags');

  		break;

  	default:

  		icms_cp_header();

  		$icmsModule->displayAdminMenu(2, _AM_IMTAGGING_TAGS);

  		include_once ICMS_ROOT_PATH."/kernel/icmspersistabletable.php";
  		$objectTable = new IcmsPersistableTable($imtagging_tag_handler);
  		$objectTable->addColumn(new IcmsPersistableColumn('tag_title', _GLOBAL_LEFT));
  		$objectTable->addColumn(new IcmsPersistableColumn('tag_created_date', 'center', 150));
  		$objectTable->addColumn(new IcmsPersistableColumn('tag_uid', 'center', 150));

  		$objectTable->addIntroButton('addtag', 'tag.php?op=mod', _AM_IMTAGGING_TAG_CREATE);
  		$objectTable->addQuickSearch(array('tag_title', 'tag_description'));

  		$icmsAdminTpl->assign('imtagging_tag_table', $objectTable->fetch());

  		$icmsAdminTpl->display('db:imtagging_admin_tag.html');
  		break;
  }
  icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */
?>