<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{ $shop->logo_path }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ $shop->name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header">@lang('app.transaction.name')</li>
          <li class="nav-item">
            <a href="/cashier" class="nav-link {{ Request::is('cashier') ? 'active' : '' }}">
              <i class="nav-icon fa fa-calculator"></i>
              <p>
                @lang('app.transaction.cashier')
              </p>
            </a>
          </li>
          @if (auth()->user()->level == 1)
          <li class="nav-item">
            <a href="/purchase" class="nav-link {{ Request::is('purchase') ? 'active' : '' }}">
              <i class="nav-icon fa fa-download"></i>
              <p>
                @lang('app.transaction.purchase')
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/sale" class="nav-link">
              <i class="nav-icon fa fa-upload"></i>
              <p>
                @lang('app.transaction.sales')
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/expense" class="nav-link {{ Request::is('expense') ? 'active' : '' }}">
              <i class="nav-icon fa fa-money-bill-wave"></i>
              <p>
                @lang('app.transaction.expense')
              </p>
            </a>
          </li>
          <li class="nav-header">DATA MASTER</li>
          <li class="nav-item {{ Request::is('category') ||  Request::is('product') || Request::is('stock') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('category') ||  Request::is('product') || Request::is('stock') ? 'active' : ''}}">
              <i class="nav-icon fa fa-cube"></i>
              <p>
                @lang('app.product.product')
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/category" class="nav-link {{ Request::is('category') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>@lang('app.product.category')</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/product" class="nav-link {{ Request::is('product') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>@lang('app.product.product')</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/stock" class="nav-link {{ Request::is('stock') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>@lang('app.product.stock')</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="/supplier" class="nav-link {{ Request::is('supplier') ? 'active' : '' }}">
              <i class="nav-icon fa fa-truck"></i>
              <p>
                Supplier
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/users" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>@lang('app.user.userdata')</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/member" class="nav-link {{ Request::is('member') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Data Member</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/shop" class="nav-link {{ Request::is('shop') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>@lang('app.data.shop')</p>
            </a>
          </li>
          @endif

          <li class="nav-header">@lang('app.setting.name')</li>
          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="nav-icon fas fa-store-alt"></i>
              <p>@lang('app.setting.shop')</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="iframe.html" class="nav-link">
              <i class="nav-icon fas fa-ellipsis-h"></i>
              <p>@lang('app.setting.display')</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>