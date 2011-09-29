<?php
/**
* Tag page
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @package imtagging
* @version		$Id$
*/

/**
 * Edit a Tag
 *
 * @param object $tagObj ImtaggingTag object to be edited
*/
function edittag($tagObj)
{
	global $imtagging_tag_handler, $icmsTpl, $icmsUser;

	if (!$tagObj->isNew()){
		if (!$tagObj->userCanEditAndDelete()) {
			redirect_header($tagObj->getItemLink(true), 3, _NOPERM);
		}
		$tagObj->hideFieldFromForm(array('tag_published_date', 'tag_uid', 'meta_keywords', 'meta_description', 'short_url'));
		$sform = $tagObj->getSecureForm(_MD_IMTAGGING_TAG_EDIT, 'addtag');
		$sform->assign($icmsTpl, 'imtagging_tagform');
		$icmsTpl->assign('imtagging_category_path', $tagObj->getVar('tag_title') . ' > ' . _EDIT);
	} else {
		if (!$imtagging_tag_handler->userCanSubmit()) {
			redirect_header(IMTAGGING_URL, 3, _NOPERM);
		}
		$tagObj->setVar('tag_uid', $icmsUser->uid());
		$tagObj->setVar('tag_published_date', time());
		$tagObj->hideFieldFromForm(array('tag_published_date', 'tag_uid', 'meta_keywords', 'meta_description', 'short_url'));
		$sform = $tagObj->getSecureForm(_MD_IMTAGGING_TAG_SUBMIT, 'addtag');
		$sform->assign($icmsTpl, 'imtagging_tagform');
		$icmsTpl->assign('imtagging_category_path', _SUBMIT);
	}
}

include_once 'header.php';

$xoopsOption['template_main'] = 'imtagging_tag.html';
include_once ICMS_ROOT_PATH . '/header.php';

$imtagging_tag_handler = icms_getModulehandler('tag');

/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';

if (isset($_GET['op'])) $clean_op = $_GET['op'];
if (isset($_POST['op'])) $clean_op = $_POST['op'];

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_tag_id = isset($_GET['tag_id']) ? intval($_GET['tag_id']) : 0 ;
$tagObj = $imtagging_tag_handler->get($clean_tag_id);

/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('mod','addtag','del','');
/**
 * Only proceed if the supplied operation is a valid operation
 */
if (in_array($clean_op,$valid_op,true)){
  switch ($clean_op) {
	case "mod":
  		if ($clean_tag_id > 0 && $tagObj->isNew()) {
			redirect_header(icms_getPreviousPage('index.php'), 3, _NOPERM);
		}
		edittag($tagObj);
		break;

	case "addtag":
        if (!$xoopsSecurity->check()) {
        	redirect_header(icms_getPreviousPage('index.php'), 3, _MD_IMTAGGING_SECURITY_CHECK_FAILED . implode('<br />', $xoopsSecurity->getErrors()));
        }
          include_once ICMS_ROOT_PATH.'/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($imtagging_tag_handler);
		$controller->storeFromDefaultForm(_MD_IMTAGGING_TAG_CREATED, _MD_IMTAGGING_TAG_MODIFIED);
		break;

	case "del":
		if (!$tagObj->userCanEditAndDelete()) {
			redirect_header($tagObj->getItemLink(true), 3, _NOPERM);
		}
		if (isset($_POST['confirm'])) {
		    if (!$xoopsSecurity->check()) {
		    	redirect_header($impresscms->urls['previouspage'], 3, _MD_IMTAGGING_SECURITY_CHECK_FAILED . implode('<br />', $xoopsSecurity->getErrors()));
		    }
		}
  	    include_once ICMS_ROOT_PATH.'/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($imtagging_tag_handler);
		$controller->handleObjectDeletionFromUserSide();
		$icmsTpl->assign('imtagging_category_path', $tagObj->getVar('tag_title') . ' > ' . _DELETE);

		break;

	default:
		if ($tagObj && !$tagObj->isNew() && $tagObj->accessGranted()) {
			$icmsTpl->assign('imtagging_tag', $tagObj->toArray());
			$icmsTpl->assign('imtagging_category_path', $tagObj->getVar('tag_title'));
		} else {
			redirect_header(IMTAGGING_URL, 3, _NOPERM);
		}

		if ($icmsModuleConfig['com_rule'] && $tagObj->getVar('tag_cancomment')) {
			$icmsTpl->assign('imtagging_tag_comment', true);
  			include_once ICMS_ROOT_PATH . '/include/comment_view.php';
		}
		break;
}

/**
 * Generating meta information for this page
 */
$icms_metagen = new IcmsMetagen($tagObj->getVar('tag_title'), $tagObj->getVar('meta_keywords','n'), $tagObj->getVar('meta_description', 'n'));
$icms_metagen->createMetaTags();

}
$icmsTpl->assign('imtagging_module_home', imtagging_getModuleName(true, true));
include_once 'footer.php';
?>