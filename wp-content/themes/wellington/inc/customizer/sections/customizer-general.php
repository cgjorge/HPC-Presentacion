<?php
/**
 * General Settings
 *
 * Register General section, settings and controls for Theme Customizer
 *
 * @package Wellington
 */

/**
 * Adds all general settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function wellington_customize_register_general_settings( $wp_customize ) {

	// Add Section for Theme Options.
	$wp_customize->add_section( 'wellington_section_general', array(
		'title'    => esc_html__( 'General Settings', 'wellington' ),
		'priority' => 10,
		'panel'    => 'wellington_options_panel',
	) );

	// Add Settings and Controls for Layout.
	$wp_customize->add_setting( 'wellington_theme_options[layout]', array(
		'default'           => 'right-sidebar',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wellington_sanitize_select',
	) );

	$wp_customize->add_control( 'wellington_theme_options[layout]', array(
		'label'    => esc_html__( 'Theme Layout', 'wellington' ),
		'section'  => 'wellington_section_general',
		'settings' => 'wellington_theme_options[layout]',
		'type'     => 'radio',
		'priority' => 10,
		'choices'  => array(
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'wellington' ),
			'right-sidebar' => esc_html__( 'Right Sidebar', 'wellington' ),
		),
	) );
}
add_action( 'customize_register', 'wellington_customize_register_general_settings' );
