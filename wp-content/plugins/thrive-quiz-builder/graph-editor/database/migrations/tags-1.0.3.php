<?php
/**
 * Thrive Themes  https://thrivethemes.com
 *
 * @package thrive-quiz-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}

global $wpdb;
$answers = tge_table_name( 'answers' );

$sqls   = array();
$sqls[] = " ALTER TABLE {$answers} ADD `tags` TEXT NULL DEFAULT NULL AFTER `is_right`;";

foreach ( $sqls as $sql ) {
	if ( $wpdb->query( $sql ) === false ) {
		return false;
	}
}

return true;
