<?php

/*  Copyright (C) 2016 Drew Phillips  (http://phpcaptcha.org/download/securimage-wp.zip)

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

$captchaId = (isset($_GET['id']) && strlen($_GET['id']) == 40) ?
             $_GET['id'] :
             sha1(uniqid($_SERVER['REMOTE_ADDR'] . $_SERVER['REMOTE_PORT']));

//set_error_handler(array(&$img, 'errorHandler')); // set this early, WP omits a lot of warnings and errors

require_once dirname(__FILE__) . '/../../../../wp-load.php'; // backwards "lib/securimage-wp/plugins/wp-content/"

if (get_option('siwp_disable_audio', 0) == 1) {
    exit;
}

$audio_lang = get_option('siwp_audio_lang', 'en');
$audio_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'audio' . DIRECTORY_SEPARATOR . $audio_lang;

// mp3 or wav format
$format   = (isset($_GET['format']) && strtolower($_GET['format']) == 'mp3') ? 'mp3' : null;
$lame_bin = get_option('siwp_lame_binary_path', siwp_find_lame_binary());

if ($format == 'mp3' && (empty($lame_bin) || !is_executable($lame_bin))) {
    $format = 'wav';
}

$options = array(
    'captchaId'  => $captchaId,
    'audio_path' => $audio_path,
);

$img = siwp_get_securimage_object($options);
$img::$lame_binary_path = $lame_bin;

$img->outputAudioFile($format);
