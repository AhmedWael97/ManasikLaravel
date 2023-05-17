@extends('Dashboard.Layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Countries') }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Countries') }}</li>
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
                    <a href="{{ route('country-create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        {{ translate('Add New Country') }}
                    </a>
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-striped " id="filtersIns">
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
                                {{ translate('Code') }}
                            </th>
                            <td>
                                {{ translate('Actions') }}
                            </td>
                        </thead>
                        <tbody>
                            @foreach ($countries as $key=>$country)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $country->user->name }}
                                    </td>
                                    <td>
                                        {{ $country->name_ar }}
                                    </td>
                                    <td>
                                        {{ $country->name_en }}
                                    </td>
                                    <td>
                                        {{ $country->code }}
                                    </td>

                                    <td>
                                        <a href="{{ route('country-edit',$country->id) }}" class="btn btn-default btn-sm mr-1 ml-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('country-delete',$country->id) }}" class="btn btn-danger btn-sm mr-1 ml-1">
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

