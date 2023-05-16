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
                <div class="card-header">
                  <h3 class="card-title">
                    <a href="{{ route('Users-Create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        {{ translate('Add New User') }}
                    </a>
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="display table table-striped  " id="example">
                        <thead>
                        <tr>
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
                                {{ translate('Email') }}
                            </th>
                            <th>
                                {{ translate('Phone') }}
                            </th>
                            <th>
                                {{ translate('Is Active') }}
                            </th>
                            <th>
                                {{ translate('Actions') }}
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Users as $key=>$user)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $user->name }} | {{ $user->name_ar }}
                                    </td>
                                    <td>
                                        @if(count($user->roles) >= 1)
                                            {{ $user->roles[0]->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->email }}
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
                                     <a href="{{ route('Users-auto',$user->id) }}" class="btn btn-warning btn-sm mr-1 ml-1 text-white">
                                             {{ translate('Automate Assigning') }}
                                        </a>

                                        <a href="{{ route('Users-Edit',$user->id) }}" class="btn btn-default btn-sm mr-1 ml-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('Users-Delete',$user->id) }}" class="btn btn-danger btn-sm mr-1 ml-1">
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

