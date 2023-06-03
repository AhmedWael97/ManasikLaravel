@extends('Dashboard.Layout.app')
@section('css')
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('View User') }} {{ $User->name }}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('Users') }}">{{ translate('Users') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('View User') }}</li>
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
                    <div class="row p-0 m-0">
                        <div class="col-md-5 mb-2">
                            <label class="d-block">
                                {{ translate('User Image') }}
                            </label>
                            <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/photos') }}/{{ $User->photo_path }}" />
                            <span class="d-block mt-1 mb-1">
                                <a href="{{ url('/images/photos') }}/{{ $User->photo_path }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ url('/images/photos') }}/{{ $User->photo_path }}" download class="btn btn-primary btn-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                            </span>
                        </div>
                        <div class="col-md-7 mb-2">
                            <span class="d-block">
                                {{ translate('Role Name') }} : <label> {{ $User->roles[0]->name }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('English Name') }} : <label> {{ $User->name }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Arabic Name') }} : <label> {{ $User->name_ar}} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Email') }} : <label>{{ $User->email }}</label>
                            </span>
                            <span class="d-block">
                                {{ translate('Phone') }} : <label>{{ $User->phone }}</label>
                            </span>
                            <span class="d-block">
                                {{ translate('Gender') }} : <label>{{ $User->gender_method?->name_en }}</label>
                            </span>
                            <span class="d-block">
                                {{ translate('Birthdate') }} : <label> {{ $User->birthdate }} </label>
                            </span>
                        </div>



                    </div>


                </div>
            </div>

            @if( $User->roles[0]->name != 'Super Admin' && $User->roles[0]->name != 'Application User'  )
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ translate('Nationality And Job Information') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row p-0 m-0">
                        <div class="col-md-5 mb-2">
                            <span class="d-block">
                                {{ translate('Government ID Image') }}
                                <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/govs') }}/{{ $User->government_id_path }}" />
                                <span class="d-block mt-1 mb-1">
                                    <a href="{{ url('/images/govs') }}/{{ $User->government_id_path }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/images/govs') }}/{{ $User->government_id_path }}" download class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </span>
                            </span>
                            <span class="d-block">
                                {{ translate('Activity License Image') }}
                                <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/act') }}/{{ $User->activity_license_image_path }}" />
                                <span class="d-block mt-1 mb-1">
                                    <a href="{{ url('/images/act') }}/{{ $User->activity_license_image_path }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/images/act') }}/{{ $User->activity_license_image_path }}" download class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </span>
                            </span>
                            <span class="d-block">
                                {{ translate('Certificate Registration Tax') }}
                                <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/crt') }}/{{ $User->certificate_registration_tax }}" />
                                <span class="d-block mt-1 mb-1">
                                    <a href="{{ url('/images/crt') }}/{{ $User->certificate_registration_tax }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/images/crt') }}/{{ $User->certificate_registration_tax }}" download class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </span>
                            </span>
                            <span class="d-block">
                                {{ translate('Chamber Of Commerce Registration') }}
                                <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/chamber') }}/{{ $User->chamber_of_commerce_registration }}" />

                                <span class="d-block mt-1 mb-1">
                                    <a href="{{ url('/images/chamber') }}/{{ $User->chamber_of_commerce_registration }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/images/chamber') }}/{{ $User->chamber_of_commerce_registration }}" download class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </span>
                            </span>
                            <span class="d-block">
                                {{ translate('Commercial Registration Image Path') }}
                                <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/comm') }}/{{ $User->commercial_registration_image_path }}" />
                                <span class="d-block mt-1 mb-1">
                                    <a href="{{ url('/images/comm') }}/{{ $User->commercial_registration_image_path }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/images/comm') }}/{{ $User->commercial_registration_image_path }}" download class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </span>
                            </span>
                        </div>
                        <div class="col-md-7 mb-2">
                            <span class="d-block">
                                {{ translate('Id Number') }} : <label>{{ $User->id_number }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Country') }} : <label>{{ $User->country?->name_en }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Nationality') }} : <label>{{ $User->nationality?->name_en }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Language') }} : <label>{{ $User->language?->name_en }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Place of Resdience') }} : <label>{{ $User->place_of_resdience }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Job') }} :  <label>{{ $User->job?->name_en }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Instituation Name') }} : <label>{{ $User->instituation_name }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Activity License Number') }} : <label>{{ $User->activity_license_number }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Agency Address') }} : <label>{{ $User->agency_address }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Commercial Registration No') }} : <label>{{ $User->commercial_registratoin_no }} </label>
                            </span>
                        </div>

                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ translate('Bank Account Information') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row p-0 m-0">
                        <div class="col-md-9 mb-2">
                            <span class="d-block">
                                {{ translate('Bank Name') }} : <label>{{ $User->bank }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Bank Branch') }} : <label>{{ $User->bank_branch }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Bank Account Number') }}  : <label>{{ $User->bank_account_no }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('IBAN') }} : <label>{{ $User->iban }} </label>
                            </span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <span class="d-block">
                                {{ translate('Wallet Balance') }} : <label>{{ $User->wallet?->amount }} {{ $User->wallet?->currency?->symbol }} </label>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <a href="#" class="btn btn-default btn-sm">
                               <i class="fas fa-eye"></i> {{ translate('View Total Transaction') }}
                            </a>
                            <a href="#" class="btn btn-default btn-sm">
                                <i class="fas fa-eye"></i>  {{ translate('View Total Withdrawal Requests') }} (0)
                            </a>
                            <a href="#" class="btn btn-default btn-sm">
                                <i class="fas fa-dollar-sign"></i>  {{ translate('Transfer Money') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ translate('Orders Information') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row p-0 m-0">
                        <div class="col-md-3 mb-2">
                            <h5 class="mb-2 mt-2">
                                <label> <i class="fas fa-align-left text-primary"></i> {{ translate('Quick Analysis Overview') }}</label>
                            </h6>
                            <span class="d-block">
                                {{ translate('Total Orders') }} : <label> {{ $analysisBag['orders'] }} </label>
                            </span>

                            <span class="d-block">
                                {{ translate('Total Init Orders') }} : <label> {{ $analysisBag['InitOrders'] }} </label> ( {{ precent($analysisBag['InitOrders'], $analysisBag['orders']) }} % )
                            </span>
                            <span class="d-block">
                                {{ translate('Total InProgress Orders') }} : <label> {{ $analysisBag['inProgressOrders'] }} </label> ( {{ precent($analysisBag['inProgressOrders'], $analysisBag['orders']) }} % )
                            </span>
                            <span class="d-block">
                                {{ translate('Total Canceled Orders') }} : <label> {{ $analysisBag['canceledOrders'] }} </label> ( {{ precent($analysisBag['canceledOrders'], $analysisBag['orders']) }} % )
                            </span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <h5 class="mb-2 mt-2">
                                <label> <i class="fas fa-align-left text-primary"></i> {{ translate('Latency Analysis Overview') }}</label>
                            </h6>
                            <span class="d-block">
                                {{ translate('Latency Orders') }} : <label> {{ $analysisBag['delayedOrders'] }} </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Average Latency In Minutes') }} : <label> 0 </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Average Latency ') }} : <label> 0 % </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Executor Effiency ') }} : <label> 0 % </label>
                            </span>

                        </div>
                        <div class="col-md-3 mb-2">
                            <h5 class="mb-2 mt-2">
                                <label> <i class="fas fa-align-left text-primary"></i> {{ translate('Total Average For Executer') }}</label>
                            </h5>
                            <span class="d-block">
                                {{ translate('Orders Growth for last year') }} : <label> 0 % </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Orders Growth') }} : <label> 0 % </label>
                            </span>
                            <span class="d-block">
                                {{ translate('Executer Level') }} : <label> {{ translate('Begginer') }} </label>
                            </span>

                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('specificExecuter',['id' => $User->id, 'status' => 0]) }}" class="btn btn-default btn-sm mb-2">
                               <i class="fas fa-eye"></i> {{ translate('View Total Orders') }}
                            </a>
                            <a href="{{ route('specificExecuter',['id' => $User->id, 'status' => 6]) }}" class="btn btn-default btn-sm mb-2">
                                <i class="fas fa-eye"></i>  {{ translate('View Total Init Orders') }}
                            </a>
                            <a href="{{ route('specificExecuter',['id' => $User->id, 'status' => 3]) }}" class="btn btn-default btn-sm mb-2">
                                <i class="fas fa-eye"></i>  {{ translate('View Total InProgress Orders') }}
                            </a>
                            <a href="{{ route('specificExecuter',['id' => $User->id, 'status' => 11]) }}" class="btn btn-default btn-sm mb-2">
                                <i class="fas fa-eye"></i>  {{ translate('View Total Finished Orders') }}
                            </a>
                            <a href="{{ route('specificExecuter',['id' => $User->id, 'status' => 2]) }}" class="btn btn-default btn-sm mb-2">
                                <i class="fas fa-eye"></i>  {{ translate('View Total Canceled Orders') }}
                            </a>
                            <a href="{{ route('specificExecuter',['id' => $User->id, 'status' => 4]) }}" class="btn btn-default btn-sm mb-2">
                                <i class="fas fa-eye"></i>  {{ translate('View Total Skipped Orders') }}
                            </a>
                            <a href="{{ route('specificExecuter',['id' => $User->id, 'status' => 5]) }}" class="btn btn-default btn-sm mb-2">
                                <i class="fas fa-eye"></i>  {{ translate('View Total Delayed Orders') }}
                            </a>
                            <a href="{{ route('specificExecuter',['id' => $User->id, 'status' => 7]) }}" class="btn btn-default btn-sm mb-2">
                                <i class="fas fa-eye"></i>  {{ translate('View Total Refused Orders') }}
                            </a>
                            <a href="{{ route('specificExecuter',['id' => $User->id, 'status' => 10]) }}" class="btn btn-default btn-sm mb-2">
                                <i class="fas fa-eye"></i>  {{ translate('View Total SOS Orders') }}
                            </a>
                            <a href="#" class="btn btn-success btn-sm mb-2">
                                <i class="fas fa-charts"></i>  {{ translate('View AI Analysis') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ translate('Account Controller') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row p-0 m-0">

                        <div class="col-md-12">
                            <a href="{{ route('Users-auto',$User->id) }}" class="btn btn-default btn-sm mb-2">
                                <i class="fas fa-circle"></i>  {{ translate('Automate Assigning') }}
                           </a>
                           <a href="{{ Route('Users-Edit',$User->id) }}" class="btn btn-warning btn-sm mb-2 text-white">
                                <i class="fas fa-edit"></i>  {{ translate('Edit User') }}
                            </a>
                            @if($User->is_active == 0)
                                <a href="{{ Route('Users-quick-actions',['type'=>'Active_Executer_User','id'=>$User->id]) }}" class="btn btn-success btn-sm mb-2">
                                     <i class="fas fa-check"></i> {{ translate('Active User And Accept is As Executer') }}
                                </a>
                            @endif
                            @if($User->is_active == 1)
                                <a href="{{ Route('Users-quick-actions',['type'=>'Deactive_Executer_User','id'=>$User->id]) }}" class="btn btn-danger btn-sm mb-2">
                                     <i class="fas fa-times"></i> {{ translate('Deactivate User') }}
                                </a>
                            @endif
                            @if($User->is_allow_notification == 0)
                                <a href="{{ Route('Users-quick-actions',['type'=>'Allow_Notification','id'=>$User->id]) }}" class="btn btn-success btn-sm mb-2">
                                    <i class="fas fa-check"></i> {{ translate('Allow Notification') }}
                                </a>
                            @endif
                            @if($User->is_allow_notification == 1)
                                <a href="{{ Route('Users-quick-actions',['type'=>'Diallow_Notification','id'=>$User->id]) }}" class="btn btn-danger btn-sm mb-2">
                                    <i class="fas fa-check"></i> {{ translate('Disallow Notification') }}
                                </a>
                            @endif

                            @if($User->sos_status == 0)
                                <a href="{{ Route('Users-quick-actions',['type'=>'Enable_SOS_Status','id'=>$User->id]) }}" class="btn btn-danger btn-sm mb-2">
                                    <i class="fas fa-times-circle"></i>  {{ translate('Adding To SOS Status') }}
                                </a>
                            @endif

                            @if($User->sos_status == 1)
                                <a href="{{ Route('Users-quick-actions',['type'=>'Disable_SOS_Status','id'=>$User->id]) }}" class="btn btn-success btn-sm mb-2">
                                    <i class="fas fa-check-circle"></i>  {{ translate('Remove From SOS Status') }}
                                </a>
                            @endif

                            <a href="{{ route('Users-Delete',$User->id) }}" class="btn btn-danger btn-sm mb-2">
                                <i class="fas fa-trash"></i> {{ translate('Delete User') }}
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
      </div>
    </div>
</section>

@endsection

@section('js')
@endsection
