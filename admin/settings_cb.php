<?php
function paquetemx_section_developers_cb( $args ) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'En ésta sección puedes configurar el comportamiento que tendrá el plugin en tu plataforma. Para más información sobre el uso de la API revisar la documentación.', 'paquetemx' ); ?></p>
	<?php
	if(!class_exists('WooCommerce')){
		?>
		<div class="notice notice-error ">
	        <p><?php _e( 'Woocommerce aún no está instalado. Paquete.MX funciona para WooCommerce. Por favor, instálalo antes de continuar', 'paquetemx' ); ?></p>
	    </div>
	<?php
	}else{
		?>
		<div class="notice notice-success is-dismissible">
	        <p><?php _e( 'Woocommerce ya está instalado correctamente. Puedes empezar a usar el plugin Paquete.MX sin problema', 'paquetemx' ); ?></p>
	    </div>
	<?php
	
	if(!function_exists('curl_init')) {
		?>
		<div class="notice notice-error ">
	        <p><?php _e( 'cURL no está instalado en tu servidor. Esta extensión es necesaria para poder comunicarte con los servicios de Paquete.MX', 'paquetemx' ); ?></p>
	    </div>
	<?php
	}
		?>
	<?php
	
	if(!function_exists('mb_convert_encoding')) {
		?>
		<div class="notice notice-error ">
	        <p><?php _e( 'La extensión mbstring no está instalado en tu servidor. Esta extensión es necesaria para poder comunicarte con los servicios de Paquete.MX', 'paquetemx' ); ?></p>
	    </div>
	<?php
	}
		?>
		<div class="notice notice-info">
	        <p><?php _e( '¿Tienes dudas sobre la configuración? Puedes consultar la documentación del plugin:', 'paquetemx' ); ?>
	        	<a href="https://paquete.mx/docs/plugin/wordpress/DocumentacionPluginWordpress.pdf" target="_blank">Ver documentación</a>
	        </p>
	    </div>
	<?php

	}
}

function paquetemx_pickup_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<input type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
		<?php echo isset( $options[ $args['label_for']] ) ? esc_attr("checked") : '' ?>
		/>
	<p class="description">
		<?php esc_html_e( 'Si ésta opción está activada, la recolección se realizará de forma automática al domicilio configurado en ésta sección inmediatamente después de haber realizado un envío de forma correcta.' ); ?>
	</p>
	<?php
}

function paquetemx_field_api_token_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
		value="<?php echo esc_attr($options[ $args['label_for'] ]) ?>"
		class="regular-text" required="required" />
	<p class="description">
		<?php esc_html_e( 'El API Token es tu llave de acceso a la API de Paquete.MX. Lo obtienes en la sección EMPRESARIAL del dashboard de tu cuenta empresarial en' ); ?>
		<span><a href="https://paquete.mx">PAQUETE</a></span>
		<?php esc_html_e( 'o', 'paquetemx' ); ?>
		<span><a href="http://beta.paquete.mx">BETA PAQUETE</a></span>
		<?php esc_html_e( 'que corresponden a los entornos de producción y desarrollo respectivamente.', 'paquetemx' ); ?>
	</p>
	<?php
}
function paquetemx_checkbox_production_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<input type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
		<?php echo isset( $options[ $args['label_for']] ) ? esc_attr("checked") : '' ?>
		/>
	<p class="description">
		<?php esc_html_e( 'Si ésta opción está activada, el plugin trabajará en el entorno de producción. En caso contrario estará trabajando en el entorno de desarrollo (BETA Paquete)' ); ?>
	</p>
	<?php
}

function paquetemx_manual_shipping_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<input type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
		<?php echo isset( $options[ $args['label_for']] ) ? esc_attr("checked") : '' ?>
		/>
	<p class="description">
		<?php esc_html_e( 'Si ésta opción está activada, los envíos al final del checkout no se generarán automáticamente y se quedarán en espera. Se podrán realizar en el panel de envíos.' ); ?>
	</p>
	<?php
}

function paquetemx_checkbox_providers_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<p>
		<input type="checkbox" id="<?php echo esc_attr('fedex'); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'fedex' ); ?>]"
			<?php echo isset( $options['fedex'] ) ? esc_attr("checked") : '' ?>
			/> Fedex
	</p>
	<p>
		<input type="checkbox" id="<?php echo esc_attr('ups'); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'ups' ); ?>]"
			<?php echo isset( $options['ups'] ) ? esc_attr("checked") : '' ?>
			/> UPS
	</p>
	<p>
		<input type="checkbox" id="<?php echo esc_attr('redpack'); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'redpack' ); ?>]"
			<?php echo isset( $options['redpack'] ) ? esc_attr("checked") : '' ?>
			/> Redpack
	</p>
	<p class="description">
		<?php esc_html_e( 'Elige qué paqueterías vas a incluir en el cálculo de los envíos. NOTA: Es recomendable elegir todas pues hay paqueterías que no entregan en determinadas zonas. En el caso de que no aparezcan paqueterías en el cálculo del envío, puede seleccionar el comportamiento que tendrá el proceso de pago. Revisar la opción "¿Omitir pago en envíos sin cobertura?".' ); ?>
	</p>
	<?php
}

function paquetemx_radio_currency_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<p>
		<input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
			name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			<?php if($options[ $args['label_for'] ] === 'MXN' || !isset($options[ $args['label_for'] ])) echo esc_attr("checked"); else echo ''; ?>
			value="<?php echo esc_attr( 'MXN' ) ?>"
			/> MXN - Peso mexicano
			
	</p>
	<p>
		<input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
			name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			<?php echo $options[ $args['label_for'] ] === 'USD' ? esc_attr("checked") : '' ?>
			value="<?php echo esc_attr( 'USD' ) ?>"
			/> USD - Dolar estadounidense
	</p>
	<p class="description">
		<?php esc_html_e( 'Esta opción define la divisa en la que se mostrará el precio del envío.' ); ?>
	</p>
	<?php
}

function paquetemx_rate_increase_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="paquetemx_options[<?php echo esc_attr( 'rate_increase' ); ?>]"
		value="<?php echo isset($options['rate_increase']) ? esc_attr($options['rate_increase']) : 0 ?>"
		/> %
	<p class="description">
		<?php esc_html_e( 'Indica un incremento porcentual en el costo del envío que se muestra en el carrito de compras. Si deseas mostrar el costo de los envíos tal cual sin incrementos, puedes dejar este valor en 0' ); ?>
	</p>
	<?php
}

function paquetemx_radio_behaviour_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<p>
		<input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
			name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			<?php echo $options[ $args['label_for'] ] === 'fastest' ? '' : esc_attr("checked") ?>
			value="<?php echo esc_attr( 'lowest_price' ) ?>"
			/> Paquetería más barata - Devuelve un resultado
	</p>
	<p>
		<input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
			name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			<?php echo $options[ $args['label_for'] ] === 'fastest' ? esc_attr("checked") : '' ?>
			value="<?php echo esc_attr( 'fastest' ) ?>"
			/> Paquetería más rápida - Devuelve un resultado
	</p>
	<p>
		<input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
			name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			<?php echo $options[ $args['label_for'] ] === 'fastest_services' ? esc_attr("checked") : '' ?>
			value="<?php echo esc_attr( 'fastest_services' ) ?>"
			/> Paqueterías más rápidas - Devuelve varios resultados
	</p>
	<p>
		<input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
			name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			<?php echo $options[ $args['label_for'] ] === 'cheapest_services' ? esc_attr("checked") : '' ?>
			value="<?php echo esc_attr( 'cheapest_services' ) ?>"
			/> Paqueterías más baratas - Devuelve varios resultados
	</p>
	<p class="description">
		<?php esc_html_e( 'Esta opcion define el comportamiento para el cálculo del costo del envío. Elige si deseas que en el checkout apareza uno o varios servicios, más baratos o más rápidos.' ); ?>
	</p>
	<?php
}

function paquetemx_checkbox_payment_bypass_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<input type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="paquetemx_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
		<?php echo isset( $options[ $args['label_for']] ) ? esc_attr("checked") : '' ?>
		/>
	<p class="description">
		<?php esc_html_e( 'Si ésta opción está activada, cuando no aparezcan paqueterías que puedan cubrir el envío hacia el domicilio de destino especificado, la orden se completará omitiendo el pago. Si está desactivada, se realizará el cobro del carrito únicamente. En ambos casos el envío tendrá qué realizarse manualmente contactando a Paquete.MX' ); ?>
	</p>
	<?php
}
function paquetemx_services_number_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="paquetemx_options[<?php echo esc_attr( 'services_limit' ); ?>]"
		value="<?php echo isset($options['services_limit']) ? esc_attr($options['services_limit']) : 0 ?>"
		/>
	<p class="description">
		<?php esc_html_e( 'Elige hasta cuántas opciones de envíos se mostrarán en el checkout. Escribe 0 o deja el campo vacío si no deseas establecer un límite (sólo aplica si en Cálculo de costo está seleccionado "Paqueterías más rápidas" o "Paqueterías más baratas' ); ?>
	</p>
	<?php
}

function paquetemx_shipper_info_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<p>
		Nombre:
		<input type="text" id="<?php echo esc_attr( 'from_name' ); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'from_name' ); ?>]"
			value="<?php echo isset($options['from_name']) ? esc_attr($options['from_name']) : '' ?>"
			class="regular-text" required="required" maxlength="22"
			/>
	</p>
	<p>
		Empresa:
		<input type="text" id="<?php echo esc_attr( 'from_company' ); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'from_company' ); ?>]"
			value="<?php echo isset($options['from_company']) ? esc_attr($options['from_company']) : '' ?>"
			class="regular-text" required="required" maxlength="22"
			/>
	</p>
	<p>
		Teléfono:
		<input type="text" id="<?php echo esc_attr( 'from_phone' ); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'from_phone' ); ?>]"
			value="<?php echo isset($options['from_phone']) ? esc_attr($options['from_phone']) : '' ?>" required="required"
			/>
	</p>
	<p>
		Email:
		<input type="email" id="<?php echo esc_attr( 'from_email' ); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'from_email' ); ?>]"
			value="<?php echo isset($options['from_email']) ? esc_attr($options['from_email']) : '' ?>"
			class="regular-text" required="required"
			/> <small>* A éste correo recibirás tus etiquetas de envío, facturas y notificaciones relacionadas con tus envíos</small>
	</p>
	<p class="description">
		<?php esc_html_e( 'Ésta información será agregada a las etiquetas de envío que generen tus ventas.' ); ?>
	</p>
	<?php
}
function paquetemx_address_cb( $args ) {
	$options = get_option( 'paquetemx_options' );
	?>
	<p>
		Estado:
		<select id="<?php echo esc_attr( 'state' ); ?>"
		name="paquetemx_options[<?php echo esc_attr( 'state' ); ?>]"
		>
			<option value="AGUASCALIENTES" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'AGUASCALIENTES', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'AGUASCALIENTES', 'paquetemx' ); ?>
			</option>
			<option value="BAJA CALIFORNIA" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'BAJA CALIFORNIA', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'BAJA CALIFORNIA', 'paquetemx' ); ?>
			</option>
			<option value="BAJA CALIFORNIA SUR" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'BAJA CALIFORNIA SUR', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'BAJA CALIFORNIA SUR', 'paquetemx' ); ?>
			</option>
			<option value="CAMPECHE" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'CAMPECHE', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'CAMPECHE', 'paquetemx' ); ?>
			</option>
			<option value="CHIHUAHA" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'CHIHUAHA', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'CHIHUAHA', 'paquetemx' ); ?>
			</option>
			<option value="CHIAPAS" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'CHIAPAS', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'CHIAPAS', 'paquetemx' ); ?>
			</option>
			<option value="CIUDAD DE MEXICO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'CIUDAD DE MEXICO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'CIUDAD DE MEXICO', 'paquetemx' ); ?>
			</option>
			<option value="CUAHUILA" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'CUAHUILA', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'CUAHUILA', 'paquetemx' ); ?>
			</option>
			<option value="COLIMA" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'COLIMA', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'COLIMA', 'paquetemx' ); ?>
			</option>
			<option value="DURANGO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'DURANGO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'DURANGO', 'paquetemx' ); ?>
			</option>
			<option value="GUANAJUATO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'GUANAJUATO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'GUANAJUATO', 'paquetemx' ); ?>
			</option>
			<option value="GUERRERO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'GUERRERO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'GUERRERO', 'paquetemx' ); ?>
			</option>
			<option value="HIDALGO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'HIDALGO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'HIDALGO', 'paquetemx' ); ?>
			</option>
			<option value="JALISCO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'JALISCO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'JALISCO', 'paquetemx' ); ?>
			</option>
			<option value="MEXICO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'MEXICO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'MEXICO', 'paquetemx' ); ?>
			</option>
			<option value="MICHOACAN" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'MICHOACAN', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'MICHOACAN', 'paquetemx' ); ?>
			</option>
			<option value="MORELOS" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'MORELOS', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'MORELOS', 'paquetemx' ); ?>
			</option>
			<option value="NAYARIT" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'NAYARIT', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'NAYARIT', 'paquetemx' ); ?>
			</option>
			<option value="NUEVO LEON" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'NUEVO LEON', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'NUEVO LEON', 'paquetemx' ); ?>
			</option>
			<option value="OAXACA" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'OAXACA', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'OAXACA', 'paquetemx' ); ?>
			</option>
			<option value="PUEBLA" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'PUEBLA', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'PUEBLA', 'paquetemx' ); ?>
			</option>
			<option value="QUERETARO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'QUERETARO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'QUERETARO', 'paquetemx' ); ?>
			</option>
			<option value="QUINTANA ROO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'QUINTANA ROO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'QUINTANA ROO', 'paquetemx' ); ?>
			</option>
			<option value="SAN LUIS POTOSI" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'SAN LUIS POTOSI', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'SAN LUIS POTOSI', 'paquetemx' ); ?>
			</option>
			<option value="SINALOA" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'SINALOA', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'SINALOA', 'paquetemx' ); ?>
			</option>
			<option value="SONORA" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'SONORA', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'SONORA', 'paquetemx' ); ?>
			</option>
			<option value="TABASCO" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'TABASCO', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'TABASCO', 'paquetemx' ); ?>
			</option>
			<option value="TAMAULIPAS" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'TAMAULIPAS', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'TAMAULIPAS', 'paquetemx' ); ?>
			</option>
			<option value="TLAXCALA" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'TLAXCALA', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'TLAXCALA', 'paquetemx' ); ?>
			</option>
			<option value="VERACRUZ" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'VERACRUZ', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'VERACRUZ', 'paquetemx' ); ?>
			</option>
			<option value="YUCATAN" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'YUCATAN', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'YUCATAN', 'paquetemx' ); ?>
			</option>
			<option value="ZACATECAS" <?php echo isset( $options[ 'state' ] ) ? ( selected( $options[ 'state' ], 'ZACATECAS', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'ZACATECAS', 'paquetemx' ); ?>
			</option>
			
		</select>
	</p>
	<p>
		Ciudad:
		<input type="text" id="<?php echo esc_attr( 'from_city' ); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'from_city' ); ?>]"
			value="<?php echo isset($options['from_city']) ? esc_attr($options['from_city']) : '' ?>"
			class="regular-text" required="required" maxlength="25"
			/>
	</p>
	<p>
		Colonia:
		<input type="text" id="<?php echo esc_attr( 'from_county' ); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'from_county' ); ?>]"
			value="<?php echo isset($options['from_county']) ? esc_attr($options['from_county']) : '' ?>"
			class="regular-text" required="required" maxlength="25"
			/>
	</p>
	<p>
		Calle y número:
		<input type="text" id="<?php echo esc_attr( 'from_street' ); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'from_street' ); ?>]"
			value="<?php echo isset($options['from_street']) ? esc_attr($options['from_street']) : '' ?>"
			class="regular-text" required="required" maxlength="30"
			/>
	</p>
	<p>
		Número interior:
		<input type="text" id="<?php echo esc_attr( 'from_number' ); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'from_number' ); ?>]"
			value="<?php echo isset($options['from_number']) ? esc_attr($options['from_number']) : '' ?>" required="required" maxlength="25"
			/>
	</p>
	<p>
		Código Postal:
		<input type="text" id="<?php echo esc_attr( 'from_zip' ); ?>"
			name="paquetemx_options[<?php echo esc_attr( 'from_zip' ); ?>]"
			value="<?php echo isset($options['from_zip']) ? esc_attr($options['from_zip']) : '' ?>" required="required"
			/>
	</p>
	<p class="description">
		<?php esc_html_e( 'Ésta será la dirección a la cual serán solicitadas las recolecciones automáticas, además de ser la dirección de origen especificada en las etiquetas de envío.' ); ?>
	</p>
	<?php
}