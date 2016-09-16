<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Set-up database tables.
 */
function iewp_slick_create_tables()
{
	global $wpdb;

	$sql = "CREATE TABLE IF NOT EXISTS `iewp_slick_carousels` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) NOT NULL DEFAULT '',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$query = $wpdb->query( $sql );
}

iewp_slick_create_tables();
