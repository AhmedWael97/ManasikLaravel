@extends('Dashboard.Layout.app')
@section('css')
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Automate Assigning Orders To') }} : {{ $user->name }}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('Users') }}">{{ translate('Users') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('Automate Assign') }}</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <form method="POST" action="{{ route('Users-Store-Auto') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}" />
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                   {{ translate('Basic Information') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>{{ translate('Service Name') }}</th>
                            <th>{{ translate('Number of Services') }}</th>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>
                                    <select class="form-control" name="services[]">

                                            <option value="{{ $service->id }}"> {{ $service->name_ar . ' || ' . $service->name_en }} </option>

                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="maxCount[]" value="{{ $user->autoAssign == null ||  count($user->autoAssign) == 0 ||  $user->autoAssign->where('service_id',$service->id)->first() == null ? '0' : $user->autoAssign->where('service_id',$service->id)->first()->maxCount }}" required class="form-control" />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center mt-4">
                        <button type="submit" name="submit" value="1" style="width: 150px;" class="btn btn-primary">
                            {{ translate('save') }}
                        </button>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</section>

@endsection

@section('js')
@endsection
