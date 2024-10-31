<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
delete_option("paquetemx_options");

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}paquetemx_shippings");