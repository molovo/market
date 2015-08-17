@extends( 'market::layouts.dashboard' )

@section( 'title', 'Create Product' )

@section( 'page' )
  <?php
    $formOptions = [
      'action' => '\Molovo\Market\Http\Controllers\ProductsController@store',
      'class' => 'admin-form'
    ];
  ?>

  {!! Form::model( new \Molovo\Market\Models\Product, $formOptions ) !!}

    <fieldset class="admin-form--title">
      {!! Form::label( 'name', 'Product Name' ) !!}
      {!! Form::text( 'name' ) !!}
    </fieldset>

    <fieldset class="admin-form--product-price">
      <div class="admin-form--field-third">
        {!! Form::label( 'net_price', 'Net Price' ) !!}
        {!! Form::number( 'net_price', null, [ 'step' => 0.01, 'class' => 'currency' ] ) !!}
      </div>

      <div class="admin-form--field-third">
        {!! Form::label( 'tax', 'Tax' ) !!}
        {!! Form::number( 'tax', null, [ 'step' => 0.01, 'class' => 'percentage' ] ) !!}
      </div>

      <div class="admin-form--field-third">
        {!! Form::label( 'gross_price', 'Gross Price' ) !!}
        {!! Form::number( 'gross_price', null, [ 'step' => 0.01, 'class' => 'currency' ] ) !!}
      </div>
    </fieldset>
  {!! Form::close() !!}
@stop