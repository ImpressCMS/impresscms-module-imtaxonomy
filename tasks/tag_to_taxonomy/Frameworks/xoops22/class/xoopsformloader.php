<?php
// $Id: xoopsformloader.php,v 1.8.22.1.2.4 2005/07/14 16:13:30 phppp Exp $
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

include_once XOOPS_ROOT_PATH."/class/xoopsform/formelement.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/form.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formlabel.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formselect.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formpassword.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formbutton.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formcheckbox.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formhidden.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formfile.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formradio.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formradioyn.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formselectcountry.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formselecttimezone.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formselectlang.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formselectgroup.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formselectuser.php";

include_once XOOPS_ROOT_PATH."/class/xoopsform/formselecttheme.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formselectmatchoption.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formtext.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formtextarea.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formdhtmltextarea.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formelementtray.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/themeform.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/simpleform.php";
@include_once XOOPS_ROOT_PATH."/class/xoopsform/formcalendar.php"; // for XOOPS 22
include_once XOOPS_ROOT_PATH."/class/xoopsform/formtextdateselect.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formdatetime.php";
include_once XOOPS_ROOT_PATH."/class/xoopsform/formhiddentoken.php";

//if(!@include_once XOOPS_ROOT_PATH."/class/xoopsform/formeditor.php") {
	require_once dirname(__FILE__)."/xoopsform/formeditor.php";
//}

//if( !@include_once XOOPS_ROOT_PATH."/class/xoopsform/formselecteditor.php" ) {
	require_once dirname(__FILE__)."/xoopsform/formselecteditor.php";
//}
?>