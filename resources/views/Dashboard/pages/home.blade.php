@extends('Dashboard.Layout.app')
@section('content')
<section class="content-header" style="padding-bottom:0px;padding-top:20px;">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>{{ translate('Dashboard Analysis - Users') }}</h1>
        </div>
      
    </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content" >
<div class="container-fluide  mt-4">
<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
               <h3 class="Admin" id="admin">
               
               </h3>
               <p>{{translate('Admin No.')}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="{{route('Users')}}" class="small-box-footer">
                {{translate('More info')}} <i class="fas fa-arrow-circle-right"></i>
              </a>
            
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 class="mobilAppUser" id="mobilAppUser">
                
                </h3>

                <p>{{translate('Mobil App Users No.')}}</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('Users')}}" class="small-box-footer">
                {{translate('More info')}} <i class="fas fa-arrow-circle-right"></i>
              </a>
             
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6" style="color:white;">
            <!-- small card -->
            <div class="small-box bg-warning" style="color:white !important;" >
              <div class="inner">
              <h3 class="ExecuterDashboard" id="ExecuterDashboard">
              
              </h3>

                <p>{{translate('Dashboard"s Executers No.')}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="{{route('Users')}}" class="small-box-footer">
                {{translate('More info')}} <i class="fas fa-arrow-circle-right"></i>
              </a>
            
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 class="ExecuterAppNo" id="ExecuterAppNo"></h3>

                <p>{{translate('App"s Executers No.')}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-pie"></i>
              </div>
              <a href="{{route('Users')}}" class="small-box-footer">
                {{translate('More info')}} <i class="fas fa-arrow-circle-right"></i>
              </a>
             
            </div>
          </div>
          <!-- ./col -->
        </div>
        </div>
        </section>


@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $.get("{{url('/return-count-admin')}}",function(response){
                $("#admin").html(response["admin_no"])
            });
            $.get("{{url('/return-count-mobilApp')}}",function(response){
                $("#mobilAppUser").html(response["app_user_no"])
            });
            $.get("{{url('/return-count-executer-dashboard')}}",function(response){
                $("#ExecuterDashboard").html(response["executer_dashboard__no"])
            });
            $.get("{{url('/return-count-executer-app')}}",function(response){
                $("#ExecuterAppNo").html(response["executer_app__no"])
            });
        });  
</script>
@endsection
