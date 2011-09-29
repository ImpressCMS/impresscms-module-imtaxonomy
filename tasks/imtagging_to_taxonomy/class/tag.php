<?php
/**
* Classes responsible for managing imTagging tag objects
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

class ImtaggingTag extends IcmsPersistableSeoObject {

    /**
     * Constructor
     *
     * @param object $handler ImtaggingTagHandler object
     */
    public function __construct(&$handler){
    	global $icmsConfig;

    	$this->IcmsPersistableObject($handler);

        $this->quickInitVar('tag_id', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('tag_title', XOBJ_DTYPE_TXTBOX);
        $this->quickInitVar('tag_description', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('tag_created_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('tag_uid', XOBJ_DTYPE_INT);
		$this->quickInitVar('tag_cancomment', XOBJ_DTYPE_INT, false, false, false, true);

		$this->setControl('tag_cancomment', 'yesno');
		$this->setControl('tag_uid', 'user');

		$this->IcmsPersistableSeoObject();
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
        if ($format == 's' && in_array($key, array('tag_uid'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

	/**
	 * Retrieving the name of the tager, linked to his profile
	 *
	 * @return str name of the tager
	 */
    function tag_uid() {
        return icms_getLinkedUnameFromId($this->getVar('tag_uid', 'e'));
    }
}
class ImtaggingTagHandler extends IcmsPersistableObjectHandler {

	/**
	 * Constructor
	 */
    public function __construct(&$db){
        $this->IcmsPersistableObjectHandler($db, 'tag', 'tag_id', 'tag_title', 'tag_description', 'imtagging');
    }
}
?>