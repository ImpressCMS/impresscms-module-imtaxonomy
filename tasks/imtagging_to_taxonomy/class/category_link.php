<?php
/**
* Classes responsible for managing imTagging category_link link objects
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

// including the IcmsPersistabelSeoObject
include_once ICMS_ROOT_PATH."/kernel/icmspersistableseoobject.php";

class ImtaggingCategory_link extends IcmsPersistableObject {

    /**
     * Constructor
     *
     * @param object $handler ImtaggingCategory_linkHandler object
     */
    public function __construct(&$handler){
    	global $icmsConfig;

    	$this->IcmsPersistableObject($handler);

        $this->quickInitVar('category_link_id', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('category_link_cid', XOBJ_DTYPE_INT, false);
        $this->quickInitVar('category_link_mid', XOBJ_DTYPE_INT, false);
        $this->quickInitVar('category_link_item', XOBJ_DTYPE_TXTBOX);
        $this->quickInitVar('category_link_iid', XOBJ_DTYPE_INT);

		$this->setControl('category_link_cid', array (
			'name' => 'categorytree',
			'itemHandler' => 'category',
			'module' => 'imtagging'
		));

		$this->setControl('category_link_mid', array(
				'name'=>'module',
				'onSelect' => 'submit'
			));
		$this->setControl('category_link_item', array(
				'name'=>'item',
				'onSelect' => 'submit'
			));
		$this->setControl('category_link_iid', 'itemid');
    }

    /**
     * Overriding the IcmsPersistableObject::getVar method to assign a custom method on some
     * specific fields to handle the value before returning it
     *
     * @param str $key key of the field
     * @param str $format format that is requested
     * @return mixed value of the field that is requested
     */
    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('category_link_cid', 'category_link_mid', 'category_link_iid'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function category_link_cid() {
		$icms_persistable_registry = IcmsPersistableRegistry::getInstance();
    	$ret = $this->getVar('category_link_cid', 'e');
		$obj = $icms_persistable_registry->getSingleObject('category', $ret, 'imtagging');

    	if ($obj && !$obj->isNew()) {
    		if (defined('XOOPS_CPFUNC_LOADED')) {
    			$ret = $obj->getAdminViewItemLink();
    		} else {
    			$ret = $obj->getItemLink();
    		}
    	} else {
    		return '';
    	}
    }

    function category_link_mid() {
    	$mid = $this->getVar('category_link_mid', 'e');
    	$moduleObj = $this->getCategory_linkModule();
    	if ($moduleObj) {
    		return '<a href="' . ICMS_URL . '/modules/' . $moduleObj->getVar('dirname') . '/">' . $moduleObj->getVar('name') . '</a>';
    	} else {
    		return '';
    	}
    }

    function getCategory_linkModule(){
    	$module_handler = xoops_getHandler('module');
    	return $module_handler->get($this->getVar('category_link_mid', 'e'));
    }

    function category_link_iid() {
		$iid = $this->getVar('category_link_iid', 'e');
		$moduleObj = $this->getCategory_linkModule();
		$category_link_module_handler = icms_getModulehandler($this->getVar('category_link_item'), $moduleObj->getVar('dirname'));
		$category_link_object = $category_link_module_handler->get($iid);
		if ($category_link_object && !$category_link_object->isNew()) {
			return $category_link_object->getItemLink();
		} else {
			return '';
		}
    }
}

class ImtaggingCategory_linkHandler extends IcmsPersistableObjectHandler {

	/**
	 * Constructor
	 */
    public function __construct(&$db){
        $this->IcmsPersistableObjectHandler($db, 'category_link', 'category_link_id', 'category_link_iid', '', 'imtagging');
    }

	/**
	 * retrieve category_ids for an object
	 *
	 * @param int $iid id of the related object
	 * @param object IcmsPersistableHandler
	 * @return array array of category_ids
	 */
    function getCategoriesForObject($iid, &$handler) {
    	$moduleObj = icms_getModuleInfo($handler->_moduleName);

    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('category_link_mid', $moduleObj->mid()));
    	$criteria->add(new Criteria('category_link_item', $handler->_itemname));
    	$criteria->add(new Criteria('category_link_iid', $iid));
    	$sql = 'SELECT category_link_cid FROM ' . $this->table;
    	$rows = $this->query($sql, $criteria);
    	$ret = array();
    	foreach($rows as $row) {
    		$ret[] = $row['category_link_cid'];
    	}
    	return $ret;
    }

	/**
	 * retrieve categories that are linked to an array of object ids
	 *
	 * @param array $iids array of object ids
	 * @param object $handler IcmsPersistableHandler
	 * @return array array of ImtaggingCategory objects
	 */
    function getCategoriesFromObjectIds($iids, &$handler) {
    	$moduleObj = icms_getModuleInfo($handler->_moduleName);
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('category_link_mid', $moduleObj->mid()));
    	$criteria->add(new Criteria('category_link_item', $handler->_itemname));
    	$criteria->add(new Criteria('category_link_iid', '(' . implode(', ', $iids) . ')', 'IN'));

    	$sql = 'SELECT category_link_cid, category_link_iid FROM ' . $this->table;
    	$rows = $this->query($sql, $criteria);

    	$category_ids = array();
    	$iids_by_cid = array();
    	foreach($rows as $row) {
    		$iids_by_cid[$row['category_link_cid']][] = $row['category_link_iid'];
    	}

    	$imtagging_category_handler = icms_getModulehandler('category', 'imtagging');
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('category_id', '(' . implode(', ', array_keys($iids_by_cid)) . ')', 'IN'));
    	$ret = $imtagging_category_handler->getObjects($criteria);

    	// add iids to each categoryObj
    	foreach ($ret as $categoryObj) {
			$categoryObj->items[$handler->_moduleName][$handler->_itemname] = $iids_by_cid[$categoryObj->id()];
    	}
    	return $ret;
    }

    function getItemidsForCategory($cid, &$handler=false) {
    	$moduleObj = icms_getModuleInfo($handler->_moduleName);

    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('category_link_mid', $moduleObj->mid()));
    	$criteria->add(new Criteria('category_link_item', $handler->_itemname));
    	$criteria->add(new Criteria('category_link_cid', $cid));
    	$sql = 'SELECT category_link_iid FROM ' . $this->table;
    	$rows = $this->query($sql, $criteria);
    	$ret = array();
    	foreach($rows as $row) {
    		$ret[] = $row['category_link_iid'];
    	}
    	return $ret;
    }

	function deleteAllForObject(&$obj) {
		/**
		 * @todo: add $moduleObj as a static var
		 */
		$moduleObj = icms_getModuleInfo($obj->handler->_moduleName);
    	$mid = $moduleObj->mid();

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('category_link_mid', $mid));
		$criteria->add(new Criteria('category_link_item', $obj->handler->_itemname));
		$criteria->add(new Criteria('category_link_iid', $obj->id()));

		$this->deleteAll($criteria);
	}

    function storeCategoriesForObject(&$obj, $category_var='categories') {
		/**
		 * @todo: check if categories have changed and if so don't do anything
		 */

		// delete all current categories linked to this object
		$this->deleteAllForObject($obj);

		$moduleObj = icms_getModuleInfo($obj->handler->_moduleName);

		$category_array = $obj->getVar($category_var);

		foreach($category_array as $category) {
			$category_linkObj = $this->create();
			$category_linkObj->setVar('category_link_mid', $moduleObj->mid());
			$category_linkObj->setVar('category_link_item', $obj->handler->_itemname);
			$category_linkObj->setVar('category_link_iid', $obj->id());
			$category_linkObj->setVar('category_link_cid', $category);
			$this->insert($category_linkObj);
		}
    }
}
?>