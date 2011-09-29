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
define("_MI_IMTAGGING_MD_DESC", "ImpressCMS Kategorisierung- und Tag-Module");

define("_MI_IMTAGGING_TAGS", "Tags");
define("_MI_IMTAGGING_CATEGORIES", "Kategorien");

// Configs
define("_MI_IMTAGGING_TAGERGR", "Gruppen die Tags erstellen dürfen");
define("_MI_IMTAGGING_TAGERGRDSC", "Select the groups which are allowed to create new tags. Please note that a user belonging to one of these groups will be able to tag directly on the site. The module currently has no moderation feature.");
define("_MI_IMTAGGING_LIMIT", "Tag Limit");
define("_MI_IMTAGGING_LIMITDSC", "Anzahl der Tags die in der Webseite maximal angezeigt werden sollen.");

// Blocks
define("_MI_IMTAGGING_TAGRECENT", "Neue Tags");
define("_MI_IMTAGGING_TAGRECENTDSC", "Zeigt die jüngsten Tags");
define("_MI_IMTAGGING_TAGBYMONTH", "Tags nach Monat");
define("_MI_IMTAGGING_TAGBYMONTHDSC", "Liste der Monate anzeigen, in denen es Tags gab");

// Notifications
define("_MI_IMTAGGING_GLOBAL_NOTIFY", "Alle Tags");
define("_MI_IMTAGGING_GLOBAL_NOTIFY_DSC", "Benachrichtigung in Zusammenhang mit allen Tags");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY", "Neuer Tag veröffentlicht");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_CAP", "Mich benachrichtigen, wenn win neuer Tag veröffentlicht wurde");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_DSC", "Sende eine Benachrichtigung, sobald ein neuer Tag veröffentlicht wurde.");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : Neuer Tag veröffentlicht");
if (!defined("_AM_IMTAGGING_CATEGORY_LINK")){define("_AM_IMTAGGING_CATEGORY_LINK", "Kategorie-Link");}
?>