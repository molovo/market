<?php

Route::group( [ 'prefix' => 'market' ], function() {
  Route::get( '/', function() {
    return view( 'market::layouts.dashboard' );
  } );

  Route::resource( 'products', 'ProductsController' );
} );