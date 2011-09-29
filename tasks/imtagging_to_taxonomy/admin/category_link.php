<?php
/**
* Admin page to manage category_links
*
* List, add, edit and delete category_link objects
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

/**
 * Edit a Category_link
 *
 * @param int $category_link_id Category_linkid to be edited
*/
function editcategory_link($category_link_id = 0)
{
	global $imtagging_category_link_handler, $icmsModule, $icmsAdminTpl;

	$category_linkObj = $imtagging_category_link_handler->get($category_link_id);
	$category_linkObj->hideFieldFromForm(array('category_link_item', 'category_link_iid'));

	if (isset($_POST['op'])) {
		$controller = new IcmsPersistableController($imtagging_category_link_handler);
		$controller->postDataToObject($category_linkObj);
		if ($_POST['op'] == 'changedField') {

			switch($_POST['changedField']) {
				case 'category_link_mid' :
					if ($category_linkObj->getVar('category_link_mid', 'e')) {
						$category_linkObj->showFieldOnForm('category_link_item');
						$category_linkObj->setVar('category_link_iid', 0);
					}
				break;

				case 'category_link_item' :
					if ($category_linkObj->getVar('category_link_item', 'e')) {
						$category_linkObj->showFieldOnForm(array('category_link_item', 'category_link_iid'));
					}
				break;
			}
		}
	}

	if (!$category_linkObj->isNew()){
		$icmsModule->displayAdminMenu(1, _AM_IMTAGGING_CATEGORIES . " > " . _CO_ICMS_EDITING);

		if (!isset($_POST['changedField'])) {
			$category_linkObj->showFieldOnForm(array('category_link_item', 'category_link_iid'));
		}

		$sform = $category_linkObj->getForm(_AM_IMTAGGING_CATEGORY_LINK_EDIT, 'addcategory_link');
		$sform->assign($icmsAdminTpl);

	} else {
		$icmsModule->displayAdminMenu(0, _AM_IMTAGGING_CATEGORIES . " > " . _CO_ICMS_CREATINGNEW);


		$sform = $category_linkObj->getForm(_AM_IMTAGGING_CATEGORY_LINK_CREATE, 'addcategory_link');
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display('db:imtagging_admin_category_link.html');
}

include_once("admin_header.php");
include_once ICMS_ROOT_PATH."/kernel/icmspersistablecontroller.php";

$imtagging_category_link_handler = icms_getModulehandler('category_link');
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('mod','changedField','addcategory_link','del','view','');

if (isset($_GET['op'])) $clean_op = htmlentities($_GET['op']);
if (isset($_POST['op'])) $clean_op = htmlentities($_POST['op']);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_category_link_id = isset($_GET['category_link_id']) ? (int) $_GET['category_link_id'] : 0 ;

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

  		editcategory_link($clean_category_link_id);
  		break;
  	case "addcategory_link":

        $controller = new IcmsPersistableController($imtagging_category_link_handler);
  		$controller->storeFromDefaultForm(_AM_IMTAGGING_CATEGORY_LINK_CREATED, _AM_IMTAGGING_CATEGORY_LINK_MODIFIED);

  		break;

  	case "del":
        $controller = new IcmsPersistableController($imtagging_category_link_handler);
  		$controller->handleObjectDeletion();

  		break;

  	default:

  		icms_cp_header();

  		$icmsModule->displayAdminMenu(1, _AM_IMTAGGING_CATEGORIES);

  		include_once ICMS_ROOT_PATH."/kernel/icmspersistabletable.php";
  		$objectTable = new IcmsPersistableTable($imtagging_category_link_handler);
  		$objectTable->addColumn(new IcmsPersistableColumn('category_link_cid', _GLOBAL_LEFT, '200'));
  		$objectTable->addColumn(new IcmsPersistableColumn('category_link_mid'));
  		$objectTable->addColumn(new IcmsPersistableColumn('category_link_item'));
  		$objectTable->addColumn(new IcmsPersistableColumn('category_link_iid'));

  		$objectTable->addIntroButton('addcategory_link', 'category_link.php?op=mod', _AM_IMTAGGING_CATEGORY_LINK_CREATE);

  		$icmsAdminTpl->assign('imtagging_category_link_table', $objectTable->fetch());

  		$icmsAdminTpl->display('db:imtagging_admin_category_link.html');
  		break;
  }
  icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */
?>