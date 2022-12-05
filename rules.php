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

$biz = new local_enrolnotify_rulebiz();

$extraction = $biz->get_all_rules_wo_msg();

$datagrid = new html_table();
$datagrid->head = [
    '#'
    ,' '
    ,get_string('rulespage_colheader_rule','local_enrolnotify')
    ,' '
];

//-variables to get first and last element
$firstrowdone = false;
$i = 0;
foreach($extraction as $record){

    if($firstrowdone){
        $url_up =  new moodle_url('/local/enrolnotify/ruleedit.php',['mode'=>'moveup','id'=>$record->id]);
        $linkname_up = $OUTPUT->pix_icon('i/up','^');
        $upbutton = html_writer::tag('a',$linkname_up,['href'=>$url_up]); 

        $uparrow = $upbutton;
        $elselabel = get_string('rulespage_elselabel','local_enrolnotify').' ';
    }
    else{
        $uparrow = '';
        $elselabel = '';
        $firstrowdone = true;
    }

    if(++$i === count($extraction)) {
        $downarrow = '';
    }
    else{
        $url_down =  new moodle_url('/local/enrolnotify/ruleedit.php',['mode'=>'movedown','id'=>$record->id]);
        $linkname_down = $OUTPUT->pix_icon('i/down','v');
        $downbutton = html_writer::tag('a',$linkname_down,['href'=>$url_down]); 

        $downarrow = $downbutton;
    }

    $url =  new moodle_url('/local/enrolnotify/ruleedit.php',['mode'=>'edit','id'=>$record->id]);
    $linkname = get_string('edit');
    $editbutton = new single_button($url, $linkname, 'get', true);

    $row =  [
        $record->priority
        ,$uparrow.$downarrow 
        ,$elselabel.$biz->get_rule_explained($record)
        ,$OUTPUT->render($editbutton)
    ];

    $datagrid->data[] = $row;
}


$pageurl = new moodle_url('/local/enrolnotify/rules.php');

$PAGE->set_pagelayout('standard');
$PAGE->set_url($pageurl);
$PAGE->set_title(get_string('rulespage_header', 'local_enrolnotify'));
$PAGE->set_heading(get_string('rulespage_header','local_enrolnotify'));

//------------------RENDERING--------------------------------

echo $OUTPUT->header();

echo html_writer::tag('h2',get_string('rulespage_title', 'local_enrolnotify'));
echo html_writer::tag('p',get_string('rulespage_explanation', 'local_enrolnotify'));

if(empty($extraction)){
    echo html_writer::tag('p',get_string('rulespage_norules', 'local_enrolnotify'));
}
else{
    echo html_writer::table($datagrid);  
    echo html_writer::tag('p',get_string('rulespage_disclaimerelse', 'local_enrolnotify'));
}

$url =  new moodle_url('/local/enrolnotify/ruleedit.php',['mode'=>'add']);
$linkname = get_string('rulespage_add_rule', 'local_enrolnotify');
$editbutton = new single_button($url, $linkname, 'get', true);

echo $OUTPUT->render($editbutton);

echo $OUTPUT->footer();