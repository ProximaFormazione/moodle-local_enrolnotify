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
$string['config_defaultsubject_desc'] = 'Default subject used if not specified otherwise';
$string['config_defaultsubject_default'] = 'Course enrolment';
$string['config_defaultmessage'] = 'Default message';
$string['config_defaultmessage_desc'] = 'Default message used if not specified otherwise';
$string['config_defaultmessage_default'] = 'You have been enrolled in a course';
$string['placeholder_description']= 'you can insert placeholders with the syntax <code>{{PROPERTY}}</code>. (mind the double brackets)<br>
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
$string['rule_categoryid'] = 'Only if category';
$string['rule_cohortid'] = 'Only if cohort';
$string['rule_courseid'] = 'Only if course';
$string['rule_donotnotify'] = 'Do not send notification if rules applies';
$string['rule_fromfield'] = 'Sender message';
$string['rule_mailsubject'] = 'Mail subject';
$string['rule_message'] = 'Mail body';
$string['rule_priority'] = 'Rule order value (better if not consecutives)';
$string['rule_userid'] = 'Only if user id';
$string['ruleform_priority_description'] = 'Priority of the rule, the lower is is the more important. There cannot be two rules with the same priority. It is advised to not use consecutive numbers to facilitate insertions of new rules. If left blank the new rule will be added at the bottom';
$string['ruleform_rules_title'] = 'Rule criterions, blank fields won\'t be checked';
$string['ruleform_maildetails_title'] = 'Notification details, if blank the default will be used';
$string['ruleeditpage_header'] = 'Rule edit';
$string['rulespage_add_rule'] = 'Add rule';
$string['rulespage_colheader_rule'] = 'Rule';
$string['rulespage_delete_rule'] = 'Delete rule';
$string['rulespage_disclaimerelse'] = 'If no rules matches no notification will be sent';
$string['rulespage_elselabel'] = 'Else';
$string['rulespage_explanation'] = 'Each rule has its own personalised message';
$string['rulespage_header'] = 'Notification rules';
$string['rulespage_norules'] = 'No rules set. Notifications will be sent for all users with the default message';
$string['rulespage_title'] = 'Custom message rules';
$string['rulestring_and'] = 'and';
$string['rulestring_category'] = 'course category is <strong>{$a}</strong>';
$string['rulestring_cohort'] = 'user cohort is <strong>{$a}</strong>';
$string['rulestring_course'] = 'course is <strong>{$a}</strong>';
$string['rulestring_donotnotify'] = '<strong>Do not notify</strong>';
$string['rulestring_if'] = 'If';
$string['rulestring_noconditions'] = 'for any enrollment';
$string['rulestring_user'] = 'user is <strong>{$a->firstname} {$a->lastname}</strong>';
