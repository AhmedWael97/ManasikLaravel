@extends('Dashboard.Layout.app')
@section('css')
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Create New User') }}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('Users') }}">{{ translate('Users') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('New User') }}</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <form method="POST" action="{{ route('Users-Store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                   {{ translate('Basic Information') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row p-0 m-0">
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('English Name') }}
                            </label>
                            <input type="text" name="name" required="true" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Arabic Name') }}
                            </label>
                            <input type="text" name="name_ar" required="true" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Email') }}
                            </label>
                            <input type="email" name="email" required="true" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Phone') }}
                            </label>
                            <input type="tel" name="phone" required="true" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Gender') }}
                            </label>
                           <select class="form-control" name="gender" required>
                                @foreach ( $Genders as $term)
                                    <option value="{{ $term->id }}"> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                           </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Birthdate') }}
                            </label>
                            <input type="date" name="birthdate" required="false" class="form-control" />
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Password') }}
                            </label>
                            <input type="password" name="password" required="true" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Password Confirmation') }}
                            </label>
                            <input type="password" name="password_confirmation" required="true" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>
                            {{ translate('User Image') }}
                        </label>
                        <input type="file" name="photo_path" required="false" class="form-control-file" />
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ translate('Nationality And Job Information') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row p-0 m-0">
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Id Number') }}
                            </label>
                            <input type="text" name="id_number" required="false" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Country') }}
                            </label>
                            <select class="form-control" required="false" name="country_id">
                                @foreach ( $Countries as $term)
                                    <option value="{{ $term->id }}"> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Nationality') }}
                            </label>
                            <select class="form-control" required="false" name="nationality_id">
                                @foreach ( $Nationalities as $term)
                                    <option value="{{ $term->id }}"> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Government ID Image') }}
                            </label>
                            <input type="file" name="government_id_path" required="false" class="form-control-file" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Language') }}
                            </label>
                            <select class="form-control" name="lang_id" required="false">
                                @foreach ( $Languages as $term)
                                    <option value="{{ $term->id }}"> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Place of Resdience') }}
                            </label>
                            <select class="form-control" name="place_of_residence_id" required="false">
                                @foreach ( $Countries as $term)
                                    <option value="{{ $term->id }}"> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Job') }}
                            </label>
                            <select class="form-control" name="job_id" required="false">
                                @foreach ( $Jobs as $term)
                                    <option value="{{ $term->id }}"> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Instituation Name') }}
                            </label>
                            <input type="text" class="form-control" name="instituation_name" required="false" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Activity License Number') }}
                            </label>
                            <input type="text" class="form-control" name="activity_license_number" required="false" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Agency Address') }}
                            </label>
                            <input type="text" class="form-control" name="agency_address" required="false" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Activity License Image') }}
                            </label>
                            <input type="file" name="activity_license_image_path" required="false" class="form-control-file" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Certificate Registration Tax') }}
                            </label>
                            <input type="text" class="form-control" name="certificate_registration_tax" required="false" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Chamber Of Commerce Registration') }}
                            </label>
                            <input type="text" class="form-control" name="chamber_of_commerce_registration" required="false" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Commercial Registration No') }}
                            </label>
                            <input type="text" class="form-control" name="commercial_registration_no" required="false" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Commercial Registration Image Path') }}
                            </label>
                            <input type="file" class="form-control-file" name="commercial_registration_image_path" required="false" />
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
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Bank Name') }}
                            </label>
                            <input type="text" name="bank" required="false" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Bank Branch') }}
                            </label>
                            <input type="text" name="bank_branch" required="false" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Bank Account Number') }}
                            </label>
                            <input type="text" name="bank_account_no" required="false" class="form-control" />
                        </div>
                            <div class="col-md-3 mb-2">
                                <label>
                                    {{ translate('IBAN') }}
                                </label>
                                <input type="text" name="iban" required="false" class="form-control" />
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>
                                    {{ translate('Currency') }}
                                </label>
                                <select class="form-control" name="currency_id">
                                    @foreach($Currencies as $term)
                                        <option value=" {{ $term->id }} "> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ translate('System Information') }}
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row p-0 m-0">
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('SOS Status') }}
                            </label>
                            <input type="text" name="sos_status" required="false" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Sos Start Date') }}
                            </label>
                            <input type="date" name="sos_start_date" required="false" class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Role') }}
                            </label>
                            <select class="form-control" name="role_id" required>
                                @foreach ($Roles as $term)
                                    <option value="{{ $term->id }}"> {{ $term->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Allow Notification') }}
                            </label>
                            <input type="checkbox" value="1" name="is_allow_notification" required="false" class="form-check" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Is Active') }}
                            </label>
                            <input type="checkbox" value="1" name="is_active" required="false" class="form-check" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Is Confirmed Eexcuter') }}
                            </label>
                            <input type="checkbox" value="1" name="is_confirmed_executer" required="false" class="form-check" />
                        </div>
                        <div class="col-md-12"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <input type="submit" class="btn btn-success w-100" value="{{ translate('Save') }}" />
                        </div>
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
