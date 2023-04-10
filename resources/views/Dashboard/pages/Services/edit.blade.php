@extends('Dashboard.Layout.app')
@section('css')
<!-- Select2 -->
  <link rel="stylesheet" href="{{ url('/') }}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{ url('/') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Update Service') }}, {{ $service->name_en }} | {{ $service->name_ar }}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('Services') }}">{{ translate('Services') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('Update Service') }}</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <form method="Post" action="{{ route('Services-Update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}" />
            <div class="row">
                <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          {{ translate('Basic Service Information') }}
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                            <div class="row p-0 m-0">
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('English Name') }}
                                    </label>
                                    <input type="text" value="{{ $service->name_en }}" required name="name_en" class="form-control" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('Arabic Name') }}
                                    </label>
                                    <input type="text" value="{{ $service->name_ar }}" required name="name_ar" class="form-control" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('Photo') }}
                                    </label>
                                    <input type="file"  name="photo" class="form-control-file" />
                                    @if($service->photo)
                                        <img src="{{ url('/images/services') }}/{{ $service->photo }}" class="mt-2" style="width:auto;height:50px;"/>
                                    @endif
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('Max Limit') }}
                                    </label>
                                    <input type="number" value="{{ $service->max_limit }}"  name="max_limit" class="form-control" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('Price') }}
                                    </label>
                                    <input type="number" step="0.001" value="{{ $service->price }}"  name="price" class="form-control" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('Executer Price') }}
                                    </label>
                                    <input type="number" step="0.001" value="{{ $service->executer_price }}"  name="executer_price" class="form-control" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('Earning Points') }}
                                    </label>
                                    <input type="number" value="{{ $service->earning_points }}" name="earning_points" class="form-control" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('Max Limit By Order') }}
                                    </label>
                                    <input type="number" value="{{ $service->max_limit_by_order }}" name="max_limit_by_order" class="form-control" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('Actual Date') }}
                                    </label>
                                    <input type="date" value="{{ $service->actual_date }}"  name="actual_date" class="form-control" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>
                                        {{ translate('Parent Service') }}
                                    </label>
                                    <select class="form-control" name="parent_id" >
                                        <option value="0" >
                                            {{ translate('No Parent') }}
                                        </option>
                                        @foreach($parents as $term)
                                            <option {{ $service->parent_id == $term->id ? 'selected' : '' }} value="{{ $term->id }}">
                                                {{ $term->name_en }} | {{ $term->name_ar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                      </div>
                    </div>
                </div>

                @if(count($service->steps) >= 1)
                <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          {{ translate('Old Service Steps') }}
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">

                            <table class="table table-bordered">
                                <thead>
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
                                        {{ translate('Max Time In Minutes') }}
                                    </th>
                                    <th>
                                        {{ translate('Min Time In Minutes') }}
                                    </th>
                                    <th>
                                        {{ translate('Delete') }}
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($service->steps as $step)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="old_step_id[]"  value="{{ $step->id }}"/>
                                            <input type="text" value="{{ $step->name_en }}" name="old_step_name_en[]" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="text" name="old_step_name_ar[]" value="{{ $step->name_ar }}" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="file" name="old_step_photo[]" class="form-control-file" />
                                            @if($step->photo)
                                            <img src="{{ url('/images/services') }}/{{ $step->photo }}" class="mt-2" style="width:auto; height:50px">
                                            @endif
                                        </td>
                                        <td>
                                            <input type="number" name="old_max_time_in_minute[]" value="{{ $step->max_time_in_minute }}" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="number" name="old_min_time_in_minute[]" value="{{ $step->min_time_in_minute }}" class="form-control" />
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('Services-Delete-step', $step->id) }}" class="btn btn-danger btn-sm">
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
                @endif

                <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          {{ translate('Service Steps') }}
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <button type="button" class="btn btn-primary addStep  mb-2 float-right">
                            <i class="fas fa-plus-circle"></i>  {{ translate('Add Step') }}
                          </button>
                            <table class="table table-bordered steps">
                                <thead>
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
                                        {{ translate('Max Time In Minutes') }}
                                    </th>
                                    <th>
                                        {{ translate('Min Time In Minutes') }}
                                    </th>
                                    <th>
                                        {{ translate('Delete') }}
                                    </th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                      </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                            {{ translate('Service Kfarat Choices') }}
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <div class="form-group">
                            <label> {{ translate('Kfarat Choices') }} </label>

                            <select class="form-control select2" name="choices[]" multiple style="width: 50%;">

                                @foreach ( $kfaratChoices as $choice)
                                    <option value="{{ $choice->id }}" {{ in_array($choice->id, $choosenKfarat) ? 'selected' : '' }}>
                                        {{ $choice->name_en }} | {{ $choice->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-12 text-center mb-2">
                    <input type="submit" class="btn btn-success" value="{{ translate('Save') }}" />
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('js')
<!-- Select2 -->
<script src="{{url('/')}}/plugins/select2/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.addStep').click(function() {
                var row = '<tr>'+
                                        '<td>'+
                                            '<input type="text" name="step_name_en[]" class="form-control" />'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" name="step_name_ar[]" class="form-control" />'+
                                                '</td>'+
                                                '<td>'+
                                                    '<input type="file" name="step_photo[]" class="form-control-file" />'+
                                                    '</td>'+
                                                    '<td>'+
                                                        '<input type="number" name="max_time_in_minute[]" class="form-control" />'+
                                                        '</td>'+
                                                        '<td>'+
                                                            '<input type="number" name="min_time_in_minute[]" class="form-control" />'+
                                                            '</td>'+
                                                            '<td class="text-center">'+
                                                                '<button type="button" class="btn btn-danger btn-sm delStep"><i class="fas fa-trash"></i></button>'+
                                                                '</td>'+
                                                                '</tr>';
                $('.steps>tbody').append(row);
            });
            $('.steps').on('click','.delStep',function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
