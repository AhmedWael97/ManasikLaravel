@extends('Dashboard.Layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Executers Orders To Do') }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Executers Orders To Do') }}</li>
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
                    {{ translate('Total Requests') }}
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
                                {{ translate('Executer Name') }}
                            </th>
                            <th>
                                {{ translate('Service Name') }}
                            </th>
                            <th>
                                {{ translate('Actions') }}
                            </th>
                        </thead>
                        <tbody>
                            <tbody>
                                @foreach($requests as $key=>$request)
                                    <tr>
                                        <td>
                                            {{ ++$key }}
                                        </td>
                                        <td>
                                            {{ $request->executer->name_ar }}
                                        </td>
                                        <td>
                                            {{ $request->orderDetails->name_ar }}
                                        </td>
                                        <td>
                                            <a href="{{ route('RequestToDo-accept',$request->id) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="{{ route('RequestToDo-refused',$request->id) }}" class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection

