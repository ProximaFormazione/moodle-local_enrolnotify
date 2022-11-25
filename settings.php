<?php

// Copyright (C) 2022 Proxima s.r.l. (https://www.proximaformazione.it/)
//
// This file is part of the Enroll Notifier module for Moodle - http://moodle.org/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details: http://www.gnu.org/copyleft/gpl.html

/**
 * @package    local_enrolnotify
 * @author     Mattia MELE <mele.mattia@gmail.com>
 * @copyright  2022 Proxima s.r.l. (https://www.proximaformazione.it/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    $yesno = array(0 => get_string('no'), 1 => get_string('yes'));
    
    
    $settings = new admin_settingpage('local_enrolnotify', get_string('pluginname', 'local_enrolnotify'));
    $ADMIN->add('localplugins', $settings);


    $settings->add(new admin_setting_configselect('local_enrolnotify/enableplugin',
    get_string('config_enableplugin', 'local_enrolnotify'),
    get_string('config_enableplugin_desc', 'local_enrolnotify'),
    array('value' => 1), $yesno));

    $settings->add(new admin_setting_configtext_with_maxlength('local_enrolnotify/defaultsubject',
    get_string('config_defaultsubject', 'local_enrolnotify'),
    get_string('config_defaultsubject_desc', 'local_enrolnotify'),
    get_string('config_defaultsubject_default', 'local_enrolnotify'),
    PARAM_TEXT,
    null,
    128
    ));

    $settings->add(new admin_setting_confightmleditor('local_enrolnotify/defaultmessage',
    get_string('config_defaultmessage', 'local_enrolnotify'),
    get_string('config_defaultmessage_desc', 'local_enrolnotify'),
    ''
    //get_string('config_defaultmessage_default', 'local_enrolnotify')
    ));

    $url_newkey =  new moodle_url('/local/enrolnotify/rules.php');
    $linkname = get_string('config_gotoindex', 'local_enrolnotify');
    $button = new single_button($url_newkey, $linkname, 'get', true);

    $settings->add(new admin_setting_description('local_enrolnotify/gotoindex',
    '',
    '<br>'.$OUTPUT->render($button)
    //'<br><p><a href="'.new moodle_url('/local/enrolnotify/rules.php').'">'.get_string('config_gotoindex', 'local_enrolnotify').'</a></p><br>'
    ));
}