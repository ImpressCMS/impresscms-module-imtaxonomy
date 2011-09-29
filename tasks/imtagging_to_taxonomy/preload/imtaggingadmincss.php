<?php
/**
* Adding admin css
*
* @copyright	The ImpressCMS Project http://www.impresscms.org/
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @package		libraries
* @since		1.1
* @author		marcan <marcan@impresscms.org>
* @version		$Id$
*/

/**
 * Define these constants to specify weight. Only for demonstration purposes for now
 */
/*define(ICMSPRELOADPROTECTOR_STARTCOREBOOT, 2);
define(ICMSPRELOADPROTECTOR_FINISHCOREBOOT, 10);
*/
class IcmsPreloadImtaggingadmincss extends IcmsPreloadItem
{
	function eventAdminHeader() {
		$ret  = '<link rel="stylesheet" type="text/css" media="all" href="' . ICMS_URL . '/modules/imtagging/module'.(( defined("_ADM_USE_RTL") && _ADM_USE_RTL )?'_rtl':'').'.css' . '" />';

		echo $ret;
	}
}
?>