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

class ImtaggingCategoryCheckboxElement extends XoopsFormCheckBox {
    function render() {
    	$ret = '<div id="imtagging_categories_container">';
    	$ret .= parent::render();
    	$ret .= '</div>';
    	return $ret;
    }
}
?>