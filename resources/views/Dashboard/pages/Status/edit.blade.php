@extends('Dashboard.Layout.app')
@section('css')
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Edit') }} {{ $type->name_en }} {{translate('Informations')}}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('Status') }}">{{ translate('Status') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('Edit Status') }}</li>
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
                {{ translate('Edit Status') }}
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form">
                    <form method="post" action="{{ route('Status-Update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $type->id }}" />

                        <div class="row p-0 m-0">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Status Arabic Name') }}
                                    </label>
                                    <input type="text" value="{{ $type->name_ar }}" required name="name_ar" class="form-control" />
                                </div>
                            </div>

                             <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Status English Name') }}
                                    </label>
                                    <input type="text" value="{{ $type->name_en }}" required name="name_en" class="form-control" />
                                </div>
                            </div>

                            <input type="submit" value="{{ translate('Save') }}" class="btn btn-success mt-2" />


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
