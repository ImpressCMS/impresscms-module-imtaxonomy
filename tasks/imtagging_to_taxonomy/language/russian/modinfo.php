<?php
/**
* Russian language constants related to module information
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gp<a href="/modules/imtagging/language/russian/modinfo.php">modinfo.php</a>l-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$ Russian translation. Charset: utf-8 (without BOM)
*/

if (!defined("ICMS_ROOT_PATH")) die("Не определен корневой путь к ICMS");

// Module Info
// The name of this module

global $icmsModule;
define("_MI_IMTAGGING_MD_NAME", "imTagging");
define("_MI_IMTAGGING_MD_DESC", "Модуль категоризациии и тэгирования (маркировки) для ImpressCMS");

define("_MI_IMTAGGING_TAGS", "Тэги");
define("_MI_IMTAGGING_CATEGORIES", "Категории");

// Configs
define("_MI_IMTAGGING_TAGERGR", "Разрешенные для тэгирования группы");
define("_MI_IMTAGGING_TAGERGRDSC", "Выберите группы, пользователям которых разрешено создавать новые тэги. Обратите внимание, что пользователи, принадлежащие к одной из этих групп, получат возможность создавать тэги прямо на сайте. На текущий момент свойство модерации в этом модуле отсутствует.");
define("_MI_IMTAGGING_LIMIT", "Лимит тэгов");
define("_MI_IMTAGGING_LIMITDSC", "Количество тэгов для отображения пользователям.");

// Blocks
define("_MI_IMTAGGING_TAGRECENT", "Последние тэги");
define("_MI_IMTAGGING_TAGRECENTDSC", "Отобразить самые последние тэги");
define("_MI_IMTAGGING_TAGBYMONTH", "Тэги за месяц");
define("_MI_IMTAGGING_TAGBYMONTHDSC", "Отобразить список месяцев, в которых происходило тэгирование");

// Notifications
define("_MI_IMTAGGING_GLOBAL_NOTIFY", "Все тэги");
define("_MI_IMTAGGING_GLOBAL_NOTIFY_DSC", "Оповещения, связанные со всеми тэгами в модуле");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY", "Опубликован новый тэг");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_CAP", "Известить меня, когда будет опубликован новый тэг");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_DSC", "Получить оповещение, когда будет опубликован любой новый тэг.");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} автооповещение : Опубликован новый тэг");
if (!defined("_AM_IMTAGGING_CATEGORY_LINK")){define("_AM_IMTAGGING_CATEGORY_LINK", "Ссылка категории");}
?>