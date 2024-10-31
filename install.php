<?php

function paquetemx_activate() {
	
	global $wpdb;

	$qry = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}paquetemx_shippings (
            id INT NOT NULL AUTO_INCREMENT,
            tracking_number VARCHAR(50) NOT NULL,
            carrier VARCHAR(40) NOT NULL,
            amount VARCHAR(10) NOT NULL,
            status VARCHAR(20) NOT NULL,
            response_code VARCHAR(20) NOT NULL,
            order_id VARCHAR(20) NOT NULL,
            content TEXT NOT NULL,
                PRIMARY KEY (id))";
                
    $states = $wpdb->get_results( $qry );
}