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

require_once('../../config.php');

require_login();

$context = context_system::instance();
require_capability('local/enrolnotify:editrules',$context);

require_once ($CFG->dirroot.'/local/enrolnotify/classes/rulebiz.php');
require_once ($CFG->dirroot.'/local/enrolnotify/classes/local_enrolnotify_ruleform.php');

$mode = optional_param('mode','add',PARAM_TEXT);
$id = optional_param('id',0,PARAM_INT);

$biz = new local_enrolnotify_rulebiz();
$mform = new local_enrolnotify_ruleform();

if($mode == 'moveup'){
    $biz->move_rule_up_by_id($id);
    redirect(new moodle_url('/local/enrolnotify/rules.php'));
}
else if($mode == 'movedown'){
    $biz->move_rule_down_by_id($id);
    redirect(new moodle_url('/local/enrolnotify/rules.php'));
}
else if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/enrolnotify/rules.php'));
} else if ($fromform = $mform->get_data()) {
    $biz->save_rule($fromform);
    redirect(new moodle_url('/local/enrolnotify/rules.php'));
}
else if($mode == 'edit'){
    $toedit = $biz->get_rule_by_id($id);
    $mform->set_data($toedit);
}
else if($mode == 'delete'){
    $biz->delete_rule_by_id($id);
    redirect(new moodle_url('/local/enrolnotify/rules.php'));
}
else if($mode == 'add'){
    
}
else{
    echo 'Mode '.$mode.' not implemented'; //-("should be unreachable")™
}

$pageurl = new moodle_url('/local/enrolnotify/ruleedit.php');

$PAGE->set_pagelayout('standard');
$PAGE->set_url($pageurl);
$PAGE->set_title(get_string('ruleeditpage_header', 'local_enrolnotify'));
$PAGE->set_heading(get_string('ruleeditpage_header','local_enrolnotify'));

//------------------RENDERING--------------------------------

echo $OUTPUT->header();

$mform->display();

if($id>0){
    $url =  new moodle_url('/local/enrolnotify/ruleedit.php',['mode'=>'delete','id'=>$id]);
    $linkname = get_string('rulespage_delete_rule', 'local_enrolnotify');
    $editbutton = new single_button($url, $linkname, 'get', true);

    echo $OUTPUT->render($editbutton);
}


echo $OUTPUT->footer();