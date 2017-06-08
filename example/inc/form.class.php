<?php

/*
 *
  -------------------------------------------------------------------------
  Plugin GLPI Example
  Copyright (C) 2017 by Walid H.
 */

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

class PluginExampleForm extends CommonDBTM {

    static $rightname = 'plugin_example';

    /**
     * 
     * @return type
     */
    public static function getTypeName() {
        return $GLOBALS['LANG']['plugin_example']['title'];
    }

    /** 
     * Show the form (menu->plugin->example)
     */
    public function formIndex() {
        echo "<form action='' method='post'>";
        echo '<div class="tab_cadre_fixe" style="box-shadow: 0 1px 8px #aaa;text-align:center;padding:1em;">';
        echo "<h1>Plugin Exemple GLPI</h1>";
        echo "<p>...</p>";
        echo "</div>";
        html::closeForm();
    }

}
