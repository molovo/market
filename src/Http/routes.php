<?php

Route::group( [ 'prefix' => '_market' ], function() {
  Route::get( '/', function() {
    return view( 'market::layouts.dashboard' );
  } );

  Route::resource( 'products', 'ProductsController' );
} );