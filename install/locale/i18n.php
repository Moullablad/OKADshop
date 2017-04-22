<?php
/*
   Copyright (c) 2003,2004,2005,2009 Danilo Segan <danilo@kvota.net>.
   Copyright (c) 2005,2006 Steven Armstrong <sa@c-area.ch>

   This file is part of PHP-gettext.

   PHP-gettext is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   PHP-gettext is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with PHP-gettext; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/
// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
session_unset();

session_start();

include 'gettext/gettext.inc';

//i18n change langue
if (isset($_POST['default_lang'])) {
  $_SESSION['default_lang'] = $_POST['default_lang'];
}

//set encoding
$encoding = 'UTF-8';
$locale = (isset($_SESSION['default_lang'])) ? $_SESSION['default_lang'] : "en_US";
$direction = (isset($_SESSION['default_lang']) && $_SESSION['default_lang'] == "ar_AR") ? 'rtl' : "ltr";
putenv("LANGUAGE=$locale");

// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
$domain = 'messages';
T_bindtextdomain($domain, 'locale');
T_bind_textdomain_codeset($domain, $encoding);
T_textdomain($domain);

header("Content-type: text/html; charset=$encoding");
?>
