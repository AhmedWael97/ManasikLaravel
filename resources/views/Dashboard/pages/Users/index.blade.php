@extends('Dashboard.Layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Users') }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Users') }}</li>
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
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="display table table-striped" id="filtersIns">
                        <thead>

                            <th>
                                #
                            </th>
                            <th>
                                {{ translate('Name') }}
                            </th>
                            <th>
                                {{ translate('Role') }}
                            </th>
                            <th>
                                {{ translate('Phone') }}
                            </th>
                            <th>
                                {{ translate('Is Active') }}
                            </th>
                            <td>
                                {{ translate('Actions') }}
                            </td>

                        </thead>
                        <tbody>
                            @foreach ($Users as $key=>$user)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        @if(count($user->roles) >= 1)
                                            {{ $user->roles[0]->name }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        {{ $user->phone }}
                                    </td>
                                    <td>
                                        @if($user->is_active )
                                            <span class="badge badge-success">
                                                {{ translate('Active') }}
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                {{ translate('Not Active') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>

                                        <a href="{{ route('Users-View',$user->id) }}" class="btn btn-warning btn-sm mr-1 ml-1">
                                            <i class="fas fa-eye"></i>
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

