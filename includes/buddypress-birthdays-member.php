<?php


class ByddyPress_Birthday_Memebers {

	/**
	 * Holds the class instance.
	 *
	 * @var array
	 */
	private static $instance = array();

	/**
	 * Constructor.
	 *
	 * Initializes the class and calls the init method.
	 */
	protected function __construct() {
		$this->init();
	}

	/**
	 * The method you use to get the ByddyPress_Birthday_Memebers's instance.
	 *
	 * This method ensures that only one instance of the class is created,
	 * reducing memory usage and improving performance.
	 *
	 * @return ByddyPress_Birthday_Memebers The instance of the class.
	 */
	public static function get_instance() : ByddyPress_Birthday_Memebers {
		$cls = static::class;
		if ( ! isset( self::$instance[ $cls ] ) ) {
			self::$instance[ $cls ] = new static();
		}

		return self::$instance[ $cls ];
	}

	/**
	 * Initializes the class.
	 *
	 * Registers a custom REST API route using the 'rest_api_init' action hook.
	 */
	public function init() {
		add_action( 'rest_api_init', array( $this, 'bpbday_register_custom_routes' ) );
	}


	public function bpbday_register_custom_routes() {
		register_rest_route(
			'byddypress-birthday/v1',
			'/member/(?P<id>\d+)',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'get_members' ),
			)
		);

	}

	public function get_members( WP_REST_Request $request ) {

		$parameters = $request->get_params();
		$user_id    = absint( $parameters['id'] );
		$members    = friends_get_friend_user_ids( $user_id );

		echo '<pre>';
		print_r( $members );
		echo '</pre>';
	}

}


ByddyPress_Birthday_Memebers::get_instance();
