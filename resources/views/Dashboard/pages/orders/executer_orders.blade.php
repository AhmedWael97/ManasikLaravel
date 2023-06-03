@extends('Dashboard.Layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Orders') }} ( {{ $executer->name }} | {{ $status }})</h1>
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
                    <table class="table table-striped dataTable" id="filtersIns">
                        <thead>
                            <td>
                                #
                            </td>
                            <th>
                                {{ translate('Order No') }}
                            </th>
                            <th>
                                {{ translate('Service Name') }}
                            </th>
                            <th>
                                {{ translate('Current Step') }}
                            </th>
                            <td>
                                {{ translate('Order Price') }}
                            </td>
                            <td>
                                {{ translate('Executer Earnings') }}
                            </td>
                            <td>
                                {{ translate('Action') }}
                            </td>
                        </thead>
                        <tbody>
                            @foreach($orders as $key=>$order)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $order->order_code }}
                                    </td>
                                    <td>
                                        {{ $order->service->name_en }}
                                    </td>
                                    <td>
                                        {{ $order->steps[0]->step->name_en }}
                                    </td>
                                    <td>
                                        {{ $order->price }} {{ $order->currency->symbol }}
                                    </td>
                                    <td>
                                        {{ $order->executer_price }} {{ $order->currency->symbol }}
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-default btn-sm">
                                            {{ translate('View Steps') }}
                                        </a>
                                    </td>
                                </tr>

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

