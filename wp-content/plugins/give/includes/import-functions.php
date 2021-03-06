<?php
/**
 * Import Functions
 *
 * @package     Give
 * @subpackage  Functions
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.8.14
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the Import report of the donations
 *
 * @since 1.8.13
 */
function give_import_donation_report() {
	return get_option( 'give_import_donation_report', array() );
}


/**
 * Update the Import report of the donations
 *
 * @since 1.8.13
 */
function give_import_donation_report_update( $value = array() ) {
	update_option( 'give_import_donation_report', $value );
}


/**
 * Delete the Import report of the donations
 *
 * @since 1.8.13
 */
function give_import_donation_report_reset() {
	update_option( 'give_import_donation_report', array() );
}

/**
 * Give get form data from csv if not then create and form and return the form value.
 *
 * @since 1.8.13.
 *
 * @param $data .
 *
 * @return array|bool|Give_Donate_Form|int|null|WP_Post
 */
function give_import_get_form_data_from_csv( $data, $import_setting = array() ) {
	$new_form = false;

	// Get the import report
	$report = give_import_donation_report();

	$form = false;
	$meta = array();

	if ( ! empty( $data['form_id'] ) ) {
		$form = new Give_Donate_Form( $data['form_id'] );
		// Add support to older php version.
		$form_id = $form->get_ID();
		if ( empty( $form_id ) ) {
			$report['duplicate_form'] = ( ! empty( $report['duplicate_form'] ) ? ( absint( $report['duplicate_form'] ) + 1 ) : 1 );
			$form                     = false;
		}
	}

	if ( false === $form && ! empty( $data['form_title'] ) ) {
		$form = get_page_by_title( $data['form_title'], OBJECT, 'give_forms' );

		if ( ! empty( $form->ID ) ) {

			$report['duplicate_form'] = ( ! empty( $report['duplicate_form'] ) ? ( absint( $report['duplicate_form'] ) + 1 ) : 1 );

			$form = new Give_Donate_Form( $form->ID );
		} else {
			$form                  = new Give_Donate_Form();
			$args                  = array(
				'post_title'  => $data['form_title'],
				'post_status' => 'publish',
			);
			$form                  = $form->create( $args );
			$report['create_form'] = ( ! empty( $report['create_form'] ) ? ( absint( $report['create_form'] ) + 1 ) : 1 );
			$new_form              = true;

		}

		$form = get_page_by_title( $data['form_title'], OBJECT, 'give_forms' );
		$form = new Give_Donate_Form( $form->ID );
	}

	if ( ! empty( $form ) && $form->get_ID() ) {
		if ( ! empty( $data['form_level'] ) && 'custom' != (string) strtolower( $data['form_level'] ) ) {
			$prices     = (array) $form->get_prices();
			$price_text = array();
			foreach ( $prices as $key => $price ) {
				if ( isset( $price['_give_id']['level_id'] ) ) {
					$price_text[ $price['_give_id']['level_id'] ] = ( ! empty( $price['_give_text'] ) ? $price['_give_text'] : '' );
				}
			}

			if ( ! in_array( $data['form_level'], $price_text ) ) {

				// For generating unquiet level id.
				$count     = 1;
				$new_level = count( $prices ) + $count;
				while ( array_key_exists( $new_level, $price_text ) ) {
					$count ++;
					$new_level = count( $prices ) + $count;
				}

				$multi_level_donations = array(
					array(
						'_give_id'     => array(
							'level_id' => $new_level,
						),
						'_give_amount' => give_sanitize_amount_for_db( $data['amount'] ),
						'_give_text'   => $data['form_level'],
					),
				);

				$price_text[ $new_level ] = $data['form_level'];

				if ( ! empty( $prices ) && is_array( $prices ) && ! empty( $prices[0] ) ) {
					$prices = wp_parse_args( $multi_level_donations, $prices );

					// Sort $prices by amount in ascending order.
					$prices = wp_list_sort( $prices, '_give_amount', 'ASC' );
				} else {
					$prices = $multi_level_donations;
				}

				// Unset _give_default key from $prices.
				foreach ( $prices as $key => $price ) {
					if ( isset( $prices[ $key ]['_give_default'] ) ) {
						unset( $prices[ $key ]['_give_default'] );
					}
				}

				// Set the first $price of the $prices as defalut.
				$prices[0]['_give_default'] = 'default';
			}
			$form->price_id = array_search( $data['form_level'], $price_text );

			$donation_levels_amounts = wp_list_pluck( $prices, '_give_amount' );
			$min_amount              = min( $donation_levels_amounts );
			$max_amount              = max( $donation_levels_amounts );

			$meta = array(
				'_give_levels_minimum_amount' => $min_amount,
				'_give_levels_maximum_amount' => $max_amount,
				'_give_price_option'          => 'multi',
				'_give_donation_levels'       => array_values( $prices ),
			);
		} else {
			$form->price_id = 'custom';
		}

		$defaults = array(
			'_give_set_price'    => give_sanitize_amount_for_db( $data['amount'] ),
			'_give_price_option' => 'set',
		);

		// If new form is created.
		if ( ! empty( $new_form ) ) {
			$new_form = array(
				'_give_custom_amount_text' => ( ! empty( $data['form_custom_amount_text'] ) ? $data['form_custom_amount_text'] : 'Custom' ),
				'_give_logged_in_only'     => 'enabled',
				'_give_custom_amount'      => 'enabled',
				'_give_payment_import'     => true,
				'_give_display_style'      => 'radios',
				'_give_payment_display'    => 'onpage',
				'give_product_notes'       => 'Donation Notes',
				'_give_product_type'       => 'default',
				'_give_default_gateway'    => 'global',
				'_give_show_register_form' => 'both',
			);
			$defaults = wp_parse_args( $defaults, $new_form );
		}

		$meta = wp_parse_args( $meta, $defaults );

		foreach ( $meta as $key => $value ) {
			give_update_meta( $form->get_ID(), $key, $value );
		}
	}

	// update the report
	give_import_donation_report_update( $report );

	return $form;
}

/**
 * Give get user details if not then create a user. Used in Import Donation CSV.
 *
 * @since 1.8.13
 *
 * @param $data
 *
 * @return bool|false|WP_User
 */
function give_import_get_user_from_csv( $data, $import_setting = array() ) {
	$report      = give_import_donation_report();
	$donor_data  = false;
	$customer_id = false;

	// check if donor id is not empty
	if ( ! empty( $data['donor_id'] ) ) {
		$donor_data = new Give_Donor( (int) $data['donor_id'] );
		if ( ! empty( $donor_data->id ) ) {
			$report['duplicate_donor'] = ( ! empty( $report['duplicate_donor'] ) ? ( absint( $report['duplicate_donor'] ) + 1 ) : 1 );
		}
	}

	if ( empty( $donor_data->id ) && ! empty( $data['user_id'] ) ) {
		$user_id    = (int) $data['user_id'];
		$donor_data = new Give_Donor( $user_id, true );


		if ( empty( $donor_data->id ) ) {
			$donor_data = get_user_by( 'id', $user_id );
			if ( ! empty( $donor_data->ID ) ) {
				$first_name = ( ! empty( $data['first_name'] ) ? $data['first_name'] : $donor_data->user_nicename );
				$last_name  = ( ! empty( $data['last_name'] ) ? $data['last_name'] : ( ( $lastname = get_user_meta( $donor_data->ID, 'last_name', true ) ) ? $lastname : '' ) );
				$name       = $first_name . ' ' . $last_name;
				$user_email = $donor_data->user_email;
				$donor_args = array(
					'name'    => $name,
					'email'   => $user_email,
					'user_id' => $user_id,
				);

				$donor_data = new Give_Donor();
				$donor_data->create( $donor_args );

				// Adding notes that donor is being imported from CSV.
				$current_user = wp_get_current_user();
				$donor_data->add_note( esc_html( wp_sprintf( __( 'This donor was imported by %s', 'give' ), $current_user->user_email ) ) );

				// Add is used to ensure duplicate emails are not added
				if ( $user_email != $data['email'] && ! empty( $data['email'] ) ) {
					$donor_data->add_meta( 'additional_email', $data['email'] );
				}

				$report['create_donor'] = ( ! empty( $report['create_donor'] ) ? ( absint( $report['create_donor'] ) + 1 ) : 1 );
			} else {
			}
		} else {
			// Add is used to ensure duplicate emails are not added
			if ( $donor_data->email != $data['email'] ) {
				$donor_data->add_meta( 'additional_email', ( ! empty( $data['email'] ) ? $data['email'] : $donor_data->email ) );
			}
			$report['duplicate_donor'] = ( ! empty( $report['duplicate_donor'] ) ? ( absint( $report['duplicate_donor'] ) + 1 ) : 1 );
		}
	}

	if ( empty( $donor_data->id ) && ! empty( $data['email'] ) ) {

		$donor_data = new Give_Donor( $data['email'] );
		if ( empty( $donor_data->id ) ) {
			$donor_data = get_user_by( 'email', $data['email'] );

			if ( empty( $donor_data->ID ) && ! empty( $data['first_name'] ) && ! empty( $data['last_name'] ) && isset( $import_setting['create_user'] ) && 1 === absint( $import_setting['create_user'] ) ) {
				$give_role  = (array) give_get_option( 'donor_default_user_role', get_option( 'default_role', ( ( $give_donor = wp_roles()->is_role( 'give_donor' ) ) && ! empty( $give_donor ) ? 'give_donor' : 'subscriber' ) ) );
				$donor_args = array(
					'user_login'      => $data['email'],
					'user_email'      => $data['email'],
					'user_registered' => date( 'Y-m-d H:i:s' ),
					'user_first'      => $data['first_name'],
					'user_last'       => $data['last_name'],
					'user_pass'       => wp_generate_password( 8, true ),
					'role'            => $give_role,
				);

				/**
				 * Filter to modify user data before new user id register.
				 *
				 * @since 1.8.13
				 */
				$donor_args = (array) apply_filters( 'give_import_insert_user_args', $donor_args, $data, $import_setting );

				// This action was added to remove the login when using the give register function.
				add_filter( 'give_log_user_in_on_register', 'give_log_user_in_on_register_callback', 11 );
				$customer_id = give_register_and_login_new_user( $donor_args );
				remove_filter( 'give_log_user_in_on_register', 'give_log_user_in_on_register_callback', 11 );

				update_user_meta( $customer_id, '_give_payment_import', true );
				$donor_data = new Give_Donor( $customer_id, true );
			} else {
				$customer_id = ( ! empty( $donor_data->ID ) ? $donor_data->ID : false );
			}

			if ( ! empty( $customer_id ) || ( isset( $import_setting['create_user'] ) && 0 === absint( $import_setting['create_user'] ) ) ) {
				$donor_data = new Give_Donor( $customer_id, true );

				if ( empty( $donor_data->id ) ) {

					if ( ! empty( $data['form_id'] ) ) {
						$form = new Give_Donate_Form( $data['form_id'] );
					}

					$payment_title = ( isset( $data['form_title'] ) ? $data['form_title'] : ( isset( $form ) ? $form->get_name() : esc_html__( 'New Form', 'give' ) ) );
					$donor_args    = array(
						'name'  => ! is_email( $payment_title ) ? $data['first_name'] . ' ' . $data['last_name'] : '',
						'email' => $data['email'],
					);

					if ( ! empty( $customer_id ) ) {
						$donor_args['user_id'] = $customer_id;
					}

					$donor_data->create( $donor_args );

					// Adding notes that donor is being imported from CSV.
					$current_user = wp_get_current_user();
					$donor_data->add_note( esc_html( wp_sprintf( __( 'This donor was imported by %s', 'give' ), $current_user->user_email ) ) );

					$report['create_donor'] = ( ! empty( $report['create_donor'] ) ? ( absint( $report['create_donor'] ) + 1 ) : 1 );
				} else {
					$report['duplicate_donor'] = ( ! empty( $report['duplicate_donor'] ) ? ( absint( $report['duplicate_donor'] ) + 1 ) : 1 );
				}
			}
		} else {
			$report['duplicate_donor'] = ( ! empty( $report['duplicate_donor'] ) ? ( absint( $report['duplicate_donor'] ) + 1 ) : 1 );
		}
	}

	// update the report
	give_import_donation_report_update( $report );

	return $donor_data;
}

/**
 * Return the option that are default options.
 *
 * @since 1.8.13
 */
function give_import_default_options() {
	/**
	 * Filter to modify default option in the import dropdown
	 *
	 * @since 1.8.13
	 *
	 * @return array
	 */
	return (array) apply_filters( 'give_import_default_options', array(
		'' => __( 'Do not import', 'give' ),
	) );
}

/**
 * Return the option that are related to donations.
 *
 * @since 1.8.13
 */
function give_import_donations_options() {
	/**
	 * Filter to modify donations option in the import dropdown
	 *
	 * @since 1.8.13
	 *
	 * @return array
	 */
	return (array) apply_filters( 'give_import_donations_options', array(
		'id'          => __( 'Donation ID', 'give' ),
		'amount'      => __( 'Donation Amount', 'give' ),
		'post_date'   => __( 'Donation Date', 'give' ),
		'first_name'  => __( 'Donor First Name', 'give' ),
		'last_name'   => __( 'Donor Last Name', 'give' ),
		'line1'       => __( 'Address 1', 'give' ),
		'line2'       => __( 'Address 2', 'give' ),
		'city'        => __( 'City', 'give' ),
		'state'       => __( 'State', 'give' ),
		'country'     => array(
			__( 'Country', 'give' ),
			__( 'County', 'give' ),
			__( 'Region', 'give' ),
			__( 'Province', 'give' ),
		),
		'zip'         => array(
			__( 'Zip', 'give' ),
			__( 'Postal Code', 'give' ),
		),
		'email'       => __( 'Donor Email', 'give' ),
		'post_status' => __( 'Donation Status', 'give' ),
		'gateway'     => __( 'Payment Method', 'give' ),
		'notes'       => __( 'Notes', 'give' ),
		'mode'        => __( 'Test Mode', 'give' ),
		'post_meta'   => __( 'Import as Meta', 'give' ),
	) );
}

/**
 * Return the option that are related to donations.
 *
 * @since 1.8.13
 */
function give_import_donor_options() {
	/**
	 * Filter to modify donors option in the import dropdown
	 *
	 * @since 1.8.13
	 *
	 * @return array
	 */
	return (array) apply_filters( 'give_import_donor_options', array(
		'donor_id' => __( 'Donor ID', 'give' ),
		'user_id'  => __( 'User ID', 'give' ),
	) );
}

/**
 * Return the option that are related to donations.
 *
 * @since 1.8.13
 */
function give_import_donation_form_options() {
	/**
	 * Filter to modify form option in the import dropdown
	 *
	 * @since 1.8.13
	 *
	 * @return array
	 */
	return (array) apply_filters( 'give_import_donation_form_options', array(
		'form_title'              => __( 'Donation Form Title', 'give' ),
		'form_id'                 => __( 'Donation Form ID', 'give' ),
		'form_level'              => __( 'Donation Level', 'give' ),
		'form_custom_amount_text' => __( 'Custom Amount Text', 'give' ),
	) );
}

/**
 * Import CSV in DB
 *
 * @param int    $file_id   CSV id
 * @param int    $start     Start from which csv line.
 * @param int    $end       End from which csv line.
 * @param string $delimiter CSV delimeter.
 *
 * @return array
 */
function give_get_donation_data_from_csv( $file_id, $start, $end, $delimiter = 'csv' ) {
	/**
	 * Filter to modify delimiter of Import.
	 *
	 * @since
	 * 1.8.14
	 *
	 * Return string $delimiter.
	 */
	$delimiter = (string) apply_filters( 'give_import_delimiter_set', $delimiter );

	$raw_data = array();
	$file_dir = get_attached_file( $file_id );
	$count    = 0;
	if ( false !== ( $handle = fopen( $file_dir, 'r' ) ) ) {
		while ( false !== ( $row = fgetcsv( $handle, 0, $delimiter ) ) ) {
			if ( $count >= $start && $count <= $end ) {
				$raw_data[] = $row;
			}
			$count ++;
		}
		fclose( $handle );
	}

	return $raw_data;
}


/**
 * Remove login when user register with give functions.
 *
 * @since 1.8.13
 *
 * @param $value
 *
 * @return bool
 */
function give_log_user_in_on_register_callback( $value ) {
	return false;
}

/**
 * Add import Donation forms, donations , donor from CSV to database
 *
 * @since 1.8.13
 *
 * @param array $raw_key        Setup bu user at step 2.
 * @param array $row_data       Feilds that are being imported from CSV
 * @param array $main_key       First row from the CSV
 * @param array $import_setting Contain the global variable.
 *
 * @return bool
 */
function give_save_import_donation_to_db( $raw_key, $row_data, $main_key = array(), $import_setting = array() ) {
	$data                          = array_combine( $raw_key, $row_data );
	$price_id                      = false;
	$customer_id                   = 0;
	$import_setting['create_user'] = ( isset( $import_setting['create_user'] ) ? $import_setting['create_user'] : 1 );

	$data = (array) apply_filters( 'give_save_import_donation_to_db', $data );

	$data['amount'] = give_maybe_sanitize_amount( $data['amount'] );

	// Here come the login function.
	$donor_data = give_import_get_user_from_csv( $data, $import_setting );
	if ( ! empty( $donor_data->id ) ) {
		if ( ! empty( $donor_data->user_id ) ) {
			$customer_id = $donor_data->user_id;
		} elseif ( ! empty( $data['user_id'] ) ) {
			$customer_id = $data['user_id'];
		}
	} else {
		return false;
	}

	// get form data or register a form data.
	$form = give_import_get_form_data_from_csv( $data, $import_setting );
	if ( false == $form ) {
		return false;
	} else {
		$price_id = ( ! empty( $form->price_id ) ) ? $form->price_id : false;
	}


	$address = array(
		'line1'   => ( ! empty( $data['line1'] ) ? give_clean( $data['line1'] ) : '' ),
		'line2'   => ( ! empty( $data['line1'] ) ? give_clean( $data['line2'] ) : '' ),
		'city'    => ( ! empty( $data['line1'] ) ? give_clean( $data['city'] ) : '' ),
		'zip'     => ( ! empty( $data['zip'] ) ? give_clean( $data['zip'] ) : '' ),
		'state'   => ( ! empty( $data['state'] ) ? give_clean( $data['state'] ) : '' ),
		'country' => ( ! empty( $data['country'] ) ? ( ( $country_code = array_search( $data['country'], give_get_country_list() ) ) ? $country_code : $data['country'] ) : '' ),
	);

	//Create payment_data array
	$payment_data = array(
		'donor_id'        => $donor_data->id,
		'price'           => $data['amount'],
		'status'          => ( ! empty( $data['post_status'] ) ? $data['post_status'] : 'publish' ),
		'currency'        => give_get_currency(),
		'user_info'       => array(
			'id'         => $customer_id,
			'email'      => ( ! empty( $data['email'] ) ? $data['email'] : ( isset( $donor_data->email ) ? $donor_data->email : false ) ),
			'first_name' => ( ! empty( $data['first_name'] ) ? $data['first_name'] : ( ! empty( $customer_id ) && ( $first_name = get_user_meta( $customer_id, 'first_name', true ) ) ? $first_name : $donor_data->name ) ),
			'last_name'  => ( ! empty( $data['last_name'] ) ? $data['last_name'] : ( ! empty( $customer_id ) && ( $last_name = get_user_meta( $customer_id, 'last_name', true ) ) ? $last_name : $donor_data->name ) ),
			'address'    => $address,
		),
		'gateway'         => ( ! empty( $data['gateway'] ) && 'offline' != strtolower( $data['gateway'] ) ? strtolower( $data['gateway'] ) : 'manual' ),
		'give_form_title' => ( ! empty( $data['form_title'] ) ? $data['form_title'] : $form->get_name() ),
		'give_form_id'    => (string) $form->get_ID(),
		'give_price_id'   => $price_id,
		'purchase_key'    => strtolower( md5( uniqid() ) ),
		'user_email'      => $data['email'],
		'post_date'       => ( ! empty( $data['post_date'] ) ? mysql2date( 'Y-m-d H:i:s', $data['post_date'] ) : current_time( 'mysql' ) ),
		'mode'            => ( ! empty( $data['mode'] ) ? ( 'true' == (string) $data['mode'] || 'TRUE' == (string) $data['mode'] ? 'test' : 'live' ) : ( isset( $import_setting['mode'] ) ? ( true == (bool) $import_setting['mode'] ? 'test' : 'live' ) : ( give_is_test_mode() ? 'test' : 'live' ) ) ),
	);

	$payment_data = apply_filters( 'give_import_before_import_payment', $payment_data, $data, $donor_data, $form );

	// Get the report
	$report = give_import_donation_report();

	// Check for duplicate code.
	if ( true === give_check_import_donation_duplicate( $payment_data, $data, $form, $donor_data ) ) {
		$report['duplicate_donation'] = ( ! empty( $report['duplicate_donation'] ) ? ( absint( $report['duplicate_donation'] ) + 1 ) : 1 );
	} else {
		add_action( 'give_update_payment_status', 'give_donation_import_insert_default_payment_note', 1, 1 );
		add_filter( 'give_insert_payment_args', 'give_donation_import_give_insert_payment_args', 11, 2 );
		add_filter( 'give_update_donor_information', 'give_donation_import_update_donor_information', 11, 3 );
		add_action( 'give_insert_payment', 'give_import_donation_insert_payment', 11, 2 );
		$payment = give_insert_payment( $payment_data );
		remove_action( 'give_update_payment_status', 'give_donation_import_insert_default_payment_note', 1 );
		remove_filter( 'give_insert_payment_args', 'give_donation_import_give_insert_payment_args', 11 );
		remove_filter( 'give_update_donor_information', 'give_donation_import_update_donor_information', 11 );
		remove_action( 'give_insert_payment', 'give_import_donation_insert_payment', 11 );

		if ( $payment ) {

			$report['create_donation'] = ( ! empty( $report['create_donation'] ) ? ( absint( $report['create_donation'] ) + 1 ) : 1 );

			update_post_meta( $payment, '_give_payment_import', true );

			if ( ! empty( $import_setting['csv'] ) ) {
				update_post_meta( $payment, '_give_payment_import_id', $import_setting['csv'] );
			}

			// Insert Notes.
			if ( ! empty( $data['notes'] ) ) {
				give_insert_payment_note( $payment, $data['notes'] );
			}

			$meta_exists = array_keys( $raw_key, 'post_meta' );
			if ( ! empty( $main_key ) && ! empty( $meta_exists ) ) {
				foreach ( $meta_exists as $meta_exist ) {
					if ( ! empty( $main_key[ $meta_exist ] ) && ! empty( $row_data[ $meta_exist ] ) ) {
						update_post_meta( $payment, $main_key[ $meta_exist ], $row_data[ $meta_exist ] );
					}
				}
			}
		} else {
			$report['failed_donation'] = ( ! empty( $report['failed_donation'] ) ? ( absint( $report['failed_donation'] ) + 1 ) : 1 );
		}
	}

	// update the report
	give_import_donation_report_update( $report );

	return true;
}

/**
 * Alter donor information when importing donations from CSV
 *
 * @since 1.8.13
 *
 * @param $donor
 * @param $payment_id
 * @param $payment_data
 *
 * @return Give_Donor
 */
function give_donation_import_update_donor_information( $donor, $payment_id, $payment_data ) {
	$old_donor = $donor;
	if ( ! empty( $payment_data['donor_id'] ) ) {
		$donor_id = absint( $payment_data['donor_id'] );
		$donor    = new Give_Donor( $donor_id );
		if ( ! empty( $donor->id ) ) {
			return $donor;
		}
	}

	return $old_donor;
}

/*
 * Give update purchase_count of give customer.
 *
 * @since 1.8.13
 */
function give_import_donation_insert_payment( $payment_id, $payment_data ) {
	// Update Give Customers purchase_count
	if ( ! empty( $payment_data['status'] ) && ( 'complete' === (string) $payment_data['status'] || 'publish' === (string) $payment_data['status'] ) ) {
		$donor_id = (int) get_post_meta( $payment_id, '_give_payment_customer_id', true );
		if ( ! empty( $donor_id ) ) {
			$donor = new Give_Donor( $donor_id );
			$donor->increase_purchase_count();
		}
	}
}

/**
 * Add author id in in donation post
 *
 * @since 1.8.13
 */
function give_donation_import_give_insert_payment_args( $args, $payment_data ) {
	if ( ! empty( $payment_data['user_info']['id'] ) ) {
		$args['post_author'] = (int) $payment_data['user_info']['id'];
	}

	return $args;
}

/**
 * Check if Import donation is duplicate
 *
 * @since 1.8.13
 */
function give_check_import_donation_duplicate( $payment_data, $data, $form, $donor_data ) {
	$return = false;
	if ( ! empty( $data['post_date'] ) ) {
		$post_date = mysql2date( 'Y-m-d-H-i-s', $data['post_date'] );
		$post_date = explode( '-', $post_date );
		$args      = array(
			'post_type'              => 'give_payment',
			'cache_results'          => false,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'fields'                 => 'ids',
			'date_query'             => array(
				array(
					'year'   => $post_date[0],
					'month'  => $post_date[1],
					'day'    => $post_date[2],
					'hour'   => $post_date[3],
					'minute' => $post_date[4],
					'second' => $post_date[5],
				),
			),
			'meta_query'             => array(
				array(
					'key'     => '_give_payment_total',
					'value'   => preg_replace( '/[\$,]/', '', $payment_data['price'] ),
					'compare' => 'LIKE',
				),
				array(
					'key'     => '_give_payment_form_id',
					'value'   => $payment_data['give_form_id'],
					'type'    => 'numeric',
					'compare' => '=',
				),
				array(
					'key'     => '_give_payment_gateway',
					'value'   => $payment_data['gateway'],
					'compare' => '=',
				),
			),
		);

		$payments  = new Give_Payments_Query( $args );
		$donations = $payments->get_payments();
		if ( ! empty( $donations ) ) {
			return true;
		}
	}

	return $return;
}

/**
 * Record payment notes that is being imported from CSV.
 *
 * @since  1.8.13
 *
 * @param  int $payment_id The ID number of the payment.
 *
 * @return void
 */
function give_donation_import_insert_default_payment_note( $payment_id ) {
	$current_user = wp_get_current_user();
	give_insert_payment_note( $payment_id, esc_html( wp_sprintf( __( 'This donation was imported by %s', 'give' ), $current_user->user_email ) ) );
}

/**
 * Return Import Page URL
 *
 * @since 1.8.13
 *
 * @param array $parameter
 *
 * @return string URL
 */
function give_import_page_url( $parameter = array() ) {
	$defalut_query_arg = array(
		'post_type'     => 'give_forms',
		'page'          => 'give-tools',
		'tab'           => 'import',
		'importer-type' => 'import_donations',
	);
	$import_query_arg  = wp_parse_args( $parameter, $defalut_query_arg );

	return add_query_arg( $import_query_arg, admin_url( 'edit.php' ) );
}