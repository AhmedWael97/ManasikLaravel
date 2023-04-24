@extends('Dashboard.Layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Orders') }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Orders') }}</li>
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
                    {{ translate('Total Order Details') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-striped dataTable">
                        <thead>
                            <th>
                                #
                            </th>
                            <th>
                                {{ translate('Added By') }}
                            </th>
                            <th>
                                {{ translate('Main Service') }}
                            </th>
                            <th>
                                {{ translate('Payment Type') }}
                            </th>

                            <th>
                                {{ translate('Payment Type Status') }}
                            </th>
                            <th>
                                {{ translate('Order Status') }}
                            </th>
                            <th>
                                {{ translate('Price') }}
                            </th>
                            <th>
                                {{ translate('Actions') }}
                            </th>
                        </thead>
                        <tbody>
                            @foreach($orders as $key => $order)
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    {{ $order->user->name . ' || ' . $order->user->name_ar }}
                                </td>
                                <td>
                                    {{ $order->mainService->name_en }} || {{ $order->mainService->name_ar }}
                                </td>
                                <td>
                                    {{ $order->paymentType->name_en }} || {{ $order->paymentType->name_ar }}
                                </td>

                                <td>
                                    {{ $order->paymentTypeStatus->name_en }} || {{ $order->paymentTypeStatus->name_ar }}
                                </td>
                                <td>
                                    {{ $order->status->name_en }} || {{ $order->status->name_ar }}
                                </td>
                                <td>
                                    {{ $order->price }} ({{ $order->user->wallet->currency->symbol }})
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('Orders-Show', $order->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection

