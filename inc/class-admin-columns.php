<?php
/**
 * Tradesw visit counter
 * @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) exit;

class Tradesw_Admin_Columns {

    public function __construct() {
        // Filter the column headers
        add_filter( 'manage_posts_columns', [ $this, 'add_views_column' ] );
        // Render the column content
        add_action( 'manage_posts_custom_column', [ $this, 'render_views_column' ], 10, 2 );
        // Make the column sortable
        add_filter( 'manage_edit-post_sortable_columns', [ $this, 'make_views_sortable' ] );
    }

    /**
     * Injects the 'Views' column after the 'Comments' column.
     */
    public function add_views_column( $columns ) {
        $new_columns = [];
        foreach ( $columns as $key => $value ) {
            $new_columns[$key] = $value;
            if ( $key === 'comments' ) {
                $new_columns['post_views'] = __( 'Views', 'tradesw-visit-counter' );
            }
        }
        return $new_columns;
    }

    /**
     * Fetches and displays the view count for each row.
     */
    public function render_views_column( $column, $post_id ) {
        if ( $column === 'post_views' ) {
            $views = get_post_meta( $post_id, '_tradesw_post_views', true );
            echo $views ? esc_html( $views ) : '0';
        }
    }

    /**
     * Enables sorting by the view count metadata.
     */
    public function make_views_sortable( $columns ) {
        $columns['post_views'] = 'post_views';
        return $columns;
    }
}