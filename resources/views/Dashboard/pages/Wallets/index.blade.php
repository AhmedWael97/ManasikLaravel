@extends('Dashboard.Layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Wallets') }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Wallets') }}</li>
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
                    {{ translate('Make Transactions And See Credits') }}
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
                                {{ translate('User') }}
                            </th>
                            <th>
                                {{ translate('Amount') }}
                            </th>
                            <th>
                                {{ translate('Currency') }}
                            </th>
                            <th>
                                {{ translate('Actions') }}
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($Wallets as $key=>$wallet)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $wallet->user->name }} | {{ $wallet->user->name_ar }}
                                    </td>
                                    <td>
                                        {{ $wallet->amount }}
                                    </td>
                                    <td>
                                        {{ $wallet->currency->symbol }}
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm mr-2 mt-2">
                                            <i class="fas fa-plus-circle"></i> {{ translate('Make Transaction') }}
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm mr-2 mt-2">
                                            <i class="fas fa-minus-circle"></i> {{ translate('Remove Transaction') }}
                                        </a>
                                        <a href="#" class="btn btn-default btn-sm mr-2 mt-2">
                                            <i class="fas fa-eye"></i> {{ translate('See Transactions') }}
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

