@extends('Dashboard.Layout.app')
@section('css')
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Edit') }} {{ $currency->name_en }} {{translate('Informations')}}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('currency-index') }}">{{ translate('Currencies') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('Edit Currency') }}</li>
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
              Edit Currency
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form">
                    <form method="post" action="{{ route('currency-update') }}">
                        @csrf
                      <input type="hidden" name="id" value="{{$currency->id}}">
                        <div class="row p-0 m-0">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Currency Arabic Name') }}
                                    </label>
                                    <input type="text" required value="{{$currency->name_ar}}" name="name_ar" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Currency English Name') }}
                                    </label>
                                    <input type="text" required value="{{$currency->name_en}}" name="name_en" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Currency Convert Value') }}
                                    </label>
                                    <input type="text" required value="{{$currency->convert_value}}" name="convert_value" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Currency Symbol') }}
                                    </label>
                                    <input type="text" required value="{{$currency->symbol}}" name="symbol" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-8"></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input type="submit" value="{{ translate('Save') }}" class="btn btn-success w-100" />

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
