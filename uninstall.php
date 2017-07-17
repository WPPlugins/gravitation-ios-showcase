<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
$gravitation_ios_showcase_cat = 'gravitation_ios_showcase_cat';
delete_option( $gravitation_ios_showcase_cat );
?>