<?php

/**
 * Plugin Name: Test Fuse
 * Description: Create a Test Fuse
 * Author:      Sunil Jaiswal
 */

use FusePlugin\Apps\WordPress\Actions\Email;
use FusePlugin\Apps\WordPress\Triggers\AdminMenu;
use FusePlugin\Refer;
use FusePlugin\Fuse;
use FusePlugin\Node;


add_action( 'fuse_plugin_register_fuses', function () {

	Fuse::create( 'Test Fuse' )
		->key( 'fuse-test-fuse' )
		->runInBackground( true )
		->nodes( [
			Node::create( 0 )
				->process( AdminMenu::class )
				->priority( 10 )
				->connect( AdminMenu::outputSuccess, 1, [
					'to'      => [ Refer::to( 'first_name' ), ' ', Refer::to( 'last_name' ) ],
					'email'   => Refer::to( 'email' ),
					'subject' => 'This is a subject',
					'body'    => [ 'Hi ', Refer::to( 'first_name' ), '\n\nThis is a body' ],
					'html'    => true,
				] ),
			Node::create( 1 )
				->process( Email::class ),
		] )
		->register();
} );