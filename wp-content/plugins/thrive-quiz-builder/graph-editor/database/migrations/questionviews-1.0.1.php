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
$questions = tge_table_name( 'questions' );

$sqls   = array();
$sqls[] = " ALTER TABLE {$questions} ADD views INT(10) NULL DEFAULT 0;";

foreach ( $sqls as $sql ) {
	if ( $wpdb->query( $sql ) === false ) {
		return false;
	}
}

return true;
