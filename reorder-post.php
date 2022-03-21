<?php
function reorder_posts( $order = array() ) {
    global $wpdb;
    $list = join(', ', $order);
    $wpdb->query( 'SELECT @i:=-1' );
    $result = $wpdb->query(
        "UPDATE wp_posts SET menu_order = ( @i:= @i+1 )
        WHERE ID IN ( $list ) ORDER BY FIELD( ID, $list );"
    );
    return $result;
}