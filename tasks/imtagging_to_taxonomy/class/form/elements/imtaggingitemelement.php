<?php
/**
* Creating a selectbox with available item
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

class ImtaggingItemElement extends XoopsFormSelect {
    function ImtaggingItemElement($object, $key) {
    	$icms_module = $object->getCategory_linkModule();
		$this->XoopsFormSelect( $object->vars[$key]['form_caption'], $key, $object->getVar($key, 'e') );
        $icms_module->loadInfo($icms_module->dirname());
        $object_items = $icms_module->modinfo['object_items'];
        foreach($object_items as $v) {
        	$optionArray[$v] = $v;
        }
        $this->addOptionArray(array(0=>_CO_IMTAGGING_CATEGORY_LINK_ITEM_SELECT) +$optionArray);
    }
}
?>