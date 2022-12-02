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

function xmldb_local_enrolnotify_upgrade($oldversion) {
    global $DB;
 
    $dbman = $DB->get_manager();
 
    if ($oldversion < 2022120203) {

        // Define table local_enrolnotify_rule to be created.
        $table = new xmldb_table('local_enrolnotify_rule');

        // Adding fields to table local_enrolnotify_rule.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('priority', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('donotnotify', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('mailsubject', XMLDB_TYPE_CHAR, '256', null, null, null, null);
        $table->add_field('message', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('fromfield', XMLDB_TYPE_CHAR, '512', null, null, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('categoryid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('cohortid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table local_enrolnotify_rule.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Adding indexes to table local_enrolnotify_rule.
        $table->add_index('i_priority', XMLDB_INDEX_UNIQUE, ['priority']);

        // Conditionally launch create table for local_enrolnotify_rule.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Enrolnotify savepoint reached.
        upgrade_plugin_savepoint(true, 2022120203, 'local', 'enrolnotify');
    }


    return true;
}