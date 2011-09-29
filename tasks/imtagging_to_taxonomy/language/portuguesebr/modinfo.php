<?php
/**
* Portuguese language constants related to module information
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
* @translation        GibaPhp - http://br.impresscms.org 
*/

if (!defined("ICMS_ROOT_PATH")) die("O caminho para o raiz do site não foi definido");

// Module Info
// The name of this module

global $icmsModule;
define("_MI_IMTAGGING_MD_NAME", "imTagging");
define("_MI_IMTAGGING_MD_DESC", "Módulo de Categorização e codificação de Tags/Etiquetas");

define("_MI_IMTAGGING_TAGS", "Tags");
define("_MI_IMTAGGING_CATEGORIES", "Categorias");

// Configs
define("_MI_IMTAGGING_TAGERGR", "Grupos permitidos para a tags");
define("_MI_IMTAGGING_TAGERGRDSC", "Escolha os grupos que têm permissão para criar novas tags. Observe que se um usuário pertencer a um destes grupos, será capaz de criar novas tags diretamente no site sem solicitar autorização. Atenção, o módulo atualmente não tem nenhum recurso de moderação.");
define("_MI_IMTAGGING_LIMIT", "Limite de Tags");
define("_MI_IMTAGGING_LIMITDSC", "Número de tags que será exibido no lado do usuário.");

// Blocks
define("_MI_IMTAGGING_TAGRECENT", "Tags Recentes");
define("_MI_IMTAGGING_TAGRECENTDSC", "Mostrar Tags mais recentes");
define("_MI_IMTAGGING_TAGBYMONTH", "Tags por Mês");
define("_MI_IMTAGGING_TAGBYMONTHDSC", "Mostrar lista de meses em que houve tags");

// Notifications
define("_MI_IMTAGGING_GLOBAL_NOTIFY", "Todas tags");
define("_MI_IMTAGGING_GLOBAL_NOTIFY_DSC", "As notificações relacionadas a todas as tags no módulo");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY", "Nova Tag publicada");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_CAP", "Avise-me quando uma nova tag for publicada");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_DSC", "Receberá uma notificação quando qualquer nova tag forem publicadas.");
define("_MI_IMTAGGING_GLOBAL_TAG_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} Notificação-automática : Nova tag publicada");
?>