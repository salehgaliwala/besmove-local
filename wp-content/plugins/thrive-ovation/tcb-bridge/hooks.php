<?php

add_filter( 'wp', 'tvo_shortcode_post' );

add_shortcode( 'tvo_shortcode', 'tvo_render_shortcode' );

/**
 * TCB 2.0 Hooks
 */

add_filter( 'tcb_elements', 'tvo_tcb_add_elements', 10, 1 );

/**
 * Adds extra script(s) to the main frame
 */
add_action( 'tcb_main_frame_enqueue', 'tvo_tcb_enqueue_scripts', 10, 0 );

/**
 * Add menu components/controls for ovation elements
 */
add_filter( 'tcb_menu_path_ovation_capture', 'tvo_tcb_capture_menu_path' );
add_filter( 'tcb_menu_path_ovation_display', 'tvo_tcb_display_menu_path' );

/**
 * Import backbone templates to editor page
 */
add_filter( 'tcb_backbone_templates', 'tvo_tcb_add_backbone_templates' );
add_filter( 'tcb_modal_templates', 'tvo_tcb_add_modal_templates' );

/**
 * Enqueue tcb editor scripts
 */
add_action( 'tcb_editor_enqueue_scripts', 'tvo_tcb_load_editor_scripts' );

