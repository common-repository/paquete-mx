<?php
$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );



if ( in_array( 'woocommerce/woocommerce.php',  $active_plugins) ) {
	function paquetemx_shipping_method() {

		if(!class_exists('PaqueteMX_Shipping_Method')){

			class PaqueteMX_Shipping_Method extends WC_Shipping_Method{
				
				public function __construct(){
					$this->id                 = 'paquetemx'; 
		            $this->method_title       = __( 'Paquete.MX', 'paquetemx' );  
		            $this->method_description = __( 'No necesitas configurar ajustes aquí, el plugin ya los ha configurado por tí.', 'paquetemx' ); 

		            $this->init();

		            $this->enabled = 'yes';
		            $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'Paquete.MX', 'paquetemx' );
		        
				}

				function init() {
		            add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		        }

		        public function calculate_shipping($package = array()) {
		        	$cost = 0.0;

		        	/* 	Prepares request to Paquete.MX API 	*/
		        	$config = get_option( 'paquetemx_options' );
		        	$type = $config['paquetemx_radio_behaviour'];
		        	$currency = $config['paquetemx_radio_currency'];
		        	$services_limit = intval( $config["services_limit"] );
		        	$providers = [];

		        	/* 	Sets shipping providers	*/
		        	isset($config['fedex']) 	? $providers 	[]= 'fedex' : '';
		        	isset($config['ups']) 		? $providers	[]= 'ups' : '';
		        	isset($config['redpack']) 	? $providers 	[]= 'redpack' : '';

		        	$api_token = $config['paquetemx_field_api_token'];
		        	$increase_pct = $config['rate_increase'];

		        	/* 	Set shipping rate info 	*/
		        	$from_zip 		= $config["from_zip"];
		        	$from_country 	= 'mx';
		        	$to 			= $package['destination'];
		        	$to_zip 		= $to['postcode'];
		        	$to_country 	= $to['country'];

		        	/* 	Sets packages info for rating 	*/
		        	$packages = PMX_Shipping_Functions::convert_to_packages($package['contents']);

		        	/* 	Fixes real packages weight 	*/
		        	PMX_Shipping_Functions::define_packages_weight($packages);

		        	/* 	Builds body request 	*/
		        	$rate_body = [
		        		'type' 		=> $type,
		        		'providers' => $providers,
		        		'shipping' 	=> [
		        			'type' 	=> 'package',
		        			'from' 	=> [
		        				'zip' 		=> $from_zip,
		        				'country' 	=> $from_country
		        			],
		        			'to' 	=> [
		        				'zip' 		=> $to_zip,
		        				'country' 	=> $to_country		        				
		        			],
		        			'packages' 	=> $packages
		        		],
		        		'buffer' => base64_encode($api_token)
		        	];

		        	$args = [
		        		'timeout' 	=> '15',
		        		'sslverify' => false,
					    'body' 		=> json_encode($rate_body),
					    'headers'	=> [
					    	'Content-Type'	=> 'application/json'
					    ]
					];


		        	/* 	Determines if it's in production or development*/
		        	$env = isset($config['paquetemx_checkbox_production']) ? 'prod' : 'dev';
		        	
		        	/* 	Sends request 	*/
					$response = wp_remote_post('https://api.paquete.mx/' . $env . '/pmx-rate', $args);
					if( !is_wp_error( $response ) ){
						$r = json_decode($response['body']);

						$rate = array();
						if(!empty($r->code)){
							if($r->code === '9003'){
								/*		Determines if response has one or many services 	*/
								if( isset( $r->response->total ) ){
										//	It's single service
									$service = $r->response;

									if( $currency == "USD" )
										$cost = floatval($service->totalUSD);
									else
										$cost = floatval($service->total);

									$increase = $cost * $increase_pct / 100.0;
									$cost += $increase;

									$hours = isset($service->estimated_delivery_hours) ? $service->estimated_delivery_hours : 144;
									$days = PMX_Shipping_Functions::hours_to_deliver_days( $hours );
									$days_text = $days > 1 ? 'días' : 'día';

									$rate = array(
										'id'	=> $service->provider_code,
										'label' => 'Paquete.MX - ' . strtoupper($service->provider) . ' (' . $days . ' ' . $days_text . ')',
										'cost' 	=> $cost,
										'meta_data' => [
											'provider'		=>	$service->provider,
											'name'			=>	$service->name,
											'provider_code'	=>	$service->provider_code,
											'estimated_delivery_hours'	=>	$hours,
											'total'			=>	$service->total
										]
									);
									$this->add_rate( $rate );
								}else{
										//	It's multiple service
									$services = $r->response;

									if( $services_limit == 0)
										$limit = count( $services );
									else
										$limit = $services_limit < count( $services ) ? $services_limit : count( $services );

									for( $i = 0 ; $i < $limit ; $i++ ){
										$service = $services[ $i ];

										if( $currency == "USD" )
											$cost = floatval($service->totalUSD);
										else
											$cost = floatval($service->total);
										
										$increase = $cost * $increase_pct / 100.0;
										$cost += $increase;

										$hours = isset($service->estimated_delivery_hours) ? $service->estimated_delivery_hours : 144;
										$days = PMX_Shipping_Functions::hours_to_deliver_days( $hours );
										$days_text = $days > 1 ? 'días' : 'día';

										$rate = array(
											'id'	=> $service->provider_code,
											'label' => 'Paquete.MX - ' . strtoupper($service->provider) . ' (' . $days . ' ' . $days_text . ')',
											'cost' 	=> $cost,
											'meta_data' => [
												'provider'		=>	$service->provider,
												'name'			=>	$service->name,
												'provider_code'	=>	$service->provider_code,
												'estimated_delivery_hours'	=>	$hours,
												'total'			=>	$service->total,
												'method'		=> 'Paquete.MX'
											]
										);
										$this->add_rate( $rate );
									}
								}

							}else{
								$rate = array(
									'id'	=> "-1",
									'label' => "Paquete.MX (Sin cobertura)"
								);
								$this->add_rate( $rate );
							}
						}else{
							$rate = array(
								'id'	=> "-1",
								'label' => "Paquete.MX (Sin cobertura)"
							);
							$this->add_rate( $rate );
						}
					}else{
						$rate = array(
							'id'	=> "-1",
							'label' => "Paquete.MX (Sin cobertura)"
						);
						$this->add_rate( $rate );
					}

		        }
			}
		}
	}
	add_action( 'woocommerce_shipping_init', 'paquetemx_shipping_method' );

	/*	Shipping Method is changed 	*/
	function paquetemx_shipping_chosen($gateways){

		$config = get_option( 'paquetemx_options' );
		$id = WC()->session->get('chosen_shipping_methods')[0];
		
		if($id == "-1") 	//	There's no shipping providers for the given destination
			if( isset($config['paquetemx_checkbox_payment_bypass']) )
				add_action( 'woocommerce_cart_needs_payment', '__return_false', 99, 2);
			else
				add_action( 'woocommerce_cart_needs_payment', '__return_true', 99, 2);
		else
			add_action( 'woocommerce_cart_needs_payment', '__return_true', 99, 2);
		
		return $gateways;
	}
	add_action( 'woocommerce_available_payment_gateways', 'paquetemx_shipping_chosen', 99, 1 );

	/*	Makes shipping with Paquete.MX API 	*/
	function make_paquetemx_shipment($order_id){
		
		/*		Get Shipping Meta Data 		*/
		$order = wc_get_order( $order_id );
		$config = get_option( 'paquetemx_options' );

		if( preg_match("/Paquete\.MX \-.*/", $order->get_shipping_method())){
			//var_dump($config['paquetemx_manual_shipping']);
			if( !isset($config['paquetemx_manual_shipping']) ){
			//if( false ){
				PMX_Shipping_Functions::make_paquetemx_shipping( $order_id, $order );
			}else
				PMX_Shipping_Functions::preregister_shipping( $order_id, $order );
			
		}else if($order->get_shipping_method() === 'Paquete.MX (Sin cobertura)'){
			/* 	Paquete.MX shipping was requested 	*/

			$packages = PMX_Shipping_Functions::convert_to_packages($order->get_items());
			$packages_names = PMX_Shipping_Functions::get_packages_names($order->get_items());

	    	$config = get_option( 'paquetemx_options' );
	    	$api_token = $config['paquetemx_field_api_token'];

	    	/* 	Determines if it's in production or development*/
	    	$env = isset($config['paquetemx_checkbox_production']) ? 'prod' : 'dev';

			/* 	Get shipping info 	*/
			$provider = '';

			/* 	Build ship body for request 	*/
	    	$from_state 	= $config["state"];
	    	$from_city 		= $config["from_city"];
	    	$from_county 	= $config["from_county"];
	    	$from_street 	= $config["from_street"];
	    	$from_number 	= $config["from_number"];
	    	$from_zip 		= $config["from_zip"];
	    	$from_email 	= $config["from_email"];
	    	$from_phone 	= $config["from_phone"];
	    	$from_company 	= $config["from_company"];
	    	$from_name 		= $config["from_name"];

	    	$to_street 		= $order->get_shipping_address_1();
	    	$to_number 		= $order->get_shipping_address_2();
	    	$to_name 		= ($order->get_shipping_first_name()).' '.($order->get_shipping_last_name());
	    	$to_company 	= $order->get_shipping_company();
	    	$to_email 		= $order->get_billing_email();
	    	$to_phone 		= $order->get_billing_phone();
	    	$to_county 		= $order->get_meta("_billing_options");	//Custom field
	    	$to_state 		= $order->get_shipping_state();
	    	$to_city 		= $order->get_shipping_city();
	    	$to_zip 		= $order->get_shipping_postcode();

			$ship_body = [
				'service'	=> [
					'code'	=>	'N-A',
					'name'	=>	'N-A'
				],
				'packagingType'	=>	'package',
				'from'	=>	[
					'name'		=> PMX_Shipping_Functions::limit_field($from_name, 22), // UPS Max Contact Name Length
					'company'	=> PMX_Shipping_Functions::limit_field($from_company, 25),
					'phone'		=> $from_phone,
					'country'	=> [
						'code'	=>	'mx',
						'name'	=>	'mexico'
					],
					'email'		=> $from_email,
					'street'	=> PMX_Shipping_Functions::limit_field($from_street, 25),
					'number'	=> $from_number,
					'county'	=> PMX_Shipping_Functions::limit_field($from_county, 25),
					'city'		=> PMX_Shipping_Functions::limit_field($from_city, 25),
					'state'		=> $from_state,
					'zip'		=> $from_zip,
				],
				'to'	=>	[
					'name'	=> PMX_Shipping_Functions::limit_field( $to_name, 22), // UPS Max Contact Name Length
					'company'	=> PMX_Shipping_Functions::format_shipping_field(PMX_Shipping_Functions::limit_field( $to_company, 25)),
					'phone'		=> $to_phone,
					'country'	=> [
						'code'	=>	'mx',
						'name'	=>	'mexico'
					],
					'email'		=> PMX_Shipping_Functions::format_shipping_field($from_email),
					'street'	=> PMX_Shipping_Functions::limit_field( $to_street, 25),
					'number'	=> PMX_Shipping_Functions::format_shipping_field($to_number),
					'county'	=> PMX_Shipping_Functions::limit_field( $to_county, 25),
					'city'		=> PMX_Shipping_Functions::limit_field( $to_city, 25),
					'state'		=> $to_state,
					'zip'		=> $to_zip,
					'reference'	=> 'N-A'
				],
				'packages'			=>	$packages,
				'content'			=>	'N-A',
				'estimated_value'	=> 	1.0
			];

			$notification_body = [
	    		'status' 			=>	'8001',
	    		'type'				=> 	'shipping',
	    		'shipping'			=>	$ship_body,
	    		'response'			=>	'N-A',
	    		'packagesNames'		=>	$packages_names,
	    		'trackingNumber'	=>	'N-A',
	    		'platform'			=>	'WORDPRESS'
	    	];

			/* 	Consumes Notification API 	*/
	    	$args = [
	    		'timeout' 	=> '15',
	    		'sslverify' => false,
			    'body' 		=> json_encode($notification_body),
			    'headers'	=> [
			    	'Content-Type'	=> 	'application/json'
			    ]
			];

			$response = wp_remote_post('https://api.paquete.mx/'.$env.'/pmx-notification', $args);
		}
	}

	add_action( 'woocommerce_thankyou', 'make_paquetemx_shipment', 10, 2);

	/*	Adds county field 	*/
	function to_county_field ( $fields  ) {
		$fields['billing']['billing_options'] = array(
	        'label'         => __('Colonia'),
	        'placeholder'   => __('Colonia de entrega del pedido'),
	        'required' => true,
	        'type' => 'text',
	        'class' => array('form-row-wide')
	    );

	    return $fields;
	}

	add_filter('woocommerce_checkout_fields', 'to_county_field');

	/*	Hide shipping value when zero 	*/
	function hide_zero_value_shipping($label, $method){
	    if ( $method->cost <= 0 ) {
	        $label = $method->get_label();
	    }
	    return $label;
	}

	add_filter( 'woocommerce_cart_shipping_method_full_label', 'hide_zero_value_shipping', 10, 2 );

	/* 	Adds Paquete.MX shipping method 	*/
	function add_paquetemx_shipping_method( $methods ) {
		//$methods = Array();
	    $methods []= 'PaqueteMX_Shipping_Method';
	    return $methods;
	}
	add_filter( 'woocommerce_shipping_methods', 'add_paquetemx_shipping_method' );

	/* 	Removes Shipping calculation from cart 	*/
	function disable_shipping_calc_on_cart( $show_shipping ) {
	    if( is_cart() ) return false;
	    else return $show_shipping;
	}
	add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );

}
