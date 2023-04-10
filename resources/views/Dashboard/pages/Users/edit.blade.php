@extends('Dashboard.Layout.app')
@section('css')
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Update User') }} {{ $User->name }} | {{ $User->name_ar }}</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ Route('Home') }}">{{ translate('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('Users') }}">{{ translate('Users') }}</a></li>
            <li class="breadcrumb-item active"> {{ translate('Update User') }}</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <form method="POST" action="{{ route('Users-Update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ $User->id }}" />
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
                            <input value="{{ $User->name }}" type="text" name="name"   class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Arabic Name') }}
                            </label>
                            <input value="{{ $User->name_ar}}" type="text" name="name_ar"   class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Email') }}
                            </label>
                            <input value="{{ $User->email }}" type="email" name="email"   class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Phone') }}
                            </label>
                            <input value="{{ $User->phone }}" type="tel" name="phone"   class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Gender') }}
                            </label>
                           <select class="form-control" name="gender" required>
                                @foreach ( $Genders as $term)
                                    <option value="{{ $term->id }}" {{ $User->gender == $term->id ? 'selected' : ''}}> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                           </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Birthdate') }}
                            </label>
                            <input value="{{ $User->birthdate }}" type="date" name="birthdate"   class="form-control" />
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Password') }}
                            </label>
                            <input type="password" name="password"   class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Password Confirmation') }}
                            </label>
                            <input type="password" name="password_confirmation"   class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>
                            {{ translate('User Image') }}
                        </label>
                        <input type="file" name="photo_path"   class="form-control-file" />
                        <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/photos') }}/{{ $User->photo_path }}" />
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
                            <input type="text" name="id_number" value="{{ $User->id_number }}"  class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Country') }}
                            </label>
                            <select class="form-control"   name="country_id">
                                @foreach ( $Countries as $term)
                                    <option value="{{ $term->id }}" {{ $User->country_id == $term->id ? 'selected' : '' }}> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Nationality') }}
                            </label>
                            <select class="form-control"   name="nationality_id">
                                @foreach ( $Nationalities as $term)
                                    <option value="{{ $term->id }}" {{ $User->nationality_id == $term->id ? 'selected' : '' }} > {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Government ID Image') }}
                            </label>
                            <input type="file" name="government_id_path"   class="form-control-file" />
                            <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/govs') }}/{{ $User->government_id_path }}" />

                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Language') }}
                            </label>
                            <select class="form-control" name="lang_id"  >
                                @foreach ( $Languages as $term)
                                    <option value="{{ $term->id }}" {{ $User->lang_id == $term->id ? 'selected' : '' }}> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Place of Resdience') }}
                            </label>
                            <select class="form-control" name="place_of_residence_id"  >
                                @foreach ( $Countries as $term)
                                    <option value="{{ $term->id }}" {{ $User->country_id == $term->id ? 'selected' : '' }}> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Job') }}
                            </label>
                            <select class="form-control" name="job_id"  >
                                @foreach ( $Jobs as $term)
                                    <option value="{{ $term->id }}" {{ $User->job_id == $term->id ? 'selected' : '' }}> {{ $term->name_en }} | {{ $term->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Instituation Name') }}
                            </label>
                            <input type="text" class="form-control" value="{{ $User->instituation_name }}" name="instituation_name"   />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Activity License Number') }}
                            </label>
                            <input type="text" class="form-control" value="{{ $User->activity_license_number }}" name="activity_license_number"   />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Agency Address') }}
                            </label>
                            <input type="text" class="form-control"   value="{{ $User->agency_address }}" name="agency_address"   />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Activity License Image') }}
                            </label>
                            <input type="file" name="activity_license_image_path"   class="form-control-file" />

                            <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/act') }}/{{ $User->activity_license_image_path }}" />

                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Certificate Registration Tax') }}
                            </label>
                            <input type="text" value="{{ $User->certificate_registration_tax }}" class="form-control" name="certificate_registration_tax"   />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Chamber Of Commerce Registration') }}
                            </label>
                            <input type="text" value="{{ $User->chamber_of_commerce_registration }}" class="form-control" name="chamber_of_commerce_registration"   />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Commercial Registration No') }}
                            </label>
                            <input type="text" value="{{ $User->commercial_registration_no }}" class="form-control" name="commercial_registration_no"   />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Commercial Registration Image Path') }}
                            </label>
                            <input type="file" class="form-control-file" name="commercial_registration_image_path"   />
                            <img style="width:auto; height: 160px;margin-top:10px;" src="{{ url('/images/comm') }}/{{ $User->commercial_registration_image_path }}" />

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
                            <input type="text" value="{{ $User->bank }}" name="bank"   class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Bank Branch') }}
                            </label>
                            <input type="text" name="bank_branch" value="{{ $User->bank_branch }}"  class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Bank Account Number') }}
                            </label>
                            <input type="text" name="bank_account_no" value="{{ $User->bank_account_no }}"  class="form-control" />
                        </div>
                            <div class="col-md-3 mb-2">
                                <label>
                                    {{ translate('IBAN') }}
                                </label>
                                <input type="text" name="iban" value="{{ $User->iban }}"  class="form-control" />
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
                            <input type="text" name="sos_status" value="{{ $User->sos_status }}"  class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Sos Start Date') }}
                            </label>
                            <input type="date" name="sos_start_date" value="{{ $User->sos_start_date }}"  class="form-control" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Role') }}
                            </label>
                            <select class="form-control" name="role_id" required>
                                @foreach ($Roles as $term)
                                    <option value="{{ $term->id }}" {{ $User->roles[0]->id == $term->id ? 'selected' : '' }} > {{ $term->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Allow Notification') }}
                            </label>
                            <input type="checkbox" value="1" {{ $User->is_allow_notification == 1 ? 'checked' : '' }} name="is_allow_notification"   class="form-check" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Is Active') }}
                            </label>
                            <input type="checkbox" value="1" name="is_active" {{ $User->is_active == 1 ? 'checked' : '' }}   class="form-check" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>
                                {{ translate('Is Confirmed Eexcuter') }}
                            </label>
                            <input type="checkbox" value="1" name="is_confirmed_executer" {{ $User->is_confirmed_executer == 1 ? 'checked' : '' }}  class="form-check" />
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
