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

class PluginExampleProfile extends Profile {

    static $rightname = 'profile';

    public static function getAllRights() {
        global $LANG;

        return array(
            array(
                'itemtype' => 'PluginExampleProfile',
                'label' => $LANG['plugin_example']['manage_alerts'],
                'field' => 'plugin_example'
            ),
        );
    }

    public static function addDefaultProfileInfos($profiles_id, $rights) {
        $profileRight = new ProfileRight();
        foreach ($rights as $right => $value) {
            if (!countElementsInTable('glpi_profilerights', "`profiles_id`='$profiles_id' AND `name`='$right'")) {
                $myright['profiles_id'] = $profiles_id;
                $myright['name'] = $right;
                $myright['rights'] = $value;
                $profileRight->add($myright);

                //Add right to the current session
                $_SESSION['glpiactiveprofile'][$right] = $value;
            }
        }
    }

    /**
     * @param $ID  integer
     */
    public static function createFirstAccess($profiles_id) {
        $profile = new self();
        foreach ($profile->getAllRights() as $right) {
            self::addDefaultProfileInfos($profiles_id, array($right['field'] => ALLSTANDARDRIGHT));
        }
    }

    public static function changeProfile() {
        $profile = new self();

        if ($profile->getFromDBByProfile($_SESSION['glpiactiveprofile']['id'])) {
            $_SESSION['glpiactiveprofile']['example_alert'] = $profile->getField('alert');
        } else {
            unset($_SESSION['glpiactiveprofile']['example_alert']);
        }
    }

    public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {
        global $LANG;
        return $LANG['plugin_example']['title'];
    }

    public function getFromDBByProfile($profiles_id) {
        global $DB;

        $query = "SELECT *
                FROM `" . $this->getTable() . "`
                WHERE `profiles_id` = '" . (int) $profiles_id . "' ";

        if ($result = $DB->query($query)) {
            if ($DB->numrows($result)) {
                $this->fields = $DB->fetch_assoc($result);
                if (is_array($this->fields) && count($this->fields)) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0) {
        $profile = new self();

        if (!$profile->getFromDBByProfile($item->getID())) {
            self::createFirstAccess($item->getID());
            $profile->getFromDBByProfile($item->getID());
        }
        $profile->showForm($item->getField('id'));
    }

    public function showForm($profiles_id, $options = array()) {
        global $LANG;

        $profile = new Profile();
        $profile->getFromDB($profiles_id);

        if ($canedit = Session::haveRightsOr(self::$rightname, array(CREATE, UPDATE, PURGE))) {
            echo "<form action='" . $profile->getFormURL() . "' method='post'>";
        }

        $profile = new Profile();
        $profile->getFromDB($profiles_id);

        $rights = $this->getAllRights();
        $profile->displayRightsChoiceMatrix($rights, array(
            'canedit' => $canedit,
            'default_class' => 'tab_bg_2',
            'title' => $LANG['plugin_example']['title'],
        ));

        if ($canedit) {
            echo "<div class='center'>";
            echo Html::hidden('id', array('value' => $profiles_id));
            echo Html::submit(_sx('button', 'Save'), array('name' => 'update'));
            echo "</div>\n";
            Html::closeForm();
        }
        HTML::closeForm();
    }

    public static function uninstallProfile() {
        $pfProfile = new self();
        $a_rights = $pfProfile->getAllRights();
        foreach ($a_rights as $data) {
            ProfileRight::deleteProfileRights(array($data['field']));
        }
    }

}
