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

defined('MOODLE_INTERNAL') || die();

class local_enrolnotify_observer {

    public static function user_enrolment_created(\core\event\user_enrolment_created $event) {
        global $USER, $DB, $CFG;

        if(get_config('local_enrolnotify','enableplugin') == '1' && $event->relateduserid == 2994){ //-prototipo: mando la mail solo all'utente mattia.mele
            $userEnrolled = $DB->get_record('user',['id' => $event->relateduserid]);
            $course = $DB->get_record('course',['id' => $event->courseid]);

            $placeholderreplacer = new local_enrolnotify_placeholder_replacer($userEnrolled,$course);
            
            $mailSubject = $placeholderreplacer->Process_text(get_config('local_enrolnotify','defaultsubject'));
            $mailBody = $placeholderreplacer->Process_text(get_config('local_enrolnotify','defaultmessage'));
            $from = $CFG->noreplyaddress;

            email_to_user($userEnrolled,$from,$mailSubject,$mailBody,$mailBody);

            return true;
        }
    }

} 
