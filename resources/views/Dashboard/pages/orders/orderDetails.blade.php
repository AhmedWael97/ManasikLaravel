@extends('Dashboard.Layout.app')
@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ url('/') }}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ url('/') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{ translate('Order Detail') }}, #{{ $order->id }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('Orders') }}">{{ translate('Orders') }}</a></li>
                <li class="breadcrumb-item active"> {{ translate('Order Detail') }}</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ translate('User Information') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="mainInfo">
                        <p> Name : <b>{{ $order->user->name }}</b> </p>
                        <p> Phone : <b>{{ $order->user->phone }}</b> </p>
                        <p> Email : <b>{{ $order->user->email }}</b> </p>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">
                      {{ translate('Order and Payment Information') }}
                    </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6">
                            <p> {{ translate('Order Status') }} : <b>{{ $order->status->name_ar }}</b> </p>
                            <p> {{ translate('Total Order') }} : <b>{{ $order->price }} ({{ $order->user->wallet->currency->symbol}})</b> </p>
                        </div>
                        <div class="col-md-6">
                            <div class="mainInfo">
                                <p> {{ translate('Payment Status') }} : <b>{{ $order->paymentTypeStatus->name_ar }}</b> </p>
                                <p> {{ translate('Payment Type') }} : <b>{{ $order->paymentType->name_ar }}</b> </p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <button class="btn btn-primary  btn-sm" data-toggle="modal" data-target="#changePaymentStatus">
                                {{ translate('Change Payment Status') }}
                            </button>
                             <!-- Modal -->
                             <div class="modal fade" id="changePaymentStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ translate('Change payment status') }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <form method="post" action="{{ Route('ChangeStatus') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <label>
                                              {{ translate('Status') }}
                                            </label>
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <select class="form-control" name="status_id">
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->id }}" {{ $order->order_status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name_ar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary">
                                                  {{ translate('Save') }}
                                              </button>
                                          </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                            <button class="btn btn-danger  btn-sm">
                                {{ translate('Delete Order') }}
                            </button>
                        </div>
                     </div>
                  </div>
                </div>
              </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        {{ translate('Order Details Information') }}
                      </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>{{ translate('Service') }}</th>
                                <th>{{ translate('Full Name') }}</th>
                                <th>{{ translate('Kfara') }}</th>
                                <th>{{ translate('Haj Purpose') }}</th>
                                <th>{{ translate('Required Date') }}</th>
                                <th>{{ translate('Execution Date') }}</th>
                                <th>{{ translate('Price') }}({{ $order->user->wallet->currency->symbol}})</th>
                                <th>{{ translate('Executer Name') }}</th>
                                <th>{{ translate('Actions') }}</th>

                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $key=>$detail)

                                    <tr>
                                        <td>
                                            {{ ++$key }}
                                        </td>
                                        <td>
                                            {{ $detail->service->name_ar }}
                                        </td>
                                        <td>
                                            {{ $detail->full_name }}
                                        </td>
                                        <td>
                                            {{ $detail->KfaraChoice != null ? $detail->KfaraChoice->name_ar : '-' }}
                                        </td>
                                        <td>
                                            {{ $detail->hajPurpose != null ? $detail->hajPurpose->name_ar : '-' }}
                                        </td>
                                        <td>
                                            {{ $detail->required_date }}
                                        </td>
                                        <td>
                                            {{ $detail->execution_date }}
                                        </td>
                                        <td>
                                            {{ $detail->price }}
                                        </td>
                                        <td>
                                            {{ $detail->executer != null ?  $detail->executer->name_ar : '-'}}
                                        </td>
                                        <td>
                                            @if($detail->executer == null)
                                                <button class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#AssignExecuter">
                                                    {{ translate('Assign to Executer') }}
                                                </button>
                                                <div class="modal fade" id="AssignExecuter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ translate('Assign Executer to the service') }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <form method="post" action="{{ Route('AssignExecuter') }}">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <label>
                                                                {{ translate('Executers') }}
                                                                </label>
                                                                <input type="hidden" name="orderDetail_id" value="{{ $detail->id }}">
                                                                <select class="form-control select2" name="executer_id">
                                                                    @foreach($executers as $executer)
                                                                        <option value="{{ $executer->id }}">
                                                                            {{ $executer->name_ar }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ translate('Save') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            @else
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#AssignExecuter">
                                                    {{ translate('Change Executer') }}
                                                </button>

                                                <div class="modal fade" id="AssignExecuter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ translate('Change Executer to the service') }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <form method="post" action="{{ Route('AssignExecuter') }}">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <label>
                                                                {{ translate('Executers') }}
                                                                </label>
                                                                <input type="hidden" name="orderDetail_id" value="{{ $detail->id }}">
                                                                <select class="form-control select2" name="executer_id">
                                                                    @foreach($executers as $executer)
                                                                        <option value="{{ $executer->id }}" {{ $executer->id == $detail->executer_id ? 'selected' : '' }}>
                                                                            {{ $executer->name_ar }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ translate('Save') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target=".id-{{ $detail->id }}">
                                                {{ translate('See Steps') }}
                                            </button>
                                            <div class="modal fade bd-example-modal-lg id-{{ $detail->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog  modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ translate('Services Steps') }}
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <th>{{ translate('Step Name') }}</th>
                                                                    <th>{{ translate('Start') }}</th>
                                                                    <th>{{ translate('End') }}</th>
                                                                    <th>{{ translate('Status') }}</th>

                                                                </thead>
                                                                <tbody>
                                                                    @foreach($detail->steps as $step)
                                                                        <tr>
                                                                            <td>
                                                                                {{ $step->step->name_ar }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $step->start_in }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $step->end_in }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $step->status->name_ar }}
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                    </div>
                                              </div>
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

@section('js')
<!-- Select2 -->
<script src="{{url('/')}}/plugins/select2/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
