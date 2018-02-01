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
$sqls[]  = " ALTER TABLE {$answers} ADD `is_right` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `points`;";

foreach ( $sqls as $sql ) {
	if ( $wpdb->query( $sql ) === false ) {
		return false;
	}
}

return true;
