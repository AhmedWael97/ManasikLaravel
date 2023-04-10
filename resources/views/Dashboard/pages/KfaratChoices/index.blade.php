@extends('Dashboard.Layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Kfarat Choices') }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Kfarat Choices') }}</li>
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
                    <a href="{{ route('KfaratChoice-Create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        {{ translate('Add New Kfarat Choice') }}
                    </a>
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
                                {{ translate('English Name') }}
                            </th>
                            <th>
                                {{ translate('Arabic Name') }}
                            </th>
                            <th>
                                {{ translate('Image') }}
                            </th>
                            <th>
                                {{ translate('Menu Image') }}
                            </th>
                            <th>
                                {{ translate('Actions') }}
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($Choices as $key=>$choice)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $choice->name_en }}
                                    </td>
                                    <td>
                                        {{ $choice->name_ar }}
                                    </td>
                                    <td>
                                        <img src="{{ url('/images/kfarat_choices') }}/{{ $choice->image }}" style="width:auto; height:50px" />
                                    </td>
                                    <td>
                                        <img src="{{ url('/images/kfarat_choices') }}/{{ $choice->menu_image_path }}" style="width:auto; height:50px" />
                                    </td>

                                    <td>
                                        <a href="{{ route('KfaratChoice-Edit',['id' => $choice->id]) }}" class="btn btn-default btn-sm mr-1 ml-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('KfaratChoice-Delete',$choice->id) }}" class="btn btn-danger btn-sm mr-1 ml-1">
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

