<?php
/**
* Admin page to manage categories
*
* List, add, edit and delete category objects
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

/**
 * Edit a Category
 *
 * @param int $category_id Categoryid to be edited
*/
function editcategory($category_id = 0)
{
	global $imtagging_category_handler, $icmsModule, $icmsAdminTpl;

	$categoryObj = $imtagging_category_handler->get($category_id);

	if (!$categoryObj->isNew()){

		$icmsModule->displayAdminMenu(0, _AM_IMTAGGING_CATEGORIES . " > " . _CO_ICMS_EDITING);
		$sform = $categoryObj->getForm(_AM_IMTAGGING_CATEGORY_EDIT, 'addcategory');
		$sform->assign($icmsAdminTpl);

	} else {
		$icmsModule->displayAdminMenu(0, _AM_IMTAGGING_CATEGORIES . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $categoryObj->getForm(_AM_IMTAGGING_CATEGORY_CREATE, 'addcategory');
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display('db:imtagging_admin_category.html');
}

include_once("admin_header.php");
include_once ICMS_ROOT_PATH."/kernel/icmspersistabletreetable.php";

$imtagging_category_handler = icms_getModulehandler('category');
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('mod','changedField','addcategory','del','view','');

if (isset($_GET['op'])) $clean_op = htmlentities($_GET['op']);
if (isset($_POST['op'])) $clean_op = htmlentities($_POST['op']);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0 ;

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

  		editcategory($clean_category_id);
  		break;
  	case "addcategory":
        include_once ICMS_ROOT_PATH."/kernel/icmspersistablecontroller.php";
        $controller = new IcmsPersistableController($imtagging_category_handler);
  		$controller->storeFromDefaultForm(_AM_IMTAGGING_CATEGORY_CREATED, _AM_IMTAGGING_CATEGORY_MODIFIED);

  		break;

  	case "del":
  	    include_once ICMS_ROOT_PATH."/kernel/icmspersistablecontroller.php";
        $controller = new IcmsPersistableController($imtagging_category_handler);
  		$controller->handleObjectDeletion();

  		break;

  	case "view" :
  		include_once ICMS_ROOT_PATH."/kernel/icmspersistablesingleview.php";

  		$imtagging_category_link_handler = icms_getModulehandler('category_link');

  		$categoryObj = $imtagging_category_handler->get($clean_category_id);

  		icms_cp_header();
		$icmsModule->displayAdminMenu(0, _AM_IMTAGGING_CATEGORY_VIEW . ' > ' . $categoryObj->getVar('category_title'));

  		$icmsAdminTpl->assign('imtagging_category_singleobject', $categoryObj->displaySingleObject());

  		$criteria = new CriteriaCompo();
  		$criteria->add(new Criteria('category_link_cid', $clean_category_id));

  		$objectTable = new IcmsPersistableTable($imtagging_category_link_handler, $criteria);
  		$objectTable->addColumn(new IcmsPersistableColumn('category_link_iid'));
  		$objectTable->addColumn(new IcmsPersistableColumn('category_link_mid', _GLOBAL_LEFT, '200'));

  		$icmsAdminTpl->assign('imtagging_category_link_table', $objectTable->fetch());

  		$icmsAdminTpl->display('db:imtagging_admin_category.html');

  		break;

  	default:

  		icms_cp_header();

  		$icmsModule->displayAdminMenu(0, _AM_IMTAGGING_CATEGORIES);

  		$objectTable = new IcmsPersistableTreeTable($imtagging_category_handler);
  		$objectTable->addColumn(new IcmsPersistableColumn('category_title', _GLOBAL_LEFT, '200', 'getAdminViewItemLink'));
  		$objectTable->addColumn(new IcmsPersistableColumn('category_description'));

  		$objectTable->addIntroButton('addcategory', 'category.php?op=mod', _AM_IMTAGGING_CATEGORY_CREATE);
  		$objectTable->addQuickSearch(array('category_title', 'category_description'));

  		$icmsAdminTpl->assign('imtagging_category_table', $objectTable->fetch());

  		$icmsAdminTpl->display('db:imtagging_admin_category.html');
  		break;
  }
  icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */
?>