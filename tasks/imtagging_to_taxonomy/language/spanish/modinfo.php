<?php
/**
* English language constants related to module information
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @translator	debianus
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

// Module Info
// The name of this module

global $icmsModule;
define("_MI_IMTAGGING_MD_NAME", "imTagging");
define("_MI_IMTAGGING_MD_DESC", "Módulo para establecer categorías y etiquetas de contenido web para ImpressCMS");

define("_MI_IMTAGGING_TAGS", "Etiquetas");
define("_MI_IMTAGGING_CATEGORIES", "Categorías");

// Configs
define("_MI_IMTAGGING_TAGERGR", "Grupos de usuarios que pueden crear etiquetas");
define("_MI_IMTAGGING_TAGERGRDSC", "Determine los grupos de usuarios que pueden crear etiquetas. Tenga en cuenta que un usuario que pertenezca a uno de los grupos que seleccione podrá añadir etiquetas directamente, por cuanto el móduo actualmente no tiene la característica de poder moderar los envíos.");
define("_MI_IMTAGGING_LIMIT", "Límite de etiquetas");
define("_MI_IMTAGGING_LIMITDSC", "Número de etiquetas que se mostrarán a los visitantes del sitio.");

// Blocks
define("_MI_IMTAGGING_TAGRECENT", "Etiquetas recientes");
define("_MI_IMTAGGING_TAGRECENTDSC", "Mostrar las últimas etiquetas creadas en el sistema");
define("_MI_IMTAGGING_TAGBYMONTH", "Etiquetas por mes");
define("_MI_IMTAGGING_TAGBYMONTHDSC", "Se mostrará una lista de los meses en los se crearon etiquetas.");

// Notifications
define("_MI_IMTAGGING_GLOBAL_NOTIFY", "Etiquetas");
define("_MI_IMTAGGING_GLOBAL_NOTIFY_DSC", "Notificaciones relacionados con las etiquetas existentes");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY", "Nueva etiqueta publicada");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_CAP", "Notificarme cuando una nueva etiqueta sea publicada");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_DSC", "");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} Autonotificación: nueva etiqueta publicada");
if (!defined("_AM_IMTAGGING_CATEGORY_LINK")){define("_AM_IMTAGGING_CATEGORY_LINK", "Enlace de categoría");}
?>