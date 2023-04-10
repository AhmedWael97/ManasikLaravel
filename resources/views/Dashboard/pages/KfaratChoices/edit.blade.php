@extends('Dashboard.Layout.app')
@section('css')
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Create New Kfara Choice') }}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('KfaratChoice') }}">{{ translate('Kfarat Choices') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('New Kfara Choice') }}</li>
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
                {{ translate('Basic Information') }}
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form">
                    <form method="post" action="{{ route('KfaratChoice-Update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="choice_id" value="{{ $Choice->id }}" />
                        <div class="row p-0 m-0">
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('English Name') }}
                                    </label>
                                    <input type="text" value="{{ $Choice->name_en }}" required name="name_en" class="form-control" />

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Arabic Name') }}
                                    </label>
                                    <input type="text" value="{{ $Choice->name_ar }}" required name="name_ar" class="form-control" />

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Image') }}
                                    </label>
                                    <input type="file" name="image" class="form-control-file" />
                                    <img src="{{ url('/images/kfarat_choices') }}/{{ $Choice->image }}" style="width:auto; height:50px" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label>
                                        {{ translate('Menu Image') }}
                                    </label>
                                    <input type="file" name="menu_image_path" class="form-control-file mb-2" />
                                    <img src="{{ url('/images/kfarat_choices') }}/{{ $Choice->menu_image_path }}" style="width:auto; height:50px" />

                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input type="submit" value="{{ translate('Save') }}" class="btn btn-success mt-2 w-100" />
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
