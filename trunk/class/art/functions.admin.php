<?php
/**
 * Module admin functions
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @author		McDonald <pietjebell31@hotmail.com>
 * @since		1.00
 * @version		$Id: functions.admin.php 19246 2010-05-10 10:19:05Z underdogg $
 * @package		Frameworks::art
 */

function loadModuleAdminMenu ($currentoption = 0, $breadcrumb = '')  {
	global $icmsModule;
	$icmsModule -> displayAdminMenu( $currentoption, $icmsModule -> name() . ' | ' . $breadcrumb );
}

?>