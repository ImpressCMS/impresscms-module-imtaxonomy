<?php
/**
 * Xoops multi-language string and encoding handling class
 *
 * @copyright	 The XOOPS project http://www.xoops.org/
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package      language
 * @version      $Id: local.php 108 2006-03-23 17:41:10Z phppp $
 * @author       D.J. (phppp)
 * @since        2.2
 */

// !!IMPORTANT!! insert '\' before any char among reserved chars: "a", "A", "B", "c", "d", "D", "F", "g", "G", "h", "H", "i", "I", "j", "l", "L", "m", "M", "n", "O", "r", "s", "S", "t", "T", "U", "w", "W", "Y", "y", "z", "Z"	
// insert double '\' before 't', 'r', 'n'
if(!defined("_YEARMONTHDAY")) {
define("_TODAY", "\Heu\\te H:i");
define("_YESTERDAY", "\Ge\s\\te\\r\\n H:i");
define("_MONTHDAY", "d.m.Y H:i");
define("_YEARMONTHDAY", "d.m.Y H:i");
}

define("_ELAPSE", "vor %s");

define("_TIMEFORMAT_DESC", "Gültige Formate: \"s\" - "._SHORTDATESTRING."; \"m\" - "._MEDIUMDATESTRING."; \"l\" - "._DATESTRING.";<br />".
							"\"c\" or \"custom\" - format determined according to interval to present; \"e\" - Elapsed; \"mysql\" - Y-m-d H:i:s;<br />".
							"specified string - Refer to <a href=\"http://php.net/manual/en/function.date.php\" target=\"_blank\">PHP manual</a>."
							);
							
require_once dirname(dirname(__FILE__))."/german/local.class.php";

/**
 * The class should be an abstract one using PHP embedded functions
 * based on which, 
 * each local language defines its own equalient methods
 *
 * A comprehensive handler is expected in Xoops 2.3 or 2.4
 */

class XoopsLocal extends XoopsLocalEnglish
{	
}
?>