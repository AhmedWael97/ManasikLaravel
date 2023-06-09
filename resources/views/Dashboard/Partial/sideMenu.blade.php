<!-- Main Sidebar Container -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('Home') }}" class="brand-link">
      <span class="brand-text font-weight-light">Manasik Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
         <i class="fas fa-user" style="font-size: 50px"></i>
        </div>
        <div class="info">
          <a href="#" class="d-block">
            {{ Auth::user()->name }}
            @if(Auth::user()->wallet != null)
             -  {{ Auth::user()->wallet->amount  }} ({{ Auth::user()->wallet->currency->symbol }})
            @endif
            <br>
            <small class="text-danger">({{ auth()->user()->roles[0]->name }})</small>
          </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tables
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/tables/simple.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Simple Tables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/data.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DataTables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/jsgrid.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>jsGrid</p>
                </a>
              </li>
            </ul>
          </li> --}}

          <li class="nav-item">
            <a href="{{ route('Home') }}" class="nav-link {{ is_active('Home')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>

          @can('Roles')
          <li class="nav-item">
            <a href="{{ route('Roles') }}" class="nav-link {{ is_active('Roles')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                {{ translate('Roles') }}

              </p>
            </a>
          </li>
          @endcan

          @can('Users')
          <li class="nav-item">
            <a href="{{ route('Users') }}" class="nav-link {{ is_active('Users')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                {{ translate('Users') }}
              </p>
            </a>
          </li>
          @endcan


          @can('Wallet')
          <li class="nav-item">
            <a href="{{ route('Wallet') }}" class="nav-link {{ is_active('Wallet')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                {{ translate('Wallet') }}
              </p>
            </a>
          </li>
          @endcan

          @can('Country_View')
          <li class="nav-item">
            <a href="{{ route('country-index') }}" class="nav-link {{ is_active('country')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-globe-europe"></i>

              <p>
                {{ translate('Countries') }}

              </p>
            </a>
          </li>
          @endcan
          @can('Currency_View')
          <li class="nav-item">
            <a href="{{ route('currency-index') }}" class="nav-link {{ is_active('currency')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-coins"></i>
              <p>
                {{ translate('Currencies') }}

              </p>
            </a>
          </li>
          @endcan

          @can('Gender_View')
          <li class="nav-item">
            <a href="{{ route('gender-index') }}" class="nav-link {{ is_active('gender')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-venus-mars"></i>
              <p>
                {{ translate('Genders') }}

              </p>
            </a>
          </li>
          @endcan
          @can('Job_View')
          <li class="nav-item">
            <a href="{{ route('job-index') }}" class="nav-link {{ is_active('job')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-align-justify"></i>
              <p>
                {{ translate('Jobs') }}

              </p>
            </a>
          </li>
          @endcan

           @can('Language_View')
          <li class="nav-item">
            <a href="{{ route('language-index') }}" class="nav-link {{ is_active('language')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-language"></i>
              <p>
                {{ translate('Languages') }}

              </p>
            </a>
          </li>
          @endcan

           @can('Nationality_View')
          <li class="nav-item">
            <a href="{{ route('nationality-index') }}" class="nav-link {{ is_active('nationality')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-globe"></i>
              <p>
                {{ translate('Nationalities') }}

              </p>
            </a>
          </li>
          @endcan


          @can('KfaratChoice')
          <li class="nav-item">
            <a href="{{ route('KfaratChoice') }}" class="nav-link {{ is_active('KfaratChoice')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-check-square"></i>
              <p>
                {{ translate('Kfarat Choices') }}
              </p>
            </a>
          </li>
          @endcan

          @can('Services')
          <li class="nav-item">
            <a href="{{ route('Services') }}" class="nav-link {{ is_active('Services')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                {{ translate('Services') }}
              </p>
            </a>
          </li>
          @endcan

          @can('PaymentTypes')
          <li class="nav-item">
            <a href="{{ route('PaymentTypes') }}" class="nav-link {{ is_active('PaymentTypes')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-circle"></i>
              <p>
                {{ translate('Payment Types') }}

              </p>
            </a>
          </li>
          @endcan

          @can('HajPurpose')
          <li class="nav-item">
            <a href="{{ route('HajPurpose') }}" class="nav-link {{ is_active('HajPurpose')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-circle"></i>
              <p>
                {{ translate('Haj Purpose') }}

              </p>
            </a>
          </li>
          @endcan

          @can('Status')
          <li class="nav-item">
            <a href="{{ route('Status') }}" class="nav-link {{ is_active('Status')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-circle"></i>
              <p>
                {{ translate('Statuses') }}

              </p>
            </a>
          </li>
          @endcan

          @can('Orders')
          <li class="nav-item">
            <a href="{{ route('Orders') }}" class="nav-link {{ is_active('Orders')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-list"></i>
              <p>
                {{ translate('Orders') }}

              </p>
            </a>
          </li>
          @endcan

          @can('OrdersToDo')
          <li class="nav-item">
            <a href="{{ route('RequestToDo') }}" class="nav-link {{ is_active('RequestToDo')  ? 'active' : '' }}">

              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                {{ translate('Request To Do') }}

              </p>
            </a>
          </li>
          @endcan

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
