@extends('Dashboard.Layout.app')
@section('css')
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Create New Role') }}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('Roles') }}">{{ translate('Roles') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('New Role') }}</li>
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
                Add New Role
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form">
                    <form method="post" action="{{ route('Roles-Store') }}">
                        @csrf

                        <div class="row p-0 m-0">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Role Name') }}
                                    </label>
                                    <input type="text" required name="name" class="form-control" />
                                    <input type="submit" value="{{ translate('Save') }}" class="btn btn-success mt-2" />
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-7">
                                <label>
                                    {{ translate('Permissions') }}
                                </label>
                                <br>
                                @foreach ($Permissions as $permission)
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-inline" /> {{ $permission->name }}
                                    <br />
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

@endsection

@section('js')
@endsection
