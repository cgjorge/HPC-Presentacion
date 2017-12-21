<?php

/*  Copyright (C) 2015 Drew Phillips  (http://phpcaptcha.org/download/securimage-wp.zip)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once dirname(__FILE__) . '/../../../../wp-load.php'; // backwards "lib/securimage-wp/plugins/wp-content/"

if (get_option('siwp_debug_image', 0) == 1) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if (!defined('WP_DEBUG'))
        define('WP_DEBUG', 1);
} else {
    ini_set('display_errors', 0);
}

$captchaId = (isset($_GET['id']) && strlen($_GET['id']) == 40) ?
              $_GET['id'] :
              sha1(uniqid($_SERVER['REMOTE_ADDR'] . $_SERVER['REMOTE_PORT']));

$captcha_type = (get_option('siwp_use_math', 0) == 1) ? 1 : 0;

$options = array(
    'captcha_type' => $captcha_type,
    'captchaId'    => $captchaId,
);

$img = siwp_get_securimage_object($options);

if (get_option('siwp_randomize_background', 0) == 1) {
    $img->background_directory = dirname(__FILE__) . '/backgrounds/';
}

update_site_option('siwp_stat_displayed', (int)get_site_option('siwp_stat_displayed') + 1);

$img->show(); // alternate use:  $img->show('/path/to/background_image.jpg');
