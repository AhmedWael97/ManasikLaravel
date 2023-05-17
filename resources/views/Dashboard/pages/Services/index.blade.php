@extends('Dashboard.Layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Services') }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Services') }}</li>
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
                    <a href="{{ route('Services-Create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        {{ translate('Add New Service') }}
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
                                {{ translate('Name') }}
                            </th>
                            <th>
                                {{ translate('Max Limit') }}
                            </th>
                            <th>
                                {{ translate('Price') }}
                            </th>
                            <th>
                                {{ translate('Executer Price') }}
                            </th>
                            <th>
                                {{ translate('Serivce Parent') }}
                            </th>
                            <td>
                                {{ translate('Actions') }}
                            </td>
                        </thead>
                        <tbody>
                            @foreach ($Services as $key=>$service)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $service->name_en }} | {{ $service->name_ar }}
                                    </td>
                                    <td>
                                        {{ $service->max_limit }}
                                    </td>
                                    <td>
                                        {{ $service->price }}
                                    </td>
                                    <td>
                                        {{ $service->executer_price }}
                                    </td>
                                    <td>
                                       @if($service->parent)
                                        {{ $service->parent->name_en   }} || {{ $service->parent->name_ar  }}
                                       @else
                                       {{ translate('Parent Service') }}
                                       @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('Services-Edit',$service->id) }}" class="btn btn-warning btn-sm mr-1 ml-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('Services-Edit',$service->id) }}" class="btn btn-default btn-sm mr-1 ml-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('Services-Delete',$service->id) }}" class="btn btn-danger btn-sm mr-1 ml-1">
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

