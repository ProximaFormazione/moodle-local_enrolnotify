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

// //decomment for test
// $course = new stdClass();
// $user = new stdClass();

// $user->name = 'Mario';
// $user->COGNOME = 'Rossi';
// $course->name = 'Idraulica per principianti';
// $course->url = 'http://localhost/vattelapesca';


// $replacer = new local_enrolnotify_placeholder_replacer($user,$course);

// $testtext = 'buongiono signor {{user.NaME}} {{ user.COGNOME }},

// lei e\' appena stato iscritto al corso <strong>"{{ course.name}}"</strong>, per accedere puo\' usare il link {{course.url }}.';

// echo $replacer->Process_text($testtext);



/**
 * This class handles replacing placeholder strings in texts for usage in generating messages pertaining enrolment events, requires an user and course objects.
 * @copyright  2022 Proxima s.r.l. (https://www.proximaformazione.it/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_enrolnotify_placeholder_replacer {

    /**
     * An array with all the substitutions to do, is populated via reflection. keys have na object identifier
     */
    private $substarray = [];

    /**
     * Class constructor. Receives and validates information received through a
     * web form submission.
     
     */
    function __construct(stdclass $user, stdclass $course)
    {
        //-while we could have generalised this more and passed an array of stdobjects, i prefer to have them explicit in this case
        
        //-this pattern to remove protocol from url, because the htmleditor adds it to links
        $noprotocolurlpattern = '/.*\/\//';

        //-we use reflection to deserialize the objects
        $userpropinfo = get_object_vars($user);
        $coursepropinfo = get_object_vars($course);

        //-we compile an array with OBJECT.PROPERTY as keys and the value of that property
        foreach ($userpropinfo as $key => $value) {
            $this->substarray['user.'.$key] = $value;
        }
        //-password is encrypted anyways, let's not disclose the hash
        $this->substarray['user.password'] = '***';

        foreach ($coursepropinfo as $key => $value) {
            $this->substarray['course.'.$key] = $value;
        }
        //-course URL is widely used, i'll just put it in even if the record does not have it
        $coursemoodleurl = new moodle_url('/course/view.php',['id'=>$course->id]);
        $this->substarray['course.url'] = preg_replace($noprotocolurlpattern,'',$coursemoodleurl->out(true));

        //-base url might be useful for manually creating other links
        $sitemoodleurl = new moodle_url('/');
        $this->substarray['siteurl'] = preg_replace($noprotocolurlpattern,'',$sitemoodleurl->out(true));
    }

    /**
     * processes the text using the data from the objects saved in this class
     *
     * @return  string the string with all occourences of placeholders that match object properties replaced with object values.
     * placeholder are written with the syntax {{OBJECT.PROPERTY}} case insensitive where OBJECT can be user or course, and PROPERTY is the property in the php class
     */
    public function Process_text(string $text){
        $toret = $text;

        foreach ($this->substarray as $search => $replace) {
            
            //-spaces are allowed between brackets and identifier, case insentitive cause we don't know how people might serialize objects
            $pattern = '/{{\s*'.$search.'\s*}}/i';

            $toret = preg_replace($pattern,$replace,$toret);

        }

        return $toret;
    }
 }
