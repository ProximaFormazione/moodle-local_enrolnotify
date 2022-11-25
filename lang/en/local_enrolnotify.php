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


$string['pluginname'] = 'Enrol Notifier';
$string['config_enableplugin'] = 'Enable Plugin';
$string['config_enableplugin_desc'] = 'Enable or deactivate all notifications';
$string['config_gotoindex'] = 'Go to rule and message settings';
$string['config_defaultsubject'] = 'Default subject';
$string['config_defaultsubject_desc'] = 'Default subject for new rules';
$string['config_defaultsubject_default'] = 'Course enrolment';
$string['config_defaultmessage'] = 'Default message';
$string['config_defaultmessage_desc'] = 'Default message for new rules';
$string['config_defaultmessage_default'] = 'You have been enrolled in a course';
$string['placeholder_description']= 'you can insert placeholders in the body and/or subject with the syntax <code>{{PROPERTY}}</code>. (mind the double brackets)<br>
some of the properties enabled:<br>
<code>{{user.firstname}}</code> User Firstname
<code>{{user.lastname}}</code> User Lastname<br>
<code>{{user.email}}</code> User EMail<br>
<code>{{user.username}}</code> Username<br>
<code>{{course.fullname}}</code> Full name of the course<br>
<code>{{course.url}}</code> Course url without protocol ("http://")<br>
<code>{{course.id}}</code> Course Id (useful to make urls)<br>
<code>{{siteurl}}</code>  Base site url without protocol ("http://")<br>
Protocol is omitted becaue it gets added by the editor when you insert links<br>
All other properties of user and course entities are likewise accessible, refer to Moodle dev documentation for a full list';
