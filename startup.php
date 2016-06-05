<?php

// Exit if accessed directly
if( count( get_included_files() ) == 1 ) exit( "Direct access not permitted." );

define( 'ABSPATH', dirname(__FILE__) . '/' );

if ( file_exists( ABSPATH . 'config.php' ) ) {
	require_once( ABSPATH . 'config.php' );
} else {
    exit( "Configuration file not found." );
}

require_once( ABSPATH . 'includes/functions.php');
