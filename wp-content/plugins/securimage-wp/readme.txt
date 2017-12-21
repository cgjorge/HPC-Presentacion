=== Securimage-WP ===
Contributors: drew010
Author URI: http://phpcaptcha.org
Donate link: http://www.phpcaptcha.org/donate/
Tags: CAPTCHA, comments, spam protection, comment form, registration, register
Requires at least: 4.0
Tested up to: 4.9
Stable tag: 3.6.13

Block comment spam and fake registrations by adding the powerful CAPTCHA protection of Securimage-WP to your WordPress site.

== Description ==

Built from the open-source [Securimage PHP Captcha](https://www.phpcaptcha.org/ "Securimage PHP CAPTCHA"), this plugin allows you to add CAPTCHA protection to your WordPress site.  This plugin gives you the option to add CAPTCHA images to your comment, registration, login, and/or signup forms on your site.  You can also add CAPTCHA protection to any post or page using a shortcode provided by the plugin.

The image appearance can be easily customized to match your site's look and feel from the WordPress Settings menu.

Securimage-WP also has the ability to stream secure, high-quality, dynamic audio CAPTCHAs to visitors using HTML5 audio tags or Flash.

Features Include:

*   Protect comment, registration, login, or lost password forms
*   Shortcode support
*   Customize code-length, image dimensions, colors and distortion factors from a menu
*   Word or math based CAPTCHA images and audio
*   Add a custom signature to your images
*   Stream audio using HTML5 (compatible with mobile) with optional Flash fallback
*   Easily add CSS classes and styles to the CAPTCHA inputs
*   Select the sequence of the CAPTCHA inputs to match your site layout
*   Allows pingbacks and trackbacks, and replies from administration panel
*   Doesn't require cookies or PHP session support; codes are stored in the WordPress database
*   Works with BuddyPress
*   Contact Form 7 Integration - Add Securimage to your CF7 forms with the [securimage_wp] tag
*   Formidable Forms integration - Add Securimage with a single click
*   Supports multiple captchas on a single post or page

Requirements:

*   WordPress 3.0 or greater
*   Requires PHP 5.2+ with GD and FreeType

About This Plugin:

This plugin was developed by Drew Phillips, the developer of [Securimage PHP CAPTCHA](https://www.phpcaptcha.org/).  Securimage is completely free and open-source for the community and your use, as is this WordPress plugin.  If you find either of these things useful, please consider [donating](https://www.phpcaptcha.org/donate).  Thank you for using this plugin!

== Installation ==

Installation of Securimage-WP is simple.

1. From the `Plugins` menu, select `Add New` and then `Upload`.  Select the .zip file containing Securimage-WP.  Alternatively, you can upload the `securimage-wp` directory to your `/wp-content/plugins` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Customize the CAPTCHA options from `Securimage-WP` under the WordPress `Settings` menu.

== Frequently Asked Questions ==

= What are the requirements? =

Securimage-WP requires `PHP 5.2+`, `GD2`, `FreeType`, and `WordPress 3+`.
If you install Securimage-WP, there is a test script that will tell you whether or not your system meets the requirements.

= The CAPTCHA image appears broken =

From the Securimage-WP settings menu, enable the `Debug Image Errors` option, save the settings, and then click the link labeled `View Image Directly`.  Ideally, this will reveal any error messages that may be causing the image generation to fail.  Try to troubleshoot the error, or contact us for assistance.

= Can I display a CAPTCHA somewhere other than the comment or registration forms? =

Yes, since version 3.6.1 you can display a captcha using the shortcode `[siwp_show_captcha]` anywhere on your WordPress site.

To validate the user's input, call the function siwp_check_captcha.  Note: To validate from a WordPress page, you will need a plugin like Exec-PHP installed, or your PHP form processor needs to hook into WordPress (typically by including wp-load.php from your PHP script).

See [here](https://gist.github.com/dapphp/ab9016409535a6638816) for an example WordPress page with a simple form and captcha with validation.

= I enabled the captcha on my comment form, registration page, login form, or lost password form but no captcha image appears =

Securimage-WP relies on some standard function hooks for displaying the CAPTCHA.  If the image doesn't appear on your site's forms, it may be due to those templates not implementing the proper hooks.

To fix this, you can either edit your templates to include the proper hooks, or if the site uses a custom registration page, use the `[siwp_show_captcha]` shortcode on your registration form.

For the comment form, the proper hook needed is `<?php do_action( 'comment_form', $post_id ); ?>`

For the registration form, the proper hook needed is `<?php do_action( 'register_form' ); ?>`

The calls to these actions should go in the template where you want the CAPTCHA image to appear.

= How to install audio files for CAPTCHA audio =

Automatic installation of audio files may not work for a number of reasons (e.g. directories not writable by the server, http wrapper not enabled for fopen/file_get_contents, low memory limits) but this does not mean audio files cannot be used.

If automatic installation is not available, audio files can be downloaded from [https://www.phpcaptcha.org/download](https://www.phpcaptcha.org/download) and manually placed in the Securimage-WP plugin directory.

To install audio files, extract the contents of the language pack you wish to use to the `wp-content/plugins/securimage-wp/lib` directory preserving the directory structure from the audio package (so the resulting directories are `lib/audio/en`, `lib/audio/de`, `lib/audio/fr` etc).

= Audio FAQ/General Info =

Since version 3.6.4 HTML5 audio is used for better browser support without the need for plugins.  Consider the following when using HTML5 audio streaming:

- Audio files are generated in WAV format which is supported by all browsers except Internet Explorer
- To support Internet Explorer 9+ using HTML5 audio, audio files can be streamed in MP3 format if the LAME MP3 encoder is installed on the system
- To support older browsers without HTML5 audio capability, optional Flash fallback can be used 
- If LAME is not available, browsers that don't support WAV or HTML5 audio, Flash fallback will be used, or if disabled, the audio button will be hidden
- If possible, install LAME for MP3 output since the resulting audio files are smaller and will use less bandwidth (average 30-60 KB versus 200-300 KB for WAV files)
- HTML5 audio playback requires Javascript to be enabled.  If Javascript is disabled the audio button links to an audio download
- To install LAME on Windows, download the LAME bundle from RareWares (http://www.rarewares.org/mp3-lame-bundle.php)
- To install LAME on Linux, either compile from source or install using your package manager (e.g. Debian/Ubuntu: apt-get install lame; CentOS: yum install lame)
- Securimage-WP needs to know where LAME is installed on your system which is configured from the Securimage-WP settings menu 

= The refresh button does not work =

Javascript must be enabled for the refresh buttons to work.  Make sure Javascript is enabled or check for errors that may prevent it from functioning.

= I noticed the image refresh by itself when I was looking at my comment form =

CAPTCHA codes have expiration times in order to reduce the amount of time spammers have to break the CAPTCHA.  The default time is 15 minutes.  After this time lapses, the CAPTCHA refreshes since it is no longer valid.  You can customize this setting in the options menu.

== Screenshots ==

1. Securimage-WP shown on a comment form
2. A math CAPTCHA with custom text instead of a refresh button in the Twenty Ten theme
3. A CAPTCHA customized to use a CSS border and margin
4. Admin options to control image appearance
5. Miscellanous options for captcha functionality and look
6. CAPTCHA on the registration form

== Changelog ==

= 3.6.13-WP =
* Eliminate warnings checking for lame binary when open_basedir restriction is in effect
* Fix potential warnings when re-activating plugin and duplicate indexes for created column when re-activiting plugin
* Remove additional javascript anti-bot check
* Test up to 4.9

= 3.6.12-WP =
* Fix plugin URL functions to use plugins_url() for proper https urls

= 3.6.11-WP =
* Skipped

= 3.6.10-WP =
* Fix warning in securimage-wp.php - can't use return value in write context

= 3.6.9-WP =
* Upgrade Securimage library to 4.0
* Switch over to Securimage WordPress storage adapter for database access
* Test with WordPress 4.7 and 4.8-alpha

= 3.6.7-WP =
* Add Contact Form 7 integration.  Easily add Securimage-WP to your CF7 forms
* Add Formidable forms integration.  Easily add Securimage-WP to Formidable Forms
* Fix messages emitted from PHP 5.3 strict standards
* Fix errors with wp_enqueue_script and wp_enqueue_style calls
* WordPress 4.4 fix - enqueue audio script on login page if audio enabled

= 3.6.6-WP =
* Fix audio streaming on iOS devices; upgrade Securimage library to 3.6.2

= 3.6.5-WP =
* Fix tabindex on audio play button so it is excluded
* Add Spanish and Chilean Spanish language to available audio languages

= 3.6.4-WP =
* HTML5 audio support
* Ability to stream audio as MP3 (requires LAME encoder, see FAQ)

= 3.6.3-WP =
* Compatibility with BuddyPress registration form
* Disable audio by default and remove audio files from distribution
* Automatic language pack installation from plugin options page

= 3.6.2-WP =
* Add options to protect login and lost password forms
* Add plugin stats (number of captchas displayed, passed, and failed)
* Cleanup/improve options page

= 3.6.1-WP =
* Add `[siwp_show_captcha]` shortcode for displaying a captcha in any WordPress post or page

= 3.6-WP =
* Add option to protect site registration form
* WordPress 4.2 compatibility

= 3.5.4-WP =
* Confirm compatibilty with WordPress 4.1.1
* Upgrade Securimage code to 3.5.4

= 3.5.1-WP =
* Fix potential XSS vulnerability in siwp_test.php
* Upgrade Securimage library to latest version

= 3.2-WP =
* Initial release of WordPress plugin

== Upgrade Notice ==

None yet!
