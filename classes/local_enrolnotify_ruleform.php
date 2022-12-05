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

require_once("$CFG->libdir/formslib.php");

class local_enrolnotify_ruleform extends moodleform {

    private $courses = [];
    private $cohorts = [];
    private $categories = [];

    public function __construct($action=null, $customdata=null, $method='post', $target='', $attributes=null, $editable=true,$ajaxformdata=null){
        global $DB;

        $this->courses = $DB->get_records('course',['visible'=>1],'fullname','id,shortname,fullname');
        $this->cohorts = $DB->get_records('cohort',['visible'=>1],'name','id,name');
        $this->categories = $DB->get_records('course_categories',['visible'=>1],'name','id,name');

        parent::__construct($action, $customdata, $method, $target, $attributes, $editable,$ajaxformdata);
    }


    public function definition() {
        
       
        $mform = $this->_form; // Don't forget the underscore! 
        $mform->addElement('hidden', 'id', '');
        $mform->setType('id', PARAM_INT);

        

        $mform->addElement('text', 'priority', get_string('rule_priority', 'local_enrolnotify')); 
        $mform->setType('priority', PARAM_INT);
        $mform->setDefault('priority', null);

        $mform->addElement('static', 'prioritydescription', '', get_string('ruleform_priority_description', 'local_enrolnotify'));

        $mform->addElement('html', '<hr>');

        $mform->addElement('static', 'ruledescription', '', get_string('ruleform_rules_title', 'local_enrolnotify'));

        $coursearr = [0=>''];
        foreach($this->courses as $id=>$course){
            $coursearr[$id] = $id.' - '.$course->shortname.' - '.$course->fullname;
        }
        $mform->addElement('select', 'courseid',get_string('rule_courseid','local_enrolnotify'),$coursearr);
        $mform->setType('courseid', PARAM_INT); 

        $catarr = [0=>''];
        foreach($this->categories as $id=>$category){
            $catarr[$id] = $category->name;
        }
        $mform->addElement('select', 'categoryid',get_string('rule_categoryid','local_enrolnotify'),$catarr);
        $mform->setType('categoryid', PARAM_INT); 

        $cohortarr = [0=>''];
        foreach($this->cohorts as $id=>$cohort){
            $cohortarr[$id] = $cohort->name;
        }
        $mform->addElement('select', 'cohortid',get_string('rule_cohortid','local_enrolnotify'),$cohortarr);
        $mform->setType('cohortid', PARAM_INT); 

        $mform->addElement('text', 'userid', get_string('rule_userid', 'local_enrolnotify')); 
        $mform->setType('userid', PARAM_INT);
        $mform->setDefault('userid', null);

        $mform->addElement('checkbox', 'donotnotify', get_string('rule_donotnotify', 'local_enrolnotify'));
        $mform->setType('donotnotify', PARAM_BOOL);

        $mform->addElement('html', '<hr>');

        $mform->addElement('static', 'maildesc', '', get_string('ruleform_maildetails_title', 'local_enrolnotify'));

        $mform->addElement('text', 'mailsubject', get_string('rule_mailsubject','local_enrolnotify')); 
        $mform->setType('mailsubject', PARAM_TEXT);
        $mform->setDefault('mailsubject', '');

        $mform->addElement('editor', 'message', get_string('rule_message', 'local_enrolnotify'));
        $mform->setType('message', PARAM_RAW);

        $mform->addElement('text', 'fromfield', get_string('rule_fromfield','local_enrolnotify')); 
        $mform->setType('fromfield', PARAM_TEXT);
        $mform->setDefault('fromfield', '');

        $mform->addElement('static', 'placeholderdescription', '', get_string('placeholder_description', 'local_enrolnotify'));
        

        $this->add_action_buttons();
        
    }

    public function get_data(){
        $toret = parent::get_data();

        if($toret){
            $message = $toret->message['text'];
            $toret->message = $message;

            if($toret->donotnotify == null){  
                $toret->donotnotify = 0;
            }

            if($toret->userid == 0){  
                $toret->userid = null;
            }
            if($toret->courseid == 0){  
                $toret->courseid = null;
            }
            if($toret->categoryid == 0){  
                $toret->categoryid = null;
            }
            if($toret->cohortid == 0){  
                $toret->cohortid = null;
            }
        }
        return $toret;
    }

    public function set_data($default_values){
        parent::set_data($default_values);

        parent::set_data(['message' => ['text' => $default_values->message , 'format' => FORMAT_HTML]]);
        
    }
}