<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateMarketPackage extends Migration
{

    private $prefix = NULL;
    private $admin_prefix = NULL;

    public function __construct()
    {
        // Get the prefix
        $this->prefix = Config::get('market.prefix');
        $this->admin_prefix = Config::get('admin.prefix');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix       = $this->prefix;
        $admin_prefix = $this->admin_prefix;

        Schema::create( $prefix.'product_categories', function( Blueprint $table ) use( $prefix ) {
            // Category Info
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();
            $table->string( 'name' );
            $table->longtext( 'description' );

            // Stock Control
            $table->boolean( 'use_stock_control' )->default( false );
            $table->integer( 'max_per_order' )->unsigned()->default( 0 );
            $table->integer( 'max_per_user' )->unsigned()->default( 0 );
            $table->boolean( 'allow_back_order' )->default( false );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'products', function( Blueprint $table ) use( $prefix ) {
            // Product Info
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();
            $table->string('name');
            $table->longtext( 'description' );

            // Link To
            $table->integer( 'category_id' )->unsigned()->index();
            $table->foreign( 'category_id' )->references( 'id' )->on( $prefix.'product_categories' )->onDelete( 'cascade' );

            // Pricing
            $table->decimal( 'net_price' );
            $table->decimal( 'tax' );

            // Stock Control
            $table->boolean( 'use_stock_control' )->default( false );
            $table->integer( 'current_stock_level' )->unsigned();
            $table->integer( 'max_per_order' )->unsigned();
            $table->integer( 'max_per_user' )->unsigned();
            $table->boolean( 'allow_back_order' )->default( false );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'product_images', function( Blueprint $table ) use( $prefix ) {
            // Image Info
            $table->increments( 'id' );
            $table->string( 'caption' );
            $table->string( 'alt_text' );
            $table->integer( 'sequence' )->unsigned();

            // Link To
            $table->integer( 'product_id' )->unsigned()->index();
            $table->foreign( 'product_id' )->references( 'id' )->on( $prefix.'products' )->onDelete( 'cascade' );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'customers', function( Blueprint $table ) use( $prefix ) {
            // Customer Info
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();
            $table->string( 'name' );
            $table->string( 'email' );
            $table->string( 'password' );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'customer_addresses', function( Blueprint $table ) use( $prefix ) {
            // Address Info
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();
            $table->string( 'name' );
            $table->string( 'line_one' );
            $table->string( 'line_two' );
            $table->string( 'line_three' );
            $table->string( 'town' );
            $table->string( 'county' );
            $table->string( 'postcode' );
            $table->string( 'country' );

            // Link To
            $table->integer( 'customer_id' )->unsigned()->index();
            $table->foreign( 'customer_id' )->references( 'id' )->on( $prefix.'customers' )->onDelete( 'cascade' );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'orders', function( Blueprint $table ) use( $prefix ) {
            // Order Info
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();

            // Link To
            $table->integer( 'customer_id' )->unsigned()->index()->nullable();
            $table->foreign( 'customer_id' )->references( 'id' )->on( $prefix.'customers' );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'baskets', function( Blueprint $table ) use( $prefix ) {
            // Basket Info
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();

            // Link To
            $table->integer( 'customer_id' )->unsigned()->index()->nullable();
            $table->foreign( 'customer_id' )->references( 'id' )->on( $prefix.'customers' );
            $table->string( 'session_id' )->index()->nullable();
            $table->integer( 'order_id' )->unsigned()->index()->nullable();
            $table->foreign( 'order_id' )->references( 'id' )->on( $prefix.'orders' )->onDelete( 'cascade' );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'basket_items', function( Blueprint $table ) use( $prefix ) {
            // Item Info
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();

            // Link To
            $table->integer( 'basket_id' )->unsigned()->index();
            $table->foreign( 'basket_id' )->references( 'id' )->on( $prefix.'baskets' )->onDelete( 'cascade' );
            $table->integer( 'product_id' )->unsigned()->index()->nullable();
            $table->foreign( 'product_id' )->references( 'id' )->on( $prefix.'products' );

            // Purchase Info
            $table->integer( 'quantity' );
            $table->decimal( 'subtotal' );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'payment_providers', function( Blueprint $table ) use( $prefix ) {
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();
            $table->string( 'class' );
        } );

        Schema::create( $prefix.'payments', function( Blueprint $table ) use( $prefix ) {
            // Payment Info
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();

            // Link To
            $table->integer( 'order_id' )->unsigned()->index();
            $table->foreign( 'order_id' )->references( 'id' )->on( $prefix.'orders' )->onDelete( 'cascade' );

            // Provider Info
            $table->integer( 'provider_id' )->unsigned()->index()->nullable();
            $table->foreign( 'provider_id' )->references( 'id' )->on( $prefix.'payment_providers' );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'payment_log', function( Blueprint $table ) use( $prefix ) {
            // Log Info
            $table->increments( 'id' );
            $table->integer( 'old_status' )->unsigned();
            $table->integer( 'new_status' )->unsigned();

            // Link To
            $table->integer( 'payment_id' )->unsigned()->index();
            $table->foreign( 'payment_id' )->references( 'id' )->on( $prefix.'payments' )->onDelete( 'cascade' );

            // Data
            $table->longtext( 'request_data' )->nullable();
            $table->longtext( 'response_data' )->nullable();
            $table->longtext( 'comment' )->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( $prefix.'customer_cards', function( Blueprint $table ) use( $prefix ) {
            // Card Info
            $table->increments( 'id' );
            $table->integer( 'status' )->unsigned();
            $table->string( 'name' );
            $table->string( 'last4' );

            // Link To
            $table->integer( 'customer_id' )->unsigned()->index();
            $table->foreign( 'customer_id' )->references( 'id' )->on( $prefix.'customers' )->onDelete( 'cascade' );
            $table->integer( 'payment_provider_id' )->unsigned()->index();
            $table->foreign( 'payment_provider_id' )->references( 'id' )->on( $prefix.'payment_providers' )->onDelete( 'cascade' );
            $table->string( 'payment_provider_reference' );

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = $this->prefix;

        Schema::drop( $prefix.'products' );
        Schema::drop( $prefix.'product_images' );
        Schema::drop( $prefix.'product_categories' );
        Schema::drop( $prefix.'baskets' );
        Schema::drop( $prefix.'basket_items' );
        Schema::drop( $prefix.'orders' );
        Schema::drop( $prefix.'payment_providers' );
        Schema::drop( $prefix.'payments' );
        Schema::drop( $prefix.'payment_log' );
        Schema::drop( $prefix.'customers' );
        Schema::drop( $prefix.'customer_addresses' );
        Schema::drop( $prefix.'customer_cards' );
    }
}
