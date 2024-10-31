<?php
$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );


if ( in_array( 'woocommerce/woocommerce.php',  $active_plugins) ) {

	function woocommerce_product_custom_fields_save($post_id){

	    $woocommerce_autogroup_product = $_POST['_autogroup_product'];

	    if (!empty($woocommerce_autogroup_product)){
	        update_post_meta($post_id, '_autogroup_product', esc_attr($woocommerce_autogroup_product));
	    }else{
	        update_post_meta($post_id, '_autogroup_product', esc_attr('no'));
	    }


	    $woocommerce_max_group_number = $_POST['_max_group_number'];

	    if (!empty($woocommerce_max_group_number))
	        update_post_meta($post_id, '_max_group_number', esc_attr($woocommerce_max_group_number));


	    $woocommerce_package_length = $_POST['_package_length'];

	    if (!empty($woocommerce_package_length))
	        update_post_meta($post_id, '_package_length', esc_html($woocommerce_package_length));

	    $woocommerce_package_width = $_POST['_package_width'];

	    if (!empty($woocommerce_package_width))
	        update_post_meta($post_id, '_package_width', esc_html($woocommerce_package_width));

	    $woocommerce_package_height = $_POST['_package_height'];

	    if (!empty($woocommerce_package_height))
	        update_post_meta($post_id, '_package_height', esc_html($woocommerce_package_height));

	}
	function woocommerce_variation_custom_fields_save($variation_id, $i){

	    $woocommerce_autogroup_product = $_POST['_autogroup_product'][$i];

	    if (!empty($woocommerce_autogroup_product)){
	        update_post_meta($variation_id, '_autogroup_product', esc_attr($woocommerce_autogroup_product));
	    }else{
	        update_post_meta($variation_id, '_autogroup_product', esc_attr('no'));
	    }


	    $woocommerce_max_group_number = $_POST['_max_group_number'][$i];

	    if (!empty($woocommerce_max_group_number))
	        update_post_meta($variation_id, '_max_group_number', esc_attr($woocommerce_max_group_number));


	    $woocommerce_package_length = $_POST['_package_length'][$i];

	    if (!empty($woocommerce_package_length))
	        update_post_meta($variation_id, '_package_length', esc_html($woocommerce_package_length));

	    $woocommerce_package_width = $_POST['_package_width'][$i];

	    if (!empty($woocommerce_package_width))
	        update_post_meta($variation_id, '_package_width', esc_html($woocommerce_package_width));

	    $woocommerce_package_height = $_POST['_package_height'][$i];

	    if (!empty($woocommerce_package_height))
	        update_post_meta($variation_id, '_package_height', esc_html($woocommerce_package_height));

	}
	add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
	add_action('woocommerce_save_product_variation', 'woocommerce_variation_custom_fields_save', 10, 2);



	function woocommerce_product_custom_paquetemx_fields(){


		global $woocommerce, $post;
	    echo '<div class="product_custom_field">';

	    woocommerce_wp_checkbox(
	        array(
	            'id' 			=> '_autogroup_product',
	            'label' 		=> '¿Agrupar productos iguales en envío?',
	        )
	    );

	    woocommerce_wp_text_input(
	        array(
	            'id' 			=> '_max_group_number',
	            'placeholder' 	=> 'Máximo número de productos por paquete',
	            'label' 		=> 'Cantidad máxima de productos por paquete',
	            'type' 			=> 'number',
	            'custom_attributes' => array(
	                'step' 		=> '1',
	                'min' 		=> '0'
	            )
	        )
	    );
		
	    woocommerce_wp_text_input(
	        array(
	            'id' 			=> '_package_length',
	            'placeholder' 	=> 'cm.',
	            'label' 		=> 'Dimensiones de caja en cm. (Largo)',
	            'type' 			=> 'number',
	            'custom_attributes' => array(
	                'step' 		=> '0.01',
	                'min' 		=> '0'
	            )
	        )
	    );
	    woocommerce_wp_text_input(
	        array(
	            'id' 			=> '_package_width',
	            'placeholder' 	=> 'cm.',
	            'label' 		=> 'Dimensiones de caja en cm. (Ancho)',
	            'type' 			=> 'number',
	            'custom_attributes' => array(
	                'step' 		=> '0.01',
	                'min' 		=> '0'
	            )
	        )
	    );
	    woocommerce_wp_text_input(
	        array(
	            'id' 			=> '_package_height',
	            'placeholder' 	=> 'cm.',
	            'label' 		=> 'Dimensiones de caja en cm. (Alto)',
	            'type' 			=> 'number',
	            'custom_attributes' => array(
	                'step' 		=> '0.01',
	                'min' 		=> '0'
	            )
	        )
	    );


	    echo '</div>';
	}
	function woocommerce_variation_custom_paquetemx_fields($loop, $variation_data, $variation){

		global $woocommerce, $post;
	    echo '<div class="options_group">';
	    echo "<h2 style='border-bottom:1px solid rgba(0, 0, 0, 0.6);'>Opciones de envío - Paquete.MX</h2>";

	    woocommerce_wp_checkbox(
	        array(
	            'id' 			=> '_autogroup_product['.$loop.']',
	            'class'			=> 'checkbox',
	            'style'			=> 'margin-right: 5px !important',
	            'label' 		=> '¿Agrupar productos iguales en envío?',
	            'value'			=> get_post_meta( $variation->ID, '_autogroup_product', true )
	        )
	    );

	    /*woocommerce_wp_text_input(
	        array(
	            'id' 			=> '_max_group_number['.$loop.']',
	            'placeholder' 	=> 'Máximo número de productos por paquete',
	            'label' 		=> 'Cantidad máxima de productos por paquete',
	            'type' 			=> 'number',
	            'custom_attributes' => array(
	                'step' 		=> '1',
	                'min' 		=> '0'
	            ),
	            'value'			=> get_post_meta( $variation->ID, '_max_group_number', true )
	        )
	    );*/

	    //	Max Group Number Input
	    ?>
		<p class="form-field form-row dimensions_field form-row-first">
			<label>Cantidad máxima de productos por paquete: </label>
			<span class="wrap">
				<?php $max_group_number = get_post_meta( $variation->ID, '_max_group_number', true ); ?>	
				<input
					name="<?php echo '_max_group_number['.$loop.']'; ?>"
					id="<?php echo '_max_group_number['.$loop.']'; ?>"
					placeholder="Máximo número de productos por paquete"
					class="input-text wc_input_decimal"
					type="number"
					value="<?php echo $max_group_number; ?>"
					step="1"
					min="0" />
			</span>
		</p>
		<?php

	    //	Dimensions
	    ?>
		<p class="form-field form-row dimensions_field form-row-last">
			<label>Dimensiones de caja (Alto × Largo × Ancho) en cm.</label>
			<span class="wrap">
				<?php 
					$package_height = get_post_meta( $variation->ID, '_package_height', true );
					$package_length = get_post_meta( $variation->ID, '_package_length', true );
					$package_width = get_post_meta( $variation->ID, '_package_width', true );
				?>	
				<input
					name="<?php echo '_package_height['.$loop.']'; ?>"
					id="<?php echo '_package_height['.$loop.']'; ?>"
					placeholder="10"
					class="input-text wc_input_decimal"
					type="number"
					value="<?php echo $package_height; ?>"
					step="1"
					min="0"/>
				<input
					name="<?php echo '_package_length['.$loop.']'; ?>"
					id="<?php echo '_package_length['.$loop.']'; ?>"
					placeholder="15"
					class="input-text wc_input_decimal"
					type="number"
					value="<?php echo $package_length; ?>"
					step="1"
					min="0"/>
				<input
					name="<?php echo '_package_width['.$loop.']'; ?>"
					id="<?php echo '_package_width['.$loop.']'; ?>"
					placeholder="20"
					class="input-text wc_input_decimal"
					type="number"
					value="<?php echo $package_width; ?>"
					step="1"
					min="0"/>
		</p>
		<?php
		
	    /*woocommerce_wp_text_input(
	        array(
	            'id' 			=> '_package_length['.$loop.']',
	            'placeholder' 	=> 'cm.',
	            'label' 		=> 'Dimensiones de caja en cm. (Largo)',
	            'type' 			=> 'number',
	            'custom_attributes' => array(
	                'step' 		=> '0.01',
	                'min' 		=> '0'
	            ),
	            'value'			=> get_post_meta( $variation->ID, '_package_length', true )
	        )
	    );
	    woocommerce_wp_text_input(
	        array(
	            'id' 			=> '_package_width['.$loop.']',
	            'placeholder' 	=> 'cm.',
	            'label' 		=> 'Dimensiones de caja en cm. (Ancho)',
	            'type' 			=> 'number',
	            'custom_attributes' => array(
	                'step' 		=> '0.01',
	                'min' 		=> '0'
	            ),
	            'value'			=> get_post_meta( $variation->ID, '_package_width', true )
	        )
	    );
	    woocommerce_wp_text_input(
	        array(
	            'id' 			=> '_package_height['.$loop.']',
	            'placeholder' 	=> 'cm.',
	            'label' 		=> 'Dimensiones de caja en cm. (Alto)',
	            'type' 			=> 'number',
	            'custom_attributes' => array(
	                'step' 		=> '0.01',
	                'min' 		=> '0'
	            ),
	            'value'			=> get_post_meta( $variation->ID, '_package_height', true )
	        )
	    );*/


	    echo '</div>';

	}
	add_action('woocommerce_product_options_shipping', 'woocommerce_product_custom_paquetemx_fields');
	add_action('woocommerce_variation_options_pricing', 'woocommerce_variation_custom_paquetemx_fields', 10, 3);

}