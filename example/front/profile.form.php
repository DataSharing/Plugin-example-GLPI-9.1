<?php
/*
 *
 -------------------------------------------------------------------------
 Plugin GLPI Example
 Copyright (C) 2017 by Walid H.
*/

include (GLPI_ROOT . "../../../inc/includes.php");

Session::checkRight('profile', UPDATE);

$profile = new PluginExampleProfile();
$profile->update($_POST);

PluginExampleProfile::changeProfile();

Html::back();
