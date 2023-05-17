@extends('Dashboard.Layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Currencies') }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Currency') }}</li>
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
                    <a href="{{ route('currency-create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        {{ translate('Add New Currency') }}
                    </a>
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-striped dataTable" id="filtersIns">
                        <thead>
                            <th>
                                #
                            </th>
                            <th>
                                {{ translate('Added By') }}
                            </th>
                            <th>
                                {{ translate('Arabic Name') }}
                            </th>
                            <th>
                                {{ translate('English Name') }}
                            </th>
                            <th>
                                {{ translate('Convert Value') }}
                            </th>
                            <th>
                                {{ translate('Symbol') }}
                            </th>
                            <td>
                                {{ translate('Actions') }}
                            </td>
                        </thead>
                        <tbody>
                            @foreach ($currencies as $key=>$currency)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $currency->user->name }}
                                    </td>
                                    <td>
                                        {{ $currency->name_ar }}
                                    </td>
                                    <td>
                                        {{ $currency->name_en }}
                                    </td>
                                    <td>
                                        {{ $currency->convert_value }}
                                    </td>
                                    <td>
                                        {{ $currency->symbol }}
                                    </td>

                                    <td>
                                        <a href="{{ route('currency-edit',$currency->id) }}" class="btn btn-default btn-sm mr-1 ml-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('currency-delete',$currency->id) }}" class="btn btn-danger btn-sm mr-1 ml-1">
                                            <i class="fas fa-trash"></i>
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

