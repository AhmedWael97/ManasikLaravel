@extends('Dashboard.Layout.app')
@section('css')
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Edit') }} {{ $nationality->name_en }} {{translate('Informations')}}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('nationality-index') }}">{{ translate('Nationality') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('Edit Nationality') }}</li>
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
                Edit Nationality
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form">
                    <form method="post" action="{{ route('nationality-update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $nationality->id }}" />

                        <div class="row p-0 m-0">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Nationality Arabic Name') }}
                                    </label>
                                    <input type="text" value="{{ $nationality->name_ar }}" required name="name_ar" class="form-control" />
                                </div>
                            </div>

                             <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Nationality English Name') }}
                                    </label>
                                    <input type="text" value="{{ $nationality->name_en }}" required name="name_en" class="form-control" />
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
