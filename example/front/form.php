<?php
/*
 *
 -------------------------------------------------------------------------
 Plugin GLPI Example
 Copyright (C) 2017 by Walid H.
*/

include ("../../../inc/includes.php");

$plugin = new Plugin();
if (!$plugin->isInstalled("example") || !$plugin->isActivated("example")) {
   Html::displayNotFoundError();
}

Session::checkRight('plugin_example', READ);

$app = new PluginExampleForm();

Html::header(
   $LANG['plugin_example']['title'],
   $_SERVER["PHP_SELF"],
   'plugins',
   "PluginExampleForm"
);

$app->formIndex();

Html::footer();
