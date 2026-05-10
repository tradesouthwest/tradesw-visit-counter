<?php
/**
 * Plugin Name:       Tradesw Visit Counter
 * Plugin URI:        https://github.com/tradesouthwest/tradesw-visit-counter
 * Description:       Adds a column to posts admin page to show visit count.
 * Version:           1.0.1
 * Requires at least: 4.9.15
 * Requires PHP:      7.4
 * Requires CP:       1.3
 * Author:            Larry Judd @Tradesouthwest
 * Author URI:        https://tradesouthwest.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tradesw-visit-counter
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Tradesw_Visit_Counter {

    public function __construct() {
        // Register the tracking function
        add_action( 'wp_head', [ $this, 'track_post_views' ] );
        
        // Load Admin Class
        if ( is_admin() ) {
            require_once plugin_dir_path( __FILE__ ) . 'inc/class-admin-columns.php';
            new Tradesw_Admin_Columns();
        }
    }

    /**
     * Increments the view count for single post types.
     */
    public function track_post_views() {
        if ( is_single() ) {
            global $post;
            $count = get_post_meta( $post->ID, '_tradesw_post_views', true );
            $count = ( $count == '' ) ? 0 : $count;
            $count++;
            update_post_meta( $post->ID, '_tradesw_post_views', $count );
        }
    }
}

new Tradesw_Visit_Counter();