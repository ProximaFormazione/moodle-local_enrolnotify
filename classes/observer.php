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

require_once($CFG->libdir.'/moodlelib.php');
require_once($CFG->dirroot . '/local/enrolnotify/classes/placeholder_replacer.php');
require_once($CFG->dirroot . '/local/enrolnotify/classes/rulebiz.php');

defined('MOODLE_INTERNAL') || die();

class local_enrolnotify_observer {

    public static function user_enrolment_created(\core\event\user_enrolment_created $event) {
        global $DB, $CFG;

        if(get_config('local_enrolnotify','enableplugin') == '1'){ 
            //- Get the relevant entities
            $userEnrolled = $DB->get_record('user',['id' => $event->relateduserid]);
            $course = $DB->get_record('course',['id' => $event->courseid]);
            $cohorts = array_keys(cohort_get_user_cohorts($event->relateduserid));
            $categoriespath = $DB->get_record('course_categories',['id' => $course->category],'path');
            $categories = explode( '/',$categoriespath->path);
            array_shift($categories); //-first element is empty string

            $rulesbiz = new local_enrolnotify_rulebiz();

            $rulesarray = $rulesbiz->get_all_rules_wo_msg();

            $subjecttouse = null;
            $bodytouse = null;
            $fromtouse = null;
            $sendnotification = false;

            if(empty($rulesarray)){
                $subjecttouse = get_config('local_enrolnotify','defaultsubject');
                $bodytouse = get_config('local_enrolnotify','defaultmessage');
                $fromtouse = $CFG->noreplyaddress;
                $sendnotification = true;
            }
            else{
                foreach ($rulesarray as $rule) {

                    //- rule logic check: if a rule has multiple elements they are linked logically by an AND
                    $rulelogiccheck = ($rule->userid == null || $rule->userid == $userEnrolled->id) 
                        && ($rule->courseid == null || $rule->userid == $course->id) 
                        && ($rule->cohortid == null || in_array($rule->cohortid,$cohorts)) 
                        && ($rule->categoryid == null || in_array($rule->categoryid,$categories)) ;

                    if($rulelogiccheck){
                        if($rule->donotnotify == 1){
                            return; //-if rules matches ans has this flag then no notification must be sent
                        }

                        $sendnotification = true;

                        //-getting message details (it's an html might be heavy, so I just get it here)
                        $msgdetails = $rulesbiz->get_rule_message_by_id($rule->id);

                        $subjecttouse = $msgdetails->mailsubject;
                        $bodytouse = $msgdetails->message;
                        $fromtouse = $msgdetails->fromfield;

                        //-if some fileds are not set I use default values
                        if (empty($subjecttouse)){
                            $subjecttouse = get_config('local_enrolnotify','defaultsubject');
                        }
                        if(empty($bodytouse)){
                            $bodytouse = get_config('local_enrolnotify','defaultmessage');
                        }
                        if(empty($fromtouse)){
                            $fromtouse = $CFG->noreplyaddress;
                        }

                        break;
                    }
                }
            }

            if($sendnotification){
                $placeholderreplacer = new local_enrolnotify_placeholder_replacer($userEnrolled,$course);
            
                $mailSubject = $placeholderreplacer->Process_text($subjecttouse);
                $mailBody = $placeholderreplacer->Process_text($bodytouse);
                $from = $placeholderreplacer->Process_text($fromtouse);
    
                email_to_user($userEnrolled,$from,$mailSubject,$mailBody,$mailBody);
            }

            return true;
        }
    }

} 
