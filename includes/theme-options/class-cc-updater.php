<?php
/**
 * Cyberchimps theme Update
 *
 * @package responsive
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;}

if ( ! class_exists( 'CC_Updater' ) ) :

	/**
	 * [CC_Updater description]
	 */
	class CC_Updater {

		/**
		 * [public description]
		 *
		 * @var [type]
		 */
		public $url = 'https://cyberchimps.com/verify_user.php';
		/**
		 * [public description]
		 *
		 * @var [type]
		 */
		public $username;
		/**
		 * [public description]
		 *
		 * @var [type]
		 */
		public $password;

		/**
		 * [__construct description]
		 *
		 * @param [type] $username [description].
		 * @param [type] $password [description].
		 */
		public function __construct( $username, $password ) {

			$this->username = $username;
			$this->password = $password;
		}

		/**
		 * [validate description]
		 *
		 * @return [type] [description]
		 */
		public function validate() {

			$str_response_message = '';
			$username             = $this->username;
			$password             = $this->password;
			$theme_details        = wp_get_theme();
			$current_theme_name   = $theme_details->get( 'Name' );
			$api_values           = array(
				'cc_action_to_take' => 'check_cc_login_details',
				'username'          => $username,
				'password'          => $password,
				'theme_name'        => $current_theme_name,
			);
			$options              = array(
				'timeout' => 30,
				'body'    => $api_values,
			);

			$url                      = $this->url;
			$response_from_validate_user = wp_remote_post( $url, $options );

			if ( ! is_wp_error( $response_from_validate_user ) && 200 == wp_remote_retrieve_response_code( $response_from_validate_user ) ) {

				$response = wp_remote_retrieve_body( $response_from_validate_user );

				if ( ! empty( $response ) ) {

					if ( 'not_found' == trim( $response ) ) {
						// User is not found.
						$str_response_message = 'Username or Password is incorrect. Please check your credentials and authenticate again.';
						$account_data         = array(
							'username' => $this->username,
							'password' => $this->password,
						);
						update_option( 'cc_account_user_details', $account_data );
						update_option( 'cc_account_status', 'not_found' );
					} elseif ( 2 == trim( $response ) ) {
						// User found & product is purchased.
						$str_response_message = 'Settings saved';
						$account_data         = array(
							'username' => $this->username,
							'password' => $this->password,
						);
						update_option( 'cc_account_user_details', $account_data );
						update_option( 'cc_account_status', 'found' );
					} elseif ( '1' == trim( $response ) ) {
						// User found - not purchased.
						$str_response_message = 'Settings saved';
						$account_data         = array(
							'username' => $this->username,
							'password' => $this->password,
						);
						update_option( 'cc_account_user_details', $account_data );
						update_option( 'cc_account_status', 'not_valid' );
					}
				}
			} else {
				$str_response_message = 'Some issue';
			}
			return $str_response_message;
		}
	}

endif;
