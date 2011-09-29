<?php
/**
* English language constants related to module information
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

// Module Info
// The name of this module

global $icmsModule;
define("_MI_IMTAGGING_MD_NAME", "imTagging");
define("_MI_IMTAGGING_MD_DESC", "ImpressCMS Categorising and tagging module");

define("_MI_IMTAGGING_TAGS", "Tags");
define("_MI_IMTAGGING_CATEGORIES", "Categories");

// Configs
define("_MI_IMTAGGING_TAGERGR", "Groups allowed to tags");
define("_MI_IMTAGGING_TAGERGRDSC", "Select the groups which are allowed to create new tags. Please note that a user belonging to one of these groups will be able to tag directly on the site. The module currently has no moderation feature.");
define("_MI_IMTAGGING_LIMIT", "Tags limit");
define("_MI_IMTAGGING_LIMITDSC", "Number of tags to display on user side.");

// Blocks
define("_MI_IMTAGGING_TAGRECENT", "Recent tags");
define("_MI_IMTAGGING_TAGRECENTDSC", "Display most recent tags");
define("_MI_IMTAGGING_TAGBYMONTH", "Tags by month");
define("_MI_IMTAGGING_TAGBYMONTHDSC", "Display list of months in which there were tags");

// Notifications
define("_MI_IMTAGGING_GLOBAL_NOTIFY", "All tags");
define("_MI_IMTAGGING_GLOBAL_NOTIFY_DSC", "Notifications related to all tags in the module");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY", "New tag published");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_CAP", "Notify me when a new tag is published");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_DSC", "Receive notification when any new tag is published.");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New tag published");
if (!defined("_AM_IMTAGGING_CATEGORY_LINK")){define("_AM_IMTAGGING_CATEGORY_LINK", "Category link");}
?>