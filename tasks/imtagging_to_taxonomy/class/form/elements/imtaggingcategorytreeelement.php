<?php
/**
* Creating a parent category select box
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

include_once(ICMS_ROOT_PATH . "/modules/imtagging/class/form/elements/imtaggingtrayelement.php");

class ImtaggingCategoryTreeElement extends ImtaggingTrayElement {
    function ImtaggingCategoryTreeElement($object, $key) {

		// Creating Tray
		$var = $object->vars[$key];
		$this->XoopsFormElementTray($var['form_caption'], '', $key);

		// Creating check boxes

        $itemHandler = isset($object->controls[$key]['itemHandler']) ? $object->controls[$key]['itemHandler'] : 'category';
        $module = isset($object->controls[$key]['module']) ? $object->controls[$key]['module'] : $object->handler->_moduleName;
        $userside = isset($object->controls[$key]['userside']) ? $object->controls[$key]['userside'] : false;
		$category_handler = icms_getModulehandler('category', $module);

		$category_title_field = $category_handler->identifierName;
    	$criteria = new CriteriaCompo();
        $criteria->setSort("weight, " . $category_title_field);

        $categories = $category_handler->getObjects($criteria);

        include_once(ICMS_ROOT_PATH . "/modules/imtagging/class/icmspersistabletree.php");
        include_once(ICMS_ROOT_PATH . "/modules/imtagging/class/form/elements/imtaggingcategorycheckboxelement.php");
        $mytree = new IcmsPersistableTree($categories, "category_id", "category_pid");
		$options = $this->getOptionArray($mytree, $category_title_field, 0, "", $ret);

        $check_box = new ImtaggingCategoryCheckboxElement(null, $key, $object->getVar($key, 'e'), '<br />');
        $ret = array();
        $check_box->addOptionArray($options);
        $this->addElement($check_box);

        // if userside we will use a simple select box
        if (!$userside) {
        	// if admin side then we will use the full blown categories control

			// on the fly new category creation
			$new_category_label = new XoopsFormLabel(null, '<a href="#" onclick="jQuery(\'#new_category_tray\').toggle()">' . _CO_IMTAGGING_CATEGORY_ADD . '</a><br />');
			$this->addElement($new_category_label);

			// new category container
			$new_category_tray = new ImtaggingTrayElement(null, null, 'new_category_tray');

			// new category title
			$category_text = new XoopsFormText(null, 'new_category_title', 40, 255);
			$new_category_tray->addElement($category_text);

			// parent select box
			$parent_cateory_select = new XoopsFormSelect(null, 'category_pid', 0);
			$parent_options = array(0=>_CO_IMTAGGING_CATEGORY_CATEGORY_PID);
			if (is_array($options)){
				foreach ($options as $k=>$v) {
					$parent_options[$k] = $v;
				}
			}
			$parent_cateory_select->addOptionArray($parent_options);
			$new_category_tray->addElement($parent_cateory_select);

			// new category button
			$butt_create = new XoopsFormButton('', 'create_button', _CO_ICMS_CREATE, 'button');
			$butt_create->setExtra('onclick="imtaggingAddCategory();"');
			$new_category_tray->addElement($butt_create);

			$this->addElement($new_category_tray);
        }
    }
    /**
     * Get options for a category select with hierarchy (recursive)
     *
     * @param XoopsObjectTree $tree
     * @param string $fieldName
     * @param int $key
     * @param string $prefix_curr
     * @param array $ret
     *
     * @return array
     */
    function getOptionArray($tree, $fieldName, $key, $prefix_curr = "", &$ret) {

        if ($key > 0) {
            $value = $tree->_tree[$key]['obj']->getVar($tree->_myId);
			$ret[$key] = $prefix_curr.$tree->_tree[$key]['obj']->getVar($fieldName);
            $prefix_curr .= "-";
        }
        if (isset($tree->_tree[$key]['child']) && !empty($tree->_tree[$key]['child'])) {
            foreach ($tree->_tree[$key]['child'] as $childkey) {
                $this->getOptionArray($tree, $fieldName, $childkey, $prefix_curr, $ret);
            }
        }
        return $ret;
    }
}
?>