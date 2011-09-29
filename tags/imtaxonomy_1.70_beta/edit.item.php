<?php

// File: edit.item.php

$itemid = $item_obj->isNew() ? 0 : $item_obj->getVar("itemid");

include_once ICMS_ROOT_PATH."/modules/tag/include/formtag.php";

$form_item->addElement(new XoopsFormTag("item_tag", 60, 255, $itemid, $catid = 0));



?>