# Enrolnotify

**EnrolNotify** is a Moodle plugin that generates email notifications for students whenever they are enrolled in a course by any means.

In its simplest configuration notifications are produced for every student and any course. Optionally it's possible to set up rules for notifications to be produced only in specific conditions (or not produced) with the possibility to specify custom messages for each rule.

## Installation

Copy the contents of the repository in the `YOURMOODLEDIR/local/enrolnotify` folder in your moodle installation. then login into moodle as administrator to let it install itself.

## Configuration

you can configure the plugin from *Site Administration > Plugins > Local Plugin > Enrol Notifier*

There it's possible to set the default message and subject of the notification mail. You can use placeholders for details pertaining to the enrolment like student or course name. Placeholders are enclosed by a double curly bracket

some of the properties enabled:
`{{user.firstname}}` User Firstname
`{{user.lastname}}` User Lastname
`{{user.email}}` User EMail
`{{user.username}}` Username
`{{course.fullname}}` Full name of the course
`{{course.url}}` Course url without protocol ("http://")
`{{course.id}}` Course Id (useful to make urls)
`{{siteurl}}`  Base site url without protocol ("http://")

Protocol is omitted becaue it gets added by the editor when you insert links. For course and user every other database column is also accessible (should you need any of them for a reason).

## Notification rules

If no rules are set notifications will be sent for every student on every enrollment using the default message entered in the configuration screen.

Otherwise it's possible to specify **rules** for the notifications.

Every rule can have the following conditions to check:
* Course category of the course
* User cohort
* User or course id (mostly for test purposes)

If more than one is specified for a rule they need to be valid at the same time to qualify.

Rules are checked in order of priority (the lowest the number the earlier it is checked). If at least one rule exists, then events that don't match any rule **will not** generate notifications. it is possible to specify a rule with no conditions which is always valid.

Rules can specify a different message body and subject from the default. It is also posssible to specify a different sender from the site default (if applicable by mail settings).

It is also possible to flag a rule to not send notifications, in that case if the rule is chosen for an enrollment no notifications will be sent, useful to create specific exclusions

