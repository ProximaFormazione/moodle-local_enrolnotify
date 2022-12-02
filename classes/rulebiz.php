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



// //decomment for test
// require_once("../../../config.php");
// $class = new local_enrolnotify_rulebiz();

// $ans = $class->get_all_rules_wo_msg();

// var_dump($ans);

// echo 'test';

require_once($CFG->libdir.'/moodlelib.php');

/**
 * Class with business logic regarding rules.
 * @copyright  2022 Proxima s.r.l. (https://www.proximaformazione.it/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_enrolnotify_rulebiz {

    /**
     * gets all rules saved in the database ,message not included. As I don't expect them to be many i just get them all
     *
     * @return  array array with rules records, just without the mail message
     */
    public function get_all_rules_wo_msg(){
        global $DB;

        return $DB->get_records('local_enrolnotify_rule',null,'priority','id,donotnotify,userid,courseid,categoryid,cohortid');
    }

    /**
     * gets all message details for a specific rule
     *
     * @return stdobject with mailsubjet, message, fromfield 
     */
    public function get_rule_message_by_id(int $id){
        global $DB;

        $toret = $DB->get_record('local_enrolnotify_rule',['id'=>$id],'mailsubject,message,fromfield');
        
        return $toret;
    }
}