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


$string['pluginname'] = 'Notificatore iscrizioni';
$string['config_enableplugin'] = 'Attiva Plugin';
$string['config_enableplugin_desc'] = 'Attiva o disattiva tutte le notifiche';
$string['config_gotoindex'] = 'Vai ai settaggi di regole e messaggi';
$string['config_defaultsubject'] = 'Oggetto di default';
$string['config_defaultsubject_desc'] = 'Oggetto iniziale nella maschera per le nuove regole';
$string['config_defaultsubject_default'] = 'Iscrizione corso';
$string['config_defaultmessage'] = 'Messaggio di default';
$string['config_defaultmessage_desc'] = 'Messaggio base per le nuove regole';
$string['config_defaultmessage_default'] = 'Sei stata/o iscritta/o ad un corso';
$string['placeholder_description']= 'Puoi inserire dati contestuali nel messaggio e/o nel soggetto usando la sintassi <code>{{PROPERTY}}</code>. (occhio alle doppie parentesi)<br>
Alcune delle propieta\' abilitate:<br>
<code>{{user.firstname}}</code> Nome Utente<br>
<code>{{user.lastname}}</code> Cognome Utente<br>
<code>{{user.email}}</code> Email dell\' Utente<br>
<code>{{user.username}}</code> Username Utente<br>
<code>{{course.fullname}}</code> Nome lungo del corso<br>
<code>{{course.url}}</code> Url del corso senza il protocollo (tipo "http://")<br>
<code>{{course.id}}</code> Id del corso (utile per creare url)<br>
<code>{{siteurl}}</code> Url base del sito senza il protocollo (tipo "http://")<br>
il protocollo e\' omesso dalle url perche\' se fate un link moodle lo aggiunge<br>
Sono similmente accessibili anche tutte le altre propieta\' delle tabelle base, consultare la documentazione ufficiale Moodle per una lista completa';