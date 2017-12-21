<?php

class SecurimageWPCF7Service extends WPCF7_Service {
    private static $instance;

    public static function get_instance() {
        if ( empty( self::$instance ) ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function register_service() {
        $service     = SecurimageWPCF7Service::get_instance();
        $integration = WPCF7_Integration::get_instance();
        $integration->add_service('securimage_wp', $service);

        wpcf7_add_form_tag(array('securimage_wp', 'securimage_wp*'), array(&$service, 'shortcode_handler'), true);
        add_filter('wpcf7_validate_securimage_wp', array(&$service, 'validate'), 20, 2);
        add_filter('wpcf7_validate_securimage_wp*', array(&$service, 'validate'), 20, 2);
        add_action('wpcf7_admin_init', array(&$service, 'add_tag_generator'), 45);
    }

    public function add_tag_generator() {
        $tag_generator = WPCF7_TagGenerator::get_instance();
        $tag_generator->add(
            'securimage',
            __( 'Securimage-WP', 'securimage-wp' ),
            array(&$this, 'tag_generator'),
            array('name' => 'securimage_wp')
        );
    }

    public function shortcode_handler($tag) {
        $html = siwp_captcha_shortcode(array());
        $html = '<span class="wpcf7-form-control-wrap securimage_wp"></span>' . $html;

        return $html;
    }

    public function validate($result, $tag) {
        // do not validate captcha unless the form is valid
        if (!$result->is_valid()) return $result;

        $error = '';
        $failed  = (bool)(siwp_check_captcha($error) == false);

        if ($failed) {
            $tag['name'] = 'securimage_wp';
            $result->invalidate($tag, $error);
        }

        return $result;
    }


    public function is_active() {
        return true;
    }

    public function get_title() {
        return __( 'Securimage-WP', 'securimage-wp' );
    }

    public function get_categories() {
        return array('captcha');
    }

    public function icon() {
    }

    public function link() {
        echo sprintf( '<a href="%1$s">%2$s</a>',
            'https://wordpress.org/plugins/securimage-wp/',
            __('Securimage-WP Plugin', 'securimage-wp'));
    }

    private function menu_page_url($args = '') {
        $args = wp_parse_args($args, array());

        $url = menu_page_url('securimage-wp', false);

        if (!empty($args)) {
            $url = add_query_arg($args, $url);
        }

        return $url;
    }

    public function load($action = '') {

    }

    public function admin_notice($message = '') {
        if ('invalid' == $message) {
            echo sprintf(
                '<div class="error notice notice-error is-dismissible"><p><strong>%1$s</strong>: %2$s</p></div>',
                esc_html(__("ERROR", 'contact-form-7')),
                esc_html(__("Invalid key values.", 'contact-form-7')));
        }

        if ('success' == $message) {
            echo sprintf('<div class="updated notice notice-success is-dismissible"><p>%s</p></div>',
                esc_html(__( 'Settings saved.', 'contact-form-7' )));
        }
    }

    public function display($action = '') {
    ?>

        <p><?php echo esc_html(__( "Securimage is a widely used, self-hosted, open-source PHP CAPTCHA.", 'securimage-wp')); ?></p>
        <p><?php echo esc_html(__( "To customize the CAPTCHA appearance on your contact form, go to Settings &gt;&gt; Securimage-WP.", 'securimage-wp')); ?></p>
        <p><?php echo sprintf(esc_html(__( "For more details, see %s.", 'contact-form-7')), wpcf7_link(__('https://wordpress.org/plugins/securimage-wp/', 'contact-form-7'), __('Securimage-WP WordPress Plugin', 'securimage-wp'))); ?></p>

        <?php
    }

    public function tag_generator($contact_form, $args = '') {
        $args = wp_parse_args($args, array());

        $description = __("Generate a form-tag for a Securimage-WP captcha image. For more details, see %s.", 'contact-form-7');

        $desc_link = wpcf7_link(__('https://wordpress.org/plugins/seurimage-wp/', 'contact-form-7'), __('Securimage-WP', 'securimage-wp'));

        ?>
        <div class="control-box">
        <fieldset>
        <legend><?php echo sprintf(esc_html($description), $desc_link); ?></legend>
        <p>
          The [securimage_wp] tag does not yet support any options.<br><br>
          To customize the appearance of the CAPTCHA, go to <em>Settings &raquo; Securimage-WP</em>
        </p>
        </fieldset>
        </div>

        <div class="insert-box">
            <input type="text" name="securimage_wp" class="tag code" readonly="readonly" onfocus="this.select()" />

            <div class="submitbox">
            <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr(__( 'Insert Tag', 'contact-form-7')); ?>">
            </div>
        </div>
        <?php
    }
}
