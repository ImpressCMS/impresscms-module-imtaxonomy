<?php 

/* Step 2: add tag storage after item storage */

// File: submit.item.php

$tag_handler = xoops_getmodulehandler('tag', 'tag');

$tag_handler->updateByItem($_POST["item_tag"], $itemid, $xoopsModule->getVar("dirname"), $catid =0);



?>