<?php

/*
 *
  -------------------------------------------------------------------------
  Plugin GLPI Example
  Copyright (C) 2017 by Walid H.

 */

function plugin_init_example() {
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['example'] = true;
    $PLUGIN_HOOKS['change_profile']['example'] = array('PluginExampleProfile', 'changeProfile');

    Plugin::registerClass('PluginExampleProfile', array('addtabon' => 'Profile'));

    $plugin = new Plugin();

    if (isset($_SESSION['glpiID']) && $plugin->isInstalled('example') && $plugin->isActivated('example')) {
        if (Session::haveRight('plugin_example', READ)) {
            $PLUGIN_HOOKS['menu_toadd']['example'] = array(
                'plugins' => 'PluginExampleForm',
            );
            /*
             * Add the CSS and JS file for the plugin
              $PLUGIN_HOOKS['add_javascript']['example'] = array();
              $PLUGIN_HOOKS['add_css']['example'] = array();
              $PLUGIN_HOOKS['add_css']['example'][]="bootstrap/css/bootstrap.min.css";
              $PLUGIN_HOOKS['add_javascript']['example'][]="bootstrap/js/bootstrap.min.js";
             * 
             */
        }
    }
}

function plugin_version_example() {
    global $LANG;

    return array(
        'name' => $LANG['plugin_example']['title'],
        'version' => '9.1',
        'author' => "Walid Heddaji",
        'license' => "GPLv2+",
        'homepage' => '',
        'minGlpiVersion' => '0.90'
    );
}

function plugin_example_check_prerequisites() {
    if (GLPI_VERSION >= 0.90) {
        return true;
    } else {
        echo "GLPI version NOT compatible. Requires GLPI 0.90";
        return false;
    }
}

function plugin_example_check_config() {
    return true;
}
