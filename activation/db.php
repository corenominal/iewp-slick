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
			  `options` text NOT NULL DEFAULT '',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$query = $wpdb->query( $sql );

	$sql = "CREATE TABLE IF NOT EXISTS `iewp_slick_carousel_images` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `carousel_id` int(11) NOT NULL,
			  `order` int(11) NOT NULL,
			  `img_url` varchar(255) NOT NULL DEFAULT '',
			  `img_alt` varchar(255) NOT NULL DEFAULT '',
			  `img_title` varchar(255) NOT NULL DEFAULT '',
			  `link_url` varchar(255) NOT NULL DEFAULT '',
			  PRIMARY KEY (`id`),
			  KEY `carousel_id` (`carousel_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$query = $wpdb->query( $sql );
}

iewp_slick_create_tables();
