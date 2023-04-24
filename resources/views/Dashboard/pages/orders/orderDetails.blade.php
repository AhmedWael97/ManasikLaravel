@extends('Dashboard.Layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Order Detail') }}, #{{ $order->id }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('Orders') }}">{{ translate('Orders') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Order Detail') }}</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ translate('Order Details') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="mainInfo">

                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection

