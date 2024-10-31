<?php



add_action( 'admin_init', 'paquetemx_settings_init' );
add_action( 'admin_menu', 'paquetemx_options_page' );

function paquetemx_settings_init() {
	register_setting( 'paquetemx', 'paquetemx_options' );

	// Adds Provider checkboxes
	add_settings_field(
		'paquetemx_checkbox_providers',
		__( 'Paqueterías a incluir en cálculo de envío', 'paquetemx' ),
		'paquetemx_checkbox_providers_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_checkbox_providers',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);
	// Adds Behaviour radio buttons
	add_settings_field(
		'paquetemx_radio_behaviour',
		__( 'Cálculo de costo', 'paquetemx' ),
		'paquetemx_radio_behaviour_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_radio_behaviour',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);
	// Adds Currency radio buttons
	add_settings_field(
		'paquetemx_radio_currency',
		__( 'Divisa', 'paquetemx' ),
		'paquetemx_radio_currency_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_radio_currency',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);


	// Adds Manual/Automatic shipping checkbox
	add_settings_field(
		'paquetemx_manual_shipping',
		__( '¿Poner envíos en espera?', 'paquetemx' ),
		'paquetemx_manual_shipping_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_manual_shipping',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);

	// Adds rate increase field
	add_settings_field(
		'paquetemx_rate_increase',
		__( 'Tasa de incremento', 'paquetemx' ),
		'paquetemx_rate_increase_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_rate_increase',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);
	// Adds Services Limite input buttons
	add_settings_field(
		'paquetemx_services_limit',
		__( 'Límite de servicios', 'paquetemx' ),
		'paquetemx_services_number_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_services_limit',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);
	// Adds new settings Section
	add_settings_section(
		'paquetemx_section_developers',
		__( 'Configuración de uso.', 'paquetemx' ),
		'paquetemx_section_developers_cb',
		'paquetemx'
	);
	// Adds General Shipper Info Form
	add_settings_field(
		'paquetemx_shipper_info',
		__( 'Información de remitente', 'paquetemx' ),
		'paquetemx_shipper_info_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_shipper_info',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);
	// Adds Shipper Address Info Form
	add_settings_field(
		'paquetemx_address',
		__( 'Dirección de remitente', 'paquetemx' ),
		'paquetemx_address_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_address',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);

	// Adds pikcup checkbox
	add_settings_field(
		'paquetemx_pickup',
		__( '¿Solicitar recolección automáticamente?', 'paquetemx' ),
		'paquetemx_pickup_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_pickup',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);

	// Adds Api Token Field
	add_settings_field(
		'paquetemx_field_api_token',
		__( 'API TOKEN', 'paquetemx' ),
		'paquetemx_field_api_token_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_field_api_token',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);
	// Adds Payment Bybass option
	add_settings_field(
		'paquetemx_checkbox_payment_bypass',
		__( '¿Omitir pago en envíos sin cobertura?', 'paquetemx' ),
		'paquetemx_checkbox_payment_bypass_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_checkbox_payment_bypass',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);
	// Adds Production/Development checkbox
	add_settings_field(
		'paquetemx_checkbox_production',
		__( '¿Producción?', 'paquetemx' ),
		'paquetemx_checkbox_production_cb',
		'paquetemx',
		'paquetemx_section_developers',
		[
			'label_for' => 'paquetemx_checkbox_production',
			'class' => 'paquetemx_row',
			'paquetemx_custom_data' => 'custom',
		]
	);
}

function paquetemx_options_page() {
	add_menu_page(
		'Paquete.MX',
		'Paquete.MX',
		'manage_options',
		'paquetemx',
		'paquetemx_options_page_html',
		plugin_dir_url(__FILE__) . 'images/admin_icon.png'
	);

	add_submenu_page(
		'paquetemx',
		'Paquete.MX - Envíos',
		'Mis Envíos',
		'manage_options',
		'paquetemx_shippings',
		'paquetemx_shippings_page'
	);
}

function paquetemx_shippings_page() {
    $shippings = PMX_Shipping_Functions::get_stored_shippings();

	echo '<div class="wrap">';
    echo '<h2>Mis envíos realizados.</h2>';

    //echo '<div class="notice notice-success is-dismissible"><p>Hello</p></div>';
    
    echo '<table class="wp-list-table widefat">
    		<thead>
    			<tr>
    				<th class="manage-column column-name column-primary">Orden</th>
    				<th class="manage-column column-name column-primary">Tracking</th>
    				<th class="manage-column column-name column-primary">Carrier</th>
    				<th class="manage-column column-name column-primary">Costo</th>
    				<th class="manage-column column-name column-primary">Contenido/Embalaje</th>
    				<th class="manage-column column-name column-primary" style="text-align:center;">Tipo</th>
    				<th class="manage-column column-name column-primary" style="text-align:center;">Envío generado?</th>
    				<th class="manage-column column-name column-primary">Acciones</th>
    				<th class="manage-column column-name column-primary">Etiqueta</th>
    			</tr>
    		</thead>';

    echo '<tbody>';

    if( count( $shippings ) == 0)
    	echo "<td colspan='6' style='text-align:center;' ><strong>Sin envíos</strong></td>";
    else{

    	$baseDownloadLink = isset($config['paquetemx_checkbox_production']) ? 'http://54.201.237.120?trackingNumber=' : 'http://54.201.237.120/dev.php?trackingNumber=';


	    foreach( $shippings as $shipping ){
	    	$labelLink = $baseDownloadLink . ($shipping->tracking_number ?: 'nolabel');
    		echo '<tr>';
	    	echo "<td>" . ($shipping->order_id ?: "-") . "</td>";
	    	echo "<td>" . ($shipping->tracking_number ?: "-") . "</td>";
	    	echo "<td style='text-transform: uppercase;'>" . ($shipping->carrier ?: "-") . "</td>";
	    	echo "<td>$" . ($shipping->amount ?: "-") . "</td>";
	    	
	    	if( isset($shipping->content) )
	    		echo "<td>" . $shipping->content . "</td>";
	    	else
	    		echo "<td>-</td>";

	    	if( isset($shipping->type) )
	    		if( $shipping->type == "automatic")
	    			echo "<td><p style='text-align:center;'>Automático</p></td>";
	    		else if( $shipping->type == "" )
	    			echo "<td><p style='text-align:center;'>Automático</p></td>";
	    		else
	    			echo "<td><p style='text-align:center;'>Manual</p></td>";
	    	else
	    		echo "<td><p style='text-align:center;'>Automático</p></td>";

	    	if( isset($shipping->shipped) && isset($shipping->type) )
	    		if( $shipping->type == "automatic" )
	    			echo "<td><p style='text-align:center;'>☻</p></td>";
	    		else if( $shipping->type == "" )
	    			echo "<td><p style='text-align:center;'>☻</p></td>";
	    		else
	    			echo "<td><p style='text-align:center;'>" . ($shipping->shipped ? "☻" : "") . "</p></td>";
	    	else
	    		echo "<td><p style='text-align:center;'>☻</p></td>";

	    	if( isset($shipping->shipped) && isset($shipping->type) ){

	    		if( $shipping->shipped == 0 && $shipping->type == "manual" )
	    			echo "<td><span class='paquetemx-send-action' data-orderid='" . $shipping->order_id . "'>Enviar<img class='loader-".$shipping->order_id."' src='https://paquetemx.s3-us-west-2.amazonaws.com/loading.gif'/></span></td>";
	    		else
	    			echo "<td></td>";

	    	}else
	    		echo "<td></td>";

    		if( $shipping->tracking_number != "" )
    			echo "<td><a target='_blank' href='" . ($labelLink ?: "-") . "'>Descargar</a></td>";
    		else
    			echo "<td></td>";

    		echo '</tr>';
	    }
    }
    echo '</tbody>';
    echo '</table>';
    echo '<style>';
    echo '.paquetemx-send-action{color:#0073aa;position:relative;}.paquetemx-send-action:hover{color:#034666;cursor:pointer;}.paquetemx-send-action img{width: 25px;position:absolute;top: -7px;right: -25px;display:none;}';
    echo '</style>';
    echo '<script type="text/javascript">';
    echo 'jQuery(document).ready(function($) {
	$(".paquetemx-send-action").click(e => {

		let row = $(e.target)
		let orderId = row.data("orderid")
		console.log("#loader-"+orderId)
		$(".loader-"+orderId).show()
		let url = "' . admin_url('admin-ajax.php') . '";
		
		$.ajax({
			url: url,
			data: {action:"paquetemx_ship_ajax", orderId: orderId},
			type: "post",
			success: function(data){
				console.log( data )
				if( data.status == true ){
					location.reload()
				}else{
					alert("El envío no pudo ser realizado. Recibimos una notificación del envío y nuestro equipo de operaciones está trabajando para entregarte la etiqueta de tu envío lo antes posible.")
				}
			},
			complete: function() {
				$(".loader-"+orderId).hide()	
			}
		});
	})
 });';
    echo '</script>';
    echo '</div>';
}
 
function paquetemx_options_page_html() {
	 if ( ! current_user_can( 'manage_options' ) ) {
	 return;
	 }
	 
	 if ( isset( $_GET['settings-updated'] ) ) {
	 	add_settings_error( 'paquetemx_messages', 'paquetemx_message', __( '¡Configuración guardada!', 'paquetemx' ), 'updated' );
	 }
	 
	 settings_errors( 'paquetemx_messages' );
	 ?>
	 <div class="wrap">
		 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		 <form action="options.php" method="post">
			 <?php
			 settings_fields( 'paquetemx' );
			 do_settings_sections( 'paquetemx' );
			 submit_button( 'Guardar ajustes' );
			 ?>
		 </form>
	 </div>
	 <?php
 }


add_action( 'wp_ajax_paquetemx_ship_ajax', 'paquetemx_ship_ajax' );
add_action( 'wp_ajax_admin_paquetemx_ship_ajax', 'paquetemx_ship_ajax' );

function paquetemx_ship_ajax() {
	
	global $wpdb;

	$order_id = $_POST["orderId"];
	if( $order_id == "" ){
		return wp_send_json(array("status" => false));
	}else{
		
		$query = "SELECT * FROM {$wpdb->prefix}paquetemx_shippings WHERE order_id = '{$order_id}' LIMIT 1";
		$wpdb->get_results( $query );
		$pmxOrder = $wpdb->get_results( $query )[0];
		//$resp = array('orderId' => $order_id);
		
		/*		Body for Paquete.MX API 	*/
		//return wp_send_json( $pmxOrder );
		$json = $pmxOrder->json;
		$ship_body = json_decode($json);
		$provider = $pmxOrder->carrier;
		$order = wc_get_order( $order_id );
		@$shipping_method = reset($order->get_shipping_methods());
		$provider_code 	= $shipping_method->get_meta( 'provider_code' );
		$packages = PMX_Shipping_Functions::convert_to_packages($order->get_items());

    	$config = get_option( 'paquetemx_options' );
    	$env = isset($config['paquetemx_checkbox_production']) ? 'prod' : 'dev';
    	$api_token = $config['paquetemx_field_api_token'];

		/* 		Consumes Paquete.MX API 	*/
		$args = [
    		'timeout' 	=> '15',
    		'sslverify' => false,
		    'body' 		=> $json,
		    'headers'	=> [
		    	'Content-Type'	=> 	'application/json',
		    	'pmx_api_token'	=>	$api_token
		    ]
		];

    	//return wp_send_json(array("status" => false));

    	/* 	Consumes Shipping API 	*/
		$response = wp_remote_post('https://api.paquete.mx/' . $env . '/pmx-ship', $args);
		$r = json_decode($response['body']);

		$notification_body = [
    		'status' 			=>	'',
    		'type'				=> 	'shipping',
    		'shipping'			=>	$ship_body,
    		'response'			=>	$r,
    		'packagesNames'		=>	$pmxOrder->content,
    		'trackingNumber'	=>	'',
    		'platform'			=>	'WORDPRESS'
    	];

    	/*	Buuilds Notification Body 	*/

    	$shipping_status = '';
    	$shippingStatus = false;
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
				PMX_Shipping_Functions::update_shipping( $order_id, $trackingNumber, 1 );
			}else{
				/* 	Shipment request failed	*/
				$notification_body['trackingNumber'] = 'SIN GUÍA';
			}

			/* 		Updates DB with Shipping info 	*/
		}else{
			/* 	Shipment request failed	*/
			$notification_body['trackingNumber'] = 'SIN GUÍA';
		}

    	/*	Consumes Notification API 	*/
    	$args = [
    		'timeout' 	=> '15',
    		'sslverify' => false,
		    'body' 		=> json_encode($notification_body),
		    'headers'	=> [
		    	'Content-Type'	=> 	'application/json',
		    	'pmx_api_token'	=>	$api_token
		    ]
		];

		$response = wp_remote_post('https://api.paquete.mx/'.$env.'/pmx-notification', $args);
		$r = json_decode($response['body']);

		if(isset($config['paquetemx_pickup'])){

			/* 	If shipment was successfully made, checks if pickup is available and then requests it	*/
			if($shipping_status === '9008'){
				$notification_body['type'] = 'pickup';
				
				if($provider != 'redpack'){ /* 	Pickup is available	for UPS and FEDEX */
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
						'serviceCode'		=> 	$provider_code
					];

			    	$args = [
			    		'timeout' 	=> '60',
			    		'sslverify' => false,
					    'body' 		=> json_encode($pickup_body),
					    'headers'	=> [
					    	'Content-Type'	=> 	'application/json',
					    	'pmx_api_token'	=>	$api_token
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
				    	'Content-Type'	=> 	'application/json',
				    	'pmx_api_token'	=>	$api_token
				    ]
				];

				/* 	Consumes PMX Notification API 	*/
				$response = wp_remote_post('https://api.paquete.mx/'.$env.'/pmx-notification', $args);
					
			}
		}

		if( $shippingStatus == true )
			wp_send_json(array("status" => true));
		else
			wp_send_json(array("status" => false));

	}
}
