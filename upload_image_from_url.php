<?php
function mrpi_upload_from_url( $url, $alt="") {
    include_once ABSPATH . 'wp-admin/includes/media.php';
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/image.php';
    $tmp = download_url( $url );
    $desc = $alt;
    $file_array = array();

    preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $url, $matches);
    $file_array['name'] = basename($matches[0]);
    $file_array['tmp_name'] = $tmp;

    // If error storing temporarily, unlink
    if ( is_wp_error( $tmp ) ) {
        @unlink($file_array['tmp_name']);
        $file_array['tmp_name'] = '';
    }

    // do the validation and storage stuff
    $id = media_handle_sideload( $file_array, $postID, $desc);

    // If error storing permanently, unlink
    if ( is_wp_error($id) ) {
        @unlink($file_array['tmp_name']);
        return $id;
    }

    return $id;
}