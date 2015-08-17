@extends( 'admin::layouts.dashboard' )

@section( 'sidebar' )
  <aside class="admin--sidebar market--sidebar">
    <a href="/" class="admin--sidebar-logo">Market</a>

    <nav class="admin--sidebar-menu">
      <ul>
        <li>
          <h6>Products</h6>

          <ul class="admin--sidebar-menu-sub">
            <li>
              <a href="/products">Products</a>
            </li>
            <li>
              <a href="/product-categories">Categories</a>
            </li>
          </ul>
        </li>

        <li>
          <h6>Customers</h6>

          <ul class="admin--sidebar-menu-sub">
            <li>
              <a href="/customers">Customers</a>
            </li>
            <li>
              <a href="/orders">Orders</a>
            </li>
            <li>
              <a href="/baskets">Baskets</a>
            </li>
          </ul>
        </li>

        <li>
          <h6>Settings</h6>

          <ul class="admin--sidebar-menu-sub">
            <li>
              <a href="/settings/payment-methods">Payment Methods</a>
            </li>
            <li>
              <a href="/settings/delivery-methods">Delivery Methods</a>
            </li>
            <li>
              <a href="/settings/emails">Emails</a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </aside>
@endsection

@section( 'css' )
  <link rel="stylesheet" type="text/css" href="/vendor/molovo/market/css/main.min.css">
@endsection