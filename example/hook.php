<?php

/*
 *
  -------------------------------------------------------------------------
  Plugin GLPI Example
  Copyright (C) 2017 by Walid H.
  --------------------------------------------------------------------------
 */

require_once "inc/form.class.php";
require_once "inc/profile.class.php";

function plugin_example_install() {
    PluginExampleProfile::createFirstAccess($_SESSION['glpiactiveprofile']['id']);
    return true;
}

function plugin_example_uninstall() {
    PluginExampleProfile::uninstallProfile();
    return true;
}
