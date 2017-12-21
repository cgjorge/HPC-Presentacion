<?php

/**
 * Formidable Forms Securimage-WP Addon
 *
 */
class SecurimageWPFormidableAddon
{
    private static $_instance;

    public static function register()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        // register form field
        add_filter('frm_available_fields', array(&$this, 'addFormField'), 10, 1);

        // show captcha input
        add_action('frm_form_fields', array(&$this, 'showCaptcha'), 10, 3);

        // form captcha validation
        add_filter('frm_validate_field_entry', array(&$this, 'validate'), 99, 4);
    }

    public function addFormField($fields)
    {
        $fields['securimage_wp'] = __('Securimage-WP', 'Securimage-WP');

        return $fields;
    }

    public function showCaptcha($field, $field_name, $params)
    {
        if ($field['type'] != 'securimage_wp') return;

        $html = siwp_captcha_shortcode(array());

        $html = preg_replace('/siwp_captcha_value_\d+/', 'field_' . $field['field_key'], $html);
        $html = str_replace('siwp_captcha_value', $field_name, $html);

        echo $html;
    }

    public function validate($errors, $posted_field, $value, $args)
    {
        if ($posted_field->type != 'securimage_wp') return $errors;

        if (sizeof($errors) == 0) {
            // validate captcha if no other form errors
            $_POST['siwp_captcha_value'] = $value;

            $error = '';
            $failed  = (bool)(siwp_check_captcha($error) == false);

            if ($failed) {
                $errors['field' . $args['id']] = $error;
            }
        }

        return $errors;
    }
}
