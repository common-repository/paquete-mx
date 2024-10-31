<?php
class PMX_Shipping_Functions{
	public static function convert_to_packages($items){
		$packages = [];

		foreach($items as $item){
			$product 	= null;
			if(!empty($item['data']))
				$product = $item['data'];
			else
				$product 	= $item->get_product();

    		$autogroup = $product->get_meta('_autogroup_product');

    		if(!empty($autogroup)){
    			if($autogroup === 'yes' ){

    				$max_group_number 	= intval($product->get_meta('_max_group_number'));
    				$package_length 	= strval($product->get_meta('_package_length'));
    				$package_height 	= strval($product->get_meta('_package_height'));
    				$package_width 		= strval($product->get_meta('_package_width'));

    				$individual_weight 	= floatval($product->get_weight());

		    		$total_items 		= intval($item['quantity']);

    				$packages_number = ceil( $total_items / $max_group_number );
    				$remaining_items	= ($total_items % $max_group_number);

    				if($remaining_items == 0){
		    			for( $i = 0 ; $i < $packages_number; $i++ )
			        		array_push($packages, [
			        			'height'	=> $package_height,
			        			'width'		=> $package_width,
			        			'length'	=> $package_length,
			        			'weight'	=> strval($individual_weight * $max_group_number)
			        		]);
    				}else{
		    			for( $i = 0 ; $i < $packages_number; $i++ ){
			    			if($i == $packages_number - 1)
				        		array_push($packages, [
				        			'height'	=> $package_height,
				        			'width'		=> $package_width,
				        			'length'	=> $package_length,
				        			'weight'	=> strval($individual_weight * $remaining_items)
				        		]);
			    			else
			    				array_push($packages, [
				        			'height'	=> $package_height,
				        			'width'		=> $package_width,
				        			'length'	=> $package_length,
				        			'weight'	=> strval($individual_weight * $max_group_number)
				        		]);
		    			}

    				}

    			}else{

		    		$height 	= strval($product->get_height());
		    		$width 		= strval($product->get_width());
		    		$length 	= strval($product->get_length());
		    		$weight 	= strval($product->get_weight());

		    		$quantity 	= intval($item['quantity']);

		    		for( $i = 0 ; $i < $quantity; $i++ )
		        		array_push($packages, [
		        			'height'	=> $height,
		        			'width'		=> $width,
		        			'length'	=> $length,
		        			'weight'	=> $weight
		        		]);

    			}
    		}else{

	    		$height 	= strval($product->get_height());
	    		$width 		= strval($product->get_width());
	    		$length 	= strval($product->get_length());
	    		$weight 	= strval($product->get_weight());

	    		$quantity 	= intval($item['quantity']);

	    		for( $i = 0 ; $i < $quantity; $i++ )
	        		array_push($packages, [
	        			'height'	=> $height,
	        			'width'		=> $width,
	        			'length'	=> $length,
	        			'weight'	=> $weight
	        		]);

    		}
    	};

    	return $packages;
	}

	public static function get_packages_names($items){
		$names = [];
		foreach($items as $item){

			$product 	= $item->get_product();

			$item_name = mb_convert_encoding($product->get_name(), 'UTF-8', 'UTF-8');
			$total_items = $item->get_quantity();

			$autogroup = $product->get_meta('_autogroup_product');

			if(!empty($autogroup)){
    			if($autogroup === 'yes' ){

					$max_group_number 	= intval($product->get_meta('_max_group_number'));
					$package_length 	= strval($product->get_meta('_package_length'));
					$package_height 	= strval($product->get_meta('_package_height'));
					$package_width 		= strval($product->get_meta('_package_width'));

					$packages_number = ceil( $total_items / $max_group_number );

					$items_left = $total_items % $max_group_number;

					if($items_left === 0){

						$names []= $total_items.'x'.$item_name.' en '.$packages_number.' CAJA/S de '.$package_length.'x'.$package_width.'x'.$package_height.'cm. </br>&nbsp;&nbsp;&nbsp;&nbsp;<strong>EMBALAJE</strong> => '.$packages_number.' CAJA/S con '.$max_group_number.' '.$item_name.' en CADA UNA<br/>';

					}else{
						if($total_items <= $max_group_number){

							$names []= $total_items.'x'.$item_name.' en '.$packages_number.' CAJA/S de '.$package_length.'x'.$package_width.'x'.$package_height.'cm. </br>&nbsp;&nbsp;&nbsp;&nbsp;<strong>EMBALAJE</strong> => 1 CAJA con '.$items_left.' '.$item_name.'<br/>';

						}else{

							$names []= $total_items.'x'.$item_name.' en '.$packages_number.' CAJA/S de '.$package_length.'x'.$package_width.'x'.$package_height.'cm. </br>&nbsp;&nbsp;&nbsp;&nbsp;<strong>EMBALAJE</strong> => '.($packages_number - 1).' CAJA/S con '.$max_group_number.' '.$item_name.' en CADA UNA, y otra CAJA con '.$items_left.' '.$item_name.'<br/>';

						}

					}


    			}else{
    				
					$length 	= $product->get_length();
					$width 		= $product->get_width();
					$height 	= $product->get_height();

					$names []= $total_items.'x'.$item_name.' en '.$total_items.' CAJA/S de '.$length.'x'.$width.'x'.$height.'<br/>';
    			}
    		}else{

				$length 	= $product->get_length();
				$width 		= $product->get_width();
				$height 	= $product->get_height();

				$names []= $total_items.'x'.$item_name.' en '.$total_items.' CAJA/S de '.$length.'x'.$width.'x'.$height.'<br/>';
    		}

		}

		return implode(' ', $names);
	}

	public static function make_paquetemx_shipping($order_id, $order){
		
		/*		Get Shipping Meta Data 		*/
		$order = wc_get_order( $order_id );

		$total = $order->get_total();
		@$shipping_method = reset($order->get_shipping_methods());

		$provider_code 	= $shipping_method->get_meta( 'provider_code' );
		$provider 		= $shipping_method->get_meta( 'provider' );
		$service_total	= $shipping_method->get_meta( 'total' );
		$service_name	= $shipping_method->get_meta( 'name' );
		$shippingJson 	= "";
		$shippingStatus = false;
		$shippingType = isset($config['paquetemx_checkbox_production']) ? 'manual' : 'automatic';

		/* 	Paquete.MX shipping was requested 	*/
		$packages = PMX_Shipping_Functions::convert_to_packages($order->get_items());
		$packages_names = PMX_Shipping_Functions::get_packages_names($order->get_items());

    	$config = get_option( 'paquetemx_options' );
    	$api_token = $config['paquetemx_field_api_token'];

    	/* 	Determines if it's in production or development*/
    	$env = isset($config['paquetemx_checkbox_production']) ? 'prod' : 'dev';

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
				'code'	=>	$provider_code,
				'name'	=>	$service_name
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
			'estimated_value'	=> 	intval($total)
		];
		
		//if( $order->get_shipping_country() === 'MX' ){
		if( true ){

			$shippingJson = json_encode($ship_body);
	    	$args = [
	    		'timeout' 	=> '120',
	    		'sslverify' => false,
			    'body' 		=> $shippingJson,
			    'headers'	=> [
			    	'Content-Type'	=> 	'application/json',
			    	'pmx_api_token'	=>	$api_token
			    ]
			];
	    	
	    	/* 	Sends request for shipping 	*/
			$response = wp_remote_post('https://api.paquete.mx/' . $env . '/pmx-ship', $args);
			$r = json_decode($response['body']);

	    	/* 	Sends notification to Paquete.MX 	*/
	    	$notification_body = [
	    		'status' 			=>	'',
	    		'type'				=> 	'shipping',
	    		'shipping'			=>	$ship_body,
	    		'response'			=>	$r,
	    		'packagesNames'		=>	$packages_names,
	    		'trackingNumber'	=>	'',
	    		'platform'			=>	'WORDPRESS'
	    	];

	    	$shipping_status = '';
	    	$trackingNumber = '';

			if(!empty($r->response) && !empty($r->code)){
	    		$shipping_status = $r->code;
				if( $shipping_status === '9008' || $shipping_status === '9009' || $shipping_status === '9010'){
					/* 	Shipment requested successfully	*/
					$shippingStatus = true;
					$shipping_status = '9008';
					$trackingNumber = $r->masterTrackingNumber;
					$notification_body['status'] = $shipping_status;
					$notification_body['trackingNumber'] = $trackingNumber;
				}else{
					/* 	Shipment request failed	*/
					$notification_body['trackingNumber'] = 'SIN GUÍA';
				}

				PMX_Shipping_Functions::register_shipping( $trackingNumber, $provider, $service_total, $shipping_status, $order_id, $packages_names, $shippingJson, $shippingStatus, $shippingType );
			}else{
				/* 	Shipment request failed	*/
				$notification_body['trackingNumber'] = 'SIN GUÍA';
			}

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
			$r = json_decode($response['body']);

			
			/*	Checks if automatic pickup is configured 	*/
			if(isset($config['paquetemx_pickup'])){

				/* 	If shipment was successfully made, checks if pickup is available and then requests it	*/
				if($shipping_status === '9008'){
					$notification_body['type'] = 'pickup';
					if($provider != 'redpack'){
						/* 	Pickup is available	for UPS and FEDEX */
						$timestamp = time();
						$dt = new DateTime("now", new DateTimeZone("America/Mexico_City"));
						$dt->setTimestamp($timestamp);
						$time = intval($dt->format('H'));

						/*	If it's 12:59 or less, pickup can be requested for the same day, if not, it will be requested for the next day 	*/
						$date = null;
						$start = '09:00';
						$end = '18:00';

						if($time <= 12){
							$date = $dt->format('Y-m-d');
							$start = PMX_Shipping_Functions::fill_with_zeros($time + 1) . ':' . '00';
						}else{
							$date = date('Y-m-d', strtotime(' +1 Weekdays'));
						}

						/*	Consumes PMX Pickup API 	*/
						$pickup_body = [
							'type' 				=>	$provider,
							'date'				=>	$date,
							'start'				=>	$start,
							'end'				=> 	$end,
							'trackingNumber'	=>	$trackingNumber,
							'packages'			=>	$packages,
							'from'				=>	$ship_body['from'],
							'to'				=>	$ship_body['to'],
							'serviceCode'		=> 	$code
						];

				    	$args = [
				    		'timeout' 	=> '60',
				    		'sslverify' => false,
						    'body' 		=> json_encode($pickup_body),
						    'headers'	=> [
						    	'Content-Type'	=> 	'application/json'
						    ]
						];

						/*	Sends pickup request 	*/
						$response = wp_remote_post('https://api.paquete.mx/'.$env.'/pmx-pickup', $args);
						$r = json_decode($response['body']);

						/*	Notifies for the pickup request 	*/
						if(!empty($r->code)){
							/*	Pickup response 	*/
							$notification_body['status'] = $r->code;

						}else{
							/*	Pickup failed 	*/
							$notification_body['status'] = '';
						}
						$notification_body['response'] = $r;

					}else{

						/* 	Pickup is not available	*/
						$notification_body['status'] = '8001';
						$notification_body['response'] = 'N-A';
					}

			    	$args = [
			    		'timeout' 	=> '15',
			    		'sslverify' => false,
					    'body' 		=> json_encode($notification_body),
					    'headers'	=> [
					    	'Content-Type'	=> 	'application/json'
					    ]
					];

					/* 	Consumes PMX Notification API 	*/
					$response = wp_remote_post('https://api.paquete.mx/'.$env.'/pmx-notification', $args);
						
				}
			}
		}else{
			/*	International shipping. Needs to be done manually by Paquete.MX Operations department	*/

	    	$notification_body = [
	    		'status' 			=>	'8002',
	    		'type'				=> 	'shipping',
	    		'shipping'			=>	$ship_body,
	    		'response'			=>	'N-A',
	    		'packagesNames'		=>	$packages_names,
	    		'trackingNumber'	=>	'SIN GUÍA',
	    		'platform'			=>	'WORDPRESS'
	    	];

	    	$args = [
	    		'timeout' 	=> '15',
	    		'sslverify' => false,
			    'body' 		=> json_encode($notification_body),
			    'headers'	=> [
			    	'Content-Type'	=> 	'application/json'
			    ]
			];

			/* 	Consumes PMX Notification API 	*/
			$response = wp_remote_post('https://api.paquete.mx/'.$env.'/pmx-notification', $args);
		}
	}

	public static function define_packages_weight($packages){
		for( $i = 0 ; $i < count($packages) ; $i++ ){

			$volumetric_weight = self::calculate_simple_volumetric_weight($packages[$i]['height'], $packages[$i]['length'], $packages[$i]['width']);

			/*	If volumetric weight is higher than real weight, then it wil be considered for rates	*/
			if( $volumetric_weight > floatval($packages[$i]['weight']))
				$packages[$i]['weight'] = $volumetric_weight;
		}

		return $packages;
	}

	public static function fill_with_zeros($value){
		if(intval($value) >= 10)
			return $value.'';
		else
			return '0'.$value;
	}

	public static function calculate_simple_volumetric_weight($height, $length, $width){
		return (floatval($height) * floatval($length) * floatval($width)) / 5000.0;
	}

	public static function format_shipping_field($field){
		return empty($field) ? 'N/A' : $field;
	}

	
	public static function hours_to_deliver_days($hours){
		return ceil( intval($hours) / 24.0 );
	}

	public static function limit_field($field, $n){
		if(!empty($field)){
			if(strlen($field) >= $n)
				return substr($field, 0, $n);
			else
				return $field;
		}else{
			return null;
		}
	}

	public static function traduce_shipping_codes( $code ) {
		$status = strval( intval( $code ) );
		$codes = [
			'619' 	=> 	'unknown_error',
			'3' 	=> 	'unsupported_country',
			'20' 	=> 	'unavailable_credit',
			'21' 	=> 	'invalid_token',
			'22' 	=> 	'unavailable_credit',
			'23' 	=> 	'unavailable_credit',
			'26' 	=> 	'unavailable_credit',
			'27' 	=> 	'label_error',
			'33' 	=> 	'unavailable_credit',
			'34' 	=> 	'unavailable_credit',
			'9007' 	=> 	'label_created',
			'9008' 	=> 	'label_created'
		];

		return $codes[ $status ] ?: 'unknown_error';
	}

	public static function traduce_shipping_status ( $code ) {
		$status = strval( intval( $code ) );
		$statues = [
			'unknown_error' 		=> 	'Error desconocido',
			'unsupported_country' 	=> 	'País no soportado',
			'unavailable_credit' 	=> 	'Crédito no disponible',
			'invalid_token' 		=> 	'Token inválido',
			'label_error' 			=> 	'Envío generado manualmente',
			'label_created' 		=> 	'Envío generado exitosamente'
		];

		return $statues[ $status ] ?: 'Error desconocido';
	}

	public static function get_stored_shippings() {
		global $wpdb;
		$query = "SELECT * FROM {$wpdb->prefix}paquetemx_shippings";
		return $wpdb->get_results( $query );
	}

	public static function register_shipping( $trackingNumber, $carrier, $amount, $shippingCode, $order_id, $html_content, $json, $shipped, $type){

		global $wpdb;

		/* 	Defines DB Schema if necessary 	*/
		self::define_schema();


		/*	Registers Shipping 		*/
		$status = PMX_Shipping_Functions::traduce_shipping_codes( $shippingCode );
		$query = "INSERT INTO {$wpdb->prefix}paquetemx_shippings (tracking_number, carrier, amount, status, order_id, content, response_code, json, shipped, type)
			VALUES (
				'{$trackingNumber}',
				'{$carrier}',
				'{$amount}',
				'{$status}',
				'{$order_id}',
				'{$html_content}',
				'{$shippingCode}',
				'{$json}',
				'{$shipped}',
				'{$type}'
			)";

		$rs = $wpdb->query( $query );
	}

	public static function define_schema() {

		global $wpdb;
		$dbname = $wpdb->dbname;

		/*	Create database if not exists 		*/
		$qry = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}paquetemx_shippings (
            id INT NOT NULL AUTO_INCREMENT,
            tracking_number VARCHAR(50) NOT NULL,
            carrier VARCHAR(40) NOT NULL,
            amount VARCHAR(10) NOT NULL,
            status VARCHAR(20) NOT NULL,
            response_code VARCHAR(20) NOT NULL,
            order_id VARCHAR(20) NOT NULL,
            json VARCHAR(10240) NOT NULL,
            shipped TINYINT(1) NOT NULL,
            type VARCHAR(16) NOT NULL,
            content TEXT NOT NULL,
                PRIMARY KEY (id))";
    	$states = $wpdb->get_results( $qry );

		$is_status_col = $wpdb->get_results( "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS`    WHERE `table_name` = '{$wpdb->prefix}paquetemx_shippings' AND `TABLE_SCHEMA` = '{$dbname}' AND `COLUMN_NAME` = 'json'" );

		if( empty($is_status_col) ){
			$alter_table = "ALTER TABLE {$wpdb->prefix}paquetemx_shippings ADD IF NOT EXISTS json VARCHAR(10240) NOT NULL, ADD IF NOT EXISTS shipped TINYINT(1) NOT NULL, ADD IF NOT EXISTS type VARCHAR(16) NOT NULL, ADD IF NOT EXISTS content TEXT NOT NULL";

            $wpdb->query( $alter_table );
		}
	}

	public static function preregister_shipping( $order_id, $order ){

		global $wpdb;

		/* 	Defines DB Schema if necessary 	*/
		self::define_schema();

		/*		Get Shipping Meta Data 		*/
		$order = wc_get_order( $order_id );
		$total = $order->get_total();
		@$shipping_method = reset($order->get_shipping_methods());

		$provider_code 	= $shipping_method->get_meta( 'provider_code' );
		$service_name	= $shipping_method->get_meta( 'name' );
		$carrier 		= $shipping_method->get_meta( 'provider' );
		$amount			= $shipping_method->get_meta( 'total' );

		$json = "";
		$shipped = 0;
		$type = "manual";

		/*	Loads shipping info */
		$config = get_option( 'paquetemx_options' );
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

		/* 	Paquete.MX shipping was requested 	*/
		$packages = PMX_Shipping_Functions::convert_to_packages($order->get_items());
		$packages_names = PMX_Shipping_Functions::get_packages_names($order->get_items());

		/*	Ship JSON Generation for API */
		$ship_body = [
			'service'	=> [
				'code'	=>	$provider_code,
				'name'	=>	$service_name
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
			'estimated_value'	=> 	intval($total)
		];

		$json = json_encode( $ship_body );

		/*	Registers Shipping 		*/
		$query = "INSERT INTO {$wpdb->prefix}paquetemx_shippings (carrier, amount, order_id, content, json, shipped, type)
			VALUES (
				'{$carrier}',
				'{$amount}',
				'{$order_id}',
				'{$packages_names}',
				'{$json}',
				'{$shipped}',
				'{$type}'
			)";

		$rs = $wpdb->query( $query );
	}
	public static function update_shipping( $order_id, $trackingNumber, $shipped ){

		global $wpdb;
		/*	Registers Shipping 		*/
		$query = "UPDATE {$wpdb->prefix}paquetemx_shippings SET tracking_number='{$trackingNumber}', shipped='{$shipped}' WHERE order_id = '{$order_id}'";
		$rs = $wpdb->query( $query );
	}

}
