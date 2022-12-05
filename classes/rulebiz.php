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

        return $DB->get_records('local_enrolnotify_rule',null,'priority','id,priority,donotnotify,userid,courseid,categoryid,cohortid');
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

    /**
     * gets  a specific rule
     *
     * @return stdobject with all fields
     */
    public function get_rule_by_id(int $id){
        global $DB;

        $toret = $DB->get_record('local_enrolnotify_rule',['id'=>$id]);
        
        return $toret;
    }

    public function move_rule_up_by_id(int $id){
        

        $rules = $this->get_all_rules_wo_msg();
        $priority = $rules[$id]->priority;

        $keyslookup = array_flip(array_keys($rules));
        $pos = $keyslookup[$id];
        if($pos == 0){
            return; //-it's the first rule already
        }
        else{
            $otherid = array_flip($keyslookup)[$pos-1];
            $otherpriority = $rules[$otherid]->priority;

            $this->swap_priorities($id,$otherpriority,$otherid, $priority);
        }

    }

    public function move_rule_down_by_id(int $id){
        

        $rules = $this->get_all_rules_wo_msg();
        $priority = $rules[$id]->priority;

        $keyslookup = array_flip(array_keys($rules));
        $pos = $keyslookup[$id];
        if($pos == count($rules)-1){
            return; //-it's the last rule already
        }
        else{
            $otherid = array_flip($keyslookup)[$pos+1];
            $otherpriority = $rules[$otherid]->priority;

            $this->swap_priorities($id,$otherpriority,$otherid, $priority);
        }

    }

    /**
     * This runs the query to swap priorities, there's an unique index on that column
     */
    function swap_priorities(int $id1, int $priority1, int $id2, int $priority2){
        global $DB;

        $record1 = new stdClass();
        $record1->id = $id1;
        $record1->priority = -42; //-temporary, we need to free its value

        $DB->update_record('local_enrolnotify_rule', $record1);

        $record2 = new stdClass();
        $record2->id = $id2;
        $record2->priority = $priority2;

        $DB->update_record('local_enrolnotify_rule', $record2);

        $record1->priority = $priority1;

        $DB->update_record('local_enrolnotify_rule', $record1);
    }

    public function save_rule(stdClass $rule){
        global $DB;

        if($rule->priority == null){ //- if priority is not set I'll just add 11 to the last one
            $rules = $this->get_all_rules_wo_msg();
            $rule->priority = end($rules)->priority +11;
        }

        if($rule->id == 0){
            $DB->insert_record('local_enrolnotify_rule', $rule);
        }
        else{
            $DB->update_record('local_enrolnotify_rule', $rule);
        }
    }

    public function delete_rule_by_id(int $id){
        global $DB;

        $DB->delete_records('local_enrolnotify_rule', ['id'=>$id]);
    }

    /**
     * Gets a language friendly explanation of the rule
     */
    public function get_rule_explained(stdClass $rule){
        global $DB;

        $strings = [];

        //-if any condition has value i write down the explanation in language
        if(empty($rule->userid)==false){
            $user = $DB->get_record('user',['id'=>$rule->userid],'firstname,lastname');
            if($user == false){
                $user = new stdClass();
                $user->firstname = '[ID:'.$rule->userid.']';
            }
            $strings[] = get_string('rulestring_user','local_enrolnotify', ['firstname' => $user->firstname, 'lastname' => $user->lastname]);
        }

        if(empty($rule->courseid)==false){
            $course = $DB->get_record('course',['id'=>$rule->courseid],'fullname');
            if($course == false){
                $course = new stdClass();
                $course->fullname = '[ID:'.$rule->courseid.']';
            }
            $strings[] = get_string('rulestring_course','local_enrolnotify', $course->fullname);
        }

        if(empty($rule->cohortid)==false){
            $cohort = $DB->get_record('cohort',['id'=>$rule->cohortid],'name');
            if($cohort == false){
                $cohort = new stdClass();
                $cohort->name = '[ID:'.$rule->cohortid.']';
            }
            $strings[] = get_string('rulestring_cohort','local_enrolnotify', $cohort->name);
        }

        if(empty($rule->categoryid)==false){
            $category = $DB->get_record('course_categories',['id'=>$rule->categoryid],'name');
            if($category == false){
                $category = new stdClass();
                $category->name = '[ID:'.$rule->categoryid.']';
            }
            $strings[] = get_string('rulestring_category','local_enrolnotify', $category->name);
        }

        $toret = '';

        if($rule->donotnotify){
            $toret .= get_string('rulestring_donotnotify','local_enrolnotify').' ';
        }
        

        if(empty($strings)){
            $toret .= get_string('rulestring_noconditions','local_enrolnotify');
        }
        else{
            $toret .= get_string('rulestring_if','local_enrolnotify').' ';
            for($i = 0; $i < count($strings); $i++){
                if($i != 0){
                    $toret .= ' '.get_string('rulestring_and','local_enrolnotify').' ';
                }
                $toret .= $strings[$i];
            }
        }

        $toret .= '.';

        return $toret;
    }
}